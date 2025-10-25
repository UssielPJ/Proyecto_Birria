<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;
use PDO;
class GroupsController
{
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

    /* ========== INDEX ========== */
    public function index() {
        $this->requireRole(['admin']);
        $db = new Database();

        // OJO: tabla correcta es "grupos"
        $db->query("
            SELECT g.*, s.clave AS semestre_clave
            FROM grupos g
            JOIN semestres s ON s.id = g.semestre_id
            ORDER BY s.clave ASC, g.codigo ASC
        ");
        $grupos = $db->fetchAll();

        // para selects (crear/editar)
        $db->query("SELECT id, clave FROM semestres ORDER BY clave ASC");
        $semestres = $db->fetchAll();

        View::render('admin/groups/index', 'admin', [
            'grupos'    => $grupos,
            'semestres' => $semestres
        ]);
    }

    /* ========== CREATE ========== */
    public function create() {
        $this->requireRole(['admin']);
        $db = new Database();
        $db->query("SELECT id, clave FROM semestres ORDER BY clave ASC");
        $semestres = $db->fetchAll();
        View::render('admin/groups/create', 'admin', ['semestres'=>$semestres]);
    }

    /* ========== STORE ========== */
    public function store() {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();

        $d = $_POST;
        $db = new Database();

        try {
            $semestre_id = (int)($d['semestre_id'] ?? 0);
            $capacidad   = (int)($d['capacidad'] ?? 30);
            $titulo      = trim($d['titulo'] ?? '');

            if ($semestre_id <= 0) throw new \Exception('Semestre inválido');
            if ($capacidad < 1)   $capacidad = 30;

            // Obtener clave del semestre (ej: "IDGS-03")
            $db->query("SELECT clave FROM semestres WHERE id = ?", [$semestre_id]);
            $sem = $db->fetch();
            if (!$sem) throw new \Exception('Semestre no encontrado');

            // Siguiente sufijo dentro del semestre: ...-01, -02, ...
            $db->query("
                SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(codigo,'-',-1) AS UNSIGNED)),0) AS maxc
                FROM grupos
                WHERE semestre_id = ?
            ", [$semestre_id]);
            $next  = ((int)$db->fetchColumn()) + 1;
            $codigo = $sem->clave . '-' . str_pad((string)$next, 2, '0', STR_PAD_LEFT);

            if ($titulo === '') {
                // Título opcional (ej.: "Grupo 01")
                $titulo = 'Grupo ' . str_pad((string)$next, 2, '0', STR_PAD_LEFT);
            }

            // Insert a la tabla correcta y columnas reales
            $db->query("
                INSERT INTO grupos (semestre_id, codigo, titulo, capacidad, inscritos)
                VALUES (:sid, :cod, :tit, :cap, 0)
            ", [
                ':sid' => $semestre_id,
                ':cod' => $codigo,
                ':tit' => $titulo,
                ':cap' => $capacidad
            ]);

            $_SESSION['success'] = "Grupo creado: $codigo";
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo crear el grupo: '.$e->getMessage();
        }
        header('Location: /src/plataforma/app/admin/groups'); exit;
    }

    /* ========== EDIT (robusto) ========== */
public function edit($id) {
    $this->requireRole(['admin']);
    if (session_status() === PHP_SESSION_NONE) session_start();

    $id = (int)$id;
    if ($id <= 0) {
        $_SESSION['error'] = 'ID inválido.';
        header('Location: /src/plataforma/app/admin/groups'); exit;
    }

    $db = new Database();

    // 1) Traer el grupo con named param (evita problemas con "?")
    $sqlGrupo = "SELECT * FROM `grupos` WHERE `id` = :id LIMIT 1";
    $db->query($sqlGrupo, [':id' => $id]);
    // Fuerza fetch asociativo (si tu Database tiene FETCH_OBJ por default)
    $grupo = $db->fetch(PDO::FETCH_ASSOC);

    if (!$grupo) {
        $_SESSION['error'] = 'Grupo no encontrado.';
        header('Location: /src/plataforma/app/admin/groups'); exit;
    }

    // 2) Semestres para el select (también asociativo)
    $sqlSem = "SELECT `id`, `clave`, `numero` FROM `semestres` ORDER BY `clave` ASC";
    $db->query($sqlSem);
    $semestres = $db->fetchAll(PDO::FETCH_ASSOC);

    View::render('admin/groups/edit', 'admin', [
        'grupo'     => $grupo,
        'semestres' => $semestres
    ]);
}


    /* ========== UPDATE ========== */
    public function update($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();

        $id         = (int)$id;
        $db         = new Database();
        $d          = $_POST;

        try {
            // estado actual
            $db->query("SELECT * FROM grupos WHERE id = ?", [$id]);
            $actual = $db->fetch();
            if (!$actual) throw new \Exception('Grupo no encontrado.');

            $semestre_id = (int)($d['semestre_id'] ?? $actual->semestre_id);
            $capacidad   = (int)($d['capacidad']   ?? $actual->capacidad);
            $titulo      = trim($d['titulo']       ?? $actual->titulo);

            if ($capacidad < 1) $capacidad = $actual->capacidad;

            $codigo = $actual->codigo;

            // Si cambió de semestre, recalculamos el código para el nuevo semestre
            if ($semestre_id !== (int)$actual->semestre_id) {
                $db->query("SELECT clave FROM semestres WHERE id = ?", [$semestre_id]);
                $sem = $db->fetch();
                if (!$sem) throw new \Exception('Semestre no válido.');

                $db->query("
                    SELECT COALESCE(MAX(CAST(SUBSTRING_INDEX(codigo,'-',-1) AS UNSIGNED)),0) AS maxc
                    FROM grupos
                    WHERE semestre_id = ?
                ", [$semestre_id]);
                $next  = ((int)$db->fetchColumn()) + 1;
                $codigo = $sem->clave . '-' . str_pad((string)$next, 2, '0', STR_PAD_LEFT);
            }

            $db->query("
                UPDATE grupos
                SET semestre_id = :sid,
                    codigo      = :cod,
                    titulo      = :tit,
                    capacidad   = :cap
                WHERE id = :id
            ", [
                ':sid' => $semestre_id,
                ':cod' => $codigo,
                ':tit' => $titulo,
                ':cap' => $capacidad,
                ':id'  => $id
            ]);

            $_SESSION['success'] = 'Grupo actualizado.';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo actualizar: '.$e->getMessage();
        }

        header('Location: /src/plataforma/app/admin/groups'); exit;
    }

    /* ========== DELETE ========== */
    public function delete($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();
        $db = new Database();
        try {
            $db->query("DELETE FROM grupos WHERE id = ?", [(int)$id]);
            $_SESSION['success'] = 'Grupo eliminado.';
        } catch (\Throwable $e) {
            $_SESSION['error'] = 'No se pudo eliminar.';
        }
        header('Location: /src/plataforma/app/admin/groups'); exit;
    }


    /*  ==========  Grupos  ============ */
    public function students($id) {
    $this->requireRole(['admin']); // o ['admin', 'teacher'] si deseas permitir ambos
    $db = new \App\Core\Database();

    // Obtener datos del grupo
    $db->query("
        SELECT 
            g.id,
            g.codigo,
            g.titulo,
            g.capacidad,
            g.inscritos,
            s.id AS semestre_id,
            s.clave AS semestre_clave,
            s.numero AS semestre_numero,
            c.id AS carrera_id,
            c.nombre AS carrera_nombre,
            c.iniciales AS carrera_iniciales
        FROM grupos g
        LEFT JOIN semestres s ON s.id = g.semestre_id
        LEFT JOIN carreras c ON c.id = s.carrera_id
        WHERE g.id = :id
        LIMIT 1
    ", [':id' => $id]);

    $grupo = $db->fetch(\PDO::FETCH_OBJ);

    if (!$grupo) {
        header('Location: /src/plataforma/app/admin/groups?error=Grupo no encontrado');
        exit;
    }

    // Obtener alumnos asignados a ese grupo
    $db->query("
        SELECT 
            u.id AS user_id,
            u.nombre,
            u.apellido_paterno,
            u.apellido_materno,
            u.email,
            sp.curp,
            sp.tipo_ingreso,
            sp.beca_activa,
            sp.promedio_general,
            sp.creditos_aprobados
        FROM student_profiles sp
        INNER JOIN users u ON u.id = sp.user_id
        WHERE sp.grupo_id = :gid
        ORDER BY u.apellido_paterno, u.apellido_materno, u.nombre
    ", [':gid' => $id]);

    $alumnos = $db->fetchAll(\PDO::FETCH_OBJ);

    // Enviar a la vista
    \App\Core\View::render('admin/groups/students', 'admin', [
        'grupo'   => $grupo,
        'alumnos' => $alumnos,
    ]);
}

}
