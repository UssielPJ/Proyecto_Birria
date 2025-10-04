<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Grade {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getRecentByStudent($studentId, $limit = 5): array {
        try {
            // Get student's user_id from alumnos table
            $this->db->query("SELECT u.id as user_id FROM users u JOIN alumnos a ON u.email = a.email WHERE a.id = ?", [$studentId]);
            $studentUser = $this->db->fetch();

            if (!$studentUser) {
                return [];
            }

            // Get grades from grades table
            $this->db->query("
                SELECT g.id, g.grade, g.created_at, c.name as course_name
                FROM grades g
                JOIN assignments a ON g.assignment_id = a.id
                JOIN courses c ON a.course_id = c.id
                WHERE g.student_id = ?
                ORDER BY g.created_at DESC
                LIMIT ?
            ", [$studentUser['user_id'], $limit]);

            return $this->db->fetchAll();
        } catch (\Exception $e) {
            error_log("Error getting grades for student: " . $e->getMessage());
            return [];
        }
    }

    public function getAverageByStudent($studentId): array {
        try {
            // Get student's user_id from alumnos table
            $this->db->query("SELECT u.id as user_id FROM users u JOIN alumnos a ON u.email = a.email WHERE a.id = ?", [$studentId]);
            $studentUser = $this->db->fetch();

            if (!$studentUser) {
                return ['average' => 0, 'total' => 0];
            }

            // Get average from grades table
            $this->db->query("
                SELECT AVG(g.grade) as average, COUNT(*) as total
                FROM grades g
                JOIN assignments a ON g.assignment_id = a.id
                WHERE g.student_id = ?
            ", [$studentUser['user_id']]);

            $result = $this->db->fetch();

            return [
                'average' => $result ? (float)$result['average'] : 0,
                'total' => $result ? (int)$result['total'] : 0
            ];
        } catch (\Exception $e) {
            error_log("Error getting average for student: " . $e->getMessage());
            return ['average' => 0, 'total' => 0];
        }
    }

    public function getPendingGrades() {
        try {
            $this->db->query("SELECT g.id, g.grade, g.comments as feedback, g.created_at,
                                    u.name as student_name, u.email as student_email,
                                    c.name as course_name, c.code as course_code
                             FROM grades g
                             JOIN users u ON g.student_id = u.id
                             JOIN assignments a ON g.assignment_id = a.id
                             JOIN courses c ON a.course_id = c.id
                             ORDER BY g.created_at DESC");
            return $this->db->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting pending grades: " . $e->getMessage());
            return [];
        }
    }

    public function getRecentByTeacher($teacherId, $limit = 5) {
        try {
            $this->db->query("SELECT g.id, g.grade, g.comments as feedback, g.created_at,
                                    u.name as student_name, u.email as student_email,
                                    c.name as course_name, c.code as course_code
                             FROM grades g
                             JOIN users u ON g.student_id = u.id
                             JOIN assignments a ON g.assignment_id = a.id
                             JOIN courses c ON a.course_id = c.id
                             WHERE c.teacher_id = ?
                             ORDER BY g.created_at DESC
                             LIMIT ?", [$teacherId, $limit]);
            return $this->db->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting recent grades for teacher: " . $e->getMessage());
            return [];
        }
    }

    public function countPendingUpdates() {
        try {
            // Since no status column, return 0 or count all grades as pending
            $this->db->query("SELECT COUNT(*) as count FROM grades");
            $result = $this->db->fetch();
            return $result ? (int)$result->count : 0;
        } catch (PDOException $e) {
            error_log("Error counting pending updates: " . $e->getMessage());
            return 0;
        }
    }

    public function create($data) {
        try {
            $fields = [];
            $placeholders = [];
            $values = [];

            foreach ($data as $key => $value) {
                $fields[] = $key;
                $placeholders[] = "?";
                $values[] = $value;
            }

            $query = "INSERT INTO grades (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")";
            $this->db->query($query, $values);
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating grade: " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $data) {
        try {
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
        } catch (PDOException $e) {
            error_log("Error updating grade: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $this->db->query("DELETE FROM grades WHERE id = ?", [$id]);
            return $this->db->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Error deleting grade: " . $e->getMessage());
            return false;
        }
    }

    public function findById($id) {
        try {
            $this->db->query("SELECT g.id, g.grade, g.comments as feedback, g.created_at, g.assignment_id, g.student_id,
                                    u.name as student_name, u.email as student_email,
                                    c.name as course_name, c.code as course_code
                             FROM grades g
                             JOIN users u ON g.student_id = u.id
                             JOIN assignments a ON g.assignment_id = a.id
                             JOIN courses c ON a.course_id = c.id
                             WHERE g.id = ?", [$id]);
            return $this->db->fetch();
        } catch (PDOException $e) {
            error_log("Error finding grade by ID: " . $e->getMessage());
            return null;
        }
    }

    public function getAll() {
        try {
            $this->db->query("SELECT g.id, g.grade, g.comments as feedback, g.created_at,
                                    u.name as student_name, u.email as student_email,
                                    c.name as course_name, c.code as course_code
                             FROM grades g
                             JOIN users u ON g.student_id = u.id
                             JOIN assignments a ON g.assignment_id = a.id
                             JOIN courses c ON a.course_id = c.id
                             ORDER BY g.created_at DESC");
            return $this->db->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting all grades: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get grades by course
     * @param int $courseId
     * @return array
     */
    public function getByCourse($courseId) {
        try {
            $this->db->query("SELECT g.id, g.grade, g.comments as feedback, g.created_at,
                                    u.name as student_name, u.email as student_email
                             FROM grades g
                             JOIN users u ON g.student_id = u.id
                             JOIN assignments a ON g.assignment_id = a.id
                             WHERE a.course_id = ?
                             ORDER BY u.name ASC, g.created_at DESC", [$courseId]);
            return $this->db->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting grades by course: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get average grade by course
     * @param int $courseId
     * @return array
     */
    public function getAverageByCourse($courseId) {
        try {
            $this->db->query("SELECT AVG(g.grade) as average, COUNT(*) as total,
                                    MIN(g.grade) as min_grade, MAX(g.grade) as max_grade,
                                    STDDEV(g.grade) as std_dev
                             FROM grades g
                             JOIN assignments a ON g.assignment_id = a.id
                             WHERE a.course_id = ?", [$courseId]);
            $result = $this->db->fetch();
            return $result ? [
                'average' => (float)$result['average'],
                'total' => (int)$result['total'],
                'min_grade' => (float)$result['min_grade'],
                'max_grade' => (float)$result['max_grade'],
                'std_dev' => (float)$result['std_dev']
            ] : [
                'average' => 0,
                'total' => 0,
                'min_grade' => 0,
                'max_grade' => 0,
                'std_dev' => 0
            ];
        } catch (PDOException $e) {
            error_log("Error getting average grade by course: " . $e->getMessage());
            return [
                'average' => 0,
                'total' => 0,
                'min_grade' => 0,
                'max_grade' => 0,
                'std_dev' => 0
            ];
        }
    }

    /**
     * Publish a grade
     * @param int $id
     * @return bool
     */
    public function publish($id) {
        try {
            // Since no status column, just return true
            return true;
        } catch (PDOException $e) {
            error_log("Error publishing grade: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get grades by academic period
     * @param int $periodId
     * @return array
     */
    public function getByAcademicPeriod($periodId) {
        try {
            $this->db->query("SELECT g.id, g.grade, g.comments as feedback, g.created_at,
                                    u.name as student_name, u.email as student_email,
                                    c.name as course_name, c.code as course_code
                             FROM grades g
                             JOIN users u ON g.student_id = u.id
                             JOIN assignments a ON g.assignment_id = a.id
                             JOIN courses c ON a.course_id = c.id
                             WHERE c.academic_period_id = ?
                             ORDER BY c.name ASC, u.name ASC, g.created_at DESC", [$periodId]);
            return $this->db->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting grades by academic period: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get global average grade
     * @return float
     */
    public function getGlobalAverage() {
        try {
            $this->db->query("SELECT AVG(g.grade) as average FROM grades g");
            $result = $this->db->fetch();
            return $result ? (float)$result->average : 0.0;
        } catch (PDOException $e) {
            error_log("Error getting global average: " . $e->getMessage());
            return 0.0;
        }
    }

    /**
     * Get count of passed grades (assuming passing grade is 6.0)
     * @return int
     */
    public function getPassedCount() {
        try {
            $this->db->query("SELECT COUNT(*) as count FROM grades WHERE grade >= 6.0");
            $result = $this->db->fetch();
            return $result ? (int)$result->count : 0;
        } catch (PDOException $e) {
            error_log("Error getting passed count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get count of failed grades (assuming failing grade is < 6.0)
     * @return int
     */
    public function getFailedCount() {
        try {
            $this->db->query("SELECT COUNT(*) as count FROM grades WHERE grade < 6.0");
            $result = $this->db->fetch();
            return $result ? (int)$result->count : 0;
        } catch (PDOException $e) {
            error_log("Error getting failed count: " . $e->getMessage());
            return 0;
        }
    }
}
