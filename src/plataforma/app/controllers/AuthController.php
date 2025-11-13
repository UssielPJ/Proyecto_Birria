<?php
namespace App\Controllers;

use App\Core\Database;
use PDO;

class AuthController {

  /* ====== Vista de login ====== */
  public function showLogin(){
    if (session_status()===PHP_SESSION_NONE) session_start();

    $flash = $_SESSION['flash_error'] ?? null;
    if ($flash) unset($_SESSION['flash_error']);

    $error = $flash;
    $this->renderLoginView($error);
  }

  /* ====== POST /login ====== */
  public function login(){
    if (session_status()===PHP_SESSION_NONE) session_start();

    // Puede venir como "identificador" o "email"
    $ident = trim($_POST['identificador'] ?? ($_POST['email'] ?? ''));
    $pass  = $_POST['password'] ?? '';

    if ($ident === '' || $pass === '') {
      return $this->renderLoginView('Ingresa tu identificador y contraseña.');
    }

    $db = new Database();

    /* ---------- 1) Resolver usuario por identificador ---------- */
    $u = null;

    if (strpos($ident, '@') !== false) {
      // Email (caso admin / general)
      $db->query("
        SELECT u.id, u.email, u.password, u.nombre, u.status
        FROM users u
        WHERE u.email = ?
        LIMIT 1
      ", [mb_strtolower($ident)]);
      $u = $db->fetch();

    } else {
      // 1.a) Alumno por matrícula
      $db->query("
        SELECT u.id, u.email, u.password, u.nombre, u.status,
               sp.matricula AS identificador
        FROM users u
        JOIN student_profiles sp ON sp.user_id = u.id
        WHERE sp.matricula = ?
        LIMIT 1
      ", [$ident]);
      $u = $db->fetch();

      // 1.b) Docente por número de empleado (si no hubo alumno)
      if (!$u) {
        $db->query("
          SELECT u.id, u.email, u.password, u.nombre, u.status,
                 tp.numero_empleado AS identificador
          FROM users u
          JOIN teacher_profiles tp ON tp.user_id = u.id
          WHERE tp.numero_empleado = ?
          LIMIT 1
        ", [$ident]);
        $u = $db->fetch();
      }

      // 1.c) Capturista por número de empleado (si no hubo docente)
      if (!$u) {
        $db->query("
          SELECT u.id, u.email, u.password, u.nombre, u.status,
                 cp.numero_empleado AS identificador
          FROM users u
          JOIN capturista_profiles cp ON cp.user_id = u.id
          WHERE cp.numero_empleado = ?
          LIMIT 1
        ", [$ident]);
        $u = $db->fetch();
      }
    }

    /* ---------- 2) Validación de credenciales ---------- */
    if (!$u || !isset($u->password) || !password_verify($pass, $u->password)) {
      return $this->renderLoginView('Identificador o contraseña inválidos.');
    }
    if (isset($u->status) && $u->status !== 'active') {
      return $this->renderLoginView('Tu cuenta está inactiva.');
    }

    /* ---------- 3) Cargar roles desde pivote (si existe) ---------- */
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
      // Si no hay tabla de roles, seguimos con inferencia
    }

    /* ---------- 4) Inferir roles por perfiles si no hay pivote ---------- */
    if (empty($roles)) {
      // Student
      $db->query("SELECT 1 FROM student_profiles WHERE user_id = ? LIMIT 1", [$u->id]);
      if ($db->fetchColumn()) $roles[] = 'student';

      // Teacher
      $db->query("SELECT 1 FROM teacher_profiles WHERE user_id = ? LIMIT 1", [$u->id]);
      if ($db->fetchColumn()) $roles[] = 'teacher';

      // Capturista
      $db->query("SELECT 1 FROM capturista_profiles WHERE user_id = ? LIMIT 1", [$u->id]);
      if ($db->fetchColumn()) $roles[] = 'capturista';

      // (Opcional) admin por bandera en users si la tienes; si no, omitir
      // $db->query("SELECT is_admin FROM users WHERE id=? LIMIT 1", [$u->id]);
      // if ((int)$db->fetchColumn() === 1) $roles[] = 'admin';
    }

    /* ---------- 5) Normalizar slugs + deduplicar ---------- */
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

    /* ---------- 6) Guardar sesión ---------- */
    $_SESSION['user'] = [
      'id'            => (int)$u->id,
      'email'         => $u->email ?? null,
      'name'          => $u->nombre ?? '',
      'roles'         => $roles,
      'identificador' => $ident,
    ];
    $_SESSION['roles'] = $roles;            // compat
    $_SESSION['role']  = $roles[0] ?? null; // compat

    /* ---------- 7) Redirección según rol principal ---------- */
    $first = $roles[0] ?? '';
    if     ($first === 'admin')      { header('Location: /src/plataforma/app/admin');   exit; }
    elseif ($first === 'teacher')    { header('Location: /src/plataforma/app/teacher'); exit; }
    elseif ($first === 'student')    { header('Location: /src/plataforma/app');         exit; }
    elseif ($first === 'capturista') { header('Location: /src/plataforma/capturista');  exit; }

    // Si llegó aquí, no tiene rol claro
    return $this->renderLoginView('Tu cuenta no tiene un rol asignado.');
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

  /* ====== Render login con toast opcional ====== */
  private function renderLoginView(?string $errorMessage = null): void {
    http_response_code($errorMessage ? 401 : 200);
    $error = $errorMessage;

    ob_start();
    require __DIR__ . '/../views/auth/login.php';
    $viewHtml = ob_get_clean();

    if ($errorMessage) {
      $toast = <<<HTML
      <div id="login-toast" class="fixed top-5 right-5 z-50 bg-red-600 text-white px-5 py-3 rounded-xl shadow-lg"
           style="animation: fadein .2s ease-out;">{$this->e($errorMessage)}</div>
      <style>
        @keyframes fadein { from {opacity:0; transform: translateY(-4px);} to {opacity:1; transform: translateY(0);} }
        @keyframes fadeout{ from {opacity:1;} to {opacity:0;} }
      </style>
      <script>
        setTimeout(function(){
          var t = document.getElementById('login-toast');
          if(!t) return;
          t.style.animation = 'fadeout .25s ease-in forwards';
          setTimeout(function(){ if(t && t.parentNode) t.parentNode.removeChild(t); }, 280);
        }, 3500);
      </script>
      HTML;
      echo $toast . $viewHtml;
    } else {
      echo $viewHtml;
    }
    exit;
  }

  private function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
  }
}
