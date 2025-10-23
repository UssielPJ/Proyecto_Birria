<?php
global $pdo;
$conn = $pdo;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = trim($_POST['nombre'] ?? '');
    $iniciales = strtoupper(trim($_POST['iniciales'] ?? ''));
    // status: 1=activa, 0=inactiva
    $status    = isset($_POST['status']) && $_POST['status'] !== '' ? (int)$_POST['status'] : 1;

    // Validaciones
    if ($nombre === '') {
        $errors[] = 'El nombre de la carrera es obligatorio.';
    }
    if ($iniciales === '') {
        $errors[] = 'Las iniciales son obligatorias.';
    } elseif (mb_strlen($iniciales) < 2 || mb_strlen($iniciales) > 10) {
        $errors[] = 'Las iniciales deben tener entre 2 y 10 caracteres.';
    }

    // Unicidad básica
    if (empty($errors)) {
        // ¿existe nombre?
        $stmt = $conn->prepare("SELECT COUNT(*) FROM carreras WHERE nombre = ?");
        $stmt->execute([$nombre]);
        if ($stmt->fetchColumn() > 0) $errors[] = 'Ya existe una carrera con ese nombre.';

        // ¿existen iniciales?
        $stmt = $conn->prepare("SELECT COUNT(*) FROM carreras WHERE iniciales = ?");
        $stmt->execute([$iniciales]);
        if ($stmt->fetchColumn() > 0) $errors[] = 'Las iniciales ya están en uso.';
    }

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("
                INSERT INTO carreras (nombre, iniciales, status)
                VALUES (:nombre, :iniciales, :status)
            ");
            $stmt->execute([
                ':nombre'    => $nombre,
                ':iniciales' => $iniciales,
                ':status'    => $status
            ]);

            header('Location: /src/plataforma/app/admin/careers?success=created');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Error al crear la carrera: ' . $e->getMessage();
        }
    }
}
?>
<main class="p-6">
  <div class="max-w-3xl mx-auto">
    <div class="mb-6">
      <div class="flex items-center gap-4 mb-4">
        <a href="/src/plataforma/app/admin/careers"
           class="text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200">
          <i data-feather="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
          <h1 class="text-2xl font-bold">Nueva Carrera</h1>
          <p class="text-neutral-500 dark:text-neutral-400">Ingresa la información de la nueva carrera.</p>
        </div>
      </div>
    </div>

    <?php if (!empty($errors)): ?>
      <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
        <div class="flex">
          <i data-feather="alert-circle" class="w-5 h-5 text-red-400 mr-2 mt-0.5"></i>
          <div>
            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Revisa estos detalles:</h3>
            <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
              <?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <form method="POST" action="/src/plataforma/app/admin/careers/store" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="md:col-span-2">
            <label for="nombre" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
              Nombre de la carrera *
            </label>
            <input type="text" name="nombre" id="nombre" required
              value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
              class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500"
              placeholder="Ej: Ingeniería en Sistemas Computacionales">
            <p class="mt-2 text-xs text-neutral-500 dark:text-neutral-400">
              Escribe el nombre completo; las iniciales se sugerirán automáticamente.
            </p>
          </div>

          <div>
            <label for="iniciales" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
              Iniciales *
            </label>
            <input type="text" name="iniciales" id="iniciales" required
              value="<?= htmlspecialchars($_POST['iniciales'] ?? '') ?>"
              class="uppercase block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500"
              placeholder="Ej: ISC">
            <p class="mt-2 text-xs text-neutral-500 dark:text-neutral-400">
              Puedes editar las iniciales sugeridas.
            </p>
          </div>

          <div>
            <label for="status" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
              Estado *
            </label>
            <?php $st = $_POST['status'] ?? 'activa'; ?>
            <select name="status" id="status" required class="block w-full rounded-md ...">
                <option value="activa"   <?= $st === 'activa'   ? 'selected' : '' ?>>Activa</option>
                <option value="inactiva" <?= $st === 'inactiva' ? 'selected' : '' ?>>Inactiva</option>
            </select>
          </div>
        </div>

        <!-- Vista previa -->
        <div class="rounded-lg border border-neutral-200 dark:border-neutral-700 p-4 bg-neutral-50 dark:bg-neutral-900/40">
          <span class="text-sm text-neutral-500 dark:text-neutral-400">Vista previa:</span>
          <div class="mt-2 flex items-center gap-3">
            <span id="previewNombre" class="text-base font-medium text-neutral-900 dark:text-neutral-100">—</span>
            <span id="previewChip"
              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-200">
              —
            </span>
          </div>
        </div>

        <div class="flex justify-end gap-4 pt-6 border-t border-neutral-200 dark:border-neutral-700">
          <a href="/src/plataforma/app/admin/careers"
             class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-md hover:bg-neutral-50 dark:hover:bg-neutral-600">
            Cancelar
          </a>
          <button type="submit"
             class="px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
            Crear Carrera
          </button>
        </div>
      </form>
    </div>
  </div>
</main>

<script>
  feather.replace();

  // Stopwords comunes para generar las iniciales
  const STOP = new Set(['de','del','la','el','los','las','y','en','para','por','a','e','o','u','con']);

  const $nombre    = document.getElementById('nombre');
  const $iniciales = document.getElementById('iniciales');
  const $prevNom   = document.getElementById('previewNombre');
  const $prevChip  = document.getElementById('previewChip');

  function sugerirIniciales(nombre) {
    const parts = nombre
      .normalize('NFD').replace(/\p{Diacritic}/gu, '')   // quita acentos
      .toLowerCase()
      .split(/[\s\-_/.,;:]+/)
      .filter(Boolean)
      .filter(w => !STOP.has(w));

    // Toma primera letra de cada palabra significativa
    const acro = parts.map(w => w[0]).join('').slice(0, 10).toUpperCase();
    return acro || nombre.trim().slice(0, 3).toUpperCase();
  }

  function syncPreview() {
    const nom = $nombre.value.trim();
    if (nom && !$iniciales.dataset.userEdited) {
      $iniciales.value = sugerirIniciales(nom);
    }
    $prevNom.textContent  = nom || '—';
    $prevChip.textContent = ($iniciales.value || '—').toUpperCase();
  }

  // Cuando el usuario escribe el nombre → autollenar iniciales (si no editó manualmente)
  $nombre.addEventListener('input', syncPreview);

  // Si el usuario escribe en "iniciales", marcamos como edición manual
  $iniciales.addEventListener('input', () => {
    $iniciales.value = $iniciales.value.toUpperCase();
    $iniciales.dataset.userEdited = '1';
    $prevChip.textContent = $iniciales.value || '—';
  });

  // Estado inicial
  syncPreview();
</script>
