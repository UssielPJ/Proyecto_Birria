<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;

class SemestersController
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

    /* ========== INDEX ========== */
    public function index() {
        $this->requireRole(['admin']);
        $db = new Database();

        // Trae semestres con la carrera (para listar bonito)
        $db->query("
            SELECT s.id, s.carrera_id, s.numero, s.clave,
                   c.nombre AS carrera_nombre, c.iniciales AS carrera_iniciales
            FROM semestres s
            LEFT JOIN carreras c ON c.id = s.carrera_id
            ORDER BY c.nombre ASC, s.numero ASC
        ");
        $semestres = $db->fetchAll(); // objetos

        View::render('admin/semesters/index', 'admin', ['semestres' => $semestres]);
    }

    /* ========== CREATE ========== */
    public function create() {
        $this->requireRole(['admin']);
        $db = new Database();

        // Necesitamos las carreras para el select
        $db->query("SELECT id, nombre, iniciales FROM carreras ORDER BY nombre ASC");
        $careers = $db->fetchAll();

        View::render('admin/semesters/create', 'admin', ['careers' => $careers]);
    }

    /* ========== STORE ========== */
public function store() {
    $this->requireRole(['admin']);
    if (session_status() === PHP_SESSION_NONE) session_start();

    $carrera_id = (int)($_POST['carrera_id'] ?? 0);
    $numero     = (int)($_POST['numero'] ?? 0);
    // $clave POST ya no es fuente de verdad; se recalcula en servidor
    $clavePost  = trim($_POST['clave'] ?? '');

    if ($carrera_id <= 0 || $numero <= 0) {
        $_SESSION['error'] = 'Carrera y número de semestre son obligatorios.';
        header('Location: /src/plataforma/app/admin/semesters/create'); exit;
    }
    if ($numero < 1 || $numero > 12) {
        $_SESSION['error'] = 'El número de semestre debe estar entre 1 y 12.';
        header('Location: /src/plataforma/app/admin/semesters/create'); exit;
    }

    $db = new Database();

    // Obtener iniciales de la carrera
    $db->query("SELECT id, iniciales FROM carreras WHERE id = ?", [$carrera_id]);
    $car = $db->fetch();
    if (!$car) {
        $_SESSION['error'] = 'La carrera seleccionada no existe.';
        header('Location: /src/plataforma/app/admin/semesters/create'); exit;
    }

    // **Recalcular clave en servidor**
    $ini   = strtoupper($car->iniciales ?? '');
    $clave = sprintf('%s-%02d', $ini, $numero);

    // Unicidad: (carrera_id, numero)
    $db->query("SELECT COUNT(*) AS c FROM semestres WHERE carrera_id = ? AND numero = ?", [$carrera_id, $numero]);
    if ((int)($db->fetch()->c ?? 0) > 0) {
        $_SESSION['error'] = 'Ya existe un semestre con ese número para la carrera seleccionada.';
        header('Location: /src/plataforma/app/admin/semesters/create'); exit;
    }

    // Unicidad: clave global
    $db->query("SELECT COUNT(*) AS c FROM semestres WHERE clave = ?", [$clave]);
    if ((int)($db->fetch()->c ?? 0) > 0) {
        $_SESSION['error'] = 'La clave generada ya está en uso.';
        header('Location: /src/plataforma/app/admin/semesters/create'); exit;
    }

    $db->query(
        "INSERT INTO semestres (carrera_id, numero, clave) VALUES (:cid, :num, :clv)",
        [':cid' => $carrera_id, ':num' => $numero, ':clv' => $clave]
    );

    $_SESSION['success'] = 'Semestre creado.';
    header('Location: /src/plataforma/app/admin/semesters'); exit;
}

    /* ========== EDIT ========== */
    public function edit($id) {
        $this->requireRole(['admin']);
        $id = (int)$id;

        $db = new Database();

        // Semestre
        $db->query("SELECT id, carrera_id, numero, clave FROM semestres WHERE id = ?", [$id]);
        $sem = $db->fetch();
        if (!$sem) {
            $_SESSION['error'] = 'Semestre no encontrado.';
            header('Location: /src/plataforma/app/admin/semesters'); exit;
        }

        // Carreras para el select
        $db->query("SELECT id, nombre, iniciales FROM carreras ORDER BY nombre ASC");
        $careers = $db->fetchAll();

        View::render('admin/semesters/edit', 'admin', ['semestre' => $sem, 'careers' => $careers]);
    }

   /* ========== UPDATE ========== */
public function update($id) {
    $this->requireRole(['admin']);
    if (session_status() === PHP_SESSION_NONE) session_start();

    $id         = (int)$id;
    $carrera_id = (int)($_POST['carrera_id'] ?? 0);
    $numero     = (int)($_POST['numero'] ?? 0);
    // El valor enviado de 'clave' se ignora; se recalcula
    $clavePost  = trim($_POST['clave'] ?? '');

    if ($id <= 0 || $carrera_id <= 0 || $numero <= 0) {
        $_SESSION['error'] = 'Datos inválidos.';
        header('Location: /src/plataforma/app/admin/semesters'); exit;
    }
    if ($numero < 1 || $numero > 12) {
        $_SESSION['error'] = 'El número de semestre debe estar entre 1 y 12.';
        header("Location: /src/plataforma/app/admin/semesters/edit/$id"); exit;
    }

    $db = new Database();

    // Existe el semestre
    $db->query("SELECT id FROM semestres WHERE id = ?", [$id]);
    if (!$db->fetch()) {
        $_SESSION['error'] = 'Semestre no encontrado.';
        header('Location: /src/plataforma/app/admin/semesters'); exit;
    }

    // Carrera válida + iniciales
    $db->query("SELECT id, iniciales FROM carreras WHERE id = ?", [$carrera_id]);
    $car = $db->fetch();
    if (!$car) {
        $_SESSION['error'] = 'La carrera seleccionada no existe.';
        header("Location: /src/plataforma/app/admin/semesters/edit/$id"); exit;
    }

    // **Recalcular clave en servidor**
    $ini   = strtoupper($car->iniciales ?? '');
    $clave = sprintf('%s-%02d', $ini, $numero);

    // Unicidad: (carrera_id, numero) excluyendo el actual
    $db->query(
        "SELECT COUNT(*) AS c FROM semestres WHERE carrera_id = ? AND numero = ? AND id <> ?",
        [$carrera_id, $numero, $id]
    );
    if ((int)($db->fetch()->c ?? 0) > 0) {
        $_SESSION['error'] = 'Ya existe un semestre con ese número para la carrera seleccionada.';
        header("Location: /src/plataforma/app/admin/semesters/edit/$id"); exit;
    }

    // Unicidad: clave global excluyendo el actual
    $db->query("SELECT COUNT(*) AS c FROM semestres WHERE clave = ? AND id <> ?", [$clave, $id]);
    if ((int)($db->fetch()->c ?? 0) > 0) {
        $_SESSION['error'] = 'La clave generada ya está en uso.';
        header("Location: /src/plataforma/app/admin/semesters/edit/$id"); exit;
    }

    $db->query(
        "UPDATE semestres SET carrera_id = :cid, numero = :num, clave = :clv WHERE id = :id",
        [':cid' => $carrera_id, ':num' => $numero, ':clv' => $clave, ':id' => $id]
    );

    $_SESSION['success'] = 'Semestre actualizado.';
    header('Location: /src/plataforma/app/admin/semesters'); exit;
}

    /* ========== DELETE ========== */
    public function delete($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $id = (int)$id;

        $db = new Database();
        try {
            $db->query("DELETE FROM semestres WHERE id = ?", [$id]);
            $_SESSION['success'] = 'Semestre eliminado.';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo eliminar el semestre.';
        }

        header('Location: /src/plataforma/app/admin/semesters'); exit;
    }
}
