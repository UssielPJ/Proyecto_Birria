<?php
// Script para probar el login con todos los roles

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

echo "=== Prueba de Login con todos los roles ===\n\n";

// Usuarios de prueba
$users = [
    ['email' => 'admin@utec.edu', 'password' => '12345', 'expected_role' => 'admin', 'expected_redirect' => '/src/plataforma/admin'],
    ['email' => 'maestro@utec.edu', 'password' => '12345', 'expected_role' => 'teacher', 'expected_redirect' => '/src/plataforma/teacher'],
    ['email' => 'alumno@utec.edu', 'password' => '12345', 'expected_role' => 'student', 'expected_redirect' => '/src/plataforma/app'],
    ['email' => 'capturista@utec.edu', 'password' => '12345', 'expected_role' => 'capturista', 'expected_redirect' => '/src/plataforma/capturista']
];

// Crear instancia del modelo User
$userModel = new User();

foreach ($users as $userData) {
    $email = $userData['email'];
    $password = $userData['password'];
    $expectedRole = $userData['expected_role'];
    $expectedRedirect = $userData['expected_redirect'];

    echo "Probando login con: $email / $password\n";

    // Limpiar sesión
    $_SESSION = [];

    // Probar Auth::attempt
    if (Auth::attempt($email, $password)) {
        echo "Auth::attempt exitoso\n";

        // Obtener roles del usuario
        $roles = $userModel->getUserRoles($_SESSION['user']['id']);
        $primary = $roles[0] ?? null;

        echo "Rol obtenido: $primary\n";
        echo "Rol esperado: $expectedRole\n";

        // Determinar destino según rol
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

        echo "Redirección a: $goto\n";
        echo "Redirección esperada: $expectedRedirect\n";

        if ($primary === $expectedRole && $goto === $expectedRedirect) {
            echo "✓ Prueba exitosa\n";
        } else {
            echo "✗ Prueba fallida\n";
        }
    } else {
        echo "✗ Auth::attempt falló\n";
    }

    echo "\n---\n\n";
}

echo "=== Fin de las pruebas ===\n";
