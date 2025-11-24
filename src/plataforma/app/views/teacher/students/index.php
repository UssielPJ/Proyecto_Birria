<?php
/** @var array $gruposAsignados */
?>

<div class="py-8 max-w-7xl mx-auto">

    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="users" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Gestión de Estudiantes</h2>
                <p class="opacity-90">Selecciona qué deseas gestionar para tus grupos asignados.</p>
            </div>
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 mb-6" data-aos="fade-up">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            Selecciona qué deseas gestionar
        </h3>

        <form method="GET"
              action="/src/plataforma/app/teacher/students/seleccionar"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Tipo de gestión -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tipo de gestión
                </label>
                <select name="tipo"
                        class="w-full px-3 py-2 border rounded-lg text-sm
                               bg-white dark:bg-neutral-900 border-gray-300 dark:border-neutral-700
                               focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                    <option value="">-- Elige una opción --</option>
                    <option value="calificaciones">Calificaciones</option>
                    <option value="asistencia">Asistencia</option>
                </select>
            </div>

            <!-- Grupo asignado -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Grupo asignado
                </label>
                <select name="grupo_id"
                        class="w-full px-3 py-2 border rounded-lg text-sm
                               bg-white dark:bg-neutral-900 border-gray-300 dark:border-neutral-700
                               focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                    <option value="">-- Grupos asignados --</option>

                    <?php foreach ($gruposAsignados as $g): ?>
                        <?php
                            $label = $g['nombre']
                                ?? $g['clave']
                                ?? $g['codigo']
                                ?? ('Grupo #' . ($g['id'] ?? ''));
                        ?>
                        <option value="<?= htmlspecialchars($g['id']) ?>">
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <!-- Botón -->
            <div class="md:col-span-2 flex justify-end">
                <button
                    class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-medium
                           bg-indigo-600 hover:bg-indigo-700 text-white shadow-md transition-colors">
                    <i data-feather="arrow-right-circle" class="w-4 h-4 mr-2"></i>
                    Continuar
                </button>
            </div>
        </form>
    </div>

    <!-- Nota / ayuda rápida -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-4" data-aos="fade-up" data-aos-delay="80">
        <h4 class="text-sm font-semibold text-gray-800 dark:text-white mb-2">¿Cómo funciona?</h4>
        <ul class="text-sm text-gray-600 dark:text-gray-300 list-disc list-inside space-y-1">
            <li>Elige si quieres gestionar <strong>calificaciones</strong> o <strong>asistencia</strong>.</li>
            <li>Selecciona uno de tus <strong>grupos asignados</strong>.</li>
            <li>Pulsa en <strong>Continuar</strong> para ir al módulo correspondiente.</li>
        </ul>
    </div>
</div>

<script>
    AOS.init();
    feather.replace();
</script>
