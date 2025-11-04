<?php
namespace App\Controllers;

use App\Core\Database;
use PDO;

class AuthController {

  /* ====== Vista de login con soporte de "toast" ====== */
  public function showLogin(){
    if (session_status()===PHP_SESSION_NONE) session_start();

    // Si viene un flash_error de algún redirect anterior, lo mostramos como toast y lo limpiamos.
    $flash = $_SESSION['flash_error'] ?? null;
    if ($flash) unset($_SESSION['flash_error']);

    // Render simple (la vista puede leer variables locales)
    $error = $flash; // compat: la vista podría imprimir $error también
    $this->renderLoginView($error);
  }

  /* ====== POST /login ====== */
  public function login(){
    if (session_status()===PHP_SESSION_NONE) session_start();

    // Ahora esperamos "identificador" desde la vista (matrícula / num. empleado / email opcional)
    $ident = trim($_POST['identificador'] ?? ($_POST['email'] ?? ''));
    $pass  = $_POST['password'] ?? '';

    if ($ident === '' || $pass === '') {
      // En lugar de redirigir, renderizamos con mensaje flotante
      return $this->renderLoginView('Ingresa tu identificador y contraseña.');
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

    // Validación de credenciales
    if (!$u || !isset($u->password) || !password_verify($pass, $u->password)) {
      return $this->renderLoginView('Identificador o contraseña inválidos.');
    }

    if (isset($u->status) && $u->status !== 'active') {
      return $this->renderLoginView('Tu cuenta está inactiva.');
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
      // Ajusta esta ruta si tu dashboard de alumno es otra
      header('Location: /src/plataforma/app'); exit;
    } elseif ($first === 'capturista') {
      header('Location: /src/plataforma/capturista'); exit;
    } else {
      // Si alguien entra sin rol, mostramos toast y devolvemos la vista (sin 404)
      return $this->renderLoginView('Tu cuenta no tiene un rol asignado.');
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

  /* ====== Helper para renderizar la vista con mensaje flotante ====== */
  private function renderLoginView(?string $errorMessage = null): void {
    http_response_code($errorMessage ? 401 : 200);

    // Salimos en limpio a la misma vista y montamos un "toast" ligero si hay error
    // (Si tu vista ya imprime $_SESSION['flash_error'] o $error, también funcionará).
    $error = $errorMessage;

    // Carga la vista en buffer para poder anteponer el toast
    ob_start();
    require __DIR__ . '/../views/auth/login.php';
    $viewHtml = ob_get_clean();

    if ($errorMessage) {
      // Toast minimalista (Tailwind-friendly). Se auto-cierra en 3.5s.
      $toast = <<<HTML
      <div id="login-toast" class="fixed top-5 right-5 z-50 bg-red-600 text-white px-5 py-3 rounded-xl shadow-lg"
           style="animation: fadein .2s ease-out;">
        {$this->e($errorMessage)}
      </div>
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
    exit; // Importante: detenemos el flujo aquí para no pasar por Router de nuevo.
  }

  private function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
  }
}
