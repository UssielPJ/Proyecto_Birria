<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Announcement {
    private $db;
    private $id;
    private $title;
    private $content;
    private $user_id;
    private $target_role;
    private $created_at;
    private $author_name;

    public function __construct() {
        $this->db = new Database();
    }

    public static function all() {
        $db = new Database();
        $db->query("SELECT a.*, u.name as author_name FROM announcements a LEFT JOIN users u ON a.user_id = u.id");
        return $db->fetchAll();
    }

    public static function getByRole($role) {
        $db = new Database();
        $db->query("SELECT a.*, u.name as author_name FROM announcements a LEFT JOIN users u ON a.user_id = u.id WHERE a.target_role = 'all' OR a.target_role = ?", [$role]);
        return $db->fetchAll();
    }

    public static function find($id) {
        $db = new Database();
        $db->query("SELECT a.*, u.name as author_name FROM announcements a LEFT JOIN users u ON a.user_id = u.id WHERE a.id = ?", [$id]);
        $result = $db->fetch();
        if ($result) {
            $announcement = new self();
            $announcement->id = $result->id;
            $announcement->title = $result->title;
            $announcement->content = $result->content;
            $announcement->user_id = $result->user_id;
            $announcement->target_role = $result->target_role;
            $announcement->created_at = $result->created_at;
            $announcement->author_name = $result->author_name;
            return $announcement;
        }
        return null;
    }

    public static function create($data) {
        $db = new Database();
        $db->query("INSERT INTO announcements (title, content, user_id, target_role, created_at) VALUES (?, ?, ?, ?, NOW())", [
            $data['title'],
            $data['content'],
            $data['user_id'],
            $data['target_role'] ?? 'all'
        ]);
        return $db->rowCount() > 0;
    }

    public function update($data) {
        $fields = [];
        $values = [];

        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }

        $values[] = $this->id;
        $query = "UPDATE announcements SET " . implode(', ', $fields) . " WHERE id = ?";
        $this->db->query($query, $values);
        return $this->db->rowCount() > 0;
    }

    public function delete() {
        $this->db->query("DELETE FROM announcements WHERE id = ?", [$this->id]);
        return $this->db->rowCount() > 0;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getContent() { return $this->content; }
    public function getUserId() { return $this->user_id; }
    public function getTargetRole() { return $this->target_role; }
    public function getCreatedAt() { return $this->created_at; }
    public function getAuthorName() { return $this->author_name ?? null; }
}