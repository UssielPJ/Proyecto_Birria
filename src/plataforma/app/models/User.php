<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class User {
    private $db;
    public $id;
    public $name;
    public $email;
    public $password;
    public $role_id;
    public $status;
    public $created_at;
    public $matricula;
    public $semestre;
    public $carrera;
    public $num_empleado;
    public $departamento;

    public function __construct() {
        $this->db = new Database();
    }

    public function getRoleIdBySlug($slug) {
        $this->db->query("SELECT id FROM roles WHERE slug = ?", [$slug]);
        $result = $this->db->fetch();
        return $result ? $result->id : null;
    }

    public function count() {
        $this->db->query("SELECT COUNT(*) FROM users");
        return $this->db->fetchColumn();
    }

    public function countByRole($role) {
        $this->db->query("SELECT COUNT(*) FROM users u JOIN roles r ON u.role_id = r.id WHERE r.slug = ?", [$role]);
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
        $query = "SELECT r.slug as role, COUNT(*) as count
                  FROM users u
                  JOIN roles r ON u.role_id = r.id
                  GROUP BY r.slug";
        $this->db->query($query);
        $results = $this->db->fetchAll();

        // Transformar los resultados
        $transformedResults = [];
        foreach ($results as $result) {
            $transformedResults[] = (object)[
                'role' => $result->role,
                'count' => $result->count
            ];
        }

        return $transformedResults;
    }

    public function findById($id) {
        $this->db->query("SELECT * FROM users WHERE id = ?", [$id]);
        $user = $this->db->fetch();
        error_log("User::findById - Query result for id '$id': " . ($user ? 'Found' : 'Not found'));
        return $user;
    }

    public function getStudentsByTeacher($teacherId) {
        // Note: enrollments table structure is different - using user_id instead of student_id
        // and carrera_id instead of course_id. For now, return empty array
        return [];
    }

    public function getRecentUsers($limit = 5) {
        $query = "SELECT u.*, r.slug as role FROM users u JOIN roles r ON u.role_id = r.id ORDER BY u.created_at DESC LIMIT ?";
        $this->db->query($query, [$limit]);
        return $this->db->fetchAll();
    }

    public function getRecentByRole($role, $limit = 5) {
        $query = "SELECT u.* FROM users u JOIN roles r ON u.role_id = r.id WHERE r.slug = ? ORDER BY u.created_at DESC LIMIT ?";
        $this->db->query($query, [$role, $limit]);
        return $this->db->fetchAll();
    }

    public function getByRole($role) {
        $query = "SELECT u.* FROM users u JOIN roles r ON u.role_id = r.id WHERE r.slug = ?";
        $this->db->query($query, [$role]);
        return $this->db->fetchAll();
    }

    public function create($data) {
        $roleSlug = $data['role'] ?? 'alumno';
        $roleId = $this->getRoleIdBySlug($roleSlug);
        $query = "INSERT INTO users (name, email, password, role_id, status, created_at)
                  VALUES (?, ?, ?, ?, 'active', NOW())";
        $this->db->query($query, [
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $roleId
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
        // Get user with role from database
        $this->db->query("SELECT u.*, r.slug as role FROM users u JOIN roles r ON u.role_id = r.id WHERE u.id = ?", [$userId]);
        $user = $this->db->fetch();

        // Return the role slug
        if ($user && !empty($user->role)) {
            error_log("User::getUserRoles - Role: " . $user->role);
            return [$user->role];
        }

        error_log("User::getUserRoles - No role found for user ID: " . $userId);
        return [];
    }

    public function countPendingRegistrations() {
        $this->db->query("SELECT COUNT(*) FROM users WHERE status = 'inactive'");
        return $this->db->fetchColumn();
    }

    public function countPendingSolicitudes() {
        $this->db->query("SELECT COUNT(*) FROM solicitudes WHERE estado = 'pendiente'");
        return $this->db->fetchColumn();
    }

    public function countIncompleteDocuments() {
        $this->db->query("SELECT COUNT(*) FROM solicitudes WHERE documentos_completos = FALSE");
        return $this->db->fetchColumn();
    }

    public function getStudentsWithFilters($filters = []) {
        $where = ["r.slug = 'alumno'"];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "(u.name LIKE :search OR u.email LIKE :search OR u.matricula LIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['semestre'])) {
            $where[] = "u.semestre = :semestre";
            $params[':semestre'] = $filters['semestre'];
        }

        if (!empty($filters['carrera'])) {
            $where[] = "u.carrera = :carrera";
            $params[':carrera'] = $filters['carrera'];
        }

        if (!empty($filters['estado'])) {
            $where[] = "u.status = :estado";
            $params[':estado'] = $filters['estado'];
        }

        $whereClause = implode(' AND ', $where);
        $limit = $filters['limit'] ?? 10;
        $offset = $filters['offset'] ?? 0;

        $query = "SELECT u.* FROM users u JOIN roles r ON u.role_id = r.id WHERE $whereClause ORDER BY u.name ASC LIMIT $limit OFFSET $offset";
        $this->db->query($query, $params);
        return $this->db->fetchAll();
    }

    public function countStudentsWithFilters($filters = []) {
        $where = ["r.slug = 'alumno'"];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "(u.name LIKE :search OR u.email LIKE :search OR u.matricula LIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['semestre'])) {
            $where[] = "u.semestre = :semestre";
            $params[':semestre'] = $filters['semestre'];
        }

        if (!empty($filters['carrera'])) {
            $where[] = "u.carrera = :carrera";
            $params[':carrera'] = $filters['carrera'];
        }

        if (!empty($filters['estado'])) {
            $where[] = "u.status = :estado";
            $params[':estado'] = $filters['estado'];
        }

        $whereClause = implode(' AND ', $where);
        $query = "SELECT COUNT(*) FROM users u JOIN roles r ON u.role_id = r.id WHERE $whereClause";
        $this->db->query($query, $params);
        return $this->db->fetchColumn();
    }

    public function getDistinctCarreras(): array {
        $this->db->query("SELECT DISTINCT carrera FROM users WHERE carrera IS NOT NULL AND carrera != '' ORDER BY carrera");
        return $this->db->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getDistinctSemestres(): array {
        $this->db->query("SELECT DISTINCT semestre FROM users WHERE semestre IS NOT NULL AND semestre != '' ORDER BY semestre");
        return $this->db->fetchAll(PDO::FETCH_COLUMN, 0);
    }

    public function getTeachersWithFilters($filters = []) {
        $where = ["r.slug = 'maestro'"];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "(u.name LIKE :search OR u.email LIKE :search OR u.num_empleado LIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['departamento'])) {
            $where[] = "u.departamento = :departamento";
            $params[':departamento'] = $filters['departamento'];
        }

        if (!empty($filters['estado'])) {
            $where[] = "u.status = :estado";
            $params[':estado'] = $filters['estado'];
        }

        $whereClause = implode(' AND ', $where);
        $limit = $filters['limit'] ?? 10;
        $offset = $filters['offset'] ?? 0;

        $query = "SELECT u.* FROM users u JOIN roles r ON u.role_id = r.id WHERE $whereClause ORDER BY u.name ASC LIMIT $limit OFFSET $offset";
        $this->db->query($query, $params);
        return $this->db->fetchAll();
    }

    public function countTeachersWithFilters($filters = []) {
        $where = ["r.slug = 'maestro'"];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "(u.name LIKE :search OR u.email LIKE :search OR u.num_empleado LIKE :search)";
            $params[':search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['departamento'])) {
            $where[] = "u.departamento = :departamento";
            $params[':departamento'] = $filters['departamento'];
        }

        if (!empty($filters['estado'])) {
            $where[] = "u.status = :estado";
            $params[':estado'] = $filters['estado'];
        }

        $whereClause = implode(' AND ', $where);
        $query = "SELECT COUNT(*) FROM users u JOIN roles r ON u.role_id = r.id WHERE $whereClause";
        $this->db->query($query, $params);
        return $this->db->fetchColumn();
    }

    public function getDistinctDepartamentos() {
        $this->db->query("SELECT DISTINCT departamento FROM users WHERE departamento IS NOT NULL AND departamento != '' ORDER BY departamento");
        return $this->db->fetchAll(PDO::FETCH_COLUMN, 0);
    }

}
