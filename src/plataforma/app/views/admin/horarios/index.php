<?php
/** @var array $grupos */
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

function badgeEstado(?string $estado): string {
    $estado = $estado ?? 'sin';

    switch ($estado) {
        case 'publicado':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-2"></span>Publicado
                    </span>';
        case 'borrador':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-2"></span>Borrador
                    </span>';
        default:
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-neutral-700 dark:text-gray-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400 mr-2"></span>Sin generar
                    </span>';
    }
}
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 rounded-xl p-6 text-white mb-8 shadow-lg" data-aos="fade-up">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/15 rounded-2xl">
                    <i data-feather="clock" class="w-8 h-8"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold mb-1">
                        Gestión de horarios por grupo
                    </h1>
                    <p class="text-sm md:text-base text-white/90">
                        Genera automáticamente los horarios, ajusta manualmente y publícalos para alumnos y docentes.
                    </p>
                </div>
            </div>
            <div class="hidden md:flex flex-col items-end text-sm text-white/80">
                <span class="font-semibold">Vista: Administrador</span>
                <span class="text-xs opacity-80">Módulo de Horarios UTSC</span>
            </div>
        </div>
    </div>

    <!-- Filtros / barra superior -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-md p-4 mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3" data-aos="fade-up">
        <div class="flex items-center gap-3">
            <div class="relative">
                <i data-feather="search" class="w-4 h-4 text-gray-400 dark:text-gray-500 absolute left-3 top-2.5"></i>
                <input type="text"
                       id="horarios-search"
                       placeholder="Buscar grupo por código o título..."
                       class="pl-9 pr-3 py-2 rounded-lg border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-sm text-gray-800 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/60 focus:border-indigo-500/60">
            </div>
        </div>
        <div class="flex items-center gap-2 justify-end">
            <!-- Filtro por estado -->
            <div class="flex items-center gap-2">
                <label for="horarios-filtro-estado" class="text-xs text-gray-500 dark:text-gray-300">
                    Estado:
                </label>
                <select id="horarios-filtro-estado"
                        class="px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 dark:text-gray-100 border border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 focus:outline-none focus:ring-2 focus:ring-indigo-500/60">
                    <option value="todos">Todos</option>
                    <option value="con">Con horario</option>
                    <option value="sin">Sin generar</option>
                </select>
            </div>

            <!-- Configuración (placeholder simple) -->
            <button id="horarios-config-btn"
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-medium text-gray-600 dark:text-gray-200 border border-gray-200 dark:border-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-700/60">
                <i data-feather="sliders" class="w-4 h-4"></i>
                Configuración
            </button>
        </div>
    </div>

    <!-- Tabla de grupos -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="50">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <thead class="bg-gray-50 dark:bg-neutral-800/80">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Grupo
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Título
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Estado del horario
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Última actualización
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-gray-100 dark:divide-neutral-700">

                <?php if (empty($grupos)): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-300">
                            No hay grupos registrados aún. Crea grupos primero para poder generar horarios.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($grupos as $g): ?>
                        <?php
                        $estado      = $g->estado_horario ?? 'sin';
                        $ultima      = $g->ultima_actualizacion ?? null;
                        $ultimaTexto = $ultima ? date('d/m/Y H:i', strtotime($ultima)) : '—';
                        $totalClases = $g->total_clases ?? null;
                        ?>
                        <tr class="hover:bg-gray-50/70 dark:hover:bg-neutral-700/40 transition-colors"
                            data-row="grupo-horario"
                            data-grupo="<?= $esc($g->codigo ?? '') ?>"
                            data-titulo="<?= $esc($g->titulo ?? '') ?>"
                            data-estado="<?= $esc($estado) ?>">
                            <!-- Grupo -->
                            <td class="px-4 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-9 h-9 rounded-full bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 text-xs font-semibold">
                                        <?= strtoupper(substr($esc($g->codigo ?? '?'), 0, 2)) ?>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                            <?= $esc($g->codigo ?? 'S/COD') ?>
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            ID #<?= $esc($g->id ?? '') ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Título -->
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                <?= $esc($g->titulo ?? '—') ?>
                            </td>

                            <!-- Estado -->
                            <td class="px-4 py-4 whitespace-nowrap text-sm">
                                <?= badgeEstado($estado) ?>
                                <?php if ($totalClases !== null): ?>
                                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        <?= (int)$totalClases ?> bloques asignados
                                    </div>
                                <?php endif; ?>
                            </td>

                            <!-- Última actualización -->
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                <?= $esc($ultimaTexto) ?>
                            </td>

                            <!-- Acciones -->
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-center">
                                <div class="flex flex-wrap justify-center gap-2">

                                    <!-- Configurar horas por semana -->
                                    <a href="/src/plataforma/app/admin/horarios/configurar-horas/<?= $esc($g->id) ?>"
                                       class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium border border-gray-200 dark:border-neutral-700 text-gray-700 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-neutral-700/70">
                                        <i data-feather="sliders" class="w-3.5 h-3.5"></i>
                                        Horas/semana
                                    </a>

                                    <!-- Generar / editar horario -->
                                    <?php if ($estado === 'sin'): ?>
                                        <a href="/src/plataforma/app/admin/horarios/generar/<?= $esc($g->id) ?>"
                                           class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm">
                                            <i data-feather="sparkles" class="w-3.5 h-3.5"></i>
                                            Generar horario
                                        </a>
                                    <?php else: ?>
                                        <a href="/src/plataforma/app/admin/horarios/vista-previa/<?= $esc($g->id) ?>"
                                           class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm">
                                            <i data-feather="edit-3" class="w-3.5 h-3.5"></i>
                                            Editar horario
                                        </a>
                                    <?php endif; ?>

                                    <!-- Ver como alumno -->
                                    <a href="/src/plataforma/app/admin/groups/horario/<?= $esc($g->id) ?>"
                                       class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-indigo-600 dark:text-indigo-300 hover:bg-indigo-50 dark:hover:bg-neutral-700/60">
                                        <i data-feather="eye" class="w-3.5 h-3.5"></i>
                                        Ver horario
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Pie / leyenda pequeña -->
    <div class="mt-4 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2" data-aos="fade-up" data-aos-delay="80">
        <i data-feather="info" class="w-3.5 h-3.5"></i>
        <span>
            Usa <strong>Horas/semana</strong> para definir la carga de cada materia antes de generar el horario automático.
        </span>
    </div>
</div>

<script>
    AOS.init();
    feather.replace();

    (function () {
        const searchInput   = document.getElementById('horarios-search');
        const filtroEstado  = document.getElementById('horarios-filtro-estado');
        const rows          = document.querySelectorAll('tr[data-row="grupo-horario"]');

        function normalizar(str) {
            return (str || '').toString().toLowerCase();
        }

        function aplicarFiltros() {
            const q   = normalizar(searchInput ? searchInput.value : '');
            const est = filtroEstado ? filtroEstado.value : 'todos';

            rows.forEach(tr => {
                const codigo = normalizar(tr.getAttribute('data-grupo'));
                const titulo = normalizar(tr.getAttribute('data-titulo'));
                const estado = tr.getAttribute('data-estado') || 'sin';

                let ok = true;

                // Filtro de texto
                if (q && !(codigo.includes(q) || titulo.includes(q))) {
                    ok = false;
                }

                // Filtro por estado
                if (est === 'con' && estado === 'sin') {
                    ok = false;
                }
                if (est === 'sin' && estado !== 'sin') {
                    ok = false;
                }

                tr.style.display = ok ? '' : 'none';
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', aplicarFiltros);
        }
        if (filtroEstado) {
            filtroEstado.addEventListener('change', aplicarFiltros);
        }

        const configBtn = document.getElementById('horarios-config-btn');
        if (configBtn) {
            configBtn.addEventListener('click', function () {
                alert('Aquí podrías abrir una configuración avanzada (rangos de horas, días activos, etc.). Por ahora es solo un placeholder.');
            });
        }
    })();
</script>
