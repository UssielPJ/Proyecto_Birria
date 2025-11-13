<?php
namespace App\Controllers;

use App\Core\Database;

class TasksController
{
    private Database $db;

    public function __construct(?Database $db = null)
    {
        $this->db = $db ?? new Database();
    }

    /** ====================== VISTAS ====================== */

    /** Muestra todas las tareas / actividades del estudiante (vista principal) */
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location:/src/plataforma/');
            exit;
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);

        // Listas para la vista principal
        $pendingTasks   = $this->getPendingTasks($userId);
        $submittedTasks = $this->getSubmittedTasks($userId);
        $overdueTasks   = $this->getOverdueTasks($userId);

        $title = 'Mis Actividades';
        $user  = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/index.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Muestra las tareas/actividades pendientes */
    public function pending()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location:/src/plataforma/');
            exit;
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $tasks  = $this->getPendingTasks($userId);

        $title = 'Actividades Pendientes';
        $user  = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/pending.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Muestra las tareas/actividades entregadas */
    public function submitted()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location:/src/plataforma/');
            exit;
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $tasks  = $this->getSubmittedTasks($userId);

        $title = 'Actividades Entregadas';
        $user  = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/submitted.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Muestra las tareas/actividades vencidas */
    public function overdue()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location:/src/plataforma/');
            exit;
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $tasks  = $this->getOverdueTasks($userId);

        $title = 'Actividades Vencidas';
        $user  = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/overdue.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Detalle de una actividad */
    public function view($id)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location:/src/plataforma/');
            exit;
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $taskId = (int)$id;

        $task = $this->getTaskById($taskId, $userId);
        if (!$task) {
            header('Location:/src/plataforma/app/tareas');
            exit;
        }

        $submission = $this->getSubmission($taskId, $userId);
        $attemptsUsed = $this->getSubmissionCount($taskId, $userId);
        $maxAttempts  = (int)($task->max_attempts ?? 1);

        $title = 'Detalle de Actividad';
        $user  = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/view.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Formulario de entrega de tarea normal (archivo) */
    public function submit($id)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location:/src/plataforma/');
            exit;
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $taskId = (int)$id;

        $task = $this->getTaskById($taskId, $userId);
        if (!$task) {
            header('Location:/src/plataforma/app/tareas');
            exit;
        }

        // Si es examen, redirigir al flujo de examen
        if (($task->activity_type_slug ?? '') === 'exam') {
            header("Location:/src/plataforma/app/tareas/exam/$taskId");
            exit;
        }

        $submission = $this->getSubmission($taskId, $userId);

        $title = 'Entregar Tarea';
        $user  = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/submit.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Procesa el envío de una tarea normal (archivo) */
    public function storeSubmission($id)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location:/src/plataforma/');
            exit;
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $taskId = (int)$id;

        // Validar tarea y pertenencia
        $task = $this->getTaskById($taskId, $userId);
        if (!$task) {
            header('Location:/src/plataforma/app/tareas');
            exit;
        }

        // Si es examen, no usar este método
        if (($task->activity_type_slug ?? '') === 'exam') {
            header("Location:/src/plataforma/app/tareas/exam/$taskId");
            exit;
        }

        // Doble entrega no permitida (para tareas normales)
        if ($this->getSubmission($taskId, $userId)) {
            $_SESSION['flash_error'] = 'Ya has entregado esta actividad anteriormente.';
            header("Location:/src/plataforma/app/tareas/view/$id");
            exit;
        }

        // Subir archivo (opcional)
        $filePath = null;
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../storage/task_submissions/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = 'task_' . $taskId . '_user_' . $userId . '_' . time() . '_' . basename($_FILES['file']['name']);
            $dest     = $uploadDir . $fileName;

            if (!move_uploaded_file($_FILES['file']['tmp_name'], $dest)) {
                $_SESSION['flash_error'] = 'Error al subir el archivo.';
                header("Location:/src/plataforma/app/tareas/submit/$id");
                exit;
            }

            // Ruta relativa para BD
            $filePath = '/src/plataforma/storage/task_submissions/' . $fileName;
        }

        $sql = "INSERT INTO task_submissions (task_id, student_user_id, file_path, created_at)
                VALUES (:task_id, :student_user_id, :file_path, NOW())";

        $this->db->query($sql, [
            ':task_id'         => $taskId,
            ':student_user_id' => $userId,
            ':file_path'       => $filePath
        ]);

        $_SESSION['flash_success'] = 'Actividad entregada correctamente.';
        header("Location:/src/plataforma/app/tareas/submitted");
        exit;
    }

    /** ================== EXÁMENES (JSON, opción única / múltiples) ================== */

    /** Mostrar formulario para presentar examen */
    public function takeExam($id)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location:/src/plataforma/');
            exit;
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $taskId = (int)$id;

        $task = $this->getTaskById($taskId, $userId);
        if (!$task) {
            header('Location:/src/plataforma/app/tareas');
            exit;
        }

        if (($task->activity_type_slug ?? '') !== 'exam') {
            header("Location:/src/plataforma/app/tareas/view/$taskId");
            exit;
        }

        $attemptsUsed = $this->getSubmissionCount($taskId, $userId);
        $maxAttempts  = (int)($task->max_attempts ?? 1);

        if ($attemptsUsed >= $maxAttempts) {
            $_SESSION['flash_error'] = 'Ya agotaste los intentos permitidos para este examen.';
            header("Location:/src/plataforma/app/tareas/view/$taskId");
            exit;
        }

        $examDef = null;
        if (!empty($task->exam_definition)) {
            $decoded = json_decode($task->exam_definition, true);
            if (is_array($decoded)) {
                $examDef = $decoded;
            }
        }

        if (!$examDef || empty($examDef['questions'])) {
            $_SESSION['flash_error'] = 'El examen aún no está configurado.';
            header("Location:/src/plataforma/app/tareas/view/$taskId");
            exit;
        }

        $title = 'Presentar Examen';
        $user  = $_SESSION['user'];

        // $task => info de la actividad/examen
        // $examDef => ['instructions','due_at','questions'=>[]]
        // $attemptsUsed, $maxAttempts
        ob_start();
        include __DIR__ . '/../views/student/tasks/exam.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Procesa el envío del examen (autocalificación) */
    public function storeExamSubmission($id)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location:/src/plataforma/');
            exit;
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $taskId = (int)$id;

        $task = $this->getTaskById($taskId, $userId);
        if (!$task) {
            header('Location:/src/plataforma/app/tareas');
            exit;
        }

        if (($task->activity_type_slug ?? '') !== 'exam') {
            header("Location:/src/plataforma/app/tareas/view/$taskId");
            exit;
        }

        $attemptsUsed = $this->getSubmissionCount($taskId, $userId);
        $maxAttempts  = (int)($task->max_attempts ?? 1);
        if ($attemptsUsed >= $maxAttempts) {
            $_SESSION['flash_error'] = 'Ya agotaste los intentos permitidos para este examen.';
            header("Location:/src/plataforma/app/tareas/view/$taskId");
            exit;
        }

        $examDef = null;
        if (!empty($task->exam_definition)) {
            $decoded = json_decode($task->exam_definition, true);
            if (is_array($decoded)) {
                $examDef = $decoded;
            }
        }

        if (!$examDef || empty($examDef['questions']) || !is_array($examDef['questions'])) {
            $_SESSION['flash_error'] = 'El examen no está configurado correctamente.';
            header("Location:/src/plataforma/app/tareas/view/$taskId");
            exit;
        }

        $rawAnswers = $_POST['answers'] ?? []; // answers[qIndex] o answers[qIndex][]
        $answers = ['questions' => []];

        foreach ($examDef['questions'] as $idx => $qDef) {
            $v = $rawAnswers[$idx] ?? null;

            if ($v === null) {
                $answers['questions'][$idx] = ['selected_indices' => []];
                continue;
            }

            if (!is_array($v)) {
                $v = [$v]; // radios → single value
            }

            $indices = [];
            foreach ($v as $one) {
                if ($one === '' && $one !== '0') continue;
                $indices[] = (int)$one;
            }

            $answers['questions'][$idx] = ['selected_indices' => $indices];
        }

        // Calificación automática
        $totalQuestions = count($examDef['questions']);
        $correctCount   = 0;

        foreach ($examDef['questions'] as $idx => $qDef) {
            $type = $qDef['type'] ?? 'single_choice';
            $given = $answers['questions'][$idx]['selected_indices'] ?? [];
            $expected = [];

            if ($type === 'single_choice' && isset($qDef['correct_index'])) {
                $expected = [(int)$qDef['correct_index']];
            } elseif ($type === 'multiple_choice' && isset($qDef['correct_indices']) && is_array($qDef['correct_indices'])) {
                $expected = array_map('intval', $qDef['correct_indices']);
            } else {
                // si no hay clave correcta definida, la pregunta no cuenta
                continue;
            }

            sort($given);
            sort($expected);

            if ($given === $expected) {
                $correctCount++;
            }
        }

        $score0to1 = $totalQuestions > 0 ? ($correctCount / $totalQuestions) : 0.0;
        $grade0to10 = round($score0to1 * 10, 2);

        $answersJson = json_encode($answers, JSON_UNESCAPED_UNICODE);

        // Guardar intento
        $sql = "INSERT INTO task_submissions (task_id, student_user_id, file_path, answers_json, created_at, grade)
                VALUES (:task_id, :student_user_id, NULL, :answers_json, NOW(), :grade)";

        $this->db->query($sql, [
            ':task_id'         => $taskId,
            ':student_user_id' => $userId,
            ':answers_json'    => $answersJson,
            ':grade'           => $grade0to10
        ]);

        $_SESSION['flash_success'] = "Examen enviado. Obtuviste {$grade0to10} / 10.";
        header("Location:/src/plataforma/app/tareas/submitted");
        exit;
    }

    /** ====================== QUERIES (solo alumno) ====================== */

    /** Grupo del alumno */
    private function getStudentGroupId(int $userId): ?int
    {
        $sql = "SELECT sp.grupo_id FROM student_profiles sp WHERE sp.user_id = :uid LIMIT 1";
        $this->db->query($sql, [':uid' => $userId]);
        $row = $this->db->fetch();
        return $row ? (int)$row->grupo_id : null;
    }

    /** Tareas / actividades pendientes (no entregadas) */
    /** Tareas pendientes (no entregadas) */
    private function getPendingTasks($userId): array
    {
        $gid = $this->getStudentGroupId((int)$userId);
        if (!$gid) return [];

        $sql = "
            SELECT 
                ct.id,
                ct.title,
                ct.description,
                ct.due_at,
                ct.created_at,
                m.nombre AS course_name,
                m.clave  AS course_code,
                CONCAT_WS(' ', tu.nombre, tu.apellido_paterno, tu.apellido_materno) AS teacher_name,
                at.slug  AS activity_type_slug,
                at.name  AS activity_type_name
            FROM course_tasks ct
            INNER JOIN materias_grupos mg 
                ON mg.id = ct.mg_id
            INNER JOIN materias m 
                ON m.id = mg.materia_id
            INNER JOIN users tu 
                ON tu.id = ct.created_by_teacher_user_id
            LEFT JOIN activity_types at 
                ON at.id = ct.activity_type_id
            LEFT JOIN task_submissions ts 
                ON ts.task_id = ct.id 
               AND ts.student_user_id = :uid
            WHERE mg.grupo_id = :gid
              AND ts.id IS NULL
              AND (ct.due_at IS NULL OR ct.due_at > NOW())
            ORDER BY ct.due_at IS NULL, ct.due_at ASC, ct.id DESC
        ";

        $this->db->query($sql, [
            ':uid' => (int)$userId,
            ':gid' => $gid
        ]);

        return $this->db->fetchAll() ?: [];
    }

    /** Tareas entregadas por el alumno */
    private function getSubmittedTasks($userId): array
    {
        $sql = "
            SELECT
                ct.id,
                ct.title,
                ct.description,
                ct.due_at,
                ct.created_at,
                m.nombre AS course_name,
                m.clave  AS course_code,
                CONCAT_WS(' ', tu.nombre, tu.apellido_paterno, tu.apellido_materno) AS teacher_name,
                ts.file_path   AS submission_file,
                ts.created_at  AS submission_date,
                ts.grade,
                ts.feedback,
                at.slug AS activity_type_slug,
                at.name AS activity_type_name
            FROM task_submissions ts
            INNER JOIN course_tasks ct 
                ON ct.id = ts.task_id
            INNER JOIN materias_grupos mg 
                ON mg.id = ct.mg_id
            INNER JOIN materias m        
                ON m.id = mg.materia_id
            INNER JOIN users tu        
                ON tu.id = ct.created_by_teacher_user_id
            LEFT JOIN activity_types at
                ON at.id = ct.activity_type_id
            WHERE ts.student_user_id = :uid
            ORDER BY ts.created_at DESC
        ";

        $this->db->query($sql, [':uid' => (int)$userId]);
        return $this->db->fetchAll() ?: [];
    }

    /** Tareas vencidas no entregadas */
    private function getOverdueTasks($userId): array
    {
        $gid = $this->getStudentGroupId((int)$userId);
        if (!$gid) return [];

        $sql = "
            SELECT 
                ct.id,
                ct.title,
                ct.description,
                ct.due_at,
                ct.created_at,
                m.nombre AS course_name,
                m.clave  AS course_code,
                CONCAT_WS(' ', tu.nombre, tu.apellido_paterno, tu.apellido_materno) AS teacher_name,
                at.slug  AS activity_type_slug,
                at.name  AS activity_type_name
            FROM course_tasks ct
            INNER JOIN materias_grupos mg 
                ON mg.id = ct.mg_id
            INNER JOIN materias m        
                ON m.id = mg.materia_id
            INNER JOIN users tu        
                ON tu.id = ct.created_by_teacher_user_id
            LEFT JOIN activity_types at
                ON at.id = ct.activity_type_id
            LEFT JOIN task_submissions ts 
                ON ts.task_id = ct.id 
               AND ts.student_user_id = :uid
            WHERE mg.grupo_id = :gid
              AND ts.id IS NULL
              AND ct.due_at IS NOT NULL
              AND ct.due_at <= NOW()
            ORDER BY ct.due_at DESC, ct.id DESC
        ";

        $this->db->query($sql, [
            ':uid' => (int)$userId,
            ':gid' => $gid
        ]);

        return $this->db->fetchAll() ?: [];
    }


    /** Detalle de actividad (validando que pertenezca al grupo del alumno) */
    private function getTaskById($taskId, $userId): ?object
    {
        $gid = $this->getStudentGroupId((int)$userId);
        if (!$gid) return null;

        $sql = "
            SELECT 
                ct.id,
                ct.title,
                ct.description,
                ct.due_at,
                ct.created_at,
                ct.activity_type_id,
                ct.max_attempts,
                ct.weight_percent,
                ct.total_points,
                ct.parcial,
                ct.exam_definition,
                at.slug AS activity_type_slug,
                at.name AS activity_type_name,
                m.nombre AS course_name,
                m.clave  AS course_code,
                CONCAT_WS(' ', tu.nombre, tu.apellido_paterno, tu.apellido_materno) AS teacher_name
            FROM course_tasks ct
            INNER JOIN materias_grupos mg ON mg.id = ct.mg_id
            INNER JOIN materias m        ON m.id = mg.materia_id
            INNER JOIN users   tu        ON tu.id = ct.created_by_teacher_user_id
            LEFT  JOIN activity_types at ON at.id = ct.activity_type_id
            WHERE ct.id = :tid
              AND mg.grupo_id = :gid
            LIMIT 1
        ";
        $this->db->query($sql, [':tid' => (int)$taskId, ':gid' => $gid]);
        return $this->db->fetch() ?: null;
    }

    /** Entrega del alumno para una actividad (última/única) */
    private function getSubmission($taskId, $userId): ?object
    {
        $sql = "
            SELECT 
                ts.id,
                ts.file_path,
                ts.created_at,
                ts.grade,
                ts.feedback
            FROM task_submissions ts
            WHERE ts.task_id = :tid
              AND ts.student_user_id = :uid
            ORDER BY ts.created_at DESC
            LIMIT 1
        ";
        $this->db->query($sql, [':tid' => (int)$taskId, ':uid' => (int)$userId]);
        return $this->db->fetch() ?: null;
    }

    /** Número de intentos (entregas) que lleva el alumno en una actividad */
    private function getSubmissionCount($taskId, $userId): int
    {
        $sql = "
            SELECT COUNT(*) AS c
            FROM task_submissions ts
            WHERE ts.task_id = :tid
              AND ts.student_user_id = :uid
        ";
        $this->db->query($sql, [':tid' => (int)$taskId, ':uid' => (int)$userId]);
        $row = $this->db->fetch();
        return $row ? (int)$row->c : 0;
    }
}
