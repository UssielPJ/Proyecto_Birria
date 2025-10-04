<div class="container px-6 py-8">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-blue-600 to-cyan-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="calendar" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Horario</h2>
                <p class="opacity-90">Gestiona tu horario académico</p>
            </div>
        </div>
    </div>

    <!-- Controles de Horario -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 mb-8" data-aos="fade-up">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <h3 class="text-lg font-bold">Semestre Actual</h3>
                <div class="relative">
                    <select class="appearance-none bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-lg py-2 px-4 pr-8 leading-tight focus:outline-none focus:border-primary-500 dark:text-white">
                        <option>Otoño 2025</option>
                        <option>Primavera 2025</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-neutral-700 dark:text-neutral-300">
                        <i data-feather="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <button class="inline-flex items-center px-4 py-2 border border-neutral-300 dark:border-neutral-700 rounded-lg text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                    <i data-feather="download" class="w-4 h-4 mr-2"></i>
                    Exportar
                </button>
                <button class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <i data-feather="printer" class="w-4 h-4 mr-2"></i>
                    Imprimir
                </button>
            </div>
        </div>
    </div>

    <!-- Horario Semanal -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden" data-aos="fade-up">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full">
                <div class="grid grid-cols-6 divide-x divide-neutral-200 dark:divide-neutral-700">
                    <!-- Horarios -->
                    <div class="w-20">
                        <div class="h-20 border-b border-neutral-200 dark:border-neutral-700"></div>
                        <?php
                        $hours = ['7:00', '8:00', '9:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00'];
                        foreach ($hours as $hour):
                        ?>
                        <div class="h-20 flex items-center justify-center border-b border-neutral-200 dark:border-neutral-700">
                            <span class="text-sm text-neutral-500 dark:text-neutral-400"><?= $hour ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Días de la semana -->
                    <?php
                    $days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
                    foreach ($days as $day):
                    ?>
                    <div class="flex-1">
                        <div class="h-20 flex items-center justify-center border-b border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900/50">
                            <span class="font-medium text-neutral-900 dark:text-white"><?= $day ?></span>
                        </div>
                        <?php foreach ($hours as $hour): ?>
                        <div class="h-20 border-b border-neutral-200 dark:border-neutral-700 relative group">
                            <?php
                            $dayIndex = array_search($day, $days) + 1; // 1 = Monday, etc.
                            $currentHour = $hour . ':00';
                            $matchingSchedule = null;
                            foreach ($schedule as $sch) {
                                if ($sch->day_of_week == $dayIndex && date('H:i', strtotime($sch->start_time)) == $currentHour) {
                                    $matchingSchedule = $sch;
                                    break;
                                }
                            }
                            if ($matchingSchedule):
                            ?>
                            <div class="absolute inset-x-2 top-0 h-40 bg-blue-100 dark:bg-blue-900/50 rounded-lg p-2 cursor-pointer hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-colors">
                                <div class="flex flex-col h-full">
                                    <span class="text-sm font-medium text-blue-800 dark:text-blue-200"><?= htmlspecialchars($matchingSchedule->course_name) ?></span>
                                    <span class="text-xs text-blue-600 dark:text-blue-300">Aula <?= htmlspecialchars($matchingSchedule->room_name) ?></span>
                                    <span class="text-xs text-blue-600 dark:text-blue-300 mt-auto"><?= date('H:i', strtotime($matchingSchedule->start_time)) ?> - <?= date('H:i', strtotime($matchingSchedule->end_time)) ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen de Materias -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-up">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold mb-4">Resumen de Materias</h3>
            <div class="space-y-4">
                <?php
                $courseHours = [];
                foreach ($schedule as $sch) {
                    $courseName = $sch->course_name;
                    if (!isset($courseHours[$courseName])) {
                        $courseHours[$courseName] = 0;
                    }
                    $start = strtotime($sch->start_time);
                    $end = strtotime($sch->end_time);
                    $hours = ($end - $start) / 3600;
                    $courseHours[$courseName] += $hours;
                }
                $colors = ['blue', 'green', 'purple', 'red', 'yellow'];
                $i = 0;
                foreach ($courseHours as $course => $hours):
                $color = $colors[$i % count($colors)];
                ?>
                <div class="flex items-center justify-between p-3 bg-<?= $color ?>-50 dark:bg-<?= $color ?>-900/20 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 bg-<?= $color ?>-500 rounded-full"></div>
                        <span class="text-sm font-medium text-neutral-900 dark:text-white"><?= htmlspecialchars($course) ?></span>
                    </div>
                    <span class="text-sm text-neutral-500 dark:text-neutral-400"><?= $hours ?> hrs/sem</span>
                </div>
                <?php $i++; endforeach; ?>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold mb-4">Profesores</h3>
            <div class="space-y-4">
                <?php
                $uniqueTeachers = [];
                foreach ($schedule as $sch) {
                    $teacher = $sch->teacher_name;
                    $course = $sch->course_name;
                    if (!isset($uniqueTeachers[$teacher])) {
                        $uniqueTeachers[$teacher] = $course;
                    }
                }
                foreach ($uniqueTeachers as $teacher => $course):
                ?>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                        <i data-feather="user" class="w-5 h-5 text-primary-600 dark:text-primary-400"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-neutral-900 dark:text-white"><?= htmlspecialchars($teacher) ?></p>
                        <p class="text-xs text-neutral-500 dark:text-neutral-400"><?= htmlspecialchars($course) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold mb-4">Aulas</h3>
            <div class="space-y-4">
                <?php
                $uniqueRooms = [];
                foreach ($schedule as $sch) {
                    $room = $sch->room_name;
                    if (!in_array($room, $uniqueRooms)) {
                        $uniqueRooms[] = $room;
                    }
                }
                foreach ($uniqueRooms as $room):
                ?>
                <div class="flex items-center justify-between p-3 border border-neutral-200 dark:border-neutral-700 rounded-lg">
                    <div class="flex items-center gap-3">
                        <i data-feather="map-pin" class="w-4 h-4 text-neutral-500 dark:text-neutral-400"></i>
                        <div>
                            <p class="text-sm font-medium text-neutral-900 dark:text-white"><?= htmlspecialchars($room) ?></p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Edificio por definir</p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Inicializar las animaciones y los íconos
    AOS.init();
    feather.replace();
</script>
