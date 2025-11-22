<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;
use App\Helpers\Storage;

class TeacherCoursesController
{
    /* ---------- Guards ---------- */
    private function requireLogin() {
        if (session_status()===PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/login');
            exit;
        }
    }

    private function requireRole(array $roles) {
        $this->requireLogin();
        $userRoles = $_SESSION['user']['roles'] ?? [];
        foreach ($roles as $r) {
            if (in_array($r, $userRoles, true)) return;
        }
        header('Location: /src/plataforma/login');
        exit;
    }

    private function filesCfg(): array {
        return require __DIR__ . '/../config/files.php';
    }

    /* ===================== HUB ===================== */
    public function show() {
        $this->requireRole(['teacher']);

        // Garantiza carpetas de storage
        Storage::ensureDirs($this->filesCfg());

        $teacherId = (int)($_SESSION['user']['id'] ?? 0);
        $mgId      = (int)($_GET['id'] ?? 0);
        if ($mgId <= 0) {
            header('Location: /src/plataforma/app/teacher');
            exit;
        }

        $db = new Database();

        // Ownership: el maestro debe estar asignado en materia_grupo_profesor
        $db->query("
            SELECT mg.id, mg.codigo, m.nombre AS materia_nombre
            FROM materias_grupos mg
            JOIN materias m ON m.id = mg.materia_id
            JOIN materia_grupo_profesor mgp ON mgp.mg_id = mg.id
            WHERE mg.id = :mg AND mgp.teacher_user_id = :tid
            LIMIT 1
        ", [
            ':mg'  => $mgId,
            ':tid' => $teacherId
        ]);
        $course = $db->fetch();
        if (!$course) {
            header('Location: /src/plataforma/app/teacher');
            exit;
        }

        // ===================== ACTIVIDADES =====================
        $db->query("
            SELECT 
                ct.id,
                ct.title,
                ct.description,
                ct.due_at,
                ct.file_path,
                ct.activity_type_id,
                ct.weight_percent,
                ct.max_attempts,
                ct.total_points,
                ct.parcial,
                ct.exam_definition,
                at.name  AS activity_type_name,
                at.slug  AS activity_type_slug,
                at.partial_weight_percent  -- peso de la categoría en el parcial
            FROM course_tasks ct
            LEFT JOIN activity_types at ON at.id = ct.activity_type_id
            WHERE ct.mg_id = :mg
            ORDER BY 
                ct.parcial ASC,
                ct.due_at IS NULL,  -- primero las que tienen fecha
                ct.due_at ASC,
                ct.id DESC
        ", [':mg' => $mgId]);
        $tasks = $db->fetchAll() ?? []; // seguimos llamando $tasks para no romper la vista

        // Catálogo de tipos de actividad para el formulario (Examen, Proyecto, etc.)
        $db->query("
            SELECT id, name, slug, default_weight, default_max_attempts, partial_weight_percent
            FROM activity_types
            ORDER BY name ASC
        ");
        $activityTypes = $db->fetchAll() ?? [];

        // Entregas recientes (últimas 10) con nombre del alumno y título de la actividad
        $db->query("
            SELECT 
                s.id,
                s.student_user_id,
                u.nombre AS student_name,
                s.task_id,
                t.title AS task_title,
                t.activity_type_id,
                at.slug AS activity_type_slug,
                at.name AS activity_type_name,
                s.file_path,
                s.answers_json,
                s.created_at,
                s.grade,
                s.feedback
            FROM task_submissions s
            JOIN course_tasks t ON t.id = s.task_id
            LEFT JOIN activity_types at ON at.id = t.activity_type_id
            JOIN users u ON u.id = s.student_user_id
            WHERE t.mg_id = :mg
            ORDER BY s.created_at DESC
            LIMIT 10
        ", [':mg' => $mgId]);
        $recentSubmissions = $db->fetchAll() ?? [];

        // Recursos del curso (usa mg_id)
        $db->query("
            SELECT id, title, file_path, created_at
            FROM course_resources
            WHERE mg_id = :mg
            ORDER BY created_at DESC
        ", [':mg' => $mgId]);
        $resources = $db->fetchAll() ?? [];

        View::render('teacher/course_hub', 'teacher', [
            'course'        => $course,
            'tasks'         => $tasks,
            'activityTypes' => $activityTypes,
            'subs'          => $recentSubmissions,
            'resources'     => $resources,
        ]);
    }

    /* ===================== Crear actividad ===================== */
    public function storeTask() {
        $this->requireRole(['teacher']);
        $teacherId = (int)($_SESSION['user']['id'] ?? 0);

        // en el form lo llamamos course_id, pero es mg_id
        $mgId   = (int)($_POST['course_id'] ?? 0);
        $title  = trim($_POST['title'] ?? '');
        $desc   = trim($_POST['description'] ?? '');
        $due    = trim($_POST['due_at'] ?? '');

        // nuevos campos
        $typeIdPost   = (int)($_POST['activity_type_id'] ?? 0);
        // IMPORTANTE: ya no dependemos del weight_percent del form
        // $weightPost   = $_POST['weight_percent'] ?? null;
        $attemptsPost = $_POST['max_attempts'] ?? null;
        $pointsPost   = $_POST['total_points'] ?? null;
        $parcialPost  = $_POST['parcial'] ?? null;

        // JSON para exámenes (desde la vista course_hub)
        $examJsonPost = trim($_POST['exam_definition'] ?? '');

        if ($mgId <= 0 || $title === '') {
            header("Location: /src/plataforma/app/teacher/courses/show?id={$mgId}#tareas");
            exit;
        }

        $db = new Database();

        // Ownership estricto via tabla puente
        $db->query("
            SELECT 1
            FROM materia_grupo_profesor
            WHERE mg_id = :mg AND teacher_user_id = :tid
            LIMIT 1
        ", [':mg' => $mgId, ':tid' => $teacherId]);
        if (!$db->fetchColumn()) {
            header("Location: /src/plataforma/app/teacher");
            exit;
        }

        // ===================== RESOLVER TIPO =====================
        $db->query("
            SELECT id, slug, default_weight, default_max_attempts, partial_weight_percent
            FROM activity_types
            WHERE id = :id
            LIMIT 1
        ", [':id' => $typeIdPost]);

        $typeRow = $db->fetch();
        if (!$typeRow) {
            header("Location: /src/plataforma/app/teacher/courses/show?id={$mgId}#tareas");
            exit;
        }

        $slugType       = strtolower($typeRow->slug);
        $activityTypeId = (int)$typeRow->id;

        // ===================== PESO (INTERNO, NO DEL PARCIAL) =====================
        // Nuevo modelo: la calificación del parcial se calculará por categoría
        // usando activity_types.partial_weight_percent.
        // Este weight_percent por tarea se conserva SOLO como peso relativo
        // dentro de su tipo (o por compatibilidad). No se usará para el parcial.
        $weightPercent = (float)$typeRow->default_weight;
        if ($weightPercent < 0)   $weightPercent = 0;
        if ($weightPercent > 100) $weightPercent = 100;

        // ===================== INTENTOS =====================
        if ($attemptsPost !== null && $attemptsPost !== '' && is_numeric($attemptsPost)) {
            $maxAttempts = (int)$attemptsPost;
        } else {
            $maxAttempts = (int)$typeRow->default_max_attempts;
        }
        if ($maxAttempts <= 0) $maxAttempts = 1;
        if ($maxAttempts > 10) $maxAttempts = 10;

        // ===================== PUNTOS =====================
        if ($pointsPost !== null && $pointsPost !== '' && is_numeric($pointsPost)) {
            $totalPoints = (float)$pointsPost;
        } else {
            $totalPoints = 10.0;
        }

        if ($totalPoints <= 0)   $totalPoints = 1;
        if ($totalPoints > 1000) $totalPoints = 1000;

        // ===================== PARCIAL =====================
        if ($parcialPost !== null && $parcialPost !== '' && is_numeric($parcialPost)) {
            $parcial = (int)$parcialPost;
        } else {
            $parcial = 1;
        }
        if ($parcial <= 0) $parcial = 1;
        if ($parcial > 3)  $parcial = 3;

        // ===================== ARCHIVO OPCIONAL =====================
        $fileUrl = null;
        if (!empty($_FILES['file']['tmp_name'] ?? '')) {
            $fileUrl = Storage::saveUpload($this->filesCfg(), 'tasks', $_FILES['file']);
        }

        // ===================== PROCESAR JSON DEL EXAMEN =====================
        $examDefinition = null;

        if ($slugType === 'exam') {
            if ($examJsonPost !== '') {
                $decoded = json_decode($examJsonPost, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    // Guardar JSON limpio
                    $examDefinition = json_encode($decoded, JSON_UNESCAPED_UNICODE);

                    // Si el JSON trae due_at, sobreescribir la fecha de entrega
                    if (!empty($decoded['due_at'])) {
                        $due = $decoded['due_at'];
                    }

                    // Si trae attempts en el JSON, lo usamos como máximo de intentos del examen
                    if (isset($decoded['attempts']) && is_numeric($decoded['attempts'])) {
                        $maxAttempts = (int)$decoded['attempts'];
                        if ($maxAttempts <= 0) $maxAttempts = 1;
                        if ($maxAttempts > 10) $maxAttempts = 10;
                    }
                }
            }
        }

        // ===================== INSERT =====================
        $sql = "
            INSERT INTO course_tasks 
                (mg_id, created_by_teacher_user_id, title, description, due_at, file_path,
                 activity_type_id, weight_percent, max_attempts, total_points, parcial,
                 exam_definition, created_at)
            VALUES 
                (:mg, :tid, :t, :d, :due, :fp,
                 :type_id, :weight, :max_attempts, :total_points, :parcial,
                 :exam_definition, NOW())
        ";

        $db->query($sql, [
            ':mg'              => $mgId,
            ':tid'             => $teacherId,
            ':t'               => $title,
            ':d'               => $desc !== '' ? $desc : null,
            ':due'             => $due !== '' ? $due : null,
            ':fp'              => $fileUrl,
            ':type_id'         => $activityTypeId,
            ':weight'          => $weightPercent,
            ':max_attempts'    => $maxAttempts,
            ':total_points'    => $totalPoints,
            ':parcial'         => $parcial,
            ':exam_definition' => $examDefinition
        ]);

        header("Location: /src/plataforma/app/teacher/courses/show?id={$mgId}#tareas");
        exit;
    }

    /* ===================== Calificar entrega (manual) ===================== */
    public function gradeSubmission() {
        $this->requireRole(['teacher']);
        $teacherId = (int)($_SESSION['user']['id'] ?? 0);

        $mgId       = (int)($_POST['course_id'] ?? 0);  // mg_id
        $submission = (int)($_POST['submission_id'] ?? 0);
        $grade      = is_numeric($_POST['grade'] ?? null) ? (float)$_POST['grade'] : null;
        $feedback   = trim($_POST['feedback'] ?? '');

        if ($mgId <= 0 || $submission <= 0) {
            header("Location: /src/plataforma/app/teacher/courses/show?id={$mgId}#calificaciones");
            exit;
        }

        $db = new Database();
        // Validar que la entrega pertenece a una actividad de un mg_id asignado a este maestro
        $db->query("
            SELECT mgp.teacher_user_id
            FROM task_submissions s
            JOIN course_tasks t              ON t.id = s.task_id
            JOIN materia_grupo_profesor mgp  ON mgp.mg_id = t.mg_id
            WHERE s.id = :sid
            LIMIT 1
        ", [':sid' => $submission]);
        $row = $db->fetch();
        if (!$row || (int)$row->teacher_user_id !== $teacherId) {
            header("Location: /src/plataforma/app/teacher");
            exit;
        }

        $db->query("
            UPDATE task_submissions
               SET grade = :g,
                   feedback = :fb,
                   graded_at = NOW()
             WHERE id = :sid
        ", [
            ':g'  => $grade,
            ':fb' => $feedback !== '' ? $feedback : null,
            ':sid'=> $submission
        ]);

        header("Location: /src/plataforma/app/teacher/courses/show?id={$mgId}#calificaciones");
        exit;
    }

    /* ===================== Subir recurso ===================== */
    public function storeResource() {
        $this->requireRole(['teacher']);
        $teacherId = (int)($_SESSION['user']['id'] ?? 0);

        $mgId  = (int)($_POST['course_id'] ?? 0); // mg_id
        $title = trim($_POST['title'] ?? '');

        if ($mgId <= 0 || $title === '') {
            header("Location: /src/plataforma/app/teacher/courses/show?id={$mgId}#recursos");
            exit;
        }

        $db = new Database();
        // Ownership via tabla puente
        $db->query("
            SELECT 1
            FROM materia_grupo_profesor
            WHERE mg_id = :mg AND teacher_user_id = :tid
            LIMIT 1
        ", [':mg' => $mgId, ':tid' => $teacherId]);
        if (!$db->fetchColumn()) {
            header("Location: /src/plataforma/app/teacher");
            exit;
        }

        $fileUrl = null;
        if (!empty($_FILES['file']['tmp_name'] ?? '')) {
            $fileUrl = Storage::saveUpload($this->filesCfg(), 'resources', $_FILES['file']);
        }

        $db->query("
            INSERT INTO course_resources (mg_id, uploaded_by_teacher_user_id, title, file_path, created_at)
            VALUES (:mg, :tid, :t, :fp, NOW())
        ", [
            ':mg'  => $mgId,
            ':tid' => $teacherId,
            ':t'   => $title,
            ':fp'  => $fileUrl
        ]);

        header("Location: /src/plataforma/app/teacher/courses/show?id={$mgId}#recursos");
        exit;
    }
}
