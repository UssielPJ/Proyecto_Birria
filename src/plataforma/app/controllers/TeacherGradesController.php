<?php
// app/controllers/TeacherGradesController.php

namespace App\Controllers;

use App\Core\View;
use App\Core\Database;
use PDO;

class TeacherGradesController
{
    /** Usuario actual (ajusta si tu auth es distinto) */
    private static function currentUser(): ?array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        return $_SESSION['user'] ?? null;
    }

    /** GET /src/plataforma/app/teacher/grades */
    public function index(): void
    {
        $user = self::currentUser();
        if (!$user) {
            header('Location: /src/plataforma/login');
            exit;
        }

        // En tu sesión sueles guardar el id de user
        $teacherUserId = (int)($user['id'] ?? 0); // AJUSTA si tu campo es otro

        $db = new Database();

        // Filtros desde la URL
        $groupId   = isset($_GET['group_id'])   ? (int)$_GET['group_id']   : null;
        $subjectId = isset($_GET['subject_id']) ? (int)$_GET['subject_id'] : null;
        $partialId = isset($_GET['partial_id']) ? (int)$_GET['partial_id'] : null;

        /* ==================== 1) Grupos del docente ==================== */
        // Usamos grupos.codigo y grupos.titulo para armar el nombre
        $groups = $db->query("
            SELECT DISTINCT 
                g.id,
                CONCAT(
                    g.codigo,
                    IF(g.titulo IS NULL OR g.titulo = '', '', CONCAT(' · ', g.titulo))
                ) AS nombre
            FROM materia_grupo_profesor mgp
            INNER JOIN materias_grupos mg ON mgp.mg_id = mg.id
            INNER JOIN grupos g           ON mg.grupo_id = g.id
            WHERE mgp.teacher_user_id = :t
            ORDER BY nombre
        ", ['t' => $teacherUserId])->fetchAll(PDO::FETCH_ASSOC);


        /* ==================== 2) Materias del docente para ese grupo ==================== */
        $subjects = [];
        if ($groupId) {
            $subjects = $db->query("
                SELECT DISTINCT
                    m.id,
                    m.nombre
                FROM materia_grupo_profesor mgp
                INNER JOIN materias_grupos mg ON mgp.mg_id = mg.id
                INNER JOIN materias m         ON mg.materia_id = m.id
                WHERE mgp.teacher_user_id = :t
                  AND mg.grupo_id         = :g
                ORDER BY m.nombre
            ", [
                't' => $teacherUserId,
                'g' => $groupId,
            ])->fetchAll(PDO::FETCH_ASSOC);
        }

        /* ==================== 3) Parciales ==================== */
        $partials = [
            ['id' => 1, 'label' => 'Parcial 1'],
            ['id' => 2, 'label' => 'Parcial 2'],
            ['id' => 3, 'label' => 'Parcial 3'],
        ];

        $students       = [];
        $activities     = [];
        $existingGrades = [];

        /* ==================== 4) Si ya eligió grupo + materia + parcial ==================== */
        if ($groupId && $subjectId && $partialId) {

            // 4.1 Encontrar el materias_grupos.id (mg_id) para esa combinación
            $mgRow = $db->query("
                SELECT mg.id
                FROM materias_grupos mg
                WHERE mg.grupo_id   = :g
                  AND mg.materia_id = :m
                LIMIT 1
            ", [
                'g' => $groupId,
                'm' => $subjectId,
            ])->fetch(PDO::FETCH_ASSOC);

            $mgId = $mgRow['id'] ?? null;

            if ($mgId) {
                /* 4.2 Alumnos del grupo (solo con student_profiles por ahora) */
                $students = $db->query("
                    SELECT 
                        sp.user_id AS id,
                        sp.matricula,
                        CONCAT('Alumno ', sp.matricula) AS nombre
                    FROM student_profiles sp
                    WHERE sp.grupo_id = :g
                    ORDER BY sp.matricula
                ", ['g' => $groupId])->fetchAll(PDO::FETCH_ASSOC);


                /* 4.3 Actividades (course_tasks) de ese mg + parcial */
                $activities = $db->query("
                    SELECT
                        ct.id,
                        ct.title          AS nombre,
                        ct.weight_percent AS peso,
                        ct.due_at
                    FROM course_tasks ct
                    WHERE ct.mg_id   = :mg
                      AND ct.parcial = :p
                    ORDER BY ct.due_at ASC, ct.id ASC
                ", [
                    'mg' => $mgId,
                    'p'  => $partialId,
                ])->fetchAll(PDO::FETCH_ASSOC);

                /* 4.4 Calificaciones existentes: primero course_task_grades, luego task_submissions */
                if (!empty($students) && !empty($activities)) {
                    $studentIds  = array_column($students, 'id');   // user_id de student_profiles
                    $activityIds = array_column($activities, 'id'); // id de course_tasks

                    $inStu = implode(',', array_fill(0, count($studentIds), '?'));
                    $inAct = implode(',', array_fill(0, count($activityIds), '?'));
                    $params = array_merge($studentIds, $activityIds);

                    $existingGrades = [];

                    /* 4.4.1 Calificaciones finales manuales (course_task_grades) */
                    $sqlGrades = "
                        SELECT 
                            ctg.student_user_id,
                            ctg.task_id,
                            ctg.grade
                        FROM course_task_grades ctg
                        WHERE ctg.student_user_id IN ($inStu)
                        AND ctg.task_id         IN ($inAct)
                    ";

                    $stmt = $db->query($sqlGrades, $params);
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $r) {
                        $sid = (int)$r['student_user_id'];
                        $aid = (int)$r['task_id'];
                        $existingGrades[$sid][$aid] = [
                            'grade' => (float)$r['grade'],
                        ];
                    }

                    /* 4.4.2 Si no hay override en course_task_grades, tomar la ÚLTIMA entrega de task_submissions */
            $sqlSubs = "
                SELECT 
                    ts.student_user_id,
                    ts.task_id,
                    ts.grade
                FROM task_submissions ts
                WHERE ts.student_user_id IN ($inStu)
                AND ts.task_id         IN ($inAct)
                AND ts.grade IS NOT NULL
                AND ts.attempt_number = (
                    SELECT MAX(ts2.attempt_number)
                    FROM task_submissions ts2
                    WHERE ts2.task_id         = ts.task_id
                        AND ts2.student_user_id = ts.student_user_id
                        AND ts2.grade IS NOT NULL
                )
            ";

            $stmt2 = $db->query($sqlSubs, $params);
            $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows2 as $r) {
                $sid = (int)$r['student_user_id'];
                $aid = (int)$r['task_id'];

                // Solo rellenamos si NO hay override manual en course_task_grades
                if (!isset($existingGrades[$sid][$aid])) {
                    $existingGrades[$sid][$aid] = [
                        'grade' => (float)$r['grade'],
                    ];
                }
            }
        }

            }
        }

        /* ==================== Render de la vista ==================== */
        View::render('teacher/grades/index', 'teacher', [
            'user'          => $user,
            'groups'        => $groups,
            'subjects'      => $subjects,
            'partials'      => $partials,
            'students'      => $students,
            'activities'    => $activities,
            'existingGrades'=> $existingGrades,
            'currentFilter' => [
                'group_id'   => $groupId,
                'subject_id' => $subjectId,
                'partial_id' => $partialId,
            ],
        ]);
    }

public function save(): void
{
    $user = self::currentUser();
    if (!$user) {
        header('Location: /src/plataforma/login');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /src/plataforma/app/teacher/grades');
        exit;
    }

    $db = new Database();

    // Filtros para volver a la misma pantalla
    $groupId   = isset($_POST['group_id'])   ? (int)$_POST['group_id']   : 0;
    $subjectId = isset($_POST['subject_id']) ? (int)$_POST['subject_id'] : 0;
    $partialId = isset($_POST['partial_id']) ? (int)$_POST['partial_id'] : 0;

    // Matriz de calificaciones: grades[student_user_id][task_id] = valor
    $grades = $_POST['grades'] ?? [];

    // ============================================
    // 1) Guardar por actividad en course_task_grades
    // ============================================
    $sqlUpsert = "
        INSERT INTO course_task_grades (
            task_id,
            student_user_id,
            grade,
            graded_at,
            created_at,
            updated_at
        ) VALUES (
            :task_id,
            :student_user_id,
            :grade,
            NOW(),
            NOW(),
            NOW()
        )
        ON DUPLICATE KEY UPDATE
            grade        = VALUES(grade),
            graded_at    = VALUES(graded_at),
            updated_at   = VALUES(updated_at)
    ";

    // Para saber a qué alumnos les tocamos algo
    $touchedStudents = [];

    foreach ($grades as $studentUserId => $activities) {
        $studentUserId = (int)$studentUserId;
        if ($studentUserId <= 0 || !is_array($activities)) {
            continue;
        }

        foreach ($activities as $taskId => $gradeRaw) {
            // Si está vacío, no tocamos esa celda
            if ($gradeRaw === '' || $gradeRaw === null) {
                continue;
            }

            $gradeRaw = str_replace(',', '.', (string)$gradeRaw);
            if (!is_numeric($gradeRaw)) {
                continue;
            }

            $grade  = (float)$gradeRaw;
            $taskId = (int)$taskId;

            // Rango básico 0–100, ajusta si usas otro
            if ($grade < 0 || $grade > 100) {
                continue;
            }

            $db->query($sqlUpsert, [
                'task_id'         => $taskId,
                'student_user_id' => $studentUserId,
                'grade'           => $grade,
            ]);

            $touchedStudents[$studentUserId] = true;
        }
    }

    // ============================================
    // 2) Si tenemos filtros válidos, recalcular parcial en student_calif
    // ============================================
    $teacherId = (int)($user['id'] ?? 0);

    if ($groupId > 0 && $subjectId > 0 && $partialId > 0 && $teacherId > 0 && !empty($touchedStudents)) {

        // 2.1 Resolver mg_id asegurando que el curso sea de este maestro
        $db->query("
            SELECT mg.id
            FROM materias_grupos mg
            JOIN materia_grupo_profesor mgp ON mgp.mg_id = mg.id
            WHERE mg.grupo_id         = :gid
              AND mg.materia_id       = :mid
              AND mgp.teacher_user_id = :tid
            LIMIT 1
        ", [
            ':gid' => $groupId,
            ':mid' => $subjectId,
            ':tid' => $teacherId,
        ]);
        $mgRow = $db->fetch();
        if ($mgRow) {
            $mgId = (int)$mgRow->id;

            // 2.2 Recalcular por cada alumno tocado
            foreach (array_keys($touchedStudents) as $stuId) {
                $studentId = (int)$stuId;
                if ($studentId <= 0) continue;

                // Traer TODAS las actividades del parcial para ese alumno con su tipo y peso
                $db->query("
                    SELECT 
                        g.grade,
                        ct.id                AS task_id,
                        ct.activity_type_id  AS type_id,
                        at.partial_weight_percent,
                        at.slug,
                        at.name
                    FROM course_task_grades g
                    JOIN course_tasks ct      ON ct.id = g.task_id
                    JOIN activity_types at    ON at.id = ct.activity_type_id
                    WHERE g.student_user_id = :stu
                      AND ct.mg_id         = :mg
                      AND ct.parcial       = :parcial
                ", [
                    ':stu'     => $studentId,
                    ':mg'      => $mgId,
                    ':parcial' => $partialId,
                ]);

                $rows = $db->fetchAll() ?? [];
                if (empty($rows)) {
                    continue;
                }

                // Agrupar por tipo de actividad
                $byType     = [];
                $activities = [];

                foreach ($rows as $r) {
                    $grade = (float)$r->grade;

                    $typeId = (int)$r->type_id;
                    if (!isset($byType[$typeId])) {
                        $byType[$typeId] = [
                            'sum'        => 0.0,
                            'count'      => 0,
                            'weightType' => (float)$r->partial_weight_percent,
                            'slug'       => (string)$r->slug,
                            'name'       => (string)$r->name,
                        ];
                    }

                    $byType[$typeId]['sum']   += $grade;
                    $byType[$typeId]['count'] += 1;

                    $activities[(int)$r->task_id] = $grade;
                }

                if (empty($byType)) {
                    continue;
                }

                // 2.3 Calcular promedio ponderado del parcial
                $finalGrade   = 0.0;
                $totalWeight  = 0.0;
                $detailsTypes = [];

                foreach ($byType as $typeId => $info) {
                    if ($info['count'] <= 0) continue;

                    $avg = $info['sum'] / $info['count'];
                    $w   = (float)$info['weightType']; // porcentaje del parcial

                    if ($w <= 0) continue;

                    $contribution = $avg * ($w / 100.0);

                    $finalGrade  += $contribution;
                    $totalWeight += $w;

                    $detailsTypes[] = [
                        'activity_type_id'        => $typeId,
                        'slug'                    => $info['slug'],
                        'name'                    => $info['name'],
                        'avg'                     => round($avg, 2),
                        'weight_percent_partial'  => $w,
                        'contribution'            => round($contribution, 2),
                    ];
                }

                if ($totalWeight <= 0) {
                    continue;
                }

                $finalGrade = round($finalGrade, 2);

                $details = [
                    'partial'       => $partialId,
                    'mg_id'         => $mgId,
                    'student_id'    => $studentId,
                    'total_weight'  => $totalWeight,
                    'final_grade'   => $finalGrade,
                    'per_type'      => $detailsTypes,
                    'activities'    => $activities,
                ];
                $detailsJson = json_encode($details, JSON_UNESCAPED_UNICODE);

                // 2.4 Upsert en student_calif
                $db->query("
                    SELECT id
                    FROM student_calif
                    WHERE mg_id = :mg
                      AND student_user_id = :stu
                      AND parcial = :parcial
                    LIMIT 1
                ", [
                    ':mg'      => $mgId,
                    ':stu'     => $studentId,
                    ':parcial' => $partialId,
                ]);
                $existing = $db->fetch();

                if ($existing) {
                    $db->query("
                        UPDATE student_calif
                        SET final_grade   = :grade,
                            details_json  = :details,
                            calculated_at = NOW()
                        WHERE id = :id
                    ", [
                        ':grade'   => $finalGrade,
                        ':details' => $detailsJson,
                        ':id'      => (int)$existing->id,
                    ]);
                } else {
                    $db->query("
                        INSERT INTO student_calif
                            (mg_id, student_user_id, parcial, final_grade, details_json, calculated_at)
                        VALUES
                            (:mg, :stu, :parcial, :grade, :details, NOW())
                    ", [
                        ':mg'       => $mgId,
                        ':stu'      => $studentId,
                        ':parcial'  => $partialId,
                        ':grade'    => $finalGrade,
                        ':details'  => $detailsJson,
                    ]);
                }
            }
        }
    }

    // Redirige de vuelta con los filtros
    $query = http_build_query([
        'group_id'   => $groupId ?: null,
        'subject_id' => $subjectId ?: null,
        'partial_id' => $partialId ?: null,
        'saved'      => 1,
    ]);

    header("Location: /src/plataforma/app/teacher/grades?$query");
    exit;
}

}
