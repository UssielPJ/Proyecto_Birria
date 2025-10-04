<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Editar Materia</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Modifica la información de la materia</p>
            </div>

            <form action="/src/plataforma/app/admin/subjects/update/<?= $subject->id ?>" method="POST" class="space-y-6">
                <!-- Información Básica -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información Básica</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nombre de la Materia</label>
                            <input type="text" name="nombre" required value="<?= htmlspecialchars($subject->nombre) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Código de la Materia</label>
                            <input type="text" name="codigo" required value="<?= htmlspecialchars($subject->codigo) ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Ej: MAT101">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Créditos</label>
                            <select name="creditos" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona los créditos</option>
                                <option value="1" <?= $subject->creditos == '1' ? 'selected' : '' ?>>1 crédito</option>
                                <option value="2" <?= $subject->creditos == '2' ? 'selected' : '' ?>>2 créditos</option>
                                <option value="3" <?= $subject->creditos == '3' ? 'selected' : '' ?>>3 créditos</option>
                                <option value="4" <?= $subject->creditos == '4' ? 'selected' : '' ?>>4 créditos</option>
                                <option value="5" <?= $subject->creditos == '5' ? 'selected' : '' ?>>5 créditos</option>
                                <option value="6" <?= $subject->creditos == '6' ? 'selected' : '' ?>>6 créditos</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Horas por Semana</label>
                            <select name="horas_semana" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona las horas</option>
                                <option value="2" <?= $subject->horas_semana == '2' ? 'selected' : '' ?>>2 horas</option>
                                <option value="3" <?= $subject->horas_semana == '3' ? 'selected' : '' ?>>3 horas</option>
                                <option value="4" <?= $subject->horas_semana == '4' ? 'selected' : '' ?>>4 horas</option>
                                <option value="5" <?= $subject->horas_semana == '5' ? 'selected' : '' ?>>5 horas</option>
                                <option value="6" <?= $subject->horas_semana == '6' ? 'selected' : '' ?>>6 horas</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Clasificación Académica -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Clasificación Académica</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Departamento</label>
                            <select name="departamento" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona un departamento</option>
                                <option value="Ingeniería en Sistemas" <?= $subject->departamento === 'Ingeniería en Sistemas' ? 'selected' : '' ?>>Ingeniería en Sistemas</option>
                                <option value="Ingeniería Industrial" <?= $subject->departamento === 'Ingeniería Industrial' ? 'selected' : '' ?>>Ingeniería Industrial</option>
                                <option value="Ingeniería Mecatrónica" <?= $subject->departamento === 'Ingeniería Mecatrónica' ? 'selected' : '' ?>>Ingeniería Mecatrónica</option>
                                <option value="Ciencias Básicas" <?= $subject->departamento === 'Ciencias Básicas' ? 'selected' : '' ?>>Ciencias Básicas</option>
                                <option value="Humanidades" <?= $subject->departamento === 'Humanidades' ? 'selected' : '' ?>>Humanidades</option>
                                <option value="Administración" <?= $subject->departamento === 'Administración' ? 'selected' : '' ?>>Administración</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre</label>
                            <select name="semestre" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el semestre</option>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>" <?= $subject->semestre == $i ? 'selected' : '' ?>><?= $i ?>° Semestre</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Materia</label>
                            <select name="tipo" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el tipo</option>
                                <option value="obligatoria" <?= $subject->tipo === 'obligatoria' ? 'selected' : '' ?>>Obligatoria</option>
                                <option value="optativa" <?= $subject->tipo === 'optativa' ? 'selected' : '' ?>>Optativa</option>
                                <option value="especialidad" <?= $subject->tipo === 'especialidad' ? 'selected' : '' ?>>Especialidad</option>
                                <option value="servicio" <?= $subject->tipo === 'servicio' ? 'selected' : '' ?>>Servicio Social</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Modalidad</label>
                            <select name="modalidad" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona la modalidad</option>
                                <option value="presencial" <?= $subject->modalidad === 'presencial' ? 'selected' : '' ?>>Presencial</option>
                                <option value="virtual" <?= $subject->modalidad === 'virtual' ? 'selected' : '' ?>>Virtual</option>
                                <option value="hibrida" <?= $subject->modalidad === 'hibrida' ? 'selected' : '' ?>>Híbrida</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Estado de la Materia -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Estado de la Materia</h2>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
                        <select name="estado" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                            <option value="activa" <?= $subject->estado === 'activa' ? 'selected' : '' ?>>Activa</option>
                            <option value="inactiva" <?= $subject->estado === 'inactiva' ? 'selected' : '' ?>>Inactiva</option>
                            <option value="suspendida" <?= $subject->estado === 'suspendida' ? 'selected' : '' ?>>Suspendida</option>
                        </select>
                    </div>
                </div>

                <!-- Asignación de Profesor -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Asignación de Profesor</h2>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Profesor Asignado</label>
                        <select name="profesor_id" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                            <option value="">Sin asignar</option>
                            <?php
                            // Aquí deberías obtener la lista de profesores desde la base de datos
                            $profesores = [
                                ['id' => 1, 'nombre' => 'Dr. Juan Pérez'],
                                ['id' => 2, 'nombre' => 'Ing. María González'],
                                ['id' => 3, 'nombre' => 'M.C. Carlos Rodríguez'],
                            ];
                            foreach ($profesores as $profesor): ?>
                                <option value="<?= $profesor['id'] ?>" <?= $subject->profesor_id == $profesor['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($profesor['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Descripción y Objetivos -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Descripción y Objetivos</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Descripción de la Materia</label>
                            <textarea name="descripcion" rows="3" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Describe brevemente el contenido y enfoque de la materia..."><?= htmlspecialchars($subject->descripcion ?? '') ?></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Objetivo General</label>
                            <textarea name="objetivo" rows="2" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="¿Qué se espera que el estudiante logre al completar esta materia?"><?= htmlspecialchars($subject->objetivo ?? '') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Prerrequisitos -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Prerrequisitos</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Selecciona las materias que deben ser aprobadas antes de cursar esta materia</p>
                    
                    <?php 
                    $prerrequisitosMateria = isset($subject->prerrequisitos) ? explode(',', $subject->prerrequisitos) : [];
                    ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <?php
                        // Aquí deberías obtener la lista de materias desde la base de datos
                        $materiasDisponibles = [
                            ['id' => 1, 'nombre' => 'Matemáticas I', 'codigo' => 'MAT101'],
                            ['id' => 2, 'nombre' => 'Física I', 'codigo' => 'FIS101'],
                            ['id' => 3, 'nombre' => 'Programación I', 'codigo' => 'PRG101'],
                            ['id' => 4, 'nombre' => 'Álgebra Lineal', 'codigo' => 'MAT201'],
                        ];
                        foreach ($materiasDisponibles as $materia): ?>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="prerrequisitos[]" value="<?= $materia['id'] ?>" 
                                       <?= in_array($materia['id'], $prerrequisitosMateria) ? 'checked' : '' ?>
                                       class="rounded border-neutral-300 dark:border-neutral-600">
                                <span class="text-sm"><?= htmlspecialchars($materia['codigo']) ?> - <?= htmlspecialchars($materia['nombre']) ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/src/plataforma/app/admin/subjects" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
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