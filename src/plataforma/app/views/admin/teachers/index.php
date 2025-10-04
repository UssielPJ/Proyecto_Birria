<?php
require_once __DIR__ . '/../../layouts/admin.php';

// Obtener parámetros de búsqueda y filtrado
$buscar = $_GET['q'] ?? '';
$departamento = $_GET['departamento'] ?? '';
$estado = $_GET['estado'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Construir la consulta
$where = [];
$params = [];

if ($buscar) {
    $where[] = "(nombre LIKE :buscar OR email LIKE :buscar OR num_empleado LIKE :buscar)";
    $params[':buscar'] = "%$buscar%";
}

if ($departamento) {
    $where[] = "departamento = :departamento";
    $params[':departamento'] = $departamento;
}

if ($estado) {
    $where[] = "estado = :estado";
    $params[':estado'] = $estado;
}

$whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Consulta para obtener el total
$queryTotal = "SELECT COUNT(*) as total FROM profesores $whereClause";
$stmt = $conn->prepare($queryTotal);
$stmt->execute($params);
$total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($total / $limit);

// Consulta para obtener los profesores
$query = "
    SELECT * FROM profesores 
    $whereClause 
    ORDER BY nombre ASC 
    LIMIT $offset, $limit
";

$stmt = $conn->prepare($query);
$stmt->execute($params);
$profesores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener lista de departamentos para el filtro
$departamentos = $conn->query("SELECT DISTINCT departamento FROM profesores WHERE departamento IS NOT NULL")->fetchAll(PDO::FETCH_COLUMN);
?>

<main class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold mb-2">Profesores</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Administra el personal docente de la institución.</p>
        </div>
        <a href="/src/plataforma/admin/teachers/create" 
           class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2">
            <i data-feather="user-plus"></i>
            Nuevo profesor
        </a>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 mb-6">
        <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="q" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Buscar
                </label>
                <div class="relative">
                    <input type="text" name="q" id="q" value="<?= htmlspecialchars($buscar) ?>"
                           placeholder="Nombre, email o número de empleado..."
                           class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 pr-10 focus:border-primary-500 focus:ring-primary-500">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i data-feather="search" class="h-5 w-5 text-neutral-400"></i>
                    </div>
                </div>
            </div>

            <div>
                <label for="departamento" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Departamento
                </label>
                <select name="departamento" id="departamento"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos los departamentos</option>
                    <?php foreach ($departamentos as $d): ?>
                        <option value="<?= htmlspecialchars($d) ?>" <?= $departamento === $d ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="estado" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Estado
                </label>
                <select name="estado" id="estado"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos los estados</option>
                    <option value="activo" <?= $estado === 'activo' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactivo" <?= $estado === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                    <option value="sabático" <?= $estado === 'sabático' ? 'selected' : '' ?>>Sabático</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2">
                    <i data-feather="filter"></i>
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de profesores -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Profesor
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            No. Empleado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Departamento
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    <?php foreach ($profesores as $profesor): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <?php if ($profesor['foto']): ?>
                                            <img class="h-10 w-10 rounded-full" src="<?= htmlspecialchars($profesor['foto']) ?>" alt="">
                                        <?php else: ?>
                                            <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                                <i data-feather="user" class="text-primary-600 dark:text-primary-400"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                            <?= htmlspecialchars($profesor['nombre']) ?>
                                        </div>
                                        <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                            <?= htmlspecialchars($profesor['email']) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($profesor['num_empleado']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($profesor['departamento']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $estadoClases = [
                                    'activo' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                    'inactivo' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                    'sabático' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'
                                ];
                                $clase = $estadoClases[$profesor['estado']] ?? 'bg-neutral-100 text-neutral-800';
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $clase ?>">
                                    <?= ucfirst(htmlspecialchars($profesor['estado'])) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-3">
                                    <a href="/src/plataforma/admin/teachers/<?= $profesor['id'] ?>/schedule" 
                                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                        Horario
                                    </a>
                                    <a href="/src/plataforma/admin/teachers/<?= $profesor['id'] ?>" 
                                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                        Ver
                                    </a>
                                    <a href="/src/plataforma/admin/teachers/<?= $profesor['id'] ?>/edit" 
                                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                        Editar
                                    </a>
                                    <button onclick="confirmDelete(<?= $profesor['id'] ?>)" 
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($profesores)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                                No se encontraron profesores
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
                    <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&departamento=<?= urlencode($departamento) ?>&estado=<?= urlencode($estado) ?>" 
                       class="relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                        Anterior
                    </a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&departamento=<?= urlencode($departamento) ?>&estado=<?= urlencode($estado) ?>" 
                       class="ml-3 relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                        Siguiente
                    </a>
                <?php endif; ?>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-neutral-700 dark:text-neutral-400">
                        Mostrando 
                        <span class="font-medium"><?= $offset + 1 ?></span>
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
                            <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&departamento=<?= urlencode($departamento) ?>&estado=<?= urlencode($estado) ?>" 
                               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
                                <span class="sr-only">Previous</span>
                                <i data-feather="chevron-left" class="h-5 w-5"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <a href="?page=<?= $i ?>&q=<?= urlencode($buscar) ?>&departamento=<?= urlencode($departamento) ?>&estado=<?= urlencode($estado) ?>" 
                               class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium <?= $i === $page ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&departamento=<?= urlencode($departamento) ?>&estado=<?= urlencode($estado) ?>" 
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
    // Inicializar los íconos
    feather.replace();

    // Enviar formulario automáticamente al cambiar filtros
    document.querySelectorAll('select[name="departamento"], select[name="estado"]').forEach(select => {
        select.addEventListener('change', () => {
            select.closest('form').submit();
        });
    });

    // Función para confirmar eliminación
    function confirmDelete(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este profesor? Esta acción no se puede deshacer.')) {
            window.location.href = `/src/plataforma/admin/teachers/${id}/delete`;
        }
    }
</script>