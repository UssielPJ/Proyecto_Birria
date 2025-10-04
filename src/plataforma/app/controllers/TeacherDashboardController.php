<?php
class TeacherDashboardController {
  public function index(){
    // Solo docente o admin
    Gate::allow(['teacher','admin']);

    // Cargar modelos necesarios
    require_once __DIR__ . '/../models/Course.php';
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../models/Grade.php';
    require_once __DIR__ . '/../models/Schedule.php';

    $courseModel = new \App\Models\Course();
    $userModel = new \App\Models\User();
    $gradeModel = new \App\Models\Grade();
    $scheduleModel = new \App\Models\Schedule();

    $user = $_SESSION['user'];

    // Obtener datos del docente
    $teacherCourses = $courseModel->getByTeacher($user['id']);
    $totalStudents = count($userModel->getStudentsByTeacher($user['id']));
    $pendingGrades = $gradeModel->getPendingGrades();
    $recentGradeUpdates = $gradeModel->getRecentByTeacher($user['id'], 5);
    $weekSchedule = $scheduleModel->getWeekByTeacher($user['id']);
    $nextClass = $scheduleModel->getNextClass($weekSchedule);

    // Render con tu sistema de vistas. Usa View::render si lo tienes;
    // si no, incluye directamente el archivo de la vista.
    if (class_exists('View')) {
      View::render('teacher/dashboard', 'teacher', [
        'title' => 'Panel del Docente',
        'user'  => $user,
        'teacherCourses' => $teacherCourses,
        'totalStudents' => $totalStudents,
        'pendingGrades' => $pendingGrades,
        'recentGradeUpdates' => $recentGradeUpdates,
        'weekSchedule' => $weekSchedule,
        'nextClass' => $nextClass
      ]);
    } else {
      // Fallback simple
      $title = 'Panel del Docente';
      $user  = $_SESSION['user'];
      include __DIR__ . '/../views/teacher/dashboard.php';
    }
  }
}
