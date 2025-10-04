<?php
require_once __DIR__ . '/../layouts/teacher.php';
require_once __DIR__ . '/../../models/Course.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Grade.php';

$courseModel = new Course();
$userModel = new User();
$gradeModel = new Grade();

$user = $_SESSION['user'];
$teacherCourses = $courseModel->getByTeacher($user['id']);
$totalStudents = count($userModel->getStudentsByTeacher($user['id']));
$pendingGrades = $gradeModel->getPendingGrades();
$recentGradeUpdates = $gradeModel->getRecentByTeacher($user['id'], 5);

?>
<div class="container px-6 py-8">
    <!-- Bienvenida -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="book-open" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">¡Bienvenido, <?= htmlspecialchars($user['name']) ?>!</h2>
                <p class="opacity-90">Administra tus clases, estudiantes y calificaciones desde aquí.</p>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Cursos Activos -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500" data-aos="fade-up">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Cursos Activos</p>
                    <h3 class="text-2xl font-bold mt-1"><?= count($teacherCourses) ?></h3>
                </div>
                <div class="p-3 rounded-lg bg-blue-50">
                    <i data-feather="book" class="w-6 h-6 text-blue-500"></i>
                </div>
            </div>
            <a href="/courses" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center mt-4">
                Ver mis cursos
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Total Estudiantes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Estudiantes</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $totalStudents ?></h3>
                </div>
                <div class="p-3 rounded-lg bg-green-50">
                    <i data-feather="users" class="w-6 h-6 text-green-500"></i>
                </div>
            </div>
            <a href="/students" class="text-green-600 hover:text-green-700 text-sm font-medium flex items-center mt-4">
                Ver estudiantes
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Calificaciones Pendientes -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Calificaciones Pendientes</p>
                    <h3 class="text-2xl font-bold mt-1"><?= count($pendingGrades) ?></h3>
                </div>
                <div class="p-3 rounded-lg bg-yellow-50">
                    <i data-feather="clock" class="w-6 h-6 text-yellow-500"></i>
                </div>
            </div>
            <a href="/grades/pending" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium flex items-center mt-4">
                Calificar pendientes
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Próxima Clase -->
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Próxima Clase</p>
                    <?php 
                    $nextClass = current($teacherCourses);
                    if ($nextClass): ?>
                        <h3 class="text-xl font-bold mt-1"><?= htmlspecialchars($nextClass['name']) ?></h3>
                        <p class="text-sm text-gray-500"><?= date('H:i', strtotime($nextClass['start_time'])) ?></p>
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
                <i data-feather="users" class="w-6 h-6 text-green-500"></i>
            </div>
            <div class="text-right">
                <p class="text-gray-500 text-sm">Total Estudiantes</p>
                <h3 class="text-2xl font-bold"><?= $totalStudents ?></h3>
            </div>
        </div>
        <div class="mt-4">
            <a href="/students" class="text-green-600 hover:text-green-700 text-sm font-medium flex items-center justify-end">
                Ver lista de estudiantes
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Tareas Pendientes -->
    <div class="bg-white rounded-xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="200">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-lg bg-yellow-50">
                <i data-feather="clock" class="w-6 h-6 text-yellow-500"></i>
            </div>
            <div class="text-right">
                <p class="text-gray-500 text-sm">Tareas por Revisar</p>
                <h3 class="text-2xl font-bold">12</h3>
            </div>
        </div>
        <div class="mt-4">
            <a href="/assignments" class="text-yellow-600 hover:text-yellow-700 text-sm font-medium flex items-center justify-end">
                Revisar tareas
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Cursos Activos -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <h3 class="text-lg font-semibold mb-4">Mis Cursos Activos</h3>
    
    <?php if (empty($teacherCourses)): ?>
        <p class="text-gray-500">No tienes cursos asignados actualmente.</p>
    <?php else: ?>
        <div class="grid gap-4">
            <?php foreach ($teacherCourses as $course): ?>
                <div class="flex items-center justify-between p-4 border rounded-lg hover:bg-gray-50">
                    <div>
                        <h4 class="font-medium"><?= htmlspecialchars($course['name']) ?></h4>
                        <p class="text-sm text-gray-500">
                            <?= $course['student_count'] ?> estudiantes | 
                            Horario: <?= htmlspecialchars($course['schedule'] ?? 'No definido') ?>
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <a href="/grades/course/<?= $course['id'] ?>" class="btn btn-secondary btn-sm">
                            Calificaciones
                        </a>
                        <a href="/courses/<?= $course['id'] ?>" class="btn btn-primary btn-sm">
                            Ver Curso
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- KPIs -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-primary-500" data-aos="fade-up">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-neutral-500 dark:text-neutral-400 text-sm">Clases asignadas</p>
        <h3 class="text-2xl font-bold mt-1">4</h3>
      </div>
      <div class="p-3 rounded-lg bg-primary-50 dark:bg-neutral-700">
        <i data-feather="book" class="text-primary-600"></i>
      </div>
    </div>
  </div>

  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-emerald-500" data-aos="fade-up" data-aos-delay="50">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-neutral-500 dark:text-neutral-400 text-sm">Estudiantes totales</p>
        <h3 class="text-2xl font-bold mt-1">87</h3>
      </div>
      <div class="p-3 rounded-lg bg-emerald-50 dark:bg-neutral-700">
        <i data-feather="users" class="text-emerald-600"></i>
      </div>
    </div>
  </div>

  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-amber-500" data-aos="fade-up" data-aos-delay="100">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-neutral-500 dark:text-neutral-400 text-sm">Tareas por revisar</p>
        <h3 class="text-2xl font-bold mt-1">24</h3>
      </div>
      <div class="p-3 rounded-lg bg-amber-50 dark:bg-neutral-700">
        <i data-feather="clipboard" class="text-amber-600"></i>
      </div>
    </div>
  </div>

  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-purple-500" data-aos="fade-up" data-aos-delay="150">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-neutral-500 dark:text-neutral-400 text-sm">Próxima clase</p>
        <h3 class="text-2xl font-bold mt-1">9:00 AM</h3>
      </div>
      <div class="p-3 rounded-lg bg-purple-50 dark:bg-neutral-700">
        <i data-feather="clock" class="text-purple-600"></i>
      </div>
    </div>
  </div>
</div>

<!-- Dos columnas: Próximas clases / Tareas por revisar -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
  <section class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6" data-aos="fade-up">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-bold">Próximas clases</h2>
      <a href="/src/plataforma/app/maestro/horario" class="text-primary-700 dark:text-primary-300 text-sm">Ver horario</a>
    </div>

    <div class="space-y-4">
      <div class="flex items-center justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
        <div class="flex items-center gap-3">
          <div class="p-2 rounded-lg bg-rose-50 dark:bg-neutral-700"><i data-feather="book" class="text-rose-600"></i></div>
          <div>
            <h3 class="font-medium">Matemáticas Avanzadas</h3>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Aula 302 — 9:00–11:00</p>
          </div>
        </div>
        <a href="#" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700">
          <i data-feather="chevron-right" class="text-neutral-400"></i>
        </a>
      </div>

      <div class="flex items-center justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
        <div class="flex items-center gap-3">
          <div class="p-2 rounded-lg bg-purple-50 dark:bg-neutral-700"><i data-feather="book" class="text-purple-600"></i></div>
          <div>
            <h3 class="font-medium">Física Moderna</h3>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Aula 205 — 14:00–16:00</p>
          </div>
        </div>
        <a href="#" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700">
          <i data-feather="chevron-right" class="text-neutral-400"></i>
        </a>
      </div>
    </div>
  </section>

  <section class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6" data-aos="fade-up">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-bold">Tareas por revisar</h2>
      <a href="/src/plataforma/app/maestro/calificar" class="text-primary-700 dark:text-primary-300 text-sm">Ver todas</a>
    </div>

    <div class="space-y-4">
      <div class="flex items-start justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
        <div class="flex items-start gap-3">
          <div class="p-2 rounded-lg bg-amber-50 dark:bg-neutral-700 mt-1"><i data-feather="clipboard" class="text-amber-600"></i></div>
          <div>
            <h3 class="font-medium">Proyecto de Física</h3>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Entrega: 15 de marzo</p>
            <div class="flex items-center gap-2 mt-2">
              <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-1.5">
                <div class="bg-amber-500 h-1.5 rounded-full" style="width:24%"></div>
              </div>
              <span class="text-xs text-neutral-500 dark:text-neutral-400">24/87</span>
            </div>
          </div>
        </div>
        <a href="#" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700">
          <i data-feather="chevron-right" class="text-neutral-400"></i>
        </a>
      </div>

      <div class="flex items-start justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
        <div class="flex items-start gap-3">
          <div class="p-2 rounded-lg bg-primary-50 dark:bg-neutral-700 mt-1"><i data-feather="clipboard" class="text-primary-600"></i></div>
          <div>
            <h3 class="font-medium">Examen parcial</h3>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Entrega: 10 de marzo</p>
            <div class="flex items-center gap-2 mt-2">
              <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-1.5">
                <div class="bg-primary-500 h-1.5 rounded-full" style="width:87%"></div>
              </div>
              <span class="text-xs text-neutral-500 dark:text-neutral-400">76/87</span>
            </div>
          </div>
        </div>
        <a href="#" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700">
          <i data-feather="chevron-right" class="text-neutral-400"></i>
        </a>
      </div>
    </div>
  </section>
</div>
