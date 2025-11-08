<?php
namespace App\Controllers\api;

class ChatApiController {
  // Obtener conversaciones del usuario actual
  public function getConversations() {
    // Verificar sesión
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user'])) {
      http_response_code(401);
      echo json_encode(['error' => 'No autorizado']);
      exit;
    }

    // Simular obtención de conversaciones desde la base de datos
    $conversations = [
      [
        'id' => 1,
        'user' => [
          'id' => 2,
          'name' => 'Juan Pérez',
          'role' => 'Estudiante',
          'avatar' => null,
          'online' => true
        ],
        'lastMessage' => [
          'content' => 'Hola, ¿cómo estás?',
          'timestamp' => '2023-06-15 10:30:00',
          'sender' => 'other'
        ],
        'unread' => 2
      ],
      [
        'id' => 2,
        'user' => [
          'id' => 3,
          'name' => 'María González',
          'role' => 'Maestra',
          'avatar' => null,
          'online' => false
        ],
        'lastMessage' => [
          'content' => 'Gracias por la información',
          'timestamp' => '2023-06-14 15:45:00',
          'sender' => 'other'
        ],
        'unread' => 0
      ]
    ];

    header('Content-Type: application/json');
    echo json_encode($conversations);
  }

  // Obtener mensajes de una conversación
  public function getMessages() {
    // Verificar sesión
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user'])) {
      http_response_code(401);
      echo json_encode(['error' => 'No autorizado']);
      exit;
    }

    // Obtener ID de conversación
    $conversationId = $_GET['conversation_id'] ?? null;
    if (!$conversationId) {
      http_response_code(400);
      echo json_encode(['error' => 'ID de conversación requerido']);
      exit;
    }

    // Simular obtención de mensajes desde la base de datos
    $messages = [
      [
        'id' => 1,
        'content' => 'Hola, ¿cómo estás?',
        'timestamp' => '2023-06-15 10:30:00',
        'sender' => 'other'
      ],
      [
        'id' => 2,
        'content' => 'Hola, bien gracias. ¿Y tú?',
        'timestamp' => '2023-06-15 10:32:00',
        'sender' => 'me'
      ],
      [
        'id' => 3,
        'content' => 'Todo bien por aquí. ¿Ya revisaste la tarea?',
        'timestamp' => '2023-06-15 10:35:00',
        'sender' => 'other'
      ]
    ];

    header('Content-Type: application/json');
    echo json_encode($messages);
  }

  // Enviar un mensaje
  public function sendMessage() {
    // Verificar sesión
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user'])) {
      http_response_code(401);
      echo json_encode(['error' => 'No autorizado']);
      exit;
    }

    // Obtener datos del mensaje
    $data = json_decode(file_get_contents('php://input'), true);
    $conversationId = $data['conversation_id'] ?? null;
    $content = $data['content'] ?? null;

    if (!$conversationId || !$content) {
      http_response_code(400);
      echo json_encode(['error' => 'ID de conversación y contenido requeridos']);
      exit;
    }

    // Simular envío de mensaje a la base de datos
    $message = [
      'id' => rand(1000, 9999),
      'content' => $content,
      'timestamp' => date('Y-m-d H:i:s'),
      'sender' => 'me'
    ];

    header('Content-Type: application/json');
    echo json_encode($message);
  }

  // Obtener lista de contactos
  public function getContacts() {
    // Verificar sesión
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user'])) {
      http_response_code(401);
      echo json_encode(['error' => 'No autorizado']);
      exit;
    }

    // Simular obtención de contactos desde la base de datos
    $contacts = [
      [
        'id' => 4,
        'name' => 'Carlos Rodríguez',
        'role' => 'Estudiante',
        'avatar' => null,
        'online' => true
      ],
      [
        'id' => 5,
        'name' => 'Ana López',
        'role' => 'Maestra',
        'avatar' => null,
        'online' => true
      ],
      [
        'id' => 6,
        'name' => 'Luis Martínez',
        'role' => 'Administrador',
        'avatar' => null,
        'online' => false
      ]
    ];

    header('Content-Type: application/json');
    echo json_encode($contacts);
  }
}
?>
