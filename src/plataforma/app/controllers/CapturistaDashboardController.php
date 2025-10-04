<?php
class CapturistaDashboardController {
  public function index(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
      header('Location: /src/plataforma/'); exit;
    }

    // Cargar modelos necesarios
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../models/Course.php';
    require_once __DIR__ . '/../models/Grade.php';

    // Obtener datos del capturista
    $userModel = new \App\Models\User();
    $courseModel = new \App\Models\Course();
    $gradeModel = new \App\Models\Grade();

    $recentRegistrations = $userModel->getRecentUsers(5);
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
    $user = $_SESSION['user'];
    include __DIR__.'/../views/capturista/dashboard.php';
  }
}
