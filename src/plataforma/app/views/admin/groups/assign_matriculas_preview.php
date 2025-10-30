<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<div class="p-6">
  <h1 class="text-2xl font-bold mb-4">Asignar matrículas (5 dígitos)</h1>

  <?php if (!empty($_SESSION['error'])): ?>
    <div class="mb-4 rounded-md bg-red-50 p-4 text-red-700">
      <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['success'])): ?>
    <div class="mb-4 rounded-md bg-emerald-50 p-4 text-emerald-700">
      <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
    </div>
  <?php endif; ?>

  <div class="grid gap-4 md:grid-cols-2">
    <div class="rounded-lg border border-slate-200 p-4">
      <h2 class="font-semibold mb-2">Datos del grupo</h2>
      <p><b>Código:</b> <?= htmlspecialchars($grupo->codigo) ?></p>
      <p><b>Año (YY):</b> <?= (int)$YY ?></p>
      <p><b>Grupo (G):</b> <?= (int)$G ?></p>
      <p><b>Prefijo (YYG):</b> <?= (int)$prefix3 ?></p>
    </div>

    <div class="rounded-lg border border-slate-200 p-4">
      <h2 class="font-semibold mb-2">Asignación</h2>
      <p><b>Pendientes:</b> <?= (int)$count ?></p>
      <?php if ($count > 0): ?>
        <p><b>Rango de lista (LL):</b> <?= sprintf('%02d', $startLL) ?> – <?= sprintf('%02d', $endLL) ?></p>
        <p class="text-sm text-slate-600 mt-2">
          Ejemplo de primera matrícula a asignar:
          <b><?= (int)($YY*1000 + $G*100 + $startLL) ?></b>
        </p>
      <?php endif; ?>
    </div>
  </div>

  <div class="mt-6 flex items-center gap-3">
    <form method="post" action="/src/plataforma/app/admin/groups/assign-matriculas/<?= (int)$groupId ?>">
      <?php if ($count > 0): ?>
        <button class="rounded bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">
          Confirmar asignación
        </button>
      <?php endif; ?>
      <a href="/src/plataforma/app/admin/groups" class="rounded border px-4 py-2 text-slate-700 hover:bg-slate-50">
        Volver
      </a>
    </form>
  </div>
</div>
