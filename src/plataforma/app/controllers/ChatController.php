<?php
namespace App\Controllers;

class ChatController {
  public function index() {
    // Verificar sesión
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user'])) {
      header('Location: /src/plataforma/login'); 
      exit;
    }

    // Cargar la vista de chat
    include __DIR__ . '/../views/chat/index.php';
  }
}
?>
