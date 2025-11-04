<?php
namespace App\Models;

use App\Core\Database;

class Course
{
    private Database $db;
    private string $table = 'materias';

    public function __construct(?Database $db = null)
    {
        $this->db = $db ?? new Database();
    }

    /* ============================================================
     * LISTADO
     * filters:
     *  - search  : string (busca en nombre/clave)
     *  - status  : 'activa' | 'inactiva'
     *  - limit   : int (opcional, por defecto 0 = sin LIMIT)
     *  - offset  : int
     * ============================================================ */
    public function getAll(array $filters = []): array
    {
        $where  = [];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "(nombre LIKE :q OR clave LIKE :q)";
            $params[':q'] = '%'.$filters['search'].'%';
        }
        if (!empty($filters['status'])) {
            $where[] = "status = :status";
            $params[':status'] = $filters['status'];
        }

        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

        $sql = "SELECT id, clave, nombre, status, created_at, updated_at
                FROM {$this->table}
                {$whereSql}
                ORDER BY nombre ASC";

        $limit  = isset($filters['limit'])  ? (int)$filters['limit']  : 0;
        $offset = isset($filters['offset']) ? (int)$filters['offset'] : 0;

        if ($limit > 0) {
            $sql .= " LIMIT :offset, :limit";
            $params[':offset'] = $offset;
            $params[':limit']  = $limit;
        }

        $this->db->query($sql, $params);
        return $this->db->fetchAll();
    }

    public function countAll(array $filters = []): int
    {
        $where  = [];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "(nombre LIKE :q OR clave LIKE :q)";
            $params[':q'] = '%'.$filters['search'].'%';
        }
        if (!empty($filters['status'])) {
            $where[] = "status = :status";
            $params[':status'] = $filters['status'];
        }

        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';
        $sql = "SELECT COUNT(*) FROM {$this->table} {$whereSql}";
        $this->db->query($sql, $params);
        return (int)$this->db->fetchColumn();
    }

    /* ============================================================
     * CONSULTA POR ID
     * ============================================================ */
    public function findById(int $id): ?object
    {
        $sql = "SELECT id, clave, nombre, status, created_at, updated_at
                FROM {$this->table}
                WHERE id = :id";
        $this->db->query($sql, [':id' => $id]);
        return $this->db->fetch() ?: null;
    }

    /* ============================================================
     * ALTAS
     * data: ['clave','nombre','status']
     *  - status por defecto 'activa'
     * ============================================================ */
public function create(array $data): bool
{
    $nombre = trim($data['nombre'] ?? '');
    $clave  = trim($data['clave']  ?? '');

    if ($clave === '' && $nombre !== '') {
        $base  = $this->makeClaveBase($nombre);
        $clave = $this->ensureUniqueClave($base);
    }

    if ($nombre === '' || $clave === '') {
        // nombre es obligatorio y clave no puede quedar vacía
        throw new \InvalidArgumentException('Nombre y clave son requeridos.');
    }

    $sql = "INSERT INTO {$this->table}
            (clave, nombre, status, created_at)
            VALUES
            (:clave, :nombre, :status, NOW())";
    $this->db->query($sql, [
        ':clave'  => $clave,
        ':nombre' => $nombre,
        ':status' => $data['status'] ?? 'activa',
    ]);
    return $this->db->rowCount() > 0;
}


    /* ============================================================
     * CAMBIOS
     * data: ['clave','nombre','status']
     * ============================================================ */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET clave = :clave,
                    nombre = :nombre,
                    status = :status
                WHERE id = :id";
        $this->db->query($sql, [
            ':clave'  => $data['clave']  ?? null,
            ':nombre' => $data['nombre'] ?? null,
            ':status' => $data['status'] ?? 'activa',
            ':id'     => $id,
        ]);
        // rowCount puede ser 0 cuando no cambian valores; lo consideramos OK
        return $this->db->rowCount() >= 0;
    }

    /* ============================================================
     * BAJAS
     * ============================================================ */
    public function delete(int $id): bool
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id", [':id' => $id]);
        return $this->db->rowCount() > 0;
    }

    /* ============================================================
     * RELACIONADAS CON DOCENTES/HORARIOS/ALUMNOS
     * (ajustadas a columnas existentes de 'materias')
     * ============================================================ */

/** Materias impartidas por un docente (user_id del profesor) */
public function getByTeacher(int $teacherUserId): array
{
    $sql = "
        SELECT
            mg.id                  AS mg_id,         -- clave para el hub
            mg.codigo              AS mg_code,
            m.id                   AS materia_id,
            m.nombre               AS name,
            m.clave                AS code,
            m.status,
            m.created_at,

            g.id                   AS group_id,
            g.codigo               AS group_code,
            COALESCE(g.titulo, '') AS group_title,  -- ← ya no usamos g.nombre

            -- Conteo de alumnos usando student_profiles
            COALESCE((
                SELECT COUNT(*) FROM student_profiles sp
                WHERE sp.grupo_id = mg.grupo_id
            ), 0) AS student_count,

            -- Resumen de horario (si existe la tabla 'horarios')
            h.day_of_week,
            h.start_time,
            h.end_time,
            h.room
        FROM materia_grupo_profesor mgp
        INNER JOIN materias_grupos mg ON mg.id = mgp.mg_id
        INNER JOIN materias m         ON m.id = mg.materia_id
        LEFT JOIN grupos g            ON g.id = mg.grupo_id

        LEFT JOIN (
            SELECT 
                h.group_id,
                h.materia_id,
                MIN(h.dia_semana)  AS day_of_week,
                MIN(h.hora_inicio) AS start_time,
                MAX(h.hora_fin)    AS end_time,
                MIN(h.aula)        AS room
            FROM horarios h
            GROUP BY h.group_id, h.materia_id
        ) h ON h.group_id = mg.grupo_id AND h.materia_id = mg.materia_id

        WHERE mgp.teacher_user_id = :tid
        ORDER BY m.nombre ASC, g.codigo ASC, mg.codigo ASC
    ";
    $this->db->query($sql, [':tid' => $teacherUserId]);
    return $this->db->fetchAll() ?: [];
}




/** Próximas clases del docente según 'horarios' (usa professor_user_id directamente) */
public function getUpcomingByTeacher(int $teacherUserId, int $limit = 10): array
{
    $limit = max(1, (int)$limit);
    $sql = "
        SELECT
            h.id,
            h.dia_semana  AS day_of_week,   -- en tu esquema es VARCHAR(10)
            h.hora_inicio AS start_time,
            h.hora_fin    AS end_time,
            h.aula,
            m.nombre      AS course_name,
            m.clave       AS code
        FROM horarios h
        LEFT JOIN materias m ON m.id = h.materia_id   -- FK apunta a backup, pero si IDs coinciden, esto funciona
        WHERE h.profesor_id = :uid
        ORDER BY 
            FIELD(h.dia_semana,'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'),
            h.hora_inicio
        LIMIT {$limit}
    ";
    $this->db->query($sql, [':uid' => $teacherUserId]);
    return $this->db->fetchAll();
}


    /**
     * Materias actuales del alumno (por user_id del alumno).
     * Intenta varias tablas si existen. Retorna [] si no hay fuente.
     */
    public function getCurrentByStudent(int $studentUserId): array
    {
        // A) pivote: student_courses(student_id, materia_id)
        try {
            $sql = "
                SELECT m.id,
                       m.nombre AS name,
                       m.clave  AS code,
                       m.status,
                       m.created_at
                FROM student_courses sc
                INNER JOIN materias m ON m.id = sc.materia_id
                WHERE sc.student_id = :sid
                  AND (sc.status IS NULL OR sc.status IN ('activo','inscrito','current'))
                ORDER BY m.nombre ASC
            ";
            $this->db->query($sql, [':sid' => $studentUserId]);
            $rows = $this->db->fetchAll();
            if ($rows) return $rows;
        } catch (\Throwable $e) {}

        // B) inscripciones(materia_id, alumno_id|student_id)
        try {
            $sqlA = "
                SELECT m.id,
                       m.nombre AS name,
                       m.clave  AS code,
                       m.status,
                       m.created_at
                FROM inscripciones i
                INNER JOIN materias m ON m.id = i.materia_id
                WHERE (i.alumno_id = :sid OR i.student_id = :sid)
                  AND (i.estado IS NULL OR i.estado IN ('inscrito','activo'))
                ORDER BY m.nombre ASC
            ";
            $this->db->query($sqlA, [':sid' => $studentUserId]);
            $rows = $this->db->fetchAll();
            if ($rows) return $rows;
        } catch (\Throwable $e) {}

        // C) inscripciones(course_id) si usabas courses
        try {
            $sqlB = "
                SELECT m.id,
                       m.nombre AS name,
                       m.clave  AS code,
                       m.status,
                       m.created_at
                FROM inscripciones i
                INNER JOIN materias m ON m.id = i.course_id
                WHERE (i.alumno_id = :sid OR i.student_id = :sid)
                  AND (i.estado IS NULL OR i.estado IN ('inscrito','activo'))
                ORDER BY m.nombre ASC
            ";
            $this->db->query($sqlB, [':sid' => $studentUserId]);
            $rows = $this->db->fetchAll();
            if ($rows) return $rows;
        } catch (\Throwable $e) {}

        return [];
    }

    /** Estudiantes de las materias impartidas por un docente */
    public function getStudentsByTeacher(int $teacherUserId): array
    {
        // Intento A: student_courses
        try {
            $sql = "
                SELECT DISTINCT
                    u.id,
                    u.name,
                    u.email,
                    u.status,
                    m.id   AS materia_id,
                    m.nombre AS materia_nombre
                FROM horarios h
                INNER JOIN materias m         ON m.id = h.materia_id
                INNER JOIN student_courses sc ON sc.materia_id = m.id
                INNER JOIN users u            ON u.id = sc.student_id
                WHERE h.profesor_id = :uid
                ORDER BY u.name ASC
            ";
            $this->db->query($sql, [':uid' => $teacherUserId]);
            $rows = $this->db->fetchAll();
            if ($rows) return $rows;
        } catch (\Throwable $e) {}

        // Intento B: inscripciones
        try {
            $sql = "
                SELECT DISTINCT
                    u.id,
                    u.name,
                    u.email,
                    u.status,
                    m.id   AS materia_id,
                    m.nombre AS materia_nombre
                FROM horarios h
                INNER JOIN materias m ON m.id = h.materia_id
                INNER JOIN inscripciones i
                    ON (i.materia_id = m.id OR i.course_id = m.id)
                INNER JOIN users u
                    ON u.id = COALESCE(i.alumno_id, i.student_id)
                WHERE h.profesor_id = :uid
                  AND (i.estado IS NULL OR i.estado IN ('inscrito','activo','current'))
                ORDER BY u.name ASC
            ";
            $this->db->query($sql, [':uid' => $teacherUserId]);
            $rows = $this->db->fetchAll();
            if ($rows) return $rows;
        } catch (\Throwable $e) {}

        // Intento C: course_user (fallback)
        try {
            $sql = "
                SELECT DISTINCT
                    u.id,
                    u.name,
                    u.email,
                    u.status,
                    m.id   AS materia_id,
                    m.nombre AS materia_nombre
                FROM horarios h
                INNER JOIN materias m   ON m.id = h.materia_id
                INNER JOIN course_user cu ON cu.course_id = m.id
                INNER JOIN users u        ON u.id = cu.user_id
                WHERE h.profesor_id = :uid
                  AND (
                        u.role = 'student'
                     OR JSON_CONTAINS(u.roles, '\"student\"')
                     OR u.roles LIKE '%student%'
                  )
                ORDER BY u.name ASC
            ";
            $this->db->query($sql, [':uid' => $teacherUserId]);
            $rows = $this->db->fetchAll();
            if ($rows) return $rows;
        } catch (\Throwable $e) {}

        return [];
    }

    /** Contador de solicitudes de cambio de horario pendientes (si existen tablas) */
    public function countPendingScheduleChanges(): int
    {
        try {
            $this->db->query("SELECT COUNT(*) AS c FROM cambios_horario WHERE estado IN ('pendiente','pending')");
            $row = $this->db->fetch();
            if ($row && isset($row->c)) return (int)$row->c;
        } catch (\Throwable $e) {}

        try {
            $this->db->query("SELECT COUNT(*) AS c FROM solicitudes_cambio_horario WHERE status IN ('pendiente','pending')");
            $row = $this->db->fetch();
            if ($row && isset($row->c)) return (int)$row->c;
        } catch (\Throwable $e) {}

        try {
            $this->db->query("SELECT COUNT(*) AS c FROM schedule_changes WHERE status IN ('pendiente','pending')");
            $row = $this->db->fetch();
            if ($row && isset($row->c)) return (int)$row->c;
        } catch (\Throwable $e) {}

        try {
            $this->db->query("SELECT COUNT(*) AS c FROM schedule_changes WHERE state IN ('pendiente','pending')");
            $row = $this->db->fetch();
            if ($row && isset($row->c)) return (int)$row->c;
        } catch (\Throwable $e) {}

        return 0;
    }

    private function makeClaveBase(string $nombre): string
{
    // Quitar acentos/símbolos y dejar letras/números/espacios
    $ascii = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $nombre);
    if ($ascii === false) $ascii = $nombre;
    $ascii = preg_replace('/[^A-Za-z0-9\s]/', ' ', $ascii);

    // Tomar iniciales de cada palabra
    $parts = preg_split('/\s+/', trim($ascii), -1, PREG_SPLIT_NO_EMPTY);
    $abbr = '';
    foreach ($parts as $p) {
        $abbr .= strtoupper(substr($p, 0, 1));
    }

    // Fallback si quedó muy corta
    if (strlen($abbr) < 3) {
        $compact = strtoupper(preg_replace('/\s+/', '', $ascii));
        $abbr = substr($compact, 0, 6);
    }

    return substr($abbr, 0, 12); // límite razonable
}

/** Verifica si ya existe una clave */
private function existsClave(string $clave): bool
{
    $sql = "SELECT 1 FROM {$this->table} WHERE clave = :c LIMIT 1";
    $this->db->query($sql, [':c' => $clave]);
    return (bool)$this->db->fetch();
}

/** Asegura unicidad de la clave agregando sufijos (-01, -02, …) si es necesario */
private function ensureUniqueClave(string $base): string
{
    $base = strtoupper($base);
    if (!$this->existsClave($base)) return $base;

    $i = 1;
    while (true) {
        $suffix = '-'.str_pad((string)$i, 2, '0', STR_PAD_LEFT);
        // reservar espacio para el sufijo
        $candidate = substr($base, 0, max(1, 12 - strlen($suffix))) . $suffix;
        if (!$this->existsClave($candidate)) return $candidate;
        $i++;
    }
}

/** Genera abreviatura desde el nombre, ignorando stopwords en español */
private function generateAbbrFromName(string $name): string
{
    // quitar acentos y símbolos
    $s = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
    $s = preg_replace('/[^A-Za-z0-9\s]/', ' ', $s);

    $words = preg_split('/\s+/', trim($s), -1, PREG_SPLIT_NO_EMPTY);
    $stop  = [
        'a','al','del','de','la','las','lo','los','y','e','u','o',
        'en','para','por','con','sobre','sin','un','una','unos','unas'
    ];

    $letters = [];
    foreach ($words as $w) {
        $lw = strtolower($w);
        if (in_array($lw, $stop, true)) continue;
        $letters[] = strtoupper($w[0]);
    }

    // fallback si quedó vacío: primeras letras del nombre “aplanado”
    if (!$letters) {
        $flat = strtoupper(preg_replace('/\s+/', '', $s));
        $abbr = substr($flat, 0, 6);
    } else {
        $abbr = implode('', $letters);
    }
    return substr($abbr, 0, 12);
}

/** Autogenera clave única si viene vacía; si existe, agrega sufijos -01, -02, ... */
private function autogenUniqueKey(string $nombre, ?string $clave): string
{
    $key = trim((string)$clave);
    if ($key === '') {
        $key = $this->generateAbbrFromName($nombre);
    }
    // normaliza clave
    $key = strtoupper(preg_replace('/[^A-Z0-9\-]/', '', $key));
    if ($key === '') $key = 'MAT';

    // asegura unicidad
    $base = $key;
    $i = 1;
    while (true) {
        $this->db->query("SELECT 1 FROM {$this->table} WHERE clave = :c LIMIT 1", [':c' => $key]);
        if (!$this->db->fetch()) break; // libre
        $key = sprintf('%s-%02d', $base, $i++);
    }
    return $key;
}


}
