<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;

class GroupAssignmentsController
{
    /* ===== Auth ===== */
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
    private function flashTo(string $path, string $type, string $msg) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['flash'] = ['type'=>$type, 'msg'=>$msg];
        header("Location: {$path}"); exit;
    }

    /* Recalcula inscritos a partir de student_profiles (fuente de verdad) */
    private function recalcInscritos(Database $db, int $grupo_id): void {
        $db->query("SELECT COUNT(*) FROM student_profiles WHERE grupo_id = :gid", [':gid'=>$grupo_id]);
        $ins = (int)$db->fetchColumn();
        $db->query("UPDATE grupos SET inscritos = :i WHERE id = :gid", [':i'=>$ins, ':gid'=>$grupo_id]);
    }

    /* ========== UI principal: filtrar por semestre, elegir grupo, ver listas ========== */
    public function index() {
        $this->requireRole(['admin']);
        $db = new Database();

        // Combos de semestres
        $db->query("SELECT id, clave FROM semestres ORDER BY clave ASC");
        $semestres = $db->fetchAll(\PDO::FETCH_ASSOC);

        $sid = (int)($_GET['semestre_id'] ?? 0);
        $gid = (int)($_GET['grupo_id'] ?? 0);

        // Grupos del semestre seleccionado
        $grupos = [];
        if ($sid > 0) {
            $db->query("SELECT id, codigo, titulo, capacidad, inscritos
                        FROM grupos
                        WHERE semestre_id = :sid
                        ORDER BY titulo ASC, codigo ASC", [':sid'=>$sid]);
            $grupos = $db->fetchAll(\PDO::FETCH_ASSOC);
        }

        // Alumnos sin grupo en ese semestre (disponibles)
        $disponibles = [];
        if ($sid > 0) {
            $db->query("SELECT u.id AS user_id, sp.matricula,
                               u.nombre, u.apellido_paterno, u.apellido_materno
                        FROM student_profiles sp
                        JOIN users u ON u.id = sp.user_id
                        WHERE sp.semestre_id = :sid
                          AND sp.grupo_id IS NULL
                        ORDER BY u.apellido_paterno, u.apellido_materno, u.nombre",
                        [':sid'=>$sid]);
            $disponibles = $db->fetchAll(\PDO::FETCH_ASSOC);
        }

        // Alumnos asignados al grupo seleccionado
        $asignados = [];
        if ($gid > 0) {
            $db->query("SELECT u.id AS user_id, sp.matricula,
                               u.nombre, u.apellido_paterno, u.apellido_materno
                        FROM student_profiles sp
                        JOIN users u ON u.id = sp.user_id
                        WHERE sp.grupo_id = :gid
                        ORDER BY u.apellido_paterno, u.apellido_materno, u.nombre",
                        [':gid'=>$gid]);
            $asignados = $db->fetchAll(\PDO::FETCH_ASSOC);
        }

        View::render('admin/group_assignments/index', 'admin', [
            'semestres'   => $semestres,
            'grupos'      => $grupos,
            'disponibles' => $disponibles,
            'asignados'   => $asignados,
            'semestre_id' => $sid,
            'grupo_id'    => $gid,
        ]);
    }

    /* ========== Asignar alumnos seleccionados a un grupo ========== */
    public function assign() {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $db = new Database();

        $grupo_id = (int)($_POST['grupo_id'] ?? 0);
        $alumnos  = $_POST['alumnos'] ?? [];   // array de user_id
        $sid      = (int)($_POST['semestre_id'] ?? 0);

        if ($grupo_id <= 0 || empty($alumnos)) {
            $this->flashTo('/src/plataforma/app/admin/group_assignments?semestre_id='.$sid, 'error', 'Selecciona grupo y al menos un alumno.');
        }

        // Meta del grupo
        $db->query("SELECT g.id, g.capacidad, s.id AS semestre_id, c.id AS carrera_id
                    FROM grupos g
                    LEFT JOIN semestres s ON s.id = g.semestre_id
                    LEFT JOIN carreras  c ON c.id = s.carrera_id
                    WHERE g.id = :gid", [':gid'=>$grupo_id]);
        $grupo = $db->fetch(\PDO::FETCH_ASSOC);
        if (!$grupo) {
            $this->flashTo('/src/plataforma/app/admin/group_assignments?semestre_id='.$sid, 'error', 'Grupo inválido.');
        }

        // Cupo ocupado real (COUNT)
        $db->query("SELECT COUNT(*) FROM student_profiles WHERE grupo_id = :gid", [':gid'=>$grupo_id]);
        $ocupados  = (int)$db->fetchColumn();
        $capacidad = (int)($grupo['capacidad'] ?? 0);

        $asignados = 0;
        $omitidos  = 0;

        try {
            $db->query('START TRANSACTION');

            foreach ($alumnos as $uidRaw) {
                $uid = (int)$uidRaw;

                // Elegible: mismo semestre y sin grupo actualmente
                $db->query("SELECT user_id FROM student_profiles
                            WHERE user_id = :u AND semestre_id = :sid AND grupo_id IS NULL",
                           [':u'=>$uid, ':sid'=>($sid ?: $grupo['semestre_id'])]);
                if (!$db->fetch()) { $omitidos++; continue; }

                // Capacidad
                if ($capacidad > 0 && $ocupados >= $capacidad) { $omitidos++; continue; }

                // Asignar y sincronizar semestre/carrera por consistencia
                $db->query("UPDATE student_profiles
                            SET grupo_id = :gid, semestre_id = :sid, carrera_id = :cid, updated_at = NOW()
                            WHERE user_id = :u",
                           [':gid'=>$grupo_id,
                            ':sid'=>($grupo['semestre_id'] ?? null),
                            ':cid'=>($grupo['carrera_id']  ?? null),
                            ':u'=>$uid]);

                $ocupados++;
                $asignados++;
            }

            // Recalcular inscritos en 'grupos'
            $this->recalcInscritos($db, $grupo_id);

            $db->query('COMMIT');
        } catch (\Throwable $e) {
            try { $db->query('ROLLBACK'); } catch (\Throwable $ignored) {}
            $this->flashTo('/src/plataforma/app/admin/group_assignments?semestre_id='.$sid.'&grupo_id='.$grupo_id,
                           'error', 'No se pudo asignar: '.$e->getMessage());
        }

        $msg = "Asignados: {$asignados}";
        if ($omitidos > 0) $msg .= " · Omitidos: {$omitidos}";
        $this->flashTo('/src/plataforma/app/admin/group_assignments?semestre_id='.$sid.'&grupo_id='.$grupo_id,
                       'success', $msg);
    }

    /* ========== Quitar un alumno del grupo ========== */
    public function unassign() {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $db = new Database();

        $uid      = (int)($_POST['user_id'] ?? 0);
        $grupo_id = (int)($_POST['grupo_id'] ?? 0);
        $sid      = (int)($_POST['semestre_id'] ?? 0);

        if ($uid <= 0 || $grupo_id <= 0) {
            $this->flashTo('/src/plataforma/app/admin/group_assignments?semestre_id='.$sid, 'error', 'Parámetros inválidos.');
        }

        try {
            $db->query('START TRANSACTION');

            // Solo quita si pertenece a ese grupo
            $db->query("UPDATE student_profiles
                        SET grupo_id = NULL, updated_at = NOW()
                        WHERE user_id = :u AND grupo_id = :gid",
                       [':u'=>$uid, ':gid'=>$grupo_id]);

            // Recalcula inscritos
            $this->recalcInscritos($db, $grupo_id);

            $db->query('COMMIT');
            $this->flashTo('/src/plataforma/app/admin/group_assignments?semestre_id='.$sid.'&grupo_id='.$grupo_id,
                           'success', 'Alumno removido del grupo.');
        } catch (\Throwable $e) {
            try { $db->query('ROLLBACK'); } catch (\Throwable $ignored) {}
            $this->flashTo('/src/plataforma/app/admin/group_assignments?semestre_id='.$sid.'&grupo_id='.$grupo_id,
                           'error', 'No se pudo remover: '.$e->getMessage());
        }
    }
}
