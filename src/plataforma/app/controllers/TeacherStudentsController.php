<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;
use PDO;

class TeacherStudentsController
{
    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/login');
            exit;
        }
    }

    private function requireRole(array $roles) {
        $this->requireLogin();
        $userRoles = $_SESSION['user']['roles'] ?? [];
        foreach ($roles as $r) {
            if (in_array($r, $userRoles, true)) {
                return;
            }
        }
        header('Location: /src/plataforma/login');
        exit;
    }

    /* ========= VISTA PRINCIPAL ========= */
    public function index() {
        $this->requireRole(['teacher']);

        $db     = new Database();
        $userId = $_SESSION['user']['id'];

        // Grupos asignados al maestro (FETCH_ASSOC)
        $db->query("
            SELECT g.*
            FROM materia_grupo_profesor mgp
            INNER JOIN materias_grupos mg ON mg.id = mgp.mg_id
            INNER JOIN grupos g ON g.id = mg.grupo_id
            WHERE mgp.teacher_user_id = ?
            GROUP BY g.id
            ORDER BY g.id
        ", [$userId]);

        $gruposAsignados = $db->fetchAll(PDO::FETCH_ASSOC);

        View::render('teacher/students/index', 'teacher', [
            'title'           => 'Gestión de Estudiantes',
            'gruposAsignados' => $gruposAsignados,
        ]);
    }

    /* ========= SELECCIONAR ACCIÓN ========= */
    public function seleccionar() {
        $this->requireRole(['teacher']);

        $tipo    = $_GET['tipo']     ?? null;
        $grupoId = $_GET['grupo_id'] ?? null;

        if (!$tipo || !$grupoId) {
            header('Location: /src/plataforma/app/teacher/students');
            exit;
        }

        if ($tipo === 'calificaciones') {
            header('Location: /src/plataforma/app/teacher/grades?grupo_id='.(int)$grupoId);
            exit;
        }

        if ($tipo === 'asistencia') {
            return $this->asistenciaVista((int)$grupoId);
        }

        header('Location: /src/plataforma/app/teacher/students');
        exit;
    }

    /* ========= VISTA ASISTENCIA ========= */
    private function asistenciaVista(int $grupoId) {
        $this->requireRole(['teacher']);

        $db = new Database();

        $db->query("
            SELECT u.id, u.nombre
            FROM student_profiles sp
            INNER JOIN users u ON u.id = sp.user_id
            WHERE sp.grupo_id = ?
            ORDER BY u.nombre
        ", [$grupoId]);

        $alumnos = $db->fetchAll(PDO::FETCH_ASSOC);

        View::render('teacher/students/asistencia', 'teacher', [
            'title'   => 'Registro de Asistencia',
            'grupoId' => $grupoId,
            'alumnos' => $alumnos,
        ]);
    }

    /* ========= GUARDAR ASISTENCIA ========= */
    public function guardarAsistencia() {
        $this->requireRole(['teacher']);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $grupoId = (int)($_POST['grupo_id'] ?? 0);
        $fecha   = $_POST['fecha'] ?? null;
        $alumnos = $_POST['alumnos'] ?? [];

        if (!$grupoId || !$fecha || empty($alumnos)) {
            $_SESSION['error'] = 'Faltan datos para registrar la asistencia.';
            header('Location: /src/plataforma/app/teacher/students');
            exit;
        }

        $db = new Database();

        foreach ($alumnos as $alumnoId => $estado) {
            $alumnoId = (int)$alumnoId;
            $estado   = trim((string)$estado);
            if (!$alumnoId || $estado === '') continue;

            $db->query("
                INSERT INTO asistencias (alumno_id, grupo_id, fecha, estado, created_at)
                VALUES (?, ?, ?, ?, NOW())
            ", [$alumnoId, $grupoId, $fecha, $estado]);
        }

        $_SESSION['success'] = 'Asistencia registrada correctamente.';
        header('Location: /src/plataforma/app/teacher/students');
        exit;
    }
}
