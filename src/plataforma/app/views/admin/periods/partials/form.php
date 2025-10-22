<?php
/**
 * Formulario parcial para crear/editar periods
 * @var object|null $period Period a editar (null para nueva period)
 * @var string $action URL de acción del formulario
 * @var string $method Método HTTP (POST para crear, PUT/PATCH para editar)
 * @var string $submitText Texto del botón de envío
 */

// Determinar si estamos editando o creando
$isEditing = isset($period) && is_object($period);
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
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nombre del Periodo</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($period->name ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                       placeholder="Ej: Enero - Junio 2024">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Año</label>
                <input type="number" name="year" required min="2020" max="2030" value="<?= htmlspecialchars($period->year ?? date('Y')) ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Periodo</label>
                <select name="period_type" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona el tipo</option>
                    <option value="semestre" <?= ($period->period_type ?? '') === 'semestre' ? 'selected' : '' ?>>Semestre</option>
                    <option value="cuatrimestre" <?= ($period->period_type ?? '') === 'cuatrimestre' ? 'selected' : '' ?>>Cuatrimestre</option>
                    <option value="trimestre" <?= ($period->period_type ?? '') === 'trimestre' ? 'selected' : '' ?>>Trimestre</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
                <select name="status" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="upcoming" <?= ($period->status ?? '') === 'upcoming' ? 'selected' : '' ?>>Próximo</option>
                    <option value="active" <?= ($period->status ?? '') === 'active' ? 'selected' : '' ?>>Activo</option>
                    <option value="finished" <?= ($period->status ?? '') === 'finished' ? 'selected' : '' ?>>Finalizado</option>
                    <option value="inactive" <?= ($period->status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Fechas -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="calendar" class="mr-2 h-5 w-5 text-primary-500"></i>
            Fechas del Periodo
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Inicio</label>
                <input type="date" name="start_date" required value="<?= htmlspecialchars($period->start_date ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Fin</label>
                <input type="date" name="end_date" required value="<?= htmlspecialchars($period->end_date ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>
        </div>
    </div>

    <div class="flex justify-end gap-4 pt-4">
        <a href="/src/plataforma/app/admin/periods"
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
        const startDate = new Date(form.querySelector('input[name="start_date"]').value);
        const endDate = new Date(form.querySelector('input[name="end_date"]').value);

        if (!name) {
            e.preventDefault();
            alert('El nombre del periodo es obligatorio');
            return;
        }

        if (startDate >= endDate) {
            e.preventDefault();
            alert('La fecha de fin debe ser posterior a la fecha de inicio');
            return;
        }
    });
});
</script>