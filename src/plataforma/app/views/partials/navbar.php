<?php
$role = $_SESSION['roles'][0] ?? 'student';
$menu = [];
if ($role === 'admin') {
    $menu = [
        ['href' => '/src/plataforma/app/admin', 'icon' => 'home', 'text' => 'Panel'],
        ['href' => '/src/plataforma/app/admin/students', 'icon' => 'users', 'text' => 'Estudiantes'],
        ['href' => '/src/plataforma/app/admin/teachers', 'icon' => 'user-plus', 'text' => 'Profesores'],
        ['href' => '/src/plataforma/app/admin/subjects', 'icon' => 'book-open', 'text' => 'Materias'],
        ['href' => '/src/plataforma/app/admin/schedule', 'icon' => 'calendar', 'text' => 'Horarios'],
        ['href' => '/src/plataforma/app/admin/grades', 'icon' => 'award', 'text' => 'Calificaciones'],
        ['href' => '/src/plataforma/app/admin/scholarships', 'icon' => 'gift', 'text' => 'Becas'],
        ['href' => '/src/plataforma/app/admin/surveys', 'icon' => 'clipboard', 'text' => 'Encuestas'],
        ['href' => '/src/plataforma/app/admin/payments', 'icon' => 'dollar-sign', 'text' => 'Pagos'],
        ['href' => '/src/plataforma/app/admin/settings', 'icon' => 'settings', 'text' => 'Configuración'],
        ['href' => '/src/plataforma/app/admin/announcements', 'icon' => 'bell', 'text' => 'Anuncios'],
    ];
} elseif ($role === 'student') {
    $menu = [
        ['href' => '/src/plataforma/app', 'icon' => 'home', 'text' => 'Panel'],
        ['href' => '/src/plataforma/app/student/profile', 'icon' => 'user', 'text' => 'Perfil'],
        ['href' => '/src/plataforma/app/materias', 'icon' => 'book-open', 'text' => 'Materias'],
        ['href' => '/src/plataforma/app/horario', 'icon' => 'calendar', 'text' => 'Horario'],
        ['href' => '/src/plataforma/app/calificaciones', 'icon' => 'award', 'text' => 'Calificaciones'],
        ['href' => '/src/plataforma/app/scholarships', 'icon' => 'gift', 'text' => 'Becas'],
        ['href' => '/src/plataforma/app/surveys', 'icon' => 'clipboard', 'text' => 'Encuestas'],
        ['href' => '/src/plataforma/app/anuncios', 'icon' => 'bell', 'text' => 'Anuncios'],
    ];
} elseif ($role === 'teacher') {
    $menu = [
        ['href' => '/src/plataforma/app/teacher', 'icon' => 'home', 'text' => 'Panel'],
        ['href' => '/src/plataforma/app/teacher/subjects', 'icon' => 'book-open', 'text' => 'Materias'],
        ['href' => '/src/plataforma/app/teacher/grades', 'icon' => 'award', 'text' => 'Calificaciones'],
        ['href' => '/src/plataforma/app/teacher/surveys', 'icon' => 'clipboard', 'text' => 'Encuestas'],
        ['href' => '/src/plataforma/app/teacher/courses', 'icon' => 'book-open', 'text' => 'Mis Clases'],
        ['href' => '/src/plataforma/app/teacher/horario', 'icon' => 'calendar', 'text' => 'Horario'],
        ['href' => '/src/plataforma/app/teacher/students', 'icon' => 'users', 'text' => 'Estudiantes'],
        ['href' => '/src/plataforma/app/teacher/attendance', 'icon' => 'clipboard', 'text' => 'Asistencia'],
        ['href' => '/src/plataforma/app/teacher/announcements', 'icon' => 'bell', 'text' => 'Anuncios'],
    ];
} elseif ($role === 'capturista') {
    $menu = [
        ['href' => '/src/plataforma/capturista', 'icon' => 'home', 'text' => 'Panel'],
        ['href' => '/src/plataforma/solicitudes', 'icon' => 'file-text', 'text' => 'Solicitudes'],
        ['href' => '/src/plataforma/solicitudes/nueva', 'icon' => 'edit-3', 'text' => 'Capturar solicitud'],
        ['href' => '/src/plataforma/capturista/importar', 'icon' => 'upload-cloud', 'text' => 'Importar CSV/Excel'],
        ['href' => '/src/plataforma/capturista/alumnos', 'icon' => 'users', 'text' => 'Alumnos'],
        ['href' => '/src/plataforma/capturista/inscripciones', 'icon' => 'check-circle', 'text' => 'Inscripciones'],
        ['href' => '/src/plataforma/capturista/reportes', 'icon' => 'bar-chart-2', 'text' => 'Reportes'],
    ];
}
$currentUri = $_SERVER['REQUEST_URI'];
?>
<nav class="p-4">
    <ul class="space-y-1">
        <?php foreach ($menu as $item): ?>
        <li>
            <a href="<?= $item['href'] ?>" class="nav-item group relative flex items-center px-4 py-3 rounded-xl font-medium text-neutral-600 dark:text-neutral-300 transition-all duration-300 ease-in-out hover:bg-gradient-to-r hover:from-primary-50 hover:to-primary-100 dark:hover:from-neutral-700 dark:hover:to-neutral-600 hover:text-primary-700 dark:hover:text-primary-300 hover:shadow-lg hover:scale-105 <?= strpos($currentUri, $item['href']) === 0 ? 'active bg-gradient-to-r from-primary-100 to-primary-200 dark:from-primary-900/50 dark:to-primary-800/50 text-primary-800 dark:text-primary-200 shadow-md' : '' ?>">
                <i data-feather="<?= $item['icon'] ?>" class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12"></i>
                <span class="nav-text transition-all duration-300 group-hover:translate-x-1"><?= $item['text'] ?></span>
                <?php if (strpos($currentUri, $item['href']) === 0): ?>
                    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-primary-500 rounded-r-full"></div>
                <?php endif; ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</nav>