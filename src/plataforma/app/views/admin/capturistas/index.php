<?php
// Helpers para escapar y componer el nombre completo
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
$fullName = function ($row) {
    $parts = [ $row->nombre ?? '', $row->apellido_paterno ?? '', $row->apellido_materno ?? '' ];
    $parts = array_filter($parts, fn($x) => $x !== '');
    return trim(implode(' ', $parts));
};

// Mostrar mensajes de éxito/error
$success = isset($_GET['created']) || isset($_GET['updated']);
$error = $_GET['error'] ?? null;
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
                <a href="/src/plataforma/app/admin/capturistas/create" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i data-feather="user-plus" class="w-4 h-4"></i>
                    Nuevo Capturista
                </a>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="mb-6">
            <form method="GET" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" name="q" value="<?= $esc($buscar ?? '') ?>" placeholder="Buscar capturistas..." class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                </div>
                <select name="status" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                    <option value="">Todos los estados</option>
                    <option value="active"   <?= (($status ?? '') === 'active')   ? 'selected' : '' ?>>Activo</option>
                    <option value="inactive" <?= (($status ?? '') === 'inactive') ? 'selected' : '' ?>>Inactivo</option>
                </select>
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i data-feather="search" class="w-4 h-4"></i>
                    Buscar
                </button>
            </form>
        </div>

        <!-- Tabla de Capturistas -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Capturista</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Número Empleado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">CURP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Fecha Ingreso</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    <?php foreach (($capturistas ?? []) as $capturista): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                        <i data-feather="user" class="w-5 h-5 text-primary-600 dark:text-primary-400"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium"><?= $esc($fullName($capturista)) ?></div>
                                    <div class="text-sm text-neutral-500 dark:text-neutral-400"><?= $esc($capturista->email ?? '') ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm"><?= $esc($capturista->numero_empleado ?? '') ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm"><?= $esc($capturista->capturista_telefono ?? '') ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-xs"><?= $esc($capturista->curp ?? '') ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm"><?= $capturista->fecha_ingreso ? $esc(date('d/m/Y', strtotime($capturista->fecha_ingreso))) : '' ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= (($capturista->capturista_status ?? '') === 'activo') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                <?= $esc(ucfirst($capturista->capturista_status ?? '')) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-3">
                                <a href="/src/plataforma/app/admin/capturistas/edit/<?= $esc($capturista->id) ?>" class="text-primary-600 hover:text-primary-900">
                                    <i data-feather="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="/src/plataforma/app/admin/capturistas/delete/<?= $esc($capturista->id) ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este capturista?');">
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (empty($capturistas)): ?>
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
        <?php if (($totalPages ?? 1) > 1): ?>
        <div class="flex items-center justify-between px-4 py-3 border-t border-neutral-200 dark:border-neutral-700 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <?php if (($page ?? 1) > 1): ?>
                    <a href="?page=<?= ($page ?? 1) - 1 ?>&q=<?= urlencode($buscar ?? '') ?>&status=<?= urlencode($status ?? '') ?>" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                        Anterior
                    </a>
                <?php endif; ?>
                <?php if (($page ?? 1) < ($totalPages ?? 1)): ?>
                    <a href="?page=<?= ($page ?? 1) + 1 ?>&q=<?= urlencode($buscar ?? '') ?>&status=<?= urlencode($status ?? '') ?>" class="ml-3 relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                        Siguiente
                    </a>
                <?php endif; ?>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-neutral-700 dark:text-neutral-400">
                        Mostrando
                        <span class="font-medium"><?= (($page ?? 1) - 1) * 10 + 1 ?></span>
                        a
                        <span class="font-medium"><?= min(($page ?? 1) * 10, $total ?? 0) ?></span>
                        de
                        <span class="font-medium"><?= $esc($total ?? 0) ?></span>
                        resultados
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php if (($page ?? 1) > 1): ?>
                            <a href="?page=<?= ($page ?? 1) - 1 ?>&q=<?= urlencode($buscar ?? '') ?>&status=<?= urlencode($status ?? '') ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 bg-white text-sm font-medium text-neutral-500 hover:bg-neutral-50">
                                <span class="sr-only">Anterior</span>
                                <i data-feather="chevron-left" class="w-5 h-5"></i>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = max(1, ($page ?? 1) - 2); $i <= min(($totalPages ?? 1), ($page ?? 1) + 2); $i++): ?>
                            <a href="?page=<?= $i ?>&q=<?= urlencode($buscar ?? '') ?>&status=<?= urlencode($status ?? '') ?>" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 bg-white text-sm font-medium <?= $i === ($page ?? 1) ? 'text-primary-600' : 'text-neutral-700 hover:bg-neutral-50' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if (($page ?? 1) < ($totalPages ?? 1)): ?>
                            <a href="?page=<?= ($page ?? 1) + 1 ?>&q=<?= urlencode($buscar ?? '') ?>&status=<?= urlencode($status ?? '') ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-neutral-300 bg-white text-sm font-medium text-neutral-500 hover:bg-neutral-50">
                                <span class="sr-only">Siguiente</span>
                                <i data-feather="chevron-right" class="w-5 h-5"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
  feather.replace();
</script>