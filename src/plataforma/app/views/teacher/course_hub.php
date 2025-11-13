<?php
/** @var object $course */
/** @var array<object> $tasks */
/** @var array<object> $subs */
/** @var array<object> $resources */
/** @var array<object> $activityTypes */
$esc = fn($v)=>htmlspecialchars((string)($v??''),ENT_QUOTES,'UTF-8');

$cid   = (int)($_GET['id'] ?? 0);
$title = trim(($course->materia_nombre ?? 'Materia').' · '.($course->codigo ?? ''));

// contadores rápidos
$tasksCount = is_array($tasks) ? count($tasks) : 0;
$subsCount  = is_array($subs) ? count($subs) : 0;
$resoCount  = is_array($resources) ? count($resources) : 0;
?>
<div class="container px-6 py-8">
  <!-- Encabezado / Breadcrumb -->
  <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-6 text-white shadow-2xl mb-6">
    <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-white/10 blur-2xl"></div>
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 relative">
      <div class="space-y-1">
        <nav class="text-white/80 text-sm">
          <a href="/src/plataforma/app/teacher/courses" class="hover:underline">Mis cursos</a>
          <span class="mx-1">/</span>
          <span class="opacity-90"><?= $esc($title) ?></span>
        </nav>
        <h1 class="text-2xl md:text-3xl font-bold"><?= $esc($title) ?></h1>
        <p class="text-white/90">Gestiona actividades, calificaciones y recursos de este curso.</p>
      </div>
      <div class="flex items-center gap-3">
        <a href="/src/plataforma/app/teacher/courses" class="inline-flex items-center gap-2 rounded-lg bg-white/15 hover:bg-white/25 px-3 py-2 text-sm transition">
          <i data-feather="arrow-left" class="w-4 h-4"></i> Volver a cursos
        </a>
        <a href="#tareas" class="inline-flex items-center gap-2 rounded-lg bg-white text-blue-700 px-3 py-2 text-sm font-semibold shadow hover:shadow-md transition">
          <i data-feather="plus-circle" class="w-4 h-4"></i> Nueva actividad
        </a>
      </div>
    </div>

    <!-- KPIs -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-3">
      <div class="rounded-xl bg-white/15 px-4 py-3 backdrop-blur-sm">
        <div class="flex items-center justify-between">
          <p class="text-sm text-white/90">Actividades</p>
          <i data-feather="check-square" class="w-4 h-4 opacity-90"></i>
        </div>
        <p class="text-2xl font-extrabold mt-1"><?= $tasksCount ?></p>
      </div>
      <div class="rounded-xl bg-white/15 px-4 py-3 backdrop-blur-sm">
        <div class="flex items-center justify-between">
          <p class="text-sm text-white/90">Entregas recientes</p>
          <i data-feather="inbox" class="w-4 h-4 opacity-90"></i>
        </div>
        <p class="text-2xl font-extrabold mt-1"><?= $subsCount ?></p>
      </div>
      <div class="rounded-xl bg-white/15 px-4 py-3 backdrop-blur-sm">
        <div class="flex items-center justify-between">
          <p class="text-sm text-white/90">Recursos</p>
          <i data-feather="folder" class="w-4 h-4 opacity-90"></i>
        </div>
        <p class="text-2xl font-extrabold mt-1"><?= $resoCount ?></p>
      </div>
    </div>
  </div>

  <!-- Tabs -->
  <div class="sticky top-0 z-10 -mx-6 px-6 bg-white/80 dark:bg-neutral-900/80 backdrop-blur supports-[backdrop-filter]:bg-white/50 border-b border-neutral-200 dark:border-neutral-800">
    <div class="flex items-center gap-2 py-3 overflow-x-auto">
      <?php
        $active = function(string $id): string {
          $is = (isset($_GET['tab']) && $_GET['tab']===$id) || (!isset($_GET['tab']) && $id==='tareas');
          return $is ? 'data-active="1"' : '';
        };
        $tabUrl = fn($id)=> '/src/plataforma/app/teacher/courses/show?id='.$cid.'&tab='.$id.'#'.$id;
      ?>
      <a href="<?= $esc($tabUrl('tareas')) ?>" class="tablink" <?= $active('tareas') ?>>
        <i data-feather="file-plus" class="w-4 h-4"></i> Actividades
      </a>
      <a href="<?= $esc($tabUrl('calificaciones')) ?>" class="tablink" <?= $active('calificaciones') ?>>
        <i data-feather="edit-3" class="w-4 h-4"></i> Calificaciones
      </a>
      <a href="<?= $esc($tabUrl('recursos')) ?>" class="tablink" <?= $active('recursos') ?>>
        <i data-feather="archive" class="w-4 h-4"></i> Recursos
      </a>
    </div>
  </div>

  <!-- ACTIVIDADES -->
  <section id="tareas" class="card mt-6" data-tab="tareas">
    <div class="card-head">
      <div class="title">
        <i data-feather="file-text" class="w-5 h-5"></i>
        <h2>Gestión de actividades</h2>
      </div>
    </div>

    <!-- Crear actividad -->
    <form id="activity-form"
          class="grid md:grid-cols-3 gap-4 p-6 border-b border-neutral-100 dark:border-neutral-800"
          method="post"
          action="/src/plataforma/app/teacher/courses/task/store"
          enctype="multipart/form-data">
      <input type="hidden" name="course_id" value="<?= $cid ?>">
      <!-- para guardar el examen en JSON cuando el tipo sea 'exam' -->
      <textarea name="exam_definition" id="exam-definition" class="hidden"></textarea>

      <div class="md:col-span-2 space-y-3">
        <div>
          <label class="label">Título *</label>
          <input class="input" name="title" id="activity-title" placeholder="Ej. Examen parcial 1" required>
        </div>

        <div class="grid md:grid-cols-2 gap-3">
          <div>
            <label class="label">Tipo de actividad *</label>
            <select class="input" name="activity_type_id" id="activity-type" required>
              <option value="">Selecciona un tipo</option>
              <?php if (!empty($activityTypes)): ?>
                <?php foreach ($activityTypes as $at): ?>
                  <?php
                    $slug = (string)($at->slug ?? '');
                    // No mostrar asistencia en el combo
                    if (strtolower($slug) === 'attendance' || strtolower($at->name ?? '') === 'asistencia') {
                      continue;
                    }
                  ?>
                  <option value="<?= (int)($at->id ?? 0) ?>"
                          data-slug="<?= $esc($slug) ?>"
                          data-default-weight="<?= $esc((float)($at->default_weight ?? 0)) ?>"
                          data-default-attempts="<?= (int)($at->default_max_attempts ?? 1) ?>">
                    <?= $esc($at->name ?? '') ?>
                    <?php if (isset($at->default_weight) && $at->default_weight > 0): ?>
                      (<?= $esc((float)$at->default_weight) ?>%)
                    <?php endif; ?>
                  </option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
            <p class="help-text">Tarea, actividad de clase, proyecto, examen, etc.</p>
          </div>
          <div>
            <label class="label">Parcial</label>
            <select class="input" name="parcial" id="activity-parcial">
              <option value="1">Parcial 1</option>
              <option value="2">Parcial 2</option>
              <option value="3">Parcial 3</option>
            </select>
            <p class="help-text">Para el cálculo de la calificación del parcial.</p>
          </div>
        </div>

        <div class="grid md:grid-cols-3 gap-3">
          <div>
            <label class="label">Peso en el parcial (%)</label>
            <input class="input" type="number" name="weight_percent" id="activity-weight"
                   step="0.01" min="0" max="100" placeholder="Ej. 10">
            <p class="help-text">Si lo dejas vacío se usa el valor sugerido del tipo.</p>
          </div>
          <div>
            <label class="label">Intentos permitidos</label>
            <input class="input" type="number" name="max_attempts" id="activity-attempts"
                   min="1" max="10" placeholder="Ej. 3">
            <p class="help-text">Tareas/actividades/proyectos: más intentos. Exámenes: normalmente 1.</p>
          </div>
          <div>
            <label class="label">Puntos totales</label>
            <input class="input" type="number" name="total_points" id="activity-points"
                   step="0.01" min="1" placeholder="Ej. 10">
            <p class="help-text">Máximo de puntos de la actividad.</p>
          </div>
        </div>

        <!-- BLOQUE NORMAL (tarea / actividad de clase / proyecto) -->
        <div id="block-basic-activity" class="space-y-3">
          <div>
            <label class="label">Descripción</label>
            <textarea class="input min-h-[90px]" name="description" id="activity-description"
                      placeholder="Instrucciones, criterios, formato…"></textarea>
          </div>
          <div class="grid md:grid-cols-2 gap-3">
            <div>
              <label class="label">Fecha de entrega</label>
              <input class="input" type="datetime-local" name="due_at" id="activity-due">
            </div>
            <div>
              <label class="label">Archivos (opcional)</label>
              <input class="input file:mr-3 file:py-2 file:px-3 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700"
                     type="file" name="file">
              <p class="help-text">Ej. PDF de instrucciones, rúbrica, plantillas.</p>
            </div>
          </div>
        </div>

        <!-- BLOQUE EXAMEN (tipo Google Forms) -->
        <div id="block-exam-activity" class="space-y-4 hidden">
          <div>
            <label class="label">Instrucciones del examen</label>
            <textarea class="input min-h-[80px]" id="exam-instructions"
                      placeholder="Indicaciones generales, tiempo estimado, reglas, etc."></textarea>
          </div>

          <div class="grid md:grid-cols-2 gap-3">
            <div>
              <label class="label">Fecha de aplicación / cierre</label>
              <input class="input" type="datetime-local" id="exam-due">
              <p class="help-text">Se copiará a la fecha de entrega de la actividad.</p>
            </div>
            <div>
              <label class="label">Intentos del examen</label>
              <input class="input" type="number" id="exam-attempts" min="1" max="3" placeholder="Normalmente 1">
              <p class="help-text">Si lo dejas vacío se usará el valor por defecto del tipo.</p>
            </div>
          </div>

          <div class="exam-builder">
            <div class="exam-builder-header">
              <h3>Preguntas del examen</h3>
              <button type="button" class="btn-indigo btn-sm" id="btn-add-question">
                <i data-feather="plus" class="w-4 h-4"></i> Agregar pregunta
              </button>
            </div>
            <div id="exam-questions"></div>
            <p class="help-text mt-2">
              Para cada pregunta puedes elegir “Opción única” o “Varias correctas” y marcar cuáles opciones son las respuestas correctas.
            </p>
          </div>
        </div>
      </div>

      <div class="space-y-3">
        <button class="btn-primary w-full mt-2">
          <i data-feather="save" class="w-4 h-4"></i> Crear actividad
        </button>
      </div>
    </form>

    <!-- Lista de actividades -->
    <div class="p-6">
      <?php if (!empty($tasks)): ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <?php foreach ($tasks as $t): ?>
            <div class="item">
              <div class="flex items-start justify-between gap-3">
                <div class="space-y-1">
                  <h3 class="item-title"><?= $esc($t->title ?? '') ?></h3>
                  <?php if (!empty($t->activity_type_name)): ?>
                    <div class="text-xs text-neutral-500 dark:text-neutral-400 flex flex-wrap gap-1">
                      <span class="pill pill-type">
                        <?= $esc($t->activity_type_name) ?>
                      </span>
                      <?php if (isset($t->weight_percent) && $t->weight_percent > 0): ?>
                        <span class="pill pill-weight">
                          Peso: <?= $esc((float)$t->weight_percent) ?>%
                        </span>
                      <?php endif; ?>
                      <?php
                        $maxAtt = isset($t->max_attempts) && $t->max_attempts > 0 ? (int)$t->max_attempts : 1;
                        $par    = isset($t->parcial) && $t->parcial > 0 ? (int)$t->parcial : 1;
                        $pts    = isset($t->total_points) && $t->total_points > 0 ? (float)$t->total_points : 10;
                      ?>
                      <span class="pill">Intentos: <?= $maxAtt ?></span>
                      <span class="pill">Parcial <?= $par ?></span>
                      <span class="pill">Puntos: <?= $pts ?></span>
                    </div>
                  <?php endif; ?>
                  <?php if (!empty($t->description)): ?>
                    <p class="item-text mt-1"><?= $esc($t->description) ?></p>
                  <?php endif; ?>
                </div>
                <span class="badge">
                  <?= $esc($t->due_at ? ('Vence: '.date('d/m H:i', strtotime($t->due_at))) : 'Sin fecha') ?>
                </span>
              </div>
              <div class="mt-3 flex items-center justify-between">
                <div class="flex items-center gap-2 text-sm text-neutral-500 dark:text-neutral-400">
                  <i data-feather="clock" class="w-4 h-4"></i>
                  <?= $esc($t->due_at ? date('D d M, H:i', strtotime($t->due_at)) : '—') ?>
                </div>
                <?php if (!empty($t->file_path)): ?>
                  <a class="link" target="_blank" href="<?= $esc($t->file_path) ?>">
                    <i data-feather="paperclip" class="w-4 h-4"></i> Adjunto
                  </a>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="empty">
          <i data-feather="box" class="w-10 h-10"></i>
          <p>No hay actividades aún. Crea la primera con el formulario de arriba.</p>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- CALIFICACIONES -->
  <section id="calificaciones" class="card mt-6" data-tab="calificaciones">
    <div class="card-head">
      <div class="title">
        <i data-feather="edit-3" class="w-5 h-5"></i>
        <h2>Calificaciones (entregas recientes)</h2>
      </div>
    </div>

    <div class="p-6">
      <?php if (!empty($subs)): ?>
        <div class="space-y-4">
          <?php foreach ($subs as $s): ?>
            <div class="item">
              <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                  <h3 class="item-title"><?= $esc($s->student_name ?? 'Alumno') ?></h3>
                  <p class="item-text">
                    <?= $esc($s->task_title ?? 'Actividad') ?> · <?= $esc($s->created_at ?? '') ?>
                  </p>
                  <?php if (!empty($s->file_path)): ?>
                    <a class="link mt-1 inline-flex items-center gap-1" target="_blank" href="<?= $esc($s->file_path) ?>">
                      <i data-feather="external-link" class="w-4 h-4"></i> Ver entrega
                    </a>
                  <?php endif; ?>
                </div>
                <form class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2"
                      method="post"
                      action="/src/plataforma/app/teacher/courses/task/grade">
                  <input type="hidden" name="course_id" value="<?= $cid ?>">
                  <input type="hidden" name="submission_id" value="<?= (int)($s->id ?? 0) ?>">
                  <input class="input w-28" name="grade" placeholder="Calificación" value="<?= $esc($s->grade ?? '') ?>">
                  <input class="input w-64" name="feedback" placeholder="Comentarios" value="<?= $esc($s->feedback ?? '') ?>">
                  <button class="btn-indigo">
                    <i data-feather="save" class="w-4 h-4"></i> Guardar
                  </button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="empty">
          <i data-feather="inbox" class="w-10 h-10"></i>
          <p>No hay entregas recientes.</p>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- RECURSOS -->
  <section id="recursos" class="card mt-6" data-tab="recursos">
    <div class="card-head">
      <div class="title">
        <i data-feather="archive" class="w-5 h-5"></i>
        <h2>Recursos del curso</h2>
      </div>
    </div>

    <!-- Subir recurso -->
    <form class="grid md:grid-cols-3 gap-4 p-6 border-b border-neutral-100 dark:border-neutral-800"
          method="post"
          action="/src/plataforma/app/teacher/courses/resource/store"
          enctype="multipart/form-data">
      <input type="hidden" name="course_id" value="<?= $cid ?>">
      <div class="md:col-span-2">
        <label class="label">Título *</label>
        <input class="input" name="title" placeholder="Ej. Guía de estudio" required>
      </div>
      <div>
        <label class="label">Archivo</label>
        <input class="input file:mr-3 file:py-2 file:px-3 file:rounded file:border-0 file:bg-purple-50 file:text-purple-700" type="file" name="file" accept="*/*">
        <button class="btn-purple w-full mt-2">
          <i data-feather="upload" class="w-4 h-4"></i> Subir
        </button>
      </div>
    </form>

    <!-- Lista de recursos -->
    <div class="p-6">
      <?php if (!empty($resources)): ?>
        <ul class="divide-y divide-neutral-100 dark:divide-neutral-800">
          <?php foreach ($resources as $r): ?>
            <li class="py-3 flex items-center justify-between">
              <div>
                <p class="font-medium text-neutral-800 dark:text-neutral-100"><?= $esc($r->title ?? '') ?></p>
                <p class="text-sm text-neutral-500 dark:text-neutral-400"><?= $esc($r->created_at ?? '') ?></p>
              </div>
              <?php if (!empty($r->file_path)): ?>
                <a class="link" target="_blank" href="<?= $esc($r->file_path) ?>">
                  <i data-feather="download-cloud" class="w-4 h-4"></i> Ver / Descargar
                </a>
              <?php endif; ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <div class="empty">
          <i data-feather="folder" class="w-10 h-10"></i>
          <p>No hay recursos aún.</p>
        </div>
      <?php endif; ?>
    </div>
  </section>
</div>

<!-- Estilos utilitarios locales -->
<style>
  .tablink{
    display:inline-flex;align-items:center;gap:.5rem;
    padding:.5rem .75rem;border-radius:.625rem;font-weight:600;
    color:#334155;background:#f1f5f9;border:1px solid #e5e7eb;
    transition:.2s;
  }
  .dark .tablink{color:#e5e7eb;background:#0f172a;border-color:#1f2937}
  .tablink:hover{background:#e2e8f0}.dark .tablink:hover{background:#111827}
  .tablink[data-active="1"]{background:#e0e7ff;color:#4338ca;border-color:#c7d2fe}
  .dark .tablink[data-active="1"]{background:#1e1b4b;color:#c7d2fe;border-color:#312e81}

  .card{background:#fff;border:1px solid #e5e7eb;border-radius:1rem;box-shadow:0 8px 24px rgba(0,0,0,.06)}
  .dark .card{background:#0b1220;border-color:#1e293b}
  .card-head{display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;border-bottom:1px solid #e5e7eb}
  .dark .card-head{border-color:#1e293b}
  .card-head .title{display:flex;align-items:center;gap:.5rem}
  .card-head h2{font-weight:700;font-size:1.1rem}

  .label{display:block;margin-bottom:.35rem;font-size:.85rem;color:#475569}
  .dark .label{color:#cbd5e1}
  .input{width:100%;padding:.55rem .75rem;border:1px solid #e2e8f0;border-radius:.625rem;background:#fff;color:#0f172a}
  .input:focus{outline:none;border-color:#818cf8;box-shadow:0 0 0 3px rgba(129,140,248,.25)}
  .dark .input{background:#0b1220;color:#e5e7eb;border-color:#1e293b}
  .badge{display:inline-flex;align-items:center;gap:.35rem;padding:.25rem .5rem;border-radius:9999px;font-size:.7rem;background:#eef2ff;color:#4338ca}
  .dark .badge{background:#1e1b4b;color:#c7d2fe}
  .item{border:1px solid #e5e7f1;border-radius:.875rem;padding:1rem;background:#fff}
  .dark .item{border-color:#1e293b;background:#0b1220}
  .item-title{font-weight:700;color:#0f172a}
  .dark .item-title{color:#e5e7eb}
  .item-text{font-size:.9rem;color:#64748b}
  .dark .item-text{color:#94a3b8}
  .link{display:inline-flex;align-items:center;gap:.35rem;color:#4338ca;font-weight:600}
  .link:hover{text-decoration:underline}
  .btn-primary,.btn-indigo,.btn-purple{
    display:inline-flex;align-items:center;gap:.5rem;justify-content:center;
    border-radius:.625rem;padding:.55rem .8rem;font-weight:700;transition:.2s
  }
  .btn-primary{background:#2563eb;color:#fff}
  .btn-primary:hover{background:#1d4ed8}
  .btn-indigo{background:#4f46e5;color:#fff}
  .btn-indigo:hover{background:#4338ca}
  .btn-purple{background:#7c3aed;color:#fff}
  .btn-purple:hover{background:#6d28d9}
  .btn-sm{padding:.35rem .6rem;font-size:.8rem}

  .empty{border:2px dashed #e5e7eb;border-radius:1rem;padding:2rem;text-align:center;color:#64748b;background:#fafafa}
  .dark .empty{border-color:#1e293b;background:#0b1220;color:#94a3b8}

  .help-text{
    font-size:.75rem;
    color:#9ca3af;
    margin-top:.15rem;
  }
  .dark .help-text{color:#6b7280}

  .pill{
    display:inline-flex;
    align-items:center;
    padding:.1rem .55rem;
    border-radius:9999px;
    border:1px solid rgba(148,163,184,.5);
    background:rgba(248,250,252,.8);
  }
  .dark .pill{
    border-color:#1e293b;
    background:#020617;
  }
  .pill-type{
    border-color:#4f46e5;
    background:#eef2ff;
    color:#4338ca;
  }
  .dark .pill-type{
    border-color:#4338ca;
    background:#1e1b4b;
    color:#c7d2fe;
  }
  .pill-weight{
    border-color:#22c55e;
    background:#ecfdf3;
    color:#15803d;
  }
  .dark .pill-weight{
    border-color:#16a34a;
    background:#052e16;
    color:#bbf7d0;
  }

  .hidden{display:none;}

  .exam-builder{
    border-radius:.9rem;
    border:1px solid #e5e7eb;
    background:#f9fafb;
    padding:1rem;
  }
  .dark .exam-builder{
    border-color:#1e293b;
    background:#020617;
  }
  .exam-builder-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:.75rem;
  }
  .exam-builder-header h3{
    font-weight:700;
    font-size:.95rem;
    color:#111827;
  }
  .dark .exam-builder-header h3{color:#e5e7eb}

  .exam-question{
    border-radius:.75rem;
    border:1px solid #e5e7eb;
    background:#fff;
    padding:.75rem;
    margin-bottom:.75rem;
  }
  .dark .exam-question{
    border-color:#1f2937;
    background:#020617;
  }
  .exam-question-header{
    display:flex;
    justify-content:space-between;
    gap:.5rem;
    margin-bottom:.5rem;
  }
  .exam-question-title{
    flex:1;
  }
  .exam-option-row{
    display:flex;
    align-items:center;
    gap:.5rem;
    margin-bottom:.35rem;
  }
  .exam-option-row input[type="text"]{
    flex:1;
  }
  .exam-question-actions{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:.5rem;
    font-size:.8rem;
  }
  .btn-link{
    border:none;
    background:none;
    padding:0;
    font-size:.8rem;
    color:#4f46e5;
    cursor:pointer;
  }
  .btn-link:hover{text-decoration:underline;}
</style>

<script>
  // Feather
  feather.replace();

  // Tabs
  (function () {
    const params = new URLSearchParams(location.search);
    const tab = params.get('tab') || 'tareas';
    document.querySelectorAll('[data-tab]').forEach(s => {
      s.style.display = (s.getAttribute('data-tab') === tab) ? 'block' : 'none';
    });
    if (!params.get('tab') && location.hash) {
      const id = location.hash.replace('#','');
      document.querySelectorAll('[data-tab]').forEach(s => {
        s.style.display = (s.getAttribute('data-tab') === id) ? 'block' : 'none';
      });
      document.querySelectorAll('.tablink').forEach(a=>{
        a.removeAttribute('data-active');
        if (a.getAttribute('href')?.includes('#'+id)) a.setAttribute('data-active','1');
      });
    }
  })();

  // ===== Lógica de tipo de actividad (normal vs examen) =====
  (function () {
    const typeSelect     = document.getElementById('activity-type');
    const weightInput    = document.getElementById('activity-weight');
    const attemptsInput  = document.getElementById('activity-attempts');
    const pointsInput    = document.getElementById('activity-points');

    const blockBasic     = document.getElementById('block-basic-activity');
    const blockExam      = document.getElementById('block-exam-activity');
    const examDue        = document.getElementById('exam-due');
    const examAttempts   = document.getElementById('exam-attempts');
    const activityDue    = document.getElementById('activity-due');

    if (!typeSelect) return;

    function updateMode() {
      const opt = typeSelect.options[typeSelect.selectedIndex];
      const slug = opt?.dataset.slug || '';
      const defaultWeight   = parseFloat(opt?.dataset.defaultWeight || '0');
      const defaultAttempts = parseInt(opt?.dataset.defaultAttempts || '1', 10);

      // Autorellenar peso e intentos si están vacíos
      if (!weightInput.value && !isNaN(defaultWeight)) {
        weightInput.value = defaultWeight > 0 ? defaultWeight : '';
      }
      if (!attemptsInput.value && !isNaN(defaultAttempts)) {
        attemptsInput.value = defaultAttempts > 0 ? defaultAttempts : '';
      }

      const isExam = slug === 'exam';

      if (isExam) {
        blockBasic.classList.add('hidden');
        blockExam.classList.remove('hidden');
      } else {
        blockBasic.classList.remove('hidden');
        blockExam.classList.add('hidden');
      }
    }

    typeSelect.addEventListener('change', updateMode);
    updateMode();

    // Sincronizar fecha de examen con fecha de entrega
    if (examDue && activityDue) {
      examDue.addEventListener('change', () => {
        if (!activityDue.value) activityDue.value = examDue.value;
      });
    }

    // ===== Mini constructor de examen (single_choice / multiple_choice) =====
    const questionsContainer = document.getElementById('exam-questions');
    const btnAddQuestion     = document.getElementById('btn-add-question');
    const examDefinition     = document.getElementById('exam-definition');
    const examInstructions   = document.getElementById('exam-instructions');
    const activityForm       = document.getElementById('activity-form');

    let questionCounter = 0;

    function createQuestionCard() {
      questionCounter++;
      const qId = 'q_' + questionCounter;

      const wrapper = document.createElement('div');
      wrapper.className = 'exam-question';
      wrapper.dataset.qid = qId;

      wrapper.innerHTML = `
        <div class="exam-question-header">
          <div class="exam-question-title">
            <label class="label">Pregunta</label>
            <input type="text" class="input exam-question-text" placeholder="Escribe la pregunta">
          </div>
          <div class="w-40">
            <label class="label">Tipo</label>
            <select class="input exam-question-type">
              <option value="single_choice">Opción única</option>
              <option value="multiple_choice">Varias correctas</option>
            </select>
          </div>
        </div>
        <div class="exam-question-body">
          <div class="exam-options-container"></div>
        </div>
        <div class="exam-question-actions">
          <button type="button" class="btn-link exam-add-option">+ Agregar opción</button>
          <button type="button" class="btn-link exam-remove-question">Eliminar pregunta</button>
        </div>
      `;

      const typeSelectQ      = wrapper.querySelector('.exam-question-type');
      const optionsContainer = wrapper.querySelector('.exam-options-container');
      const btnAddOption     = wrapper.querySelector('.exam-add-option');
      const btnRemoveQuestion= wrapper.querySelector('.exam-remove-question');

      function addOption() {
        const row = document.createElement('div');
        row.className = 'exam-option-row';
        row.innerHTML = `
          <input type="text" class="input exam-option-text" placeholder="Opción">
          <label class="flex items-center text-xs text-neutral-500">
            <input type="checkbox" class="exam-option-correct mr-1">
            Correcta
          </label>
          <button type="button" class="btn-link exam-remove-option">x</button>
        `;
        const removeBtn = row.querySelector('.exam-remove-option');
        const correctCb = row.querySelector('.exam-option-correct');

        removeBtn.addEventListener('click', () => {
          row.remove();
        });

        correctCb.addEventListener('change', () => {
          // Si es single_choice, solo permitir una correcta
          if (typeSelectQ.value === 'single_choice' && correctCb.checked) {
            optionsContainer.querySelectorAll('.exam-option-correct').forEach(cb => {
              if (cb !== correctCb) cb.checked = false;
            });
          }
        });

        optionsContainer.appendChild(row);
      }

      function renderOptions() {
        optionsContainer.innerHTML = '';
        // Por defecto siempre 2 opciones
        addOption();
        addOption();
      }

      typeSelectQ.addEventListener('change', () => {
        // No necesitamos cambiar el UI de opciones,
        // solo la lógica de cómo interpretamos las correctas
        // (single_choice vs multiple_choice) ya se maneja en el submit
        // pero si quieres resetear al cambiar tipo:
        // renderOptions();
      });

      btnAddOption.addEventListener('click', () => {
        addOption();
      });

      btnRemoveQuestion.addEventListener('click', () => {
        wrapper.remove();
      });

      // inicial: dos opciones
      renderOptions();

      questionsContainer.appendChild(wrapper);
    }

    if (btnAddQuestion && questionsContainer) {
      btnAddQuestion.addEventListener('click', () => {
        createQuestionCard();
      });
    }

    // Antes de enviar el formulario, si es examen, serializar el esquema a JSON
    if (activityForm && examDefinition) {
      activityForm.addEventListener('submit', (e) => {
        const opt = typeSelect.options[typeSelect.selectedIndex];
        const slug = opt?.dataset.slug || '';
        if (slug !== 'exam') {
          examDefinition.value = '';
          return;
        }

        const data = {
          instructions: examInstructions.value || '',
          due_at: examDue.value || '',
          questions: []
        };

        questionsContainer.querySelectorAll('.exam-question').forEach(q => {
          const textEl = q.querySelector('.exam-question-text');
          const typeEl = q.querySelector('.exam-question-type');
          const optionsEls = q.querySelectorAll('.exam-option-text');
          const correctEls = q.querySelectorAll('.exam-option-correct');

          const typeVal = typeEl?.value || 'single_choice';
          const qData = {
            text: textEl?.value || '',
            type: typeVal,
            options: []
          };

          const correctIdxs = [];

          optionsEls.forEach((optEl, idx) => {
            const val = optEl.value.trim();
            const correctCb = correctEls[idx];
            if (val) {
              qData.options.push(val);
              if (correctCb && correctCb.checked) {
                correctIdxs.push(idx);
              }
            }
          });

          // Ajustar correctos según tipo
          if (typeVal === 'single_choice') {
            if (correctIdxs.length > 0) {
              // Tomar solo la primera por seguridad
              qData.correct_index = correctIdxs[0];
            }
          } else if (typeVal === 'multiple_choice') {
            qData.correct_indices = correctIdxs;
          }

          if (qData.text.trim() && qData.options.length > 0) {
            data.questions.push(qData);
          }
        });

        examDefinition.value = JSON.stringify(data);
        // copiar fecha/intent de campos de examen si están llenos
        if (examDue && examDue.value && !activityDue.value) {
          activityDue.value = examDue.value;
        }
        if (examAttempts && examAttempts.value && !attemptsInput.value) {
          attemptsInput.value = examAttempts.value;
        }
      });
    }
  })();
</script>
