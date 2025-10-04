<?php
namespace App\Controllers;

use App\Core\View;
class CapturistaImportarController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        \App\Core\View::render('capturista/importar', 'capturista');
    }

    public function historial() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        \App\Core\View::render('capturista/importar', 'capturista');
    }

    public function estado() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        \App\Core\View::render('capturista/importar', 'capturista');
    }

    public function procesar() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Lógica para procesar el archivo importado
        // Redireccionar a la página de estado
        $importacionId = uniqid(); // Simulación de ID de importación
        header("Location: /src/plataforma/capturista/importar/estado?id=$importacionId");
    }
}
