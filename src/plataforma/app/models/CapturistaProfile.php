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
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    }

    /* ================= Helpers ================= */

    /** Mapea y normaliza a enum de BD: 'active' | 'inactive' */
    private function normPerfilStatus(?string $v): string {
        $v = $v ? mb_strtolower(trim($v)) : 'active';
        $map = [
            'activo'   => 'active',
            'inactivo' => 'inactive',
        ];
        if (isset($map[$v])) $v = $map[$v];
        return in_array($v, ['active','inactive'], true) ? $v : 'active';
    }

    /** Acepta español/inglés para filtrar, true si mapea a enum válido */
    private function isPerfilStatus(string $v): bool {
        $v = $this->normPerfilStatus($v);
        return in_array($v, ['active','inactive'], true);
    }

    private function isUserStatus(string $v): bool {
        return in_array(mb_strtolower(trim($v)), ['active','inactive','suspended'], true);
    }

    private function normEmpleado(string $v): string {
        $v = preg_replace('/\D+/', '', $v);
        return str_pad(substr($v, 0, 4), 4, '0', STR_PAD_LEFT);
    }

    /** Vacío -> NULL, sino CURP en mayúsculas */
    private function normCurpNullable(?string $v): ?string {
        $t = trim((string)($v ?? ''));
        if ($t === '') return null;
        return mb_strtoupper($t);
    }

    /* ================= CRUD perfil ================= */

    public function create(array $data): int
    {
        $sql = "INSERT INTO capturista_profiles
                (user_id, numero_empleado, curp, fecha_ingreso, status, created_at, updated_at)
                VALUES (:user_id, :numero_empleado, :curp, :fecha_ingreso, :status, NOW(), NOW())";

        $stmt = $this->db->prepare($sql);

        $userId         = (int)($data['user_id'] ?? 0);
        $numeroEmpleado = $this->normEmpleado((string)($data['numero_empleado'] ?? '0'));
        $curp           = $this->normCurpNullable($data['curp'] ?? null);
        $fechaIngreso   = $data['fecha_ingreso'] ?? null;
        $status         = $this->normPerfilStatus($data['status'] ?? null);

        $stmt->bindValue(':user_id',         $userId, PDO::PARAM_INT);
        $stmt->bindValue(':numero_empleado', $numeroEmpleado, PDO::PARAM_STR);
        if ($curp === null) {
            $stmt->bindValue(':curp', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':curp', $curp, PDO::PARAM_STR);
        }
        if ($fechaIngreso === null || $fechaIngreso === '') {
            $stmt->bindValue(':fecha_ingreso', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':fecha_ingreso', $fechaIngreso, PDO::PARAM_STR);
        }
        $stmt->bindValue(':status',          $status, PDO::PARAM_STR);

        $stmt->execute();
        return (int)$this->db->lastInsertId();
    }

    public function updateByUserId(int $userId, array $data): bool
    {
        $sql = "UPDATE capturista_profiles
                SET numero_empleado = :numero_empleado,
                    curp           = :curp,
                    fecha_ingreso  = :fecha_ingreso,
                    status         = :status,
                    updated_at     = NOW()
                WHERE user_id = :user_id
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        $numeroEmpleado = $this->normEmpleado((string)($data['numero_empleado'] ?? '0'));
        $curp           = $this->normCurpNullable($data['curp'] ?? null);
        $fechaIngreso   = $data['fecha_ingreso'] ?? null;
        $status         = $this->normPerfilStatus($data['status'] ?? null);

        $stmt->bindValue(':user_id',         $userId, PDO::PARAM_INT);
        $stmt->bindValue(':numero_empleado', $numeroEmpleado, PDO::PARAM_STR);
        if ($curp === null) {
            $stmt->bindValue(':curp', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':curp', $curp, PDO::PARAM_STR);
        }
        if ($fechaIngreso === null || $fechaIngreso === '') {
            $stmt->bindValue(':fecha_ingreso', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindValue(':fecha_ingreso', $fechaIngreso, PDO::PARAM_STR);
        }
        $stmt->bindValue(':status',          $status, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function findByUserId(int $userId): ?object
    {
        $stmt = $this->db->prepare("SELECT * FROM capturista_profiles WHERE user_id = :id LIMIT 1");
        $stmt->execute([':id' => $userId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function deleteByUserId(int $userId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM capturista_profiles WHERE user_id = :id");
        return $stmt->execute([':id' => $userId]);
    }

    /* ================= Listado con users ================= */

    public function getAllWithUser(array $filters, int $limit, int $offset): array
    {
        $sql = "SELECT u.id as user_id, u.nombre, u.apellido_paterno, u.apellido_materno,
                       u.email, u.telefono, u.fecha_nacimiento, u.status as user_status,
                       cp.numero_empleado, cp.curp, cp.fecha_ingreso, cp.status as capturista_status
                FROM users u
                INNER JOIN capturista_profiles cp ON cp.user_id = u.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= " AND (
                u.nombre LIKE :search
                OR u.apellido_paterno LIKE :search
                OR u.apellido_materno LIKE :search
                OR u.email LIKE :search
                OR cp.numero_empleado LIKE :search
                OR cp.curp LIKE :search
            )";
            $params[':search'] = '%'.$filters['search'].'%';
        }

        if (!empty($filters['status'])) {
            // Acepta 'activo|inactivo' o 'active|inactive'
            $mapped = $this->normPerfilStatus($filters['status']);
            if ($this->isPerfilStatus($mapped)) {
                $sql .= " AND cp.status = :cpstatus";
                $params[':cpstatus'] = $mapped;
            } elseif ($this->isUserStatus($filters['status'])) {
                $sql .= " AND u.status = :ustatus";
                $params[':ustatus'] = mb_strtolower(trim($filters['status']));
            }
        }

        $sql .= " ORDER BY cp.numero_empleado ASC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v, PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll() ?: [];
    }

    public function countWithUser(array $filters): int
    {
        $sql = "SELECT COUNT(*)
                FROM users u
                INNER JOIN capturista_profiles cp ON cp.user_id = u.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['search'])) {
            $sql .= " AND (
                u.nombre LIKE :search
                OR u.apellido_paterno LIKE :search
                OR u.apellido_materno LIKE :search
                OR u.email LIKE :search
                OR cp.numero_empleado LIKE :search
                OR cp.curp LIKE :search
            )";
            $params[':search'] = '%'.$filters['search'].'%';
        }

        if (!empty($filters['status'])) {
            $mapped = $this->normPerfilStatus($filters['status']);
            if ($this->isPerfilStatus($mapped)) {
                $sql .= " AND cp.status = :cpstatus";
                $params[':cpstatus'] = $mapped;
            } elseif ($this->isUserStatus($filters['status'])) {
                $sql .= " AND u.status = :ustatus";
                $params[':ustatus'] = mb_strtolower(trim($filters['status']));
            }
        }

        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v, PDO::PARAM_STR);
        }
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }
}
