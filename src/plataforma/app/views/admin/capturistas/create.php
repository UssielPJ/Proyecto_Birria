<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Nuevo Capturista</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Ingresa la información del nuevo capturista</p>
      </div>

      <form action="/src/plataforma/app/admin/capturistas/store" method="POST" class="space-y-6" enctype="multipart/form-data">
        <!-- Información Personal -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información Personal</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Nombre(s)</label>
              <input type="text" name="nombre" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Apellido paterno</label>
              <input type="text" name="apellido_paterno" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Apellido materno</label>
              <input type="text" name="apellido_materno" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Correo electrónico</label>
              <input type="email" name="email" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Teléfono</label>
              <input type="tel" name="telefono" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Fecha de nacimiento</label>
              <input type="date" name="fecha_nacimiento" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Estado</label>
              <select name="status" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="active" selected>Activo</option>
                <option value="inactive">Inactivo</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Información del Capturista -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información del Capturista</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Número de Empleado *</label>
              <input type="text" name="numero_empleado" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Ej: EMP001">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Teléfono</label>
              <input type="tel" name="telefono" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Ej: +52 55 1234 5678">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">CURP *</label>
              <input type="text" name="curp" required maxlength="18" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 font-mono" placeholder="Ej: ABCD123456HDFXXX01">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Fecha de Ingreso *</label>
              <input type="date" name="fecha_ingreso" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Estado</label>
              <select name="capturista_status" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
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
              <label class="block text-sm font-medium mb-1">Contraseña</label>
              <input type="password" name="password" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Confirmar contraseña</label>
              <input type="password" name="password_confirmation" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
          </div>
        </div>

        <div class="flex justify-end gap-4">
          <a href="/src/plataforma/app/admin/capturistas" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
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

<script>
  // Validación simple de contraseña
  const form = document.querySelector('form');
  form.addEventListener('submit', function(e) {
    const p1 = form.querySelector('input[name="password"]').value;
    const p2 = form.querySelector('input[name="password_confirmation"]').value;
    if (p1 !== p2) { e.preventDefault(); alert('Las contraseñas no coinciden'); }
  });
</script>