<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$layout = ($_SESSION['user_role'] ?? 'student') . '.php';
require_once __DIR__ . '/../layouts/' . $layout;
?>

<div class="container px-6 py-8">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="award" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Calificaciones</h2>
                <p class="opacity-90">Consulta y gestiona tus calificaciones</p>
            </div>
        </div>
    </div>

    <!-- Resumen de Calificaciones -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <?php if ($_SESSION['user_role'] === 'student'): ?>
            <!-- Promedio General -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-emerald-500" data-aos="fade-up">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm">Promedio General</p>
                        <h3 class="text-2xl font-bold mt-1"><?= number_format($stats['average'], 1) ?></h3>
                    </div>
                    <div class="p-3 rounded-lg bg-emerald-50 dark:bg-neutral-700">
                        <i data-feather="bar-chart-2" class="text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                </div>
            </div>

            <!-- Total Materias -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-blue-500" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm">Total Materias</p>
                        <h3 class="text-2xl font-bold mt-1"><?= $stats['total'] ?></h3>
                    </div>
                    <div class="p-3 rounded-lg bg-blue-50 dark:bg-neutral-700">
                        <i data-feather="book" class="text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
        <?php elseif ($_SESSION['user_role'] === 'teacher'): ?>
            <!-- Total Calificaciones -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-emerald-500" data-aos="fade-up">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm">Total Calificaciones</p>
                        <h3 class="text-2xl font-bold mt-1"><?= $stats['total_grades'] ?></h3>
                    </div>
                    <div class="p-3 rounded-lg bg-emerald-50 dark:bg-neutral-700">
                        <i data-feather="bar-chart-2" class="text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                </div>
            </div>
        <?php elseif ($_SESSION['user_role'] === 'admin'): ?>
            <!-- Total Calificaciones -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-emerald-500" data-aos="fade-up">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm">Total Calificaciones</p>
                        <h3 class="text-2xl font-bold mt-1"><?= $stats['total_grades'] ?></h3>
                    </div>
                    <div class="p-3 rounded-lg bg-emerald-50 dark:bg-neutral-700">
                        <i data-feather="bar-chart-2" class="text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                </div>
            </div>
        <?php elseif ($_SESSION['user_role'] === 'capturista'): ?>
            <!-- Calificaciones Pendientes -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-yellow-500" data-aos="fade-up">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-neutral-500 dark:text-neutral-400 text-sm">Calificaciones Pendientes</p>
                        <h3 class="text-2xl font-bold mt-1"><?= $stats['pending_grades'] ?></h3>
                    </div>
                    <div class="p-3 rounded-lg bg-yellow-50 dark:bg-neutral-700">
                        <i data-feather="clock" class="text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tabla de Calificaciones -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden" data-aos="fade-up">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 class="text-xl font-bold">Calificaciones por Materia</h2>
                <div class="flex gap-4">
                    <div class="relative">
                        <select class="appearance-none bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-primary-500 dark:text-white">
                            <option>Todos los Semestres</option>
                            <option>1er Semestre</option>
                            <option>2do Semestre</option>
                            <!-- Más opciones aquí -->
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-neutral-700 dark:text-neutral-300">
                            <i data-feather="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <button class="inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        <i data-feather="download" class="w-4 h-4 mr-2"></i>
                        Exportar
                    </button>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Materia
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Profesor
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Parcial 1
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Parcial 2
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Final
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Promedio
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Estado
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    <?php if (!empty($grades)): ?>
                        <?php foreach ($grades as $grade): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-neutral-900 dark:text-white">
                                                <?= htmlspecialchars($grade->course_name) ?>
                                            </div>
                                            <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                                <?= htmlspecialchars($grade->course_code) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-neutral-900 dark:text-white">
                                        <?php if ($_SESSION['user_role'] === 'student'): ?>
                                            <?= htmlspecialchars($grade->course_name) ?> <!-- For student, teacher not directly available, but course_name is shown -->
                                        <?php else: ?>
                                            <?= htmlspecialchars($grade->student_name) ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-neutral-900 dark:text-white">-</span> <!-- Assuming no partial grades -->
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-neutral-900 dark:text-white">-</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-neutral-900 dark:text-white">-</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-neutral-900 dark:text-white"><?= number_format($grade->grade, 1) ?></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $grade->grade >= 7 ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' ?>">
                                        <?= $grade->grade >= 7 ? 'Aprobado' : 'Reprobado' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                                No hay calificaciones disponibles
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Paginación -->
        <div class="bg-white dark:bg-neutral-800 px-4 py-3 flex items-center justify-between border-t border-neutral-200 dark:border-neutral-700 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <button class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 text-sm font-medium rounded-md text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                    Anterior
                </button>
                <button class="ml-3 relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 text-sm font-medium rounded-md text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                    Siguiente
                </button>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-neutral-700 dark:text-neutral-300">
                        Mostrando <span class="font-medium">1</span> a <span class="font-medium">10</span> de <span class="font-medium">30</span> resultados
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <button class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                            <span class="sr-only">Anterior</span>
                            <i data-feather="chevron-left" class="w-5 h-5"></i>
                        </button>
                        <button class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                            1
                        </button>
                        <button class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 bg-primary-50 dark:bg-primary-900 text-sm font-medium text-primary-600 dark:text-primary-400">
                            2
                        </button>
                        <button class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                            3
                        </button>
                        <button class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                            <span class="sr-only">Siguiente</span>
                            <i data-feather="chevron-right" class="w-5 h-5"></i>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Inicializar las animaciones y los íconos
    AOS.init();
    feather.replace();
</script>
