<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Course {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function count() {
        $this->db->query("SELECT COUNT(*) FROM courses");
        return $this->db->fetchColumn();
    }

    public function countActive() {
        $this->db->query("SELECT COUNT(*) FROM courses WHERE status = 'active'");
        return $this->db->fetchColumn();
    }

    public function getCurrentByStudent($studentId) {
        $this->db->query("
            SELECT c.*, u.name as teacher_name
            FROM courses c
            INNER JOIN enrollments e ON c.id = e.course_id
            INNER JOIN users u ON c.teacher_id = u.id
            WHERE e.student_id = ? AND c.status = 'active'
        ", [$studentId]);
        return $this->db->fetchAll();
    }

    public function getByTeacher($teacherId) {
        $this->db->query("
            SELECT c.*, COUNT(e.id) as student_count
            FROM courses c
            LEFT JOIN enrollments e ON c.id = e.course_id
            WHERE c.teacher_id = ? AND c.status = 'active'
            GROUP BY c.id
        ", [$teacherId]);
        return $this->db->fetchAll();
    }

    public function getActiveCourses() {
        $this->db->query("
            SELECT c.*, u.name as teacher_name, COUNT(e.student_id) as student_count
            FROM courses c
            LEFT JOIN users u ON c.teacher_id = u.id
            LEFT JOIN enrollments e ON c.id = e.course_id
            WHERE c.status = 'active'
            GROUP BY c.id
        ");
        return $this->db->fetchAll();
    }

    public function create($data) {
        $this->db->query("
            INSERT INTO courses (name, code, teacher_id, schedule, status, created_at)
            VALUES (?, ?, ?, ?, 'active', NOW())
        ", [
            $data['name'],
            $data['code'],
            $data['teacher_id'],
            $data['schedule']
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
        $query = "UPDATE courses SET " . implode(', ', $fields) . " WHERE id = ?";
        $this->db->query($query, $values);
        return $this->db->rowCount() > 0;
    }

    public function delete($id) {
        $this->db->query("UPDATE courses SET status = 'inactive' WHERE id = ?", [$id]);
        return $this->db->rowCount() > 0;
    }

    public function findById($id) {
        $this->db->query("SELECT * FROM courses WHERE id = ?", [$id]);
        return $this->db->fetch();
    }

    public function enrollStudent($courseId, $studentId) {
        $this->db->query("
            INSERT INTO enrollments (course_id, student_id, enrolled_at)
            VALUES (?, ?, NOW())
        ", [$courseId, $studentId]);
        return $this->db->rowCount() > 0;
    }

    public function unenrollStudent($courseId, $studentId) {
        $this->db->query("DELETE FROM enrollments WHERE course_id = ? AND student_id = ?", [$courseId, $studentId]);
        return $this->db->rowCount() > 0;
    }

    public function countPendingScheduleChanges() {
        $this->db->query("SELECT COUNT(*) FROM schedule_change_requests WHERE status = 'pending'");
        return $this->db->fetchColumn();
    }
}
