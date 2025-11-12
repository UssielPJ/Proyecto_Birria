<?php
// Guard de acceso
if (session_status() === PHP_SESSION_NONE) session_start();
if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
  header('Location: /src/plataforma/'); exit;
}

// Helpers para escapar y castear null→''
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

// Shorthands (pueden venir null si el controlador aún no los pasa)
$alumno = $alumno ?? (object)[];
$isEdit = !empty($alumno->user_id);
?>

<main class="p-6">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold mb-2"><?= $isEdit ? 'Editar Alumno' : 'Nuevo Alumno' ?></h1>
                <p class="text-neutral-500 dark:text-neutral-400">
                    <?= $isEdit ? 'Modifica la información del alumno' : 'Ingresa la información del nuevo alumno' ?>
                </p>
            </div>

            <form action="/src/plataforma/capturista/alumnos/guardar" method="POST" class="space-y-6">
                <?php if ($isEdit): ?>
                    <input type="hidden" name="user_id" value="<?= $esc($alumno->user_id) ?>">
                <?php endif; ?>

                <!-- Información Personal -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información Personal</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Nombre(s) *</label>
                            <input type="text" name="nombre" required value="<?= $esc($alumno->nombre_usuario ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Apellido paterno</label>
                            <input type="text" name="apellido_paterno" value="<?= $esc($alumno->apellido_paterno ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Apellido materno</label>
                            <input type="text" name="apellido_materno" value="<?= $esc($alumno->apellido_materno ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Correo electrónico *</label>
                            <input type="email" name="email" required value="<?= $esc($alumno->email_usuario ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Teléfono</label>
                            <input type="tel" name="telefono" value="<?= $esc($alumno->telefono ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Fecha de nacimiento</label>
                            <input type="date" name="fecha_nacimiento" value="<?= $esc($alumno->fecha_nacimiento ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>
                </div>

                <!-- Información Académica -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información Académica</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Matrícula</label>
                            <input type="text" name="matricula" value="<?= $esc($alumno->matricula ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Ej: 2024001">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">CURP *</label>
                            <input type="text" name="curp" required maxlength="18" value="<?= $esc($alumno->curp ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 font-mono" placeholder="Ej: ABCD123456HDFXXX01">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Carrera ID</label>
                            <input type="number" name="carrera_id" value="<?= $esc($alumno->carrera_id ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="ID de la carrera">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Semestre</label>
                            <input type="number" name="semestre" min="1" max="12" value="<?= $esc($alumno->semestre ?? '1') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Grupo</label>
                            <input type="text" name="grupo" value="<?= $esc($alumno->grupo ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Ej: A, B, 1A">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Tipo de Ingreso</label>
                            <select name="tipo_ingreso" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="nuevo" <?= ($alumno->tipo_ingreso ?? 'nuevo') === 'nuevo' ? 'selected' : '' ?>>Nuevo</option>
                                <option value="reingreso" <?= ($alumno->tipo_ingreso ?? '') === 'reingreso' ? 'selected' : '' ?>>Reingreso</option>
                                <option value="transferencia" <?= ($alumno->tipo_ingreso ?? '') === 'transferencia' ? 'selected' : '' ?>>Transferencia</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Promedio General</label>
                            <input type="number" name="promedio_general" step="0.01" min="0" max="10" value="<?= $esc($alumno->promedio_general ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="0.00">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Créditos Aprobados</label>
                            <input type="number" name="creditos_aprobados" min="0" value="<?= $esc($alumno->creditos_aprobados ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Dirección</label>
                            <textarea name="direccion" rows="3" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Dirección completa"><?= $esc($alumno->direccion ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Contacto de Emergencia - Nombre</label>
                            <input type="text" name="contacto_emergencia_nombre" value="<?= $esc($alumno->contacto_emergencia_nombre ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">Contacto de Emergencia - Teléfono</label>
                            <input type="tel" name="contacto_emergencia_telefono" value="<?= $esc($alumno->contacto_emergencia_telefono ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1">Parentesco de Emergencia</label>
                            <input type="text" name="parentesco_emergencia" value="<?= $esc($alumno->parentesco_emergencia ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Ej: Madre, Padre, Hermano">
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <input id="beca_activa" type="checkbox" name="beca_activa" value="1" <?= !empty($alumno->beca_activa) ? 'checked' : '' ?> class="h-4 w-4">
                        <label for="beca_activa" class="text-sm font-medium">Beca activa</label>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/src/plataforma/capturista/alumnos" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
                        <?= $isEdit ? 'Guardar Cambios' : 'Guardar Alumno' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    // Validación simple
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const curp = form.querySelector('input[name="curp"]').value;
        if (curp && curp.length !== 18) {
            e.preventDefault();
            alert('La CURP debe tener exactamente 18 caracteres');
            return;
        }
    });

    // Inicializar íconos
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
</script>