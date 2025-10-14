<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Course
{
    private Database $db;
    private string $table = 'materias'; // <-- nombre real de tu tabla

    public function __construct()
    {
        $this->db = new Database();
    }

    /* ===== Listado ===== */
    public function getAll($filters = []): array
    {
        $where  = [];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "(nombre LIKE :q OR clave LIKE :q OR area_conocimiento LIKE :q)";
            $params[':q'] = '%'.$filters['search'].'%';
        }
        if (!empty($filters['carrera_id'])) {
            $where[] = "carrera_id = :carrera_id";
            $params[':carrera_id'] = (int)$filters['carrera_id'];
        }
        if (!empty($filters['tipo'])) {
            $where[] = "tipo = :tipo";
            $params[':tipo'] = $filters['tipo'];
        }
        if (!empty($filters['status'])) {
            $where[] = "status = :status";
            $params[':status'] = $filters['status'];
        }

        $sql = "SELECT id, clave, nombre, descripcion, creditos, horas_semana,
                       semestre_sugerido, tipo, area_conocimiento, carrera_id,
                       status, created_at, updated_at
                FROM {$this->table}";
        if ($where) $sql .= " WHERE ".implode(' AND ', $where);
        $sql .= " ORDER BY nombre ASC";

        $this->db->query($sql, $params);
        return $this->db->fetchAll();
    }

    public function findById(int $id): ?object
    {
        $sql = "SELECT id, clave, nombre, descripcion, creditos, horas_semana,
                       semestre_sugerido, tipo, area_conocimiento, carrera_id,
                       status, created_at, updated_at
                FROM {$this->table}
                WHERE id = :id";
        $this->db->query($sql, [':id' => $id]);
        return $this->db->fetch() ?: null;
    }

    /* ===== Altas ===== */
    public function create(array $data): bool
    {
        $sql = "INSERT INTO {$this->table}
                (clave, nombre, descripcion, creditos, horas_semana,
                 semestre_sugerido, tipo, area_conocimiento, carrera_id, status, created_at)
                VALUES
                (:clave, :nombre, :descripcion, :creditos, :horas_semana,
                 :semestre_sugerido, :tipo, :area_conocimiento, :carrera_id, :status, NOW())";
        $this->db->query($sql, [
            ':clave'              => $data['clave'] ?? null,
            ':nombre'             => $data['nombre'] ?? null,
            ':descripcion'        => $data['descripcion'] ?? null,
            ':creditos'           => (int)($data['creditos'] ?? 0),
            ':horas_semana'       => (int)($data['horas_semana'] ?? 0),
            ':semestre_sugerido'  => (int)($data['semestre_sugerido'] ?? 1),
            ':tipo'               => $data['tipo'] ?? 'obligatoria',
            ':area_conocimiento'  => $data['area_conocimiento'] ?? null,
            ':carrera_id'         => (int)($data['carrera_id'] ?? 0),
            ':status'             => $data['status'] ?? 'activa',
        ]);
        return $this->db->rowCount() > 0;
    }

    /* ===== Cambios ===== */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE {$this->table}
                SET clave = :clave,
                    nombre = :nombre,
                    descripcion = :descripcion,
                    creditos = :creditos,
                    horas_semana = :horas_semana,
                    semestre_sugerido = :semestre_sugerido,
                    tipo = :tipo,
                    area_conocimiento = :area_conocimiento,
                    carrera_id = :carrera_id,
                    status = :status
                WHERE id = :id";
        $this->db->query($sql, [
            ':clave'              => $data['clave'] ?? null,
            ':nombre'             => $data['nombre'] ?? null,
            ':descripcion'        => $data['descripcion'] ?? null,
            ':creditos'           => (int)($data['creditos'] ?? 0),
            ':horas_semana'       => (int)($data['horas_semana'] ?? 0),
            ':semestre_sugerido'  => (int)($data['semestre_sugerido'] ?? 1),
            ':tipo'               => $data['tipo'] ?? 'obligatoria',
            ':area_conocimiento'  => $data['area_conocimiento'] ?? null,
            ':carrera_id'         => (int)($data['carrera_id'] ?? 0),
            ':status'             => $data['status'] ?? 'activa',
            ':id'                 => $id,
        ]);
        return $this->db->rowCount() >= 0;
    }

    /* ===== Bajas ===== */
    public function delete(int $id): bool
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id", [':id' => $id]);
        return $this->db->rowCount() > 0;
    }

    /* ===== Helpers ===== */
    public function getDistinctTipos(): array
    {
        $this->db->query("SELECT DISTINCT tipo FROM {$this->table} ORDER BY tipo");
        return $this->db->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getDistinctSemestresSugeridos(): array
    {
        $this->db->query("SELECT DISTINCT semestre_sugerido FROM {$this->table} ORDER BY semestre_sugerido");
        return $this->db->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    // Materias (cursos) que imparte un docente por su user_id
public function getByTeacher(int $teacherUserId): array {
    $sql = "
        SELECT DISTINCT
            m.id,
            m.nombre        AS name,
            m.clave         AS code,
            m.creditos,
            m.semestre_sugerido AS semestre_sugerido,
            m.area_conocimiento,
            m.status,
            m.created_at
        FROM materias m
        INNER JOIN horarios h ON h.materia_id = m.id
        WHERE h.profesor_id = :uid
        ORDER BY m.nombre ASC
    ";
    $this->db->query($sql, [':uid' => $teacherUserId]);
    return $this->db->fetchAll();
}

// Próximas clases del docente (ordenadas por día y hora)
public function getUpcomingByTeacher(int $teacherUserId, int $limit = 10): array {
    $limit = (int)$limit; // por seguridad en LIMIT

    $sql = "
        SELECT
            h.id,
            m.nombre AS course_name,
            h.dia_semana      AS day_of_week,
            h.hora_inicio     AS start_time,
            h.hora_fin        AS end_time,
            h.aula
        FROM horarios h
        INNER JOIN materias m ON m.id = h.materia_id
        WHERE h.profesor_id = :uid
        ORDER BY FIELD(h.dia_semana,1,2,3,4,5,6,7), h.hora_inicio
        LIMIT {$limit}
    ";
    $this->db->query($sql, [':uid' => $teacherUserId]);
    return $this->db->fetchAll();
}

/**
 * Materias actuales del alumno (por user_id del alumno).
 * Intenta varias tablas según lo que exista en tu BD:
 *  - student_courses (pivot: student_id, materia_id)
 *  - inscripciones   (con materia_id o course_id)
 * Si no encuentra ninguna, devuelve [] sin romper.
 */
public function getCurrentByStudent(int $studentUserId): array {
    // 1) Intento vía tabla pivot: student_courses(student_id, materia_id, status)
    try {
        $sql = "
            SELECT m.id,
                   m.nombre AS name,
                   m.clave  AS code,
                   m.creditos,
                   m.semestre_sugerido,
                   m.area_conocimiento,
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
    } catch (\Throwable $e) {
        // tabla no existe o columnas distintas: seguimos al plan B
    }

    // 2) Intento vía inscripciones (ajusta nombres si tu esquema es distinto)
    try {
        // Variante A: inscripciones(materia_id, alumno_id|student_id)
        $sqlA = "
            SELECT m.id,
                   m.nombre AS name,
                   m.clave  AS code,
                   m.creditos,
                   m.semestre_sugerido,
                   m.area_conocimiento,
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

    try {
        // Variante B: inscripciones(course_id) si usabas courses
        $sqlB = "
            SELECT m.id,
                   m.nombre AS name,
                   m.clave  AS code,
                   m.creditos,
                   m.semestre_sugerido,
                   m.area_conocimiento,
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

    // 3) No hay fuente disponible → devolvemos vacío
    return [];
}

public function getStudentsByTeacher(int $teacherUserId): array
{
    // Intento A: pivote student_courses(student_id, materia_id)
    try {
        $sql = "
            SELECT DISTINCT
                u.id,
                u.name,
                u.email,
                u.matricula,
                u.carrera,
                u.semestre,
                u.grupo,
                u.status,
                m.id  AS materia_id,
                m.nombre AS materia_nombre
            FROM horarios h
            INNER JOIN materias m       ON m.id = h.materia_id
            INNER JOIN student_courses sc ON sc.materia_id = m.id
            INNER JOIN users u            ON u.id = sc.student_id
            WHERE h.profesor_id = :uid
            ORDER BY u.name ASC
        ";
        $this->db->query($sql, [':uid' => $teacherUserId]);
        $rows = $this->db->fetchAll();
        if ($rows) return $rows;
    } catch (\Throwable $e) { /* seguimos con otros intentos */ }

    // Intento B: inscripciones con materia_id y alumno_id|student_id
    try {
        $sql = "
            SELECT DISTINCT
                u.id,
                u.name,
                u.email,
                u.matricula,
                u.carrera,
                u.semestre,
                u.grupo,
                u.status,
                m.id  AS materia_id,
                m.nombre AS materia_nombre
            FROM horarios h
            INNER JOIN materias m    ON m.id = h.materia_id
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

    // Intento C: pivote course_user(user_id, course_id) + filtro por rol
    try {
        $sql = "
            SELECT DISTINCT
                u.id,
                u.name,
                u.email,
                u.matricula,
                u.carrera,
                u.semestre,
                u.grupo,
                u.status,
                m.id  AS materia_id,
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

public function countPendingScheduleChanges(): int
{
    // Intento A: cambios_horario(estado IN ('pendiente','pending'))
    try {
        $sql = "SELECT COUNT(*) AS c FROM cambios_horario WHERE estado IN ('pendiente','pending')";
        $this->db->query($sql);
        $row = $this->db->fetch();
        if ($row && isset($row->c)) return (int)$row->c;
    } catch (\Throwable $e) { /* tabla/columna no existe, seguimos */ }

    // Intento B: solicitudes_cambio_horario(status IN ('pendiente','pending'))
    try {
        $sql = "SELECT COUNT(*) AS c FROM solicitudes_cambio_horario WHERE status IN ('pendiente','pending')";
        $this->db->query($sql);
        $row = $this->db->fetch();
        if ($row && isset($row->c)) return (int)$row->c;
    } catch (\Throwable $e) {}

    // Intento C: schedule_changes(state/status)
    try {
        // Variante 1: columna 'status'
        $sql1 = "SELECT COUNT(*) AS c FROM schedule_changes WHERE status IN ('pendiente','pending')";
        $this->db->query($sql1);
        $row = $this->db->fetch();
        if ($row && isset($row->c)) return (int)$row->c;
    } catch (\Throwable $e) {}

    try {
        // Variante 2: columna 'state'
        $sql2 = "SELECT COUNT(*) AS c FROM schedule_changes WHERE state IN ('pendiente','pending')";
        $this->db->query($sql2);
        $row = $this->db->fetch();
        if ($row && isset($row->c)) return (int)$row->c;
    } catch (\Throwable $e) {}

    // Sin tabla conocida → 0
    return 0;
}


}
