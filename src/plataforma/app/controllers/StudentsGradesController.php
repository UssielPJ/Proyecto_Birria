<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;
use App\Models\Grade;

class StudentGradesController
{
    /* ----------------- Guards ----------------- */
    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/login');
            exit;
        }
    }

    private function requireRole(array $roles) {
        $this->requireLogin();
        $userRoles = $_SESSION['user']['roles'] ?? [];
        foreach ($roles as $r) {
            if (in_array($r, $userRoles, true)) {
                return;
            }
        }
        header('Location: /src/plataforma/login');
        exit;
    }

    /* ============= Vista alumno: Mis calificaciones ============= */
    public function index(): void
    {
        $this->requireRole(['student']);

        $user = $_SESSION['user'] ?? null;
        if (!$user || empty($user['id'])) {
            header('Location: /src/plataforma/login');
            exit;
        }

        $studentUserId = (int)$user['id'];

        $gradeModel = new Grade();
        $db         = new Database();

        /* --------- 1) Calificaciones del alumno (detalle) --------- */
        $grades  = $gradeModel->getAllByStudentUserId($studentUserId);
        $avgData = $gradeModel->getAverageByStudentUserId($studentUserId);

        $stats = [
            'total_grades'  => is_array($grades) ? count($grades) : 0,
            'average_grade' => isset($avgData['average']) ? (float)$avgData['average'] : 0.0,
        ];

        /* --------- 2) Datos del alumno para el encabezado --------- */
        $studentInfo = [];
        try {
            $db->query("
                SELECT 
                    sp.*,
                    c.nombre AS career_name
                FROM student_profiles sp
                LEFT JOIN carreras c ON c.id = sp.carrera_id
                WHERE sp.user_id = ?
                LIMIT 1
            ", [$studentUserId]);

            $row = $db->fetch();
            if ($row) {
                $studentInfo = is_array($row) ? $row : (array)$row;
            }
        } catch (\Throwable $e) {
            error_log('Error cargando student_profiles: ' . $e->getMessage());
            $studentInfo = [];
        }

        /* --------- 3) Materias dinámicas por grupo --------- */
        $subjects = [];
        try {
            $db->query("
                SELECT DISTINCT
                    m.id,
                    m.nombre AS name
                FROM student_profiles sp
                INNER JOIN materias_grupos mg ON mg.grupo_id = sp.grupo_id
                INNER JOIN materias        m ON m.id = mg.materia_id
                WHERE sp.user_id = ?
                ORDER BY m.nombre ASC
            ", [$studentUserId]);

            $subjects = $db->fetchAll() ?: [];
        } catch (\Throwable $e) {
            error_log('Error cargando materias del alumno: ' . $e->getMessage());
            $subjects = [];
        }

        /* --------- 4) Apartados desde activity_types --------- */
        $activityTypes = [];
        try {
            $db->query("
                SELECT 
                    id,
                    name  AS label,
                    slug,
                    weight_percent
                FROM activity_types
                ORDER BY name ASC
            ");
            $activityTypes = $db->fetchAll() ?: [];
        } catch (\Throwable $e) {
            error_log('Error cargando activity_types: ' . $e->getMessage());
            $activityTypes = [];
        }

        /* --------- 5) Parciales (1–3) --------- */
        $partials = [
            ['value' => '1', 'label' => 'Parcial 1'],
            ['value' => '2', 'label' => 'Parcial 2'],
            ['value' => '3', 'label' => 'Parcial 3'],
        ];

        /* --------- 6) Promedios por parcial (para la tabla de arriba) --------- */
        $partialRows = $gradeModel->getPartialAveragesByStudentUserId($studentUserId);

        $partialWeightedMatrix = [];
        foreach ($partialRows as $rowRaw) {
            $r = is_array($rowRaw) ? $rowRaw : (array)$rowRaw;

            $subject = $r['materia']
                ?? ($r['course_name'] ?? null)
                ?? ($r['subject_name'] ?? null)
                ?? '';

            $parcial = isset($r['parcial'])
                ? (string)$r['parcial']
                : (isset($r['partial']) ? (string)$r['partial'] : '');

            $avg = isset($r['promedio']) ? (float)$r['promedio'] : null;

            if ($subject === '' || $parcial === '' || $avg === null) {
                continue;
            }

            if (!isset($partialWeightedMatrix[$subject])) {
                $partialWeightedMatrix[$subject] = [];
            }
            $partialWeightedMatrix[$subject][$parcial] = $avg;
        }

        // Orden de materias para la tabla de arriba
        $summarySubjectsOrder = [];
        foreach ($subjects as $s) {
            $name = is_array($s)
                ? ($s['name'] ?? $s['materia'] ?? $s['nombre'] ?? '')
                : ($s->name ?? $s->materia ?? $s->nombre ?? '');
            if ($name !== '' && !in_array($name, $summarySubjectsOrder, true)) {
                $summarySubjectsOrder[] = $name;
            }
        }
        foreach (array_keys($partialWeightedMatrix) as $subjName) {
            if (!in_array($subjName, $summarySubjectsOrder, true)) {
                $summarySubjectsOrder[] = $subjName;
            }
        }

        /* --------- 7) Promedio detallado por filtros (tabla de abajo) --------- */

        // 7.1 Leer filtros desde GET
        $selectedSubjectId  = isset($_GET['subject_id']) && $_GET['subject_id'] !== ''
            ? (int)$_GET['subject_id']
            : null;

        $selectedPartial    = isset($_GET['partial']) && $_GET['partial'] !== ''
            ? (int)$_GET['partial']
            : null;

        $selectedActivity   = $_GET['activity_type'] ?? '';
        $selectedActivityId = null;

        if ($selectedActivity !== '') {
            // Buscamos el id real en $activityTypes (puede venir slug o id)
            foreach ($activityTypes as $t) {
                $row  = is_array($t) ? $t : (array)$t;
                $id   = isset($row['id'])   ? (int)$row['id']   : null;
                $slug = $row['slug'] ?? null;

                if ($id !== null && (string)$id === $selectedActivity) {
                    $selectedActivityId = $id;
                    break;
                }
                if ($slug !== null && $slug === $selectedActivity) {
                    $selectedActivityId = $id;
                    break;
                }
            }
        }

        // 7.2 Obtener promedios según filtros
        $filteredAverages = $gradeModel->getFilteredAveragesByStudentUserId(
            $studentUserId,
            $selectedSubjectId,
            $selectedPartial,
            $selectedActivityId
        );

        /* --------- 8) Render --------- */
        View::render('student/grades/index', 'student', [
            'grades'                => $grades,
            'stats'                 => $stats,
            'subjects'              => $subjects,
            'activityTypes'         => $activityTypes,
            'partials'              => $partials,
            'studentInfo'           => $studentInfo,
            'partialWeightedMatrix' => $partialWeightedMatrix,
            'summarySubjectsOrder'  => $summarySubjectsOrder,
            'filteredAverages'      => $filteredAverages,
        ]);
    }
}
