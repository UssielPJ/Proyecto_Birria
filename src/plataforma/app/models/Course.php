<?php

namespace App\Models;

use App\Core\Database;
use PDO;

/**
 * Course Model
 *
 * Handles all database operations related to courses/materias
 */
class Course {
    private $db;

    /**
     * Constructor - Initialize database connection
     */
    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Get total count of courses
     *
     * @return int Total number of courses
     */
    public function count() {
        $this->db->query("SELECT COUNT(*) FROM courses");
        return $this->db->fetchColumn();
    }

    /**
     * Get count of active courses
     *
     * @return int Number of active courses
     */
    public function countActive() {
        return $this->countByStatus('active');
    }

    /**
     * Get count of courses by status
     *
     * @param string $status Course status ('active' or 'inactive')
     * @return int Number of courses with the specified status
     */
    public function countByStatus($status) {
        $this->db->query("SELECT COUNT(*) FROM courses WHERE status = ?", [$status]);
        return $this->db->fetchColumn();
    }

    /**
     * Get courses that a student is currently enrolled in
     *
     * @param int $studentId Student ID
     * @return array List of courses the student is enrolled in
     */
    public function getCurrentByStudent($studentId): array {
        try {
            // Get student's user_id from alumnos table
            $this->db->query("SELECT u.id as user_id FROM users u JOIN alumnos a ON u.email = a.email WHERE a.id = ?", [$studentId]);
            $studentUser = $this->db->fetch();

            if (!$studentUser) {
                return [];
            }

            // Get courses from enrollments table
            $this->db->query("
                SELECT c.*, u.name as teacher_name
                FROM courses c
                JOIN enrollments e ON c.id = e.course_id
                LEFT JOIN users u ON c.teacher_id = u.id
                WHERE e.student_id = ? AND c.estado = 'activa'
                ORDER BY c.name
            ", [$studentUser['user_id']]);

            return $this->db->fetchAll();
        } catch (\Exception $e) {
            error_log("Error getting courses for student: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get courses taught by a specific teacher
     *
     * @param int $teacherId Teacher ID
     * @return array List of courses taught by the teacher
     */
    public function getByTeacher($teacherId) {
        // Note: courses table uses 'estado' column instead of 'status', and 'activa' instead of 'active'
        $this->db->query("
            SELECT c.*, 0 as student_count
            FROM courses c
            WHERE c.teacher_id = ? AND c.estado = 'activa'
        ", [$teacherId]);
        return $this->db->fetchAll();
    }

    /**
     * Get all active courses with teacher and enrollment information
     *
     * @return array List of active courses
     */
    public function getActiveCourses() {
        // Note: enrollments table structure is different - using user_id instead of student_id
        // and carrera_id instead of course_id. For now, return courses without student count
        $this->db->query("
            SELECT c.*, u.name as teacher_name, 0 as student_count
            FROM courses c
            LEFT JOIN users u ON c.teacher_id = u.id
            WHERE c.estado = 'activa'
        ");
        return $this->db->fetchAll();
    }

    /**
     * Create a new course
     *
     * @param array $data Course data (supports both English and Spanish field names)
     * @return bool True on success, false on failure
     */
    public function create($data) {
        $this->db->query("
            INSERT INTO courses (name, code, teacher_id, schedule, status, creditos, horas_semana, departamento, semestre, tipo, modalidad, estado, descripcion, objetivo, prerrequisitos, created_at)
            VALUES (?, ?, ?, ?, 'active', ?, ?, ?, ?, ?, ?, 'activa', ?, ?, ?, NOW())
        ", [
            $data['name'] ?? $data['nombre'],
            $data['code'] ?? $data['codigo'],
            $data['teacher_id'] ?? $data['profesor_id'],
            $data['schedule'] ?? '',
            $data['creditos'] ?? 0,
            $data['horas_semana'] ?? 0,
            $data['departamento'] ?? '',
            $data['semestre'] ?? 1,
            $data['tipo'] ?? 'obligatoria',
            $data['modalidad'] ?? 'presencial',
            $data['descripcion'] ?? '',
            $data['objetivo'] ?? '',
            $data['prerrequisitos'] ?? ''
        ]);
        return $this->db->rowCount() > 0;
    }

    /**
     * Update an existing course
     *
     * @param int $id Course ID
     * @param array $data Updated course data (supports both English and Spanish field names)
     * @return bool True on success, false on failure
     */
    public function update($id, $data) {
        $fields = [];
        $values = [];

        // Map Spanish field names to English if needed
        $fieldMapping = [
            'nombre' => 'name',
            'codigo' => 'code',
            'profesor_id' => 'teacher_id'
        ];

        foreach ($data as $key => $value) {
            $dbKey = $fieldMapping[$key] ?? $key;
            $fields[] = "$dbKey = ?";
            $values[] = $value;
        }

        $values[] = $id;
        $query = "UPDATE courses SET " . implode(', ', $fields) . " WHERE id = ?";
        $this->db->query($query, $values);
        return $this->db->rowCount() > 0;
    }

    /**
     * Soft delete a course (set status to inactive)
     *
     * @param int $id Course ID
     * @return bool True on success, false on failure
     */
    public function delete($id) {
        $this->db->query("UPDATE courses SET status = 'inactive' WHERE id = ?", [$id]);
        return $this->db->rowCount() > 0;
    }

    /**
     * Find course by ID
     *
     * @param int $id Course ID
     * @return array|null Course data or null if not found
     */
    public function findById($id) {
        $this->db->query("SELECT * FROM courses WHERE id = ?", [$id]);
        return $this->db->fetch();
    }

    /**
     * Find course by code
     *
     * @param string $code Course code
     * @return array|null Course data or null if not found
     */
    public function getByCode($code) {
        $this->db->query("SELECT * FROM courses WHERE code = ?", [$code]);
        return $this->db->fetch();
    }

    /**
     * Get students enrolled in a course
     *
     * @param int $courseId Course ID
     * @return array List of enrolled students
     */
    public function getStudents($courseId) {
        try {
            $this->db->query("
                SELECT u.id, u.name, u.email
                FROM users u
                JOIN enrollments e ON u.id = e.student_id
                WHERE e.course_id = ? AND u.role = 'student'
                ORDER BY u.name
            ", [$courseId]);

            return $this->db->fetchAll();
        } catch (\Exception $e) {
            error_log("Error getting students for course: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get all courses with teacher information
     *
     * @return array List of all courses
     */
    public function getAll() {
        $this->db->query("
            SELECT c.*, u.name as teacher_name
            FROM courses c
            LEFT JOIN users u ON c.teacher_id = u.id
            ORDER BY c.name
        ");
        return $this->db->fetchAll();
    }

    /**
     * Get recent courses (by creation date)
     *
     * @param int $limit Number of courses to return
     * @return array List of recent courses
     */
    public function getRecent($limit = 5) {
        $this->db->query("
            SELECT c.*, u.name as teacher_name
            FROM courses c
            LEFT JOIN users u ON c.teacher_id = u.id
            ORDER BY c.id DESC
            LIMIT ?
        ", [$limit]);
        return $this->db->fetchAll();
    }

    /**
     * Enroll a student in a course
     *
     * @param int $courseId Course ID
     * @param int $studentId Student ID
     * @return bool True on success, false on failure
     */
    public function enrollStudent($courseId, $studentId) {
        try {
            // Check if student is already enrolled
            $this->db->query("SELECT id FROM enrollments WHERE course_id = ? AND student_id = ?", [$courseId, $studentId]);
            if ($this->db->fetch()) {
                return true; // Already enrolled
            }

            // Enroll student
            $this->db->query("INSERT INTO enrollments (course_id, student_id) VALUES (?, ?)", [$courseId, $studentId]);
            return $this->db->rowCount() > 0;
        } catch (\Exception $e) {
            error_log("Error enrolling student: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Unenroll a student from a course
     *
     * @param int $courseId Course ID
     * @param int $studentId Student ID
     * @return bool True on success, false on failure
     */
    public function unenrollStudent($courseId, $studentId) {
        // Note: enrollments table structure is different - using user_id instead of student_id
        // and carrera_id instead of course_id. For now, return false
        return false;
    }

    /**
     * Count pending schedule change requests
     *
     * @return int Number of pending schedule changes (currently returns 0 as table doesn't exist)
     */
    public function countPendingScheduleChanges() {
        // Como la tabla schedule_change_requests no existe, devolvemos 0 para evitar errores
        return 0;
    }

    /**
     * Get upcoming classes with schedule information
     *
     * @param int $limit Number of classes to return
     * @return array List of upcoming classes
     */
    public function getUpcomingClasses($limit = 5) {
        $this->db->query("
            SELECT c.*, u.name as teacher_name, s.day_of_week, s.start_time, s.end_time, r.name as room_name
            FROM courses c
            LEFT JOIN users u ON c.teacher_id = u.id
            LEFT JOIN schedules s ON c.id = s.course_id
            LEFT JOIN rooms r ON s.room_id = r.id
            WHERE c.estado = 'activa'
            ORDER BY s.day_of_week, s.start_time
            LIMIT ?
        ", [$limit]);
        return $this->db->fetchAll();
    }

    /**
     * Get students enrolled in courses taught by a specific teacher
     *
     * @param int $teacherId Teacher ID
     * @return array List of students enrolled in teacher's courses
     */
    public function getStudentsByTeacher($teacherId) {
        try {
            $this->db->query("
                SELECT DISTINCT u.id, u.name, u.email, u.matricula, u.carrera, u.semestre,
                               COUNT(e.course_id) as enrolled_courses
                FROM users u
                JOIN enrollments e ON u.id = e.student_id
                JOIN courses c ON e.course_id = c.id
                WHERE c.teacher_id = ? AND u.role_id = 3
                GROUP BY u.id, u.name, u.email, u.matricula, u.carrera, u.semestre
                ORDER BY u.name
            ", [$teacherId]);

            return $this->db->fetchAll();
        } catch (\Exception $e) {
            error_log("Error getting students by teacher: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Validate course data before creation/update
     *
     * @param array $data Course data to validate
     * @return array Array with 'valid' boolean and 'errors' array
     */
    public function validate($data) {
        $errors = [];

        if (empty($data['name'] ?? $data['nombre'])) {
            $errors[] = 'Course name is required';
        }

        if (empty($data['code'] ?? $data['codigo'])) {
            $errors[] = 'Course code is required';
        } else {
            // Check if code already exists (for new courses or updates)
            $existing = $this->getByCode($data['code'] ?? $data['codigo']);
            if ($existing && (!isset($data['id']) || $existing['id'] != $data['id'])) {
                $errors[] = 'Course code already exists';
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
}
