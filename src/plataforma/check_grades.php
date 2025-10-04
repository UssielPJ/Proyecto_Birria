<?php
require_once '../../src/db.php';

try {
    $stmt = $pdo->query("SELECT * FROM grades LIMIT 5");
    $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Grades:\n";
    print_r($grades);

    $stmt = $pdo->query("DESCRIBE grades");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "\nGrades table structure:\n";
    foreach ($columns as $col) {
        echo "- {$col['Field']}: {$col['Type']}\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}