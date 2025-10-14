

<main class="p-6">
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
    <div>
      <h1 class="text-2xl font-bold mb-2">Mis Materias</h1>
      <p class="text-neutral-500 dark:text-neutral-400">Materias asignadas a ti como docente.</p>
    </div>
  </div>

  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
        <thead class="bg-neutral-50 dark:bg-neutral-800">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Materia</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Clave</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Créditos</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Horas/sem</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Semestre</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Tipo</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Área</th>
            <th class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
          <?php if (!empty($subjects)): ?>
            <?php foreach ($subjects as $m): ?>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-neutral-900 dark:text-neutral-100">
                  <?= htmlspecialchars($m->nombre ?? $m->name ?? '') ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                  <?= htmlspecialchars($m->clave ?? $m->code ?? '') ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                  <?= htmlspecialchars($m->creditos ?? 0) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                  <?= htmlspecialchars($m->horas_semana ?? 0) ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                  <?= htmlspecialchars($m->semestre_sugerido ?? 1) ?>° Semestre
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                  <?= htmlspecialchars($m->tipo ?? '') ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                  <?= htmlspecialchars($m->area_conocimiento ?? '') ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div class="flex justify-end gap-3">
                    <a href="/src/plataforma/app/teacher/grades?subject=<?= urlencode($m->id) ?>"
                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                      Calificaciones
                    </a>
                    <a href="/src/plataforma/app/teacher/students?subject=<?= urlencode($m->id) ?>"
                       class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                      Estudiantes
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="px-6 py-6 text-center text-neutral-500 dark:text-neutral-400">
                No tienes materias asignadas.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<script>
  if (window.feather) feather.replace();
</script>
