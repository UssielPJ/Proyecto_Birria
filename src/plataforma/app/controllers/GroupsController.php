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

    /** Expone el PDO como $GLOBALS['pdo'] para vistas legacy que usan "global $pdo" */
    private function exposePdo(Database $db): void {
        $pdo = $db->pdo(); // requiere que tu Database tenga ->pdo()
        $GLOBALS['pdo'] = $pdo; // hace visible "global $pdo" en la vista
    }

    /* ========== INDEX ========== */
    public function index() {
        $this->requireRole(['admin']);
        $db = new Database();

        // Consulta opcional (la vista podría volver a consultar, pero no rompe)
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

        // <-- clave para que la vista no falle con $pdo->prepare()
        $this->exposePdo($db);

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

        $this->exposePdo($db);

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
                $titulo = 'Grupo ' . str_pad((string)$next, 2, '0', STR_PAD_LEFT);
            }

            // Insert
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

    /* ========== EDIT ========== */
    public function edit($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();

        $id = (int)$id;
        if ($id <= 0) {
            $_SESSION['error'] = 'ID inválido.';
            header('Location: /src/plataforma/app/admin/groups'); exit;
        }

        $db = new Database();

        $sqlGrupo = "SELECT * FROM `grupos` WHERE `id` = :id LIMIT 1";
        $db->query($sqlGrupo, [':id' => $id]);
        $grupo = $db->fetch();

        if (!$grupo) {
            $_SESSION['error'] = 'Grupo no encontrado.';
            header('Location: /src/plataforma/app/admin/groups'); exit;
        }

        $sqlSem = "SELECT `id`, `clave`, `numero` FROM `semestres` ORDER BY `clave` ASC";
        $db->query($sqlSem);
        $semestres = $db->fetchAll(PDO::FETCH_ASSOC);

        $this->exposePdo($db);

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
            $db->query("SELECT * FROM grupos WHERE id = ?", [$id]);
            $actual = $db->fetch();
            if (!$actual) throw new \Exception('Grupo no encontrado.');

            $semestre_id = (int)($d['semestre_id'] ?? $actual->semestre_id);
            $capacidad   = (int)($d['capacidad']   ?? $actual->capacidad);
            $titulo      = trim($d['titulo']       ?? $actual->titulo);
            if ($capacidad < 1) $capacidad = $actual->capacidad;

            $codigo = $actual->codigo;

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

    /* ========== LISTA DE ALUMNOS DEL GRUPO ========== */
    public function students($id) {
        $this->requireRole(['admin']); // o ['admin','teacher']
        $db = new Database();

        // Datos del grupo
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

        $grupo = $db->fetch();
        if (!$grupo) {
            header('Location: /src/plataforma/app/admin/groups?error=Grupo no encontrado');
            exit;
        }

        // Alumnos del grupo
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
                sp.creditos_aprobados,
                sp.matricula
            FROM student_profiles sp
            INNER JOIN users u ON u.id = sp.user_id
            WHERE sp.grupo_id = :gid
            ORDER BY u.apellido_paterno, u.apellido_materno, u.nombre
        ", [':gid' => $id]);

        $alumnos = $db->fetchAll(PDO::FETCH_OBJ);

        $this->exposePdo($db);

        View::render('admin/groups/students', 'admin', [
            'grupo'   => $grupo,
            'alumnos' => $alumnos,
        ]);
    }

    /* ========== PREVIEW ASIGNACIÓN DE MATRÍCULAS (5 dígitos) ========== */
    public function assignMatriculasPreview($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();

        $groupId = (int)$id;
        $db = new Database();

        // Grupo
        $db->query("SELECT id, codigo FROM grupos WHERE id = ? LIMIT 1", [$groupId]);
        $grupo = $db->fetch();
        if (!$grupo) { $_SESSION['error'] = 'Grupo no encontrado.'; header('Location: /src/plataforma/app/admin/groups'); exit; }

        $G  = $this->groupDigit((string)$grupo->codigo);
        $YY = (int)date('y');
        $prefix3 = $YY*10 + $G;

        // Alumnos sin matrícula
        $db->query("
            SELECT sp.user_id
            FROM student_profiles sp
            WHERE sp.grupo_id = ? AND (sp.matricula IS NULL OR sp.matricula = '')
        ", [$groupId]);
        $pendientes = $db->fetchAll();
        $count = count($pendientes);

        // Max para ese prefijo (matricula VARCHAR -> castear a UNSIGNED)
        $db->query("
            SELECT MAX(CAST(matricula AS UNSIGNED)) AS max_mat
            FROM student_profiles
            WHERE matricula IS NOT NULL AND matricula <> '' 
              AND FLOOR(CAST(matricula AS UNSIGNED)/100) = ?
        ", [$prefix3]);
        $maxMat = (int)($db->fetchColumn() ?: 0);
        $lastLL = $maxMat ? ($maxMat % 100) : 0;

        $startLL = $lastLL + 1;
        $endLL   = $lastLL + $count;

        $this->exposePdo($db);

        View::render('admin/groups/assign_matriculas_preview', 'admin', [
            'groupId'  => $groupId,
            'grupo'    => $grupo,
            'YY'       => $YY,
            'G'        => $G,
            'prefix3'  => $prefix3,
            'count'    => $count,
            'startLL'  => $startLL,
            'endLL'    => $endLL,
        ]);
    }

    /* ========== RUN ASIGNACIÓN DE MATRÍCULAS (5 dígitos) ========== */
    public function assignMatriculasRun($id) {
        $this->requireRole(['admin']);
        if (session_status() === PHP_SESSION_NONE) session_start();

        $groupId = (int)$id;
        $db  = new Database();
        $pdo = $db->pdo();

        try {
            $pdo->beginTransaction();

            // Grupo
            $stmt = $pdo->prepare("SELECT id, codigo FROM grupos WHERE id = ? LIMIT 1");
            $stmt->execute([$groupId]);
            $grupo = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$grupo) throw new \RuntimeException('Grupo no encontrado.');

            $G  = $this->groupDigit((string)$grupo['codigo']);
            $YY = (int)date('y');
            $prefix3 = $YY*10 + $G; // YYG

            // Bloquear alumnos pendientes
            $stmt = $pdo->prepare("
                SELECT sp.user_id
                FROM student_profiles sp
                WHERE sp.grupo_id = ? AND (sp.matricula IS NULL OR sp.matricula = '')
                ORDER BY sp.user_id ASC
                FOR UPDATE
            ");
            $stmt->execute([$groupId]);
            $pending = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$pending) {
                $pdo->commit();
                $_SESSION['success'] = 'No hay alumnos pendientes de matrícula.';
                header('Location: /src/plataforma/app/admin/groups'); exit;
            }

            // Max para el prefijo (matricula VARCHAR -> castear)
            $stmt = $pdo->prepare("
                SELECT MAX(CAST(matricula AS UNSIGNED)) AS max_mat
                FROM student_profiles
                WHERE matricula IS NOT NULL AND matricula <> '' 
                  AND FLOOR(CAST(matricula AS UNSIGNED)/100) = ?
                FOR UPDATE
            ");
            $stmt->execute([$prefix3]);
            $maxMat = (int)($stmt->fetchColumn() ?: 0);
            $lastLL = $maxMat ? ($maxMat % 100) : 0;

            $upd = $pdo->prepare("UPDATE student_profiles SET matricula = ? WHERE user_id = ?");
            $LL  = $lastLL;

            foreach ($pending as $row) {
                $LL++;
                if ($LL > 99) throw new \RuntimeException('Se alcanzó el límite (99) de lista para este prefijo YYG.');
                $matricula = $YY*1000 + $G*100 + $LL; // YYGLL
                $upd->execute([$matricula, $row['user_id']]);
            }

            $pdo->commit();
            $_SESSION['success'] = "Se asignaron matrículas a ".count($pending)." alumno(s).";
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $_SESSION['error'] = 'No se pudo asignar: '.$e->getMessage();
        }

        header('Location: /src/plataforma/app/admin/groups'); exit;
    }

    /* ========= Helper: derivar dígito de grupo (0–9) desde g.codigo ========= */
    private function groupDigit(string $codigo): int {
        $codigo = trim($codigo);

        if (preg_match('/\d/', $codigo, $m)) {
            return (int)$m[0];
        }

        $letra = mb_strtoupper(mb_substr($codigo, 0, 1, 'UTF-8'), 'UTF-8');
        $map = ['A'=>1,'B'=>2,'C'=>3,'D'=>4,'E'=>5,'F'=>6,'G'=>7,'H'=>8,'I'=>9,'J'=>0];
        return $map[$letra] ?? 0;
    }
}
