

<div class="container mx-auto px-6 py-10">
  <div class="max-w-3xl mx-auto bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-8">

    <div class="mb-8 text-center">
      <h1 class="text-3xl font-bold text-neutral-800 dark:text-neutral-100">
        Crear nuevo anuncio
      </h1>
      <p class="text-neutral-500 dark:text-neutral-400 mt-2">
        Escribe un mensaje para tus estudiantes.
      </p>
    </div>

    <form action="/src/plataforma/app/teacher/announcements/store" method="POST" class="space-y-6">
      
      <!-- Título -->
      <div>
        <label for="title" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
          Título del anuncio
        </label>
        <input type="text" name="title" id="title" required
               placeholder="Ej. Examen parcial el próximo lunes"
               class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg
                      bg-neutral-50 dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100
                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
      </div>

      <!-- Contenido -->
      <div>
        <label for="content" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
          Contenido
        </label>
        <textarea name="content" id="content" rows="6" required
                  placeholder="Escribe aquí los detalles del anuncio..."
                  class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg
                         bg-neutral-50 dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100
                         focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200"></textarea>
      </div>

      <!-- Opcional: grupo o materia -->
      <div>
        <label for="materia_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
          Materia (opcional)
        </label>
        <select name="materia_id" id="materia_id"
                class="w-full px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg
                       bg-neutral-50 dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
          <option value="">Seleccionar...</option>
          <?php if (!empty($materias)): ?>
            <?php foreach ($materias as $m): ?>
              <option value="<?= htmlspecialchars($m->id) ?>">
                <?= htmlspecialchars($m->nombre) ?>
              </option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>

      <!-- Botones -->
      <div class="flex justify-between pt-4">
        <a href="/src/plataforma/app/teacher/announcements"
           class="inline-flex items-center px-5 py-2.5 rounded-lg font-medium bg-neutral-200 dark:bg-neutral-700
                  text-neutral-700 dark:text-neutral-200 hover:bg-neutral-300 dark:hover:bg-neutral-600
                  transition-all duration-200">
          <i data-feather="arrow-left" class="w-5 h-5 mr-2"></i>
          Cancelar
        </a>

        <button type="submit"
                class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white
                       font-medium rounded-lg shadow-sm transition-all duration-200">
          <i data-feather="send" class="w-5 h-5 mr-2"></i>
          Publicar anuncio
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) feather.replace();
  });
</script>
