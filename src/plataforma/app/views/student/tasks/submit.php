<?php
/** @var object $task */
/** @var ?object $submission */
/** @var int $attemptsUsed */
/** @var int $maxAttempts */

$esc = fn($v)=>htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

$isResubmission = !empty($submission);
$passGrade      = 7.0;
$lastGrade      = $submission->grade ?? null;
?>

<div class="py-8 max-w-5xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white mb-8 shadow-xl" data-aos="fade-up">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="p-3 bg-white/20 rounded-full">
                    <i data-feather="upload-cloud" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-1">
                        <?= $isResubmission ? 'Reenviar tarea' : 'Entregar tarea' ?>
                    </h2>
                    <p class="opacity-90">
                        <?= $esc($task->title) ?> ·
                        <?= $esc($task->course_name) ?> (<?= $esc($task->course_code) ?>)
                    </p>
                    <div class="flex flex-wrap gap-2 mt-2 text-xs">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-white/10 text-white">
                            Intentos usados: <?= (int)$attemptsUsed ?> / <?= (int)$maxAttempts ?>
                        </span>
                        <?php if ($lastGrade !== null): ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-white/10 text-white">
                                Última calificación: <?= number_format((float)$lastGrade, 1) ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($task->due_at)): ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-white/10 text-white">
                                Vence: <?= date('d/m/Y H:i', strtotime($task->due_at)) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <a href="/src/plataforma/app/tareas/view/<?= (int)$task->id ?>"
               class="inline-flex items-center gap-2 rounded-lg bg-white/15 hover:bg-white/25 px-3 py-2 text-sm transition">
                <i data-feather="arrow-left" class="w-4 h-4"></i> Volver a la actividad
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 space-y-6" data-aos="fade-up">

        <!-- Tarjeta de la actividad -->
        <div class="bg-slate-900/5 dark:bg-slate-700/40 rounded-xl p-4 flex flex-col gap-1">
            <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">
                <?= $esc($task->title) ?>
            </p>
            <?php if (!empty($task->description)): ?>
                <p class="text-xs text-slate-600 dark:text-slate-300">
                    <?= nl2br($esc($task->description)) ?>
                </p>
            <?php endif; ?>
            <?php if (!empty($task->file_path)): ?>
                <div class="mt-2">
                    <p class="text-xs text-slate-500 dark:text-slate-300 mb-1">
                        Archivo que el profesor adjuntó:
                    </p>
                    <a href="<?= $esc($task->file_path) ?>" target="_blank"
                       class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-indigo-100 hover:bg-indigo-200 text-indigo-700 text-xs font-medium dark:bg-indigo-900 dark:hover:bg-indigo-800 dark:text-indigo-200">
                        <i data-feather="download" class="w-4 h-4"></i>
                        Descargar archivo de instrucciones
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Si ya había entrega, mostrar resumen -->
        <?php if ($isResubmission): ?>
            <div class="bg-slate-50 dark:bg-neutral-700 rounded-xl p-4 border border-slate-200 dark:border-neutral-600">
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-2">
                    Tu último envío
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-300 mb-1">
                    Fecha de entrega: <?= date('d/m/Y H:i', strtotime($submission->created_at ?? 'now')) ?>
                </p>

                <?php if (!empty($submission->file_path)): ?>
                    <p class="text-xs text-slate-500 dark:text-slate-300 mb-1">
                        Archivo entregado:
                        <a href="<?= $esc($submission->file_path) ?>" target="_blank"
                           class="inline-flex items-center gap-1 text-indigo-600 dark:text-indigo-300 hover:underline">
                            <i data-feather="paperclip" class="w-4 h-4"></i> Ver archivo
                        </a>
                    </p>
                <?php endif; ?>

                <?php if ($lastGrade !== null): ?>
                    <p class="text-xs text-slate-500 dark:text-slate-300 mb-1">
                        Calificación anterior:
                        <span class="font-semibold"><?= number_format((float)$lastGrade, 1) ?></span>
                    </p>
                <?php endif; ?>

                <?php if (!empty($submission->feedback)): ?>
                    <p class="text-xs text-slate-500 dark:text-slate-300 mb-1">
                        Retroalimentación del profesor:
                    </p>
                    <p class="text-xs text-slate-700 dark:text-slate-100">
                        <?= $esc($submission->feedback) ?>
                    </p>
                <?php endif; ?>

                <p class="mt-3 text-xs text-amber-600 dark:text-amber-300">
                    Si seleccionas un nuevo archivo y envías de nuevo, esta reentrega contará como
                    <strong>un intento adicional</strong> y se tomará en cuenta la nueva calificación.
                </p>
            </div>
        <?php endif; ?>

        <!-- Formulario de entrega / reentrega -->
        <form action="/src/plataforma/app/tareas/submit/<?= (int)$task->id ?>"
              method="post"
              enctype="multipart/form-data"
              class="space-y-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
                    Comentarios (opcional)
                </label>
                <textarea name="comments"
                          rows="3"
                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm
                                 focus:outline-none focus:ring-2 focus:ring-indigo-500
                                 dark:bg-neutral-700 dark:text-white"
                          placeholder="Añade cualquier comentario o nota para tu profesor..."></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                    <?= $isResubmission ? 'Reemplazar archivo' : 'Archivo (opcional)' ?>
                </label>

                <div class="border-2 border-dashed rounded-xl px-4 py-6 text-center
                            border-gray-300 dark:border-gray-600
                            bg-gray-50 dark:bg-neutral-800">
                    <input type="file"
                           name="file"
                           class="w-full text-sm text-gray-600 dark:text-gray-200
                                  file:mr-3 file:py-2 file:px-3
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100">
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Puedes seleccionar un nuevo archivo para <?= $isResubmission ? 'reemplazar tu entrega anterior' : 'subir tu tarea' ?>.
                        Tamaño máximo aproximado: 10MB.
                    </p>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="/src/plataforma/app/tareas/view/<?= (int)$task->id ?>"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600
                          rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300
                          bg-white dark:bg-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-600
                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm
                               text-sm font-medium text-white
                               <?= $isResubmission ? 'bg-amber-600 hover:bg-amber-700' : 'bg-indigo-600 hover:bg-indigo-700' ?>
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i data-feather="<?= $isResubmission ? 'repeat' : 'send' ?>" class="w-4 h-4 mr-2"></i>
                    <?= $isResubmission ? 'Reenviar tarea' : 'Entregar tarea' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    AOS.init();
    feather.replace();
</script>
