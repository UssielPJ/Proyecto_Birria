<?php
global $pdo;
$conn = $pdo;

/* ===== Parámetros ===== */
$buscar    = $_GET['q'] ?? '';
$rawStatus = $_GET['status'] ?? '';
$status    = in_array($rawStatus, ['activa','inactiva'], true) ? $rawStatus : '';

$page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit  = 10;
$offset = ($page - 1) * $limit;

/* ===== WHERE dinámico ===== */
$where  = [];
$params = []; // llaves sin ':'

if ($buscar !== '') {
    // Usa placeholders distintos para evitar HY093
    $where[] = "(nombre LIKE :buscar1 OR iniciales LIKE :buscar2)";
    $params['buscar1'] = "%{$buscar}%";
    $params['buscar2'] = "%{$buscar}%";
}

if ($status !== '') { // 'activa' | 'inactiva'
    $where[] = "status = :status";
    $params['status'] = $status; // string para ENUM
}

$whereClause = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

/* ===== Total ===== */
$sqlTotal = "SELECT COUNT(*) AS total FROM carreras {$whereClause}";
$stmt = $conn->prepare($sqlTotal);
foreach ($params as $k => $v) {
    $stmt->bindValue(':'.$k, $v, PDO::PARAM_STR);
}
$stmt->execute();
$total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = max(1, (int)ceil($total / $limit));

/* ===== Listado ===== */
$sql = "
  SELECT id, nombre, iniciales, status, created_at
  FROM carreras
  {$whereClause}
  ORDER BY nombre ASC
  LIMIT :offset, :limit
";
$stmt = $conn->prepare($sql);

// bindea params de texto (:buscar1, :buscar2, :status) si existen
foreach ($params as $k => $v) {
    $stmt->bindValue(':'.$k, $v, PDO::PARAM_STR);
}
// y los de paginación como enteros
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);

$stmt->execute();
$careers = $stmt->fetchAll(PDO::FETCH_ASSOC);

function fechaBonita($dt) {
    if (!$dt) return '';
    $t = strtotime($dt);
    return $t ? date('d/m/Y H:i', $t) : htmlspecialchars($dt);
}
?>

<main class="p-6">
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
      <h1 class="text-2xl font-bold mb-2">Carreras</h1>
      <p class="text-neutral-500 dark:text-neutral-400">Administra las carreras académicas.</p>
    </div>
    <a href="/src/plataforma/app/admin/careers/create"
       class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2 w-full sm:w-auto justify-center">
      <i data-feather="plus"></i>
      Nueva carrera
    </a>
  </div>

  <!-- Filtros -->
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 mb-6">
    <form class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="lg:col-span-2">
        <label for="q" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Buscar</label>
        <div class="relative">
          <input type="text" name="q" id="q" value="<?= htmlspecialchars($buscar) ?>"
            placeholder="Nombre o iniciales…"
            class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 pr-10 focus:border-primary-500 focus:ring-primary-500">
          <div class="absolute inset-y-0 right-0 flex items-center pr-3">
            <i data-feather="search" class="h-5 w-5 text-neutral-400"></i>
          </div>
        </div>
      </div>

      <div>
        <label for="status" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
        <?php $stSel = $status; ?>
        <select name="status" id="status"
          class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
          <option value="">Todos</option>
          <option value="activa"   <?= $stSel === 'activa'   ? 'selected' : '' ?>>Activa</option>
          <option value="inactiva" <?= $stSel === 'inactiva' ? 'selected' : '' ?>>Inactiva</option>
        </select>
      </div>

      <div class="flex items-end">
        <button type="submit"
          class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2 w-full sm:w-auto justify-center">
          <i data-feather="filter"></i> Filtrar
        </button>
      </div>
    </form>
  </div>

  <!-- Tabla -->
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
        <thead class="bg-neutral-50 dark:bg-neutral-800">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Nombre</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Iniciales</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estado</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Creada</th>
            <th class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
          <?php foreach ($careers as $c): ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-100">
                <?= htmlspecialchars($c['nombre']) ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                <?= htmlspecialchars($c['iniciales'] ?? '') ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <?php $isActive = ($c['status'] === 'activa'); ?>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                  <?= $isActive ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' ?>">
                  <?= $isActive ? 'Activa' : 'Inactiva' ?>
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                <?= fechaBonita($c['created_at'] ?? '') ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex justify-end gap-3">
                  <a href="/src/plataforma/app/admin/careers/edit/<?= (int)$c['id'] ?>"
                     class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Editar</a>
                  <button onclick="confirmDelete(<?= (int)$c['id'] ?>)"
                     class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Eliminar</button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>

          <?php if (empty($careers)): ?>
            <tr>
              <td colspan="5" class="px-6 py-6 text-center text-neutral-500 dark:text-neutral-400">
                No se encontraron carreras
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Paginación -->
    <?php if ($totalPages > 1): ?>
    <div class="bg-neutral-50 dark:bg-neutral-800 px-4 py-3 flex items-center justify-between border-t border-neutral-200 dark:border-neutral-700 sm:px-6">
      <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <p class="text-sm text-neutral-700 dark:text-neutral-400">
          Mostrando <span class="font-medium"><?= $total ? ($offset + 1) : 0 ?></span>
          a <span class="font-medium"><?= min($offset + $limit, $total) ?></span>
          de <span class="font-medium"><?= $total ?></span> resultados
        </p>
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
          <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&status=<?= urlencode($status) ?>"
               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
              <span class="sr-only">Anterior</span><i data-feather="chevron-left" class="h-5 w-5"></i>
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
              <span class="sr-only">Siguiente</span><i data-feather="chevron-right" class="h-5 w-5"></i>
            </a>
          <?php endif; ?>
        </nav>
      </div>
    </div>
    <?php endif; ?>
  </div>
</main>

<script>
  feather.replace();
  document.querySelector('select[name="status"]')?.addEventListener('change', e => {
    e.target.closest('form').submit();
  });
  function confirmDelete(id) {
    if (confirm('¿Estás seguro de eliminar esta carrera?')) {
      window.location.href = `/src/plataforma/app/admin/careers/${id}/delete`;
    }
  }
</script>
