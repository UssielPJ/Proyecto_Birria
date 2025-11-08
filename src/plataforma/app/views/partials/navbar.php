<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$role = $_SESSION['user']['roles'][0] ?? 'student';
  $menu = [];

  if ($role === 'admin') {
      // 🔹 Admin: agregamos navegación para Cohortes y Clases
      $menu = [
      // Panel principal
      ['href' => '/src/plataforma/app/admin/',          'icon' => 'home',        'text' => 'Panel'],

      // Personas
      ['href' => '/src/plataforma/app/admin/students',           'icon' => 'users',       'text' => 'Estudiantes'],
      ['href' => '/src/plataforma/app/admin/teachers',           'icon' => 'user-plus',   'text' => 'Profesores'],

      // Cohortes y organización académica
      ['href' => '/src/plataforma/app/admin/careers',            'icon' => 'layers',      'text' => 'Carreras'],
      ['href' => '/src/plataforma/app/admin/semesters',          'icon' => 'hash',        'text' => 'Semestres'],
      ['href' => '/src/plataforma/app/admin/groups',             'icon' => 'grid',        'text' => 'Grupos (Cohorte)'],
      ['href' => '/src/plataforma/app/admin/group_assignments',  'icon' => 'user-check',  'text' => 'Asignar a Grupo'],

      // Clases y estructura académica
      ['href' => '/src/plataforma/app/admin/subjects',           'icon' => 'book-open',   'text' => 'Materias'],
      ['href' => '/src/plataforma/app/admin/schedule',           'icon' => 'clock',       'text' => 'Horarios'],
      ['href' => '/src/plataforma/app/admin/materias-grupos',    'icon' => 'link',        'text' => 'Asignar Materias a Grupos'],
      ['href' => '/src/plataforma/app/admin/mg-profesores',       'icon' => 'user-check','text' => 'Asignar Profesor a Materia'],

      // Operación escolar
      ['href' => '/src/plataforma/app/admin/grades',             'icon' => 'award',       'text' => 'Calificaciones'],
      ['href' => '/src/plataforma/app/admin/scholarships',       'icon' => 'gift',        'text' => 'Becas'],
      ['href' => '/src/plataforma/app/admin/surveys',            'icon' => 'clipboard',   'text' => 'Encuestas'],
      ['href' => '/src/plataforma/app/admin/payments',           'icon' => 'dollar-sign', 'text' => 'Pagos'],

      // Sistema y comunicación
      ['href' => '/src/plataforma/app/admin/announcements',      'icon' => 'bell',        'text' => 'Anuncios'],
      ['href' => '/src/plataforma/app/admin/chat',                        'icon' => 'message-circle','text' => 'Chat'],
      ['href' => '/src/plataforma/app/admin/settings',           'icon' => 'settings',    'text' => 'Configuración'],
  ];

} elseif ($role === 'student') {
    $menu = [
        ['href' => '/src/plataforma/app',                   'icon' => 'home',       'text' => 'Panel'],
        ['href' => '/src/plataforma/app/student/profile',   'icon' => 'user',       'text' => 'Perfil'],
        ['href' => '/src/plataforma/app/materias',          'icon' => 'book-open',  'text' => 'Materias'],
        ['href' => '/src/plataforma/app/tareas',           'icon' => 'check-square','text' => 'Tareas'],
        ['href' => '/src/plataforma/app/horario',           'icon' => 'calendar',   'text' => 'Horario'],
        ['href' => '/src/plataforma/app/calificaciones',    'icon' => 'award',      'text' => 'Calificaciones'],
        ['href' => '/src/plataforma/app/scholarships',      'icon' => 'gift',       'text' => 'Becas'],
        ['href' => '/src/plataforma/app/surveys',           'icon' => 'clipboard',  'text' => 'Encuestas'],
        ['href' => '/src/plataforma/app/anuncios',          'icon' => 'bell',       'text' => 'Anuncios'],
        ['href' => '/src/plataforma/app/chat',      'icon' => 'message-circle','text' => 'Chat'],
    ];
} elseif ($role === 'teacher') {
    $menu = [
        ['href' => '/src/plataforma/app/teacher',           'icon' => 'home',       'text' => 'Panel'],
        ['href' => '/src/plataforma/app/teacher/subjects',  'icon' => 'book-open',  'text' => 'Materias'],
        ['href' => '/src/plataforma/app/teacher/courses',   'icon' => 'briefcase',  'text' => 'Mis Clases'],
        ['href' => '/src/plataforma/app/teacher/horario',   'icon' => 'calendar',   'text' => 'Horario'],
        ['href' => '/src/plataforma/app/teacher/students',  'icon' => 'users',      'text' => 'Estudiantes'],
        ['href' => '/src/plataforma/app/teacher/attendance','icon' => 'clipboard',  'text' => 'Asistencia'],
        ['href' => '/src/plataforma/app/teacher/grades',    'icon' => 'award',      'text' => 'Calificaciones'],
        ['href' => '/src/plataforma/app/teacher/surveys',   'icon' => 'edit-3',     'text' => 'Encuestas'],
        ['href' => '/src/plataforma/app/teacher/announcements','icon'=>'bell',      'text' => 'Anuncios'],
        ['href' => '/src/plataforma/app/teacher/chat',      'icon'=>'message-circle','text' => 'Chat'],
    ];
} elseif ($role === 'capturista') {
    $menu = [
        ['href' => '/src/plataforma/app/capturista',                    'icon' => 'home',        'text' => 'Panel'],
        ['href' => '/src/plataforma/app/capturista/solicitudes',                   'icon' => 'file-text',   'text' => 'Solicitudes'],
        ['href' => '/src/plataforma/app/capturista/solicitudes/nueva','icon'=>'edit-3',     'text' => 'Capturar solicitud'],
        ['href' => '/src/plataforma/app/capturista/importar',           'icon' => 'upload-cloud','text' => 'Importar CSV/Excel'],
        ['href' => '/src/plataforma/app/capturista/alumnos',            'icon' => 'users',       'text' => 'Alumnos'],
        ['href' => '/src/plataforma/app/capturista/inscripciones',      'icon' => 'check-circle','text' => 'Inscripciones'],
        ['href' => '/src/plataforma/app/capturista/reportes',           'icon' => 'bar-chart-2', 'text' => 'Reportes'],
        ['href' => '/src/plataforma/app/capturista/chat',           'icon' => 'message-circle','text' => 'Chat'],
    ];
}

$currentUri = $_SERVER['REQUEST_URI'] ?? '/';
?>
<nav class="p-4">
  <ul class="space-y-1 list-none">
    <?php foreach ($menu as $item): ?>
      <li>
        <a href="<?= htmlspecialchars($item['href']) ?>"
           class="nav-item group relative flex items-center px-4 py-3 rounded-xl font-medium text-neutral-600 dark:text-neutral-300 transition-all duration-300 ease-in-out hover:bg-gradient-to-r hover:from-primary-50 hover:to-primary-100 dark:hover:from-neutral-700 dark:hover:to-neutral-600 hover:text-primary-700 dark:hover:text-primary-300 hover:shadow-lg hover:scale-105 <?= strpos($currentUri, $item['href']) === 0 ? 'active bg-gradient-to-r from-primary-100 to-primary-200 dark:from-primary-900/50 dark:to-primary-800/50 text-primary-800 dark:text-primary-200 shadow-md' : '' ?>">
          <i data-feather="<?= htmlspecialchars($item['icon']) ?>" class="w-5 h-5 mr-3 shrink-0 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12"></i>
          <span class="nav-text transition-all duration-300 group-hover:translate-x-1"><?= htmlspecialchars($item['text']) ?></span>
          <?php if (strpos($currentUri, $item['href']) === 0): ?>
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-primary-500 rounded-r-full"></div>
          <?php endif; ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>

<style>
/* Soporta colapso por data-attr o clase */
#sidebar[data-collapsed="true"] .nav-text,
body.sidebar-collapsed .nav-text,
.sidebar-collapsed .nav-text { display: none !important; }

#sidebar[data-collapsed="true"] .nav-item,
body.sidebar-collapsed .nav-item,
.sidebar-collapsed .nav-item { justify-content: center; padding-left: .75rem; padding-right: .75rem; }

#sidebar[data-collapsed="true"] .nav-item i,
body.sidebar-collapsed .nav-item i,
.sidebar-collapsed .nav-item i { margin-right: 0 !important; }

nav ul { list-style: none; padding-left: 0; }
</style>
