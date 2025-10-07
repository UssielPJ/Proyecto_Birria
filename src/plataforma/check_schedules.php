<?php
// Script para verificar la tabla schedules

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

    // Verificar la estructura de la tabla schedules
    echo "\n=== Estructura de la tabla schedules ===\n";
    $stmt = $pdo->query("DESCRIBE schedules");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
    }

    // Intentar una consulta simple
    echo "\n=== Consulta a schedules ===\n";
    $stmt = $pdo->query("SELECT * FROM schedules LIMIT 5");
    $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Encontrados " . count($schedules) . " registros.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>