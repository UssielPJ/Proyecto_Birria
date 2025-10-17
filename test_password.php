<?php
// Probar las contraseñas comunes
$passwords = ['password', '123456', 'admin', 'test', 'UTSC2025'];
$hash = '$2a$12$HE2nILaoVjrBKXUoqhynVu.6N5tPz0QnGYgl.uZIH/Qp2.5CJgpzq';

echo 'Probando contraseñas contra el hash:' . PHP_EOL;
echo 'Hash: ' . $hash . PHP_EOL . PHP_EOL;

foreach ($passwords as $password) {
    $result = password_verify($password, $hash);
    echo sprintf('Contraseña "%s": %s' . PHP_EOL, $password, $result ? 'VÁLIDA' : 'inválida');
}