<?php
// Debug course query

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

    // Check course details
    $stmt = $pdo->query("SELECT * FROM courses WHERE id = 1");
    $course = $stmt->fetch();
    echo "Course details:\n";
    print_r($course);
    echo "\n";

    // Test the exact query from Course::getByTeacher
    $stmt = $pdo->prepare("SELECT c.*, 0 as student_count FROM courses c WHERE c.teacher_id = ? AND c.status = 'active'");
    $stmt->execute([2]);
    $courses = $stmt->fetchAll();
    echo "Courses for teacher 2 with status 'active':\n";
    print_r($courses);
    echo "\n";

    // Check what status values exist
    $stmt = $pdo->query("SELECT DISTINCT status FROM courses");
    $statuses = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Available status values in courses table:\n";
    print_r($statuses);

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}