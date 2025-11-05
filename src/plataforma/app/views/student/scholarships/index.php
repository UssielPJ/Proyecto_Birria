<?php
// Variables esperadas desde el controlador:
// $user, $scholarships
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="gift" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Becas</h2>
                <p class="opacity-90">Explora las becas disponibles y solicita las que te interesen</p>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-purple-200" data-aos="fade-up">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-purple-600 dark:text-purple-300 text-sm font-medium">Becas disponibles</p>
                    <h3 class="text-3xl font-bold mt-1 text-purple-800 dark:text-purple-100">12</h3>
                </div>
                <div class="p-4 rounded-xl bg-purple-100 dark:bg-neutral-700">
                    <i data-feather="gift" class="w-8 h-8 text-purple-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-green-200" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-green-600 dark:text-green-300 text-sm font-medium">Becas aplicadas</p>
                    <h3 class="text-3xl font-bold mt-1 text-green-800 dark:text-green-100">5</h3>
                </div>
                <div class="p-4 rounded-xl bg-green-100 dark:bg-neutral-700">
                    <i data-feather="send" class="w-8 h-8 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-blue-200" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-blue-600 dark:text-blue-300 text-sm font-medium">Becas activas</p>
                    <h3 class="text-3xl font-bold mt-1 text-blue-800 dark:text-blue-100">2</h3>
                </div>
                <div class="p-4 rounded-xl bg-blue-100 dark:bg-neutral-700">
                    <i data-feather="check-circle" class="w-8 h-8 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-amber-200" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-amber-600 dark:text-amber-300 text-sm font-medium">Descuento total</p>
                    <h3 class="text-3xl font-bold mt-1 text-amber-800 dark:text-amber-100">45%</h3>
                </div>
                <div class="p-4 rounded-xl bg-amber-100 dark:bg-neutral-700">
                    <i data-feather="percent" class="w-8 h-8 text-amber-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestañas -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg mb-6" data-aos="fade-up">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex -mb-px">
                <button class="py-4 px-6 text-center border-b-2 border-purple-500 font-medium text-purple-600 dark:text-purple-300 focus:outline-none" data-tab="available">
                    Becas disponibles
                </button>
                <button class="py-4 px-6 text-center border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none" data-tab="applied">
                    Becas aplicadas
                </button>
                <button class="py-4 px-6 text-center border-b-2 border-transparent font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 focus:outline-none" data-tab="active">
                    Becas activas
                </button>
            </nav>
        </div>

        <!-- Becas disponibles -->
        <div class="p-6" data-content="available">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="h-40 bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                            <i data-feather="gift" class="w-16 h-16 text-white"></i>
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                                Beca Ejemplo <?= $i ?>
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                Descripción breve de la beca y los requisitos para solicitarla.
                            </p>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    Descuento: <?= 10 * $i ?>%
                                </span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    Plazo: 15 días
                                </span>
                            </div>
                            <button class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors">
                                Solicitar
                            </button>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Becas aplicadas -->
        <div class="p-6 hidden" data-content="applied">
            <div class="space-y-4">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-neutral-700 flex items-center justify-center mr-4">
                                <i data-feather="send" class="w-6 h-6 text-gray-500 dark:text-gray-400"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-white">
                                    Beca Aplicada <?= $i ?>
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Aplicada el <?= date('d/m/Y', strtotime("-$i days")) ?>
                                </p>
                            </div>
                        </div>
                        <span class="px-3 py-1 text-xs rounded-full bg-amber-100 dark:bg-amber-900 text-amber-800 dark:text-amber-300">
                            En revisión
                        </span>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Becas activas -->
        <div class="p-6 hidden" data-content="active">
            <div class="space-y-4">
                <?php for ($i = 1; $i <= 2; $i++): ?>
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mr-4">
                                    <i data-feather="check-circle" class="w-6 h-6 text-green-600 dark:text-green-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-white">
                                        Beca Activa <?= $i ?>
                                    </h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Aprobada el <?= date('d/m/Y', strtotime("-$i*10 days")) ?>
                                    </p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300">
                                Activa
                            </span>
                        </div>
                        <div class="bg-gray-50 dark:bg-neutral-700 rounded-lg p-3">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600 dark:text-gray-300">Descuento:</span>
                                <span class="text-sm font-medium text-gray-800 dark:text-white"><?= 10 * $i * 5 ?>%</span>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600 dark:text-gray-300">Vigencia:</span>
                                <span class="text-sm font-medium text-gray-800 dark:text-white"><?= date('d/m/Y', strtotime("+6 months")) ?></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-300">Próxima renovación:</span>
                                <span class="text-sm font-medium text-gray-800 dark:text-white"><?= date('d/m/Y', strtotime("+5 months")) ?></span>
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
                t.classList.remove('border-purple-500', 'text-purple-600', 'dark:text-purple-300');
                t.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });
            this.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            this.classList.add('border-purple-500', 'text-purple-600', 'dark:text-purple-300');

            // Mostrar contenido correspondiente
            document.querySelectorAll('[data-content]').forEach(content => {
                content.classList.add('hidden');
            });
            document.querySelector(`[data-content="${tabName}"]`).classList.remove('hidden');
        });
    });
</script>
