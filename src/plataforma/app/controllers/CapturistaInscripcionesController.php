<?php
namespace App\Controllers;

use App\Core\View;
class CapturistaInscripcionesController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        \App\Core\View::render('capturista/inscripciones', 'capturista');
    }

    public function crear() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        \App\Core\View::render('capturista/inscripciones', 'capturista');
    }

    public function guardar() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Procesar datos del formulario
        // Redireccionar a la lista de inscripciones
        header('Location: /src/plataforma/capturista/inscripciones');
    }

    public function eliminar($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Eliminar inscripción
        // Redireccionar a la lista de inscripciones
        header('Location: /src/plataforma/capturista/inscripciones');
    }
}
