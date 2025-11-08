<?php
$map('GET', '/ping', function () {
  header('Content-Type: text/plain; charset=utf-8');
  echo "pong";
});

use App\Controllers\AuthController;
use App\Controllers\AdminDashboardController;
use App\Controllers\ChatController;
use App\Controllers\api\ChatApiController;
use App\Controllers\NotificationsController;

/* ========== Notifications Routes ========== */
$map('GET', '/api/notifications',          [new NotificationsController, 'getUnread']);
$map('POST', '/api/notifications/read',    [new NotificationsController, 'markAsRead']);
$map('POST', '/api/notifications/read-all',[new NotificationsController, 'markAllAsRead']);

/* ========== Auth Routes ========== */
$map('GET', '/login',  [new AuthController, 'showLogin']);
$map('POST', '/login', [new AuthController, 'login']);
$map('GET', '/logout', [new AuthController, 'logout']);
$map('GET',  '/admin',  [new AdminDashboardController,'index']);
$map('GET',  '/chat',   [new ChatController,'index']);

/* ========== Chat API Routes ========== */
$map('GET',  '/api/chat/conversations', [new ChatApiController,'getConversations']);
$map('GET',  '/api/chat/messages',      [new ChatApiController,'getMessages']);
$map('POST', '/api/chat/send',         [new ChatApiController,'sendMessage']);
$map('GET',  '/api/chat/contacts',     [new ChatApiController,'getContacts']);