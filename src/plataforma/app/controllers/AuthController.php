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

    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    error_log("AuthController::login - Email: " . $email);
    error_log("AuthController::login - Password provided: " . (!empty($pass) ? 'Yes' : 'No'));

    if ($email === '' || $pass === '') {
      $_SESSION['flash_error'] = 'Completa tus credenciales';
      header('Location: /src/plataforma/'); exit;
    }

    if (Auth::attempt($email, $pass)) {
      // Redirección por rol
      $userModel = new User();
      $roles = $userModel->getUserRoles($_SESSION['user']['id']);
      $_SESSION['roles'] = $roles; // Set roles in session
      $primary = $roles[0] ?? null;

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

      header('Location: ' . $goto);
      exit;
    } else {
      $_SESSION['flash_error'] = 'Credenciales inválidas';
      header('Location: /src/plataforma/'); exit;
    }
  }

  public function logout(){
    Auth::logout();
    header('Location: /src/plataforma/'); exit;
  }
}
