<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;
use App\Models\User;
use PDO;
class CapturistaAlumnosController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        $db = new Database();
        $conn = $db->getPdo();

        // Parámetros de búsqueda y filtrado
        $buscar = $_GET['q'] ?? '';
        $carrera = $_GET['carrera'] ?? '';
        $estado = $_GET['estado'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Construir la consulta
        $where = [];
        $params = [];

        if ($buscar) {
            $where[] = "(a.nombre LIKE :buscar OR a.email LIKE :buscar)";
            $params[':buscar'] = "%$buscar%";
        }

        if ($carrera) {
            $where[] = "a.carrera = :carrera";
            $params[':carrera'] = $carrera;
        }

        if ($estado) {
            $where[] = "s.estado = :estado";
            $params[':estado'] = $estado;
        }

        $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

        // Consulta para obtener el total
        $queryTotal = "
            SELECT COUNT(DISTINCT a.id) as total
            FROM alumnos a
            LEFT JOIN solicitudes s ON a.id = s.alumno_id
            $whereClause
        ";
        $stmt = $conn->prepare($queryTotal);
        $stmt->execute($params);
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($total / $limit);

        // Consulta para obtener los alumnos
        $query = "
            SELECT a.*,
                   MAX(s.estado) as estado_solicitud,
                   MAX(s.fecha_creacion) as fecha_solicitud,
                   (SELECT COUNT(*) FROM solicitudes WHERE alumno_id = a.id) as total_solicitudes
            FROM alumnos a
            LEFT JOIN solicitudes s ON a.id = s.alumno_id
            $whereClause
            GROUP BY a.id
            ORDER BY a.nombre ASC
            LIMIT $offset, $limit
        ";

        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Obtener lista de carreras para el filtro
        $carreras = $conn->query("SELECT DISTINCT carrera FROM alumnos WHERE carrera IS NOT NULL")->fetchAll(PDO::FETCH_COLUMN);

        $data = [
            'buscar' => $buscar,
            'carrera' => $carrera,
            'estado' => $estado,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'offset' => $offset,
            'limit' => $limit,
            'alumnos' => $alumnos,
            'carreras' => $carreras
        ];

        // Cargar vista
        View::render('capturista/alumnos', 'capturista', $data);
    }

    public function crear() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        View::render('capturista/alumnos', 'capturista');
    }

    public function editar($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        View::render('capturista/alumnos', 'capturista');
    }

    public function guardar() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Procesar datos del formulario
        // Redireccionar a la lista de alumnos
        header('Location: /src/plataforma/capturista/alumnos');
    }

    public function eliminar($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar modelos necesarios
        require_once __DIR__ . '/../models/User.php';
        $userModel = new User();

        // Eliminar alumno
        $userModel->delete($id);

        // Redireccionar a la lista de alumnos
        header('Location: /src/plataforma/capturista/alumnos');
    }
}
