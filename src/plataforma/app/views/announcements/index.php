<?php 
$layout = $_SESSION['user_role'] . '.php';
require_once __DIR__ . '/../layouts/' . $layout;

// Anuncios reales basados en búsqueda reciente (Octubre 2025)
$anuncios = [
    [
        'tipo' => 'urgente',
        'titulo' => 'Conmemoración de la Masacre de Tlatelolco 1968',
        'mensaje' => 'El 2 de octubre se conmemora la masacre de Tlatelolco 1968. Participa en las actividades organizadas por la UTSC para reflexionar sobre este evento histórico.<grok-card data-id="400225" data-type="citation_card"></grok-card>',
        'fecha' => 'Hace 1 día',
        'color' => 'red',
        'comentarios' => 3,
        'imagen' => '/src/plataforma/app/img/events/tlatelolco.jpg'
    ],
    [
        'tipo' => 'academico',
        'titulo' => 'Semana Nacional de la Salud Pública 2025',
        'mensaje' => 'Continúa la Semana Nacional de la Salud Pública 2025 en la UTSC. Participa en talleres y conferencias sobre bienestar y salud comunitaria.<grok-card data-id="916136" data-type="citation_card"></grok-card>',
        'fecha' => 'Hace 25 días',
        'color' => 'blue',
        'comentarios' => 12,
        'imagen' => null
    ],
    [
        'tipo' => 'evento',
        'titulo' => 'Feria de Ciencia y Tecnología 2025',
        'mensaje' => 'No te pierdas la Feria de Ciencia y Tecnología este 20 de octubre. Presentaciones de proyectos, talleres y conferencias con expertos.',
        'fecha' => 'Hace 2 días',
        'color' => 'purple',
        'comentarios' => 8,
        'imagen' => '/src/plataforma/app/img/events/tech-fair.jpg'
    ],
    [
        'tipo' => 'administrativo',
        'titulo' => 'Actualización de Datos Personales',
        'mensaje' => 'Se solicita actualizar datos personales en el sistema antes del 30 de octubre. Revisa tu historial y requisitos.',
        'fecha' => 'Hace 3 días',
        'color' => 'green',
        'comentarios' => 5,
        'imagen' => null
    ]
];
?>

<div class="container px-6 py-8">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-rose-600 to-pink-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="bell" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Anuncios</h2>
                <p class="opacity-90">Mantente informado sobre las novedades y avisos importantes</p>
            </div>
        </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 mb-8" data-aos="fade-up">
        <div class="flex flex-wrap gap-4 items-center justify-between">
            <div class="flex flex-wrap gap-4 items-center">
                <div class="relative">
                    <select class="appearance-none bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-primary-500 dark:text-white">
                        <option>Todos los tipos</option>
                        <?php foreach(array_unique(array_column($anuncios, 'tipo')) as $tipo): ?>
                            <option><?php echo ucfirst($tipo); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-neutral-700 dark:text-neutral-300">
                        <i data-feather="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div class="relative">
                    <select class="appearance-none bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-primary-500 dark:text-white">
                        <option>Más recientes</option>
                        <option>Más antiguos</option>
                        <option>Importantes</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-neutral-700 dark:text-neutral-300">
                        <i data-feather="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>
            <div class="relative">
                <input type="text" placeholder="Buscar anuncios..." 
                    class="w-full sm:w-64 pl-10 pr-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:outline-none focus:border-primary-500 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i data-feather="search" class="w-4 h-4 text-neutral-500 dark:text-neutral-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Anuncios -->
    <div class="space-y-6" data-aos="fade-up">
        <?php foreach($anuncios as $anuncio): ?>
            <?php $colorClass = 'border-' . $anuncio['color'] . '-500'; ?>
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden <?php echo $colorClass; ?>-l-4">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-<?php echo $anuncio['color']; ?>-100 dark:bg-<?php echo $anuncio['color']; ?>-900/50 text-<?php echo $anuncio['color']; ?>-700 dark:text-<?php echo $anuncio['color']; ?>-300">
                                <?php echo ucfirst($anuncio['tipo']); ?>
                            </span>
                            <span class="text-sm text-neutral-500 dark:text-neutral-400">
                                <?php echo $anuncio['fecha']; ?>
                            </span>
                        </div>
                        <button class="text-neutral-400 hover:text-neutral-500 dark:text-neutral-500 dark:hover:text-neutral-400">
                            <i data-feather="more-vertical" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">
                        <?php echo htmlspecialchars($anuncio['titulo']); ?>
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-300 mb-4">
                        <?php echo $anuncio['mensaje']; ?>
                    </p>
                    <?php if ($anuncio['imagen']): ?>
                        <img src="<?php echo htmlspecialchars($anuncio['imagen']); ?>" alt="<?php echo htmlspecialchars($anuncio['titulo']); ?>" class="w-full h-48 object-cover rounded-lg mb-4">
                    <?php endif; ?>
                    <div class="flex items-center gap-4 text-sm">
                        <button class="flex items-center gap-1 text-neutral-500 dark:text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                            <i data-feather="message-square" class="w-4 h-4"></i>
                            <span>Comentarios (<?php echo $anuncio['comentarios']; ?>)</span>
                        </button>
                        <button class="flex items-center gap-1 text-neutral-500 dark:text-neutral-400 hover:text-neutral-600 dark:hover:text-neutral-300">
                            <i data-feather="share-2" class="w-4 h-4"></i>
                            <span>Compartir</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Paginación -->
    <div class="mt-8 flex items-center justify-between" data-aos="fade-up">
        <button class="inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800">
            <i data-feather="chevron-left" class="w-4 h-4 mr-2"></i>
            Anterior
        </button>
        <div class="hidden md:flex gap-2">
            <button class="px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg text-sm font-medium text-white bg-primary-600 hover:bg-primary-700">1</button>
            <button class="px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800">2</button>
            <button class="px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800">3</button>
            <span class="px-4 py-2 text-sm text-neutral-500 dark:text-neutral-400">...</span>
            <button class="px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800">8</button>
        </div>
        <button class="inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800">
            Siguiente
            <i data-feather="chevron-right" class="w-4 h-4 ml-2"></i>
        </button>
    </div>
</div>

<script>
    // Inicializar las animaciones y los íconos
    AOS.init();
    feather.replace();

    // Lógica de filtros (simulada)
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', (e) => {
            // Simular filtrado - en producción, enviar AJAX
            console.log('Filtrando por:', e.target.value);
        });
    });

    // Búsqueda en tiempo real
    const searchInput = document.querySelector('input[type="text"]');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            // Simular búsqueda - en producción, AJAX
            console.log('Buscando:', e.target.value);
        });
    }
</script>