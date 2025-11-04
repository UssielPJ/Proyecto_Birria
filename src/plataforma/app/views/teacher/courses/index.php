<?php
// Variables esperadas: $courses (array de objetos), $role (string), $user (array)
$isTeacher = isset($role) && $role === 'teacher';

// Helper seguro
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

// Nombre del profesor desde sesión
$sessionTeacherName = '';
if (!empty($user['nombre'])) {
    $sessionTeacherName = trim(
        ($user['nombre'] ?? '') . ' ' .
        ($user['apellido_paterno'] ?? '') . ' ' .
        ($user['apellido_materno'] ?? '')
    );
}
?>
<div class="container px-6 py-8">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="book" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Cursos</h2>
                <p class="opacity-90"><?= $isTeacher ? 'Tus materias asignadas' : 'Gestiona tus cursos y materias' ?></p>
            </div>
        </div>
    </div>

    <!-- Filtros y Búsqueda (decorativo) -->
    <div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
        <div class="flex flex-wrap gap-4 items-center">
            <div class="relative">
                <select class="appearance-none bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-primary-500 dark:text-white">
                    <option>Todos los Semestres</option>
                    <option>Primer Semestre</option>
                    <option>Segundo Semestre</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-neutral-700 dark:text-neutral-300">
                    <i data-feather="chevron-down" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="relative">
                <select class="appearance-none bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-primary-500 dark:text-white">
                    <option>Todas las Carreras</option>
                    <option>Ingeniería</option>
                    <option>Administración</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-neutral-700 dark:text-neutral-300">
                    <i data-feather="chevron-down" class="w-4 h-4"></i>
                </div>
            </div>
        </div>
        
        <div class="relative">
            <input type="text" placeholder="Buscar cursos..." 
                class="w-full sm:w-64 pl-10 pr-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg focus:outline-none focus:border-primary-500 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i data-feather="search" class="w-4 h-4 text-neutral-500 dark:text-neutral-400"></i>
            </div>
        </div>
    </div>

    <!-- Grid de Cursos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <?php
                  // mg_id preferente, si no existe usa id
                  $mgId = isset($course->mg_id) ? (int)$course->mg_id : (int)($course->id ?? 0);
                  $hubUrl = "/src/plataforma/app/teacher/courses/show?id={$mgId}";
                  $status = strtolower((string)($course->status ?? 'activa'));
                  $isActive = ($status === 'activa' || $status === 'active' || $status === '1');
                ?>
                <a href="<?= $esc($hubUrl) ?>" class="block group">
                  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden ring-1 ring-transparent group-hover:ring-primary-200 dark:group-hover:ring-primary-900 transition" data-aos="fade-up">
                      <div class="relative h-48 bg-neutral-200 dark:bg-neutral-700">
                          <img src="/src/plataforma/app/img/UT.jpg" alt="<?= $esc($course->name ?? 'Materia') ?>" class="w-full h-full object-cover">
                          <div class="absolute top-4 right-4">
                              <span class="px-2 py-1 text-xs font-semibold rounded-full
                                           <?= $isActive ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200'
                                                        : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' ?>">
                                  <?= $isActive ? 'Activo' : 'Inactivo' ?>
                              </span>
                          </div>
                      </div>

                      <div class="p-6">
                          <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-1">
                              <?= $esc($course->name ?? 'Materia sin nombre') ?>
                          </h3>
                          <p class="text-sm text-neutral-600 dark:text-neutral-300 mb-4">
                              <span class="opacity-80">Clave:</span>
                              <?= $esc($course->code ?? '—') ?>
                          </p>

                          <!-- Meta opcional -->
                          <div class="grid grid-cols-2 gap-3 mb-4 text-sm">
                              <?php if (!empty($course->group_code) || !empty($course->group_title)): ?>
                                  <div class="flex items-center gap-2 text-neutral-600 dark:text-neutral-300">
                                      <i data-feather="layers" class="w-4 h-4 text-neutral-400"></i>
                                      Grupo:
                                      <?= $esc($course->group_code ?? '—') ?>
                                      <?php if (!empty($course->group_title)): ?>
                                        · <?= $esc($course->group_title) ?>
                                      <?php endif; ?>
                                  </div>
                              <?php endif; ?>

                              <?php if (!empty($course->mg_code)): ?>
                                  <div class="flex items-center gap-2 text-neutral-600 dark:text-neutral-300">
                                      <i data-feather="tag" class="w-4 h-4 text-neutral-400"></i>
                                      Relación MG: <?= $esc($course->mg_code) ?>
                                  </div>
                              <?php endif; ?>

                              <?php if (!empty($course->start_time) || !empty($course->room)): ?>
                                  <div class="flex items-center gap-2 text-neutral-600 dark:text-neutral-300">
                                      <i data-feather="clock" class="w-4 h-4 text-neutral-400"></i>
                                      <?= !empty($course->start_time)
                                          ? $esc(($course->day_of_week ?? '').' '.($course->start_time).'–'.($course->end_time ?? ''))
                                          : 'Horario por definir' ?>
                                      <?php if (!empty($course->room)): ?> · Aula <?= $esc($course->room) ?><?php endif; ?>
                                  </div>
                              <?php endif; ?>
                          </div>

                          <div class="flex items-center justify-between">
                              <div class="flex items-center space-x-2">
                                  <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                                      <i data-feather="user" class="w-4 h-4 text-primary-600 dark:text-primary-400"></i>
                                  </div>
                                  <span class="text-sm text-neutral-600 dark:text-neutral-300">
                                    <?php
                                      if (!empty($course->teacher_name)) {
                                          echo $esc($course->teacher_name);
                                      } elseif ($isTeacher && $sessionTeacherName !== '') {
                                          echo $esc($sessionTeacherName);
                                      } else {
                                          echo 'Profesor';
                                      }
                                    ?>
                                  </span>
                              </div>

                              <?php if (isset($course->student_count)): ?>
                                  <div class="flex items-center space-x-1">
                                      <i data-feather="users" class="w-4 h-4 text-neutral-400"></i>
                                      <span class="text-sm text-neutral-500 dark:text-neutral-400">
                                          <?= (int)$course->student_count ?> estudiantes
                                      </span>
                                  </div>
                              <?php endif; ?>
                          </div>

                          <div class="mt-4 flex items-center justify-end">
                              <span class="text-primary-600 group-hover:text-primary-700 dark:text-primary-400 dark:group-hover:text-primary-300 text-sm font-medium">
                                  Abrir curso
                              </span>
                          </div>
                      </div>
                  </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-12">
                <i data-feather="book" class="w-16 h-16 text-neutral-300 dark:text-neutral-600 mx-auto mb-4"></i>
                <p class="text-neutral-500 dark:text-neutral-400">
                    <?= $isTeacher ? 'No tienes materias asignadas todavía' : 'No hay cursos disponibles' ?>
                </p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Paginación (dummy) -->
    <div class="flex items-center justify-between border-t border-neutral-200 dark:border-neutral-700 px-4 py-3 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 text-sm font-medium rounded-md text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-700">Anterior</a>
            <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 text-sm font-medium rounded-md text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-700">Siguiente</a>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-neutral-700 dark:text-neutral-300">
                    Mostrando <span class="font-medium">1</span> a <span class="font-medium"><?= str_pad((string)min(count($courses ?? []), 10), 1, ' ', STR_PAD_LEFT) ?></span> de <span class="font-medium"><?= count($courses ?? []) ?></span> resultados
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        <span class="sr-only">Anterior</span><i data-feather="chevron-left" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 bg-primary-50 dark:bg-primary-900 text-sm font-medium text-primary-600 dark:text-primary-400">1</a>
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm font-medium text-neutral-500 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                        <span class="sr-only">Siguiente</span><i data-feather="chevron-right" class="w-5 h-5"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
  AOS.init();
  feather.replace();
</script>
