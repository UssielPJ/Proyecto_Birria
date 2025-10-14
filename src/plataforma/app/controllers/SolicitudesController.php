<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;
use Exception;
use PDO;

class SolicitudesController {

    /** --------- Ver lista de aspirantes (solicitudes) --------- */
    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        $db = new Database();
        $db->query("SELECT * FROM aspirantes ORDER BY fecha_registro DESC");
        $aspirantes = $db->fetchAll();

        View::render('capturista/solicitudes/index', 'capturista', [
            'aspirantes' => $aspirantes
        ]);
    }

    /** --------- Formulario nueva solicitud --------- */
    public function nueva() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        View::render('capturista/solicitudes/nueva', 'capturista');
    }

    /** --------- Guardar (crear o actualizar) --------- */
    public function guardar() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        $db = new Database();

        try {
            $db->beginTransaction();

            // Si viene un ID => actualizar
            if (!empty($_POST['id'])) {
                $sql = "
                    UPDATE aspirantes SET
                        folio = :folio,
                        email = :email,
                        nombre = :nombre,
                        apellido_paterno = :apellido_paterno,
                        apellido_materno = :apellido_materno,
                        telefono = :telefono,
                        curp = :curp,
                        fecha_nacimiento = :fecha_nacimiento,
                        direccion = :direccion,
                        carrera_solicitada_id = :carrera_solicitada_id,
                        periodo_solicitado_id = :periodo_solicitado_id,
                        preparatoria_procedencia = :preparatoria_procedencia,
                        promedio_preparatoria = :promedio_preparatoria,
                        documentos_entregados = :documentos_entregados,
                        status = :status,
                        capturado_por = :capturado_por,
                        updated_at = NOW()
                    WHERE id = :id
                ";
                $db->query($sql, [
                    ':id'                      => $_POST['id'],
                    ':folio'                   => $_POST['folio'] ?? '',
                    ':email'                   => $_POST['email'] ?? '',
                    ':nombre'                  => $_POST['nombre'] ?? '',
                    ':apellido_paterno'        => $_POST['apellido_paterno'] ?? '',
                    ':apellido_materno'        => $_POST['apellido_materno'] ?? '',
                    ':telefono'                => $_POST['telefono'] ?? '',
                    ':curp'                    => $_POST['curp'] ?? '',
                    ':fecha_nacimiento'        => $_POST['fecha_nacimiento'] ?? null,
                    ':direccion'               => $_POST['direccion'] ?? '',
                    ':carrera_solicitada_id'   => $_POST['carrera_solicitada_id'] ?? null,
                    ':periodo_solicitado_id'   => $_POST['periodo_solicitado_id'] ?? null,
                    ':preparatoria_procedencia'=> $_POST['preparatoria_procedencia'] ?? '',
                    ':promedio_preparatoria'   => $_POST['promedio_preparatoria'] ?? 0,
                    ':documentos_entregados'   => $_POST['documentos_entregados'] ?? '',
                    ':status'                  => $_POST['status'] ?? 'registrado',
                    ':capturado_por'           => $_SESSION['user']['id'] ?? null,
                ]);
            } else {
                // Nuevo registro
                $sql = "
                    INSERT INTO aspirantes (
                        folio, email, nombre, apellido_paterno, apellido_materno,
                        telefono, curp, fecha_nacimiento, direccion,
                        carrera_solicitada_id, periodo_solicitado_id,
                        preparatoria_procedencia, promedio_preparatoria,
                        documentos_entregados, status, capturado_por, fecha_registro
                    ) VALUES (
                        :folio, :email, :nombre, :apellido_paterno, :apellido_materno,
                        :telefono, :curp, :fecha_nacimiento, :direccion,
                        :carrera_solicitada_id, :periodo_solicitado_id,
                        :preparatoria_procedencia, :promedio_preparatoria,
                        :documentos_entregados, :status, :capturado_por, NOW()
                    )
                ";
                $db->query($sql, [
                    ':folio'                   => $_POST['folio'] ?? '',
                    ':email'                   => $_POST['email'] ?? '',
                    ':nombre'                  => $_POST['nombre'] ?? '',
                    ':apellido_paterno'        => $_POST['apellido_paterno'] ?? '',
                    ':apellido_materno'        => $_POST['apellido_materno'] ?? '',
                    ':telefono'                => $_POST['telefono'] ?? '',
                    ':curp'                    => $_POST['curp'] ?? '',
                    ':fecha_nacimiento'        => $_POST['fecha_nacimiento'] ?? null,
                    ':direccion'               => $_POST['direccion'] ?? '',
                    ':carrera_solicitada_id'   => $_POST['carrera_solicitada_id'] ?? null,
                    ':periodo_solicitado_id'   => $_POST['periodo_solicitado_id'] ?? null,
                    ':preparatoria_procedencia'=> $_POST['preparatoria_procedencia'] ?? '',
                    ':promedio_preparatoria'   => $_POST['promedio_preparatoria'] ?? 0,
                    ':documentos_entregados'   => $_POST['documentos_entregados'] ?? '',
                    ':status'                  => $_POST['status'] ?? 'registrado',
                    ':capturado_por'           => $_SESSION['user']['id'] ?? null,
                ]);
            }

            $db->commit();
            header('Location: /src/plataforma/app/capturista/solicitudes?ok=1');
            exit;
        } catch (Exception $e) {
            $db->rollBack();
            header('Location: /src/plataforma/app/capturista/solicitudes/nueva?error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    /** --------- Editar --------- */
    public function editar($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        $db = new Database();
        $db->query("SELECT * FROM aspirantes WHERE id = ?", [$id]);
        $aspirante = $db->fetch(PDO::FETCH_OBJ);

        if (!$aspirante) {
            header('Location: /src/plataforma/app/capturista/solicitudes');
            exit;
        }

        View::render('capturista/solicitudes/nueva', 'capturista', [
            'aspirante' => $aspirante
        ]);
    }

    /** --------- Eliminar --------- */
    public function eliminar($id) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }

        $db = new Database();
        $db->query("DELETE FROM aspirantes WHERE id = ?", [$id]);

        header('Location: /src/plataforma/app/capturista/solicitudes');
        exit;
    }
}
