<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Schedule {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getWeekByStudent($studentId) {
        $this->db->query("
            SELECT s.*, c.name as course_name, u.name as teacher_name, r.name as room_name
            FROM schedules s
            JOIN courses c ON s.course_id = c.id
            JOIN users u ON c.teacher_id = u.id
            JOIN rooms r ON s.room_id = r.id
            JOIN enrollments e ON c.id = e.course_id
            WHERE e.student_id = ?
            ORDER BY s.day_of_week, s.start_time
        ", [$studentId]);
        return $this->db->fetchAll();
    }

    public function getWeekByTeacher($teacherId) {
        $this->db->query("
            SELECT s.*, c.name as course_name, r.name as room_name, COUNT(e.student_id) as student_count
            FROM schedules s
            JOIN courses c ON s.course_id = c.id
            JOIN rooms r ON s.room_id = r.id
            LEFT JOIN enrollments e ON c.id = e.course_id
            WHERE c.teacher_id = ?
            GROUP BY s.id
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
        $fields = [];
        $values = [];

        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }

        $values[] = $id;
        $query = "UPDATE schedules SET " . implode(', ', $fields) . " WHERE id = ?";
        $this->db->query($query, $values);
        return $this->db->rowCount() > 0;
    }

    public function delete($id) {
        $this->db->query("DELETE FROM schedules WHERE id = ?", [$id]);
        return $this->db->rowCount() > 0;
    }

    public function findById($id) {
        $this->db->query("SELECT * FROM schedules WHERE id = ?", [$id]);
        return $this->db->fetch();
    }
}
