<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;
use PDO;

class CareersController
{
    /* --------- Guards --------- */
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

    /** Expone el PDO como $GLOBALS['pdo'] para vistas legacy que usan "global $pdo" */
    private function exposePdo(Database $db): void {
        if (!function_exists('get_class')) return; // nada, solo evitar warnings raros
        $GLOBALS['pdo'] = $db->pdo();  // <-- clave para evitar "prepare() on null"
    }

    /* ================== INDEX ================== */
    public function index() {
        $this->requireRole(['admin']);
        $db = new Database();

        // (Opcional) puedes precargar datos si tu vista los usa por variables;
        // la mayoría de tus vistas hacen sus propias consultas con $pdo, así que no es obligatorio.
        // $db->query("SELECT id, nombre, iniciales FROM carreras ORDER BY nombre ASC");
        // $careers = $db->fetchAll(PDO::FETCH_OBJ);

        $this->exposePdo($db); // <-- evita el fatal en la vista

        View::render('admin/careers/index', 'admin', [
            // 'careers' => $careers ?? [],
        ]);
    }

    /* ================== CREATE ================== */
    public function create() {
        $this->requireRole(['admin']);
        $db = new Database();

        $this->exposePdo($db); // por si la vista usa $pdo
        View::render('admin/careers/create', 'admin', []);
    }

    /* ================== STORE ================== */
    public function store() {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();

        $d  = $_POST;
        $db = new Database();

        try {
            $nombre    = trim($d['nombre']    ?? '');
            $iniciales = trim($d['iniciales'] ?? '');
            $clave     = trim($d['clave']     ?? null); // si tu tabla la tiene

            if ($nombre === '' || $iniciales === '') {
                throw new \InvalidArgumentException('Nombre e iniciales son obligatorios.');
            }

            // Ajusta columnas a tu schema real de "carreras"
            if ($clave !== null && $clave !== '') {
                $db->query("
                    INSERT INTO carreras (nombre, iniciales, clave, created_at)
                    VALUES (:n, :i, :c, NOW())
                ", [':n'=>$nombre, ':i'=>$iniciales, ':c'=>$clave]);
            } else {
                $db->query("
                    INSERT INTO carreras (nombre, iniciales, created_at)
                    VALUES (:n, :i, NOW())
                ", [':n'=>$nombre, ':i'=>$iniciales]);
            }

            $_SESSION['success'] = 'Carrera creada.';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo crear: '.$e->getMessage();
        }

        header('Location: /src/plataforma/app/admin/careers'); exit;
    }

    /* ================== EDIT ================== */
    public function edit($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();

        $id = (int)$id;
        if ($id <= 0) { $_SESSION['error']='ID inválido.'; header('Location: /src/plataforma/app/admin/careers'); exit; }

        $db = new Database();

        $db->query("SELECT * FROM carreras WHERE id = :id LIMIT 1", [':id'=>$id]);
        $career = $db->fetch(PDO::FETCH_ASSOC);
        if (!$career) { $_SESSION['error']='Carrera no encontrada.'; header('Location: /src/plataforma/app/admin/careers'); exit; }

        $this->exposePdo($db); // por si la vista usa $pdo
        View::render('admin/careers/edit', 'admin', ['career'=>$career]);
    }

    /* ================== UPDATE ================== */
    public function update($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();

        $id = (int)$id;
        $db = new Database();
        $d  = $_POST;

        try {
            $db->query("SELECT * FROM carreras WHERE id = ?", [$id]);
            $actual = $db->fetch();
            if (!$actual) throw new \RuntimeException('Carrera no encontrada.');

            $nombre    = trim($d['nombre']    ?? $actual->nombre);
            $iniciales = trim($d['iniciales'] ?? ($actual->iniciales ?? ''));
            $clave     = array_key_exists('clave', $d) ? trim((string)$d['clave']) : (property_exists($actual,'clave') ? $actual->clave : null);

            if ($nombre === '' || $iniciales === '') {
                throw new \InvalidArgumentException('Nombre e iniciales son obligatorios.');
            }

            if ($clave !== null) {
                $db->query("
                    UPDATE carreras
                    SET nombre = :n, iniciales = :i, clave = :c
                    WHERE id = :id
                ", [':n'=>$nombre, ':i'=>$iniciales, ':c'=>$clave, ':id'=>$id]);
            } else {
                $db->query("
                    UPDATE carreras
                    SET nombre = :n, iniciales = :i
                    WHERE id = :id
                ", [':n'=>$nombre, ':i'=>$iniciales, ':id'=>$id]);
            }

            $_SESSION['success'] = 'Carrera actualizada.';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo actualizar: '.$e->getMessage();
        }

        header('Location: /src/plataforma/app/admin/careers'); exit;
    }

    /* ================== DELETE ================== */
    public function delete($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();

        $db = new Database();
        try {
            $db->query("DELETE FROM carreras WHERE id = ?", [(int)$id]);
            $_SESSION['success'] = 'Carrera eliminada.';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo eliminar.';
        }

        header('Location: /src/plataforma/app/admin/careers'); exit;
    }
}
