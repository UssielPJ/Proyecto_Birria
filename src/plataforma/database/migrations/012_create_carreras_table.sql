-- Careers table
CREATE TABLE IF NOT EXISTS careers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) NOT NULL UNIQUE,
    description TEXT,
    duration_semesters INT NOT NULL DEFAULT 8,
    total_credits INT NOT NULL DEFAULT 240,
    modality ENUM('presencial', 'virtual', 'mixta') DEFAULT 'presencial',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Semesters table
CREATE TABLE IF NOT EXISTS semesters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    career_id INT,
    semester_number INT NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (career_id) REFERENCES careers(id)
);

-- Subjects/Materials table (extending existing courses)
CREATE TABLE IF NOT EXISTS subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) NOT NULL UNIQUE,
    description TEXT,
    credits INT NOT NULL DEFAULT 5,
    hours_per_week INT NOT NULL DEFAULT 4,
    semester_id INT,
    career_id INT,
    subject_type ENUM('obligatoria', 'optativa', 'especialidad') DEFAULT 'obligatoria',
    knowledge_area VARCHAR(100),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (semester_id) REFERENCES semesters(id),
    FOREIGN KEY (career_id) REFERENCES careers(id)
);

-- Groups/Cohorts table
CREATE TABLE IF NOT EXISTS groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    career_id INT,
    semester_id INT,
    generation VARCHAR(20),
    max_students INT DEFAULT 30,
    current_students INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (career_id) REFERENCES careers(id),
    FOREIGN KEY (semester_id) REFERENCES semesters(id)
);

-- Group assignments table
CREATE TABLE IF NOT EXISTS group_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    group_id INT,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active',
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (group_id) REFERENCES groups(id),
    UNIQUE KEY unique_student_group (student_id, group_id)
);

-- Periods table
CREATE TABLE IF NOT EXISTS periods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    period_type ENUM('semestre', 'cuatrimestre', 'trimestre') DEFAULT 'semestre',
    year INT NOT NULL,
    status ENUM('active', 'inactive', 'upcoming', 'finished') DEFAULT 'upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Classes table (specific class instances)
CREATE TABLE IF NOT EXISTS classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_id INT,
    group_id INT,
    teacher_id INT,
    period_id INT,
    room_id INT,
    max_students INT DEFAULT 30,
    enrolled_students INT DEFAULT 0,
    status ENUM('active', 'inactive', 'cancelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id),
    FOREIGN KEY (group_id) REFERENCES groups(id),
    FOREIGN KEY (teacher_id) REFERENCES users(id),
    FOREIGN KEY (period_id) REFERENCES periods(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);

-- Insert sample data
INSERT INTO careers (name, code, description, duration_semesters, total_credits, modality) VALUES
('Ingeniería en Sistemas Computacionales', 'ISC', 'Carrera enfocada en el desarrollo de sistemas de información y tecnologías computacionales', 9, 260, 'presencial'),
('Ingeniería Industrial', 'II', 'Carrera orientada a la optimización de procesos industriales y administrativos', 9, 250, 'presencial'),
('Licenciatura en Administración', 'LA', 'Carrera enfocada en la gestión empresarial y administrativa', 8, 240, 'presencial'),
('Ingeniería en Gestión Empresarial', 'IGE', 'Carrera que combina ingeniería con administración empresarial', 9, 255, 'presencial');

INSERT INTO periods (name, start_date, end_date, year, status) VALUES
('Enero - Junio 2024', '2024-01-15', '2024-06-15', 2024, 'finished'),
('Agosto - Diciembre 2024', '2024-08-15', '2024-12-15', 2024, 'active'),
('Enero - Junio 2025', '2025-01-15', '2025-06-15', 2025, 'upcoming');