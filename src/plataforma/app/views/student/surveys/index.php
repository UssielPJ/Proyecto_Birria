<?php
// Variables esperadas desde el controlador:
// $user, $surveys
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-teal-600 to-cyan-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="clipboard" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Encuestas</h2>
                <p class="opacity-90">Participa en las encuestas disponibles y ayuda a mejorar tu experiencia educativa</p>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-teal-200" data-aos="fade-up">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-teal-600 dark:text-teal-300 text-sm font-medium">Encuestas disponibles</p>
                    <h3 class="text-3xl font-bold mt-1 text-teal-800 dark:text-teal-100">5</h3>
                </div>
                <div class="p-4 rounded-xl bg-teal-100 dark:bg-neutral-700">
                    <i data-feather="clipboard" class="w-8 h-8 text-teal-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-green-200" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-green-600 dark:text-green-300 text-sm font-medium">Encuestas completadas</p>
                    <h3 class="text-3xl font-bold mt-1 text-green-800 dark:text-green-100">12</h3>
                </div>
                <div class="p-4 rounded-xl bg-green-100 dark:bg-neutral-700">
                    <i data-feather="check-circle" class="w-8 h-8 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-amber-200" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-amber-600 dark:text-amber-300 text-sm font-medium">Pendientes</p>
                    <h3 class="text-3xl font-bold mt-1 text-amber-800 dark:text-amber-100">5</h3>
                </div>
                <div class="p-4 rounded-xl bg-amber-100 dark:bg-neutral-700">
                    <i data-feather="clock" class="w-8 h-8 text-amber-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-purple-200" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-purple-600 dark:text-purple-300 text-sm font-medium">Puntos acumulados</p>
                    <h3 class="text-3xl font-bold mt-1 text-purple-800 dark:text-purple-100">240</h3>
                </div>
                <div class="p-4 rounded-xl bg-purple-100 dark:bg-neutral-700">
                    <i data-feather="award" class="w-8 h-8 text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestañas -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg mb-6" data-aos="fade-up">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex -mb-px">
                <button class="py-4 px-6 text-center border-b-2 border-teal-500 font-medium text-teal-600 dark:text-teal-300 focus:outline-none" data-tab="available">
                    Disponibles
                </button>
                <button class="py-4 px-6 text-center border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none" data-tab="completed">
                    Completadas
                </button>
            </nav>
        </div>

        <!-- Encuestas disponibles -->
        <div class="p-6" data-content="available">
            <div class="space-y-4">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-5 hover:shadow-md transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mr-3">
                                        Encuesta de Satisfacción <?= $i ?>
                                    </h3>
                                    <span class="px-2 py-1 text-xs rounded-full bg-amber-100 dark:bg-amber-900 text-amber-800 dark:text-amber-300">
                                        <?= $i <= 2 ? 'Urgente' : 'Normal' ?>
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 mb-2">
                                    Ayúdanos a mejorar la calidad educativa respondiendo esta breve encuesta sobre tu experiencia.
                                </p>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
                                    Disponible hasta: <?= date('d/m/Y', strtotime("+$i weeks")) ?>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <i data-feather="clock" class="w-4 h-4 mr-1"></i>
                                    Duración aproximada: 5-10 minutos
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <a href="/src/plataforma/app/surveys/take/<?= $i ?>" class="inline-flex items-center justify-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition-colors">
                                    <i data-feather="edit-3" class="w-4 h-4 mr-1"></i>
                                    Responder encuesta
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Encuestas completadas -->
        <div class="p-6 hidden" data-content="completed">
            <div class="space-y-4">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-5">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mr-3">
                                        Encuesta Completada <?= $i ?>
                                    </h3>
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300">
                                        Completada
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 mb-2">
                                    Gracias por participar en esta encuesta. Tu opinión es muy importante para nosotros.
                                </p>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
                                    Respondida el: <?= date('d/m/Y', strtotime("-$i weeks")) ?>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    <i data-feather="award" class="w-4 h-4 mr-1"></i>
                                    Puntos obtenidos: <?= $i * 10 ?>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <button class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                                    <i data-feather="eye" class="w-4 h-4 mr-1"></i>
                                    Ver respuestas
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>

<script>
    AOS.init();
    feather.replace();

    // Cambiar entre pestañas
    document.querySelectorAll('[data-tab]').forEach(tab => {
        tab.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');

            // Actualizar pestañas
            document.querySelectorAll('[data-tab]').forEach(t => {
                t.classList.remove('border-teal-500', 'text-teal-600', 'dark:text-teal-300');
                t.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });
            this.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            this.classList.add('border-teal-500', 'text-teal-600', 'dark:text-teal-300');

            // Mostrar contenido correspondiente
            document.querySelectorAll('[data-content]').forEach(content => {
                content.classList.add('hidden');
            });
            document.querySelector(`[data-content="${tabName}"]`).classList.remove('hidden');
        });
    });
</script>
