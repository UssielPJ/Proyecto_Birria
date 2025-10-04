<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;
class CapturistaAlumnosController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        View::render('capturista/alumnos', 'capturista');
    }

    public function crear() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        View::render('capturista/alumnos', 'capturista');
    }

    public function editar($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        View::render('capturista/alumnos', 'capturista');
    }

    public function guardar() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Procesar datos del formulario
        // Redireccionar a la lista de alumnos
        header('Location: /src/plataforma/capturista/alumnos');
    }

    public function eliminar($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar modelos necesarios
        require_once __DIR__ . '/../models/User.php';
        $userModel = new User();

        // Eliminar alumno
        $userModel->delete($id);

        // Redireccionar a la lista de alumnos
        header('Location: /src/plataforma/capturista/alumnos');
    }
}
