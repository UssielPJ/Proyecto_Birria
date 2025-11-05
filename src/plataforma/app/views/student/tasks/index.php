<?php
// Variables esperadas desde el controlador:
// $user, $pendingTasks, $submittedTasks, $overdueTasks
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="check-square" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Mis Tareas</h2>
                <p class="opacity-90">Gestiona tus tareas pendientes, entregadas y vencidas</p>
            </div>
        </div>
    </div>

    <!-- Estadísticas de Tareas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Tareas Pendientes -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-amber-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-tooltip="Ver tareas pendientes">
            <div class="absolute inset-0 bg-gradient-to-r from-amber-400/20 to-orange-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between mb-4">
                <div>
                    <p class="text-amber-600 dark:text-amber-300 text-sm font-medium">Pendientes</p>
                    <h3 class="text-3xl font-bold mt-1 text-amber-800 dark:text-amber-100"><?= count($pendingTasks ?? []) ?></h3>
                    <p class="text-amber-500 dark:text-amber-300 text-xs mt-1">Por entregar</p>
                </div>
                <div class="p-4 rounded-xl bg-amber-100 dark:bg-neutral-700 shadow-inner group-hover:bg-amber-200 group-hover:rotate-12 transition-all duration-300">
                    <i data-feather="clock" class="w-8 h-8 text-amber-600"></i>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-orange-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            <a href="/src/plataforma/app/tareas/pending" class="text-amber-600 dark:text-amber-300 hover:text-amber-700 text-sm font-medium flex items-center mt-4 group-hover:translate-x-1 transition-transform">
                Ver tareas pendientes
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Tareas Entregadas -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-green-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="100" data-tooltip="Ver tareas entregadas">
            <div class="absolute inset-0 bg-gradient-to-r from-green-400/20 to-emerald-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between mb-4">
                <div>
                    <p class="text-green-600 dark:text-green-300 text-sm font-medium">Entregadas</p>
                    <h3 class="text-3xl font-bold mt-1 text-green-800 dark:text-green-100"><?= count($submittedTasks ?? []) ?></h3>
                    <p class="text-green-500 dark:text-green-300 text-xs mt-1">Completadas</p>
                </div>
                <div class="p-4 rounded-xl bg-green-100 dark:bg-neutral-700 shadow-inner group-hover:bg-green-200 group-hover:rotate-12 transition-all duration-300">
                    <i data-feather="check-circle" class="w-8 h-8 text-green-600"></i>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-green-400 to-emerald-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            <a href="/src/plataforma/app/tareas/submitted" class="text-green-600 dark:text-green-300 hover:text-green-700 text-sm font-medium flex items-center mt-4 group-hover:translate-x-1 transition-transform">
                Ver tareas entregadas
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Tareas Vencidas -->
        <div class="bg-gradient-to-br from-red-50 to-pink-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-red-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="200" data-tooltip="Ver tareas vencidas">
            <div class="absolute inset-0 bg-gradient-to-r from-red-400/20 to-pink-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between mb-4">
                <div>
                    <p class="text-red-600 dark:text-red-300 text-sm font-medium">Vencidas</p>
                    <h3 class="text-3xl font-bold mt-1 text-red-800 dark:text-red-100"><?= count($overdueTasks ?? []) ?></h3>
                    <p class="text-red-500 dark:text-red-300 text-xs mt-1">No entregadas a tiempo</p>
                </div>
                <div class="p-4 rounded-xl bg-red-100 dark:bg-neutral-700 shadow-inner group-hover:bg-red-200 group-hover:rotate-12 transition-all duration-300">
                    <i data-feather="alert-circle" class="w-8 h-8 text-red-600"></i>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-red-400 to-pink-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            <a href="/src/plataforma/app/tareas/overdue" class="text-red-600 dark:text-red-300 hover:text-red-700 text-sm font-medium flex items-center mt-4 group-hover:translate-x-1 transition-transform">
                Ver tareas vencidas
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Tareas más recientes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Próximas tareas por entregar -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300" data-aos="fade-up">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center">
                    <i data-feather="clock" class="w-5 h-5 mr-2 text-amber-600"></i>
                    Próximas por Entregar
                </h3>
                <a href="/src/plataforma/app/tareas/pending" class="text-amber-600 dark:text-amber-300 hover:text-amber-700 text-sm font-medium flex items-center group">
                    Ver todas
                    <i data-feather="arrow-right" class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            <div class="space-y-4">
                <?php if (!empty($pendingTasks)): ?>
                    <?php 
                    // Mostrar solo las primeras 5 tareas
                    $pendingToShow = array_slice($pendingTasks, 0, 5);
                    foreach ($pendingToShow as $task): 
                        $dueDate = new DateTime($task->due_at);
                        $now = new DateTime();
                        $daysLeft = $now->diff($dueDate)->days;
                        $isUrgent = $daysLeft <= 2;
                    ?>
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-neutral-800 dark:to-neutral-800 rounded-lg hover:from-amber-50 hover:to-orange-50 transition-all duration-300 group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-<?= $isUrgent ? 'red' : 'amber' ?>-100 dark:bg-neutral-700 flex items-center justify-center mr-3 group-hover:bg-<?= $isUrgent ? 'red' : 'amber' ?>-200 transition-colors">
                                    <i data-feather="<?= $isUrgent ? 'alert-triangle' : 'clock' ?>" class="w-5 h-5 text-<?= $isUrgent ? 'red' : 'amber' ?>-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">
                                        <?= htmlspecialchars($task->title) ?>
                                    </h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-300"><?= htmlspecialchars($task->course_name) ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs bg-<?= $isUrgent ? 'red' : 'amber' ?>-100 dark:bg-neutral-700 text-<?= $isUrgent ? 'red' : 'amber' ?>-800 dark:text-<?= $isUrgent ? 'red' : 'amber' ?>-300 px-3 py-1 rounded-full font-medium">
                                    <?= $isUrgent ? '¡Urgente!' : 'Quedan ' . $daysLeft . ' días' ?>
                                </span>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    <?= date('d/m/Y H:i', strtotime($task->due_at)) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-12 text-gray-500 dark:text-gray-300">
                        <i data-feather="check-circle" class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-neutral-600"></i>
                        <p class="text-lg">No tienes tareas pendientes</p>
                        <p class="text-sm mt-2">¡Felicidades, todo al día!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Entregas recientes -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center">
                    <i data-feather="check-circle" class="w-5 h-5 mr-2 text-green-600"></i>
                    Entregas Recientes
                </h3>
                <a href="/src/plataforma/app/tareas/submitted" class="text-green-600 dark:text-green-300 hover:text-green-700 text-sm font-medium flex items-center group">
                    Ver todas
                    <i data-feather="arrow-right" class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            <div class="space-y-4">
                <?php if (!empty($submittedTasks)): ?>
                    <?php 
                    // Mostrar solo las primeras 5 tareas
                    $submittedToShow = array_slice($submittedTasks, 0, 5);
                    foreach ($submittedToShow as $task): 
                        $hasGrade = isset($task->grade) && $task->grade !== null;
                    ?>
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-neutral-800 dark:to-neutral-800 rounded-lg hover:from-green-50 hover:to-emerald-50 transition-all duration-300 group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-neutral-700 flex items-center justify-center mr-3 group-hover:bg-green-200 transition-colors">
                                    <i data-feather="check-circle" class="w-5 h-5 text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">
                                        <?= htmlspecialchars($task->title) ?>
                                    </h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-300"><?= htmlspecialchars($task->course_name) ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <?php if ($hasGrade): ?>
                                    <span class="text-lg font-bold <?= $task->grade >= 7 ? 'text-green-600' : 'text-red-600' ?>">
                                        <?= number_format($task->grade, 1) ?>
                                    </span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Calificado</p>
                                <?php else: ?>
                                    <span class="text-xs bg-blue-100 dark:bg-neutral-700 text-blue-800 dark:text-blue-300 px-3 py-1 rounded-full font-medium">
                                        Pendiente de calificación
                                    </span>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        Entregado: <?= date('d/m/Y', strtotime($task->submission_date)) ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-12 text-gray-500 dark:text-gray-300">
                        <i data-feather="inbox" class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-neutral-600"></i>
                        <p class="text-lg">No tienes entregas registradas</p>
                        <p class="text-sm mt-2">Tus entregas aparecerán aquí</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    AOS.init();
    feather.replace();

    // Enhanced hover effects
    document.querySelectorAll('.grid > div').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.05)';
            this.style.boxShadow = '0 25px 50px rgba(0,0,0,0.15), 0 0 30px rgba(99, 102, 241, 0.4)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '';
        });
    });

    // Tooltip functionality
    function initTooltips() {
        const cards = document.querySelectorAll('[data-tooltip]');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function(e) {
                const tooltip = document.createElement('div');
                tooltip.className = 'absolute bg-gray-800 text-white text-xs px-2 py-1 rounded shadow-lg z-50 pointer-events-none';
                tooltip.textContent = this.getAttribute('data-tooltip');
                tooltip.style.top = e.clientY - 30 + 'px';
                tooltip.style.left = e.clientX + 10 + 'px';
                document.body.appendChild(tooltip);

                this.addEventListener('mousemove', function(e) {
                    tooltip.style.top = e.clientY - 30 + 'px';
                    tooltip.style.left = e.clientX + 10 + 'px';
                });

                this.addEventListener('mouseleave', function() {
                    tooltip.remove();
                });
            });
        });
    }

    // Initialize
    window.addEventListener('load', function() {
        initTooltips();
    });
</script>
