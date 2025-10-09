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
    
    // Describir la estructura de la tabla users
    $stmt = $pdo->query('DESCRIBE users');
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo 'Estructura de la tabla users:' . PHP_EOL;
    foreach ($columns as $column) {
        echo sprintf('Campo: %s, Tipo: %s, Null: %s, Key: %s, Default: %s' . PHP_EOL,
            $column['Field'], $column['Type'], $column['Null'], $column['Key'], $column['Default']);
    }
    
    echo PHP_EOL . 'Primeros 5 usuarios:' . PHP_EOL;
    $stmt = $pdo->query('SELECT * FROM users LIMIT 5');
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
        echo 'Usuario: ' . json_encode($user) . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}