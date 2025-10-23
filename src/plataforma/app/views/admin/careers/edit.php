<?php
// NO reconsultar la base aquí. El controlador ya mandó $career (objeto).
// Variables esperadas: $career (objeto con id, nombre, iniciales, status, created_at)
?>

<main class="p-6">
  <div class="max-w-3xl mx-auto">
    <div class="mb-6">
      <div class="flex items-center gap-4 mb-4">
        <a href="/src/plataforma/app/admin/careers" class="text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200">
          <i data-feather="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
          <h1 class="text-2xl font-bold">Editar Carrera</h1>
          <p class="text-neutral-500 dark:text-neutral-400">Modifica la información de la carrera.</p>
        </div>
      </div>
    </div>

    <?php if (!empty($errors ?? [])): ?>
      <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
        <div class="flex">
          <i data-feather="alert-circle" class="w-5 h-5 text-red-400 mr-2 mt-0.5"></i>
          <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside">
            <?php foreach (($errors ?? []) as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
          </ul>
        </div>
      </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <!-- IMPORTANTE: action a /update/{id} con segmento -->
      <form method="POST" action="/src/plataforma/app/admin/careers/update/<?= (int)$career->id ?>" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="md:col-span-2">
            <label for="nombre" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Nombre *</label>
            <input type="text" name="nombre" id="nombre" required
              value="<?= htmlspecialchars($career->nombre) ?>"
              class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
            <p class="mt-2 text-xs text-neutral-500 dark:text-neutral-400">Las iniciales se sugerirán automáticamente.</p>
          </div>

          <div>
            <label for="iniciales" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Iniciales *</label>
            <input type="text" name="iniciales" id="iniciales" required
              value="<?= htmlspecialchars($career->iniciales) ?>"
              class="uppercase block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
          </div>

          <div>
            <label for="status" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Estado *</label>
            <?php $stSel = (int)$career->status; ?>
            <?php $stSel = $career->status; ?>
            <select name="status" id="status" required class="block w-full rounded-md ...">
                <option value="activa"   <?= $stSel === 'activa'   ? 'selected' : '' ?>>Activa</option>
                <option value="inactiva" <?= $stSel === 'inactiva' ? 'selected' : '' ?>>Inactiva</option>
            </select>
          </div>
        </div>

        <!-- Vista previa -->
        <div class="rounded-lg border border-neutral-200 dark:border-neutral-700 p-4 bg-neutral-50 dark:bg-neutral-900/40">
          <span class="text-sm text-neutral-500 dark:text-neutral-400">Vista previa:</span>
          <div class="mt-2 flex items-center gap-3">
            <span id="previewNombre" class="text-base font-medium text-neutral-900 dark:text-neutral-100">
              <?= htmlspecialchars($career->nombre) ?>
            </span>
            <span id="previewChip"
              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200">
              <?= htmlspecialchars(strtoupper($career->iniciales)) ?>
            </span>
          </div>
        </div>

        <div class="flex justify-end gap-4 pt-6 border-t border-neutral-200 dark:border-neutral-700">
          <a href="/src/plataforma/app/admin/careers"
             class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-md hover:bg-neutral-50 dark:hover:bg-neutral-600">
            Cancelar
          </a>
          <button type="submit"
             class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Guardar cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</main>

<script>
  feather.replace();

  // Autollenado de iniciales como en create
  const STOP = new Set(['de','del','la','el','los','las','y','en','para','por','a','e','o','u','con']);
  const $nombre = document.getElementById('nombre');
  const $inic   = document.getElementById('iniciales');
  const $prevN  = document.getElementById('previewNombre');
  const $chip   = document.getElementById('previewChip');

  function sugerirIniciales(nombre) {
    const parts = nombre
      .normalize('NFD').replace(/\p{Diacritic}/gu, '')
      .toLowerCase().split(/[\s\-_/.,;:]+/).filter(Boolean)
      .filter(w => !STOP.has(w));
    const acro = parts.map(w => w[0]).join('').slice(0,10).toUpperCase();
    return acro || nombre.trim().slice(0,3).toUpperCase();
  }

  function sync() {
    const n = $nombre.value.trim();
    if (n && !$inic.dataset.userEdited) $inic.value = sugerirIniciales(n);
    $prevN.textContent = n || '—';
    $chip.textContent  = ($inic.value || '—').toUpperCase();
  }

  $nombre.addEventListener('input', sync);
  $inic.addEventListener('input', () => {
    $inic.value = $inic.value.toUpperCase();
    $inic.dataset.userEdited = '1';
    $chip.textContent = $inic.value || '—';
  });

  // inicial
  sync();
</script>
