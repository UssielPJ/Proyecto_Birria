<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Gate;
use App\Models\User;
use App\Core\View;

class StudentsController {
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

        if ($role === 'admin') {
            // Obtener parámetros de búsqueda y filtrado
            $buscar = $_GET['q'] ?? '';
            $semestre = $_GET['semestre'] ?? '';
            $carrera = $_GET['carrera'] ?? '';
            $estado = $_GET['estado'] ?? '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Obtener lista de estudiantes de la base de datos con filtros
            $userModel = new User();
            $students = $userModel->getStudentsWithFilters([
                'search' => $buscar,
                'semestre' => $semestre,
                'carrera' => $carrera,
                'estado' => $estado,
                'limit' => $limit,
                'offset' => $offset
            ]);

            // Obtener total para paginación
            $total = $userModel->countStudentsWithFilters([
                'search' => $buscar,
                'semestre' => $semestre,
                'carrera' => $carrera,
                'estado' => $estado
            ]);
            $totalPages = ceil($total / $limit);

            // Obtener opciones para filtros
            $carreras = $userModel->getDistinctCarreras();
            $semestres = $userModel->getDistinctSemestres();

            // Cargar la vista con los datos
            View::render('admin/students/index', 'admin', [
                'students' => $students,
                'buscar' => $buscar,
                'semestre' => $semestre,
                'carrera' => $carrera,
                'estado' => $estado,
                'page' => $page,
                'totalPages' => $totalPages,
                'total' => $total,
                'carreras' => $carreras,
                'semestres' => $semestres
            ]);
        } elseif ($role === 'teacher') {
            // Para profesores, mostrar solo estudiantes de sus cursos
            $courseModel = new \App\Models\Course();
            $students = $courseModel->getStudentsByTeacher($user['id']);

            View::render('teacher/students/index', 'teacher', [
                'students' => $students
            ]);
        }
    }
    
    public function create() {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['admin', 'teacher']);

        View::render('admin/students/create', 'admin');
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
        if (empty($data['name'])) $errors[] = 'El nombre es requerido.';
        if (empty($data['email'])) $errors[] = 'El email es requerido.';
        elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'El email no es válido.';
        if (empty($data['password'])) $errors[] = 'La contraseña es requerida.';
        if (!empty($errors)) {
            // Para simplicidad, redirigir con errores (puedes mejorar con sesiones)
            header('Location: /src/plataforma/app/admin/students/create?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        // Crear nuevo estudiante
        $userModel = new User();
        $userModel->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'alumno'
        ]);

        // Redireccionar a la lista de estudiantes
        header('Location: /src/plataforma/app/admin/students');
        exit;
    }
    
    public function edit($id) {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['admin', 'teacher']);

        $userModel = new User();
        $student = $userModel->findById($id);

        if (!$student) {
            header('Location: /src/plataforma/app/admin/students');
            exit;
        }

        View::render('admin/students/edit', 'admin', [
            'student' => $student
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

        // Validación de campos requeridos
        if (empty($data['name'])) $errors[] = 'El nombre es requerido.';
        if (empty($data['email'])) $errors[] = 'El email es requerido.';
        elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'El email no es válido.';
        if (empty($data['phone'])) $errors[] = 'El teléfono es requerido.';
        if (empty($data['birthdate'])) $errors[] = 'La fecha de nacimiento es requerida.';
        if (empty($data['carrera'])) $errors[] = 'La carrera es requerida.';
        if (empty($data['semestre'])) $errors[] = 'El semestre es requerido.';
        if (empty($data['matricula'])) $errors[] = 'La matrícula es requerida.';
        if (empty($data['grupo'])) $errors[] = 'El grupo es requerido.';
        if (empty($data['status'])) $errors[] = 'El estado es requerido.';

        // Validación de contraseña si se proporciona
        if (!empty($data['password'])) {
            if ($data['password'] !== $data['password_confirmation']) {
                $errors[] = 'Las contraseñas no coinciden.';
            } elseif (strlen($data['password']) < 6) {
                $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
            }
        }

        if (!empty($errors)) {
            header('Location: /src/plataforma/app/admin/students/edit/' . $id . '?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        // Preparar datos para actualizar
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'birthdate' => $data['birthdate'],
            'carrera' => $data['carrera'],
            'semestre' => $data['semestre'],
            'matricula' => $data['matricula'],
            'grupo' => $data['grupo'],
            'status' => $data['status']
        ];

        // Incluir contraseña solo si se proporciona
        if (!empty($data['password'])) {
            $updateData['password'] = $data['password'];
        }

        $userModel = new User();
        $userModel->update($id, $updateData);

        header('Location: /src/plataforma/app/admin/students');
        exit;
    }
    
    public function delete($id) {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['admin', 'teacher']);

        $userModel = new User();
        $userModel->delete($id);

        header('Location: /src/plataforma/app/admin/students');
        exit;
    }

    public function export() {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['admin', 'teacher']);

        $format = $_GET['format'] ?? 'csv';
        $buscar = $_GET['q'] ?? '';
        $semestre = $_GET['semestre'] ?? '';
        $carrera = $_GET['carrera'] ?? '';
        $estado = $_GET['estado'] ?? '';

        // Obtener estudiantes con filtros (sin paginación)
        $userModel = new User();
        $students = $userModel->getStudentsWithFilters([
            'search' => $buscar,
            'semestre' => $semestre,
            'carrera' => $carrera,
            'estado' => $estado,
            'limit' => 10000, // Límite alto para exportación
            'offset' => 0
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

        // BOM para UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Encabezados
        fputcsv($output, [
            'ID',
            'Nombre',
            'Email',
            'Matrícula',
            'Carrera',
            'Semestre',
            'Teléfono',
            'Fecha de Nacimiento',
            'Grupo',
            'Estado',
            'Fecha de Creación'
        ]);

        // Datos
        foreach ($students as $student) {
            fputcsv($output, [
                $student->id,
                $student->name,
                $student->email,
                $student->matricula ?? '',
                $student->carrera ?? '',
                $student->semestre ?? '',
                $student->phone ?? '',
                $student->birthdate ?? '',
                $student->grupo ?? '',
                $student->status ?? '',
                $student->created_at ?? ''
            ]);
        }

        fclose($output);
        exit;
    }

    public function profile() {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['student']);

        $user = $_SESSION['user'];
        View::render('student/profile/view', 'student', [
            'user' => $user
        ]);
    }

    public function editProfile() {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['student']);

        $user = $_SESSION['user'];
        View::render('student/profile/edit', 'student', [
            'user' => $user
        ]);
    }

    public function updateProfile() {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['student']);

        $data = $_POST;
        $userModel = new User();
        $userModel->update($_SESSION['user']['id'], $data);

        // Update session
        $_SESSION['user'] = array_merge($_SESSION['user'], $data);

        header('Location: /src/plataforma/app/student/profile');
        exit;
    }
}
