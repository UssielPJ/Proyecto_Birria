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
    
    // Verificar si existe la tabla users
    $stmt = $pdo->query('SHOW TABLES LIKE "users"');
    if ($stmt->rowCount() > 0) {
        echo 'Tabla users existe' . PHP_EOL;
        
        // Contar usuarios
        $stmt = $pdo->query('SELECT COUNT(*) FROM users');
        $count = $stmt->fetchColumn();
        echo 'Total de usuarios: ' . $count . PHP_EOL;
        
        // Mostrar usuarios
        $stmt = $pdo->query('SELECT id, name, email, role FROM users LIMIT 10');
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($users as $user) {
            echo sprintf('ID: %d, Nombre: %s, Email: %s, Rol: %s' . PHP_EOL,
                $user['id'], $user['name'], $user['email'], $user['role']);
        }
    } else {
        echo 'Tabla users NO existe' . PHP_EOL;
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}