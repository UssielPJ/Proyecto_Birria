<?php
global $pdo;
$conn = $pdo;

/* ===== Parámetros ===== */
$buscar = $_GET['q'] ?? '';
$status = $_GET['status'] ?? ''; // '', 'activa', 'inactiva'
$page   = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit  = 10;
$offset = ($page - 1) * $limit;

/* ===== WHERE dinámico ===== */
$where  = [];
$params = [];

if ($buscar !== '') {
    $where[] = "(nombre LIKE :buscar OR clave LIKE :buscar)";
    $params[':buscar'] = "%{$buscar}%";
}
if ($status !== '') {
    $where[] = "status = :status";
    $params[':status'] = $status;
}
$whereClause = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

/* ===== Total ===== */
$sqlTotal = "SELECT COUNT(*) AS total FROM materias {$whereClause}";
$stmt = $conn->prepare($sqlTotal);
$stmt->execute($params);
$total = (int)($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
$totalPages = max(1, (int)ceil($total / $limit));

/* ===== Listado ===== */
$sql = "
    SELECT id, clave, nombre, status, created_at, updated_at
    FROM materias
    {$whereClause}
    ORDER BY nombre ASC
    LIMIT {$offset}, {$limit}
";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* Helper */
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
?>
<main class="p-6">
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
      <h1 class="text-2xl font-bold mb-2">Materias</h1>
      <p class="text-neutral-500 dark:text-neutral-400">Administra las materias.</p>
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
      <div class="sm:col-span-2">
        <label for="q" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Buscar</label>
        <div class="relative">
          <input type="text" name="q" id="q" value="<?= $esc($buscar) ?>"
                 placeholder="Nombre o clave…"
                 class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 pr-10 focus:border-primary-500 focus:ring-primary-500">
          <div class="absolute inset-y-0 right-0 flex items-center pr-3">
            <i data-feather="search" class="h-5 w-5 text-neutral-400"></i>
          </div>
        </div>
      </div>

      <div>
        <label for="status" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
        <select name="status" id="status"
                class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
          <option value="">Todos</option>
          <option value="activa"   <?= $status==='activa'   ? 'selected' : '' ?>>Activa</option>
          <option value="inactiva" <?= $status==='inactiva' ? 'selected' : '' ?>>Inactiva</option>
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
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estado</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Creada</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Actualizada</th>
            <th class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
          <?php foreach ($materias as $m): ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                  <?= $esc($m['nombre']) ?>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                <?= $esc($m['clave']) ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <?php if (($m['status'] ?? 'activa') === 'activa'): ?>
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                    Activa
                  </span>
                <?php else: ?>
                  <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-neutral-200 text-neutral-800 dark:bg-neutral-700 dark:text-neutral-200">
                    Inactiva
                  </span>
                <?php endif; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                <?= $esc($m['created_at']) ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                <?= $esc($m['updated_at']) ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex justify-end gap-3">
                  <a href="/src/plataforma/app/admin/subjects/<?= (int)$m['id'] ?>" 
                     class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Ver</a>
                  <a href="/src/plataforma/app/admin/subjects/edit/<?= (int)$m['id'] ?>" 
                     class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Editar</a>
                  <button onclick="confirmDelete(<?= (int)$m['id'] ?>)" 
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
            <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&status=<?= urlencode($status) ?>" 
               class="relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
              Anterior
            </a>
          <?php endif; ?>
          <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&status=<?= urlencode($status) ?>" 
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
                <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&status=<?= urlencode($status) ?>" 
                   class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
                  <span class="sr-only">Previous</span>
                  <i data-feather="chevron-left" class="h-5 w-5"></i>
                </a>
              <?php endif; ?>

              <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <a href="?page=<?= $i ?>&q=<?= urlencode($buscar) ?>&status=<?= urlencode($status) ?>" 
                   class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium <?= $i === $page ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600' ?>">
                  <?= $i ?>
                </a>
              <?php endfor; ?>

              <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&status=<?= urlencode($status) ?>" 
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
  document.querySelector('select[name="status"]')?.addEventListener('change', (e) => {
    e.target.closest('form').submit();
  });
</script>
