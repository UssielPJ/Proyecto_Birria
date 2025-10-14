<?php
$map('GET', '/src/plataforma/ping', function () {
  header('Content-Type: text/plain; charset=utf-8');
  echo "pong";
});

use App\Controllers\AuthController;
use App\Controllers\AdminDashboardController;

require_once __DIR__ . '/controllers/NotificationsController.php';

/* ========== Notifications Routes ========== */
$map('GET', '/src/plataforma/api/notifications',          [new \App\Controllers\NotificationsController, 'getUnread']);
$map('POST', '/src/plataforma/api/notifications/read',    [new \App\Controllers\NotificationsController, 'markAsRead']);
$map('POST', '/src/plataforma/api/notifications/read-all',[new \App\Controllers\NotificationsController, 'markAllAsRead']);

/* ========== Auth Routes ========== */
$map('GET', '/src/plataforma/login',  [new AuthController, 'showLogin']);
$map('POST', '/src/plataforma/login', [new AuthController, 'login']);
$map('GET', '/src/plataforma/logout', [new AuthController, 'logout']);
$map('GET',  '/src/plataforma/admin',  [new AdminDashboardController,'index']);