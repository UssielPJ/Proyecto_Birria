<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\User;
use Exception;
use PDO;
class SolicitudesController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        \App\Core\View::render('capturista/solicitudes/index', 'capturista');
    }

    public function nueva() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Cargar vista
        \App\Core\View::render('capturista/solicitudes/nueva', 'capturista');
    }

    public function guardar() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Procesar datos del formulario
        try {
            db()->beginTransaction();

            if (isset($_POST['solicitud_id'])) {
                // Actualizar solicitud existente
                $stmtSolicitud = db()->prepare("
                    UPDATE solicitudes SET
                    periodo = :periodo,
                    documentos_completos = :documentos_completos,
                    observaciones = :observaciones
                    WHERE id = :id
                ");

                $stmtSolicitud->execute([
                    ':id' => $_POST['solicitud_id'],
                    ':periodo' => $_POST['periodo'],
                    ':documentos_completos' => isset($_POST['documentos_completos']) ? 1 : 0,
                    ':observaciones' => $_POST['observaciones']
                ]);

                // Actualizar alumno
                $stmtAlumno = db()->prepare("
                    UPDATE alumnos SET
                    nombre = :nombre,
                    email = :email,
                    telefono = :telefono,
                    carrera = :carrera
                    WHERE id = (SELECT alumno_id FROM solicitudes WHERE id = :solicitud_id)
                ");

                $stmtAlumno->execute([
                    ':solicitud_id' => $_POST['solicitud_id'],
                    ':nombre' => $_POST['nombre'],
                    ':email' => $_POST['email'],
                    ':telefono' => $_POST['telefono'],
                    ':carrera' => $_POST['carrera']
                ]);
            } else {
                // Insertar nueva
                // Insertar primero en la tabla alumnos
                $stmtAlumno = db()->prepare("
                    INSERT INTO alumnos (nombre, email, telefono, carrera)
                    VALUES (:nombre, :email, :telefono, :carrera)
                ");

                $stmtAlumno->execute([
                    ':nombre' => $_POST['nombre'],
                    ':email' => $_POST['email'],
                    ':telefono' => $_POST['telefono'],
                    ':carrera' => $_POST['carrera']
                ]);

                $alumnoId = db()->lastInsertId();

                // Luego insertar la solicitud
                $stmtSolicitud = db()->prepare("
                    INSERT INTO solicitudes (alumno_id, periodo, estado, documentos_completos, observaciones)
                    VALUES (:alumno_id, :periodo, :estado, :documentos_completos, :observaciones)
                ");

                $stmtSolicitud->execute([
                    ':alumno_id' => $alumnoId,
                    ':periodo' => $_POST['periodo'],
                    ':estado' => 'pendiente',
                    ':documentos_completos' => isset($_POST['documentos_completos']) ? 1 : 0,
                    ':observaciones' => $_POST['observaciones']
                ]);
            }

            db()->commit();
            header('Location: /src/plataforma/solicitudes?mensaje=success');
            exit;
        } catch (Exception $e) {
            db()->rollBack();
            // Handle error
            header('Location: /src/plataforma/solicitudes/nueva?error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    public function editar($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Obtener datos de la solicitud
        $stmt = db()->prepare("
            SELECT s.*, a.nombre, a.email, a.telefono, a.carrera
            FROM solicitudes s
            LEFT JOIN alumnos a ON s.alumno_id = a.id
            WHERE s.id = ?
        ");
        $stmt->execute([$id]);
        $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$solicitud) {
            header('Location: /src/plataforma/solicitudes');
            exit;
        }

        // Cargar vista
        \App\Core\View::render('capturista/solicitudes/nueva', 'capturista', ['solicitud' => $solicitud]);
    }

    public function eliminar($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        // Eliminar solicitud
        $stmt = db()->prepare("DELETE FROM solicitudes WHERE id = ?");
        $stmt->execute([$id]);

        // Redireccionar a la lista de solicitudes
        header('Location: /src/plataforma/solicitudes');
    }
}
