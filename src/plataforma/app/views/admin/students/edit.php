<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Editar Estudiante</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Modifica la información del estudiante</p>
            </div>

            <form action="/src/plataforma/app/admin/students/update/<?= $student->id ?>" method="POST" class="space-y-6">
                <!-- Información Personal -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información Personal</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nombre Completo</label>
                            <input type="text" name="name" required value="<?= htmlspecialchars($student->name) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Correo Electrónico</label>
                            <input type="email" name="email" required value="<?= htmlspecialchars($student->email) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Teléfono</label>
                            <input type="tel" name="phone" required value="<?= htmlspecialchars($student->phone) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Nacimiento</label>
                            <input type="date" name="birthdate" required value="<?= htmlspecialchars($student->birthdate) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>
                </div>

                <!-- Información Académica -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información Académica</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Carrera</label>
                            <select name="carrera" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona una carrera</option>
                                <option value="sistemas" <?= $student->carrera === 'sistemas' ? 'selected' : '' ?>>Ing. en Sistemas</option>
                                <option value="industrial" <?= $student->carrera === 'industrial' ? 'selected' : '' ?>>Ing. Industrial</option>
                                <option value="mecatronica" <?= $student->carrera === 'mecatronica' ? 'selected' : '' ?>>Ing. Mecatrónica</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre</label>
                            <select name="semestre" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el semestre</option>
                                <option value="1" <?= $student->semestre === '1' ? 'selected' : '' ?>>1er Semestre</option>
                                <option value="2" <?= $student->semestre === '2' ? 'selected' : '' ?>>2do Semestre</option>
                                <option value="3" <?= $student->semestre === '3' ? 'selected' : '' ?>>3er Semestre</option>
                                <option value="4" <?= $student->semestre === '4' ? 'selected' : '' ?>>4to Semestre</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Matrícula</label>
                            <input type="text" name="matricula" required value="<?= htmlspecialchars($student->matricula) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Grupo</label>
                            <input type="text" name="grupo" required value="<?= htmlspecialchars($student->grupo) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>
                </div>

                <!-- Estado del Estudiante -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Estado del Estudiante</h2>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
                        <select name="status" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                            <option value="active" <?= $student->status === 'active' ? 'selected' : '' ?>>Activo</option>
                            <option value="inactive" <?= $student->status === 'inactive' ? 'selected' : '' ?>>Inactivo</option>
                            <option value="suspended" <?= $student->status === 'suspended' ? 'selected' : '' ?>>Suspendido</option>
                        </select>
                    </div>
                </div>

                <!-- Nueva Contraseña (Opcional) -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Cambiar Contraseña</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-4">Deja estos campos en blanco si no deseas cambiar la contraseña</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nueva Contraseña</label>
                            <input type="password" name="password" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/src/plataforma/app/admin/students" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    feather.replace();

    // Validación del formulario
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const password = form.querySelector('input[name="password"]').value;
        const passwordConfirmation = form.querySelector('input[name="password_confirmation"]').value;

        if (password || passwordConfirmation) {
            if (password !== passwordConfirmation) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return;
            }
            if (password.length < 6) {
                e.preventDefault();
                alert('La contraseña debe tener al menos 6 caracteres');
                return;
            }
        }
    });
</script>