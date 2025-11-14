<?php
// Variables esperadas desde el controlador:
// $user, $task, $submission, (opcionales) $examSchema, $examAnswers

$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

$isExam      = ($task->activity_type_slug ?? '') === 'exam';
$examSchema  = $examSchema  ?? null;
$examAnswers = $examAnswers ?? null;
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-full">
                    <i data-feather="file-text" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold"><?= $esc($task->title) ?></h2>
                    <p class="opacity-90"><?= $esc($task->course_name) ?> (<?= $esc($task->course_code) ?>)</p>
                </div>
            </div>
            <a href="/src/plataforma/app/tareas" class="inline-flex items-center gap-2 rounded-lg bg-white/15 hover:bg-white/25 px-3 py-2 text-sm transition">
                <i data-feather="arrow-left" class="w-4 h-4"></i> Volver a tareas
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Detalles de la tarea -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6" data-aos="fade-up">
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Descripción</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        <?= nl2br($esc($task->description ?? 'No hay descripción disponible.')) ?>
                    </p>
                </div>

                <?php if (!empty($task->file_path)): ?>
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Archivo adjunto</h3>
                        <a href="<?= $esc($task->file_path) ?>" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-100 hover:bg-indigo-200 dark:bg-indigo-900 dark:hover:bg-indigo-800 text-indigo-700 dark:text-indigo-300 rounded-lg transition-colors">
                            <i data-feather="download" class="w-4 h-4"></i>
                            Descargar archivo
                        </a>
                    </div>
                <?php endif; ?>

                <?php if ($submission): ?>
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Tu entrega</h3>
                        <div class="bg-gray-50 dark:bg-neutral-700 rounded-lg p-4">
                            <div class="mb-3">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Fecha de entrega:</p>
                                <p class="text-gray-800 dark:text-gray-200">
                                    <?php if (!empty($submission->submission_date)): ?>
                                        <?= date('d/m/Y H:i', strtotime($submission->submission_date)) ?>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </p>
                            </div>

                            <?php if (!empty($submission->file_path)): ?>
                                <div class="mb-3">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Archivo entregado:</p>
                                    <a href="<?= $esc($submission->file_path) ?>" target="_blank" class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        <i data-feather="paperclip" class="w-4 h-4"></i>
                                        Ver archivo
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php
                    // ===== REVISUALIZACIÓN DEL EXAMEN =====
                    if (
                        $isExam &&
                        $examSchema &&
                        isset($examSchema['questions']) &&
                        is_array($examSchema['questions']) &&
                        $examAnswers &&
                        isset($examAnswers['answers']) &&
                        is_array($examAnswers['answers'])
                    ):
                        $answers = $examAnswers['answers'];
                    ?>
                        <div class="mb-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center gap-2">
                                <i data-feather="check-circle" class="w-4 h-4 text-emerald-500"></i>
                                Resumen de tu examen
                            </h3>

                            <div class="space-y-4">
                                <?php foreach ($examSchema['questions'] as $qIndex => $qDef):
                                    $qText  = $qDef['text']  ?? ('Pregunta '.($qIndex+1));
                                    $qType  = strtolower($qDef['type'] ?? 'multiple_choice');
                                    $opts   = $qDef['options'] ?? [];
                                    $correct = isset($qDef['correct']) && is_array($qDef['correct'])
                                        ? array_map('intval', $qDef['correct'])
                                        : [];

                                    $raw = $answers[$qIndex] ?? null;

                                    $selected   = [];
                                    $textAnswer = '';

                                    if ($qType === 'single_choice') {
                                        if ($raw !== null && $raw !== '') {
                                            $selected = [(int)$raw];
                                        }
                                    } elseif ($qType === 'multiple_choice') {
                                        if (is_array($raw)) {
                                            $selected = array_map('intval', $raw);
                                        } elseif ($raw !== null && $raw !== '') {
                                            $selected = [(int)$raw];
                                        }
                                    } elseif ($qType === 'short_answer') {
                                        $textAnswer = is_array($raw) ? implode(' ', $raw) : (string)($raw ?? '');
                                    }
                                ?>
                                    <div class="rounded-xl bg-gray-50 dark:bg-neutral-800/80 border border-gray-200 dark:border-neutral-700 p-4">
                                        <div class="flex items-start gap-2 mb-2">
                                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200 flex items-center justify-center text-xs font-bold">
                                                <?= $qIndex + 1 ?>
                                            </span>
                                            <div>
                                                <p class="font-medium text-gray-800 dark:text-gray-100">
                                                    <?= $esc($qText) ?>
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    <?php
                                                        if ($qType === 'single_choice') {
                                                            echo 'Opción única';
                                                        } elseif ($qType === 'multiple_choice') {
                                                            echo 'Varias respuestas correctas';
                                                        } else {
                                                            echo 'Respuesta abierta';
                                                        }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>

                                        <?php if ($qType === 'single_choice' || $qType === 'multiple_choice'): ?>
                                            <div class="space-y-2 mt-2">
                                                <?php foreach ($opts as $optIndex => $optText):
                                                    $isSelected = in_array($optIndex, $selected, true);
                                                    $isCorrect  = in_array($optIndex, $correct, true);

                                                    $baseClass = 'flex items-start gap-2 rounded-lg px-3 py-2 text-sm border';
                                                    if ($isSelected && $isCorrect) {
                                                        $classes = $baseClass.' bg-emerald-50 border-emerald-400 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200';
                                                        $label   = 'Tu respuesta (correcta)';
                                                    } elseif ($isSelected && !$isCorrect) {
                                                        $classes = $baseClass.' bg-red-50 border-red-400 text-red-800 dark:bg-red-900/40 dark:text-red-200';
                                                        $label   = 'Tu respuesta (incorrecta)';
                                                    } elseif (!$isSelected && $isCorrect) {
                                                        $classes = $baseClass.' bg-emerald-50/60 border-emerald-300 text-emerald-800/90 dark:bg-emerald-900/20 dark:text-emerald-200/90';
                                                        $label   = 'Respuesta correcta (no seleccionada)';
                                                    } else {
                                                        $classes = $baseClass.' bg-white border-gray-200 text-gray-700 dark:bg-neutral-900 dark:border-neutral-700 dark:text-gray-200';
                                                        $label   = null;
                                                    }
                                                ?>
                                                    <div class="<?= $classes ?>">
                                                        <div class="mt-0.5">
                                                            <?php if ($qType === 'multiple_choice'): ?>
                                                                <div class="w-3 h-3 rounded border border-gray-300 dark:border-gray-600 <?= $isSelected ? 'bg-indigo-500' : 'bg-white dark:bg-neutral-900' ?>"></div>
                                                            <?php else: ?>
                                                                <div class="w-3 h-3 rounded-full border border-gray-300 dark:border-gray-600 <?= $isSelected ? 'bg-indigo-500' : 'bg-white dark:bg-neutral-900' ?>"></div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="flex-1">
                                                            <p><?= $esc($optText) ?></p>
                                                            <?php if ($label): ?>
                                                                <p class="text-[11px] mt-1 opacity-80">
                                                                    <?= $label ?>
                                                                </p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php elseif ($qType === 'short_answer'): ?>
                                            <div class="mt-2">
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Tu respuesta:</p>
                                                <p class="text-sm text-gray-800 dark:text-gray-100 bg-white/70 dark:bg-neutral-900 rounded-lg px-3 py-2">
                                                    <?= $textAnswer !== '' ? $esc($textAnswer) : 'Sin respuesta.' ?>
                                                </p>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-sm text-red-500">
                                                Tipo de pregunta no soportado todavía para revisión: <?= $esc($qType) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($submission && $submission->grade !== null): ?>
                    <?php
                        $grade        = (float)$submission->grade;
                        $gradeColor   = $grade >= 9 ? 'green' : ($grade >= 7 ? 'blue' : 'orange');
                        $gradeLabel   = $grade >= 9 ? 'Excelente' : ($grade >= 7 ? 'Aprobado' : 'Necesita mejorar');
                    ?>
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Calificación</h3>
                        <div class="rounded-lg p-4 bg-<?= $gradeColor ?>-50 dark:bg-<?= $gradeColor ?>-900/20">
                            <div class="flex items-center gap-3 mb-3">
                                <span class="text-3xl font-bold text-<?= $gradeColor ?>-700 dark:text-<?= $gradeColor ?>-300">
                                    <?= number_format($grade, 1) ?>
                                </span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    <?= $gradeLabel ?>
                                </span>
                            </div>
                            <?php if (!empty($submission->feedback)): ?>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Retroalimentación:</p>
                                    <p class="text-gray-800 dark:text-gray-200"><?= $esc($submission->feedback) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Información</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Profesor:</p>
                        <p class="text-gray-800 dark:text-gray-200"><?= $esc($task->teacher_name) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de entrega:</p>
                        <p class="text-gray-800 dark:text-gray-200">
                            <?= $task->due_at ? date('d/m/Y H:i', strtotime($task->due_at)) : '—' ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Fecha de publicación:</p>
                        <p class="text-gray-800 dark:text-gray-200"><?= date('d/m/Y H:i', strtotime($task->created_at)) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Estado:</p>
                        <?php 
                        $now      = new DateTime();
                        $dueDate  = $task->due_at ? new DateTime($task->due_at) : null;
                        $isOverdue = $dueDate ? ($now > $dueDate) : false;
                        ?>
                        <?php if ($submission): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                Entregada
                            </span>
                        <?php elseif ($isOverdue): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                Vencida
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300">
                                Pendiente
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php
$isExam       = ($task->activity_type_slug ?? '') === 'exam';
$passGrade    = 7.0;
$lastGrade    = $submission->grade ?? null;
?>

<?php if (!$isExam && !$submission): ?>
    <!-- Primera entrega -->
    <div class="mt-6">
        <a href="/src/plataforma/app/tareas/submit/<?= (int)$task->id ?>" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
            <i data-feather="upload" class="w-4 h-4 mr-2"></i>
            Entregar tarea
        </a>
    </div>

        <?php elseif (!$isExam && !empty($canResubmitTask)): ?>
            <!-- Reentrega permitida (nota no aprobatoria y quedan intentos) -->
            <div class="mt-6 space-y-2">
                <a href="/src/plataforma/app/tareas/submit/<?= (int)$task->id ?>" class="w-full inline-flex items-center justify-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg transition-colors">
                    <i data-feather="repeat" class="w-4 h-4 mr-2"></i>
                    Volver a entregar tarea
                </a>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Tienes <?= (int)$attemptsUsed ?> de <?= (int)$maxAttempts ?> intentos usados.
                    Puedes reenviar porque tu calificación actual (<?= $lastGrade !== null ? number_format($lastGrade,1) : 'N/A' ?>) no es aprobatoria.
                </p>
            </div>
        <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    AOS.init();
    feather.replace();
</script>
