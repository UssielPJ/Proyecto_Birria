<?php
// app/views/admin/horarios/vista_previa.php

/** @var object $grupo */
/** @var array  $slots */
/** @var array  $materiasIndex */
/** @var array  $teachersIndex */
/** @var array  $materiaToTeacher */

$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

// Mapear días
$diasSemana = [
    1 => 'Lunes',
    2 => 'Martes',
    3 => 'Miércoles',
    4 => 'Jueves',
    5 => 'Viernes',
    6 => 'Sábado',
];

// Reorganizar los slots para construir la tabla
$grid = [];

foreach ($slots as $s) {
    $hi  = $s['hora_inicio'] ?? null;
    $hf  = $s['hora_fin'] ?? null;
    $dia = (int)($s['dia_semana'] ?? 0);

    if (!$hi || !$hf || $dia <= 0) {
        continue;
    }

    $key = $hi . '|' . $hf;

    if (!isset($grid[$key])) {
        $grid[$key] = [
            'meta' => [
                'inicio' => $hi,
                'fin'    => $hf,
            ],
            'dias' => [],
        ];
    }

    $grid[$key]['dias'][$dia] = $s;
}

// Ordenar por hora
uksort($grid, function ($a, $b) {
    [$aInicio,] = explode('|', $a);
    [$bInicio,] = explode('|', $b);
    return strcmp($aInicio, $bInicio);
});

// Paleta de colores por materia
$colorSchemes = [
    ['bg' => 'bg-blue-50 dark:bg-blue-900/20',    'border' => 'border-blue-500',    'text' => 'text-blue-800 dark:text-blue-300'],
    ['bg' => 'bg-purple-50 dark:bg-purple-900/20','border' => 'border-purple-500',  'text' => 'text-purple-800 dark:text-purple-300'],
    ['bg' => 'bg-green-50 dark:bg-green-900/20',  'border' => 'border-green-500',   'text' => 'text-green-800 dark:text-green-300'],
    ['bg' => 'bg-amber-50 dark:bg-amber-900/20',  'border' => 'border-amber-500',   'text' => 'text-amber-800 dark:text-amber-300'],
    ['bg' => 'bg-red-50 dark:bg-red-900/20',      'border' => 'border-red-500',     'text' => 'text-red-800 dark:text-red-300'],
    ['bg' => 'bg-indigo-50 dark:bg-indigo-900/20','border' => 'border-indigo-500',  'text' => 'text-indigo-800 dark:text-indigo-300'],
    ['bg' => 'bg-teal-50 dark:bg-teal-900/20',    'border' => 'border-teal-500',    'text' => 'text-teal-800 dark:text-teal-300'],
];

$materiaColorClasses = [];
$schemeCount = count($colorSchemes);

foreach ($materiasIndex as $mId => $mData) {
    $idx = $schemeCount > 0 ? ($mId % $schemeCount) : 0;
    $scheme = $colorSchemes[$idx];
    $materiaColorClasses[$mId] = $scheme['bg'] . ' ' . $scheme['border'] . ' ' . $scheme['text'];
}

?>
<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="calendar" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">
                    Horario generado · <?= $esc($grupo->codigo ?? 'Grupo') ?>
                </h2>
                <p class="opacity-90">
                    Revisa, ajusta manualmente y guarda el horario definitivo
                </p>
            </div>
        </div>
    </div>

    <!-- Barra de acciones -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-4 mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3" data-aos="fade-up">
        <div class="flex flex-col">
            <span class="text-sm text-gray-500 dark:text-gray-300">Grupo</span>
            <span class="text-lg font-semibold text-gray-800 dark:text-white">
                <?= $esc($grupo->codigo ?? '') ?>
                <?php if (!empty($grupo->titulo)): ?>
                    · <?= $esc($grupo->titulo) ?>
                <?php endif; ?>
            </span>
        </div>
        <div class="flex gap-3">
            <a href="/src/plataforma/app/admin/horarios/generar/<?= $esc($grupo->id) ?>"
               class="px-4 py-2 border border-indigo-600 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-neutral-700 rounded-lg text-sm font-medium flex items-center gap-2">
                <i data-feather="refresh-ccw" class="w-4 h-4"></i>
                Regenerar borrador
            </a>
        </div>
    </div>

    <!-- Layout: horario + panel lateral -->
    <div class="grid grid-cols-1 lg:grid-cols-[minmax(0,3.2fr)_minmax(0,1fr)] gap-6">
        <!-- Tabla de horario + formulario para guardar -->
        <form id="form-guardar-horario"
              action="/src/plataforma/app/admin/horarios/guardar/<?= $esc($grupo->id) ?>"
              method="POST"
              class="lg:col-span-1">

            <input type="hidden" name="slots_json" id="slots_json">

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

                        <?php if (empty($grid)): ?>
                            <tr>
                                <td colspan="<?= 1 + count($diasSemana) ?>" class="px-4 py-6 text-center text-gray-500 dark:text-gray-300 text-sm">
                                    No hay bloques generados para este grupo. Regresa y configura las horas por semana.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $filaIndex = 0;
                            foreach ($grid as $key => $info):
                                $filaIndex++;
                                $meta   = $info['meta'];
                                $dias   = $info['dias'];
                                $hiText = substr($meta['inicio'], 0, 5); // HH:MM
                                $hfText = substr($meta['fin'], 0, 5);   // HH:MM
                                $rowClass = $filaIndex % 2 === 0
                                    ? 'bg-gray-50 dark:bg-neutral-700/20'
                                    : '';
                                ?>
                                <tr class="<?= $rowClass ?>">
                                    <!-- Columna hora -->
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                        <?= $esc("$hiText - $hfText") ?>
                                    </td>

                                    <!-- Columnas por día -->
                                    <?php foreach ($diasSemana as $diaNum => $diaNombre): ?>
                                        <?php
                                        $slot = $dias[$diaNum] ?? null;

                                        if ($slot) {
                                            $materiaId = (int)$slot['materia_id'];
                                            $teacherId = !empty($slot['teacher_id']) ? (int)$slot['teacher_id'] : null;

                                            $materiaNombre = $materiasIndex[$materiaId]['nombre'] ?? ('Materia #' . $materiaId);
                                            $colorClass = $materiaColorClasses[$materiaId] ?? 'bg-blue-50 dark:bg-blue-900/20 border-blue-500 text-blue-800 dark:text-blue-300';
                                        }
                                        ?>
                                        <td class="px-4 py-3 text-center align-top droppable-slot"
                                            data-dia="<?= $esc($diaNum) ?>"
                                            data-hora-inicio="<?= $esc($meta['inicio']) ?>"
                                            data-hora-fin="<?= $esc($meta['fin']) ?>">

                                            <?php if ($slot): ?>
                                                <div class="inline-block text-left w-full max-w-[220px]">
                                                    <div class="rounded-lg p-2 border-l-4 mb-2 <?= $esc($colorClass ?? '') ?>" data-role="slot-card">
                                                        <h4 class="text-sm font-medium" data-role="materia-nombre">
                                                            <?= $esc($materiaNombre) ?>
                                                        </h4>
                                                        <p class="text-xs mt-1">
                                                            Docente:
                                                            <select class="mt-1 w-full rounded-md border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-900 px-2 py-1 text-xs text-gray-800 dark:text-gray-100"
                                                                    data-role="teacher-select">
                                                                <option value="">Sin docente</option>
                                                                <?php foreach ($teachersIndex as $tId => $tData): ?>
                                                                    <option value="<?= $esc($tId) ?>"
                                                                        <?= ($teacherId === (int)$tId) ? 'selected' : '' ?>>
                                                                        <?= $esc($tData['nombre'] ?? ('Docente #' . $tId)) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </p>
                                                        <input type="hidden" value="<?= $esc($materiaId) ?>" data-role="materia-id">
                                                    </div>
                                                    <button type="button"
                                                            class="mt-1 text-xs text-red-500 hover:text-red-600"
                                                            data-role="vaciar-celda">
                                                        Vaciar slot
                                                    </button>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-xs text-gray-400 dark:text-gray-500">
                                                    — Vacío —
                                                </div>
                                                <button type="button"
                                                        class="mt-1 text-xs text-indigo-500 hover:text-indigo-600"
                                                        data-role="agregar-slot">
                                                    Agregar clase
                                                </button>
                                                <div class="mt-2 hidden" data-role="nuevo-slot-form">
                                                    <div class="rounded-lg p-2 border border-dashed border-gray-300 dark:border-neutral-600">
                                                        <p class="text-xs text-gray-600 dark:text-gray-300 mb-1">
                                                            Selecciona materia y docente:
                                                        </p>
                                                        <select class="w-full mb-1 rounded-md border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-900 px-2 py-1 text-xs text-gray-800 dark:text-gray-100"
                                                                data-role="materia-select">
                                                            <option value="">Materia...</option>
                                                            <?php foreach ($materiasIndex as $mId => $mData): ?>
                                                                <option value="<?= $esc($mId) ?>">
                                                                    <?= $esc($mData['nombre'] ?? ('Materia #' . $mId)) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <select class="w-full mb-1 rounded-md border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-900 px-2 py-1 text-xs text-gray-800 dark:text-gray-100"
                                                                data-role="teacher-select-nuevo">
                                                            <option value="">Docente...</option>
                                                            <?php foreach ($teachersIndex as $tId => $tData): ?>
                                                                <option value="<?= $esc($tId) ?>">
                                                                    <?= $esc($tData['nombre'] ?? ('Docente #' . $tId)) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <button type="button"
                                                                class="w-full text-xs mt-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md py-1"
                                                                data-role="confirmar-nuevo-slot">
                                                            Confirmar
                                                        </button>
                                                    </div>
                                                </div>
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

            <!-- Botón guardar -->
            <div class="mt-6 flex justify-end" data-aos="fade-up" data-aos-delay="100">
                <button type="submit"
                        class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow-md text-sm font-semibold flex items-center gap-2">
                    <i data-feather="save" class="w-4 h-4"></i>
                    Guardar horario definitivo
                </button>
            </div>
        </form>

        <!-- Panel lateral de materias (sticky) -->
        <aside class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-4 h-fit lg:sticky lg:top-24 self-start max-h-[calc(100vh-7rem)] overflow-y-auto"
               data-aos="fade-left">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-3 flex items-center gap-2">
                <i data-feather="book-open" class="w-4 h-4"></i>
                Materias del grupo
            </h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                Arrastra una materia y suéltala sobre un slot del horario.
            </p>
            <div class="space-y-2">
                <?php foreach ($materiasIndex as $mId => $mData):
                    $defaultTeacherId = $materiaToTeacher[$mId] ?? null;
                    $docenteNombre = '';
                    if ($defaultTeacherId && isset($teachersIndex[$defaultTeacherId])) {
                        $docenteNombre = $teachersIndex[$defaultTeacherId]['nombre'] ?? '';
                    }
                    $colorClass = $materiaColorClasses[$mId] ?? '';
                ?>
                    <div class="cursor-move select-none rounded-lg border border-dashed border-gray-300 dark:border-neutral-600 px-3 py-2 text-sm bg-gray-50 dark:bg-neutral-900 flex flex-col gap-0.5"
                         draggable="true"
                         data-role="materia-draggable"
                         data-materia-id="<?= $esc($mId) ?>"
                         data-docente-id="<?= $defaultTeacherId ? $esc($defaultTeacherId) : '' ?>"
                         data-color-classes="<?= $esc($colorClass) ?>">
                        <span class="font-medium text-gray-800 dark:text-gray-100">
                            <?= $esc($mData['nombre'] ?? ('Materia #' . $mId)) ?>
                        </span>
                        <?php if ($docenteNombre): ?>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">
                                Docente: <?= $esc($docenteNombre) ?>
                            </span>
                        <?php endif; ?>
                        <span class="mt-1 inline-block h-1 w-10 rounded-full <?= $esc($colorClass) ?>"></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </aside>
    </div>
</div>

<!-- Template para tarjeta de slot (para drag & drop) -->
<template id="slot-card-template">
    <div class="inline-block text-left w-full max-w-[220px]">
        <div class="rounded-lg p-2 border-l-4 mb-2" data-role="slot-card">
            <h4 class="text-sm font-medium" data-role="materia-nombre"></h4>
            <p class="text-xs mt-1">
                Docente:
                <select class="mt-1 w-full rounded-md border border-gray-200 dark:border-neutral-600 bg-white dark:bg-neutral-900 px-2 py-1 text-xs text-gray-800 dark:text-gray-100"
                        data-role="teacher-select">
                    <option value="">Sin docente</option>
                    <?php foreach ($teachersIndex as $tId => $tData): ?>
                        <option value="<?= $esc($tId) ?>">
                            <?= $esc($tData['nombre'] ?? ('Docente #' . $tId)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <input type="hidden" data-role="materia-id">
        </div>
        <button type="button"
                class="mt-1 text-xs text-red-500 hover:text-red-600"
                data-role="vaciar-celda">
            Vaciar slot
        </button>
    </div>
</template>

<script>
    AOS.init();
    feather.replace();

    (function() {
        const form = document.getElementById('form-guardar-horario');
        const slotsJsonInput = document.getElementById('slots_json');
        const slotTemplate = document.getElementById('slot-card-template');

        /* ================== Drag & Drop ================== */

        // Inicio de arrastre desde panel lateral
        document.addEventListener('dragstart', function(e) {
            const card = e.target.closest('[data-role="materia-draggable"]');
            if (!card) return;

            const materiaId = card.getAttribute('data-materia-id');
            const docenteId = card.getAttribute('data-docente-id') || '';
            const colorClasses = card.getAttribute('data-color-classes') || '';

            const payload = {
                materia_id: materiaId ? parseInt(materiaId, 10) : null,
                teacher_id: docenteId ? parseInt(docenteId, 10) : null,
                materia_nombre: card.querySelector('span.font-medium')?.textContent.trim() || '',
                color_classes: colorClasses
            };

            e.dataTransfer.effectAllowed = 'copy';
            e.dataTransfer.setData('application/json', JSON.stringify(payload));
        });

        // Permitir soltar en los slots
        document.querySelectorAll('.droppable-slot').forEach(td => {
            td.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
                td.classList.add('ring-2', 'ring-indigo-400');
            });
            td.addEventListener('dragleave', function() {
                td.classList.remove('ring-2', 'ring-indigo-400');
            });
            td.addEventListener('drop', function(e) {
                e.preventDefault();
                td.classList.remove('ring-2', 'ring-indigo-400');

                const data = e.dataTransfer.getData('application/json');
                if (!data || !slotTemplate) return;

                let payload;
                try {
                    payload = JSON.parse(data);
                } catch (_) {
                    return;
                }
                if (!payload.materia_id) return;

                // Clonar template
                const clone = slotTemplate.content.cloneNode(true);
                const card = clone.querySelector('[data-role="slot-card"]');
                const materiaNombreEl = clone.querySelector('[data-role="materia-nombre"]');
                const materiaIdInput   = clone.querySelector('[data-role="materia-id"]');
                const teacherSelect    = clone.querySelector('[data-role="teacher-select"]');

                if (materiaNombreEl) materiaNombreEl.textContent = payload.materia_nombre || ('Materia #' + payload.materia_id);
                if (materiaIdInput)   materiaIdInput.value = payload.materia_id;

                if (teacherSelect) {
                    const tid = payload.teacher_id || '';
                    teacherSelect.value = tid ? String(tid) : '';
                }

                if (card && payload.color_classes) {
                    card.className += ' ' + payload.color_classes;
                }

                // Reemplazar contenido de la celda
                td.innerHTML = '';
                td.appendChild(clone);
            });
        });

        /* ================== Vaciar slot & agregar clase ================== */

        document.addEventListener('click', function(e) {
            // Vaciar slot
            const btnVaciar = e.target.closest('[data-role="vaciar-celda"]');
            if (btnVaciar) {
                const td = btnVaciar.closest('td');
                if (!td) return;
                td.innerHTML = `
                    <div class="text-xs text-gray-400 dark:text-gray-500">
                        — Vacío —
                    </div>
                    <button type="button"
                            class="mt-1 text-xs text-indigo-500 hover:text-indigo-600"
                            data-role="agregar-slot">
                        Agregar clase
                    </button>
                    <div class="mt-2 hidden" data-role="nuevo-slot-form">
                        <div class="rounded-lg p-2 border border-dashed border-gray-300 dark:border-neutral-600">
                            <p class="text-xs text-gray-600 dark:text-gray-300 mb-1">
                                Selecciona materia y docente:
                            </p>
                        </div>
                    </div>
                `;
                return;
            }

            // Mostrar formulario “Agregar clase” (manual, además del drag&drop)
            const btnAgregar = e.target.closest('[data-role="agregar-slot"]');
            if (btnAgregar) {
                const td = btnAgregar.closest('td');
                if (!td) return;
                const formNuevo = td.querySelector('[data-role="nuevo-slot-form"]');
                if (formNuevo) {
                    formNuevo.classList.toggle('hidden');
                }
                return;
            }
        });

        /* ================== Serializar al guardar ================== */

        form.addEventListener('submit', function() {
            const rows = [];
            const celdas = form.querySelectorAll('td[data-dia][data-hora-inicio][data-hora-fin]');

            celdas.forEach(td => {
                const dia = parseInt(td.getAttribute('data-dia'), 10);
                const hi  = td.getAttribute('data-hora-inicio');
                const hf  = td.getAttribute('data-hora-fin');

                const materiaInput = td.querySelector('[data-role="materia-id"]');
                const teacherSelect = td.querySelector('[data-role="teacher-select"]');

                if (materiaInput) {
                    const materiaId = parseInt(materiaInput.value, 10) || null;
                    const teacherId = teacherSelect ? (parseInt(teacherSelect.value, 10) || null) : null;

                    if (materiaId) {
                        rows.push({
                            dia_semana:  dia,
                            hora_inicio: hi,
                            hora_fin:    hf,
                            materia_id:  materiaId,
                            teacher_id:  teacherId,
                        });
                    }
                }
            });

            slotsJsonInput.value = JSON.stringify(rows);
        });
    })();
</script>
