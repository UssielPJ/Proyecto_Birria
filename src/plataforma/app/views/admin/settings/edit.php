<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Configuración del Sistema</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Modifica la configuración general del sistema</p>
            </div>

            <form action="/src/plataforma/app/admin/settings/update" method="POST" class="space-y-6">
                <!-- Información de la Institución -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información de la Institución</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nombre de la Institución</label>
                            <input type="text" name="institution_name" value="<?= htmlspecialchars($settings['institution_name'] ?? 'UTSC') ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Dirección</label>
                            <input type="text" name="institution_address" value="<?= htmlspecialchars($settings['institution_address'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Teléfono</label>
                            <input type="tel" name="institution_phone" value="<?= htmlspecialchars($settings['institution_phone'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Correo Electrónico</label>
                            <input type="email" name="institution_email" value="<?= htmlspecialchars($settings['institution_email'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Sitio Web</label>
                            <input type="url" name="institution_website" value="<?= htmlspecialchars($settings['institution_website'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Director</label>
                            <input type="text" name="institution_director" value="<?= htmlspecialchars($settings['institution_director'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>
                </div>

                <!-- Configuración Académica -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Configuración Académica</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Calificación Mínima para Aprobar</label>
                            <input type="number" name="minimum_passing_grade" min="0" max="100" value="<?= htmlspecialchars($settings['minimum_passing_grade'] ?? '70') ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre Actual</label>
                            <select name="current_semester" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="2025-1" <?= ($settings['current_semester'] ?? '2025-1') == '2025-1' ? 'selected' : '' ?>>2025-1</option>
                                <option value="2024-2" <?= ($settings['current_semester'] ?? '2025-1') == '2024-2' ? 'selected' : '' ?>>2024-2</option>
                                <option value="2024-1" <?= ($settings['current_semester'] ?? '2025-1') == '2024-1' ? 'selected' : '' ?>>2024-1</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Año Escolar</label>
                            <input type="number" name="school_year" min="2020" max="2030" value="<?= htmlspecialchars($settings['school_year'] ?? '2025') ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Moneda</label>
                            <select name="currency" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="MXN" <?= ($settings['currency'] ?? 'MXN') == 'MXN' ? 'selected' : '' ?>>MXN (Peso Mexicano)</option>
                                <option value="USD" <?= ($settings['currency'] ?? 'MXN') == 'USD' ? 'selected' : '' ?>>USD (Dólar)</option>
                                <option value="EUR" <?= ($settings['currency'] ?? 'MXN') == 'EUR' ? 'selected' : '' ?>>EUR (Euro)</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="allow_self_enrollment" value="1" <?= ($settings['allow_self_enrollment'] ?? 0) ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-700">
                            <span class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">Permitir auto-inscripción</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="require_email_verification" value="1" <?= ($settings['require_email_verification'] ?? 1) ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-700">
                            <span class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">Requerir verificación de email</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="enable_notifications" value="1" <?= ($settings['enable_notifications'] ?? 1) ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-700">
                            <span class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">Habilitar notificaciones</span>
                        </label>
                    </div>
                </div>

                <!-- Configuración del Sistema -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Configuración del Sistema</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Zona Horaria</label>
                            <select name="timezone" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="America/Mexico_City" <?= ($settings['timezone'] ?? 'America/Mexico_City') == 'America/Mexico_City' ? 'selected' : '' ?>>America/Mexico_City</option>
                                <option value="America/New_York" <?= ($settings['timezone'] ?? 'America/Mexico_City') == 'America/New_York' ? 'selected' : '' ?>>America/New_York</option>
                                <option value="Europe/Madrid" <?= ($settings['timezone'] ?? 'America/Mexico_City') == 'Europe/Madrid' ? 'selected' : '' ?>>Europe/Madrid</option>
                                <option value="Asia/Tokyo" <?= ($settings['timezone'] ?? 'America/Mexico_City') == 'Asia/Tokyo' ? 'selected' : '' ?>>Asia/Tokyo</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Idioma Predeterminado</label>
                            <select name="default_language" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="es" <?= ($settings['default_language'] ?? 'es') == 'es' ? 'selected' : '' ?>>Español</option>
                                <option value="en" <?= ($settings['default_language'] ?? 'es') == 'en' ? 'selected' : '' ?>>English</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Límite de Archivo (MB)</label>
                            <input type="number" name="max_file_size" min="1" max="100" value="<?= htmlspecialchars($settings['max_file_size'] ?? '10') ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tiempo de Sesión (minutos)</label>
                            <input type="number" name="session_timeout" min="15" max="480" value="<?= htmlspecialchars($settings['session_timeout'] ?? '60') ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="maintenance_mode" value="1" <?= ($settings['maintenance_mode'] ?? 0) ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-700">
                            <span class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">Modo de Mantenimiento</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="debug_mode" value="1" <?= ($settings['debug_mode'] ?? 0) ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-700">
                            <span class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">Modo Debug</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/src/plataforma/app/admin/settings" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
                        Guardar Configuración
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    feather.replace();
</script>