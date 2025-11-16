<?php
// app/views/admin/horarios/configurar_horas.php
/** @var object $grupo */
/** @var array  $materiasGrupo */

$esc = function ($v) {
    if ($v === null) {
        $v = '';
    }
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
};

// Errores de generación previa (si los hubiera)
$errores = [];
if (isset($_SESSION) && isset($grupo->id)) {
    $grupoId    = (int)$grupo->id;
    $erroresKey = 'horarios_errores_' . $grupoId;
    if (!empty($_SESSION[$erroresKey]) && is_array($_SESSION[$erroresKey])) {
        $errores = $_SESSION[$erroresKey];
        unset($_SESSION[$erroresKey]);
    }
}
?>

<div class="py-8 max-w-5xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-xl p-6 text-white mb-8">
        <h2 class="text-2xl font-bold mb-1">
            Configurar horas por semana · <?= $esc(isset($grupo->codigo) ? $grupo->codigo : 'Grupo') ?>
        </h2>
        <?php if (!empty($grupo->titulo)): ?>
            <p class="opacity-90 text-sm mb-1"><?= $esc($grupo->titulo) ?></p>
        <?php endif; ?>
        <p class="opacity-80 text-sm">
            Asigna cuántas horas a la semana tendrá cada materia de este grupo.
            Después podrás generar el horario automático.
        </p>
    </div>

    <?php if (!empty($errores)): ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg p-4 dark:bg-red-900/20 dark:border-red-700 dark:text-red-100">
            <p class="font-semibold mb-2">Revisa lo siguiente antes de generar el horario:</p>
            <ul class="list-disc pl-5 space-y-1">
                <?php foreach ($errores as $e): ?>
                    <li><?= $esc($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (empty($materiasGrupo)): ?>
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow p-6 text-center text-gray-600 dark:text-gray-300">
            Este grupo no tiene materias asignadas. Primero asigna materias a este grupo.
        </div>
    <?php else: ?>

        <form action="/src/plataforma/app/admin/horarios/guardar-horas/<?= $esc($grupo->id) ?>"
              method="POST"
              class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 space-y-4">

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                    Materias del grupo
                </h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Deja vacío si aún no quieres contar esa materia en el horario.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                    <tr class="bg-gray-50 dark:bg-neutral-700/60">
                        <th class="px-4 py-2 text-left font-medium text-gray-600 dark:text-gray-200">Clave</th>
                        <th class="px-4 py-2 text-left font-medium text-gray-600 dark:text-gray-200">Materia</th>
                        <th class="px-4 py-2 text-center font-medium text-gray-600 dark:text-gray-200">Horas / semana</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    <?php foreach ($materiasGrupo as $mg): ?>
                        <?php
                        $mgId        = (int)$mg->mg_id;
                        $clave       = isset($mg->materia_clave) ? $mg->materia_clave : '';
                        $nombre      = isset($mg->materia_nombre) ? $mg->materia_nombre : '';
                        $horasSemana = $mg->horas_semana !== null ? (int)$mg->horas_semana : '';
                        ?>
                        <tr class="hover:bg-gray-50/70 dark:hover:bg-neutral-700/40">
                            <td class="px-4 py-2 text-gray-700 dark:text-gray-100 whitespace-nowrap">
                                <?= $esc($clave) ?>
                            </td>
                            <td class="px-4 py-2 text-gray-800 dark:text-gray-50">
                                <?= $esc($nombre) ?>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <input
                                    type="number"
                                    min="0"
                                    max="40"
                                    name="horas[<?= $esc($mgId) ?>]"
                                    value="<?= $esc($horasSemana) ?>"
                                    class="w-24 mx-auto rounded-md border border-gray-300 dark:border-neutral-600 bg-white dark:bg-neutral-900 px-2 py-1 text-center text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="0">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-neutral-700">
                <a href="/src/plataforma/app/admin/horarios"
                   class="text-xs md:text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    ← Volver a lista de grupos
                </a>

                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow">
                    <i data-feather="play-circle" class="w-4 h-4"></i>
                    Guardar horas y generar horario
                </button>
            </div>
        </form>

    <?php endif; ?>
</div>

<script>
    feather.replace();
</script>
