<?php
/**
 * Formulario parcial para crear/editar payments
 * @var object|null $payment Payment a editar (null para nueva payment)
 * @var string $action URL de acción del formulario
 * @var string $method Método HTTP (POST para crear, PUT/PATCH para editar)
 * @var string $submitText Texto del botón de envío
 */

// Determinar si estamos editando o creando
$isEditing = isset($payment) && is_object($payment);

// Fetch data for selects
global $pdo;
$students = $pdo->query("SELECT id, name, email FROM users WHERE role = 'student' ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<form action="<?= htmlspecialchars($action) ?>" method="<?= htmlspecialchars($method) ?>" class="space-y-6">
    <!-- Información del Pago -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="credit-card" class="mr-2 h-5 w-5 text-primary-500"></i>
            Información del Pago
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estudiante</label>
                <select name="student_id" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona un estudiante</option>
                    <?php foreach ($students as $student): ?>
                        <option value="<?= $student['id'] ?>" <?= ($payment->student_id ?? '') == $student['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($student['name'] . ' (' . $student['email'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Tipo de Pago</label>
                <select name="payment_type" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="">Selecciona el tipo</option>
                    <option value="tuition" <?= ($payment->payment_type ?? '') === 'tuition' ? 'selected' : '' ?>>Colegiatura</option>
                    <option value="enrollment" <?= ($payment->payment_type ?? '') === 'enrollment' ? 'selected' : '' ?>>Inscripción</option>
                    <option value="exam" <?= ($payment->payment_type ?? '') === 'exam' ? 'selected' : '' ?>>Examen</option>
                    <option value="other" <?= ($payment->payment_type ?? '') === 'other' ? 'selected' : '' ?>>Otro</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Monto</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-neutral-500">$</span>
                    <input type="number" name="amount" required min="0" step="0.01" value="<?= htmlspecialchars($payment->amount ?? '') ?>"
                           class="w-full pl-8 pr-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Referencia</label>
                <input type="text" name="reference" value="<?= htmlspecialchars($payment->reference ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                       placeholder="Número de referencia o comprobante">
            </div>
        </div>
    </div>

    <!-- Fechas y Estado -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="calendar" class="mr-2 h-5 w-5 text-primary-500"></i>
            Fechas y Estado
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha de Pago</label>
                <input type="date" name="payment_date" value="<?= htmlspecialchars($payment->payment_date ?? date('Y-m-d')) ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Fecha Límite</label>
                <input type="date" name="due_date" value="<?= htmlspecialchars($payment->due_date ?? '') ?>"
                       class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Estado</label>
                <select name="status" required
                        class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500">
                    <option value="pending" <?= ($payment->status ?? '') === 'pending' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="paid" <?= ($payment->status ?? '') === 'paid' ? 'selected' : '' ?>>Pagado</option>
                    <option value="overdue" <?= ($payment->status ?? '') === 'overdue' ? 'selected' : '' ?>>Vencido</option>
                    <option value="cancelled" <?= ($payment->status ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelado</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Descripción -->
    <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
        <h2 class="font-semibold text-lg flex items-center">
            <i data-feather="file-text" class="mr-2 h-5 w-5 text-primary-500"></i>
            Descripción
        </h2>

        <div>
            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">Descripción del Pago</label>
            <textarea name="description" rows="3"
                      class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 focus:border-primary-500 focus:ring-primary-500"
                      placeholder="Describe el concepto del pago..."><?= htmlspecialchars($payment->description ?? '') ?></textarea>
        </div>
    </div>

    <div class="flex justify-end gap-4 pt-4">
        <a href="/src/plataforma/app/admin/payments"
           class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700 inline-flex items-center gap-2">
            <i data-feather="x" class="h-4 w-4"></i>
            Cancelar
        </a>
        <button type="submit"
                class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600 inline-flex items-center gap-2">
            <i data-feather="save" class="h-4 w-4"></i>
            <?= htmlspecialchars($submitText) ?>
        </button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    feather.replace();

    // Validación del formulario
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const studentId = form.querySelector('select[name="student_id"]').value;
        const amount = parseFloat(form.querySelector('input[name="amount"]').value);

        if (!studentId) {
            e.preventDefault();
            alert('Debes seleccionar un estudiante');
            return;
        }

        if (isNaN(amount) || amount <= 0) {
            e.preventDefault();
            alert('El monto debe ser un número positivo');
            return;
        }
    });
});
</script>