<?php require_once __DIR__ . '/../../layouts/teacher.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Nueva Calificación</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Ingresa una nueva calificación para tus estudiantes</p>
            </div>

            <form action="/src/plataforma/app/teacher/grades/store" method="POST" class="space-y-6">
                <!-- Información de la Calificación -->
                <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
                    <h2 class="font-semibold text-lg">Información de la Calificación</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estudiante</label>
                            <select name="student_id" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona un estudiante</option>
                                <?php if (!empty($students)): ?>
                                    <?php foreach ($students as $student): ?>
                                        <option value="<?= $student['id'] ?>"><?= htmlspecialchars($student['name']) ?> - <?= htmlspecialchars($student['matricula'] ?? $student['id']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Materia</label>
                            <select name="subject_id" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona una materia</option>
                                <?php if (!empty($subjects)): ?>
                                    <?php foreach ($subjects as $subject): ?>
                                        <option value="<?= $subject['materia_id'] ?>"><?= htmlspecialchars($subject['name']) ?> (<?= htmlspecialchars($subject['code']) ?>)</option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Calificación (0-100)</label>
                            <input type="number" name="grade" min="0" max="100" step="0.1" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Comentarios</label>
                        <textarea name="comments" rows="3" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Comentarios adicionales sobre la calificación..."></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/src/plataforma/app/teacher/grades" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
                        Guardar Calificación
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    feather.replace();

    // Auto-check passed based on grade
    document.querySelector('input[name="grade"]').addEventListener('input', function() {
        const grade = parseFloat(this.value);
        const passedCheckbox = document.querySelector('input[name="passed"]');
        if (!isNaN(grade)) {
            passedCheckbox.checked = grade >= 70;
        }
    });
</script>