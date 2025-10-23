<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;

class ClassesController
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

        $db->query("SELECT g.*, m.clave AS materia_clave, m.nombre AS materia_nombre, p.nombre AS periodo_nombre, u.nombre AS profesor_nombre
                    FROM grupos g
                    JOIN materias m ON m.id = g.materia_id
                    JOIN periodos p ON p.id = g.periodo_id
                    JOIN users u ON u.id = g.profesor_id
                    ORDER BY p.id DESC, m.nombre ASC, g.clave_grupo ASC");
        $clases = $db->fetchAll();

        // selects
        $db->query("SELECT id, clave, nombre FROM materias WHERE status='activa' ORDER BY nombre");
        $materias = $db->fetchAll();
        $db->query("SELECT id, nombre FROM periodos ORDER BY id DESC");
        $periodos = $db->fetchAll();
        $db->query("SELECT u.id, u.nombre FROM users u JOIN teacher_profiles tp ON tp.user_id = u.id ORDER BY u.nombre");
        $profes = $db->fetchAll();

        View::render('admin/classes/index', 'admin', [
            'clases'=>$clases, 'materias'=>$materias, 'periodos'=>$periodos, 'profes'=>$profes
        ]);
    }

    public function store() {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $d = $_POST; $db = new Database();

        try {
            $db->query("INSERT INTO grupos
                        (materia_id, periodo_id, profesor_id, clave_grupo, cupo_maximo, inscritos, aula, horario, modalidad, status, created_at)
                        VALUES (:m, :p, :t, :c, :cup, 0, :aula, :hor, :mod, :st, NOW())", [
                ':m'=>(int)$d['materia_id'],
                ':p'=>(int)$d['periodo_id'],
                ':t'=>(int)$d['profesor_id'],
                ':c'=>trim($d['clave_grupo']),
                ':cup'=>(int)($d['cupo_maximo'] ?? 30),
                ':aula'=>$d['aula'] ?? null,
                ':hor'=>$d['horario'] ?? null,
                ':mod'=>$d['modalidad'] ?? 'presencial',
                ':st' =>$d['status'] ?? 'activo'
            ]);
            $_SESSION['success'] = 'Clase creada.';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo crear: '.$e->getMessage();
        }
        header('Location: /src/plataforma/app/admin/classes'); exit;
    }

    public function edit($id) {
        $this->requireRole(['admin']);
        $db = new Database();
        $db->query("SELECT * FROM grupos WHERE id = ?", [$id]); $g = $db->fetch();

        $db->query("SELECT id, clave, nombre FROM materias WHERE status='activa' ORDER BY nombre");
        $materias = $db->fetchAll();
        $db->query("SELECT id, nombre FROM periodos ORDER BY id DESC");
        $periodos = $db->fetchAll();
        $db->query("SELECT u.id, u.nombre FROM users u JOIN teacher_profiles tp ON tp.user_id = u.id ORDER BY u.nombre");
        $profes = $db->fetchAll();

        View::render('admin/classes/edit', 'admin', [
            'clase'=>$g, 'materias'=>$materias, 'periodos'=>$periodos, 'profes'=>$profes
        ]);
    }

    public function update($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $d = $_POST; $db = new Database();
        try {
            $db->query("UPDATE grupos SET
                        materia_id=:m, periodo_id=:p, profesor_id=:t,
                        clave_grupo=:c, cupo_maximo=:cup, aula=:aula, horario=:hor,
                        modalidad=:mod, status=:st, updated_at=NOW()
                        WHERE id=:id", [
                ':m'=>(int)$d['materia_id'],
                ':p'=>(int)$d['periodo_id'],
                ':t'=>(int)$d['profesor_id'],
                ':c'=>trim($d['clave_grupo']),
                ':cup'=>(int)($d['cupo_maximo'] ?? 30),
                ':aula'=>$d['aula'] ?? null,
                ':hor'=>$d['horario'] ?? null,
                ':mod'=>$d['modalidad'] ?? 'presencial',
                ':st' =>$d['status'] ?? 'activo',
                ':id' =>$id
            ]);
            $_SESSION['success'] = 'Clase actualizada.';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo actualizar.';
        }
        header('Location: /src/plataforma/app/admin/classes'); exit;
    }

    public function delete($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $db = new Database();
        try { $db->query("DELETE FROM grupos WHERE id = ?", [$id]); $_SESSION['success']='Clase eliminada.'; }
        catch (\Throwable $e) { $_SESSION['error']='No se pudo eliminar.'; }
        header('Location: /src/plataforma/app/admin/classes'); exit;
    }
}
