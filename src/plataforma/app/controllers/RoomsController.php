<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;

class RoomsController
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
        $db->query("SELECT * FROM salones ORDER BY clave");
        $rooms = $db->fetchAll();
        View::render('admin/rooms/index', 'admin', ['rooms'=>$rooms]);
    }

    public function store() {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $d = $_POST; $db = new Database();
        try {
            $db->query("INSERT INTO salones (clave, nombre, capacidad, tipo, status, created_at)
                        VALUES (:c, :n, :cap, :t, :st, NOW())", [
                ':c'=>trim($d['clave']),
                ':n'=>trim($d['nombre']),
                ':cap'=>(int)($d['capacidad'] ?? 0),
                ':t'=>$d['tipo'] ?? 'aula',
                ':st'=>$d['status'] ?? 'activo'
            ]);
            $_SESSION['success']='Salón creado.';
        } catch (\Throwable $e) {
            $_SESSION['error']='No se pudo crear: '.$e->getMessage();
        }
        header('Location: /src/plataforma/app/admin/rooms'); exit;
    }

    public function edit($id) {
        $this->requireRole(['admin']);
        $db = new Database();
        $db->query("SELECT * FROM salones WHERE id = ?", [$id]);
        $room = $db->fetch();
        View::render('admin/rooms/edit', 'admin', ['room'=>$room]);
    }

    public function update($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $d = $_POST; $db = new Database();
        try {
            $db->query("UPDATE salones SET
                        clave=:c, nombre=:n, capacidad=:cap, tipo=:t, status=:st, updated_at=NOW()
                        WHERE id = :id", [
                ':c'=>trim($d['clave']),
                ':n'=>trim($d['nombre']),
                ':cap'=>(int)($d['capacidad'] ?? 0),
                ':t'=>$d['tipo'] ?? 'aula',
                ':st'=>$d['status'] ?? 'activo',
                ':id'=>$id
            ]);
            $_SESSION['success']='Salón actualizado.';
        } catch (\Throwable $e) {
            $_SESSION['error']='No se pudo actualizar.';
        }
        header('Location: /src/plataforma/app/admin/rooms'); exit;
    }

    public function delete($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $db = new Database();
        try { $db->query("DELETE FROM salones WHERE id = ?", [$id]); $_SESSION['success']='Salón eliminado.'; }
        catch (\Throwable $e) { $_SESSION['error']='No se pudo eliminar.'; }
        header('Location: /src/plataforma/app/admin/rooms'); exit;
    }
}
