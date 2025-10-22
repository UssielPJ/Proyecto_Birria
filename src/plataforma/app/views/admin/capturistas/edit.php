<?php
// Helpers para escapar y castear null→''
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

// Shorthands (pueden venir null si el controlador aún no los pasa)
$capturista = $capturista ?? (object)[];
$profile = $profile ?? (object)[];
?>
<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Editar Capturista</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Modifica la información del capturista</p>
      </div>

      <form action="/admin/capturistas/update/<?= $esc($capturista->id ?? '') ?>" method="POST" class="space-y-6">

        <!-- Información Personal -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información Personal</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Nombre(s)</label>
              <input type="text" name="nombre" required value="<?= $esc($capturista->nombre ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Apellido paterno</label>
              <input type="text" name="apellido_paterno" value="<?= $esc($capturista->apellido_paterno ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Apellido materno</label>
              <input type="text" name="apellido_materno" value="<?= $esc($capturista->apellido_materno ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Correo electrónico</label>
              <input type="email" name="email" required value="<?= $esc($capturista->email ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Teléfono</label>
              <input type="tel" name="telefono" value="<?= $esc($capturista->telefono ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Fecha de nacimiento</label>
              <input type="date" name="fecha_nacimiento" value="<?= $esc($capturista->fecha_nacimiento ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Estado</label>
              <?php $status = (string)($capturista->status ?? 'active'); ?>
              <select name="status" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="active"   <?= $status==='active'   ? 'selected':'' ?>>Activo</option>
                <option value="inactive" <?= $status==='inactive' ? 'selected':'' ?>>Inactivo</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Información del Capturista -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información del Capturista</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Número de Empleado</label>
              <input type="text" name="numero_empleado" value="<?= $esc($profile->numero_empleado ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Ej: EMP001">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">RFC</label>
              <input type="text" name="rfc" value="<?= $esc($profile->rfc ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Ej: ABCD123456XYZ">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Especialidad</label>
              <input type="text" name="especialidad" value="<?= $esc($profile->especialidad ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Ej: Captura de Datos">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Grado Académico</label>
              <?php $grado = (string)($profile->grado_academico ?? ''); ?>
              <select name="grado_academico" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona un grado</option>
                <option value="bachillerato" <?= $grado==='bachillerato' ? 'selected':'' ?>>Bachillerato</option>
                <option value="licenciatura" <?= $grado==='licenciatura' ? 'selected':'' ?>>Licenciatura</option>
                <option value="maestria" <?= $grado==='maestria' ? 'selected':'' ?>>Maestría</option>
                <option value="doctorado" <?= $grado==='doctorado' ? 'selected':'' ?>>Doctorado</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Fecha de Contratación</label>
              <input type="date" name="fecha_contratacion" value="<?= $esc($profile->fecha_contratacion ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Tipo de Contrato</label>
              <?php $contrato = (string)($profile->tipo_contrato ?? ''); ?>
              <select name="tipo_contrato" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona un tipo</option>
                <option value="tiempo_completo" <?= $contrato==='tiempo_completo' ? 'selected':'' ?>>Tiempo Completo</option>
                <option value="medio_tiempo" <?= $contrato==='medio_tiempo' ? 'selected':'' ?>>Medio Tiempo</option>
                <option value="temporal" <?= $contrato==='temporal' ? 'selected':'' ?>>Temporal</option>
                <option value="honorarios" <?= $contrato==='honorarios' ? 'selected':'' ?>>Honorarios</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Nivel SNI</label>
              <?php $sni = (string)($profile->nivel_sni ?? 'sin_nivel'); ?>
              <select name="nivel_sni" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="sin_nivel" <?= $sni==='sin_nivel' ? 'selected':'' ?>>Sin Nivel</option>
                <option value="candidato" <?= $sni==='candidato' ? 'selected':'' ?>>Candidato</option>
                <option value="nivel_1" <?= $sni==='nivel_1' ? 'selected':'' ?>>Nivel 1</option>
                <option value="nivel_2" <?= $sni==='nivel_2' ? 'selected':'' ?>>Nivel 2</option>
                <option value="nivel_3" <?= $sni==='nivel_3' ? 'selected':'' ?>>Nivel 3</option>
                <option value="emerito" <?= $sni==='emerito' ? 'selected':'' ?>>Emérito</option>
              </select>
            </div>

            <div class="flex items-center gap-2">
              <input id="perfil_prodep" type="checkbox" name="perfil_prodep" value="1" <?= !empty($profile->perfil_prodep) ? 'checked':'' ?> class="h-4 w-4">
              <label for="perfil_prodep" class="text-sm font-medium">Perfil PRODEP</label>
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
          <a href="/admin/capturistas" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
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