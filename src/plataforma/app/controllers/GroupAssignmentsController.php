<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;

class GroupAssignmentsController
{
    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) { header('Location: /src/plataforma/login'); exit; }
    }
    private function requireRole(array $roles) {
        $this->requireLogin();
        $userRoles = $_SESSION['user']['roles'] ?? [];
        foreach ($roles as $r) if (in_array($r, $userRoles, true)) return;
        header('Location: /src/plataforma/login'); exit;
    }

    public function index() {
        $this->requireRole(['admin']);
        $db = new Database();

        // selects
        $db->query("SELECT s.id, s.clave FROM semestres s ORDER BY s.clave");
        $semestres = $db->fetchAll();

        $sid = (int)($_GET['semestre_id'] ?? 0);

        $grupos = [];
        if ($sid > 0) {
            $db->query("SELECT * FROM grupos_semestre WHERE semestre_id = ? ORDER BY codigo", [$sid]);
            $grupos = $db->fetchAll();
        }

        // alumnos sin grupo en ese semestre
        $alumnos = [];
        if ($sid > 0) {
            $db->query("SELECT u.id, u.nombre, u.apellido_paterno, u.apellido_materno, sp.user_id
                        FROM student_profiles sp
                        JOIN users u ON u.id = sp.user_id
                        WHERE sp.semestre_id = :sid AND sp.grupo_semestre_id IS NULL
                        ORDER BY u.apellido_paterno, u.nombre", [':sid'=>$sid]);
            $alumnos = $db->fetchAll();
        }

        View::render('admin/group_assignments/index', 'admin', [
            'semestres'=>$semestres,
            'grupos'=>$grupos,
            'alumnos'=>$alumnos,
            'semestre_id'=>$sid
        ]);
    }

    public function assign() {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $db = new Database();

        $grupo_id = (int)($_POST['grupo_id'] ?? 0);
        $ids      = $_POST['alumnos'] ?? [];   // array de user_id

        if ($grupo_id <= 0 || empty($ids)) {
            $_SESSION['error'] = 'Selecciona grupo y al menos un alumno.';
            header('Location: /src/plataforma/app/admin/group_assignments'); exit;
        }

        try {
            $db->query('START TRANSACTION');

            // datos del grupo
            $db->query("SELECT gs.*, s.carrera_id, s.id AS semestre_id
                        FROM grupos_semestre gs
                        JOIN semestres s ON s.id = gs.semestre_id
                        WHERE gs.id = ?", [$grupo_id]);
            $g = $db->fetch();
            if (!$g) throw new \Exception('Grupo inválido');

            $inscritos = (int)$g->inscritos; $cap = (int)$g->capacidad;

            foreach ($ids as $uid) {
                // valida elegibilidad: mismo semestre
                $db->query("SELECT user_id FROM student_profiles WHERE user_id = :u AND semestre_id = :sid",
                    [':u'=>(int)$uid, ':sid'=>(int)$g->semestre_id]);
                if (!$db->fetch()) continue; // ignora no elegibles

                if ($inscritos >= $cap) {
                    // crea siguiente grupo automáticamente
                    $db->query("SELECT s.clave FROM semestres s WHERE s.id = ?", [$g->semestre_id]);
                    $sem = $db->fetch();
                    $db->query("SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(codigo,'-',-1) AS UNSIGNED)),0)+1
                                FROM grupos_semestre WHERE semestre_id = ?", [$g->semestre_id]);
                    $next = (int)$db->fetchColumn();
                    $codigo = preg_replace('/-/', '', $sem->clave) . '-' . str_pad((string)$next, 2, '0', STR_PAD_LEFT);
                    $db->query("INSERT INTO grupos_semestre (semestre_id, codigo, capacidad, inscritos, status, created_at)
                                VALUES (:sid, :cod, :cap, 0, 'activo', NOW())", [
                        ':sid'=>$g->semestre_id, ':cod'=>$codigo, ':cap'=>$cap
                    ]);
                    // recarga g
                    $db->query("SELECT * FROM grupos_semestre WHERE semestre_id = :sid AND codigo = :cod",
                        [':sid'=>$g->semestre_id, ':cod'=>$codigo]);
                    $g = $db->fetch();
                    $grupo_id = (int)$g->id;
                    $inscritos = (int)$g->inscritos;
                }

                // asigna alumno
                $db->query("UPDATE student_profiles SET grupo_semestre_id = :gid, updated_at = NOW()
                            WHERE user_id = :uid", [':gid'=>$grupo_id, ':uid'=>(int)$uid]);
                $inscritos++;
                $db->query("UPDATE grupos_semestre SET inscritos = :i, updated_at = NOW()
                            WHERE id = :gid", [':i'=>$inscritos, ':gid'=>$grupo_id]);
            }

            $db->query('COMMIT');
            $_SESSION['success'] = 'Asignación realizada.';
        } catch (\Throwable $e) {
            try { $db->query('ROLLBACK'); } catch (\Throwable $ignored) {}
            $_SESSION['error'] = 'No se pudo asignar: '.$e->getMessage();
        }

        header('Location: /src/plataforma/app/admin/group_assignments'); exit;
    }

    public function unassign() {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $db = new Database();

        $uid = (int)($_POST['user_id'] ?? 0);
        if ($uid <= 0) { $_SESSION['error']='Alumno inválido.'; header('Location: /src/plataforma/app/admin/group_assignments'); exit; }

        try {
            $db->query('START TRANSACTION');
            // obtener grupo actual para decrementar inscritos
            $db->query("SELECT grupo_semestre_id FROM student_profiles WHERE user_id = ?", [$uid]);
            $gid = (int)$db->fetchColumn();

            $db->query("UPDATE student_profiles SET grupo_semestre_id = NULL, updated_at = NOW() WHERE user_id = ?", [$uid]);
            if ($gid > 0) {
                $db->query("UPDATE grupos_semestre SET inscritos = GREATEST(inscritos-1,0), updated_at = NOW() WHERE id = ?", [$gid]);
            }
            $db->query('COMMIT');
            $_SESSION['success'] = 'Alumno removido del grupo.';
        } catch (\Throwable $e) {
            try { $db->query('ROLLBACK'); } catch (\Throwable $ignored) {}
            $_SESSION['error'] = 'No se pudo remover.';
        }
        header('Location: /src/plataforma/app/admin/group_assignments'); exit;
    }
}
