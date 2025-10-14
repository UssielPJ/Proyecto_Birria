<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\Course;

class SubjectsController
{
    /* ----------------- Guards compatibles ----------------- */
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

    /* ===================== Index ===================== */
    public function index() {
        $this->requireLogin();
        $roles = $_SESSION['user']['roles'] ?? [];

        $courseModel = new Course();

        if (in_array('teacher', $roles, true)) {
            // Maestro: solo sus materias
            $subjects = $courseModel->getByTeacher($_SESSION['user']['id']);

            View::render('teacher/subjects/index', 'teacher', [
                'subjects' => $subjects
            ]);
            return;
        }

        if (in_array('admin', $roles, true)) {
            // Admin: todas las materias
            $subjects = $courseModel->getAll();

            View::render('admin/subjects/index', 'admin', [
                'subjects' => $subjects
            ]);
            return;
        }

        // Rol no autorizado
        header('Location: /src/plataforma/login'); exit;
    }

    /* ===================== Crear ===================== */
    public function create() {
        $this->requireRole(['admin']);
        View::render('admin/subjects/create', 'admin');
    }

    public function store() {
        $this->requireRole(['admin']);

        // TODO: valida según tu formulario
        $data = $_POST;

        $courseModel = new Course();
        $courseModel->create([
            'nombre'         => $data['nombre']        ?? '',
            'codigo'         => $data['codigo']        ?? '',
            'creditos'       => $data['creditos']      ?? null,
            'horas_semana'   => $data['horas_semana']  ?? null,
            'departamento'   => $data['departamento']  ?? '',
            'semestre'       => $data['semestre']      ?? '',
            'tipo'           => $data['tipo']          ?? '',
            'modalidad'      => $data['modalidad']     ?? '',
            'estado'         => $data['estado']        ?? 'activa',
            'profesor_id'    => $data['profesor_id']   ?? null,
            'descripcion'    => $data['descripcion']   ?? '',
            'objetivo'       => $data['objetivo']      ?? '',
            'prerrequisitos' => isset($data['prerrequisitos']) ? implode(',', (array)$data['prerrequisitos']) : ''
        ]);

        header('Location: /src/plataforma/app/admin/subjects'); exit;
    }

    /* ===================== Editar ===================== */
    public function edit($id) {
        $this->requireRole(['admin']);

        $courseModel = new Course();
        $subject = $courseModel->findById($id);

        if (!$subject || !is_object($subject)) {
            header('Location: /src/plataforma/app/admin/subjects'); exit;
        }

        View::render('admin/subjects/edit', 'admin', [
            'subject' => $subject
        ]);
    }

    public function update($id) {
        $this->requireRole(['admin']);

        // TODO: valida según tu formulario
        $data = $_POST;

        $courseModel = new Course();
        $courseModel->update($id, [
            'nombre'         => $data['nombre']        ?? '',
            'codigo'         => $data['codigo']        ?? '',
            'creditos'       => $data['creditos']      ?? null,
            'horas_semana'   => $data['horas_semana']  ?? null,
            'departamento'   => $data['departamento']  ?? '',
            'semestre'       => $data['semestre']      ?? '',
            'tipo'           => $data['tipo']          ?? '',
            'modalidad'      => $data['modalidad']     ?? '',
            'estado'         => $data['estado']        ?? 'activa',
            'profesor_id'    => $data['profesor_id']   ?? null,
            'descripcion'    => $data['descripcion']   ?? '',
            'objetivo'       => $data['objetivo']      ?? '',
            'prerrequisitos' => isset($data['prerrequisitos']) ? implode(',', (array)$data['prerrequisitos']) : ''
        ]);

        header('Location: /src/plataforma/app/admin/subjects'); exit;
    }

    /* ===================== Eliminar ===================== */
    public function delete($id) {
        $this->requireRole(['admin']);

        $courseModel = new Course();
        $courseModel->delete($id);

        header('Location: /src/plataforma/app/admin/subjects'); exit;
    }
}
