<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Asistencia
{
    public static function getHorasSemanaGrupo(int $grupoId): array
    {
        $db = (new Database())->getPdo();

        $sql = "SELECT dia_semana, hora_inicio, hora_fin
                FROM horarios
                WHERE grupo_id = :gid";

        $stmt = $db->prepare($sql);
        $stmt->execute(['gid' => $grupoId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function registrar(int $grupoId, string $fecha, array $alumnos)
    {
        $db = (new Database())->getPdo();

        foreach ($alumnos as $alumnoId => $valor) {
            $sql = "INSERT INTO asistencias (alumno_id, grupo_id, fecha, estado)
                    VALUES (:alumno, :grupo, :fecha, :estado)";

            $stmt = $db->prepare($sql);
            $stmt->execute([
                'alumno' => $alumnoId,
                'grupo' => $grupoId,
                'fecha' => $fecha,
                'estado' => $valor
            ]);
        }
    }
}
