<?php
// ===== Helpers =====
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

/** Convierte objeto/array a escalar imprimible, respetando orden preferido */
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
    $first = reset($v);
    return is_scalar($first) ? $first : '';
  }
  return $v; // ya es escalar/null
};

// Shorthands
$st = $student ?? (object)[];
$pf = $profile ?? (object)[];

// Catálogos (permitimos que falten)
$semestres = $semestres ?? []; // usamos FK semestre_id

$status = (string)($st->status ?? 'active');
$semId  = (string)($pf->semestre_id ?? '');
$carreraIdActual = (string)($pf->carrera_id ?? ''); // para precargar el hidden
?>
<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Editar Estudiante</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Modifica la información del estudiante</p>
      </div>

      <form action="/src/plataforma/app/admin/students/update/<?= $esc($st->id ?? '') ?>" method="POST" class="space-y-6">

        <!-- Información Personal (users) -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información Personal</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Nombre(s)</label>
              <input type="text" name="nombre" required value="<?= $esc($st->nombre ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Apellido paterno</label>
              <input type="text" name="apellido_paterno" value="<?= $esc($st->apellido_paterno ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Apellido materno</label>
              <input type="text" name="apellido_materno" value="<?= $esc($st->apellido_materno ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Correo electrónico</label>
              <input type="email" name="email" required value="<?= $esc($st->email ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Teléfono</label>
              <input type="tel" name="telefono" value="<?= $esc($st->telefono ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Fecha de nacimiento</label>
              <input type="date" name="fecha_nacimiento" value="<?= $esc($st->fecha_nacimiento ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Estado</label>
              <select name="status" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="active"    <?= $status==='active'    ? 'selected':'' ?>>Activo</option>
                <option value="inactive"  <?= $status==='inactive'  ? 'selected':'' ?>>Inactivo</option>
                <option value="suspended" <?= $status==='suspended' ? 'selected':'' ?>>Suspendido</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Información Académica (student_profiles) -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información Académica</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Campo de Matrícula eliminado -->

            <div>
              <label class="block text-sm font-medium mb-1">CURP</label>
              <input type="text" name="curp" required value="<?= $esc($pf->curp ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <!-- Semestre (usar FK semestre_id); Carrera se infiere y se envía en hidden -->
            <div class="md:col-span-2">
              <label class="block text-sm font-medium mb-1">Semestre</label>
              <select id="semestre_id" name="semestre_id" required
                      class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona el semestre</option>
                <?php if (!empty($semestres)): ?>
                  <?php foreach ($semestres as $s):
                        $optId   = (string)$toScalar($s, ['id']);
                        $optLbl  = (string)$toScalar($s, ['label','numero','clave']);
                        $carId   = (string)$toScalar($s, ['carrera_id']);
                        if ($optLbl === '') $optLbl = $optId;
                  ?>
                    <option value="<?= $esc($optId) ?>"
                            data-carrera-id="<?= $esc($carId) ?>"
                            <?= $semId === $optId ? 'selected':'' ?>>
                      <?= $esc($optLbl) ?>
                    </option>
                  <?php endforeach; ?>
                <?php else: ?>
                  <?php for ($i=1; $i<=12; $i++): ?>
                    <option value="<?= $i ?>" <?= $semId===(string)$i ? 'selected':'' ?>><?= $i ?></option>
                  <?php endfor; ?>
                <?php endif; ?>
              </select>

              <!-- Hidden auto: carrera_id (para compatibilidad con el controlador actual) -->
              <input type="hidden" id="carrera_id" name="carrera_id" value="<?= $esc($carreraIdActual) ?>">
              <!-- (Opcional) Hidden legacy: semestre numérico si lo sigues usando -->
              <input type="hidden" id="semestre_legacy" name="semestre" value="<?= $esc($pf->semestre ?? '') ?>">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Tipo de ingreso</label>
              <?php $tipo = (string)($pf->tipo_ingreso ?? 'nuevo'); ?>
              <select name="tipo_ingreso" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="nuevo"         <?= $tipo==='nuevo'         ? 'selected':'' ?>>Nuevo</option>
                <option value="reingreso"     <?= $tipo==='reingreso'     ? 'selected':'' ?>>Reingreso</option>
                <option value="transferencia" <?= $tipo==='transferencia' ? 'selected':'' ?>>Transferencia</option>
              </select>
            </div>

            <div class="flex items-center gap-2">
              <input id="beca_activa" type="checkbox" name="beca_activa" value="1" <?= !empty($pf->beca_activa) ? 'checked':'' ?> class="h-4 w-4">
              <label for="beca_activa" class="text-sm font-medium">Beca activa</label>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Promedio general</label>
              <input type="number" step="0.01" min="0" max="100" name="promedio_general" value="<?= $esc($pf->promedio_general ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Créditos aprobados</label>
              <input type="number" min="0" name="creditos_aprobados" value="<?= $esc($pf->creditos_aprobados ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium mb-1">Dirección</label>
              <textarea name="direccion" rows="2" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800"><?= $esc($pf->direccion ?? '') ?></textarea>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Contacto de emergencia (nombre)</label>
              <input type="text" name="contacto_emergencia_nombre" value="<?= $esc($pf->contacto_emergencia_nombre ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Contacto de emergencia (teléfono)</label>
              <input type="tel" name="contacto_emergencia_telefono" value="<?= $esc($pf->contacto_emergencia_telefono ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium mb-1">Parentesco de emergencia</label>
              <input type="text" name="parentesco_emergencia" value="<?= $esc($pf->parentesco_emergencia ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
          </div>
        </div>

        <!-- Cambiar contraseña -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Cambiar Contraseña</h2>
          <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
            Deja estos campos en blanco si no deseas cambiar la contraseña
          </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="relative">
              <label class="block text-sm font-medium mb-1">Nueva contraseña</label>
              <input type="password" id="password" name="password" placeholder="••••••••"
                     class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 pr-10 focus:ring-2 focus:ring-primary-500">
              <button type="button" id="togglePassword"
                      class="absolute inset-y-0 right-0 flex items-center pr-3 text-neutral-500 dark:text-neutral-400" tabindex="-1">
                <i data-feather="eye"></i>
              </button>
            </div>

            <div class="relative">
              <label class="block text-sm font-medium mb-1">Confirmar contraseña</label>
              <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••"
                     class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 pr-10 focus:ring-2 focus:ring-primary-500">
              <button type="button" id="togglePasswordConfirm"
                      class="absolute inset-y-0 right-0 flex items-center pr-3 text-neutral-500 dark:text-neutral-400" tabindex="-1">
                <i data-feather="eye"></i>
              </button>
            </div>
          </div>
        </div>

        <div class="flex justify-end gap-4">
          <a href="/src/plataforma/app/admin/students" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">Cancelar</a>
          <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  feather.replace();

  // Toggle visibilidad password
  function toggleVisibility(inputId, buttonId) {
    const input = document.getElementById(inputId);
    const btn = document.getElementById(buttonId);
    const icon = btn.querySelector('i');
    btn.addEventListener('click', () => {
      const isHidden = input.type === 'password';
      input.type = isHidden ? 'text' : 'password';
      icon.setAttribute('data-feather', isHidden ? 'eye-off' : 'eye');
      feather.replace();
    });
  }
  toggleVisibility('password', 'togglePassword');
  toggleVisibility('password_confirmation', 'togglePasswordConfirm');

  // Vincular carrera_id oculto al semestre seleccionado
  (function(){
    const selSem = document.getElementById('semestre_id');
    const hidCar = document.getElementById('carrera_id');
    const hidSemLegacy = document.getElementById('semestre_legacy'); // por si sigues usando tinyint en algun lado

    function syncCarrera() {
      const opt = selSem.options[selSem.selectedIndex];
      if (!opt) return;
      const carreraId = opt.getAttribute('data-carrera-id') || '';
      hidCar.value = carreraId;
      // Si tuvieras el número de semestre como data-numero, aquí podrías setear hidSemLegacy.
    }

    selSem.addEventListener('change', syncCarrera);
    // init
    syncCarrera();
  })();

  // Validación simple de contraseña opcional
  const form = document.querySelector('form');
  form.addEventListener('submit', (e) => {
    const p1 = form.password.value.trim();
    const p2 = form.password_confirmation.value.trim();
    if (p1 || p2) {
      if (p1 !== p2) { e.preventDefault(); alert('Las contraseñas no coinciden'); }
      else if (p1.length < 6) { e.preventDefault(); alert('La contraseña debe tener al menos 6 caracteres'); }
    }
  });
</script>
