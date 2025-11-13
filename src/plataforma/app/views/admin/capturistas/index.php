<?php
// admin/capturistas/index.php

// Helpers
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
$fullName = function ($row) {
    $parts = [ $row->nombre ?? '', $row->apellido_paterno ?? '', $row->apellido_materno ?? '' ];
    $parts = array_filter($parts, fn($x) => $x !== '');
    return trim(implode(' ', $parts));
};

// Vars esperadas desde el controlador
$rows           = $rows           ?? [];
$total          = (int)($total    ?? 0);
$page           = max(1, (int)($page  ?? 1));
$limit          = max(1, (int)($limit ?? 10));
$q              = $q              ?? '';
$user_status    = $user_status    ?? '';
$profile_status = $profile_status ?? '';

$totalPages = (int)max(1, ceil($total / $limit));

// Mensajes
$success = isset($_GET['created']) || isset($_GET['updated']) || isset($_GET['deleted']);
$error   = $_GET['error'] ?? null;
?>
<div class="container px-6 py-8">
  <?php if ($success): ?>
    <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700">
      <div class="flex items-center gap-2">
        <i data-feather="check-circle" class="w-5 h-5"></i>
        <span>Operación completada exitosamente.</span>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700">
      <div class="flex items-center gap-2">
        <i data-feather="alert-circle" class="w-5 h-5"></i>
        <span><?= $esc($error) ?></span>
      </div>
    </div>
  <?php endif; ?>

  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Gestión de Capturistas</h1>
      <div class="flex gap-3">
        <a href="/src/plataforma/app/admin/capturistas/create"
           class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
          <i data-feather="user-plus" class="w-4 h-4"></i>
          Nuevo Capturista
        </a>
      </div>
    </div>

    <!-- Filtros -->
    <div class="mb-6">
      <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2">
          <input type="text" name="q" value="<?= $esc($q) ?>" placeholder="Buscar por nombre, correo, número o CURP..."
                 class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
        </div>

        <select name="user_status" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
          <option value="">Usuario: todos</option>
          <option value="active"    <?= $user_status==='active'    ? 'selected' : '' ?>>Usuario activo</option>
          <option value="inactive"  <?= $user_status==='inactive'  ? 'selected' : '' ?>>Usuario inactivo</option>
          <option value="suspended" <?= $user_status==='suspended' ? 'selected' : '' ?>>Usuario suspendido</option>
        </select>

        <select name="profile_status" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
          <option value="">Perfil: todos</option>
          <option value="active"   <?= $profile_status==='active'   ? 'selected' : '' ?>>Perfil activo</option>
          <option value="inactive" <?= $profile_status==='inactive' ? 'selected' : '' ?>>Perfil inactivo</option>
        </select>

        <div class="md:col-span-4 flex justify-end">
          <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            <i data-feather="search" class="w-4 h-4"></i>
            Buscar
          </button>
        </div>
      </form>
    </div>

    <!-- Tabla -->
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
        <thead>
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Capturista</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Número</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Teléfono</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">CURP</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Ingreso</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Perfil</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Acciones</th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
          <?php foreach ($rows as $r): ?>
            <?php
              $badgeClass = ($r->profile_status ?? '') === 'active'
                ? 'bg-green-100 text-green-800'
                : 'bg-red-100 text-red-800';
              $badgeText = ($r->profile_status ?? '') === 'active' ? 'Activo' : 'Inactivo';
            ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                      <i data-feather="user" class="w-5 h-5 text-primary-600 dark:text-primary-400"></i>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium"><?= $esc($fullName($r)) ?></div>
                    <div class="text-sm text-neutral-500 dark:text-neutral-400"><?= $esc($r->email ?? '') ?></div>
                    <div class="text-xs text-neutral-400">Usuario: <?= $esc($r->user_status ?? '') ?></div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm"><?= $esc($r->numero_empleado ?? '') ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm"><?= $esc($r->telefono ?? '') ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-xs"><?= $esc($r->curp ?? '') ?></td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <?= !empty($r->fecha_ingreso) ? $esc(date('d/m/Y', strtotime($r->fecha_ingreso))) : '' ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $badgeClass ?>">
                  <?= $esc($badgeText) ?>
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm">
                <div class="flex items-center gap-3">
                  <a href="/src/plataforma/app/admin/capturistas/edit/<?= $esc($r->user_id) ?>" class="text-primary-600 hover:text-primary-900" title="Editar">
                    <i data-feather="edit" class="w-4 h-4"></i>
                  </a>
                  <form action="/src/plataforma/app/admin/capturistas/delete/<?= $esc($r->user_id) ?>" method="POST" class="inline-block"
                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este capturista?');">
                    <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                      <i data-feather="trash-2" class="w-4 h-4"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>

          <?php if (empty($rows)): ?>
            <tr>
              <td colspan="7" class="px-6 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                No se encontraron capturistas con los filtros aplicados.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Paginación -->
    <?php if ($totalPages > 1): ?>
      <div class="flex items-center justify-between px-4 py-3 border-t border-neutral-200 dark:border-neutral-700 sm:px-6">
        <div class="hidden sm:block text-sm text-neutral-700 dark:text-neutral-400">
          Mostrando
          <span class="font-medium"><?= $total ? (($page - 1) * $limit + 1) : 0 ?></span>
          a
          <span class="font-medium"><?= min($page * $limit, $total) ?></span>
          de
          <span class="font-medium"><?= $esc($total) ?></span>
          resultados
        </div>
        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
          <?php if ($page > 1): ?>
            <a href="?page=<?= $page-1 ?>&q=<?= urlencode($q) ?>&user_status=<?= urlencode($user_status) ?>&profile_status=<?= urlencode($profile_status) ?>"
               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 bg-white text-sm font-medium text-neutral-500 hover:bg-neutral-50">
              <span class="sr-only">Anterior</span>
              <i data-feather="chevron-left" class="w-5 h-5"></i>
            </a>
          <?php endif; ?>

          <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
            <a href="?page=<?= $i ?>&q=<?= urlencode($q) ?>&user_status=<?= urlencode($user_status) ?>&profile_status=<?= urlencode($profile_status) ?>"
               class="relative inline-flex items-center px-4 py-2 border border-neutral-300 bg-white text-sm font-medium <?= $i === $page ? 'text-primary-600' : 'text-neutral-700 hover:bg-neutral-50' ?>">
              <?= $i ?>
            </a>
          <?php endfor; ?>

          <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page+1 ?>&q=<?= urlencode($q) ?>&user_status=<?= urlencode($user_status) ?>&profile_status=<?= urlencode($profile_status) ?>"
               class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-neutral-300 bg-white text-sm font-medium text-neutral-500 hover:bg-neutral-50">
              <span class="sr-only">Siguiente</span>
              <i data-feather="chevron-right" class="w-5 h-5"></i>
            </a>
          <?php endif; ?>
        </nav>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>feather.replace();</script>
