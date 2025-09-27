<?php
class AuthController {
  public function showLogin(){
    // muestra tu vista de login actual
    include __DIR__ . '/../views/auth/login.php';
  }

public function login(){
    if (session_status() === PHP_SESSION_NONE) session_start();

    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if ($email === '' || $pass === '') {
      $_SESSION['flash_error'] = 'Completa tus credenciales';
      header('Location: /src/plataforma/'); exit;
    }

    $pdo = db();

    // Trae usuario con su rol "legacy" (por compatibilidad)
    $sql = "
      SELECT u.id, u.name, u.email, u.password, u.status, r.slug AS role_slug, u.role_id
      FROM users u
      LEFT JOIN roles r ON r.id = u.role_id
      WHERE u.email = ? AND u.status = 'active'
      LIMIT 1
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($pass, $user['password'])) {
      $_SESSION['flash_error'] = 'Credenciales inválidas';
      header('Location: /src/plataforma/'); exit;
    }

    // Cargar roles desde user_roles (multi-rol)
    $rs = $pdo->prepare("
      SELECT r.slug
      FROM user_roles ur
      JOIN roles r ON r.id = ur.role_id
      WHERE ur.user_id = ?
    ");
    $rs->execute([$user['id']]);
    $roles = $rs->fetchAll(PDO::FETCH_COLUMN);

    // Si no hay en user_roles, usa el rol legacy (si existe)
    if (!$roles && !empty($user['role_slug'])) {
      $roles = [$user['role_slug']];
    }

    // Prioridad de rol para compatibilidad con tu mapeo de destinos
    $priority = ['admin','capturista','maestro','teacher','alumno','student'];
    $primary  = null;
    foreach ($priority as $r) {
      if (in_array($r, $roles, true)) { $primary = $r; break; }
    }
    // Fallback si no se encontró nada
    if ($primary === null) { $primary = $user['role_slug'] ?: 'alumno'; }

    // Guardar en sesión (mantengo tu estructura original)
    $_SESSION['user'] = [
      'id'    => (int)$user['id'],
      'name'  => $user['name'] ?? '',
      'email' => $user['email'],
      'role'  => $primary,     // <-- clave para que tu código viejo no se rompa
    ];
    $_SESSION['roles'] = $roles; // lista completa (multi-rol)

    // Redirección por rol (mantengo tu mapeo y agrego capturista)
    $destinos = [
      'alumno'      => '/src/plataforma/app',
      'student'     => '/src/plataforma/app',
      'maestro'     => '/src/plataforma/teacher',
      'teacher'     => '/src/plataforma/teacher',
      'admin'       => '/src/plataforma/admin',
      'capturista'  => '/src/plataforma/capturista', // crea esta ruta a tu vista capturista.php
    ];
    $goto = $destinos[$primary] ?? '/src/plataforma/app';
    header('Location: '.$goto); exit;
}


  public function logout(){
    session_destroy();
    header('Location: /src/plataforma/'); exit;
  }
}
