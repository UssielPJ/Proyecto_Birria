<?php
namespace App\Models;

use App\Core\Database;

class Solicitud {
  private Database $db;
  private ?string $resolvedTable = null;

  // posibles nombres reales en tu BD
  private array $candidates = [
    'solicitudes',
    'solicitudes_cambio_horario',
    'solicitudes_cambio',
    'schedule_requests',
    'requests'
  ];

  public function __construct() { $this->db = new Database(); }

  private function table(): string {
    if ($this->resolvedTable) return $this->resolvedTable;
    foreach ($this->candidates as $t) {
      try {
        $this->db->query("SELECT 1 FROM {$t} LIMIT 1");
        $this->db->fetch(); // si llega aquí, existe
        $this->resolvedTable = $t;
        return $t;
      } catch (\Throwable $e) { /* probar siguiente */ }
    }
    // si ninguna existe, usa 'solicitudes' y deja que truene "controlado"
    $this->resolvedTable = 'solicitudes';
    return $this->resolvedTable;
  }

  public function countAll(array $filters = []): int {
    $t = $this->table();
    $where = []; $params = [];

    if (!empty($filters['status'])) { $where[] = "(estado = :status OR status = :status)"; $params[':status'] = $filters['status']; }
    if (!empty($filters['type']))   { $where[] = "(tipo = :type OR type = :type)";       $params[':type']   = $filters['type']; }
    if (!empty($filters['q']))      { $where[] = "(descripcion LIKE :q OR motivo LIKE :q)"; $params[':q'] = '%'.$filters['q'].'%'; }

    $sql = "SELECT COUNT(*) AS c FROM {$t}";
    if ($where) $sql .= ' WHERE '.implode(' AND ', $where);
    $this->db->query($sql, $params);
    $row = $this->db->fetch();
    return (int)($row->c ?? 0);
  }

  public function getAll(array $filters = [], int $limit = 10, int $offset = 0): array {
    $t = $this->table();
    $where = []; $params = [];

    if (!empty($filters['status'])) { $where[] = "(s.estado = :status OR s.status = :status)"; $params[':status'] = $filters['status']; }
    if (!empty($filters['type']))   { $where[] = "(s.tipo = :type OR s.type = :type)";        $params[':type']   = $filters['type']; }
    if (!empty($filters['q']))      { $where[] = "(s.descripcion LIKE :q OR s.motivo LIKE :q)"; $params[':q'] = '%'.$filters['q'].'%'; }

    // Columnas comunes con alias seguros
    $sql = "
      SELECT
        s.id,
        COALESCE(s.tipo, s.type, 'general')           AS tipo,
        COALESCE(s.estado, s.status, 'pendiente')     AS estado,
        COALESCE(s.descripcion, s.motivo, '')         AS descripcion,
        COALESCE(s.created_at, s.fecha_creacion, NOW()) AS created_at,
        COALESCE(s.alumno_id, s.student_id, s.user_id, NULL) AS user_ref
      FROM {$t} s
    ";
    if ($where) $sql .= ' WHERE '.implode(' AND ', $where);
    $sql .= ' ORDER BY created_at DESC LIMIT :limit OFFSET :offset';

    // bind seguro para limit/offset
    $params[':limit']  = (int)$limit;
    $params[':offset'] = (int)$offset;

    $this->db->query($sql, $params);
    return $this->db->fetchAll();
  }
}
