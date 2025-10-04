<?php

use App\Controllers\AuthController;

require_once __DIR__ . '/controllers/NotificationsController.php';

/* ========== Notifications Routes ========== */
$map('GET', '/src/plataforma/api/notifications',          [new \App\Controllers\NotificationsController, 'getUnread']);
$map('POST', '/src/plataforma/api/notifications/read',    [new \App\Controllers\NotificationsController, 'markAsRead']);
$map('POST', '/src/plataforma/api/notifications/read-all',[new \App\Controllers\NotificationsController, 'markAllAsRead']);

/* ========== Auth Routes ========== */
$map('GET', '/src/plataforma/login',  [new AuthController, 'showLogin']);
$map('POST', '/src/plataforma/login', [new AuthController, 'login']);
$map('GET', '/src/plataforma/logout', [new AuthController, 'logout']);