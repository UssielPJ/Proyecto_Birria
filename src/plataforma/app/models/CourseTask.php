<?php
namespace App\Models;

use App\Core\Database;

class CourseTask
{
    private Database $db;
    private string $table = 'course_tasks';

    public function __construct(?Database $db = null)
    {
        $this->db = $db ?? new Database();
    }

    /** Actividades por mg_id (materia_grupo) */
    public function getByMgId(int $mgId): array
    {
        $sql = "
            SELECT 
                ct.id,
                ct.mg_id,
                ct.created_by_teacher_user_id,
                ct.title,
                ct.description,
                ct.due_at,
                ct.file_path,
                ct.activity_type_id,
                ct.weight_percent,
                ct.max_attempts,
                ct.total_points,
                ct.parcial,
                ct.created_at,
                at.name AS activity_type_name,
                at.slug AS activity_type_slug
            FROM {$this->table} ct
            LEFT JOIN activity_types at ON at.id = ct.activity_type_id
            WHERE ct.mg_id = :mg
            ORDER BY ct.parcial ASC, ct.due_at ASC, ct.created_at ASC
        ";
        $this->db->query($sql, [':mg' => $mgId]);
        return $this->db->fetchAll() ?: [];
    }

    /** Una actividad por id */
    public function findById(int $id): ?object
    {
        $sql = "
            SELECT 
                ct.id,
                ct.mg_id,
                ct.created_by_teacher_user_id,
                ct.title,
                ct.description,
                ct.due_at,
                ct.file_path,
                ct.activity_type_id,
                ct.weight_percent,
                ct.max_attempts,
                ct.total_points,
                ct.parcial,
                ct.created_at,
                at.name AS activity_type_name,
                at.slug AS activity_type_slug
            FROM {$this->table} ct
            LEFT JOIN activity_types at ON at.id = ct.activity_type_id
            WHERE ct.id = :id
        ";
        $this->db->query($sql, [':id' => $id]);
        return $this->db->fetch() ?: null;
    }

    /** Crear actividad (tarea/examen/proyecto/etc.) */
    public function create(array $data): int
    {
        $sql = "
            INSERT INTO {$this->table}
            (mg_id, created_by_teacher_user_id, title, description, due_at, file_path,
             activity_type_id, weight_percent, max_attempts, total_points, parcial, created_at)
            VALUES
            (:mg_id, :teacher_id, :title, :description, :due_at, :file_path,
             :activity_type_id, :weight_percent, :max_attempts, :total_points, :parcial, NOW())
        ";

        $mgId         = (int)($data['mg_id'] ?? 0);
        $teacherId    = (int)($data['created_by_teacher_user_id'] ?? 0);
        $title        = trim($data['title'] ?? '');
        $description  = trim($data['description'] ?? '');
        $dueAt        = $data['due_at'] ?? null;
        $filePath     = $data['file_path'] ?? null;
        $typeId       = (int)($data['activity_type_id'] ?? 0);
        $weight       = (float)($data['weight_percent'] ?? 0);
        $maxAttempts  = (int)($data['max_attempts'] ?? 1);
        $totalPoints  = (float)($data['total_points'] ?? 10);
        $parcial      = (int)($data['parcial'] ?? 1);

        if ($title === '' || $mgId <= 0 || $teacherId <= 0 || $typeId <= 0) {
            throw new \InvalidArgumentException('Datos insuficientes para crear la actividad.');
        }

        // saneo básico
        if ($weight < 0)   $weight = 0;
        if ($weight > 100) $weight = 100;
        if ($maxAttempts <= 0) $maxAttempts = 1;
        if ($maxAttempts > 10) $maxAttempts = 10;
        if ($parcial <= 0) $parcial = 1;
        if ($parcial > 3)  $parcial = 3;
        if ($totalPoints <= 0) $totalPoints = 10;

        $this->db->query($sql, [
            ':mg_id'            => $mgId,
            ':teacher_id'       => $teacherId,
            ':title'            => $title,
            ':description'      => $description ?: null,
            ':due_at'           => $dueAt ?: null,
            ':file_path'        => $filePath ?: null,
            ':activity_type_id' => $typeId,
            ':weight_percent'   => $weight,
            ':max_attempts'     => $maxAttempts,
            ':total_points'     => $totalPoints,
            ':parcial'          => $parcial,
        ]);

        return (int)$this->db->lastInsertId();
    }

    /** Actualizar actividad */
    public function update(int $id, array $data): bool
    {
        $sql = "
            UPDATE {$this->table}
            SET title            = :title,
                description      = :description,
                due_at           = :due_at,
                file_path        = :file_path,
                activity_type_id = :activity_type_id,
                weight_percent   = :weight_percent,
                max_attempts     = :max_attempts,
                total_points     = :total_points,
                parcial          = :parcial
            WHERE id = :id
        ";

        $title        = trim($data['title'] ?? '');
        $description  = trim($data['description'] ?? '');
        $dueAt        = $data['due_at'] ?? null;
        $filePath     = $data['file_path'] ?? null;
        $typeId       = (int)($data['activity_type_id'] ?? 0);
        $weight       = (float)($data['weight_percent'] ?? 0);
        $maxAttempts  = (int)($data['max_attempts'] ?? 1);
        $totalPoints  = (float)($data['total_points'] ?? 10);
        $parcial      = (int)($data['parcial'] ?? 1);

        if ($title === '' || $typeId <= 0) {
            throw new \InvalidArgumentException('Título y tipo de actividad son requeridos.');
        }

        if ($weight < 0)   $weight = 0;
        if ($weight > 100) $weight = 100;
        if ($maxAttempts <= 0) $maxAttempts = 1;
        if ($maxAttempts > 10) $maxAttempts = 10;
        if ($parcial <= 0) $parcial = 1;
        if ($parcial > 3)  $parcial = 3;
        if ($totalPoints <= 0) $totalPoints = 10;

        $this->db->query($sql, [
            ':title'            => $title,
            ':description'      => $description ?: null,
            ':due_at'           => $dueAt ?: null,
            ':file_path'        => $filePath ?: null,
            ':activity_type_id' => $typeId,
            ':weight_percent'   => $weight,
            ':max_attempts'     => $maxAttempts,
            ':total_points'     => $totalPoints,
            ':parcial'          => $parcial,
            ':id'               => $id,
        ]);

        return $this->db->rowCount() >= 0;
    }

    /** Eliminar actividad (cascada borrará task_submissions) */
    public function delete(int $id): bool
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id", [':id' => $id]);
        return $this->db->rowCount() > 0;
    }
}
