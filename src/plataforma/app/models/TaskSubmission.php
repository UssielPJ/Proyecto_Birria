<?php
namespace App\Models;

use App\Core\Database;

class TaskSubmission
{
    private Database $db;
    private string $table = 'task_submissions';

    public function __construct(?Database $db = null)
    {
        $this->db = $db ?? new Database();
    }

    /** Todas las entregas de un alumno en una actividad, ordenadas por intento */
    public function getByTaskAndStudent(int $taskId, int $studentUserId): array
    {
        $sql = "
            SELECT id, task_id, student_user_id, attempt_number,
                   file_path, created_at, grade, feedback, graded_at
            FROM {$this->table}
            WHERE task_id = :tid AND student_user_id = :sid
            ORDER BY attempt_number ASC, created_at ASC
        ";
        $this->db->query($sql, [
            ':tid' => $taskId,
            ':sid' => $studentUserId,
        ]);
        return $this->db->fetchAll() ?: [];
    }

    /** Número de intentos usados por el alumno en esa actividad */
    public function countAttempts(int $taskId, int $studentUserId): int
    {
        $sql = "
            SELECT COUNT(*) 
            FROM {$this->table}
            WHERE task_id = :tid AND student_user_id = :sid
        ";
        $this->db->query($sql, [
            ':tid' => $taskId,
            ':sid' => $studentUserId,
        ]);
        return (int)$this->db->fetchColumn();
    }

    /** Calificación más alta del alumno en esa actividad */
    public function getMaxGrade(int $taskId, int $studentUserId): ?float
    {
        $sql = "
            SELECT MAX(grade) AS max_grade
            FROM {$this->table}
            WHERE task_id = :tid AND student_user_id = :sid
        ";
        $this->db->query($sql, [
            ':tid' => $taskId,
            ':sid' => $studentUserId,
        ]);
        $row = $this->db->fetch();
        if ($row && $row->max_grade !== null) {
            return (float)$row->max_grade;
        }
        return null;
    }

    /**
     * Crear una entrega nueva.
     * IMPORTANTE: el controlador debe revisar que no se exceda max_attempts.
     */
    public function create(array $data): int
    {
        $taskId        = (int)($data['task_id'] ?? 0);
        $studentUserId = (int)($data['student_user_id'] ?? 0);
        $filePath      = $data['file_path'] ?? null;

        if ($taskId <= 0 || $studentUserId <= 0) {
            throw new \InvalidArgumentException('task_id y student_user_id son requeridos.');
        }

        // si no viene attempt_number, calculamos siguiente
        $attemptNumber = (int)($data['attempt_number'] ?? 0);
        if ($attemptNumber <= 0) {
            $current = $this->countAttempts($taskId, $studentUserId);
            $attemptNumber = $current + 1;
        }

        $sql = "
            INSERT INTO {$this->table}
            (task_id, student_user_id, attempt_number, file_path, created_at)
            VALUES
            (:task_id, :student_user_id, :attempt_number, :file_path, NOW())
        ";
        $this->db->query($sql, [
            ':task_id'        => $taskId,
            ':student_user_id'=> $studentUserId,
            ':attempt_number' => $attemptNumber,
            ':file_path'      => $filePath ?: null,
        ]);

        return (int)$this->db->lastInsertId();
    }

    /** Actualizar calificación y feedback de una entrega */
    public function gradeSubmission(int $id, float $grade, ?string $feedback = null): bool
    {
        $sql = "
            UPDATE {$this->table}
            SET grade = :grade,
                feedback = :feedback,
                graded_at = NOW()
            WHERE id = :id
        ";
        $this->db->query($sql, [
            ':grade'    => $grade,
            ':feedback' => $feedback ?: null,
            ':id'       => $id,
        ]);
        return $this->db->rowCount() >= 0;
    }
}
