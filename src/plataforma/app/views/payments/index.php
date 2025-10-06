<?php require_once __DIR__ . "/../partials/head.php" ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestión de Pagos</h1>
        <a href="/payments/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Registrar Nuevo Pago
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Pagos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="paymentsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Estudiante</th>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($payments) && !empty($payments)) : ?>
                            <?php foreach ($payments as $payment) : ?>
                                <tr>
                                    <td><?php echo $payment->id; ?></td>
                                    <td><?php echo $payment->student_name; ?></td>
                                    <td><?php echo $payment->concept; ?></td>
                                    <td>$<?php echo number_format($payment->amount, 2); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($payment->payment_date)); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $payment->status === 'paid' ? 'success' : 'warning'; ?>">
                                            <?php echo $payment->status === 'paid' ? 'Pagado' : 'Pendiente'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/payments/edit/<?php echo $payment->id; ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/payments/view/<?php echo $payment->id; ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/../partials/footer.php" ?>