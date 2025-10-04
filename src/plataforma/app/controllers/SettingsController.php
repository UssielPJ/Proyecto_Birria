<?php

class SettingsController
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

        $settings = $this->getAllSettings();
        
        // Renderizar la vista usando el patrón del proyecto
        ob_start();
        include __DIR__ . '/../views/settings/index.php';
        return ob_get_clean();
    }

    public function updateGeneral()
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
            'school_name' => trim($_POST['school_name'] ?? ''),
            'school_address' => trim($_POST['school_address'] ?? ''),
            'contact_email' => trim($_POST['contact_email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? '')
        ];

        // Validaciones básicas
        if (empty($data['school_name'])) {
            $_SESSION['error'] = 'El nombre de la institución es requerido';
            header('Location: /src/plataforma/settings');
            exit;
        }

        if (!empty($data['contact_email']) && !filter_var($data['contact_email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'El email de contacto no es válido';
            header('Location: /src/plataforma/settings');
            exit;
        }

        if ($this->saveSettings('general', $data)) {
            $_SESSION['success'] = 'Configuración general actualizada correctamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar la configuración general';
        }

        header('Location: /src/plataforma/settings');
        exit;
    }

    public function updateAcademic()
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
            'current_period' => trim($_POST['current_period'] ?? ''),
            'enrollment_open' => $_POST['enrollment_open'] ?? '0',
            'min_attendance' => intval($_POST['min_attendance'] ?? 80),
            'passing_grade' => intval($_POST['passing_grade'] ?? 70)
        ];

        // Validaciones básicas
        if (empty($data['current_period'])) {
            $_SESSION['error'] = 'El periodo actual es requerido';
            header('Location: /src/plataforma/settings');
            exit;
        }

        if ($data['min_attendance'] < 0 || $data['min_attendance'] > 100) {
            $_SESSION['error'] = 'La asistencia mínima debe estar entre 0 y 100';
            header('Location: /src/plataforma/settings');
            exit;
        }

        if ($data['passing_grade'] < 0 || $data['passing_grade'] > 100) {
            $_SESSION['error'] = 'La calificación mínima debe estar entre 0 y 100';
            header('Location: /src/plataforma/settings');
            exit;
        }

        if ($this->saveSettings('academic', $data)) {
            $_SESSION['success'] = 'Configuración académica actualizada correctamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar la configuración académica';
        }

        header('Location: /src/plataforma/settings');
        exit;
    }

    public function updateNotifications()
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
            'email_notifications' => $_POST['email_notifications'] ?? '0',
            'smtp_host' => trim($_POST['smtp_host'] ?? ''),
            'smtp_user' => trim($_POST['smtp_user'] ?? '')
        ];

        // Solo actualizar la contraseña si se proporciona una nueva
        if (!empty($_POST['smtp_password'])) {
            $data['smtp_password'] = $_POST['smtp_password']; // No hashear contraseñas SMTP
        }

        if ($this->saveSettings('notifications', $data)) {
            $_SESSION['success'] = 'Configuración de notificaciones actualizada correctamente';
        } else {
            $_SESSION['error'] = 'Error al actualizar la configuración de notificaciones';
        }

        header('Location: /src/plataforma/settings');
        exit;
    }

    private function getAllSettings()
    {
        try {
            $pdo = db();
            
            // Obtener todas las configuraciones de la base de datos
            $stmt = $pdo->prepare("SELECT category, setting_key, setting_value FROM settings");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $settings = [];
            foreach ($results as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
            
            return $settings;
        } catch (Exception $e) {
            error_log("Error al obtener configuraciones: " . $e->getMessage());
            return [];
        }
    }

    private function getSettings($category)
    {
        try {
            $pdo = db();
            
            $stmt = $pdo->prepare("SELECT setting_key, setting_value FROM settings WHERE category = ?");
            $stmt->execute([$category]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $settings = [];
            foreach ($results as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
            
            return $settings;
        } catch (Exception $e) {
            error_log("Error al obtener configuraciones de categoría {$category}: " . $e->getMessage());
            return [];
        }
    }

    private function saveSettings($category, $data)
    {
        try {
            $pdo = db();
            
            // Usar transacción para asegurar consistencia
            $pdo->beginTransaction();
            
            foreach ($data as $key => $value) {
                // Usar INSERT ... ON DUPLICATE KEY UPDATE para manejar actualizaciones e inserciones
                $stmt = $pdo->prepare("
                    INSERT INTO settings (category, setting_key, setting_value, created_at, updated_at) 
                    VALUES (?, ?, ?, NOW(), NOW())
                    ON DUPLICATE KEY UPDATE 
                    setting_value = VALUES(setting_value), 
                    updated_at = NOW()
                ");
                $stmt->execute([$category, $key, $value]);
            }
            
            $pdo->commit();
            return true;
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Error al guardar configuraciones: " . $e->getMessage());
            return false;
        }
    }
}