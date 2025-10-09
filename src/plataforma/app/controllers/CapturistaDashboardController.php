<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Grade;

class CapturistaDashboardController {
  public function index(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
      header('Location: /src/plataforma/'); exit;
    }

    // Obtener datos del capturista
    $userModel = new User();
    $courseModel = new Course();
    $gradeModel = new Grade();

    $recentRegistrations = $userModel->getRecentUsers(5);
    // Map role_id to role name for display
    $roleMapping = [1 => 'admin', 2 => 'teacher', 3 => 'student', 4 => 'capturista'];
    foreach ($recentRegistrations as $user) {
        $user->role = $roleMapping[$user->role_id] ?? 'student';
    }
    $pendingGrades = $gradeModel->getPendingGrades();
    $totalStudents = $userModel->countByRole('student');
    $totalTeachers = $userModel->countByRole('teacher');

    // Estadísticas del día
    $todayStats = [
      'new_registrations' => count($recentRegistrations),
      'pending_grades' => count($pendingGrades),
      'total_students' => $totalStudents,
      'total_teachers' => $totalTeachers
    ];

    // Acciones pendientes
    $pendingActions = [
      'new_students' => $userModel->countPendingRegistrations(),
      'grade_updates' => $gradeModel->countPendingUpdates(),
      'schedule_changes' => $courseModel->countPendingScheduleChanges()
    ];

    // Cargar vista con los datos
    \App\Core\View::render('capturista/dashboard', 'capturista', [
      'title' => 'UTEC · Capturista',
      'user'  => $_SESSION['user'] ?? null,
      'todayStats' => $todayStats,
      'pendingActions' => $pendingActions,
      'recentRegistrations' => $recentRegistrations,
      'pendingGrades' => $pendingGrades
    ]);
  }
}
