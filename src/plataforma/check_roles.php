<?php
// Script para verificar la tabla roles

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

    // Verificar si existe la tabla roles
    $stmt = $pdo->query("SHOW TABLES LIKE 'roles'");
    if ($stmt->rowCount() > 0) {
        echo "
=== Estructura de la tabla roles ===
";
        $stmt = $pdo->query("DESCRIBE roles");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($columns as $column) {
            echo "- " . $column['Field'] . " (" . $column['Type'] . ")
";
        }

        // Verificar los datos de la tabla roles
        echo "
=== Datos de la tabla roles ===
";
        $stmt = $pdo->query("SELECT * FROM roles");
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($roles as $role) {
            echo "ID: " . $role['id'] . "
";
            echo "Nombre: " . $role['name'] . "
";
            echo "Slug: " . $role['slug'] . "
";
            echo "---
";
        }

        // Verificar la relación entre users y roles
        echo "
=== Relación users-roles ===
";
        $stmt = $pdo->query("
            SELECT u.id, u.name, u.email, r.slug as role
            FROM users u
            LEFT JOIN roles r ON u.role_id = r.id
        ");
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
    } else {
        echo "
La tabla 'roles' no existe.
";
    }

} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage() . "
";
    exit(1);
}
