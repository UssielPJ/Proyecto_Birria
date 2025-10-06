<?php
// Script para ejecutar todas las migraciones pendientes

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

    echo "Conexión a la base de datos exitosa.\n";

    // Obtener lista de archivos de migración
    $migrationDir = __DIR__ . '/database/migrations/';
    $migrationFiles = glob($migrationDir . '*.sql');

    // Ordenar por nombre (que incluye números)
    sort($migrationFiles);

    foreach ($migrationFiles as $file) {
        $filename = basename($file);
        echo "\nEjecutando migración: $filename\n";

        // Leer contenido del archivo
        $sql = file_get_contents($file);

        // Ejecutar la migración
        try {
            $pdo->exec($sql);
            echo "Migración $filename ejecutada exitosamente.\n";
        } catch (PDOException $e) {
            echo "Error al ejecutar $filename: " . $e->getMessage() . "\n";
            // Continuar con la siguiente migración
        }
    }

    echo "\nTodas las migraciones han sido procesadas.\n";

} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage() . "\n";
    exit(1);
}