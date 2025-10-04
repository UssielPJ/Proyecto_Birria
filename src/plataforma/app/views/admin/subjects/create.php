<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Nueva Materia</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Ingresa la información de la nueva materia</p>
            </div>

            <form action="/src/plataforma/app/admin/subjects/store" method="POST" class="space-y-6">
                <!-- Información Básica -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información Básica</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nombre de la Materia</label>
                            <input type="text" name="nombre" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Código de la Materia</label>
                            <input type="text" name="codigo" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Ej: MAT101">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Créditos</label>
                            <select name="creditos" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona los créditos</option>
                                <option value="1">1 crédito</option>
                                <option value="2">2 créditos</option>
                                <option value="3">3 créditos</option>
                                <option value="4">4 créditos</option>
                                <option value="5">5 créditos</option>
                                <option value="6">6 créditos</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Horas por Semana</label>
                            <select name="horas_semana" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona las horas</option>
                                <option value="2">2 horas</option>
                                <option value="3">3 horas</option>
                                <option value="4">4 horas</option>
                                <option value="5">5 horas</option>
                                <option value="6">6 horas</option>
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
                                <option value="Ingeniería en Sistemas">Ingeniería en Sistemas</option>
                                <option value="Ingeniería Industrial">Ingeniería Industrial</option>
                                <option value="Ingeniería Mecatrónica">Ingeniería Mecatrónica</option>
                                <option value="Ciencias Básicas">Ciencias Básicas</option>
                                <option value="Humanidades">Humanidades</option>
                                <option value="Administración">Administración</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre</label>
                            <select name="semestre" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el semestre</option>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?>° Semestre</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Materia</label>
                            <select name="tipo" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el tipo</option>
                                <option value="obligatoria">Obligatoria</option>
                                <option value="optativa">Optativa</option>
                                <option value="especialidad">Especialidad</option>
                                <option value="servicio">Servicio Social</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Modalidad</label>
                            <select name="modalidad" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona la modalidad</option>
                                <option value="presencial">Presencial</option>
                                <option value="virtual">Virtual</option>
                                <option value="hibrida">Híbrida</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Asignación de Profesor -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Asignación de Profesor</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Puedes asignar un profesor ahora o dejarlo para después</p>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Profesor Asignado</label>
                        <select name="profesor_id" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                            <option value="">Sin asignar</option>
                            <?php
                            // Aquí deberías obtener la lista de profesores desde la base de datos
                            // Por ahora, usaré algunos ejemplos
                            $profesores = [
                                ['id' => 1, 'nombre' => 'Dr. Juan Pérez'],
                                ['id' => 2, 'nombre' => 'Ing. María González'],
                                ['id' => 3, 'nombre' => 'M.C. Carlos Rodríguez'],
                            ];
                            foreach ($profesores as $profesor): ?>
                                <option value="<?= $profesor['id'] ?>"><?= htmlspecialchars($profesor['nombre']) ?></option>
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
                            <textarea name="descripcion" rows="3" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Describe brevemente el contenido y enfoque de la materia..."></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Objetivo General</label>
                            <textarea name="objetivo" rows="2" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="¿Qué se espera que el estudiante logre al completar esta materia?"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Prerrequisitos -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Prerrequisitos</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Selecciona las materias que deben ser aprobadas antes de cursar esta materia</p>
                    
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
                                <input type="checkbox" name="prerrequisitos[]" value="<?= $materia['id'] ?>" class="rounded border-neutral-300 dark:border-neutral-600">
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
                        Guardar Materia
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

    // Auto-generar código basado en departamento
    const departamentoSelect = document.querySelector('select[name="departamento"]');
    const codigoInput = document.querySelector('input[name="codigo"]');
    
    departamentoSelect.addEventListener('change', function() {
        const prefijos = {
            'Ingeniería en Sistemas': 'SIS',
            'Ingeniería Industrial': 'IND',
            'Ingeniería Mecatrónica': 'MEC',
            'Ciencias Básicas': 'CB',
            'Humanidades': 'HUM',
            'Administración': 'ADM'
        };
        
        const prefijo = prefijos[this.value];
        if (prefijo && !codigoInput.value) {
            codigoInput.value = prefijo + '101';
        }
    });
</script>