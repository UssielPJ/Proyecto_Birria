<?php

if (session_status() === PHP_SESSION_NONE) {
  session_set_cookie_params([
    'path'     => '/',          // ¡clave! aplica a todo birria.local
    'httponly' => true,
    'samesite' => 'Lax'
    // 'domain' => 'birria.local', // normalmente no hace falta, úsalo solo si lo requieres
  ]);
  session_start();
  // --- Compat: normaliza sesión para código viejo ---
  if (!empty($_SESSION['user']['roles']) && is_array($_SESSION['user']['roles'])) {
    // Copias para código que aún usa las claves antiguas
    $_SESSION['roles'] = $_SESSION['user']['roles'];      // array de slugs
    $_SESSION['role']  = $_SESSION['user']['roles'][0];   // primer rol
  }
}

/* ==========================================================
 * CARGA DEL .env (para variables de entorno en PHP)
 * ========================================================== */

require_once __DIR__ . '/../../vendor/autoload.php'; // Ajusta si tu vendor está fuera de /src
use Dotenv\Dotenv;

try {
  // Carga el archivo .env desde la raíz del proyecto
  $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
  $dotenv->load();
} catch (Exception $e) {
  error_log("⚠️ No se pudo cargar .env: " . $e->getMessage());
}

/* ==========================================================
 * CARGA DEL CORE Y CONTROLADORES/MODELOS/HELPERS
 * ========================================================== */

foreach (glob(__DIR__ . '/app/core/*.php') as $f) require_once $f;
foreach (glob(__DIR__ . '/app/controllers/*.php') as $f) require_once $f;
foreach (glob(__DIR__ . '/app/models/*.php') as $f) require_once $f;
foreach (glob(__DIR__ . '/app/helpers/*.php') as $f) require_once $f; // <--- NUEVO

// configurar storage y garantizar carpetas
$__filesCfg = require __DIR__ . '/app/config/files.php';
\App\Helpers\Storage::ensureDirs($__filesCfg);

use App\Core\Router;
use App\Controllers\AuthController;
use App\Controllers\NotificationsController;
use App\Controllers\PaymentsController;
use App\Controllers\CoursesController;
use App\Controllers\ScheduleController;
use App\Controllers\GradesController;
use App\Controllers\SurveysController;
use App\Controllers\ScholarshipsController;
use App\Controllers\AnnouncementsController;
use App\Controllers\StudentsController;
use App\Controllers\TeachersController;
use App\Controllers\SubjectsController;
use App\Controllers\SettingsController;
use App\Controllers\CapturistaImportarController;
use App\Controllers\CapturistaAlumnosController;
use App\Controllers\CapturistaInscripcionesController;
use App\Controllers\CapturistaReportesController;
use App\Controllers\SolicitudesController;
use App\Controllers\GroupsController;
use App\Controllers\GroupAssignmentsController;
use App\Controllers\ClassesController;
use App\Controllers\RoomsController;
use App\Controllers\PeriodsController;
use App\Controllers\CareersController;
use App\Controllers\SemestersController;
use App\Controllers\MateriaGrupoController;
use App\Controllers\MateriaGrupoProfesorController;
use App\Controllers\TeacherCoursesController;
use App\Controllers\CapturistaProfilesController;
use App\Controllers\ChatController;
use App\Controllers\HorariosController;
use App\Controllers\AttendanceController;

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

$map('GET', '/src/plataforma/debug/session', function () {
  if (session_status()===PHP_SESSION_NONE) session_start();
  header('Content-Type:text/plain; charset=utf-8');
  var_dump($_SESSION);
  exit;
});


/* ========== Auth ========== */
$map('GET',  '/src/plataforma',         [new AuthController, 'showLogin']); // sin slash
$map('GET',  '/src/plataforma/',        [new AuthController, 'showLogin']); // con slash (por claridad)
$map('POST', '/src/plataforma/login',   [new AuthController, 'login']);

// Mantén tu ruta existente:
$map('GET',  '/src/plataforma/logout',  [new AuthController, 'logout']);
// (Opcional, más seguro) también aceptar POST:
$map('POST', '/src/plataforma/logout',  [new AuthController, 'logout']);

/* ========== Panel ALUMNO (requiere login) ========== */
$map('GET', '/src/plataforma/app',                [new \App\Controllers\StudentDashboardController,'index']);
$map('GET', '/src/plataforma/app/materias',       [new CoursesController,        'index']);
$map('GET', '/src/plataforma/app/tareas',         [new \App\Controllers\TasksController,          'index']);
$map('GET', '/src/plataforma/app/tareas/pending', [new \App\Controllers\TasksController,          'pending']);
$map('GET', '/src/plataforma/app/tareas/submitted', [new \App\Controllers\TasksController,          'submitted']);
$map('GET', '/src/plataforma/app/tareas/overdue', [new \App\Controllers\TasksController,          'overdue']);
$map('GET', '/src/plataforma/app/tareas/view/{id}', [new \App\Controllers\TasksController,          'view']);
$map('GET', '/src/plataforma/app/tareas/submit/{id}', [new \App\Controllers\TasksController,          'submit']);
$map('POST', '/src/plataforma/app/tareas/submit/{id}',    [new \App\Controllers\TasksController, 'storeSubmission']);
$map('POST', '/src/plataforma/app/tareas/store/{id}', [new \App\Controllers\TasksController,          'storeSubmission']);
// Ver el examen (formulario)
$map('GET',  '/src/plataforma/app/tareas/exam/{id}',        [new \App\Controllers\TasksController, 'exam']);
// Enviar respuestas del examen
$map('POST', '/src/plataforma/app/tareas/exam/{id}',  [new \App\Controllers\TasksController, 'storeExam']);
$map('GET', '/src/plataforma/app/horario',        [new HorariosController,       'horarioAlumno']);
$map('GET', '/src/plataforma/app/calificaciones', [new GradesController,         'index']);
$map('GET', '/src/plataforma/app/encuestas',      [new SurveysController,        'index']);
$map('GET', '/src/plataforma/app/becas',          [new ScholarshipsController,   'index']);
$map('GET', '/src/plataforma/app/anuncios',       [new AnnouncementsController,  'index']);

/* ========== Student Profile Routes ========== */
$map('GET',  '/src/plataforma/app/student/profile',          [new StudentsController, 'profile']);
$map('GET',  '/src/plataforma/app/student/profile/edit',     [new StudentsController, 'editProfile']);
$map('POST', '/src/plataforma/app/student/profile/update',   [new StudentsController, 'updateProfile']);

/* ========== Student Scholarships Routes ========== */
$map('GET',  '/src/plataforma/app/scholarships',             [new ScholarshipsController, 'index']);
$map('GET',  '/src/plataforma/app/scholarships/apply/{id}',  [new ScholarshipsController, 'apply']);
$map('POST', '/src/plataforma/app/scholarships/apply/{id}',  [new ScholarshipsController, 'submitApplication']);

/* ========== Student Surveys Routes ========== */
$map('GET',  '/src/plataforma/app/surveys',                  [new SurveysController, 'index']);
$map('GET',  '/src/plataforma/app/surveys/take/{id}',        [new SurveysController, 'take']);
$map('POST', '/src/plataforma/app/surveys/submit/{id}',      [new SurveysController, 'submit']);


/* ========== Chat Routes (vista) ========== */
$map('GET', '/src/plataforma/app/chat',            [new ChatController, 'index']);

/* Opcionales por dashboard (misma vista; el layout se decide por rol en la vista) */
$map('GET', '/src/plataforma/app/admin/chat',      [new ChatController, 'index']);
$map('GET', '/src/plataforma/app/teacher/chat',    [new ChatController, 'index']);
$map('GET', '/src/plataforma/app/student/chat',    [new ChatController, 'index']);
$map('GET', '/src/plataforma/app/capturista/chat', [new ChatController, 'index']);

/* ========== Chat API ========== */
$map('GET',  '/src/plataforma/app/chat/token',         [new ChatController, 'token']);        // JWT para Socket.IO
$map('GET',  '/src/plataforma/app/chat/conversations', [new ChatController, 'conversations']); // lista conversaciones
$map('GET',  '/src/plataforma/app/chat/contacts',      [new ChatController, 'contacts']);      // buscar/listar usuarios
$map('GET',  '/src/plataforma/app/chat/messages/{id}', [new ChatController, 'messages']);      // historial por conversación
$map('POST', '/src/plataforma/app/chat/start',         [new ChatController, 'start']);         // crear/abrir 1-1
$map('POST', '/src/plataforma/app/chat/send',          [new ChatController, 'send']);          // fallback HTTP enviar



/* ========== Panel MAESTRO ========== */
$map('GET', '/src/plataforma/app/teacher',            [new \App\Controllers\TeacherDashboardController,'index']);
$map('GET', '/src/plataforma/app/teacher/courses',    [new CoursesController, 'index']);
// Hub del curso (mg_id por query ?id=...)
$map('GET',  '/src/plataforma/app/teacher/courses/show', [new TeacherCoursesController, 'show']);
$map('POST', '/src/plataforma/app/teacher/courses/task/store', [new TeacherCoursesController, 'storeTask']);
$map('POST', '/src/plataforma/app/teacher/courses/task/grade', [new TeacherCoursesController, 'gradeSubmission']);
$map('POST', '/src/plataforma/app/teacher/courses/resource/store', [new TeacherCoursesController, 'storeResource']);

// Horario para DOCENTE (vista propia del maestro)
$map('GET', '/src/plataforma/app/teacher/horario', [new HorariosController, 'horarioDocente']);

$map('GET', '/src/plataforma/app/teacher/grades',     [new GradesController, 'index']);
$map('GET', '/src/plataforma/app/teacher/students',   [new StudentsController, 'index']);
$map('GET', '/src/plataforma/app/teacher/attendance', [new AttendanceController, 'index']);
$map('GET', '/src/plataforma/app/teacher/announcements', [new AnnouncementsController, 'index']);

/* ========== Teacher Subjects Routes ========== */
$map('GET',  '/src/plataforma/app/teacher/subjects',          [new SubjectsController, 'index']);
$map('GET',  '/src/plataforma/app/teacher/subjects/create',   [new SubjectsController, 'create']);
$map('POST', '/src/plataforma/app/teacher/subjects/store',    [new SubjectsController, 'store']);
$map('GET',  '/src/plataforma/app/teacher/subjects/edit/{id}',[new SubjectsController, 'edit']);
$map('POST', '/src/plataforma/app/teacher/subjects/update/{id}',[new SubjectsController, 'update']);
$map('POST', '/src/plataforma/app/teacher/subjects/delete/{id}',[new SubjectsController, 'delete']);

/* ========== Teacher Grades Routes ========== */
$map('GET',  '/src/plataforma/app/teacher/grades/create',   [new GradesController, 'create']);
$map('POST', '/src/plataforma/app/teacher/grades/store',    [new GradesController, 'store']);
$map('GET',  '/src/plataforma/app/teacher/grades/edit/{id}',[new GradesController, 'edit']);
$map('POST', '/src/plataforma/app/teacher/grades/update/{id}',[new GradesController, 'update']);

/* ========== Teacher Surveys Routes ========== */
$map('GET',  '/src/plataforma/app/teacher/surveys',          [new SurveysController, 'index']);
$map('GET',  '/src/plataforma/app/teacher/surveys/create',   [new SurveysController, 'create']);
$map('POST', '/src/plataforma/app/teacher/surveys/store',    [new SurveysController, 'store']);
$map('GET',  '/src/plataforma/app/teacher/surveys/edit/{id}',[new SurveysController, 'edit']);
$map('POST', '/src/plataforma/app/teacher/surveys/update/{id}',[new SurveysController, 'update']);
$map('POST', '/src/plataforma/app/teacher/surveys/delete/{id}',[new SurveysController, 'delete']);

/* ========== Teacher Announcements Routes ========== */
$map('GET',  '/src/plataforma/app/teacher/announcements',             [new \App\Controllers\AnnouncementsController, 'index']);
$map('GET',  '/src/plataforma/app/teacher/announcements/create',      [new \App\Controllers\AnnouncementsController, 'create']);
$map('POST', '/src/plataforma/app/teacher/announcements/store',       [new \App\Controllers\AnnouncementsController, 'store']);
$map('GET',  '/src/plataforma/app/teacher/announcements/edit/{id}',   [new \App\Controllers\AnnouncementsController, 'edit']);
$map('POST', '/src/plataforma/app/teacher/announcements/update/{id}', [new \App\Controllers\AnnouncementsController, 'update']);
$map('POST', '/src/plataforma/app/teacher/announcements/delete/{id}', [new \App\Controllers\AnnouncementsController, 'delete']);


/* ========== Panel ADMIN ========== */

$map('GET', '/src/plataforma/admin',              [new \App\Controllers\AdminDashboardController,'index']);
$map('GET', '/src/plataforma/app/admin',          [new \App\Controllers\AdminDashboardController,'index']);
$map('GET', '/src/plataforma/app/admin/students', [new StudentsController, 'index']);
// --- Admin Students (faltaban) ---
$map('GET',  '/src/plataforma/app/admin/students/create',   [new StudentsController, 'create']);
$map('POST', '/src/plataforma/app/admin/students/store',    [new StudentsController, 'store']);
$map('GET',  '/src/plataforma/app/admin/students/edit/{id}',[new StudentsController, 'edit']);
$map('POST', '/src/plataforma/app/admin/students/update/{id}',[new StudentsController, 'update']);
$map('POST', '/src/plataforma/app/admin/students/delete/{id}',[new StudentsController, 'delete']);
$map('GET', '/src/plataforma/app/admin/capturistas', [new CapturistaProfilesController, 'index']);
$map('GET', '/src/plataforma/app/admin/capturistas/create', [new CapturistaProfilesController, 'create']);
$map('POST', '/src/plataforma/app/admin/capturistas/store', [new CapturistaProfilesController, 'store']);
$map('GET', '/src/plataforma/app/admin/capturistas/edit/{id}', [new CapturistaProfilesController, 'edit']);
$map('POST', '/src/plataforma/app/admin/capturistas/update/{id}', [new CapturistaProfilesController, 'update']);
$map('POST', '/src/plataforma/app/admin/capturistas/delete/{id}', [new CapturistaProfilesController, 'delete']);
$map('GET', '/src/plataforma/app/admin/capturistas/next-numero', [new CapturistaProfilesController, 'nextNumero']);
// --- Admin Capturista ---//



$map('GET', '/src/plataforma/app/admin/teachers', [new TeachersController, 'index']);
$map('GET', '/src/plataforma/app/admin/teachers/export', [new TeachersController, 'export']);
$map('GET', '/src/plataforma/app/admin/teachers/create', [new TeachersController, 'create']);
$map('POST', '/src/plataforma/app/admin/teachers/store', [new TeachersController, 'store']);
$map('GET', '/src/plataforma/app/admin/teachers/edit/{id}', [new TeachersController, 'edit']);
$map('POST', '/src/plataforma/app/admin/teachers/update/{id}', [new TeachersController, 'update']);
$map('POST', '/src/plataforma/app/admin/teachers/delete/{id}', [new TeachersController, 'delete']);


/* ========== Admin Horarios Routes ========== */

// Listado de grupos + estado del horario
$map('GET',  '/src/plataforma/app/admin/horarios',                               [new HorariosController, 'index']);

// Configurar horas por semana para un grupo
$map('GET',  '/src/plataforma/app/admin/horarios/configurar-horas/{id}',       [new HorariosController, 'configurarHoras']);
$map('POST', '/src/plataforma/app/admin/horarios/guardar-horas/{id}',          [new HorariosController, 'guardarHoras']);

// Generar horario automático (borrador)
$map('GET',  '/src/plataforma/app/admin/horarios/generar/{id}',                [new HorariosController, 'generar']);

// Vista previa del horario generado
$map('GET',  '/src/plataforma/app/admin/horarios/vista-previa/{id}',           [new HorariosController, 'vistaPrevia']);

// Guardar horario definitivo
$map('POST', '/src/plataforma/app/admin/horarios/guardar/{id}',                [new HorariosController, 'guardarHorario']);

// Ver horario de un grupo (solo lectura, estilo alumno)
$map('GET',  '/src/plataforma/app/admin/groups/horario/{id}',                  [new HorariosController, 'verHorarioGrupo']);




/* ========== Admin Groups Routes ========== */
$map('GET',  '/src/plataforma/app/admin/groups/create',        [new GroupsController, 'create']);
$map('POST', '/src/plataforma/app/admin/groups/store',         [new GroupsController, 'store']);
$map('GET',  '/src/plataforma/app/admin/groups/edit/{id}',     [new GroupsController, 'edit']);
$map('POST', '/src/plataforma/app/admin/groups/update/{id}',   [new GroupsController, 'update']);
$map('POST', '/src/plataforma/app/admin/groups/delete/{id}',   [new GroupsController, 'delete']);
$map('GET',  '/src/plataforma/app/admin/groups',               [new GroupsController, 'index']);
$map('GET',  '/src/plataforma/app/admin/groups/students/{id}',               [new GroupsController, 'students']);
// Vista previa y ejecución
$map('GET',  '/src/plataforma/app/admin/groups/assign-matriculas/{id}', [new \App\Controllers\GroupsController, 'assignMatriculasPreview']);
$map('POST', '/src/plataforma/app/admin/groups/assign-matriculas/{id}', [new \App\Controllers\GroupsController, 'assignMatriculasRun']);


/*========== Admin Groups assignments Routes ========== */
$map('GET',  '/src/plataforma/app/admin/group_assignments',        [new GroupAssignmentsController, 'index']);
$map('POST', '/src/plataforma/app/admin/group_assignments/assign', [new GroupAssignmentsController, 'assign']);
$map('POST', '/src/plataforma/app/admin/group_assignments/unassign',[new GroupAssignmentsController, 'unassign']);

/*  ======== Admin Classes Routes ========== */
$map('GET',  '/src/plataforma/app/admin/classes',             [new ClassesController, 'index']);
$map('POST', '/src/plataforma/app/admin/classes/store',       [new ClassesController, 'store']);
$map('GET',  '/src/plataforma/app/admin/classes/edit/{id}',   [new ClassesController, 'edit']);
$map('POST', '/src/plataforma/app/admin/classes/update/{id}', [new ClassesController, 'update']);
$map('POST', '/src/plataforma/app/admin/classes/delete/{id}', [new ClassesController, 'delete']);

/*  ======== Admin Rooms Routes ========== */
$map('GET',  '/src/plataforma/app/admin/rooms',             [new RoomsController, 'index']);
$map('POST', '/src/plataforma/app/admin/rooms/store',       [new RoomsController, 'store']);
$map('GET',  '/src/plataforma/app/admin/rooms/edit/{id}',   [new RoomsController, 'edit']);
$map('POST', '/src/plataforma/app/admin/rooms/update/{id}', [new RoomsController, 'update']);
$map('POST', '/src/plataforma/app/admin/rooms/delete/{id}', [new RoomsController, 'delete']);

/*  ========= Admin Periods Routes ========== */
$map('GET',  '/src/plataforma/app/admin/periods',             [new PeriodsController, 'index']);
$map('POST', '/src/plataforma/app/admin/periods/store',       [new PeriodsController, 'store']);
$map('GET',  '/src/plataforma/app/admin/periods/edit/{id}',   [new PeriodsController, 'edit']);
$map('POST', '/src/plataforma/app/admin/periods/update/{id}', [new PeriodsController, 'update']);
$map('POST', '/src/plataforma/app/admin/periods/delete/{id}', [new PeriodsController, 'delete']);

/* ========= Admin Careers Routes ========== */
$map('GET',  '/src/plataforma/app/admin/careers',               [new CareersController, 'index']);
$map('GET',  '/src/plataforma/app/admin/careers/create',        [new CareersController, 'create']);
$map('POST', '/src/plataforma/app/admin/careers/store',         [new CareersController, 'store']);
$map('GET',  '/src/plataforma/app/admin/careers/edit/{id}',     [new CareersController, 'edit']);
$map('POST', '/src/plataforma/app/admin/careers/update/{id}',   [new CareersController, 'update']);
$map('POST', '/src/plataforma/app/admin/careers/delete/{id}',   [new CareersController, 'delete']);

/* ========= Admin Semesters Routes ========== */
$map('GET',  '/src/plataforma/app/admin/semesters',               [new SemestersController, 'index']);
$map('GET',  '/src/plataforma/app/admin/semesters/create',        [new SemestersController, 'create']);
$map('POST', '/src/plataforma/app/admin/semesters/store',         [new SemestersController, 'store']);
$map('GET',  '/src/plataforma/app/admin/semesters/edit/{id}',     [new SemestersController, 'edit']);
$map('POST', '/src/plataforma/app/admin/semesters/update/{id}',   [new SemestersController, 'update']);
$map('POST', '/src/plataforma/app/admin/semesters/delete/{id}',   [new SemestersController, 'delete']);

/* ========== Admin Schedule Routes ========== */
$map('GET',  '/src/plataforma/app/admin/schedule',            [new \App\Controllers\ScheduleController,'index']);
$map('GET',  '/src/plataforma/app/admin/schedule/add',        [new \App\Controllers\ScheduleController,'add']);
$map('POST', '/src/plataforma/app/admin/schedule/store',      [new \App\Controllers\ScheduleController,'store']);
$map('GET',  '/src/plataforma/app/admin/schedule/edit/{id}',  [new \App\Controllers\ScheduleController,'edit']);
$map('POST', '/src/plataforma/app/admin/schedule/update/{id}',[new \App\Controllers\ScheduleController,'update']);
$map('POST', '/src/plataforma/app/admin/schedule/{id}/delete',[new \App\Controllers\ScheduleController,'delete']);



/* ========== Subjects Routes ========== */
$map('GET',  '/src/plataforma/app/admin/subjects',          [new SubjectsController, 'index']);
$map('GET',  '/src/plataforma/app/admin/subjects/create',   [new SubjectsController, 'create']);
$map('POST', '/src/plataforma/app/admin/subjects/store',    [new SubjectsController, 'store']);
$map('GET',  '/src/plataforma/app/admin/subjects/edit/{id}',[new SubjectsController, 'edit']);
$map('POST', '/src/plataforma/app/admin/subjects/update/{id}',[new SubjectsController, 'update']);
$map('POST', '/src/plataforma/app/admin/subjects/delete/{id}',[new SubjectsController, 'delete']);
$map('GET',  '/src/plataforma/app/admin/subjects/show/{id}',  [new SubjectsController, 'show']);

/* ========== Admin Payments Routes ========== */
$map('GET',  '/src/plataforma/app/admin/payments',          [new PaymentsController, 'index']);
$map('GET',  '/src/plataforma/app/admin/payments/create',   [new PaymentsController, 'create']);
$map('POST', '/src/plataforma/app/admin/payments/store',    [new PaymentsController, 'store']);
$map('GET',  '/src/plataforma/app/admin/payments/edit/{id}',[new PaymentsController, 'edit']);
$map('POST', '/src/plataforma/app/admin/payments/update/{id}',[new PaymentsController, 'update']);
$map('POST', '/src/plataforma/app/admin/payments/delete/{id}',[new PaymentsController, 'delete']);

/* ========== Admin Settings Routes ========== */
$map('GET',  '/src/plataforma/app/admin/settings',          [new SettingsController, 'index']);
$map('POST', '/src/plataforma/app/admin/settings/update-general', [new SettingsController, 'updateGeneral']);
$map('POST', '/src/plataforma/app/admin/settings/update-academic', [new SettingsController, 'updateAcademic']);
$map('POST', '/src/plataforma/app/admin/settings/update-notifications', [new SettingsController, 'updateNotifications']);

/* ========== Admin Grades Routes ========== */
$map('GET',  '/src/plataforma/app/admin/grades',          [new GradesController, 'index']);
$map('GET',  '/src/plataforma/app/admin/grades/create',   [new GradesController, 'create']);
$map('POST', '/src/plataforma/app/admin/grades/store',    [new GradesController, 'store']);
$map('GET',  '/src/plataforma/app/admin/grades/edit/{id}',[new GradesController, 'edit']);
$map('POST', '/src/plataforma/app/admin/grades/update/{id}',[new GradesController, 'update']);

/* ========== Admin Scholarships Routes ========== */
$map('GET',  '/src/plataforma/app/admin/scholarships',          [new ScholarshipsController, 'index']);
$map('GET',  '/src/plataforma/app/admin/scholarships/create',   [new ScholarshipsController, 'create']);
$map('POST', '/src/plataforma/app/admin/scholarships/store',    [new ScholarshipsController, 'store']);
$map('GET',  '/src/plataforma/app/admin/scholarships/edit/{id}',[new ScholarshipsController, 'edit']);
$map('POST', '/src/plataforma/app/admin/scholarships/update/{id}',[new ScholarshipsController, 'update']);
$map('POST', '/src/plataforma/app/admin/scholarships/delete/{id}',[new ScholarshipsController, 'delete']);

/* ========== Admin Surveys Routes ========== */
$map('GET',  '/src/plataforma/app/admin/surveys',          [new SurveysController, 'index']);
$map('GET',  '/src/plataforma/app/admin/surveys/create',   [new SurveysController, 'create']);
$map('POST', '/src/plataforma/app/admin/surveys/store',    [new SurveysController, 'store']);
$map('GET',  '/src/plataforma/app/admin/surveys/edit/{id}',[new SurveysController, 'edit']);
$map('POST', '/src/plataforma/app/admin/surveys/update/{id}',[new SurveysController, 'update']);
$map('POST', '/src/plataforma/app/admin/surveys/delete/{id}',[new SurveysController, 'delete']);

/* ========== Admin Announcements Routes ========== */
$map('GET',  '/src/plataforma/app/admin/announcements',          [new AnnouncementsController, 'index']);
$map('GET',  '/src/plataforma/app/admin/announcements/create',   [new AnnouncementsController, 'create']);
$map('POST', '/src/plataforma/app/admin/announcements/store',    [new AnnouncementsController, 'store']);
$map('GET',  '/src/plataforma/app/admin/announcements/edit/{id}',[new AnnouncementsController, 'edit']);
$map('POST', '/src/plataforma/app/admin/announcements/update/{id}',[new AnnouncementsController, 'update']);
$map('POST', '/src/plataforma/app/admin/announcements/delete/{id}',[new AnnouncementsController, 'delete']);

/* ========== Admin Materia-grupo Routes ========== */
$map('GET',  '/src/plataforma/app/admin/materias-grupos',          [new MateriaGrupoController, 'index']);
$map('GET',  '/src/plataforma/app/admin/materias-grupos/create',   [new MateriaGrupoController, 'create']);
$map('POST', '/src/plataforma/app/admin/materias-grupos/store',    [new MateriaGrupoController, 'store']);
$map('GET',  '/src/plataforma/app/admin/materias-grupos/edit/{id}',[new MateriaGrupoController, 'edit']);
$map('POST', '/src/plataforma/app/admin/materias-grupos/update/{id}',[new MateriaGrupoController, 'update']);
$map('POST', '/src/plataforma/app/admin/materias-grupos/delete/{id}', [new MateriaGrupoController, 'delete']);

/* ========== Admin MG-Profesores Routes ========== */
$map('GET',  '/src/plataforma/app/admin/mg-profesores',             [new MateriaGrupoProfesorController, 'index']);
$map('GET',  '/src/plataforma/app/admin/mg-profesores/create',      [new MateriaGrupoProfesorController, 'create']);
$map('POST', '/src/plataforma/app/admin/mg-profesores/store',       [new MateriaGrupoProfesorController, 'store']);
$map('GET',  '/src/plataforma/app/admin/mg-profesores/edit/{id}',   [new MateriaGrupoProfesorController, 'edit']);
$map('POST', '/src/plataforma/app/admin/mg-profesores/update/{id}', [new MateriaGrupoProfesorController, 'update']);
$map('POST', '/src/plataforma/app/admin/mg-profesores/delete/{id}', [new MateriaGrupoProfesorController, 'delete']);



/* ========== Notifications Routes ========== */
$map('GET',  '/src/plataforma/api/notifications',          [new NotificationsController, 'getUnread']);
$map('POST', '/src/plataforma/api/notifications/read',     [new NotificationsController, 'markAsRead']);
$map('POST', '/src/plataforma/api/notifications/read-all', [new NotificationsController, 'markAllAsRead']);

/* ========== Panel CAPTURISTA ========== */
$map('GET', '/src/plataforma/capturista', [new \App\Controllers\CapturistaDashboardController,'index']);

/* ========== Funcionalidades del Capturista ========== */
// Importar
$map('GET', '/src/plataforma/capturista/importar', [new CapturistaImportarController,'index']);
$map('GET', '/src/plataforma/capturista/importar/historial', [new CapturistaImportarController,'historial']);
$map('GET', '/src/plataforma/capturista/importar/estado', [new CapturistaImportarController,'estado']);
$map('POST', '/src/plataforma/capturista/importar/procesar', [new CapturistaImportarController,'procesar']);

// Alumnos
$map('GET', '/src/plataforma/capturista/alumnos', [new CapturistaAlumnosController,'index']);
$map('GET', '/src/plataforma/capturista/alumnos/crear', [new CapturistaAlumnosController,'crear']);
$map('GET', '/src/plataforma/capturista/alumnos/editar/{id}', [new CapturistaAlumnosController,'editar']);
$map('POST', '/src/plataforma/capturista/alumnos/guardar', [new CapturistaAlumnosController,'guardar']);
$map('POST', '/src/plataforma/capturista/alumnos/eliminar/{id}', [new CapturistaAlumnosController,'eliminar']);

// Reportes
$map('GET', '/src/plataforma/capturista/reportes', [new CapturistaReportesController,'index']);
$map('GET', '/src/plataforma/capturista/reportes/estudiantes', [new CapturistaReportesController,'estudiantes']);
$map('GET', '/src/plataforma/capturista/reportes/profesores', [new CapturistaReportesController,'profesores']);
$map('GET', '/src/plataforma/capturista/reportes/cursos', [new CapturistaReportesController,'cursos']);
$map('GET', '/src/plataforma/capturista/reportes/calificaciones', [new CapturistaReportesController,'calificaciones']);
$map('POST', '/src/plataforma/capturista/reportes/generar', [new CapturistaReportesController,'generar']);

// Capturista · Inscripciones
$map('GET',  '/src/plataforma/app/capturista/inscripciones',                [new CapturistaInscripcionesController, 'index']);
$map('GET',  '/src/plataforma/app/capturista/inscripciones/nueva',          [new CapturistaInscripcionesController, 'nueva']);
$map('POST', '/src/plataforma/app/capturista/inscripciones/guardar',        [new CapturistaInscripcionesController, 'guardar']);
$map('GET',  '/src/plataforma/app/capturista/inscripciones/editar/{id}',    [new CapturistaInscripcionesController, 'editar']);
$map('POST', '/src/plataforma/app/capturista/inscripciones/eliminar/{id}',  [new CapturistaInscripcionesController, 'eliminar']);

// Capturista · Solicitudes
$map('GET', '/src/plataforma/app/capturista/solicitudes',                  [new SolicitudesController, 'index']);
$map('GET', '/src/plataforma/app/capturista/solicitudes/nueva',            [new SolicitudesController, 'nueva']);
$map('POST', '/src/plataforma/app/capturista/solicitudes/guardar',         [new SolicitudesController, 'guardar']);
$map('GET', '/src/plataforma/app/capturista/solicitudes/editar/{id}',      [new SolicitudesController, 'editar']);
$map('POST', '/src/plataforma/app/capturista/solicitudes/eliminar/{id}',   [new SolicitudesController, 'eliminar']);


$router->dispatch();
