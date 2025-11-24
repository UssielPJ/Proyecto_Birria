<?php
/**
 * Variables esperadas desde el controlador:
 * $semestres   → listado paginado de semestres
 * $careers     → carreras activas
 * $buscar      → texto de búsqueda
 * $career_id   → carrera filtrada
 * $page        → página actual
 * $total       → total de registros
 * $totalPages  → total de páginas
 * $limit       → cantidad por página
 * $offset      → inicio
 */

// Normalizar a arreglos si vienen como stdClass (FETCH_OBJ)
if (!empty($semestres) && is_object($semestres[0])) {
    $semestres = array_map(fn($row) => (array)$row, $semestres);
}
if (!empty($careers) && is_object($careers[0])) {
    $careers = array_map(fn($row) => (array)$row, $careers);
}

$esc = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
?>

<main class="p-6">

  <!-- HEADER -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
      <h1 class="text-2xl font-bold mb-2">Semestres</h1>
      <p class="text-neutral-500 dark:text-neutral-400">
        Administra los semestres por carrera académica.
      </p>
    </div>

    <a href="/src/plataforma/app/admin/semesters/create"
       class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2 w-full sm:w-auto justify-center">
      <i data-feather="plus"></i>
      Nuevo semestre
    </a>
  </div>

  <!-- FILTROS -->
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 mb-6">
    <form class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

      <!-- BUSCAR -->
      <div class="lg:col-span-2">
        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Buscar</label>
        <div class="relative">
          <input type="text" name="q" value="<?= $esc($buscar) ?>"
                 placeholder="Carrera, iniciales, clave o número…"
                 class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 pr-10
                 focus:border-primary-500 focus:ring-primary-500">
          <div class="absolute inset-y-0 right-0 flex items-center pr-3">
            <i data-feather="search" class="h-5 w-5 text-neutral-400"></i>
          </div>
        </div>
      </div>

      <!-- CARRERA -->
      <div>
        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Carrera</label>
        <select name="career_id"
                class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700
                focus:border-primary-500 focus:ring-primary-500">
          <option value="">Todas las carreras</option>
          <?php foreach ($careers as $c): ?>
            <option value="<?= (int)$c['id'] ?>"
              <?= ($career_id == $c['id']) ? 'selected' : '' ?>>
              <?= $esc($c['iniciales']) ?> — <?= $esc($c['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- SUBMIT -->
      <div class="flex items-end">
        <button class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2
                       w-full sm:w-auto justify-center">
          <i data-feather="filter"></i>
          Filtrar
        </button>
      </div>

    </form>
  </div>

  <!-- TABLA -->
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

          <?php if (!empty($semestres)): ?>
            <?php foreach ($semestres as $s): ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-100">
                  <?= $esc($s['carrera_nombre'] ?? '—') ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                  <?= $esc($s['carrera_iniciales'] ?? '—') ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                  <?= $esc($s['clave'] ?? '—') ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                               bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    <?= (int)$s['numero'] ?>° semestre
                  </span>
                </td>

                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex justify-end gap-3">

                    <a href="/src/plataforma/app/admin/semesters/edit/<?= (int)$s['id'] ?>"
                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                      Editar
                    </a>

                    <form method="POST"
                          action="/src/plataforma/app/admin/semesters/delete/<?= (int)$s['id'] ?>"
                          onsubmit="return confirm('¿Eliminar este semestre?');"
                          class="inline">
                      <button class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                        Eliminar
                      </button>
                    </form>

                  </div>
                </td>

              </tr>
            <?php endforeach; ?>

          <?php else: ?>
            <tr>
              <td colspan="5" class="px-6 py-6 text-center text-neutral-500 dark:text-neutral-400">
                No se encontraron semestres
              </td>
            </tr>
          <?php endif; ?>

        </tbody>

      </table>

    </div>

    <!-- PAGINACIÓN -->
    <?php if ($totalPages > 1): ?>
      <div class="bg-neutral-50 dark:bg-neutral-800 px-4 py-3 flex items-center justify-between border-t
                  border-neutral-200 dark:border-neutral-700 sm:px-6">

        <p class="text-sm text-neutral-700 dark:text-neutral-400">
          Mostrando
          <span class="font-medium"><?= $total ? ($offset + 1) : 0 ?></span>
          a <span class="font-medium"><?= min($offset + $limit, $total) ?></span>
          de <span class="font-medium"><?= $total ?></span> resultados
        </p>

        <nav class="relative z-0 inline-flex rounded-md shadow-sm" aria-label="Pagination">
          <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&career_id=<?= urlencode($career_id) ?>"
               class="px-3 py-2 border rounded-l-md dark:bg-neutral-700">«</a>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&q=<?= urlencode($buscar) ?>&career_id=<?= urlencode($career_id) ?>"
               class="px-3 py-2 border dark:bg-neutral-700 <?= $i == $page ? 'bg-primary-100 text-primary-600 dark:text-primary-300' : '' ?>">
               <?= $i ?>
            </a>
          <?php endfor; ?>

          <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&career_id=<?= urlencode($career_id) ?>"
               class="px-3 py-2 border rounded-r-md dark:bg-neutral-700">»</a>
          <?php endif; ?>
        </nav>
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
