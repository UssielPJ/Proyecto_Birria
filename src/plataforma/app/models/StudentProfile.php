<?php
namespace App\Models;

use App\Core\Database as DB;
use PDO;

class StudentProfile
{
    private PDO $db;

    public function __construct(?PDO $pdo = null)
    {
        $this->db = $pdo ?? (new DB())->getPdo();

    }

    /**
     * Crea un nuevo registro de perfil de estudiante
     * @param array $data
     * @return int ID del registro (user_id)
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO student_profiles (
                    user_id, matricula, curp, carrera_id, semestre, grupo,
                    tipo_ingreso, beca_activa, promedio_general,
                    creditos_aprobados, direccion,
                    contacto_emergencia_nombre, contacto_emergencia_telefono,
                    parentesco_emergencia, created_at, updated_at
                ) VALUES (
                    :user_id, :matricula, :curp, :carrera_id, :semestre, :grupo,
                    :tipo_ingreso, :beca_activa, :promedio_general,
                    :creditos_aprobados, :direccion,
                    :contacto_emergencia_nombre, :contacto_emergencia_telefono,
                    :parentesco_emergencia, NOW(), NOW()
                )";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id'                    => $data['user_id'],
            ':matricula'                  => $data['matricula'],
            ':curp'                       => $data['curp'],
            ':carrera_id'                 => $data['carrera_id'],
            ':semestre'                   => $data['semestre'],
            ':grupo'                      => $data['grupo'] ?? null,
            ':tipo_ingreso'               => $data['tipo_ingreso'] ?? 'nuevo',
            ':beca_activa'                => $data['beca_activa'] ?? 0,
            ':promedio_general'           => $data['promedio_general'] ?? 0,
            ':creditos_aprobados'         => $data['creditos_aprobados'] ?? 0,
            ':direccion'                  => $data['direccion'] ?? null,
            ':contacto_emergencia_nombre' => $data['contacto_emergencia_nombre'] ?? null,
            ':contacto_emergencia_telefono' => $data['contacto_emergencia_telefono'] ?? null,
            ':parentesco_emergencia'      => $data['parentesco_emergencia'] ?? null
        ]);

        return (int)$data['user_id'];
    }

    /**
     * Actualiza el perfil de un estudiante según el user_id
     */
    public function updateByUserId(int $userId, array $data): bool
    {
        $sql = "UPDATE students_profile SET
                    matricula = :matricula,
                    curp = :curp,
                    carrera_id = :carrera_id,
                    semestre = :semestre,
                    grupo = :grupo,
                    tipo_ingreso = :tipo_ingreso,
                    beca_activa = :beca_activa,
                    promedio_general = :promedio_general,
                    creditos_aprobados = :creditos_aprobados,
                    direccion = :direccion,
                    contacto_emergencia_nombre = :contacto_emergencia_nombre,
                    contacto_emergencia_telefono = :contacto_emergencia_telefono,
                    parentesco_emergencia = :parentesco_emergencia,
                    updated_at = NOW()
                WHERE user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id'                    => $userId,
            ':matricula'                  => $data['matricula'],
            ':curp'                       => $data['curp'],
            ':carrera_id'                 => $data['carrera_id'],
            ':semestre'                   => $data['semestre'],
            ':grupo'                      => $data['grupo'] ?? null,
            ':tipo_ingreso'               => $data['tipo_ingreso'] ?? 'nuevo',
            ':beca_activa'                => $data['beca_activa'] ?? 0,
            ':promedio_general'           => $data['promedio_general'] ?? 0,
            ':creditos_aprobados'         => $data['creditos_aprobados'] ?? 0,
            ':direccion'                  => $data['direccion'] ?? null,
            ':contacto_emergencia_nombre' => $data['contacto_emergencia_nombre'] ?? null,
            ':contacto_emergencia_telefono' => $data['contacto_emergencia_telefono'] ?? null,
            ':parentesco_emergencia'      => $data['parentesco_emergencia'] ?? null
        ]);
    }

    /**
     * Obtiene el perfil completo de un estudiante
     */
    public function findByUserId(int $userId): ?object
    {
        $stmt = $this->db->prepare("SELECT * FROM student_profiles WHERE user_id = :id LIMIT 1");
        $stmt->execute([':id' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row ?: null;
    }

    /**
     * Elimina (opcional) el perfil del estudiante
     */
    public function deleteByUserId(int $userId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM student_profiles WHERE user_id = :id");
        return $stmt->execute([':id' => $userId]);
    }

    /**
     * Listado con filtros (join con users)
     */
    public function getAllWithUser(array $filters = []): array
    {
        $query = "SELECT 
                    u.id, u.email, u.nombre, u.apellido_paterno, u.apellido_materno, u.telefono,
                    u.fecha_nacimiento, u.status, u.created_at,
                    sp.matricula, sp.curp, sp.carrera_id, sp.semestre, sp.grupo, sp.tipo_ingreso,
                    sp.promedio_general, sp.beca_activa
                  FROM users u
                  JOIN student_profiles sp ON sp.user_id = u.id
                  WHERE 1=1";

        $params = [];

        if (!empty($filters['search'])) {
            $query .= " AND (u.nombre LIKE :search OR u.email LIKE :search OR sp.matricula LIKE :search)";
            $params[':search'] = "%{$filters['search']}%";
        }
        if (!empty($filters['semestre'])) {
            $query .= " AND sp.semestre = :semestre";
            $params[':semestre'] = $filters['semestre'];
        }
        if (!empty($filters['carrera'])) {
            $query .= " AND sp.carrera_id = :carrera";
            $params[':carrera'] = $filters['carrera'];
        }
        if (!empty($filters['estado'])) {
            $query .= " AND u.status = :estado";
            $params[':estado'] = $filters['estado'];
        }

        $query .= " ORDER BY sp.matricula ASC";

        if (isset($filters['limit'])) {
            $query .= " LIMIT :limit OFFSET :offset";
            $params[':limit'] = (int)($filters['limit'] ?? 10);
            $params[':offset'] = (int)($filters['offset'] ?? 0);
        }

        $stmt = $this->db->prepare($query);

        // Si hay limit/offset se deben bindear como enteros
        foreach ($params as $k => $v) {
            if (in_array($k, [':limit', ':offset'])) {
                $stmt->bindValue($k, $v, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($k, $v);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
