-- Insertar usuarios de prueba con contraseña: 12345
-- La contraseña está hasheada usando password_hash() de PHP

INSERT INTO users (name, email, password, role, status) VALUES
('Administrador', 'admin@utec.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active'),
('Capturista', 'capturista@utec.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'capturista', 'active'),
('Maestro', 'maestro@utec.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', 'active'),
('Estudiante', 'estudiante@utec.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', 'active');

-- Nota: El hash corresponde a la contraseña '12345'