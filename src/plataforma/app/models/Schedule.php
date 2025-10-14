<?php
namespace App\Models;

use App\Core\Database;

class Schedule {
    private Database $db;
    private string $table = 'horarios'; // nombre real de tu tabla
    private const DAYS = ['Lun','Mar','Mie','Jue','Vie','Sab','Dom'];

    public function __construct() { $this->db = new Database(); }

    // ========== CRUD básico ==========
    public function getAll(array $filters = []): array {
        $where  = [];
        $params = [];

        if (!empty($filters['materia_id'])) {
            $where[] = "materia_id = :materia_id";
            $params[':materia_id'] = (int)$filters['materia_id'];
        }
        if (!empty($filters['dia_semana'])) {
            $where[] = "dia_semana = :dia_semana";
            $params[':dia_semana'] = $filters['dia_semana'];
        }
        if (!empty($filters['profesor_id'])) {
            $where[] = "profesor_id = :profesor_id";
            $params[':profesor_id'] = (int)$filters['profesor_id'];
        }

        $sql = "SELECT id, materia_id, dia_semana, hora_inicio, hora_fin, aula, profesor_id, created_at, updated_at
                FROM {$this->table}";
        if ($where) $sql .= " WHERE ".implode(' AND ', $where);
        $sql .= " ORDER BY FIELD(dia_semana,'Lun','Mar','Mie','Jue','Vie','Sab','Dom'), hora_inicio";

        $this->db->query($sql, $params);
        return $this->db->fetchAll();
    }

    public function getById(int $id): ?object {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id", [':id'=>$id]);
        return $this->db->fetch() ?: null;
    }

    public function create(array $d): bool {
        $sql = "INSERT INTO {$this->table}
                (materia_id, dia_semana, hora_inicio, hora_fin, aula, profesor_id, created_at)
                VALUES (:materia_id, :dia_semana, :hora_inicio, :hora_fin, :aula, :profesor_id, NOW())";
        $this->db->query($sql, [
            ':materia_id' => (int)$d['materia_id'],
            ':dia_semana' => $d['dia_semana'],
            ':hora_inicio'=> $d['hora_inicio'],
            ':hora_fin'   => $d['hora_fin'],
            ':aula'       => $d['aula'] ?? null,
            ':profesor_id'=> $d['profesor_id'] ?? null,
        ]);
        return $this->db->rowCount() > 0;
    }

    public function update(int $id, array $d): bool {
        $sql = "UPDATE {$this->table}
                SET dia_semana=:dia_semana, hora_inicio=:hora_inicio, hora_fin=:hora_fin,
                    aula=:aula, profesor_id=:profesor_id
                WHERE id=:id";
        $this->db->query($sql, [
            ':dia_semana' => $d['dia_semana'],
            ':hora_inicio'=> $d['hora_inicio'],
            ':hora_fin'   => $d['hora_fin'],
            ':aula'       => $d['aula'] ?? null,
            ':profesor_id'=> $d['profesor_id'] ?? null,
            ':id'         => $id,
        ]);
        return $this->db->rowCount() >= 0;
    }

    public function delete(int $id): bool {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id", [':id'=>$id]);
        return $this->db->rowCount() > 0;
    }

    // ========== Nuevos métodos para horario de maestro ==========

    /**
     * Trae el horario del profesor (lista plana), con filtros opcionales.
     * $filters: dia_semana (Lun..Dom) o materia_id
     */
    public function getByTeacher(int $teacherId, array $filters = []): array {
        $where  = ["profesor_id = :tid"];
        $params = [':tid' => $teacherId];

        if (!empty($filters['dia_semana'])) {
            $where[] = "dia_semana = :dia_semana";
            $params[':dia_semana'] = $filters['dia_semana'];
        }
        if (!empty($filters['materia_id'])) {
            $where[] = "materia_id = :materia_id";
            $params[':materia_id'] = (int)$filters['materia_id'];
        }

        $sql = "SELECT id, materia_id, dia_semana, hora_inicio, hora_fin, aula, profesor_id
                FROM {$this->table}
                WHERE ".implode(' AND ', $where)."
                ORDER BY FIELD(dia_semana,'Lun','Mar','Mie','Jue','Vie','Sab','Dom'), hora_inicio";
        $this->db->query($sql, $params);
        return $this->db->fetchAll();
    }

    /**
     * Devuelve el horario semanal del profesor, agrupado por día.
     * Estructura: ['Lun'=>[...], 'Mar'=>[...], ..., 'Dom'=>[...]]
     */
    public function getWeekByTeacher(int $teacherId): array {
        $rows = $this->getByTeacher($teacherId);

        // Inicializa arreglo por días
        $week = [];
        foreach (self::DAYS as $d) $week[$d] = [];

        foreach ($rows as $r) {
            $dia = $this->normalizeDay($r['dia_semana'] ?? '');
            if ($dia) $week[$dia][] = $r;
        }
        return $week;
    }

    // ========== Helpers ==========

    private function normalizeDay(string $dia): ?string {
        $dia = trim($dia);
        // Acepta variantes comunes
        $map = [
            'Lun'=>'Lun','Lunes'=>'Lun',
            'Mar'=>'Mar','Martes'=>'Mar',
            'Mie'=>'Mie','Mié'=>'Mie','Miercoles'=>'Mie','Miércoles'=>'Mie',
            'Jue'=>'Jue','Jueves'=>'Jue',
            'Vie'=>'Vie','Viernes'=>'Vie',
            'Sab'=>'Sab','Sáb'=>'Sab','Sabado'=>'Sab','Sábado'=>'Sab',
            'Dom'=>'Dom','Domingo'=>'Dom',
        ];
        return $map[$dia] ?? (in_array($dia, self::DAYS, true) ? $dia : null);
    }
}
