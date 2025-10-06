<?php
// Guard de acceso
if (session_status() === PHP_SESSION_NONE) session_start();
if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
  header('Location: /src/plataforma/'); exit;
}

// Obtener lista de carreras
$carreras = db()->query("SELECT DISTINCT carrera FROM alumnos WHERE carrera IS NOT NULL")->fetchAll(PDO::FETCH_COLUMN);
?>

<main class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-2"><?= isset($solicitud) ? 'Editar Solicitud' : 'Nueva Solicitud' ?></h1>
        <p class="text-neutral-500 dark:text-neutral-400"><?= isset($solicitud) ? 'Modifica los datos del alumno y su solicitud.' : 'Ingresa los datos del alumno y su solicitud.' ?></p>
    </div>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

    <form method="POST" action="/src/plataforma/solicitudes/guardar" class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
        <?php if (isset($solicitud)): ?>
            <input type="hidden" name="solicitud_id" value="<?= $solicitud['id'] ?>">
        <?php endif; ?>
        <div class="space-y-6">
            <!-- Datos del alumno -->
            <div class="border-b border-neutral-200 dark:border-neutral-700 pb-6">
                <h2 class="text-lg font-medium mb-4">Datos del Alumno</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                            Nombre completo
                        </label>
                        <input type="text" name="nombre" id="nombre" required
                                value="<?= htmlspecialchars($solicitud['nombre'] ?? '') ?>"
                                class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                            Correo electrónico
                        </label>
                        <input type="email" name="email" id="email" required
                                value="<?= htmlspecialchars($solicitud['email'] ?? '') ?>"
                                class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="telefono" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                            Teléfono
                        </label>
                        <input type="tel" name="telefono" id="telefono" required
                                value="<?= htmlspecialchars($solicitud['telefono'] ?? '') ?>"
                                class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="carrera" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                            Carrera
                        </label>
                        <select name="carrera" id="carrera" required
                                class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Selecciona una carrera</option>
                            <?php foreach ($carreras as $carrera): ?>
                                <option value="<?= htmlspecialchars($carrera) ?>" <?= ($solicitud['carrera'] ?? '') === $carrera ? 'selected' : '' ?>><?= htmlspecialchars($carrera) ?></option>
                            <?php endforeach; ?>
                            <option value="otro">Otra carrera...</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Datos de la solicitud -->
            <div>
                <h2 class="text-lg font-medium mb-4">Datos de la Solicitud</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="periodo" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                            Periodo
                        </label>
                        <select name="periodo" id="periodo" required
                                class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Selecciona un periodo</option>
                            <option value="2025-1" <?= ($solicitud['periodo'] ?? '') === '2025-1' ? 'selected' : '' ?>>2025-1</option>
                            <option value="2025-2" <?= ($solicitud['periodo'] ?? '') === '2025-2' ? 'selected' : '' ?>>2025-2</option>
                            <option value="2026-1" <?= ($solicitud['periodo'] ?? '') === '2026-1' ? 'selected' : '' ?>>2026-1</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                            Estado de documentos
                        </label>
                        <div class="mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="documentos_completos" <?= ($solicitud['documentos_completos'] ?? 0) ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-600 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <span class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">Documentación completa</span>
                            </label>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label for="observaciones" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                            Observaciones
                        </label>
                        <textarea name="observaciones" id="observaciones" rows="3"
                                  class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"><?= htmlspecialchars($solicitud['observaciones'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="/src/plataforma/solicitudes" 
               class="bg-white dark:bg-neutral-700 px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-600">
                Cancelar
            </a>
            <button type="submit" 
                    class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2">
                <i data-feather="save"></i>
                Guardar solicitud
            </button>
        </div>
    </form>
</main>

<script>
    // Inicializar los íconos
    feather.replace();

    // Manejar la opción "Otra carrera"
    const carreraSelect = document.getElementById('carrera');
    carreraSelect.addEventListener('change', function() {
        if (this.value === 'otro') {
            const nuevaCarrera = prompt('Ingresa el nombre de la carrera:');
            if (nuevaCarrera) {
                // Crear nueva opción
                const option = new Option(nuevaCarrera, nuevaCarrera, true, true);
                this.add(option);
            } else {
                this.value = ''; // Reset si se cancela
            }
        }
    });
</script>