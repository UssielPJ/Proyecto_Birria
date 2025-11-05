<?php
// Variables esperadas desde el controlador:
// $user
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="user" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Mi Perfil</h2>
                <p class="opacity-90">Gestiona tu información personal y académica</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información personal -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6" data-aos="fade-up">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center">
                        <i data-feather="user" class="w-5 h-5 mr-2 text-indigo-600"></i>
                        Información Personal
                    </h3>
                    <a href="/src/plataforma/app/student/profile/edit" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-sm font-medium flex items-center group">
                        Editar
                        <i data-feather="edit-2" class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center">
                        <div class="w-20 h-20 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center mr-4">
                            <i data-feather="user" class="w-10 h-10 text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-800 dark:text-white">
                                <?= htmlspecialchars($user['name'] ?? $user['nombre'] ?? 'Nombre del estudiante') ?>
                            </h4>
                            <p class="text-gray-500 dark:text-gray-400">
                                Matrícula: <?= htmlspecialchars($user['matricula'] ?? 'N/A') ?>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Correo electrónico</p>
                            <p class="text-gray-800 dark:text-gray-200">
                                <?= htmlspecialchars($user['email'] ?? 'N/A') ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Teléfono</p>
                            <p class="text-gray-800 dark:text-gray-200">
                                <?= htmlspecialchars($user['phone'] ?? $user['telefono'] ?? 'N/A') ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Fecha de nacimiento</p>
                            <p class="text-gray-800 dark:text-gray-200">
                                <?= isset($user['birth_date']) ? date('d/m/Y', strtotime($user['birth_date'])) : 'N/A' ?>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Género</p>
                            <p class="text-gray-800 dark:text-gray-200">
                                <?= htmlspecialchars($user['gender'] ?? $user['genero'] ?? 'N/A') ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información académica -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 mt-6" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center">
                        <i data-feather="book-open" class="w-5 h-5 mr-2 text-indigo-600"></i>
                        Información Académica
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Carrera</p>
                        <p class="text-gray-800 dark:text-gray-200">
                            Ingeniería en Sistemas Computacionales
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Semestre actual</p>
                        <p class="text-gray-800 dark:text-gray-200">
                            6° Semestre
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Promedio general</p>
                        <p class="text-gray-800 dark:text-gray-200">
                            8.5
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Créditos acumulados</p>
                        <p class="text-gray-800 dark:text-gray-200">
                            162 / 240
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel lateral -->
        <div class="lg:col-span-1">
            <!-- Acciones rápidas -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 mb-6" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i data-feather="zap" class="w-5 h-5 mr-2 text-indigo-600"></i>
                    Acciones Rápidas
                </h3>

                <div class="space-y-3">
                    <a href="/src/plataforma/app/student/profile/edit" class="w-full flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
                        <i data-feather="edit-2" class="w-4 h-4 mr-2"></i>
                        Editar perfil
                    </a>
                    <a href="/src/plataforma/app/calificaciones" class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                        <i data-feather="award" class="w-4 h-4 mr-2"></i>
                        Ver calificaciones
                    </a>
                    <a href="/src/plataforma/app/horario" class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                        <i data-feather="calendar" class="w-4 h-4 mr-2"></i>
                        Ver horario
                    </a>
                </div>
            </div>

            <!-- Configuración de cuenta -->
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                    <i data-feather="settings" class="w-5 h-5 mr-2 text-indigo-600"></i>
                    Configuración
                </h3>

                <div class="space-y-3">
                    <button class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                        <i data-feather="lock" class="w-4 h-4 mr-2"></i>
                        Cambiar contraseña
                    </button>
                    <button class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                        <i data-feather="bell" class="w-4 h-4 mr-2"></i>
                        Notificaciones
                    </button>
                    <button class="w-full flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                        <i data-feather="shield" class="w-4 h-4 mr-2"></i>
                        Privacidad
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    AOS.init();
    feather.replace();
</script>
