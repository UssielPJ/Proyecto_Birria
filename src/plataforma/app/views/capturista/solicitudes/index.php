<?php
// Guard de acceso
if (session_status() === PHP_SESSION_NONE) session_start();
if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
  header('Location: /src/plataforma/'); exit;
}

require_once __DIR__ . '/../../../../config/database.php';

// Obtener solicitudes con paginación
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$filtro = isset($_GET['f']) ? $_GET['f'] : '';
$where = '';
switch($filtro) {
    case 'faltantes':
        $where = "WHERE estado = 'pendiente'";
        break;
    case 'aprobadas':
        $where = "WHERE estado = 'aprobada'";
        break;
    case 'revision':
        $where = "WHERE estado = 'revision'";
        break;
    case 'rechazadas':
        $where = "WHERE estado = 'rechazada'";
        break;
}

// Consulta para obtener el total de registros
$stmt = $conn->query("SELECT COUNT(*) as total FROM solicitudes $where");
$total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($total / $limit);

// Consulta para obtener las solicitudes con join a la tabla alumnos
$query = "SELECT s.*, a.nombre, a.carrera 
          FROM solicitudes s 
          LEFT JOIN alumnos a ON s.alumno_id = a.id 
          $where
          ORDER BY s.fecha_creacion DESC 
          LIMIT $offset, $limit";
$solicitudes = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require __DIR__ . '/../../layouts/capturista.php' ?>

<main class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Solicitudes</h1>
        <a href="/src/plataforma/solicitudes/nueva" 
           class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2">
            <i data-feather="plus"></i>
            Nueva solicitud
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-neutral-800 p-4 rounded-xl shadow-sm mb-6">
        <div class="flex gap-2 flex-wrap">
            <a href="?f=" class="px-3 py-1 rounded-full <?= $filtro === '' ? 'bg-primary-500 text-white' : 'bg-neutral-100 dark:bg-neutral-700' ?>">
                Todas
            </a>
            <a href="?f=faltantes" class="px-3 py-1 rounded-full <?= $filtro === 'faltantes' ? 'bg-primary-500 text-white' : 'bg-neutral-100 dark:bg-neutral-700' ?>">
                Pendientes
            </a>
            <a href="?f=aprobadas" class="px-3 py-1 rounded-full <?= $filtro === 'aprobadas' ? 'bg-primary-500 text-white' : 'bg-neutral-100 dark:bg-neutral-700' ?>">
                Aprobadas
            </a>
            <a href="?f=revision" class="px-3 py-1 rounded-full <?= $filtro === 'revision' ? 'bg-primary-500 text-white' : 'bg-neutral-100 dark:bg-neutral-700' ?>">
                En revisión
            </a>
            <a href="?f=rechazadas" class="px-3 py-1 rounded-full <?= $filtro === 'rechazadas' ? 'bg-primary-500 text-white' : 'bg-neutral-100 dark:bg-neutral-700' ?>">
                Rechazadas
            </a>
        </div>
    </div>

    <!-- Tabla de solicitudes -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Alumno
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Carrera
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    <?php foreach ($solicitudes as $solicitud): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                            <i data-feather="user" class="text-primary-600 dark:text-primary-400"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                            <?= htmlspecialchars($solicitud['nombre']) ?>
                                        </div>
                                        <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                            <?= htmlspecialchars($solicitud['email'] ?? '') ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-neutral-900 dark:text-neutral-100"><?= htmlspecialchars($solicitud['carrera']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $estadoClases = [
                                    'pendiente' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                                    'aprobada' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                    'revision' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'rechazada' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                ];
                                $clase = $estadoClases[$solicitud['estado']] ?? 'bg-neutral-100 text-neutral-800';
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $clase ?>">
                                    <?= ucfirst(htmlspecialchars($solicitud['estado'])) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                <?= date('d/m/Y', strtotime($solicitud['fecha_creacion'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="/src/plataforma/solicitudes/editar?id=<?= $solicitud['id'] ?>" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <?php if ($totalPages > 1): ?>
        <div class="bg-neutral-50 dark:bg-neutral-800 px-4 py-3 flex items-center justify-between border-t border-neutral-200 dark:border-neutral-700 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?>&f=<?= $filtro ?>" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                        Anterior
                    </a>
                <?php endif; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?= $page + 1 ?>&f=<?= $filtro ?>" class="ml-3 relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
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
                            <a href="?page=<?= $page - 1 ?>&f=<?= $filtro ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
                                <span class="sr-only">Previous</span>
                                <i data-feather="chevron-left" class="h-5 w-5"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <a href="?page=<?= $i ?>&f=<?= $filtro ?>" 
                               class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium <?= $i === $page ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page + 1 ?>&f=<?= $filtro ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
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
</script>