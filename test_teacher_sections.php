<?php
// Test teacher section access

session_start();

// Load configuration and core files
require_once __DIR__ . '/src/plataforma/app/config/app.php';
foreach (glob(__DIR__ . '/src/plataforma/app/core/*.php') as $f) require_once $f;
foreach (glob(__DIR__ . '/src/plataforma/app/controllers/*.php') as $f) require_once $f;
foreach (glob(__DIR__ . '/src/plataforma/app/models/*.php') as $f) require_once $f;

echo "=== Testing Teacher Section Access ===\n\n";

// Test login
$userModel = new \App\Models\User();
$user = $userModel->findByEmail('maestro@utec.edu');

if ($user) {
    echo "User found: {$user->name} (ID: {$user->id}, Role ID: {$user->role_id})\n";

    // Simulate Auth::attempt success
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

    echo "Session set with role: {$roleName}\n";

    // Test GradesController
    echo "\n--- Testing Grades Section ---\n";
    try {
        $controller = new \App\Controllers\GradesController();
        $controller->index();
        echo "Grades section accessed successfully\n";
    } catch (Exception $e) {
        echo "Grades section failed: " . $e->getMessage() . "\n";
    }

    // Test StudentsController
    echo "\n--- Testing Students Section ---\n";
    try {
        $controller = new \App\Controllers\StudentsController();
        $controller->index();
        echo "Students section accessed successfully\n";
    } catch (Exception $e) {
        echo "Students section failed: " . $e->getMessage() . "\n";
    }

    // Test ScheduleController
    echo "\n--- Testing Schedule Section ---\n";
    try {
        $controller = new \App\Controllers\ScheduleController();
        $controller->index();
        echo "Schedule section accessed successfully\n";
    } catch (Exception $e) {
        echo "Schedule section failed: " . $e->getMessage() . "\n";
    }

} else {
    echo "Teacher user not found\n";
}

echo "\n=== Test Complete ===\n";