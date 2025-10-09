<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Setting {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function get($key): ?string {
        $this->db->query("SELECT value FROM settings WHERE `key` = ?", [$key]);
        $result = $this->db->fetch();
        return $result ? $result->value : null;
    }

    public function set($key, $value) {
        // Check if the setting already exists
        $this->db->query("SELECT COUNT(*) FROM settings WHERE `key` = ?", [$key]);
        if ($this->db->fetchColumn() > 0) {
            // Update existing setting
            $this->db->query("UPDATE settings SET value = ? WHERE `key` = ?", [$value, $key]);
        } else {
            // Insert new setting
            $this->db->query("INSERT INTO settings (`key`, value) VALUES (?, ?)", [$key, $value]);
        }
        return $this->db->rowCount() > 0;
    }

    public function getAll() {
        $this->db->query("SELECT * FROM settings");
        return $this->db->fetchAll();
    }
}