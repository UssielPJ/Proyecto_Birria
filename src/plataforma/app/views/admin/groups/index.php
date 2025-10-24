<?php
global $pdo;
$conn = $pdo;

/* ===== Parámetros ===== */
$buscar   = $_GET['q'] ?? '';
$career   = $_GET['career'] ?? '';
$semester = $_GET['semester'] ?? '';
$page     = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit    = 10;
$offset   = ($page - 1) * $limit;

/* ===== WHERE dinámico ===== */
$whereParts = [];
$params     = []; // sin dos puntos en las llaves

if ($buscar !== '') {
    $whereParts[]        = "(g.`titulo` LIKE :buscar1 OR g.`codigo` LIKE :buscar2)";
    $params['buscar1']   = "%{$buscar}%";
    $params['buscar2']   = "%{$buscar}%";
}
if ($career !== '') {
    $whereParts[]        = "c.`id` = :career";
    $params['career']    = (int)$career;
}
if ($semester !== '') {
    $whereParts[]        = "s.`id` = :semester";
    $params['semester']  = (int)$semester;
}
$whereClause = $whereParts ? ('WHERE ' . implode(' AND ', $whereParts)) : '';

/* ===== Total ===== */
$queryTotal = "
    SELECT COUNT(*) AS total
    FROM `grupos` AS g
    LEFT JOIN `semestres` AS s ON s.`id` = g.`semestre_id`
    LEFT JOIN `carreras`  AS c ON c.`id` = s.`carrera_id`
    {$whereClause}
";
$stmt = $conn->prepare($queryTotal);

/* Bind seguro para COUNT */
foreach ($params as $name => $value) {
    if (strpos($queryTotal, ':' . $name) !== false) {
        $stmt->bindValue(':' . $name, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
}
$stmt->execute();
$total = (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = max(1, (int)ceil($total / $limit));

/* ===== Listado ===== */
$query = "
    SELECT
        g.`id`,
        g.`titulo`,
        g.`codigo`,
        g.`capacidad`,
        g.`inscritos`,
        s.`id`      AS `semester_id`,
        s.`numero`  AS `semester_number`,
        s.`clave`   AS `semester_name`,
        c.`id`      AS `career_id`,
        c.`nombre`  AS `career_name`
    FROM `grupos` AS g
    LEFT JOIN `semestres` AS s ON s.`id` = g.`semestre_id`
    LEFT JOIN `carreras`  AS c ON c.`id` = s.`carrera_id`
    {$whereClause}
    ORDER BY g.`titulo` ASC
    LIMIT :offset, :limit
";
$stmt = $conn->prepare($query);

/* Bind de filtros presentes en el SELECT */
foreach ($params as $name => $value) {
    if (strpos($query, ':' . $name) !== false) {
        $stmt->bindValue(':' . $name, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
}
/* Paginación */
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);

$stmt->execute();
$groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ===== Filtros (combos) ===== */
$careers   = $conn->query("SELECT `id`, `nombre` AS `name` FROM `carreras`  ORDER BY `nombre` ASC")->fetchAll(PDO::FETCH_ASSOC);
$semesters = $conn->query("SELECT `id`, `clave`  AS `name` FROM `semestres` ORDER BY `numero` ASC")->fetchAll(PDO::FETCH_ASSOC);


?>


<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php if (!empty($_SESSION['flash'])): 
  $type = $_SESSION['flash']['type'] ?? 'info';
  $msg  = $_SESSION['flash']['msg']  ?? '';
  // Mapear estilos
  $classes = [
    'success' => 'bg-green-50 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-200 dark:border-green-800',
    'error'   => 'bg-red-50 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-200 dark:border-red-800',
    'info'    => 'bg-blue-50 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-200 dark:border-blue-800',
  ];
  $cls = $classes[$type] ?? $classes['info'];
?>
  <div id="flash-msg" class="mb-4 border rounded-lg px-4 py-3 <?= $cls; ?>">
    <div class="flex items-start gap-2">
      <i data-feather="<?= $type === 'success' ? 'check-circle' : ($type === 'error' ? 'alert-triangle' : 'info') ?>"></i>
      <div class="text-sm font-medium"><?= htmlspecialchars($msg) ?></div>
    </div>
  </div>
  <script>
    feather.replace();
    setTimeout(() => {
      const el = document.getElementById('flash-msg');
      if (el) el.style.display = 'none';
    }, 4000); // 4s y se oculta
  </script>
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<main class="p-6">
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
      <h1 class="text-2xl font-bold mb-2">Grupos</h1>
      <p class="text-neutral-500 dark:text-neutral-400">Administra los grupos y cohortes de estudiantes.</p>
    </div>
    <a href="/src/plataforma/app/admin/groups/create"
       class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2 w-full sm:w-auto justify-center">
      <i data-feather="plus"></i> Nuevo Grupo
    </a>
  </div>

  <!-- Filtros y búsqueda -->
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 mb-6">
    <form class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div>
        <label for="q" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Buscar</label>
        <div class="relative">
          <input type="text" name="q" id="q" value="<?= htmlspecialchars($buscar) ?>"
                 placeholder="Título o código…"
                 class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 pr-10 focus:border-primary-500 focus:ring-primary-500">
          <div class="absolute inset-y-0 right-0 flex items-center pr-3">
            <i data-feather="search" class="h-5 w-5 text-neutral-400"></i>
          </div>
        </div>
      </div>

      <div>
        <label for="career" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Carrera</label>
        <select name="career" id="career"
                class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
          <option value="">Todas las carreras</option>
          <?php foreach ($careers as $c): ?>
            <option value="<?= $c['id'] ?>" <?= $career == $c['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($c['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label for="semester" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre</label>
        <select name="semester" id="semester"
                class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
          <option value="">Todos los semestres</option>
          <?php foreach ($semesters as $s): ?>
            <option value="<?= $s['id'] ?>" <?= $semester == $s['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($s['name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="flex items-end">
        <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2 w-full sm:w-auto justify-center">
          <i data-feather="filter"></i> Filtrar
        </button>
      </div>
    </form>
  </div>

  <!-- Tabla de grupos -->
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
        <thead class="bg-neutral-50 dark:bg-neutral-800">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Grupo</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Carrera</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Semestre</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estudiantes</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estado</th>
            <th class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
          <?php foreach ($groups as $group): ?>
            <?php
              $ins = (int)($group['inscritos'] ?? 0);
              $cap = (int)($group['capacidad'] ?? 0);
              $activo = $cap === 0 ? true : ($ins < $cap);
            ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                  <?= htmlspecialchars($group['titulo']) ?>
                </div>
                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                  Código: <?= htmlspecialchars($group['codigo'] ?? '') ?>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                <?= htmlspecialchars($group['career_name'] ?? '') ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                <?= htmlspecialchars($group['semester_name'] ?? '') /* ej. IDGS-01 */ ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                <?= $ins ?>/<?= $cap ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                  <?= $activo ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                             : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' ?>">
                  <?= $activo ? 'Activo' : 'Lleno' ?>
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <div class="flex justify-end gap-3">
                  <a href="/src/plataforma/app/admin/groups/students/<?= (int)$group['id'] ?>"
                     class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Estudiantes</a>
                  <a href="/src/plataforma/app/admin/groups/edit/<?= (int)$group['id'] ?>"
                     class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">Editar</a>
                  <button onclick="confirmDelete(<?= (int)$group['id'] ?>)"
                          class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Eliminar</button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>

          <?php if (empty($groups)): ?>
            <tr>
              <td colspan="6" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                No se encontraron grupos
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
            <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&career=<?= urlencode($career) ?>&semester=<?= urlencode($semester) ?>"
               class="relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">Anterior</a>
          <?php endif; ?>
          <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&career=<?= urlencode($career) ?>&semester=<?= urlencode($semester) ?>"
               class="ml-3 relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">Siguiente</a>
          <?php endif; ?>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
          <div>
            <p class="text-sm text-neutral-700 dark:text-neutral-400">
              Mostrando <span class="font-medium"><?= $total ? ($offset + 1) : 0 ?></span>
              a <span class="font-medium"><?= min($offset + $limit, $total) ?></span>
              de <span class="font-medium"><?= $total ?></span> resultados
            </p>
          </div>
          <div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
              <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&career=<?= urlencode($career) ?>&semester=<?= urlencode($semester) ?>"
                   class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
                  <span class="sr-only">Previous</span>
                  <i data-feather="chevron-left" class="h-5 w-5"></i>
                </a>
              <?php endif; ?>

              <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <a href="?page=<?= $i ?>&q=<?= urlencode($buscar) ?>&career=<?= urlencode($career) ?>&semester=<?= urlencode($semester) ?>"
                   class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium <?= $i === $page ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600' ?>">
                  <?= $i ?>
                </a>
              <?php endfor; ?>

              <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&career=<?= urlencode($career) ?>&semester=<?= urlencode($semester) ?>"
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
  document.querySelectorAll('select[name="career"], select[name="semester"]').forEach(select => {
    select.addEventListener('change', () => select.closest('form').submit());
  });
  function confirmDelete(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este grupo? Esta acción no se puede deshacer.')) {
      window.location.href = `/src/plataforma/app/admin/groups/delete/${id}`;
    }
  }
</script>
