<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class MateriaGrupo {
    private Database $db;
    public function __construct() { $this->db = new Database(); }

public function attach(int $materia_id, int $grupo_id): bool {
    if ($this->exists($materia_id, $grupo_id)) return true;

    $codigo = $this->db->query(
        "SELECT CONCAT(m.clave,'-',g.codigo)
         FROM materias m, grupos g
         WHERE m.id=? AND g.id=?", [$materia_id, $grupo_id]
    )->fetchColumn();

    $sql = "INSERT INTO materias_grupos (materia_id, grupo_id, codigo) VALUES (?, ?, ?)";
    $this->db->query($sql, [$materia_id, $grupo_id, $codigo]);
    return true;
}


    public function detach(int $materia_id, int $grupo_id): bool {
        $sql = "DELETE FROM materias_grupos WHERE materia_id=? AND grupo_id=?";
        $this->db->query($sql, [$materia_id, $grupo_id]);
        return true;
    }

    public function exists(int $materia_id, int $grupo_id): bool {
        $sql = "SELECT 1 FROM materias_grupos WHERE materia_id=? AND grupo_id=? LIMIT 1";
        $stmt = $this->db->query($sql, [$materia_id, $grupo_id]);
        return (bool)$stmt->fetchColumn();
    }

    public function forGrupo(int $grupo_id): array {
        $sql = "SELECT m.id, m.clave, m.nombre
                FROM materias_grupos mg
                JOIN materias m ON m.id = mg.materia_id
                WHERE mg.grupo_id=?
                ORDER BY m.nombre";
        return $this->db->query($sql, [$grupo_id])->fetchAll(PDO::FETCH_OBJ);
    }

    public function forMateria(int $materia_id): array {
        $sql = "SELECT g.id, g.codigo, g.titulo
                FROM materias_grupos mg
                JOIN grupos g ON g.id = mg.grupo_id
                WHERE mg.materia_id=?
                ORDER BY g.codigo";
        return $this->db->query($sql, [$materia_id])->fetchAll(PDO::FETCH_OBJ);
    }
}
