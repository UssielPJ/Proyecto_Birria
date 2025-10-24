<?php
// Guard (opcional)
if (session_status() === PHP_SESSION_NONE) session_start();
$roles = $_SESSION['user']['roles'] ?? [];
if (!in_array('admin', $roles ?? [], true)) { header('Location: /src/plataforma/login'); exit; }

global $pdo;
$conn = $pdo;

// Cargar combos
$semesters = $conn->query("
  SELECT s.id, s.clave, s.numero, s.carrera_id,
         COALESCE(c.nombre, '') AS carrera_nombre
  FROM semestres s
  LEFT JOIN carreras c ON c.id = s.carrera_id
  ORDER BY c.nombre ASC, s.numero ASC
")->fetchAll(PDO::FETCH_ASSOC);

// Valores “viejos” si hubo validación previa (opcional)
$old = [
  'semestre_id' => $_POST['semestre_id'] ?? '',
  'titulo'      => $_POST['titulo']      ?? '',
  'capacidad'   => $_POST['capacidad']   ?? '',
  'inscritos'   => $_POST['inscritos']   ?? '0',
  'codigo'      => $_POST['codigo']      ?? '',
];
// $errors = [...] // si mandas errores desde el controlador
?>

<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Nuevo Grupo</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Registra un grupo asociado a un semestre.</p>
      </div>

      <?php if (!empty($errors ?? [])): ?>
        <div class="mb-4 rounded-lg border border-red-300 bg-red-50 dark:bg-red-900/30 p-3 text-red-700 dark:text-red-200">
          <ul class="list-disc pl-5">
            <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="/src/plataforma/app/admin/groups/store" method="POST" class="space-y-6" autocomplete="off">
        <!-- Semestre -->
        <div>
          <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre *</label>
          <select name="semestre_id" id="semestre_id"
                  class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500"
                  required>
            <option value="">Selecciona un semestre…</option>
            <?php foreach ($semesters as $s): ?>
              <option
                value="<?= $s['id'] ?>"
                data-clave="<?= htmlspecialchars($s['clave']) ?>"
                data-carrera="<?= htmlspecialchars($s['carrera_nombre']) ?>"
                data-numero="<?= (int)$s['numero'] ?>"
                <?= $old['semestre_id'] == $s['id'] ? 'selected' : '' ?>
              >
                <?= htmlspecialchars(($s['carrera_nombre'] ? $s['carrera_nombre'].' · ' : '').$s['clave']) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <p id="semestre_meta" class="mt-1 text-xs text-neutral-500 dark:text-neutral-400"></p>
        </div>

        <!-- Título -->
        <div>
          <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Título del grupo *</label>
          <input type="text" name="titulo" id="titulo" required
                 value="<?= htmlspecialchars($old['titulo']) ?>"
                 placeholder="Ej. Grupo A, Vespertino, IDGS 1A…"
                 class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500" />
          <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Nombre visible del grupo.</p>
        </div>

        <!-- Código (auto con vista previa) -->
        <div>
          <div class="flex items-center justify-between">
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Código *</label>
            <span id="codigo_preview"
                  class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold bg-neutral-100 text-neutral-700 dark:bg-neutral-700 dark:text-neutral-200">
              Vista previa: —
            </span>
          </div>
          <input type="text" name="codigo" id="codigo" required
                 value="<?= htmlspecialchars($old['codigo']) ?>"
                 placeholder="Se generará con la clave del semestre (editable)…"
                 class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500" />
          <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
            Por defecto: <code>CLAVE-<em>sufijo</em></code> (ej. <b>IDGS-01-A</b>). Puedes editarlo manualmente.
          </p>
        </div>

        <!-- Capacidad e Inscritos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Capacidad *</label>
            <input type="number" name="capacidad" id="capacidad" min="0" required
                   value="<?= htmlspecialchars($old['capacidad']) ?>"
                   class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500" />
          </div>
          <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Inscritos</label>
            <input type="number" name="inscritos" id="inscritos" min="0"
                   value="<?= htmlspecialchars($old['inscritos']) ?>"
                   class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500" />
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Si no indicas nada, usa 0.</p>
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
            Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  feather.replace();

  // ----- Helpers de UI -----
  const $sem   = document.getElementById('semestre_id');
  const $tit   = document.getElementById('titulo');
  const $cod   = document.getElementById('codigo');
  const $prev  = document.getElementById('codigo_preview');
  const $meta  = document.getElementById('semestre_meta');

  let manualOverride = false; // si el usuario edita el código, deja de autogenerarse

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
    const opt   = $sem.options[$sem.selectedIndex];
    const clave = opt && opt.dataset.clave ? opt.dataset.clave.toUpperCase() : '';
    const suf   = slug($tit.value).split('-')[0] || 'A'; // usa primera “palabra” del título; fallback A
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
  if (!$cod.value) autoCodigo();
</script>
