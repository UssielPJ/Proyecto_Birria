<?php
// Script para verificar la estructura de la tabla users

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

    // Listar todas las tablas
    echo "
=== Tablas en la base de datos ===
";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_NUM);

    foreach ($tables as $table) {
        echo "- " . $table[0] . "
";
    }

    // Verificar la estructura de la tabla users
    echo "
=== Estructura de la tabla users ===
";
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")
";
    }

    // Verificar la estructura de la tabla courses
    echo "
=== Estructura de la tabla courses ===
";
    $stmt = $pdo->query("DESCRIBE courses");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")
";
    }

    // Verificar la estructura de la tabla rooms
    echo "
=== Estructura de la tabla rooms ===
";
    $stmt = $pdo->query("DESCRIBE rooms");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")
";
    }

    // Verificar la estructura de la tabla groups
    echo "
=== Estructura de la tabla groups ===
";
    $stmt = $pdo->query("DESCRIBE `groups`");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")
";
    }

    // Verificar la estructura de la tabla terms
    echo "
=== Estructura de la tabla terms ===
";
    $stmt = $pdo->query("DESCRIBE terms");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")
";
    }

    // Verificar los datos de la tabla users
    echo "
=== Datos de la tabla users ===
";
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        echo "ID: " . $user['id'] . "
";
        echo "Nombre: " . $user['name'] . "
";
        echo "Email: " . $user['email'] . "
";
        echo "Rol: " . ($user['role'] ?? 'No definido') . "
";
        echo "---
";
    }

} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage() . "
";
    exit(1);
}
