<?php
// Script para probar el proceso de login

// Iniciar sesión
session_start();

// Cargar configuración
$config = require __DIR__ . '/../../config/config.php';

// Cargar clases necesarias
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/User.php';
require_once __DIR__ . '/app/core/Auth.php';

use App\Core\Database;
use App\Models\User;
use App\Core\Auth;

echo "=== Prueba de Login ===\n\n";

// Probar login con el usuario administrador
$email = 'admin@UTSC.edu';
$password = '12345';

echo "Intentando login con: $email / $password\n";

// Crear instancia del modelo User
$userModel = new User();

// Buscar usuario por email
$user = $userModel->findByEmail($email);

if ($user) {
    echo "Usuario encontrado:\n";
    echo "- ID: " . $user->id . "\n";
    echo "- Nombre: " . $user->name . "\n";
    echo "- Email: " . $user->email . "\n";
    echo "- Rol ID: " . $user->role_id . "\n";

    // Verificar contraseña
    if (password_verify($password, $user->password)) {
        echo "Contraseña válida\n";

        // Probar Auth::attempt
        if (Auth::attempt($email, $password)) {
            echo "Auth::attempt exitoso\n";

            // Obtener roles del usuario
            $roles = $userModel->getUserRoles($user->id);
            echo "Roles del usuario: " . implode(', ', $roles) . "\n";

            // Verificar datos de sesión
            echo "Datos de sesión:\n";
            print_r($_SESSION['user']);

            // Determinar destino según rol
            $destinos = [
                'student'     => '/src/plataforma/app',
                'teacher'     => '/src/plataforma/teacher',
                'admin'       => '/src/plataforma/admin',
                'capturista'  => '/src/plataforma/capturista'
            ];

            $primary = $roles[0] ?? null;
            $goto = '/src/plataforma/app'; // Default destination
            if ($primary && isset($destinos[$primary])) {
                $goto = $destinos[$primary];
            }

            echo "Redirección a: $goto\n";
        } else {
            echo "Auth::attempt falló\n";
        }
    } else {
        echo "Contraseña inválida\n";
    }
} else {
    echo "Usuario no encontrado\n";
}

echo "\n=== Fin de la prueba ===\n";
