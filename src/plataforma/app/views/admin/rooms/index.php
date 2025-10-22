<?php
global $pdo;
$conn = $pdo;

/* ===== Parámetros ===== */
$buscar       = $_GET['q'] ?? '';
$building     = $_GET['building'] ?? '';
$type         = $_GET['type'] ?? '';
$status       = $_GET['status'] ?? '';
$page         = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit        = 10;
$offset       = ($page - 1) * $limit;

/* ===== WHERE dinámico ===== */
$where  = [];
$params = [];

if ($buscar !== '') {
    $where[] = "(r.name LIKE :buscar OR r.building LIKE :buscar OR r.floor LIKE :buscar)";
    $params[':buscar'] = "%{$buscar}%";
}

if ($building !== '') {
    $where[] = "r.building = :building";
    $params[':building'] = $building;
}

if ($type !== '') {
    $where[] = "r.type = :type";
    $params[':type'] = $type;
}

if ($status !== '') {
    $where[] = "r.status = :status";
    $params[':status'] = $status;
}

$whereClause = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

/* ===== Total ===== */
$queryTotal = "SELECT COUNT(*) AS total FROM rooms r {$whereClause}";
$stmt = $conn->prepare($queryTotal);
$stmt->execute($params);
$total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = max(1, (int)ceil($total / $limit));

/* ===== Listado ===== */
$query = "
    SELECT
        r.id, r.name, r.building, r.floor, r.capacity, r.type, r.equipment, r.status, r.created_at
    FROM rooms r
    {$whereClause}
    ORDER BY r.building ASC, r.floor ASC, r.name ASC
    LIMIT {$offset}, {$limit}
";
$stmt = $conn->prepare($query);
$stmt->execute($params);
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ===== Filtros ===== */
$buildings = $conn->query("SELECT DISTINCT building FROM rooms WHERE building IS NOT NULL AND building <> '' ORDER BY building ASC")->fetchAll(PDO::FETCH_COLUMN);
$types = ['classroom' => 'Aula', 'laboratory' => 'Laboratorio', 'auditorium' => 'Auditorio', 'office' => 'Oficina', 'other' => 'Otro'];
?>

<main class="p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold mb-2">Salones</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Administra los salones y espacios disponibles.</p>
        </div>
        <a href="/src/plataforma/app/admin/rooms/create"
           class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2 w-full sm:w-auto justify-center">
            <i data-feather="plus"></i>
            Nuevo Salón
        </a>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 mb-6">
        <form class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label for="q" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Buscar</label>
                <div class="relative">
                    <input type="text" name="q" id="q" value="<?= htmlspecialchars($buscar) ?>"
                           placeholder="Nombre, edificio, piso…"
                           class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 pr-10 focus:border-primary-500 focus:ring-primary-500">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i data-feather="search" class="h-5 w-5 text-neutral-400"></i>
                    </div>
                </div>
            </div>

            <div>
                <label for="building" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Edificio</label>
                <select name="building" id="building"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos los edificios</option>
                    <?php foreach ($buildings as $b): ?>
                        <option value="<?= htmlspecialchars($b) ?>" <?= $building === $b ? 'selected' : '' ?>>
                            <?= htmlspecialchars($b) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="type" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo</label>
                <select name="type" id="type"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos los tipos</option>
                    <?php foreach ($types as $value => $label): ?>
                        <option value="<?= $value ?>" <?= $type === $value ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
                <select name="status" id="status"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos los estados</option>
                    <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactivo</option>
                    <option value="maintenance" <?= $status === 'maintenance' ? 'selected' : '' ?>>Mantenimiento</option>
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

    <!-- Tabla de salones -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Salón</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Edificio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Capacidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estado</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                    <?= htmlspecialchars($room['name']) ?>
                                </div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                    Piso <?= htmlspecialchars($room['floor'] ?? '') ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($room['building'] ?? '') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?php
                                switch ($room['type']) {
                                    case 'classroom':
                                        echo 'Aula';
                                        break;
                                    case 'laboratory':
                                        echo 'Laboratorio';
                                        break;
                                    case 'auditorium':
                                        echo 'Auditorio';
                                        break;
                                    case 'office':
                                        echo 'Oficina';
                                        break;
                                    default:
                                        echo 'Otro';
                                }
                                ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= (int)($room['capacity'] ?? 0) ?> personas
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    <?php
                                    switch ($room['status']) {
                                        case 'active':
                                            echo 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                            break;
                                        case 'maintenance':
                                            echo 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
                                            break;
                                        default:
                                            echo 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                                    }
                                    ?>">
                                    <?php
                                    switch ($room['status']) {
                                        case 'active':
                                            echo 'Activo';
                                            break;
                                        case 'maintenance':
                                            echo 'Mantenimiento';
                                            break;
                                        default:
                                            echo 'Inactivo';
                                    }
                                    ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3">
                                    <a href="/src/plataforma/app/admin/rooms/<?= (int)$room['id'] ?>/schedule"
                                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Horario</a>
                                    <a href="/src/plataforma/app/admin/rooms/<?= (int)$room['id'] ?>/edit"
                                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Editar</a>
                                    <button onclick="confirmDelete(<?= (int)$room['id'] ?>)"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($rooms)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                                No se encontraron salones
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
                    <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&building=<?= urlencode($building) ?>&type=<?= urlencode($type) ?>&status=<?= urlencode($status) ?>" 
                       class="relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                        Anterior
                    </a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&building=<?= urlencode($building) ?>&type=<?= urlencode($type) ?>&status=<?= urlencode($status) ?>" 
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
                            <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&building=<?= urlencode($building) ?>&type=<?= urlencode($type) ?>&status=<?= urlencode($status) ?>" 
                               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
                                <span class="sr-only">Previous</span>
                                <i data-feather="chevron-left" class="h-5 w-5"></i>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <a href="?page=<?= $i ?>&q=<?= urlencode($buscar) ?>&building=<?= urlencode($building) ?>&type=<?= urlencode($type) ?>&status=<?= urlencode($status) ?>" 
                               class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium <?= $i === $page ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&building=<?= urlencode($building) ?>&type=<?= urlencode($type) ?>&status=<?= urlencode($status) ?>" 
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

    document.querySelectorAll('select[name="building"], select[name="type"], select[name="status"]').forEach(select => {
        select.addEventListener('change', () => {
            select.closest('form').submit();
        });
    });

    function confirmDelete(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este salón? Esta acción no se puede deshacer.')) {
            window.location.href = `/src/plataforma/app/admin/rooms/${id}/delete`;
        }
    }
</script>