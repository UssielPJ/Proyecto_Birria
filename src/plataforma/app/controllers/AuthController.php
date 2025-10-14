<?php
namespace App\Controllers;

use App\Core\Database;
use PDO;

class AuthController {
  public function showLogin(){ require __DIR__ . '/../views/auth/login.php'; }

  public function login(){
    if (session_status()===PHP_SESSION_NONE) session_start();

    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    $db = new Database();

    // 1) Buscar usuario
    $db->query("SELECT id,email,password,nombre,status FROM users WHERE email = ? LIMIT 1", [$email]);
    $u = $db->fetch();
    if (!$u || !password_verify($pass, $u->password)) {
      $_SESSION['flash_error'] = 'Correo o contraseña inválidos.';
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
      // si no existe la tabla, seguimos
    }

    // 3) Si no hay roles por pivote, inferir por perfiles
    if (empty($roles)) {
      // estudiante
      $db->query("SELECT 1 FROM student_profiles WHERE user_id = ? LIMIT 1", [$u->id]);
      if ($db->fetchColumn()) $roles[] = 'student';

      // maestro
      $db->query("SELECT 1 FROM teacher_profiles WHERE user_id = ? LIMIT 1", [$u->id]);
      if ($db->fetchColumn()) $roles[] = 'teacher';

      // capturista (si tienes esta tabla)
      try {
        $db->query("SELECT 1 FROM capturista_profiles WHERE user_id = ? LIMIT 1", [$u->id]);
        if ($db->fetchColumn()) $roles[] = 'capturista';
      } catch (\Throwable $e) {}
    }

    // 4) Normalizar slugs + deduplicar
    $norm = function(string $r): string {
      $r = strtolower(trim($r));
      return match($r) {
        'alumno'    => 'student',
        'maestro', 'docente', 'teacher' => 'teacher',
        'capturista'=> 'capturista',
        'admin'     => 'admin',
        default     => $r
      };
    };
    $roles = array_values(array_unique(array_map($norm, $roles)));

    // 5) Guardar en sesión (incluye compat para código viejo)
    $_SESSION['user'] = [
      'id'    => (int)$u->id,
      'email' => $u->email,
      'name'  => $u->nombre ?? '',
      'roles' => $roles,
    ];
    $_SESSION['roles'] = $roles;            // compat
    $_SESSION['role']  = $roles[0] ?? null;  // compat

    // 6) Redirigir según rol principal
    $first = $roles[0] ?? '';
    if ($first === 'admin') {
      header('Location: /src/plataforma/app/admin'); exit;
    } elseif ($first === 'teacher') {
      header('Location: /src/plataforma/app/teacher'); exit;
    } elseif ($first === 'student') {
      header('Location: /src/plataforma/app'); exit; // dashboard alumno
    } elseif ($first === 'capturista') {
      header('Location: /src/plataforma/capturista'); exit;
    } else {
      // sin rol reconocido: manda al login con aviso
      $_SESSION['flash_error'] = 'Tu cuenta no tiene un rol asignado.';
      header('Location: /src/plataforma/login'); exit;
    }
  }

  public function logout(){
    if (session_status()===PHP_SESSION_NONE) session_start();

    // vaciar variables de sesión
    $_SESSION = [];

    // eliminar cookie de sesión si existe
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }

    session_destroy();

    // puedes mandar a la raíz (que ya apunta a showLogin) o a /login
    header('Location: /src/plataforma/'); // o '/src/plataforma/login'
    exit;
}

}
