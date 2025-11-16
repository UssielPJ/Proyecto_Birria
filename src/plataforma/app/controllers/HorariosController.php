<?php
// app/controllers/HorariosController.php
namespace App\Controllers;

use App\Core\Database;
use App\Core\View;
use PDO;
use Exception;

class HorariosController
{
    private Database $db;
    private PDO $pdo;

    // Config por defecto para la generación automática
    private const DIAS_SEMANA     = [1, 2, 3, 4, 5]; // 1=Lunes ... 5=Viernes
    private const HORA_INICIO_DIA = '07:00';
    private const HORA_FIN_DIA    = '14:00';
    private const SLOT_MINUTOS    = 60; // 60 min por bloque

    public function __construct()
    {
        $this->db  = new Database();
        $this->pdo = $this->db->getPdo();
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /* =========================================================
     * INDEX: listado de grupos + estado
     * GET /src/plataforma/app/admin/horarios
     * ======================================================= */
    public function index(): void
    {
        $sql = "
            SELECT 
                g.id,
                g.codigo,
                g.titulo,
                COUNT(h.id) AS total_clases,
                MAX(h.created_at) AS ultima_actualizacion,
                CASE 
                    WHEN COUNT(h.id) > 0 THEN 'publicado'
                    ELSE 'sin'
                END AS estado_horario
            FROM grupos g
            LEFT JOIN horarios h ON h.group_id = g.id
            GROUP BY g.id, g.codigo, g.titulo
            ORDER BY g.codigo ASC
        ";
        $stmt   = $this->db->query($sql);
        $grupos = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Si hay horario en BORRADOR en sesión, marcamos como 'borrador'
        foreach ($grupos as $g) {
            $key = 'horario_borrador_' . (int)$g->id;
            if (!empty($_SESSION[$key])) {
                $g->estado_horario = 'borrador';
            }
        }

        View::render('admin/horarios/index', 'admin', [
            'grupos' => $grupos,
        ]);
    }

    /* =========================================================
     * (Opcional) Seleccionar grupo
     * ======================================================= */
    public function seleccionarGrupo(): void
    {
        $sql = "SELECT g.id, g.codigo, g.titulo
                FROM grupos g
                ORDER BY g.codigo ASC";
        $stmt   = $this->db->query($sql);
        $grupos = $stmt->fetchAll(PDO::FETCH_OBJ);

        View::render('admin/horarios/seleccionar_grupo', 'admin', [
            'grupos' => $grupos,
        ]);
    }

    /* =========================================================
     * 2) Configurar horas por semana para las materias del grupo
     * GET /src/plataforma/app/admin/horarios/configurar-horas/{id}
     * ======================================================= */
    public function configurarHoras(int $id): void
    {
        $groupId = $id;

        // Info del grupo
        $sqlGrupo = "SELECT id, codigo, titulo FROM grupos WHERE id = :id";
        $stmtGrupo = $this->db->query($sqlGrupo, ['id' => $groupId]);
        $grupo = $stmtGrupo->fetch(PDO::FETCH_OBJ);
        if (!$grupo) {
            throw new Exception("Grupo no encontrado");
        }

        // Materias del grupo + horas_semana (puede ser NULL)
        $sql = "
            SELECT 
                mg.id              AS mg_id,
                mg.materia_id,
                mg.grupo_id,
                mg.horas_semana,
                m.nombre           AS materia_nombre,
                m.clave            AS materia_clave
            FROM materias_grupos mg
            JOIN materias m ON m.id = mg.materia_id
            WHERE mg.grupo_id = :grupo_id
            ORDER BY m.nombre ASC
        ";
        $stmt = $this->db->query($sql, ['grupo_id' => $groupId]);
        $materiasGrupo = $stmt->fetchAll(PDO::FETCH_OBJ);

        View::render('admin/horarios/configurar_horas', 'admin', [
            'grupo'          => $grupo,
            'materiasGrupo'  => $materiasGrupo,
        ]);
    }

    /* =========================================================
     * 2b) Guardar horas por semana
     * POST /src/plataforma/app/admin/horarios/guardar-horas/{id}
     * ======================================================= */
    public function guardarHoras(int $id): void
    {
        $groupId = $id;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /src/plataforma/app/admin/horarios/configurar-horas/' . $groupId);
            exit;
        }

        $horas = $_POST['horas'] ?? []; // [mg_id => horas_semana]

        $this->pdo->beginTransaction();
        try {
            $sqlUpdate = "
                UPDATE materias_grupos
                SET horas_semana = :horas
                WHERE id = :mg_id AND grupo_id = :grupo_id
            ";
            $stmt = $this->pdo->prepare($sqlUpdate);

            foreach ($horas as $mgId => $valor) {
                $mgId  = (int)$mgId;
                $valor = trim((string)$valor);

                if ($mgId <= 0) {
                    continue;
                }

                if ($valor === '') {
                    $horasSemana = null;
                } else {
                    $horasSemana = (int)$valor;
                    if ($horasSemana < 0) {
                        $horasSemana = 0;
                    }
                    if ($horasSemana > 40) {
                        $horasSemana = 40;
                    }
                }

                $stmt->execute([
                    'horas'    => $horasSemana,
                    'mg_id'    => $mgId,
                    'grupo_id' => $groupId,
                ]);
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }

        header('Location: /src/plataforma/app/admin/horarios/generar/' . $groupId);
        exit;
    }

    /* =========================================================
     * 3) Generar horario automático (borrador en sesión)
     * GET /src/plataforma/app/admin/horarios/generar/{id}
     * ======================================================= */
    public function generar(int $id): void
    {
        $groupId = $id;

        // Cargar materias+docentes+horas_semana para este grupo
        $materias = $this->obtenerMateriasDocentesGrupo($groupId);

        if (empty($materias)) {
            $_SESSION['horarios_errores_' . $groupId] = [
                'Este grupo no tiene materias asignadas. Asigna materias primero.'
            ];
            header('Location: /src/plataforma/app/admin/horarios/configurar-horas/' . $groupId);
            exit;
        }

        // Generar matriz de slots
        $slots = $this->generarBorradorHorario($groupId, $materias);

        // Guardar en sesión como borrador
        $_SESSION['horario_borrador_' . $groupId] = $slots;

        header('Location: /src/plataforma/app/admin/horarios/vista-previa/' . $groupId);
        exit;
    }

    /* =========================================================
     * 4) Vista previa del horario
     * GET /src/plataforma/app/admin/horarios/vista-previa/{id}
     * ======================================================= */
    public function vistaPrevia(int $id): void
    {
        $groupId = $id;

        // Info del grupo
        $sqlGrupo = "SELECT id, codigo, titulo FROM grupos WHERE id = :id";
        $stmtGrupo = $this->db->query($sqlGrupo, ['id' => $groupId]);
        $grupo = $stmtGrupo->fetch(PDO::FETCH_OBJ);
        if (!$grupo) {
            throw new Exception("Grupo no encontrado");
        }

        // Borrador de horario desde sesión
        $slots = $_SESSION['horario_borrador_' . $groupId] ?? [];

        // Índice de materias del grupo
        $materiasIndex = [];
        $sqlMaterias = "
            SELECT mg.materia_id, m.nombre
            FROM materias_grupos mg
            JOIN materias m ON m.id = mg.materia_id
            WHERE mg.grupo_id = :grupo_id
        ";
        $stmtMat = $this->db->query($sqlMaterias, ['grupo_id' => $groupId]);
        foreach ($stmtMat->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $mid = (int)$row['materia_id'];
            $materiasIndex[$mid] = [
                'id'     => $mid,
                'nombre' => $row['nombre'],
            ];
        }

        // Docentes asignados en materia_grupo_profesor
        $teachersIndex    = [];
        $materiaToTeacher = [];

        $sqlAsign = "
            SELECT 
                mg.materia_id,
                mgp.teacher_user_id,
                tp.user_id,
                CONCAT_WS(' ', u.nombre, u.apellido_paterno, u.apellido_materno) AS docente_nombre
            FROM materias_grupos mg
            LEFT JOIN materia_grupo_profesor mgp ON mgp.mg_id = mg.id
            LEFT JOIN teacher_profiles tp       ON tp.user_id = mgp.teacher_user_id
            LEFT JOIN users u                   ON u.id = tp.user_id
            WHERE mg.grupo_id = :grupo_id
        ";
        $stmtAsign = $this->db->query($sqlAsign, ['grupo_id' => $groupId]);
        foreach ($stmtAsign->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $mid = (int)$row['materia_id'];
            $tid = $row['teacher_user_id'] !== null ? (int)$row['teacher_user_id'] : null;

            if ($tid) {
                $materiaToTeacher[$mid] = $tid;

                if (!isset($teachersIndex[$tid])) {
                    $nombreDoc = trim($row['docente_nombre'] ?? '');
                    if ($nombreDoc === '') {
                        $nombreDoc = 'Docente #' . $tid;
                    }
                    $teachersIndex[$tid] = [
                        'id'     => $tid,
                        'nombre' => $nombreDoc,
                    ];
                }
            }
        }

        // Inyectar docente por defecto en cada slot
        foreach ($slots as &$slot) {
            $mid = isset($slot['materia_id']) ? (int)$slot['materia_id'] : 0;

            if ($mid > 0 && (empty($slot['teacher_id']) || (int)$slot['teacher_id'] === 0)) {
                if (isset($materiaToTeacher[$mid])) {
                    $slot['teacher_id'] = (int)$materiaToTeacher[$mid];
                }
            }
        }
        unset($slot);

        View::render('admin/horarios/vista_previa', 'admin', [
            'grupo'            => $grupo,
            'slots'            => $slots,
            'materiasIndex'    => $materiasIndex,
            'teachersIndex'    => $teachersIndex,
            'materiaToTeacher' => $materiaToTeacher,
        ]);
    }

    /* =========================================================
     * 5) Guardar horario definitivo
     * POST /src/plataforma/app/admin/horarios/guardar/{id}
     * ======================================================= */
    public function guardarHorario(int $groupId): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /src/plataforma/app/admin/horarios/vista-previa/' . $groupId);
            exit;
        }

        $slotsJson = $_POST['slots_json'] ?? null;
        $slots     = [];

        if ($slotsJson !== null && $slotsJson !== '') {
            $tmp = json_decode($slotsJson, true);
            if (is_array($tmp)) {
                $slots = $tmp;
            }
        }

        if (empty($slots)) {
            $slots = $_SESSION['horario_borrador_' . $groupId] ?? [];
        }

        if (empty($slots)) {
            header('Location: /src/plataforma/app/admin/horarios/vista-previa/' . $groupId);
            exit;
        }

        $this->pdo->beginTransaction();
        try {
            $sqlDelete = "DELETE FROM horarios WHERE group_id = :grupo_id";
            $this->db->query($sqlDelete, ['grupo_id' => $groupId]);

            $sqlInsert = "
                INSERT INTO horarios
                    (group_id, dia_semana, hora_inicio, hora_fin, materia_id, teacher_id, aula, created_at)
                VALUES
                    (:group_id, :dia_semana, :hora_inicio, :hora_fin, :materia_id, :teacher_id, :aula, NOW())
            ";
            $stmtInsert = $this->pdo->prepare($sqlInsert);

            foreach ($slots as $slot) {
                $diaSemana  = (int)($slot['dia_semana'] ?? 0);
                $horaInicio = $slot['hora_inicio'] ?? null;
                $horaFin    = $slot['hora_fin'] ?? null;
                $materiaId  = isset($slot['materia_id']) ? (int)$slot['materia_id'] : null;
                $teacherId  = isset($slot['teacher_id']) ? (int)$slot['teacher_id'] : null;
                $aula       = $slot['aula'] ?? null;

                if ($diaSemana <= 0 || !$horaInicio || !$horaFin || !$materiaId) {
                    continue;
                }

                $stmtInsert->execute([
                    'group_id'   => $groupId,
                    'dia_semana' => $diaSemana,
                    'hora_inicio'=> $horaInicio,
                    'hora_fin'   => $horaFin,
                    'materia_id' => $materiaId,
                    'teacher_id' => $teacherId ?: null,
                    'aula'       => $aula,
                ]);
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }

        unset($_SESSION['horario_borrador_' . $groupId]);

        header('Location: /src/plataforma/app/admin/grupos/horario/' . $groupId);
        exit;
    }

    /* =========================================================
     * Métodos privados de apoyo
     * ======================================================= */

    private function obtenerMateriasDocentesGrupo(int $groupId): array
    {
        $sql = "
            SELECT
                mg.id                  AS mg_id,
                mg.materia_id,
                mg.grupo_id,
                mg.horas_semana,
                m.nombre               AS materia_nombre,
                m.clave                AS materia_clave,
                mgp.teacher_user_id    AS teacher_user_id
            FROM materias_grupos mg
            JOIN materias m ON m.id = mg.materia_id
            LEFT JOIN materia_grupo_profesor mgp 
                   ON mgp.mg_id = mg.id
            WHERE mg.grupo_id = :grupo_id
            ORDER BY m.nombre ASC
        ";
        $stmt = $this->db->query($sql, ['grupo_id' => $groupId]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Genera borrador del horario para un grupo
     * (solo evita choques dentro del mismo borrador).
     */
    private function generarBorradorHorario(int $groupId, array $materias): array
    {
        $slotsHoras = $this->buildSlotsHoras(
            self::HORA_INICIO_DIA,
            self::HORA_FIN_DIA,
            self::SLOT_MINUTOS
        );

        usort($materias, function ($a, $b) {
            return ((int)$b->horas_semana) <=> ((int)$a->horas_semana);
        });

        $resultado = [];

        foreach ($materias as $m) {
            $horasRequeridas = (int)$m->horas_semana;
            $materiaId       = (int)$m->materia_id;
            $teacherId       = $m->teacher_user_id !== null ? (int)$m->teacher_user_id : null;

            if ($horasRequeridas <= 0) {
                continue;
            }

            $horasAsignadas = 0;

            foreach (self::DIAS_SEMANA as $dia) {
                foreach ($slotsHoras as $slot) {
                    if ($horasAsignadas >= $horasRequeridas) {
                        break 2;
                    }

                    $horaInicio = $slot['inicio'];
                    $horaFin    = $slot['fin'];

                    if ($this->yaOcupadoEnResultado($resultado, $dia, $horaInicio)) {
                        continue;
                    }

                    $resultado[] = [
                        'group_id'   => $groupId,
                        'dia_semana' => $dia,
                        'hora_inicio'=> $horaInicio,
                        'hora_fin'   => $horaFin,
                        'materia_id' => $materiaId,
                        'teacher_id' => $teacherId,
                        'aula'       => null,
                    ];

                    $horasAsignadas++;
                }
            }
        }

        return $resultado;
    }

    private function buildSlotsHoras(string $horaInicio, string $horaFin, int $minutosPorSlot): array
    {
        $inicio = strtotime($horaInicio);
        $fin    = strtotime($horaFin);

        $slots = [];
        while ($inicio < $fin) {
            $slotFin = $inicio + $minutosPorSlot * 60;
            if ($slotFin > $fin) {
                break;
            }

            $slots[] = [
                'inicio' => date('H:i:s', $inicio),
                'fin'    => date('H:i:s', $slotFin),
            ];

            $inicio = $slotFin;
        }

        return $slots;
    }

    private function yaOcupadoEnResultado(array $slots, int $diaSemana, string $horaInicio): bool
    {
        foreach ($slots as $s) {
            if ((int)$s['dia_semana'] === $diaSemana && $s['hora_inicio'] === $horaInicio) {
                return true;
            }
        }
        return false;
    }

    private function docenteOcupado(int $teacherId, int $diaSemana, string $horaInicio): bool
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM horarios
            WHERE teacher_id = :teacher_id
              AND dia_semana = :dia_semana
              AND hora_inicio = :hora_inicio
        ";
        $stmt = $this->db->query($sql, [
            'teacher_id'  => $teacherId,
            'dia_semana'  => $diaSemana,
            'hora_inicio' => $horaInicio,
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return ((int)($row['total'] ?? 0) > 0);
    }

    /* =========================================================
     * Ver horario definitivo del grupo (solo lectura) - ADMIN
     * GET /src/plataforma/app/admin/grupos/horario/{id}
     * ======================================================= */
    public function verHorarioGrupo(int $id): void
    {
        $groupId = $id;

        $sqlGrupo = "
            SELECT g.id, g.codigo, g.titulo
            FROM grupos g
            WHERE g.id = :id
        ";
        $stmtGrupo = $this->db->query($sqlGrupo, ['id' => $groupId]);
        $grupo = $stmtGrupo->fetch(PDO::FETCH_OBJ);

        if (!$grupo) {
            throw new Exception("Grupo no encontrado");
        }

        $sql = "
        SELECT 
            h.dia_semana,
            h.hora_inicio,
            h.hora_fin,
            h.aula,
            h.materia_id,
            h.teacher_id,
            m.nombre AS materia_nombre,
            m.clave  AS materia_clave,
            CONCAT_WS(' ', u.nombre, u.apellido_paterno, u.apellido_materno) AS docente_nombre
        FROM horarios h
        JOIN materias m          ON m.id = h.materia_id
        LEFT JOIN teacher_profiles tp ON tp.user_id = h.teacher_id
        LEFT JOIN users u             ON u.id = tp.user_id
        WHERE h.group_id = :grupo_id
        ORDER BY h.hora_inicio, h.dia_semana
        ";
        $stmt = $this->db->query($sql, ['grupo_id' => $groupId]);
        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

        $schedule = [];

        foreach ($rows as $r) {
            $hi = substr($r->hora_inicio, 0, 5);
            $hf = substr($r->hora_fin,   0, 5);
            $labelHora  = $hi . ' - ' . $hf;
            $dia        = (int)$r->dia_semana;

            $color = $this->colorPorMateriaId((int)$r->materia_id);

            if (!isset($schedule[$labelHora])) {
                $schedule[$labelHora] = [];
            }

            $nombreDoc = trim($r->docente_nombre ?? '');
            if ($nombreDoc === '') {
                $nombreDoc = $r->teacher_id ? ('Docente #' . $r->teacher_id) : '';
            }

            $schedule[$labelHora][$dia] = [
                'materia' => $r->materia_nombre ?? ('Materia #' . $r->materia_id),
                'aula'    => $r->aula ?? '',
                'docente' => $nombreDoc,
                'color'   => $color,
            ];
        }

        View::render('admin/groups/horario', 'admin', [
            'grupo'    => $grupo,
            'schedule' => $schedule,
        ]);
    }

    /**
     * Asigna un color de tarjeta en base al ID de materia.
     */
    private function colorPorMateriaId(int $materiaId): string
    {
        $colores = ['blue', 'purple', 'green', 'amber', 'red', 'indigo', 'teal'];
        if ($materiaId <= 0) {
            return 'blue';
        }
        $index = $materiaId % count($colores);
        return $colores[$index];
    }

    /* =========================================================
     * HORARIO PARA DOCENTE (panel maestro)
     * GET /src/plataforma/app/teacher/horario
     * ======================================================= */
    public function horarioDocente(): void
    {
        $teacherUserId = $_SESSION['user']['id'] ?? null;

        if (!$teacherUserId) {
            throw new Exception('No hay docente autenticado.');
        }

        $user = [
            'id'    => $teacherUserId,
            'name'  => $_SESSION['user']['name']  ?? '',
            'email' => $_SESSION['user']['email'] ?? '',
        ];

        $sql = "
            SELECT 
                h.dia_semana,
                h.hora_inicio,
                h.hora_fin,
                h.aula,
                h.materia_id,
                h.group_id,
                m.nombre AS materia_nombre,
                m.clave  AS materia_clave,
                g.codigo AS grupo_codigo,
                g.titulo AS grupo_titulo
            FROM horarios h
            JOIN materias m ON m.id = h.materia_id
            JOIN grupos   g ON g.id = h.group_id
            WHERE h.teacher_id = :teacher_id
            ORDER BY h.hora_inicio, h.dia_semana
        ";
        $stmt = $this->db->query($sql, ['teacher_id' => $teacherUserId]);
        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

        // formato: $schedule[horaLabel][dia]
        $schedule = [];

        foreach ($rows as $r) {
            $hi = substr($r->hora_inicio, 0, 5);
            $hf = substr($r->hora_fin,   0, 5);
            $labelHora = $hi . ' - ' . $hf;
            $dia       = (int)$r->dia_semana;

            $color = $this->colorPorMateriaId((int)$r->materia_id);

            if (!isset($schedule[$labelHora])) {
                $schedule[$labelHora] = [];
            }

            $schedule[$labelHora][$dia] = [
                'materia' => $r->materia_nombre ?? ('Materia #' . $r->materia_id),
                'grupo'   => $r->grupo_codigo ?? '',
                'aula'    => $r->aula ?? '',
                'color'   => $color,
            ];
        }

        View::render('teacher/horario/horario', 'teacher', [
            'user'     => $user,
            'schedule' => $schedule,
        ]);
    }

    /* =========================================================
     * HORARIO PARA ALUMNO (panel alumno)
     * GET /src/plataforma/app/student/horario
     * ======================================================= */
public function horarioAlumno(): void
{
    // 1) ID de usuario alumno logueado
    $studentUserId = $_SESSION['user']['id'] ?? null;
    if (!$studentUserId) {
        throw new \Exception('No hay alumno autenticado.');
    }

    // 2) Buscar su perfil y el grupo al que pertenece
    $sqlPerfil = "
        SELECT 
            sp.grupo_id AS grupo_id,
            g.codigo,
            g.titulo
        FROM student_profiles sp
        JOIN grupos g ON g.id = sp.grupo_id
        WHERE sp.user_id = :uid
        LIMIT 1
    ";
    $stmtPerfil = $this->db->query($sqlPerfil, ['uid' => $studentUserId]);
    $grupo = $stmtPerfil->fetch(PDO::FETCH_OBJ);

    if (!$grupo) {
        // El alumno no tiene grupo asignado
        View::render('student/schedule/index', 'student', [
            'grupo'    => null,
            'schedule' => [],
        ]);
        return;
    }

    $groupId = (int)$grupo->grupo_id;

    // 3) Traer bloques de horario del grupo
    $sql = "
        SELECT 
            h.dia_semana,
            h.hora_inicio,
            h.hora_fin,
            h.aula,
            h.materia_id,
            h.teacher_id,
            m.nombre AS materia_nombre,
            m.clave  AS materia_clave,
            CONCAT_WS(' ', u.nombre, u.apellido_paterno, u.apellido_materno) AS docente_nombre
        FROM horarios h
        JOIN materias m          ON m.id = h.materia_id
        LEFT JOIN teacher_profiles tp ON tp.user_id = h.teacher_id
        LEFT JOIN users u             ON u.id = tp.user_id
        WHERE h.group_id = :grupo_id
        ORDER BY h.hora_inicio, h.dia_semana
    ";

    $stmt = $this->db->query($sql, ['grupo_id' => $groupId]);
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    // 4) Construir $schedule
    $schedule = [];

    foreach ($rows as $r) {
        $hi = substr($r->hora_inicio, 0, 5);
        $hf = substr($r->hora_fin,   0, 5);
        $labelHora  = $hi . ' - ' . $hf;
        $dia        = (int)$r->dia_semana;

        $color = $this->colorPorMateriaId((int)$r->materia_id);

        if (!isset($schedule[$labelHora])) {
            $schedule[$labelHora] = [];
        }

        $nombreDoc = trim($r->docente_nombre ?? '');
        if ($nombreDoc === '') {
            $nombreDoc = $r->teacher_id ? ('Docente #' . $r->teacher_id) : '';
        }

        $schedule[$labelHora][$dia] = [
            'materia' => $r->materia_nombre ?? ('Materia #' . $r->materia_id),
            'aula'    => $r->aula ?? '',
            'docente' => $nombreDoc,
            'color'   => $color,
        ];
    }

    // 5) Render de la vista de alumno
    View::render('student/schedule/index', 'student', [
        'grupo'    => $grupo,
        'schedule' => $schedule,
    ]);
}

}
