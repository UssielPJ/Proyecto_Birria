<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Editar Materia</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Modifica la información de la materia</p>
            </div>

            <?php if (!isset($subject) || !is_object($subject)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <p class="font-bold">Error</p>
                    <p>No se encontró la materia solicitada.</p>
                </div>
                <div class="mt-4">
                    <a href="/src/plataforma/app/admin/subjects" class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600">
                        Volver a la lista
                    </a>
                </div>
            <?php else: ?>
                <?php
                $action = '/src/plataforma/admin/subjects/update/' . htmlspecialchars($subject->id ?? '');
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

    // Validación del formulario
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const nombre = form.querySelector('input[name="nombre"]').value.trim();
        const codigo = form.querySelector('input[name="codigo"]').value.trim();
        
        if (!nombre || !codigo) {
            e.preventDefault();
            alert('El nombre y código de la materia son obligatorios');
            return;
        }

        // Validar formato del código (letras seguidas de números)
        const codigoPattern = /^[A-Z]{2,4}\d{3}$/;
        if (!codigoPattern.test(codigo)) {
            e.preventDefault();
            alert('El código debe tener el formato: 2-4 letras seguidas de 3 números (Ej: MAT101)');
            return;
        }
    });
</script>