<?php
// Check users table structure

$config = require __DIR__ . '/config/config.php';

try {
    $pdo = new PDO(
        sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $config['db']['host'],
            $config['db']['port'],
            $config['db']['name'],
            $config['db']['charset']
        ),
        $config['db']['user'],
        $config['db']['pass'],
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );

    echo "Connected to database successfully.\n\n";

    // Check users table structure
    echo "Users table structure:\n";
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll();
    foreach ($columns as $column) {
        echo "- {$column['Field']}: {$column['Type']}\n";
    }
    echo "\n";

    // Check courses table structure
    echo "Courses table structure:\n";
    $stmt = $pdo->query("DESCRIBE courses");
    $columns = $stmt->fetchAll();
    foreach ($columns as $column) {
        echo "- {$column['Field']}: {$column['Type']}\n";
    }
    echo "\n";

    // Check assignments table structure
    echo "Assignments table structure:\n";
    $stmt = $pdo->query("DESCRIBE assignments");
    $columns = $stmt->fetchAll();
    foreach ($columns as $column) {
        echo "- {$column['Field']}: {$column['Type']}\n";
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}