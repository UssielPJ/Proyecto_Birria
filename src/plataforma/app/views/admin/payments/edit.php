<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Editar Pago</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Modifica la información del pago</p>
            </div>

            <?php if (!isset($payment) || !is_object($payment)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <p class="font-bold">Error</p>
                    <p>No se encontró el pago solicitado.</p>
                </div>
                <div class="mt-4">
                    <a href="/src/plataforma/app/admin/payments" class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600">
                        Volver a la lista
                    </a>
                </div>
            <?php else: ?>
                <?php
                $action = '/src/plataforma/admin/payments/update/' . htmlspecialchars($payment->id ?? '');
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