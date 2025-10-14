<?php
namespace App\Controllers;

use App\Core\View;
use App\Core\Database;
use PDO;

class CapturistaInscripcionesController
{
    /* ----------- Helpers ----------- */
    private function requireCapturista(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
            header('Location: /src/plataforma/'); exit;
        }
    }

    private function pdo(): PDO {
        $db = new Database();
        return $db->getPdo();
    }

    /* ----------- Listado ----------- */
    public function index() {
        $this->requireCapturista();
        // La vista hace las consultas (ya corregida)
        View::render('capturista/inscripciones', 'capturista');
    }

    /* ----------- Form nueva ----------- */
    public function nueva() {
        $this->requireCapturista();
        // La vista carga catálogos básicos por su cuenta
        View::render('capturista/inscripciones/nueva', 'capturista');
    }

    /* ----------- Guardar (crear/actualizar) ----------- */
    public function guardar() {
        $this->requireCapturista();
        $pdo = $this->pdo();

        // Normalizar POST
        $id               = isset($_POST['id']) ? (int)$_POST['id'] : null;
        $estudiante_id    = isset($_POST['estudiante_id']) ? (int)$_POST['estudiante_id'] : 0;
        $grupo_id         = isset($_POST['grupo_id']) && $_POST['grupo_id'] !== '' ? (int)$_POST['grupo_id'] : null;

        // periodo_id puede venir del select o del input manual
        $periodo_id = null;
        if (!empty($_POST['periodo_id_manual'])) {
            $periodo_id = (int)$_POST['periodo_id_manual'];
        } elseif (!empty($_POST['periodo_id'])) {
            $periodo_id = (int)$_POST['periodo_id'];
        }

        $tipo_inscripcion = $_POST['tipo_inscripcion'] ?? 'normal';
        $status           = $_POST['status'] ?? 'inscrito';

        $calificacion_final = null;
        if (isset($_POST['calificacion_final']) && $_POST['calificacion_final'] !== '') {
            $calificacion_final = (float)$_POST['calificacion_final'];
        }

        $fecha_inscripcion = $_POST['fecha_inscripcion'] ?? null; // si es null, usamos NOW() en SQL

        // Validaciones mínimas
        $errs = [];
        if ($estudiante_id <= 0) $errs[] = 'Selecciona un alumno válido.';
        if ($periodo_id === null) $errs[] = 'Indica el periodo (ID).';
        if (!in_array($tipo_inscripcion, ['normal','adicional','especial'], true)) $errs[] = 'Tipo de inscripción inválido.';
        if (!in_array($status, ['inscrito','cursando','aprobado','reprobado','cancelada','completada'], true)) $errs[] = 'Estado inválido.';

        if ($errs) {
            $msg = urlencode(implode(' ', $errs));
            header('Location: /src/plataforma/app/capturista/inscripciones/nueva?error='.$msg); exit;
        }

        try {
            if ($id) {
                // UPDATE
                $sql = "
                    UPDATE inscripciones
                    SET estudiante_id = :estudiante_id,
                        grupo_id = :grupo_id,
                        periodo_id = :periodo_id,
                        fecha_inscripcion = COALESCE(:fecha_inscripcion, fecha_inscripcion),
                        tipo_inscripcion = :tipo_inscripcion,
                        calificacion_final = :calificacion_final,
                        status = :status,
                        updated_at = NOW()
                    WHERE id = :id
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':id'                 => $id,
                    ':estudiante_id'      => $estudiante_id,
                    ':grupo_id'           => $grupo_id,
                    ':periodo_id'         => $periodo_id,
                    ':fecha_inscripcion'  => $fecha_inscripcion ?: null,
                    ':tipo_inscripcion'   => $tipo_inscripcion,
                    ':calificacion_final' => $calificacion_final,
                    ':status'             => $status,
                ]);
            } else {
                // INSERT
                $sql = "
                    INSERT INTO inscripciones
                      (estudiante_id, grupo_id, periodo_id, fecha_inscripcion, tipo_inscripcion, calificacion_final, status, created_at)
                    VALUES
                      (:estudiante_id, :grupo_id, :periodo_id, COALESCE(:fecha_inscripcion, NOW()), :tipo_inscripcion, :calificacion_final, :status, NOW())
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':estudiante_id'      => $estudiante_id,
                    ':grupo_id'           => $grupo_id,
                    ':periodo_id'         => $periodo_id,
                    ':fecha_inscripcion'  => $fecha_inscripcion ?: null,
                    ':tipo_inscripcion'   => $tipo_inscripcion,
                    ':calificacion_final' => $calificacion_final,
                    ':status'             => $status,
                ]);
            }

            header('Location: /src/plataforma/app/capturista/inscripciones?ok=1'); exit;
        } catch (\Throwable $e) {
            $msg = urlencode('Error al guardar: '.$e->getMessage());
            // Si venía de editar, regrésalo a editar; si no, a nueva
            if ($id) {
                header('Location: /src/plataforma/app/capturista/inscripciones/editar/'.$id.'?error='.$msg); exit;
            } else {
                header('Location: /src/plataforma/app/capturista/inscripciones/nueva?error='.$msg); exit;
            }
        }
    }

    /* ----------- Form editar ----------- */
    public function editar($id) {
        $this->requireCapturista();
        $pdo = $this->pdo();

        $stmt = $pdo->prepare("
            SELECT i.*
            FROM inscripciones i
            WHERE i.id = ?
            LIMIT 1
        ");
        $stmt->execute([(int)$id]);
        $inscripcion = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$inscripcion) {
            header('Location: /src/plataforma/app/capturista/inscripciones?error='.urlencode('Inscripción no encontrada')); exit;
        }

        // Reutilizamos la misma vista de 'nueva' pasándole $inscripcion
        View::render('capturista/inscripciones/nueva', 'capturista', [
            'inscripcion' => $inscripcion
        ]);
    }

    /* ----------- Eliminar ----------- */
    public function eliminar($id) {
        $this->requireCapturista();
        $pdo = $this->pdo();

        try {
            $stmt = $pdo->prepare("DELETE FROM inscripciones WHERE id = ?");
            $stmt->execute([(int)$id]);
            header('Location: /src/plataforma/app/capturista/inscripciones?ok=1'); exit;
        } catch (\Throwable $e) {
            header('Location: /src/plataforma/app/capturista/inscripciones?error='.urlencode($e->getMessage())); exit;
        }
    }
}
