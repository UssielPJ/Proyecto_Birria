<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\Grade;

class GradesController
{
    /* ----------------- Guards compatibles con la nueva sesión ----------------- */
    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/login'); exit;
        }
    }

    private function requireRole(array $roles) {
        $this->requireLogin();
        $userRoles = $_SESSION['user']['roles'] ?? [];
        foreach ($roles as $r) {
            if (in_array($r, $userRoles, true)) return;
        }
        header('Location: /src/plataforma/login'); exit;
    }

    /* ===================== Listado ===================== */
    public function index() {
        $this->requireRole(['admin','teacher']);

        $user  = $_SESSION['user'];
        $roles = $_SESSION['user']['roles'] ?? [];

        $gradeModel = new Grade();

        if (in_array('admin', $roles, true)) {
            $grades = $gradeModel->getAll();
            $stats  = [
                'total_grades'   => is_array($grades) ? count($grades) : 0,
                'average_grade'  => (float)($gradeModel->getGlobalAverage() ?? 0),
                'passed_count'   => (int)($gradeModel->getPassedCount() ?? 0),
                'failed_count'   => (int)($gradeModel->getFailedCount() ?? 0),
            ];

            View::render('admin/grades/index', 'admin', [
                'grades' => $grades,
                'stats'  => $stats,
            ]);
            return;
        }

        // teacher
        $grades        = $gradeModel->getRecentByTeacher($user['id']);
        $pendingGrades = $gradeModel->getPendingGrades(); // si tu modelo requiere id, cámbialo a getPendingGrades($user['id'])

        View::render('teacher/grades/index', 'teacher', [
            'grades'        => $grades,
            'pendingGrades' => $pendingGrades,
        ]);
    }

    /* ===================== Crear ===================== */
    public function create() {
        $this->requireRole(['admin','teacher']);
        $roles = $_SESSION['user']['roles'] ?? [];
        $user = $_SESSION['user'];

        if (in_array('teacher', $roles, true) && !in_array('admin', $roles, true)) {
            // Load students and subjects for teacher
            $courseModel = new \App\Models\Course();
            $students = $courseModel->getStudentsByTeacher($user['id']);
            $subjects = $courseModel->getByTeacher($user['id']);
            View::render('teacher/grades/create', 'teacher', ['students' => $students, 'subjects' => $subjects]);
            return;
        }

        View::render('admin/grades/create', 'admin');
    }

    public function store() {
        $this->requireRole(['admin','teacher']);

        $data   = $_POST;
        $errors = [];

        // Validaciones básicas
        if (empty($data['student_id'])) $errors[] = 'El estudiante es requerido.';
        if (empty($data['subject_id'])) $errors[] = 'La materia es requerida.';
        if (!isset($data['grade']) || $data['grade'] === '') $errors[] = 'La calificación es requerida.';
        if (!is_numeric($data['grade']) || $data['grade'] < 0 || $data['grade'] > 100) {
            $errors[] = 'La calificación debe ser un número entre 0 y 100.';
        }

        if ($errors) {
            header('Location: /src/plataforma/app/admin/grades/create?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        $gradeModel = new Grade();
        $gradeModel->create([
            'student_id' => (int)$data['student_id'],
            'assignment_id' => (int)$data['subject_id'], // map subject_id to assignment_id
            'grade'      => (float)$data['grade'],
            'comments'   => $data['comments'] ?? '',
            'created_by' => $_SESSION['user']['id'],
        ]);

        $roles = $_SESSION['user']['roles'] ?? [];
        $redirect = (in_array('teacher', $roles, true) && !in_array('admin', $roles, true))
            ? '/src/plataforma/app/teacher/grades'
            : '/src/plataforma/app/admin/grades';
        header('Location: ' . $redirect); exit;
    }

    /* ===================== Editar ===================== */
    public function edit($id) {
        $this->requireRole(['admin','teacher']);
        $roles = $_SESSION['user']['roles'] ?? [];
        $user = $_SESSION['user'];

        $gradeModel = new Grade();
        $grade = $gradeModel->findById($id);

        if (!$grade) {
            $redirect = (in_array('teacher', $roles, true) && !in_array('admin', $roles, true))
                ? '/src/plataforma/app/teacher/grades'
                : '/src/plataforma/app/admin/grades';
            header('Location: ' . $redirect); exit;
        }

        if (in_array('teacher', $roles, true) && !in_array('admin', $roles, true)) {
            // Load students and subjects for teacher
            $courseModel = new \App\Models\Course();
            $students = $courseModel->getStudentsByTeacher($user['id']);
            $subjects = $courseModel->getByTeacher($user['id']);
            View::render('teacher/grades/edit', 'teacher', ['grade' => $grade, 'students' => $students, 'subjects' => $subjects]);
            return;
        }

        View::render('admin/grades/edit', 'admin', ['grade' => $grade]);
    }

    public function update($id) {
        $this->requireRole(['admin','teacher']);

        $data   = $_POST;
        $errors = [];

        if (empty($data['student_id'])) $errors[] = 'El estudiante es requerido.';
        if (empty($data['subject_id'])) $errors[] = 'La materia es requerida.';
        if (!isset($data['grade']) || $data['grade'] === '') $errors[] = 'La calificación es requerida.';
        if (!is_numeric($data['grade']) || $data['grade'] < 0 || $data['grade'] > 100) {
            $errors[] = 'La calificación debe ser un número entre 0 y 100.';
        }

        if ($errors) {
            header('Location: /src/plataforma/app/admin/grades/edit/' . $id . '?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        $updateData = [
            'student_id' => (int)$data['student_id'],
            'assignment_id' => (int)$data['subject_id'], // map subject_id to assignment_id
            'grade'      => (float)$data['grade'],
            'comments'   => $data['comments'] ?? '',
            'updated_by' => $_SESSION['user']['id'],
        ];

        $gradeModel = new Grade();
        $gradeModel->update($id, $updateData);

        $roles = $_SESSION['user']['roles'] ?? [];
        $redirect = (in_array('teacher', $roles, true) && !in_array('admin', $roles, true))
            ? '/src/plataforma/app/teacher/grades'
            : '/src/plataforma/app/admin/grades';
        header('Location: ' . $redirect); exit;
    }

    /* ===================== Eliminar ===================== */
    public function delete($id) {
        $this->requireRole(['admin','teacher']);

        $gradeModel = new Grade();
        $gradeModel->delete($id);

        $roles = $_SESSION['user']['roles'] ?? [];
        $redirect = (in_array('teacher', $roles, true) && !in_array('admin', $roles, true))
            ? '/src/plataforma/app/teacher/grades'
            : '/src/plataforma/app/admin/grades';
        header('Location: ' . $redirect); exit;
    }
}
