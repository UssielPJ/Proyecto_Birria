<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Schedule {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getWeekByStudent($studentId): array {
        try {
            // Get student's user_id from alumnos table
            $this->db->query("SELECT u.id as user_id FROM users u JOIN alumnos a ON u.email = a.email WHERE a.id = ?", [$studentId]);
            $studentUser = $this->db->fetch();

            if (!$studentUser) {
                return [];
            }

            // Get schedules from enrollments table
            $this->db->query("
                SELECT s.*, c.name as course_name, r.name as room_name
                FROM schedules s
                JOIN courses c ON s.course_id = c.id
                JOIN enrollments e ON c.id = e.course_id
                LEFT JOIN rooms r ON s.room_id = r.id
                WHERE e.student_id = ? AND c.estado = 'activa'
                ORDER BY s.day_of_week, s.start_time
            ", [$studentUser['user_id']]);

            return $this->db->fetchAll();
        } catch (\Exception $e) {
            error_log("Error getting schedule for student: " . $e->getMessage());
            return [];
        }
    }

    public function getWeekByTeacher($teacherId) {
        // Note: enrollments table structure is different - using user_id instead of student_id
        // and carrera_id instead of course_id. For now, return schedules without student count
        $this->db->query("
            SELECT s.*, c.name as course_name, r.name as room_name, 0 as student_count
            FROM schedules s
            JOIN courses c ON s.course_id = c.id
            JOIN rooms r ON s.room_id = r.id
            WHERE c.teacher_id = ?
            ORDER BY s.day_of_week, s.start_time
        ", [$teacherId]);
        return $this->db->fetchAll();
    }

    public function getNextClass($weekSchedule) {
        if (empty($weekSchedule)) {
            return null;
        }

        $currentDay = date('w'); // 0 = Sunday, 6 = Saturday
        $currentTime = date('H:i');

        // Find next class today or later this week
        foreach ($weekSchedule as $schedule) {
            $scheduleDay = $schedule->day_of_week;

            // If class is later today or later this week
            if ($scheduleDay > $currentDay || 
                ($scheduleDay == $currentDay && $schedule->start_time > $currentTime)) {
                return [
                    'course' => $schedule->course_name,
                    'time' => date('H:i', strtotime($schedule->start_time)),
                    'room' => $schedule->room_name,
                    'day' => $this->getDayName($scheduleDay)
                ];
            }
        }

        // If no class found for today or later this week, return first class of next week
        $firstClass = $weekSchedule[0];
        return [
            'course' => $firstClass->course_name,
            'time' => date('H:i', strtotime($firstClass->start_time)),
            'room' => $firstClass->room_name,
            'day' => $this->getDayName($firstClass->day_of_week)
        ];
    }

    private function getDayName($dayNumber) {
        $days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        return $days[$dayNumber] ?? '';
    }

    public function create($data) {
        $this->db->query("
            INSERT INTO schedules (course_id, room_id, day_of_week, start_time, end_time)
            VALUES (?, ?, ?, ?, ?)
        ", [
            $data['course_id'],
            $data['room_id'],
            $data['day_of_week'],
            $data['start_time'],
            $data['end_time']
        ]);
        return $this->db->rowCount() > 0;
    }

    public function update($id, $data) {
        try {
            // Mapear los campos del formulario a los campos de la tabla
            $scheduleData = [
                'course_id' => $data['materia_id'] ?? null,
                'room_id' => $data['aula_id'] ?? null,
                'day_of_week' => $data['dia'] ?? null,
                'start_time' => $data['hora_inicio'] ?? null,
                'end_time' => $data['hora_fin'] ?? null
            ];

            // Actualizar el horario
            $fields = [];
            $values = [];

            foreach ($scheduleData as $key => $value) {
                if ($value !== null) {
                    $fields[] = "$key = ?";
                    $values[] = $value;
                }
            }

            if (empty($fields)) {
                return false;
            }

            $values[] = $id;
            $query = "UPDATE schedules SET " . implode(', ', $fields) . " WHERE id = ?";
            $this->db->query($query, $values);

            // También necesitamos actualizar el curso si se cambia el profesor
            if (isset($data['profesor_id'])) {
                $this->db->query("UPDATE courses SET teacher_id = ? WHERE id = ?", 
                    [$data['profesor_id'], $scheduleData['course_id']]);
            }

            return $this->db->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Error updating schedule: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        $this->db->query("DELETE FROM schedules WHERE id = ?", [$id]);
        return $this->db->rowCount() > 0;
    }

    public function getAll() {
        $this->db->query("
            SELECT s.*, c.name as course_name, u.name as teacher_name, r.name as room_name
            FROM schedules s
            JOIN courses c ON s.course_id = c.id
            JOIN users u ON c.teacher_id = u.id
            JOIN rooms r ON s.room_id = r.id
            ORDER BY s.day_of_week, s.start_time
        ");
        return $this->db->fetchAll();
    }

    public function findById($id) {
        $this->db->query("SELECT s.*,
                                c.id as materia_id,
                                c.name as materia_nombre,
                                c.code as materia_codigo,
                                c.teacher_id as profesor_id,
                                u.name as profesor_nombre,
                                r.id as aula_id,
                                r.name as aula_nombre,
                                r.type as aula_tipo,
                                s.day_of_week as dia,
                                s.start_time as hora_inicio,
                                s.end_time as hora_fin,
                                '2025-1' as periodo,
                                'SIS-1A' as grupo_id,
                                'presencial' as modalidad,
                                'activa' as estado,
                                'teorica' as tipo_clase,
                                '2' as duracion,
                                '' as observaciones,
                                CURDATE() as fecha_inicio,
                                DATE_ADD(CURDATE(), INTERVAL 4 MONTH) as fecha_fin
                         FROM schedules s
                         LEFT JOIN courses c ON s.course_id = c.id
                         LEFT JOIN users u ON c.teacher_id = u.id
                         LEFT JOIN rooms r ON s.room_id = r.id
                         WHERE s.id = ?", [$id]);
        return $this->db->fetch();
    }
}
