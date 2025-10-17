<?php
// Test script to verify teacher dashboard functionality

session_start();

// Load configuration and core files
require_once __DIR__ . '/src/plataforma/app/config/app.php';
foreach (glob(__DIR__ . '/src/plataforma/app/core/*.php') as $f) require_once $f;
foreach (glob(__DIR__ . '/src/plataforma/app/controllers/*.php') as $f) require_once $f;
foreach (glob(__DIR__ . '/src/plataforma/app/models/*.php') as $f) require_once $f;

echo "=== Testing Teacher Dashboard ===\n\n";

$userModel = new \App\Models\User();
$user = $userModel->findByEmail('maestro@UTSC.edu');

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

    echo "User: {$user->name} (ID: {$user->id}, Role: {$roleName})\n";

    try {
        $controller = new \App\Controllers\TeacherDashboardController();
        $controller->index();
        echo "✓ Teacher dashboard rendered successfully\n";
    } catch (Exception $e) {
        echo "✗ Error rendering teacher dashboard: " . $e->getMessage() . "\n";
        echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    }
} else {
    echo "✗ Teacher user not found\n";
}

echo "=== Test Complete ===\n";