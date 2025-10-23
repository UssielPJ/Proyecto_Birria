<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;

class PeriodsController
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
        $db->query("SELECT * FROM periodos ORDER BY id DESC");
        $periodos = $db->fetchAll();
        View::render('admin/periods/index', 'admin', ['periodos'=>$periodos]);
    }

    public function store() {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $d = $_POST; $db = new Database();

        try {
            $db->query("INSERT INTO periodos (nombre, fecha_inicio, fecha_fin, status, created_at)
                        VALUES (:n, :fi, :ff, :st, NOW())", [
                ':n'=>trim($d['nombre']),
                ':fi'=>$d['fecha_inicio'] ?? null,
                ':ff'=>$d['fecha_fin'] ?? null,
                ':st'=>$d['status'] ?? 'activo'
            ]);
            $_SESSION['success'] = 'Periodo creado.';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo crear: '.$e->getMessage();
        }
        header('Location: /src/plataforma/app/admin/periods'); exit;
    }

    public function edit($id) {
        $this->requireRole(['admin']);
        $db = new Database();
        $db->query("SELECT * FROM periodos WHERE id = ?", [$id]);
        $periodo = $db->fetch();
        View::render('admin/periods/edit', 'admin', ['periodo'=>$periodo]);
    }

    public function update($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $d = $_POST; $db = new Database();

        try {
            $db->query("UPDATE periodos SET
                        nombre=:n, fecha_inicio=:fi, fecha_fin=:ff, status=:st, updated_at=NOW()
                        WHERE id=:id", [
                ':n'=>trim($d['nombre']),
                ':fi'=>$d['fecha_inicio'] ?? null,
                ':ff'=>$d['fecha_fin'] ?? null,
                ':st'=>$d['status'] ?? 'activo',
                ':id'=>$id
            ]);
            $_SESSION['success'] = 'Periodo actualizado.';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo actualizar.';
        }
        header('Location: /src/plataforma/app/admin/periods'); exit;
    }

    public function delete($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $db = new Database();
        try { $db->query("DELETE FROM periodos WHERE id = ?", [$id]); $_SESSION['success']='Periodo eliminado.'; }
        catch (\Throwable $e) { $_SESSION['error']='No se pudo eliminar.'; }
        header('Location: /src/plataforma/app/admin/periods'); exit;
    }
}
