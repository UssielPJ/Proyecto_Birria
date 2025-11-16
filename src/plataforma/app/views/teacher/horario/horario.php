<?php
// app/views/teacher/horario.php
/** @var array $user */
/** @var array $schedule */

$esc = function ($v) {
    return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
};

$schedule = $schedule ?? [];

$diasSemana = [
    1 => 'Lunes',
    2 => 'Martes',
    3 => 'Miércoles',
    4 => 'Jueves',
    5 => 'Viernes',
    6 => 'Sábado',
];

// Ordenar horas
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
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="calendar" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Mi Horario</h2>
                <p class="opacity-90 text-sm">
                    Docente: <?= $esc($user['name'] ?? '') ?>
                </p>
                <p class="opacity-75 text-xs">
                    Consulta tus clases y grupos asignados durante la semana.
                </p>
            </div>
        </div>
    </div>

    <!-- Selector semana + botón descargar con menú -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-4 mb-6 flex items-center justify-between" data-aos="fade-up">
        <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-100">
            <i data-feather="calendar" class="w-4 h-4"></i>
            <span>Semana actual</span>
        </div>

        <div class="relative" id="export-menu-wrapper">
            <button id="btn-export-toggle"
                    type="button"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors flex items-center text-sm">
                <i data-feather="download" class="w-4 h-4 mr-2"></i>
                Descargar horario
                <i data-feather="chevron-down" class="w-4 h-4 ml-1"></i>
            </button>

            <!-- Menú desplegable (abre hacia arriba) -->
            <div id="export-menu"
                 class="hidden absolute bottom-full right-0 mb-2 w-44
                        bg-white dark:bg-neutral-800
                        border border-gray-200 dark:border-neutral-700
                        rounded-lg shadow-xl
                        z-[9999]">
                <button type="button"
                        id="btn-export-png"
                        class="w-full flex items-center gap-2 px-3 py-2 text-xs text-gray-700 dark:text-gray-100
                               hover:bg-gray-50 dark:hover:bg-neutral-700 rounded-t-lg">
                    <i data-feather="image" class="w-3.5 h-3.5"></i>
                    Descargar como PNG
                </button>

                <button type="button"
                        id="btn-export-pdf"
                        class="w-full flex items-center gap-2 px-3 py-2 text-xs text-gray-700 dark:text-gray-100
                               hover:bg-gray-50 dark:hover:bg-neutral-700 rounded-b-lg">
                    <i data-feather="file-text" class="w-3.5 h-3.5"></i>
                    Descargar como PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Contenedor que se exporta -->
    <div id="schedule-export">
        <!-- Tabla de horario -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-neutral-700">
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Hora
                            </th>
                            <?php foreach ($diasSemana as $diaNum => $diaNombre): ?>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <?= $esc($diaNombre) ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                    <?php if (empty($schedule)): ?>
                        <tr>
                            <td colspan="<?= 1 + count($diasSemana) ?>"
                                class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-300">
                                Aún no tienes clases asignadas en el horario.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $rowIndex = 0;
                        foreach ($horas as $labelHora):
                            $rowIndex++;
                            $fila     = $schedule[$labelHora];
                            $rowClass = $rowIndex % 2 === 0 ? 'bg-gray-50 dark:bg-neutral-700/20' : '';
                        ?>
                            <tr class="<?= $rowClass ?>">
                                <!-- Columna hora -->
                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                    <?= $esc($labelHora) ?>
                                </td>

                                <!-- Columnas por día -->
                                <?php foreach ($diasSemana as $diaNum => $diaNombre): ?>
                                    <?php $slot = $fila[$diaNum] ?? null; ?>
                                    <td class="px-4 py-3 text-center align-top">
                                        <?php if ($slot): ?>
                                            <?php $classes = $colorCard($slot['color'] ?? 'blue'); ?>
                                            <div class="inline-block text-left w-full max-w-[220px]">
                                                <div class="rounded-lg p-2 border-l-4 <?= $classes ?> shadow-sm">
                                                    <h4 class="text-sm font-semibold">
                                                        <?= $esc($slot['materia'] ?? 'Materia') ?>
                                                    </h4>
                                                    <?php if (!empty($slot['grupo'])): ?>
                                                        <p class="text-xs opacity-80 mt-1">
                                                            Grupo: <?= $esc($slot['grupo']) ?>
                                                        </p>
                                                    <?php endif; ?>
                                                    <?php if (!empty($slot['aula'])): ?>
                                                        <p class="text-xs opacity-80">
                                                            Aula: <?= $esc($slot['aula']) ?>
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
</div>

<!-- Librerías para exportar -->
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>

<script>
    AOS.init();
    feather.replace();

    (function() {
        const menuWrapper = document.getElementById('export-menu-wrapper');
        const toggleBtn   = document.getElementById('btn-export-toggle');
        const menu        = document.getElementById('export-menu');
        const btnPNG      = document.getElementById('btn-export-png');
        const btnPDF      = document.getElementById('btn-export-pdf');
        const exportNode  = document.getElementById('schedule-export');

        if (!menuWrapper || !toggleBtn || !menu || !exportNode) return;

        // Mostrar / ocultar menú
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            menu.classList.toggle('hidden');
        });

        // Cerrar al hacer click fuera
        document.addEventListener('click', function(e) {
            if (!menuWrapper.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        // PNG
        btnPNG.addEventListener('click', async function() {
            menu.classList.add('hidden');

            const canvas = await html2canvas(exportNode, {
                scale: 2,
                useCORS: true,
                scrollY: -window.scrollY
            });

            canvas.toBlob(function(blob) {
                if (!blob) return;
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'horario-docente.png';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }, 'image/png');
        });

        // PDF
        btnPDF.addEventListener('click', async function() {
            menu.classList.add('hidden');

            const { jsPDF } = window.jspdf;

            const canvas = await html2canvas(exportNode, {
                scale: 2,
                useCORS: true,
                scrollY: -window.scrollY
            });

            const imgData = canvas.toDataURL('image/png');

            const pdf = new jsPDF('l', 'mm', 'a4');
            const pdfWidth  = pdf.internal.pageSize.getWidth();
            const pdfHeight = canvas.height * pdfWidth / canvas.width;

            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save('horario-docente.pdf');
        });
    })();
</script>
