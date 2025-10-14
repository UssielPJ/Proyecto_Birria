<?php
// 🔒 Guard de acceso
if (session_status() === PHP_SESSION_NONE) session_start();
if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
  header('Location: /src/plataforma/'); exit;
}

use App\Core\Database;

$db   = new Database();
$conn = $db->getPdo();

// ¿Estamos editando?
$editing       = isset($inscripcion) && is_object($inscripcion);
$insc          = $editing ? $inscripcion : null;
$estudianteSel = $editing ? (int)($insc->estudiante_id ?? 0) : 0;

// Cargar un listado corto de alumnos
$alumnos = [];
try {
  $stmt = $conn->query("
    SELECT u.id AS user_id, u.nombre, u.email, sp.matricula
    FROM users u
    INNER JOIN student_profiles sp ON sp.user_id = u.id
    ORDER BY u.nombre ASC
    LIMIT 300
  ");
  $alumnos = $stmt->fetchAll(\PDO::FETCH_OBJ);
} catch (\Throwable $e) { $alumnos = []; }

// Si estamos editando y el alumno NO está en el top 300, lo agregamos manualmente
if ($editing && $estudianteSel) {
  $exists = false;
  foreach ($alumnos as $a) { if ((int)$a->user_id === $estudianteSel) { $exists = true; break; } }
  if (!$exists) {
    $stmt = $conn->prepare("
      SELECT u.id AS user_id, u.nombre, u.email, sp.matricula
      FROM users u
      INNER JOIN student_profiles sp ON sp.user_id = u.id
      WHERE u.id = ?
      LIMIT 1
    ");
    $stmt->execute([$estudianteSel]);
    if ($row = $stmt->fetch(\PDO::FETCH_OBJ)) {
      array_unshift($alumnos, $row);
    }
  }
}

// Sugerencias de periodos (IDs)
try {
  $periodos = $conn->query("SELECT DISTINCT periodo_id FROM inscripciones ORDER BY periodo_id DESC")
                   ->fetchAll(\PDO::FETCH_COLUMN);
} catch (\Throwable $e) { $periodos = []; }

// mensajes
$err = $_GET['error'] ?? '';
$ok  = $_GET['ok'] ?? '';
?>

<main class="p-6">
  <div class="mb-6">
    <h1 class="text-2xl font-bold mb-2">
      <?= $editing ? 'Editar inscripción' : 'Nueva inscripción' ?>
    </h1>
    <p class="text-neutral-500 dark:text-neutral-400">
      <?= $editing ? 'Modifica los datos de la inscripción seleccionada.' : 'Registra una nueva inscripción para un alumno.' ?>
    </p>
  </div>

  <?php if ($err): ?>
    <div class="mb-6 rounded-lg border border-red-300 bg-red-50 p-3 text-red-700">
      <strong>Error:</strong> <?= htmlspecialchars($err) ?>
    </div>
  <?php endif; ?>
  <?php if ($ok): ?>
    <div class="mb-6 rounded-lg border border-green-300 bg-green-50 p-3 text-green-700">
      Inscripción guardada correctamente.
    </div>
  <?php endif; ?>

  <form method="POST" action="/src/plataforma/app/capturista/inscripciones/guardar"
        class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 space-y-8">

    <?php if ($editing): ?>
      <input type="hidden" name="id" value="<?= (int)$insc->id ?>">
    <?php endif; ?>

    <!-- Alumno -->
    <section>
      <h2 class="text-lg font-semibold mb-4">Alumno</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm mb-1">Selecciona alumno</label>
          <select name="estudiante_id" required
                  class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
            <option value="">— Seleccionar —</option>
            <?php foreach ($alumnos as $a): ?>
              <option value="<?= (int)$a->user_id ?>"
                <?= $estudianteSel && (int)$a->user_id === $estudianteSel ? 'selected' : '' ?>>
                <?= htmlspecialchars($a->nombre) ?> — <?= htmlspecialchars($a->matricula ?? 's/matrícula') ?> (ID: <?= (int)$a->user_id ?>)
              </option>
            <?php endforeach; ?>
          </select>
          <p class="mt-1 text-xs text-neutral-500">Debe existir en <code>student_profiles</code>.</p>
        </div>

        <div>
          <label class="block text-sm mb-1">Grupo (ID)</label>
          <input type="number" name="grupo_id" min="0" step="1"
                 value="<?= $editing ? htmlspecialchars((string)($insc->grupo_id ?? '')) : '' ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700"
                 placeholder="Ej. 101">
          <p class="mt-1 text-xs text-neutral-500">Opcional si no manejas catálogo.</p>
        </div>
      </div>
    </section>

    <!-- Datos de inscripción -->
    <section>
      <h2 class="text-lg font-semibold mb-4">Datos de la inscripción</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
          <label class="block text-sm mb-1">Periodo (ID)</label>
          <select name="periodo_id"
                  class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
            <option value="">— Seleccionar —</option>
            <?php foreach ($periodos as $p): ?>
              <option value="<?= (int)$p ?>"
                <?= $editing && (string)$insc->periodo_id === (string)$p ? 'selected' : '' ?>>
                <?= (int)$p ?>
              </option>
            <?php endforeach; ?>
          </select>
          <p class="mt-1 text-xs text-neutral-500">Si no está en la lista, escribe el ID:</p>
          <input type="number" name="periodo_id_manual" min="0" step="1"
                 value="<?= $editing && !in_array($insc->periodo_id, $periodos) ? (int)$insc->periodo_id : '' ?>"
                 class="mt-2 w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700"
                 placeholder="Teclea el ID">
        </div>

        <div>
          <label class="block text-sm mb-1">Tipo de inscripción</label>
          <?php $tipo = $editing ? (string)$insc->tipo_inscripcion : 'normal'; ?>
          <select name="tipo_inscripcion" required
                  class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
            <option value="normal"   <?= $tipo==='normal'   ? 'selected' : '' ?>>Normal</option>
            <option value="adicional"<?= $tipo==='adicional'? 'selected' : '' ?>>Adicional</option>
            <option value="especial" <?= $tipo==='especial' ? 'selected' : '' ?>>Especial</option>
          </select>
        </div>

        <div>
          <label class="block text-sm mb-1">Estado</label>
          <?php $st = $editing ? (string)$insc->status : 'inscrito'; ?>
          <select name="status" required
                  class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
            <option value="inscrito"   <?= $st==='inscrito'   ? 'selected' : '' ?>>Inscrito</option>
            <option value="cursando"   <?= $st==='cursando'   ? 'selected' : '' ?>>Cursando</option>
            <option value="aprobado"   <?= $st==='aprobado'   ? 'selected' : '' ?>>Aprobado</option>
            <option value="reprobado"  <?= $st==='reprobado'  ? 'selected' : '' ?>>Reprobado</option>
            <option value="cancelada"  <?= $st==='cancelada'  ? 'selected' : '' ?>>Cancelada</option>
            <option value="completada" <?= $st==='completada' ? 'selected' : '' ?>>Completada</option>
          </select>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div>
          <label class="block text-sm mb-1">Fecha de inscripción</label>
          <?php
            // formatea a value de input datetime-local si viene la fecha
            $valueFecha = '';
            if ($editing && !empty($insc->fecha_inscripcion)) {
              $ts = strtotime($insc->fecha_inscripcion);
              if ($ts) $valueFecha = date('Y-m-d\TH:i', $ts);
            }
          ?>
          <input type="datetime-local" name="fecha_inscripcion"
                 value="<?= htmlspecialchars($valueFecha) ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
          <p class="mt-1 text-xs text-neutral-500">Vacío = se usa la fecha/hora actual del servidor.</p>
        </div>

        <div>
          <label class="block text-sm mb-1">Calificación final (opcional)</label>
          <input type="number" name="calificacion_final" step="0.01" min="0" max="10"
                 value="<?= $editing && $insc->calificacion_final !== null ? htmlspecialchars((string)$insc->calificacion_final) : '' ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
        </div>
      </div>
    </section>

    <!-- Acciones -->
    <div class="flex items-center justify-end gap-3">
      <a href="/src/plataforma/app/capturista/inscripciones"
         class="px-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-600">
        Cancelar
      </a>
      <button type="submit"
              class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white inline-flex items-center gap-2">
        <i data-feather="save"></i> <?= $editing ? 'Actualizar' : 'Guardar' ?>
      </button>
    </div>
  </form>
</main>

<script>
if (window.feather) feather.replace();

// Si el usuario escribe un periodo manual, vaciamos el select
const sel = document.querySelector('select[name="periodo_id"]');
const manual = document.querySelector('input[name="periodo_id_manual"]');
if (sel && manual) {
  manual.addEventListener('input', () => { if (manual.value !== '') sel.value = ''; });
}
</script>
