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

    /* ==========================================================
     * MÉTODOS ORIGINALES (basados en tabla grades) - LEGACY
     * Los dejo por compatibilidad con otros módulos que quizá
     * aún usen la tabla grades. Si ya no la usas, luego los
     * puedes limpiar.
     * ========================================================== */

    public function getRecentByStudent($studentId, $limit = 5): array {
        try {
            $this->db->query("SELECT u.id as user_id 
                              FROM users u 
                              JOIN alumnos a ON u.email = a.email 
                              WHERE a.id = ?", [$studentId]);
            $studentUser = $this->db->fetch();

            if (!$studentUser) {
                return [];
            }

            $this->db->query("
                SELECT g.id, g.grade, g.created_at, c.name as course_name
                FROM grades g
                JOIN assignments a ON g.assignment_id = a.id
                JOIN courses c     ON a.course_id = c.id
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
            $this->db->query("SELECT u.id as user_id 
                              FROM users u 
                              JOIN alumnos a ON u.email = a.email 
                              WHERE a.id = ?", [$studentId]);
            $studentUser = $this->db->fetch();

            if (!$studentUser) {
                return ['average' => 0, 'total' => 0];
            }

            $this->db->query("
                SELECT AVG(g.grade) as average, COUNT(*) as total
                FROM grades g
                JOIN assignments a ON g.assignment_id = a.id
                WHERE g.student_id = ?
            ", [$studentUser['user_id']]);

            $result = $this->db->fetch();

            return [
                'average' => $result ? (float)$result['average'] : 0,
                'total'   => $result ? (int)$result['total']   : 0
            ];
        } catch (\Exception $e) {
            error_log("Error getting average for student: " . $e->getMessage());
            return ['average' => 0, 'total' => 0];
        }
    }

    public function getPendingGrades() {
        try {
            $this->db->query("
                SELECT g.id, g.grade, g.comments as feedback, g.created_at,
                       u.name as student_name, u.email as student_email,
                       c.name as course_name, c.code as course_code
                FROM grades g
                JOIN users u     ON g.student_id  = u.id
                JOIN assignments a ON g.assignment_id = a.id
                JOIN courses c   ON a.course_id   = c.id
                ORDER BY g.created_at DESC
            ");
            return $this->db->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting pending grades: " . $e->getMessage());
            return [];
        }
    }

    public function getRecentByTeacher($teacherId, $limit = 5) {
        try {
            $this->db->query("
                SELECT g.id, g.grade, g.comments as feedback, g.created_at,
                       u.name as student_name, u.email as student_email,
                       c.name as course_name, c.code as course_code
                FROM grades g
                JOIN users u     ON g.student_id  = u.id
                JOIN assignments a ON g.assignment_id = a.id
                JOIN courses c   ON a.course_id   = c.id
                WHERE c.teacher_id = ?
                ORDER BY g.created_at DESC
                LIMIT ?
            ", [$teacherId, $limit]);

            return $this->db->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting recent grades for teacher: " . $e->getMessage());
            return [];
        }
    }

    public function countPendingUpdates() {
        try {
            $this->db->query("SELECT COUNT(*) as count FROM grades");
            $result = $this->db->fetch();
            return $result ? (int)$result['count'] : 0;
        } catch (PDOException $e) {
            error_log("Error counting pending updates: " . $e->getMessage());
            return 0;
        }
    }

    public function create($data) {
        try {
            $fields       = [];
            $placeholders = [];
            $values       = [];

            foreach ($data as $key => $value) {
                $fields[]       = $key;
                $placeholders[] = "?";
                $values[]       = $value;
            }

            $query = "INSERT INTO grades (" . implode(', ', $fields) . ") 
                      VALUES (" . implode(', ', $placeholders) . ")";
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
            $query    = "UPDATE grades SET " . implode(', ', $fields) . " WHERE id = ?";
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
            $this->db->query("
                SELECT g.id, g.grade, g.comments as feedback, g.created_at, 
                       g.assignment_id, g.student_id,
                       u.name as student_name, u.email as student_email,
                       c.name as course_name, c.code as course_code
                FROM grades g
                JOIN users u     ON g.student_id  = u.id
                JOIN assignments a ON g.assignment_id = a.id
                JOIN courses c   ON a.course_id   = c.id
                WHERE g.id = ?
            ", [$id]);
            return $this->db->fetch();
        } catch (PDOException $e) {
            error_log("Error finding grade by ID: " . $e->getMessage());
            return null;
        }
    }

    public function getAll() {
        try {
            $this->db->query("
                SELECT g.id, g.grade, g.comments as feedback, g.created_at,
                       u.name as student_name, u.email as student_email,
                       c.name as course_name, c.code as course_code
                FROM grades g
                JOIN users u     ON g.student_id  = u.id
                JOIN assignments a ON g.assignment_id = a.id
                JOIN courses c   ON a.course_id   = c.id
                ORDER BY g.created_at DESC
            ");
            return $this->db->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting all grades: " . $e->getMessage());
            return [];
        }
    }

    public function getByCourse($courseId) {
        try {
            $this->db->query("
                SELECT g.id, g.grade, g.comments as feedback, g.created_at,
                       u.name as student_name, u.email as student_email
                FROM grades g
                JOIN users u     ON g.student_id  = u.id
                JOIN assignments a ON g.assignment_id = a.id
                WHERE a.course_id = ?
                ORDER BY u.name ASC, g.created_at DESC
            ", [$courseId]);

            return $this->db->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting grades by course: " . $e->getMessage());
            return [];
        }
    }

    public function getAverageByCourse($courseId) {
        try {
            $this->db->query("
                SELECT AVG(g.grade)   as average,
                       COUNT(*)       as total,
                       MIN(g.grade)   as min_grade,
                       MAX(g.grade)   as max_grade,
                       STDDEV(g.grade) as std_dev
                FROM grades g
                JOIN assignments a ON g.assignment_id = a.id
                WHERE a.course_id = ?
            ", [$courseId]);

            $result = $this->db->fetch();

            return $result ? [
                'average'   => (float)$result['average'],
                'total'     => (int)$result['total'],
                'min_grade' => (float)$result['min_grade'],
                'max_grade' => (float)$result['max_grade'],
                'std_dev'   => (float)$result['std_dev'],
            ] : [
                'average'   => 0,
                'total'     => 0,
                'min_grade' => 0,
                'max_grade' => 0,
                'std_dev'   => 0,
            ];
        } catch (PDOException $e) {
            error_log("Error getting average grade by course: " . $e->getMessage());
            return [
                'average'   => 0,
                'total'     => 0,
                'min_grade' => 0,
                'max_grade' => 0,
                'std_dev'   => 0,
            ];
        }
    }

    public function publish($id) {
        try {
            // Sin status real, simplemente devolvemos true
            return true;
        } catch (PDOException $e) {
            error_log("Error publishing grade: " . $e->getMessage());
            return false;
        }
    }

    public function getByAcademicPeriod($periodId) {
        try {
            $this->db->query("
                SELECT g.id, g.grade, g.comments as feedback, g.created_at,
                       u.name as student_name, u.email as student_email,
                       c.name as course_name, c.code as course_code
                FROM grades g
                JOIN users u     ON g.student_id  = u.id
                JOIN assignments a ON g.assignment_id = a.id
                JOIN courses c   ON a.course_id   = c.id
                WHERE c.academic_period_id = ?
                ORDER BY c.name ASC, u.name ASC, g.created_at DESC
            ", [$periodId]);

            return $this->db->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting grades by academic period: " . $e->getMessage());
            return [];
        }
    }

    public function getGlobalAverage() {
        try {
            $this->db->query("SELECT AVG(g.grade) as average FROM grades g");
            $result = $this->db->fetch();
            return $result ? (float)$result['average'] : 0.0;
        } catch (PDOException $e) {
            error_log("Error getting global average: " . $e->getMessage());
            return 0.0;
        }
    }

    public function getPassedCount() {
        try {
            $this->db->query("SELECT COUNT(*) as count FROM grades WHERE grade >= 6.0");
            $result = $this->db->fetch();
            return $result ? (int)$result['count'] : 0;
        } catch (PDOException $e) {
            error_log("Error getting passed count: " . $e->getMessage());
            return 0;
        }
    }

    public function getFailedCount() {
        try {
            $this->db->query("SELECT COUNT(*) as count FROM grades WHERE grade < 6.0");
            $result = $this->db->fetch();
            return $result ? (int)$result['count'] : 0;
        } catch (PDOException $e) {
            error_log("Error getting failed count: " . $e->getMessage());
            return 0;
        }
    }

    /* ==========================================================
     *  NUEVOS MÉTODOS BASADOS EN task_submissions
     *  (lo que usa el alumno en su dashboard de calificaciones)
     * ========================================================== */
    /**
     * TODAS las calificaciones de un alumno (users.id) usando course_task_grades
     * Se usa en el panel de calificaciones del ALUMNO.
     */
    /**
     * Obtiene TODAS las calificaciones de un alumno usando users.id,
     * leyendo desde course_task_grades + course_tasks + materias + activity_types.
     */
    /**
     * Obtiene TODAS las calificaciones de un alumno usando users.id
     * Leyendo desde task_submissions (último intento por tarea)
     * y uniendo con course_tasks, activity_types, materias_grupos, materias.
     */
    public function getAllByStudentUserId(int $userId): array
    {
        try {
            $this->db->query("
                SELECT
                    ts.id,
                    ts.grade,
                    ts.feedback,
                    ts.graded_at,
                    ts.created_at,
                    ts.task_id,
                    ts.student_user_id,
                    ts.attempt_number,

                    -- Datos de la tarea
                    ct.title          AS task_title,
                    ct.parcial        AS parcial,
                    ct.total_points,
                    ct.weight_percent AS task_weight_percent,

                    -- Tipo / apartado
                    at.id             AS activity_type_id,
                    at.name           AS activity_type_label,
                    at.slug           AS activity_type_slug,
                    at.weight_percent AS activity_type_weight_percent,

                    -- Materia / grupo
                    m.id              AS materia_id,
                    m.nombre          AS materia,
                    mg.id             AS mg_id,
                    mg.grupo_id

                FROM task_submissions ts
                INNER JOIN (
                    SELECT 
                        task_id,
                        student_user_id,
                        MAX(attempt_number) AS max_attempt
                    FROM task_submissions
                    WHERE student_user_id = ?
                    GROUP BY task_id, student_user_id
                ) last_sub ON last_sub.task_id = ts.task_id
                          AND last_sub.student_user_id = ts.student_user_id
                          AND last_sub.max_attempt = ts.attempt_number

                INNER JOIN course_tasks    ct ON ts.task_id        = ct.id
                INNER JOIN activity_types  at ON ct.activity_type_id = at.id
                INNER JOIN materias_grupos mg ON ct.mg_id          = mg.id
                INNER JOIN materias        m  ON mg.materia_id     = m.id

                WHERE ts.student_user_id = ?
                  AND ts.grade IS NOT NULL

                ORDER BY 
                    m.nombre ASC,
                    ct.parcial ASC,
                    ct.title ASC,
                    ts.created_at DESC
            ", [$userId, $userId]);

            $rows = $this->db->fetchAll();
            if (!$rows) {
                return [];
            }

            // Normalizar a array asociativo por si Database devuelve stdClass
            $out = [];
            foreach ($rows as $r) {
                $out[] = is_array($r) ? $r : (array)$r;
            }
            return $out;
        } catch (PDOException $e) {
            error_log('Error getAllByStudentUserId (task_submissions): ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Promedio y total de calificaciones de un alumno usando users.id,
     * tomando el ÚLTIMO intento de cada tarea en task_submissions.
     */
    public function getAverageByStudentUserId(int $userId): array
    {
        try {
            $this->db->query("
                SELECT 
                    AVG(ts.grade) AS average,
                    COUNT(*)      AS total
                FROM task_submissions ts
                INNER JOIN (
                    SELECT 
                        task_id,
                        student_user_id,
                        MAX(attempt_number) AS max_attempt
                    FROM task_submissions
                    WHERE student_user_id = ?
                    GROUP BY task_id, student_user_id
                ) last_sub ON last_sub.task_id = ts.task_id
                          AND last_sub.student_user_id = ts.student_user_id
                          AND last_sub.max_attempt = ts.attempt_number
                WHERE ts.student_user_id = ?
                  AND ts.grade IS NOT NULL
            ", [$userId, $userId]);

            $row = $this->db->fetch();

            if (!$row) {
                return ['average' => 0.0, 'total' => 0];
            }

            // Normalizar por si viene como stdClass
            $row = is_array($row) ? $row : (array)$row;

            return [
                'average' => isset($row['average']) ? (float)$row['average'] : 0.0,
                'total'   => isset($row['total'])   ? (int)$row['total']   : 0,
            ];
        } catch (PDOException $e) {
            error_log('Error getAverageByStudentUserId (task_submissions): ' . $e->getMessage());
            return ['average' => 0.0, 'total' => 0];
        }
    }


    /**
     * Materias/cursos donde el alumno tiene calificaciones,
     * también basado en course_task_grades.
     */
    public function getCoursesByStudentUserId(int $userId): array
    {
        try {
            $this->db->query("
                SELECT DISTINCT
                    m.id,
                    m.nombre AS name
                FROM course_task_grades ctg
                INNER JOIN course_tasks      ct ON ctg.task_id        = ct.id
                INNER JOIN materias_grupos   mg ON ct.materia_grupo_id = mg.id
                INNER JOIN materias          m  ON mg.materia_id      = m.id
                WHERE ctg.student_user_id = ?
                ORDER BY m.nombre ASC
            ", [$userId]);

            $rows = $this->db->fetchAll();
            if (!$rows) {
                return [];
            }
            if (is_array($rows) && isset($rows[0]) && is_object($rows[0])) {
                return array_map(fn($r) => (array)$r, $rows);
            }
            return $rows;
        } catch (PDOException $e) {
            error_log('Error getCoursesByStudentUserId (ctg): ' . $e->getMessage());
            return [];
        }
    }
  
    /**
     * Promedios por materia y parcial para un alumno (usando course_task_grades)
     * Devuelve filas: materia, parcial, promedio
     */
    public function getPartialAveragesByStudentUserId(int $userId): array
    {
        try {
            $this->db->query("
                SELECT
                    m.nombre       AS materia,
                    ct.parcial     AS parcial,
                    CASE 
                        WHEN SUM(ct.weight_percent) > 0
                            THEN SUM(ctg.grade * ct.weight_percent) / SUM(ct.weight_percent)
                        ELSE AVG(ctg.grade)
                    END            AS promedio
                FROM course_task_grades ctg
                JOIN course_tasks       ct  ON ctg.task_id   = ct.id
                JOIN materias_grupos    mg  ON ct.mg_id      = mg.id
                JOIN materias           m   ON mg.materia_id = m.id
                WHERE ctg.student_user_id = ?
                  AND ctg.grade IS NOT NULL
                GROUP BY m.id, ct.parcial
                ORDER BY m.nombre ASC, ct.parcial ASC
            ", [$userId]);

            $rows = $this->db->fetchAll();
            return $rows ?: [];
        } catch (PDOException $e) {
            error_log('Error getPartialAveragesByStudentUserId: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Promedio (ponderado si hay pesos) de un alumno
     * filtrado por materia, parcial y tipo de actividad,
     * usando course_task_grades + course_tasks.
     *
     * @return array ['average' => float|null, 'count' => int]
     */
    public function getFilteredAverageForStudent(
        int $studentUserId,
        ?int $subjectId,
        ?int $partial,
        ?string $activityFilter
    ): array {
        try {
            $sql = "
                SELECT 
                    at.id              AS activity_type_id,
                    at.slug            AS activity_slug,
                    at.name            AS activity_name,
                    at.weight_percent  AS weight_percent,
                    AVG(ctg.grade)     AS avg_grade,
                    COUNT(*)           AS grade_count
                FROM course_task_grades ctg
                INNER JOIN course_tasks      ct  ON ctg.task_id = ct.id
                INNER JOIN materias_grupos   mg  ON ct.mg_id = mg.id
                INNER JOIN materias          m   ON mg.materia_id = m.id
                INNER JOIN activity_types    at  ON ct.activity_type_id = at.id
                WHERE ctg.student_user_id = ?
            ";

            $params = [$studentUserId];

            // Filtro por materia (m.id)
            if ($subjectId !== null) {
                $sql     .= " AND m.id = ?";
                $params[] = $subjectId;
            }

            // Filtro por parcial (ct.parcial)
            if ($partial !== null) {
                $sql     .= " AND ct.parcial = ?";
                $params[] = $partial;
            }

            // Filtro por tipo de actividad (slug o id)
            if ($activityFilter !== null && $activityFilter !== '') {
                $sql     .= " AND (at.slug = ? OR at.id = ?)";
                $params[] = $activityFilter;
                $params[] = (int)$activityFilter;
            }

            $sql .= "
                GROUP BY 
                    at.id,
                    at.slug,
                    at.name,
                    at.weight_percent
            ";

            $this->db->query($sql, $params);
            $rows = $this->db->fetchAll();

            if (!$rows) {
                return ['average' => null, 'count' => 0];
            }

            $sumWeighted   = 0.0;
            $totalWeights  = 0.0;
            $sumSimple     = 0.0;
            $typesCount    = 0;
            $gradesCount   = 0;

            foreach ($rows as $row) {
                // Soporta fetch como array o como stdClass
                $avg   = is_array($row) ? (float)$row['avg_grade']        : (float)$row->avg_grade;
                $wRaw  = is_array($row) ? ($row['weight_percent'] ?? 0)   : ($row->weight_percent ?? 0);
                $count = is_array($row) ? ($row['grade_count']    ?? 0)   : ($row->grade_count    ?? 0);

                $weight = (float)$wRaw;

                $sumSimple   += $avg;
                $typesCount  += 1;
                $gradesCount += (int)$count;

                if ($weight > 0) {
                    $sumWeighted  += $avg * ($weight / 100.0);
                    $totalWeights += $weight;
                }
            }

            if ($totalWeights > 0) {
                // Promedio ponderado
                $factor   = $totalWeights / 100.0;
                $average  = $sumWeighted / $factor;
            } elseif ($typesCount > 0) {
                // Sin pesos definidos → promedio simple de los tipos
                $average = $sumSimple / $typesCount;
            } else {
                $average = null;
            }

            return [
                'average' => $average,
                'count'   => $gradesCount,
            ];
        } catch (PDOException $e) {
            error_log('Error getFilteredAverageForStudent: ' . $e->getMessage());
            return ['average' => null, 'count' => 0];
        }
    }


        /**
     * Obtiene las calificaciones del alumno filtrando por:
     * - materia (m.id)
     * - parcial (course_tasks.parcial)
     * - apartado / tipo de actividad (activity_types.id o slug)
     *
     * Se usa course_task_grades como tabla de calificaciones finales.
     */
    public function getFilteredGradesByStudent(
        int $studentUserId,
        ?string $subjectId = '',
        ?string $partial = '',
        ?string $activityTypeValue = ''
    ): array {
        try {
            $sql = "
                SELECT
                    ctg.grade,
                    ct.parcial,
                    ct.title         AS task_title,
                    m.id             AS subject_id,
                    m.nombre         AS subject_name,
                    at.id            AS activity_type_id,
                    at.slug          AS activity_type_slug,
                    at.name          AS activity_type_label
                FROM course_task_grades ctg
                INNER JOIN course_tasks      ct ON ctg.task_id = ct.id
                INNER JOIN materias_grupos   mg ON ct.mg_id   = mg.id
                INNER JOIN materias          m  ON mg.materia_id = m.id
                INNER JOIN activity_types    at ON ct.activity_type_id = at.id
                WHERE ctg.student_user_id = ?
            ";

            $params = [$studentUserId];

            // Filtro por materia (m.id)
            if (!empty($subjectId)) {
                $sql     .= " AND m.id = ? ";
                $params[] = (int)$subjectId;
            }

            // Filtro por parcial (ct.parcial)
            if (!empty($partial)) {
                $sql     .= " AND ct.parcial = ? ";
                $params[] = (int)$partial;
            }

            // Filtro por tipo de actividad (id o slug)
            if (!empty($activityTypeValue)) {
                if (ctype_digit($activityTypeValue)) {
                    // Es un id numérico
                    $sql     .= " AND at.id = ? ";
                    $params[] = (int)$activityTypeValue;
                } else {
                    // Es un slug
                    $sql     .= " AND at.slug = ? ";
                    $params[] = $activityTypeValue;
                }
            }

            $sql .= "
                ORDER BY
                    m.nombre ASC,
                    ct.parcial ASC,
                    at.name ASC,
                    ct.title ASC
            ";

            $this->db->query($sql, $params);
            $rows = $this->db->fetchAll();

            return $rows ?: [];
        } catch (PDOException $e) {
            error_log('Error getFilteredGradesByStudent: ' . $e->getMessage());
            return [];
        }
    }


    

        /**
     * Promedios filtrados por alumno (detalle inferior):
     * materia + parcial + tipo de actividad.
     *
     * @param int      $studentUserId  users.id del alumno
     * @param int|null $subjectId      materias.id (null = todas)
     * @param int|null $partial        número de parcial (null = todos)
     * @param int|null $activityTypeId activity_types.id (null = todos)
     * @return array
     */
    public function getFilteredAveragesByStudentUserId(
        int $studentUserId,
        ?int $subjectId,
        ?int $partial,
        ?int $activityTypeId
    ): array {
        try {
            $sql = "
                SELECT
                    m.nombre       AS subject_name,
                    ct.parcial     AS parcial,
                    at.name        AS activity_type_label,
                    AVG(ctg.grade) AS promedio
                FROM course_task_grades ctg
                INNER JOIN course_tasks     ct ON ctg.task_id          = ct.id
                INNER JOIN materias_grupos  mg ON ct.mg_id            = mg.id
                INNER JOIN materias         m  ON mg.materia_id       = m.id
                INNER JOIN activity_types   at ON ct.activity_type_id = at.id
                WHERE ctg.student_user_id = ?
            ";

            $params = [$studentUserId];

            // Filtro por materia
            if (!empty($subjectId)) {
                $sql      .= " AND m.id = ? ";
                $params[] = (int)$subjectId;
            }

            // Filtro por parcial
            if (!empty($partial)) {
                $sql      .= " AND ct.parcial = ? ";
                $params[] = (int)$partial;
            }

            // Filtro por tipo de actividad
            if (!empty($activityTypeId)) {
                $sql      .= " AND at.id = ? ";
                $params[] = (int)$activityTypeId;
            }

            $sql .= "
                GROUP BY m.id, ct.parcial, at.id
                ORDER BY m.nombre ASC, ct.parcial ASC, at.name ASC
            ";

            $this->db->query($sql, $params);
            $rows = $this->db->fetchAll() ?: [];

            // Normalizar a array asociativo (por si viene como stdClass)
            if (!empty($rows) && !is_array($rows[0])) {
                $rows = array_map(
                    static fn($r) => (array)$r,
                    $rows
                );
            }

            return $rows;
        } catch (\PDOException $e) {
            error_log('Error getFilteredAveragesByStudentUserId: ' . $e->getMessage());
            return [];
        }
    }

}
