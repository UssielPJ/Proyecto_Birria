<div class="container px-6 py-8">
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Nueva asignación de profesor</h1>
      <a href="/src/plataforma/app/admin/mg-profesores" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Volver</a>
    </div>

    <form action="/src/plataforma/app/admin/mg-profesores/store" method="POST" class="space-y-6">
      <div>
        <label class="block mb-2 text-sm font-medium">Materia-Grupo</label>
        <select name="mg_id" required
                class="w-full border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg px-3 py-2">
          <option value="">Seleccione…</option>
          <?php foreach($mgs as $x): ?>
            <option value="<?= $x->id ?>">
              <?= htmlspecialchars(($x->codigo).' — '.$x->materia_nombre.' ('.$x->materia_clave.')') ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label class="block mb-2 text-sm font-medium">Profesor</label>
        <select name="teacher_user_id" required
                class="w-full border-gray-300 dark:border-neutral-600 dark:bg-neutral-700 dark:text-white rounded-lg px-3 py-2">
          <option value="">Seleccione…</option>
          <?php foreach($teachers as $t): ?>
            <option value="<?= $t->user_id ?>"><?= htmlspecialchars($t->nombre) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="flex justify-end gap-3">
        <a href="/src/plataforma/app/admin/mg-profesores" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Cancelar</a>
        <button class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg">Guardar</button>
      </div>
    </form>
  </div>
</div>
<script>document.addEventListener('DOMContentLoaded',()=>{ if(window.feather) feather.replace(); });</script>
