<?php
namespace App\Controllers;

use App\Core\Database;
use PDO;
use Throwable;

class AdminDashboardController {
  public function index(){
    // sesión + guard
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user']['roles']) || !in_array('admin', $_SESSION['user']['roles'], true)) {
      header('Location: /src/plataforma/login'); exit;
    }

    // Modo debug por querystring: /src/plataforma/admin?debug=1
    $debug = isset($_GET['debug']);

    try {
      $db = new Database();

      // === KPIs (ajusta nombres si tu schema difiere) ===
      $total_students = (int)$db->query("SELECT COUNT(*) FROM student_profiles")->fetchColumn();
      $total_teachers = (int)$db->query("SELECT COUNT(*) FROM teacher_profiles")->fetchColumn();
      $total_subjects = (int)$db->query("SELECT COUNT(*) FROM materias WHERE status='activa'")->fetchColumn();
      $active_groups  = (int)$db->query("SELECT COUNT(*) FROM grupos WHERE status='activo'")->fetchColumn();

      $asp_reg  = (int)$db->query("SELECT COUNT(*) FROM aspirantes WHERE status='registrado'")->fetchColumn();
      $asp_docs = (int)$db->query("SELECT COUNT(*) FROM aspirantes WHERE status='documentacion'")->fetchColumn();

      $becas_rev = (int)$db->query("SELECT COUNT(*) FROM solicitudes_becas WHERE status='en_revision'")->fetchColumn();

      $incomplete_documents = (int)$db->query("
        SELECT COUNT(*) FROM aspirantes WHERE documentos_entregados IS NULL
      ")->fetchColumn();

      $recent_users = $db->query("
        SELECT id, email, nombre, created_at
        FROM users ORDER BY created_at DESC LIMIT 5
      ")->fetchAll(PDO::FETCH_ASSOC);

      $recent_subjects = $db->query("
        SELECT id, clave, nombre, status, created_at
        FROM materias ORDER BY created_at DESC LIMIT 5
      ")->fetchAll(PDO::FETCH_ASSOC);

      $stats = [
        'total_students' => $total_students,
        'total_teachers' => $total_teachers,
        'total_subjects' => $total_subjects,
        'active_groups'  => $active_groups,
        'aspirantes_registrados'   => $asp_reg,
        'aspirantes_documentacion' => $asp_docs,
        'becas_en_revision'        => $becas_rev,
        'incomplete_documents' => $incomplete_documents,
        'recent_users'        => $recent_users,
        'recent_subjects'     => $recent_subjects,
      ];

      if ($debug) {
        header('Content-Type: text/plain; charset=utf-8');
        echo "AdminDashboardController@index (DEBUG)\n";
        echo "Usuario: " . ($_SESSION['user']['email'] ?? '???') . "\n\n";
        print_r($stats);
        exit;
      }

      // ===== Render real =====
      // SI falla aquí, el problema es la vista o la clase View.
      \App\Core\View::render('admin/dashboard', 'admin', [
        'title' => 'UTEC · Administración',
        'user'  => $_SESSION['user'] ?? null,
        'name'  => $_SESSION['user']['name'] ?? '',
        'email' => $_SESSION['user']['email'] ?? '',
        'stats' => $stats,
      ]);

    } catch (Throwable $e) {
      // No permitas que el router lo convierta en 404 silencioso
      http_response_code(500);
      header('Content-Type: text/plain; charset=utf-8');
      echo "Error en AdminDashboardController@index\n\n";
      echo $e->getMessage() . "\n";
      // En debug, muestra traza para ubicar tabla/campo/vista
      if ($debug) {
        echo "\n--- TRACE ---\n" . $e->getTraceAsString();
      }
      exit;
    }
  }
}
