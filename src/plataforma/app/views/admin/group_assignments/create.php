<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Nueva Asignación a Grupo</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Asigna un estudiante a un grupo</p>
            </div>

            <?php
            $assignment = null; // No hay asignación para editar
            $action = '/src/plataforma/admin/group_assignments/store';
            $method = 'POST';
            $submitText = 'Guardar Asignación';
            include __DIR__ . '/partials/form.php';
            ?>
        </div>
    </div>
</div>

<script>
    feather.replace();
</script>