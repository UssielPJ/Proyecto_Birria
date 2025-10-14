<?php
namespace App\Models;

use App\Core\Database;

class Departamento {
    private Database $db;
    public function __construct() { $this->db = new Database(); }

    /** Devuelve id y nombre de departamentos activos ordenados por nombre */
    public function allActive(): array {
        $sql = "SELECT id, nombre 
                FROM departamentos 
                WHERE status = 'activo'
                ORDER BY nombre ASC";
        $this->db->query($sql);
        return $this->db->fetchAll();
    }
}
