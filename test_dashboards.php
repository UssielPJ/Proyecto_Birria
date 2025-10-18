<?php
// Test script to verify dashboard functionality for each role

session_start();

// Load configuration and core files
require_once __DIR__ . '/src/plataforma/app/config/app.php';
foreach (glob(__DIR__ . '/src/plataforma/app/core/*.php') as $f) require_once $f;
foreach (glob(__DIR__ . '/src/plataforma/app/controllers/*.php') as $f) require_once $f;
foreach (glob(__DIR__ . '/src/plataforma/app/models/*.php') as $f) require_once $f;

echo "=== Testing Dashboard Functionality ===\n\n";

// Test users (same as in test_all_roles.php)
$testUsers = [
    ['email' => 'admin@UTSC.edu', 'role' => 'admin', 'dashboard_url' => '/src/plataforma/admin'],
    ['email' => 'maestro@UTSC.edu', 'role' => 'teacher', 'dashboard_url' => '/src/plataforma/teacher'],
    ['email' => 'alumno@UTSC.edu', 'role' => 'student', 'dashboard_url' => '/src/plataforma/app'],
    ['email' => 'capturista@UTSC.edu', 'role' => 'capturista', 'dashboard_url' => '/src/plataforma/capturista']
];

$userModel = new \App\Models\User();

foreach ($testUsers as $testUser) {
    echo "Testing {$testUser['role']} dashboard...\n";

    // Simulate login by setting session
    $_SESSION = [];
    $user = $userModel->findByEmail($testUser['email']);
    if ($user) {
        // Set session like Auth::attempt does
        $roleNames = [1 => 'admin', 2 => 'teacher', 3 => 'student', 4 => 'capturista'];
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

        try {
            // Test dashboard controller
            switch ($testUser['role']) {
                case 'admin':
                    $controller = new \App\Controllers\AdminDashboardController();
                    $controller->index();
                    echo "✓ Admin dashboard rendered successfully\n";
                    break;
                case 'teacher':
                    $controller = new \App\Controllers\TeacherDashboardController();
                    $controller->index();
                    echo "✓ Teacher dashboard rendered successfully\n";
                    break;
                case 'student':
                    $controller = new \App\Controllers\StudentDashboardController();
                    $controller->index();
                    echo "✓ Student dashboard rendered successfully\n";
                    break;
                case 'capturista':
                    $controller = new \App\Controllers\CapturistaDashboardController();
                    $controller->index();
                    echo "✓ Capturista dashboard rendered successfully\n";
                    break;
            }
        } catch (Exception $e) {
            echo "✗ Error rendering dashboard: " . $e->getMessage() . "\n";
        }
    } else {
        echo "✗ User not found: {$testUser['email']}\n";
    }

    echo "---\n\n";
}

echo "=== Dashboard Testing Complete ===\n";