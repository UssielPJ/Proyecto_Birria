<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Gestión de Estudiantes</h1>
            <a href="/src/plataforma/app/admin/students/create" class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <i data-feather="user-plus" class="w-4 h-4"></i>
                Nuevo Estudiante
            </a>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="mb-6">
            <div class="flex gap-4">
                <div class="flex-1">
                    <input type="text" placeholder="Buscar estudiantes..." class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                </div>
                <select class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                    <option value="">Todos los semestres</option>
                    <option value="1">1er Semestre</option>
                    <option value="2">2do Semestre</option>
                    <option value="3">3er Semestre</option>
                    <option value="4">4to Semestre</option>
                </select>
                <select class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                    <option value="">Todas las carreras</option>
                    <option value="sistemas">Ing. en Sistemas</option>
                    <option value="industrial">Ing. Industrial</option>
                    <option value="mecatronica">Ing. Mecatrónica</option>
                </select>
            </div>
        </div>

        <!-- Tabla de Estudiantes -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estudiante</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Matrícula</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Carrera</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Semestre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                    <?php foreach ($students as $student): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                        <i data-feather="user" class="w-5 h-5 text-primary-600 dark:text-primary-400"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium"><?= htmlspecialchars($student->name) ?></div>
                                    <div class="text-sm text-neutral-500 dark:text-neutral-400"><?= htmlspecialchars($student->email) ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm"><?= htmlspecialchars($student->matricula) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm"><?= htmlspecialchars($student->carrera) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm"><?= htmlspecialchars($student->semestre) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $student->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                <?= ucfirst($student->status) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex items-center gap-3">
                                <a href="/src/plataforma/app/admin/students/edit/<?= $student->id ?>" class="text-primary-600 hover:text-primary-900">
                                    <i data-feather="edit" class="w-4 h-4"></i>
                                </a>
                                <form action="/src/plataforma/app/admin/students/delete/<?= $student->id ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este estudiante?');">
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="flex items-center justify-between px-4 py-3 border-t border-neutral-200 dark:border-neutral-700 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                    Anterior
                </a>
                <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-neutral-300 text-sm font-medium rounded-md text-neutral-700 bg-white hover:bg-neutral-50">
                    Siguiente
                </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-neutral-700 dark:text-neutral-400">
                        Mostrando
                        <span class="font-medium">1</span>
                        a
                        <span class="font-medium">10</span>
                        de
                        <span class="font-medium"><?= count($students) ?></span>
                        resultados
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 bg-white text-sm font-medium text-neutral-500 hover:bg-neutral-50">
                            <span class="sr-only">Anterior</span>
                            <i data-feather="chevron-left" class="w-5 h-5"></i>
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 bg-white text-sm font-medium text-neutral-700 hover:bg-neutral-50">
                            1
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 bg-white text-sm font-medium text-neutral-700 hover:bg-neutral-50">
                            2
                        </a>
                        <a href="#" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 bg-white text-sm font-medium text-neutral-700 hover:bg-neutral-50">
                            3
                        </a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-neutral-300 bg-white text-sm font-medium text-neutral-500 hover:bg-neutral-50">
                            <span class="sr-only">Siguiente</span>
                            <i data-feather="chevron-right" class="w-5 h-5"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Inicializar iconos
    feather.replace();
    
    // Inicializar búsqueda y filtros
    document.querySelector('input[type="text"]').addEventListener('input', function(e) {
        // Implementar lógica de búsqueda
        console.log('Buscando:', e.target.value);
    });
    
    // Escuchar cambios en los filtros
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', function(e) {
            // Implementar lógica de filtrado
            console.log('Filtro cambiado:', e.target.value);
        });
    });
</script>