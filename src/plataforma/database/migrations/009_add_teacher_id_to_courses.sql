-- Add teacher_id column to courses table if it doesn't exist
SET @sql = (SELECT IF(
    (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'courses' AND COLUMN_NAME = 'teacher_id') = 0,
    'ALTER TABLE courses ADD COLUMN teacher_id INT UNSIGNED NULL, ADD CONSTRAINT fk_courses_teacher_id FOREIGN KEY (teacher_id) REFERENCES users(id)',
    'SELECT "teacher_id column already exists"'
));
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;