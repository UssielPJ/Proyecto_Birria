<?php
// Página de prueba para el botón de inicio de sesión
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

// Procesar formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    error_log("test_login_button - Formulario enviado");
    error_log("test_login_button - Email: " . $email);
    error_log("test_login_button - Password length: " . strlen($password));
    
    if (Auth::attempt($email, $password)) {
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
        $_SESSION['user']['role'] = $primary;
        
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
        
        error_log("test_login_button - Login exitoso");
        error_log("test_login_button - Rol: " . $primary);
        error_log("test_login_button - Redirección a: " . $goto);
        
        // Redirigir
        header('Location: ' . $goto);
        exit;
    } else {
        $error = "Credenciales inválidas";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Login Button</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .login-container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
        }
        input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Test Login Button</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="post" action="">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" onclick="console.log('Botón clickeado')">Iniciar Sesión</button>
        </form>
        
        <div style="margin-top: 1rem; font-size: 0.8rem; color: #666;">
            Usuarios de prueba:<br>
            admin@UTSC.edu / 12345<br>
            maestro@UTSC.edu / 12345<br>
            alumno@UTSC.edu / 12345<br>
            capturista@UTSC.edu / 12345
        </div>
    </div>
    
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            console.log('Formulario enviado');
        });
    </script>
</body>
</html>