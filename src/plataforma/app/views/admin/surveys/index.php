<?php
// Helpers para escapar
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
?>
<div class="container px-6 py-8">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Gestión de Encuestas</h1>
            <div class="flex gap-3">
                <a href="/src/plataforma/app/admin/surveys/create" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i data-feather="plus" class="w-4 h-4"></i>
                    Nueva Encuesta
                </a>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="mb-6">
            <form method="GET" class="flex gap-4">
                <div class="flex-1">
                    <input type="text" name="q" value="<?= $esc($buscar ?? '') ?>" placeholder="Buscar encuestas..." class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                </div>
                <select name="status" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                    <option value="">Todos los estados</option>
                    <option value="active" <?= (($status ?? '') === 'active') ? 'selected' : '' ?>>Activa</option>
                    <option value="inactive" <?= (($status ?? '') === 'inactive') ? 'selected' : '' ?>>Inactiva</option>
                    <option value="draft" <?= (($status ?? '') === 'draft') ? 'selected' : '' ?>>Borrador</option>
                </select>
                <select name="target_role" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                    <option value="">Todos los roles</option>
                    <option value="student" <?= (($target_role ?? '') === 'student') ? 'selected' : '' ?>>Estudiantes</option>
                    <option value="teacher" <?= (($target_role ?? '') === 'teacher') ? 'selected' : '' ?>>Profesores</option>
                    <option value="all" <?= (($target_role ?? '') === 'all') ? 'selected' : '' ?>>Todos</option>
                </select>
                <button type="submit" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                    <i data-feather="search" class="w-4 h-4"></i>
                    Buscar
                </button>
            </form>
        </div>

        <!-- Tabla de Encuestas -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Título de la Encuesta</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Dirigida a</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Respuestas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Fecha de Creación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    <?php foreach (($surveys ?? []) as $survey): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                                        <i data-feather="clipboard" class="w-5 h-5 text-purple-600 dark:text-purple-400"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium"><?= $esc($survey->title ?? '') ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="max-w-xs truncate text-neutral-500 dark:text-neutral-400">
                                <?= $esc($survey->description ?? '') ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <?php
                            $role = $survey->target_role ?? 'all';
                            $roleText = match($role) {
                                'student' => 'Estudiantes',
                                'teacher' => 'Profesores',
                                default => 'Todos'
                            };
                            $roleColor = match($role) {
                                'student' => 'bg-green-100 text-green-800',
                                'teacher' => 'bg-blue-100 text-blue-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                            ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $roleColor ?>">
                                <?= $roleText ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                <?= $esc($survey->responses_count ?? 0) ?> respuestas
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                            $status = $survey->status ?? '';
                            $statusText = match($status) {
                                'active' => 'Activa',
                                'inactive' => 'Inactiva',
                                'draft' => 'Borrador',
                                default => 'Desconocido'
                            };
                            $statusColor = match($status) {
                                'active' => 'bg-green-100 text-green-800',
                                'inactive' => 'bg-red-100 text-red-800',
                                'draft' => 'bg-yellow-100 text-yellow-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                            ?>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusColor ?>">
                                <?= $statusText ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <?php if (isset($survey->created_at) && $survey->created_at): ?>
                                <?= $esc(date('d/m/Y', strtotime($survey->created_at))) ?>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-3">
                                <a href="/src/plataforma/app/admin/surveys/edit/<?= $esc($survey->id) ?>" class="text-primary-600 hover:text-primary-900">
                                    <i data-feather="edit" class="w-4 h-4"></i>
                                </a>
                                <a href="/src/plataforma/app/admin/surveys/results/<?= $esc($survey->id) ?>" class="text-blue-600 hover:text-blue-900">
                                    <i data-feather="bar-chart" class="w-4 h-4"></i>
                                </a>
                                <form action="/src/plataforma/app/admin/surveys/delete/<?= $esc($survey->id) ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta encuesta?');">
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (empty($surveys)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                            No se encontraron encuestas con los filtros aplicados.
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
                    <a href="?page=<?= ($page ?? 1) - 1 ?>&q=<?= urlencode($buscar ?? '') ?>&status=<?= urlencode($status ?? '') ?>&target_role=<?= urlencode($target_role ?? '') ?>" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                        Anterior
                    </a>
                <?php endif; ?>
                <?php if (($page ?? 1) < ($totalPages ?? 1)): ?>
                    <a href="?page=<?= ($page ?? 1) + 1 ?>&q=<?= urlencode($buscar ?? '') ?>&status=<?= urlencode($status ?? '') ?>&target_role=<?= urlencode($target_role ?? '') ?>" class="ml-3 relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
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
                            <a href="?page=<?= ($page ?? 1) - 1 ?>&q=<?= urlencode($buscar ?? '') ?>&status=<?= urlencode($status ?? '') ?>&target_role=<?= urlencode($target_role ?? '') ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 bg-white text-sm font-medium text-neutral-500 hover:bg-neutral-50">
                                <span class="sr-only">Anterior</span>
                                <i data-feather="chevron-left" class="w-5 h-5"></i>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = max(1, ($page ?? 1) - 2); $i <= min(($totalPages ?? 1), ($page ?? 1) + 2); $i++): ?>
                            <a href="?page=<?= $i ?>&q=<?= urlencode($buscar ?? '') ?>&status=<?= urlencode($status ?? '') ?>&target_role=<?= urlencode($target_role ?? '') ?>" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 bg-white text-sm font-medium <?= $i === ($page ?? 1) ? 'text-primary-600' : 'text-neutral-700 hover:bg-neutral-50' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if (($page ?? 1) < ($totalPages ?? 1)): ?>
                            <a href="?page=<?= ($page ?? 1) + 1 ?>&q=<?= urlencode($buscar ?? '') ?>&status=<?= urlencode($status ?? '') ?>&target_role=<?= urlencode($target_role ?? '') ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-neutral-300 bg-white text-sm font-medium text-neutral-500 hover:bg-neutral-50">
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