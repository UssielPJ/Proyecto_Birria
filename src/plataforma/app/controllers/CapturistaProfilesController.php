<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use App\Models\CapturistaProfile;

class CapturistaProfilesController {

    /* ===== Helpers internos ===== */

    /**
     * Normaliza $db a PDO (acepta PDO o tu wrapper App\Core\Database)
     */
    private function toPdo($db): \PDO {
        if ($db instanceof \PDO) return $db;
        if (is_object($db) && method_exists($db, 'getPdo')) return $db->getPdo();
        // Último recurso: si alguien pasó null u otro tipo
        return (new \App\Core\Database())->getPdo();
    }

    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
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

    /* ===== Listado ===== */

    public function index() {
        $this->requireRole(['admin']);
        $user  = $_SESSION['user'];
        $roles = $_SESSION['user']['roles'];

        // Filtros
        $buscar = $_GET['q']     ?? '';
        $status = $_GET['status'] ?? '';
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $limit  = 10;
        $offset = ($page - 1) * $limit;

        $profileModel = new CapturistaProfile();
        $capturistas  = $profileModel->getAllWithUser([
            'search' => $buscar,
            'status' => $status,
            'limit'  => $limit,
            'offset' => $offset
        ]);

        $total = count($profileModel->getAllWithUser([
            'search' => $buscar,
            'status' => $status
        ]));

        $totalPages = $total > 0 ? (int)ceil($total / $limit) : 1;

        View::render('admin/capturistas/index', 'admin', [
            'capturistas' => $capturistas,
            'buscar'      => $buscar,
            'status'      => $status,
            'page'        => $page,
            'totalPages'  => $totalPages,
            'total'       => $total
        ]);
    }

    /* ===== Formularios ===== */

    public function create() {
        $this->requireRole(['admin']);

        View::render('admin/capturistas/create', 'admin', []);
    }

    /* ===== Crear ===== */

    public function store() {
        $this->requireRole(['admin']);
        $d = $_POST;

        // ===== Validación =====
        $errors = [];
        if (empty($d['email']) || !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
        if (empty($d['password'])) $errors[] = 'La contraseña es requerida.';
        if (($d['password'] ?? '') !== ($d['password_confirmation'] ?? '')) $errors[] = 'Las contraseñas no coinciden.';
        if (empty($d['nombre'])) $errors[] = 'El nombre es requerido.';
        if (empty($d['numero_empleado'])) $errors[] = 'El número de empleado es requerido.';
        if (empty($d['curp'])) $errors[] = 'La CURP es requerida.';
        if (empty($d['fecha_ingreso'])) $errors[] = 'La fecha de ingreso es requerida.';

        if ($errors) {
            header('Location: /src/plataforma/app/admin/capturistas/create?error='.urlencode(implode(' ', $errors)));
            exit;
        }

        $userModel = new User();
        $pdo = $this->toPdo($userModel->getDb());
        $pdo->beginTransaction();

        try {
            // Pre-chequeos duplicados
            $st = $pdo->prepare("SELECT 1 FROM users WHERE email = ? LIMIT 1");
            $st->execute([$d['email']]);
            if ($st->fetch()) throw new \RuntimeException('El email ya está en uso.');

            $st = $pdo->prepare("SELECT 1 FROM capturista_profiles WHERE numero_empleado = ? LIMIT 1");
            $st->execute([$d['numero_empleado']]);
            if ($st->fetch()) throw new \RuntimeException('El número de empleado ya existe.');

            $st = $pdo->prepare("SELECT 1 FROM capturista_profiles WHERE curp = ? LIMIT 1");
            $st->execute([$d['curp']]);
            if ($st->fetch()) throw new \RuntimeException('La CURP ya existe.');

            // === INSERT users ===
            $userId = $userModel->create([
                'email'            => $d['email'],
                'password'         => $d['password'],
                'nombre'           => $d['nombre'],
                'apellido_paterno' => $d['apellido_paterno'] ?? null,
                'apellido_materno' => $d['apellido_materno'] ?? null,
                'telefono'         => $d['telefono'] ?? null,
                'fecha_nacimiento' => $d['fecha_nacimiento'] ?? null,
                'status'           => $d['status'] ?? 'active',
                'role'             => 'capturista'
            ]);

            // === INSERT profile ===
            $profileModel = new CapturistaProfile($pdo);
            $profileModel->create([
                'user_id'         => $userId,
                'numero_empleado' => $d['numero_empleado'],
                'telefono'        => $d['telefono'] ?? null,
                'curp'            => $d['curp'],
                'fecha_ingreso'   => $d['fecha_ingreso'],
                'status'          => $d['capturista_status'] ?? 'activo',
            ]);

            $pdo->commit();
            header('Location: /src/plataforma/app/admin/capturistas?created=1');
            exit;

        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            error_log('CapturistaProfilesController@store ERROR: '.$e->getMessage());
            header('Location: /src/plataforma/app/admin/capturistas/create?error='.urlencode('No se pudo crear: '.$e->getMessage()));
            exit;
        }
    }

    /* ===== Editar ===== */

    public function edit($id) {
        $this->requireRole(['admin']);

        $userModel    = new User();
        $profileModel = new CapturistaProfile();

        $user = $userModel->findById((int)$id);
        if (!$user) { header('Location: /src/plataforma/app/admin/capturistas'); exit; }

        $profile = $profileModel->findByUserId((int)$id);

        View::render('admin/capturistas/edit', 'admin', [
            'user'    => $user,
            'profile' => $profile,
        ]);
    }

    /* ===== Actualizar ===== */

    public function update($id) {
        $this->requireRole(['admin']);
        $id = (int)$id;
        $d  = $_POST;

        // ===== Validación =====
        $errors = [];
        if (empty($d['email']) || !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
        if (empty($d['nombre'])) $errors[] = 'El nombre es requerido.';
        if (!empty($d['password']) && ($d['password'] !== ($d['password_confirmation'] ?? ''))) {
            $errors[] = 'Las contraseñas no coinciden.';
        }
        if (empty($d['numero_empleado'])) $errors[] = 'El número de empleado es requerido.';
        if (empty($d['curp'])) $errors[] = 'La CURP es requerida.';
        if (empty($d['fecha_ingreso'])) $errors[] = 'La fecha de ingreso es requerida.';

        if ($errors) {
            header('Location: /src/plataforma/app/admin/capturistas/edit/'.$id.'?error='.urlencode(implode(' ', $errors)));
            exit;
        }

        $userModel = new User();
        $pdo = $this->toPdo($userModel->getDb());
        $pdo->beginTransaction();

        try {
            // Validar unicidad
            $st = $pdo->prepare("SELECT 1 FROM users WHERE email = ? AND id <> ? LIMIT 1");
            $st->execute([$d['email'], $id]);
            if ($st->fetch()) throw new \RuntimeException('El email ya está en uso por otro usuario.');

            $st = $pdo->prepare("SELECT 1 FROM capturista_profiles WHERE numero_empleado = ? AND user_id <> ? LIMIT 1");
            $st->execute([$d['numero_empleado'], $id]);
            if ($st->fetch()) throw new \RuntimeException('El número de empleado ya pertenece a otro capturista.');

            $st = $pdo->prepare("SELECT 1 FROM capturista_profiles WHERE curp = ? AND user_id <> ? LIMIT 1");
            $st->execute([$d['curp'], $id]);
            if ($st->fetch()) throw new \RuntimeException('La CURP ya pertenece a otro capturista.');

            // === UPDATE users ===
            $userUpdate = [
                'email'            => $d['email'],
                'nombre'           => $d['nombre'],
                'apellido_paterno' => $d['apellido_paterno'] ?? null,
                'apellido_materno' => $d['apellido_materno'] ?? null,
                'telefono'         => $d['telefono'] ?? null,
                'fecha_nacimiento' => $d['fecha_nacimiento'] ?? null,
                'status'           => $d['status'] ?? 'active',
            ];
            if (!empty($d['password'])) {
                $userUpdate['password'] = $d['password'];
            }
            $userModel->update($id, $userUpdate);

            // === UPSERT profile ===
            $profileModel = new CapturistaProfile($pdo);
            $exists = $pdo->prepare("SELECT 1 FROM capturista_profiles WHERE user_id = ? LIMIT 1");
            $exists->execute([$id]);

            $payload = [
                'numero_empleado' => $d['numero_empleado'],
                'telefono'        => $d['telefono'] ?? null,
                'curp'            => $d['curp'],
                'fecha_ingreso'   => $d['fecha_ingreso'],
                'status'          => $d['capturista_status'] ?? 'activo',
            ];

            if ($exists->fetch()) {
                $profileModel->updateByUserId($id, $payload);
            } else {
                $payload['user_id'] = $id;
                $profileModel->create($payload);
            }

            $pdo->commit();
            header('Location: /src/plataforma/app/admin/capturistas?updated=1');
            exit;

        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            error_log('CapturistaProfilesController@update ERROR: '.$e->getMessage());
            header('Location: /src/plataforma/app/admin/capturistas/edit/'.$id.'?error='.urlencode('No se pudo actualizar: '.$e->getMessage()));
            exit;
        }
    }

    /* ===== Eliminar ===== */

    public function delete($id) {
        $this->requireRole(['admin']);
        $userModel = new User();
        $userModel->delete((int)$id);
        header('Location: /src/plataforma/app/admin/capturistas');
        exit;
    }
}