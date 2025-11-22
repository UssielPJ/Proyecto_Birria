<?php
/** @var array $grades */
/** @var array $stats */
/** @var array|null $subjects */
/** @var array|null $partials */
/** @var array|null $activityTypes */
/** @var array|null $studentInfo */
/** @var array $partialWeightedMatrix */
/** @var array $summarySubjectsOrder */
/** @var float|null $filteredAverage */
/** @var int $filteredCount */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user        = $_SESSION['user'] ?? [];
$studentInfo = $studentInfo ?? [];

$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

// Filtros seleccionados (GET)
$selectedSubjectId  = $_GET['subject_id']    ?? '';
$selectedPartial    = $_GET['partial']       ?? '';
$selectedActivity   = $_GET['activity_type'] ?? '';

$subjects      = $subjects      ?? [];
$partials      = $partials      ?? [];
$activityTypes = $activityTypes ?? [];

$filteredAverage = $filteredAverage ?? null;
$filteredCount   = $filteredCount   ?? 0;

// ===== Campos dinámicos del encabezado =====
$matricula = $studentInfo['matricula']
    ?? $studentInfo['matricula_uts']
    ?? ($user['matricula'] ?? $user['username'] ?? '—');

$career = $studentInfo['career_name']
    ?? $studentInfo['carrera']
    ?? $studentInfo['career']
    ?? ($user['career'] ?? $user['carrera'] ?? '—');

$groupName = $studentInfo['group_name']
    ?? $studentInfo['grupo']
    ?? $studentInfo['grupo_id']
    ?? $studentInfo['group_id']
    ?? ($user['group_name'] ?? $user['grupo'] ?? '—');

$status = $studentInfo['status'] ?? ($user['status'] ?? 'ACTIVO');
?>
<div class="max-w-6xl mx-auto px-4 py-6 space-y-6">

    <!-- BLOQUE: Datos del alumno -->
    <div class="rounded-xl border border-emerald-600/30 bg-white/80 dark:bg-slate-950/70 overflow-hidden shadow-lg shadow-emerald-900/30">
        <div class="bg-gradient-to-r from-emerald-700 via-emerald-600 to-emerald-500 px-4 py-2 flex items-center justify-between">
            <h2 class="text-xs md:text-sm font-semibold tracking-wide text-emerald-50">
                DATOS GENERALES DEL ALUMNO
            </h2>
            <span class="text-[11px] text-emerald-100/80">
                Actualizado: <?= $esc(date('d/m/Y H:i')) ?>
            </span>
        </div>

        <div class="px-4 py-3 grid gap-2 md:grid-cols-2 text-xs md:text-sm text-slate-900 dark:text-slate-100 bg-slate-50/80 dark:bg-slate-900/60">
            <div>
                <span class="font-semibold">Matrícula:</span>
                <span class="ml-1 text-emerald-700 dark:text-emerald-200">
                    <?= $esc($matricula) ?>
                </span>
            </div>
            <div>
                <span class="font-semibold">Nombre:</span>
                <span class="ml-1">
                    <?= $esc($user['name'] ?? $user['nombre'] ?? '—') ?>
                </span>
            </div>
        </div>

        <div class="bg-slate-100/90 dark:bg-slate-900/90 border-t border-emerald-500/40 px-4 py-2">
            <h3 class="text-[11px] md:text-xs font-semibold tracking-wide text-emerald-800 dark:text-emerald-100">
                DATOS ACADÉMICOS
            </h3>
        </div>

        <div class="px-4 py-3 grid gap-2 md:grid-cols-3 text-xs md:text-sm text-slate-900 dark:text-slate-100 bg-slate-50/80 dark:bg-slate-950/60">
            <div>
                <span class="font-semibold">Carrera:</span>
                <span class="ml-1 text-slate-700 dark:text-slate-200">
                    <?= $esc($career) ?>
                </span>
            </div>
            <div>
                <span class="font-semibold">Grupo:</span>
                <span class="ml-1 text-slate-700 dark:text-slate-200">
                    <?= $esc($groupName) ?>
                </span>
            </div>
            <div>
                <span class="font-semibold">Situación:</span>
                <span class="ml-1 text-emerald-700 dark:text-emerald-300">
                    <?= $esc($status) ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Tarjetas de resumen -->
    <div class="grid gap-4 grid-cols-1 md:grid-cols-3">
        <div class="rounded-xl border border-emerald-500/40 bg-emerald-50 dark:bg-emerald-900/40 px-4 py-3 text-emerald-900 dark:text-emerald-50 shadow-sm shadow-emerald-900/40">
            <p class="text-xs uppercase tracking-wide opacity-80">Promedio general</p>
            <p class="mt-1 text-2xl font-semibold">
                <?= $esc(number_format($stats['average_grade'] ?? 0, 1)) ?>
            </p>
        </div>

        <div class="rounded-xl border border-sky-500/40 bg-sky-50 dark:bg-sky-900/40 px-4 py-3 text-sky-900 dark:text-sky-50 shadow-sm shadow-sky-900/40">
            <p class="text-xs uppercase tracking-wide opacity-80">Calificaciones registradas</p>
            <p class="mt-1 text-2xl font-semibold">
                <?= $esc($stats['total_grades'] ?? 0) ?>
            </p>
        </div>

        <div class="rounded-xl border border-indigo-500/40 bg-indigo-50 dark:bg-indigo-900/40 px-4 py-3 text-indigo-900 dark:text-indigo-50 shadow-sm shadow-indigo-900/40">
            <p class="text-xs uppercase tracking-wide opacity-80">Última actualización</p>
            <p class="mt-1 text-sm">
                <?= $esc(date('d/m/Y H:i')) ?>
            </p>
        </div>
    </div>

    <!-- TABLA: Resumen por materia y parcial -->
    <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-950/80 overflow-hidden shadow-md shadow-slate-950/40">
        <div class="bg-slate-100 dark:bg-slate-900/90 border-b border-slate-200 dark:border-slate-700 px-4 py-3 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                Resumen por materia y parcial
            </h2>
            <span class="text-[11px] text-slate-500 dark:text-slate-400">
                Promedio por parcial y calificación final de cada materia
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-xs md:text-sm text-slate-900 dark:text-slate-100">
                <thead class="bg-slate-100 dark:bg-slate-900/90 text-[11px] md:text-xs uppercase text-slate-500 dark:text-slate-400">
                    <tr>
                        <th class="px-4 py-3 text-left border-b border-slate-200 dark:border-slate-800">Materia</th>
                        <th class="px-3 py-3 text-center border-b border-slate-200 dark:border-slate-800">Parcial 1</th>
                        <th class="px-3 py-3 text-center border-b border-slate-200 dark:border-slate-800">Parcial 2</th>
                        <th class="px-3 py-3 text-center border-b border-slate-200 dark:border-slate-800">Parcial 3</th>
                        <th class="px-3 py-3 text-center border-b border-slate-200 dark:border-slate-800">Cal. final</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($summarySubjectsOrder)): ?>
                        <?php
                        $fmt = function($v) use ($esc) {
                            return $v === null ? '—' : $esc(number_format($v, 1));
                        };

                        $getPartialVal = function(array $row, int $parcialNumero) {
                            foreach ($row as $k => $val) {
                                if ((int)$k === $parcialNumero) {
                                    return $val;
                                }
                            }
                            return null;
                        };
                        ?>
                        <?php foreach ($summarySubjectsOrder as $subjectName): ?>
                            <?php
                                $row = $partialWeightedMatrix[$subjectName] ?? [];

                                $p1  = $getPartialVal($row, 1);
                                $p2  = $getPartialVal($row, 2);
                                $p3  = $getPartialVal($row, 3);

                                $vals  = array_filter([$p1, $p2, $p3], fn($v) => $v !== null);
                                $final = !empty($vals) ? array_sum($vals) / count($vals) : null;
                            ?>
                            <tr class="border-t border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900/60">
                                <td class="px-4 py-2">
                                    <?= $esc($subjectName) ?>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <?= $fmt($p1) ?>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <?= $fmt($p2) ?>
                                </td>
                                <td class="px-3 py-2 text-center">
                                    <?= $fmt($p3) ?>
                                </td>
                                <td class="px-3 py-2 text-center font-semibold text-emerald-700 dark:text-emerald-300">
                                    <?= $fmt($final) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400">
                                Aún no hay información suficiente para generar el resumen por materia y parcial.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
    /* ===== Etiquetas legibles para la parte de abajo ===== */

    // Materia seleccionada
    $subjectLabel = 'Todas las materias';
    if ($selectedSubjectId !== '') {
        foreach ($subjects as $s) {
            $id = is_array($s) ? ($s['id'] ?? null) : ($s->id ?? null);
            $name = is_array($s)
                ? ($s['name'] ?? $s['materia'] ?? $s['nombre'] ?? '')
                : ($s->name ?? $s->materia ?? $s->nombre ?? '');
            if ($id !== null && (string)$id === (string)$selectedSubjectId) {
                $subjectLabel = $name;
                break;
            }
        }
    }

    // Parcial seleccionado
    $partialLabel = 'Todos';
    if ($selectedPartial !== '') {
        foreach ($partials as $p) {
            $value = is_array($p) ? ($p['value'] ?? $p['id'] ?? '') : ($p->value ?? $p->id ?? '');
            $label = is_array($p) ? ($p['label'] ?? $p['nombre'] ?? $value) : ($p->label ?? $p->nombre ?? $value);
            if ((string)$value === (string)$selectedPartial) {
                $partialLabel = $label;
                break;
            }
        }
    }

    // Apartado seleccionado
    $activityLabel = 'Todos';
    if ($selectedActivity !== '') {
        foreach ($activityTypes as $t) {
            $value = is_array($t) ? ($t['slug'] ?? $t['id'] ?? '') : ($t->slug ?? $t->id ?? '');
            $label = is_array($t) ? ($t['label'] ?? $t['nombre'] ?? $value) : ($t->label ?? $t->nombre ?? $value);
            if ((string)$value === (string)$selectedActivity) {
                $activityLabel = $label;
                break;
            }
        }
    }
    ?>

    <!-- BLOQUE: Calificación detallada (filtros + promedio único) -->
    <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-950/80 overflow-hidden shadow-lg shadow-slate-950/40">

        <!-- Encabezado interno -->
        <div class="bg-slate-100 dark:bg-slate-900/90 border-b border-slate-200 dark:border-slate-700 px-4 py-3 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                Calificación detallada
            </h2>
            <span class="text-[11px] text-slate-500 dark:text-slate-400">
                Promedio por materia, parcial y apartado
            </span>
        </div>

        <!-- Filtros -->
        <form
            method="GET"
            class="px-4 py-4 space-y-3 md:space-y-0 md:flex md:items-end md:gap-4 border-b border-slate-200 dark:border-slate-800"
            id="filters-form"
        >
            <!-- Materia -->
            <div class="flex-1">
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Materia
                </label>
                <select
                    name="subject_id"
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-950 px-3 py-2 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                >
                    <option value="">Todas las materias</option>
                    <?php if (!empty($subjects)): ?>
                        <?php foreach ($subjects as $subject): ?>
                            <?php
                                $id   = is_array($subject) ? ($subject['id'] ?? '') : ($subject->id ?? '');
                                $name = is_array($subject)
                                    ? ($subject['name'] ?? $subject['materia'] ?? $subject['nombre'] ?? '')
                                    : ($subject->name ?? $subject->materia ?? $subject->nombre ?? '');
                            ?>
                            <option value="<?= $esc($id) ?>" <?= ($selectedSubjectId == $id ? 'selected' : '') ?>>
                                <?= $esc($name) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Parcial -->
            <div class="w-full md:w-40">
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Parcial
                </label>
            <select
                    name="partial"
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-950 px-3 py-2 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                >
                    <option value="">Todos</option>
                    <?php if (!empty($partials)): ?>
                        <?php foreach ($partials as $p): ?>
                            <?php
                                $value = is_array($p) ? ($p['value'] ?? $p['id'] ?? '') : ($p->value ?? $p->id ?? '');
                                $label = is_array($p) ? ($p['label'] ?? $p['nombre'] ?? $value) : ($p->label ?? $p->nombre ?? $value);
                            ?>
                            <option value="<?= $esc($value) ?>" <?= ($selectedPartial == $value ? 'selected' : '') ?>>
                                <?= $esc($label) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="1" <?= ($selectedPartial === '1' ? 'selected' : '') ?>>Parcial 1</option>
                        <option value="2" <?= ($selectedPartial === '2' ? 'selected' : '') ?>>Parcial 2</option>
                        <option value="3" <?= ($selectedPartial === '3' ? 'selected' : '') ?>>Parcial 3</option>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Apartado -->
            <div class="w-full md:w-48">
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Apartado
                </label>
                <select
                    name="activity_type"
                    class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-950 px-3 py-2 text-sm text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                >
                    <option value="">Todos</option>
                    <?php if (!empty($activityTypes)): ?>
                        <?php foreach ($activityTypes as $t): ?>
                            <?php
                                $value = is_array($t) ? ($t['slug'] ?? $t['id'] ?? '') : ($t->slug ?? $t->id ?? '');
                                $label = is_array($t) ? ($t['label'] ?? $t['nombre'] ?? $value) : ($t->label ?? $t->nombre ?? $value);
                            ?>
                            <option value="<?= $esc($value) ?>" <?= ($selectedActivity == $value ? 'selected' : '') ?>>
                                <?= $esc($label) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="tarea"      <?= ($selectedActivity === 'tarea' ? 'selected' : '') ?>>Tareas</option>
                        <option value="examen"     <?= ($selectedActivity === 'examen' ? 'selected' : '') ?>>Exámenes</option>
                        <option value="proyecto"   <?= ($selectedActivity === 'proyecto' ? 'selected' : '') ?>>Proyectos</option>
                        <option value="asistencia" <?= ($selectedActivity === 'asistencia' ? 'selected' : '') ?>>Asistencia</option>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Botón -->
            <div class="w-full md:w-auto">
                <button
                    type="submit"
                    class="mt-2 md:mt-0 inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                >
                    Aplicar filtros
                </button>
            </div>
        </form>

        <!-- Tabla detallada: solo un promedio -->
                <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-slate-900 dark:text-slate-100">
                <thead class="bg-slate-100 dark:bg-slate-900/80 text-xs uppercase text-slate-500 dark:text-slate-400">
                    <tr>
                        <th class="px-4 py-3 text-left">Materia</th>
                        <th class="px-4 py-3 text-center">Parcial</th>
                        <th class="px-4 py-3 text-center">Apartado</th>
                        <th class="px-4 py-3 text-center">Promedio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($filteredAverages)): ?>
                        <?php foreach ($filteredAverages as $row): ?>
                            <?php $r = is_array($row) ? $row : (array)$row; ?>
                            <tr class="border-t border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900/60">
                                <td class="px-4 py-2">
                                    <?= $esc($r['subject_name'] ?? '') ?>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <?= $esc($r['parcial'] ?? '') ?>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <?= $esc($r['activity_type_label'] ?? '-') ?>
                                </td>
                                <td class="px-4 py-2 text-center font-semibold">
                                    <?= isset($r['promedio'])
                                        ? $esc(number_format((float)$r['promedio'], 1))
                                        : '—'
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400">
                                Aún no hay calificaciones con los filtros seleccionados.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
// Auto-submit al cambiar filtros
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filters-form');
    if (!form) return;

    const selects = form.querySelectorAll('select[name="subject_id"], select[name="partial"], select[name="activity_type"]');
    selects.forEach(sel => {
        sel.addEventListener('change', () => form.submit());
    });
});
</script>
