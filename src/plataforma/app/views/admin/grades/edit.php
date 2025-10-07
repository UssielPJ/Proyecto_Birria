<?php require_once __DIR__ . '/../../layouts/admin.php'; ?>

<div class="container px-6 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Editar Calificación</h1>
                <p class="text-neutral-500 dark:text-neutral-400">Modifica la información de la calificación</p>
            </div>

            <form action="/src/plataforma/app/admin/grades/update/<?= $grade['id'] ?>" method="POST" class="space-y-6">
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
                                        <option value="<?= $student['id'] ?>" <?= $student['id'] == $grade['student_id'] ? 'selected' : '' ?>><?= htmlspecialchars($student['name']) ?> - <?= htmlspecialchars($student['matricula']) ?></option>
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
                                        <option value="<?= $subject['id'] ?>" <?= $subject['id'] == $grade['subject_id'] ? 'selected' : '' ?>><?= htmlspecialchars($subject['name']) ?> (<?= htmlspecialchars($subject['code']) ?>)</option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Evaluación</label>
                            <select name="evaluation_type" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el tipo</option>
                                <option value="parcial1" <?= $grade['evaluation_type'] == 'parcial1' ? 'selected' : '' ?>>Primer Parcial</option>
                                <option value="parcial2" <?= $grade['evaluation_type'] == 'parcial2' ? 'selected' : '' ?>>Segundo Parcial</option>
                                <option value="parcial3" <?= $grade['evaluation_type'] == 'parcial3' ? 'selected' : '' ?>>Tercer Parcial</option>
                                <option value="final" <?= $grade['evaluation_type'] == 'final' ? 'selected' : '' ?>>Examen Final</option>
                                <option value="practica" <?= $grade['evaluation_type'] == 'practica' ? 'selected' : '' ?>>Práctica</option>
                                <option value="tarea" <?= $grade['evaluation_type'] == 'tarea' ? 'selected' : '' ?>>Tarea</option>
                                <option value="proyecto" <?= $grade['evaluation_type'] == 'proyecto' ? 'selected' : '' ?>>Proyecto</option>
                                <option value="extraordinario" <?= $grade['evaluation_type'] == 'extraordinario' ? 'selected' : '' ?>>Extraordinario</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Calificación (0-100)</label>
                            <input type="number" name="grade" min="0" max="100" step="0.1" value="<?= htmlspecialchars($grade['grade']) ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Evaluación</label>
                            <input type="date" name="evaluation_date" value="<?= htmlspecialchars($grade['evaluation_date']) ?>" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Semestre</label>
                            <select name="semester" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                                <option value="">Selecciona el semestre</option>
                                <option value="2025-1" <?= $grade['semester'] == '2025-1' ? 'selected' : '' ?>>2025-1</option>
                                <option value="2024-2" <?= $grade['semester'] == '2024-2' ? 'selected' : '' ?>>2024-2</option>
                                <option value="2024-1" <?= $grade['semester'] == '2024-1' ? 'selected' : '' ?>>2024-1</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Comentarios</label>
                        <textarea name="comments" rows="3" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Comentarios adicionales sobre la calificación..."><?= htmlspecialchars($grade['comments'] ?? '') ?></textarea>
                    </div>

                    <div class="flex items-center gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_final" value="1" <?= $grade['is_final'] ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-700">
                            <span class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">Calificación Final</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="passed" value="1" <?= $grade['passed'] ? 'checked' : '' ?> class="rounded border-neutral-300 dark:border-neutral-700">
                            <span class="ml-2 text-sm text-neutral-700 dark:text-neutral-300">Aprobado</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="/src/plataforma/app/admin/grades" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        Cancelar
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
                        Actualizar Calificación
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