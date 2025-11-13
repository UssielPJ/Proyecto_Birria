<?php
namespace App\Models;

use App\Core\Database;

class ActivityType
{
    private Database $db;
    private string $table = 'activity_types';

    public function __construct(?Database $db = null)
    {
        $this->db = $db ?? new Database();
    }

    /** Lista todos los tipos de actividad (para selects, etc.) */
    public function getAll(): array
    {
        $sql = "SELECT id, name, slug, default_weight, default_max_attempts, created_at
                FROM {$this->table}
                ORDER BY name ASC";
        $this->db->query($sql);
        return $this->db->fetchAll() ?: [];
    }

    /** Devuelve un tipo por id */
    public function findById(int $id): ?object
    {
        $sql = "SELECT id, name, slug, default_weight, default_max_attempts, created_at
                FROM {$this->table}
                WHERE id = :id";
        $this->db->query($sql, [':id' => $id]);
        return $this->db->fetch() ?: null;
    }

    /** Buscar por slug (ej. 'exam', 'project', etc.) */
    public function findBySlug(string $slug): ?object
    {
        $sql = "SELECT id, name, slug, default_weight, default_max_attempts, created_at
                FROM {$this->table}
                WHERE slug = :slug";
        $this->db->query($sql, [':slug' => $slug]);
        return $this->db->fetch() ?: null;
    }

    /** Para selects tipo [id => "Examen (10%)"] */
    public function getForSelect(): array
    {
        $rows = $this->getAll();
        $out  = [];
        foreach ($rows as $r) {
            $label = $r->name;
            if ($r->default_weight > 0) {
                $label .= ' ('.(float)$r->default_weight.'%)';
            }
            $out[$r->id] = $label;
        }
        return $out;
    }
}
