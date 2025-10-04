<?php
require_once '../../src/db.php';

try {
    $stmt = $pdo->query("SELECT * FROM courses LIMIT 5");
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Courses:\n";
    print_r($courses);

    $stmt = $pdo->query("SELECT COUNT(*) as count FROM courses");
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "\nTotal courses: " . $count['count'] . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}