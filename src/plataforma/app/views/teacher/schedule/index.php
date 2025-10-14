<?php
// ================== HELPERS (array/objeto + alias) ==================
$val = function($row, $key, $fallbacks = []) {
  if (is_array($row)) {
    if (array_key_exists($key, $row)) return $row[$key];
    foreach ($fallbacks as $alt) if (array_key_exists($alt, $row)) return $row[$alt];
  } else {
    if (isset($row->$key)) return $row->$key;
    foreach ($fallbacks as $alt) if (isset($row->$alt)) return $row->$alt;
  }
  return null;
};

$getDia    = fn($row) => $val($row, 'dia_semana', ['dia','day_of_week']);          // 'Lun','Mar','Mie','Jue','Vie','Sab','Dom' o número/etiqueta
$getInicio = fn($row) => $val($row, 'hora_inicio', ['start_time','inicio']);        // 'HH:MM' o 'HH:MM:SS'
$getFin    = fn($row) => $val($row, 'hora_fin', ['end_time','fin']);
$getAula   = fn($row) => $val($row, 'aula', ['aula_id','room','room_name']);
$getMat    = fn($row) => $val($row, 'materia', ['materia_nombre','course_name','materia_id','course_id']);
$getProf   = fn($row) => $val($row, 'teacher_name', ['profesor','profesor_nombre','docente']);

// ================== NORMALIZACIÓN DE DÍAS ==================
$abbrDays = ['Lun','Mar','Mie','Jue','Vie','Sab','Dom'];
$labelToAbbr = [
  'Lunes'=>'Lun','Martes'=>'Mar','Miércoles'=>'Mie','Miercoles'=>'Mie',
  'Jueves'=>'Jue','Viernes'=>'Vie','Sábado'=>'Sab','Sabado'=>'Sab','Domingo'=>'Dom',
  'Lun'=>'Lun','Mar'=>'Mar','Mié'=>'Mie','Mie'=>'Mie','Jue'=>'Jue','Vie'=>'Vie','Sáb'=>'Sab','Sab'=>'Sab','Dom'=>'Dom',
  '1'=>'Lun','2'=>'Mar','3'=>'Mie','4'=>'Jue','5'=>'Vie','6'=>'Sab','7'=>'Dom'
];

$displayDays = [
  'Lunes'    => 'Lun',
  'Martes'   => 'Mar',
  'Miércoles'=> 'Mie',
  'Jueves'   => 'Jue',
  'Viernes'  => 'Vie'
];

// ================== HORAS (formato consistente HH:MM) ==================
$hours = ['07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00'];

// ================== ARMA $week (agrupado) Y UN ÍNDICE POR SLOT ==================
$week = ['Lun'=>[], 'Mar'=>[], 'Mie'=>[], 'Jue'=>[], 'Vie'=>[], 'Sab'=>[], 'Dom'=>[]];

if (is_array($schedule)) {
  // ¿Vino ya agrupado? (tiene llaves de días)
  $keys = array_keys($schedule);
  $hasDayKeys = count(array_intersect($keys, $abbrDays)) > 0;
  if ($hasDayKeys) {
    foreach ($abbrDays as $d) {
      if (!empty($schedule[$d]) && is_array($schedule[$d])) {
        foreach ($schedule[$d] as $row) $week[$d][] = $row;
      }
    }
  } else {
    // Vino plano: agrupar por día
    foreach ($schedule as $row) {
      $raw = (string)($getDia($row) ?? '');
      $abbr = $labelToAbbr[$raw] ?? (in_array($raw, $abbrDays, true) ? $raw : null);
      if ($abbr) $week[$abbr][] = $row;
    }
  }
}

// Índice rápido por [díaAbbr][HH:MM] => registro
$slot = [];
foreach ($abbrDays as $d) $slot[$d] = [];

foreach ($week as $d => $rows) {
  foreach ($rows as $r) {
    $h = (string)$getInicio($r);
    if ($h === '') continue;
    // Normaliza a HH:MM
    $h = date('H:i', strtotime($h));
    $slot[$d][$h] = $r;
  }
}
?>

<div class="mx-auto w-full max-w-7xl px-6 py-8">
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

  <!-- Controles -->
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
          <!-- Columna horas -->
          <div class="w-20">
            <div class="h-20 border-b border-neutral-200 dark:border-neutral-700"></div>
            <?php foreach ($hours as $h): ?>
              <div class="h-20 flex items-center justify-center border-b border-neutral-200 dark:border-neutral-700">
                <span class="text-sm text-neutral-500 dark:text-neutral-400"><?= htmlspecialchars($h) ?></span>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- Columnas por día (Lunes a Viernes) -->
          <?php foreach ($displayDays as $label => $abbr): ?>
            <div class="flex-1">
              <div class="h-20 flex items-center justify-center border-b border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-900/50">
                <span class="font-medium text-neutral-900 dark:text-white"><?= $label ?></span>
              </div>

              <?php foreach ($hours as $h): ?>
                <?php
                  $match = $slot[$abbr][$h] ?? null;
                  // Datos del slot si existe
                  $mat  = $match ? $getMat($match)   : null;
                  $aula = $match ? $getAula($match)  : null;
                  $ini  = $match ? date('H:i', strtotime((string)$getInicio($match))) : null;
                  $fin  = $match ? date('H:i', strtotime((string)$getFin($match)))    : null;
                ?>
                <div class="h-20 border-b border-neutral-200 dark:border-neutral-700 relative group">
                  <?php if ($match): ?>
                    <div class="absolute inset-x-2 top-0 h-40 bg-blue-100 dark:bg-blue-900/50 rounded-lg p-2 cursor-pointer hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-colors">
                      <div class="flex flex-col h-full">
                        <span class="text-sm font-medium text-blue-800 dark:text-blue-200">
                          <?= htmlspecialchars((string)($mat ?: 'Materia')) ?>
                        </span>
                        <span class="text-xs text-blue-600 dark:text-blue-300">
                          Aula <?= htmlspecialchars((string)($aula ?: '—')) ?>
                        </span>
                        <span class="text-xs text-blue-600 dark:text-blue-300 mt-auto">
                          <?= htmlspecialchars((string)$ini) ?> - <?= htmlspecialchars((string)$fin) ?>
                        </span>
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
          // Recorre todos los registros (semana) y suma horas por materia
          $courseHours = [];
          foreach ($abbrDays as $d) {
            foreach ($week[$d] as $r) {
              $matName = (string)($getMat($r) ?: 'Materia');
              $iniTime = strtotime((string)$getInicio($r));
              $finTime = strtotime((string)$getFin($r));
              if ($iniTime && $finTime && $finTime > $iniTime) {
                $hoursDelta = ($finTime - $iniTime) / 3600;
                $courseHours[$matName] = ($courseHours[$matName] ?? 0) + $hoursDelta;
              }
            }
          }
          $colors = ['blue','green','purple','red','yellow'];
          $i = 0;
          foreach ($courseHours as $course => $hrs):
            $color = $colors[$i % count($colors)];
            $i++;
        ?>
          <div class="flex items-center justify-between p-3 bg-<?= $color ?>-50 dark:bg-<?= $color ?>-900/20 rounded-lg">
            <div class="flex items-center gap-3">
              <div class="w-2 h-2 bg-<?= $color ?>-500 rounded-full"></div>
              <span class="text-sm font-medium text-neutral-900 dark:text-white"><?= htmlspecialchars($course) ?></span>
            </div>
            <span class="text-sm text-neutral-500 dark:text-neutral-400"><?= $hrs ?> hrs/sem</span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <h3 class="text-lg font-bold mb-4">Profesores</h3>
      <div class="space-y-4">
        <?php
          $uniqueTeachers = [];
          foreach ($abbrDays as $d) {
            foreach ($week[$d] as $r) {
              $t = (string)($getProf($r) ?: '—');
              $m = (string)($getMat($r)  ?: 'Materia');
              if ($t !== '—' && !isset($uniqueTeachers[$t])) $uniqueTeachers[$t] = $m;
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
          foreach ($abbrDays as $d) {
            foreach ($week[$d] as $r) {
              $room = (string)($getAula($r) ?: '—');
              if ($room !== '—' && !in_array($room, $uniqueRooms, true)) $uniqueRooms[] = $room;
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
  AOS.init();
  feather.replace();
</script>
