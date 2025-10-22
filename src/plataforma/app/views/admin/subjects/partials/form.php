<?php
/**
 * Formulario parcial para crear/editar subjects
 * @var object|null $subject Subject a editar (null para nueva subject)
 * @var string $action URL de acción del formulario
 * @var string $method Método HTTP (POST para crear, PUT/PATCH para editar)
 * @var string $submitText Texto del botón de envío
 */

// Determinar si estamos editando o creando
$isEditing = isset($subject) && is_object($subject);

// Fetch semesters and careers for selects
global $pdo;
$semesters = $pdo->query("SELECT id, name FROM semesters ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
$careers = $pdo->query("SELECT id, name FROM careers ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
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
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nombre de la Materia</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($subject->name ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Código de la Materia</label>
                <input type="text" name="code" required value="<?= htmlspecialchars($subject->code ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                       placeholder="Ej: MAT101">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Créditos</label>
                <input type="number" name="credits" required min="1" max="10" value="<?= htmlspecialchars($subject->credits ?? 5) ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Horas por Semana</label>
                <input type="number" name="hours_per_week" required min="1" max="10" value="<?= htmlspecialchars($subject->hours_per_week ?? 4) ?>"
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
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre</label>
                <select name="semester_id" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona el semestre</option>
                    <?php foreach ($semesters as $sem): ?>
                        <option value="<?= $sem['id'] ?>" <?= ($subject->semester_id ?? '') == $sem['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sem['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Carrera</label>
                <select name="career_id" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona la carrera</option>
                    <?php foreach ($careers as $career): ?>
                        <option value="<?= $career['id'] ?>" <?= ($subject->career_id ?? '') == $career['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($career['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Materia</label>
                <select name="subject_type" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona el tipo</option>
                    <option value="obligatoria" <?= ($subject->subject_type ?? '') === 'obligatoria' ? 'selected' : '' ?>>Obligatoria</option>
                    <option value="optativa" <?= ($subject->subject_type ?? '') === 'optativa' ? 'selected' : '' ?>>Optativa</option>
                    <option value="especialidad" <?= ($subject->subject_type ?? '') === 'especialidad' ? 'selected' : '' ?>>Especialidad</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Área de Conocimiento</label>
                <input type="text" name="knowledge_area" value="<?= htmlspecialchars($subject->knowledge_area ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                       placeholder="Ej: Matemáticas, Física">
            </div>
        </div>
    </div>

    <?php if ($isEditing): ?>
    <!-- Estado del Subject (solo para edición) -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="toggle-left" class="mr-2 h-5 w-5 text-primary-500"></i>
            Estado del Subject
        </h2>

        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
            <select name="status" required
                    class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                <option value="active" <?= ($subject->status ?? '') === 'active' ? 'selected' : '' ?>>Activo</option>
                <option value="inactive" <?= ($subject->status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>
    </div>
    <?php endif; ?>

    <!-- Descripción -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="file-text" class="mr-2 h-5 w-5 text-primary-500"></i>
            Descripción
        </h2>

        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Descripción de la Materia</label>
            <textarea name="description" rows="3"
                      class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                      placeholder="Describe brevemente el contenido y enfoque de la materia..."><?= htmlspecialchars($subject->description ?? '') ?></textarea>
        </div>
    </div>

    <div class="flex justify-end gap-4 pt-4">
        <a href="/src/plataforma/app/admin/subjects"
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
        const nombre = form.querySelector('input[name="nombre"]').value.trim();
        const codigo = form.querySelector('input[name="codigo"]').value.trim();

        if (!nombre || !codigo) {
            e.preventDefault();
            alert('El nombre y código de la materia son obligatorios');
            return;
        }

        // Validar formato del código (letras seguidas de números)
        const codigoPattern = /^[A-Z]{2,4}\d{3}$/;
        if (!codigoPattern.test(codigo)) {
            e.preventDefault();
            alert('El código debe tener el formato: 2-4 letras seguidas de 3 números (Ej: MAT101)');
            return;
        }
    });

    // Auto-generar código basado en departamento
    const departamentoSelect = document.querySelector('select[name="departamento"]');
    const codigoInput = document.querySelector('input[name="codigo"]');

    departamentoSelect.addEventListener('change', function() {
        const prefijos = {
            'Ingeniería en Sistemas': 'SIS',
            'Ingeniería Industrial': 'IND',
            'Ingeniería Mecatrónica': 'MEC',
            'Ciencias Básicas': 'CB',
            'Humanidades': 'HUM',
            'Administración': 'ADM'
        };

        const prefijo = prefijos[this.value];
        if (prefijo && !codigoInput.value) {
            codigoInput.value = prefijo + '101';
        }
    });
});
</script>
