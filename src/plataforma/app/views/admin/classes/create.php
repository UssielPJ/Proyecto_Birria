<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Nueva Clase</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Ingresa la información de la nueva clase</p>
            </div>

            <?php
            $class = null; // No hay clase para editar
            $action = '/src/plataforma/admin/classes/store';
            $method = 'POST';
            $submitText = 'Guardar Clase';
            include __DIR__ . '/partials/form.php';
            ?>
        </div>
    </div>
</div>

<script>
    feather.replace();
</script>