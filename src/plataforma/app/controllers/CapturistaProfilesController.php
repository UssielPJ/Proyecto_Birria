<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;
use PDO;

class CapturistaProfilesController
{
    /* ===================== Infra básica ===================== */

    private function pdo(): PDO
    {
        $db = (new Database())->getPdo();
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $db;
    }

    private function requireLogin()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (
            empty($_SESSION['user']) &&
            empty($_SESSION['rol']) &&
            empty($_SESSION['usuario'])
        ) {
            header('Location: /src/plataforma/login'); exit;
        }
    }

    private function requireRole(array $roles)
    {
        $this->requireLogin();
        $rolesSesion = [];
        if (!empty($_SESSION['user']['roles']) && is_array($_SESSION['user']['roles'])) {
            $rolesSesion = $_SESSION['user']['roles'];
        } elseif (!empty($_SESSION['rol'])) {
            $rolesSesion = [$_SESSION['rol']];
        } elseif (!empty($_SESSION['usuario']['rol'])) {
            $rolesSesion = [$_SESSION['usuario']['rol']];
        }
        foreach ($roles as $r) if (in_array($r, $rolesSesion, true)) return;
        header('Location: /src/plataforma/login'); exit;
    }

    /* ===================== Helpers dominio ===================== */

    /** Busca id del rol por slug o name = 'capturista' */
    private function getRoleId(PDO $pdo, string $slugOrName = 'capturista'): ?int
    {
        $sql = "SELECT id FROM roles 
                WHERE slug = :v OR name = :v 
                ORDER BY id ASC LIMIT 1";
        $st = $pdo->prepare($sql);
        $st->execute([':v' => $slugOrName]);
        $id = $st->fetchColumn();
        return $id ? (int)$id : null;
    }

    /** Asigna rol al usuario, ignora si ya existe (unique user_id,role_id) */
    private function assignRole(PDO $pdo, int $userId, int $roleId): void
    {
        try {
            $sql = "INSERT INTO user_roles (user_id, role_id, created_at)
                    VALUES (:u, :r, NOW())";
            $st = $pdo->prepare($sql);
            $st->execute([':u'=>$userId, ':r'=>$roleId]);
        } catch (\PDOException $e) {
            // Duplicado u otro: no detenemos el flujo
            if ($e->getCode() !== '23000') { // no es duplicate key
                throw $e;
            }
        }
    }

    /** Genera número de empleado de 4 dígitos único */
    private function generateNumeroEmpleado(PDO $pdo): string
    {
        $check = $pdo->prepare("SELECT 1 FROM capturista_profiles WHERE numero_empleado = ? LIMIT 1");
        for ($i=0; $i<30; $i++) {
            $cand = str_pad((string)random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            $check->execute([$cand]);
            if (!$check->fetch()) return $cand;
        }
        throw new \RuntimeException('No se pudo generar un número de empleado único.');
    }

    /** Normaliza status del perfil a enum de la tabla (active|inactive) */
    private function normPerfilStatus(?string $v): string
    {
        $v = $v ? mb_strtolower(trim($v)) : 'active';
        // Acepta 'activo|inactivo' del formulario y mapea
        $map = ['activo' => 'active', 'inactivo' => 'inactive'];
        if (isset($map[$v])) $v = $map[$v];
        return in_array($v, ['active','inactive'], true) ? $v : 'active';
    }

    /** Normaliza status del user a enum (active|inactive|suspended) */
    private function normUserStatus(?string $v): string
    {
        $v = $v ? mb_strtolower(trim($v)) : 'active';
        return in_array($v, ['active','inactive','suspended'], true) ? $v : 'active';
    }

    /* ===================== Endpoints ===================== */

    /** GET /src/plataforma/app/admin/capturistas/next-numero */
    public function nextNumero()
    {
        $this->requireRole(['admin']);
        $pdo = $this->pdo();
        header('Content-Type: application/json; charset=utf-8');
        try {
            $n = $this->generateNumeroEmpleado($pdo);
            echo json_encode(['numero' => $n], JSON_UNESCAPED_UNICODE);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => 'No se pudo generar número'], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    /** GET index list */
public function index()
{
    $this->requireRole(['admin']);
    $pdo = $this->pdo();

    $q              = trim($_GET['q'] ?? '');
    $user_status    = $_GET['user_status'] ?? '';
    $profile_status = $_GET['profile_status'] ?? '';
    $page           = max(1, (int)($_GET['page'] ?? 1));
    $limit          = 10;
    $offset         = ($page - 1) * $limit;

    $where  = [];
    $params = [];

    if ($q !== '') {
        // placeholders únicos para MySQL nativo (emulate_prepares = false)
        $where[] =
            "(u.nombre LIKE :q1 OR u.apellido_paterno LIKE :q2 OR u.apellido_materno LIKE :q3
              OR u.email LIKE :q4 OR cp.numero_empleado LIKE :q5 OR cp.curp LIKE :q6)";
        $like = "%{$q}%";
        $params[':q1'] = $like;
        $params[':q2'] = $like;
        $params[':q3'] = $like;
        $params[':q4'] = $like;
        $params[':q5'] = $like;
        $params[':q6'] = $like;
    }

    if (in_array($user_status, ['active','inactive','suspended'], true)) {
        $where[] = "u.status = :us";
        $params[':us'] = $user_status;
    }

    if (in_array($profile_status, ['active','inactive'], true)) {
        $where[] = "cp.status = :ps";
        $params[':ps'] = $profile_status;
    }

    $whereSql = $where ? (' WHERE '.implode(' AND ', $where)) : '';

    // ----- Count -----
    $sqlCount = "SELECT COUNT(*)
                 FROM users u
                 INNER JOIN capturista_profiles cp ON cp.user_id = u.id
                 {$whereSql}";
    $st = $pdo->prepare($sqlCount);
    foreach ($params as $k => $v) {
        // todos los :qN, :us, :ps son strings
        $st->bindValue($k, $v, PDO::PARAM_STR);
    }
    $st->execute();
    $total = (int)$st->fetchColumn();

    // ----- Data -----
    $sql = "SELECT
                u.id AS user_id, u.email, u.nombre, u.apellido_paterno, u.apellido_materno,
                u.telefono, u.fecha_nacimiento, u.status AS user_status,
                cp.id AS profile_id, cp.numero_empleado, cp.curp, cp.fecha_ingreso, cp.status AS profile_status
            FROM users u
            INNER JOIN capturista_profiles cp ON cp.user_id = u.id
            {$whereSql}
            ORDER BY cp.numero_empleado ASC
            LIMIT :limit OFFSET :offset";
    $st = $pdo->prepare($sql);
    foreach ($params as $k => $v) {
        $st->bindValue($k, $v, PDO::PARAM_STR);
    }
    $st->bindValue(':limit',  $limit,  PDO::PARAM_INT);
    $st->bindValue(':offset', $offset, PDO::PARAM_INT);
    $st->execute();
    $rows = $st->fetchAll() ?: [];

    \App\Core\View::render('admin/capturistas/index', 'admin', [
        'rows' => $rows,
        'total' => $total,
        'page' => $page,
        'limit' => $limit,
        'q' => $q,
        'user_status' => $user_status,
        'profile_status' => $profile_status,
    ]);
}


    /** GET create */
    public function create()
    {
        $this->requireRole(['admin']);
        View::render('admin/capturistas/create', 'admin');
    }

public function store()
{
    $this->requireRole(['admin']);
    if (session_status() === PHP_SESSION_NONE) session_start();

    $d = $_POST;
    $errors = [];

    // ===== Validaciones =====
    if (empty($d['nombre']))             $errors[] = 'El nombre es requerido.';
    if (empty($d['apellido_paterno']))   $errors[] = 'El apellido paterno es requerido.';
    if (!isset($d['apellido_materno']))  $d['apellido_materno'] = null;
    if (empty($d['email']) || !filter_var($d['email'], FILTER_VALIDATE_EMAIL))
        $errors[] = 'Email inválido.';
    if (empty($d['password']))           $errors[] = 'La contraseña es requerida.';
    if (($d['password_confirmation'] ?? '') !== ($d['password'] ?? ''))
        $errors[] = 'Las contraseñas no coinciden.';
    if (empty($d['curp']))               $errors[] = 'La CURP es requerida.';
    if (empty($d['fecha_ingreso']))      $errors[] = 'La fecha de ingreso es requerida.';

    $userStatus   = $this->normUserStatus($d['status'] ?? 'active');              // users: active|inactive|suspended
    $perfilStatus = $this->normPerfilStatus($d['capturista_status'] ?? 'active'); // perfil: active|inactive

    if ($errors) {
        $_SESSION['error'] = implode(' ', $errors);
        header('Location: /src/plataforma/app/admin/capturistas/create?debug=1'); exit;
    }

    $pdo = $this->pdo();

    // ===== Duplicados previos =====
    try {
        $st = $pdo->prepare("SELECT 1 FROM users WHERE email = ? LIMIT 1");
        $st->execute([mb_strtolower(trim($d['email']))]);
        if ($st->fetch()) {
            $_SESSION['error'] = 'El correo ya está registrado.';
            header('Location: /src/plataforma/app/admin/capturistas/create?debug=1'); exit;
        }
    } catch (\Throwable $e) {
        $_SESSION['error'] = 'Fallo SELECT email | '.$e->getMessage();
        header('Location: /src/plataforma/app/admin/capturistas/create?debug=1'); exit;
    }

    try {
        $st = $pdo->prepare("SELECT 1 FROM capturista_profiles WHERE curp = ? LIMIT 1");
        $st->execute([mb_strtoupper(trim($d['curp']))]);
        if ($st->fetch()) {
            $_SESSION['error'] = 'La CURP ya está registrada.';
            header('Location: /src/plataforma/app/admin/capturistas/create?debug=1'); exit;
        }
    } catch (\Throwable $e) {
        $_SESSION['error'] = 'Fallo SELECT curp | '.$e->getMessage();
        header('Location: /src/plataforma/app/admin/capturistas/create?debug=1'); exit;
    }

    try {
        $pdo->beginTransaction();

        // ===== INSERT users (posicional) =====
        $sqlUser = "INSERT INTO users
            (email, password, nombre, apellido_paterno, apellido_materno, telefono, fecha_nacimiento, status, created_at, updated_at)
            VALUES (?,?,?,?,?,?,?, ?, NOW(), NOW())";

        $am  = ($d['apellido_materno'] === '' ? null : trim((string)$d['apellido_materno']));
        $tel = ($d['telefono'] ?? null);
        $fn  = ($d['fecha_nacimiento'] ?? null);

        try {
            $u = $pdo->prepare($sqlUser);
            $paramsU = [
                mb_strtolower(trim($d['email'])),
                password_hash($d['password'], PASSWORD_DEFAULT),
                trim($d['nombre']),
                trim($d['apellido_paterno']),
                $am,
                $tel,
                $fn,
                $userStatus,
            ];
            $u->execute($paramsU);
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            ob_start();
            if (isset($u) && $u instanceof \PDOStatement) { $u->debugDumpParams(); }
            $dump = ob_get_clean();
            $_SESSION['error'] =
                "HY093 en INSERT users | ".$e->getMessage().
                " | SQL: ".$sqlUser.
                " | dumpParams: ".$dump.
                " | POST=".json_encode($_POST, JSON_UNESCAPED_UNICODE);
            header('Location: /src/plataforma/app/admin/capturistas/create?debug=1'); exit;
        }

        $userId = (int)$pdo->lastInsertId();
        if ($userId <= 0) throw new \RuntimeException('No se obtuvo ID de usuario.');

        // ===== Asignar rol 'capturista' si existe =====
        try {
            if ($roleId = $this->getRoleId($pdo, 'capturista')) {
                $this->assignRole($pdo, $userId, $roleId);
            }
        } catch (\Throwable $e) {
            // No es fatal; seguimos sin rol
        }

        // ===== número de empleado único =====
        $numeroEmpleado = null;
        if (!empty($d['numero_empleado']) && preg_match('/^\d{4}$/', (string)$d['numero_empleado'])) {
            $numeroEmpleado = (string)$d['numero_empleado'];
            $chk = $pdo->prepare("SELECT 1 FROM capturista_profiles WHERE numero_empleado = ? LIMIT 1");
            $chk->execute([$numeroEmpleado]);
            if ($chk->fetch()) $numeroEmpleado = null; // duplicado → generar
        }
        if ($numeroEmpleado === null) {
            $numeroEmpleado = $this->generateNumeroEmpleado($pdo);
        }

        // ===== INSERT capturista_profiles (posicional) =====
        $sqlProf = "INSERT INTO capturista_profiles
            (user_id, numero_empleado, curp, fecha_ingreso, status, created_at, updated_at)
            VALUES (?,?,?,?,?, NOW(), NOW())";

        try {
            $p = $pdo->prepare($sqlProf);
            $paramsP = [
                $userId,
                $numeroEmpleado,
                mb_strtoupper(trim($d['curp'])),
                $d['fecha_ingreso'],
                $perfilStatus,
            ];
            $p->execute($paramsP);
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            ob_start();
            if (isset($p) && $p instanceof \PDOStatement) { $p->debugDumpParams(); }
            $dump = ob_get_clean();
            $_SESSION['error'] =
                "HY093 en INSERT capturista_profiles | ".$e->getMessage().
                " | SQL: ".$sqlProf.
                " | dumpParams: ".$dump.
                " | POST=".json_encode($_POST, JSON_UNESCAPED_UNICODE);
            header('Location: /src/plataforma/app/admin/capturistas/create?debug=1'); exit;
        }

        $pdo->commit();
        header('Location: /src/plataforma/app/admin/capturistas?created=1'); exit;

    } catch (\Throwable $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        $_SESSION['error'] = 'Error al crear: '.$e->getMessage().' | POST='.json_encode($_POST, JSON_UNESCAPED_UNICODE);
        header('Location: /src/plataforma/app/admin/capturistas/create?debug=1'); exit;
    }
}


    /** GET edit */
    public function edit(int $id)
    {
        $this->requireRole(['admin']);
        $pdo = $this->pdo();

        $st = $pdo->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $st->execute([(int)$id]);
        $user = $st->fetch();

        if (!$user) { header('Location: /src/plataforma/app/admin/capturistas'); exit; }

        $st = $pdo->prepare("SELECT * FROM capturista_profiles WHERE user_id = ? LIMIT 1");
        $st->execute([(int)$id]);
        $profile = $st->fetch();

        View::render('admin/capturistas/edit', 'admin', [
            'user'    => $user,
            'profile' => $profile
        ]);
    }

    /** POST update */
    public function update(int $id)
    {
        $this->requireRole(['admin']);
        $pdo = $this->pdo();
        $d   = $_POST;

        $errors = [];
        if (empty($d['email']) || !filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Email inválido.';
        if (empty($d['nombre'])) $errors[] = 'El nombre es requerido.';
        if (empty($d['curp']))  $errors[] = 'La CURP es requerida.';
        if (empty($d['fecha_ingreso'])) $errors[] = 'La fecha de ingreso es requerida.';
        if (!empty($d['password']) && ($d['password'] !== ($d['password_confirmation'] ?? ''))) $errors[] = 'Las contraseñas no coinciden.';

        $userStatus   = $this->normUserStatus($d['status'] ?? 'active');
        $perfilStatus = $this->normPerfilStatus($d['capturista_status'] ?? 'active');

        if ($errors) {
            header('Location: /src/plataforma/app/admin/capturistas/edit/'.$id.'?error='.urlencode(implode(' ', $errors))); exit;
        }

        try {
            $pdo->beginTransaction();

            // update users
            $sql = "UPDATE users SET
                        email = :email,
                        nombre = :nombre,
                        apellido_paterno = :ap,
                        apellido_materno = :am,
                        telefono = :tel,
                        fecha_nacimiento = :fn,
                        status = :st,
                        updated_at = NOW()
                    WHERE id = :id";
            $u = $pdo->prepare($sql);
            $u->execute([
                ':id'    => (int)$id,
                ':email' => mb_strtolower(trim($d['email'])),
                ':nombre'=> trim($d['nombre']),
                ':ap'    => trim($d['apellido_paterno'] ?? ''),
                ':am'    => ($d['apellido_materno'] ?? '') !== '' ? trim($d['apellido_materno']) : null,
                ':tel'   => $d['telefono'] ?? null,
                ':fn'    => $d['fecha_nacimiento'] ?? null,
                ':st'    => $userStatus,
            ]);

            if (!empty($d['password'])) {
                $p = $pdo->prepare("UPDATE users SET password = :p, updated_at = NOW() WHERE id = :id");
                $p->execute([
                    ':p'  => password_hash($d['password'], PASSWORD_DEFAULT),
                    ':id' => (int)$id
                ]);
            }

            // upsert capturista_profiles
            $st = $pdo->prepare("SELECT id FROM capturista_profiles WHERE user_id = ? LIMIT 1");
            $st->execute([(int)$id]);
            $pid = $st->fetchColumn();

            $numero = null;
            if (!empty($d['numero_empleado']) && preg_match('/^\d{4}$/', (string)$d['numero_empleado'])) {
                $numero = (string)$d['numero_empleado'];
                // si cambió, verificar unicidad
                $chk = $pdo->prepare("SELECT 1 FROM capturista_profiles WHERE numero_empleado = ? AND user_id <> ? LIMIT 1");
                $chk->execute([$numero, (int)$id]);
                if ($chk->fetch()) {
                    // inválido, mejor no lo cambiamos
                    $numero = null;
                }
            }

            if ($pid) {
                $sql = "UPDATE capturista_profiles SET
                            ".($numero ? "numero_empleado = :num," : "")."
                            curp = :curp,
                            fecha_ingreso = :fi,
                            status = :st,
                            updated_at = NOW()
                        WHERE user_id = :uid LIMIT 1";
                $p = $pdo->prepare($sql);
                $params = [
                    ':uid' => (int)$id,
                    ':curp'=> mb_strtoupper(trim($d['curp'])),
                    ':fi'  => $d['fecha_ingreso'],
                    ':st'  => $perfilStatus,
                ];
                if ($numero) $params[':num'] = $numero;
                $p->execute($params);
            } else {
                $sql = "INSERT INTO capturista_profiles
                        (user_id, numero_empleado, curp, fecha_ingreso, status, created_at, updated_at)
                        VALUES (:uid, :num, :curp, :fi, :st, NOW(), NOW())";
                $p = $pdo->prepare($sql);
                $p->execute([
                    ':uid' => (int)$id,
                    ':num' => $numero ?: $this->generateNumeroEmpleado($pdo),
                    ':curp'=> mb_strtoupper(trim($d['curp'])),
                    ':fi'  => $d['fecha_ingreso'],
                    ':st'  => $perfilStatus,
                ]);
            }

            $pdo->commit();
            header('Location: /src/plataforma/app/admin/capturistas?updated=1'); exit;

        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            header('Location: /src/plataforma/app/admin/capturistas/edit/'.$id.'?error='.urlencode($e->getMessage())); exit;
        }
    }

    /** POST delete */
    public function delete(int $id)
    {
        $this->requireRole(['admin']);
        $pdo = $this->pdo();
        $st = $pdo->prepare("DELETE FROM users WHERE id = ? LIMIT 1");
        $st->execute([(int)$id]); // cascada borra perfil y user_roles
        header('Location: /src/plataforma/app/admin/capturistas?deleted=1'); exit;
    }
}
