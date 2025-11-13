<?php
// admin/capturistas/create.php
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Nuevo Capturista</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Ingresa la información del nuevo capturista</p>
      </div>

      <form id="form-capturista"
            action="/src/plataforma/app/admin/capturistas/store"
            method="POST"
            class="space-y-6"
            accept-charset="UTF-8"
            autocomplete="off"
            novalidate>
        <?php /* <input type="hidden" name="_token" value="<?= $esc($_SESSION['csrf'] ?? '') ?>"> */ ?>

        <!-- Información Personal (tabla: users) -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información Personal</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="nombre" class="block text-sm font-medium mb-1">Nombre(s)</label>
              <input id="nombre" type="text" name="nombre" required class="input-utsc">
            </div>
            <div>
              <label for="apellido_paterno" class="block text-sm font-medium mb-1">Apellido paterno</label>
              <input id="apellido_paterno" type="text" name="apellido_paterno" required class="input-utsc">
            </div>
            <div>
              <label for="apellido_materno" class="block text-sm font-medium mb-1">Apellido materno</label>
              <input id="apellido_materno" type="text" name="apellido_materno" required class="input-utsc">
            </div>
            <div>
              <label for="email" class="block text-sm font-medium mb-1">Correo electrónico</label>
              <input id="email" type="email" name="email" required class="input-utsc">
            </div>
            <div>
              <label for="telefono" class="block text-sm font-medium mb-1">Teléfono</label>
              <input id="telefono" type="tel" name="telefono" placeholder="Ej: +52 55 1234 5678" class="input-utsc">
            </div>
            <div>
              <label for="fecha_nacimiento" class="block text-sm font-medium mb-1">Fecha de nacimiento</label>
              <input id="fecha_nacimiento" type="date" name="fecha_nacimiento" class="input-utsc">
            </div>
            <div>
              <label for="status" class="block text-sm font-medium mb-1">Estado (usuario)</label>
              <select id="status" name="status" class="input-utsc">
                <option value="active" selected>Activo</option>
                <option value="inactive">Inactivo</option>
                <option value="suspended">Suspendido</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Información del Capturista (tabla: capturista_profiles) -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información del Capturista</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="numero_empleado" class="block text-sm font-medium mb-1">Número de Empleado</label>
              <input id="numero_empleado" type="text" name="numero_empleado"
                     class="input-utsc font-mono"
                     readonly pattern="\d{4}" maxlength="4" placeholder="Generando...">
              <small class="text-xs text-neutral-500">Se genera automático; el backend valida unicidad.</small>
            </div>
            <div>
              <label for="curp" class="block text-sm font-medium mb-1">CURP *</label>
              <input id="curp" type="text" name="curp" required maxlength="18"
                     pattern="[A-Za-z]{4}[0-9]{6}[A-Za-z]{6}[0-9A-Za-z]{2}"
                     class="input-utsc font-mono"
                     placeholder="Ej: ABCD123456HDFXXX01">
            </div>
            <div>
              <label for="fecha_ingreso" class="block text-sm font-medium mb-1">Fecha de Ingreso *</label>
              <input id="fecha_ingreso" type="date" name="fecha_ingreso" required class="input-utsc">
            </div>
            <div>
              <label for="capturista_status" class="block text-sm font-medium mb-1">Estado (perfil)</label>
              <select id="capturista_status" name="capturista_status" class="input-utsc">
                <option value="activo" selected>Activo</option>
                <option value="inactivo">Inactivo</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Credenciales de Acceso -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Credenciales de Acceso</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="password" class="block text-sm font-medium mb-1">Contraseña</label>
              <input id="password" type="password" name="password" required minlength="6" class="input-utsc">
            </div>
            <div>
              <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirmar contraseña</label>
              <input id="password_confirmation" type="password" name="password_confirmation" required minlength="6" class="input-utsc">
            </div>
          </div>
        </div>

        <div class="flex justify-end gap-4">
          <a href="/src/plataforma/app/admin/capturistas"
             class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
            Cancelar
          </a>
          <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
            Guardar Capturista
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
  .dark .input-utsc {
    background-color: #1f2937;
    border-color: #374151;
    color: #f3f4f6;
  }
  .dark .input-utsc::placeholder { color: #9ca3af; }
  .input-utsc:focus {
    border-color: var(--ut-accent-blue, #3b82f6);
    box-shadow: 0 0 0 3px rgba(59,130,246,.25);
  }
  .dark .input-utsc:focus {
    border-color: var(--ut-accent-blue, #3b82f6);
    box-shadow: 0 0 0 3px rgba(59,130,246,.4);
  }
</style>

<script>
  // CURP en mayúsculas
  (function () {
    const curp = document.getElementById('curp');
    if (curp) curp.addEventListener('input', () => curp.value = curp.value.toUpperCase());

    // Generar número de empleado (silencioso)
    const numeroInp = document.getElementById('numero_empleado');
    fetch('/src/plataforma/app/admin/capturistas/next-numero', { cache: 'no-store' })
      .then(r => r.ok ? r.json() : null)
      .then(data => { if (data && data.numero) numeroInp.value = String(data.numero); })
      .catch(() => { /* sin logs ni alerts */ });
  })();
</script>
