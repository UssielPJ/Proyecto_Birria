<?php

namespace App\Models;

use App\Core\Database;

class Notification {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getUnreadNotifications($userId) {
        $query = "SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC";
        return $this->db->query($query, [$userId])->fetchAll();
    }

    public function getAllNotifications($userId) {
        $query = "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
        return $this->db->query($query, [$userId])->fetchAll();
    }

    public function markAsRead($notificationId, $userId) {
        $query = "UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?";
        return $this->db->query($query, [$notificationId, $userId]);
    }

    public function markAllAsRead($userId) {
        $query = "UPDATE notifications SET is_read = 1 WHERE user_id = ?";
        return $this->db->query($query, [$userId]);
    }

    public function create($userId, $title, $message, $type = 'info') {
        $query = "INSERT INTO notifications (user_id, title, message, type) VALUES (?, ?, ?, ?)";
        return $this->db->query($query, [$userId, $title, $message, $type]);
    }

    public function getUnreadCount($userId) {
        $query = "SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND is_read = 0";
        $result = $this->db->query($query, [$userId])->fetch();
        return $result->count;
    }
}