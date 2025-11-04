<?php
namespace App\Models;

use App\Core\Database;

class Schedule {
    private Database $db;
    private string $table = 'horarios'; // tabla real
    // Mapa 1..7 -> etiqueta
    private const DAY_LABELS = [1=>'Lun',2=>'Mar',3=>'Mie',4=>'Jue',5=>'Vie',6=>'Sab',7=>'Dom'];

    public function __construct() { $this->db = new Database(); }

    /* ================= Utils para normalizar fetch() / fetchAll() ================= */
    private function rowToArray($row): ?array {
        if ($row === null || $row === false) return null;
        if (is_array($row)) return $row;
        if (is_object($row)) return get_object_vars($row);
        return null;
    }

    /** @return array<int, array<string,mixed>> */
    private function rowsToArrays($rows): array {
        if (!is_array($rows)) return [];
        $out = [];
        foreach ($rows as $r) {
            if (is_array($r))      { $out[] = $r; }
            elseif (is_object($r)) { $out[] = get_object_vars($r); }
        }
        return $out;
    }

    /* ================= CRUD ================= */
    public function getAll(array $filters = []): array {
        $where=[]; $p=[];

        if (!empty($filters['group_id']))   { $where[]="group_id = :gid";     $p[':gid']=(int)$filters['group_id']; }
        if (!empty($filters['materia_id'])) { $where[]="materia_id = :mid";   $p[':mid']=(int)$filters['materia_id']; }
        if (!empty($filters['teacher_id'])) { $where[]="teacher_id = :tid";   $p[':tid']=(int)$filters['teacher_id']; }
        if (!empty($filters['dia_semana'])) { $where[]="dia_semana = :dow";   $p[':dow']=(int)$filters['dia_semana']; }

        $sql = "SELECT id, group_id, materia_id, teacher_id, dia_semana, hora_inicio, hora_fin, aula, created_at
                FROM {$this->table}";
        if ($where) $sql .= " WHERE ".implode(' AND ', $where);
        $sql .= " ORDER BY dia_semana, hora_inicio";

        $this->db->query($sql, $p);
        return $this->rowsToArrays($this->db->fetchAll() ?? []);
    }

    public function getById(int $id): ?array {
        $this->db->query("SELECT * FROM {$this->table} WHERE id=:id", [':id'=>$id]);
        return $this->rowToArray($this->db->fetch()) ?: null;
    }

    public function create(array $d): bool {
        $sql = "INSERT INTO {$this->table}
                (group_id, materia_id, teacher_id, dia_semana, hora_inicio, hora_fin, aula, created_at)
                VALUES (:gid, :mid, :tid, :dow, :hin, :hfin, :aula, NOW())";
        $this->db->query($sql, [
            ':gid'  => (int)$d['group_id'],
            ':mid'  => (int)$d['materia_id'],
            ':tid'  => !empty($d['teacher_id']) ? (int)$d['teacher_id'] : null,
            ':dow'  => (int)$d['dia_semana'],           // 1..7
            ':hin'  => $d['hora_inicio'],               // 'HH:MM:SS'
            ':hfin' => $d['hora_fin'],
            ':aula' => $d['aula'] ?? null,
        ]);
        return $this->db->rowCount() > 0;
    }

    public function update(int $id, array $d): bool {
        $sql = "UPDATE {$this->table}
                SET group_id=:gid, materia_id=:mid, teacher_id=:tid, dia_semana=:dow,
                    hora_inicio=:hin, hora_fin=:hfin, aula=:aula
                WHERE id=:id";
        $this->db->query($sql, [
            ':gid'  => (int)$d['group_id'],
            ':mid'  => (int)$d['materia_id'],
            ':tid'  => !empty($d['teacher_id']) ? (int)$d['teacher_id'] : null,
            ':dow'  => (int)$d['dia_semana'],
            ':hin'  => $d['hora_inicio'],
            ':hfin' => $d['hora_fin'],
            ':aula' => $d['aula'] ?? null,
            ':id'   => $id,
        ]);
        return $this->db->rowCount() >= 0;
    }

    public function delete(int $id): bool {
        $this->db->query("DELETE FROM {$this->table} WHERE id=:id", [':id'=>$id]);
        return $this->db->rowCount() > 0;
    }

    /* ============ Consultas para paneles ============ */

    /** Semana del ALUMNO: infiere group_id desde student_profiles.user_id */
    public function getWeekByStudent(int $studentUserId): array {
        // 1) grupo del alumno
        $this->db->query("SELECT grupo_id FROM student_profiles WHERE user_id=:uid LIMIT 1", [':uid'=>$studentUserId]);
        $sp = $this->rowToArray($this->db->fetch());
        if (!$sp || empty($sp['grupo_id'])) return $this->emptyWeek();

        $gid = (int)$sp['grupo_id'];

        // 2) horario del grupo con joins para nombres
        $sql = "
            SELECT 
                h.dia_semana, h.hora_inicio, h.hora_fin, h.aula,
                m.id AS materia_id, m.nombre AS materia_nombre,
                h.teacher_id,
                u.nombre AS teacher_nombre
            FROM {$this->table} h
            JOIN materias m   ON m.id = h.materia_id
            LEFT JOIN users u ON u.id = h.teacher_id
            WHERE h.group_id = :gid
            ORDER BY h.dia_semana, h.hora_inicio";
        $this->db->query($sql, [':gid'=>$gid]);
        $rows = $this->rowsToArrays($this->db->fetchAll() ?? []);

        return $this->groupByDay($rows);
    }

    /** Semana del PROFESOR (teacher_profiles.user_id) */
    public function getWeekByTeacher(int $teacherUserId): array {
        $sql = "
            SELECT 
                h.dia_semana, h.hora_inicio, h.hora_fin, h.aula,
                m.id AS materia_id, m.nombre AS materia_nombre,
                h.group_id
            FROM {$this->table} h
            JOIN materias m ON m.id = h.materia_id
            WHERE h.teacher_id = :tid
            ORDER BY h.dia_semana, h.hora_inicio";
        $this->db->query($sql, [':tid'=>$teacherUserId]);
        $rows = $this->rowsToArrays($this->db->fetchAll() ?? []);

        return $this->groupByDay($rows);
    }

    /* ================= Helpers ================= */
    private function emptyWeek(): array {
        $w = [];
        foreach (self::DAY_LABELS as $lab) $w[$lab] = [];
        return $w;
    }

    private function groupByDay(array $rows): array {
        $week = $this->emptyWeek();
        foreach ($rows as $r) {
            $n = (int)($r['dia_semana'] ?? 1); // 1..7
            $key = self::DAY_LABELS[$n] ?? 'Lun';
            $week[$key][] = $r;
        }
        return $week;
    }

    /** Próxima clase del alumno a partir de ahora (server time). */
    public function getNextClass(int $studentUserId): ?array
    {
        // 1) Obtener grupo del alumno
        $this->db->query(
            "SELECT grupo_id FROM student_profiles WHERE user_id = :uid LIMIT 1",
            [':uid' => $studentUserId]
        );
        $sp = $this->rowToArray($this->db->fetch());
        if (!$sp || empty($sp['grupo_id'])) return null;

        $gid   = (int)$sp['grupo_id'];
        $today = (int)date('N');       // 1..7 (Lun=1)
        $now   = date('H:i:s');        // HH:MM:SS

        // 2) Buscar la siguiente clase (evitar reutilizar el mismo placeholder)
        $sql = "
            SELECT 
                h.dia_semana, h.hora_inicio, h.hora_fin, h.aula, h.group_id,
                m.id AS materia_id, m.nombre AS materia_nombre,
                h.teacher_id,
                u.nombre AS teacher_nombre
            FROM {$this->table} h
            JOIN materias m   ON m.id = h.materia_id
            LEFT JOIN users u ON u.id = h.teacher_id
            WHERE h.group_id = :gid
              AND (h.dia_semana <> :today1 OR h.hora_inicio >= :now)
            ORDER BY MOD(h.dia_semana + 7 - :today2, 7), h.hora_inicio
            LIMIT 1
        ";
        $this->db->query($sql, [
            ':gid'    => $gid,
            ':today1' => $today,
            ':today2' => $today,
            ':now'    => $now,
        ]);

        $row = $this->rowToArray($this->db->fetch());
        return $row ?: null;
    }

    /** Clases de HOY para el alumno, ordenadas por hora. */
    public function getTodayByStudent(int $studentUserId): array
    {
        $this->db->query(
            "SELECT grupo_id FROM student_profiles WHERE user_id = :uid LIMIT 1",
            [':uid' => $studentUserId]
        );
        $sp = $this->rowToArray($this->db->fetch());
        if (!$sp || empty($sp['grupo_id'])) return [];

        $gid   = (int)$sp['grupo_id'];
        $today = (int)date('N');

        $sql = "
            SELECT 
                h.dia_semana, h.hora_inicio, h.hora_fin, h.aula, h.group_id,
                m.id AS materia_id, m.nombre AS materia_nombre,
                h.teacher_id,
                u.nombre AS teacher_nombre
            FROM {$this->table} h
            JOIN materias m   ON m.id = h.materia_id
            LEFT JOIN users u ON u.id = h.teacher_id
            WHERE h.group_id = :gid AND h.dia_semana = :today
            ORDER BY h.hora_inicio
        ";
        $this->db->query($sql, [':gid' => $gid, ':today' => $today]);
        return $this->rowsToArrays($this->db->fetchAll() ?? []);
    }
}
