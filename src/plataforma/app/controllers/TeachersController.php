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
    $this->requireRole(['admin']);
    if (session_status() === PHP_SESSION_NONE) session_start();

    $d = $_POST;
    $errors = [];

    /* ========== Validaciones (users) ========== */
    if (empty($d['nombre']))             $errors[] = 'El nombre es requerido.';
    if (empty($d['apellido_paterno']))   $errors[] = 'El apellido paterno es requerido.';
    if (empty($d['apellido_materno']))   $errors[] = 'El apellido materno es requerido.';
    if (empty($d['email']) || !filter_var($d['email'], FILTER_VALIDATE_EMAIL))
        $errors[] = 'Email inválido.';
    if (empty($d['password']))           $errors[] = 'La contraseña es requerida.';
    if (!empty($d['password']) && ($d['password_confirmation'] ?? '') !== $d['password'])
        $errors[] = 'Las contraseñas no coinciden.';
    if (!empty($d['telefono']) && !preg_match('/^[0-9\s+\-()]{7,20}$/', $d['telefono']))
        $errors[] = 'El teléfono tiene un formato inválido.';
    if (!empty($d['fecha_nacimiento']) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $d['fecha_nacimiento']))
        $errors[] = 'La fecha de nacimiento debe ser YYYY-MM-DD.';

    /* ========== Perfil docente (teacher_profiles) ========== */
    $perfil = [
        'rfc'                => $d['rfc']                ?? null,
        'departamento_id'    => !empty($d['departamento_id']) ? (int)$d['departamento_id'] : null,
        'grado_academico'    => $d['grado_academico']    ?? null,
        'especialidad'       => $d['especialidad']       ?? null,
        'fecha_contratacion' => $d['fecha_contratacion'] ?? null,
        'tipo_contrato'      => $d['tipo_contrato']      ?? null,
        'nivel_sni'          => $d['nivel_sni']          ?? 'sin_nivel',
        'perfil_prodep'      => isset($d['perfil_prodep']) ? 1 : 0,
    ];

    $gradoEnum = ['licenciatura','maestria','doctorado','esp'];
    $tipoEnum  = ['tiempo_completo','medio_tiempo','por_horas','asignatura'];
    $sniEnum   = ['sin_nivel','candidato','nivel1','nivel2','nivel3'];

    if (empty($perfil['departamento_id'])) $errors[] = 'El departamento es requerido.';
    if (!empty($perfil['grado_academico']) && !in_array($perfil['grado_academico'], $gradoEnum, true))
        $errors[] = 'Grado académico inválido.';
    if (!empty($perfil['tipo_contrato']) && !in_array($perfil['tipo_contrato'], $tipoEnum, true))
        $errors[] = 'Tipo de contrato inválido.';
    if (!empty($perfil['nivel_sni']) && !in_array($perfil['nivel_sni'], $sniEnum, true))
        $errors[] = 'Nivel SNI inválido.';
    if (!empty($perfil['fecha_contratacion']) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $perfil['fecha_contratacion']))
        $errors[] = 'La fecha de contratación debe ser YYYY-MM-DD.';

    if ($errors) {
        $_SESSION['error'] = implode(' ', $errors);
        header('Location: /src/plataforma/app/admin/teachers/create'); exit;
    }

    $user = new \App\Models\User();
    $db   = $user->getDb();

    /* ========== PRE-CHECKS para errores típicos ========== */
    // 1) Email duplicado
    $existsEmail = $user->findByEmail($d['email']);
    if ($existsEmail) {
        $_SESSION['error'] = 'El correo ya está registrado.';
        header('Location: /src/plataforma/app/admin/teachers/create'); exit;
    }

    // 2) Departamento existe (FK)
    if (!$this->departamentoExiste((int)$perfil['departamento_id'])) {
        $_SESSION['error'] = 'Departamento inválido (no existe en el catálogo).';
        header('Location: /src/plataforma/app/admin/teachers/create'); exit;
    }

    try {
        $db->query('START TRANSACTION');

        // === Insert users ===
        $userId = $user->create([
            'nombre'            => $d['nombre'],
            'apellido_paterno'  => $d['apellido_paterno'],
            'apellido_materno'  => $d['apellido_materno'],
            'telefono'          => $d['telefono'] ?? null,
            'fecha_nacimiento'  => $d['fecha_nacimiento'] ?? null,
            'email'             => $d['email'],
            'password'          => password_hash($d['password'], PASSWORD_DEFAULT),
            'status'            => $d['status'] ?? 'active',
        ]);

        // === Numero de empleado auto + verificación de colisión ===
        $autoNum = $user->generateNumeroEmpleado();
        // si por alguna razón ya existe, incrementa hasta encontrar uno libre
        $intNum = (int)$autoNum;
        while ($this->numeroEmpleadoExiste((string)$intNum)) {
            $intNum++;
        }
        $perfil['numero_empleado'] = str_pad((string)$intNum, 4, '0', STR_PAD_LEFT);

        // === Insert/Update perfil docente ===
        $user->upsertTeacherProfile($userId, $perfil);

        $db->query('COMMIT');
        $_SESSION['success'] = "Profesor creado correctamente. Número de empleado asignado: {$perfil['numero_empleado']}";
        header('Location: /src/plataforma/app/admin/teachers'); exit;

    } catch (\PDOException $e) {
        try { $db->query('ROLLBACK'); } catch (\Throwable $ignored) {}

        // Mensajes más claros con errorInfo
        $msg = $e->getMessage();
        $driverMsg = $e->errorInfo[2] ?? ''; // detalle del motor (índice/columna)
        $m = strtolower($msg.' '.$driverMsg);

        if ($e->getCode() === '23000') {
            if (str_contains($m, 'users_email_unique') || str_contains($m, 'email')) {
                $msg = 'El correo ya está registrado.';
            } elseif (str_contains($m, 'numero_empleado')) {
                $msg = 'El número de empleado ya existe.';
            } elseif (str_contains($m, 'foreign key') && str_contains($m, 'departamento')) {
                $msg = 'El departamento seleccionado no existe (violación de llave foránea).';
            } elseif (str_contains($m, 'cannot be null')) {
                // Detecta qué columna
                if (preg_match('/Column \'([^\']+)\' cannot be null/i', $driverMsg, $mm)) {
                    $msg = "El campo '{$mm[1]}' no puede ser nulo.";
                } else {
                    $msg = 'Hay campos requeridos vacíos.';
                }
            } else {
                $msg = 'Conflicto de integridad de datos.';
            }
        }

        error_log('TeachersController@store PDO: '.$e->getMessage().' | Driver: '.$driverMsg);
        $_SESSION['error'] = 'Error al guardar: '.$msg;
        header('Location: /src/plataforma/app/admin/teachers/create'); exit;

    } catch (\Throwable $e) {
        try { $db->query('ROLLBACK'); } catch (\Throwable $ignored) {}
        error_log('TeachersController@store: '.$e->getMessage());
        $_SESSION['error'] = 'Error al guardar: '.$e->getMessage();
        header('Location: /src/plataforma/app/admin/teachers/create'); exit;
    }
}

/* ===== Helpers privados en el mismo controlador ===== */
private function numeroEmpleadoExiste(string $numero): bool {
    $db = new \App\Core\Database();
    $db->query("SELECT 1 FROM teacher_profiles WHERE numero_empleado = :n LIMIT 1", [':n' => $numero]);
    return (bool)$db->fetchColumn();
}

private function departamentoExiste(int $id): bool {
    if ($id <= 0) return false;
    $db = new \App\Core\Database();
    $db->query("SELECT 1 FROM departamentos WHERE id = :id LIMIT 1", [':id' => $id]);
    return (bool)$db->fetchColumn();
}

    /* ===================== Editar ===================== */
    public function edit($id) {
    $this->requireRole(['admin']);

    $db = new \App\Core\Database();

    $db->query("
        SELECT
            u.id,
            u.nombre,
            u.apellido_paterno,
            u.apellido_materno,
            u.telefono,
            u.fecha_nacimiento,
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

    $deps = (new \App\Models\Departamento())->allActive();

    \App\Core\View::render('admin/teachers/edit', 'admin', [
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
    if (!empty($d['fecha_nacimiento']) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $d['fecha_nacimiento'])) {
        $errors[] = 'La fecha de nacimiento debe ser YYYY-MM-DD.';
    }
    if (!empty($d['telefono']) && !preg_match('/^[0-9\s+\-()]{7,20}$/', $d['telefono'])) {
        $errors[] = 'El teléfono tiene un formato inválido.';
    }

    // Enums permitidos (ajusta a tu BD real)
    $gradoEnum = ['licenciatura','maestria','doctorado','especialidad']; // <-- en tu BD es "especialidad"
    $tipoEnum  = ['tiempo_completo','medio_tiempo','por_horas','asignatura'];
    $sniEnum   = ['sin_nivel','candidato','nivel1','nivel2','nivel3'];

    if (!empty($d['grado_academico']) && !in_array($d['grado_academico'], $gradoEnum, true)) $errors[] = 'Grado académico inválido.';
    if (!empty($d['tipo_contrato']) && !in_array($d['tipo_contrato'], $tipoEnum, true))       $errors[] = 'Tipo de contrato inválido.';
    if (!empty($d['nivel_sni']) && !in_array($d['nivel_sni'], $sniEnum, true))               $errors[] = 'Nivel SNI inválido.';
    if (!empty($d['fecha_contratacion']) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $d['fecha_contratacion'])) {
        $errors[] = 'La fecha de contratación debe ser YYYY-MM-DD.';
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode(' ', $errors);
        header('Location: /src/plataforma/app/admin/teachers/edit/'.$id); exit;
    }

    $db = new \App\Core\Database();

    try {
        $db->query('START TRANSACTION');

        // 1) Users (incluye apellidos, teléfono, fecha_nacimiento)
        $paramsUser = [
            ':id'   => $id,
            ':n'    => $d['nombre'],
            ':ap'   => $d['apellido_paterno'] ?? null,
            ':am'   => $d['apellido_materno'] ?? null,
            ':e'    => $d['email'],
            ':tel'  => $d['telefono'] ?? null,
            ':fnac' => $d['fecha_nacimiento'] ?? null,
            ':s'    => $d['status'] ?? 'active',
        ];
        $sqlUser = "UPDATE users
                    SET nombre = :n,
                        apellido_paterno = :ap,
                        apellido_materno = :am,
                        email = :e,
                        telefono = :tel,
                        fecha_nacimiento = :fnac,
                        status = :s";
        if (!empty($d['password'])) {
            $sqlUser .= ", password = :p";
            $paramsUser[':p'] = password_hash($d['password'], PASSWORD_DEFAULT);
        }
        $sqlUser .= " WHERE id = :id";
        $db->query($sqlUser, $paramsUser);

        // 2) Teacher profile (upsert simple, ya lo tenías)
        $db->query("SELECT COUNT(*) FROM teacher_profiles WHERE user_id = :id", [':id' => $id]);
        $exists = (int)$db->fetchColumn() > 0;

        $paramsTp = [
            ':uid'  => $id,
            ':num'  => $d['numero_empleado'] ?? null, // si lo dejas readonly, no cambiará
            ':rfc'  => !empty(trim($d['rfc'] ?? '')) ? trim($d['rfc']) : null, // vacíos -> NULL (por UNIQUE en RFC)
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

