<?php
require_once '../../src/db.php';

try {
    $stmt = $pdo->query("SELECT * FROM roles");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Roles:\n";
    print_r($roles);

    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role_id = 1");
    $admins = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "\nAdmins: " . $admins['count'] . "\n";

    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role_id = 2");
    $teachers = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Teachers: " . $teachers['count'] . "\n";

    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role_id = 3");
    $students = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Students: " . $students['count'] . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
