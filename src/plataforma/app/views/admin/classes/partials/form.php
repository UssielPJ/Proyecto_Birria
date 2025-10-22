<?php
/**
 * Formulario parcial para crear/editar classes
 * @var object|null $class Class a editar (null para nueva class)
 * @var string $action URL de acción del formulario
 * @var string $method Método HTTP (POST para crear, PUT/PATCH para editar)
 * @var string $submitText Texto del botón de envío
 */

// Determinar si estamos editando o creando
$isEditing = isset($class) && is_object($class);

// Fetch data for selects
global $pdo;
$subjects = $pdo->query("SELECT id, name, code FROM subjects ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$groups = $pdo->query("SELECT id, name FROM groups ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$periods = $pdo->query("SELECT id, name FROM periods ORDER BY year DESC, start_date DESC")->fetchAll(PDO::FETCH_ASSOC);
$teachers = $pdo->query("SELECT id, name FROM users WHERE role = 'teacher' ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$rooms = $pdo->query("SELECT id, name FROM rooms ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<form action="<?= htmlspecialchars($action) ?>" method="<?= htmlspecialchars($method) ?>" class="space-y-6">
    <!-- Información Básica -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="info" class="mr-2 h-5 w-5 text-primary-500"></i>
            Información Básica
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Materia</label>
                <select name="subject_id" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona una materia</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?= $subject['id'] ?>" <?= ($class->subject_id ?? '') == $subject['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($subject['code'] . ' - ' . $subject['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Grupo</label>
                <select name="group_id" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona un grupo</option>
                    <?php foreach ($groups as $group): ?>
                        <option value="<?= $group['id'] ?>" <?= ($class->group_id ?? '') == $group['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($group['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Periodo</label>
                <select name="period_id" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona un periodo</option>
                    <?php foreach ($periods as $period): ?>
                        <option value="<?= $period['id'] ?>" <?= ($class->period_id ?? '') == $period['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($period['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Profesor</label>
                <select name="teacher_id" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona un profesor</option>
                    <?php foreach ($teachers as $teacher): ?>
                        <option value="<?= $teacher['id'] ?>" <?= ($class->teacher_id ?? '') == $teacher['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($teacher['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- Detalles de la Clase -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="settings" class="mr-2 h-5 w-5 text-primary-500"></i>
            Detalles de la Clase
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Máximo de Estudiantes</label>
                <input type="number" name="max_students" required min="1" max="100" value="<?= htmlspecialchars($class->max_students ?? 30) ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estudiantes Inscritos</label>
                <input type="number" name="enrolled_students" required min="0" value="<?= htmlspecialchars($class->enrolled_students ?? 0) ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Aula</label>
                <select name="room_id"
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Sin asignar</option>
                    <?php foreach ($rooms as $room): ?>
                        <option value="<?= $room['id'] ?>" <?= ($class->room_id ?? '') == $room['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($room['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <?php if ($isEditing): ?>
    <!-- Estado de la Clase (solo para edición) -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="toggle-left" class="mr-2 h-5 w-5 text-primary-500"></i>
            Estado de la Clase
        </h2>

        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
            <select name="status" required
                    class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                <option value="active" <?= ($class->status ?? '') === 'active' ? 'selected' : '' ?>>Activa</option>
                <option value="inactive" <?= ($class->status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactiva</option>
                <option value="cancelled" <?= ($class->status ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelada</option>
            </select>
        </div>
    </div>
    <?php endif; ?>

    <div class="flex justify-end gap-4 pt-4">
        <a href="/src/plataforma/app/admin/classes"
           class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700 inline-flex items-center gap-2">
            <i data-feather="x" class="h-4 w-4"></i>
            Cancelar
        </a>
        <button type="submit"
                class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600 inline-flex items-center gap-2">
            <i data-feather="save" class="h-4 w-4"></i>
            <?= htmlspecialchars($submitText) ?>
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    feather.replace();

    // Validación del formulario
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const maxStudents = parseInt(form.querySelector('input[name="max_students"]').value);
        const enrolledStudents = parseInt(form.querySelector('input[name="enrolled_students"]').value);

        if (enrolledStudents > maxStudents) {
            e.preventDefault();
            alert('Los estudiantes inscritos no pueden ser mayores al máximo permitido');
            return;
        }
    });
});
</script>