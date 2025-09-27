<?php
session_start();

// Reusar tu conexión y config
require __DIR__ . '/../db.php';
require __DIR__ . '/app/config/app.php';

// cargar core y controladores
foreach (glob(__DIR__ . '/app/core/*.php') as $f) require $f;
foreach (glob(__DIR__ . '/app/controllers/*.php') as $f) require $f;

$router = new Router();

/* ===== Helper local: registra una ruta con y sin barra final ===== */
$map = function($method, $path, $handler) use ($router) {
  if ($method === 'GET')  { $router->get($path,  $handler); }
  if ($method === 'POST') { $router->post($path, $handler); }
  // variante con slash final si no es raíz
  if ($path !== '/' && substr($path, -1) !== '/') {
    if ($method === 'GET')  { $router->get($path.'/',  $handler); }
    if ($method === 'POST') { $router->post($path.'/', $handler); }
  }
};

/* ========== Auth ========== */
$map('GET',  '/src/plataforma',         [new AuthController, 'showLogin']); // sin slash
$map('GET',  '/src/plataforma/',        [new AuthController, 'showLogin']); // con slash (por claridad)
$map('POST', '/src/plataforma/login',   [new AuthController, 'login']);
$map('GET',  '/src/plataforma/logout',  [new AuthController, 'logout']);

/* ========== Panel ALUMNO (requiere login) ========== */
$map('GET', '/src/plataforma/app',                [new StudentDashboardController,'index']);
$map('GET', '/src/plataforma/app/materias',       [new CoursesController,        'index']);
$map('GET', '/src/plataforma/app/horario',        [new ScheduleController,       'index']);
$map('GET', '/src/plataforma/app/calificaciones', [new GradesController,         'index']);
$map('GET', '/src/plataforma/app/encuestas',      [new SurveysController,        'index']);
$map('GET', '/src/plataforma/app/becas',          [new ScholarshipsController,   'index']);
$map('GET', '/src/plataforma/app/anuncios',       [new AnnouncementsController,  'index']);

/* ========== Panel MAESTRO ========== */
$map('GET', '/src/plataforma/teacher',            [new TeacherDashboardController,'index']);

/* ========== Panel ADMIN ========== */
$map('GET', '/src/plataforma/admin',              [new AdminDashboardController,'index']);


/* ========== Panel CAPTURISTA ========== */
$map('GET', '/src/plataforma/capturista', [new CapturistaDashboardController,'index']);

$router->dispatch();
