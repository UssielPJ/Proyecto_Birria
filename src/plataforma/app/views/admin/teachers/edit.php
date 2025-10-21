<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$teacher = $teacher ?? (object)[];
?>

<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Editar Profesor</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Actualiza la información del profesor</p>
      </div>

      <?php if (!empty($_SESSION['error'])): ?>
        <div class="mb-4 p-3 rounded bg-red-50 text-red-700">
          <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($_SESSION['success'])): ?>
        <div class="mb-4 p-3 rounded bg-green-50 text-green-700">
          <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
      <?php endif; ?>

      <form action="/src/plataforma/app/admin/teachers/update/<?= htmlspecialchars($teacher->id ?? '') ?>" method="POST" class="space-y-6" novalidate>
        
        <!-- Datos de Usuario -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Cuenta de Usuario</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Nombre</label>
              <input type="text" name="nombre" required value="<?= htmlspecialchars($teacher->nombre ?? '') ?>"
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Apellido Paterno</label>
              <input type="text" name="apellido_paterno" required value="<?= htmlspecialchars($teacher->apellido_paterno ?? '') ?>"
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Apellido Materno</label>
              <input type="text" name="apellido_materno" value="<?= htmlspecialchars($teacher->apellido_materno ?? '') ?>"
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Correo electrónico</label>
              <input type="email" name="email" required value="<?= htmlspecialchars($teacher->email ?? '') ?>"
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Teléfono</label>
              <input type="text" name="telefono" value="<?= htmlspecialchars($teacher->telefono ?? '') ?>"
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Fecha de nacimiento</label>
              <input type="date" name="fecha_nacimiento" value="<?= htmlspecialchars($teacher->fecha_nacimiento ?? '') ?>"
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
          </div>
        </div>

        <!-- Perfil Docente -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Perfil Docente</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Número de empleado</label>
              <input type="text" name="numero_empleado" readonly value="<?= htmlspecialchars($teacher->numero_empleado ?? '') ?>"
                class="w-full px-4 py-2 rounded-lg border border-neutral-300 dark:border-neutral-700 bg-gray-100 dark:bg-neutral-700 text-neutral-600 dark:text-neutral-400 cursor-not-allowed">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">RFC</label>
              <input type="text" name="rfc" maxlength="13" value="<?= htmlspecialchars($teacher->rfc ?? '') ?>"
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <!-- Estado del profesor -->
            <div>
                <label class="block text-sm font-medium mb-1">Estado actual</label>
                <select name="status" required
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="active" <?= ($teacher->status ?? '') === 'active' ? 'selected' : '' ?>>Activo</option>
                <option value="inactive" <?= ($teacher->status ?? '') === 'inactive' ? 'selected' : '' ?>>Inactivo</option>
                <option value="suspended" <?= ($teacher->status ?? '') === 'suspended' ? 'selected' : '' ?>>Suspendido</option>
                </select>
            </div>
            


            <div class="md:col-span-2">
              <label class="block text-sm font-medium mb-1">Departamento</label>
              <select name="departamento_id" required
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona un departamento</option>
                <?php foreach (($departamentos ?? []) as $dep): ?>
                  <option value="<?= htmlspecialchars($dep->id) ?>"
                    <?= ($teacher->departamento_id ?? '') == $dep->id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dep->nombre) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Grado académico</label>
              <select name="grado_academico" required
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona</option>
                <option value="licenciatura" <?= ($teacher->grado_academico ?? '') === 'licenciatura' ? 'selected' : '' ?>>Licenciatura</option>
                <option value="maestria" <?= ($teacher->grado_academico ?? '') === 'maestria' ? 'selected' : '' ?>>Maestría</option>
                <option value="doctorado" <?= ($teacher->grado_academico ?? '') === 'doctorado' ? 'selected' : '' ?>>Doctorado</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Especialidad</label>
              <input type="text" name="especialidad" value="<?= htmlspecialchars($teacher->especialidad ?? '') ?>"
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Fecha de contratación</label>
              <input type="date" name="fecha_contratacion" value="<?= htmlspecialchars($teacher->fecha_contratacion ?? '') ?>"
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Tipo de contrato</label>
              <select name="tipo_contrato"
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="">Selecciona</option>
                <option value="tiempo_completo" <?= ($teacher->tipo_contrato ?? '') === 'tiempo_completo' ? 'selected' : '' ?>>Tiempo completo</option>
                <option value="medio_tiempo" <?= ($teacher->tipo_contrato ?? '') === 'medio_tiempo' ? 'selected' : '' ?>>Medio tiempo</option>
                <option value="por_horas" <?= ($teacher->tipo_contrato ?? '') === 'por_horas' ? 'selected' : '' ?>>Por horas</option>
                <option value="asignatura" <?= ($teacher->tipo_contrato ?? '') === 'asignatura' ? 'selected' : '' ?>>Asignatura</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Nivel SNI</label>
              <select name="nivel_sni"
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="sin_nivel" <?= ($teacher->nivel_sni ?? '') === 'sin_nivel' ? 'selected' : '' ?>>Sin nivel</option>
                <option value="candidato" <?= ($teacher->nivel_sni ?? '') === 'candidato' ? 'selected' : '' ?>>Candidato</option>
                <option value="nivel1" <?= ($teacher->nivel_sni ?? '') === 'nivel1' ? 'selected' : '' ?>>Nivel I</option>
                <option value="nivel2" <?= ($teacher->nivel_sni ?? '') === 'nivel2' ? 'selected' : '' ?>>Nivel II</option>
                <option value="nivel3" <?= ($teacher->nivel_sni ?? '') === 'nivel3' ? 'selected' : '' ?>>Nivel III</option>
              </select>
            </div>

            <div class="flex items-center gap-2">
              <input id="prodep" type="checkbox" name="perfil_prodep" value="1"
                <?= !empty($teacher->perfil_prodep) ? 'checked' : '' ?>
                class="h-4 w-4 rounded border-neutral-300 dark:border-neutral-600">
              <label for="prodep" class="text-sm">Perfil PRODEP</label>
            </div>
          </div>
        </div>

        <!-- Contraseña -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Cambiar Contraseña (opcional)</h2>
          <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">
            Deja estos campos vacíos si no deseas modificar la contraseña.
          </p>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Nueva contraseña</label>
              <input type="password" name="password"
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Confirmar contraseña</label>
              <input type="password" name="password_confirmation"
                class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
            </div>
          </div>
        </div>

        <div class="flex justify-end gap-4">
          <a href="/src/plataforma/app/admin/teachers"
            class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
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
(function(){
  const form = document.querySelector('form');
  form.addEventListener('submit', (e) => {
    const p = form.password.value.trim();
    const pc = form.password_confirmation.value.trim();
    if (p || pc) {
      if (p.length < 6) { e.preventDefault(); alert('La contraseña debe tener al menos 6 caracteres'); return; }
      if (p !== pc) { e.preventDefault(); alert('Las contraseñas no coinciden'); return; }
    }
  });
})();
</script>
