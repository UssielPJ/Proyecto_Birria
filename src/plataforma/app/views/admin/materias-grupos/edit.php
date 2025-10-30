<div class="container px-6 py-8">
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">

    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Editar asignación</h1>
      <a href="/src/plataforma/app/admin/materias-grupos" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Volver</a>
    </div>

    <form action="/src/plataforma/app/admin/materias-grupos/update/<?= (int)$row->id ?>" method="POST" class="space-y-6">

      <!-- Materia -->
      <div>
        <label class="block mb-2 text-sm font-medium">Materia</label>
        <select name="materia_id" id="materiaSelect" required
                class="w-full border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg px-3 py-2">
          <?php foreach ($materias as $m): ?>
            <option value="<?= $m->id ?>"
                    data-clave="<?= htmlspecialchars($m->clave) ?>"
                    <?= (int)$m->id === (int)$row->materia_id ? 'selected' : '' ?>>
              <?= htmlspecialchars($m->clave.' — '.$m->nombre) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Grupo -->
      <div>
        <label class="block mb-2 text-sm font-medium">Grupo</label>
        <select name="grupo_id" id="grupoSelect" required
                class="w-full border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg px-3 py-2">
          <?php foreach ($grupos as $g): ?>
            <option value="<?= $g->id ?>"
                    data-gcodigo="<?= htmlspecialchars($g->codigo) ?>"
                    <?= (int)$g->id === (int)$row->grupo_id ? 'selected' : '' ?>>
              <?= htmlspecialchars($g->codigo.($g->titulo ? ' — '.$g->titulo : '')) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Código (editable por si quieres forzarlo) -->
      <div>
        <label class="block mb-2 text-sm font-medium">Código</label>
        <input name="codigo" id="codigoInput" type="text"
               value="<?= htmlspecialchars($row->codigo ?? '') ?>"
               class="w-full border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg px-3 py-2">
        <p class="text-xs opacity-70 mt-1">Se sugiere formato <code>CLAVE-GRUPO</code> (ej. POO-IDGS-01-01).</p>
      </div>

      <div class="flex justify-end gap-4">
        <a href="/src/plataforma/app/admin/materias-grupos" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Cancelar</a>
        <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg">Guardar cambios</button>
      </div>
    </form>
  </div>
</div>

<script>
  const matSel = document.getElementById('materiaSelect');
  const grpSel = document.getElementById('grupoSelect');
  const codeIn = document.getElementById('codigoInput');

  function suggestCodigo() {
    const m = matSel.options[matSel.selectedIndex]?.dataset?.clave || '';
    const g = grpSel.options[grpSel.selectedIndex]?.dataset?.gcodigo || '';
    if (m && g) codeIn.value = `${m}-${g}`;
  }

  // Si el usuario cambia materia o grupo, proponemos nuevo código
  matSel.addEventListener('change', suggestCodigo);
  grpSel.addEventListener('change', suggestCodigo);

  if (window.feather) feather.replace();
</script>
