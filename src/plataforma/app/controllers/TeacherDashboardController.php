<?php

namespace App\Controllers;

use App\Core\Gate;
use App\Core\View;
use App\Models\Course;
use App\Models\User;
use App\Models\Grade;
use App\Models\Schedule;

class TeacherDashboardController {
  public function index(){
    // 1) Asegurar sesión antes de verificar roles
    if (session_status() === PHP_SESSION_NONE) session_start();

    // 2) Solo docente o admin
    Gate::allow(['teacher','admin']);

    // 3) Usuario en sesión
    $user = $_SESSION['user'] ?? null;
    if (!$user || empty($user['id'])) {
      header('Location: /src/plataforma/login'); exit;
    }

    // 4) Modelos
    $courseModel   = new Course();
    $userModel     = new User();
    $gradeModel    = class_exists('\App\Models\Grade') ? new Grade() : null;
    $scheduleModel = new Schedule();

    // 5) Datos del docente
    try {
      $teacherCourses = $courseModel->getByTeacher((int)$user['id']);
    } catch (\Throwable $e) {
      $teacherCourses = [];
    }

    try {
      $totalStudents = count($userModel->getStudentsByTeacher((int)$user['id']));
    } catch (\Throwable $e) {
      $totalStudents = 0;
    }

    try {
      $pendingGrades = $gradeModel ? $gradeModel->getPendingGrades() : [];
    } catch (\Throwable $e) {
      $pendingGrades = [];
    }

    try {
      $recentGradeUpdates = $gradeModel ? $gradeModel->getRecentByTeacher((int)$user['id'], 5) : [];
    } catch (\Throwable $e) {
      $recentGradeUpdates = [];
    }

    try {
      $weekSchedule = $scheduleModel->getWeekByTeacher((int)$user['id']);
    } catch (\Throwable $e) {
      $weekSchedule = [];
    }

    try {
      $nextClass = $scheduleModel->getNextClass($weekSchedule);
    } catch (\Throwable $e) {
      $nextClass = null;
    }

    // 6) Progreso del semestre (placeholder)
    $startDate = strtotime('2025-08-15');
    $endDate   = strtotime('2025-12-15');
    $current   = time();
    $semesterProgress = ($endDate > $startDate)
      ? min(100, max(0, (($current - $startDate) / ($endDate - $startDate)) * 100))
      : 0;

    // 7) Render
    View::render('teacher/dashboard', 'teacher', [
      'title'              => 'Panel del Docente',
      'user'               => $user,
      'teacherCourses'     => $teacherCourses,
      'totalStudents'      => $totalStudents,
      'pendingGrades'      => $pendingGrades,
      'recentGradeUpdates' => $recentGradeUpdates,
      'weekSchedule'       => $weekSchedule,
      'nextClass'          => $nextClass,
      'semesterProgress'   => $semesterProgress,
    ]);
  }
}
