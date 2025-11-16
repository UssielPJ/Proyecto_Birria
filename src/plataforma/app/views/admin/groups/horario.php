<?php
// app/views/admin/grupos/horario.php
/** @var object $grupo */
/** @var array  $schedule */

$esc = function ($v) {
    if ($v === null) $v = '';
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
};

$diasSemana = [
    1 => 'Lunes',
    2 => 'Martes',
    3 => 'Miércoles',
    4 => 'Jueves',
    5 => 'Viernes',
    6 => 'Sábado',
];

// Ordenar las horas (keys del arreglo: "HH:MM - HH:MM")
$horas = array_keys($schedule);
sort($horas);

// Mapeo simple de color lógico -> clases tailwind
$colorCard = function (string $colorKey): string {
    switch ($colorKey) {
        case 'purple': return 'bg-purple-50 dark:bg-purple-900/20 border-purple-500 text-purple-800 dark:text-purple-200';
        case 'green':  return 'bg-green-50 dark:bg-green-900/20 border-green-500 text-green-800 dark:text-green-200';
        case 'amber':  return 'bg-amber-50 dark:bg-amber-900/20 border-amber-500 text-amber-800 dark:text-amber-200';
        case 'red':    return 'bg-red-50 dark:bg-red-900/20 border-red-500 text-red-800 dark:text-red-200';
        case 'indigo': return 'bg-indigo-50 dark:bg-indigo-900/20 border-indigo-500 text-indigo-800 dark:text-indigo-200';
        case 'teal':   return 'bg-teal-50 dark:bg-teal-900/20 border-teal-500 text-teal-800 dark:text-teal-200';
        case 'blue':
        default:
            return 'bg-blue-50 dark:bg-blue-900/20 border-blue-500 text-blue-800 dark:text-blue-200';
    }
};
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 rounded-xl p-6 text-white mb-8 shadow-2xl relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-pulse"></div>
        <div class="relative flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-full backdrop-blur-sm">
                    <i data-feather="calendar" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-1">
                        Horario del grupo · <?= $esc(isset($grupo->codigo) ? $grupo->codigo : 'Grupo') ?>
                    </h2>
                    <?php if (!empty($grupo->titulo)): ?>
                        <p class="opacity-90 text-sm"><?= $esc($grupo->titulo) ?></p>
                    <?php endif; ?>
                    <p class="opacity-80 text-sm">Vista de sólo lectura del horario definitivo.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-neutral-700/80">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                            Hora
                        </th>
                        <?php foreach ($diasSemana as $diaNum => $diaNombre): ?>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-200 uppercase tracking-wider">
                                <?= $esc($diaNombre) ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">

                <?php if (empty($schedule)): ?>
                    <tr>
                        <td colspan="<?= 1 + count($diasSemana) ?>"
                            class="px-4 py-6 text-center text-gray-500 dark:text-gray-300 text-sm">
                            Este grupo aún no tiene horario guardado.
                        </td>
                    </tr>
                <?php else: ?>

                    <?php
                    $rowIndex = 0;
                    foreach ($horas as $labelHora):
                        $rowIndex++;
                        $rowClass = $rowIndex % 2 === 0 ? 'bg-gray-50 dark:bg-neutral-800/60' : '';
                        $fila = $schedule[$labelHora];
                    ?>
                        <tr class="<?= $rowClass ?>">
                            <!-- Columna de la hora -->
                            <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                <?= $esc($labelHora) ?>
                            </td>

                            <!-- Columnas por día -->
                            <?php foreach ($diasSemana as $diaNum => $diaNombre): ?>
                                <?php $slot = isset($fila[$diaNum]) ? $fila[$diaNum] : null; ?>
                                <td class="px-4 py-3 text-center align-top">
                                    <?php if ($slot): ?>
                                        <?php
                                        $classes = $colorCard(isset($slot['color']) ? $slot['color'] : 'blue');
                                        ?>
                                        <div class="inline-block text-left w-full max-w-[220px]">
                                            <div class="rounded-lg p-2 border-l-4 <?= $classes ?> shadow-sm">
                                                <h4 class="text-sm font-semibold mb-1">
                                                    <?= $esc($slot['materia']) ?>
                                                </h4>
                                                <?php if (!empty($slot['aula'])): ?>
                                                    <p class="text-xs opacity-80">
                                                        Aula: <?= $esc($slot['aula']) ?>
                                                    </p>
                                                <?php endif; ?>
                                                <?php if (!empty($slot['docente'])): ?>
                                                    <p class="text-xs opacity-80 mt-1">
                                                        Docente: <?= $esc($slot['docente']) ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400 dark:text-gray-500">—</span>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    feather.replace();
</script>
