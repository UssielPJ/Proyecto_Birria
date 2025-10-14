<?php
global $pdo;
$conn = $pdo;

/* ===== Parámetros ===== */
$buscar       = $_GET['q'] ?? '';
$departamento = $_GET['departamento'] ?? ''; // lo mapeamos a area_conocimiento
$semestre     = $_GET['semestre'] ?? '';
$page         = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit        = 10;
$offset       = ($page - 1) * $limit;

/* ===== WHERE dinámico ===== */
$where  = [];
$params = [];

if ($buscar !== '') {
    // nombre/clave/área
    $where[] = "(nombre LIKE :buscar OR clave LIKE :buscar OR area_conocimiento LIKE :buscar)";
    $params[':buscar'] = "%{$buscar}%";
}

if ($departamento !== '') {
    $where[] = "area_conocimiento = :area";
    $params[':area'] = $departamento;
}

if ($semestre !== '') {
    $where[] = "semestre_sugerido = :sem";
    $params[':sem'] = (int)$semestre;
}

$whereClause = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

/* ===== Total ===== */
$queryTotal = "SELECT COUNT(*) AS total FROM materias {$whereClause}";
$stmt = $conn->prepare($queryTotal);
$stmt->execute($params);
$total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = max(1, (int)ceil($total / $limit));

/* ===== Listado ===== */
$query = "
    SELECT 
        id, clave, nombre, descripcion, creditos, horas_semana,
        semestre_sugerido, tipo, area_conocimiento, carrera_id, status, created_at, updated_at,
        NULL AS profesor_nombre -- placeholder
    FROM materias
    {$whereClause}
    ORDER BY nombre ASC
    LIMIT {$offset}, {$limit}
";
$stmt = $conn->prepare($query);
$stmt->execute($params);
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ===== Filtro de 'departamento' (área de conocimiento) ===== */
$departamentos = $conn
    ->query("SELECT DISTINCT area_conocimiento 
             FROM materias 
             WHERE area_conocimiento IS NOT NULL AND area_conocimiento <> ''
             ORDER BY area_conocimiento ASC")
    ->fetchAll(PDO::FETCH_COLUMN);
?>

<main class="p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold mb-2">Materias</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Administra las materias y sus asignaciones.</p>
        </div>
        <a href="/src/plataforma/app/admin/subjects/create"
           class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2 w-full sm:w-auto justify-center">
            <i data-feather="plus"></i>
            Nueva materia
        </a>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 mb-6">
        <form class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="q" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Buscar</label>
                <div class="relative">
                    <input type="text" name="q" id="q" value="<?= htmlspecialchars($buscar) ?>"
                           placeholder="Nombre, clave o área…"
                           class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 pr-10 focus:border-primary-500 focus:ring-primary-500">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i data-feather="search" class="h-5 w-5 text-neutral-400"></i>
                    </div>
                </div>
            </div>

            <div>
                <label for="departamento" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Área de conocimiento
                </label>
                <select name="departamento" id="departamento"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todas las áreas</option>
                    <?php foreach ($departamentos as $d): ?>
                        <option value="<?= htmlspecialchars($d) ?>" <?= $departamento === $d ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="semestre" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre sugerido</label>
                <select name="semestre" id="semestre"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos</option>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?= $i ?>" <?= ($semestre !== '' && (int)$semestre === $i) ? 'selected' : '' ?>>
                            <?= $i ?>° Semestre
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2 w-full sm:w-auto justify-center">
                    <i data-feather="filter"></i>
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de materias -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Materia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Clave</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Área</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Semestre sugerido</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Profesor</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    <?php foreach ($materias as $materia): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                    <?= htmlspecialchars($materia['nombre']) ?>
                                </div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                    <?= (int)($materia['creditos'] ?? 0) ?> créditos
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($materia['clave'] ?? '') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($materia['area_conocimiento'] ?? '') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= (int)($materia['semestre_sugerido'] ?? 1) ?>° Semestre
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if (!empty($materia['profesor_nombre'])): ?>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                                <i data-feather="user" class="h-4 w-4 text-primary-600 dark:text-primary-400"></i>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                                <?= htmlspecialchars($materia['profesor_nombre']) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <span class="text-sm text-neutral-500 dark:text-neutral-400">Sin asignar</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3">
                                    <a href="/src/plataforma/app/admin/subjects/<?= (int)$materia['id'] ?>/schedule" 
                                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Horario</a>
                                    <a href="/src/plataforma/app/admin/subjects/<?= (int)$materia['id'] ?>" 
                                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Ver</a>
                                    <a href="/src/plataforma/app/admin/subjects/<?= (int)$materia['id'] ?>/edit" 
                                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Editar</a>
                                    <button onclick="confirmDelete(<?= (int)$materia['id'] ?>)" 
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($materias)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                                No se encontraron materias
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <?php if ($totalPages > 1): ?>
        <div class="bg-neutral-50 dark:bg-neutral-800 px-4 py-3 flex items-center justify-between border-t border-neutral-200 dark:border-neutral-700 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&departamento=<?= urlencode($departamento) ?>&semestre=<?= urlencode($semestre) ?>" 
                       class="relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                        Anterior
                    </a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&departamento=<?= urlencode($departamento) ?>&semestre=<?= urlencode($semestre) ?>" 
                       class="ml-3 relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                        Siguiente
                    </a>
                <?php endif; ?>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-neutral-700 dark:text-neutral-400">
                        Mostrando 
                        <span class="font-medium"><?= $total ? ($offset + 1) : 0 ?></span>
                        a 
                        <span class="font-medium"><?= min($offset + $limit, $total) ?></span>
                        de 
                        <span class="font-medium"><?= $total ?></span>
                        resultados
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&departamento=<?= urlencode($departamento) ?>&semestre=<?= urlencode($semestre) ?>" 
                               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
                                <span class="sr-only">Previous</span>
                                <i data-feather="chevron-left" class="h-5 w-5"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <a href="?page=<?= $i ?>&q=<?= urlencode($buscar) ?>&departamento=<?= urlencode($departamento) ?>&semestre=<?= urlencode($semestre) ?>" 
                               class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium <?= $i === $page ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&departamento=<?= urlencode($departamento) ?>&semestre=<?= urlencode($semestre) ?>" 
                               class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
                                <span class="sr-only">Next</span>
                                <i data-feather="chevron-right" class="h-5 w-5"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<script>
    feather.replace();

    document.querySelectorAll('select[name="departamento"], select[name="semestre"]').forEach(select => {
        select.addEventListener('change', () => {
            select.closest('form').submit();
        });
    });

    function confirmDelete(id) {
        if (confirm('¿Estás seguro de que deseas eliminar esta materia? Esta acción no se puede deshacer.')) {
            window.location.href = `/src/plataforma/app/admin/subjects/${id}/delete`;
        }
    }
</script>
