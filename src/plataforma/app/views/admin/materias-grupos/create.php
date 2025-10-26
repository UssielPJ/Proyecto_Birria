<div class="container px-6 py-8">
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">

    <!-- ENCABEZADO -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Asignar Materia a Grupo</h1>
      <a href="/src/plataforma/app/admin/materias-grupos" 
         class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Volver</a>
    </div>

    <!-- FORMULARIO -->
    <form action="/src/plataforma/app/admin/materias-grupos/store" method="POST" class="space-y-6">

      <!-- Materia -->
      <div>
        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Materia</label>
        <select name="materia_id" id="materiaSelect" required 
                class="w-full border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg px-3 py-2">
          <option value="">Seleccione una materia...</option>
          <?php foreach ($materias as $m): ?>
            <option value="<?= $m->id ?>" data-clave="<?= htmlspecialchars($m->clave) ?>">
              <?= htmlspecialchars($m->clave . ' — ' . $m->nombre) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Grupo -->
      <div>
        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Grupo</label>
        <select name="grupo_id" id="grupoSelect" required 
                class="w-full border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg px-3 py-2">
          <option value="">Seleccione un grupo...</option>
          <?php foreach ($grupos as $g): ?>
            <option value="<?= $g->id ?>" data-gcodigo="<?= htmlspecialchars($g->codigo) ?>">
              <?= htmlspecialchars($g->codigo . ($g->titulo ? ' — ' . $g->titulo : '')) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Código generado -->
      <div>
        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-200">Código generado</label>
        <input id="codigoPreview" type="text" 
               class="w-full border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg px-3 py-2" 
               readonly 
               placeholder="Se generará automáticamente (ej. POO-IDGS-01-01)">
      </div>

      <!-- BOTONES -->
      <div class="flex justify-end gap-4">
        <a href="/src/plataforma/app/admin/materias-grupos" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Cancelar</a>
        <button type="submit" 
                class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg">
          Guardar Asignación
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const matSel = document.getElementById('materiaSelect');
    const grpSel = document.getElementById('grupoSelect');
    const out = document.getElementById('codigoPreview');

    function updateCodigo() {
      const m = matSel.options[matSel.selectedIndex]?.dataset?.clave || '';
      const g = grpSel.options[grpSel.selectedIndex]?.dataset?.gcodigo || '';
      out.value = (m && g) ? `${m}-${g}` : '';
    }

    matSel.addEventListener('change', updateCodigo);
    grpSel.addEventListener('change', updateCodigo);

    if (window.feather) feather.replace();
  });
</script>
