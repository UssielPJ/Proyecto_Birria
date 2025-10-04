<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Gate;
use App\Models\User;
use App\Core\View;

class TeachersController {
    public function index() {
        // Verificar autenticación
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }

        // Verificar rol de administrador
        Gate::allow('admin');

        // Obtener parámetros de búsqueda y filtrado
        $buscar = $_GET['q'] ?? '';
        $departamento = $_GET['departamento'] ?? '';
        $estado = $_GET['estado'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Obtener lista de profesores de la base de datos con filtros
        $userModel = new User();
        $teachers = $userModel->getTeachersWithFilters([
            'search' => $buscar,
            'departamento' => $departamento,
            'estado' => $estado,
            'limit' => $limit,
            'offset' => $offset
        ]);

        // Obtener total para paginación
        $total = $userModel->countTeachersWithFilters([
            'search' => $buscar,
            'departamento' => $departamento,
            'estado' => $estado
        ]);
        $totalPages = ceil($total / $limit);

        // Obtener opciones para filtros
        $departamentos = $userModel->getDistinctDepartamentos();

        // Cargar la vista con los datos
        View::render('admin/teachers/index', 'admin', [
            'teachers' => $teachers,
            'buscar' => $buscar,
            'departamento' => $departamento,
            'estado' => $estado,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'departamentos' => $departamentos
        ]);
    }

    public function create() {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow('admin');

        View::render('admin/teachers/create', 'admin');
    }

    public function store() {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow('admin');

        // Validación de datos
        $data = $_POST;
        $errors = [];
        if (empty($data['name'])) $errors[] = 'El nombre es requerido.';
        if (empty($data['email'])) $errors[] = 'El email es requerido.';
        elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'El email no es válido.';
        if (empty($data['password'])) $errors[] = 'La contraseña es requerida.';
        if (!empty($errors)) {
            // Para simplicidad, redirigir con errores (puedes mejorar con sesiones)
            header('Location: /src/plataforma/app/admin/teachers/create?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        // Crear nuevo profesor
        $userModel = new User();
        $userModel->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'teacher'
        ]);

        // Redireccionar a la lista de profesores
        header('Location: /src/plataforma/app/admin/teachers');
        exit;
    }

    public function edit($id) {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow('admin');

        $userModel = new User();
        $teacher = $userModel->findById($id);

        if (!$teacher) {
            header('Location: /src/plataforma/app/admin/teachers');
            exit;
        }

        View::render('admin/teachers/edit', 'admin', [
            'teacher' => $teacher
        ]);
    }

    public function update($id) {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow('admin');

        $data = $_POST;
        $errors = [];

        // Validación de campos requeridos
        if (empty($data['name'])) $errors[] = 'El nombre es requerido.';
        if (empty($data['email'])) $errors[] = 'El email es requerido.';
        elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'El email no es válido.';
        if (empty($data['phone'])) $errors[] = 'El teléfono es requerido.';
        if (empty($data['specialty'])) $errors[] = 'La especialidad es requerida.';
        if (empty($data['department'])) $errors[] = 'El departamento es requerido.';
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
            header('Location: /src/plataforma/app/admin/teachers/edit/' . $id . '?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        // Preparar datos para actualizar
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'specialty' => $data['specialty'],
            'department' => $data['department'],
            'status' => $data['status']
        ];

        // Incluir contraseña solo si se proporciona
        if (!empty($data['password'])) {
            $updateData['password'] = $data['password'];
        }

        $userModel = new User();
        $userModel->update($id, $updateData);

        header('Location: /src/plataforma/app/admin/teachers');
        exit;
    }

    public function delete($id) {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow('admin');

        $userModel = new User();
        $userModel->delete($id);

        header('Location: /src/plataforma/app/admin/teachers');
        exit;
    }

    public function export() {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow('admin');

        $format = $_GET['format'] ?? 'csv';
        $buscar = $_GET['q'] ?? '';
        $departamento = $_GET['departamento'] ?? '';
        $estado = $_GET['estado'] ?? '';

        // Obtener profesores con filtros (sin paginación)
        $userModel = new User();
        $teachers = $userModel->getTeachersWithFilters([
            'search' => $buscar,
            'departamento' => $departamento,
            'estado' => $estado,
            'limit' => 10000, // Límite alto para exportación
            'offset' => 0
        ]);

        if ($format === 'csv') {
            $this->exportCSV($teachers);
        } else {
            header('Location: /src/plataforma/app/admin/teachers');
            exit;
        }
    }

    private function exportCSV($teachers) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=profesores_' . date('Y-m-d_H-i-s') . '.csv');

        $output = fopen('php://output', 'w');

        // BOM para UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // Encabezados
        fputcsv($output, [
            'ID',
            'Nombre',
            'Email',
            'Teléfono',
            'Especialidad',
            'Departamento',
            'Número de Empleado',
            'Estado',
            'Fecha de Creación'
        ]);

        // Datos
        foreach ($teachers as $teacher) {
            fputcsv($output, [
                $teacher->id,
                $teacher->name,
                $teacher->email,
                $teacher->phone ?? '',
                $teacher->specialty ?? '',
                $teacher->department ?? '',
                $teacher->num_empleado ?? '',
                $teacher->status ?? '',
                $teacher->created_at ?? ''
            ]);
        }

        fclose($output);
        exit;
    }
}
