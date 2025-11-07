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

    /** Muestra todas las tareas del estudiante (vista principal) */
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

        $title = 'Mis Tareas';
        $user  = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/index.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Muestra las tareas pendientes */
    public function pending()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) { 
            header('Location:/src/plataforma/'); 
            exit; 
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $tasks  = $this->getPendingTasks($userId);

        $title = 'Tareas Pendientes';
        $user  = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/pending.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Muestra las tareas entregadas */
    public function submitted()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) { 
            header('Location:/src/plataforma/'); 
            exit; 
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $tasks  = $this->getSubmittedTasks($userId);

        $title = 'Tareas Entregadas';
        $user  = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/submitted.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Muestra las tareas vencidas */
    public function overdue()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) { 
            header('Location:/src/plataforma/'); 
            exit; 
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $tasks  = $this->getOverdueTasks($userId);

        $title = 'Tareas Vencidas';
        $user  = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/overdue.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Detalle de una tarea */
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

        $title = 'Detalle de Tarea';
        $user  = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/view.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Formulario de entrega */
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

        $submission = $this->getSubmission($taskId, $userId);

        $title = 'Entregar Tarea';
        $user  = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/submit.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Procesa el envío de una tarea */
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

        // Doble entrega no permitida
        if ($this->getSubmission($taskId, $userId)) {
            $_SESSION['flash_error'] = 'Ya has entregado esta tarea anteriormente.';
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

        // Insert acorde a tu tabla real (NO existe comments / NI student_id)
        $sql = "INSERT INTO task_submissions (task_id, student_user_id, file_path, created_at) 
                VALUES (:task_id, :student_user_id, :file_path, NOW())";

        $this->db->query($sql, [
            ':task_id'         => $taskId,
            ':student_user_id' => $userId,
            ':file_path'       => $filePath
        ]);

        $_SESSION['flash_success'] = 'Tarea entregada correctamente.';
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
                CONCAT_WS(' ', tu.nombre, tu.apellido_paterno, tu.apellido_materno) AS teacher_name
            FROM course_tasks ct
            INNER JOIN materias_grupos mg ON mg.id = ct.mg_id
            INNER JOIN materias m        ON m.id = mg.materia_id
            INNER JOIN users   tu        ON tu.id = ct.created_by_teacher_user_id
            LEFT  JOIN task_submissions ts 
                   ON ts.task_id = ct.id AND ts.student_user_id = :uid
            WHERE mg.grupo_id = :gid
              AND ts.id IS NULL
              AND (ct.due_at IS NULL OR ct.due_at > NOW())
            ORDER BY ct.due_at IS NULL, ct.due_at ASC, ct.id DESC
        ";
        $this->db->query($sql, [':uid' => (int)$userId, ':gid' => $gid]);
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
                ts.feedback
            FROM task_submissions ts
            INNER JOIN course_tasks ct ON ct.id = ts.task_id
            INNER JOIN materias_grupos mg ON mg.id = ct.mg_id
            INNER JOIN materias m        ON m.id = mg.materia_id
            INNER JOIN users   tu        ON tu.id = ct.created_by_teacher_user_id
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
            CONCAT_WS(' ', tu.nombre, tu.apellido_paterno, tu.apellido_materno) AS teacher_name
        FROM course_tasks ct
        INNER JOIN materias_grupos mg ON mg.id = ct.mg_id
        INNER JOIN materias m        ON m.id = mg.materia_id
        INNER JOIN users   tu        ON tu.id = ct.created_by_teacher_user_id
        LEFT  JOIN task_submissions ts 
               ON ts.task_id = ct.id AND ts.student_user_id = :uid
        WHERE mg.grupo_id = :gid
          AND ts.id IS NULL
          AND ct.due_at IS NOT NULL
          AND ct.due_at <= NOW()
        ORDER BY ct.due_at DESC, ct.id DESC
    ";
    $this->db->query($sql, [':uid' => (int)$userId, ':gid' => $gid]);
    return $this->db->fetchAll() ?: [];
}


    /** Detalle de tarea (validando que pertenezca al grupo del alumno) */
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
                m.nombre AS course_name,
                m.clave  AS course_code,
                CONCAT_WS(' ', tu.nombre, tu.apellido_paterno, tu.apellido_materno) AS teacher_name
            FROM course_tasks ct
            INNER JOIN materias_grupos mg ON mg.id = ct.mg_id
            INNER JOIN materias m        ON m.id = mg.materia_id
            INNER JOIN users   tu        ON tu.id = ct.created_by_teacher_user_id
            WHERE ct.id = :tid
              AND mg.grupo_id = :gid
            LIMIT 1
        ";
        $this->db->query($sql, [':tid' => (int)$taskId, ':gid' => $gid]);
        return $this->db->fetch() ?: null;
    }

    /** Entrega del alumno para una tarea */
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
            LIMIT 1
        ";
        $this->db->query($sql, [':tid' => (int)$taskId, ':uid' => (int)$userId]);
        return $this->db->fetch() ?: null;
    }
}
