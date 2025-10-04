<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Grade {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getRecentByStudent($studentId) {
        $this->db->query("
            SELECT g.*, a.name as assignment_name, c.name as course_name
            FROM grades g
            JOIN assignments a ON g.assignment_id = a.id
            JOIN courses c ON a.course_id = c.id
            WHERE g.student_id = ?
            ORDER BY g.created_at DESC
            LIMIT 5
        ", [$studentId]);
        return $this->db->fetchAll();
    }

    public function getAverageByStudent($studentId) {
        $this->db->query("
            SELECT AVG(grade) as average
            FROM grades g
            JOIN assignments a ON g.assignment_id = a.id
            JOIN courses c ON a.course_id = c.id
            WHERE g.student_id = ? AND c.status = 'active'
        ", [$studentId]);
        $result = $this->db->fetch();
        return $result ? $result->average : 0;
    }

    public function getPendingGrades() {
        $this->db->query("
            SELECT a.*, c.name as course_name, COUNT(e.student_id) as pending_count
            FROM assignments a
            JOIN courses c ON a.course_id = c.id
            JOIN enrollments e ON c.id = e.course_id
            LEFT JOIN grades g ON a.id = g.assignment_id AND e.student_id = g.student_id
            WHERE g.id IS NULL AND a.due_date < NOW()
            GROUP BY a.id
        ");
        return $this->db->fetchAll();
    }

    public function getRecentByTeacher($teacherId, $limit = 5) {
        $this->db->query("
            SELECT g.*, u.name as student_name, a.name as assignment_name, c.name as course_name
            FROM grades g
            JOIN assignments a ON g.assignment_id = a.id
            JOIN courses c ON a.course_id = c.id
            JOIN users u ON g.student_id = u.id
            WHERE c.teacher_id = ?
            ORDER BY g.created_at DESC
            LIMIT ?
        ", [$teacherId, $limit]);
        return $this->db->fetchAll();
    }

    public function countPendingUpdates() {
        $this->db->query("
            SELECT COUNT(*) as count
            FROM grade_update_requests
            WHERE status = 'pending'
        ");
        $result = $this->db->fetch();
        return $result ? $result->count : 0;
    }

    public function create($data) {
        $this->db->query("
            INSERT INTO grades (student_id, assignment_id, grade, comments, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ", [
            $data['student_id'],
            $data['assignment_id'],
            $data['grade'],
            $data['comments'] ?? null
        ]);
        return $this->db->rowCount() > 0;
    }

    public function update($id, $data) {
        $fields = [];
        $values = [];

        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }

        $values[] = $id;
        $query = "UPDATE grades SET " . implode(', ', $fields) . " WHERE id = ?";
        $this->db->query($query, $values);
        return $this->db->rowCount() > 0;
    }

    public function delete($id) {
        $this->db->query("DELETE FROM grades WHERE id = ?", [$id]);
        return $this->db->rowCount() > 0;
    }

    public function findById($id) {
        $this->db->query("SELECT * FROM grades WHERE id = ?", [$id]);
        return $this->db->fetch();
    }
}
