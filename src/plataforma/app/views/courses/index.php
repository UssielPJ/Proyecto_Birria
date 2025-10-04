<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$layout = ($_SESSION['user_role'] ?? 'student') . '.php';
require_once __DIR__ . '/../layouts/' . $layout;
?>

<div class="container px-6 py-8">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="book" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Cursos</h2>
                <p class="opacity-90">Gestiona tus cursos y materias</p>
            </div>
        </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
        <div class="flex flex-wrap gap-4 items-center">
            <div class="relative">
                <select class="appearance-none bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-primary-500 dark:text-white">
                    <option>Todos los Semestres</option>
                    <option>Primer Semestre</option>
                    <option>Segundo Semestre</option>
                    <!-- Más opciones aquí -->
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-neutral-700 dark:text-neutral-300">
                    <i data-feather="chevron-down" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="relative">
                <select class="appearance-none bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-primary-500 dark:text-white">
                    <option>Todas las Carreras</option>
                    <option>Ingeniería</option>
                    <option>Administración</option>
                    <!-- Más opciones aquí -->
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-neutral-700 dark:text-neutral-300">
                    <i data-feather="chevron-down" class="w-4 h-4"></i>
                </div>
            </div>
        </div>
        
        <div class="relative">
            <input type="text" placeholder="Buscar cursos..." 
                class="w-full sm:w-64 pl-10 pr-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:outline-none focus:border-primary-500 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-feather="search" class="w-4 h-4 text-neutral-500 dark:text-neutral-400"></i>
            </div>
        </div>
    </div>

    <!-- Grid de Cursos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden" data-aos="fade-up">
                    <div class="relative h-48 bg-neutral-200 dark:bg-neutral-700">
                        <img src="/src/plataforma/app/img/UT.jpg" alt="<?= htmlspecialchars($course->name) ?>" class="w-full h-full object-cover">
                        <div class="absolute top-4 right-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                Activo
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2"><?= htmlspecialchars($course->name) ?></h3>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
                            <?= htmlspecialchars($course->description ?? 'Descripción no disponible') ?>
                        </p>
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                    <i data-feather="user" class="w-4 h-4 text-primary-600 dark:text-primary-400"></i>
                                </div>
                                <span class="text-sm text-neutral-600 dark:text-neutral-300"><?= htmlspecialchars($course->teacher_name ?? 'Profesor no asignado') ?></span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <i data-feather="users" class="w-4 h-4 text-neutral-400"></i>
                                <span class="text-sm text-neutral-500 dark:text-neutral-400"><?= $course->student_count ?? 0 ?> estudiantes</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-1">
                                <i data-feather="clock" class="w-4 h-4 text-neutral-400"></i>
                                <span class="text-sm text-neutral-500 dark:text-neutral-400">Horario por definir</span>
                            </div>
                            <a href="#" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 text-sm font-medium">
                                Ver detalles
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-12">
                <i data-feather="book" class="w-16 h-16 text-neutral-300 dark:text-neutral-600 mx-auto mb-4"></i>
                <p class="text-neutral-500 dark:text-neutral-400">No hay cursos disponibles</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Paginación -->
    <div class="flex items-center justify-between border-t border-neutral-200 dark:border-neutral-700 px-4 py-3 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 text-sm font-medium rounded-md text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                Anterior
            </a>
            <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 text-sm font-medium rounded-md text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                Siguiente
            </a>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-neutral-700 dark:text-neutral-300">
                    Mostrando <span class="font-medium">1</span> a <span class="font-medium">10</span> de <span class="font-medium">97</span> resultados
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        <span class="sr-only">Anterior</span>
                        <i data-feather="chevron-left" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        1
                    </a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 bg-primary-50 dark:bg-primary-900 text-sm font-medium text-primary-600 dark:text-primary-400">
                        2
                    </a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        3
                    </a>
                    <span class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-700 dark:text-neutral-300">
                        ...
                    </span>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        10
                    </a>
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        <span class="sr-only">Siguiente</span>
                        <i data-feather="chevron-right" class="w-5 h-5"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
    // Inicializar las animaciones y los íconos
    AOS.init();
    feather.replace();
</script>
