<?php
/**
 * Formulario parcial para crear/editar materias
 * @var object|null $subject Materia a editar (null para nueva materia)
 * @var string $action URL de acción del formulario
 * @var string $method Método HTTP (POST para crear, PUT/PATCH para editar)
 * @var string $submitText Texto del botón de envío
 */

// Determinar si estamos editando o creando
$isEditing = isset($subject) && is_object($subject);
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
                <input type="text" name="nombre" required value="<?= htmlspecialchars($subject->name ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Código de la Materia</label>
                <input type="text" name="codigo" required value="<?= htmlspecialchars($subject->code ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                       placeholder="Ej: MAT101">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Créditos</label>
                <select name="creditos" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona los créditos</option>
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <option value="<?= $i ?>" <?= ($subject->creditos ?? '') == $i ? 'selected' : '' ?>><?= $i ?> crédito<?= $i > 1 ? 's' : '' ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Horas por Semana</label>
                <select name="horas_semana" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona las horas</option>
                    <?php for ($i = 2; $i <= 6; $i++): ?>
                        <option value="<?= $i ?>" <?= ($subject->horas_semana ?? '') == $i ? 'selected' : '' ?>><?= $i ?> horas</option>
                    <?php endfor; ?>
                </select>
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
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Departamento</label>
                <select name="departamento" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona un departamento</option>
                    <?php
                    $departamentos = [
                        'Ingeniería en Sistemas',
                        'Ingeniería Industrial',
                        'Ingeniería Mecatrónica',
                        'Ciencias Básicas',
                        'Humanidades',
                        'Administración'
                    ];
                    foreach ($departamentos as $departamento): ?>
                        <option value="<?= htmlspecialchars($departamento) ?>" <?= ($subject->departamento ?? '') === $departamento ? 'selected' : '' ?>>
                            <?= htmlspecialchars($departamento) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre</label>
                <select name="semestre" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona el semestre</option>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?= $i ?>" <?= ($subject->semestre ?? '') == $i ? 'selected' : '' ?>><?= $i ?>° Semestre</option>
                    <?php endfor; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Materia</label>
                <select name="tipo" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona el tipo</option>
                    <?php
                    $tipos = [
                        'obligatoria' => 'Obligatoria',
                        'optativa' => 'Optativa',
                        'especialidad' => 'Especialidad',
                        'servicio' => 'Servicio Social'
                    ];
                    foreach ($tipos as $value => $label): ?>
                        <option value="<?= $value ?>" <?= ($subject->tipo ?? '') === $value ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Modalidad</label>
                <select name="modalidad" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona la modalidad</option>
                    <?php
                    $modalidades = [
                        'presencial' => 'Presencial',
                        'virtual' => 'Virtual',
                        'hibrida' => 'Híbrida'
                    ];
                    foreach ($modalidades as $value => $label): ?>
                        <option value="<?= $value ?>" <?= ($subject->modalidad ?? '') === $value ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <?php if ($isEditing): ?>
    <!-- Estado de la Materia (solo para edición) -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="toggle-left" class="mr-2 h-5 w-5 text-primary-500"></i>
            Estado de la Materia
        </h2>

        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
            <select name="estado" required
                    class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                <?php
                $estados = [
                    'activa' => 'Activa',
                    'inactiva' => 'Inactiva',
                    'suspendida' => 'Suspendida'
                ];
                foreach ($estados as $value => $label): ?>
                    <option value="<?= $value ?>" <?= ($subject->estado ?? '') === $value ? 'selected' : '' ?>>
                        <?= htmlspecialchars($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <?php endif; ?>

    <!-- Asignación de Profesor -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="user" class="mr-2 h-5 w-5 text-primary-500"></i>
            Asignación de Profesor
        </h2>
        <p class="text-sm text-neutral-500 dark:text-neutral-400">Puedes asignar un profesor ahora o dejarlo para después</p>

        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Profesor Asignado</label>
            <select name="profesor_id"
                    class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                <option value="">Sin asignar</option>
                <?php
                // Aquí deberías obtener la lista de profesores desde la base de datos
                $profesores = [
                    ['id' => 1, 'nombre' => 'Dr. Juan Pérez'],
                    ['id' => 2, 'nombre' => 'Ing. María González'],
                    ['id' => 3, 'nombre' => 'M.C. Carlos Rodríguez'],
                ];
                foreach ($profesores as $profesor): ?>
                    <option value="<?= $profesor['id'] ?>" <?= ($subject->teacher_id ?? '') == $profesor['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($profesor['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- Descripción y Objetivos -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="file-text" class="mr-2 h-5 w-5 text-primary-500"></i>
            Descripción y Objetivos
        </h2>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Descripción de la Materia</label>
                <textarea name="descripcion" rows="3"
                          class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                          placeholder="Describe brevemente el contenido y enfoque de la materia..."><?= htmlspecialchars($subject->descripcion ?? '') ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Objetivo General</label>
                <textarea name="objetivo" rows="2"
                          class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                          placeholder="¿Qué se espera que el estudiante logre al completar esta materia?"><?= htmlspecialchars($subject->objetivo ?? '') ?></textarea>
            </div>
        </div>
    </div>

    <!-- Prerrequisitos -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="git-branch" class="mr-2 h-5 w-5 text-primary-500"></i>
            Prerrequisitos
        </h2>
        <p class="text-sm text-neutral-500 dark:text-neutral-400">Selecciona las materias que deben ser aprobadas antes de cursar esta materia</p>

        <?php
        $prerrequisitosMateria = isset($subject->prerrequisitos) ? explode(',', $subject->prerrequisitos) : [];
        ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <?php
            // Aquí deberías obtener la lista de materias desde la base de datos
            $materiasDisponibles = [
                ['id' => 1, 'nombre' => 'Matemáticas I', 'codigo' => 'MAT101'],
                ['id' => 2, 'nombre' => 'Física I', 'codigo' => 'FIS101'],
                ['id' => 3, 'nombre' => 'Programación I', 'codigo' => 'PRG101'],
                ['id' => 4, 'nombre' => 'Álgebra Lineal', 'codigo' => 'MAT201'],
            ];
            foreach ($materiasDisponibles as $materia): ?>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="prerrequisitos[]" value="<?= htmlspecialchars($materia['id']) ?>"
                           <?= in_array($materia['id'], $prerrequisitosMateria) ? 'checked' : '' ?>
                           class="rounded border-neutral-300 dark:border-neutral-600 text-primary-600 focus:ring-primary-500">
                    <span class="text-sm"><?= htmlspecialchars($materia['codigo']) ?> - <?= htmlspecialchars($materia['nombre']) ?></span>
                </label>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="flex justify-end gap-4 pt-4">
        <a href="/src/plataforma/admin/subjects"
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
