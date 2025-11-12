<?php
// Guard de acceso
if (session_status() === PHP_SESSION_NONE) session_start();
if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
  header('Location: /src/plataforma/'); exit;
}

// $aspirante puede/no venir del controlador en modo edición
$isEdit = isset($aspirante) && is_object($aspirante);
$title  = $isEdit ? 'Editar registro' : 'Nuevo registro';
$desc   = $isEdit ? 'Modifica los datos del aspirante.' : 'Ingresa los datos del aspirante.';
$aspirante = $aspirante ?? (object)[];
?>

<main class="p-6">
  <div class="mb-6">
    <h1 class="text-2xl font-bold mb-2"><?= $title ?></h1>
    <p class="text-neutral-500 dark:text-neutral-400"><?= $desc ?></p>
  </div>

  <?php if (!empty($_GET['error'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
      <strong class="font-bold">Error:</strong>
      <span class="block sm:inline"><?= htmlspecialchars($_GET['error']) ?></span>
    </div>
  <?php endif; ?>

  <form method="POST" action="/src/plataforma/app/capturista/solicitudes/guardar"
        class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 space-y-8">
    <?php if ($isEdit): ?>
      <input type="hidden" name="id" value="<?= (int)$aspirante->id ?>">
    <?php endif; ?>

    <!-- Identificación -->
    <section>
      <h2 class="text-lg font-semibold mb-4">Identificación</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm mb-1">Folio</label>
          <input name="folio" type="text" value="<?= htmlspecialchars($aspirante->folio ?? '') ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
        </div>
        <div>
          <label class="block text-sm mb-1">CURP</label>
          <input name="curp" type="text" value="<?= htmlspecialchars($aspirante->curp ?? '') ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700" maxlength="18">
        </div>
      </div>
    </section>

    <!-- Datos personales -->
    <section>
      <h2 class="text-lg font-semibold mb-4">Datos personales</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
          <label class="block text-sm mb-1">Nombre</label>
          <input name="nombre" type="text" required value="<?= htmlspecialchars($aspirante->nombre ?? '') ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
        </div>
        <div>
          <label class="block text-sm mb-1">Apellido paterno</label>
          <input name="apellido_paterno" type="text" value="<?= htmlspecialchars($aspirante->apellido_paterno ?? '') ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
        </div>
        <div>
          <label class="block text-sm mb-1">Apellido materno</label>
          <input name="apellido_materno" type="text" value="<?= htmlspecialchars($aspirante->apellido_materno ?? '') ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div>
          <label class="block text-sm mb-1">Correo</label>
          <input name="email" type="email" required value="<?= htmlspecialchars($aspirante->email ?? '') ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
        </div>
        <div>
          <label class="block text-sm mb-1">Teléfono</label>
          <input name="telefono" type="text" value="<?= htmlspecialchars($aspirante->telefono ?? '') ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
        </div>
        <div>
          <label class="block text-sm mb-1">Fecha de nacimiento</label>
          <input name="fecha_nacimiento" type="date" value="<?= htmlspecialchars($aspirante->fecha_nacimiento ?? '') ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
        </div>
      </div>

      <div class="mt-6">
        <label class="block text-sm mb-1">Dirección</label>
        <textarea name="direccion" rows="2"
                  class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700"><?= htmlspecialchars($aspirante->direccion ?? '') ?></textarea>
      </div>
    </section>

    <!-- Datos académicos -->
    <section>
      <h2 class="text-lg font-semibold mb-4">Datos académicos</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
          <label class="block text-sm mb-1">Carrera solicitada (ID)</label>
          <input name="carrera_solicitada_id" type="number" min="0"
                 value="<?= htmlspecialchars($aspirante->carrera_solicitada_id ?? '') ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
        </div>
        <div>
          <label class="block text-sm mb-1">Periodo solicitado (ID)</label>
          <input name="periodo_solicitado_id" type="number" min="0"
                 value="<?= htmlspecialchars($aspirante->periodo_solicitado_id ?? '') ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
        </div>
        <div>
          <label class="block text-sm mb-1">Promedio preparatoria</label>
          <input name="promedio_preparatoria" type="number" step="0.01" min="0" max="10"
                 value="<?= htmlspecialchars($aspirante->promedio_preparatoria ?? '') ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <div>
          <label class="block text-sm mb-1">Preparatoria de procedencia</label>
          <input name="preparatoria_procedencia" type="text"
                 value="<?= htmlspecialchars($aspirante->preparatoria_procedencia ?? '') ?>"
                 class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
        </div>
        <div>
          <label class="block text-sm mb-1">Estatus</label>
          <select name="status"
                  class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
            <?php
              $statuses = ['registrado','documentacion','examen','aceptado','rechazado'];
              $current  = $aspirante->status ?? 'registrado';
              foreach ($statuses as $s):
            ?>
              <option value="<?= $s ?>" <?= $current === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="mt-6">
        <label class="block text-sm mb-1">Documentos entregados (JSON o texto)</label>
        <textarea name="documentos_entregados" rows="3"
                  class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700"><?= htmlspecialchars($aspirante->documentos_entregados ?? '') ?></textarea>
      </div>
    </section>

    <!-- Acciones -->
    <div class="flex items-center justify-end gap-3">
      <a href="/src/plataforma/app/capturista/solicitudes"
         class="bg-white dark:bg-neutral-700 px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-600">Cancelar</a>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center gap-2">
        <i data-feather="save"></i>
        Guardar
      </button>
    </div>
  </form>
</main>

<script>
if (window.feather) feather.replace();
</script>
