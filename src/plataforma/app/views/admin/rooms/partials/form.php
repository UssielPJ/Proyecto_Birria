<?php
/**
 * Formulario parcial para crear/editar rooms
 * @var object|null $room Room a editar (null para nueva room)
 * @var string $action URL de acción del formulario
 * @var string $method Método HTTP (POST para crear, PUT/PATCH para editar)
 * @var string $submitText Texto del botón de envío
 */

// Determinar si estamos editando o creando
$isEditing = isset($room) && is_object($room);
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
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nombre del Salón</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($room->name ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                       placeholder="Ej: A101, Lab-1, Auditorio Principal">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Edificio</label>
                <input type="text" name="building" required value="<?= htmlspecialchars($room->building ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                       placeholder="Ej: Edificio A, Torre Principal">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Piso</label>
                <input type="text" name="floor" value="<?= htmlspecialchars($room->floor ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                       placeholder="Ej: 1, PB, Sótano">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Capacidad</label>
                <input type="number" name="capacity" required min="1" max="500" value="<?= htmlspecialchars($room->capacity ?? 30) ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>
        </div>
    </div>

    <!-- Clasificación y Estado -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="settings" class="mr-2 h-5 w-5 text-primary-500"></i>
            Clasificación y Estado
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Salón</label>
                <select name="type" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona el tipo</option>
                    <option value="classroom" <?= ($room->type ?? '') === 'classroom' ? 'selected' : '' ?>>Aula</option>
                    <option value="laboratory" <?= ($room->type ?? '') === 'laboratory' ? 'selected' : '' ?>>Laboratorio</option>
                    <option value="auditorium" <?= ($room->type ?? '') === 'auditorium' ? 'selected' : '' ?>>Auditorio</option>
                    <option value="office" <?= ($room->type ?? '') === 'office' ? 'selected' : '' ?>>Oficina</option>
                    <option value="other" <?= ($room->type ?? '') === 'other' ? 'selected' : '' ?>>Otro</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
                <select name="status" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="active" <?= ($room->status ?? '') === 'active' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactive" <?= ($room->status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactivo</option>
                    <option value="maintenance" <?= ($room->status ?? '') === 'maintenance' ? 'selected' : '' ?>>Mantenimiento</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Equipamiento -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="tool" class="mr-2 h-5 w-5 text-primary-500"></i>
            Equipamiento
        </h2>
        <p class="text-sm text-neutral-500 dark:text-neutral-400">Selecciona el equipamiento disponible en este salón</p>

        <?php
        $equipment = isset($room->equipment) ? json_decode($room->equipment, true) : [];
        $availableEquipment = [
            'projector' => 'Proyector',
            'whiteboard' => 'Pizarrón blanco',
            'blackboard' => 'Pizarrón negro',
            'computers' => 'Computadoras',
            'wifi' => 'WiFi',
            'air_conditioning' => 'Aire acondicionado',
            'sound_system' => 'Sistema de sonido',
            'microphones' => 'Micrófonos',
            'video_conference' => 'Videoconferencia'
        ];
        ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <?php foreach ($availableEquipment as $value => $label): ?>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="equipment[]" value="<?= $value ?>"
                           <?= in_array($value, $equipment) ? 'checked' : '' ?>
                           class="rounded border-neutral-300 dark:border-neutral-600 text-primary-600 focus:ring-primary-500">
                    <span class="text-sm"><?= htmlspecialchars($label) ?></span>
                </label>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="flex justify-end gap-4 pt-4">
        <a href="/src/plataforma/app/admin/rooms"
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
        const building = form.querySelector('input[name="building"]').value.trim();

        if (!name) {
            e.preventDefault();
            alert('El nombre del salón es obligatorio');
            return;
        }

        if (!building) {
            e.preventDefault();
            alert('El edificio es obligatorio');
            return;
        }
    });
});
</script>