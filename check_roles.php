<?php
try {
    $config = require 'config/config.php';
    $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
        $config['db']['host'],
        $config['db']['port'],
        $config['db']['name'],
        $config['db']['charset']
    );
    $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass']);
    echo 'Conexión exitosa a la base de datos' . PHP_EOL;
    
    // Verificar tabla roles
    $stmt = $pdo->query('SHOW TABLES LIKE "roles"');
    if ($stmt->rowCount() > 0) {
        echo 'Tabla roles existe' . PHP_EOL;
        
        // Describir la estructura de la tabla roles
        $stmt = $pdo->query('DESCRIBE roles');
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo 'Estructura de la tabla roles:' . PHP_EOL;
        foreach ($columns as $column) {
            echo sprintf('Campo: %s, Tipo: %s' . PHP_EOL, $column['Field'], $column['Type']);
        }
        
        // Mostrar roles
        $stmt = $pdo->query('SELECT * FROM roles');
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo PHP_EOL . 'Roles disponibles:' . PHP_EOL;
        foreach ($roles as $role) {
            echo sprintf('ID: %d, Nombre: %s, Slug: %s' . PHP_EOL,
                $role['id'], $role['name'], $role['slug']);
        }
    } else {
        echo 'Tabla roles NO existe' . PHP_EOL;
    }
    
    // Verificar tabla user_roles
    $stmt = $pdo->query('SHOW TABLES LIKE "user_roles"');
    if ($stmt->rowCount() > 0) {
        echo PHP_EOL . 'Tabla user_roles existe' . PHP_EOL;
        $stmt = $pdo->query('SELECT * FROM user_roles LIMIT 10');
        $userRoles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($userRoles as $ur) {
            echo sprintf('User ID: %d, Role ID: %d' . PHP_EOL, $ur['user_id'], $ur['role_id']);
        }
    } else {
        echo 'Tabla user_roles NO existe' . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}