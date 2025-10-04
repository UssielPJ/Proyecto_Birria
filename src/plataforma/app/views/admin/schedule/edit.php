<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Editar Clase del Horario</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Modifica la información de la clase programada</p>
            </div>

            <form action="/src/plataforma/app/admin/schedule/update/<?= $schedule->id ?>" method="POST" class="space-y-6">
                <!-- Información del Periodo y Grupo -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información del Periodo</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Periodo Académico</label>
                            <select name="periodo" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el periodo</option>
                                <option value="2025-1" <?= $schedule->periodo === '2025-1' ? 'selected' : '' ?>>2025-1</option>
                                <option value="2025-2" <?= $schedule->periodo === '2025-2' ? 'selected' : '' ?>>2025-2</option>
                                <option value="2026-1" <?= $schedule->periodo === '2026-1' ? 'selected' : '' ?>>2026-1</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Grupo</label>
                            <select name="grupo_id" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona un grupo</option>
                                <?php
                                // Aquí deberías obtener la lista de grupos desde la base de datos
                                $grupos = [
                                    ['id' => 1, 'nombre' => 'SIS-1A', 'carrera' => 'Ing. en Sistemas'],
                                    ['id' => 2, 'nombre' => 'SIS-1B', 'carrera' => 'Ing. en Sistemas'],
                                    ['id' => 3, 'nombre' => 'IND-1A', 'carrera' => 'Ing. Industrial'],
                                    ['id' => 4, 'nombre' => 'MEC-1A', 'carrera' => 'Ing. Mecatrónica'],
                                ];
                                $carrera_actual = '';
                                foreach ($grupos as $grupo):
                                    if ($grupo['carrera'] !== $carrera_actual):
                                        if ($carrera_actual !== '') echo '</optgroup>';
                                        echo '<optgroup label="' . htmlspecialchars($grupo['carrera']) . '">';
                                        $carrera_actual = $grupo['carrera'];
                                    endif;
                                ?>
                                    <option value="<?= $grupo['id'] ?>" <?= $schedule->grupo_id == $grupo['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($grupo['nombre']) ?>
                                    </option>
                                <?php 
                                endforeach;
                                if ($carrera_actual !== '') echo '</optgroup>';
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Información de la Materia -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Materia y Profesor</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Materia</label>
                            <select name="materia_id" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona una materia</option>
                                <?php
                                // Aquí deberías obtener la lista de materias desde la base de datos
                                $materias = [
                                    ['id' => 1, 'nombre' => 'Matemáticas I', 'codigo' => 'MAT101', 'creditos' => 4],
                                    ['id' => 2, 'nombre' => 'Programación I', 'codigo' => 'PRG101', 'creditos' => 5],
                                    ['id' => 3, 'nombre' => 'Física I', 'codigo' => 'FIS101', 'creditos' => 4],
                                    ['id' => 4, 'nombre' => 'Inglés I', 'codigo' => 'ING101', 'creditos' => 3],
                                ];
                                foreach ($materias as $materia): ?>
                                    <option value="<?= $materia['id'] ?>" <?= $schedule->materia_id == $materia['id'] ? 'selected' : '' ?> data-creditos="<?= $materia['creditos'] ?>">
                                        <?= htmlspecialchars($materia['codigo']) ?> - <?= htmlspecialchars($materia['nombre']) ?> (<?= $materia['creditos'] ?> créditos)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Profesor</label>
                            <select name="profesor_id" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona un profesor</option>
                                <?php
                                // Aquí deberías obtener la lista de profesores desde la base de datos
                                $profesores = [
                                    ['id' => 1, 'nombre' => 'Dr. Juan Pérez', 'departamento' => 'Ciencias Básicas'],
                                    ['id' => 2, 'nombre' => 'Ing. María González', 'departamento' => 'Ing. en Sistemas'],
                                    ['id' => 3, 'nombre' => 'M.C. Carlos Rodríguez', 'departamento' => 'Ing. Industrial'],
                                ];
                                foreach ($profesores as $profesor): ?>
                                    <option value="<?= $profesor['id'] ?>" <?= $schedule->profesor_id == $profesor['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($profesor['nombre']) ?> - <?= htmlspecialchars($profesor['departamento']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Horario -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Horario de la Clase</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Día de la Semana</label>
                            <select name="dia" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el día</option>
                                <option value="1" <?= $schedule->dia == '1' ? 'selected' : '' ?>>Lunes</option>
                                <option value="2" <?= $schedule->dia == '2' ? 'selected' : '' ?>>Martes</option>
                                <option value="3" <?= $schedule->dia == '3' ? 'selected' : '' ?>>Miércoles</option>
                                <option value="4" <?= $schedule->dia == '4' ? 'selected' : '' ?>>Jueves</option>
                                <option value="5" <?= $schedule->dia == '5' ? 'selected' : '' ?>>Viernes</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Hora de Inicio</label>
                            <select name="hora_inicio" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona la hora</option>
                                <?php for ($i = 7; $i <= 21; $i++): 
                                    $hora = sprintf('%02d:00', $i);
                                ?>
                                    <option value="<?= $hora ?>" <?= $schedule->hora_inicio === $hora ? 'selected' : '' ?>><?= $hora ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Hora de Fin</label>
                            <select name="hora_fin" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona la hora</option>
                                <?php for ($i = 8; $i <= 22; $i++): 
                                    $hora = sprintf('%02d:00', $i);
                                ?>
                                    <option value="<?= $hora ?>" <?= $schedule->hora_fin === $hora ? 'selected' : '' ?>><?= $hora ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Aula y Modalidad -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Ubicación y Modalidad</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Aula</label>
                            <select name="aula_id" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona un aula</option>
                                <?php
                                // Aquí deberías obtener la lista de aulas desde la base de datos
                                $aulas = [
                                    ['id' => 1, 'nombre' => 'A-101', 'capacidad' => 30, 'tipo' => 'Aula'],
                                    ['id' => 2, 'nombre' => 'LAB-SIS-1', 'capacidad' => 25, 'tipo' => 'Laboratorio'],
                                    ['id' => 3, 'nombre' => 'A-102', 'capacidad' => 35, 'tipo' => 'Aula'],
                                    ['id' => 4, 'nombre' => 'LAB-IND-1', 'capacidad' => 20, 'tipo' => 'Laboratorio'],
                                ];
                                foreach ($aulas as $aula): ?>
                                    <option value="<?= $aula['id'] ?>" <?= $schedule->aula_id == $aula['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($aula['nombre']) ?> - <?= htmlspecialchars($aula['tipo']) ?> (<?= $aula['capacidad'] ?> personas)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Modalidad</label>
                            <select name="modalidad" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona la modalidad</option>
                                <option value="presencial" <?= $schedule->modalidad === 'presencial' ? 'selected' : '' ?>>Presencial</option>
                                <option value="virtual" <?= $schedule->modalidad === 'virtual' ? 'selected' : '' ?>>Virtual</option>
                                <option value="hibrida" <?= $schedule->modalidad === 'hibrida' ? 'selected' : '' ?>>Híbrida</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Estado de la Clase -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Estado de la Clase</h2>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
                        <select name="estado" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                            <option value="activa" <?= $schedule->estado === 'activa' ? 'selected' : '' ?>>Activa</option>
                            <option value="suspendida" <?= $schedule->estado === 'suspendida' ? 'selected' : '' ?>>Suspendida</option>
                            <option value="cancelada" <?= $schedule->estado === 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                        </select>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información Adicional</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Clase</label>
                            <select name="tipo_clase" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el tipo</option>
                                <option value="teorica" <?= $schedule->tipo_clase === 'teorica' ? 'selected' : '' ?>>Teórica</option>
                                <option value="practica" <?= $schedule->tipo_clase === 'practica' ? 'selected' : '' ?>>Práctica</option>
                                <option value="laboratorio" <?= $schedule->tipo_clase === 'laboratorio' ? 'selected' : '' ?>>Laboratorio</option>
                                <option value="taller" <?= $schedule->tipo_clase === 'taller' ? 'selected' : '' ?>>Taller</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Duración (horas)</label>
                            <select name="duracion" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona la duración</option>
                                <option value="1" <?= $schedule->duracion == '1' ? 'selected' : '' ?>>1 hora</option>
                                <option value="2" <?= $schedule->duracion == '2' ? 'selected' : '' ?>>2 horas</option>
                                <option value="3" <?= $schedule->duracion == '3' ? 'selected' : '' ?>>3 horas</option>
                                <option value="4" <?= $schedule->duracion == '4' ? 'selected' : '' ?>>4 horas</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Observaciones</label>
                        <textarea name="observaciones" rows="3" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Notas adicionales sobre esta clase..."><?= htmlspecialchars($schedule->observaciones ?? '') ?></textarea>
                    </div>
                </div>

                <!-- Fechas de Vigencia -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Fechas de Vigencia</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Periodo en el que esta clase está programada</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" value="<?= htmlspecialchars($schedule->fecha_inicio ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Fin</label>
                            <input type="date" name="fecha_fin" value="<?= htmlspecialchars($schedule->fecha_fin ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/src/plataforma/app/admin/schedule" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
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
        const horaInicio = form.querySelector('select[name="hora_inicio"]').value;
        const horaFin = form.querySelector('select[name="hora_fin"]').value;
        
        if (horaInicio && horaFin) {
            const inicio = parseInt(horaInicio.split(':')[0]);
            const fin = parseInt(horaFin.split(':')[0]);
            
            if (fin <= inicio) {
                e.preventDefault();
                alert('La hora de fin debe ser posterior a la hora de inicio');
                return;
            }
        }
    });

    // Auto-calcular hora de fin basada en duración
    const duracionSelect = document.querySelector('select[name="duracion"]');
    const horaInicioSelect = document.querySelector('select[name="hora_inicio"]');
    const horaFinSelect = document.querySelector('select[name="hora_fin"]');
    
    function calcularHoraFin() {
        const horaInicio = horaInicioSelect.value;
        const duracion = parseInt(duracionSelect.value);
        
        if (horaInicio && duracion) {
            const inicio = parseInt(horaInicio.split(':')[0]);
            const fin = inicio + duracion;
            if (fin <= 22) { // Validar que no exceda las 22:00
                horaFinSelect.value = sprintf('%02d:00', fin);
            }
        }
    }
    
    duracionSelect.addEventListener('change', calcularHoraFin);
    horaInicioSelect.addEventListener('change', calcularHoraFin);
    
    function sprintf(format, ...args) {
        return format.replace(/%(\d*)d/g, (match, width) => {
            const num = args.shift();
            return width ? num.toString().padStart(parseInt(width), '0') : num.toString();
        });
    }
</script>