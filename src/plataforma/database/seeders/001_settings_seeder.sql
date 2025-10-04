-- Insertar configuraciones generales por defecto
INSERT INTO settings (category, setting_key, setting_value) VALUES
('general', 'school_name', 'Universidad Tecnológica'),
('general', 'school_address', 'Calle Principal #123'),
('general', 'contact_email', 'contacto@utec.edu'),
('general', 'phone', '123-456-7890');

-- Insertar configuraciones académicas por defecto
INSERT INTO settings (category, setting_key, setting_value) VALUES
('academic', 'current_period', '2025-1'),
('academic', 'enrollment_open', '1'),
('academic', 'min_attendance', '80'),
('academic', 'passing_grade', '70');

-- Insertar configuraciones de notificaciones por defecto
INSERT INTO settings (category, setting_key, setting_value) VALUES
('notifications', 'email_notifications', '1'),
('notifications', 'smtp_host', 'smtp.example.com'),
('notifications', 'smtp_user', 'notifications@utec.edu');