<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Announcement
{
    private Database $db;

    public function __construct() { $this->db = new Database(); }

    /* ===== helpers de introspección ===== */
    private static function columnExists(Database $db, string $table, string $column): bool {
        $pdo = $db->getPdo();
        $stmt = $pdo->prepare("
            SELECT 1
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = :c
            LIMIT 1
        ");
        $stmt->execute([':t'=>$table, ':c'=>$column]);
        return (bool)$stmt->fetchColumn();
    }

    private static function tableExists(Database $db, string $table): bool {
        $pdo = $db->getPdo();
        $stmt = $pdo->prepare("
            SELECT 1
            FROM INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t
            LIMIT 1
        ");
        $stmt->execute([':t'=>$table]);
        return (bool)$stmt->fetchColumn();
    }

    /* ===== SELECT base, adaptado a tu esquema ===== */
    private static function buildSelect(Database $db): array {
        // columnas mínimas obligatorias que sí sabemos que existen por tu error previo:
        // id, titulo, contenido. created_at/updated_at si existen las tomamos.
        $hasCreated  = self::columnExists($db, 'anuncios', 'created_at');
        $hasUpdated  = self::columnExists($db, 'anuncios', 'updated_at');

        // rol_destino puede no existir
        $hasRoleDest = self::columnExists($db, 'anuncios', 'rol_destino');

        // user_id + users.name para autor (opcionales)
        $hasUserId   = self::columnExists($db, 'anuncios', 'user_id');
        $hasUsersTbl = self::tableExists($db, 'users');
        $canJoinUser = $hasUserId && $hasUsersTbl && self::columnExists($db, 'users', 'id') && self::columnExists($db, 'users', 'name');

        $select = "SELECT a.id,
                          a.titulo    AS title,
                          a.contenido AS content";
        if ($hasRoleDest) $select .= ", a.rol_destino AS target_role";
        if ($hasUserId)   $select .= ", a.user_id";
        if ($hasCreated)  $select .= ", a.created_at";
        if ($hasUpdated)  $select .= ", a.updated_at";
        if ($canJoinUser) $select .= ", u.name AS author_name";

        $from = " FROM anuncios a";
        if ($canJoinUser) $from .= " LEFT JOIN users u ON u.id = a.user_id";

        return [$select, $from, $hasRoleDest, $canJoinUser, $hasCreated];
    }

    /* ================= Listados ================= */
    public static function all(): array
    {
        $db = new Database();
        [$select, $from, $hasRoleDest, $canJoinUser, $hasCreated] = self::buildSelect($db);

        $order = $hasCreated ? " ORDER BY a.created_at DESC" : " ORDER BY a.id DESC";
        $sql   = $select . $from . $order;

        return $db->query($sql)->fetchAll(PDO::FETCH_OBJ);
    }

    public static function getByRole(string $role): array
    {
        $db = new Database();
        [$select, $from, $hasRoleDest, $canJoinUser, $hasCreated] = self::buildSelect($db);

        // Si no existe rol_destino, no podemos filtrar → devolvemos todo
        if (!$hasRoleDest) {
            $order = $hasCreated ? " ORDER BY a.created_at DESC" : " ORDER BY a.id DESC";
            $sql   = $select . $from . $order;
            return $db->query($sql)->fetchAll(PDO::FETCH_OBJ);
        }

        $order = $hasCreated ? " ORDER BY a.created_at DESC" : " ORDER BY a.id DESC";
        $sql   = $select . $from . " WHERE a.rol_destino = :r OR a.rol_destino = 'all' " . $order;

        return $db->query($sql, [':r'=>$role])->fetchAll(PDO::FETCH_OBJ);
    }

    /* ================= CRUD ================= */
    public static function find(int $id): ?self
    {
        $db = new Database();
        [$select, $from] = self::buildSelect($db);

        $sql  = $select . $from . " WHERE a.id = :id LIMIT 1";
        $row  = $db->query($sql, [':id'=>$id])->fetch(PDO::FETCH_OBJ);
        if (!$row) return null;

        $obj = new self();
        foreach ($row as $k=>$v) $obj->$k = $v;
        return $obj;
    }

    public static function create(array $data): bool
    {
        $db = new Database();

        // columnas disponibles
        $hasRoleDest = self::columnExists($db, 'anuncios', 'rol_destino');
        $hasUserId   = self::columnExists($db, 'anuncios', 'user_id');
        $hasCreated  = self::columnExists($db, 'anuncios', 'created_at');
        $hasUpdated  = self::columnExists($db, 'anuncios', 'updated_at');

        $cols = ['titulo','contenido'];
        $vals = [':t', ':c'];
        $params = [
            ':t' => $data['title']   ?? '',
            ':c' => $data['content'] ?? '',
        ];

        if ($hasRoleDest) { $cols[]='rol_destino'; $vals[]=':tr'; $params[':tr'] = $data['target_role'] ?? 'all'; }
        if ($hasUserId)   { $cols[]='user_id';     $vals[]=':uid'; $params[':uid']= $data['user_id']     ?? null; }
        if ($hasCreated)  { $cols[]='created_at';  $vals[]='NOW()'; }
        if ($hasUpdated)  { $cols[]='updated_at';  $vals[]='NOW()'; }

        $sql = "INSERT INTO anuncios (".implode(',', $cols).") VALUES (".implode(',', $vals).")";
        return $db->query($sql, $params)->rowCount() > 0;
    }

    public function update(array $data): bool
    {
        $db = $this->db;

        $hasRoleDest = self::columnExists($db, 'anuncios', 'rol_destino');
        $hasUpdated  = self::columnExists($db, 'anuncios', 'updated_at');

        $sets = ["titulo = :t", "contenido = :c"];
        $params = [
            ':t'  => $data['title']   ?? $this->title   ?? '',
            ':c'  => $data['content'] ?? $this->content ?? '',
            ':id' => $this->id,
        ];

        if ($hasRoleDest) { $sets[] = "rol_destino = :tr"; $params[':tr'] = $data['target_role'] ?? ($this->target_role ?? 'all'); }
        if ($hasUpdated)  { $sets[] = "updated_at = NOW()"; }

        $sql = "UPDATE anuncios SET ".implode(', ', $sets)." WHERE id = :id";
        return $db->query($sql, $params)->rowCount() >= 0;
    }

    public function delete(): bool
    {
        return $this->db->query("DELETE FROM anuncios WHERE id = :id", [':id'=>$this->id])->rowCount() > 0;
    }
}
