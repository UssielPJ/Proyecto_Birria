<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Nuevo Estudiante</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Ingresa la información del nuevo estudiante</p>
      </div>

      <form action="/src/plataforma/app/admin/students/store" method="POST" class="space-y-6">
        <!-- Información Personal (users) -->
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

        <!-- Información Académica (student_profiles) -->
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

            <!-- Semestre por catálogo (solo semestre_id); carrera_id se infiere -->
            <div class="md:col-span-2">
              <label class="block text-sm font-medium mb-1">Semestre</label>
              <select id="semestre_id" name="semestre_id" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona semestre</option>
                <?php foreach (($semestres ?? []) as $sem): 
                  // Del catálogo: id, carrera_id, numero, clave, label
                  $optId  = (int)($sem->id ?? 0);
                  $carId  = (int)($sem->carrera_id ?? 0);
                  $numero = (int)($sem->numero ?? 0);
                  $label  = $sem->label ?? ('Sem ' . ($sem->numero ?? '') . ' · ' . ($sem->clave ?? ''));
                ?>
                  <option value="<?= $optId ?>" data-carrera-id="<?= $carId ?>" data-num="<?= $numero ?>">
                    <?= htmlspecialchars($label) ?>
                  </option>
                <?php endforeach; ?>
              </select>

              <!-- Hidden auto para el controlador actual -->
              <input type="hidden" id="carrera_id" name="carrera_id" value="">
              <!-- (Opcional) Legacy: si el backend aún acepta tinyint semestre -->
              <input type="hidden" id="semestre_legacy" name="semestre" value="">
              <!-- (Opcional) Legacy grupo: ya no se usa, lo dejamos vacío -->
              <input type="hidden" id="grupo_legacy" name="grupo" value="">
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
  (function(){
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
      const p1 = form.querySelector('input[name="password"]').value;
      const p2 = form.querySelector('input[name="password_confirmation"]').value;
      if (p1 !== p2) { e.preventDefault(); alert('Las contraseñas no coinciden'); }
    });
  })();

  // Al seleccionar semestre_id: setear carrera_id (hidden) y semestre (legacy) si aplica
  (function () {
    const semSel   = document.getElementById('semestre_id');
    const hidCarr  = document.getElementById('carrera_id');
    const semLeg   = document.getElementById('semestre_legacy');

    function syncFromSemestre() {
      const opt = semSel.options[semSel.selectedIndex];
      if (!opt) return;
      hidCarr.value = opt.getAttribute('data-carrera-id') || '';
      const num = opt.getAttribute('data-num');
      semLeg.value = num ? parseInt(num, 10) : '';
    }

    if (semSel) {
      semSel.addEventListener('change', syncFromSemestre);
      // init
      syncFromSemestre();
    }
  })();
</script>
