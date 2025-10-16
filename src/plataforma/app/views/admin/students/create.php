<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Nuevo Estudiante</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Ingresa la información del nuevo estudiante</p>
      </div>

      <form action="/src/plataforma/app/admin/students/store" method="POST" class="space-y-6">
        <!-- Información Personal (tabla: users) -->
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
                <option value="suspended">Suspendido</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Información Académica (tabla: students_profile) -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información Académica</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Matrícula</label>
              <input type="text" name="matricula" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">CURP</label>
              <input type="text" name="curp" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Carrera</label>
              <select name="carrera_id" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona una carrera</option>
                <!-- Si tienes catálogo, itéralo aquí -->
                <option value="1">Ing. en Sistemas</option>
                <option value="2">Ing. Industrial</option>
                <option value="3">Ing. Mecatrónica</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Semestre</label>
              <select name="semestre" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona el semestre</option>
                <option value="1">1</option><option value="2">2</option>
                <option value="3">3</option><option value="4">4</option>
                <option value="5">5</option><option value="6">6</option>
                <option value="7">7</option><option value="8">8</option>
                <option value="9">9</option><option value="10">10</option>
                <option value="11">11</option><option value="12">12</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Grupo</label>
              <input type="text" name="grupo" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Tipo de ingreso</label>
              <select name="tipo_ingreso" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="nuevo" selected>Nuevo</option>
                <option value="reingreso">Reingreso</option>
                <option value="transferencia">Transferencia</option>
              </select>
            </div>
            <div class="flex items-center gap-2">
              <input id="beca_activa" type="checkbox" name="beca_activa" value="1" class="h-4 w-4">
              <label for="beca_activa" class="text-sm font-medium">Beca activa</label>
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Promedio general</label>
              <input type="number" step="0.01" min="0" max="100" name="promedio_general" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Créditos aprobados</label>
              <input type="number" min="0" name="creditos_aprobados" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium mb-1">Dirección</label>
              <textarea name="direccion" rows="2" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800"></textarea>
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Contacto de emergencia (nombre)</label>
              <input type="text" name="contacto_emergencia_nombre" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Contacto de emergencia (teléfono)</label>
              <input type="tel" name="contacto_emergencia_telefono" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium mb-1">Parentesco de emergencia</label>
              <input type="text" name="parentesco_emergencia" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
          </div>
        </div>

        <!-- Credenciales (users) -->
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
          <a href="/src/plataforma/app/admin/students" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
            Cancelar
          </a>
          <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
            Guardar Estudiante
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
