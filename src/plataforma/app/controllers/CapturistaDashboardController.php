<?php
class CapturistaDashboardController {
  public function index(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
      header('Location: /src/plataforma/'); exit;
    }
    // Carga tu layout/vista del capturista
    include __DIR__.'/../views/layouts/capturista.php';
  }
}
