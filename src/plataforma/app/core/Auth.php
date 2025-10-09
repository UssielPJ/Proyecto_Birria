<?php

namespace App\Core;

use App\Models\User;

class Auth {
  static function user(){ return $_SESSION['user'] ?? null; }
  static function check(){ return !!self::user(); }

  static function attempt($email, $password){
    $userModel = new User();
    $user = $userModel->findByEmail($email);

    error_log("Auth::attempt - Attempting login for email: " . $email);

    if (!$user) {
        error_log("Auth::attempt - User not found for email: " . $email);
        return false;
    }

    error_log("Auth::attempt - User found: " . $user->email . ", Status: " . $user->status);
    
    // Debugging password values (only if debug is true)
    $config = require __DIR__ . '/../../../../config/config.php';
    if (($config['app']['debug'] ?? false)) {
        error_log("Auth::attempt - DB Password type: " . gettype($user->password) . ", length: " . (isset($user->password) ? strlen($user->password) : 'N/A'));
        error_log("Auth::attempt - Input Password type: " . gettype($password) . ", length: " . strlen($password));
    }

    if (!isset($user->password) || empty($user->password)) {
        error_log("Auth::attempt - User password not set or is empty for email: " . $email);
        return false;
    }

    // Debug password hash
    error_log("Auth::attempt - Password hash from DB: " . substr($user->password, 0, 10) . "...");
    error_log("Auth::attempt - Input password length: " . strlen($password));

    if (!password_verify($password, $user->password)) {
        error_log("Auth::attempt - Password verification failed for email: " . $email);
        return false;
    }

    // Traducir role_id a nombre de rol
    $roleNames = [
        1 => 'admin',
        2 => 'teacher',
        3 => 'student',
        4 => 'capturista'
    ];
    $roleName = $roleNames[$user->role_id] ?? 'student';
    
    $_SESSION['user'] = [
        'id'    => $user->id,
        'name'  => $user->name,
        'email' => $user->email,
        'role'  => $roleName,
        'role_id' => $user->role_id
    ];
    $_SESSION['user_role'] = $roleName;
    $_SESSION['roles'] = [$roleName];
    error_log("Auth::attempt - Login successful for user: " . $user->email);
    return true;
  }

  static function logout(){ unset($_SESSION['user']); }
}
