<?php
global $pdo;
$conn = $pdo;

/* ===== Parámetros ===== */
$buscar       = $_GET['q'] ?? '';
$subject      = $_GET['subject'] ?? '';
$group        = $_GET['group'] ?? '';
$period       = $_GET['period'] ?? '';
$status       = $_GET['status'] ?? '';
$page         = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit        = 10;
$offset       = ($page - 1) * $limit;

/* ===== WHERE dinámico ===== */
$where  = [];
$params = [];

if ($buscar !== '') {
    $where[] = "(s.name LIKE :buscar OR s.code LIKE :buscar OR u.name LIKE :buscar)";
    $params[':buscar'] = "%{$buscar}%";
}

if ($subject !== '') {
    $where[] = "c.subject_id = :subject";
    $params[':subject'] = (int)$subject;
}

if ($group !== '') {
    $where[] = "c.group_id = :group";
    $params[':group'] = (int)$group;
}

if ($period !== '') {
    $where[] = "c.period_id = :period";
    $params[':period'] = (int)$period;
}

if ($status !== '') {
    $where[] = "c.status = :status";
    $params[':status'] = $status;
}

$whereClause = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

/* ===== Total ===== */
$queryTotal = "SELECT COUNT(*) AS total FROM classes c {$whereClause}";
$stmt = $conn->prepare($queryTotal);
$stmt->execute($params);
$total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = max(1, (int)ceil($total / $limit));

/* ===== Listado ===== */
$query = "
    SELECT
        c.id, c.max_students, c.enrolled_students, c.status, c.created_at,
        s.name as subject_name, s.code as subject_code,
        g.name as group_name,
        p.name as period_name,
        u.name as teacher_name,
        r.name as room_name
    FROM classes c
    LEFT JOIN subjects s ON c.subject_id = s.id
    LEFT JOIN groups g ON c.group_id = g.id
    LEFT JOIN periods p ON c.period_id = p.id
    LEFT JOIN users u ON c.teacher_id = u.id
    LEFT JOIN rooms r ON c.room_id = r.id
    {$whereClause}
    ORDER BY c.created_at DESC
    LIMIT {$offset}, {$limit}
";
$stmt = $conn->prepare($query);
$stmt->execute($params);
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ===== Filtros ===== */
$subjects = $conn->query("SELECT id, name, code FROM subjects ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$groups = $conn->query("SELECT id, name FROM groups ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
$periods = $conn->query("SELECT id, name FROM periods ORDER BY year DESC, start_date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold mb-2">Clases</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Administra las clases y asignaciones de profesores.</p>
        </div>
        <a href="/src/plataforma/app/admin/classes/create"
           class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2 w-full sm:w-auto justify-center">
            <i data-feather="plus"></i>
            Nueva Clase
        </a>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 mb-6">
        <form class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <div>
                <label for="q" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Buscar</label>
                <div class="relative">
                    <input type="text" name="q" id="q" value="<?= htmlspecialchars($buscar) ?>"
                           placeholder="Materia, profesor…"
                           class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 pr-10 focus:border-primary-500 focus:ring-primary-500">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i data-feather="search" class="h-5 w-5 text-neutral-400"></i>
                    </div>
                </div>
            </div>

            <div>
                <label for="subject" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Materia</label>
                <select name="subject" id="subject"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todas las materias</option>
                    <?php foreach ($subjects as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= $subject == $s['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['code'] . ' - ' . $s['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="group" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Grupo</label>
                <select name="group" id="group"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos los grupos</option>
                    <?php foreach ($groups as $g): ?>
                        <option value="<?= $g['id'] ?>" <?= $group == $g['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($g['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="period" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Periodo</label>
                <select name="period" id="period"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos los periodos</option>
                    <?php foreach ($periods as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= $period == $p['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
                <select name="status" id="status"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos los estados</option>
                    <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Activa</option>
                    <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactiva</option>
                    <option value="cancelled" <?= $status === 'cancelled' ? 'selected' : '' ?>>Cancelada</option>
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

    <!-- Tabla de clases -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Materia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Grupo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Profesor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Periodo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estudiantes</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estado</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    <?php foreach ($classes as $class): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                    <?= htmlspecialchars($class['subject_name'] ?? '') ?>
                                </div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                    <?= htmlspecialchars($class['subject_code'] ?? '') ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($class['group_name'] ?? '') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($class['teacher_name'] ?? 'Sin asignar') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($class['period_name'] ?? '') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= (int)($class['enrolled_students'] ?? 0) ?>/<?= (int)($class['max_students'] ?? 0) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    <?php
                                    switch ($class['status']) {
                                        case 'active':
                                            echo 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                            break;
                                        case 'cancelled':
                                            echo 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                                            break;
                                        default:
                                            echo 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
                                    }
                                    ?>">
                                    <?php
                                    switch ($class['status']) {
                                        case 'active':
                                            echo 'Activa';
                                            break;
                                        case 'cancelled':
                                            echo 'Cancelada';
                                            break;
                                        default:
                                            echo 'Inactiva';
                                    }
                                    ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3">
                                    <a href="/src/plataforma/app/admin/classes/<?= (int)$class['id'] ?>/students"
                                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Estudiantes</a>
                                    <a href="/src/plataforma/app/admin/classes/<?= (int)$class['id'] ?>/edit"
                                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Editar</a>
                                    <button onclick="confirmDelete(<?= (int)$class['id'] ?>)"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($classes)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                                No se encontraron clases
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
                    <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&subject=<?= urlencode($subject) ?>&group=<?= urlencode($group) ?>&period=<?= urlencode($period) ?>&status=<?= urlencode($status) ?>" 
                       class="relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                        Anterior
                    </a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&subject=<?= urlencode($subject) ?>&group=<?= urlencode($group) ?>&period=<?= urlencode($period) ?>&status=<?= urlencode($status) ?>" 
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
                            <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&subject=<?= urlencode($subject) ?>&group=<?= urlencode($group) ?>&period=<?= urlencode($period) ?>&status=<?= urlencode($status) ?>" 
                               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
                                <span class="sr-only">Previous</span>
                                <i data-feather="chevron-left" class="h-5 w-5"></i>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <a href="?page=<?= $i ?>&q=<?= urlencode($buscar) ?>&subject=<?= urlencode($subject) ?>&group=<?= urlencode($group) ?>&period=<?= urlencode($period) ?>&status=<?= urlencode($status) ?>" 
                               class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium <?= $i === $page ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&subject=<?= urlencode($subject) ?>&group=<?= urlencode($group) ?>&period=<?= urlencode($period) ?>&status=<?= urlencode($status) ?>" 
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

    document.querySelectorAll('select[name="subject"], select[name="group"], select[name="period"], select[name="status"]').forEach(select => {
        select.addEventListener('change', () => {
            select.closest('form').submit();
        });
    });

    function confirmDelete(id) {
        if (confirm('¿Estás seguro de que deseas eliminar esta clase? Esta acción no se puede deshacer.')) {
            window.location.href = `/src/plataforma/app/admin/classes/${id}/delete`;
        }
    }
</script>