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

    /**
     * Muestra todas las tareas del estudiante (vista principal)
     */
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) { 
            header('Location:/src/plataforma/'); 
            exit; 
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);

        // Obtener todas las tareas del estudiante
        $pendingTasks = $this->getPendingTasks($userId);
        $submittedTasks = $this->getSubmittedTasks($userId);
        $overdueTasks = $this->getOverdueTasks($userId);

        // Cargar la vista
        $title = 'Mis Tareas';
        $user = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/index.php';
        $content = ob_get_clean();

        // Incluir el layout del estudiante
        include __DIR__ . '/../views/layouts/student.php';
    }

    /**
     * Muestra las tareas pendientes
     */
    public function pending()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) { 
            header('Location:/src/plataforma/'); 
            exit; 
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $tasks = $this->getPendingTasks($userId);

        $title = 'Tareas Pendientes';
        $user = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/pending.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /**
     * Muestra las tareas entregadas
     */
    public function submitted()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) { 
            header('Location:/src/plataforma/'); 
            exit; 
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $tasks = $this->getSubmittedTasks($userId);

        $title = 'Tareas Entregadas';
        $user = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/submitted.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /**
     * Muestra las tareas vencidas
     */
    public function overdue()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) { 
            header('Location:/src/plataforma/'); 
            exit; 
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $tasks = $this->getOverdueTasks($userId);

        $title = 'Tareas Vencidas';
        $user = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/overdue.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /**
     * Muestra el detalle de una tarea específica
     */
    public function view($id)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) { 
            header('Location:/src/plataforma/'); 
            exit; 
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $taskId = (int)$id;

        // Obtener detalles de la tarea
        $task = $this->getTaskById($taskId, $userId);

        if (!$task) {
            header('Location:/src/plataforma/app/tareas');
            exit;
        }

        // Verificar si ya ha sido entregada
        $submission = $this->getSubmission($taskId, $userId);

        $title = 'Detalle de Tarea';
        $user = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/view.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /**
     * Muestra el formulario para entregar una tarea
     */
    public function submit($id)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) { 
            header('Location:/src/plataforma/'); 
            exit; 
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $taskId = (int)$id;

        // Obtener detalles de la tarea
        $task = $this->getTaskById($taskId, $userId);

        if (!$task) {
            header('Location:/src/plataforma/app/tareas');
            exit;
        }

        // Verificar si ya ha sido entregada
        $submission = $this->getSubmission($taskId, $userId);

        $title = 'Entregar Tarea';
        $user = $_SESSION['user'];

        ob_start();
        include __DIR__ . '/../views/student/tasks/submit.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /**
     * Procesa el envío de una tarea
     */
    public function storeSubmission($id)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) { 
            header('Location:/src/plataforma/'); 
            exit; 
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);
        $taskId = (int)$id;

        // Verificar que la tarea existe y pertenece al estudiante
        $task = $this->getTaskById($taskId, $userId);
        if (!$task) {
            header('Location:/src/plataforma/app/tareas');
            exit;
        }

        // Verificar si ya ha sido entregada
        $existingSubmission = $this->getSubmission($taskId, $userId);
        if ($existingSubmission) {
            // Redirigir con mensaje de error
            $_SESSION['flash_error'] = 'Ya has entregado esta tarea anteriormente.';
            header("Location:/src/plataforma/app/tareas/view/$id");
            exit;
        }

        // Procesar el archivo si se proporcionó
        $filePath = null;
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../storage/task_submissions/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = 'task_' . $taskId . '_user_' . $userId . '_' . time() . '_' . basename($_FILES['file']['name']);
            $filePath = $uploadDir . $fileName;

            if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                $_SESSION['flash_error'] = 'Error al subir el archivo.';
                header("Location:/src/plataforma/app/tareas/submit/$id");
                exit;
            }

            // Guardar la ruta relativa para la base de datos
            $filePath = '/src/plataforma/storage/task_submissions/' . $fileName;
        }

        // Guardar la entrega en la base de datos
        $sql = "INSERT INTO task_submissions (task_id, student_id, file_path, comments, created_at) 
                VALUES (:task_id, :student_id, :file_path, :comments, NOW())";

        $this->db->query($sql, [
            ':task_id' => $taskId,
            ':student_id' => $userId,
            ':file_path' => $filePath,
            ':comments' => $_POST['comments'] ?? null
        ]);

        $_SESSION['flash_success'] = 'Tarea entregada correctamente.';
        header("Location:/src/plataforma/app/tareas/submitted");
        exit;
    }

    /**
     * Obtiene las tareas pendientes del estudiante
     */
    private function getPendingTasks($userId): array
    {
        $sql = "
            SELECT t.id, t.title, t.description, t.due_at, t.created_at,
                   m.nombre AS course_name, m.clave AS course_code,
                   u.name AS teacher_name
            FROM tasks t
            INNER JOIN materias m ON m.id = t.course_id
            INNER JOIN materia_grupo_profesor mgp ON mgp.materia_id = m.id
            INNER JOIN users u ON u.id = mgp.teacher_user_id
            INNER JOIN student_courses sc ON sc.materia_id = m.id
            WHERE sc.student_id = :student_id
              AND t.due_at > NOW()
              AND t.id NOT IN (
                  SELECT ts.task_id FROM task_submissions ts 
                  WHERE ts.student_id = :student_id
              )
            ORDER BY t.due_at ASC
        ";

        $this->db->query($sql, [':student_id' => $userId]);
        return $this->db->fetchAll() ?: [];
    }

    /**
     * Obtiene las tareas entregadas por el estudiante
     */
    private function getSubmittedTasks($userId): array
    {
        $sql = "
            SELECT t.id, t.title, t.description, t.due_at, t.created_at,
                   m.nombre AS course_name, m.clave AS course_code,
                   u.name AS teacher_name,
                   ts.file_path AS submission_file, ts.comments AS submission_comments,
                   ts.created_at AS submission_date, ts.grade, ts.feedback
            FROM tasks t
            INNER JOIN materias m ON m.id = t.course_id
            INNER JOIN materia_grupo_profesor mgp ON mgp.materia_id = m.id
            INNER JOIN users u ON u.id = mgp.teacher_user_id
            INNER JOIN student_courses sc ON sc.materia_id = m.id
            INNER JOIN task_submissions ts ON ts.task_id = t.id AND ts.student_id = sc.student_id
            WHERE sc.student_id = :student_id
            ORDER BY ts.created_at DESC
        ";

        $this->db->query($sql, [':student_id' => $userId]);
        return $this->db->fetchAll() ?: [];
    }

    /**
     * Obtiene las tareas vencidas no entregadas por el estudiante
     */
    private function getOverdueTasks($userId): array
    {
        $sql = "
            SELECT t.id, t.title, t.description, t.due_at, t.created_at,
                   m.nombre AS course_name, m.clave AS course_code,
                   u.name AS teacher_name
            FROM tasks t
            INNER JOIN materias m ON m.id = t.course_id
            INNER JOIN materia_grupo_profesor mgp ON mgp.materia_id = m.id
            INNER JOIN users u ON u.id = mgp.teacher_user_id
            INNER JOIN student_courses sc ON sc.materia_id = m.id
            WHERE sc.student_id = :student_id
              AND t.due_at <= NOW()
              AND t.id NOT IN (
                  SELECT ts.task_id FROM task_submissions ts 
                  WHERE ts.student_id = :student_id
              )
            ORDER BY t.due_at DESC
        ";

        $this->db->query($sql, [':student_id' => $userId]);
        return $this->db->fetchAll() ?: [];
    }

    /**
     * Obtiene una tarea específica por ID
     */
    private function getTaskById($taskId, $userId): ?object
    {
        $sql = "
            SELECT t.id, t.title, t.description, t.due_at, t.created_at,
                   m.nombre AS course_name, m.clave AS course_code,
                   u.name AS teacher_name
            FROM tasks t
            INNER JOIN materias m ON m.id = t.course_id
            INNER JOIN materia_grupo_profesor mgp ON mgp.materia_id = m.id
            INNER JOIN users u ON u.id = mgp.teacher_user_id
            INNER JOIN student_courses sc ON sc.materia_id = m.id
            WHERE sc.student_id = :student_id AND t.id = :task_id
        ";

        $this->db->query($sql, [':student_id' => $userId, ':task_id' => $taskId]);
        return $this->db->fetch() ?: null;
    }

    /**
     * Obtiene la entrega de una tarea específica
     */
    private function getSubmission($taskId, $userId): ?object
    {
        $sql = "
            SELECT ts.id, ts.file_path, ts.comments, ts.created_at, ts.grade, ts.feedback
            FROM task_submissions ts
            WHERE ts.task_id = :task_id AND ts.student_id = :student_id
        ";

        $this->db->query($sql, [':task_id' => $taskId, ':student_id' => $userId]);
        return $this->db->fetch() ?: null;
    }
}
