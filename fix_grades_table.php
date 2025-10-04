<?php
// Fix the grades table structure

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

    // Drop existing grades table
    echo "Dropping existing grades table...\n";
    $pdo->exec("DROP TABLE IF EXISTS grades");

    // Create grades table with correct structure
    echo "Creating grades table with correct structure...\n";
    $pdo->exec("
        CREATE TABLE grades (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_id INT,
            assignment_id INT,
            grade DECIMAL(5,2) NOT NULL,
            comments TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (student_id) REFERENCES users(id),
            FOREIGN KEY (assignment_id) REFERENCES assignments(id),
            UNIQUE KEY unique_grade (student_id, assignment_id)
        )
    ");

    echo "Grades table created successfully.\n";

    // Check if assignments table exists and has data
    $stmt = $pdo->query("SHOW TABLES LIKE 'assignments'");
    if ($stmt->rowCount() > 0) {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM assignments");
        $count = $stmt->fetch()['count'];
        echo "Assignments table exists with $count records.\n";
    } else {
        echo "Assignments table does not exist, creating it...\n";
        $pdo->exec("
            CREATE TABLE assignments (
                id INT AUTO_INCREMENT PRIMARY KEY,
                course_id INT,
                name VARCHAR(100) NOT NULL,
                description TEXT,
                due_date DATETIME NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (course_id) REFERENCES courses(id)
            )
        ");
        echo "Assignments table created.\n";
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}