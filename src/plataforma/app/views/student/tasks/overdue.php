<?php
// Variables esperadas desde el controlador:
// $user, $tasks
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-red-500 to-pink-500 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="alert-circle" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Tareas Vencidas</h2>
                <p class="opacity-90">Estas son las tareas que no entregaste a tiempo</p>
            </div>
        </div>
    </div>

    <!-- Alerta -->
    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 mb-6" data-aos="fade-up">
        <div class="flex">
            <div class="flex-shrink-0">
                <i data-feather="alert-triangle" class="h-5 w-5 text-red-500"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700 dark:text-red-300">
                    Las tareas vencidas pueden afectar tu calificación final. Contacta a tu profesor para ver si aún puedes entregarlas.
                </p>
            </div>
        </div>
    </div>

    <!-- Lista de tareas vencidas -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6" data-aos="fade-up">
        <?php if (!empty($tasks)): ?>
            <div class="space-y-4">
                <?php foreach ($tasks as $task): 
                    $dueDate = new DateTime($task->due_at);
                    $now = new DateTime();
                    $daysOverdue = $now->diff($dueDate)->days;
                ?>
                    <div class="border border-red-200 dark:border-red-800 rounded-lg p-5 hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mr-3">
                                        <?= htmlspecialchars($task->title) ?>
                                    </h3>
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300">
                                        Vencida hace <?= $daysOverdue ?> días
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
                                <div class="flex items-center text-sm text-red-600 dark:text-red-400">
                                    <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
                                    Fecha de entrega: <?= date('d/m/Y H:i', strtotime($task->due_at)) ?>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <a href="/src/plataforma/app/tareas/view/<?= $task->id ?>" class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                                    <i data-feather="eye" class="w-4 h-4 mr-1"></i>
                                    Ver detalles
                                </a>
                                <button onclick="contactTeacher('<?= htmlspecialchars($task->teacher_name) ?>', '<?= htmlspecialchars($task->title) ?>')" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                                    <i data-feather="mail" class="w-4 h-4 mr-1"></i>
                                    Contactar profesor
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12 text-gray-500 dark:text-gray-300">
                <i data-feather="check-circle" class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-neutral-600"></i>
                <p class="text-lg">No tienes tareas vencidas</p>
                <p class="text-sm mt-2">¡Sigue así!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    AOS.init();
    feather.replace();

    function contactTeacher(teacherName, taskTitle) {
        if (confirm(`¿Deseas contactar al profesor ${teacherName} sobre la tarea "${taskTitle}"?`)) {
            // Aquí podrías redirigir a un formulario de contacto o abrir un cliente de correo
            alert('Esta función te permitirá contactar al profesor. Estará disponible próximamente.');
        }
    }
</script>
