<div class="container px-6 py-8">
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">

    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Asignar Profesor a Materia-Grupo</h1>
      <a href="/src/plataforma/app/admin/mg-profesores/create"
         class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <i data-feather="plus-circle" class="w-4 h-4"></i> Nueva Asignación
      </a>
    </div>

    <form class="flex gap-3 mb-4" method="GET">
      <input name="q" value="<?= htmlspecialchars($q ?? '') ?>"
             placeholder="Buscar profesor / materia / grupo / código"
             class="flex-1 border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg px-3 py-2">
      <button class="bg-gray-200 dark:bg-neutral-700 dark:text-white px-3 py-2 rounded-lg">
        <i data-feather="search" class="w-4 h-4 inline"></i>
      </button>
    </form>

    <div class="overflow-x-auto">
      <table class="min-w-full text-sm border-collapse border border-gray-200 dark:border-neutral-700">
        <thead class="bg-gray-100 dark:bg-neutral-700 text-left">
          <tr>
            <th class="px-3 py-2 border-b">Código M-G</th>
            <th class="px-3 py-2 border-b">Materia</th>
            <th class="px-3 py-2 border-b">Grupo</th>
            <th class="px-3 py-2 border-b">Profesor</th>
            <th class="px-3 py-2 border-b">Fecha</th>
            <th class="px-3 py-2 border-b">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($rows)): foreach ($rows as $r): ?>
            <tr class="border-b border-gray-200 dark:border-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-700/40">
              <td class="px-3 py-2 font-mono"><?= htmlspecialchars($r->mg_codigo ?? '') ?></td>
              <td class="px-3 py-2">
                <div class="font-medium"><?= htmlspecialchars($r->materia_nombre ?? '') ?></div>
                <div class="text-xs opacity-70"><?= htmlspecialchars($r->materia_clave ?? '') ?></div>
              </td>
              <td class="px-3 py-2">
                <div class="font-medium"><?= htmlspecialchars($r->grupo_codigo ?? '') ?></div>
                <div class="text-xs opacity-70"><?= htmlspecialchars($r->grupo_titulo ?? '') ?></div>
              </td>
              <td class="px-3 py-2">
                <div class="font-medium"><?= htmlspecialchars($r->profesor_nombre ?? '') ?></div>
                <div class="text-xs opacity-70"><?= htmlspecialchars($r->profesor_email ?? '') ?></div>
              </td>
              <td class="px-3 py-2 text-xs opacity-80">
                <?= htmlspecialchars(date('d/m/Y H:i', strtotime($r->created_at ?? ''))) ?>
              </td>
              <td class="px-3 py-2">
                <div class="flex items-center gap-2">
                  <a href="/src/plataforma/app/admin/mg-profesores/edit/<?= (int)$r->id ?>"
                     class="bg-primary-500 hover:bg-primary-600 text-white px-3 py-1.5 rounded-lg text-sm flex items-center gap-1">
                    <i data-feather="edit-3" class="w-4 h-4"></i> Editar
                  </a>
                  <form action="/src/plataforma/app/admin/mg-profesores/delete/<?= (int)$r->id ?>" method="POST"
                        onsubmit="return confirm('¿Eliminar asignación?')">
                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm flex items-center gap-1">
                      <i data-feather="trash-2" class="w-4 h-4"></i> Eliminar
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; else: ?>
            <tr><td colspan="6" class="text-center py-6 opacity-70">Sin asignaciones.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script>document.addEventListener('DOMContentLoaded',()=>{ if(window.feather) feather.replace(); });</script>
