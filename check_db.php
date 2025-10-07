<?php
// Check database tables and structure

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

    // Show all tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Tables in database:\n";
    foreach ($tables as $table) {
        echo "- $table\n";
    }
    echo "\n";

    // Check grades table structure
    if (in_array('grades', $tables)) {
        echo "Grades table structure:\n";
        $stmt = $pdo->query("DESCRIBE grades");
        $columns = $stmt->fetchAll();
        foreach ($columns as $column) {
            echo "- {$column['Field']}: {$column['Type']}\n";
        }
        echo "\n";

        // Check if there are any grades
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM grades");
        $count = $stmt->fetch()['count'];
        echo "Number of grades in table: $count\n";
    } else {
        echo "Grades table does not exist!\n";
    }

    // Check courses table
    if (in_array('courses', $tables)) {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM courses");
        $count = $stmt->fetch()['count'];
        echo "Number of courses in table: $count\n";

        // Check courses for teacher ID 2
        $stmt = $pdo->query("SELECT * FROM courses WHERE teacher_id = 2");
        $courses = $stmt->fetchAll();
        echo "Courses for teacher ID 2: " . count($courses) . "\n";
        foreach ($courses as $course) {
            echo "  - {$course['name']} (ID: {$course['id']})\n";
        }
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}