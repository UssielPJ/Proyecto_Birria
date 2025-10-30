<?php
namespace App\Controllers;

use App\Core\Database;
use PDO;

class AuthController {
  public function showLogin(){ require __DIR__ . '/../views/auth/login.php'; }

  public function login(){
    if (session_status()===PHP_SESSION_NONE) session_start();

    // Ahora esperamos "identificador" desde la vista (matrícula / num. empleado / email opcional)
    $ident = trim($_POST['identificador'] ?? ($_POST['email'] ?? ''));
    $pass  = $_POST['password'] ?? '';

    if ($ident === '' || $pass === '') {
      $_SESSION['flash_error'] = 'Ingresa tu identificador y contraseña.';
      header('Location: /src/plataforma/login'); exit;
    }

    $db = new Database();

    // 1) Resolver usuario por identificador:
    //    - Si parece email, buscar por users.email
    //    - Si no, buscar por student_profiles.matricula
    //    - Si no, buscar por teacher_profiles.numero_empleado
    $u = null;

    if (strpos($ident, '@') !== false) {
      // Email (compatibilidad)
      $db->query("SELECT id,email,password,nombre,status FROM users WHERE email = ? LIMIT 1", [$ident]);
      $u = $db->fetch();
    } else {
      // Matrícula (alumno)
      $db->query("
        SELECT u.id,u.email,u.password,u.nombre,u.status, sp.matricula AS identificador
        FROM users u
        JOIN student_profiles sp ON sp.user_id = u.id
        WHERE sp.matricula = ?
        LIMIT 1
      ", [$ident]);
      $u = $db->fetch();

      // Número de empleado (docente/adm) si no encontró alumno
      if (!$u) {
        $db->query("
          SELECT u.id,u.email,u.password,u.nombre,u.status, tp.numero_empleado AS identificador
          FROM users u
          JOIN teacher_profiles tp ON tp.user_id = u.id
          WHERE tp.numero_empleado = ?
          LIMIT 1
        ", [$ident]);
        $u = $db->fetch();
      }
    }

    if (!$u || !isset($u->password) || !password_verify($pass, $u->password)) {
      $_SESSION['flash_error'] = 'Identificador o contraseña inválidos.';
      header('Location: /src/plataforma/login'); exit;
    }

    if (isset($u->status) && $u->status !== 'active') {
      $_SESSION['flash_error'] = 'Tu cuenta está inactiva.';
      header('Location: /src/plataforma/login'); exit;
    }

    // 2) Roles por tabla pivote (si existen)
    $roles = [];
    try {
      $db->query("
        SELECT r.slug
        FROM roles r
        JOIN user_roles ur ON ur.role_id = r.id
        WHERE ur.user_id = ?
      ", [$u->id]);
      $roles = $db->fetchAll(PDO::FETCH_COLUMN) ?: [];
    } catch (\Throwable $e) {
      // si no existe la tabla, continuamos
    }

    // 3) Si no hay roles por pivote, inferir por perfiles
    if (empty($roles)) {
      $db->query("SELECT 1 FROM student_profiles WHERE user_id = ? LIMIT 1", [$u->id]);
      if ($db->fetchColumn()) $roles[] = 'student';

      $db->query("SELECT 1 FROM teacher_profiles WHERE user_id = ? LIMIT 1", [$u->id]);
      if ($db->fetchColumn()) $roles[] = 'teacher';

      try {
        $db->query("SELECT 1 FROM capturista_profiles WHERE user_id = ? LIMIT 1", [$u->id]);
        if ($db->fetchColumn()) $roles[] = 'capturista';
      } catch (\Throwable $e) {}
    }

    // 4) Normalizar slugs + deduplicar
    $norm = function(string $r): string {
      $r = strtolower(trim($r));
      return match($r) {
        'alumno' => 'student',
        'maestro', 'docente', 'teacher' => 'teacher',
        'capturista' => 'capturista',
        'admin' => 'admin',
        default => $r
      };
    };
    $roles = array_values(array_unique(array_map($norm, $roles)));

    // 5) Guardar en sesión (incluye el identificador usado)
    $_SESSION['user'] = [
      'id'            => (int)$u->id,
      'email'         => $u->email ?? null,
      'name'          => $u->nombre ?? '',
      'roles'         => $roles,
      'identificador' => $ident,
    ];
    $_SESSION['roles'] = $roles;            // compat
    $_SESSION['role']  = $roles[0] ?? null; // compat

    // 6) Redirigir según rol principal
    $first = $roles[0] ?? '';
    if ($first === 'admin') {
      header('Location: /src/plataforma/app/admin'); exit;
    } elseif ($first === 'teacher') {
      header('Location: /src/plataforma/app/teacher'); exit;
    } elseif ($first === 'student') {
      header('Location: /src/plataforma/app'); exit;
    } elseif ($first === 'capturista') {
      header('Location: /src/plataforma/capturista'); exit;
    } else {
      $_SESSION['flash_error'] = 'Tu cuenta no tiene un rol asignado.';
      header('Location: /src/plataforma/login'); exit;
    }
  }

  public function logout(){
    if (session_status()===PHP_SESSION_NONE) session_start();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
      $p = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
    header('Location: /src/plataforma/'); exit;
  }
}
