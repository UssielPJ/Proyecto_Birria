<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;
use PDO;

class CapturistaAlumnosController {
    /** ----------- LISTAR ALUMNOS (student_profiles) ----------- */
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        $db = new Database();
        $conn = $db->getPdo();

        // Filtros
        $buscar  = $_GET['q'] ?? '';
        $carrera = $_GET['carrera'] ?? '';
        $tipo    = $_GET['tipo_ingreso'] ?? '';
        $page    = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit   = 10;
        $offset  = ($page - 1) * $limit;

        // Construir WHERE
        $where = [];
        $params = [];

        if ($buscar) {
            $where[] = "(sp.matricula LIKE :buscar OR sp.curp LIKE :buscar)";
            $params[':buscar'] = "%$buscar%";
        }
        if ($carrera) {
            $where[] = "sp.carrera_id = :carrera";
            $params[':carrera'] = $carrera;
        }
        if ($tipo) {
            $where[] = "sp.tipo_ingreso = :tipo";
            $params[':tipo'] = $tipo;
        }

        $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        // Total de registros
        $queryTotal = "SELECT COUNT(*) AS total FROM student_profiles sp $whereClause";
        $stmt = $conn->prepare($queryTotal);
        $stmt->execute($params);
        $total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = $total > 0 ? ceil($total / $limit) : 1;

        // Datos paginados
        $query = "
            SELECT 
                sp.user_id,
                sp.matricula,
                sp.curp,
                sp.carrera_id,
                sp.semestre,
                sp.grupo,
                sp.tipo_ingreso,
                sp.beca_activa,
                sp.promedio_general,
                sp.creditos_aprobados,
                sp.direccion,
                sp.contacto_emergencia_nombre,
                sp.contacto_emergencia_telefono,
                sp.parentesco_emergencia,
                sp.created_at,
                sp.updated_at,
                u.nombre AS nombre_usuario,
                u.email AS email_usuario
            FROM student_profiles sp
            LEFT JOIN users u ON u.id = sp.user_id
            $whereClause
            ORDER BY sp.matricula ASC
            LIMIT :offset, :limit
        ";
        $stmt = $conn->prepare($query);
        foreach ($params as $key => $val) $stmt->bindValue($key, $val);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $alumnos = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Carreras distintas
        $carreras = [];
        try {
            $carreras = $conn->query("SELECT DISTINCT carrera_id FROM student_profiles WHERE carrera_id IS NOT NULL ORDER BY carrera_id")->fetchAll(PDO::FETCH_COLUMN);
        } catch (\Throwable $e) {}

        $data = [
            'buscar'      => $buscar,
            'carrera'     => $carrera,
            'tipo_ingreso'=> $tipo,
            'page'        => $page,
            'totalPages'  => $totalPages,
            'total'       => $total,
            'offset'      => $offset,
            'limit'       => $limit,
            'alumnos'     => $alumnos,
            'carreras'    => $carreras
        ];

        View::render('capturista/alumnos/index', 'capturista', $data);
    }

    /** ----------- NUEVO / FORMULARIO ----------- */
    public function crear() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        View::render('capturista/alumnos/nueva', 'capturista');
    }

    /** ----------- EDITAR ----------- */
    public function editar($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        $db = new Database();
        $conn = $db->getPdo();
        $stmt = $conn->prepare("SELECT * FROM student_profiles WHERE user_id = ?");
        $stmt->execute([$id]);
        $alumno = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$alumno) {
            header('Location: /src/plataforma/app/capturista/alumnos');
            exit;
        }

        View::render('capturista/alumnos/nueva', 'capturista', ['alumno' => $alumno]);
    }

    /** ----------- GUARDAR / ACTUALIZAR ----------- */
    public function guardar() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        $db = new Database();
        $conn = $db->getPdo();

        $data = $_POST;
        $isEdit = !empty($data['user_id']);

        $sql = $isEdit
            ? "UPDATE student_profiles
               SET matricula=:matricula, curp=:curp, carrera_id=:carrera_id, semestre=:semestre,
                   grupo=:grupo, tipo_ingreso=:tipo_ingreso, beca_activa=:beca_activa,
                   promedio_general=:promedio_general, creditos_aprobados=:creditos_aprobados,
                   direccion=:direccion, contacto_emergencia_nombre=:contacto_emergencia_nombre,
                   contacto_emergencia_telefono=:contacto_emergencia_telefono,
                   parentesco_emergencia=:parentesco_emergencia,
                   updated_at=NOW()
               WHERE user_id=:user_id"
            : "INSERT INTO student_profiles
               (user_id, matricula, curp, carrera_id, semestre, grupo, tipo_ingreso, beca_activa,
                promedio_general, creditos_aprobados, direccion, contacto_emergencia_nombre,
                contacto_emergencia_telefono, parentesco_emergencia, created_at)
               VALUES
               (:user_id, :matricula, :curp, :carrera_id, :semestre, :grupo, :tipo_ingreso,
                :beca_activa, :promedio_general, :creditos_aprobados, :direccion,
                :contacto_emergencia_nombre, :contacto_emergencia_telefono, :parentesco_emergencia, NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':user_id'                    => $data['user_id'] ?? null,
            ':matricula'                  => $data['matricula'] ?? '',
            ':curp'                       => $data['curp'] ?? '',
            ':carrera_id'                 => $data['carrera_id'] ?? null,
            ':semestre'                   => $data['semestre'] ?? 1,
            ':grupo'                      => $data['grupo'] ?? '',
            ':tipo_ingreso'               => $data['tipo_ingreso'] ?? 'nuevo',
            ':beca_activa'                => isset($data['beca_activa']) ? 1 : 0,
            ':promedio_general'           => $data['promedio_general'] ?? 0,
            ':creditos_aprobados'         => $data['creditos_aprobados'] ?? 0,
            ':direccion'                  => $data['direccion'] ?? '',
            ':contacto_emergencia_nombre' => $data['contacto_emergencia_nombre'] ?? '',
            ':contacto_emergencia_telefono'=> $data['contacto_emergencia_telefono'] ?? '',
            ':parentesco_emergencia'      => $data['parentesco_emergencia'] ?? ''
        ]);

        header('Location: /src/plataforma/app/capturista/alumnos');
        exit;
    }

    /** ----------- ELIMINAR ----------- */
    public function eliminar($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        $db = new Database();
        $conn = $db->getPdo();
        $stmt = $conn->prepare("DELETE FROM student_profiles WHERE user_id = ?");
        $stmt->execute([$id]);

        header('Location: /src/plataforma/app/capturista/alumnos');
        exit;
    }
}
