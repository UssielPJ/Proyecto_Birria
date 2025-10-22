<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;

class GroupsController
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

        $db->query("SELECT gs.*, s.clave AS semestre_clave
                    FROM grupos_semestre gs
                    JOIN semestres s ON s.id = gs.semestre_id
                    ORDER BY s.clave, gs.codigo");
        $grupos = $db->fetchAll();

        // para selects
        $db->query("SELECT s.id, s.clave FROM semestres s ORDER BY s.clave");
        $semestres = $db->fetchAll();

        View::render('admin/groups/index', 'admin', [
            'grupos' => $grupos,
            'semestres' => $semestres
        ]);
    }

    public function create() {
        $this->requireRole(['admin']);
        $db = new Database();
        $db->query("SELECT s.id, s.clave FROM semestres s ORDER BY s.clave");
        $semestres = $db->fetchAll();
        View::render('admin/groups/create', 'admin', ['semestres'=>$semestres]);
    }

    public function store() {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $d = $_POST;
        $db = new Database();

        try {
            $semestre_id = (int)($d['semestre_id'] ?? 0);
            $capacidad   = (int)($d['capacidad'] ?? 30);
            if ($semestre_id <= 0) throw new \Exception('Semestre inválido');

            // generar siguiente código: IS3-01, IS3-02...
            $db->query("SELECT s.clave FROM semestres s WHERE s.id = ?", [$semestre_id]);
            $sem = $db->fetch();
            if (!$sem) throw new \Exception('Semestre no encontrado');

            $db->query("SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(codigo,'-',-1) AS UNSIGNED)),0) AS maxc
                        FROM grupos_semestre WHERE semestre_id = ?", [$semestre_id]);
            $next = (int)$db->fetchColumn() + 1;
            $codigo = preg_replace('/-/', '', $sem->clave) . '-' . str_pad((string)$next, 2, '0', STR_PAD_LEFT);

            $db->query("INSERT INTO grupos_semestre (semestre_id, codigo, capacidad, inscritos, status, created_at)
                        VALUES (:sid, :cod, :cap, 0, 'activo', NOW())", [
                ':sid'=>$semestre_id, ':cod'=>$codigo, ':cap'=>$capacidad
            ]);

            $_SESSION['success'] = "Grupo creado: $codigo";
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo crear el grupo: '.$e->getMessage();
        }
        header('Location: /src/plataforma/app/admin/groups'); exit;
    }

    public function edit($id) {
        $this->requireRole(['admin']);
        $db = new Database();
        $db->query("SELECT * FROM grupos_semestre WHERE id = ?", [$id]);
        $grupo = $db->fetch();

        $db->query("SELECT id, clave FROM semestres ORDER BY clave");
        $semestres = $db->fetchAll();

        View::render('admin/groups/edit', 'admin', [
            'grupo'=>$grupo, 'semestres'=>$semestres
        ]);
    }

    public function update($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $d = $_POST; $db = new Database();
        try {
            $db->query("UPDATE grupos_semestre SET
                        semestre_id = :sid,
                        codigo = :cod,
                        capacidad = :cap,
                        status = :st,
                        updated_at = NOW()
                        WHERE id = :id", [
                ':sid'=>(int)$d['semestre_id'],
                ':cod'=>trim($d['codigo']),
                ':cap'=>(int)($d['capacidad'] ?? 30),
                ':st' => $d['status'] ?? 'activo',
                ':id' => $id
            ]);
            $_SESSION['success'] = 'Grupo actualizado.';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo actualizar: '.$e->getMessage();
        }
        header('Location: /src/plataforma/app/admin/groups'); exit;
    }

    public function delete($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $db = new Database();
        try { $db->query("DELETE FROM grupos_semestre WHERE id = ?", [$id]); $_SESSION['success']='Grupo eliminado.'; }
        catch (\Throwable $e) { $_SESSION['error']='No se pudo eliminar.'; }
        header('Location: /src/plataforma/app/admin/groups'); exit;
    }
}
