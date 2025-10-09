<?php
$layout = $_SESSION['user']['role'] . '.php';
require_once __DIR__ . '/../layouts/' . $layout;
?>

<div class="flex items-center justify-center min-h-[70vh]">
<div class="container px-6">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-amber-600 to-orange-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="gift" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Becas</h2>
                <p class="opacity-90">Explora las oportunidades de becas disponibles</p>
            </div>
        </div>
    </div>

    <!-- Información de Beca Actual -->
    <?php if (isset($current_scholarship)): ?>
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 mb-8" data-aos="fade-up">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold">Tu Beca Actual</h3>
            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                Activa
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-start gap-4">
                <div class="p-3 rounded-lg bg-primary-50 dark:bg-primary-900">
                    <i data-feather="award" class="w-6 h-6 text-primary-600 dark:text-primary-400"></i>
                </div>
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Tipo de Beca</p>
                    <p class="font-medium text-neutral-900 dark:text-white mt-1">Excelencia Académica</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="p-3 rounded-lg bg-green-50 dark:bg-green-900">
                    <i data-feather="percent" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                </div>
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Porcentaje</p>
                    <p class="font-medium text-neutral-900 dark:text-white mt-1">50%</p>
                </div>
            </div>
            <div class="flex items-start gap-4">
                <div class="p-3 rounded-lg bg-blue-50 dark:bg-blue-900">
                    <i data-feather="calendar" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
                </div>
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Vigencia</p>
                    <p class="font-medium text-neutral-900 dark:text-white mt-1">Otoño 2025</p>
                </div>
            </div>
        </div>
        <div class="mt-6 pt-6 border-t border-neutral-200 dark:border-neutral-700">
            <h4 class="font-medium text-neutral-900 dark:text-white mb-2">Requisitos de Mantenimiento</h4>
            <ul class="space-y-2">
                <li class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                    <i data-feather="check-circle" class="w-4 h-4 text-green-500"></i>
                    Mantener promedio mínimo de 9.0
                </li>
                <li class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                    <i data-feather="check-circle" class="w-4 h-4 text-green-500"></i>
                    No reprobar materias
                </li>
                <li class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                    <i data-feather="check-circle" class="w-4 h-4 text-green-500"></i>
                    Asistencia mínima del 90%
                </li>
            </ul>
        </div>
    </div>
    <?php endif; ?>

    <!-- Becas Disponibles -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden mb-8" data-aos="fade-up">
        <div class="p-6 border-b border-neutral-200 dark:border-neutral-700">
            <h3 class="text-xl font-bold">Becas Disponibles</h3>
            <p class="text-neutral-500 dark:text-neutral-400 mt-1">Explora las becas a las que puedes aplicar</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            <!-- Beca de Excelencia -->
            <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg overflow-hidden">
                <div class="bg-primary-50 dark:bg-primary-900 p-4">
                    <h4 class="font-bold text-primary-900 dark:text-primary-100">Beca de Excelencia</h4>
                </div>
                <div class="p-4">
                    <div class="flex items-baseline gap-1 mb-4">
                        <span class="text-2xl font-bold text-neutral-900 dark:text-white">50%</span>
                        <span class="text-neutral-500 dark:text-neutral-400">de descuento</span>
                    </div>
                    <ul class="space-y-2 mb-4">
                        <li class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                            <i data-feather="check" class="w-4 h-4 text-green-500"></i>
                            Promedio superior a 9.5
                        </li>
                        <li class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                            <i data-feather="check" class="w-4 h-4 text-green-500"></i>
                            Sin materias reprobadas
                        </li>
                        <li class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                            <i data-feather="check" class="w-4 h-4 text-green-500"></i>
                            Actividades extracurriculares
                        </li>
                    </ul>
                    <button class="w-full bg-primary-600 text-white py-2 px-4 rounded-lg hover:bg-primary-700 transition-colors">
                        Aplicar
                    </button>
                </div>
            </div>

            <!-- Beca Deportiva -->
            <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg overflow-hidden">
                <div class="bg-blue-50 dark:bg-blue-900 p-4">
                    <h4 class="font-bold text-blue-900 dark:text-blue-100">Beca Deportiva</h4>
                </div>
                <div class="p-4">
                    <div class="flex items-baseline gap-1 mb-4">
                        <span class="text-2xl font-bold text-neutral-900 dark:text-white">40%</span>
                        <span class="text-neutral-500 dark:text-neutral-400">de descuento</span>
                    </div>
                    <ul class="space-y-2 mb-4">
                        <li class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                            <i data-feather="check" class="w-4 h-4 text-green-500"></i>
                            Seleccionado deportivo
                        </li>
                        <li class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                            <i data-feather="check" class="w-4 h-4 text-green-500"></i>
                            Promedio mínimo 8.0
                        </li>
                        <li class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                            <i data-feather="check" class="w-4 h-4 text-green-500"></i>
                            Asistencia a entrenamientos
                        </li>
                    </ul>
                    <button class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        Aplicar
                    </button>
                </div>
            </div>

            <!-- Beca Socioeconómica -->
            <div class="border border-neutral-200 dark:border-neutral-700 rounded-lg overflow-hidden">
                <div class="bg-purple-50 dark:bg-purple-900 p-4">
                    <h4 class="font-bold text-purple-900 dark:text-purple-100">Beca Socioeconómica</h4>
                </div>
                <div class="p-4">
                    <div class="flex items-baseline gap-1 mb-4">
                        <span class="text-2xl font-bold text-neutral-900 dark:text-white">60%</span>
                        <span class="text-neutral-500 dark:text-neutral-400">de descuento</span>
                    </div>
                    <ul class="space-y-2 mb-4">
                        <li class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                            <i data-feather="check" class="w-4 h-4 text-green-500"></i>
                            Estudio socioeconómico
                        </li>
                        <li class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                            <i data-feather="check" class="w-4 h-4 text-green-500"></i>
                            Promedio mínimo 8.5
                        </li>
                        <li class="flex items-center gap-2 text-sm text-neutral-600 dark:text-neutral-300">
                            <i data-feather="check" class="w-4 h-4 text-green-500"></i>
                            Documentación completa
                        </li>
                    </ul>
                    <button class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition-colors">
                        Aplicar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Proceso de Aplicación -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6" data-aos="fade-up">
        <h3 class="text-xl font-bold mb-6">Proceso de Aplicación</h3>
        <div class="relative">
            <div class="absolute left-5 top-0 h-full w-0.5 bg-neutral-200 dark:bg-neutral-700"></div>
            <div class="space-y-8">
                <div class="relative flex items-start gap-6">
                    <div class="absolute left-0 top-0 bg-white dark:bg-neutral-800 p-1.5">
                        <div class="w-7 h-7 rounded-full bg-blue-500 flex items-center justify-center">
                            <span class="text-white font-medium">1</span>
                        </div>
                    </div>
                    <div class="ml-12">
                        <h4 class="font-medium text-neutral-900 dark:text-white mb-2">Revisa los Requisitos</h4>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">
                            Verifica que cumples con todos los requisitos de la beca antes de aplicar.
                        </p>
                    </div>
                </div>

                <div class="relative flex items-start gap-6">
                    <div class="absolute left-0 top-0 bg-white dark:bg-neutral-800 p-1.5">
                        <div class="w-7 h-7 rounded-full bg-blue-500 flex items-center justify-center">
                            <span class="text-white font-medium">2</span>
                        </div>
                    </div>
                    <div class="ml-12">
                        <h4 class="font-medium text-neutral-900 dark:text-white mb-2">Prepara la Documentación</h4>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">
                            Reúne todos los documentos necesarios según el tipo de beca.
                        </p>
                    </div>
                </div>

                <div class="relative flex items-start gap-6">
                    <div class="absolute left-0 top-0 bg-white dark:bg-neutral-800 p-1.5">
                        <div class="w-7 h-7 rounded-full bg-blue-500 flex items-center justify-center">
                            <span class="text-white font-medium">3</span>
                        </div>
                    </div>
                    <div class="ml-12">
                        <h4 class="font-medium text-neutral-900 dark:text-white mb-2">Envía tu Aplicación</h4>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">
                            Completa el formulario de solicitud y adjunta los documentos requeridos.
                        </p>
                    </div>
                </div>

                <div class="relative flex items-start gap-6">
                    <div class="absolute left-0 top-0 bg-white dark:bg-neutral-800 p-1.5">
                        <div class="w-7 h-7 rounded-full bg-blue-500 flex items-center justify-center">
                            <span class="text-white font-medium">4</span>
                        </div>
                    </div>
                    <div class="ml-12">
                        <h4 class="font-medium text-neutral-900 dark:text-white mb-2">Espera la Resolución</h4>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400">
                            El comité evaluará tu solicitud y te notificará la decisión.
                        </p>
                    </div>
                </div>
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
