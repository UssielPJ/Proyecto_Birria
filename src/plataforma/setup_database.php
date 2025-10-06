<?php
// Script para verificar la conexión a la base de datos y crear usuarios de prueba

// Cargar configuración
$config = require __DIR__ . '/../../config/config.php';

// Conectar a la base de datos
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

    echo "Conexión a la base de datos exitosa.
";

    // Verificar si la tabla users existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() == 0) {
        echo "La tabla 'users' no existe. Creando tabla...
";

        // Crear tabla users
        $pdo->exec("
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin', 'capturista', 'teacher', 'student') NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )
        ");

        echo "Tabla 'users' creada exitosamente.
";
    } else {
        echo "La tabla 'users' ya existe.
";
    }

    // Verificar si existen usuarios de prueba
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $userCount = $stmt->fetch()->count;

    if ($userCount == 0) {
        echo "No hay usuarios en la base de datos. Creando usuarios de prueba...
";

        // Insertar usuarios de prueba con contraseña: 12345
        $passwordHash = password_hash('12345', PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("
            INSERT INTO users (name, email, password, role) VALUES
            ('Administrador', 'admin@utec.edu', ?, 'admin'),
            ('Capturista', 'capturista@utec.edu', ?, 'capturista'),
            ('Maestro', 'maestro@utec.edu', ?, 'teacher'),
            ('Estudiante', 'estudiante@utec.edu', ?, 'student')
        ");

        $stmt->execute([$passwordHash, $passwordHash, $passwordHash, $passwordHash]);

        echo "Usuarios de prueba creados exitosamente.
";
        echo "Puedes iniciar sesión con:
";
        echo "- Admin: admin@utec.edu / 12345
";
        echo "- Capturista: capturista@utec.edu / 12345
";
        echo "- Maestro: maestro@utec.edu / 12345
";
        echo "- Estudiante: estudiante@utec.edu / 12345
";
    } else {
        echo "Ya existen {$userCount} usuarios en la base de datos.
";
    }

} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage() . "
";
    exit(1);
}
