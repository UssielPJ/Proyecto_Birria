<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Gate;
use App\Models\Schedule;
use App\Core\View;

class ScheduleController {
    public function index() {
        // Verificar autenticación
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }

        // Verificar rol
        Gate::allow(['admin', 'teacher', 'student']);

        $scheduleModel = new Schedule();
        $userRole = $_SESSION['user']['role'];
        $user = $_SESSION['user'];

        if ($userRole === 'admin') {
            // Obtener lista de horarios de la base de datos
            $schedules = $scheduleModel->getAll();
            // Cargar la vista con los datos
            View::render('admin/schedule/index', 'admin', [
                'schedules' => $schedules
            ]);
        } elseif ($userRole === 'teacher') {
            // Obtener horarios del docente
            $schedule = $scheduleModel->getWeekByTeacher($user['id']);
            // Cargar la vista con los datos
            View::render('schedule/index', 'teacher', [
                'schedule' => $schedule
            ]);
        } elseif ($userRole === 'student') {
            // Obtener horarios del estudiante
            $schedule = $scheduleModel->getWeekByStudent($user['id']);
            // Cargar la vista con los datos
            View::render('schedule/index', 'student', [
                'schedule' => $schedule
            ]);
        }
    }

    public function add() {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['admin', 'teacher']);

        View::render('admin/schedule/add', 'admin');
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
        if (empty($data['periodo'])) $errors[] = 'El período es requerido.';
        if (empty($data['materia_id'])) $errors[] = 'La materia es requerida.';
        if (empty($data['profesor_id'])) $errors[] = 'El profesor es requerido.';
        if (empty($data['dia'])) $errors[] = 'El día es requerido.';
        if (empty($data['hora_inicio'])) $errors[] = 'La hora de inicio es requerida.';
        if (empty($data['hora_fin'])) $errors[] = 'La hora de fin es requerida.';
        if (empty($data['aula_id'])) $errors[] = 'El aula es requerida.';

        if (!empty($errors)) {
            header('Location: /src/plataforma/app/admin/schedule/add?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        // Crear nuevo horario
        $scheduleModel = new Schedule();
        $scheduleModel->create([
            'periodo' => $data['periodo'],
            'grupo_id' => $data['grupo_id'] ?? null,
            'materia_id' => $data['materia_id'],
            'profesor_id' => $data['profesor_id'],
            'dia' => $data['dia'],
            'hora_inicio' => $data['hora_inicio'],
            'hora_fin' => $data['hora_fin'],
            'aula_id' => $data['aula_id'],
            'modalidad' => $data['modalidad'] ?? 'presencial',
            'estado' => $data['estado'] ?? 'activo',
            'tipo_clase' => $data['tipo_clase'] ?? 'teorica',
            'duracion' => $data['duracion'] ?? 60,
            'observaciones' => $data['observaciones'] ?? '',
            'fecha_inicio' => $data['fecha_inicio'] ?? null,
            'fecha_fin' => $data['fecha_fin'] ?? null
        ]);

        // Redireccionar a la lista de horarios
        header('Location: /src/plataforma/app/admin/schedule');
        exit;
    }

    public function edit($id) {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['admin', 'teacher']);

        $scheduleModel = new Schedule();
        $schedule = $scheduleModel->findById($id);

        if (!$schedule) {
            header('Location: /src/plataforma/app/admin/schedule');
            exit;
        }

        View::render('admin/schedule/edit', 'admin', [
            'schedule' => $schedule
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
        if (empty($data['periodo'])) $errors[] = 'El período es requerido.';
        if (empty($data['materia_id'])) $errors[] = 'La materia es requerida.';
        if (empty($data['profesor_id'])) $errors[] = 'El profesor es requerido.';
        if (empty($data['dia'])) $errors[] = 'El día es requerido.';
        if (empty($data['hora_inicio'])) $errors[] = 'La hora de inicio es requerida.';
        if (empty($data['hora_fin'])) $errors[] = 'La hora de fin es requerida.';
        if (empty($data['aula_id'])) $errors[] = 'El aula es requerida.';

        if (!empty($errors)) {
            header('Location: /src/plataforma/app/admin/schedule/edit/' . $id . '?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        // Preparar datos para actualizar
        $updateData = [
            'periodo' => $data['periodo'],
            'grupo_id' => $data['grupo_id'] ?? null,
            'materia_id' => $data['materia_id'],
            'profesor_id' => $data['profesor_id'],
            'dia' => $data['dia'],
            'hora_inicio' => $data['hora_inicio'],
            'hora_fin' => $data['hora_fin'],
            'aula_id' => $data['aula_id'],
            'modalidad' => $data['modalidad'] ?? 'presencial',
            'estado' => $data['estado'] ?? 'activo',
            'tipo_clase' => $data['tipo_clase'] ?? 'teorica',
            'duracion' => $data['duracion'] ?? 60,
            'observaciones' => $data['observaciones'] ?? '',
            'fecha_inicio' => $data['fecha_inicio'] ?? null,
            'fecha_fin' => $data['fecha_fin'] ?? null
        ];

        $scheduleModel = new Schedule();
        $scheduleModel->update($id, $updateData);

        header('Location: /src/plataforma/app/admin/schedule');
        exit;
    }

    public function delete($id) {
        if (!Auth::check()) {
            header('Location: /src/plataforma/');
            exit;
        }
        Gate::allow(['admin', 'teacher']);

        $scheduleModel = new Schedule();
        $scheduleModel->delete($id);

        header('Location: /src/plataforma/app/admin/schedule');
        exit;
    }
}
