-- Crear tabla de inscripciones
CREATE TABLE IF NOT EXISTS inscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    periodo VARCHAR(20) NOT NULL,
    grupo VARCHAR(50),
    estado ENUM('activa', 'completada', 'cancelada') DEFAULT 'activa',
    fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (alumno_id) REFERENCES alumnos(id) ON DELETE CASCADE,
    INDEX idx_alumno_periodo (alumno_id, periodo),
    INDEX idx_periodo (periodo),
    INDEX idx_estado (estado)
);