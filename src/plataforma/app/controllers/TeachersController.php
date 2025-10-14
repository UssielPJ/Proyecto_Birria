<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use App\Models\Departamento;

class TeachersController
{
    /* ---------- Guards compatibles con la nueva sesión ---------- */
    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/login'); exit;
        }
    }

    private function requireRole(array $roles) {
        $this->requireLogin();
        $userRoles = $_SESSION['user']['roles'] ?? [];
        foreach ($roles as $r) {
            if (in_array($r, $userRoles, true)) return;
        }
        header('Location: /src/plataforma/login'); exit;
    }

    /* ===================== Listado ===================== */
    public function index() {
        $this->requireRole(['admin']);

        // Filtros
        $buscar       = $_GET['q'] ?? '';
        $departamento = $_GET['departamento'] ?? '';
        $estado       = $_GET['estado'] ?? '';
        $page         = max(1, (int)($_GET['page'] ?? 1));
        $limit        = 10;
        $offset       = ($page - 1) * $limit;

        $userModel = new User();

        // Nota: asumimos que tu User model ya está adaptado a la BD nueva.
        $teachers = $userModel->getTeachersWithFilters([
            'search'       => $buscar,
            'departamento' => $departamento,
            'estado'       => $estado,
            'limit'        => $limit,
            'offset'       => $offset
        ]);

        $total = $userModel->countTeachersWithFilters([
            'search'       => $buscar,
            'departamento' => $departamento,
            'estado'       => $estado
        ]);
        $totalPages   = $total > 0 ? (int)ceil($total / $limit) : 1;
        $departamentos = $userModel->getDistinctDepartamentos();

        View::render('admin/teachers/index', 'admin', [
            'teachers'      => $teachers,
            'buscar'        => $buscar,
            'departamento'  => $departamento,
            'estado'        => $estado,
            'page'          => $page,
            'totalPages'    => $totalPages,
            'total'         => $total,
            'departamentos' => $departamentos
        ]);
    }

    /* ===================== Crear ===================== */
    public function create() {
    $this->requireRole(['admin']); // o lo que uses
    $deps = (new Departamento())->allActive();

    \App\Core\View::render('admin/teachers/create', 'admin', [
        'departamentos' => $deps
    ]);
}

    public function store() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!\App\Core\Auth::check()) { header('Location: /src/plataforma/'); exit; }
    \App\Core\Gate::allow('admin');

    $d = $_POST;
    $errors = [];

    // Validaciones básicas
    if (empty($d['nombre']))  $errors[] = 'El nombre es requerido.';
    if (empty($d['email']) || !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
    if (empty($d['password'])) $errors[] = 'La contraseña es requerida.';
    if (!empty($d['password']) && ($d['password'] !== ($d['password_confirmation'] ?? ''))) {
        $errors[] = 'Las contraseñas no coinciden.';
    }
    if (!empty($errors)) {
        $_SESSION['error'] = implode(' ', $errors);
        header('Location: /src/plataforma/app/admin/teachers/create');
        exit;
    }

    $db = new \App\Core\Database();

    try {
        // Iniciar transacción (si tu Database la soporta; si no, omite estas 3 líneas)
        $db->query('START TRANSACTION');

        // 1) Crear usuario (tu tabla usa 'nombre')
        $db->query(
            "INSERT INTO users (nombre, email, password, status, created_at)
             VALUES (:n, :e, :p, 'active', NOW())",
            [
                ':n' => $d['nombre'],
                ':e' => $d['email'],
                ':p' => password_hash($d['password'], PASSWORD_DEFAULT),
            ]
        );

        // Obtener ID
        $db->query("SELECT LAST_INSERT_ID()");
        $userId = (int)$db->fetchColumn();

        // 2) Resolver departamento_id (acepta id o nombre)
        $departamentoId = null;
        if (!empty($d['departamento'])) {
            if (ctype_digit((string)$d['departamento'])) {
                $departamentoId = (int)$d['departamento'];
            } else {
                $db->query("SELECT id FROM departamentos WHERE nombre = :nom LIMIT 1", [':nom' => $d['departamento']]);
                $row = $db->fetch();
                $departamentoId = $row ? (int)$row->id : null;
            }
        }

        // Normalizar campos opcionales
        $numeroEmpleado    = $d['num_empleado']      ?? null;
        $especialidad      = $d['especialidad']      ?? null;
        $gradoAcademico    = $d['grado_academico']   ?? 'licenciatura';
        $nivelSni          = $d['nivel_sni']         ?? 'sin_nivel';       // según tu UI
        $perfilProdep      = isset($d['perfil_prodep']) ? 1 : 0;           // checkbox -> tinyint(1)
        $fechaContratacion = $d['fecha_ingreso']     ?? null;              // name del form; en DB es fecha_contratacion
        $tipoContrato      = $d['tipo_contrato']     ?? 'asignatura';

        // 3) Insert en teacher_profiles (solo columnas reales)
        $db->query(
            "INSERT INTO teacher_profiles
               (user_id, numero_empleado, especialidad, departamento_id, grado_academico,
                nivel_sni, perfil_prodep, fecha_contratacion, tipo_contrato, created_at)
             VALUES
               (:uid, :num, :esp, :dep, :grado, :sni, :prodep, :fcon, :tcon, NOW())",
            [
                ':uid'   => $userId,
                ':num'   => $numeroEmpleado,
                ':esp'   => $especialidad,
                ':dep'   => $departamentoId,
                ':grado' => $gradoAcademico,
                ':sni'   => $nivelSni,
                ':prodep'=> $perfilProdep,
                ':fcon'  => $fechaContratacion,
                ':tcon'  => $tipoContrato,
            ]
        );

        $db->query('COMMIT');

        $_SESSION['success'] = 'Profesor creado correctamente';
        header('Location: /src/plataforma/app/admin/teachers');
        exit;

    } catch (\Throwable $e) {
        // Rollback si fue iniciada la transacción
        try { $db->query('ROLLBACK'); } catch (\Throwable $ignored) {}
        error_log('TeachersController@store error: '.$e->getMessage());
        $_SESSION['error'] = 'No fue posible crear el profesor. Intenta de nuevo.';
        header('Location: /src/plataforma/app/admin/teachers/create');
        exit;
    }
}



    /* ===================== Editar ===================== */
    public function edit($id) {
        $this->requireRole(['admin']);

        $userModel = new User();
        $teacher   = $userModel->findById($id);

        if (!$teacher) {
            header('Location: /src/plataforma/app/admin/teachers'); exit;
        }

        View::render('admin/teachers/edit', 'admin', ['teacher' => $teacher]);
    }

    public function update($id) {
        $this->requireRole(['admin']);

        $data   = $_POST;
        $errors = [];

        if (empty($data['name']))  $errors[] = 'El nombre es requerido.';
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'El email no es válido.';
        if (empty($data['phone']))       $errors[] = 'El teléfono es requerido.';
        if (empty($data['specialty']))   $errors[] = 'La especialidad es requerida.';
        if (empty($data['department']))  $errors[] = 'El departamento es requerido.';
        if (empty($data['status']))      $errors[] = 'El estado es requerido.';

        if (!empty($data['password'])) {
            if (($data['password_confirmation'] ?? '') !== $data['password']) {
                $errors[] = 'Las contraseñas no coinciden.';
            } elseif (strlen($data['password']) < 6) {
                $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
            }
        }

        if (!empty($errors)) {
            header('Location: /src/plataforma/app/admin/teachers/edit/' . $id . '?error=' . urlencode(implode(' ', $errors)));
            exit;
        }

        $updateData = [
            'name'        => $data['name'],
            'email'       => $data['email'],
            'phone'       => $data['phone'],
            'specialty'   => $data['specialty'],
            'department'  => $data['department'],
            'status'      => $data['status'],
        ];
        if (!empty($data['password'])) {
            $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $userModel = new User();
        $userModel->update($id, $updateData);

        header('Location: /src/plataforma/app/admin/teachers'); exit;
    }

    /* ===================== Eliminar ===================== */
    public function delete($id) {
        $this->requireRole(['admin']);
        $userModel = new User();
        $userModel->delete($id);
        header('Location: /src/plataforma/app/admin/teachers'); exit;
    }

    /* ===================== Exportar ===================== */
    public function export() {
        $this->requireRole(['admin']);

        $format       = $_GET['format'] ?? 'csv';
        $buscar       = $_GET['q'] ?? '';
        $departamento = $_GET['departamento'] ?? '';
        $estado       = $_GET['estado'] ?? '';

        $userModel = new User();
        $teachers = $userModel->getTeachersWithFilters([
            'search'       => $buscar,
            'departamento' => $departamento,
            'estado'       => $estado,
            'limit'        => 10000,
            'offset'       => 0
        ]);

        if ($format === 'csv') {
            $this->exportCSV($teachers);
        } else {
            header('Location: /src/plataforma/app/admin/teachers'); exit;
        }
    }

    private function exportCSV($teachers) {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=profesores_' . date('Y-m-d_H-i-s') . '.csv');
        $out = fopen('php://output', 'w');

        // BOM UTF-8
        fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($out, [
            'ID','Nombre','Email','Teléfono','Especialidad','Departamento',
            'Número de Empleado','Estado','Creado'
        ]);

        foreach ($teachers as $t) {
            fputcsv($out, [
                $t->id, $t->name, $t->email,
                $t->phone ?? '', $t->specialty ?? '', $t->department ?? '',
                $t->num_empleado ?? '', $t->status ?? '', $t->created_at ?? ''
            ]);
        }

        fclose($out);
        exit;
    }

    
}

