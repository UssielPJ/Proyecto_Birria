<?php
/** @var array $user */
/** @var array $groups */
/** @var array $subjects */
/** @var array $partials */
/** @var array $students */
/** @var array $activities */
/** @var array $currentFilter */
/** @var array $existingGrades */

$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

$selectedGroup   = $currentFilter['group_id']   ?? '';
$selectedSubject = $currentFilter['subject_id'] ?? '';
$selectedPartial = $currentFilter['partial_id'] ?? '';
?>

<div class="max-w-7xl mx-auto px-4 py-6">
    <!-- Encabezado -->
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">
                Calificaciones
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Selecciona grupo, materia y parcial para capturar o actualizar calificaciones.
            </p>
        </div>
        <div class="hidden md:flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700">
                <i data-feather="user" class="w-4 h-4"></i>
                <?= $esc($user['nombre'] ?? 'Docente') ?>
            </span>
        </div>
    </div>

    <!-- Barra de filtros -->
    <form
        method="get"
        action="/src/plataforma/app/teacher/grades"
        class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm px-4 py-4 md:px-6 md:py-5 mb-6"
    >
        <div class="flex flex-col md:flex-row md:items-end gap-4">
            <!-- Grupo -->
            <div class="w-full md:w-1/3">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">
                    Grupo
                </label>
                <select
                    name="group_id"
                    class="w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/60 text-slate-800 dark:text-slate-100 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">Selecciona un grupo</option>
                    <?php foreach ($groups as $g): ?>
                        <option value="<?= $esc($g['id']) ?>"
                            <?= (string)$selectedGroup === (string)$g['id'] ? 'selected' : '' ?>>
                            <?= $esc($g['nombre'] ?? ('Grupo '.$g['id'])) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Materia -->
            <div class="w-full md:w-1/3">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">
                    Materia
                </label>
                <select
                    name="subject_id"
                    class="w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/60 text-slate-800 dark:text-slate-100 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">Selecciona una materia</option>
                    <?php foreach ($subjects as $m): ?>
                        <option value="<?= $esc($m['id']) ?>"
                            <?= (string)$selectedSubject === (string)$m['id'] ? 'selected' : '' ?>>
                            <?= $esc($m['nombre'] ?? ('Materia '.$m['id'])) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Parcial -->
            <div class="w-full md:w-1/3">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">
                    Parcial
                </label>
                <select
                    name="partial_id"
                    class="w-full rounded-lg border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/60 text-slate-800 dark:text-slate-100 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="">Selecciona el parcial</option>
                    <?php foreach ($partials as $p): ?>
                        <option value="<?= $esc($p['id']) ?>"
                            <?= (string)$selectedPartial === (string)$p['id'] ? 'selected' : '' ?>>
                            <?= $esc($p['label'] ?? ('Parcial '.$p['id'])) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botón aplicar -->
            <div class="flex md:block">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center w-full md:w-auto px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium shadow-sm"
                >
                    <i data-feather="filter" class="w-4 h-4 mr-2"></i>
                    Aplicar filtros
                </button>
            </div>
        </div>
    </form>

    <!-- Zona de captura de calificaciones -->
    <?php if ($selectedGroup && $selectedSubject && $selectedPartial): ?>

        <?php if (!empty($students) && !empty($activities)): ?>
            <form
                method="post"
                action="/src/plataforma/app/teacher/grades/save"
                class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm overflow-hidden"
            >
                <!-- Filtros actuales como ocultos -->
                <input type="hidden" name="group_id" value="<?= $esc($selectedGroup) ?>">
                <input type="hidden" name="subject_id" value="<?= $esc($selectedSubject) ?>">
                <input type="hidden" name="partial_id" value="<?= $esc($selectedPartial) ?>">

                <div class="px-4 py-3 md:px-6 md:py-4 border-b border-slate-200 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-2">
                    <div>
                        <h2 class="text-sm font-semibold text-slate-800 dark:text-slate-100">
                            Captura de calificaciones
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Ingresa las calificaciones de cada estudiante por actividad. Deja en blanco lo que no quieras modificar.
                        </p>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-800">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Edición en lote
                        </span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs md:text-sm">
                        <thead class="bg-slate-50 dark:bg-slate-900/70 border-b border-slate-200 dark:border-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500 uppercase tracking-wide text-[0.65rem] md:text-xs sticky left-0 bg-slate-50 dark:bg-slate-900/70 z-10">
                                    Estudiante
                                </th>
                                <?php foreach ($activities as $act): ?>
                                    <th class="px-3 py-3 text-center font-semibold text-slate-500 uppercase tracking-wide text-[0.65rem] md:text-xs whitespace-nowrap">
                                        <?= $esc($act['nombre'] ?? 'Actividad') ?>
                                        <?php if (isset($act['peso'])): ?>
                                            <span class="block text-[0.6rem] text-slate-400">
                                                Peso: <?= $esc($act['peso']) ?>%
                                            </span>
                                        <?php endif; ?>
                                    </th>
                                <?php endforeach; ?>
                                <th class="px-3 py-3 text-center font-semibold text-slate-500 uppercase tracking-wide text-[0.65rem] md:text-xs whitespace-nowrap">
                                    Promedio (vista previa)
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            <?php foreach ($students as $stu):
                                $stuId = $stu['id'];
                            ?>
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-900/60" data-student-row="<?= $esc($stuId) ?>">
                                    <!-- Nombre estudiante -->
                                    <td class="px-4 py-3 sticky left-0 bg-white dark:bg-slate-900 z-10 align-middle">
                                        <div class="flex flex-col">
                                            <span class="font-medium text-slate-800 dark:text-slate-100">
                                                <?= $esc($stu['nombre'] ?? 'Estudiante') ?>
                                            </span>
                                            <span class="text-[0.7rem] text-slate-400">
                                                <?= $esc($stu['matricula'] ?? '') ?>
                                            </span>
                                        </div>
                                        <input type="hidden" name="students[]" value="<?= $esc($stuId) ?>">
                                    </td>

                                    <!-- Inputs por actividad -->
                                    <?php foreach ($activities as $act):
                                        $actId = $act['id'];
                                        $weight = isset($act['peso']) ? (float)$act['peso'] : 0;
                                        $gradeValue = $existingGrades[$stuId][$actId]['grade'] ?? '';
                                    ?>
                                        <td class="px-3 py-2 text-center align-middle">
                                            <input
                                                type="number"
                                                name="grades[<?= $esc($stuId) ?>][<?= $esc($actId) ?>]"
                                                value="<?= $gradeValue !== '' ? $esc(number_format((float)$gradeValue, 2, '.', '')) : '' ?>"
                                                step="0.01"
                                                min="0"
                                                max="100"
                                                data-grade-input="1"
                                                data-weight="<?= $esc($weight) ?>"
                                                class="w-20 md:w-24 px-2 py-1 rounded-md border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/70 text-slate-800 dark:text-slate-100 text-xs md:text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-center"
                                            >
                                        </td>
                                    <?php endforeach; ?>

                                    <!-- Columna de promedio (vista previa) -->
                                    <td class="px-3 py-2 text-center align-middle">
                                        <span
                                            class="inline-flex items-center justify-center px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-[0.7rem] md:text-xs"
                                            data-average-badge="1"
                                        >
                                            —
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Footer del formulario -->
                <div class="px-4 py-3 md:px-6 md:py-4 border-t border-slate-200 dark:border-slate-800 flex flex-col md:flex-row items-center justify-between gap-3">
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Tip: Puedes dejar en blanco las celdas que no quieras modificar. El sistema solo actualizará los campos con un valor válido.
                    </p>
                    <div class="flex items-center gap-2">
                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium shadow-sm"
                        >
                            <i data-feather="save" class="w-4 h-4 mr-2"></i>
                            Guardar calificaciones
                        </button>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <div class="bg-white dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-700 rounded-xl p-6 text-center text-sm text-slate-500 dark:text-slate-400">
                <i data-feather="info" class="w-6 h-6 mx-auto mb-2 text-slate-400"></i>
                <p>No se encontraron estudiantes o actividades para los filtros seleccionados.</p>
                <p class="text-xs mt-1">
                    Verifica que el grupo tenga estudiantes inscritos y que existan actividades configuradas para esta materia y parcial.
                </p>
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="bg-white dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-700 rounded-xl p-6 text-center text-sm text-slate-500 dark:text-slate-400">
            <i data-feather="sliders" class="w-6 h-6 mx-auto mb-2 text-slate-400"></i>
            <p>Selecciona un grupo, materia y parcial en la barra superior para comenzar a capturar calificaciones.</p>
        </div>
    <?php endif; ?>
</div>

<?php if (!empty($students) && !empty($activities)): ?>
<script>
// Calcula el promedio por fila usando pesos si existen
(function () {
    function calcularPromedioFila(tr) {
        const inputs = tr.querySelectorAll('input[data-grade-input]');
        let sumaPonderada = 0;
        let sumaPesos = 0;
        let sumaSimple = 0;
        let conteoSimple = 0;

        inputs.forEach(function (inp) {
            const raw = inp.value.trim();
            if (!raw) return;

            const val = parseFloat(raw.replace(',', '.'));
            if (isNaN(val)) return;

            const peso = parseFloat(inp.getAttribute('data-weight') || '0');

            // Para promedio simple
            sumaSimple += val;
            conteoSimple++;

            // Para promedio ponderado
            if (!isNaN(peso) && peso > 0) {
                sumaPonderada += val * peso;
                sumaPesos += peso;
            }
        });

        const badge = tr.querySelector('[data-average-badge]');
        if (!badge) return;

        if (conteoSimple === 0) {
            badge.textContent = '—';
            return;
        }

        let promedio;
        if (sumaPesos > 0) {
            promedio = sumaPonderada / sumaPesos;
        } else {
            promedio = sumaSimple / conteoSimple;
        }

        badge.textContent = promedio.toFixed(2);
    }

    function recalcularTodos() {
        document.querySelectorAll('tr[data-student-row]').forEach(calcularPromedioFila);
    }

    // Recalcular al cargar
    document.addEventListener('DOMContentLoaded', recalcularTodos);

    // Escuchar cambios en inputs
    document.addEventListener('input', function (e) {
        const inp = e.target;
        if (!inp.matches('input[data-grade-input]')) return;

        const tr = inp.closest('tr[data-student-row]');
        if (!tr) return;
        calcularPromedioFila(tr);
    });
})();
</script>
<?php endif; ?>
