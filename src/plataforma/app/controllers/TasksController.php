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

    /* ====================== VISTAS PRINCIPALES ====================== */

    /** Muestra todas las tareas / actividades del estudiante (vista principal) */
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location:/src/plataforma/');
            exit;
        }

        $userId = (int)($_SESSION['user']['id'] ?? 0);

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

    /** Actividades pendientes */
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

    /** Actividades entregadas */
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

    /** Actividades vencidas */
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

    $submission   = $this->getSubmission($taskId, $userId);
    $attemptsUsed = $this->getSubmissionCount($taskId, $userId);
    $maxAttempts  = (int)($task->max_attempts ?? 1);

    $canResubmitTask = false;
    $passGrade       = 7.0;

    if (($task->activity_type_slug ?? '') !== 'exam') {
        $lastGrade = $submission->grade ?? null;

        if (
            $attemptsUsed < $maxAttempts &&
            $submission &&                         // ya hubo al menos un intento
            $lastGrade !== null &&
            (float)$lastGrade < $passGrade        // no aprobatoria
        ) {
            $canResubmitTask = true;
        }
    }


    // ====== Datos extra para EXÁMENES ======
    $examSchema  = null;   // definición del examen (preguntas, opciones, correctas)
    $examAnswers = null;   // respuestas del alumno (lo que está en answers_json)

    if (($task->activity_type_slug ?? '') === 'exam') {

        // JSON del examen desde course_tasks.exam_definition
        if (!empty($task->exam_definition)) {
            $tmp = json_decode($task->exam_definition, true);
            if (is_array($tmp)) {
                $examSchema = $tmp;
            }
        }

        // JSON de respuestas desde task_submissions.answers_json
        if ($submission && !empty($submission->answers_json)) {
            $tmp = json_decode($submission->answers_json, true);
            if (is_array($tmp)) {
                $examAnswers = $tmp;
            }
        }
    }

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

    // Última entrega (si existe) y contadores de intentos
    $submission    = $this->getSubmission($taskId, $userId);
    $attemptsUsed  = $this->getSubmissionCount($taskId, $userId);
    $maxAttempts   = (int)($task->max_attempts ?? 1);
    $passGrade     = 7.0;

    // Bandera para saber si es reentrega
    $isResubmission = $submission !== null;

    // Por seguridad, validamos que todavía pueda enviar
    if ($attemptsUsed >= $maxAttempts) {
        $_SESSION['flash_error'] = 'Ya agotaste los intentos permitidos para esta actividad.';
        header("Location:/src/plataforma/app/tareas/view/$taskId");
        exit;
    }

    if ($isResubmission) {
        $lastGrade = $submission->grade ?? null;
        // Si ya está aprobada, no dejamos reenviar
        if ($lastGrade !== null && (float)$lastGrade >= $passGrade) {
            $_SESSION['flash_error'] = 'Ya tienes una calificación aprobatoria en esta actividad, no se permiten más entregas.';
            header("Location:/src/plataforma/app/tareas/view/$taskId");
            exit;
        }
    }

    $title = $isResubmission ? 'Reenviar tarea' : 'Entregar Tarea';
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

    // --- NUEVO: manejar intentos y reentregas ---
    $attemptsUsed = $this->getSubmissionCount($taskId, $userId);
    $maxAttempts  = (int)($task->max_attempts ?? 1);
    $passGrade    = 7.0;

    // Si ya alcanzó el máximo de intentos, bloquear
    if ($attemptsUsed >= $maxAttempts) {
        $_SESSION['flash_error'] = 'Ya agotaste los intentos permitidos para esta actividad.';
        header("Location:/src/plataforma/app/tareas/view/$taskId");
        exit;
    }

    // Revisar última entrega para ver si ya está aprobada
    $lastSubmission = $this->getSubmission($taskId, $userId);
    if ($lastSubmission && $lastSubmission->grade !== null && (float)$lastSubmission->grade >= $passGrade) {
        $_SESSION['flash_error'] = 'Ya tienes una calificación aprobatoria en esta actividad, no se permiten más entregas.';
        header("Location:/src/plataforma/app/tareas/view/$taskId");
        exit;
    }

    // Número de intento que se va a guardar (1, 2, 3, ...)
    $attemptNumber = $attemptsUsed + 1;

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

    // Comentarios opcionales del alumno (si los estás manejando en la tabla, ajusta el INSERT)

    // IMPORTANTE: agregar attempt_number al INSERT
    $sql = "INSERT INTO task_submissions (
                task_id,
                student_user_id,
                attempt_number,
                file_path,
                created_at
            ) VALUES (
                :task_id,
                :student_user_id,
                :attempt_number,
                :file_path,
                NOW()
            )";

    $this->db->query($sql, [
        ':task_id'        => $taskId,
        ':student_user_id'=> $userId,
        ':attempt_number' => $attemptNumber,
        ':file_path'      => $filePath,
    ]);

    $_SESSION['flash_success'] = $attemptNumber > 1
        ? 'Reentrega guardada correctamente.'
        : 'Actividad entregada correctamente.';

    header("Location:/src/plataforma/app/tareas/view/$id");
    exit;
}


    /* ====================== EXÁMENES (alumno) ====================== */

    /** Ver / responder un examen */
    public function exam($id)
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

        // Cargar JSON del examen
        $examSchema = null;
        if (!empty($task->exam_definition)) {
            $decoded = json_decode($task->exam_definition, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $examSchema = $decoded;
            }
        }

        if (!$examSchema || empty($examSchema['questions']) || !is_array($examSchema['questions'])) {
            $_SESSION['flash_error'] = 'Este examen aún no está configurado correctamente.';
            header("Location:/src/plataforma/app/tareas/view/$taskId");
            exit;
        }

        // Intentos
        $attemptsUsed = $this->getSubmissionCount($taskId, $userId);
        $maxAttempts  = (int)($task->max_attempts ?? 1);
        $canSubmit    = $attemptsUsed < $maxAttempts;

        // Último intento (para mostrar resumen si quieres)
        $lastSubmission = null;
        $sqlLast = "
            SELECT id, created_at, grade, feedback, answers_json
            FROM task_submissions
            WHERE task_id = :tid
              AND student_user_id = :uid
            ORDER BY created_at DESC
            LIMIT 1
        ";
        $this->db->query($sqlLast, [
            ':tid' => $taskId,
            ':uid' => $userId
        ]);
        $lastSubmission = $this->db->fetch() ?: null;

        $title = 'Examen';
        $user  = $_SESSION['user'];

        // $task, $examSchema, $attemptsUsed, $maxAttempts, $canSubmit, $lastSubmission
        ob_start();
        include __DIR__ . '/../views/student/tasks/exam.php';
        $content = ob_get_clean();

        include __DIR__ . '/../views/layouts/student.php';
    }

    /** Guardar respuestas de examen + autocalificar (0–10) */
    public function storeExam($id)
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
            $_SESSION['flash_error'] = 'No se encontró el examen o no tienes acceso.';
            header('Location:/src/plataforma/app/tareas');
            exit;
        }

        if (($task->activity_type_slug ?? '') !== 'exam') {
            header("Location:/src/plataforma/app/tareas/view/$taskId");
            exit;
        }

        // Respetar max_attempts
        $attemptsUsed = $this->getSubmissionCount($taskId, $userId);
        $maxAttempts  = (int)($task->max_attempts ?? 1);
        if ($attemptsUsed >= $maxAttempts) {
            $_SESSION['flash_error'] = 'Ya agotaste los intentos permitidos para este examen.';
            header("Location:/src/plataforma/app/tareas/view/$taskId");
            exit;
        }

        // Cargar definición del examen
        $this->db->query("
            SELECT exam_definition
            FROM course_tasks
            WHERE id = :tid
            LIMIT 1
        ", [':tid' => $taskId]);
        $row = $this->db->fetch();

        if (!$row || empty($row->exam_definition)) {
            $_SESSION['flash_error'] = 'El examen no tiene una definición válida.';
            header("/src/plataforma/app/tareas/view/$taskId");
            exit;
        }

        $schema = json_decode($row->exam_definition, true);
        if (!is_array($schema) || empty($schema['questions']) || !is_array($schema['questions'])) {
            $_SESSION['flash_error'] = 'El examen no está bien configurado.';
            header("/src/plataforma/app/tareas/view/$taskId");
            exit;
        }

        $questions  = $schema['questions'];
        $rawAnswers = $_POST['answers'] ?? [];
        $now        = date('Y-m-d H:i:s');

        $answersNormalized = [];
        $autoQuestions     = 0;
        $correctCount      = 0;

        foreach ($questions as $index => $q) {
            $qType = strtolower($q['type'] ?? 'multiple_choice');
            $raw   = $rawAnswers[$index] ?? null;

            // ---- Normalizar para guardar en answers_json ----
            if ($qType === 'multiple_choice') {
                if (is_array($raw)) {
                    $normalized = array_values(
                        array_filter(
                            array_map('intval', $raw),
                            fn($v) => $v !== null
                        )
                    );
                } elseif ($raw !== null && $raw !== '') {
                    $normalized = [(int)$raw];
                } else {
                    $normalized = [];
                }
                $answersNormalized[$index] = $normalized;
            } elseif ($qType === 'single_choice') {
                $answersNormalized[$index] = ($raw !== null && $raw !== '') ? (int)$raw : null;
            } elseif ($qType === 'short_answer') {
                $answersNormalized[$index] = is_array($raw)
                    ? implode(' ', $raw)
                    : (string)($raw ?? '');
            } else {
                $answersNormalized[$index] = $raw;
            }

            // ---- Autocorrección solo para single_choice / multiple_choice ----
            if ($qType === 'single_choice' || $qType === 'multiple_choice') {
                if (empty($q['correct']) || !is_array($q['correct'])) {
                    continue;
                }

                $correct = array_map('intval', $q['correct']);
                sort($correct);
                $autoQuestions++;

                if ($qType === 'single_choice') {
                    $userAnswer = ($raw !== null && $raw !== '') ? (int)$raw : null;
                    if ($userAnswer !== null && count($correct) === 1 && $userAnswer === $correct[0]) {
                        $correctCount++;
                    }
                } elseif ($qType === 'multiple_choice') {
                    $userOpts = [];
                    if (is_array($raw)) {
                        $userOpts = array_values(
                            array_filter(
                                array_map('intval', $raw),
                                fn($v) => $v !== null
                            )
                        );
                    } elseif ($raw !== null && $raw !== '') {
                        $userOpts = [(int)$raw];
                    }
                    sort($userOpts);

                    if ($userOpts === $correct) {
                        $correctCount++;
                    }
                }
            }
        }

        // Cada pregunta vale lo mismo → proporción de correctas
        $grade10 = null;
        if ($autoQuestions > 0) {
            $ratio   = $correctCount / $autoQuestions;
            $grade10 = round($ratio * 10, 2); // 0–10
        }

        $detail = [
            'submitted_at'   => $now,
            'auto_questions' => $autoQuestions,
            'correct_count'  => $correctCount,
            'grade_10'       => $grade10,
            'answers'        => $answersNormalized,
        ];
        $detailJson = json_encode($detail, JSON_UNESCAPED_UNICODE);

// Antes del INSERT, calcula el número de intento:
$attemptsUsed = $this->getSubmissionCount($taskId, $userId);
$attemptNumber = $attemptsUsed + 1;

// ...

$sql = "
    INSERT INTO task_submissions
        (task_id, student_user_id, attempt_number, file_path, created_at, grade, feedback, graded_at, answers_json)
    VALUES
        (:task_id, :uid, :attempt_number, NULL, :created_at, :grade, NULL, :graded_at, :answers_json)
";

$this->db->query($sql, [
    ':task_id'        => $taskId,
    ':uid'            => $userId,
    ':attempt_number' => $attemptNumber,
    ':created_at'     => $now,
    ':grade'          => $grade10,
    ':graded_at'      => $grade10 !== null ? $now : null,
    ':answers_json'   => $detailJson,
]);


        if ($grade10 !== null) {
            $_SESSION['flash_success'] = 'Examen enviado. Calificación automática: '.$grade10.'/10 (el profesor puede ajustarla).';
        } else {
            $_SESSION['flash_success'] = 'Examen enviado. El profesor revisará tu intento.';
        }

        header('Location:/src/plataforma/app/tareas/submitted');
        exit;
    }

    /* ====================== QUERIES (solo alumno) ====================== */

    /** Grupo del alumno */
    private function getStudentGroupId(int $userId): ?int
    {
        $sql = "SELECT sp.grupo_id FROM student_profiles sp WHERE sp.user_id = :uid LIMIT 1";
        $this->db->query($sql, [':uid' => $userId]);
        $row = $this->db->fetch();
        return $row ? (int)$row->grupo_id : null;
    }

    /** Actividades pendientes (no entregadas) */
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

    /** Actividades entregadas */
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

    /** Actividades vencidas no entregadas */
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

    /** Detalle de actividad (validando grupo del alumno) */
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
            ct.file_path,          -- <---- AGREGA ESTA LÍNEA
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


    /** Última entrega del alumno para una actividad */
    private function getSubmission($taskId, $userId): ?object
{
    $sql = "
        SELECT 
            ts.id,
            ts.file_path,
            ts.created_at AS submission_date,
            ts.grade,
            ts.feedback,
            ts.answers_json
        FROM task_submissions ts
        WHERE ts.task_id = :tid
          AND ts.student_user_id = :uid
        ORDER BY ts.created_at DESC
        LIMIT 1
    ";
    $this->db->query($sql, [':tid' => (int)$taskId, ':uid' => (int)$userId]);
    return $this->db->fetch() ?: null;
}


    /** Número de intentos del alumno en una actividad */
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
