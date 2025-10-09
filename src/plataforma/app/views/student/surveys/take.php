<?php require_once __DIR__ . '/../../layouts/student.php'; ?>

<div class="py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white flex items-center mb-2">
                    <i data-feather="clipboard" class="w-8 h-8 mr-3 text-emerald-600"></i>
                    Encuesta: <?= htmlspecialchars($survey['title']) ?>
                </h1>
                <p class="text-neutral-500 dark:text-neutral-400 text-lg mt-2"><?= htmlspecialchars($survey['description']) ?></p>
                <div class="flex items-center gap-6 mt-6 text-sm text-neutral-500 dark:text-neutral-400 bg-gray-50 dark:bg-neutral-700 p-4 rounded-lg">
                    <div class="flex items-center">
                        <i data-feather="tag" class="w-4 h-4 mr-2"></i>
                        <span>Tipo: <?= htmlspecialchars($survey['type']) ?></span>
                    </div>
                    <div class="flex items-center">
                        <i data-feather="calendar" class="w-4 h-4 mr-2"></i>
                        <span>Fecha límite: <?= date('d/m/Y', strtotime($survey['end_date'])) ?></span>
                    </div>
                    <?php if ($survey['is_anonymous']): ?>
                        <div class="flex items-center">
                            <i data-feather="shield" class="w-4 h-4 mr-2 text-green-600"></i>
                            <span class="text-green-600 dark:text-green-400">Anónima</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <form action="/src/plataforma/app/student/surveys/submit/<?= $survey['id'] ?>" method="POST" class="space-y-6">
                <?php
                $questions = json_decode($survey['questions'], true) ?? [];
                foreach ($questions as $index => $question):
                ?>
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-neutral-900 dark:to-neutral-800 p-6 rounded-xl shadow-sm">
                    <div class="mb-6">
                        <h3 class="font-medium text-lg text-neutral-900 dark:text-white mb-2 flex items-start">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200 mr-3 flex-shrink-0">
                                <?= ($index + 1) ?>
                            </span>
                            <span><?= htmlspecialchars($question['text']) ?></span>
                            <?php if ($question['required']): ?>
                                <span class="text-red-500 ml-2">*</span>
                            <?php endif; ?>
                        </h3>
                    </div>

                    <div class="space-y-4 ml-11">
                        <?php if ($question['type'] === 'text'): ?>
                            <textarea name="answers[<?= $index ?>]" rows="4" <?= $question['required'] ? 'required' : '' ?> class="w-full px-4 py-3 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all" placeholder="Escribe tu respuesta aquí..."></textarea>

                        <?php elseif ($question['type'] === 'radio'): ?>
                            <?php
                            $options = $question['options'] ?? [];
                            foreach ($options as $optionIndex => $option):
                            ?>
                            <label class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700 cursor-pointer transition-colors">
                                <input type="radio" name="answers[<?= $index ?>]" value="<?= htmlspecialchars($option) ?>" <?= $question['required'] ? 'required' : '' ?> class="rounded-full border-neutral-300 dark:border-neutral-700 text-emerald-600 focus:ring-emerald-500">
                                <span class="text-neutral-700 dark:text-neutral-300"><?= htmlspecialchars($option) ?></span>
                            </label>
                            <?php endforeach; ?>

                        <?php elseif ($question['type'] === 'checkbox'): ?>
                            <?php
                            $options = $question['options'] ?? [];
                            foreach ($options as $optionIndex => $option):
                            ?>
                            <label class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700 cursor-pointer transition-colors">
                                <input type="checkbox" name="answers[<?= $index ?>][]" value="<?= htmlspecialchars($option) ?>" class="rounded border-neutral-300 dark:border-neutral-700 text-emerald-600 focus:ring-emerald-500">
                                <span class="text-neutral-700 dark:text-neutral-300"><?= htmlspecialchars($option) ?></span>
                            </label>
                            <?php endforeach; ?>

                        <?php elseif ($question['type'] === 'rating'): ?>
                            <div class="flex items-center justify-between p-4 bg-white dark:bg-neutral-700 rounded-lg">
                                <span class="text-sm text-neutral-600 dark:text-neutral-400">Muy malo</span>
                                <div class="flex items-center space-x-2">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <label class="flex flex-col items-center space-y-1 cursor-pointer group">
                                        <input type="radio" name="answers[<?= $index ?>]" value="<?= $i ?>" <?= $question['required'] ? 'required' : '' ?> class="sr-only peer">
                                        <span class="w-10 h-10 rounded-full bg-gray-200 dark:bg-neutral-600 flex items-center justify-center text-sm font-medium text-gray-600 dark:text-gray-400 peer-checked:bg-emerald-500 peer-checked:text-white transition-all group-hover:scale-110">
                                            <?= $i ?>
                                        </span>
                                    </label>
                                    <?php endfor; ?>
                                </div>
                                <span class="text-sm text-neutral-600 dark:text-neutral-400">Excelente</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Confirmación -->
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div class="flex items-start gap-3">
                        <input type="checkbox" name="confirmation" value="1" required class="mt-1 rounded border-neutral-300 dark:border-neutral-700">
                        <div>
                            <h3 class="font-medium text-blue-800 dark:text-blue-200">Confirmación</h3>
                            <p class="text-sm text-blue-700 dark:text-blue-300 mt-1">
                                Confirmo que he respondido todas las preguntas de manera honesta y completa. Una vez enviada, no podré modificar mis respuestas.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/src/plataforma/app/student/surveys" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
                        Enviar Encuesta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    feather.replace();

    // Auto-save progress (optional)
    let autoSaveTimer;
    const form = document.querySelector('form');

    function autoSave() {
        // Here you could implement auto-save functionality
        // For now, just clear any existing timer and set a new one
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(() => {
            console.log('Auto-saving survey progress...');
            // Implement auto-save logic here
        }, 30000); // Auto-save every 30 seconds
    }

    // Add event listeners for auto-save
    form.addEventListener('input', autoSave);
    form.addEventListener('change', autoSave);

    // Form validation
    form.addEventListener('submit', function(e) {
        const requiredQuestions = document.querySelectorAll('input[required], textarea[required]');
        let allRequiredAnswered = true;

        requiredQuestions.forEach(input => {
            if (input.type === 'radio') {
                const radioGroup = document.querySelectorAll(`input[name="${input.name}"]`);
                const isChecked = Array.from(radioGroup).some(radio => radio.checked);
                if (!isChecked) {
                    allRequiredAnswered = false;
                }
            } else if (!input.value.trim()) {
                allRequiredAnswered = false;
            }
        });

        if (!allRequiredAnswered) {
            e.preventDefault();
            alert('Por favor responde todas las preguntas obligatorias.');
            return;
        }

        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Enviando...';
    });
</script>