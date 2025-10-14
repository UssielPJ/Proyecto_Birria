<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\Schedule;

class ScheduleController
{
    /* ----------------- Helpers ----------------- */
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

    /** Agrupa registros en formato semanal por día (Lun..Dom). Acepta claves 'dia' o 'dia_semana'. */
    private function buildWeek(array $rows): array {
        $DAYS = ['Lun','Mar','Mie','Jue','Vie','Sab','Dom'];
        $map = [
            'Lunes' => 'Lun', 'Martes' => 'Mar', 'Miércoles' => 'Mie', 'Miercoles' => 'Mie',
            'Jueves'=> 'Jue', 'Viernes'=> 'Vie', 'Sábado'=> 'Sab', 'Sabado'=> 'Sab',
            'Domingo'=>'Dom', 'Lun'=>'Lun','Mar'=>'Mar','Mie'=>'Mie','Mié'=>'Mie','Jue'=>'Jue','Vie'=>'Vie','Sab'=>'Sab','Sáb'=>'Sab','Dom'=>'Dom'
        ];
        $week = [];
        foreach ($DAYS as $d) $week[$d] = [];

        foreach ($rows as $r) {
            $raw = $r['dia_semana'] ?? $r['dia'] ?? '';
            $raw = is_string($raw) ? trim($raw) : '';
            $dia = $map[$raw] ?? (in_array($raw, $DAYS, true) ? $raw : null);
            if ($dia) $week[$dia][] = $r;
        }

        // Ordena por hora_inicio si existe
        foreach ($DAYS as $d) {
            usort($week[$d], function($a,$b){
                return strcmp($a['hora_inicio'] ?? '', $b['hora_inicio'] ?? '');
            });
        }
        return $week;
    }

    /* ===================== INDEX ===================== */
    public function index() {
        $this->requireLogin();

        $roles = $_SESSION['user']['roles'] ?? [];
        $user  = $_SESSION['user'];
        $scheduleModel = new Schedule();

        /* -------- ADMIN -------- */
        if (in_array('admin', $roles, true)) {
            // listado plano para admin
            $schedules = $scheduleModel->getAll();
            View::render('admin/schedule/index', 'admin', [
                'schedules' => $schedules
            ]);
            return;
        }

        /* -------- TEACHER -------- */
        if (in_array('teacher', $roles, true)) {
            // Preferente: método semanal
            if (method_exists($scheduleModel, 'getWeekByTeacher')) {
                $schedule = $scheduleModel->getWeekByTeacher((int)$user['id']);
            } else {
                // Fallback: traer plano y agrupar
                if (method_exists($scheduleModel, 'getByTeacher')) {
                    $rows = $scheduleModel->getByTeacher((int)$user['id']);
                } else {
                    // último recurso: filtrar manualmente si tu getAll acepta filters
                    $rows = $scheduleModel->getAll(['profesor_id' => (int)$user['id']]);
                }
                $schedule = $this->buildWeek($rows ?? []);
            }

            // 👉 Vista dentro de teacher/schedule/
            View::render('teacher/schedule/index', 'teacher', [
                'schedule' => $schedule
            ]);
            return;
        }

        /* -------- STUDENT -------- */
        if (in_array('student', $roles, true)) {
            if (method_exists($scheduleModel, 'getWeekByStudent')) {
                $schedule = $scheduleModel->getWeekByStudent((int)$user['id']);
            } else {
                // Fallback: si existe getByStudent, agrupar; si no, vacío
                if (method_exists($scheduleModel, 'getByStudent')) {
                    $rows = $scheduleModel->getByStudent((int)$user['id']);
                    $schedule = $this->buildWeek($rows ?? []);
                } else {
                    $schedule = ['Lun'=>[], 'Mar'=>[], 'Mie'=>[], 'Jue'=>[], 'Vie'=>[], 'Sab'=>[], 'Dom'=>[]];
                }
            }

            // 👉 Vista dentro de student/schedule/
            View::render('student/schedule/index', 'student', [
                'schedule' => $schedule
            ]);
            return;
        }

        // Rol desconocido
        header('Location: /src/plataforma/login'); exit;
    }

    /* ===================== CREAR ===================== */
    public function add() {
        $this->requireRole(['admin', 'teacher']);
        View::render('admin/schedule/add', 'admin');
    }

    public function store() {
        $this->requireRole(['admin', 'teacher']);

        $data = $_POST;
        $errors = [];

        // Validaciones básicas
        if (empty($data['periodo']))     $errors[] = 'El período es requerido.';
        if (empty($data['materia_id']))  $errors[] = 'La materia es requerida.';
        if (empty($data['profesor_id'])) $errors[] = 'El profesor es requerido.';
        if (empty($data['dia']))         $errors[] = 'El día es requerido.';
        if (empty($data['hora_inicio'])) $errors[] = 'La hora de inicio es requerida.';
        if (empty($data['hora_fin']))    $errors[] = 'La hora de fin es requerida.';
        if (empty($data['aula_id']))     $errors[] = 'El aula es requerida.';

        if ($errors) {
            header('Location: /src/plataforma/app/admin/schedule/add?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        $scheduleModel = new Schedule();
        $scheduleModel->create([
            'periodo'        => $data['periodo'],
            'grupo_id'       => $data['grupo_id'] ?? null,
            'materia_id'     => $data['materia_id'],
            'profesor_id'    => $data['profesor_id'],
            'dia'            => $data['dia'],          // en tu tabla puede guardarse como 'dia' o 'dia_semana'
            'hora_inicio'    => $data['hora_inicio'],
            'hora_fin'       => $data['hora_fin'],
            'aula_id'        => $data['aula_id'],
            'modalidad'      => $data['modalidad'] ?? 'presencial',
            'estado'         => $data['estado'] ?? 'activo',
            'tipo_clase'     => $data['tipo_clase'] ?? 'teorica',
            'duracion'       => $data['duracion'] ?? 60,
            'observaciones'  => $data['observaciones'] ?? '',
            'fecha_inicio'   => $data['fecha_inicio'] ?? null,
            'fecha_fin'      => $data['fecha_fin'] ?? null
        ]);

        header('Location: /src/plataforma/app/admin/schedule'); exit;
    }

    /* ===================== EDITAR ===================== */
    public function edit($id) {
        $this->requireRole(['admin', 'teacher']);

        $scheduleModel = new Schedule();
        // Tu modelo original no tenía findById; si usas getById, cámbialo aquí:
        $schedule = method_exists($scheduleModel, 'findById')
                  ? $scheduleModel->findById($id)
                  : (method_exists($scheduleModel, 'getById') ? $scheduleModel->getById($id) : null);

        if (!$schedule) {
            header('Location: /src/plataforma/app/admin/schedule'); exit;
        }

        View::render('admin/schedule/edit', 'admin', [
            'schedule' => $schedule
        ]);
    }

    public function update($id) {
        $this->requireRole(['admin', 'teacher']);

        $data = $_POST;
        $errors = [];

        if (empty($data['periodo']))     $errors[] = 'El período es requerido.';
        if (empty($data['materia_id']))  $errors[] = 'La materia es requerida.';
        if (empty($data['profesor_id'])) $errors[] = 'El profesor es requerido.';
        if (empty($data['dia']))         $errors[] = 'El día es requerido.';
        if (empty($data['hora_inicio'])) $errors[] = 'La hora de inicio es requerida.';
        if (empty($data['hora_fin']))    $errors[] = 'La hora de fin es requerida.';
        if (empty($data['aula_id']))     $errors[] = 'El aula es requerida.';

        if ($errors) {
            header('Location: /src/plataforma/app/admin/schedule/edit/' . $id . '?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        $updateData = [
            'periodo'        => $data['periodo'],
            'grupo_id'       => $data['grupo_id'] ?? null,
            'materia_id'     => $data['materia_id'],
            'profesor_id'    => $data['profesor_id'],
            'dia'            => $data['dia'],
            'hora_inicio'    => $data['hora_inicio'],
            'hora_fin'       => $data['hora_fin'],
            'aula_id'        => $data['aula_id'],
            'modalidad'      => $data['modalidad'] ?? 'presencial',
            'estado'         => $data['estado'] ?? 'activo',
            'tipo_clase'     => $data['tipo_clase'] ?? 'teorica',
            'duracion'       => $data['duracion'] ?? 60,
            'observaciones'  => $data['observaciones'] ?? '',
            'fecha_inicio'   => $data['fecha_inicio'] ?? null,
            'fecha_fin'      => $data['fecha_fin'] ?? null
        ];

        $scheduleModel = new Schedule();
        $scheduleModel->update($id, $updateData);

        header('Location: /src/plataforma/app/admin/schedule'); exit;
    }

    /* ===================== ELIMINAR ===================== */
    public function delete($id) {
        $this->requireRole(['admin', 'teacher']);

        $scheduleModel = new Schedule();
        $scheduleModel->delete($id);

        header('Location: /src/plataforma/app/admin/schedule'); exit;
    }
}
