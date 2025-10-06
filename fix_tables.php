<?php
// Fix the database tables to match application expectations

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

    echo "Connected to database successfully.\n";

    // Rename existing assignments table (file imports) and create correct one
    echo "Renaming existing assignments table...\n";
    $pdo->exec("RENAME TABLE assignments TO file_imports");

    // Drop grades table
    $pdo->exec("DROP TABLE IF EXISTS grades");

    // Create assignments table (course assignments, not file imports)
    echo "Creating assignments table...\n";
    $pdo->exec("
        CREATE TABLE assignments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            course_id INT,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            due_date DATETIME NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Create grades table
    echo "Creating grades table...\n";
    $pdo->exec("
        CREATE TABLE grades (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_id INT,
            assignment_id INT,
            grade DECIMAL(5,2) NOT NULL,
            comments TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY unique_grade (student_id, assignment_id)
        )
    ");

    echo "Tables created successfully.\n";

    // Now assign a course to the teacher
    echo "Assigning course to teacher...\n";
    $pdo->exec("UPDATE courses SET teacher_id = 2 WHERE id = 1 LIMIT 1");

    echo "Course assigned to teacher.\n";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}