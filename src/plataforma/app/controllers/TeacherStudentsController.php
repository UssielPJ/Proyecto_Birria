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
            if (in_array($r, $userRoles, true)) return;
        }
        header('Location: /src/plataforma/login');
        exit;
    }

    /* ======================================================
     * VISTA PRINCIPAL – Gestión de estudiantes
     * ====================================================== */
    public function index()
    {
        $this->requireRole(['teacher']);

        $db     = new Database();
        $userId = $_SESSION['user']['id'];

        // Obtener los grupos asignados al maestro
        $db->query("
            SELECT 
                g.id AS group_id,
                g.codigo,
                g.titulo AS grupo_titulo
            FROM materia_grupo_profesor mgp
            INNER JOIN materias_grupos mg ON mg.id = mgp.mg_id
            INNER JOIN grupos g ON g.id = mg.grupo_id
            WHERE mgp.teacher_user_id = ?
            GROUP BY g.id
            ORDER BY g.codigo ASC
        ", [$userId]);

        $grupos = $db->fetchAll(PDO::FETCH_OBJ);

        View::render('teacher/students/index', 'teacher', [
            'grupos' => $grupos
        ]);
    }

    /* ======================================================
     * AJAX – Obtener alumnos del grupo seleccionado
     * URL: /teacher/students/obtenerAlumnos?group_id=1
     * ====================================================== */
    public function obtenerAlumnos()
    {
        $this->requireRole(['teacher']);
        header('Content-Type: application/json; charset=utf-8');

        try {
            $groupId = isset($_GET['group_id']) ? (int)$_GET['group_id'] : 0;

            if ($groupId <= 0) {
                echo json_encode([
                    'ok' => false,
                    'msg' => 'Grupo inválido',
                    'alumnos' => []
                ]);
                return;
            }

            $db = new Database();

            $alumnos = $db->query("
                SELECT 
                    u.id AS user_id,
                    u.nombre,
                    u.apellido_paterno,
                    u.apellido_materno,
                    sp.matricula
                FROM student_profiles sp
                INNER JOIN users u ON u.id = sp.user_id
                WHERE sp.grupo_id = ?
                ORDER BY u.apellido_paterno, u.apellido_materno, u.nombre
            ", [$groupId])->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                'ok'      => true,
                'alumnos' => $alumnos
            ]);

        } catch (\Throwable $e) {
            echo json_encode([
                'ok'   => false,
                'msg'  => 'Error en el servidor',
                'debug'=> $e->getMessage()
            ]);
        }
    }
}
