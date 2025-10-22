<?php
global $pdo;
$conn = $pdo;

/* ===== Parámetros ===== */
$buscar       = $_GET['q'] ?? '';
$group        = $_GET['group'] ?? '';
$status       = $_GET['status'] ?? '';
$page         = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit        = 10;
$offset       = ($page - 1) * $limit;

/* ===== WHERE dinámico ===== */
$where  = [];
$params = [];

if ($buscar !== '') {
    $where[] = "(u.name LIKE :buscar OR u.email LIKE :buscar OR g.name LIKE :buscar)";
    $params[':buscar'] = "%{$buscar}%";
}

if ($group !== '') {
    $where[] = "ga.group_id = :group";
    $params[':group'] = (int)$group;
}

if ($status !== '') {
    $where[] = "ga.status = :status";
    $params[':status'] = $status;
}

$whereClause = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

/* ===== Total ===== */
$queryTotal = "SELECT COUNT(*) AS total FROM group_assignments ga {$whereClause}";
$stmt = $conn->prepare($queryTotal);
$stmt->execute($params);
$total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = max(1, (int)ceil($total / $limit));

/* ===== Listado ===== */
$query = "
    SELECT
        ga.id, ga.assigned_at, ga.status,
        u.id as student_id, u.name as student_name, u.email as student_email,
        g.id as group_id, g.name as group_name,
        c.name as career_name,
        s.name as semester_name
    FROM group_assignments ga
    LEFT JOIN users u ON ga.student_id = u.id
    LEFT JOIN groups g ON ga.group_id = g.id
    LEFT JOIN careers c ON g.career_id = c.id
    LEFT JOIN semesters s ON g.semester_id = s.id
    {$whereClause}
    ORDER BY ga.assigned_at DESC
    LIMIT {$offset}, {$limit}
";
$stmt = $conn->prepare($query);
$stmt->execute($params);
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ===== Filtros ===== */
$groups = $conn->query("SELECT id, name FROM groups ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold mb-2">Asignaciones a Grupos</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Administra las asignaciones de estudiantes a grupos.</p>
        </div>
        <a href="/src/plataforma/app/admin/group_assignments/create"
           class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2 w-full sm:w-auto justify-center">
            <i data-feather="plus"></i>
            Nueva Asignación
        </a>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 mb-6">
        <form class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="q" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Buscar</label>
                <div class="relative">
                    <input type="text" name="q" id="q" value="<?= htmlspecialchars($buscar) ?>"
                           placeholder="Estudiante, email o grupo…"
                           class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 pr-10 focus:border-primary-500 focus:ring-primary-500">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i data-feather="search" class="h-5 w-5 text-neutral-400"></i>
                    </div>
                </div>
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
                <label for="status" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
                <select name="status" id="status"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos los estados</option>
                    <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactivo</option>
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

    <!-- Tabla de asignaciones -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estudiante</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Grupo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Carrera</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Semestre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Fecha de Asignación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estado</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    <?php foreach ($assignments as $assignment): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                    <?= htmlspecialchars($assignment['student_name'] ?? 'N/A') ?>
                                </div>
                                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                    <?= htmlspecialchars($assignment['student_email'] ?? '') ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($assignment['group_name'] ?? '') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($assignment['career_name'] ?? '') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($assignment['semester_name'] ?? '') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= date('d/m/Y', strtotime($assignment['assigned_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    <?php if ($assignment['status'] === 'active'): ?>
                                        bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    <?php else: ?>
                                        bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    <?php endif; ?>">
                                    <?= $assignment['status'] === 'active' ? 'Activo' : 'Inactivo' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3">
                                    <a href="/src/plataforma/app/admin/group_assignments/<?= (int)$assignment['id'] ?>/edit"
                                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Editar</a>
                                    <button onclick="confirmDelete(<?= (int)$assignment['id'] ?>)"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Eliminar</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($assignments)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                                No se encontraron asignaciones
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
                    <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&group=<?= urlencode($group) ?>&status=<?= urlencode($status) ?>" 
                       class="relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                        Anterior
                    </a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&group=<?= urlencode($group) ?>&status=<?= urlencode($status) ?>" 
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
                            <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&group=<?= urlencode($group) ?>&status=<?= urlencode($status) ?>" 
                               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
                                <span class="sr-only">Previous</span>
                                <i data-feather="chevron-left" class="h-5 w-5"></i>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <a href="?page=<?= $i ?>&q=<?= urlencode($buscar) ?>&group=<?= urlencode($group) ?>&status=<?= urlencode($status) ?>" 
                               class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium <?= $i === $page ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&group=<?= urlencode($group) ?>&status=<?= urlencode($status) ?>" 
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

    document.querySelectorAll('select[name="group"], select[name="status"]').forEach(select => {
        select.addEventListener('change', () => {
            select.closest('form').submit();
        });
    });

    function confirmDelete(id) {
        if (confirm('¿Estás seguro de que deseas eliminar esta asignación? Esta acción no se puede deshacer.')) {
            window.location.href = `/src/plataforma/app/admin/group_assignments/${id}/delete`;
        }
    }
</script>