<!-- app/views/admin/teachers/create.php (SOLO contenido; el layout lo aplica View::render) -->

<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Nuevo Profesor</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Completa los datos requeridos</p>
      </div>

      <form action="/src/plataforma/app/admin/teachers/store" method="POST" class="space-y-6">
        <!-- Usuario -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Cuenta de Usuario</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Nombre completo</label>
              <input type="text" name="nombre" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Correo electrónico</label>
              <input type="email" name="email" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
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

        <!-- Perfil docente -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Perfil Docente</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Número de empleado</label>
              <input type="text" name="num_empleado" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">RFC (opcional)</label>
              <input type="text" name="rfc" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div class="md:col-span-2">
              <label class="block text-sm font-medium mb-1">Departamento</label>
              <select name="departamento" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona un departamento</option>
                <?php foreach (($departamentos ?? []) as $dep): ?>
                  <option value="<?= htmlspecialchars($dep->id) ?>"><?= htmlspecialchars($dep->nombre) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Grado académico</label>
              <select name="grado_academico" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona</option>
                <option value="licenciatura">Licenciatura</option>
                <option value="maestria">Maestría</option>
                <option value="doctorado">Doctorado</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Especialidad</label>
              <input type="text" name="especialidad" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Fecha de contratación</label>
              <input type="date" name="fecha_contratacion" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Tipo de contrato</label>
              <select name="tipo_contrato" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona</option>
                <option value="tiempo_completo">Tiempo completo</option>
                <option value="medio_tiempo">Medio tiempo</option>
                <option value="por_horas">Por horas</option>
                <option value="temporal">Temporal</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Nivel SNI</label>
              <select name="nivel_sni" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="sin_nivel" selected>Sin nivel</option>
                <option value="candidato">Candidato</option>
                <option value="nivel1">Nivel I</option>
                <option value="nivel2">Nivel II</option>
                <option value="nivel3">Nivel III</option>
              </select>
            </div>

            <div class="flex items-center gap-2">
              <input id="prodep" type="checkbox" name="perfil_prodep" value="1" class="h-4 w-4 rounded border-neutral-300 dark:border-neutral-600">
              <label for="prodep" class="text-sm">Perfil PRODEP</label>
            </div>
          </div>
        </div>

        <div class="flex justify-end gap-4">
          <a href="/src/plataforma/app/admin/teachers" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
            Cancelar
          </a>
          <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
            Guardar Profesor
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Validaciones mínimas de contraseñas
  (function(){
    const form = document.querySelector('form');
    form.addEventListener('submit', (e) => {
      const p  = form.password.value.trim();
      const pc = form.password_confirmation.value.trim();
      if (p.length < 6) { e.preventDefault(); alert('La contraseña debe tener al menos 6 caracteres'); return; }
      if (p !== pc) { e.preventDefault(); alert('Las contraseñas no coinciden'); return; }
    });
  })();
</script>
