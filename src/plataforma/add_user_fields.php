<?php
// Script to add missing user fields

$config = require __DIR__ . '/../../config/config.php';

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

    echo "Conexión a la base de datos exitosa.\n";

    $columns = [
        'matricula' => 'VARCHAR(20) NULL',
        'semestre' => 'VARCHAR(20) NULL',
        'carrera' => 'VARCHAR(100) NULL',
        'grupo' => 'VARCHAR(20) NULL',
        'phone' => 'VARCHAR(20) NULL',
        'birthdate' => 'DATE NULL',
        'num_empleado' => 'VARCHAR(20) NULL',
        'departamento' => 'VARCHAR(100) NULL',
        'street' => 'VARCHAR(255) NULL',
        'neighborhood' => 'VARCHAR(100) NULL',
        'city' => 'VARCHAR(100) NULL',
        'state' => 'VARCHAR(100) NULL',
        'postal_code' => 'VARCHAR(10) NULL',
        'emergency_contact_name' => 'VARCHAR(100) NULL',
        'emergency_contact_phone' => 'VARCHAR(20) NULL',
        'emergency_contact_relationship' => 'VARCHAR(50) NULL'
    ];

    foreach ($columns as $column => $definition) {
        try {
            $pdo->exec("ALTER TABLE users ADD COLUMN $column $definition");
            echo "Columna '$column' agregada exitosamente.\n";
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
                echo "Columna '$column' ya existe, saltando.\n";
            } else {
                echo "Error al agregar columna '$column': " . $e->getMessage() . "\n";
            }
        }
    }

    echo "Proceso completado.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}