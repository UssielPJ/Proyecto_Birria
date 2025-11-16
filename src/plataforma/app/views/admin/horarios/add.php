
<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Agregar Clase al Horario</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Programa una nueva clase en el horario</p>
            </div>

            <form action="/src/plataforma/app/admin/schedule/store" method="POST" class="space-y-6">
                <!-- Información del Periodo y Grupo -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información del Periodo</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Periodo Académico</label>
                            <select name="periodo" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el periodo</option>
                                <option value="2025-1">2025-1</option>
                                <option value="2025-2">2025-2</option>
                                <option value="2026-1">2026-1</option>
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
                                    <option value="<?= $grupo['id'] ?>"><?= htmlspecialchars($grupo['nombre']) ?></option>
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
                                    <option value="<?= $materia['id'] ?>" data-creditos="<?= $materia['creditos'] ?>">
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
                                    <option value="<?= $profesor['id'] ?>">
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
                                <option value="1">Lunes</option>
                                <option value="2">Martes</option>
                                <option value="3">Miércoles</option>
                                <option value="4">Jueves</option>
                                <option value="5">Viernes</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Hora de Inicio</label>
                            <select name="hora_inicio" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona la hora</option>
                                <?php for ($i = 7; $i <= 21; $i++): ?>
                                    <option value="<?= sprintf('%02d:00', $i) ?>"><?= sprintf('%02d:00', $i) ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Hora de Fin</label>
                            <select name="hora_fin" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona la hora</option>
                                <?php for ($i = 8; $i <= 22; $i++): ?>
                                    <option value="<?= sprintf('%02d:00', $i) ?>"><?= sprintf('%02d:00', $i) ?></option>
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
                                    <option value="<?= $aula['id'] ?>">
                                        <?= htmlspecialchars($aula['nombre']) ?> - <?= htmlspecialchars($aula['tipo']) ?> (<?= $aula['capacidad'] ?> personas)
                                    </option>
                                <?php endforeach; ?>
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

                <!-- Información Adicional -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información Adicional</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Clase</label>
                            <select name="tipo_clase" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el tipo</option>
                                <option value="teorica">Teórica</option>
                                <option value="practica">Práctica</option>
                                <option value="laboratorio">Laboratorio</option>
                                <option value="taller">Taller</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Duración (horas)</label>
                            <select name="duracion" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona la duración</option>
                                <option value="1">1 hora</option>
                                <option value="2">2 horas</option>
                                <option value="3">3 horas</option>
                                <option value="4">4 horas</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Observaciones</label>
                        <textarea name="observaciones" rows="3" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Notas adicionales sobre esta clase..."></textarea>
                    </div>
                </div>

                <!-- Repetir Clase -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Programación Recurrente</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">¿Esta clase se repite semanalmente durante todo el semestre?</p>
                    
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="recurrente" value="si" checked class="text-primary-600">
                            <span class="text-sm">Sí, repetir semanalmente</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="recurrente" value="no" class="text-primary-600">
                            <span class="text-sm">No, solo esta vez</span>
                        </label>
                    </div>
                    
                    <div id="fechas-recurrencia" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Inicio</label>
                            <input type="date" name="fecha_inicio" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Fin</label>
                            <input type="date" name="fecha_fin" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/src/plataforma/app/admin/schedule" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
                        Programar Clase
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

    // Mostrar/ocultar campos de recurrencia
    const recurrenteRadios = document.querySelectorAll('input[name="recurrente"]');
    const fechasRecurrencia = document.getElementById('fechas-recurrencia');
    
    recurrenteRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'si') {
                fechasRecurrencia.style.display = 'grid';
            } else {
                fechasRecurrencia.style.display = 'none';
            }
        });
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
            horaFinSelect.value = sprintf('%02d:00', fin);
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