<?php
require_once __DIR__ . '/../../layouts/admin.php';

// Obtener periodo actual y grupos
$periodo_actual = $_GET['periodo'] ?? '2025-1';
$grupo_id = $_GET['grupo'] ?? '';

// Obtener lista de grupos para el filtro
$grupos = $conn->query("
    SELECT g.*, c.nombre as carrera_nombre 
    FROM grupos g 
    JOIN carreras c ON g.carrera_id = c.id 
    ORDER BY c.nombre, g.nombre
")->fetchAll(PDO::FETCH_ASSOC);

// Si hay un grupo seleccionado, obtener su horario
if ($grupo_id) {
    $horario = $conn->prepare("
        SELECT h.*, 
               m.nombre as materia_nombre, 
               m.codigo as materia_codigo,
               p.nombre as profesor_nombre,
               a.nombre as aula_nombre
        FROM horarios h
        JOIN materias m ON h.materia_id = m.id
        LEFT JOIN profesores p ON h.profesor_id = p.id
        LEFT JOIN aulas a ON h.aula_id = a.id
        WHERE h.grupo_id = :grupo_id AND h.periodo = :periodo
        ORDER BY h.dia, h.hora_inicio
    ");
    
    $horario->execute([
        ':grupo_id' => $grupo_id,
        ':periodo' => $periodo_actual
    ]);
    
    $clases = $horario->fetchAll(PDO::FETCH_ASSOC);
}

// Preparar datos para la tabla de horarios
$dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
$horas = [];
for ($i = 7; $i <= 21; $i++) {
    $horas[] = sprintf('%02d:00', $i);
}

// Organizar las clases por día y hora
$horario_matriz = [];
if (isset($clases)) {
    foreach ($clases as $clase) {
        $horario_matriz[$clase['dia']][$clase['hora_inicio']] = $clase;
    }
}
?>

<main class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold mb-2">Horarios</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Administra los horarios de clases por grupo.</p>
        </div>
        <?php if ($grupo_id): ?>
            <a href="/src/plataforma/admin/schedule/add?grupo=<?= $grupo_id ?>&periodo=<?= $periodo_actual ?>" 
               class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2">
                <i data-feather="plus"></i>
                Agregar clase
            </a>
        <?php endif; ?>
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 mb-6">
        <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="periodo" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Periodo
                </label>
                <select name="periodo" id="periodo"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="2025-1" <?= $periodo_actual === '2025-1' ? 'selected' : '' ?>>2025-1</option>
                    <option value="2025-2" <?= $periodo_actual === '2025-2' ? 'selected' : '' ?>>2025-2</option>
                    <option value="2026-1" <?= $periodo_actual === '2026-1' ? 'selected' : '' ?>>2026-1</option>
                </select>
            </div>

            <div>
                <label for="grupo" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Grupo
                </label>
                <select name="grupo" id="grupo"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona un grupo</option>
                    <?php 
                    $carrera_actual = '';
                    foreach ($grupos as $grupo):
                        if ($grupo['carrera_nombre'] !== $carrera_actual):
                            if ($carrera_actual !== '') echo '</optgroup>';
                            echo '<optgroup label="' . htmlspecialchars($grupo['carrera_nombre']) . '">';
                            $carrera_actual = $grupo['carrera_nombre'];
                        endif;
                    ?>
                        <option value="<?= $grupo['id'] ?>" <?= $grupo_id == $grupo['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($grupo['nombre']) ?>
                        </option>
                    <?php 
                    endforeach;
                    if ($carrera_actual !== '') echo '</optgroup>';
                    ?>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2">
                    <i data-feather="filter"></i>
                    Mostrar horario
                </button>
            </div>
        </form>
    </div>

    <?php if ($grupo_id): ?>
        <!-- Tabla de horario -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse">
                    <thead class="bg-neutral-50 dark:bg-neutral-800">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider border border-neutral-200 dark:border-neutral-700">
                                Hora
                            </th>
                            <?php foreach ($dias as $dia): ?>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider border border-neutral-200 dark:border-neutral-700">
                                    <?= $dia ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                        <?php foreach ($horas as $hora): ?>
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-100 border border-neutral-200 dark:border-neutral-700">
                                    <?= $hora ?>
                                </td>
                                <?php for ($dia = 1; $dia <= 5; $dia++): ?>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm border border-neutral-200 dark:border-neutral-700 <?= isset($horario_matriz[$dia][$hora]) ? 'bg-neutral-50 dark:bg-neutral-700' : '' ?>">
                                        <?php if (isset($horario_matriz[$dia][$hora])): 
                                            $clase = $horario_matriz[$dia][$hora];
                                        ?>
                                            <div>
                                                <div class="font-medium text-neutral-900 dark:text-neutral-100">
                                                    <?= htmlspecialchars($clase['materia_nombre']) ?>
                                                </div>
                                                <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                    <?= htmlspecialchars($clase['profesor_nombre'] ?? 'Sin asignar') ?>
                                                </div>
                                                <div class="text-xs text-neutral-500 dark:text-neutral-400">
                                                    <?= htmlspecialchars($clase['aula_nombre'] ?? 'Aula sin asignar') ?>
                                                </div>
                                                <div class="mt-2">
                                                    <a href="/src/plataforma/admin/schedule/edit/<?= $clase['id'] ?>" 
                                                       class="text-xs text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                                        Editar
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                <?php endfor; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 text-center">
            <div class="text-neutral-500 dark:text-neutral-400">
                Selecciona un grupo para ver su horario
            </div>
        </div>
    <?php endif; ?>
</main>

<script>
    // Inicializar los íconos
    feather.replace();

    // Enviar formulario automáticamente al cambiar filtros
    document.querySelectorAll('select[name="periodo"], select[name="grupo"]').forEach(select => {
        select.addEventListener('change', () => {
            select.closest('form').submit();
        });
    });
</script>