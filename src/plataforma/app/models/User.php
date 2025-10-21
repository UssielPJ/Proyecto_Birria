<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class User {
    private $db;

    // Campos reales en users
    public $id;
    public $nombre;
    public $apellido_paterno;
    public $apellido_materno;
    public $email;
    public $password;
    public $telefono;
    public $fecha_nacimiento;
    public $status;
    public $created_at;

    // Nombres de tablas (ajusta aquí si en tu DB difieren)
    private const T_USERS   = 'users';
    private const T_STUDS   = 'student_profiles';  // si existe
    private const T_TEACH   = 'teacher_profiles';  // si existe
    private const T_CARRERA = 'carreras';          // si existe

    public function __construct() {
        $this->db = new Database();
    }

    /* ===================== Métricas ===================== */
    public function count(): int {
        $this->db->query("SELECT COUNT(*) FROM ".self::T_USERS);
        return (int)$this->db->fetchColumn();
    }

    public function countByRole(string $role): int {
        $role = strtolower($role);
        if (in_array($role, ['alumno','student'], true)) {
            $this->db->query("SELECT COUNT(*) FROM ".self::T_STUDS);
            return (int)$this->db->fetchColumn();
        }
        if (in_array($role, ['teacher','maestro'], true)) {
            $this->db->query("SELECT COUNT(*) FROM ".self::T_TEACH);
            return (int)$this->db->fetchColumn();
        }
        return 0;
    }

    public function getMonthlyRegistrations(): array {
        $q = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS count
              FROM ".self::T_USERS."
              GROUP BY month
              ORDER BY month DESC
              LIMIT 12";
        $this->db->query($q);
        return $this->db->fetchAll();
    }

    public function getRoleDistribution(): array {
        $out = [];
        $this->db->query("SELECT COUNT(*) FROM ".self::T_STUDS);
        $out[] = (object)['role' => 'alumno', 'count' => (int)$this->db->fetchColumn()];
        $this->db->query("SELECT COUNT(*) FROM ".self::T_TEACH);
        $out[] = (object)['role' => 'teacher', 'count' => (int)$this->db->fetchColumn()];
        return $out;
    }

    /* ===================== Búsquedas básicas ===================== */
    public function findById(int $id): mixed {
        $this->db->query("
            SELECT id, nombre, apellido_paterno, apellido_materno,
                   email, password, telefono, fecha_nacimiento, status, created_at
            FROM ".self::T_USERS."
            WHERE id = ?
            LIMIT 1
        ", [$id]);
        return $this->db->fetch();
    }

    public function findByEmail(string $email): mixed {
        $this->db->query("
            SELECT id, nombre, apellido_paterno, apellido_materno,
                   email, password, telefono, fecha_nacimiento, status, created_at
            FROM ".self::T_USERS."
            WHERE email = ?
            LIMIT 1
        ", [mb_strtolower(trim($email))]);
        return $this->db->fetch();
    }

    public function validateCredentials(string $email, string $password): bool {
        $u = $this->findByEmail($email);
        return $u ? password_verify($password, $u->password) : false;
    }

    public function getDb() { return $this->db; }

    /* ===================== Roles inferidos por perfiles ===================== */
    public function getUserRoles(int $userId): array {
        $roles = [];
        $this->db->query("SELECT 1 FROM ".self::T_STUDS." WHERE user_id = ? LIMIT 1", [$userId]);
        if ($this->db->fetchColumn()) $roles[] = 'student';

        $this->db->query("SELECT 1 FROM ".self::T_TEACH." WHERE user_id = ? LIMIT 1", [$userId]);
        if ($this->db->fetchColumn()) $roles[] = 'teacher';

        return $roles;
    }

    /* ===================== Listas recientes ===================== */
    public function getRecentUsers(int $limit = 5): array {
        $limit = (int)$limit;
        $q = "SELECT id, nombre, email, created_at
              FROM ".self::T_USERS."
              ORDER BY created_at DESC
              LIMIT {$limit}";
        $this->db->query($q);
        return $this->db->fetchAll();
    }

    public function getRecentByRole(string $role, int $limit = 5): array {
        $limit = (int)$limit;
        $role = strtolower($role);

        if (in_array($role, ['alumno','student'], true)) {
            $sql = "SELECT u.id, u.nombre, u.email, u.created_at
                    FROM ".self::T_USERS." u
                    INNER JOIN ".self::T_STUDS." sp ON sp.user_id = u.id
                    ORDER BY u.created_at DESC
                    LIMIT {$limit}";
            $this->db->query($sql);
            return $this->db->fetchAll();
        }

        if (in_array($role, ['teacher','maestro'], true)) {
            $sql = "SELECT u.id, u.nombre, u.email, u.created_at
                    FROM ".self::T_USERS." u
                    INNER JOIN ".self::T_TEACH." tp ON tp.user_id = u.id
                    ORDER BY u.created_at DESC
                    LIMIT {$limit}";
            $this->db->query($sql);
            return $this->db->fetchAll();
        }

        return [];
    }

    public function getByRole(string $role): array {
        $role = strtolower($role);
        if (in_array($role, ['alumno','student'], true)) {
            $sql = "SELECT u.id, u.nombre, u.email, u.created_at
                    FROM ".self::T_USERS." u
                    INNER JOIN ".self::T_STUDS." sp ON sp.user_id = u.id";
            $this->db->query($sql);
            return $this->db->fetchAll();
        }
        if (in_array($role, ['teacher','maestro'], true)) {
            $sql = "SELECT u.id, u.nombre, u.email, u.created_at
                    FROM ".self::T_USERS." u
                    INNER JOIN ".self::T_TEACH." tp ON tp.user_id = u.id";
            $this->db->query($sql);
            return $this->db->fetchAll();
        }
        return [];
    }

    /* ===================== CRUD users ===================== */

    /**
     * Crea usuario en `users`. Devuelve el ID insertado.
     * Acepta password en texto plano o ya hasheado.
     */
    public function create(array $data): int {
        // Normaliza / mapea
        $nombre           = $data['nombre'] ?? ($data['name'] ?? null);
        $ap               = $data['apellido_paterno'] ?? null;
        $am               = $data['apellido_materno'] ?? null;
        $email            = mb_strtolower(trim($data['email']));
        $telefono         = $data['telefono'] ?? ($data['phone'] ?? null);
        $fecha_nacimiento = $data['fecha_nacimiento'] ?? ($data['birthdate'] ?? null);
        $status           = $data['status'] ?? 'active';

        // Password: si ya viene en formato bcrypt ($2y$...) respétalo; si no, hashea.
        $pwdInput = $data['password'];
        $password = $this->looksLikeBcrypt($pwdInput)
            ? $pwdInput
            : password_hash($pwdInput, PASSWORD_DEFAULT);

        $sql = "INSERT INTO ".self::T_USERS."
                (nombre, apellido_paterno, apellido_materno, email, password,
                 telefono, fecha_nacimiento, status, created_at, updated_at)
                VALUES
                (:nombre, :ap, :am, :email, :password,
                 :tel, :fnac, :status, NOW(), NOW())";

        $this->db->query($sql, [
            ':nombre'  => $nombre,
            ':ap'      => $ap,
            ':am'      => $am,
            ':email'   => $email,
            ':password'=> $password,
            ':tel'     => $telefono,
            ':fnac'    => $fecha_nacimiento,
            ':status'  => $status,
        ]);

        // lastInsertId — usa método del wrapper si existe; si no, fallback
        $id = null;
        if (method_exists($this->db, 'lastInsertId')) {
            $id = (int)$this->db->lastInsertId();
        } else {
            $this->db->query("SELECT LAST_INSERT_ID()");
            $id = (int)$this->db->fetchColumn();
        }
        return $id;
    }

    /**
     * Actualiza SOLO columnas de `users`.
     */
    public function update(int $id, array $data): bool {
        $map = [
            'nombre'           => $data['nombre']            ?? ($data['name'] ?? null),
            'apellido_paterno' => $data['apellido_paterno']  ?? null,
            'apellido_materno' => $data['apellido_materno']  ?? null,
            'email'            => isset($data['email']) ? mb_strtolower(trim($data['email'])) : null,
            'telefono'         => $data['telefono']          ?? ($data['phone'] ?? null),
            'fecha_nacimiento' => $data['fecha_nacimiento']  ?? ($data['birthdate'] ?? null),
            'status'           => $data['status']            ?? null,
        ];
        $set = [];
        $params = [];
        foreach ($map as $col => $val) {
            if ($val !== null) {
                $set[] = "$col = :$col";
                $params[":$col"] = $val;
            }
        }
        if (!empty($data['password'])) {
            $set[] = "password = :password";
            $params[':password'] = $this->looksLikeBcrypt($data['password'])
                ? $data['password']
                : password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (!$set) return true;

        $sql = "UPDATE ".self::T_USERS." SET ".implode(', ', $set).", updated_at = NOW() WHERE id = :id";
        $params[':id'] = $id;
        $this->db->query($sql, $params);
        return true;
    }

    /**
     * Hard delete (si tienes FK ON DELETE CASCADE, no necesitas borrar perfiles a mano).
     * Si NO tienes cascada, descomenta deletes de perfiles.
     */
    public function delete(int $id): bool {
        // $this->db->query("DELETE FROM ".self::T_STUDS." WHERE user_id = ?", [$id]);
        // $this->db->query("DELETE FROM ".self::T_TEACH." WHERE user_id = ?", [$id]);
        $this->db->query("DELETE FROM ".self::T_USERS." WHERE id = ?", [$id]);
        return $this->db->rowCount() > 0;
    }

    /* ===================== Listas de ALUMNOS ===================== */
    public function getStudentsWithFilters(array $filters = []): array {
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

        $limit  = (int)($filters['limit']  ?? 10);
        $offset = (int)($filters['offset'] ?? 0);

        $sql = "SELECT 
                    u.id,
                    u.nombre,
                    u.apellido_paterno,
                    u.apellido_materno,
                    u.email,
                    u.telefono,
                    u.fecha_nacimiento,
                    u.status,
                    u.created_at,
                    sp.matricula,
                    sp.curp,
                    sp.carrera_id,
                    sp.semestre,
                    sp.grupo,
                    sp.tipo_ingreso,
                    sp.beca_activa,
                    sp.promedio_general,
                    sp.creditos_aprobados,
                    ".self::T_CARRERA.".nombre AS carrera
                FROM ".self::T_USERS." u
                INNER JOIN ".self::T_STUDS." sp ON sp.user_id = u.id
                LEFT JOIN ".self::T_CARRERA." ON ".self::T_CARRERA.".id = sp.carrera_id";

        if ($where) $sql .= " WHERE ".implode(" AND ", $where);
        $sql .= " ORDER BY u.nombre ASC LIMIT {$limit} OFFSET {$offset}";

        $this->db->query($sql, $params);
        return $this->db->fetchAll();
    }

    public function countStudentsWithFilters(array $filters = []): int {
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
                FROM ".self::T_USERS." u
                INNER JOIN ".self::T_STUDS." sp ON sp.user_id = u.id
                LEFT JOIN ".self::T_CARRERA." c ON c.id = sp.carrera_id";
        if ($where) $sql .= " WHERE ".implode(" AND ", $where);

        $this->db->query($sql, $params);
        return (int)$this->db->fetchColumn();
    }

    public function getDistinctCarreras(): array {
        $this->db->query("SELECT nombre FROM ".self::T_CARRERA." ORDER BY nombre");
        return $this->db->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getDistinctSemestres(): array {
        $this->db->query("SELECT DISTINCT semestre FROM ".self::T_STUDS." WHERE semestre IS NOT NULL ORDER BY semestre");
        return $this->db->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    /* ===================== Profesores (si aplica) ===================== */
    public function getTeachersWithFilters(array $filters = []): array {
        $where  = [];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "(u.nombre LIKE :search OR u.email LIKE :search OR tp.numero_empleado LIKE :search)";
            $params[':search'] = '%'.$filters['search'].'%';
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

        $limit  = (int)($filters['limit']  ?? 10);
        $offset = (int)($filters['offset'] ?? 0);

        $sql = "SELECT
                    u.id, u.nombre, u.email, u.status, u.created_at,
                    tp.numero_empleado, tp.especialidad, tp.grado_academico, tp.nivel_sni,
                    tp.perfil_prodep, tp.fecha_contratacion, tp.tipo_contrato,
                    tp.departamento_id, d.nombre AS departamento
                FROM ".self::T_USERS." u
                INNER JOIN ".self::T_TEACH." tp ON tp.user_id = u.id
                LEFT JOIN departamentos d ON d.id = tp.departamento_id";

        if ($where) $sql .= " WHERE ".implode(" AND ", $where);
        $sql .= " ORDER BY u.nombre ASC LIMIT {$limit} OFFSET {$offset}";

        $this->db->query($sql, $params);
        return $this->db->fetchAll();
    }

    public function countTeachersWithFilters(array $filters = []): int {
        $where  = [];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "(u.nombre LIKE :search OR u.email LIKE :search OR tp.numero_empleado LIKE :search)";
            $params[':search'] = '%'.$filters['search'].'%';
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
                FROM ".self::T_USERS." u
                INNER JOIN ".self::T_TEACH." tp ON tp.user_id = u.id
                LEFT JOIN departamentos d ON d.id = tp.departamento_id";
        if ($where) $sql .= " WHERE ".implode(" AND ", $where);

        $this->db->query($sql, $params);
        return (int)$this->db->fetchColumn();
    }

    public function getDistinctDepartamentos(): array {
        $this->db->query("SELECT nombre FROM departamentos ORDER BY nombre");
        return $this->db->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    /* ===================== Hook curso-maestro (placeholder) ===================== */
    public function getStudentsByTeacher(int $teacherId): array {
        return []; // Implementar según tus tablas de cursos/inscripciones
    }

    /* ===================== Profesores: helpers ===================== */

    /** Trae un profesor por ID con JOIN a teacher_profiles y departamentos */
    public function findTeacherById(int $id): mixed {
        $sql = "SELECT 
                    u.id, u.nombre, u.email, u.status, u.created_at,
                    tp.numero_empleado, tp.rfc, tp.especialidad, tp.departamento_id,
                    tp.grado_academico, tp.fecha_contratacion, tp.tipo_contrato,
                    tp.nivel_sni, tp.perfil_prodep,
                    d.nombre AS departamento
                FROM ".self::T_USERS." u
                LEFT JOIN ".self::T_TEACH." tp ON tp.user_id = u.id
                LEFT JOIN departamentos d ON d.id = tp.departamento_id
                WHERE u.id = :id
                LIMIT 1";
        $this->db->query($sql, [':id' => $id]);
        return $this->db->fetch();
    }

    /** Inserta/actualiza el perfil de profesor (UPsert sencillo) */
    public function upsertTeacherProfile(int $userId, array $data): bool {
        $params = [
            ':uid'  => $userId,
            ':num'  => $data['numero_empleado']     ?? ($data['num_empleado'] ?? null),
            ':rfc'  => !empty(trim($data['rfc'] ?? '')) ? trim($data['rfc']) : null,
            ':dep'  => isset($data['departamento_id']) ? (int)$data['departamento_id'] : null,
            ':grado'=> $data['grado_academico']     ?? null,
            ':esp'  => $data['especialidad']        ?? null,
            ':fcon' => $data['fecha_contratacion']  ?? ($data['fecha_ingreso'] ?? null),
            ':tcon' => $data['tipo_contrato']       ?? null,
            ':sni'  => $data['nivel_sni']           ?? 'sin_nivel',
            ':pro'  => isset($data['perfil_prodep']) ? 1 : 0,
        ];

        $this->db->query("SELECT COUNT(*) FROM ".self::T_TEACH." WHERE user_id = :uid", [':uid' => $userId]);
        $exists = (int)$this->db->fetchColumn() > 0;

        if ($exists) {
            $sql = "UPDATE ".self::T_TEACH." SET
                        numero_empleado = :num,
                        rfc = :rfc,
                        departamento_id = :dep,
                        grado_academico = :grado,
                        especialidad = :esp,
                        fecha_contratacion = :fcon,
                        tipo_contrato = :tcon,
                        nivel_sni = :sni,
                        perfil_prodep = :pro,
                        updated_at = NOW()
                    WHERE user_id = :uid";
        } else {
            $sql = "INSERT INTO ".self::T_TEACH."
                        (user_id, numero_empleado, rfc, departamento_id, grado_academico, especialidad,
                         fecha_contratacion, tipo_contrato, nivel_sni, perfil_prodep, created_at)
                    VALUES
                        (:uid, :num, :rfc, :dep, :grado, :esp, :fcon, :tcon, :sni, :pro, NOW())";
        }

        $this->db->query($sql, $params);
        return true;
    }

    /** Baja lógica del usuario (recomendada para no romper FK) */
    public function softDeleteUser(int $userId): bool {
        $this->db->query(
            "UPDATE ".self::T_USERS." SET status = 'inactive', updated_at = NOW() WHERE id = ?",
            [$userId]
        );
        return $this->db->rowCount() > 0;
    }

    /** Eliminación física del usuario + perfil de profesor (si no hay ON DELETE CASCADE) */
    public function deleteTeacherHard(int $userId): bool {
        // Si tu FK no tiene ON DELETE CASCADE, borra perfil primero:
        $this->db->query("DELETE FROM ".self::T_TEACH." WHERE user_id = ?", [$userId]);
        $this->db->query("DELETE FROM ".self::T_USERS." WHERE id = ?", [$userId]);
        return $this->db->rowCount() > 0;
    }

    /* ===================== Utils privadas ===================== */

    private function looksLikeBcrypt(?string $hash): bool {
        if (!$hash) return false;
        // Bcrypt típico: $2y$10$...
        return str_starts_with($hash, '$2y$') || str_starts_with($hash, '$2a$') || str_starts_with($hash, '$2b$');
    }

    /**
 * Genera automáticamente el siguiente número de empleado disponible.
 * Ejemplo: 1001, 1002, ... 9999
 */
public function generateNumeroEmpleado(): string {
    $sql = "SELECT MAX(CAST(numero_empleado AS UNSIGNED)) AS max_num FROM " . self::T_TEACH;
    $this->db->query($sql);
    $max = (int)$this->db->fetchColumn();

    $next = $max > 0 ? $max + 1 : 1000; // empieza en 1000 si no hay registros
    return str_pad((string)$next, 4, '0', STR_PAD_LEFT); // genera 4 o 5 dígitos, ej. 0100 o 1000
}

}
