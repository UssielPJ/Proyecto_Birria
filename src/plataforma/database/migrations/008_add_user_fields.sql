-- Add missing fields to users table for student and teacher information
ALTER TABLE users
ADD COLUMN matricula VARCHAR(20) NULL,
ADD COLUMN semestre VARCHAR(20) NULL,
ADD COLUMN carrera VARCHAR(100) NULL,
ADD COLUMN grupo VARCHAR(20) NULL,
ADD COLUMN phone VARCHAR(20) NULL,
ADD COLUMN birthdate DATE NULL,
ADD COLUMN status ENUM('active', 'inactive') DEFAULT 'active',
ADD COLUMN num_empleado VARCHAR(20) NULL,
ADD COLUMN departamento VARCHAR(100) NULL,
ADD COLUMN street VARCHAR(255) NULL,
ADD COLUMN neighborhood VARCHAR(100) NULL,
ADD COLUMN city VARCHAR(100) NULL,
ADD COLUMN state VARCHAR(100) NULL,
ADD COLUMN postal_code VARCHAR(10) NULL,
ADD COLUMN emergency_contact_name VARCHAR(100) NULL,
ADD COLUMN emergency_contact_phone VARCHAR(20) NULL,
ADD COLUMN emergency_contact_relationship VARCHAR(50) NULL;