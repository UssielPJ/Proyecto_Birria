<?php
global $pdo;
$conn = $pdo;

/* ===== Parámetros ===== */
$buscar    = trim($_GET['q'] ?? '');
$career_id = $_GET['career_id'] ?? '';
$page      = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit     = 10;
$offset    = ($page - 1) * $limit;

/* ===== WHERE dinámico ===== */
$where  = [];
$params = []; // llaves sin ':'

// Buscar por nombre de carrera, iniciales, clave; si es número, también por numero
if ($buscar !== '') {
    $where[] = "(c.nombre LIKE :b1 OR c.iniciales LIKE :b2 OR s.clave LIKE :b3" 
             . (ctype_digit($buscar) ? " OR s.numero = :num" : "")
             . ")";
    $params['b1']  = "%{$buscar}%";
    $params['b2']  = "%{$buscar}%";
    $params['b3']  = "%{$buscar}%";
    if (ctype_digit($buscar)) {
        $params['num'] = (int)$buscar;
    }
}

if ($career_id !== '') {
    $where[] = "s.carrera_id = :career_id";
    $params['career_id'] = (int)$career_id;
}

$whereClause = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

/* ===== Total ===== */
$sqlTotal = "
    SELECT COUNT(*) AS total
    FROM semestres s
    LEFT JOIN carreras c ON c.id = s.carrera_id
    {$whereClause}
";
$stmt = $conn->prepare($sqlTotal);
foreach ($params as $k => $v) {
    $stmt->bindValue(':'.$k, $v, is_int($v) ? PDO::PARAM_INT : PDO::PARAM_STR);
}
$stmt->execute();
$total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = max(1, (int)ceil($total / $limit));

/* ===== Listado ===== */
$sql = "
    SELECT 
        s.id, s.carrera_id, s.numero, s.clave,
        c.nombre AS carrera_nombre, c.iniciales AS carrera_iniciales
    FROM semestres s
    LEFT JOIN carreras c ON c.id = s.carrera_id
    {$whereClause}
    ORDER BY c.nombre ASC, s.numero ASC
    LIMIT :offset, :limit
";
$stmt = $conn->prepare($sql);
foreach ($params as $k => $v) {
    $stmt->bindValue(':'.$k, $v, is_int($v) ? PDO::PARAM_INT : PDO::PARAM_STR);
}
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
$stmt->execute();
$semestres = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ===== Carreras para filtro (solo activas) ===== */
$careers = $conn
    ->query("SELECT id, nombre, iniciales FROM carreras WHERE status = 'activa' ORDER BY nombre ASC")
    ->fetchAll(PDO::FETCH_ASSOC);
?>
<main class="p-6">
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
      <h1 class="text-2xl font-bold mb-2">Semestres</h1>
      <p class="text-neutral-500 dark:text-neutral-400">Administra los semestres por carrera académica.</p>
    </div>
    <a href="/src/plataforma/app/admin/semesters/create"
       class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2 w-full sm:w-auto justify-center">
      <i data-feather="plus"></i>
      Nuevo semestre
    </a>
  </div>

  <!-- Filtros y búsqueda -->
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 mb-6">
    <form class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="lg:col-span-2">
        <label for="q" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Buscar</label>
        <div class="relative">
          <input type="text" name="q" id="q" value="<?= htmlspecialchars($buscar) ?>"
                 placeholder="Carrera, iniciales, clave o número…"
                 class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 pr-10 focus:border-primary-500 focus:ring-primary-500">
          <div class="absolute inset-y-0 right-0 flex items-center pr-3">
            <i data-feather="search" class="h-5 w-5 text-neutral-400"></i>
          </div>
        </div>
      </div>

      <div>
        <label for="career_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Carrera</label>
        <select name="career_id" id="career_id"
                class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
          <option value="">Todas las carreras</option>
          <?php foreach ($careers as $career): ?>
            <option value="<?= (int)$career['id'] ?>" <?= $career_id == $career['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($career['iniciales']) ?> — <?= htmlspecialchars($career['nombre']) ?>
            </option>
          <?php endforeach; ?>
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

  <!-- Tabla de semestres -->
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
        <thead class="bg-neutral-50 dark:bg-neutral-800">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Carrera</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Iniciales</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Clave</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Número</th>
            <th class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
          <?php foreach ($semestres as $s): ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-100">
                <?= htmlspecialchars($s['carrera_nombre'] ?? '—') ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                <?= htmlspecialchars($s['carrera_iniciales'] ?? '—') ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                <?= htmlspecialchars($s['clave'] ?? '—') ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                  <?= (int)($s['numero'] ?? 0) ?>° semestre
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex justify-end gap-3">
                  <a href="/src/plataforma/app/admin/semesters/edit/<?= (int)$s['id'] ?>"
                     class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Editar</a>
                  <form method="POST" action="/src/plataforma/app/admin/semesters/delete/<?= (int)$s['id'] ?>" class="inline" onsubmit="return confirm('¿Eliminar este semestre?');">
                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Eliminar</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>

          <?php if (empty($semestres)): ?>
            <tr>
              <td colspan="5" class="px-6 py-6 text-center text-neutral-500 dark:text-neutral-400">
                No se encontraron semestres
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
            <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&career_id=<?= urlencode($career_id) ?>"
               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
              <span class="sr-only">Anterior</span><i data-feather="chevron-left" class="h-5 w-5"></i>
            </a>
          <?php endif; ?>
          <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
            <a href="?page=<?= $i ?>&q=<?= urlencode($buscar) ?>&career_id=<?= urlencode($career_id) ?>"
               class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium <?= $i === $page ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600' ?>">
              <?= $i ?>
            </a>
          <?php endfor; ?>
          <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&career_id=<?= urlencode($career_id) ?>"
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

  document.querySelector('select[name="career_id"]')?.addEventListener('change', e => {
    e.target.closest('form').submit();
  });
</script>
