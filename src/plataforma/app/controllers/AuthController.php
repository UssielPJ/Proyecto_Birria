<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\User;
class AuthController {
  public function showLogin(){
    // muestra tu vista de login actual
    include __DIR__ . '/../views/auth/login.php';
  }

  public function login(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    error_log("AuthController::login - Login method called.");
    error_log("AuthController::login - POST data: " . print_r($_POST, true));
    error_log("AuthController::login - REQUEST_URI: " . $_SERVER['REQUEST_URI']);
    error_log("AuthController::login - REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD']);

    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    error_log("AuthController::login - Email: " . $email);
    error_log("AuthController::login - Password provided: " . (!empty($pass) ? 'Yes' : 'No'));

    // Validación básica
    $errors = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Correo electrónico inválido.';
    }
    if (strlen($pass) < 6) {
        $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
    }

    if (!empty($errors)) {
      $_SESSION['flash_error'] = implode('<br>', $errors);
      header('Location: /src/plataforma'); exit;
    }

    // Para compatibilidad con ambos correos
    $emailToUse = $email;
    if ($email === 'admin@utsc.edu.mx') {
        $emailToUse = 'admin@utec.edu';
    }

    // Guardar correo y contraseña en cookies si se seleccionó "Recordarme"
    if ($remember) {
        // Guardar el correo original (no el convertido)
        setcookie('user_email', $email, time() + 30 * 24 * 3600, '/');
        setcookie('user_password', $pass, time() + 30 * 24 * 3600, '/');
        setcookie('remember_token', bin2hex(random_bytes(32)), time() + 30 * 24 * 3600, '/');
    }

    if (Auth::attempt($emailToUse, $pass)) {
      // Obtener información completa del usuario
      $userModel = new User();
      $user = $userModel->findById($_SESSION['user']['id']);

      // Obtener roles del usuario
      $roles = $userModel->getUserRoles($_SESSION['user']['id']);
      $_SESSION['roles'] = $roles;
      $primary = $roles[0] ?? null;

      // Si no hay roles definidos, usar el rol por defecto del usuario
      if (!$primary && !empty($user->role_id)) {
        $roleTranslation = [
            1 => 'admin',
            2 => 'teacher',
            3 => 'student',
            4 => 'capturista'
        ];
        $primary = $roleTranslation[$user->role_id] ?? 'student';
        $_SESSION['roles'] = [$primary];
      }

      // Guardar información adicional en sesión
      $_SESSION['user']['name'] = $user->name;
      $_SESSION['user']['role'] = $primary; // Usar el rol primario de getUserRoles o el rol por defecto

      // Definir destinos según rol
      $destinos = [
        'student'     => '/src/plataforma/app',
        'teacher'     => '/src/plataforma/teacher',
        'admin'       => '/src/plataforma/admin',
        'capturista'  => '/src/plataforma/capturista'
      ];



      $goto = '/src/plataforma/app'; // Default destination
      if ($primary && isset($destinos[$primary])) {
        $goto = $destinos[$primary];
      }

      // Guardar información de depuración
      error_log("AuthController::login - Primary role: " . $primary);
      error_log("AuthController::login - User data: " . print_r($user, true));
      error_log("AuthController::login - Redirecting to: " . $goto);

      // Mensaje de éxito
      $_SESSION['flash_success'] = '¡Bienvenido ' . $user->name . '! Has iniciado sesión correctamente.';

      error_log("AuthController::login - Redirigiendo a: " . $goto);
      error_log("AuthController::login - Session data: " . print_r($_SESSION, true));
      
      // Asegurar que no haya salida antes de la redirección
      if (ob_get_level()) {
        ob_end_clean();
      }
      
      header('Location: ' . $goto);
      exit;
    } else {
      $_SESSION['flash_error'] = 'Credenciales inválidas. Por favor, verifica tu correo y contraseña.';
      header('Location: /src/plataforma'); exit;
    }
  }

  public function logout(){
    Auth::logout();
    header('Location: /src/plataforma/'); exit;
  }
}
