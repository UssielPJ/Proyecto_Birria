<?php
// Helpers para escapar y castear null→''
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

// Shorthands (pueden venir null si el controlador aún no los pasa)
$user = $user ?? (object)[];
?>
<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Editar Usuario</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Modifica la información del usuario</p>
      </div>

      <form action="/admin/users/update/<?= $esc($user->id ?? '') ?>" method="POST" class="space-y-6">

        <!-- Información Personal -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información Personal</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Nombre(s)</label>
              <input type="text" name="nombre" required value="<?= $esc($user->nombre ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Apellido paterno</label>
              <input type="text" name="apellido_paterno" value="<?= $esc($user->apellido_paterno ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Apellido materno</label>
              <input type="text" name="apellido_materno" value="<?= $esc($user->apellido_materno ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Correo electrónico</label>
              <input type="email" name="email" required value="<?= $esc($user->email ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Teléfono</label>
              <input type="tel" name="telefono" value="<?= $esc($user->telefono ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Fecha de nacimiento</label>
              <input type="date" name="fecha_nacimiento" value="<?= $esc($user->fecha_nacimiento ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Estado</label>
              <?php $status = (string)($user->status ?? 'active'); ?>
              <select name="status" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="active"   <?= $status==='active'   ? 'selected':'' ?>>Activo</option>
                <option value="inactive" <?= $status==='inactive' ? 'selected':'' ?>>Inactivo</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Rol del Usuario -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Rol del Usuario</h2>
          <div>
            <label class="block text-sm font-medium mb-1">Seleccionar Rol</label>
            <?php
            $roles = $user->roles ?? [];
            $currentRole = '';
            if (in_array('admin', $roles)) $currentRole = 'admin';
            elseif (in_array('teacher', $roles)) $currentRole = 'teacher';
            elseif (in_array('student', $roles)) $currentRole = 'student';
            ?>
            <select name="role" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
              <option value="">Selecciona un rol</option>
              <option value="admin" <?= $currentRole === 'admin' ? 'selected' : '' ?>>Administrador</option>
              <option value="teacher" <?= $currentRole === 'teacher' ? 'selected' : '' ?>>Profesor</option>
              <option value="student" <?= $currentRole === 'student' ? 'selected' : '' ?>>Estudiante</option>
            </select>
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
          <a href="/admin/users" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
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