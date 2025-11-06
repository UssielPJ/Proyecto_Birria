<?php
$esc = fn($v)=>htmlspecialchars((string)($v??''), ENT_QUOTES,'UTF-8');
$get = function($row,$k){ return is_object($row)?($row->$k ?? null):(is_array($row)?($row[$k]??null):null); };
$s = $subject ?? null;
?>
<main class="p-6">
  <div class="mb-6">
    <a href="/src/plataforma/app/admin/subjects" class="text-sm text-neutral-600 dark:text-neutral-300 hover:underline">&larr; Volver</a>
  </div>

  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow p-6 space-y-4">
    <h1 class="text-2xl font-bold">Materia: <?= $esc($get($s,'nombre')) ?></h1>
    <div class="grid sm:grid-cols-2 gap-4">
      <div>
        <p class="text-sm text-neutral-500 dark:text-neutral-400">Clave</p>
        <p class="font-medium"><?= $esc($get($s,'clave')) ?></p>
      </div>
      <div>
        <p class="text-sm text-neutral-500 dark:text-neutral-400">Estado</p>
        <p class="font-medium"><?= $esc($get($s,'status') ?? 'activa') ?></p>
      </div>
      <div>
        <p class="text-sm text-neutral-500 dark:text-neutral-400">Creada</p>
        <p class="font-medium"><?= $esc($get($s,'created_at')) ?></p>
      </div>
      <div>
        <p class="text-sm text-neutral-500 dark:text-neutral-400">Actualizada</p>
        <p class="font-medium"><?= $esc($get($s,'updated_at')) ?></p>
      </div>
    </div>

    <div class="flex gap-3 pt-2">
      <a href="/src/plataforma/app/admin/subjects/edit/<?= (int)($get($s,'id') ?? 0) ?>"
         class="px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-700">Editar</a>
      <button type="button" onclick="confirmDelete(<?= (int)($get($s,'id') ?? 0) ?>)"
              class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">Eliminar</button>
    </div>
  </div>
</main>

<script>
  function confirmDelete(id){
    if (!id) return;
    if (confirm('¿Eliminar materia #' + id + '?')) {
      window.location.href = '/src/plataforma/app/admin/subjects/delete/' + id;
    }
  }
</script>
