<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User {
    private $db;

    // Campos habituales en users (ajusta si tu tabla tiene más/menos)
    public $id;
    public $name;
    public $email;
    public $password;
    public $status;
    public $created_at;

    public function __construct() {
        $this->db = new Database();
    }

    /* =========================================================
     * Contadores y métricas
     * ======================================================= */
    public function count() {
        $this->db->query("SELECT COUNT(*) FROM users");
        return (int)$this->db->fetchColumn();
    }

    /**
     * Conteo por rol usando perfiles del esquema nuevo.
     * Acepta 'alumno'|'student' o 'teacher'|'maestro'.
     */
    public function countByRole($role) {
        $role = strtolower($role);
        if (in_array($role, ['alumno','student'], true)) {
            $this->db->query("SELECT COUNT(*) FROM student_profiles");
            return (int)$this->db->fetchColumn();
        }
        if (in_array($role, ['teacher','maestro'], true)) {
            $this->db->query("SELECT COUNT(*) FROM teacher_profiles");
            return (int)$this->db->fetchColumn();
        }
        // Otros roles (admin, capturista) dependen de tu diseño.
        return 0;
    }

    public function getMonthlyRegistrations() {
        $query = "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count
                  FROM users
                  GROUP BY month
                  ORDER BY month DESC
                  LIMIT 12";
        $this->db->query($query);
        return $this->db->fetchAll();
    }

    /**
     * Distribución de roles inferida por perfiles.
     * Devuelve objetos {role, count}
     */
    public function getRoleDistribution() {
        $out = [];

        // alumnos
        $this->db->query("SELECT COUNT(*) FROM student_profiles");
        $alumnos = (int)$this->db->fetchColumn();
        $out[] = (object)['role' => 'alumno', 'count' => $alumnos];

        // maestros
        $this->db->query("SELECT COUNT(*) FROM teacher_profiles");
        $maestros = (int)$this->db->fetchColumn();
        $out[] = (object)['role' => 'teacher', 'count' => $maestros];

        // si tienes algún flag/tabla para admin, puedes añadirlo aquí

        return $out;
    }

    /* =========================================================
     * Búsquedas básicas
     * ======================================================= */
    public function findById($id) {
    $this->db->query("SELECT id, nombre AS name, email, password, status, created_at FROM users WHERE id = ?", [$id]);
    $user = $this->db->fetch();
    error_log("User::findById - Query result for id '$id': " . ($user ? 'Found' : 'Not found'));
    return $user;
}

public function findByEmail($email): mixed {
    $this->db->query("SELECT id, nombre AS name, email, password, status, created_at FROM users WHERE email = ?", [$email]);
    $result = $this->db->fetch();
    error_log("User::findByEmail - Query result for email '$email': " . ($result ? 'Found' : 'Not found'));
    return $result;
}

    public function validateCredentials($email, $password) {
        $user = $this->findByEmail($email);
        if (!$user) return false;
        return password_verify($password, $user->password);
    }

    public function getDb() { return $this->db; }

    /* =========================================================
     * “Roles” inferidos por perfiles
     * ======================================================= */
    public function getUserRoles($userId) {
        $roles = [];

        // ¿es estudiante?
        $this->db->query("SELECT 1 FROM student_profiles WHERE user_id = ? LIMIT 1", [$userId]);
        if ($this->db->fetchColumn()) $roles[] = 'student';

        // ¿es maestro?
        $this->db->query("SELECT 1 FROM teacher_profiles WHERE user_id = ? LIMIT 1", [$userId]);
        if ($this->db->fetchColumn()) $roles[] = 'teacher';

        // Hook para admin: si tienes un campo en users (ej. is_admin TINYINT)
        // $this->db->query("SELECT is_admin FROM users WHERE id = ?", [$userId]);
        // if ((int)$this->db->fetchColumn() === 1) $roles[] = 'admin';

        // Si en tu login asignas 'admin' manualmente, esto no lo rompe.
        if (empty($roles)) {
            error_log("User::getUserRoles - No profile-based role for user ID: ".$userId);
        }
        return $roles;
    }

    /* =========================================================
     * Listas recientes
     * ======================================================= */
    public function getRecentUsers($limit = 5) {
    $limit = (int)$limit;
    $query = "SELECT u.id, u.nombre AS name, u.email, u.created_at
              FROM users u
              ORDER BY u.created_at DESC
              LIMIT {$limit}";
    $this->db->query($query);
    return $this->db->fetchAll();
}

public function getRecentByRole($role, $limit = 5) {
    $limit = (int)$limit;
    $role = strtolower($role);

    if (in_array($role, ['alumno','student'], true)) {
        $sql = "SELECT u.id, u.nombre AS name, u.email, u.created_at
                FROM users u
                INNER JOIN student_profiles sp ON sp.user_id = u.id
                ORDER BY u.created_at DESC
                LIMIT {$limit}";
        $this->db->query($sql);
        return $this->db->fetchAll();
    }

    if (in_array($role, ['teacher','maestro'], true)) {
    $sql = "SELECT u.id, u.nombre AS name, u.email, u.created_at,
                   tp.numero_empleado,
                   tp.especialidad AS specialty,
                   tp.departamento_id
            FROM users u
            INNER JOIN teacher_profiles tp ON tp.user_id = u.id
            ORDER BY u.created_at DESC
            LIMIT {$limit}";
    $this->db->query($sql);
    return $this->db->fetchAll();
}


    return [];
}

public function getByRole($role) {
    $role = strtolower($role);
    if (in_array($role, ['alumno','student'], true)) {
        $sql = "SELECT u.id, u.nombre AS name, u.email, u.created_at
                FROM users u
                INNER JOIN student_profiles sp ON sp.user_id = u.id";
        $this->db->query($sql);
        return $this->db->fetchAll();
    }
    if (in_array($role, ['teacher','maestro'], true)) {
        $sql = "SELECT u.id, u.nombre AS name, u.email, u.created_at
                FROM users u
                INNER JOIN teacher_profiles tp ON tp.user_id = u.id";
        $this->db->query($sql);
        return $this->db->fetchAll();
    }
    return [];
}


    /* =========================================================
     * CRUD users + creación de perfil según rol
     * ======================================================= */
    public function create($data) {
        // Inserta en users
        $query = "INSERT INTO users (name, email, password, status, created_at)
                  VALUES (?, ?, ?, 'active', NOW())";
        $this->db->query($query, [
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
        ]);
        $ok = $this->db->rowCount() > 0;
        if (!$ok) return false;

        // ID recién insertado
        $this->db->query("SELECT LAST_INSERT_ID()");
        $userId = (int)$this->db->fetchColumn();

        // Crear perfil según rol (si viene)
        $role = strtolower($data['role'] ?? '');
        if (in_array($role, ['alumno','student'], true)) {
            // columnas típicas de student_profiles (ajusta si tu esquema difiere)
            $sql = "INSERT INTO student_profiles (user_id, matricula, carrera, semestre, status, created_at)
                    VALUES (:uid, :mat, :car, :sem, :st, NOW())";
            $this->db->query($sql, [
                ':uid' => $userId,
                ':mat' => $data['matricula'] ?? null,
                ':car' => $data['carrera']   ?? null,
                ':sem' => $data['semestre']  ?? null,
                ':st'  => $data['status']    ?? 'activo',
            ]);
        } elseif (in_array($role, ['teacher','maestro'], true)) {
            // columnas típicas de teacher_profiles (ajusta si difiere)
            $sql = "INSERT INTO teacher_profiles (user_id, num_empleado, department, specialty, phone, status, created_at)
                    VALUES (:uid, :num, :dep, :spe, :pho, :st, NOW())";
            $this->db->query($sql, [
                ':uid' => $userId,
                ':num' => $data['num_empleado'] ?? null,
                ':dep' => $data['department']   ?? ($data['departamento'] ?? null),
                ':spe' => $data['specialty']    ?? null,
                ':pho' => $data['phone']        ?? null,
                ':st'  => $data['status']       ?? 'activo',
            ]);
        }

        return true;
    }

    public function update($id, $data) {
        // Actualiza users.*; si necesitas actualizar perfil, hazlo aparte (o añade lógica condicional)
        $fields = [];
        $values = [];

        foreach ($data as $key => $value) {
            if ($key === 'password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }
            // ignora campos propios del perfil
            if (in_array($key, ['matricula','carrera','semestre','grupo','num_empleado','department','departamento','specialty','phone'], true)) {
                continue;
            }
            $fields[] = "$key = ?";
            $values[] = $value;
        }

        if ($fields) {
            $values[] = $id;
            $query = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
            $this->db->query($query, $values);
        }
        return true;
    }

    public function delete($id) {
        // Borra perfiles asociados y luego el usuario (mantén FK ON DELETE CASCADE si lo tienes)
        $this->db->query("DELETE FROM student_profiles WHERE user_id = ?", [$id]);
        $this->db->query("DELETE FROM teacher_profiles WHERE user_id = ?", [$id]);
        $this->db->query("DELETE FROM users WHERE id = ?", [$id]);
        return $this->db->rowCount() > 0;
    }

    /* =========================================================
     * Reportes / paneles (pendientes, etc.)
     * Ajusta nombres si tu esquema usa otros
     * ======================================================= */
    public function countPendingRegistrations() {
        // Si manejas pendientes en otra tabla/campo, cámbialo aquí
        $this->db->query("SELECT COUNT(*) FROM users WHERE status = 'inactive'");
        return (int)$this->db->fetchColumn();
    }

    public function countPendingSolicitudes() {
        // Ajusta a tu tabla de solicitudes real
        $this->db->query("SELECT COUNT(*) FROM solicitudes WHERE estado = 'pendiente'");
        return (int)$this->db->fetchColumn();
    }

    public function countIncompleteDocuments() {
        // Ajusta a tu tabla/campo real
        $this->db->query("SELECT COUNT(*) FROM solicitudes WHERE documentos_completos = FALSE");
        return (int)$this->db->fetchColumn();
    }

    /* =========================================================
     * Listas de ALUMNOS con filtro/paginación (student_profiles)
     * ======================================================= */
    public function getStudentsWithFilters($filters = []) {
    $where  = [];
    $params = [];

    if (!empty($filters['search'])) {
        $where[] = "(u.nombre LIKE :search OR u.email LIKE :search OR sp.matricula LIKE :search)";
        $params[':search'] = '%'.$filters['search'].'%';
    }
    if (!empty($filters['semestre'])) {
        $where[] = "sp.semestre = :semestre";
        $params[':semestre'] = (int)$filters['semestre'];
    }
    // Acepta id numérico o nombre (si existe tabla carreras)
    if (!empty($filters['carrera'])) {
        if (ctype_digit((string)$filters['carrera'])) {
            $where[] = "sp.carrera_id = :carrera_id";
            $params[':carrera_id'] = (int)$filters['carrera'];
        } else {
            $where[] = "c.nombre = :carrera_nombre";
            $params[':carrera_nombre'] = $filters['carrera'];
        }
    }
    if (!empty($filters['estado'])) {
        // student_profiles no tiene status; uso users.status si lo ocupas
        $where[] = "u.status = :estado";
        $params[':estado'] = $filters['estado'];
    }

    $limit  = (int)($filters['limit']  ?? 10);
    $offset = (int)($filters['offset'] ?? 0);

    $sql = "SELECT 
                u.id, u.nombre AS name, u.email, u.created_at,
                sp.matricula, sp.curp, sp.carrera_id, sp.semestre, sp.grupo,
                sp.tipo_ingreso, sp.beca_activa, sp.promedio_general, sp.creditos_aprobados
                -- si hay tabla carreras, devuelvo el nombre:
                , c.nombre AS carrera
            FROM users u
            INNER JOIN student_profiles sp ON sp.user_id = u.id
            LEFT JOIN carreras c ON c.id = sp.carrera_id";

    if ($where) $sql .= " WHERE ".implode(" AND ", $where);
    $sql .= " ORDER BY u.nombre ASC LIMIT {$limit} OFFSET {$offset}";

    $this->db->query($sql, $params);
    return $this->db->fetchAll();
}



    public function countStudentsWithFilters($filters = []) {
    $where  = [];
    $params = [];

    if (!empty($filters['search'])) {
        $where[] = "(u.nombre LIKE :search OR u.email LIKE :search OR sp.matricula LIKE :search)";
        $params[':search'] = '%'.$filters['search'].'%';
    }
    if (!empty($filters['semestre'])) {
        $where[] = "sp.semestre = :semestre";
        $params[':semestre'] = (int)$filters['semestre'];
    }
    if (!empty($filters['carrera'])) {
        if (ctype_digit((string)$filters['carrera'])) {
            $where[] = "sp.carrera_id = :carrera_id";
            $params[':carrera_id'] = (int)$filters['carrera'];
        } else {
            $where[] = "c.nombre = :carrera_nombre";
            $params[':carrera_nombre'] = $filters['carrera'];
        }
    }
    if (!empty($filters['estado'])) {
        $where[] = "u.status = :estado";
        $params[':estado'] = $filters['estado'];
    }

    $sql = "SELECT COUNT(*)
            FROM users u
            INNER JOIN student_profiles sp ON sp.user_id = u.id
            LEFT JOIN carreras c ON c.id = sp.carrera_id";
    if ($where) $sql .= " WHERE ".implode(" AND ", $where);

    $this->db->query($sql, $params);
    return (int)$this->db->fetchColumn();
}


public function getDistinctCarreras(): array {
    // Si tienes tabla carreras:
    $this->db->query("SELECT nombre FROM carreras ORDER BY nombre");
    return $this->db->fetchAll(PDO::FETCH_COLUMN, 0);

    // Si NO tienes tabla carreras, usa los IDs:
    // $this->db->query("SELECT DISTINCT carrera_id FROM student_profiles WHERE carrera_id IS NOT NULL ORDER BY carrera_id");
    // return $this->db->fetchAll(PDO::FETCH_COLUMN, 0);
}

public function getDistinctSemestres(): array {
    $this->db->query("SELECT DISTINCT semestre FROM student_profiles WHERE semestre IS NOT NULL ORDER BY semestre");
    return $this->db->fetchAll(PDO::FETCH_COLUMN, 0);
}


    /* =========================================================
     * Listas de PROFESORES con filtro/paginación (teacher_profiles)
     * ======================================================= */
    public function getTeachersWithFilters($filters = []) {
    $where  = [];
    $params = [];

    if (!empty($filters['search'])) {
        $where[] = "(u.nombre LIKE :search OR u.email LIKE :search OR tp.numero_empleado LIKE :search)";
        $params[':search'] = '%' . $filters['search'] . '%';
    }

    // Departamento: acepta id numérico (tp.departamento_id) o nombre (d.nombre)
    if (!empty($filters['departamento'])) {
        if (ctype_digit((string)$filters['departamento'])) {
            $where[] = "tp.departamento_id = :depto_id";
            $params[':depto_id'] = (int)$filters['departamento'];
        } else {
            $where[] = "d.nombre = :depto_nombre";
            $params[':depto_nombre'] = $filters['departamento'];
        }
    }

    // Estado: usa users.status (teacher_profiles no tiene status)
    if (!empty($filters['estado'])) {
        $where[] = "u.status = :estado";
        $params[':estado'] = $filters['estado'];
    }

    $limit  = (int)($filters['limit']  ?? 10);
    $offset = (int)($filters['offset'] ?? 0);

    $sql = "SELECT
                u.id,
                u.nombre AS name,
                u.email,
                u.status,
                u.created_at,
                tp.numero_empleado,
                tp.especialidad AS specialty,
                tp.grado_academico,
                tp.nivel_sni,
                tp.perfil_prodep,
                tp.fecha_contratacion,
                tp.tipo_contrato,
                tp.departamento_id,
                d.nombre AS department
            FROM users u
            INNER JOIN teacher_profiles tp ON tp.user_id = u.id
            LEFT JOIN departamentos d      ON d.id = tp.departamento_id";

    if ($where) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    $sql .= " ORDER BY u.nombre ASC
              LIMIT {$limit} OFFSET {$offset}";

    $this->db->query($sql, $params);
    return $this->db->fetchAll();
}


    public function countTeachersWithFilters($filters = []) {
    $where  = [];
    $params = [];

    if (!empty($filters['search'])) {
        $where[] = "(u.nombre LIKE :search OR u.email LIKE :search OR tp.numero_empleado LIKE :search)";
        $params[':search'] = '%' . $filters['search'] . '%';
    }

    if (!empty($filters['departamento'])) {
        if (ctype_digit((string)$filters['departamento'])) {
            $where[] = "tp.departamento_id = :depto_id";
            $params[':depto_id'] = (int)$filters['departamento'];
        } else {
            $where[] = "d.nombre = :depto_nombre";
            $params[':depto_nombre'] = $filters['departamento'];
        }
    }

    if (!empty($filters['estado'])) {
        $where[] = "u.status = :estado";
        $params[':estado'] = $filters['estado'];
    }

    $sql = "SELECT COUNT(*)
            FROM users u
            INNER JOIN teacher_profiles tp ON tp.user_id = u.id
            LEFT JOIN departamentos d      ON d.id = tp.departamento_id";

    if ($where) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    $this->db->query($sql, $params);
    return (int)$this->db->fetchColumn();
}



    public function getDistinctDepartamentos() {
    $this->db->query("SELECT nombre FROM departamentos ORDER BY nombre");
    return $this->db->fetchAll(PDO::FETCH_COLUMN, 0);
}


    /* =========================================================
     * Relación alumnos ↔︎ maestro (placeholder)
     * ======================================================= */
    public function getStudentsByTeacher($teacherId) {
        // Implementa según tu modelo de cursos/grupos/inscripciones
        // Por ahora, devolvemos vacío para no romper controladores viejos.
        return [];
    }
}
