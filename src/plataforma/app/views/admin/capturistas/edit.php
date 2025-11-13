<?php
// admin/capturistas/edit.php
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

if (session_status() === PHP_SESSION_NONE) session_start();

$flashError   = $_SESSION['error']   ?? '';
$flashSuccess = $_SESSION['success'] ?? '';
unset($_SESSION['error'], $_SESSION['success']);

$uid     = (int)($user->id ?? 0);
$nombre  = $user->nombre ?? '';
$ap      = $user->apellido_paterno ?? '';
$am      = $user->apellido_materno ?? '';
$email   = $user->email ?? '';
$tel     = $user->telefono ?? '';
$fnac    = $user->fecha_nacimiento ?? '';                 // YYYY-mm-dd
$uStatus = $user->status ?? 'active';                     // active|inactive|suspended

$numEmp  = $profile->numero_empleado ?? '';
$curp    = $profile->curp ?? '';
$fing    = $profile->fecha_ingreso ?? '';                 // YYYY-mm-dd
$pStatus = $profile->status ?? 'active';                  // active|inactive
?>
<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Editar Capturista</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Actualiza la información del capturista</p>
      </div>

      <?php if ($flashError): ?>
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-2 text-red-700">
          <?= $esc($flashError) ?>
        </div>
      <?php endif; ?>
      <?php if ($flashSuccess): ?>
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-2 text-emerald-700">
          <?= $esc($flashSuccess) ?>
        </div>
      <?php endif; ?>

      <form id="form-edit-capturista"
            action="/src/plataforma/app/admin/capturistas/update/<?= $esc($uid) ?>"
            method="POST"
            class="space-y-6"
            accept-charset="UTF-8"
            autocomplete="off">

        <!-- Información Personal -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información Personal</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Nombre(s)</label>
              <input type="text" name="nombre" required class="input-utsc" value="<?= $esc($nombre) ?>">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Apellido paterno</label>
              <input type="text" name="apellido_paterno" required class="input-utsc" value="<?= $esc($ap) ?>">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Apellido materno</label>
              <input type="text" name="apellido_materno" class="input-utsc" value="<?= $esc($am) ?>">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Correo electrónico</label>
              <input type="email" name="email" required class="input-utsc" value="<?= $esc($email) ?>">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Teléfono</label>
              <input type="tel" name="telefono" class="input-utsc" value="<?= $esc($tel) ?>">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Fecha de nacimiento</label>
              <input type="date" name="fecha_nacimiento" class="input-utsc" value="<?= $esc($fnac) ?>">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Estado (usuario)</label>
              <select name="status" class="input-utsc">
                <option value="active"   <?= $uStatus==='active'   ? 'selected' : '' ?>>Activo</option>
                <option value="inactive" <?= $uStatus==='inactive' ? 'selected' : '' ?>>Inactivo</option>
                <option value="suspended"<?= $uStatus==='suspended'? 'selected' : '' ?>>Suspendido</option>
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
              <input type="text" name="numero_empleado" class="input-utsc font-mono" value="<?= $esc($numEmp) ?>" maxlength="4" pattern="\d{4}">
              <small class="text-xs text-neutral-500">Debe ser único (4 dígitos). Si está ocupado, se ignora el cambio.</small>
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">CURP</label>
              <input type="text" name="curp" required maxlength="18"
                     class="input-utsc font-mono"
                     value="<?= $esc($curp) ?>"
                     pattern="[A-Za-z]{4}[0-9]{6}[A-Za-z]{6}[0-9A-Za-z]{2}">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Fecha de Ingreso</label>
              <input type="date" name="fecha_ingreso" required class="input-utsc" value="<?= $esc($fing) ?>">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Estado (perfil)</label>
              <select name="capturista_status" class="input-utsc">
                <option value="active"   <?= $pStatus==='active'   ? 'selected' : '' ?>>Activo</option>
                <option value="inactive" <?= $pStatus==='inactive' ? 'selected' : '' ?>>Inactivo</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Credenciales (opcional cambiar) -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Credenciales</h2>
          <p class="text-xs text-neutral-500">Deja en blanco para no cambiar la contraseña.</p>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Nueva contraseña</label>
              <input type="password" name="password" minlength="6" class="input-utsc">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Confirmar contraseña</label>
              <input type="password" name="password_confirmation" minlength="6" class="input-utsc">
            </div>
          </div>
        </div>

        <div class="flex justify-end gap-4">
          <a href="/src/plataforma/app/admin/capturistas"
             class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
            Cancelar
          </a>
          <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
            Guardar cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
  .input-utsc {
    width: 100%;
    padding: .5rem .75rem;
    border-radius: .5rem;
    border: 1px solid var(--twc-brd, #e5e7eb);
    background-color: var(--twc-bg, #fff);
    color: inherit;
    outline: none;
    transition: all .2s ease;
  }

  /* 🕶️ Modo oscuro */
  .dark .input-utsc {
    background-color: #1f2937; /* gris neutro oscuro */
    border-color: #374151;     /* borde gris medio */
    color: #f3f4f6;            /* texto claro */
  }

  .dark .input-utsc::placeholder {
    color: #9ca3af; /* placeholder gris claro */
  }

  /* ✨ Foco */
  .input-utsc:focus {
    border-color: var(--ut-accent-blue, #3b82f6);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .25);
  }

  .dark .input-utsc:focus {
    border-color: var(--ut-accent-blue, #3b82f6);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .4);
  }
</style>


<script>
  // Uppercase CURP en edición
  const curp = document.querySelector('input[name="curp"]');
  if (curp) curp.addEventListener('input', () => curp.value = curp.value.toUpperCase());

  // Confirmación de contraseña si se intenta cambiar
  const form = document.getElementById('form-edit-capturista');
  form.addEventListener('submit', (e) => {
    const p1 = form.querySelector('input[name="password"]').value.trim();
    const p2 = form.querySelector('input[name="password_confirmation"]').value.trim();
    if (p1 || p2) {
      if (p1.length < 6) { e.preventDefault(); alert('La contraseña debe tener al menos 6 caracteres.'); return; }
      if (p1 !== p2)     { e.preventDefault(); alert('Las contraseñas no coinciden.'); return; }
    }
  });
</script>
