<?php

namespace App\Controllers;

use App\Core\Gate;
use App\Core\View;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Setting;

class StudentDashboardController {
  public function index(){
    // Solo estudiante (o admin si quieres ver también)
    Gate::allow(['student']);

    // Cargar modelos necesarios
    $courseModel = new Course();
    $gradeModel = new Grade();
    $scheduleModel = new Schedule();
    $settingModel = new Setting(); // Instantiate Setting model

    $user = $_SESSION['user'];

    // Obtener datos del estudiante
    try {
        $currentCourses = $courseModel->getCurrentByStudent($user['id']);
    } catch (\Exception $e) {
        $currentCourses = [];
    }
    try {
        $recentGrades = $gradeModel->getRecentByStudent($user['id']);
    } catch (\Exception $e) {
        $recentGrades = [];
    }
    try {
        $averageGradeData = $gradeModel->getAverageByStudent($user['id']);
        $averageGrade = $averageGradeData['average'] ?? 0;
    } catch (\Exception $e) {
        $averageGrade = 0;
    }
    try {
        $weekSchedule = $scheduleModel->getWeekByStudent($user['id']);
    } catch (\Exception $e) {
        $weekSchedule = [];
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
    
    View::render('student/dashboard', 'student', [
      'title' => 'UTSC · Estudiante',
      'user'  => $user,
      'currentCourses' => $currentCourses,
      'recentGrades' => $recentGrades,
      'averageGrade' => $averageGrade,
      'weekSchedule' => $weekSchedule,
      'scheduleModel' => $scheduleModel,
      'semesterProgress' => $semesterProgress
    ]);
  }
}
