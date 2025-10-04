<?php

class StudentDashboardController {
  public function index(){
    // Solo estudiante (o admin si quieres ver también)
    Gate::allow(['student']);

    // Cargar modelos necesarios
    require_once __DIR__ . '/../models/Course.php';
    require_once __DIR__ . '/../models/Grade.php';
    require_once __DIR__ . '/../models/Schedule.php';

    $courseModel = new \App\Models\Course();
    $gradeModel = new \App\Models\Grade();
    $scheduleModel = new \App\Models\Schedule();

    $user = $_SESSION['user'];

    // Obtener datos del estudiante
    $currentCourses = $courseModel->getCurrentByStudent($user['id']);
    $recentGrades = $gradeModel->getRecentByStudent($user['id']);
    $averageGrade = $gradeModel->getAverageByStudent($user['id']);
    $weekSchedule = $scheduleModel->getWeekByStudent($user['id']);

    // Calcula el progreso del semestre basado en la fecha actual
    $startDate = strtotime('2025-08-15'); // Fecha de inicio del semestre
    $endDate = strtotime('2025-12-15');   // Fecha de fin del semestre
    $currentDate = time();
    $semesterProgress = min(100, max(0, (($currentDate - $startDate) / ($endDate - $startDate)) * 100));

    View::render('student/dashboard', 'student', [
      'title' => 'UTEC · Estudiante',
      'user'  => $user,
      'currentCourses' => $currentCourses,
      'recentGrades' => $recentGrades,
      'averageGrade' => $averageGrade,
      'weekSchedule' => $weekSchedule,
      'semesterProgress' => $semesterProgress
    ]);
  }
}
