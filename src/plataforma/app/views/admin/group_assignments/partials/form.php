<?php
/**
 * Formulario parcial para crear/editar group_assignments
 * @var object|null $assignment Assignment a editar (null para nueva assignment)
 * @var string $action URL de acción del formulario
 * @var string $method Método HTTP (POST para crear, PUT/PATCH para editar)
 * @var string $submitText Texto del botón de envío
 */

// Determinar si estamos editando o creando
$isEditing = isset($assignment) && is_object($assignment);

// Fetch data for selects
global $pdo;
$students = $pdo->query("SELECT id, name, email FROM users WHERE role = 'student' ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$groups = $pdo->query("SELECT g.id, g.name, c.name as career_name, s.name as semester_name FROM groups g LEFT JOIN careers c ON g.career_id = c.id LEFT JOIN semesters s ON g.semester_id = s.id ORDER BY g.name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<form action="<?= htmlspecialchars($action) ?>" method="<?= htmlspecialchars($method) ?>" class="space-y-6">
    <!-- Información de la Asignación -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="user-plus" class="mr-2 h-5 w-5 text-primary-500"></i>
            Información de la Asignación
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estudiante</label>
                <select name="student_id" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona un estudiante</option>
                    <?php foreach ($students as $student): ?>
                        <option value="<?= $student['id'] ?>" <?= ($assignment->student_id ?? '') == $student['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($student['name'] . ' (' . $student['email'] . ')') ?>
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
                        <option value="<?= $group['id'] ?>" <?= ($assignment->group_id ?? '') == $group['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($group['name'] . ' - ' . $group['career_name'] . ' (' . $group['semester_name'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
                <select name="status" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="active" <?= ($assignment->status ?? '') === 'active' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactive" <?= ($assignment->status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>

            <?php if ($isEditing): ?>
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Asignación</label>
                <input type="datetime-local" name="assigned_at" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($assignment->assigned_at ?? ''))) ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Información del Grupo Seleccionado -->
    <div id="group-info" class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg hidden">
        <h3 class="font-semibold text-lg flex items-center mb-2">
            <i data-feather="info" class="mr-2 h-5 w-5 text-blue-500"></i>
            Información del Grupo
        </h3>
        <div id="group-details" class="text-sm text-neutral-700 dark:text-neutral-300">
            <!-- Se llenará dinámicamente con JavaScript -->
        </div>
    </div>

    <div class="flex justify-end gap-4 pt-4">
        <a href="/src/plataforma/app/admin/group_assignments"
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

    // Datos de grupos para mostrar información
    const groupsData = <?php echo json_encode($groups); ?>;

    // Elementos del DOM
    const groupSelect = document.querySelector('select[name="group_id"]');
    const groupInfo = document.getElementById('group-info');
    const groupDetails = document.getElementById('group-details');

    // Función para mostrar información del grupo
    function showGroupInfo(groupId) {
        const group = groupsData.find(g => g.id == groupId);
        if (group) {
            groupDetails.innerHTML = `
                <p><strong>Carrera:</strong> ${group.career_name}</p>
                <p><strong>Semestre:</strong> ${group.semester_name}</p>
                <p><strong>Generación:</strong> ${group.generation || 'N/A'}</p>
            `;
            groupInfo.classList.remove('hidden');
        } else {
            groupInfo.classList.add('hidden');
        }
    }

    // Event listener para cambio de grupo
    groupSelect.addEventListener('change', function() {
        const selectedGroupId = this.value;
        if (selectedGroupId) {
            showGroupInfo(selectedGroupId);
        } else {
            groupInfo.classList.add('hidden');
        }
    });

    // Mostrar información si ya hay un grupo seleccionado
    const currentGroupId = groupSelect.value;
    if (currentGroupId) {
        showGroupInfo(currentGroupId);
    }

    // Validación del formulario
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const studentId = form.querySelector('select[name="student_id"]').value;
        const groupId = form.querySelector('select[name="group_id"]').value;

        if (!studentId) {
            e.preventDefault();
            alert('Debes seleccionar un estudiante');
            return;
        }

        if (!groupId) {
            e.preventDefault();
            alert('Debes seleccionar un grupo');
            return;
        }
    });
});
</script>