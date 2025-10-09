<?php
global $pdo;
$conn = $pdo;

// Usar los horarios pasados desde el controlador
$clases = $schedules ?? [];

// Preparar datos para la tabla de horarios
$dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
$horas = [];
for ($i = 7; $i <= 21; $i++) {
    $horas[] = sprintf('%02d:00', $i);
}

// Organizar las clases por día y hora
$horario_matriz = [];
if (!empty($clases)) {
    foreach ($clases as $clase) {
        // Mapear los campos del schedule a los esperados por la vista
        $clase_mapeada = [
            'id' => $clase->id,
            'materia_nombre' => $clase->course_name,
            'materia_codigo' => '', // No disponible
            'profesor_nombre' => $clase->teacher_name,
            'aula_nombre' => $clase->room_name,
            'dia' => $clase->day_of_week,
            'hora_inicio' => $clase->start_time,
            'hora_fin' => $clase->end_time
        ];
        $horario_matriz[$clase->day_of_week][$clase->start_time] = $clase_mapeada;
    }
}
?>

<main class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold mb-2">Horarios</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Administra los horarios de clases.</p>
        </div>
        <a href="/src/plataforma/admin/schedule/create"
           class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2">
            <i data-feather="plus"></i>
            Agregar horario
        </a>
    </div>
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
</main>

<script>
    // Inicializar los íconos
    feather.replace();
</script>