<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Editar Profesor</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Modifica la información del profesor</p>
            </div>

            <form action="/src/plataforma/app/admin/teachers/update/<?= $teacher->id ?>" method="POST" class="space-y-6">
                <!-- Información Personal -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información Personal</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nombre Completo</label>
                            <input type="text" name="nombre" required value="<?= htmlspecialchars($teacher->nombre) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Correo Electrónico</label>
                            <input type="email" name="email" required value="<?= htmlspecialchars($teacher->email) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Teléfono</label>
                            <input type="tel" name="telefono" required value="<?= htmlspecialchars($teacher->telefono) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" required value="<?= htmlspecialchars($teacher->fecha_nacimiento) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>
                </div>

                <!-- Información Laboral -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información Laboral</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Número de Empleado</label>
                            <input type="text" name="num_empleado" required value="<?= htmlspecialchars($teacher->num_empleado) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Departamento</label>
                            <select name="departamento" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona un departamento</option>
                                <option value="Ingeniería en Sistemas" <?= $teacher->departamento === 'Ingeniería en Sistemas' ? 'selected' : '' ?>>Ingeniería en Sistemas</option>
                                <option value="Ingeniería Industrial" <?= $teacher->departamento === 'Ingeniería Industrial' ? 'selected' : '' ?>>Ingeniería Industrial</option>
                                <option value="Ingeniería Mecatrónica" <?= $teacher->departamento === 'Ingeniería Mecatrónica' ? 'selected' : '' ?>>Ingeniería Mecatrónica</option>
                                <option value="Ciencias Básicas" <?= $teacher->departamento === 'Ciencias Básicas' ? 'selected' : '' ?>>Ciencias Básicas</option>
                                <option value="Humanidades" <?= $teacher->departamento === 'Humanidades' ? 'selected' : '' ?>>Humanidades</option>
                                <option value="Administración" <?= $teacher->departamento === 'Administración' ? 'selected' : '' ?>>Administración</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Contrato</label>
                            <select name="tipo_contrato" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el tipo de contrato</option>
                                <option value="tiempo_completo" <?= $teacher->tipo_contrato === 'tiempo_completo' ? 'selected' : '' ?>>Tiempo Completo</option>
                                <option value="medio_tiempo" <?= $teacher->tipo_contrato === 'medio_tiempo' ? 'selected' : '' ?>>Medio Tiempo</option>
                                <option value="por_horas" <?= $teacher->tipo_contrato === 'por_horas' ? 'selected' : '' ?>>Por Horas</option>
                                <option value="temporal" <?= $teacher->tipo_contrato === 'temporal' ? 'selected' : '' ?>>Temporal</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Ingreso</label>
                            <input type="date" name="fecha_ingreso" required value="<?= htmlspecialchars($teacher->fecha_ingreso) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>
                </div>

                <!-- Información Académica -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información Académica</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Grado Académico</label>
                            <select name="grado_academico" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el grado académico</option>
                                <option value="licenciatura" <?= $teacher->grado_academico === 'licenciatura' ? 'selected' : '' ?>>Licenciatura</option>
                                <option value="ingenieria" <?= $teacher->grado_academico === 'ingenieria' ? 'selected' : '' ?>>Ingeniería</option>
                                <option value="maestria" <?= $teacher->grado_academico === 'maestria' ? 'selected' : '' ?>>Maestría</option>
                                <option value="doctorado" <?= $teacher->grado_academico === 'doctorado' ? 'selected' : '' ?>>Doctorado</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Especialidad</label>
                            <input type="text" name="especialidad" required value="<?= htmlspecialchars($teacher->especialidad) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Universidad de Egreso</label>
                            <input type="text" name="universidad" required value="<?= htmlspecialchars($teacher->universidad) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>
                </div>

                <!-- Estado del Profesor -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Estado del Profesor</h2>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
                        <select name="estado" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                            <option value="activo" <?= $teacher->estado === 'activo' ? 'selected' : '' ?>>Activo</option>
                            <option value="inactivo" <?= $teacher->estado === 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                            <option value="sabático" <?= $teacher->estado === 'sabático' ? 'selected' : '' ?>>Sabático</option>
                        </select>
                    </div>
                </div>

                <!-- Materias que puede impartir -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Materias que puede impartir</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Selecciona las materias que este profesor puede impartir</p>
                    
                    <?php 
                    $materiasProfesor = isset($teacher->materias) ? explode(',', $teacher->materias) : [];
                    ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="materias[]" value="matematicas" <?= in_array('matematicas', $materiasProfesor) ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-600">
                            <span class="text-sm">Matemáticas</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="materias[]" value="fisica" <?= in_array('fisica', $materiasProfesor) ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-600">
                            <span class="text-sm">Física</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="materias[]" value="programacion" <?= in_array('programacion', $materiasProfesor) ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-600">
                            <span class="text-sm">Programación</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="materias[]" value="base_datos" <?= in_array('base_datos', $materiasProfesor) ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-600">
                            <span class="text-sm">Base de Datos</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="materias[]" value="redes" <?= in_array('redes', $materiasProfesor) ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-600">
                            <span class="text-sm">Redes</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="materias[]" value="ingles" <?= in_array('ingles', $materiasProfesor) ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-600">
                            <span class="text-sm">Inglés</span>
                        </label>
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
                    <a href="/src/plataforma/app/admin/teachers" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
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