<?php
// Script to check announcements table structure

$config = require __DIR__ . '/../../config/config.php';

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
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );

    echo "Connected to database.\n";

    // Check if announcements table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'announcements'");
    if ($stmt->rowCount() == 0) {
        echo "Announcements table does not exist.\n";
        exit;
    }

    // Describe announcements table
    echo "\nAnnouncements table structure:\n";
    $stmt = $pdo->query("DESCRIBE announcements");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
    }

    // Check if target_role column exists
    $hasTargetRole = false;
    foreach ($columns as $column) {
        if ($column['Field'] === 'target_role') {
            $hasTargetRole = true;
            break;
        }
    }

    if (!$hasTargetRole) {
        echo "\nTarget_role column missing. Adding it...\n";
        $pdo->exec("ALTER TABLE announcements ADD COLUMN target_role ENUM('all', 'student', 'teacher') DEFAULT 'all'");
        echo "Target_role column added successfully.\n";
    } else {
        echo "\nTarget_role column exists.\n";
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
    exit(1);
}