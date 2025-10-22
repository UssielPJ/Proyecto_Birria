<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;

class CareersController
{
    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/login'); exit;
        }
    }

    private function requireRole(array $roles) {
        $this->requireLogin();
        $userRoles = $_SESSION['user']['roles'] ?? [];
        foreach ($roles as $r) if (in_array($r, $userRoles, true)) return;
        header('Location: /src/plataforma/login'); exit;
    }

    /* ===================== INDEX ===================== */
    public function index() {
        $this->requireRole(['admin']);
        $db = new Database();
        $db->query("SELECT id, nombre, iniciales, status, created_at FROM carreras ORDER BY nombre ASC");
        $careers = $db->fetchAll(); // objetos
        View::render('admin/careers/index', 'admin', ['careers' => $careers]);
    }

    /* ===================== CREATE ===================== */
    public function create() {
        $this->requireRole(['admin']);
        View::render('admin/careers/create', 'admin');
    }

    /* ===================== STORE ===================== */
    public function store() {
    $this->requireRole(['admin']);
    if (session_status() === PHP_SESSION_NONE) session_start();

    $nombre    = trim($_POST['nombre'] ?? '');
    $iniciales = strtoupper(trim($_POST['iniciales'] ?? ''));
    $rawStatus = $_POST['status'] ?? 'activa'; // por defecto activa

    // Normaliza a los únicos valores válidos del ENUM español:
    $rawStatus = strtolower((string)$rawStatus);
    $status    = ($rawStatus === 'inactiva') ? 'inactiva' : 'activa';

    if ($nombre === '' || $iniciales === '') {
        $_SESSION['error'] = 'Nombre e iniciales son obligatorios.';
        header('Location: /src/plataforma/app/admin/careers/create'); exit;
    }

    $db = new Database();

    // Unicidad
    $db->query("SELECT COUNT(*) AS c FROM carreras WHERE nombre = ?", [$nombre]);
    if ((int)($db->fetch()->c ?? 0) > 0) {
        $_SESSION['error'] = 'Ya existe una carrera con ese nombre.';
        header('Location: /src/plataforma/app/admin/careers/create'); exit;
    }
    $db->query("SELECT COUNT(*) AS c FROM carreras WHERE iniciales = ?", [$iniciales]);
    if ((int)($db->fetch()->c ?? 0) > 0) {
        $_SESSION['error'] = 'Las iniciales ya están en uso.';
        header('Location: /src/plataforma/app/admin/careers/create'); exit;
    }

    // Insert (ENUM espera 'activa'/'inactiva')
    $db->query(
        "INSERT INTO carreras (nombre, iniciales, status) VALUES (:n, :i, :s)",
        [':n' => $nombre, ':i' => $iniciales, ':s' => $status]
    );

    $_SESSION['success'] = 'Carrera creada.';
    header('Location: /src/plataforma/app/admin/careers'); exit;
}



    /* ===================== EDIT ===================== */
public function edit($id) {
    $this->requireRole(['admin']);
    $id = (int)$id;

    $db = new Database();
    $db->query("SELECT id, nombre, iniciales, status, created_at FROM carreras WHERE id = ?", [$id]);
    $career = $db->fetch(); // objeto (PDO::FETCH_OBJ)

    if (!$career) {
        header('Location: /src/plataforma/app/admin/careers?error=not_found'); exit;
    }

    View::render('admin/careers/edit', 'admin', ['career' => $career]);
}


    /* ===================== UPDATE ===================== */
   public function update($id) {
    $this->requireRole(['admin']);
    if (session_status() === PHP_SESSION_NONE) session_start();

    $id        = (int)$id;
    $nombre    = trim($_POST['nombre'] ?? '');
    $iniciales = strtoupper(trim($_POST['iniciales'] ?? ''));
    $rawStatus = $_POST['status'] ?? 'activa';

    $rawStatus = strtolower((string)$rawStatus);
    $status    = ($rawStatus === 'inactiva') ? 'inactiva' : 'activa';

    if ($id <= 0 || $nombre === '' || $iniciales === '') {
        $_SESSION['error'] = 'Datos inválidos.';
        header('Location: /src/plataforma/app/admin/careers'); exit;
    }

    $db = new Database();

    // existencia
    $db->query("SELECT id FROM carreras WHERE id = ?", [$id]);
    if (!$db->fetch()) {
        $_SESSION['error'] = 'Carrera no encontrada.';
        header('Location: /src/plataforma/app/admin/careers'); exit;
    }

    // unicidad
    $db->query("SELECT COUNT(*) AS c FROM carreras WHERE nombre = ? AND id <> ?", [$nombre, $id]);
    if ((int)($db->fetch()->c ?? 0) > 0) {
        $_SESSION['error'] = 'Ya existe una carrera con ese nombre.';
        header("Location: /src/plataforma/app/admin/careers/edit/$id"); exit;
    }
    $db->query("SELECT COUNT(*) AS c FROM carreras WHERE iniciales = ? AND id <> ?", [$iniciales, $id]);
    if ((int)($db->fetch()->c ?? 0) > 0) {
        $_SESSION['error'] = 'Las iniciales ya están en uso.';
        header("Location: /src/plataforma/app/admin/careers/edit/$id"); exit;
    }

    $db->query(
        "UPDATE carreras SET nombre=:n, iniciales=:i, status=:s WHERE id=:id",
        [':n'=>$nombre, ':i'=>$iniciales, ':s'=>$status, ':id'=>$id]
    );

    $_SESSION['success'] = 'Carrera actualizada.';
    header('Location: /src/plataforma/app/admin/careers'); exit;
}



    /* ===================== DELETE ===================== */
    public function delete($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $id = (int)$id;

        $db = new Database();
        try {
            $db->query("DELETE FROM carreras WHERE id = ?", [$id]);
            $_SESSION['success'] = 'Carrera eliminada.';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo eliminar la carrera.';
        }

        header('Location: /src/plataforma/app/admin/careers'); exit;
    }
}
