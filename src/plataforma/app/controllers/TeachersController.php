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

    $db = new \App\Core\Database();

    $db->query("
        SELECT
            u.id,
            u.nombre,
            u.email,
            u.status,
            tp.numero_empleado,
            tp.rfc,
            tp.especialidad,
            tp.departamento_id,
            tp.grado_academico,
            tp.fecha_contratacion,
            tp.tipo_contrato,
            tp.nivel_sni,
            tp.perfil_prodep
        FROM users u
        LEFT JOIN teacher_profiles tp ON tp.user_id = u.id
        WHERE u.id = :id
        LIMIT 1
    ", [':id' => $id]);

    $teacher = $db->fetch();
    if (!$teacher) { header('Location: /src/plataforma/app/admin/teachers'); exit; }

    $deps = (new Departamento())->allActive();

    View::render('admin/teachers/edit', 'admin', [
        'teacher' => $teacher,
        'departamentos' => $deps
    ]);
}


    public function update($id) {
    $this->requireRole(['admin']);
    if (session_status() === PHP_SESSION_NONE) session_start();

    $d = $_POST;
    $errors = [];

    // Validaciones mínimas
    if (empty($d['nombre']))  $errors[] = 'El nombre es requerido.';
    if (empty($d['email']) || !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
    if (!empty($d['password']) && ($d['password'] !== ($d['password_confirmation'] ?? ''))) {
        $errors[] = 'Las contraseñas no coinciden.';
    }

    // Enums permitidos
    $gradoEnum = ['licenciatura','maestria','doctorado','esp']; // ajusta a tus valores reales
    $tipoEnum  = ['tiempo_completo','medio_tiempo','por_horas']; // ajusta a tus valores reales
    $sniEnum   = ['sin_nivel','candidato','nivel1','nivel2','nivel3']; // ajusta a tus valores reales

    if (!empty($d['grado_academico']) && !in_array($d['grado_academico'], $gradoEnum, true)) {
        $errors[] = 'Grado académico inválido.';
    }
    if (!empty($d['tipo_contrato']) && !in_array($d['tipo_contrato'], $tipoEnum, true)) {
        $errors[] = 'Tipo de contrato inválido.';
    }
    if (!empty($d['nivel_sni']) && !in_array($d['nivel_sni'], $sniEnum, true)) {
        $errors[] = 'Nivel SNI inválido.';
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode(' ', $errors);
        header('Location: /src/plataforma/app/admin/teachers/edit/'.$id);
        exit;
    }

    $db = new \App\Core\Database();

    try {
        $db->query('START TRANSACTION');

        // 1) Users
        $paramsUser = [
            ':id' => $id,
            ':n'  => $d['nombre'],
            ':e'  => $d['email'],
            ':s'  => $d['status'] ?? 'active',
        ];
        $sqlUser = "UPDATE users SET nombre = :n, email = :e, status = :s";
        if (!empty($d['password'])) {
            $sqlUser .= ", password = :p";
            $paramsUser[':p'] = password_hash($d['password'], PASSWORD_DEFAULT);
        }
        $sqlUser .= " WHERE id = :id";
        $db->query($sqlUser, $paramsUser);

        // 2) Teacher profile (upsert simple)
        $db->query("SELECT COUNT(*) FROM teacher_profiles WHERE user_id = :id", [':id' => $id]);
        $exists = (int)$db->fetchColumn() > 0;

        $paramsTp = [
            ':uid'  => $id,
            ':num'  => $d['numero_empleado'] ?? null,
            ':rfc'  => $d['rfc'] ?? null,
            ':dep'  => !empty($d['departamento_id']) ? (int)$d['departamento_id'] : null,
            ':grado'=> $d['grado_academico'] ?? null,
            ':esp'  => $d['especialidad'] ?? null,
            ':fcon' => $d['fecha_contratacion'] ?? null,
            ':tcon' => $d['tipo_contrato'] ?? null,
            ':sni'  => $d['nivel_sni'] ?? null,
            ':pro'  => isset($d['perfil_prodep']) ? 1 : 0,
        ];

        if ($exists) {
            $db->query("
                UPDATE teacher_profiles SET
                    numero_empleado = :num,
                    rfc = :rfc,
                    departamento_id = :dep,
                    grado_academico = :grado,
                    especialidad = :esp,
                    fecha_contratacion = :fcon,
                    tipo_contrato = :tcon,
                    nivel_sni = :sni,
                    perfil_prodep = :pro,
                    updated_at = NOW()
                WHERE user_id = :uid
            ", $paramsTp);
        } else {
            $db->query("
                INSERT INTO teacher_profiles
                    (user_id, numero_empleado, rfc, departamento_id, grado_academico, especialidad,
                     fecha_contratacion, tipo_contrato, nivel_sni, perfil_prodep, created_at)
                VALUES
                    (:uid, :num, :rfc, :dep, :grado, :esp, :fcon, :tcon, :sni, :pro, NOW())
            ", $paramsTp);
        }

        $db->query('COMMIT');
        $_SESSION['success'] = 'Profesor actualizado correctamente.';
        header('Location: /src/plataforma/app/admin/teachers'); exit;

    } catch (\Throwable $e) {
        try { $db->query('ROLLBACK'); } catch (\Throwable $ignored) {}
        error_log('TeachersController@update error: '.$e->getMessage());
        $_SESSION['error'] = 'No fue posible actualizar el profesor.';
        header('Location: /src/plataforma/app/admin/teachers/edit/'.$id); exit;
    }
}


    /* ===================== Eliminar ===================== */
    public function delete($id) {
    $this->requireRole(['admin']);
    if (session_status() === PHP_SESSION_NONE) session_start();

    $db = new \App\Core\Database();
    try {
        $db->query('START TRANSACTION');
        // Si no tienes ON DELETE CASCADE, elimina el profile primero:
        $db->query("DELETE FROM teacher_profiles WHERE user_id = :id", [':id' => $id]);
        // Baja lógica en users (recomendado) o física:
        $db->query("UPDATE users SET status = 'inactive' WHERE id = :id", [':id' => $id]);
        $db->query('COMMIT');
        $_SESSION['success'] = 'Profesor eliminado.';
    } catch (\Throwable $e) {
        try { $db->query('ROLLBACK'); } catch (\Throwable $ignored) {}
        $_SESSION['error'] = 'No fue posible eliminar el registro.';
    }
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
    fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

    fputcsv($out, [
        'ID','Nombre','Email','Estado','Número Empleado','RFC','Departamento',
        'Grado Académico','Especialidad','Fecha Contratación','Tipo Contrato','Nivel SNI','PRODEP'
    ]);

    foreach ($teachers as $t) {
        fputcsv($out, [
            $t->id,
            $t->nombre ?? '',
            $t->email ?? '',
            $t->status ?? '',
            $t->numero_empleado ?? '',
            $t->rfc ?? '',
            $t->departamento ?? '',
            $t->grado_academico ?? '',
            $t->especialidad ?? '',
            $t->fecha_contratacion ?? '',
            $t->tipo_contrato ?? '',
            $t->nivel_sni ?? '',
            isset($t->perfil_prodep) ? (int)$t->perfil_prodep : ''
        ]);
    }
    fclose($out); exit;
}


    
}

