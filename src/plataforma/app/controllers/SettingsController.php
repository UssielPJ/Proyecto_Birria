<?php
namespace App\Controllers;

use App\Core\View;
use PDO;
use Exception;

class SettingsController
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

    /* ===================== Vista principal ===================== */
    public function index()
    {
        $this->requireRole(['admin']);

        $settings = $this->getAllSettings();
        View::render('admin/settings/index', 'admin', ['settings' => $settings]);
    }

    /* ===================== Sección: General ===================== */
    public function updateGeneral()
    {
        $this->requireRole(['admin']);

        $data = [
            'school_name'    => trim($_POST['school_name']    ?? ''),
            'school_address' => trim($_POST['school_address'] ?? ''),
            'contact_email'  => trim($_POST['contact_email']  ?? ''),
            'phone'          => trim($_POST['phone']          ?? ''),
        ];

        if ($data['school_name'] === '') {
            $_SESSION['error'] = 'El nombre de la institución es requerido';
            header('Location: /src/plataforma/app/admin/settings'); exit;
        }
        if ($data['contact_email'] !== '' && !filter_var($data['contact_email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'El email de contacto no es válido';
            header('Location: /src/plataforma/app/admin/settings'); exit;
        }

        if ($this->saveSettings('general', $data)) {
            $_SESSION['success'] = 'Configuración general actualizada correctamente';
        } else {
            $_SESSION['error']   = 'Error al actualizar la configuración general';
        }
        header('Location: /src/plataforma/app/admin/settings'); exit;
    }

    /* ===================== Sección: Académica ===================== */
    public function updateAcademic()
    {
        $this->requireRole(['admin']);

        $data = [
            'current_period'  => trim($_POST['current_period']   ?? ''),
            'enrollment_open' => (isset($_POST['enrollment_open']) && $_POST['enrollment_open'] ? '1' : '0'),
            'min_attendance'  => (int)($_POST['min_attendance']  ?? 80),
            'passing_grade'    => (int)($_POST['passing_grade']   ?? 70),
        ];

        if ($data['current_period'] === '') {
            $_SESSION['error'] = 'El periodo actual es requerido';
            header('Location: /src/plataforma/app/admin/settings'); exit;
        }
        if ($data['min_attendance'] < 0 || $data['min_attendance'] > 100) {
            $_SESSION['error'] = 'La asistencia mínima debe estar entre 0 y 100';
            header('Location: /src/plataforma/app/admin/settings'); exit;
        }
        if ($data['passing_grade'] < 0 || $data['passing_grade'] > 100) {
            $_SESSION['error'] = 'La calificación mínima debe estar entre 0 y 100';
            header('Location: /src/plataforma/app/admin/settings'); exit;
        }

        if ($this->saveSettings('academic', $data)) {
            $_SESSION['success'] = 'Configuración académica actualizada correctamente';
        } else {
            $_SESSION['error']   = 'Error al actualizar la configuración académica';
        }
        header('Location: /src/plataforma/app/admin/settings'); exit;
    }

    /* ===================== Sección: Notificaciones ===================== */
    public function updateNotifications()
    {
        $this->requireRole(['admin']);

        $data = [
            'email_notifications' => (isset($_POST['email_notifications']) && $_POST['email_notifications'] ? '1' : '0'),
            'smtp_host'           => trim($_POST['smtp_host'] ?? ''),
            'smtp_user'           => trim($_POST['smtp_user'] ?? ''),
        ];
        // Solo guardar password si llegó (no la sobreescribas con vacío)
        if (isset($_POST['smtp_password']) && $_POST['smtp_password'] !== '') {
            $data['smtp_password'] = $_POST['smtp_password']; // NO se hashea (es credencial externa)
        }

        if ($this->saveSettings('notifications', $data)) {
            $_SESSION['success'] = 'Configuración de notificaciones actualizada correctamente';
        } else {
            $_SESSION['error']   = 'Error al actualizar la configuración de notificaciones';
        }
        header('Location: /src/plataforma/app/admin/settings'); exit;
    }

    /* ===================== Acceso a datos ===================== */
    private function getAllSettings(): array
    {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT category, setting_key, setting_value FROM settings");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Plano: settings['school_name'] => 'UTSC', etc.
            $settings = [];
            foreach ($rows as $r) {
                $settings[$r['setting_key']] = $r['setting_value'];
            }
            return $settings;
        } catch (Exception $e) {
            error_log("Error al obtener configuraciones: ".$e->getMessage());
            return [];
        }
    }

    private function getSettings(string $category): array
    {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT setting_key, setting_value FROM settings WHERE category = ?");
            $stmt->execute([$category]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $settings = [];
            foreach ($rows as $r) {
                $settings[$r['setting_key']] = $r['setting_value'];
            }
            return $settings;
        } catch (Exception $e) {
            error_log("Error al obtener configuraciones de categoría {$category}: ".$e->getMessage());
            return [];
        }
    }

    private function saveSettings(string $category, array $data): bool
    {
        $pdo = db();
        try {
            $pdo->beginTransaction();

            foreach ($data as $key => $value) {
                // Requiere UNIQUE KEY en (category, setting_key)
                $sql = "
                    INSERT INTO settings (category, setting_key, setting_value, created_at, updated_at)
                    VALUES (?, ?, ?, NOW(), NOW())
                    ON DUPLICATE KEY UPDATE
                      setting_value = VALUES(setting_value),
                      updated_at    = NOW()
                ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$category, $key, $value]);
            }

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            error_log("Error al guardar configuraciones: ".$e->getMessage());
            return false;
        }
    }
}
