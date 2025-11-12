<?php
/**
 * Script para ejecutar todas las migraciones de la base de datos
 * Uso: php run_migrations.php
 */

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

    echo "[✓] Conexión a la base de datos exitosa.\n\n";

    // Obtener lista de migraciones
    $migrationsDir = __DIR__ . '/database/migrations';
    $migrations = [];

    if (is_dir($migrationsDir)) {
        $files = scandir($migrationsDir);
        $files = array_filter($files, fn($f) => strpos($f, '.sql') !== false);
        sort($files);
        $migrations = $files;
    }

    if (empty($migrations)) {
        echo "[!] No se encontraron migraciones.\n";
        exit(0);
    }

    echo "Se encontraron " . count($migrations) . " migraciones:\n";
    foreach ($migrations as $mig) {
        echo "  - $mig\n";
    }
    echo "\n";

    // Ejecutar migraciones
    $executed = 0;
    $errors = [];

    foreach ($migrations as $migration) {
        $filePath = $migrationsDir . '/' . $migration;
        $sql = file_get_contents($filePath);

        // Dividir por punto y coma para múltiples sentencias
        $statements = array_filter(array_map('trim', explode(';', $sql)), fn($s) => !empty($s));

        try {
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    $pdo->exec($statement);
                }
            }
            echo "[✓] $migration ejecutada correctamente\n";
            $executed++;
        } catch (PDOException $e) {
            echo "[✗] Error en $migration: " . $e->getMessage() . "\n";
            $errors[] = $migration;
        }
    }

    echo "\n";
    echo "========================================\n";
    echo "Migraciones ejecutadas: $executed\n";
    if (!empty($errors)) {
        echo "Migraciones con error: " . count($errors) . "\n";
        foreach ($errors as $err) {
            echo "  - $err\n";
        }
    }
    echo "========================================\n";

} catch (PDOException $e) {
    echo "[✗] Error de conexión a la base de datos: " . $e->getMessage() . "\n";
    exit(1);
}
