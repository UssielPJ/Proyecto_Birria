<?php
namespace App\Controllers;

use App\Core\Database;
use App\Core\View;

class AttendanceController
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
public function index()
{
    $this->requireRole(['teacher']);

    $db = new Database();

    // ID del usuario docente logueado
    $teacherUserId = $_SESSION['user']['id'];

    $grupos = $db->query("
        SELECT 
            mgp.id              AS asignacion_id,
            g.id                AS group_id,
            g.codigo            AS grupo,
            g.titulo            AS grupo_titulo,
            m.id                AS materia_id,
            m.nombre            AS materia
        FROM materia_grupo_profesor mgp
        INNER JOIN materias_grupos mg ON mg.id = mgp.mg_id
        INNER JOIN grupos g          ON g.id = mg.grupo_id
        INNER JOIN materias m        ON m.id = mg.materia_id
        WHERE mgp.teacher_user_id = ?
        ORDER BY g.codigo ASC, m.nombre ASC
    ", [$teacherUserId])->fetchAll();

View::render('teacher/attendance/index', 'teacher', [
    'grupos' => $grupos
]);

}


    /* ========= AJAX: OBTENER ALUMNOS DEL GRUPO ========= */
public function obtenerAlumnos()
{
    $this->requireRole(['teacher']);

    header('Content-Type: application/json; charset=utf-8');

    try {
        $groupId = isset($_GET['group_id']) ? (int)$_GET['group_id'] : 0;

        if ($groupId <= 0) {
            echo json_encode(['ok' => false, 'alumnos' => [], 'msg' => 'Grupo inválido']);
            return;
        }

        $db = new Database();

        $alumnos = $db->query("
            SELECT 
                u.id         AS user_id,
                u.nombre     AS nombre,
                u.apellido_paterno  AS apellido_paterno
            FROM student_profiles sp
            INNER JOIN users u ON u.id = sp.user_id
            WHERE sp.grupo_id = ?
            ORDER BY u.apellidos ASC, u.nombre ASC
        ", [$groupId])->fetchAll();

        echo json_encode([
            'ok'      => true,
            'alumnos' => $alumnos,
        ]);
    } catch (\Throwable $e) {
        echo json_encode([
            'ok'         => false,
            'msg'        => 'Error en el servidor al obtener alumnos',
            'error_debug'=> $e->getMessage(),
        ]);
    }
}



    /* ========= AJAX: GUARDAR ASISTENCIA ========= */
    public function save()
    {
        $this->requireRole(['teacher']);

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['ok' => false, 'msg' => 'Método no permitido']);
            return;
        }

        $db       = new Database();
        $groupId  = isset($_POST['group_id']) ? (int)$_POST['group_id'] : 0;
        $fecha    = $_POST['fecha'] ?? null;
        $asistencia = $_POST['asistencia'] ?? [];

        if ($groupId <= 0 || empty($fecha)) {
            echo json_encode(['ok' => false, 'msg' => 'Grupo o fecha inválidos']);
            return;
        }

        // Normalizar estados válidos
        $validStates = ['asistio', 'falta', 'retardo'];

        // Para no mezclar registros viejos, se limpia primero la asistencia de ese día
        // y grupo, luego se inserta lo nuevo
        foreach ($asistencia as $alumnoId => $estado) {
            $alumnoId = (int)$alumnoId;
            if (!in_array($estado, $validStates, true)) {
                $estado = 'falta';
            }

            // Eliminamos cualquier registro previo del mismo alumno/grupo/fecha
            $db->query("
                DELETE FROM asistencias
                WHERE alumno_id = ? AND grupo_id = ? AND fecha = ?
            ", [$alumnoId, $groupId, $fecha]);

            // Insertamos el nuevo registro
            $db->query("
                INSERT INTO asistencias (alumno_id, grupo_id, fecha, estado)
                VALUES (?, ?, ?, ?)
            ", [$alumnoId, $groupId, $fecha, $estado]);
        }

        echo json_encode(['ok' => true, 'msg' => 'Asistencia guardada correctamente']);
    }
}
