<?php
// Variables esperadas desde el controlador:
// $user, $tasks
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="clock" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Tareas Pendientes</h2>
                <p class="opacity-90">Estas son las tareas que necesitas entregar</p>
            </div>
        </div>
    </div>

    <!-- Lista de tareas pendientes -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6" data-aos="fade-up">
        <?php if (!empty($tasks)): ?>
            <div class="space-y-4">
                <?php foreach ($tasks as $task): 
                    $dueDate = new DateTime($task->due_at);
                    $now = new DateTime();
                    $daysLeft = $now->diff($dueDate)->days;
                    $isUrgent = $daysLeft <= 2;
                    $isOverdue = $now > $dueDate;
                ?>
                    <div class="border border-<?= $isOverdue ? 'red' : ($isUrgent ? 'orange' : 'gray') ?>-200 dark:border-<?= $isOverdue ? 'red' : ($isUrgent ? 'orange' : 'gray') ?>-800 rounded-lg p-5 hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mr-3">
                                        <?= htmlspecialchars($task->title) ?>
                                    </h3>
                                    <span class="px-2 py-1 text-xs rounded-full bg-<?= $isOverdue ? 'red' : ($isUrgent ? 'orange' : 'amber') ?>-100 dark:bg-<?= $isOverdue ? 'red' : ($isUrgent ? 'orange' : 'amber') ?>-900 text-<?= $isOverdue ? 'red' : ($isUrgent ? 'orange' : 'amber') ?>-800 dark:text-<?= $isOverdue ? 'red' : ($isUrgent ? 'orange' : 'amber') ?>-300">
                                        <?= $isOverdue ? 'Vencida' : ($isUrgent ? '¡Urgente!' : 'Pendiente') ?>
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 mb-2">
                                    <?= htmlspecialchars($task->course_name) ?> (<?= htmlspecialchars($task->course_code) ?>)
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                                    Profesor: <?= htmlspecialchars($task->teacher_name) ?>
                                </p>
                                <?php if (!empty($task->description)): ?>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                                        <?= htmlspecialchars(substr($task->description, 0, 150)) ?><?= strlen($task->description) > 150 ? '...' : '' ?>
                                    </p>
                                <?php endif; ?>
                                <div class="flex items-center text-sm text-<?= $isOverdue ? 'red' : ($isUrgent ? 'orange' : 'gray') ?>-600 dark:text-<?= $isOverdue ? 'red' : ($isUrgent ? 'orange' : 'gray') ?>-400">
                                    <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
                                    Fecha de entrega: <?= date('d/m/Y H:i', strtotime($task->due_at)) ?>
                                    <?php if (!$isOverdue): ?>
                                        <span class="ml-2">(Quedan <?= $daysLeft ?> días)</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <a href="/src/plataforma/app/tareas/view/<?= $task->id ?>" class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                                    <i data-feather="eye" class="w-4 h-4 mr-1"></i>
                                    Ver detalles
                                </a>
                                <a href="/src/plataforma/app/tareas/submit/<?= $task->id ?>" class="inline-flex items-center justify-center px-4 py-2 bg-<?= $isOverdue ? 'red' : ($isUrgent ? 'orange' : 'blue') ?>-600 hover:bg-<?= $isOverdue ? 'red' : ($isUrgent ? 'orange' : 'blue') ?>-700 text-white rounded-lg transition-colors">
                                    <i data-feather="upload" class="w-4 h-4 mr-1"></i>
                                    Entregar tarea
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12 text-gray-500 dark:text-gray-300">
                <i data-feather="check-circle" class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-neutral-600"></i>
                <p class="text-lg">No tienes tareas pendientes</p>
                <p class="text-sm mt-2">¡Felicidades, todo al día!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    AOS.init();
    feather.replace();
</script>
