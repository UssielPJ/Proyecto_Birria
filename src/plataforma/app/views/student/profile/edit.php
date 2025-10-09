<?php require_once __DIR__ . '/../../layouts/student.php'; ?>

<div class="py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center">
                    <i data-feather="user" class="w-8 h-8 mr-3 text-emerald-600"></i>
                    Editar Perfil
                </h1>
                <p class="text-neutral-500 dark:text-neutral-400 mt-2">Actualiza tu información personal</p>
            </div>

            <form action="/src/plataforma/app/student/profile/update" method="POST" class="space-y-6">
                <!-- Información Personal -->
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-neutral-900 dark:to-neutral-800 p-6 rounded-xl shadow-sm space-y-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-white flex items-center">
                        <i data-feather="user" class="w-6 h-6 mr-2 text-emerald-600"></i>
                        Información Personal
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Nombre Completo</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required class="w-full px-4 py-3 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Correo Electrónico</label>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required class="w-full px-4 py-3 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Teléfono</label>
                            <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" class="w-full px-4 py-3 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Fecha de Nacimiento</label>
                            <input type="date" name="birthdate" value="<?= htmlspecialchars($user['birthdate'] ?? '') ?>" class="w-full px-4 py-3 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        </div>
                    </div>
                </div>

                <!-- Información Académica -->
                <div class="bg-gradient-to-r from-teal-50 to-cyan-50 dark:from-neutral-900 dark:to-neutral-800 p-6 rounded-xl shadow-sm space-y-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-white flex items-center">
                        <i data-feather="book-open" class="w-6 h-6 mr-2 text-teal-600"></i>
                        Información Académica
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Carrera</label>
                            <div class="relative">
                                <input type="text" name="carrera" value="<?= htmlspecialchars($user['carrera'] ?? 'Ingeniería en Software') ?>" readonly class="w-full px-4 py-3 pl-10 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-700 text-neutral-500 dark:text-neutral-400 cursor-not-allowed">
                                <i data-feather="lock" class="absolute left-3 top-3.5 w-4 h-4 text-neutral-400"></i>
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2 flex items-center">
                                <i data-feather="info" class="w-3 h-3 mr-1"></i>
                                Contacta a administración para cambiar carrera
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Semestre</label>
                            <div class="relative">
                                <input type="text" name="semestre" value="<?= htmlspecialchars($user['semestre'] ?? '3') ?>" readonly class="w-full px-4 py-3 pl-10 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-700 text-neutral-500 dark:text-neutral-400 cursor-not-allowed">
                                <i data-feather="lock" class="absolute left-3 top-3.5 w-4 h-4 text-neutral-400"></i>
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2 flex items-center">
                                <i data-feather="info" class="w-3 h-3 mr-1"></i>
                                Se actualiza automáticamente
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Matrícula</label>
                            <div class="relative">
                                <input type="text" name="matricula" value="<?= htmlspecialchars($user['matricula'] ?? '2023001') ?>" readonly class="w-full px-4 py-3 pl-10 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-700 text-neutral-500 dark:text-neutral-400 cursor-not-allowed">
                                <i data-feather="lock" class="absolute left-3 top-3.5 w-4 h-4 text-neutral-400"></i>
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2 flex items-center">
                                <i data-feather="info" class="w-3 h-3 mr-1"></i>
                                No se puede modificar
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Grupo</label>
                            <div class="relative">
                                <input type="text" name="grupo" value="<?= htmlspecialchars($user['grupo'] ?? 'A') ?>" readonly class="w-full px-4 py-3 pl-10 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-700 text-neutral-500 dark:text-neutral-400 cursor-not-allowed">
                                <i data-feather="lock" class="absolute left-3 top-3.5 w-4 h-4 text-neutral-400"></i>
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-2 flex items-center">
                                <i data-feather="info" class="w-3 h-3 mr-1"></i>
                                Se asigna por administración
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Dirección -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Dirección</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Calle y Número</label>
                            <input type="text" name="street" value="<?= htmlspecialchars($user['street'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Colonia</label>
                            <input type="text" name="neighborhood" value="<?= htmlspecialchars($user['neighborhood'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Ciudad</label>
                            <input type="text" name="city" value="<?= htmlspecialchars($user['city'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
                            <input type="text" name="state" value="<?= htmlspecialchars($user['state'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Código Postal</label>
                            <input type="text" name="postal_code" value="<?= htmlspecialchars($user['postal_code'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>
                </div>

                <!-- Información de Emergencia -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información de Emergencia</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nombre del Contacto</label>
                            <input type="text" name="emergency_contact_name" value="<?= htmlspecialchars($user['emergency_contact_name'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Teléfono del Contacto</label>
                            <input type="tel" name="emergency_contact_phone" value="<?= htmlspecialchars($user['emergency_contact_phone'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Parentesco</label>
                            <input type="text" name="emergency_contact_relationship" value="<?= htmlspecialchars($user['emergency_contact_relationship'] ?? '') ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/src/plataforma/app/student/dashboard" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
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
</script>