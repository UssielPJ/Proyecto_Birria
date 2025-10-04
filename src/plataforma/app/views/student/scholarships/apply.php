<?php require_once __DIR__ . '/../../layouts/student.php'; ?>

<div class="py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center mb-2">
                    <i data-feather="gift" class="w-8 h-8 mr-3 text-emerald-600"></i>
                    Solicitar Beca
                </h1>
                <p class="text-neutral-500 dark:text-neutral-400 text-lg">Completa tu solicitud para la beca <?= htmlspecialchars($scholarship['name']) ?></p>
            </div>

            <form action="/src/plataforma/app/student/scholarships/apply/<?= $scholarship['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Información de la Beca -->
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-neutral-900 dark:to-neutral-800 p-6 rounded-xl shadow-sm">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-white flex items-center mb-6">
                        <i data-feather="gift" class="w-6 h-6 mr-2 text-emerald-600"></i>
                        Información de la Beca
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-white dark:bg-neutral-700 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">Tipo</p>
                            <p class="font-medium text-lg"><?= htmlspecialchars($scholarship['type']) ?></p>
                        </div>
                        <div class="bg-white dark:bg-neutral-700 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">Porcentaje</p>
                            <p class="font-medium text-lg"><?= htmlspecialchars($scholarship['percentage']) ?>%</p>
                        </div>
                        <div class="bg-white dark:bg-neutral-700 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-1">Fecha Límite</p>
                            <p class="font-medium text-lg"><?= date('d/m/Y', strtotime($scholarship['deadline'])) ?></p>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-neutral-700 p-4 rounded-lg shadow-sm">
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-2">Descripción</p>
                        <p class="text-sm"><?= htmlspecialchars($scholarship['description']) ?></p>
                    </div>
                </div>

                <!-- Información Personal -->
                <div class="bg-white dark:bg-neutral-700 p-6 rounded-xl shadow-sm space-y-6">
                    <h2 class="font-semibold text-xl mb-4 text-gray-800 dark:text-white flex items-center">
                        <i data-feather="user" class="w-6 h-6 mr-2 text-emerald-600"></i>
                        Información Personal
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Nombre Completo</label>
                            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Matrícula</label>
                            <input type="text" name="matricula" value="<?= htmlspecialchars($user['matricula'] ?? '2023001') ?>" required readonly class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-700 text-neutral-500 dark:text-neutral-400 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Carrera</label>
                            <input type="text" name="carrera" value="<?= htmlspecialchars($user['carrera'] ?? 'Ingeniería en Software') ?>" required readonly class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-700 text-neutral-500 dark:text-neutral-400 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre</label>
                            <input type="text" name="semestre" value="<?= htmlspecialchars($user['semestre'] ?? '3') ?>" required readonly class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-700 text-neutral-500 dark:text-neutral-400 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Promedio Actual</label>
                            <input type="number" name="average" step="0.01" min="0" max="10" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Teléfono</label>
                            <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>
                </div>

                <!-- Documentos Requeridos -->
                <div class="bg-white dark:bg-neutral-700 p-6 rounded-xl shadow-sm space-y-6">
                    <h2 class="font-semibold text-xl mb-4 text-gray-800 dark:text-white flex items-center">
                        <i data-feather="file-text" class="w-6 h-6 mr-2 text-emerald-600"></i>
                        Documentos Requeridos
                    </h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Sube los documentos solicitados en formato PDF o imagen</p>

                    <div class="space-y-4">
                        <?php
                        $documents = json_decode($scholarship['documents'], true) ?? [];
                        foreach ($documents as $index => $docName):
                        ?>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2"><?= htmlspecialchars($docName) ?></label>
                            <input type="file" name="documents[]" accept=".pdf,.jpg,.jpeg,.png" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                            <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Máximo 5MB. Formatos: PDF, JPG, PNG</p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="bg-white dark:bg-neutral-700 p-6 rounded-xl shadow-sm space-y-6">
                    <h2 class="font-semibold text-xl mb-4 text-gray-800 dark:text-white flex items-center">
                        <i data-feather="info" class="w-6 h-6 mr-2 text-emerald-600"></i>
                        Información Adicional
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">¿Por qué mereces esta beca?</label>
                            <textarea name="motivation" rows="4" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Explica por qué eres un buen candidato para esta beca..."></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Situación Económica (opcional)</label>
                            <textarea name="economic_situation" rows="3" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Describe tu situación económica si aplica..."></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Actividades Extracurriculares</label>
                            <textarea name="extracurricular" rows="3" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Menciona actividades extracurriculares, deportes, voluntariado, etc."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Declaración -->
                <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-800">
                    <div class="flex items-start gap-3">
                        <input type="checkbox" name="declaration" value="1" required class="mt-1 rounded border-neutral-300 dark:border-neutral-700">
                        <div>
                            <h3 class="font-medium text-yellow-800 dark:text-yellow-200">Declaración de Veracidad</h3>
                            <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                                Declaro que toda la información proporcionada es veraz y completa. Entiendo que cualquier falsedad en la información puede resultar en la cancelación de mi solicitud o medidas disciplinarias.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/src/plataforma/app/student/scholarships" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
                        Enviar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    feather.replace();

    // File validation
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Check file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('El archivo es demasiado grande. Máximo 5MB.');
                    e.target.value = '';
                    return;
                }

                // Check file type
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Tipo de archivo no permitido. Solo PDF, JPG, PNG.');
                    e.target.value = '';
                    return;
                }
            }
        });
    });
</script>