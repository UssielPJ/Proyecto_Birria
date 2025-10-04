<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Gate;
use App\Models\Grade;
use App\Core\View;

class GradesController {
    public function index() {
        // Verificar autenticación
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }

        // Verificar rol
        Gate::allow(['admin', 'teacher']);

        $user = $_SESSION['user'];
        $role = $_SESSION['user_role'] ?? 'student';

        // Obtener calificaciones según el rol
        $gradeModel = new Grade();
        $grades = [];
        $stats = [];

        if ($role === 'admin') {
            $grades = $gradeModel->getAll();
            $stats = [
                'total_grades' => count($grades),
                'average_grade' => $gradeModel->getGlobalAverage(),
                'passed_count' => $gradeModel->getPassedCount(),
                'failed_count' => $gradeModel->getFailedCount()
            ];
            View::render('admin/grades/index', 'admin', [
                'grades' => $grades,
                'stats' => $stats
            ]);
        } elseif ($role === 'teacher') {
            // Para profesores, mostrar solo calificaciones de sus cursos
            $grades = $gradeModel->getRecentByTeacher($user['id']);
            $pendingGrades = $gradeModel->getPendingGrades();
            View::render('teacher/grades/index', 'teacher', [
                'grades' => $grades,
                'pendingGrades' => $pendingGrades
            ]);
        }
    }

    public function create() {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['admin', 'teacher']);

        View::render('admin/grades/create', 'admin');
    }

    public function store() {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['admin', 'teacher']);

        // Validación de datos
        $data = $_POST;
        $errors = [];

        // Validaciones básicas
        if (empty($data['student_id'])) $errors[] = 'El estudiante es requerido.';
        if (empty($data['subject_id'])) $errors[] = 'La materia es requerida.';
        if (empty($data['grade'])) $errors[] = 'La calificación es requerida.';
        if (!is_numeric($data['grade']) || $data['grade'] < 0 || $data['grade'] > 100) {
            $errors[] = 'La calificación debe ser un número entre 0 y 100.';
        }
        if (empty($data['period'])) $errors[] = 'El período es requerido.';

        if (!empty($errors)) {
            header('Location: /src/plataforma/app/admin/grades/create?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        // Crear nueva calificación
        $gradeModel = new Grade();
        $gradeModel->create([
            'student_id' => $data['student_id'],
            'subject_id' => $data['subject_id'],
            'grade' => $data['grade'],
            'period' => $data['period'],
            'comments' => $data['comments'] ?? '',
            'created_by' => $_SESSION['user']['id']
        ]);

        // Redireccionar a la lista de calificaciones
        header('Location: /src/plataforma/app/admin/grades');
        exit;
    }

    public function edit($id) {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['admin', 'teacher']);

        $gradeModel = new Grade();
        $grade = $gradeModel->findById($id);

        if (!$grade) {
            header('Location: /src/plataforma/app/admin/grades');
            exit;
        }

        View::render('admin/grades/edit', 'admin', [
            'grade' => $grade
        ]);
    }

    public function update($id) {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['admin', 'teacher']);

        $data = $_POST;
        $errors = [];

        // Validaciones básicas
        if (empty($data['student_id'])) $errors[] = 'El estudiante es requerido.';
        if (empty($data['subject_id'])) $errors[] = 'La materia es requerida.';
        if (empty($data['grade'])) $errors[] = 'La calificación es requerida.';
        if (!is_numeric($data['grade']) || $data['grade'] < 0 || $data['grade'] > 100) {
            $errors[] = 'La calificación debe ser un número entre 0 y 100.';
        }
        if (empty($data['period'])) $errors[] = 'El período es requerido.';

        if (!empty($errors)) {
            header('Location: /src/plataforma/app/admin/grades/edit/' . $id . '?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        // Preparar datos para actualizar
        $updateData = [
            'student_id' => $data['student_id'],
            'subject_id' => $data['subject_id'],
            'grade' => $data['grade'],
            'period' => $data['period'],
            'comments' => $data['comments'] ?? '',
            'updated_by' => $_SESSION['user']['id']
        ];

        $gradeModel = new Grade();
        $gradeModel->update($id, $updateData);

        header('Location: /src/plataforma/app/admin/grades');
        exit;
    }

    public function delete($id) {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['admin', 'teacher']);

        $gradeModel = new Grade();
        $gradeModel->delete($id);

        header('Location: /src/plataforma/app/admin/grades');
        exit;
    }
}
