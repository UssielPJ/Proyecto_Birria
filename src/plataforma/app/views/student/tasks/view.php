<?php
// Variables esperadas desde el controlador:
// $user, $task, $submission
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-full">
                    <i data-feather="file-text" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold"><?= htmlspecialchars($task->title) ?></h2>
                    <p class="opacity-90"><?= htmlspecialchars($task->course_name) ?> (<?= htmlspecialchars($task->course_code) ?>)</p>
                </div>
            </div>
            <a href="/src/plataforma/app/tareas" class="inline-flex items-center gap-2 rounded-lg bg-white/15 hover:bg-white/25 px-3 py-2 text-sm transition">
                <i data-feather="arrow-left" class="w-4 h-4"></i> Volver a tareas
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Detalles de la tarea -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6" data-aos="fade-up">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Descripción</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        <?= nl2br(htmlspecialchars($task->description ?? 'No hay descripción disponible.')) ?>
                    </p>
                </div>

                <?php if (!empty($task->file_path)): ?>
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Archivo adjunto</h3>
                        <a href="<?= htmlspecialchars($task->file_path) ?>" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-100 hover:bg-indigo-200 dark:bg-indigo-900 dark:hover:bg-indigo-800 text-indigo-700 dark:text-indigo-300 rounded-lg transition-colors">
                            <i data-feather="download" class="w-4 h-4"></i>
                            Descargar archivo
                        </a>
                    </div>
                <?php endif; ?>

                <?php if ($submission): ?>
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Tu entrega</h3>
                        <div class="bg-gray-50 dark:bg-neutral-700 rounded-lg p-4">
                            <div class="mb-3">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Fecha de entrega:</p>
                                <p class="text-gray-800 dark:text-gray-200"><?= date('d/m/Y H:i', strtotime($submission->submission_date)) ?></p>
                            </div>
                            <?php if (!empty($submission->comments)): ?>
                                <div class="mb-3">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Tus comentarios:</p>
                                    <p class="text-gray-800 dark:text-gray-200"><?= htmlspecialchars($submission->comments) ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($submission->file_path)): ?>
                                <div class="mb-3">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Archivo entregado:</p>
                                    <a href="<?= htmlspecialchars($submission->file_path) ?>" target="_blank" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        <i data-feather="paperclip" class="w-4 h-4"></i>
                                        Ver archivo
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($submission && isset($submission->grade)): ?>
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Calificación</h3>
                        <div class="bg-<?= $submission->grade >= 9 ? 'green' : ($submission->grade >= 7 ? 'blue' : 'orange') ?>-50 dark:bg-<?= $submission->grade >= 9 ? 'green' : ($submission->grade >= 7 ? 'blue' : 'orange') ?>-900/20 rounded-lg p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-3xl font-bold text-<?= $submission->grade >= 9 ? 'green' : ($submission->grade >= 7 ? 'blue' : 'orange') ?>-700 dark:text-<?= $submission->grade >= 9 ? 'green' : ($submission->grade >= 7 ? 'blue' : 'orange') ?>-300">
                                    <?= number_format($submission->grade, 1) ?>
                                </span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    <?= $submission->grade >= 9 ? 'Excelente' : ($submission->grade >= 7 ? 'Aprobado' : 'Necesita mejorar') ?>
                                </span>
                            </div>
                            <?php if (!empty($submission->feedback)): ?>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Retroalimentación:</p>
                                    <p class="text-gray-800 dark:text-gray-200"><?= htmlspecialchars($submission->feedback) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Información</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Profesor:</p>
                        <p class="text-gray-800 dark:text-gray-200"><?= htmlspecialchars($task->teacher_name) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de entrega:</p>
                        <p class="text-gray-800 dark:text-gray-200"><?= date('d/m/Y H:i', strtotime($task->due_at)) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de publicación:</p>
                        <p class="text-gray-800 dark:text-gray-200"><?= date('d/m/Y H:i', strtotime($task->created_at)) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Estado:</p>
                        <?php 
                        $now = new DateTime();
                        $dueDate = new DateTime($task->due_at);
                        $isOverdue = $now > $dueDate;
                        ?>
                        <?php if ($submission): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                Entregada
                            </span>
                        <?php elseif ($isOverdue): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                Vencida
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300">
                                Pendiente
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!$submission): ?>
                    <div class="mt-6">
                        <a href="/src/plataforma/app/tareas/submit/<?= $task->id ?>" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
                            <i data-feather="upload" class="w-4 h-4 mr-2"></i>
                            Entregar tarea
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    AOS.init();
    feather.replace();
</script>
