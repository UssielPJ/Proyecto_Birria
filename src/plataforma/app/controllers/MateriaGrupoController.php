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

    /** Utilidad: ¿la tabla materias_grupos tiene columna 'codigo'? */
    private function mgHasCodigo(Database $db): bool {
        $col = $db->query("SHOW COLUMNS FROM materias_grupos LIKE 'codigo'")->fetch();
        return (bool)$col;
    }

    /** Construye el código: <CLAVE_MATERIA>-<CODIGO_GRUPO> */
    private function buildCodigo(Database $db, int $materia_id, int $grupo_id): ?string {
        $mClave = $db->query("SELECT clave FROM materias WHERE id=?", [$materia_id])->fetchColumn();
        $gCod   = $db->query("SELECT codigo FROM grupos   WHERE id=?", [$grupo_id])->fetchColumn();
        if (!$mClave || !$gCod) return null;
        return $mClave . '-' . $gCod;
    }

    public function create() {
        $this->requireRole(['admin']);
        $db = new Database();
        $materias = $db->query("SELECT id, clave, nombre FROM materias WHERE status='activa' ORDER BY nombre")->fetchAll();
        $grupos   = $db->query("SELECT id, codigo, titulo FROM grupos ORDER BY codigo")->fetchAll();

        View::render(
            'admin/materias-grupos/create',
            'admin',
            compact('materias','grupos') + ['title' => 'Asignar Materia a Grupo']
        );
    }

    public function store() {
        $this->requireRole(['admin']);
        $db = new Database();

        $materia_id = (int)($_POST['materia_id'] ?? 0);
        $grupo_id   = (int)($_POST['grupo_id'] ?? 0);

        if (!$materia_id || !$grupo_id) {
            header('Location: /src/plataforma/app/admin/materias-grupos');
            exit;
        }

        try {
            // Evitar duplicado materia_id + grupo_id
            $exists = $db->query(
                "SELECT 1 FROM materias_grupos WHERE materia_id=? AND grupo_id=? LIMIT 1",
                [$materia_id, $grupo_id]
            )->fetchColumn();

            if ($exists) {
                header('Location: /src/plataforma/app/admin/materias-grupos');
                exit;
            }

            // Si existe la columna 'codigo', lo calculamos y guardamos.
            if ($this->mgHasCodigo($db)) {
                $codigo = $this->buildCodigo($db, $materia_id, $grupo_id);
                if ($codigo === null) {
                    // datos inconsistentes, regresar
                    header('Location: /src/plataforma/app/admin/materias-grupos');
                    exit;
                }

                // Evitar duplicado por código (si hay UNIQUE en la DB)
                $dupCodigo = $db->query("SELECT 1 FROM materias_grupos WHERE codigo=? LIMIT 1", [$codigo])->fetchColumn();
                if ($dupCodigo) {
                    header('Location: /src/plataforma/app/admin/materias-grupos');
                    exit;
                }

                $db->query(
                    "INSERT INTO materias_grupos (materia_id, grupo_id, codigo) VALUES (?, ?, ?)",
                    [$materia_id, $grupo_id, $codigo]
                );
            } else {
                // Fallback: sin columna 'codigo', insert simple
                $db->query(
                    "INSERT INTO materias_grupos (materia_id, grupo_id) VALUES (?, ?)",
                    [$materia_id, $grupo_id]
                );
            }

            header('Location: /src/plataforma/app/admin/materias-grupos');
            exit;

        } catch (\Throwable $e) {
            http_response_code(500);
            echo "<pre>ERROR guardando asignación:\n".$e->getMessage()."\n".$e->getFile().":".$e->getLine()."</pre>";
        }
    }

    public function index() {
        $this->requireRole(['admin']);
        try {
            $db = new Database();

            $qMateria = trim($_GET['materia'] ?? '');
            $qGrupo   = trim($_GET['grupo'] ?? '');
            $qCodigo  = trim($_GET['codigo'] ?? '');

            $selectCodigo = $this->mgHasCodigo($db) ? "mg.codigo," : "CONCAT(m.clave,'-',g.codigo) AS codigo,";

            $sql = "SELECT mg.id,
                           {$selectCodigo}
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
            if ($qCodigo  !== '') { $sql .= " AND ({$selectCodigo} 1=1)"; /* hack para reusar alias */ }

            // Ajuste del filtro por código (usamos HAVING sobre alias si no existe columna)
            if ($qCodigo !== '') {
                $sql .= " HAVING codigo LIKE ?"; 
                $params[] = "%$qCodigo%";
            }

            $sql .= " ORDER BY g.codigo, m.nombre";

            $rows = $db->query($sql, $params)->fetchAll();

            View::render(
                'admin/materias-grupos/index',
                'admin',
                compact('rows','qMateria','qGrupo','qCodigo') + ['title' => 'Materias asignadas a grupos']
            );
        } catch (\Throwable $e) {
            http_response_code(500);
            echo "<pre>ERROR:\n".$e->getMessage()."\n".$e->getFile().":".$e->getLine()."</pre>";
        }
    }

    public function delete($id) {
        $this->requireRole(['admin']);
        $db = new Database();
        $db->query("DELETE FROM materias_grupos WHERE id=?", [(int)$id]);
        header('Location: /src/plataforma/app/admin/materias-grupos');
        exit;
    }
}
