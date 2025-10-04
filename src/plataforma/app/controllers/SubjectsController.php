<?php
namespace App\Controllers;

use App\Core\Gate;
use App\Models\Course;

class SubjectsController {
    public function index() {
        // Verificar autenticación y rol
        if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }

        $userRole = $_SESSION['user']['role'] ?? '';

        if ($userRole === 'teacher') {
            Gate::allow('teacher');

            // Para maestros, mostrar solo sus materias asignadas
            $courseModel = new \App\Models\Course();
            $userId = $_SESSION['user']['id'];
            $subjects = $courseModel->getByTeacher($userId);

            // Cargar la vista de maestro
            ob_start();
            include __DIR__.'/../views/teacher/subjects/index.php';
            return ob_get_clean();
        } elseif ($userRole === 'admin') {
            Gate::allow('admin');

            // Obtener lista de todas las materias de la base de datos
            $courseModel = new \App\Models\Course();
            $subjects = $courseModel->getAll();

            // Cargar la vista de admin
            ob_start();
            include __DIR__.'/../views/admin/subjects/index.php';
            return ob_get_clean();
        } else {
            // Rol no autorizado
            header('Location:/src/plataforma/');
            exit;
        }
    }

    public function create() {
        if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }

        ob_start(); 
        include __DIR__.'/../views/admin/subjects/create.php'; 
        return ob_get_clean();
    }

    public function store() {
        if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }

        // Validación de datos
        $data = $_POST;
        // TODO: Implementar validación

        // Crear nueva materia
        $courseModel = new \App\Models\Course();
        $result = $courseModel->create([
            'nombre' => $data['nombre'],
            'codigo' => $data['codigo'],
            'creditos' => $data['creditos'],
            'horas_semana' => $data['horas_semana'],
            'departamento' => $data['departamento'],
            'semestre' => $data['semestre'],
            'tipo' => $data['tipo'],
            'modalidad' => $data['modalidad'],
            'estado' => $data['estado'],
            'profesor_id' => $data['profesor_id'],
            'descripcion' => $data['descripcion'],
            'objetivo' => $data['objetivo'],
            'prerrequisitos' => isset($data['prerrequisitos']) ? implode(',', $data['prerrequisitos']) : ''
        ]);

        // Redireccionar a la lista de materias
        header('Location: /src/plataforma/app/admin/subjects');
        exit;
    }

    public function edit($id) {
        if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }

        $courseModel = new \App\Models\Course();
        $subject = $courseModel->findById($id);

        // Si no se encuentra la materia, redirigir a la lista
        if (!$subject || !is_object($subject)) {
            header('Location: /src/plataforma/app/admin/subjects');
            exit;
        }

        ob_start(); 
        include __DIR__.'/../views/admin/subjects/edit.php'; 
        return ob_get_clean();
    }

    public function update($id) {
        if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }

        $data = $_POST;
        // TODO: Implementar validación

        $courseModel = new \App\Models\Course();
        $result = $courseModel->update($id, [
            'nombre' => $data['nombre'],
            'codigo' => $data['codigo'],
            'creditos' => $data['creditos'],
            'horas_semana' => $data['horas_semana'],
            'departamento' => $data['departamento'],
            'semestre' => $data['semestre'],
            'tipo' => $data['tipo'],
            'modalidad' => $data['modalidad'],
            'estado' => $data['estado'],
            'profesor_id' => $data['profesor_id'],
            'descripcion' => $data['descripcion'],
            'objetivo' => $data['objetivo'],
            'prerrequisitos' => isset($data['prerrequisitos']) ? implode(',', $data['prerrequisitos']) : ''
        ]);

        header('Location: /src/plataforma/app/admin/subjects');
        exit;
    }

    public function delete($id) {
        if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }

        $courseModel = new \App\Models\Course();
        $result = $courseModel->delete($id);

        header('Location: /src/plataforma/app/admin/subjects');
        exit;
    }
}