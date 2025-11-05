<?php
// Variables esperadas desde el controlador:
// $user, $courses
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="book-open" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Mis Materias</h2>
                <p class="opacity-90">Estas son las materias en las que estás inscrito este semestre</p>
            </div>
        </div>
    </div>

    <!-- Lista de materias -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-up">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
                    <div class="relative h-48 bg-gradient-to-br from-emerald-400 to-teal-500">
                        <div class="absolute inset-0 bg-black/10"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="p-4 bg-white/20 rounded-full backdrop-blur-sm">
                                <i data-feather="book" class="w-16 h-16 text-white"></i>
                            </div>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-white/20 backdrop-blur-sm text-white">
                                Activa
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">
                            <?= htmlspecialchars($course->name ?? $course->nombre ?? 'Materia') ?>
                        </h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            <?= htmlspecialchars($course->code ?? $course->clave ?? '') ?>
                        </p>
                        <?php if (!empty($course->teacher_name)): ?>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <i data-feather="user" class="w-4 h-4 mr-1"></i>
                                Prof. <?= htmlspecialchars($course->teacher_name) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($course->schedule)): ?>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <i data-feather="clock" class="w-4 h-4 mr-1"></i>
                                <?= htmlspecialchars($course->schedule) ?>
                            </div>
                        <?php endif; ?>
                        <div class="flex items-center justify-between">
                            <a href="#" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 font-medium flex items-center group-hover:translate-x-1 transition-transform">
                                Ver detalles
                                <i data-feather="arrow-right" class="w-4 h-4 ml-1"></i>
                            </a>
                            <div class="flex items-center gap-1">
                                <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700 transition-colors" title="Ver horario">
                                    <i data-feather="calendar" class="w-4 h-4 text-gray-500 dark:text-gray-400"></i>
                                </button>
                                <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700 transition-colors" title="Ver tareas">
                                    <i data-feather="check-square" class="w-4 h-4 text-gray-500 dark:text-gray-400"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-12">
                <i data-feather="book-open" class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-neutral-600"></i>
                <p class="text-lg text-gray-500 dark:text-gray-300">No estás inscrito en ninguna materia</p>
                <p class="text-sm text-gray-400 dark:text-gray-400 mt-2">Contacta a administración para inscribirte en las materias correspondientes</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8" data-aos="fade-up" data-aos-delay="100">
        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-emerald-200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-emerald-600 dark:text-emerald-300 text-sm font-medium">Total de materias</p>
                    <h3 class="text-3xl font-bold mt-1 text-emerald-800 dark:text-emerald-100"><?= count($courses ?? []) ?></h3>
                </div>
                <div class="p-4 rounded-xl bg-emerald-100 dark:bg-neutral-700">
                    <i data-feather="book-open" class="w-8 h-8 text-emerald-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-blue-200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-blue-600 dark:text-blue-300 text-sm font-medium">Créditos cursando</p>
                    <h3 class="text-3xl font-bold mt-1 text-blue-800 dark:text-blue-100">24</h3>
                </div>
                <div class="p-4 rounded-xl bg-blue-100 dark:bg-neutral-700">
                    <i data-feather="award" class="w-8 h-8 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-purple-200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-purple-600 dark:text-purple-300 text-sm font-medium">Promedio actual</p>
                    <h3 class="text-3xl font-bold mt-1 text-purple-800 dark:text-purple-100">8.5</h3>
                </div>
                <div class="p-4 rounded-xl bg-purple-100 dark:bg-neutral-700">
                    <i data-feather="trending-up" class="w-8 h-8 text-purple-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-amber-200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-amber-600 dark:text-amber-300 text-sm font-medium">Asistencia</p>
                    <h3 class="text-3xl font-bold mt-1 text-amber-800 dark:text-amber-100">92%</h3>
                </div>
                <div class="p-4 rounded-xl bg-amber-100 dark:bg-neutral-700">
                    <i data-feather="user-check" class="w-8 h-8 text-amber-600"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    AOS.init();
    feather.replace();
</script>
