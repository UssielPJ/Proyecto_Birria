<?php
// Opcional: protección (igual que otras vistas)
if (session_status() === PHP_SESSION_NONE) session_start();
$roles = $_SESSION['user']['roles'] ?? [];
if (!in_array('admin', $roles ?? [], true)) { header('Location: /src/plataforma/login'); exit; }

/**
 * Variables esperadas desde el controlador:
 * - $semestres   : array [ ['id'=>..,'clave'=>..], ... ]
 * - $grupos      : array [ ['id','codigo','titulo','capacidad','inscritos'], ... ] (solo si hay semestre seleccionado)
 * - $disponibles : array [ ['user_id','matricula','nombre','apellido_paterno','apellido_materno'], ... ] (si hay semestre)
 * - $asignados   : array [ ['user_id','matricula','nombre','apellido_paterno','apellido_materno'], ... ] (si hay grupo)
 * - $semestre_id : int
 * - $grupo_id    : int
 */

// Buscar meta del grupo seleccionado para mostrar capacidad/inscritos
$grupoMeta = null;
if (!empty($grupo_id) && !empty($grupos)) {
  foreach ($grupos as $g) {
    if ((int)$g['id'] === (int)$grupo_id) { $grupoMeta = $g; break; }
  }
}

// Flash message (estilo consistente con tus otras vistas)
if (!empty($_SESSION['flash'])):
  $type = $_SESSION['flash']['type'] ?? 'info';
  $msg  = $_SESSION['flash']['msg']  ?? '';
  $classes = [
    'success' => 'bg-green-50 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-200 dark:border-green-800',
    'error'   => 'bg-red-50 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-200 dark:border-red-800',
    'info'    => 'bg-blue-50 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-200 dark:border-blue-800',
  ];
  $cls = $classes[$type] ?? $classes['info'];
?>
  <div id="flash-msg" class="mx-6 mt-4 mb-0 border rounded-lg px-4 py-3 <?= $cls; ?>">
    <div class="flex items-start gap-2">
      <i data-feather="<?= $type === 'success' ? 'check-circle' : ($type === 'error' ? 'alert-triangle' : 'info') ?>"></i>
      <div class="text-sm font-medium"><?= htmlspecialchars($msg) ?></div>
    </div>
  </div>
  <script>
    setTimeout(() => {
      const el = document.getElementById('flash-msg');
      if (el) el.style.display = 'none';
    }, 3500);
  </script>
  <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<main class="p-6">
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
      <h1 class="text-2xl font-bold">Asignar alumnos a grupos</h1>
      <p class="text-neutral-500 dark:text-neutral-400">Selecciona un semestre y un grupo para gestionar asignaciones.</p>
    </div>
    <a href="/src/plataforma/app/admin/groups"
       class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2 w-full sm:w-auto justify-center">
      <i data-feather="arrow-left"></i> Volver a Grupos
    </a>
  </div>

  <!-- Filtros -->
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 mb-6">
    <form class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <!-- Semestre -->
      <div>
        <label for="semestre_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre</label>
        <select name="semestre_id" id="semestre_id"
                class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
          <option value="">Selecciona semestre…</option>
          <?php foreach ($semestres as $s): ?>
            <option value="<?= (int)$s['id'] ?>" <?= (string)$semestre_id === (string)$s['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($s['clave']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Grupo (solo si hay semestre) -->
      <div>
        <label for="grupo_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Grupo</label>
        <select name="grupo_id" id="grupo_id"
                class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500"
                <?= empty($semestre_id) ? 'disabled' : '' ?>>
          <option value=""><?= empty($semestre_id) ? 'Selecciona primero un semestre' : 'Selecciona grupo…' ?></option>
          <?php if (!empty($grupos)): ?>
            <?php foreach ($grupos as $g): ?>
              <?php
                $label = trim(($g['titulo'] ?? '').($g['codigo'] ? ' ('.$g['codigo'].')' : ''));
              ?>
              <option value="<?= (int)$g['id'] ?>" <?= (string)$grupo_id === (string)$g['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($label) ?>
              </option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>

      <!-- Botón filtrar (para móviles / fallback) -->
      <div class="flex items-end">
        <button type="submit"
                class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2 w-full sm:w-auto justify-center">
          <i data-feather="filter"></i> Aplicar
        </button>
      </div>
    </form>

    <!-- Resumen del grupo -->
    <?php if ($grupoMeta): ?>
      <div class="mt-4 flex flex-wrap items-center gap-3 text-sm">
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-neutral-100 text-neutral-700 dark:bg-neutral-700 dark:text-neutral-200">
          <i data-feather="users"></i>
          Capacidad: <b><?= (int)$grupoMeta['capacidad'] ?></b>
        </span>
        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-neutral-100 text-neutral-700 dark:bg-neutral-700 dark:text-neutral-200">
          <i data-feather="user-check"></i>
          Inscritos: <b><?= (int)$grupoMeta['inscritos'] ?></b>
        </span>
      </div>
    <?php endif; ?>
  </div>

  <!-- Paneles -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Disponibles -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4">
      <div class="flex items-center justify-between mb-3">
        <h2 class="text-lg font-semibold">Alumnos disponibles</h2>
        <span class="text-sm text-neutral-500 dark:text-neutral-400"><?= count($disponibles ?? []) ?> encontrados</span>
      </div>

      <?php if (empty($semestre_id)): ?>
        <div class="p-4 text-sm text-neutral-600 dark:text-neutral-300">
          Selecciona un <b>semestre</b> para ver alumnos disponibles.
        </div>
      <?php else: ?>
        <form method="POST" action="/src/plataforma/app/admin/group_assignments/assign" class="space-y-3" onsubmit="return confirmAssign()">
          <input type="hidden" name="semestre_id" value="<?= (int)$semestre_id ?>">
          <input type="hidden" name="grupo_id" value="<?= (int)$grupo_id ?>">

          <div class="relative">
            <input type="text" id="filtro_disponibles" placeholder="Filtrar por nombre o matrícula…"
                   class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 pr-10 focus:border-primary-500 focus:ring-primary-500 text-sm">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
              <i data-feather="search" class="h-5 w-5 text-neutral-400"></i>
            </div>
          </div>

          <div class="max-h-96 overflow-auto border border-neutral-200 dark:border-neutral-700 rounded-lg">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
              <thead class="bg-neutral-50 dark:bg-neutral-800 sticky top-0">
                <tr>
                  <th class="px-4 py-2 w-10">
                    <input type="checkbox" id="chk_all">
                  </th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Alumno</th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Matrícula</th>
                </tr>
              </thead>
              <tbody id="tbody_disponibles" class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                <?php if (!empty($disponibles)): ?>
                  <?php foreach ($disponibles as $a): ?>
                    <?php
                      $nombre = trim(($a['apellido_paterno'] ?? '').' '.($a['apellido_materno'] ?? '').' '.($a['nombre'] ?? ''));
                    ?>
                    <tr class="fila-disponible">
                      <td class="px-4 py-2">
                        <input type="checkbox" name="alumnos[]" value="<?= (int)$a['user_id'] ?>" class="chk_item">
                      </td>
                      <td class="px-4 py-2">
                        <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100"><?= htmlspecialchars($nombre) ?></div>
                      </td>
                      <td class="px-4 py-2 text-sm text-neutral-700 dark:text-neutral-300"><?= htmlspecialchars($a['matricula'] ?? '') ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="3" class="px-4 py-3 text-sm text-neutral-500 dark:text-neutral-400">No hay alumnos disponibles sin grupo en este semestre.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <div class="flex items-center justify-end gap-2 pt-2">
            <button type="submit"
                    class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg inline-flex items-center gap-2"
                    <?= empty($grupo_id) ? 'disabled title="Selecciona un grupo"' : '' ?>>
              <i data-feather="user-plus"></i> Asignar seleccionados
            </button>
          </div>
        </form>
      <?php endif; ?>
    </div>

    <!-- Asignados -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4">
      <div class="flex items-center justify-between mb-3">
        <h2 class="text-lg font-semibold">Alumnos asignados</h2>
        <span class="text-sm text-neutral-500 dark:text-neutral-400"><?= count($asignados ?? []) ?> en el grupo</span>
      </div>

      <?php if (empty($grupo_id)): ?>
        <div class="p-4 text-sm text-neutral-600 dark:text-neutral-300">
          Selecciona un <b>grupo</b> para ver y quitar alumnos asignados.
        </div>
      <?php else: ?>
        <div class="overflow-x-auto border border-neutral-200 dark:border-neutral-700 rounded-lg">
          <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
            <thead class="bg-neutral-50 dark:bg-neutral-800">
              <tr>
                <th class="px-4 py-2 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Alumno</th>
                <th class="px-4 py-2 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Matrícula</th>
                <th class="px-4 py-2"></th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
              <?php if (!empty($asignados)): ?>
                <?php foreach ($asignados as $a): ?>
                  <?php
                    $nombre = trim(($a['apellido_paterno'] ?? '').' '.($a['apellido_materno'] ?? '').' '.($a['nombre'] ?? ''));
                  ?>
                  <tr>
                    <td class="px-4 py-2">
                      <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100"><?= htmlspecialchars($nombre) ?></div>
                    </td>
                    <td class="px-4 py-2 text-sm text-neutral-700 dark:text-neutral-300"><?= htmlspecialchars($a['matricula'] ?? '') ?></td>
                    <td class="px-4 py-2 text-right">
                      <form method="POST" action="/src/plataforma/app/admin/group_assignments/unassign" class="inline"
                            onsubmit="return confirm('¿Quitar a este alumno del grupo?');">
                        <input type="hidden" name="user_id" value="<?= (int)$a['user_id'] ?>">
                        <input type="hidden" name="grupo_id" value="<?= (int)$grupo_id ?>">
                        <input type="hidden" name="semestre_id" value="<?= (int)$semestre_id ?>">
                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 inline-flex items-center gap-1">
                          <i data-feather="user-minus"></i> Quitar
                        </button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="3" class="px-4 py-3 text-sm text-neutral-500 dark:text-neutral-400">Este grupo no tiene alumnos asignados.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</main>

<script>
  feather.replace();

  // Auto-submit de filtros al cambiar selects
  const selSem = document.getElementById('semestre_id');
  const selGru = document.getElementById('grupo_id');
  if (selSem) selSem.addEventListener('change', () => {
    // al cambiar semestre, limpia el grupo para evitar confusión
    if (selGru) selGru.value = '';
    selSem.form.submit();
  });
  if (selGru) selGru.addEventListener('change', () => selGru.form.submit());

  // Filtro local de disponibles
  const filtro = document.getElementById('filtro_disponibles');
  const tbody  = document.getElementById('tbody_disponibles');
  if (filtro && tbody) {
    filtro.addEventListener('input', () => {
      const q = filtro.value.toLowerCase();
      tbody.querySelectorAll('tr.fila-disponible').forEach(tr => {
        const texto = tr.innerText.toLowerCase();
        tr.style.display = texto.includes(q) ? '' : 'none';
      });
    });
  }

  // Seleccionar/Deseleccionar todos
  const chkAll = document.getElementById('chk_all');
  if (chkAll && tbody) {
    chkAll.addEventListener('change', () => {
      tbody.querySelectorAll('input.chk_item').forEach(chk => { chk.checked = chkAll.checked; });
    });
  }

  // Confirmar asignación si no hay grupo seleccionado
  function confirmAssign() {
    const gsel = document.querySelector('input[name="grupo_id"]')?.value || document.getElementById('grupo_id')?.value;
    if (!gsel) {
      alert('Selecciona un grupo antes de asignar.');
      return false;
    }
    return true;
  }
</script>
