<?php
// Espera: $user, $task, $examSchema, $attemptsUsed, $maxAttempts, $canSubmit, $lastSubmission, $bestGrade

$esc = fn($v)=>htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

$typeName = $task->activity_type_name ?? 'Examen';
$totalPts = isset($task->total_points) ? (float)$task->total_points : null;
$weight   = isset($task->weight_percent) ? (float)$task->weight_percent : null;

$attemptsUsed = $attemptsUsed ?? 0;
$maxAttempts  = $maxAttempts ?? (isset($task->max_attempts) ? (int)$task->max_attempts : 1);
$canSubmit    = $canSubmit ?? ($attemptsUsed < $maxAttempts);

/**
 * $bestGrade puede venir ya calculada desde el controlador (MAX(grade)).
 * Si no viene, la calculamos como la calificación del último intento.
 */
$bestGrade = $bestGrade ?? null;
if ($bestGrade === null && !empty($lastSubmission) && isset($lastSubmission->grade) && $lastSubmission->grade !== null) {
    $bestGrade = (float)$lastSubmission->grade;
}

$now      = new DateTime();
$dueDate  = !empty($task->due_at) ? new DateTime($task->due_at) : null;
$isOverdue = $dueDate ? ($now > $dueDate) : false;
$daysLeft  = $dueDate ? $now->diff($dueDate)->days : null;

// Extra del JSON
$instructions = $examSchema['instructions'] ?? '';
$questions    = $examSchema['questions'] ?? [];
?>

<div class="py-8 max-w-5xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-6 text-white mb-8 shadow-xl" data-aos="fade-up">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="p-3 bg-white/20 rounded-full">
                    <i data-feather="file-text" class="w-8 h-8"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-1"><?= $esc($typeName) ?></h2>
                    <p class="opacity-90">
                        <?= $esc($task->course_name) ?> (<?= $esc($task->course_code) ?>)
                    </p>
                    <div class="flex flex-wrap gap-2 mt-2 text-xs">
                        <?php if ($totalPts): ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-white/10 text-white border border-white/30">
                                Máx. <?= $totalPts ?> pts
                            </span>
                        <?php endif; ?>
                        <?php if ($weight && $weight > 0): ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-white/10 text-white">
                                Peso: <?= $weight ?>%
                            </span>
                        <?php endif; ?>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-white/10 text-white">
                            Intentos: <?= $attemptsUsed ?> / <?= $maxAttempts ?>
                        </span>
                        <?php if ($bestGrade !== null): ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-500/30 text-emerald-50 border border-emerald-200/50">
                                Mejor calificación: <?= number_format($bestGrade, 1) ?> / 10
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <a href="/src/plataforma/app/tareas/view/<?= (int)$task->id ?>" 
                   class="inline-flex items-center gap-2 rounded-lg bg-white/15 hover:bg-white/25 px-3 py-2 text-sm transition">
                    <i data-feather="arrow-left" class="w-4 h-4"></i> Volver a la actividad
                </a>
                <?php if ($dueDate): ?>
                    <div class="mt-3 text-xs text-white/80 flex items-center justify-end gap-1">
                        <i data-feather="calendar" class="w-4 h-4"></i>
                        Vence: <?= $dueDate->format('d/m/Y H:i') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Tarjeta de calificación -->
    <?php if ($bestGrade !== null): ?>
        <div class="bg-emerald-50 dark:bg-emerald-900/20 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-lg" data-aos="fade-up">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <i data-feather="check-circle" class="h-6 w-6 text-emerald-500"></i>
                </div>
                <div>
                    <p class="text-sm text-emerald-800 dark:text-emerald-200">
                        Tu mejor calificación en este examen es 
                        <span class="font-semibold"><?= number_format($bestGrade, 2) ?></span> de 10.
                    </p>
                    <?php if ($maxAttempts > 1): ?>
                        <p class="text-xs text-emerald-700 dark:text-emerald-300 mt-1">
                            Puedes volver a intentarlo si aún tienes intentos disponibles.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Alertas de fecha / intentos -->
    <?php if (!$canSubmit): ?>
        <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg" data-aos="fade-up">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i data-feather="alert-triangle" class="h-5 w-5 text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 dark:text-red-300">
                        Ya utilizaste los <?= $maxAttempts ?> intentos permitidos para este examen.
                    </p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php if ($dueDate): ?>
            <?php if ($isOverdue): ?>
                <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg" data-aos="fade-up">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-feather="alert-triangle" class="h-5 w-5 text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 dark:text-red-300">
                                Este examen está vencido. Consulta con tu profesor si aún acepta intentos.
                            </p>
                        </div>
                    </div>
                </div>
            <?php elseif ($daysLeft !== null && $daysLeft <= 2): ?>
                <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 p-4 mb-6 rounded-r-lg" data-aos="fade-up">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i data-feather="alert-triangle" class="h-5 w-5 text-amber-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-amber-700 dark:text-amber-300">
                                ¡Atención! Este examen vence en <?= $daysLeft ?> día<?= $daysLeft==1?'':'s' ?>.
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Último intento -->
    <?php if ($lastSubmission): ?>
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow mb-6 p-4 text-sm" data-aos="fade-up">
            <p class="text-gray-700 dark:text-gray-200">
                Último intento enviado el 
                <strong><?= date('d/m/Y H:i', strtotime($lastSubmission->created_at)) ?></strong>.
                <?php if ($lastSubmission->grade !== null): ?>
                    Calificación de ese intento: 
                    <span class="font-semibold"><?= number_format($lastSubmission->grade, 1) ?></span>
                <?php else: ?>
                    (Pendiente de calificación)
                <?php endif; ?>
            </p>
        </div>
    <?php endif; ?>

    <!-- Instrucciones del examen -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow p-6 mb-6" data-aos="fade-up">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3 flex items-center gap-2">
            <i data-feather="info" class="w-4 h-4 text-indigo-500"></i>
            Instrucciones
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 whitespace-pre-line">
            <?= $instructions ? $esc($instructions) : 'Lee cada pregunta con atención y responde según se indica.' ?>
        </p>
    </div>

    <!-- Formulario del examen -->
    <?php if ($canSubmit): ?>
        <form action="/src/plataforma/app/tareas/exam/<?= (int)$task->id ?>" method="post" class="space-y-6" data-aos="fade-up">
            <?php foreach ($questions as $index => $q): 
                $qText  = $q['text']  ?? ('Pregunta '.($index+1));
                $qType  = strtolower($q['type'] ?? 'multiple_choice');
                $opts   = $q['options'] ?? [];

                $allowMultiple = ($qType === 'multiple_choice');
            ?>
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow p-5">
                    <div class="flex items-start gap-2 mb-3">
                        <span class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200 flex items-center justify-center text-xs font-bold">
                            <?= $index + 1 ?>
                        </span>
                        <div>
                            <p class="font-medium text-gray-800 dark:text-gray-100">
                                <?= $esc($qText) ?>
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <?php
                                    if ($qType === 'single_choice' || $qType === 'multiple_choice') {
                                        echo $allowMultiple
                                            ? 'Selecciona una o varias opciones'
                                            : 'Selecciona una opción';
                                    } else {
                                        echo 'Escribe tu respuesta';
                                    }
                                ?>
                            </p>
                        </div>
                    </div>

                    <?php if ($qType === 'multiple_choice' || $qType === 'single_choice'): ?>
                        <div class="space-y-2 mt-2">
                            <?php foreach ($opts as $optIndex => $optText): 
                                $inputName = $allowMultiple
                                    ? "answers[{$index}][]"
                                    : "answers[{$index}]";
                                $inputId = "q{$index}_opt{$optIndex}";
                            ?>
                                <label for="<?= $esc($inputId) ?>" class="flex items-start gap-2 cursor-pointer group">
                                    <input
                                        id="<?= $esc($inputId) ?>"
                                        type="<?= $allowMultiple ? 'checkbox' : 'radio' ?>"
                                        name="<?= $esc($inputName) ?>"
                                        value="<?= $esc($optIndex) ?>"
                                        class="mt-1 h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                    >
                                    <span class="text-sm text-gray-700 dark:text-gray-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-300">
                                        <?= $esc($optText) ?>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>

                    <?php elseif ($qType === 'short_answer'): ?>
                        <div class="mt-3">
                            <textarea
                                name="answers[<?= (int)$index ?>]"
                                rows="3"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-neutral-700 dark:text-white text-sm"
                                placeholder="Escribe tu respuesta aquí..."
                            ></textarea>
                        </div>

                    <?php else: ?>
                        <p class="text-sm text-red-500">
                            Tipo de pregunta no soportado todavía: <?= $esc($qType) ?>
                        </p>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

            <div class="flex justify-end gap-3 pt-2 pb-10">
                <a href="/src/plataforma/app/tareas/view/<?= (int)$task->id ?>" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i data-feather="send" class="w-4 h-4 mr-2"></i>
                    Enviar intento <?= $attemptsUsed + 1 ?>
                </button>
            </div>
        </form>
    <?php else: ?>
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow p-6 mt-4" data-aos="fade-up">
            <p class="text-sm text-gray-700 dark:text-gray-200">
                Has alcanzado el número máximo de intentos. Si consideras que es un error, comunícate con tu profesor.
            </p>
        </div>
    <?php endif; ?>
</div>

<script>
    AOS.init();
    feather.replace();
</script>
