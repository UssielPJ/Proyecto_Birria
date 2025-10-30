<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;

class MateriaGrupoController {
    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) { header('Location: /src/plataforma/login'); exit; }
    }
    private function requireRole(array $roles) {
        $this->requireLogin();
        $userRoles = $_SESSION['user']['roles'] ?? [];
        foreach ($roles as $r) if (in_array($r, $userRoles, true)) return;
        header('Location: /src/plataforma/login'); exit;
    }

    private function mgHasCodigo(Database $db): bool {
        $col = $db->query("SHOW COLUMNS FROM materias_grupos LIKE 'codigo'")->fetch();
        return (bool)$col;
    }

    private function buildCodigo(Database $db, int $materia_id, int $grupo_id): ?string {
        $mClave = $db->query("SELECT clave FROM materias WHERE id=?", [$materia_id])->fetchColumn();
        $gCod   = $db->query("SELECT codigo FROM grupos   WHERE id=?", [$grupo_id])->fetchColumn();
        if (!$mClave || !$gCod) return null;
        return $mClave.'-'.$gCod;
    }

    public function create() {
        $this->requireRole(['admin']);
        $db = new Database();
        $materias = $db->query("SELECT id, clave, nombre FROM materias WHERE status='activa' ORDER BY nombre")->fetchAll();
        $grupos   = $db->query("SELECT id, codigo, titulo FROM grupos ORDER BY codigo")->fetchAll();
        View::render('admin/materias-grupos/create', 'admin',
            compact('materias','grupos') + ['title'=>'Asignar Materia a Grupo']);
    }

    /** Guarda (acepta 'codigo' del formulario; si viene vacío lo calcula) */
    public function store() {
        $this->requireRole(['admin']);
        $db = new Database();

        $materia_id = (int)($_POST['materia_id'] ?? 0);
        $grupo_id   = (int)($_POST['grupo_id'] ?? 0);
        $codigoPost = trim($_POST['codigo'] ?? '');

        if (!$materia_id || !$grupo_id) {
            header('Location: /src/plataforma/app/admin/materias-grupos'); exit;
        }

        // prevenir duplicado materia+grupo
        $exists = $db->query(
            "SELECT 1 FROM materias_grupos WHERE materia_id=? AND grupo_id=? LIMIT 1",
            [$materia_id, $grupo_id]
        )->fetchColumn();
        if ($exists) { header('Location: /src/plataforma/app/admin/materias-grupos'); exit; }

        if ($this->mgHasCodigo($db)) {
            $codigo = $codigoPost !== '' ? $codigoPost : $this->buildCodigo($db, $materia_id, $grupo_id);
            if ($codigo === null) { header('Location: /src/plataforma/app/admin/materias-grupos'); exit; }
            // evitar duplicado por código
            $dup = $db->query("SELECT 1 FROM materias_grupos WHERE codigo=? LIMIT 1", [$codigo])->fetchColumn();
            if ($dup) { header('Location: /src/plataforma/app/admin/materias-grupos'); exit; }

            $db->query("INSERT INTO materias_grupos (materia_id, grupo_id, codigo) VALUES (?,?,?)",
                       [$materia_id, $grupo_id, $codigo]);
        } else {
            $db->query("INSERT INTO materias_grupos (materia_id, grupo_id) VALUES (?,?)",
                       [$materia_id, $grupo_id]);
        }

        header('Location: /src/plataforma/app/admin/materias-grupos'); exit;
    }

    public function index() {
        $this->requireRole(['admin']);
        try {
            $db = new Database();
            $qMateria = trim($_GET['materia'] ?? '');
            $qGrupo   = trim($_GET['grupo'] ?? '');
            $qCodigo  = trim($_GET['codigo'] ?? '');

            $selectCodigo = $this->mgHasCodigo($db) ? "mg.codigo" : "CONCAT(m.clave,'-',g.codigo)";
            $sql = "SELECT mg.id, {$selectCodigo} AS codigo,
                           m.clave AS materia_clave, m.nombre AS materia_nombre,
                           g.codigo AS grupo_codigo, g.titulo AS grupo_titulo,
                           s.numero AS semestre_numero, c.nombre AS carrera_nombre, mg.created_at
                    FROM materias_grupos mg
                    JOIN materias m ON m.id=mg.materia_id
                    JOIN grupos   g ON g.id=mg.grupo_id
                    LEFT JOIN semestres s ON s.id = g.semestre_id
                    LEFT JOIN carreras  c ON c.id = s.carrera_id
                    WHERE 1=1";
            $params = [];
            if ($qMateria !== '') { $sql .= " AND (m.clave LIKE ? OR m.nombre LIKE ?)"; $params[]="%$qMateria%"; $params[]="%$qMateria%"; }
            if ($qGrupo   !== '') { $sql .= " AND (g.codigo LIKE ? OR g.titulo LIKE ?)"; $params[]="%$qGrupo%";   $params[]="%$qGrupo%"; }
            if ($qCodigo  !== '') { $sql .= " HAVING codigo LIKE ?"; $params[]="%$qCodigo%"; }
            $sql .= " ORDER BY g.codigo, m.nombre";

            $rows = $db->query($sql, $params)->fetchAll();
            View::render('admin/materias-grupos/index', 'admin',
                compact('rows','qMateria','qGrupo','qCodigo') + ['title'=>'Materias asignadas a grupos']);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo "<pre>ERROR:\n".$e->getMessage()."\n".$e->getFile().":".$e->getLine()."</pre>";
        }
    }

    /** Vista de edición */
    public function edit($id) {
        $this->requireRole(['admin']);
        $db = new Database();

        $row = $db->query("SELECT mg.*, m.clave AS materia_clave, m.nombre AS materia_nombre,
                                  g.codigo AS grupo_codigo, g.titulo AS grupo_titulo
                           FROM materias_grupos mg
                           JOIN materias m ON m.id=mg.materia_id
                           JOIN grupos   g ON g.id=mg.grupo_id
                           WHERE mg.id=?", [(int)$id])->fetch();

        if (!$row) { header('Location: /src/plataforma/app/admin/materias-grupos'); exit; }

        $materias = $db->query("SELECT id, clave, nombre FROM materias WHERE status='activa' ORDER BY nombre")->fetchAll();
        $grupos   = $db->query("SELECT id, codigo, titulo FROM grupos ORDER BY codigo")->fetchAll();

        // si no hay columna codigo, lo calculamos para mostrar
        if (!$this->mgHasCodigo($db)) {
            $row->codigo = $row->materia_clave.'-'.$row->grupo_codigo;
        }

        View::render('admin/materias-grupos/edit', 'admin',
            compact('row','materias','grupos') + ['title'=>'Editar asignación']);
    }

    /** Actualiza (acepta 'codigo') */
    public function update($id) {
        $this->requireRole(['admin']);
        $db = new Database();

        $materia_id = (int)($_POST['materia_id'] ?? 0);
        $grupo_id   = (int)($_POST['grupo_id'] ?? 0);
        $codigoPost = trim($_POST['codigo'] ?? '');

        if (!$materia_id || !$grupo_id) {
            header('Location: /src/plataforma/app/admin/materias-grupos'); exit;
        }

        // evitar duplicado materia+grupo con otra fila
        $exists = $db->query(
            "SELECT 1 FROM materias_grupos WHERE materia_id=? AND grupo_id=? AND id<>? LIMIT 1",
            [$materia_id, $grupo_id, (int)$id]
        )->fetchColumn();
        if ($exists) { header('Location: /src/plataforma/app/admin/materias-grupos'); exit; }

        if ($this->mgHasCodigo($db)) {
            $codigo = $codigoPost !== '' ? $codigoPost : $this->buildCodigo($db, $materia_id, $grupo_id);
            if ($codigo === null) { header('Location: /src/plataforma/app/admin/materias-grupos'); exit; }

            // duplicado por código en otra fila
            $dup = $db->query("SELECT 1 FROM materias_grupos WHERE codigo=? AND id<>? LIMIT 1", [$codigo, (int)$id])->fetchColumn();
            if ($dup) { header('Location: /src/plataforma/app/admin/materias-grupos'); exit; }

            $db->query("UPDATE materias_grupos SET materia_id=?, grupo_id=?, codigo=? WHERE id=?",
                       [$materia_id, $grupo_id, $codigo, (int)$id]);
        } else {
            $db->query("UPDATE materias_grupos SET materia_id=?, grupo_id=? WHERE id=?",
                       [$materia_id, $grupo_id, (int)$id]);
        }

        header('Location: /src/plataforma/app/admin/materias-grupos'); exit;
    }

    public function delete($id) {
        $this->requireRole(['admin']);
        $db = new Database();
        $db->query("DELETE FROM materias_grupos WHERE id=?", [(int)$id]);
        header('Location: /src/plataforma/app/admin/materias-grupos'); exit;
    }
}
