<?php
require_once '../../src/db.php';

try {
    $stmt = $pdo->query("DESCRIBE payments");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Payments table structure:\n";
    foreach ($columns as $col) {
        echo "- {$col['Field']}: {$col['Type']}\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}