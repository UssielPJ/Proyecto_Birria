<?php
// Script para verificar la estructura de la tabla assignments

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

    // Verificar si la tabla assignments existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'assignments'");
    if ($stmt->rowCount() == 0) {
        echo "La tabla 'assignments' no existe.
";
    } else {
        echo "La tabla 'assignments' existe.
";

        // Verificar la estructura de la tabla assignments
        echo "
=== Estructura de la tabla assignments ===
";
        $stmt = $pdo->query("DESCRIBE assignments");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($columns as $column) {
            echo "- " . $column['Field'] . " (" . $column['Type'] . ")
";
        }
    }

} catch (PDOException $e) {
    echo "Error de conexión a la base de datos: " . $e->getMessage() . "
";
    exit(1);
}
