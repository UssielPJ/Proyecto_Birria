-- Crear tabla de horarios
CREATE TABLE IF NOT EXISTS schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT UNSIGNED,
    room_id INT,
    day_of_week TINYINT NOT NULL, -- 0 = Lunes, 6 = Domingo
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);