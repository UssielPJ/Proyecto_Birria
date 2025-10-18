<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Grade;
use App\Core\Database; // <-- agrega esto

class CapturistaDashboardController {
  public function index(){
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
      header('Location: /src/plataforma/'); exit;
    }

    $userModel   = new User();
    $courseModel = new Course();
    $gradeModel  = new Grade();

    $recentRegistrations = $userModel->getRecentUsers(5);

    // ✅ Resolver rol principal SIN usar role_id
    foreach ($recentRegistrations as $user) {
      $user->role = $this->primaryRoleSlug((int)$user->id) ?? 'student';
    }

    $pendingGrades  = $gradeModel->getPendingGrades();
    $totalStudents  = $userModel->countByRole('student');
    $totalTeachers  = $userModel->countByRole('teacher');

    $todayStats = [
      'new_registrations' => count($recentRegistrations),
      'pending_grades'    => count($pendingGrades),
      'total_students'    => $totalStudents,
      'total_teachers'    => $totalTeachers
    ];

    $pendingActions = [
      'new_students'     => $userModel->countPendingRegistrations(),
      'grade_updates'    => $gradeModel->countPendingUpdates(),
      'schedule_changes' => $courseModel->countPendingScheduleChanges()
    ];

    \App\Core\View::render('capturista/dashboard', 'capturista', [
      'title'               => 'UTSC · Capturista',
      'user'                => $_SESSION['user'] ?? null,
      'todayStats'          => $todayStats,
      'pendingActions'      => $pendingActions,
      'recentRegistrations' => $recentRegistrations,
      'pendingGrades'       => $pendingGrades
    ]);
  }

  /**
   * Devuelve el slug del rol principal de un usuario.
   * Prioridad: admin > teacher > capturista > student
   * Usa pivote user_roles/roles si existe; si no, cae a perfiles.
   */
  private function primaryRoleSlug(int $userId): ?string {
    $db = new Database();

    // 1) Intentar vía pivote user_roles + roles
    try {
      $db->query("
        SELECT r.slug
        FROM roles r
        JOIN user_roles ur ON ur.role_id = r.id
        WHERE ur.user_id = ?
      ", [$userId]);
      $slugs = $db->fetchAll(\PDO::FETCH_COLUMN) ?: [];
      $slugs = array_map(fn($s)=> strtolower(trim((string)$s)), $slugs);
      if ($slugs) {
        $priority = ['admin','teacher','capturista','student'];
        foreach ($priority as $p) if (in_array($p, $slugs, true)) return $p;
        return $slugs[0]; // cualquier otro
      }
    } catch (\Throwable $e) {
      // tablas no existen: seguimos a perfiles
    }

    // 2) Sin pivote: inferir por tablas de perfiles
    $found = [];

    // student_profiles
    try {
      $db->query("SELECT 1 FROM student_profiles WHERE user_id = ? LIMIT 1", [$userId]);
      if ($db->fetchColumn()) $found[] = 'student';
    } catch (\Throwable $e) {}

    // teacher_profiles
    try {
      $db->query("SELECT 1 FROM teacher_profiles WHERE user_id = ? LIMIT 1", [$userId]);
      if ($db->fetchColumn()) $found[] = 'teacher';
    } catch (\Throwable $e) {}

    // capturista_profiles (si existe)
    try {
      $db->query("SELECT 1 FROM capturista_profiles WHERE user_id = ? LIMIT 1", [$userId]);
      if ($db->fetchColumn()) $found[] = 'capturista';
    } catch (\Throwable $e) {}

    if ($found) {
      $priority = ['admin','teacher','capturista','student'];
      foreach ($priority as $p) if (in_array($p, $found, true)) return $p;
      return $found[0];
    }

    // 3) Nada encontrado
    return null;
  }
}
