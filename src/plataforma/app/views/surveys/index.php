<?php 
$layout = $_SESSION['user_role'] . '.php';
require_once __DIR__ . '/../layouts/' . $layout;
?>

<div class="container px-6 py-8">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-violet-600 to-fuchsia-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="clipboard" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Encuestas</h2>
                <p class="opacity-90">Tu opinión es importante para mejorar</p>
            </div>
        </div>
    </div>

    <!-- Resumen de Encuestas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Encuestas Pendientes -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-yellow-500" data-aos="fade-up">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">Pendientes</p>
                    <h3 class="text-2xl font-bold mt-1">3</h3>
                </div>
                <div class="p-3 rounded-lg bg-yellow-50 dark:bg-neutral-700">
                    <i data-feather="clock" class="text-yellow-600 dark:text-yellow-400"></i>
                </div>
            </div>
        </div>

        <!-- Encuestas Completadas -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-green-500" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">Completadas</p>
                    <h3 class="text-2xl font-bold mt-1">12</h3>
                </div>
                <div class="p-3 rounded-lg bg-green-50 dark:bg-neutral-700">
                    <i data-feather="check-circle" class="text-green-600 dark:text-green-400"></i>
                </div>
            </div>
        </div>

        <!-- Evaluación Docente -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-blue-500" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">Eval. Docente</p>
                    <h3 class="text-2xl font-bold mt-1">5/6</h3>
                </div>
                <div class="p-3 rounded-lg bg-blue-50 dark:bg-neutral-700">
                    <i data-feather="user-check" class="text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
        </div>

        <!-- Servicios Escolares -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-purple-500" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-neutral-500 dark:text-neutral-400 text-sm">Servicios</p>
                    <h3 class="text-2xl font-bold mt-1">2/2</h3>
                </div>
                <div class="p-3 rounded-lg bg-purple-50 dark:bg-neutral-700">
                    <i data-feather="briefcase" class="text-purple-600 dark:text-purple-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Encuestas Pendientes -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden mb-8" data-aos="fade-up">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h3 class="text-xl font-bold">Encuestas Pendientes</h3>
            <p class="text-neutral-500 dark:text-neutral-400 mt-1">Completa estas encuestas antes de su fecha límite</p>
        </div>
        <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
            <!-- Encuesta 1 -->
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300">
                                Urgente
                            </span>
                            <span class="text-sm text-neutral-500 dark:text-neutral-400">
                                Vence en 2 días
                            </span>
                        </div>
                        <h4 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">
                            Evaluación Docente - Cálculo Diferencial
                        </h4>
                        <p class="text-neutral-600 dark:text-neutral-300 mb-4">
                            Evalúa el desempeño del profesor y la calidad del curso durante este semestre.
                        </p>
                        <div class="flex items-center gap-4 text-sm">
                            <div class="flex items-center gap-2 text-neutral-500 dark:text-neutral-400">
                                <i data-feather="help-circle" class="w-4 h-4"></i>
                                <span>15 preguntas</span>
                            </div>
                            <div class="flex items-center gap-2 text-neutral-500 dark:text-neutral-400">
                                <i data-feather="clock" class="w-4 h-4"></i>
                                <span>~10 minutos</span>
                            </div>
                        </div>
                    </div>
                    <button class="ml-6 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        Comenzar
                    </button>
                </div>
            </div>

            <!-- Encuesta 2 -->
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-300">
                                Importante
                            </span>
                            <span class="text-sm text-neutral-500 dark:text-neutral-400">
                                Vence en 5 días
                            </span>
                        </div>
                        <h4 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">
                            Satisfacción con Servicios Escolares
                        </h4>
                        <p class="text-neutral-600 dark:text-neutral-300 mb-4">
                            Ayúdanos a mejorar la calidad de nuestros servicios administrativos.
                        </p>
                        <div class="flex items-center gap-4 text-sm">
                            <div class="flex items-center gap-2 text-neutral-500 dark:text-neutral-400">
                                <i data-feather="help-circle" class="w-4 h-4"></i>
                                <span>10 preguntas</span>
                            </div>
                            <div class="flex items-center gap-2 text-neutral-500 dark:text-neutral-400">
                                <i data-feather="clock" class="w-4 h-4"></i>
                                <span>~5 minutos</span>
                            </div>
                        </div>
                    </div>
                    <button class="ml-6 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        Comenzar
                    </button>
                </div>
            </div>

            <!-- Encuesta 3 -->
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300">
                                General
                            </span>
                            <span class="text-sm text-neutral-500 dark:text-neutral-400">
                                Vence en 1 semana
                            </span>
                        </div>
                        <h4 class="text-lg font-medium text-neutral-900 dark:text-white mb-2">
                            Experiencia en la Biblioteca
                        </h4>
                        <p class="text-neutral-600 dark:text-neutral-300 mb-4">
                            Comparte tu experiencia con los servicios y recursos de la biblioteca.
                        </p>
                        <div class="flex items-center gap-4 text-sm">
                            <div class="flex items-center gap-2 text-neutral-500 dark:text-neutral-400">
                                <i data-feather="help-circle" class="w-4 h-4"></i>
                                <span>8 preguntas</span>
                            </div>
                            <div class="flex items-center gap-2 text-neutral-500 dark:text-neutral-400">
                                <i data-feather="clock" class="w-4 h-4"></i>
                                <span>~3 minutos</span>
                            </div>
                        </div>
                    </div>
                    <button class="ml-6 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        Comenzar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Encuestas Completadas -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden" data-aos="fade-up">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold">Encuestas Completadas</h3>
                    <p class="text-neutral-500 dark:text-neutral-400 mt-1">Historial de encuestas que has respondido</p>
                </div>
                <button class="px-4 py-2 text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                    Ver todas
                </button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Encuesta
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-neutral-900 dark:text-white">Evaluación Docente - Programación</div>
                            <div class="text-sm text-neutral-500 dark:text-neutral-400">PRG-202</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300">
                                Académica
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                            25 Sep 2025
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300">
                                Completada
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                Ver detalles
                            </button>
                        </td>
                    </tr>
                    <!-- Más filas aquí -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Inicializar las animaciones y los íconos
    AOS.init();
    feather.replace();
</script>
