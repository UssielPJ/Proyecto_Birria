<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;

class MateriaGrupoProfesorController {
  private function requireLogin(){
    if (session_status()===PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['user'])) { header('Location:/src/plataforma/login'); exit; }
  }
  private function requireRole(array $roles){
    $this->requireLogin();
    $userRoles = $_SESSION['user']['roles'] ?? [];
    foreach ($roles as $r) if (in_array($r, $userRoles, true)) return;
    header('Location:/src/plataforma/login'); exit;
  }

  /** Listado + búsqueda */
  public function index(){
    $this->requireRole(['admin']);
    $db = new Database();

    $q = trim($_GET['q'] ?? '');
    $sql = "SELECT
              mgp.id,
              mg.codigo              AS mg_codigo,
              m.clave                AS materia_clave,
              m.nombre               AS materia_nombre,
              g.codigo               AS grupo_codigo,
              g.titulo               AS grupo_titulo,
              u.id                   AS teacher_user_id,
              CONCAT(u.nombre,' ',COALESCE(u.apellido_paterno,''),' ',COALESCE(u.apellido_materno,'')) AS profesor_nombre,
              u.email                AS profesor_email,
              mgp.created_at
            FROM materia_grupo_profesor mgp
            JOIN materias_grupos mg ON mg.id = mgp.mg_id
            JOIN materias m        ON m.id  = mg.materia_id
            JOIN grupos g          ON g.id  = mg.grupo_id
            JOIN users u           ON u.id  = mgp.teacher_user_id
            WHERE 1=1";
    $params = [];
    if ($q !== '') {
      $sql .= " AND (
                  m.nombre LIKE ? OR m.clave LIKE ? OR
                  g.codigo LIKE ? OR
                  u.nombre LIKE ? OR u.apellido_paterno LIKE ? OR u.apellido_materno LIKE ? OR
                  u.email LIKE ? OR
                  mg.codigo LIKE ?
                )";
      $params = array_fill(0, 8, "%$q%");
    }
    $sql .= " ORDER BY g.codigo, m.nombre, profesor_nombre";

    $rows = $db->query($sql, $params)->fetchAll();
    View::render('admin/mg-profesores/index', 'admin', compact('rows','q') + ['title'=>'Asignar Profesor a Materia-Grupo']);
  }

  /** Form crear */
  public function create(){
    $this->requireRole(['admin']);
    $db = new Database();

    $mgs = $db->query(
      "SELECT mg.id, mg.codigo,
              m.nombre AS materia_nombre, m.clave AS materia_clave,
              g.codigo AS grupo_codigo
       FROM materias_grupos mg
       JOIN materias m ON m.id=mg.materia_id
       JOIN grupos   g ON g.id=mg.grupo_id
       ORDER BY g.codigo, m.nombre"
    )->fetchAll();

    // Docentes: users activos con perfil de maestro
    $teachers = $db->query(
      "SELECT u.id AS user_id,
              CONCAT(u.nombre,' ',COALESCE(u.apellido_paterno,''),' ',COALESCE(u.apellido_materno,'')) AS nombre
       FROM users u
       JOIN teacher_profiles tp ON tp.user_id = u.id
       WHERE u.status='active'
       ORDER BY nombre"
    )->fetchAll();

    View::render('admin/mg-profesores/create', 'admin', compact('mgs','teachers') + ['title'=>'Nueva asignación']);
  }

  /** Guardar */
  public function store(){
    $this->requireRole(['admin']);
    $db = new Database();

    $mg_id = (int)($_POST['mg_id'] ?? 0);
    $teacher_user_id = (int)($_POST['teacher_user_id'] ?? 0);
    if (!$mg_id || !$teacher_user_id) { header('Location:/src/plataforma/app/admin/mg-profesores'); exit; }

    // Evitar duplicado (mg_id, teacher_user_id)
    $exists = $db->query(
      "SELECT 1 FROM materia_grupo_profesor WHERE mg_id=? AND teacher_user_id=? LIMIT 1",
      [$mg_id, $teacher_user_id]
    )->fetchColumn();
    if ($exists) { header('Location:/src/plataforma/app/admin/mg-profesores'); exit; }

    $db->query("INSERT INTO materia_grupo_profesor (mg_id, teacher_user_id) VALUES (?,?)", [$mg_id, $teacher_user_id]);
    header('Location:/src/plataforma/app/admin/mg-profesores'); exit;
  }

  /** Form editar */
  public function edit($id){
    $this->requireRole(['admin']);
    $db = new Database();

    $row = $db->query(
      "SELECT mgp.*,
              mg.codigo AS mg_codigo,
              m.clave   AS materia_clave,
              m.nombre  AS materia_nombre,
              g.codigo  AS grupo_codigo,
              g.titulo  AS grupo_titulo
       FROM materia_grupo_profesor mgp
       JOIN materias_grupos mg ON mg.id=mgp.mg_id
       JOIN materias m        ON m.id=mg.materia_id
       JOIN grupos   g        ON g.id=mg.grupo_id
       WHERE mgp.id=?", [(int)$id]
    )->fetch();

    if (!$row) { header('Location:/src/plataforma/app/admin/mg-profesores'); exit; }

    $mgs = $db->query(
      "SELECT mg.id, mg.codigo,
              m.nombre AS materia_nombre, m.clave AS materia_clave,
              g.codigo AS grupo_codigo
       FROM materias_grupos mg
       JOIN materias m ON m.id=mg.materia_id
       JOIN grupos   g ON g.id=mg.grupo_id
       ORDER BY g.codigo, m.nombre"
    )->fetchAll();

    $teachers = $db->query(
      "SELECT u.id AS user_id,
              CONCAT(u.nombre,' ',COALESCE(u.apellido_paterno,''),' ',COALESCE(u.apellido_materno,'')) AS nombre
       FROM users u
       JOIN teacher_profiles tp ON tp.user_id = u.id
       WHERE u.status='active'
       ORDER BY nombre"
    )->fetchAll();

    View::render('admin/mg-profesores/edit', 'admin', compact('row','mgs','teachers') + ['title'=>'Editar asignación']);
  }

  /** Actualizar */
  public function update($id){
    $this->requireRole(['admin']);
    $db = new Database();

    $mg_id = (int)($_POST['mg_id'] ?? 0);
    $teacher_user_id = (int)($_POST['teacher_user_id'] ?? 0);
    if (!$mg_id || !$teacher_user_id) { header('Location:/src/plataforma/app/admin/mg-profesores'); exit; }

    // Duplicado con otra fila
    $exists = $db->query(
      "SELECT 1 FROM materia_grupo_profesor WHERE mg_id=? AND teacher_user_id=? AND id<>? LIMIT 1",
      [$mg_id, $teacher_user_id, (int)$id]
    )->fetchColumn();
    if ($exists) { header('Location:/src/plataforma/app/admin/mg-profesores'); exit; }

    $db->query("UPDATE materia_grupo_profesor SET mg_id=?, teacher_user_id=? WHERE id=?", [$mg_id, $teacher_user_id, (int)$id]);
    header('Location:/src/plataforma/app/admin/mg-profesores'); exit;
  }

  /** Eliminar */
  public function delete($id){
    $this->requireRole(['admin']);
    $db = new Database();
    $db->query("DELETE FROM materia_grupo_profesor WHERE id=?", [(int)$id]);
    header('Location:/src/plataforma/app/admin/mg-profesores'); exit;
  }
}
