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
        if (empty($_SESSION['user'])) { header('Location: /src/plataforma/login'); exit; }
    }
    private function requireRole(array $roles) {
        $this->requireLogin();
        $userRoles = $_SESSION['user']['roles'] ?? [];
        foreach ($roles as $r) if (in_array($r, $userRoles, true)) return;
        header('Location: /src/plataforma/login'); exit;
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
        if ($mgId<=0) { header('Location: /src/plataforma/app/teacher'); exit; }

        $db = new Database();

        // Ownership: el maestro debe estar asignado en materia_grupo_profesor
        $db->query("
            SELECT mg.id, mg.codigo, m.nombre AS materia_nombre
            FROM materias_grupos mg
            JOIN materias m ON m.id = mg.materia_id
            JOIN materia_grupo_profesor mgp ON mgp.mg_id = mg.id
            WHERE mg.id = :mg AND mgp.teacher_user_id = :tid
            LIMIT 1
        ", [':mg'=>$mgId, ':tid'=>$teacherId]);
        $course = $db->fetch();
        if (!$course) { header('Location: /src/plataforma/app/teacher'); exit; }

        // Tareas del curso (usa mg_id)
        $db->query("
            SELECT id, title, description, due_at, file_path
            FROM course_tasks
            WHERE mg_id = :mg
            ORDER BY due_at IS NULL, due_at ASC, id DESC
        ", [':mg'=>$mgId]);
        $tasks = $db->fetchAll() ?? [];

        // Entregas recientes (últimas 10) con nombre del alumno y título de la tarea
        $db->query("
            SELECT s.id, s.student_user_id, u.nombre AS student_name,
                   s.task_id, t.title AS task_title,
                   s.file_path, s.created_at, s.grade, s.feedback
            FROM task_submissions s
            JOIN course_tasks t ON t.id = s.task_id
            JOIN users u        ON u.id = s.student_user_id
            WHERE t.mg_id = :mg
            ORDER BY s.created_at DESC
            LIMIT 10
        ", [':mg'=>$mgId]);
        $recentSubmissions = $db->fetchAll() ?? [];

        // Recursos del curso (usa mg_id)
        $db->query("
            SELECT id, title, file_path, created_at
            FROM course_resources
            WHERE mg_id = :mg
            ORDER BY created_at DESC
        ", [':mg'=>$mgId]);
        $resources = $db->fetchAll() ?? [];

        View::render('teacher/course_hub', 'teacher', [
            'course'    => $course,
            'tasks'     => $tasks,
            'subs'      => $recentSubmissions,
            'resources' => $resources,
        ]);
    }

    /* ===================== Crear tarea ===================== */
    public function storeTask() {
        $this->requireRole(['teacher']);
        $teacherId = (int)($_SESSION['user']['id'] ?? 0);

        $mgId  = (int)($_POST['course_id'] ?? 0); // en el form lo llamamos course_id, pero es mg_id
        $title = trim($_POST['title'] ?? '');
        $desc  = trim($_POST['description'] ?? '');
        $due   = trim($_POST['due_at'] ?? '');

        if ($mgId<=0 || $title==='') {
            header("Location: /src/plataforma/app/teacher/courses/show?id={$mgId}#tareas"); exit;
        }

        $db = new Database();
        // Ownership estricto via tabla puente
        $db->query("
            SELECT 1
            FROM materia_grupo_profesor
            WHERE mg_id = :mg AND teacher_user_id = :tid
            LIMIT 1
        ", [':mg'=>$mgId, ':tid'=>$teacherId]);
        if (!$db->fetchColumn()) { header("Location: /src/plataforma/app/teacher"); exit; }

        // Archivo opcional adjunto de la tarea
        $fileUrl = null;
        if (!empty($_FILES['file']['tmp_name'] ?? '')) {
            $fileUrl = Storage::saveUpload($this->filesCfg(), 'tasks', $_FILES['file']);
        }

        $db->query("
            INSERT INTO course_tasks (mg_id, created_by_teacher_user_id, title, description, due_at, file_path, created_at)
            VALUES (:mg, :tid, :t, :d, :due, :fp, NOW())
        ", [
            ':mg'=>$mgId,
            ':tid'=>$teacherId,
            ':t'=>$title,
            ':d'=>$desc ?: null,
            ':due'=>$due ?: null,
            ':fp'=>$fileUrl
        ]);

        header("Location: /src/plataforma/app/teacher/courses/show?id={$mgId}#tareas");
        exit;
    }

    /* ===================== Calificar entrega ===================== */
    public function gradeSubmission() {
        $this->requireRole(['teacher']);
        $teacherId = (int)($_SESSION['user']['id'] ?? 0);

        $mgId       = (int)($_POST['course_id'] ?? 0);  // mg_id
        $submission = (int)($_POST['submission_id'] ?? 0);
        $grade      = is_numeric($_POST['grade'] ?? null) ? (float)$_POST['grade'] : null;
        $feedback   = trim($_POST['feedback'] ?? '');

        if ($mgId<=0 || $submission<=0) {
            header("Location: /src/plataforma/app/teacher/courses/show?id={$mgId}#calificaciones"); exit;
        }

        $db = new Database();
        // Validar que la entrega pertenece a una tarea de un mg_id asignado a este maestro
        $db->query("
            SELECT mgp.teacher_user_id
            FROM task_submissions s
            JOIN course_tasks t            ON t.id = s.task_id
            JOIN materia_grupo_profesor mgp ON mgp.mg_id = t.mg_id
            WHERE s.id = :sid
            LIMIT 1
        ", [':sid'=>$submission]);
        $row = $db->fetch();
        if (!$row || (int)$row->teacher_user_id !== $teacherId) {
            header("Location: /src/plataforma/app/teacher"); exit;
        }

        $db->query("
            UPDATE task_submissions
               SET grade = :g, feedback = :fb, graded_at = NOW()
             WHERE id = :sid
        ", [':g'=>$grade, ':fb'=>$feedback ?: null, ':sid'=>$submission]);

        header("Location: /src/plataforma/app/teacher/courses/show?id={$mgId}#calificaciones");
        exit;
    }

    /* ===================== Subir recurso ===================== */
    public function storeResource() {
        $this->requireRole(['teacher']);
        $teacherId = (int)($_SESSION['user']['id'] ?? 0);

        $mgId  = (int)($_POST['course_id'] ?? 0); // mg_id
        $title = trim($_POST['title'] ?? '');

        if ($mgId<=0 || $title==='') {
            header("Location: /src/plataforma/app/teacher/courses/show?id={$mgId}#recursos"); exit;
        }

        $db = new Database();
        // Ownership via tabla puente
        $db->query("
            SELECT 1
            FROM materia_grupo_profesor
            WHERE mg_id = :mg AND teacher_user_id = :tid
            LIMIT 1
        ", [':mg'=>$mgId, ':tid'=>$teacherId]);
        if (!$db->fetchColumn()) { header("Location: /src/plataforma/app/teacher"); exit; }

        $fileUrl = null;
        if (!empty($_FILES['file']['tmp_name'] ?? '')) {
            $fileUrl = Storage::saveUpload($this->filesCfg(), 'resources', $_FILES['file']);
        }

        $db->query("
            INSERT INTO course_resources (mg_id, uploaded_by_teacher_user_id, title, file_path, created_at)
            VALUES (:mg, :tid, :t, :fp, NOW())
        ", [':mg'=>$mgId, ':tid'=>$teacherId, ':t'=>$title, ':fp'=>$fileUrl]);

        header("Location: /src/plataforma/app/teacher/courses/show?id={$mgId}#recursos");
        exit;
    }
}
