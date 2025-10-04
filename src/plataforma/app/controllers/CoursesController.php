<?php
namespace App\Controllers;

use App\Models\Course;

class CoursesController {
  function index(){
    if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }

    $courseModel = new \App\Models\Course();
    $user = $_SESSION['user'];
    $role = $_SESSION['user_role'] ?? 'student';

    $courses = [];
    if ($role === 'admin') {
      $courses = $courseModel->getAll();
    } elseif ($role === 'teacher') {
      $courses = $courseModel->getByTeacher($user['id']);
    } elseif ($role === 'student') {
      $courses = $courseModel->getCurrentByStudent($user['id']);
    } elseif ($role === 'capturista') {
      $courses = $courseModel->getAll(); // or specific logic
    }

    ob_start();
    include __DIR__.'/../views/courses/index.php';
    return ob_get_clean();
  }
}
