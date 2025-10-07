-- Add missing columns to courses table
ALTER TABLE courses ADD COLUMN IF NOT EXISTS creditos INT DEFAULT 0;
ALTER TABLE courses ADD COLUMN IF NOT EXISTS horas_semana INT DEFAULT 0;
ALTER TABLE courses ADD COLUMN IF NOT EXISTS departamento VARCHAR(100);
ALTER TABLE courses ADD COLUMN IF NOT EXISTS semestre INT DEFAULT 1;
ALTER TABLE courses ADD COLUMN IF NOT EXISTS tipo ENUM('obligatoria', 'optativa', 'especialidad', 'servicio') DEFAULT 'obligatoria';
ALTER TABLE courses ADD COLUMN IF NOT EXISTS modalidad ENUM('presencial', 'virtual', 'hibrida') DEFAULT 'presencial';
ALTER TABLE courses ADD COLUMN IF NOT EXISTS estado ENUM('activa', 'inactiva', 'suspendida') DEFAULT 'activa';
ALTER TABLE courses ADD COLUMN IF NOT EXISTS descripcion TEXT;
ALTER TABLE courses ADD COLUMN IF NOT EXISTS objetivo TEXT;
ALTER TABLE courses ADD COLUMN IF NOT EXISTS prerrequisitos TEXT;