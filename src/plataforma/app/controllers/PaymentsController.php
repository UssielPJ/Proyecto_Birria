<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Gate;
use App\Core\View;
use App\Models\Payment;
use Exception;
use PDO;

class PaymentsController
{
    public function index()
    {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar autenticación
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/');
            exit;
        }

        try {
            $payments = Payment::all();
            
            // Renderizar la vista usando el patrón del proyecto
            View::render('admin/payments/index', 'admin', [
                'payments' => $payments
            ]);
        } catch (Exception $e) {
            error_log("Error al cargar pagos: " . $e->getMessage());
            $_SESSION['error'] = 'Error al cargar los pagos';
            $payments = [];
            
            View::render('admin/payments/index', 'admin', [
                'payments' => $payments
            ]);
        }
    }

    public function create()
    {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar autenticación
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/');
            exit;
        }

        try {
            // Obtener estudiantes usando consulta directa
            $pdo = db();
            $stmt = $pdo->prepare("SELECT u.id, u.name, u.email FROM users u JOIN roles r ON u.role_id = r.id WHERE r.slug = 'alumno' ORDER BY u.name");
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            View::render('admin/payments/create', 'admin', [
                'students' => $students
            ]);
        } catch (Exception $e) {
            error_log("Error al cargar formulario de pagos: " . $e->getMessage());
            $_SESSION['error'] = 'Error al cargar el formulario';
            header('Location: /src/plataforma/app/admin/payments');
            exit;
        }
    }

    public function store()
    {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar autenticación
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/');
            exit;
        }

        // Validar datos de entrada
        $data = [
            'student_id' => intval($_POST['student_id'] ?? 0),
            'concept' => trim($_POST['concept'] ?? ''),
            'amount' => floatval($_POST['amount'] ?? 0),
            'payment_date' => $_POST['payment_date'] ?? date('Y-m-d'),
            'payment_method' => $_POST['payment_method'] ?? 'cash',
            'status' => $_POST['status'] ?? 'pending',
            'notes' => trim($_POST['notes'] ?? '') ?: null
        ];

        // Validaciones básicas
        if ($data['student_id'] <= 0) {
            $_SESSION['error'] = 'Debe seleccionar un estudiante válido';
            header('Location: /src/plataforma/app/admin/payments/create');
            exit;
        }

        if (empty($data['concept'])) {
            $_SESSION['error'] = 'El concepto del pago es requerido';
            header('Location: /src/plataforma/app/admin/payments/create');
            exit;
        }

        if ($data['amount'] <= 0) {
            $_SESSION['error'] = 'El monto debe ser mayor a 0';
            header('Location: /src/plataforma/app/admin/payments/create');
            exit;
        }

        $validMethods = ['cash', 'transfer', 'card'];
        if (!in_array($data['payment_method'], $validMethods)) {
            $_SESSION['error'] = 'Método de pago no válido';
            header('Location: /src/plataforma/app/admin/payments/create');
            exit;
        }

        $validStatuses = ['paid', 'pending'];
        if (!in_array($data['status'], $validStatuses)) {
            $_SESSION['error'] = 'Estado de pago no válido';
            header('Location: /src/plataforma/app/admin/payments/create');
            exit;
        }

        if (Payment::create($data)) {
            $_SESSION['success'] = 'Pago registrado correctamente';
        } else {
            $_SESSION['error'] = 'Error al registrar el pago';
        }

        header('Location: /src/plataforma/app/admin/payments');
        exit;
    }

    public function edit($id)
    {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar autenticación
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/');
            exit;
        }

        try {
            $payment = Payment::find($id);

            if (!$payment) {
                $_SESSION['error'] = 'Pago no encontrado';
                header('Location: /src/plataforma/app/admin/payments');
                exit;
            }

            // Obtener estudiantes usando consulta directa
            $pdo = db();
            $stmt = $pdo->prepare("SELECT u.id, u.name, u.email FROM users u JOIN roles r ON u.role_id = r.id WHERE r.slug = 'alumno' ORDER BY u.name");
            $stmt->execute();
            $students = $stmt->fetchAll(PDO::FETCH_OBJ);

            View::render('admin/payments/edit', 'admin', [
                'payment' => $payment,
                'students' => $students
            ]);
        } catch (Exception $e) {
            error_log("Error al cargar pago para edición: " . $e->getMessage());
            $_SESSION['error'] = 'Error al cargar el pago';
            header('Location: /src/plataforma/app/admin/payments');
            exit;
        }
    }

    public function update($id)
    {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar autenticación
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/');
            exit;
        }

        try {
            $payment = Payment::find($id);

            if (!$payment) {
                $_SESSION['error'] = 'Pago no encontrado';
                header('Location: /src/plataforma/app/admin/payments');
                exit;
            }

            // Validar datos de entrada
            $data = [
                'student_id' => intval($_POST['student_id'] ?? 0),
                'concept' => trim($_POST['concept'] ?? ''),
                'amount' => floatval($_POST['amount'] ?? 0),
                'payment_date' => $_POST['payment_date'] ?? date('Y-m-d'),
                'payment_method' => $_POST['payment_method'] ?? 'cash',
                'status' => $_POST['status'] ?? 'pending',
                'notes' => trim($_POST['notes'] ?? '') ?: null
            ];

            // Validaciones básicas
            if ($data['student_id'] <= 0) {
                $_SESSION['error'] = 'Debe seleccionar un estudiante válido';
                header('Location: /src/plataforma/app/admin/payments/edit/' . $id);
                exit;
            }

            if (empty($data['concept'])) {
                $_SESSION['error'] = 'El concepto del pago es requerido';
                header('Location: /src/plataforma/app/admin/payments/edit/' . $id);
                exit;
            }

            if ($data['amount'] <= 0) {
                $_SESSION['error'] = 'El monto debe ser mayor a 0';
                header('Location: /src/plataforma/app/admin/payments/edit/' . $id);
                exit;
            }

            if ($payment->update($data)) {
                $_SESSION['success'] = 'Pago actualizado correctamente';
            } else {
                $_SESSION['error'] = 'Error al actualizar el pago';
            }

            header('Location: /src/plataforma/app/admin/payments');
            exit;
        } catch (Exception $e) {
            error_log("Error al actualizar pago: " . $e->getMessage());
            $_SESSION['error'] = 'Error al actualizar el pago';
            header('Location: /src/plataforma/app/admin/payments');
            exit;
        }
    }

    public function delete($id)
    {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar autenticación
        if (empty($_SESSION['user'])) {
            header('Location: /src/plataforma/');
            exit;
        }

        try {
            $payment = Payment::find($id);

            if (!$payment) {
                $_SESSION['error'] = 'Pago no encontrado';
                header('Location: /src/plataforma/app/admin/payments');
                exit;
            }

            if ($payment->delete()) {
                $_SESSION['success'] = 'Pago eliminado correctamente';
            } else {
                $_SESSION['error'] = 'Error al eliminar el pago';
            }

            header('Location: /src/plataforma/app/admin/payments');
            exit;
        } catch (Exception $e) {
            error_log("Error al eliminar pago: " . $e->getMessage());
            $_SESSION['error'] = 'Error al eliminar el pago';
            header('Location: /src/plataforma/app/admin/payments');
            exit;
        }
    }
}
