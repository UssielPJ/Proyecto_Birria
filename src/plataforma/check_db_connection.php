<?php
// Script para verificar la conexión a la base de datos de Railway

// Cargar configuración
$config = require __DIR__ . '/../../config/config.php';

echo "Verificando conexión a la base de datos de Railway...
";
echo "Host: " . $config['db']['host'] . "
";
echo "Puerto: " . $config['db']['port'] . "
";
echo "Base de datos: " . $config['db']['name'] . "
";
echo "Usuario: " . $config['db']['user'] . "

";

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

    echo "✅ Conexión a la base de datos exitosa.

";

    // Verificar si la tabla users existe
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✅ La tabla 'users' existe.
";

        // Verificar estructura de la tabla users
        $stmt = $pdo->query("DESCRIBE users");
        echo "
Estructura de la tabla users:
";
        while ($row = $stmt->fetch()) {
            echo "- " . $row->Field . ": " . $row->Type . " (" . $row->Null . ", " . $row->Key . ")
";
        }

        // Verificar si hay usuarios en la tabla
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $userCount = $stmt->fetch()->count;
        echo "
✅ Hay " . $userCount . " usuarios en la base de datos.
";

        if ($userCount > 0) {
            // Mostrar los usuarios
            $stmt = $pdo->query("SELECT id, name, email, role_id, status FROM users");
            echo "
Usuarios en la base de datos:
";
            while ($row = $stmt->fetch()) {
                echo "- ID: " . $row->id . ", Nombre: " . $row->name . ", Email: " . $row->email . ", Rol ID: " . $row->role_id . ", Estado: " . $row->status . "
";
            }
        }
    } else {
        echo "❌ La tabla 'users' no existe.
";
    }

    // Verificar otras tablas importantes
    $tables = ['courses', 'enrollments', 'assignments', 'grades', 'announcements'];
    echo "
Verificando otras tablas importantes:
";

    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM $table");
            $count = $stmt->fetch()->count;
            echo "✅ Tabla '$table' existe con $count registros.
";
        } else {
            echo "❌ Tabla '$table' no existe.
";
        }
    }

} catch (PDOException $e) {
    echo "❌ Error de conexión a la base de datos: " . $e->getMessage() . "
";
    exit(1);
}

echo "
Verificación completada.
";
