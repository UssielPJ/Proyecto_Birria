<?php
// Variables que espera esta vista: $careers (lista de carreras activas)
// del controlador SemestersController::create()
// $careers probablemente son objetos (Database->fetchAll()). Si fueran arrays, el -> se puede cambiar por ['...'] sin más.
?>
<main class="p-6">
  <div class="max-w-3xl mx-auto">
    <div class="mb-6">
      <div class="flex items-center gap-4 mb-4">
        <a href="/src/plataforma/app/admin/semesters"
           class="text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200">
          <i data-feather="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
          <h1 class="text-2xl font-bold">Nuevo Semestre</h1>
          <p class="text-neutral-500 dark:text-neutral-400">Ingresa los datos del semestre</p>
        </div>
      </div>
    </div>

    <?php if (!empty($_SESSION['error'])): ?>
      <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
        <div class="flex">
          <i data-feather="alert-circle" class="w-5 h-5 text-red-400 mr-2 mt-0.5"></i>
          <div class="text-sm text-red-700 dark:text-red-300"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        </div>
      </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <form method="POST" action="/src/plataforma/app/admin/semesters/store" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="career_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
              Carrera *
            </label>
            <select name="carrera_id" id="career_id" required
              class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
              <option value="">Seleccionar carrera</option>
              <?php foreach ($careers as $c): ?>
                <option value="<?= (int)($c->id ?? $c['id']) ?>">
                  <?= htmlspecialchars(($c->iniciales ?? $c['iniciales']) . ' — ' . ($c->nombre ?? $c['nombre'])) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php if (empty($careers)): ?>
              <p class="mt-2 text-sm text-amber-600 dark:text-amber-400">
                <i data-feather="alert-triangle" class="w-4 h-4 inline mr-1"></i>
                No hay carreras activas. <a class="underline" href="/src/plataforma/app/admin/careers/create">Crea una carrera</a>.
              </p>
            <?php endif; ?>
          </div>

          <div>
            <label for="numero" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
              Número de semestre *
            </label>
            <select name="numero" id="numero" required
              class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
              <option value="">Seleccionar número</option>
              <?php for ($i=1; $i<=12; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?>° Semestre</option>
              <?php endfor; ?>
            </select>
          </div>
        </div>

        <div>
          <label for="clave" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
            Clave *
          </label>
          <input type="text" name="clave" id="clave" required
            class="uppercase tracking-wider block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500"
            placeholder="Ej: ISC-01">
          <p class="mt-2 text-xs text-neutral-500 dark:text-neutral-400">
            Sugerencia automática: <code>INICIALES-NÚMERO</code> (editable).
          </p>
        </div>

        <!-- Vista previa -->
        <div class="rounded-lg border border-neutral-200 dark:border-neutral-700 p-4 bg-neutral-50 dark:bg-neutral-900/40">
          <span class="text-sm text-neutral-500 dark:text-neutral-400">Vista previa:</span>
          <div class="mt-2 flex items-center gap-3">
            <span id="previewCarrera" class="text-base font-medium text-neutral-900 dark:text-neutral-100">—</span>
            <span id="previewChip"
              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200">—</span>
          </div>
        </div>

        <div class="flex justify-end gap-4 pt-6 border-t border-neutral-200 dark:border-neutral-700">
          <a href="/src/plataforma/app/admin/semesters"
             class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-md hover:bg-neutral-50 dark:hover:bg-neutral-600">
            Cancelar
          </a>
          <button type="submit"
             class="px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
             <?= empty($careers) ? 'disabled' : '' ?>>
            Crear Semestre
          </button>
        </div>
      </form>
    </div>
  </div>
</main>

<script>
  feather.replace();

  // Sugerir CLAVE = INICIALES + "-" + NUMERO (dos dígitos).
  const $career = document.getElementById('career_id');
  const $numero = document.getElementById('numero');
  const $clave  = document.getElementById('clave');
  const $prevC  = document.getElementById('previewCarrera');
  const $chip   = document.getElementById('previewChip');

  // Mapa id => {nombre, iniciales}
  const careersData = {
    <?php foreach ($careers as $c): ?>
      "<?= (int)($c->id ?? $c['id']) ?>": {
        nombre: "<?= htmlspecialchars($c->nombre ?? $c['nombre'], ENT_QUOTES) ?>",
        iniciales: "<?= htmlspecialchars(strtoupper($c->iniciales ?? $c['iniciales']), ENT_QUOTES) ?>",
      },
    <?php endforeach; ?>
  };

  let userEditedClave = false;

  function sugerirClave() {
    const cid = $career.value;
    const num = parseInt($numero.value || '0', 10);
    const data = careersData[cid];
    if (!data) return;
    const sug = `${data.iniciales}-${String(num).padStart(2,'0')}`;
    if (!userEditedClave && num > 0) $clave.value = sug;
    $prevC.textContent = data.nombre || '—';
    $chip.textContent  = $clave.value || sug || '—';
  }

  $career.addEventListener('change', sugerirClave);
  $numero.addEventListener('change', sugerirClave);
  $clave.addEventListener('input', () => { userEditedClave = true; $chip.textContent = $clave.value || '—'; });

  sugerirClave();
</script>
