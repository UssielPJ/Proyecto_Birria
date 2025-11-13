<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\CapturistaModel;
use PDO;

class CapturistasController
{
    private CapturistaModel $model;

    public function __construct(PDO $db)
    {
        $this->model = new CapturistaModel($db);
    }

    public function index(): void
    {
        $status = $_GET['status'] ?? null; // active/inactive/activo/inactivo
        $q = $_GET['q'] ?? null;
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = 20; $offset = ($page-1)*$limit;
        $rows = $this->model->list($limit, $offset, $status, $q);
        View::render('admin/capturistas/index', 'admin', [
            'rows' => $rows,
            'filters' => compact('status','q','page'),
        ]);
    }

    public function create(): void
    {
        View::render('admin/capturistas/create', 'admin', []);
    }

    public function store(): void
    {
        $user = [
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'nombre' => trim($_POST['nombre'] ?? ''),
            'apellido_paterno' => trim($_POST['apellido_paterno'] ?? ''),
            'apellido_materno' => trim($_POST['apellido_materno'] ?? ''),
            'telefono' => trim($_POST['telefono'] ?? ''),
            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? null,
            'status' => $_POST['status_user'] ?? 'active',
        ];
        $profile = [
            'numero_empleado' => trim($_POST['numero_empleado'] ?? ''),
            'curp' => strtoupper(trim($_POST['curp'] ?? '')),
            'fecha_ingreso' => $_POST['fecha_ingreso'] ?? null,
            'status' => $_POST['status_profile'] ?? $user['status'],
        ];

        $errors = $this->model->validate($user, $profile);
        if (empty($user['password'])) {
            $errors['password'] = 'Contraseña requerida.';
        }

        if ($errors) {
            View::render('admin/capturistas/create', 'admin', compact('errors','user','profile'));
            return;
        }

        try {
            $id = $this->model->create($user, $profile);
            header('Location: /admin/capturistas/'.$id.'?created=1');
        } catch (\Throwable $e) {
            $errors['general'] = 'Error al guardar: '.$e->getMessage();
            View::render('admin/capturistas/create', 'admin', compact('errors','user','profile'));
        }
    }

    public function show(int $id): void
    {
        $row = $this->model->find($id);
        if (!$row) { http_response_code(404); echo 'No encontrado'; return; }
        View::render('admin/capturistas/show', 'admin', compact('row'));
    }

    public function edit(int $id): void
    {
        $row = $this->model->find($id);
        if (!$row) { http_response_code(404); echo 'No encontrado'; return; }
        View::render('admin/capturistas/edit', 'admin', compact('row'));
    }

    public function update(int $id): void
    {
        $user = [
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '', // opcional
            'nombre' => trim($_POST['nombre'] ?? ''),
            'apellido_paterno' => trim($_POST['apellido_paterno'] ?? ''),
            'apellido_materno' => trim($_POST['apellido_materno'] ?? ''),
            'telefono' => trim($_POST['telefono'] ?? ''),
            'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? null,
            'status' => $_POST['status_user'] ?? 'active',
        ];
        $profile = [
            'numero_empleado' => trim($_POST['numero_empleado'] ?? ''),
            'curp' => strtoupper(trim($_POST['curp'] ?? '')),
            'fecha_ingreso' => $_POST['fecha_ingreso'] ?? null,
            'status' => $_POST['status_profile'] ?? $user['status'],
        ];

        $errors = $this->model->validate($user, $profile);
        if ($errors) {
            $row = array_merge($this->model->find($id) ?? [], $user, $profile);
            View::render('admin/capturistas/edit', 'admin', compact('errors','row'));
            return;
        }

        try {
            $ok = $this->model->update($id, $user, $profile);
            if ($ok) header('Location: /admin/capturistas/'.$id.'?updated=1');
            else { http_response_code(404); echo 'No encontrado'; }
        } catch (\Throwable $e) {
            $errors['general'] = 'Error al actualizar: '.$e->getMessage();
            $row = array_merge($this->model->find($id) ?? [], $user, $profile);
            View::render('admin/capturistas/edit', 'admin', compact('errors','row'));
        }
    }

    public function destroy(int $id): void
    {
        $hard = isset($_POST['hard']) && $_POST['hard'] == '1';
        try {
            $ok = $hard ? $this->model->hardDelete($id) : $this->model->softDelete($id);
            if ($ok) header('Location: /admin/capturistas?deleted=1');
            else { http_response_code(404); echo 'No encontrado'; }
        } catch (\Throwable $e) {
            http_response_code(500); echo 'Error al eliminar: '.$e->getMessage();
        }
    }
}
