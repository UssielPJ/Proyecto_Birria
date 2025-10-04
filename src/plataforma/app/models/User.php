<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function count() {
        $this->db->query("SELECT COUNT(*) FROM users");
        return $this->db->fetchColumn();
    }

    public function countByRole($role) {
        $this->db->query("SELECT COUNT(*) FROM users WHERE role = ?", [$role]);
        return $this->db->fetchColumn();
    }

    public function getMonthlyRegistrations() {
        $query = "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count
                 FROM users
                 GROUP BY month
                 ORDER BY month DESC
                 LIMIT 12";
        $this->db->query($query);
        return $this->db->fetchAll();
    }

    public function getRoleDistribution() {
        $query = "SELECT role, COUNT(*) as count
                 FROM users
                 GROUP BY role";
        $this->db->query($query);
        return $this->db->fetchAll();
    }

    public function findById($id) {
        $this->db->query("SELECT * FROM users WHERE id = ?", [$id]);
        $user = $this->db->fetch();
        error_log("User::findById - Query result for id '$id': " . ($user ? 'Found' : 'Not found'));
        return $user;
    }

    public function getStudentsByTeacher($teacherId) {
        $query = "SELECT DISTINCT u.* FROM users u
                 JOIN enrollments e ON u.id = e.student_id
                 JOIN courses c ON e.course_id = c.id
                 WHERE c.teacher_id = ? AND u.role = 'student'";
        $this->db->query($query, [$teacherId]);
        return $this->db->fetchAll();
    }

    public function getRecentUsers($limit = 5) {
        $query = "SELECT * FROM users ORDER BY created_at DESC LIMIT ?";
        $this->db->query($query, [$limit]);
        return $this->db->fetchAll();
    }

    public function create($data) {
        $query = "INSERT INTO users (name, email, password, role, created_at)
                 VALUES (?, ?, ?, ?, NOW())";
        $this->db->query($query, [
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role']
        ]);
        return $this->db->rowCount() > 0;
    }

    public function update($id, $data) {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            if ($key === 'password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        
        $values[] = $id;
        $query = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $this->db->query($query, $values);
        return $this->db->rowCount() > 0;
    }

    public function delete($id) {
        $this->db->query("DELETE FROM users WHERE id = ?", [$id]);
        return $this->db->rowCount() > 0;
    }

    public function findByEmail($email): mixed {
        $this->db->query("SELECT * FROM users WHERE email = ?", [$email]);
        $result = $this->db->fetch();
        error_log("User::findByEmail - Query result for email '$email': " . ($result ? 'Found' : 'Not found'));
        return $result;
    }

    public function validateCredentials($email, $password) {
        $user = $this->findByEmail($email);
        if (!$user) {
            return false;
        }
        return password_verify($password, $user->password);
    }

    public function getDb() {
        return $this->db;
    }

    public function getUserRoles($userId) {
        // Get user from database
        $user = $this->findById($userId);

        // Return the role from the user table
        if ($user && !empty($user->role_id)) {
            // Translate role IDs to match the expected values in the code
            $roleTranslation = [
                1 => 'admin',
                2 => 'teacher',
                3 => 'student',
                4 => 'capturista'
            ];

            $roleId = $user->role_id;
            error_log("User::getUserRoles - Original role ID: " . $roleId);

            if (isset($roleTranslation[$roleId])) {
                $translatedRole = $roleTranslation[$roleId];
                error_log("User::getUserRoles - Translated role: " . $translatedRole);
                return [$translatedRole];
            }

            error_log("User::getUserRoles - No translation found for role ID: " . $roleId);
            return [];
        }

        error_log("User::getUserRoles - No role found for user ID: " . $userId);
        return [];
    }

    public function countPendingRegistrations() {
        $this->db->query("SELECT COUNT(*) FROM users WHERE status = 'pending'");
        return $this->db->fetchColumn();
    }

}
