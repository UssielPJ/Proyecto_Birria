<?php
$esc = fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');

$grupo   = $grupo   ?? (object)[];
$alumnos = is_array($alumnos ?? null) ? $alumnos : [];

// Detección de columnas opcionales
$first = $alumnos[0] ?? null;
$showTipo = is_object($first) && isset($first->tipo_ingreso);
$showBeca = is_object($first) && isset($first->beca_activa);

// Contadores
$inscritos = count($alumnos);

// Pendientes de matrícula
$pendientesCount = 0;
foreach ($alumnos as $a) {
  $mat = isset($a->matricula) ? trim((string)$a->matricula) : '';
  if ($mat === '') $pendientesCount++;
}

// URLs
$gestionarUrl = "/src/plataforma/app/admin/group_assignments?semestre_id=" . urlencode($grupo->semestre_id ?? '') . "&grupo_id=" . urlencode($grupo->id ?? '');
$volverUrl    = "/src/plataforma/app/admin/groups";
$exportUrl    = "/src/plataforma/app/admin/groups/students_export?grupo_id=" . urlencode($grupo->id ?? '');
$assignUrl    = "/src/plataforma/app/admin/groups/assign-matriculas/" . urlencode($grupo->id ?? '');
?>
<div class="container px-6 py-8">
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">

    <!-- ENCABEZADO -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
      <div>
        <h1 class="text-2xl font-bold mb-1">
          Grupo: <?= $esc($grupo->codigo ?? '—') ?>
        </h1>
        <?php if (!empty($grupo->titulo)): ?>
          <p class="text-neutral-500 dark:text-neutral-400"><?= $esc($grupo->titulo) ?></p>
        <?php endif; ?>
      </div>
      <div class="flex flex-wrap gap-2">
        <a href="<?= $gestionarUrl ?>"
           class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg inline-flex items-center gap-2">
          <i data-feather="users" class="w-4 h-4"></i>
          Gestionar Asignaciones
        </a>

        <a href="<?= $exportUrl ?>"
           class="border border-neutral-200 dark:border-neutral-700 px-4 py-2 rounded-lg inline-flex items-center gap-2 hover:bg-neutral-50 dark:hover:bg-neutral-700">
          <i data-feather="download" class="w-4 h-4"></i>
          Exportar CSV
        </a>

        <!-- Botón Asignar matrículas -->
        <a href="<?= $assignUrl ?>"
           class="px-4 py-2 rounded-lg inline-flex items-center gap-2 text-white
                  <?= $pendientesCount > 0 ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-emerald-600/50 pointer-events-none opacity-60' ?>"
           title="<?= $pendientesCount > 0 ? 'Asignar a alumnos sin matrícula' : 'No hay alumnos pendientes' ?>">
          <i data-feather="hash" class="w-4 h-4"></i>
          Asignar matrículas
          <span class="ml-1 inline-flex items-center justify-center rounded-full bg-white/20 px-2 py-0.5 text-xs">
            <?= (int)$pendientesCount ?>
          </span>
        </a>

        <button type="button"
           onclick="window.print()"
           class="border border-neutral-200 dark:border-neutral-700 px-4 py-2 rounded-lg inline-flex items-center gap-2 hover:bg-neutral-50 dark:hover:bg-neutral-700">
          <i data-feather="printer" class="w-4 h-4"></i>
          Imprimir
        </button>
      </div>
    </div>

    <!-- META DEL GRUPO -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
      <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
        <p class="text-xs uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Carrera</p>
        <p class="mt-1 text-sm font-medium"><?= $esc($grupo->carrera_nombre ?? $grupo->carrera_iniciales ?? '—') ?></p>
      </div>
      <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
        <p class="text-xs uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Semestre</p>
        <p class="mt-1 text-sm font-medium">
          <?= $esc($grupo->semestre_clave ?? (isset($grupo->semestre_numero) ? ('Sem '.$grupo->semestre_numero) : '—')) ?>
        </p>
      </div>
      <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
        <p class="text-xs uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Capacidad</p>
        <p class="mt-1 text-sm font-medium"><?= $esc($grupo->capacidad ?? '—') ?></p>
      </div>
      <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
        <p class="text-xs uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Inscritos</p>
        <p class="mt-1 text-sm font-medium"><?= $esc((string)$inscritos) ?></p>
      </div>
      <div class="bg-neutral-50 dark:bg-neutral-900 rounded-lg p-4">
        <p class="text-xs uppercase tracking-wide text-neutral-500 dark:text-neutral-400">Pendientes de matrícula</p>
        <p class="mt-1 text-sm font-medium"><?= (int)$pendientesCount ?></p>
      </div>
    </div>

    <!-- FILTROS -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
      <div class="relative w-full sm:max-w-md">
        <input id="filterInput" type="text" placeholder="Buscar por matrícula, nombre, CURP o correo…"
               class="w-full pl-10 pr-3 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-sm">
        <span class="absolute left-3 top-2.5 text-neutral-400"><i data-feather="search" class="w-4 h-4"></i></span>
      </div>
      <div class="text-sm text-neutral-600 dark:text-neutral-300">
        Total: <span id="countSpan" class="font-semibold"><?= (int)$inscritos ?></span>
      </div>
    </div>

    <!-- TABLA -->
    <div class="overflow-x-auto border border-neutral-200 dark:border-neutral-700 rounded-lg">
      <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
        <thead class="bg-neutral-50 dark:bg-neutral-900 sticky top-0 z-10">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-600 dark:text-neutral-300">#</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-600 dark:text-neutral-300">Estudiante</th>
            <!-- NUEVO: Matrícula -->
            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-600 dark:text-neutral-300">Matrícula</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-600 dark:text-neutral-300">CURP</th>
            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-600 dark:text-neutral-300">Correo</th>
            <?php if ($showTipo): ?>
              <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-600 dark:text-neutral-300">Tipo ingreso</th>
            <?php endif; ?>
            <?php if ($showBeca): ?>
              <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-600 dark:text-neutral-300">Beca</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody id="studentsBody" class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
          <?php if ($inscritos === 0): ?>
            <tr>
              <td colspan="<?= 6 + ($showTipo?1:0) + ($showBeca?1:0) ?>" class="px-6 py-8 text-center text-sm text-neutral-500 dark:text-neutral-400">
                No hay alumnos asignados a este grupo.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($alumnos as $i => $a): ?>
              <?php
                $nombre = trim(($a->apellido_paterno ?? '').' '.($a->apellido_materno ?? '').' '.($a->nombre ?? ''));
                $mat    = isset($a->matricula) ? trim((string)$a->matricula) : '';
              ?>
              <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-900/40">
                <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300"><?= (int)$i + 1 ?></td>
                <td class="px-4 py-3">
                  <div class="flex items-center gap-3">
                    <div class="h-8 w-8 rounded-full bg-neutral-100 dark:bg-neutral-700 flex items-center justify-center text-xs font-semibold text-neutral-600 dark:text-neutral-200">
                      <?php
                        $ini = mb_strtoupper(mb_substr($a->nombre ?? '',0,1).mb_substr($a->apellido_paterno ?? '',0,1));
                        echo $esc($ini ?: '👤');
                      ?>
                    </div>
                    <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100"><?= $esc($nombre ?: '—') ?></div>
                  </div>
                </td>

                <!-- Matrícula -->
                <td class="px-4 py-3 text-sm">
                  <?php if ($mat !== ''): ?>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
                      <?= $esc($mat) ?>
                    </span>
                  <?php else: ?>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-700 dark:bg-neutral-900/40 dark:text-neutral-300">
                      sin matrícula
                    </span>
                  <?php endif; ?>
                </td>

                <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300"><?= $esc($a->curp ?? '—') ?></td>
                <td class="px-4 py-3 text-sm">
                  <?php if (!empty($a->email)): ?>
                    <a href="mailto:<?= $esc($a->email) ?>" class="text-primary-600 dark:text-primary-400 hover:underline">
                      <?= $esc($a->email) ?>
                    </a>
                  <?php else: ?>
                    <span class="text-neutral-700 dark:text-neutral-300">—</span>
                  <?php endif; ?>
                </td>
                <?php if ($showTipo): ?>
                  <td class="px-4 py-3 text-sm text-neutral-700 dark:text-neutral-300"><?= $esc(ucfirst((string)($a->tipo_ingreso ?? ''))) ?: '—' ?></td>
                <?php endif; ?>
                <?php if ($showBeca): ?>
                  <td class="px-4 py-3 text-sm">
                    <?php if (!empty($a->beca_activa)): ?>
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">Sí</span>
                    <?php else: ?>
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-neutral-100 text-neutral-700 dark:bg-neutral-900/40 dark:text-neutral-300">No</span>
                    <?php endif; ?>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- VOLVER -->
    <div class="mt-6">
      <a href="<?= $volverUrl ?>" class="text-primary-600 dark:text-primary-400 hover:underline inline-flex items-center gap-2">
        <i data-feather="arrow-left" class="w-4 h-4"></i>
        Volver a Grupos
      </a>
    </div>

  </div>
</div>

<script>
  feather.replace();

  // Búsqueda en vivo por matrícula, nombre, curp o correo (la búsqueda ya toma toda la fila)
  (function(){
    const input = document.getElementById('filterInput');
    const tbody = document.getElementById('studentsBody');
    const rows  = Array.from(tbody.querySelectorAll('tr'));
    const count = document.getElementById('countSpan');
    if (!input) return;

    // Pequeño debounce para mejorar UX
    let t;
    input.addEventListener('input', () => {
      clearTimeout(t);
      t = setTimeout(() => {
        const q = input.value.trim().toLowerCase();
        let visible = 0;
        rows.forEach(row => {
          if (row.children.length === 1) return;
          const show = row.innerText.toLowerCase().includes(q);
          row.style.display = show ? '' : 'none';
          if (show) visible++;
        });
        count.textContent = visible.toString();
      }, 120);
    });
  })();
</script>
