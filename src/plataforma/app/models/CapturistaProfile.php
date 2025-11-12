<?php
namespace App\Models;

use App\Core\Database as DB;
use PDO;

class CapturistaProfile
{
    private PDO $db;

    public function __construct(?PDO $pdo = null)
    {
        $this->db = $pdo ?? (new DB())->getPdo();
    }

    /**
     * Crea un nuevo registro de perfil de capturista
     * @param array $data
     * @return int ID del registro (user_id)
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO capturista_profiles (
                    user_id, numero_empleado, telefono, curp,
                    fecha_ingreso, status, created_at, updated_at
                ) VALUES (
                    :user_id, :numero_empleado, :telefono, :curp,
                    :fecha_ingreso, :status, NOW(), NOW()
                )";

        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute([
                ':user_id'         => (int)$data['user_id'],
                ':numero_empleado' => $data['numero_empleado'],
                ':telefono'        => $data['telefono'],
                ':curp'            => $data['curp'],
                ':fecha_ingreso'   => $data['fecha_ingreso'],
                ':status'          => $data['status'] ?? 'activo',
            ]);
        } catch (\PDOException $e) {
            error_log('CapturistaProfile@create ERROR: ' . $e->getMessage());
            throw $e;
        }

        return (int)$data['user_id'];
    }

    /**
     * Actualiza el perfil de un capturista según el user_id
     */
    public function updateByUserId(int $userId, array $data): bool
    {
        $sql = "UPDATE capturista_profiles SET
                    numero_empleado = :numero_empleado,
                    telefono = :telefono,
                    curp = :curp,
                    fecha_ingreso = :fecha_ingreso,
                    status = :status,
                    updated_at = NOW()
                WHERE user_id = :user_id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':user_id'         => (int)$userId,
            ':numero_empleado' => $data['numero_empleado'],
            ':telefono'        => $data['telefono'],
            ':curp'            => $data['curp'],
            ':fecha_ingreso'   => $data['fecha_ingreso'],
            ':status'          => $data['status'] ?? 'activo',
        ]);
    }

    /**
     * Obtiene el perfil completo de un capturista
     */
    public function findByUserId(int $userId): ?object
    {
        $stmt = $this->db->prepare("SELECT * FROM capturista_profiles WHERE user_id = :id LIMIT 1");
        $stmt->execute([':id' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row ?: null;
    }

    /**
     * Elimina el perfil del capturista
     */
    public function deleteByUserId(int $userId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM capturista_profiles WHERE user_id = :id");
        return $stmt->execute([':id' => $userId]);
    }

    /**
     * Listado con filtros (join con users)
     */
    public function getAllWithUser(array $filters = []): array
    {
        $query = "SELECT
                    u.id, u.email, u.nombre, u.apellido_paterno, u.apellido_materno, u.telefono,
                    u.fecha_nacimiento, u.status as user_status, u.created_at,
                    cp.numero_empleado, cp.telefono as capturista_telefono, cp.curp,
                    cp.fecha_ingreso, cp.status as capturista_status
                  FROM users u
                  JOIN capturista_profiles cp ON cp.user_id = u.id
                  WHERE 1=1";

        $params = [];

        if (!empty($filters['search'])) {
            $query .= " AND (u.nombre LIKE :search OR u.email LIKE :search OR cp.numero_empleado LIKE :search OR cp.curp LIKE :search)";
            $params[':search'] = "%{$filters['search']}%";
        }
        if (!empty($filters['status'])) {
            $query .= " AND cp.status = :status";
            $params[':status'] = $filters['status'];
        }

        $query .= " ORDER BY cp.numero_empleado ASC";

        if (isset($filters['limit'])) {
            $query .= " LIMIT :limit OFFSET :offset";
            $params[':limit'] = (int)($filters['limit'] ?? 10);
            $params[':offset'] = (int)($filters['offset'] ?? 0);
        }

        $stmt = $this->db->prepare($query);

        // Bind seguro
        foreach ($params as $k => $v) {
            if (in_array($k, [':limit', ':offset'])) {
                $stmt->bindValue($k, $v, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($k, $v);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}