<?php
// Guard de acceso
if (session_status() === PHP_SESSION_NONE) session_start();
if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
  header('Location: /src/plataforma/'); exit;
}
?>

<main class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold mb-2">Alumnos</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Gestiona y visualiza la información de los alumnos.</p>
        </div>
        <a href="/src/plataforma/capturista/alumnos/crear"
           class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2">
            <i data-feather="plus"></i>
            Nuevo alumno
        </a>
    </div>

    <!-- Filtros y búsqueda -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 mb-6">
        <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="q" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Buscar
                </label>
                <div class="relative">
                    <input type="text" name="q" id="q" value="<?= htmlspecialchars($buscar ?? '') ?>"
                           placeholder="Matrícula o CURP..."
                           class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 pr-10 focus:border-primary-500 focus:ring-primary-500">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <i data-feather="search" class="h-5 w-5 text-neutral-400"></i>
                    </div>
                </div>
            </div>

            <div>
                <label for="carrera" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Carrera
                </label>
                <select name="carrera" id="carrera"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todas las carreras</option>
                    <?php foreach (($carreras ?? []) as $c): ?>
                        <option value="<?= htmlspecialchars($c) ?>" <?= ($carrera ?? '') === $c ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="tipo_ingreso" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                    Tipo de Ingreso
                </label>
                <select name="tipo_ingreso" id="tipo_ingreso"
                        class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Todos los tipos</option>
                    <option value="nuevo" <?= ($tipo_ingreso ?? '') === 'nuevo' ? 'selected' : '' ?>>Nuevo</option>
                    <option value="reingreso" <?= ($tipo_ingreso ?? '') === 'reingreso' ? 'selected' : '' ?>>Reingreso</option>
                    <option value="transferencia" <?= ($tipo_ingreso ?? '') === 'transferencia' ? 'selected' : '' ?>>Transferencia</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2">
                    <i data-feather="filter"></i>
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de alumnos -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead class="bg-neutral-50 dark:bg-neutral-800">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Alumno
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Matrícula
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            CURP
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Carrera
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Semestre
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                            Tipo Ingreso
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    <?php foreach (($alumnos ?? []) as $alumno): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                            <i data-feather="user" class="text-primary-600 dark:text-primary-400"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                            <?= htmlspecialchars($alumno->nombre_usuario ?? '') ?>
                                        </div>
                                        <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                            <?= htmlspecialchars($alumno->email_usuario ?? '') ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($alumno->matricula ?? '') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($alumno->curp ?? '') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                Carrera ID: <?= htmlspecialchars($alumno->carrera_id ?? '') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($alumno->semestre ?? '') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-900 dark:text-neutral-100">
                                <?= htmlspecialchars($alumno->tipo_ingreso ?? '') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="/src/plataforma/capturista/alumnos/editar/<?= $alumno->user_id ?>" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 mr-3">
                                    Editar
                                </a>
                                <form action="/src/plataforma/capturista/alumnos/eliminar/<?= $alumno->user_id ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este alumno?');">
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($alumnos)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-neutral-500 dark:text-neutral-400">
                                No se encontraron alumnos
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <?php if (($totalPages ?? 1) > 1): ?>
        <div class="bg-neutral-50 dark:bg-neutral-800 px-4 py-3 flex items-center justify-between border-t border-neutral-200 dark:border-neutral-700 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <?php if (($page ?? 1) > 1): ?>
                    <a href="?page=<?= ($page ?? 1) - 1 ?>&q=<?= urlencode($buscar ?? '') ?>&carrera=<?= urlencode($carrera ?? '') ?>&tipo_ingreso=<?= urlencode($tipo_ingreso ?? '') ?>"
                       class="relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                        Anterior
                    </a>
                <?php endif; ?>
                <?php if (($page ?? 1) < ($totalPages ?? 1)): ?>
                    <a href="?page=<?= ($page ?? 1) + 1 ?>&q=<?= urlencode($buscar ?? '') ?>&carrera=<?= urlencode($carrera ?? '') ?>&tipo_ingreso=<?= urlencode($tipo_ingreso ?? '') ?>"
                       class="ml-3 relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                        Siguiente
                    </a>
                <?php endif; ?>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-neutral-700 dark:text-neutral-400">
                        Mostrando
                        <span class="font-medium"><?= (($page ?? 1) - 1) * ($limit ?? 10) + 1 ?></span>
                        a
                        <span class="font-medium"><?= min(($page ?? 1) * ($limit ?? 10), $total ?? 0) ?></span>
                        de
                        <span class="font-medium"><?= $total ?? 0 ?></span>
                        resultados
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php if (($page ?? 1) > 1): ?>
                            <a href="?page=<?= ($page ?? 1) - 1 ?>&q=<?= urlencode($buscar ?? '') ?>&carrera=<?= urlencode($carrera ?? '') ?>&tipo_ingreso=<?= urlencode($tipo_ingreso ?? '') ?>"
                               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
                                <span class="sr-only">Previous</span>
                                <i data-feather="chevron-left" class="h-5 w-5"></i>
                            </a>
                        <?php endif; ?>

                        <?php for ($i = max(1, ($page ?? 1) - 2); $i <= min(($totalPages ?? 1), ($page ?? 1) + 2); $i++): ?>
                            <a href="?page=<?= $i ?>&q=<?= urlencode($buscar ?? '') ?>&carrera=<?= urlencode($carrera ?? '') ?>&tipo_ingreso=<?= urlencode($tipo_ingreso ?? '') ?>"
                               class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium <?= $i === ($page ?? 1) ? 'text-primary-600 dark:text-primary-400' : 'text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if (($page ?? 1) < ($totalPages ?? 1)): ?>
                            <a href="?page=<?= ($page ?? 1) + 1 ?>&q=<?= urlencode($buscar ?? '') ?>&carrera=<?= urlencode($carrera ?? '') ?>&tipo_ingreso=<?= urlencode($tipo_ingreso ?? '') ?>"
                               class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-700 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-600">
                                <span class="sr-only">Next</span>
                                <i data-feather="chevron-right" class="h-5 w-5"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<script>
    // Inicializar los íconos
    feather.replace();

    // Enviar formulario automáticamente al cambiar filtros
    document.querySelectorAll('select[name="carrera"], select[name="tipo_ingreso"]').forEach(select => {
        select.addEventListener('change', () => {
            select.closest('form').submit();
        });
    });
</script>