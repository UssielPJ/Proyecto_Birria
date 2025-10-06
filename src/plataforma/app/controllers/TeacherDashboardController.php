<?php

namespace App\Controllers;

use App\Core\Gate;
use App\Core\View;
use App\Models\Course;
use App\Models\User;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Setting;

class TeacherDashboardController {
  public function index(){
    // Solo docente o admin
    Gate::allow(['teacher','admin']);

    // Cargar modelos necesarios
    $courseModel = new Course();
    $userModel = new User();
    $gradeModel = new Grade();
    $scheduleModel = new Schedule();
    $settingModel = new Setting(); // Instantiate Setting model

    $user = $_SESSION['user'];

    // Obtener datos del docente
    try {
        $teacherCourses = $courseModel->getByTeacher($user['id']);
    } catch (\Exception $e) {
        $teacherCourses = [];
    }
    try {
        $totalStudents = count($userModel->getStudentsByTeacher($user['id']));
    } catch (\Exception $e) {
        $totalStudents = 0;
    }
    try {
        $pendingGrades = $gradeModel->getPendingGrades();
    } catch (\Exception $e) {
        $pendingGrades = [];
    }
    try {
        $recentGradeUpdates = $gradeModel->getRecentByTeacher($user['id'], 5);
    } catch (\Exception $e) {
        $recentGradeUpdates = [];
    }
    try {
        $weekSchedule = $scheduleModel->getWeekByTeacher($user['id']);
    } catch (\Exception $e) {
        $weekSchedule = [];
    }
    try {
        $nextClass = $scheduleModel->getNextClass($weekSchedule);
    } catch (\Exception $e) {
        $nextClass = null;
    }

    // Calcula el progreso del semestre basado en la fecha actual
    $startDateStr = '2025-08-15'; // Default
    $endDateStr = '2025-12-15';     // Default

    $startDate = strtotime($startDateStr);
    $endDate = strtotime($endDateStr);
    $currentDate = time();

    $semesterProgress = 0;
    if ($endDate > $startDate) { // Avoid division by zero
        $semesterProgress = min(100, max(0, (($currentDate - $startDate) / ($endDate - $startDate)) * 100));
    }

    // Render con tu sistema de vistas. Usa View::render si lo tienes;
    // si no, incluye directamente el archivo de la vista.
    if (class_exists('App\\Core\\View')) {
      View::render('teacher/dashboard', 'teacher', [
        'title' => 'Panel del Docente',
        'user'  => $user,
        'teacherCourses' => $teacherCourses,
        'totalStudents' => $totalStudents,
        'pendingGrades' => $pendingGrades,
        'recentGradeUpdates' => $recentGradeUpdates,
        'weekSchedule' => $weekSchedule,
        'nextClass' => $nextClass,
        'semesterProgress' => $semesterProgress
      ]);
    } else {
      // Fallback simple
      $title = 'Panel del Docente';
      $user  = $_SESSION['user'];
      include __DIR__ . '/../views/teacher/dashboard.php';
    }
  }
}
