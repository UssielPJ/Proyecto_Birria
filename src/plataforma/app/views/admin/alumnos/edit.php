<?php
// Helpers para escapar y castear null→''
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

// Shorthands (pueden venir null si el controlador aún no los pasa)
$alumno = $alumno ?? (object)[];
$profile = $profile ?? (object)[];
?>
<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Editar Alumno</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Modifica la información del alumno</p>
      </div>

      <form action="/admin/alumnos/update/<?= $esc($alumno->id ?? '') ?>" method="POST" class="space-y-6">

        <!-- Información Personal (tabla: users) -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información Personal</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Nombre(s)</label>
              <input type="text" name="nombre" required value="<?= $esc($alumno->nombre ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Apellido paterno</label>
              <input type="text" name="apellido_paterno" value="<?= $esc($alumno->apellido_paterno ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Apellido materno</label>
              <input type="text" name="apellido_materno" value="<?= $esc($alumno->apellido_materno ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Correo electrónico</label>
              <input type="email" name="email" required value="<?= $esc($alumno->email ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Teléfono</label>
              <input type="tel" name="telefono" value="<?= $esc($alumno->telefono ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Fecha de nacimiento</label>
              <input type="date" name="fecha_nacimiento" value="<?= $esc($alumno->fecha_nacimiento ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Estado</label>
              <?php $status = (string)($alumno->status ?? 'active'); ?>
              <select name="status" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="active"   <?= $status==='active'   ? 'selected':'' ?>>Activo</option>
                <option value="inactive" <?= $status==='inactive' ? 'selected':'' ?>>Inactivo</option>
                <option value="suspended"<?= $status==='suspended'? 'selected':'' ?>>Suspendido</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Información Académica (tabla: student_profiles) -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información Académica</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Matrícula</label>
              <input type="text" name="matricula" required value="<?= $esc($profile->matricula ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">CURP</label>
              <input type="text" name="curp" required value="<?= $esc($profile->curp ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Carrera</label>
              <?php $carreraId = (string)($profile->carrera_id ?? ''); ?>
              <select name="carrera_id" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona una carrera</option>
                <?php foreach (($carreras ?? []) as $carrera): ?>
                  <option value="<?= htmlspecialchars($carrera['id'] ?? $carrera) ?>" <?= $carreraId === (string)($carrera['id'] ?? $carrera) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($carrera['nombre'] ?? $carrera) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Semestre</label>
              <?php $sem = (string)($profile->semestre ?? ''); ?>
              <select name="semestre" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona el semestre</option>
                <?php for ($i=1; $i<=12; $i++): ?>
                  <option value="<?= $i ?>" <?= $sem===(string)$i ? 'selected':'' ?>><?= $i ?></option>
                <?php endfor; ?>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Grupo</label>
              <input type="text" name="grupo" value="<?= $esc($profile->grupo ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Tipo de ingreso</label>
              <?php $tipo = (string)($profile->tipo_ingreso ?? 'nuevo'); ?>
              <select name="tipo_ingreso" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="nuevo"        <?= $tipo==='nuevo'        ? 'selected':'' ?>>Nuevo</option>
                <option value="reingreso"    <?= $tipo==='reingreso'    ? 'selected':'' ?>>Reingreso</option>
                <option value="transferencia"<?= $tipo==='transferencia'? 'selected':'' ?>>Transferencia</option>
              </select>
            </div>

            <div class="flex items-center gap-2">
              <input id="beca_activa" type="checkbox" name="beca_activa" value="1" <?= !empty($profile->beca_activa) ? 'checked':'' ?> class="h-4 w-4">
              <label for="beca_activa" class="text-sm font-medium">Beca activa</label>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Promedio general</label>
              <input type="number" step="0.01" min="0" max="100" name="promedio_general" value="<?= $esc($profile->promedio_general ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Créditos aprobados</label>
              <input type="number" min="0" name="creditos_aprobados" value="<?= $esc($profile->creditos_aprobados ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium mb-1">Dirección</label>
              <textarea name="direccion" rows="2" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800"><?= $esc($profile->direccion ?? '') ?></textarea>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Contacto de emergencia (nombre)</label>
              <input type="text" name="contacto_emergencia_nombre" value="<?= $esc($profile->contacto_emergencia_nombre ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Contacto de emergencia (teléfono)</label>
              <input type="tel" name="contacto_emergencia_telefono" value="<?= $esc($profile->contacto_emergencia_telefono ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium mb-1">Parentesco de emergencia</label>
              <input type="text" name="parentesco_emergencia" value="<?= $esc($profile->parentesco_emergencia ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
          </div>
        </div>

        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
  <h2 class="font-semibold text-lg">Cambiar Contraseña</h2>
  <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
    Deja estos campos en blanco si no deseas cambiar la contraseña
  </p>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Contraseña -->
    <div class="relative">
      <label class="block text-sm font-medium mb-1">Nueva contraseña</label>
      <input
        type="password"
        id="password"
        name="password"
        placeholder="••••••••"
        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700
               bg-white dark:bg-neutral-800 pr-10 focus:ring-2 focus:ring-primary-500">
      <button
        type="button"
        id="togglePassword"
        class="absolute inset-y-0 right-0 flex items-center pr-3 text-neutral-500 dark:text-neutral-400"
        tabindex="-1">
        <i data-feather="eye"></i>
      </button>
    </div>

    <!-- Confirmar -->
    <div class="relative">
      <label class="block text-sm font-medium mb-1">Confirmar contraseña</label>
      <input
        type="password"
        id="password_confirmation"
        name="password_confirmation"
        placeholder="••••••••"
        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700
               bg-white dark:bg-neutral-800 pr-10 focus:ring-2 focus:ring-primary-500">
      <button
        type="button"
        id="togglePasswordConfirm"
        class="absolute inset-y-0 right-0 flex items-center pr-3 text-neutral-500 dark:text-neutral-400"
        tabindex="-1">
        <i data-feather="eye"></i>
      </button>
    </div>
  </div>
</div>

        <div class="flex justify-end gap-4">
          <a href="/admin/alumnos" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
            Cancelar
          </a>
          <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
            Guardar Cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Función para alternar visibilidad
  function toggleVisibility(inputId, buttonId) {
    const input = document.getElementById(inputId);
    const btn = document.getElementById(buttonId);
    const icon = btn.querySelector('i');

    btn.addEventListener('click', () => {
      const isHidden = input.getAttribute('type') === 'password';
      input.setAttribute('type', isHidden ? 'text' : 'password');
      icon.setAttribute('data-feather', isHidden ? 'eye-off' : 'eye');
      feather.replace();
    });
  }

  toggleVisibility('password', 'togglePassword');
  toggleVisibility('password_confirmation', 'togglePasswordConfirm');

  // Validación de contraseña (opcional)
  const form = document.querySelector('form');
  form.addEventListener('submit', function(e) {
    const p1 = form.querySelector('input[name="password"]').value;
    const p2 = form.querySelector('input[name="password_confirmation"]').value;
    if (p1 || p2) {
      if (p1 !== p2) { e.preventDefault(); alert('Las contraseñas no coinciden'); return; }
      if (p1.length < 6) { e.preventDefault(); alert('La contraseña debe tener al menos 6 caracteres'); return; }
    }
  });
</script>