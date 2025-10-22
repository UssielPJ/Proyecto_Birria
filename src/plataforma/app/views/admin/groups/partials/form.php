<?php
/**
 * Formulario parcial para crear/editar groups
 * @var object|null $group Group a editar (null para nueva group)
 * @var string $action URL de acción del formulario
 * @var string $method Método HTTP (POST para crear, PUT/PATCH para editar)
 * @var string $submitText Texto del botón de envío
 */

// Determinar si estamos editando o creando
$isEditing = isset($group) && is_object($group);

// Fetch careers and semesters for selects
global $pdo;
$careers = $pdo->query("SELECT id, name FROM careers ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$semesters = $pdo->query("SELECT id, name FROM semesters ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
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
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nombre del Grupo</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($group->name ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                       placeholder="Ej: Grupo A, 1A, etc.">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Generación</label>
                <input type="text" name="generation" value="<?= htmlspecialchars($group->generation ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                       placeholder="Ej: 2024-2025">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Máximo de Estudiantes</label>
                <input type="number" name="max_students" required min="1" max="50" value="<?= htmlspecialchars($group->max_students ?? 30) ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estudiantes Actuales</label>
                <input type="number" name="current_students" required min="0" value="<?= htmlspecialchars($group->current_students ?? 0) ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>
        </div>
    </div>

    <!-- Clasificación Académica -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="book-open" class="mr-2 h-5 w-5 text-primary-500"></i>
            Clasificación Académica
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Carrera</label>
                <select name="career_id" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona la carrera</option>
                    <?php foreach ($careers as $career): ?>
                        <option value="<?= $career['id'] ?>" <?= ($group->career_id ?? '') == $career['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($career['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre</label>
                <select name="semester_id" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona el semestre</option>
                    <?php foreach ($semesters as $semester): ?>
                        <option value="<?= $semester['id'] ?>" <?= ($group->semester_id ?? '') == $semester['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($semester['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <?php if ($isEditing): ?>
    <!-- Estado del Group (solo para edición) -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="toggle-left" class="mr-2 h-5 w-5 text-primary-500"></i>
            Estado del Grupo
        </h2>

        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
            <select name="status" required
                    class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                <option value="active" <?= ($group->status ?? '') === 'active' ? 'selected' : '' ?>>Activo</option>
                <option value="inactive" <?= ($group->status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>
    </div>
    <?php endif; ?>

    <div class="flex justify-end gap-4 pt-4">
        <a href="/src/plataforma/app/admin/groups"
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
        const name = form.querySelector('input[name="name"]').value.trim();
        const maxStudents = parseInt(form.querySelector('input[name="max_students"]').value);
        const currentStudents = parseInt(form.querySelector('input[name="current_students"]').value);

        if (!name) {
            e.preventDefault();
            alert('El nombre del grupo es obligatorio');
            return;
        }

        if (currentStudents > maxStudents) {
            e.preventDefault();
            alert('Los estudiantes actuales no pueden ser mayores al máximo permitido');
            return;
        }
    });
});
</script>