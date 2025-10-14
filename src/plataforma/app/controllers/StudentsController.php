<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;

class StudentsController {

    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/login');
            exit;
        }
    }

    private function requireRole(array $roles) {
        $this->requireLogin();
        $userRoles = $_SESSION['user']['roles'] ?? [];
        foreach ($roles as $r) {
            if (in_array($r, $userRoles, true)) return;
        }
        header('Location: /src/plataforma/login');
        exit;
    }

    public function index() {
        $this->requireRole(['admin', 'teacher']);
        $user = $_SESSION['user'];
        $roles = $_SESSION['user']['roles'];

        if (in_array('admin', $roles, true)) {
            // Filtros
            $buscar   = $_GET['q'] ?? '';
            $semestre = $_GET['semestre'] ?? '';
            $carrera  = $_GET['carrera'] ?? '';
            $estado   = $_GET['estado'] ?? '';
            $page     = max(1, (int)($_GET['page'] ?? 1));
            $limit    = 10;
            $offset   = ($page - 1) * $limit;

            $userModel = new User();
            $students  = $userModel->getStudentsWithFilters([
                'search'   => $buscar,
                'semestre' => $semestre,
                'carrera'  => $carrera,
                'estado'   => $estado,
                'limit'    => $limit,
                'offset'   => $offset
            ]);

            $total      = $userModel->countStudentsWithFilters([
                'search'   => $buscar,
                'semestre' => $semestre,
                'carrera'  => $carrera,
                'estado'   => $estado
            ]);
            $totalPages = $total > 0 ? ceil($total / $limit) : 1;

            $carreras  = $userModel->getDistinctCarreras();
            $semestres = $userModel->getDistinctSemestres();

            View::render('admin/students/index', 'admin', [
                'students'  => $students,
                'buscar'    => $buscar,
                'semestre'  => $semestre,
                'carrera'   => $carrera,
                'estado'    => $estado,
                'page'      => $page,
                'totalPages'=> $totalPages,
                'total'     => $total,
                'carreras'  => $carreras,
                'semestres' => $semestres
            ]);

        } elseif (in_array('teacher', $roles, true)) {
            // Profesores → sólo sus estudiantes
            $courseModel = new \App\Models\Course();
            $students = $courseModel->getStudentsByTeacher($user['id']);

            View::render('teacher/students/index', 'teacher', [
                'students' => $students
            ]);
        }
    }

    public function create() {
        $this->requireRole(['admin', 'teacher']);
        View::render('admin/students/create', 'admin');
    }

    public function store() {
        $this->requireRole(['admin', 'teacher']);

        $data = $_POST;
        $errors = [];

        if (empty($data['name'])) $errors[] = 'El nombre es requerido.';
        if (empty($data['email'])) $errors[] = 'El email es requerido.';
        elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'El email no es válido.';
        if (empty($data['password'])) $errors[] = 'La contraseña es requerida.';

        if (!empty($errors)) {
            header('Location: /src/plataforma/app/admin/students/create?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        $userModel = new User();
        $userModel->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => 'student'
        ]);

        header('Location: /src/plataforma/app/admin/students');
        exit;
    }

    public function edit($id) {
        $this->requireRole(['admin', 'teacher']);
        $userModel = new User();
        $student   = $userModel->findById($id);

        if (!$student) {
            header('Location: /src/plataforma/app/admin/students');
            exit;
        }

        View::render('admin/students/edit', 'admin', ['student' => $student]);
    }

    public function update($id) {
        $this->requireRole(['admin', 'teacher']);

        $data = $_POST;
        $errors = [];

        if (empty($data['name'])) $errors[] = 'El nombre es requerido.';
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'El email no es válido.';
        if (empty($data['phone'])) $errors[] = 'El teléfono es requerido.';
        if (empty($data['birthdate'])) $errors[] = 'La fecha de nacimiento es requerida.';
        if (empty($data['carrera'])) $errors[] = 'La carrera es requerida.';
        if (empty($data['semestre'])) $errors[] = 'El semestre es requerido.';
        if (empty($data['matricula'])) $errors[] = 'La matrícula es requerida.';
        if (empty($data['grupo'])) $errors[] = 'El grupo es requerido.';
        if (empty($data['status'])) $errors[] = 'El estado es requerido.';

        if (!empty($data['password']) && $data['password'] !== ($data['password_confirmation'] ?? '')) {
            $errors[] = 'Las contraseñas no coinciden.';
        }

        if (!empty($errors)) {
            header('Location: /src/plataforma/app/admin/students/edit/' . $id . '?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        $updateData = [
            'name'      => $data['name'],
            'email'     => $data['email'],
            'phone'     => $data['phone'],
            'birthdate' => $data['birthdate'],
            'carrera'   => $data['carrera'],
            'semestre'  => $data['semestre'],
            'matricula' => $data['matricula'],
            'grupo'     => $data['grupo'],
            'status'    => $data['status']
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $userModel = new User();
        $userModel->update($id, $updateData);

        header('Location: /src/plataforma/app/admin/students');
        exit;
    }

    public function delete($id) {
        $this->requireRole(['admin', 'teacher']);
        $userModel = new User();
        $userModel->delete($id);
        header('Location: /src/plataforma/app/admin/students');
        exit;
    }

    public function export() {
        $this->requireRole(['admin', 'teacher']);

        $format   = $_GET['format'] ?? 'csv';
        $buscar   = $_GET['q'] ?? '';
        $semestre = $_GET['semestre'] ?? '';
        $carrera  = $_GET['carrera'] ?? '';
        $estado   = $_GET['estado'] ?? '';

        $userModel = new User();
        $students = $userModel->getStudentsWithFilters([
            'search'   => $buscar,
            'semestre' => $semestre,
            'carrera'  => $carrera,
            'estado'   => $estado,
            'limit'    => 10000,
            'offset'   => 0
        ]);

        if ($format === 'csv') {
            $this->exportCSV($students);
        } else {
            header('Location: /src/plataforma/app/admin/students');
            exit;
        }
    }

    private function exportCSV($students) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=estudiantes_' . date('Y-m-d_H-i-s') . '.csv');
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, ['ID','Nombre','Email','Matrícula','Carrera','Semestre','Teléfono','Nacimiento','Grupo','Estado','Creado']);

        foreach ($students as $s) {
            fputcsv($output, [
                $s->id, $s->name, $s->email,
                $s->matricula ?? '', $s->carrera ?? '', $s->semestre ?? '',
                $s->phone ?? '', $s->birthdate ?? '', $s->grupo ?? '', $s->status ?? '', $s->created_at ?? ''
            ]);
        }

        fclose($output);
        exit;
    }

    public function profile() {
        $this->requireRole(['student']);
        $user = $_SESSION['user'];
        View::render('student/profile/view', 'student', ['user' => $user]);
    }

    public function editProfile() {
        $this->requireRole(['student']);
        $user = $_SESSION['user'];
        View::render('student/profile/edit', 'student', ['user' => $user]);
    }

    public function updateProfile() {
        $this->requireRole(['student']);
        $data = $_POST;
        $userModel = new User();
        $userModel->update($_SESSION['user']['id'], $data);
        $_SESSION['user'] = array_merge($_SESSION['user'], $data);
        header('Location: /src/plataforma/app/student/profile');
        exit;
    }
}
