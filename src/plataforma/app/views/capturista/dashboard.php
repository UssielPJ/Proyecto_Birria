<?php 
require_once __DIR__ . '/../layouts/capturista.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/Grade.php';

$userModel = new User();
$courseModel = new Course();
$gradeModel = new Grade();

$recentRegistrations = $userModel->getRecentUsers(5);
$pendingGrades = $gradeModel->getPendingGrades();
$totalStudents = $userModel->countByRole('student');
$totalTeachers = $userModel->countByRole('teacher');

// Estadísticas del día
$todayStats = [
    'new_registrations' => count($recentRegistrations),
    'pending_grades' => count($pendingGrades),
    'total_students' => $totalStudents,
    'total_teachers' => $totalTeachers
];

?>

<div class="container px-6 py-8">
    <!-- Bienvenida -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="database" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Panel de Captura de Datos</h2>
                <p class="opacity-90">Gestiona la información académica de manera eficiente.</p>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Registros del Día -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500" data-aos="fade-up">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Nuevos Registros</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $todayStats['new_registrations'] ?></h3>
                </div>
                <div class="p-3 rounded-lg bg-purple-50">
                    <i data-feather="user-plus" class="w-6 h-6 text-purple-500"></i>
                </div>
            </div>
            <a href="/register/new" class="text-purple-600 hover:text-purple-700 text-sm font-medium flex items-center mt-4">
                Nuevo registro
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Calificaciones Pendientes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Calificaciones Pendientes</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $todayStats['pending_grades'] ?></h3>
                </div>
                <div class="p-3 rounded-lg bg-yellow-50">
                    <i data-feather="clock" class="w-6 h-6 text-yellow-500"></i>
                </div>
            </div>
            <a href="/grades/pending" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium flex items-center mt-4">
                Ver pendientes
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Total Estudiantes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Estudiantes</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $todayStats['total_students'] ?></h3>
                </div>
                <div class="p-3 rounded-lg bg-blue-50">
                    <i data-feather="users" class="w-6 h-6 text-blue-500"></i>
                </div>
            </div>
            <a href="/students" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center mt-4">
                Ver estudiantes
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Total Profesores -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Profesores</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $todayStats['total_teachers'] ?></h3>
                </div>
                <div class="p-3 rounded-lg bg-green-50">
                    <i data-feather="book-open" class="w-6 h-6 text-green-500"></i>
                </div>
            </div>
            <a href="/teachers" class="text-green-600 hover:text-green-700 text-sm font-medium flex items-center mt-4">
                Ver profesores
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <i data-feather="edit-3" class="w-6 h-6 text-blue-500"></i>
                </div>
                <a href="/grades/update" class="btn btn-primary btn-sm">
                    Actualizar
                </a>
            </div>
            <h3 class="font-medium">Calificaciones</h3>
            <p class="text-sm text-gray-500 mt-1">Actualizar calificaciones</p>
        </div>

        <!-- Gestión de Horarios -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-green-50">
                    <i data-feather="calendar" class="w-6 h-6 text-green-500"></i>
                </div>
                <a href="/schedule" class="btn btn-primary btn-sm">
                    Gestionar
                </a>
            </div>
            <h3 class="font-medium">Horarios</h3>
            <p class="text-sm text-gray-500 mt-1">Gestionar horarios de clases</p>
        </div>

        <!-- Reportes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-yellow-50">
                    <i data-feather="file-text" class="w-6 h-6 text-yellow-500"></i>
                </div>
                <a href="/reports" class="btn btn-primary btn-sm">
                    Ver Reportes
                </a>
            </div>
            <h3 class="font-medium">Reportes</h3>
            <p class="text-sm text-gray-500 mt-1">Generar reportes académicos</p>
        </div>
    </div>

    <!-- Tareas Pendientes -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <h3 class="text-lg font-semibold mb-4">Acciones Pendientes</h3>
        <div class="grid gap-4">
            <div class="flex items-center justify-between p-4 border rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-purple-100 rounded">
                        <i data-feather="user" class="w-5 h-5 text-purple-500"></i>
                    </div>
                    <div>
                        <h4 class="font-medium">Nuevos Estudiantes por Procesar</h4>
                        <p class="text-sm text-gray-500">Registros pendientes de revisión</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-purple-100 text-purple-600 rounded-full">
                    <?= $pendingActions['new_students'] ?>
                </span>
            </div>

            <div class="flex items-center justify-between p-4 border rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-100 rounded">
                        <i data-feather="edit-2" class="w-5 h-5 text-blue-500"></i>
                    </div>
                    <div>
                        <h4 class="font-medium">Actualizaciones de Calificaciones</h4>
                        <p class="text-sm text-gray-500">Calificaciones por actualizar</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full">
                    <?= $pendingActions['grade_updates'] ?>
                </span>
            </div>

            <div class="flex items-center justify-between p-4 border rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-green-100 rounded">
                        <i data-feather="clock" class="w-5 h-5 text-green-500"></i>
                    </div>
                    <div>
                        <h4 class="font-medium">Cambios de Horario</h4>
                        <p class="text-sm text-gray-500">Solicitudes de cambio pendientes</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full">
                    <?= $pendingActions['schedule_changes'] ?>
                </span>
            </div>
        </div>
    </div>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        }
                    },
                    transitionProperty: {
                        'width': 'width',
                        'spacing': 'margin, padding',
                    },
                }
            }
        }
    </script>
    <style>
        .sidebar-collapsed {
            width: 80px;
        }
        .sidebar-expanded {
            width: 280px;
        }
        .content-collapsed {
            margin-left: 80px;
        }
        .content-expanded {
            margin-left: 280px;
        }
        @media (max-width: 768px) {
            .sidebar-expanded {
                width: 100%;
            }
            .content-expanded {
                margin-left: 0;
            }
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 h-full" data-aos="fade-in">
    <div class="flex h-full">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar-expanded bg-white dark:bg-gray-800 shadow-lg h-full fixed z-50 transition-all duration-300 ease-in-out">
            <div class="p-4 flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center space-x-3 mb-8">
                    <div class="bg-primary-500 p-2 rounded-lg">
                        <i data-feather="book" class="text-white w-6 h-6"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-800 dark:text-white whitespace-nowrap">UTEC Admin</span>
                </div>

                <!-- User Info -->
                <div class="flex items-center space-x-3 mb-8 p-3 rounded-lg bg-gray-100 dark:bg-gray-700">
                    <div class="relative">
                        <img src="http://static.photos/people/200x200/1" alt="User" class="w-10 h-10 rounded-full">
                        <span class="absolute bottom-0 right-0 bg-green-500 border-2 border-white rounded-full w-3 h-3"></span>
                    </div>
                    <div class="whitespace-nowrap overflow-hidden">
                        <p class="font-medium text-gray-800 dark:text-white truncate">Admin User</p>
                        <p class="text-xs text-gray-500 dark:text-gray-300 truncate">admin@utec.edu</p>
                    </div>
                </div>

                <!-- Menu -->
                <nav class="flex-1 overflow-y-auto">
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg bg-primary-100 dark:bg-gray-700 text-primary-600 dark:text-white transition-all">
                                <i data-feather="home" class="w-5 h-5"></i>
                                <span>Panel Principal</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                                <i data-feather="users" class="w-5 h-5"></i>
                                <span>Estudiantes</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                                <i data-feather="user-check" class="w-5 h-5"></i>
                                <span>Profesores</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                                <i data-feather="book-open" class="w-5 h-5"></i>
                                <span>Materias</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                                <i data-feather="calendar" class="w-5 h-5"></i>
                                <span>Horarios</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                                <i data-feather="award" class="w-5 h-5"></i>
                                <span>Calificaciones</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                                <i data-feather="dollar-sign" class="w-5 h-5"></i>
                                <span>Pagos</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                                <i data-feather="settings" class="w-5 h-5"></i>
                                <span>Configuración</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                                <i data-feather="bell" class="w-5 h-5"></i>
                                <span>Anuncios</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Logout -->
                <div class="mt-auto">
                    <a href="/src/plataforma/logout" class="flex items-center space-x-3 p-3 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                        <i data-feather="log-out" class="w-5 h-5"></i>
                        <span>Cerrar Sesión</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div id="content" class="content-expanded w-full transition-all duration-300 ease-in-out">
            <!-- Topbar -->
            <header class="bg-white dark:bg-gray-800 shadow-sm fixed w-full z-40">
                <div class="flex items-center justify-between p-4">
                    <div class="flex items-center space-x-4">
                        <button id="sidebar-toggle" class="text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                            <i data-feather="menu" class="w-6 h-6"></i>
                        </button>
                        <h1 class="text-xl font-bold text-gray-800 dark:text-white">Panel Principal</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button id="theme-toggle" class="text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                            <i data-feather="sun" class="w-5 h-5 hidden dark:block"></i>
                            <i data-feather="moon" class="w-5 h-5 block dark:hidden"></i>
                        </button>
                        <button class="relative text-gray-600 dark:text-gray-300 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">
                            <i data-feather="bell" class="w-5 h-5"></i>
                            <span class="absolute -top-1 -right-1 bg-primary-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs">3</span>
                        </button>
                        <div class="flex items-center space-x-2">
                            <img src="http://static.photos/people/200x200/1" alt="User" class="w-8 h-8 rounded-full">
                            <span class="text-gray-600 dark:text-gray-300 font-medium">Admin</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="pt-20 pb-10 px-6">
                <!-- Welcome Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Bienvenido, <span class="text-primary-500">Administrador</span></h2>
                    <p class="text-gray-600 dark:text-gray-300">Aquí puedes gestionar toda la información académica de la UTEC.</p>
                </div>

                <!-- KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-primary-500 transition-all duration-300 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Estudiantes</p>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">1,254</h3>
                            </div>
                            <div class="bg-primary-100 dark:bg-gray-700 p-3 rounded-lg">
                                <i data-feather="users" class="text-primary-500 w-5 h-5"></i>
                            </div>
                        </div>
                        <p class="text-xs text-green-500 mt-2">+12% desde el mes pasado</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-secondary-500 transition-all duration-300 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Profesores</p>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">84</h3>
                            </div>
                            <div class="bg-secondary-100 dark:bg-gray-700 p-3 rounded-lg">
                                <i data-feather="user-check" class="text-secondary-500 w-5 h-5"></i>
                            </div>
                        </div>
                        <p class="text-xs text-green-500 mt-2">+3 nuevos este mes</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 transition-all duration-300 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Materias</p>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">56</h3>
                            </div>
                            <div class="bg-yellow-100 dark:bg-gray-700 p-3 rounded-lg">
                                <i data-feather="book-open" class="text-yellow-500 w-5 h-5"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">2 materias nuevas</p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border-l-4 border-red-500 transition-all duration-300 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-300">Pagos Pendientes</p>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">$12,450</h3>
                            </div>
                            <div class="bg-red-100 dark:bg-gray-700 p-3 rounded-lg">
                                <i data-feather="dollar-sign" class="text-red-500 w-5 h-5"></i>
                            </div>
                        </div>
                        <p class="text-xs text-red-500 mt-2">+$2,100 desde ayer</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <button class="bg-primary-500 hover:bg-primary-600 text-white rounded-lg p-4 flex flex-col items-center justify-center transition-all duration-300 transform hover:scale-105">
                        <i data-feather="user-plus" class="w-6 h-6 mb-2"></i>
                        <span>Nuevo Estudiante</span>
                    </button>
                    <button class="bg-secondary-500 hover:bg-secondary-600 text-white rounded-lg p-4 flex flex-col items-center justify-center transition-all duration-300 transform hover:scale-105">
                        <i data-feather="user-check" class="w-6 h-6 mb-2"></i>
                        <span>Nuevo Profesor</span>
                    </button>
                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg p-4 flex flex-col items-center justify-center transition-all duration-300 transform hover:scale-105">
                        <i data-feather="book" class="w-6 h-6 mb-2"></i>
                        <span>Nueva Materia</span>
                    </button>
                    <button class="bg-green-500 hover:bg-green-600 text-white rounded-lg p-4 flex flex-col items-center justify-center transition-all duration-300 transform hover:scale-105">
                        <i data-feather="bell" class="w-6 h-6 mb-2"></i>
                        <span>Nuevo Anuncio</span>
                    </button>
                </div>

                <!-- Two Columns -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Recent Students -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-gray-800 dark:text-white">Últimos Estudiantes</h3>
                            <a href="#" class="text-sm text-primary-500 hover:text-primary-600 transition-colors">Ver todos</a>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <img src="http://static.photos/people/200x200/2" alt="Student" class="w-10 h-10 rounded-full">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 dark:text-white">María Rodríguez</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Ingeniería en Sistemas</p>
                                </div>
                                <span class="badge bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100 rounded-full">Activo</span>
                            </div>
                            <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <img src="http://static.photos/people/200x200/3" alt="Student" class="w-10 h-10 rounded-full">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 dark:text-white">Carlos Pérez</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Administración</p>
                                </div>
                                <span class="badge bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100 rounded-full">Pendiente</span>
                            </div>
                            <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <img src="http://static.photos/people/200x200/4" alt="Student" class="w-10 h-10 rounded-full">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 dark:text-white">Ana Gómez</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Derecho</p>
                                </div>
                                <span class="badge bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100 rounded-full">Activo</span>
                            </div>
                            <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <img src="http://static.photos/people/200x200/5" alt="Student" class="w-10 h-10 rounded-full">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 dark:text-white">Luis Martínez</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Medicina</p>
                                </div>
                                <span class="badge bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100 rounded-full">Inactivo</span>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Tasks -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-gray-800 dark:text-white">Pendientes Administrativos</h3>
                            <a href="#" class="text-sm text-primary-500 hover:text-primary-600 transition-colors">Ver todos</a>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg">
                                    <i data-feather="file-text" class="text-blue-500 dark:text-blue-300 w-4 h-4"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 dark:text-white">Documentos por revisar</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">15 documentos pendientes</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <div class="bg-green-100 dark:bg-green-900 p-2 rounded-lg">
                                    <i data-feather="dollar-sign" class="text-green-500 dark:text-green-300 w-4 h-4"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 dark:text-white">Pagos atrasados</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">23 pagos sin realizar</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <div class="bg-purple-100 dark:bg-purple-900 p-2 rounded-lg">
                                    <i data-feather="mail" class="text-purple-500 dark:text-purple-300 w-4 h-4"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 dark:text-white">Solicitudes sin responder</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">7 solicitudes nuevas</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <div class="bg-orange-100 dark:bg-orange-900 p-2 rounded-lg">
                                    <i data-feather="clock" class="text-orange-500 dark:text-orange-300 w-4 h-4"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800 dark:text-white">Horarios por aprobar</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">5 horarios pendientes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">© 2023 UTEC - Dashboard Administrativo. Todos los derechos reservados.</p>
            </footer>
        </div>
    </div>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const html = document.documentElement;

        // Check for saved user preference or use system preference
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        themeToggle.addEventListener('click', () => {
            html.classList.toggle('dark');
            localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light');
        });

        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-collapsed');
            sidebar.classList.toggle('sidebar-expanded');
            content.classList.toggle('content-collapsed');
            content.classList.toggle('content-expanded');
            
            // Save state in localStorage
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('sidebar-collapsed'));
        });

        // Check saved sidebar state on load
        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.remove('sidebar-expanded');
            sidebar.classList.add('sidebar-collapsed');
            content.classList.remove('content-expanded');
            content.classList.add('content-collapsed');
        }

        // Mobile sidebar close when clicking outside
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 768 && !sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
                content.classList.remove('content-expanded');
                content.classList.add('content-collapsed');
            }
        });

        // Replace icons
        feather.replace();
    </script>
</body>
</html>