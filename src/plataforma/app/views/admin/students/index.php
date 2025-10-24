<?php
// === Helpers seguros ===
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

/**
 * Convierte un valor (objeto/array/escalar) en un escalar imprimible.
 * - $prefer: orden de campos preferidos cuando llega un objeto/array.
 */
$toScalar = function ($v, array $prefer = []) {
    if (is_object($v)) {
        foreach ($prefer as $f) if (isset($v->$f)) return $v->$f;
        if (isset($v->nombre)) return $v->nombre;
        if (isset($v->clave))  return $v->clave;
        if (isset($v->id))     return $v->id;
        return '';
    }
    if (is_array($v)) {
        foreach ($prefer as $f) if (array_key_exists($f, $v)) return $v[$f];
        // primer valor del array como fallback
        $first = reset($v);
        return is_scalar($first) ? $first : '';
    }
    return $v; // ya es escalar o null
};

$fullName = function ($row) {
    $parts = [$row->nombre ?? '', $row->apellido_paterno ?? '', $row->apellido_materno ?? ''];
    $parts = array_filter($parts, fn($x) => $x !== '');
    return trim(implode(' ', $parts));
};

// Defaults para evitar notices
$students   = $students   ?? [];
$semestres  = $semestres  ?? [];
$carreras   = $carreras   ?? [];
$buscar     = $buscar     ?? '';
$semestre   = $semestre   ?? '';
$carrera    = $carrera    ?? '';
$estado     = $estado     ?? '';
$page       = max(1, (int)($page ?? 1));
$total      = (int)($total ?? 0);
$totalPages = max(1, (int)($totalPages ?? 1));
?>
<div class="container px-6 py-8">
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Gestión de Estudiantes</h1>
      <div class="flex gap-3">
        <a href="/src/plataforma/app/admin/students/export?format=csv&q=<?= urlencode($buscar) ?>&semestre=<?= urlencode($semestre) ?>&carrera=<?= urlencode($carrera) ?>&estado=<?= urlencode($estado) ?>" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
          <i data-feather="download" class="w-4 h-4"></i>
          Exportar CSV
        </a>
        <a href="/src/plataforma/app/admin/students/create" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
          <i data-feather="user-plus" class="w-4 h-4"></i>
          Nuevo Estudiante
        </a>
      </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="mb-6">
      <form method="GET" class="flex gap-4">
        <div class="flex-1">
          <input type="text" name="q" value="<?= $esc($buscar) ?>" placeholder="Buscar estudiantes..." class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
        </div>

        <!-- Semestres -->
        <select name="semestre" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
          <option value="">Todos los semestres</option>
          <?php foreach ($semestres as $sem): 
                $semVal = $toScalar($sem, ['numero','semestre','id']);
                $semTxt = $semVal;
          ?>
            <option value="<?= $esc($semVal) ?>" <?= ($semestre === (string)$semVal) ? 'selected' : '' ?>>
              <?= $esc($semTxt) ?>º Semestre
            </option>
          <?php endforeach; ?>
        </select>

        <!-- Carreras -->
        <select name="carrera" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
          <option value="">Todas las carreras</option>
          <?php foreach ($carreras as $carr): 
                $carVal = $toScalar($carr, ['id','clave','codigo']);
                $carTxt = $toScalar($carr, ['nombre','clave','codigo']);
          ?>
            <option value="<?= $esc($carVal) ?>" <?= ($carrera === (string)$carVal) ? 'selected' : '' ?>>
              <?= $esc($carTxt) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <select name="estado" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
          <option value="">Todos los estados</option>
          <option value="active"   <?= ($estado === 'active')   ? 'selected' : '' ?>>Activo</option>
          <option value="inactive" <?= ($estado === 'inactive') ? 'selected' : '' ?>>Inactivo</option>
        </select>

        <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
          <i data-feather="search" class="w-4 h-4"></i>
          Buscar
        </button>
      </form>
    </div>

    <!-- Tabla de Estudiantes -->
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
        <thead>
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estudiante</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Matrícula</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Carrera</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Semestre</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estado</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Acciones</th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
          <?php foreach ($students as $student): ?>
            <?php $status = (string)($student->status ?? ''); ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                      <i data-feather="user" class="w-5 h-5 text-primary-600 dark:text-primary-400"></i>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium"><?= $esc($fullName($student)) ?></div>
                    <div class="text-sm text-neutral-500 dark:text-neutral-400"><?= $esc($student->email ?? '') ?></div>
                  </div>
                </div>
              </td>

              <td class="px-6 py-4 whitespace-nowrap text-sm"><?= $esc($student->matricula ?? '') ?></td>

              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <?php
                  $carCell = '';
                  if (isset($student->carrera)) {
                      $carCell = $toScalar($student->carrera, ['nombre','clave','id']);
                  } elseif (isset($student->carrera_id)) {
                      $carCell = $student->carrera_id;
                  }
                ?>
                <?= $esc($carCell) ?>
              </td>

              <td class="px-6 py-4 whitespace-nowrap text-sm"><?= $esc($student->semestre ?? '') ?></td>

              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= (($student->status ?? '') === 'active') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                  <?= $esc(ucfirst($status ?: '')) ?>
                </span>
              </td>

              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="flex items-center gap-3">
                  <a href="/src/plataforma/app/admin/students/edit/<?= $esc($student->id ?? '') ?>" class="text-primary-600 hover:text-primary-900">
                    <i data-feather="edit" class="w-4 h-4"></i>
                  </a>
                  <form action="/src/plataforma/app/admin/students/delete/<?= $esc($student->id ?? '') ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este estudiante?');">
                    <button type="submit" class="text-red-600 hover:text-red-900">
                      <i data-feather="trash-2" class="w-4 h-4"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>

          <?php if (empty($students)): ?>
            <tr>
              <td colspan="6" class="px-6 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                No se encontraron estudiantes con los filtros aplicados.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Paginación -->
    <?php if ($totalPages > 1): ?>
      <div class="flex items-center justify-between px-4 py-3 border-t border-neutral-200 dark:border-neutral-700 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
          <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&semestre=<?= urlencode($semestre) ?>&carrera=<?= urlencode($carrera) ?>&estado=<?= urlencode($estado) ?>" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
              Anterior
            </a>
          <?php endif; ?>
          <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&semestre=<?= urlencode($semestre) ?>&carrera=<?= urlencode($carrera) ?>&estado=<?= urlencode($estado) ?>" class="ml-3 relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
              Siguiente
            </a>
          <?php endif; ?>
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
          <div>
            <p class="text-sm text-neutral-700 dark:text-neutral-400">
              Mostrando
              <span class="font-medium"><?= ($page - 1) * 10 + 1 ?></span>
              a
              <span class="font-medium"><?= min($page * 10, $total) ?></span>
              de
              <span class="font-medium"><?= $esc($total) ?></span>
              resultados
            </p>
          </div>
          <div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
              <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>&q=<?= urlencode($buscar) ?>&semestre=<?= urlencode($semestre) ?>&carrera=<?= urlencode($carrera) ?>&estado=<?= urlencode($estado) ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 bg-white text-sm font-medium text-neutral-500 hover:bg-neutral-50">
                  <span class="sr-only">Anterior</span>
                  <i data-feather="chevron-left" class="w-5 h-5"></i>
                </a>
              <?php endif; ?>

              <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <a href="?page=<?= $i ?>&q=<?= urlencode($buscar) ?>&semestre=<?= urlencode($semestre) ?>&carrera=<?= urlencode($carrera) ?>&estado=<?= urlencode($estado) ?>" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 bg-white text-sm font-medium <?= $i === $page ? 'text-primary-600' : 'text-neutral-700 hover:bg-neutral-50' ?>">
                  <?= $i ?>
                </a>
              <?php endfor; ?>

              <?php if ($page < $totalPages): ?>
                <a href="?page=<?= $page + 1 ?>&q=<?= urlencode($buscar) ?>&semestre=<?= urlencode($semestre) ?>&carrera=<?= urlencode($carrera) ?>&estado=<?= urlencode($estado) ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-neutral-300 bg-white text-sm font-medium text-neutral-500 hover:bg-neutral-50">
                  <span class="sr-only">Siguiente</span>
                  <i data-feather="chevron-right" class="w-5 h-5"></i>
                </a>
              <?php endif; ?>
            </nav>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>feather.replace();</script>
