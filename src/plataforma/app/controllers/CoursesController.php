<?php
namespace App\Controllers;

use App\Models\Course;

class CoursesController {
  public function index(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user'])) { header('Location:/src/plataforma/'); exit; }

    $courseModel = new Course();
    $user  = $_SESSION['user'];

    // Roles desde sesión
    $roles = $_SESSION['user']['roles'] ?? ($_SESSION['roles'] ?? []);
    $role  = $_SESSION['role'] ?? ($roles[0] ?? 'student');

    // Normaliza alias comunes a 'teacher'
    $flat = array_map('strtolower', (array)$roles);
    if (in_array('teacher', $flat, true) || in_array('docente', $flat, true) || in_array('profesor', $flat, true)) {
      $role = 'teacher';
    }

    // ID seguro del usuario/profesor
    $userId    = (int)($user['id'] ?? $user['user_id'] ?? 0);
    $teacherId = $userId;

    // --- Datos para la vista ---
    $courses = [];
    switch ($role) {
      case 'admin':
      case 'capturista':
        $courses = $courseModel->getAll();
        $viewRelPath = 'admin/courses/index.php';
        break;

      case 'teacher':
        $courses = $courseModel->getByTeacher($teacherId);
        $viewRelPath = 'teacher/courses/index.php';
        break;

      case 'student':
      default:
        if (method_exists($courseModel, 'getCurrentByStudent')) {
          $courses = $courseModel->getCurrentByStudent($userId);
        } elseif (method_exists($courseModel, 'getByStudent')) {
          $courses = $courseModel->getByStudent($userId);
        } else {
          $courses = [];
        }
        $viewRelPath = 'student/courses/index.php';
        break;
    }

    // Log de depuración (opcional)
    // error_log("COURSES role={$role} userId={$userId} count=".count($courses));

    // --- Render vista hija (NO incluye layout) ---
    $title    = 'Mis Clases';
    $viewFile = __DIR__ . '/../views/' . $viewRelPath;

    // Fallbacks de vista por rol
    if (!is_file($viewFile)) {
      // si no existe la del rol, intenta la de teacher
      $fallback = __DIR__.'/../views/teacher/courses/index.php';
      $viewFile = is_file($fallback) ? $fallback : null;
    }

    ob_start();
    // Variables disponibles en la vista: $title, $user, $role, $courses
    if ($viewFile) {
      include $viewFile;
    } else {
      // Último recurso: imprime lista simple para no romper
      echo "<div class='p-6'><h2>{$title}</h2>";
      if (empty($courses)) {
        echo "<p>No hay cursos disponibles.</p>";
      } else {
        echo "<ul>";
        foreach ($courses as $c) {
          $name = htmlspecialchars($c->name ?? 'Materia');
          $code = htmlspecialchars($c->code ?? '—');
          echo "<li>{$name} ({$code})</li>";
        }
        echo "</ul>";
      }
      echo "</div>";
    }
    $content = ob_get_clean();

    // --- Render layout por rol ---
    $layoutFile = __DIR__ . '/../views/layouts/' . $role . '.php';
    if (!is_file($layoutFile)) {
      // fallback al layout base (si existe)
      $layoutBase = __DIR__ . '/../views/layouts/base.php';
      if (is_file($layoutBase)) $layoutFile = $layoutBase;
    }

    if (is_file($layoutFile)) {
      ob_start();
      include $layoutFile; // usa $title, $user, $content
      return ob_get_clean();
    }

    return $content; // fallback si no hay layout
  }
}
