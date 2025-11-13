<?php
namespace App\Models;

use PDO;

class CapturistaModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Listado con join a users (paginable y filtrable por status/texto)
     */
    public function list(int $limit = 20, int $offset = 0, ?string $status = null, ?string $q = null): array
    {
        $where = [];
        $params = [];

        if ($status) {
            // Acepta tanto 'active'/'inactive' como 'activo'/'inactivo'
            $statusMap = [
                'activo' => 'active',
                'inactivo' => 'inactive',
                'active' => 'active',
                'inactive' => 'inactive',
                'suspended' => 'suspended'
            ];
            $s = $statusMap[$status] ?? $status;
            $where[] = '(u.status = :ustatus OR cp.status = :cpstatus)';
            $params[':ustatus'] = $s;
            $params[':cpstatus'] = $status; // por si capturista_profiles sigue en español
        }

        if ($q) {
            $where[] = '(u.email LIKE :q OR u.nombre LIKE :q OR u.apellido_paterno LIKE :q OR u.apellido_materno LIKE :q OR cp.numero_empleado LIKE :q OR cp.curp LIKE :q)';
            $params[':q'] = "%$q%";
        }

        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

        $sql = "SELECT cp.id as capturista_id, cp.user_id, cp.numero_empleado, cp.curp, cp.fecha_ingreso,
                       cp.status AS cp_status,
                       u.id as user_id_real, u.email, u.nombre, u.apellido_paterno, u.apellido_materno,
                       u.telefono, u.status AS u_status, u.created_at, u.updated_at
                FROM capturista_profiles cp
                JOIN users u ON u.id = cp.user_id
                $whereSql
                ORDER BY cp.id DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue($k, $v);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un capturista por id de perfil
     */
    public function find(int $capturistaId): ?array
    {
        $sql = "SELECT cp.*, u.email, u.nombre, u.apellido_paterno, u.apellido_materno, u.telefono, u.status AS u_status
                FROM capturista_profiles cp
                JOIN users u ON u.id = cp.user_id
                WHERE cp.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $capturistaId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * Crea user + profile en transacción
     */
    public function create(array $userData, array $profileData): int
    {
        $this->db->beginTransaction();
        try {
            // users
            $uSql = "INSERT INTO users (email, password, nombre, apellido_paterno, apellido_materno, telefono, fecha_nacimiento, status)
                     VALUES (:email, :password, :nombre, :ap, :am, :tel, :fn, :status)";
            $u = $this->db->prepare($uSql);
            $u->execute([
                ':email' => $userData['email'],
                ':password' => password_hash($userData['password'], PASSWORD_DEFAULT),
                ':nombre' => $userData['nombre'],
                ':ap' => $userData['apellido_paterno'],
                ':am' => $userData['apellido_materno'] ?? null,
                ':tel' => $userData['telefono'] ?? null,
                ':fn' => $userData['fecha_nacimiento'] ?? null,
                ':status' => $userData['status'] ?? 'active',
            ]);
            $userId = (int)$this->db->lastInsertId();

            // capturista_profiles
            $pSql = "INSERT INTO capturista_profiles (user_id, numero_empleado, curp, fecha_ingreso, status)
                     VALUES (:uid, :num, :curp, :fi, :status)";
            $p = $this->db->prepare($pSql);
            $p->execute([
                ':uid' => $userId,
                ':num' => $profileData['numero_empleado'],
                ':curp' => $profileData['curp'] ?? null,
                ':fi' => $profileData['fecha_ingreso'] ?? null,
                ':status' => $profileData['status'] ?? ($userData['status'] ?? 'active'),
            ]);

            $this->db->commit();
            return (int)$this->db->lastInsertId(); // id del perfil
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Actualiza user + profile en transacción
     */
    public function update(int $capturistaId, array $userData, array $profileData): bool
    {
        $this->db->beginTransaction();
        try {
            $row = $this->find($capturistaId);
            if (!$row) return false;
            $userId = (int)$row['user_id'];

            // users (password opcional)
            $fields = [
                'email' => ':email',
                'nombre' => ':nombre',
                'apellido_paterno' => ':ap',
                'apellido_materno' => ':am',
                'telefono' => ':tel',
                'fecha_nacimiento' => ':fn',
                'status' => ':status',
            ];
            $set = [];
            foreach ($fields as $col => $ph) { $set[] = "$col = $ph"; }
            $uSql = 'UPDATE users SET ' . implode(', ', $set) . ' WHERE id = :id';
            $params = [
                ':email' => $userData['email'],
                ':nombre' => $userData['nombre'],
                ':ap' => $userData['apellido_paterno'],
                ':am' => $userData['apellido_materno'] ?? null,
                ':tel' => $userData['telefono'] ?? null,
                ':fn' => $userData['fecha_nacimiento'] ?? null,
                ':status' => $userData['status'] ?? 'active',
                ':id' => $userId,
            ];

            if (!empty($userData['password'])) {
                $uSql = str_replace(' WHERE', ', password = :password WHERE', $uSql);
                $params[':password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
            }
            $u = $this->db->prepare($uSql);
            $u->execute($params);

            // profile
            $pSql = "UPDATE capturista_profiles
                     SET numero_empleado = :num, curp = :curp, fecha_ingreso = :fi, status = :status
                     WHERE id = :id";
            $p = $this->db->prepare($pSql);
            $p->execute([
                ':num' => $profileData['numero_empleado'],
                ':curp' => $profileData['curp'] ?? null,
                ':fi' => $profileData['fecha_ingreso'] ?? null,
                ':status' => $profileData['status'] ?? ($userData['status'] ?? 'active'),
                ':id' => $capturistaId,
            ]);

            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Borrado lógico (opcional) o físico. Aquí hago lógico en ambas tablas.
     */
    public function softDelete(int $capturistaId): bool
    {
        $row = $this->find($capturistaId);
        if (!$row) return false;
        $this->db->beginTransaction();
        try {
            $u = $this->db->prepare("UPDATE users SET status = 'inactive' WHERE id = :id");
            $u->execute([':id' => $row['user_id']]);
            $p = $this->db->prepare("UPDATE capturista_profiles SET status = 'inactive' WHERE id = :id");
            $p->execute([':id' => $capturistaId]);
            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /** Borrado físico (si realmente lo necesitan) */
    public function hardDelete(int $capturistaId): bool
    {
        $row = $this->find($capturistaId);
        if (!$row) return false;
        $this->db->beginTransaction();
        try {
            // Por FK ON DELETE CASCADE, borrar el user elimina el profile o viceversa según el lado.
            $d = $this->db->prepare('DELETE FROM users WHERE id = :id');
            $d->execute([':id' => $row['user_id']]);
            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /** Validaciones a nivel modelo (mínimas) */
    public function validate(array $userData, array $profileData): array
    {
        $errors = [];
        if (empty($userData['email']) || !filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Correo inválido.';
        }
        if (empty($userData['nombre'])) $errors['nombre'] = 'Nombre requerido.';
        if (empty($userData['apellido_paterno'])) $errors['apellido_paterno'] = 'Apellido paterno requerido.';
        if (empty($profileData['numero_empleado'])) $errors['numero_empleado'] = 'Número de empleado requerido.';
        if (!empty($profileData['curp']) && !preg_match('/^[A-Z]{4}[0-9]{6}[A-Z]{6}[0-9A-Z]{2}$/i', $profileData['curp'])) {
            $errors['curp'] = 'CURP con formato inválido.';
        }
        return $errors;
    }
}
