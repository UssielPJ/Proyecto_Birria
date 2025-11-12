-- Crear tabla de perfiles de capturistas
CREATE TABLE IF NOT EXISTS capturista_profiles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    numero_empleado VARCHAR(20) NOT NULL,
    telefono VARCHAR(20),
    curp VARCHAR(18) NOT NULL,
    fecha_ingreso DATE NOT NULL,
    status ENUM('activo','inactivo') DEFAULT 'activo',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_numero_empleado (numero_empleado),
    UNIQUE KEY unique_curp (curp)
);