<?php require_once __DIR__ . '/../../layouts/teacher.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Editar Encuesta</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Modifica la información de la encuesta</p>
            </div>

            <form action="/src/plataforma/app/teacher/surveys/update/<?= $survey['id'] ?>" method="POST" class="space-y-6">
                <!-- Información General -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información General</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Título de la Encuesta</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($survey['title']) ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Encuesta</label>
                            <select name="type" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona un tipo</option>
                                <option value="academica" <?= $survey['type'] == 'academica' ? 'selected' : '' ?>>Académica</option>
                                <option value="docente" <?= $survey['type'] == 'docente' ? 'selected' : '' ?>>Evaluación Docente</option>
                                <option value="servicios" <?= $survey['type'] == 'servicios' ? 'selected' : '' ?>>Servicios Escolares</option>
                                <option value="satisfaccion" <?= $survey['type'] == 'satisfaccion' ? 'selected' : '' ?>>Satisfacción General</option>
                                <option value="otra" <?= $survey['type'] == 'otra' ? 'selected' : '' ?>>Otra</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Inicio</label>
                            <input type="date" name="start_date" value="<?= htmlspecialchars($survey['start_date']) ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Fin</label>
                            <input type="date" name="end_date" value="<?= htmlspecialchars($survey['end_date']) ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Descripción</label>
                        <textarea name="description" rows="3" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800"><?= htmlspecialchars($survey['description']) ?></textarea>
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_anonymous" value="1" <?= $survey['is_anonymous'] ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-700">
                            <span class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">Encuesta Anónima</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_required" value="1" <?= $survey['is_required'] ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-700">
                            <span class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">Obligatoria</span>
                        </label>
                    </div>
                </div>

                <!-- Preguntas -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Preguntas</h2>
                    <div id="questions-container" class="space-y-4">
                        <?php
                        $questions = json_decode($survey['questions'], true) ?? [];
                        $questionCount = count($questions);
                        foreach ($questions as $index => $question):
                        ?>
                        <div class="question-item bg-white dark:bg-neutral-800 p-4 rounded-lg border border-neutral-200 dark:border-neutral-700">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="font-medium">Pregunta <?= $index + 1 ?></h3>
                                <button type="button" class="remove-question text-red-500 hover:text-red-700">
                                    <i data-feather="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Texto de la Pregunta</label>
                                    <input type="text" name="questions[<?= $index ?>][text]" value="<?= htmlspecialchars($question['text']) ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Respuesta</label>
                                    <select name="questions[<?= $index ?>][type]" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                        <option value="text" <?= $question['type'] == 'text' ? 'selected' : '' ?>>Texto Libre</option>
                                        <option value="radio" <?= $question['type'] == 'radio' ? 'selected' : '' ?>>Opción Única</option>
                                        <option value="checkbox" <?= $question['type'] == 'checkbox' ? 'selected' : '' ?>>Múltiples Opciones</option>
                                        <option value="rating" <?= $question['type'] == 'rating' ? 'selected' : '' ?>>Escala (1-5)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="options-container" style="display: <?= in_array($question['type'], ['radio', 'checkbox']) ? 'block' : 'none' ?>;">
                                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Opciones de Respuesta</label>
                                <div class="space-y-2">
                                    <?php
                                    $options = $question['options'] ?? [];
                                    for ($i = 0; $i < 4; $i++):
                                    ?>
                                    <input type="text" name="questions[<?= $index ?>][options][]" value="<?= htmlspecialchars($options[$i] ?? '') ?>" placeholder="Opción <?= $i + 1 ?>" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <label class="flex items-center mt-2">
                                <input type="checkbox" name="questions[<?= $index ?>][required]" value="1" <?= $question['required'] ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-700">
                                <span class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">Pregunta Obligatoria</span>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" id="add-question" class="w-full py-2 px-4 border border-neutral-300 dark:border-neutral-700 rounded-lg text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        <i data-feather="plus" class="w-4 h-4 inline mr-2"></i>
                        Agregar Pregunta
                    </button>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/src/plataforma/app/teacher/surveys" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
                        Actualizar Encuesta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    feather.replace();

    let questionCount = <?= $questionCount ?>;

    document.getElementById('add-question').addEventListener('click', function() {
        questionCount++;
        const container = document.getElementById('questions-container');
        const questionItem = document.querySelector('.question-item').cloneNode(true);

        // Update question number
        questionItem.querySelector('h3').textContent = `Pregunta ${questionCount}`;

        // Update input names
        const inputs = questionItem.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (input.name) {
                input.name = input.name.replace(/\[\d+\]/, `[${questionCount - 1}]`);
                if (input.type === 'text' || input.type === 'checkbox') {
                    input.value = '';
                    input.checked = false;
                }
            }
        });

        // Clear options
        const options = questionItem.querySelectorAll('.options-container input');
        options.forEach(option => option.value = '');

        container.appendChild(questionItem);
        feather.replace();
    });

    // Handle question type changes
    document.addEventListener('change', function(e) {
        if (e.target.name && e.target.name.includes('[type]')) {
            const questionItem = e.target.closest('.question-item');
            const optionsContainer = questionItem.querySelector('.options-container');
            const type = e.target.value;

            if (type === 'radio' || type === 'checkbox') {
                optionsContainer.style.display = 'block';
            } else {
                optionsContainer.style.display = 'none';
            }
        }
    });

    // Handle remove question
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-question')) {
            e.target.closest('.question-item').remove();
            questionCount--;
            // Renumber questions
            document.querySelectorAll('.question-item h3').forEach((h3, index) => {
                h3.textContent = `Pregunta ${index + 1}`;
            });
        }
    });
</script>