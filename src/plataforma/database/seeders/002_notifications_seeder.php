<?php
// Test notifications seeder
$pdo = require __DIR__ . '/../../../db.php';

$user_ids = $pdo->query("SELECT id FROM users LIMIT 5")->fetchAll(PDO::FETCH_COLUMN);

$notifications = [
    [
        'title' => 'Bienvenido a la plataforma',
        'message' => 'Te damos la bienvenida a la nueva plataforma educativa. Explora todas las funcionalidades disponibles.',
        'type' => 'info'
    ],
    [
        'title' => 'Nueva tarea asignada',
        'message' => 'Se ha asignado una nueva tarea en la materia de Programación Web.',
        'type' => 'task'
    ],
    [
        'title' => 'Recordatorio de pago',
        'message' => 'Tu próximo pago vence en 5 días. Por favor, realiza el pago a tiempo.',
        'type' => 'warning'
    ],
    [
        'title' => 'Calificación publicada',
        'message' => 'Se han publicado las calificaciones del último examen parcial.',
        'type' => 'grade'
    ],
    [
        'title' => 'Evento escolar',
        'message' => 'No te pierdas la feria de tecnología este viernes en el campus principal.',
        'type' => 'event'
    ]
];

$stmt = $pdo->prepare("
    INSERT INTO notifications (user_id, title, message, type, created_at)
    VALUES (:user_id, :title, :message, :type, :created_at)
");

foreach ($user_ids as $user_id) {
    foreach ($notifications as $notification) {
        $created_at = date('Y-m-d H:i:s', strtotime('-' . rand(0, 10) . ' hours'));
        $stmt->execute([
            'user_id' => $user_id,
            'title' => $notification['title'],
            'message' => $notification['message'],
            'type' => $notification['type'],
            'created_at' => $created_at
        ]);
    }
}

echo "Notificaciones de prueba creadas exitosamente.\n";