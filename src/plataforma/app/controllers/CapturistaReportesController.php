<?php
namespace App\Controllers;

use App\Core\View;
class CapturistaReportesController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        \App\Core\View::render('capturista/reportes', 'capturista');
    }

    public function estudiantes() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        \App\Core\View::render('capturista/reportes', 'capturista');
    }

    public function profesores() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        \App\Core\View::render('capturista/reportes', 'capturista');
    }

    public function cursos() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        \App\Core\View::render('capturista/reportes', 'capturista');
    }

    public function calificaciones() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        \App\Core\View::render('capturista/reportes', 'capturista');
    }

    public function generar() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Generar reporte
        // Redireccionar a la lista de reportes
        header('Location: /src/plataforma/capturista/reportes');
    }
}
