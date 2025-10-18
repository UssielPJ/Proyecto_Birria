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
    
    // Obtener el hash completo del primer usuario
    $stmt = $pdo->query('SELECT email, password FROM users WHERE id = 1');
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo 'Email: ' . $user['email'] . PHP_EOL;
    echo 'Hash completo: ' . $user['password'] . PHP_EOL;
    echo 'Longitud del hash: ' . strlen($user['password']) . PHP_EOL;
    
    // Probar contraseñas comunes
    $passwords = ['password', '123456', 'admin', 'test', 'UTSC2025'];
    
    foreach ($passwords as $password) {
        $result = password_verify($password, $user['password']);
        echo sprintf('Contraseña "%s": %s' . PHP_EOL, $password, $result ? 'VÁLIDA' : 'inválida');
    }
    
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}