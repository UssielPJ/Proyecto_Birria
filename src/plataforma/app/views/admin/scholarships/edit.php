<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Editar Beca</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Modifica la información de la beca</p>
            </div>

            <form action="/src/plataforma/app/admin/scholarships/update/<?= $scholarship['id'] ?>" method="POST" class="space-y-6">
                <!-- Información General -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información General</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nombre de la Beca</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($scholarship['name']) ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Beca</label>
                            <select name="type" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona un tipo</option>
                                <option value="academica" <?= $scholarship['type'] == 'academica' ? 'selected' : '' ?>>Excelencia Académica</option>
                                <option value="deportiva" <?= $scholarship['type'] == 'deportiva' ? 'selected' : '' ?>>Deportiva</option>
                                <option value="socioeconomica" <?= $scholarship['type'] == 'socioeconomica' ? 'selected' : '' ?>>Socioeconómica</option>
                                <option value="otra" <?= $scholarship['type'] == 'otra' ? 'selected' : '' ?>>Otra</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Porcentaje de Descuento (%)</label>
                            <input type="number" name="percentage" min="1" max="100" value="<?= htmlspecialchars($scholarship['percentage']) ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha Límite</label>
                            <input type="date" name="deadline" value="<?= htmlspecialchars($scholarship['deadline']) ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Descripción</label>
                        <textarea name="description" rows="3" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800"><?= htmlspecialchars($scholarship['description']) ?></textarea>
                    </div>
                </div>

                <!-- Requisitos -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Requisitos</h2>

                    <div class="space-y-3">
                        <?php
                        $requirements = json_decode($scholarship['requirements'], true) ?? [];
                        for ($i = 0; $i < 5; $i++):
                        ?>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Requisito <?= $i + 1 ?></label>
                            <input type="text" name="requirements[]" value="<?= htmlspecialchars($requirements[$i] ?? '') ?>" <?= $i < 1 ? 'required' : '' ?> class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Documentos Requeridos -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Documentos Requeridos</h2>

                    <div class="space-y-3">
                        <?php
                        $documents = json_decode($scholarship['documents'], true) ?? [];
                        for ($i = 0; $i < 3; $i++):
                        ?>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Documento <?= $i + 1 ?></label>
                            <input type="text" name="documents[]" value="<?= htmlspecialchars($documents[$i] ?? '') ?>" <?= $i < 1 ? 'required' : '' ?> class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/src/plataforma/app/admin/scholarships" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
                        Actualizar Beca
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    feather.replace();
</script>