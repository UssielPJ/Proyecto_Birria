<?php
namespace App\Controllers;

use App\Models\Course;

class CoursesController {
  public function index(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user'])) { header('Location:/src/plataforma/'); exit; }

    $courseModel = new \App\Models\Course();
    $user  = $_SESSION['user'];

    // Resolver rol principal
    $roles = $_SESSION['user']['roles'] ?? ($_SESSION['roles'] ?? []);
    $role  = $_SESSION['role'] ?? ($roles[0] ?? 'student');

    // --- Datos para la vista ---
    $courses = [];
    if ($role === 'admin') {
      $courses = $courseModel->getAll();
    } elseif ($role === 'teacher') {
      $courses = $courseModel->getByTeacher((int)$user['id']);
    } elseif ($role === 'student') {
      // Evita fatal error si el método no existe
      if (method_exists($courseModel, 'getCurrentByStudent')) {
        $courses = $courseModel->getCurrentByStudent((int)$user['id']);
      } elseif (method_exists($courseModel, 'getByStudent')) {
        $courses = $courseModel->getByStudent((int)$user['id']);
      } else {
        $courses = []; // fallback seguro
      }
    } elseif ($role === 'capturista') {
      $courses = $courseModel->getAll();
    }

    // --- Render de la vista hija (NO incluye layout) ---
    $title = 'Mis Clases';
    ob_start();
    // ✅ ahora desde teacher/courses
    include __DIR__ . '/../views/teacher/courses/index.php';
    $content = ob_get_clean();

    // --- Render del layout padre según rol ---
    $layoutFile = __DIR__ . '/../views/layouts/' . $role . '.php';
    if (is_file($layoutFile)) {
      // $title, $user, $content quedan disponibles para el layout
      ob_start();
      include $layoutFile;
      return ob_get_clean();
    }

    // Si faltara el layout, al menos regresamos la vista
    return $content;
  }
}
