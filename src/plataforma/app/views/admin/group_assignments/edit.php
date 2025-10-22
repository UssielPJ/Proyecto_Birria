<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Editar Asignación a Grupo</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Modifica la asignación del estudiante al grupo</p>
            </div>

            <?php if (!isset($assignment) || !is_object($assignment)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <p class="font-bold">Error</p>
                    <p>No se encontró la asignación solicitada.</p>
                </div>
                <div class="mt-4">
                    <a href="/src/plataforma/app/admin/group_assignments" class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600">
                        Volver a la lista
                    </a>
                </div>
            <?php else: ?>
                <?php
                $action = '/src/plataforma/admin/group_assignments/update/' . htmlspecialchars($assignment->id ?? '');
                $method = 'POST';
                $submitText = 'Guardar Cambios';
                include __DIR__ . '/partials/form.php';
                ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    feather.replace();
</script>