<?php
/** @var object $course */
/** @var array<object> $tasks */
/** @var array<object> $subs */
/** @var array<object> $resources */
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
        <p class="text-white/90">Gestiona tareas, calificaciones y recursos de este curso.</p>
      </div>
      <div class="flex items-center gap-3">
        <a href="/src/plataforma/app/teacher/courses" class="inline-flex items-center gap-2 rounded-lg bg-white/15 hover:bg-white/25 px-3 py-2 text-sm transition">
          <i data-feather="arrow-left" class="w-4 h-4"></i> Volver a cursos
        </a>
        <a href="#tareas" class="inline-flex items-center gap-2 rounded-lg bg-white text-blue-700 px-3 py-2 text-sm font-semibold shadow hover:shadow-md transition">
          <i data-feather="plus-circle" class="w-4 h-4"></i> Nueva tarea
        </a>
      </div>
    </div>

    <!-- KPIs -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-3">
      <div class="rounded-xl bg-white/15 px-4 py-3 backdrop-blur-sm">
        <div class="flex items-center justify-between">
          <p class="text-sm text-white/90">Tareas</p>
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
        // tab helper
        $active = function(string $id): string {
          $hash = $_SERVER['QUERY_STRING'] ?? '';
          $is = (isset($_GET['tab']) && $_GET['tab']===$id) || (!isset($_GET['tab']) && $id==='tareas');
          return $is ? 'data-active="1"' : '';
        };
        $tabUrl = fn($id)=> '/src/plataforma/app/teacher/courses/show?id='.$cid.'&tab='.$id.'#'.$id;
      ?>
      <a href="<?= $esc($tabUrl('tareas')) ?>" class="tablink" <?= $active('tareas') ?>>
        <i data-feather="file-plus" class="w-4 h-4"></i> Tareas
      </a>
      <a href="<?= $esc($tabUrl('calificaciones')) ?>" class="tablink" <?= $active('calificaciones') ?>>
        <i data-feather="edit-3" class="w-4 h-4"></i> Calificaciones
      </a>
      <a href="<?= $esc($tabUrl('recursos')) ?>" class="tablink" <?= $active('recursos') ?>>
        <i data-feather="archive" class="w-4 h-4"></i> Recursos
      </a>
    </div>
  </div>

  <!-- TAREAS -->
  <section id="tareas" class="card mt-6" data-tab="tareas">
    <div class="card-head">
      <div class="title">
        <i data-feather="file-text" class="w-5 h-5"></i>
        <h2>Gestión de tareas</h2>
      </div>
    </div>

    <!-- Crear tarea -->
    <form class="grid md:grid-cols-3 gap-4 p-6 border-b border-neutral-100 dark:border-neutral-800"
          method="post"
          action="/src/plataforma/app/teacher/courses/task/store"
          enctype="multipart/form-data">
      <input type="hidden" name="course_id" value="<?= $cid ?>">
      <div class="md:col-span-2 space-y-3">
        <div>
          <label class="label">Título *</label>
          <input class="input" name="title" placeholder="Ej. Proyecto 1" required>
        </div>
        <div>
          <label class="label">Descripción</label>
          <textarea class="input min-h-[90px]" name="description" placeholder="Instrucciones, criterios, formato…"></textarea>
        </div>
      </div>
      <div class="space-y-3">
        <div>
          <label class="label">Fecha de entrega</label>
          <input class="input" type="datetime-local" name="due_at">
        </div>
        <div>
          <label class="label">Archivo (opcional)</label>
          <input class="input file:mr-3 file:py-2 file:px-3 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700" type="file" name="file">
        </div>
        <button class="btn-primary w-full mt-2">
          <i data-feather="save" class="w-4 h-4"></i> Crear tarea
        </button>
      </div>
    </form>

    <!-- Lista de tareas -->
    <div class="p-6">
      <?php if (!empty($tasks)): ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
          <?php foreach ($tasks as $t): ?>
            <div class="item">
              <div class="flex items-start justify-between gap-3">
                <div>
                  <h3 class="item-title"><?= $esc($t->title ?? '') ?></h3>
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
          <p>Aún no hay tareas. Crea la primera con el formulario de arriba.</p>
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
                    <?= $esc($s->task_title ?? 'Tarea') ?> · <?= $esc($s->created_at ?? '') ?>
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
  .empty{border:2px dashed #e5e7eb;border-radius:1rem;padding:2rem;text-align:center;color:#64748b;background:#fafafa}
  .dark .empty{border-color:#1e293b;background:#0b1220;color:#94a3b8}
</style>

<script>
  // Feather
  feather.replace();

  // Mostrar solo la pestaña activa (cuando hay ?tab=)
  (function () {
    const params = new URLSearchParams(location.search);
    const tab = params.get('tab') || 'tareas';
    document.querySelectorAll('[data-tab]').forEach(s => {
      s.style.display = (s.getAttribute('data-tab') === tab) ? 'block' : 'none';
    });
    // Resalta el tab activo si llega por hash sin param
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
</script>
