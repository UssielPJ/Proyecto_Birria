<?php

namespace App\Controllers;

use App\Models\Notification;

class NotificationsController {
    private $notificationModel;

    public function __construct() {
        $this->notificationModel = new Notification();
    }

    public function getUnread() {
        $userId = $_SESSION['user_id'];
        $notifications = $this->notificationModel->getUnreadNotifications($userId);
        $count = $this->notificationModel->getUnreadCount($userId);
        
        header('Content-Type: application/json');
        echo json_encode([
            'notifications' => $notifications,
            'count' => $count
        ]);
    }

    public function markAsRead() {
        if (!isset($_POST['notification_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Notification ID is required']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $notificationId = $_POST['notification_id'];
        
        $success = $this->notificationModel->markAsRead($notificationId, $userId);
        
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function markAllAsRead() {
        $userId = $_SESSION['user_id'];
        $success = $this->notificationModel->markAllAsRead($userId);
        
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }
}