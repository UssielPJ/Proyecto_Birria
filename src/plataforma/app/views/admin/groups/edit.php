<?php
// Protección (si manejas roles)
if (session_status() === PHP_SESSION_NONE) session_start();
$roles = $_SESSION['user']['roles'] ?? [];
if (!in_array('admin', $roles ?? [], true)) { header('Location: /src/plataforma/login'); exit; }

/**
 * Esta vista NO debe leer $_GET ni consultar la BD.
 * El controlador debe pasar:
 *  - $grupo (o $group) y
 *  - $semestres (o $semesters).
 * Convertimos a arrays si vienen como objetos (stdClass).
 */
if (isset($grupo) && !isset($group)) { $group = $grupo; }
if (isset($semestres) && !isset($semesters)) { $semesters = $semestres; }

if (!isset($group) || !isset($semesters)) {
  echo "<div class='p-6 text-red-600 font-semibold'>Error: datos no recibidos desde el controlador.</div>";
  exit;
}

/* 👉 Normalizamos tipos para evitar "Cannot use stdClass as array" */
if (is_object($group)) {
  $group = (array)$group;
}
if (is_array($semesters) && !empty($semesters) && is_object($semesters[0])) {
  $semesters = array_map(static fn($o) => (array)$o, $semesters);
}
?>
<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Editar Grupo</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Modifica la información del grupo seleccionado.</p>
      </div>

      <form action="/src/plataforma/app/admin/groups/update/<?= (int)$group['id'] ?>" method="POST" class="space-y-6" autocomplete="off">
        <!-- Semestre -->
        <div>
          <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre *</label>
          <select name="semestre_id" id="semestre_id"
                  class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500"
                  required>
            <option value="">Selecciona un semestre…</option>
            <?php foreach ($semesters as $s): ?>
              <?php /* $s ya es array; si faltan claves opcionales, usamos operador ?? */ ?>
              <option 
                value="<?= (int)$s['id'] ?>" 
                data-clave="<?= htmlspecialchars($s['clave'] ?? '') ?>"
                data-carrera="<?= htmlspecialchars($s['carrera_nombre'] ?? '') ?>"
                data-numero="<?= htmlspecialchars($s['numero'] ?? '') ?>"
                <?= (int)$s['id'] === (int)$group['semestre_id'] ? 'selected' : '' ?>
              >
                <?= htmlspecialchars(($s['carrera_nombre'] ?? '') ? $s['carrera_nombre'] . ' · ' : '') . htmlspecialchars($s['clave'] ?? '') ?>
              </option>
            <?php endforeach; ?>
          </select>
          <p id="semestre_meta" class="mt-1 text-xs text-neutral-500 dark:text-neutral-400"></p>
        </div>

        <!-- Título -->
        <div>
          <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Título del grupo *</label>
          <input type="text" name="titulo" id="titulo" required
                 value="<?= htmlspecialchars($group['titulo']) ?>"
                 placeholder="Ej. Grupo A, Vespertino, IDGS 1A…"
                 class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500" />
        </div>

        <!-- Código con vista previa -->
        <div>
          <div class="flex items-center justify-between">
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Código *</label>
            <span id="codigo_preview"
                  class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-neutral-100 text-neutral-700 dark:bg-neutral-700 dark:text-neutral-200">
              Vista previa: <?= htmlspecialchars($group['codigo'] ?: '—') ?>
            </span>
          </div>
          <input type="text" name="codigo" id="codigo" required
                 value="<?= htmlspecialchars($group['codigo']) ?>"
                 class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500" />
          <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
            Puedes modificar el código si lo deseas. Ejemplo: <b>IDGS-01-A</b>
          </p>
        </div>

        <!-- Capacidad e Inscritos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Capacidad *</label>
            <input type="number" name="capacidad" id="capacidad" min="0" required
                   value="<?= (int)$group['capacidad'] ?>"
                   class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500" />
          </div>
          <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Inscritos</label>
            <input type="number" name="inscritos" id="inscritos" min="0"
                   value="<?= (int)$group['inscritos'] ?>"
                   class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500" />
          </div>
        </div>

        <!-- Acciones -->
        <div class="flex items-center justify-end gap-3 pt-2">
          <a href="/src/plataforma/app/admin/groups"
             class="px-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-600 text-neutral-700 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-700">
            Cancelar
          </a>
          <button type="submit"
                  class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg inline-flex items-center gap-2">
            <i data-feather="save"></i>
            Actualizar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  feather.replace();

  const $sem  = document.getElementById('semestre_id');
  const $tit  = document.getElementById('titulo');
  const $cod  = document.getElementById('codigo');
  const $prev = document.getElementById('codigo_preview');
  const $meta = document.getElementById('semestre_meta');

  let manualOverride = false;

  function slug(str) {
    return (str || '')
      .toString()
      .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
      .replace(/[^a-zA-Z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '')
      .toUpperCase();
  }

  function updateMeta() {
    const opt = $sem.options[$sem.selectedIndex];
    if (!opt || !opt.dataset) { $meta.textContent = ''; return; }
    const clave   = opt.dataset.clave || '';
    const carrera = opt.dataset.carrera || '';
    const numero  = opt.dataset.numero || '';
    $meta.textContent = `${carrera ? carrera + ' · ' : ''}Clave: ${clave}${numero ? ' · N° ' + numero : ''}`;
  }

  function autoCodigo() {
    if (manualOverride) return;
    const opt = $sem.options[$sem.selectedIndex];
    const clave = opt && opt.dataset.clave ? opt.dataset.clave.toUpperCase() : '';
    const suf = slug($tit.value).split('-')[0] || 'A';
    const value = (clave ? clave + '-' : '') + suf;
    $cod.value = value;
    $prev.textContent = 'Vista previa: ' + (value || '—');
  }

  // Eventos
  $sem.addEventListener('change', () => { updateMeta(); autoCodigo(); });
  $tit.addEventListener('input',  () => { autoCodigo(); });
  $cod.addEventListener('input',  () => {
    manualOverride = true;
    $prev.textContent = 'Vista previa: ' + ($cod.value || '—');
  });

  // Init
  updateMeta();
  $prev.textContent = 'Vista previa: ' + ($cod.value || '—');
</script>
