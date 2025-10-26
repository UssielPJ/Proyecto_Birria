<div class="container px-6 py-8">
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
    
    <!-- ENCABEZADO -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Materias asignadas a grupos</h1>
      <a href="/src/plataforma/app/admin/materias-grupos/create" 
         class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <i data-feather="plus-circle" class="w-4 h-4"></i>
        Nueva Asignación
      </a>
    </div>

    <!-- FILTROS -->
    <form method="GET" class="grid md:grid-cols-4 gap-3 mb-6">
      <input type="text" name="materia" value="<?= htmlspecialchars($qMateria ?? '') ?>" 
             placeholder="Buscar por materia..." 
             class="border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg px-3 py-2"/>
      <input type="text" name="grupo" value="<?= htmlspecialchars($qGrupo ?? '') ?>" 
             placeholder="Buscar por grupo..." 
             class="border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg px-3 py-2"/>
      <input type="text" name="codigo" value="<?= htmlspecialchars($qCodigo ?? '') ?>" 
             placeholder="Buscar por código..." 
             class="border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg px-3 py-2"/>
      <button class="bg-gray-200 dark:bg-neutral-700 dark:text-white hover:bg-gray-300 dark:hover:bg-neutral-600 px-3 py-2 rounded-lg">
        <i data-feather="search" class="inline-block w-4 h-4 mr-1"></i> Filtrar
      </button>
    </form>

    <!-- TABLA -->
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm border-collapse border border-gray-200 dark:border-neutral-700">
        <thead class="bg-gray-100 dark:bg-neutral-700 text-left">
          <tr>
            <th class="px-3 py-2 border-b border-gray-200 dark:border-neutral-700">Código</th>
            <th class="px-3 py-2 border-b border-gray-200 dark:border-neutral-700">Grupo</th>
            <th class="px-3 py-2 border-b border-gray-200 dark:border-neutral-700">Carrera / Semestre</th>
            <th class="px-3 py-2 border-b border-gray-200 dark:border-neutral-700">Materia</th>
            <th class="px-3 py-2 border-b border-gray-200 dark:border-neutral-700">Fecha Asignación</th>
            <th class="px-3 py-2 border-b border-gray-200 dark:border-neutral-700">Acciones</th>
          </tr>
        </thead>

        <tbody>
          <?php if (!empty($rows)): ?>
            <?php foreach ($rows as $r): ?>
              <tr class="border-b border-gray-200 dark:border-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-700/40">
                <td class="px-3 py-2 font-mono"><?= htmlspecialchars($r->codigo ?? '—') ?></td>

                <td class="px-3 py-2">
                  <div class="font-medium"><?= htmlspecialchars($r->grupo_codigo ?? '—') ?></div>
                  <?php if (!empty($r->grupo_titulo)): ?>
                    <div class="text-xs opacity-70"><?= htmlspecialchars($r->grupo_titulo) ?></div>
                  <?php endif; ?>
                </td>

                <td class="px-3 py-2">
                  <div><?= htmlspecialchars($r->carrera_nombre ?? '—') ?></div>
                  <div class="text-xs opacity-70">Semestre <?= htmlspecialchars($r->semestre_numero ?? '-') ?></div>
                </td>

                <td class="px-3 py-2">
                  <div class="font-medium"><?= htmlspecialchars($r->materia_nombre ?? '—') ?></div>
                  <div class="text-xs opacity-70"><?= htmlspecialchars($r->materia_clave ?? '') ?></div>
                </td>

                <td class="px-3 py-2 text-xs opacity-80">
                  <?= htmlspecialchars(date('d/m/Y H:i', strtotime($r->created_at ?? ''))) ?>
                </td>

                <td class="px-3 py-2">
                  <form action="/src/plataforma/app/admin/materias-grupos/delete/<?= (int)$r->id ?>" 
                        method="POST" 
                        onsubmit="return confirm('¿Eliminar esta asignación?')">
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm flex items-center gap-1">
                      <i data-feather="trash-2" class="w-4 h-4"></i> Eliminar
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center py-6 text-gray-500 dark:text-gray-300">
                No se encontraron asignaciones.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) feather.replace();
  });
</script>
