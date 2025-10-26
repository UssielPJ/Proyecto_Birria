<div class="container px-6 py-8">
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Asignar Materia a Grupo</h1>
      <a href="/src/plataforma/app/admin/subjects" 
         class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
         Volver
      </a>
    </div>

    <form action="/src/plataforma/app/admin/subjects/assign_store" method="POST" class="space-y-6">
      <!-- Seleccionar materia -->
      <div>
        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Materia</label>
        <select name="subject_id" required 
                class="w-full border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg">
          <option value="">Seleccione una materia...</option>
          <?php foreach ($materias as $m): ?>
            <option value="<?= $m->id ?>"><?= htmlspecialchars($m->nombre) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Seleccionar carrera -->
      <div>
        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Carrera</label>
        <select name="carrera_id" id="carreraSelect" required 
                class="w-full border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg">
          <option value="">Seleccione una carrera...</option>
          <?php foreach ($carreras as $c): ?>
            <option value="<?= $c->id ?>"><?= htmlspecialchars($c->nombre) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Seleccionar grupo -->
      <div>
        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Grupo</label>
        <select name="grupo_id" required 
                class="w-full border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg">
          <option value="">Seleccione un grupo...</option>
          <?php foreach ($grupos as $g): ?>
            <option value="<?= $g->id ?>">
              <?= htmlspecialchars($g->codigo . " - " . $g->nombre) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Semestre -->
      <div>
        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Semestre</label>
        <input type="number" name="semestre" min="1" max="12" required
               class="w-full border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg px-3 py-2" />
      </div>

      <div class="flex justify-end gap-4">
        <a href="/src/plataforma/app/admin/subjects" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Cancelar</a>
        <button type="submit" 
                class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg">Guardar Asignación</button>
      </div>
    </form>
  </div>
</div>
