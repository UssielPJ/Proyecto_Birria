-- Crear tabla de importaciones
CREATE TABLE IF NOT EXISTS importaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_archivo VARCHAR(255) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    estado ENUM('en_proceso', 'completado', 'error') DEFAULT 'en_proceso',
    total_registros INT DEFAULT 0,
    fecha_inicio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);