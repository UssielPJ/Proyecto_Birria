<?php
// Variables esperadas desde el controlador:
// $user, $task, $submission
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-full">
                    <i data-feather="upload" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold">Entregar Tarea</h2>
                    <p class="opacity-900"><?= htmlspecialchars($task->course_name) ?> (<?= htmlspecialchars($task->course_code) ?>)</p>
                </div>
            </div>
            <a href="/src/plataforma/app/tareas/view/<?= $task->id ?>" class="inline-flex items-center gap-2 rounded-lg bg-white/15 hover:bg-white/25 px-3 py-2 text-sm transition">
                <i data-feather="arrow-left" class="w-4 h-4"></i> Volver a detalles
            </a>
        </div>
    </div>

    <?php if ($submission): ?>
        <!-- Alerta si ya se ha entregado -->
        <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 mb-6" data-aos="fade-up">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i data-feather="check-circle" class="h-5 w-5 text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700 dark:text-green-300">
                        Ya has entregado esta tarea el <?= date('d/m/Y H:i', strtotime($submission->submission_date)) ?>.
                        <?php if (!isset($submission->grade)): ?>
                            Tu entrega está siendo revisada por el profesor.
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Detalles de la entrega existente -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 mb-6" data-aos="fade-up">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Tu entrega</h3>
            <div class="bg-gray-50 dark:bg-neutral-700 rounded-lg p-4">
                <div class="mb-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Fecha de entrega:</p>
                    <p class="text-gray-800 dark:text-gray-200"><?= date('d/m/Y H:i', strtotime($submission->submission_date)) ?></p>
                </div>
                <?php if (!empty($submission->comments)): ?>
                    <div class="mb-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Tus comentarios:</p>
                        <p class="text-gray-800 dark:text-gray-200"><?= htmlspecialchars($submission->comments) ?></p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($submission->file_path)): ?>
                    <div class="mb-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Archivo entregado:</p>
                        <a href="<?= htmlspecialchars($submission->file_path) ?>" target="_blank" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                            <i data-feather="paperclip" class="w-4 h-4"></i>
                            Ver archivo
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <!-- Alerta de fecha límite -->
        <?php 
        $now = new DateTime();
        $dueDate = new DateTime($task->due_at);
        $isOverdue = $now > $dueDate;
        $daysLeft = $now->diff($dueDate)->days;
        ?>
        <?php if ($isOverdue): ?>
            <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 mb-6" data-aos="fade-up">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i data-feather="alert-triangle" class="h-5 w-5 text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 dark:text-red-300">
                            Esta tarea venció hace <?= $daysLeft ?> días. Comunícate con tu profesor para ver si aún puedes entregarla.
                        </p>
                    </div>
                </div>
            </div>
        <?php elseif ($daysLeft <= 2): ?>
            <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 p-4 mb-6" data-aos="fade-up">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i data-feather="alert-triangle" class="h-5 w-5 text-amber-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-amber-700 dark:text-amber-300">
                            ¡Atención! Esta tarea vence en <?= $daysLeft ?> días.
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Formulario de entrega -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6" data-aos="fade-up">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">Completa los siguientes campos para entregar tu tarea</h3>

            <form action="/src/plataforma/app/tareas/store/<?= $task->id ?>" method="post" enctype="multipart/form-data">
                <!-- Información de la tarea -->
                <div class="bg-gray-50 dark:bg-neutral-700 rounded-lg p-4 mb-6">
                    <h4 class="font-medium text-gray-800 dark:text-white mb-2"><?= htmlspecialchars($task->title) ?></h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-2"><?= nl2br(htmlspecialchars($task->description ?? 'Sin descripción')) ?></p>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
                        Fecha de entrega: <?= date('d/m/Y H:i', strtotime($task->due_at)) ?>
                    </div>
                </div>

                <!-- Comentarios -->
                <div class="mb-6">
                    <label for="comments" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Comentarios (opcional)
                    </label>
                    <textarea id="comments" name="comments" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-neutral-700 dark:text-white"
                              placeholder="Añade cualquier comentario o nota para tu profesor..."></textarea>
                </div>

                <!-- Archivo -->
                <div class="mb-6">
                    <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Archivo (opcional)
                    </label>
                    <div class="flex items-center justify-center w-full">
                        <label for="file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i data-feather="upload-cloud" class="w-8 h-8 mb-3 text-gray-400"></i>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-semibold">Haz clic para subir</span> o arrastra y suelta
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG (máx. 10MB)
                                </p>
                            </div>
                            <input id="file" name="file" type="file" class="hidden" />
                        </label>
                    </div>
                    <p id="file-name" class="mt-2 text-sm text-gray-500 dark:text-gray-400"></p>
                </div>

                <!-- Botones -->
                <div class="flex justify-end">
                    <a href="/src/plataforma/app/tareas/view/<?= $task->id ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i data-feather="upload" class="w-4 h-4 mr-2"></i>
                        Entregar tarea
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>

<script>
    AOS.init();
    feather.replace();

    // Vista previa del nombre del archivo
    document.getElementById('file').addEventListener('change', function() {
        const fileName = this.files[0] ? this.files[0].name : '';
        document.getElementById('file-name').textContent = fileName ? `Archivo seleccionado: ${fileName}` : '';
    });
</script>
