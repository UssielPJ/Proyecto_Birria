<?php require_once __DIR__ . "/../partials/head.php" ?>

<?php
// Asegurarse de que $payment es un objeto para evitar errores
if (!is_object($payment)) {
    $payment = new stdClass();
    $payment->id = '';
    $payment->student_id = '';
    $payment->concept = '';
    $payment->amount = '';
    $payment->payment_date = '';
    $payment->payment_method = '';
    $payment->status = '';
    $payment->notes = '';
}
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar Pago</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulario de Edición</h6>
        </div>
        <div class="card-body">
            <form action="/payments/update/<?= htmlspecialchars($payment->id ?? '') ?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="student_id">Estudiante</label>
                            <select name="student_id" id="student_id" class="form-control" required>
                                <option value="">Seleccione un estudiante</option>
                                <?php if (isset($students)) : ?>
                                    <?php foreach ($students as $student) : ?>
                                        <option value="<?= htmlspecialchars($student->id ?? '') ?>" <?= ($student->id ?? '') === ($payment->student_id ?? '') ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($student->name ?? '') . ' ' . htmlspecialchars($student->last_name ?? '') ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="concept">Concepto de Pago</label>
                            <input type="text" class="form-control" id="concept" name="concept" value="<?= htmlspecialchars($payment->concept ?? '') ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">Monto</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="<?= htmlspecialchars($payment->amount ?? '') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment_date">Fecha de Pago</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date" value="<?= htmlspecialchars(date('Y-m-d', strtotime($payment->payment_date ?? ''))) ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment_method">Método de Pago</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="">Seleccione un método</option>
                                <option value="cash" <?= ($payment->payment_method ?? '') === 'cash' ? 'selected' : '' ?>>Efectivo</option>
                                <option value="transfer" <?= ($payment->payment_method ?? '') === 'transfer' ? 'selected' : '' ?>>Transferencia</option>
                                <option value="card" <?= ($payment->payment_method ?? '') === 'card' ? 'selected' : '' ?>>Tarjeta</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Estado</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="paid" <?= ($payment->status ?? '') === 'paid' ? 'selected' : '' ?>>Pagado</option>
                                <option value="pending" <?= ($payment->status ?? '') === 'pending' ? 'selected' : '' ?>>Pendiente</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notas adicionales</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"><?= htmlspecialchars($payment->notes ?? '') ?></textarea>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Actualizar Pago</button>
                    <a href="/payments" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/../partials/footer.php" ?>
