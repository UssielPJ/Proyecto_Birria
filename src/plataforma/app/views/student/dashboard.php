<?php 
require_once __DIR__ . '/../layouts/student.php';
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/Grade.php';

$courseModel = new Course();
$gradeModel = new Grade();

$user = $_SESSION['user'];
$currentCourses = $courseModel->getCurrentByStudent($user['id']);
$recentGrades = $gradeModel->getRecentByStudent($user['id']);

// Calcula el progreso del semestre basado en la fecha actual
$startDate = strtotime('2025-08-15'); // Fecha de inicio del semestre
$endDate = strtotime('2025-12-15');   // Fecha de fin del semestre
$currentDate = time();
$semesterProgress = min(100, max(0, (($currentDate - $startDate) / ($endDate - $startDate)) * 100));
?>

<div class="container px-6 py-8">
    <!-- Bienvenida -->
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="user" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">¡Bienvenido, <?= htmlspecialchars($user['name']) ?>!</h2>
                <p class="opacity-90">Accede a tus cursos, calificaciones y recursos desde aquí.</p>
            </div>
        </div>
    </div>

    <!-- Estadísticas y Accesos Rápidos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Mis Cursos Activos -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-500" data-aos="fade-up">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Cursos Activos</p>
                    <h3 class="text-2xl font-bold mt-1"><?= count($currentCourses) ?></h3>
                </div>
                <div class="p-3 rounded-lg bg-emerald-50">
                    <i data-feather="book" class="w-6 h-6 text-emerald-500"></i>
                </div>
            </div>
            <a href="/courses" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium flex items-center mt-4">
                Ver mis cursos
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Promedio General -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Promedio General</p>
                    <h3 class="text-2xl font-bold mt-1"><?= number_format($averageGrade, 1) ?></h3>
                </div>
                <div class="p-3 rounded-lg bg-blue-50">
                    <i data-feather="award" class="w-6 h-6 text-blue-500"></i>
                </div>
            </div>
            <a href="/grades" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center mt-4">
                Ver calificaciones
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Progreso del Semestre -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Progreso Semestre</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $semesterProgress ?>%</h3>
                </div>
                <div class="p-3 rounded-lg bg-yellow-50">
                    <i data-feather="clock" class="w-6 h-6 text-yellow-500"></i>
                </div>
            </div>
            <div class="mt-4 bg-gray-200 rounded-full h-2.5">
                <div class="bg-yellow-500 h-2.5 rounded-full" style="width: <?= $semesterProgress ?>%"></div>
            </div>
        </div>

        <!-- Próxima Clase -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Próxima Clase</p>
                    <?php if (!empty($weekSchedule)): 
                        $nextClass = $scheduleModel->getNextClass($weekSchedule);
                    ?>
                        <h3 class="text-xl font-bold mt-1"><?= $nextClass['course'] ?></h3>
                        <p class="text-sm text-gray-500"><?= $nextClass['time'] ?></p>
                    <?php else: ?>
                        <h3 class="text-xl font-bold mt-1">No hay clases</h3>
                    <?php endif; ?>
                </div>
                <div class="p-3 rounded-lg bg-purple-50">
                    <i data-feather="calendar" class="w-6 h-6 text-purple-500"></i>
                </div>
            </div>
            <a href="/schedule" class="text-purple-600 hover:text-purple-700 text-sm font-medium flex items-center mt-4">
                Ver horario
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <i data-feather="book" class="w-6 h-6"></i>
                    </div>
                </div>
                <h4 class="text-lg font-semibold">Mis Cursos</h4>
                <p class="text-blue-100">Ver mis cursos actuales</p>
            </div>
            <div class="px-5 py-3 bg-blue-50">
                <a href="/student/courses" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                    Ver Detalles
                    <i data-feather="chevron-right" class="w-4 h-4 ml-2"></i>
                </a>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h4>Calificaciones</h4>
                    <p class="mb-0">Ver mis calificaciones</p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="/student/grades">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <h4>Becas</h4>
                    <p class="mb-0">Ver becas disponibles</p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="/student/scholarships">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h4>Horario</h4>
                    <p class="mb-0">Ver mi horario</p>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="/student/schedule">Ver Detalles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-calendar me-1"></i>
                    Próximas Actividades
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Las actividades se cargarán dinámicamente -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-bullhorn me-1"></i>
                    Anuncios Importantes
                </div>
                <div class="card-body">
                    <div class="announcements-list">
                        <!-- Los anuncios se cargarán dinámicamente -->
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Promedio General
                </div>
                <div class="card-body">
                    <canvas id="gradeChart" width="100%" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Aquí irá el código JavaScript para los gráficos y la carga dinámica de datos
</script>