<?php
// Variables esperadas desde el controlador:
// $user, $tasks
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="check-circle" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Tareas Entregadas</h2>
                <p class="opacity-90">Estas son las tareas que ya has entregado</p>
            </div>
        </div>
    </div>

    <!-- Lista de tareas entregadas -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6" data-aos="fade-up">
        <?php if (!empty($tasks)): ?>
            <div class="space-y-4">
                <?php foreach ($tasks as $task): 
                    $hasGrade = isset($task->grade) && $task->grade !== null;
                    $isExcellent = $hasGrade && $task->grade >= 9;
                    $isGood = $hasGrade && $task->grade >= 7 && $task->grade < 9;
                    $isRegular = $hasGrade && $task->grade < 7;
                ?>
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-5 hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mr-3">
                                        <?= htmlspecialchars($task->title) ?>
                                    </h3>
                                    <?php if ($hasGrade): ?>
                                        <span class="px-2 py-1 text-xs rounded-full bg-<?= $isExcellent ? 'green' : ($isGood ? 'blue' : 'orange') ?>-100 dark:bg-<?= $isExcellent ? 'green' : ($isGood ? 'blue' : 'orange') ?>-900 text-<?= $isExcellent ? 'green' : ($isGood ? 'blue' : 'orange') ?>-800 dark:text-<?= $isExcellent ? 'green' : ($isGood ? 'blue' : 'orange') ?>-300">
                                            Calificado: <?= number_format($task->grade, 1) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-300">
                                            Pendiente de calificación
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 mb-2">
                                    <?= htmlspecialchars($task->course_name) ?> (<?= htmlspecialchars($task->course_code) ?>)
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                                    Profesor: <?= htmlspecialchars($task->teacher_name) ?>
                                </p>
                                <?php if (!empty($task->submission_comments)): ?>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                                        <strong>Tus comentarios:</strong> <?= htmlspecialchars($task->submission_comments) ?>
                                    </p>
                                <?php endif; ?>
                                <?php if (!empty($task->feedback)): ?>
                                    <div class="p-3 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 text-sm text-blue-700 dark:text-blue-300 mb-3">
                                        <strong>Retroalimentación:</strong> <?= htmlspecialchars($task->feedback) ?>
                                    </div>
                                <?php endif; ?>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
                                    Entregada el: <?= date('d/m/Y H:i', strtotime($task->submission_date)) ?>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <?php if (!empty($task->submission_file)): ?>
                                    <a href="<?= htmlspecialchars($task->submission_file) ?>" target="_blank" class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                                        <i data-feather="download" class="w-4 h-4 mr-1"></i>
                                        Ver archivo
                                    </a>
                                <?php endif; ?>
                                <a href="/src/plataforma/app/tareas/view/<?= $task->id ?>" class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                    <i data-feather="eye" class="w-4 h-4 mr-1"></i>
                                    Ver detalles
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12 text-gray-500 dark:text-gray-300">
                <i data-feather="inbox" class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-neutral-600"></i>
                <p class="text-lg">No tienes tareas entregadas</p>
                <p class="text-sm mt-2">Tus tareas entregadas aparecerán aquí</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    AOS.init();
    feather.replace();
</script>
