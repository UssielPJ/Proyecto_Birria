<?php

class AdminController {
  function index(){
    if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }
    // Aquí podrías validar rol admin con Gate::is('admin')
    ob_start(); include __DIR__.'/../views/admin/index.php'; return ob_get_clean();
  }

  function dashboard() {
    if(empty($_SESSION['user'])){ header('Location:/src/plataforma/'); exit; }
    // Aquí podrías validar rol admin con Gate::is('admin')

    // Obtener información del usuario actual
    $userId = $_SESSION['user']['id'] ?? 0;
    $userModel = new \App\Models\User();
    $currentUser = $userModel->findById($userId);

    // Variables para la vista
    $name = $currentUser->name ?? 'Usuario';
    $email = $currentUser->email ?? 'usuario@UTSC.edu';

    // Cargar modelos necesarios
    $courseModel = new \App\Models\Course();
    $gradeModel = new \App\Models\Grade();

    // Obtener estadísticas
    $stats = [
      'total_students' => $userModel->countByRole('student'),
      'total_teachers' => $userModel->countByRole('teacher'),
      'total_courses' => $courseModel->count(),
      'active_courses' => $courseModel->countByStatus('active'),
      'pending_grades' => $gradeModel->countPendingUpdates(),
      'recent_enrollments' => $userModel->getRecentByRole('student', 5),
      'upcoming_classes' => $courseModel->getUpcomingClasses(5),
      'recent_activities' => [
        ['type' => 'grade', 'message' => 'Nueva calificación registrada', 'time' => 'Hace 2 horas'],
        ['type' => 'enrollment', 'message' => 'Nuevo estudiante inscrito', 'time' => 'Hace 5 horas'],
        ['type' => 'course', 'message' => 'Curso actualizado', 'time' => 'Ayer'],
        ['type' => 'user', 'message' => 'Nuevo profesor registrado', 'time' => 'Hace 2 días']
      ]
    ];

    // Pasar datos a la vista
    ob_start(); 
    include __DIR__.'/../views/admin/dashboard.php'; 
    return ob_get_clean();
  }
}
