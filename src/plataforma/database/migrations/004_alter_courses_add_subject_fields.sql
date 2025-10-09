-- Agregar campos adicionales para la tabla de cursos/materias
ALTER TABLE courses
ADD COLUMN creditos INT DEFAULT 0,
ADD COLUMN horas_semana INT DEFAULT 0,
ADD COLUMN departamento VARCHAR(100),
ADD COLUMN semestre INT DEFAULT 1,
ADD COLUMN tipo ENUM('obligatoria', 'optativa', 'especialidad', 'servicio') DEFAULT 'obligatoria',
ADD COLUMN modalidad ENUM('presencial', 'virtual', 'hibrida') DEFAULT 'presencial',
ADD COLUMN estado ENUM('activa', 'inactiva', 'suspendida') DEFAULT 'activa',
ADD COLUMN descripcion TEXT,
ADD COLUMN objetivo TEXT,
ADD COLUMN prerrequisitos TEXT;