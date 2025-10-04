<?php
// Test teacher login and dashboard access

session_start();

// Load configuration and core files
require_once __DIR__ . '/src/plataforma/app/config/app.php';
foreach (glob(__DIR__ . '/src/plataforma/app/core/*.php') as $f) require_once $f;
foreach (glob(__DIR__ . '/src/plataforma/app/controllers/*.php') as $f) require_once $f;
foreach (glob(__DIR__ . '/src/plataforma/app/models/*.php') as $f) require_once $f;

echo "=== Testing Teacher Login and Access ===\n\n";

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

    // Test Gate::role()
    echo "Gate::role(): " . \App\Core\Gate::role() . "\n";

    // Test Gate::is('teacher')
    echo "Gate::is('teacher'): " . (\App\Core\Gate::is('teacher') ? 'true' : 'false') . "\n";

    // Test Gate::allow(['teacher','admin']) - this should not redirect
    echo "Testing Gate::allow(['teacher','admin'])...\n";
    try {
        \App\Core\Gate::allow(['teacher','admin']);
        echo "Gate::allow passed - access granted\n";
    } catch (Exception $e) {
        echo "Gate::allow failed: " . $e->getMessage() . "\n";
    }

    // Test dashboard access
    echo "\nTesting dashboard access...\n";
    try {
        $controller = new \App\Controllers\TeacherDashboardController();
        $controller->index();
        echo "Dashboard accessed successfully\n";
    } catch (Exception $e) {
        echo "Dashboard access failed: " . $e->getMessage() . "\n";
    }

} else {
    echo "Teacher user not found\n";
}

echo "\n=== Test Complete ===\n";