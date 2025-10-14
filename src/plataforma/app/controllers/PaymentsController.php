<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\Payment;
use Exception;
use PDO;

class PaymentsController
{
    /* ------------ Guards compatibles con la nueva sesión ------------ */
    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/login'); exit;
        }
    }

    private function requireRole(array $roles) {
        $this->requireLogin();
        $userRoles = $_SESSION['user']['roles'] ?? [];
        foreach ($roles as $r) {
            if (in_array($r, $userRoles, true)) return;
        }
        header('Location: /src/plataforma/login'); exit;
    }

    /* ===================== Listado ===================== */
    public function index()
    {
        $this->requireRole(['admin']);

        try {
            $payments = Payment::all();
            View::render('admin/payments/index', 'admin', ['payments' => $payments]);
        } catch (Exception $e) {
            error_log("Error al cargar pagos: ".$e->getMessage());
            $_SESSION['error'] = 'Error al cargar los pagos';
            View::render('admin/payments/index', 'admin', ['payments' => []]);
        }
    }

    /* ===================== Crear ===================== */
    public function create()
    {
        $this->requireRole(['admin']);

        try {
            $pdo = db();

            // Ajusta esta consulta a tu esquema actual.
            // Opción A (esquema viejo con tabla roles + role_id en users):
            // $sql = "SELECT u.id, u.name, u.email
            //         FROM users u
            //         JOIN roles r ON u.role_id = r.id
            //         WHERE r.slug = 'alumno'
            //         ORDER BY u.name";

            // Opción B (esquema nuevo con student_profiles):
            // $sql = "SELECT u.id, u.name, u.email
            //         FROM users u
            //         JOIN student_profiles sp ON sp.user_id = u.id
            //         ORDER BY u.name";

            // Elige UNA de las 2 según tu DB actual:
            $sql = "SELECT u.id, u.name, u.email
                    FROM users u
                    JOIN student_profiles sp ON sp.user_id = u.id
                    ORDER BY u.name";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_OBJ);

            View::render('admin/payments/create', 'admin', ['students' => $students]);
        } catch (Exception $e) {
            error_log("Error al cargar formulario de pagos: ".$e->getMessage());
            $_SESSION['error'] = 'Error al cargar el formulario';
            header('Location: /src/plataforma/app/admin/payments'); exit;
        }
    }

    public function store()
    {
        $this->requireRole(['admin']);

        $data = [
            'student_id'    => (int)($_POST['student_id'] ?? 0),
            'concept'       => trim($_POST['concept'] ?? ''),
            'amount'        => (float)($_POST['amount'] ?? 0),
            'payment_date'  => $_POST['payment_date'] ?? date('Y-m-d'),
            'payment_method'=> $_POST['payment_method'] ?? 'cash',
            'status'        => $_POST['status'] ?? 'pending',
            'notes'         => (trim($_POST['notes'] ?? '') ?: null),
        ];

        // Validaciones
        if ($data['student_id'] <= 0) { $_SESSION['error']='Debe seleccionar un estudiante válido'; header('Location: /src/plataforma/app/admin/payments/create'); exit; }
        if ($data['concept'] === '') { $_SESSION['error']='El concepto del pago es requerido'; header('Location: /src/plataforma/app/admin/payments/create'); exit; }
        if ($data['amount'] <= 0)     { $_SESSION['error']='El monto debe ser mayor a 0'; header('Location: /src/plataforma/app/admin/payments/create'); exit; }

        $validMethods = ['cash','transfer','card'];
        if (!in_array($data['payment_method'], $validMethods, true)) {
            $_SESSION['error'] = 'Método de pago no válido'; header('Location: /src/plataforma/app/admin/payments/create'); exit;
        }

        $validStatuses = ['paid','pending'];
        if (!in_array($data['status'], $validStatuses, true)) {
            $_SESSION['error'] = 'Estado de pago no válido'; header('Location: /src/plataforma/app/admin/payments/create'); exit;
        }

        if (Payment::create($data)) {
            $_SESSION['success'] = 'Pago registrado correctamente';
        } else {
            $_SESSION['error'] = 'Error al registrar el pago';
        }

        header('Location: /src/plataforma/app/admin/payments'); exit;
    }

    /* ===================== Editar ===================== */
    public function edit($id)
    {
        $this->requireRole(['admin']);

        try {
            $payment = Payment::find($id);
            if (!$payment) {
                $_SESSION['error'] = 'Pago no encontrado';
                header('Location: /src/plataforma/app/admin/payments'); exit;
            }

            $pdo = db();

            // Mismo comentario que en create(): elige la consulta que corresponda a tu esquema.
            // $sql = "SELECT u.id, u.name, u.email
            //         FROM users u
            //         JOIN roles r ON u.role_id = r.id
            //         WHERE r.slug = 'alumno'
            //         ORDER BY u.name";

            $sql = "SELECT u.id, u.name, u.email
                    FROM users u
                    JOIN student_profiles sp ON sp.user_id = u.id
                    ORDER BY u.name";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_OBJ);

            View::render('admin/payments/edit', 'admin', [
                'payment'  => $payment,
                'students' => $students
            ]);
        } catch (Exception $e) {
            error_log("Error al cargar pago para edición: ".$e->getMessage());
            $_SESSION['error'] = 'Error al cargar el pago';
            header('Location: /src/plataforma/app/admin/payments'); exit;
        }
    }

    public function update($id)
    {
        $this->requireRole(['admin']);

        try {
            $payment = Payment::find($id);
            if (!$payment) {
                $_SESSION['error'] = 'Pago no encontrado';
                header('Location: /src/plataforma/app/admin/payments'); exit;
            }

            $data = [
                'student_id'    => (int)($_POST['student_id'] ?? 0),
                'concept'       => trim($_POST['concept'] ?? ''),
                'amount'        => (float)($_POST['amount'] ?? 0),
                'payment_date'  => $_POST['payment_date'] ?? date('Y-m-d'),
                'payment_method'=> $_POST['payment_method'] ?? 'cash',
                'status'        => $_POST['status'] ?? 'pending',
                'notes'         => (trim($_POST['notes'] ?? '') ?: null)
            ];

            if ($data['student_id'] <= 0) { $_SESSION['error']='Debe seleccionar un estudiante válido'; header('Location: /src/plataforma/app/admin/payments/edit/'.$id); exit; }
            if ($data['concept'] === '') { $_SESSION['error']='El concepto del pago es requerido'; header('Location: /src/plataforma/app/admin/payments/edit/'.$id); exit; }
            if ($data['amount'] <= 0)     { $_SESSION['error']='El monto debe ser mayor a 0'; header('Location: /src/plataforma/app/admin/payments/edit/'.$id); exit; }

            if ($payment->update($data)) {
                $_SESSION['success'] = 'Pago actualizado correctamente';
            } else {
                $_SESSION['error'] = 'Error al actualizar el pago';
            }

            header('Location: /src/plataforma/app/admin/payments'); exit;
        } catch (Exception $e) {
            error_log("Error al actualizar pago: ".$e->getMessage());
            $_SESSION['error'] = 'Error al actualizar el pago';
            header('Location: /src/plataforma/app/admin/payments'); exit;
        }
    }

    /* ===================== Eliminar ===================== */
    public function delete($id)
    {
        $this->requireRole(['admin']);

        try {
            $payment = Payment::find($id);
            if (!$payment) {
                $_SESSION['error'] = 'Pago no encontrado';
                header('Location: /src/plataforma/app/admin/payments'); exit;
            }

            if ($payment->delete()) {
                $_SESSION['success'] = 'Pago eliminado correctamente';
            } else {
                $_SESSION['error'] = 'Error al eliminar el pago';
            }

            header('Location: /src/plataforma/app/admin/payments'); exit;
        } catch (Exception $e) {
            error_log("Error al eliminar pago: ".$e->getMessage());
            $_SESSION['error'] = 'Error al eliminar el pago';
            header('Location: /src/plataforma/app/admin/payments'); exit;
        }
    }
}
