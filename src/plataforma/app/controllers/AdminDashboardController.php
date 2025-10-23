<?php
namespace App\Controllers;

use App\Core\Database;
use PDO;
use Throwable;

class AdminDashboardController {
  public function index() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user']['roles']) || !in_array('admin', $_SESSION['user']['roles'], true)) {
      header('Location: /src/plataforma/login');
      exit;
    }

    $debug = isset($_GET['debug']);
    try {
      $db = new Database();

      // === Contadores con verificación de columna 'status' ===
      $total_students = (int)$db->query("SELECT COUNT(*) FROM student_profiles")->fetchColumn();
      $total_teachers = (int)$db->query("SELECT COUNT(*) FROM teacher_profiles")->fetchColumn();

      // Materias (usa status solo si existe)
      $hasStatusMaterias = $this->columnExists($db, 'materias', 'status');
      $sqlMaterias = $hasStatusMaterias
        ? "SELECT COUNT(*) FROM materias WHERE status='activa'"
        : "SELECT COUNT(*) FROM materias";
      $total_subjects = (int)$db->query($sqlMaterias)->fetchColumn();

      // Grupos
      $hasStatusGrupos = $this->columnExists($db, 'grupos', 'status');
      $sqlGrupos = $hasStatusGrupos
        ? "SELECT COUNT(*) FROM grupos WHERE status='activo'"
        : "SELECT COUNT(*) FROM grupos";
      $active_groups = (int)$db->query($sqlGrupos)->fetchColumn();

      // Aspirantes
      $hasStatusAspirantes = $this->columnExists($db, 'aspirantes', 'status');
      if ($hasStatusAspirantes) {
        $asp_reg  = (int)$db->query("SELECT COUNT(*) FROM aspirantes WHERE status='registrado'")->fetchColumn();
        $asp_docs = (int)$db->query("SELECT COUNT(*) FROM aspirantes WHERE status='documentacion'")->fetchColumn();
      } else {
        $asp_reg = $asp_docs = 0;
      }

      // Becas
      $hasStatusBecas = $this->columnExists($db, 'solicitudes_becas', 'status');
      $becas_rev = $hasStatusBecas
        ? (int)$db->query("SELECT COUNT(*) FROM solicitudes_becas WHERE status='en_revision'")->fetchColumn()
        : 0;

      // Aspirantes sin documentos
      $hasDocs = $this->columnExists($db, 'aspirantes', 'documentos_entregados');
      $incomplete_documents = $hasDocs
        ? (int)$db->query("SELECT COUNT(*) FROM aspirantes WHERE documentos_entregados IS NULL")->fetchColumn()
        : 0;

      // Recientes
      $recent_users = $db->query("
        SELECT id, email, nombre, created_at
        FROM users ORDER BY created_at DESC LIMIT 5
      ")->fetchAll(PDO::FETCH_ASSOC);

      $hasStatusMaterias = $this->columnExists($db, 'materias', 'status');
      $recent_subjects = $hasStatusMaterias
        ? $db->query("SELECT id, clave, nombre, status, created_at FROM materias ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC)
        : $db->query("SELECT id, clave, nombre, created_at FROM materias ORDER BY created_at DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

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

      \App\Core\View::render('admin/dashboard', 'admin', [
        'title' => 'UTSC · Administración',
        'user'  => $_SESSION['user'] ?? null,
        'name'  => $_SESSION['user']['name'] ?? '',
        'email' => $_SESSION['user']['email'] ?? '',
        'stats' => $stats,
      ]);

    } catch (Throwable $e) {
      http_response_code(500);
      header('Content-Type: text/plain; charset=utf-8');
      echo "Error en AdminDashboardController@index\n\n";
      echo $e->getMessage() . "\n";
      if ($debug) echo "\n--- TRACE ---\n" . $e->getTraceAsString();
      exit;
    }
  }

  /**
   * Verifica si una columna existe en una tabla.
   */
  private function columnExists(Database $db, string $table, string $column): bool {
    try {
      $stmt = $db->query("SHOW COLUMNS FROM {$table} LIKE ?", [$column]);
      return (bool)$stmt->fetch();
    } catch (Throwable $e) {
      return false;
    }
  }
}
