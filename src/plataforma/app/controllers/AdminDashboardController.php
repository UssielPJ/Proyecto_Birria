<?php

class AdminDashboardController {
  public function index(){
    Gate::allow(['admin']);

    // Cargar modelos necesarios
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../models/CourseNew.php';
    $userModel = new \App\Models\User();
    $courseModel = new \App\Models\Course();

    // Obtener estadísticas
    $stats = [
      'total_students' => $userModel->countByRole('student'),
      'total_teachers' => $userModel->countByRole('teacher'),
      'total_courses' => $courseModel->count(),
      'active_courses' => $courseModel->countActive(),
      'monthly_registrations' => $userModel->getMonthlyRegistrations(),
      'role_distribution' => $userModel->getRoleDistribution(),
      'recent_users' => $userModel->getRecentUsers(5)
    ];

    View::render('admin/dashboard', 'admin', [
      'title' => 'UTEC · Administración',
      'user'  => $_SESSION['user'] ?? null,
      'stats' => $stats
    ]);
  }
}
