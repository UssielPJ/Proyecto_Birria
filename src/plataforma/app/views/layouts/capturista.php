<?php
// Guard de acceso
if (session_status() === PHP_SESSION_NONE) session_start();
if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
  header('Location: /src/plataforma/'); exit;
}
$U = $_SESSION['user'] ?? ['name'=>'Capturista','email'=>'capturista@utec.edu'];
?>
<!DOCTYPE html>
<html lang="es" class="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UTEC · Panel Capturista</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>

  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: {
              50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',
              500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b'
            },
            neutral: {
              50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',
              500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a'
            }
          }
        }
      }
    }
  </script>

  <style>
    /* ======= FIX de colapso consistente ======= */
    :root{
      --sb-expanded: 16rem;  /* 256px */
      --sb-collapsed: 5rem;  /* 80px  */
    }
    .sidebar{
      position: fixed; inset: 0 auto 0 0;
      width: var(--sb-expanded);
      z-index: 50;
      overflow-x: hidden; overflow-y: auto;
      transition: width .25s ease;
      background: #fff;
    }
    .content-area{
      margin-left: var(--sb-expanded);
      transition: margin-left .25s ease;
      position: relative; z-index: 40;
    }
    /* Estado colapsado aplicado al <body> */
    .body--sb-collapsed .sidebar{ width: var(--sb-collapsed); }
    .body--sb-collapsed .content-area{ margin-left: var(--sb-collapsed); }

    /* Cuando está colapsado: icon-only */
    .body--sb-collapsed .logo-text,
    .body--sb-collapsed .user-info,
    .body--sb-collapsed .nav-text{ display:none; }

    .nav-item{ display:flex; align-items:center; gap:.75rem; padding:.75rem; border-radius:.5rem; }
    .body--sb-collapsed .nav-item{ justify-content:center; gap:0; }

    /* Mobile: drawer */
    @media (max-width: 768px){
      .sidebar{ transform:translateX(-100%); }
      .sidebar.sidebar-mobile{ transform:translateX(0); }
      .content-area{ margin-left:0 !important; }
    }

    /* Botón tema animado */
    .nav-toggle { position:relative; }
    .nav-toggle .icon-sun, .nav-toggle .icon-moon{
      position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
      transition: opacity .25s ease, transform .25s ease;
    }
    .nav-toggle .icon-moon{ opacity:0; transform:scale(.5) rotate(-90deg); }
    html.dark .nav-toggle .icon-sun{ opacity:0; transform:scale(.5) rotate(90deg); }
    html.dark .nav-toggle .icon-moon{ opacity:1; transform:scale(1) rotate(0deg); }
  </style>
</head>

<body class="bg-neutral-50 dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 min-h-screen">
  <div class="flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar dark:bg-neutral-800 shadow-lg">
      <div class="p-4 flex items-center space-x-3">
        <div class="bg-primary-500 p-2 rounded-lg">
          <i data-feather="clipboard" class="text-white"></i>
        </div>
        <span class="logo-text text-xl font-bold text-primary-700 dark:text-primary-300">Captura UTEC</span>
      </div>

      <div class="px-4 pb-4 border-b border-neutral-200 dark:border-neutral-700">
        <div class="user-info flex items-center space-x-3">
          <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
            <i data-feather="user" class="text-primary-700 dark:text-primary-300"></i>
          </div>
          <div class="min-w-0">
            <p class="font-medium leading-tight truncate"><?= htmlspecialchars($U['name']) ?></p>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 leading-tight truncate"><?= htmlspecialchars($U['email']) ?></p>
          </div>
        </div>
      </div>

      <nav class="p-4">
        <ul class="space-y-2">
          <li>
            <a href="/src/plataforma/capturista/" class="nav-item bg-primary-50 dark:bg-neutral-700/60 text-primary-700 dark:text-primary-300">
              <i data-feather="home"></i><span class="nav-text">Panel</span>
            </a>
          </li>

          <li class="pt-2 pb-1 text-xs uppercase tracking-wide text-neutral-500 dark:text-neutral-400 nav-text">Inscripciones</li>

          <li>
            <a href="/src/plataforma/solicitudes" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700">
              <i data-feather="file-text"></i><span class="nav-text">Solicitudes</span>
            </a>
          </li>
          <li>
            <a href="/src/plataforma/solicitudes/nueva" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700">
              <i data-feather="edit-3"></i><span class="nav-text">Capturar solicitud</span>
            </a>
          </li>
          <li>
            <a href="/src/plataforma/capturista/importar" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700">
              <i data-feather="upload-cloud"></i><span class="nav-text">Importar CSV/Excel</span>
            </a>
          </li>
          <li>
            <a href="/src/plataforma/capturista/alumnos" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700">
              <i data-feather="users"></i><span class="nav-text">Alumnos</span>
            </a>
          </li>
          <li>
            <a href="/src/plataforma/capturista/inscripciones" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700">
              <i data-feather="check-circle"></i><span class="nav-text">Inscripciones</span>
            </a>
          </li>

          <li class="pt-3 pb-1 text-xs uppercase tracking-wide text-neutral-500 dark:text-neutral-400 nav-text">Utilidades</li>
          <li>
            <a href="/src/plataforma/capturista/reportes" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700">
              <i data-feather="bar-chart-2"></i><span class="nav-text">Reportes</span>
            </a>
          </li>
        </ul>
      </nav>

      <div class="p-4 border-t border-neutral-200 dark:border-neutral-700 mt-auto">
        <a href="/src/plataforma/logout" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700 w-full">
          <i data-feather="log-out"></i><span class="nav-text">Cerrar sesión</span>
        </a>
      </div>
    </aside>

    <!-- Contenido -->
    <div id="content" class="content-area flex-1 min-h-screen">
      <!-- Topbar -->
      <header class="bg-white dark:bg-neutral-800 shadow-sm sticky top-0 z-40">
        <div class="flex items-center justify-between p-4">
          <div class="flex items-center gap-4">
            <button id="sidebar-toggle" class="text-neutral-500 dark:text-neutral-400" aria-label="Alternar menú">
              <i data-feather="menu"></i>
            </button>
            <h1 class="text-xl font-bold">Panel de Captura</h1>
          </div>

          <div class="flex items-center gap-3">
            <button id="theme-toggle" class="nav-toggle h-9 w-9 rounded-xl ring-1 ring-black/10 dark:ring-white/10 hover:ring-black/20 dark:hover:ring-white/20 bg-white/80 dark:bg-neutral-700/60" aria-label="Cambiar tema">
              <span class="icon-sun">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="4"></circle>
                  <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
                </svg>
              </span>
              <span class="icon-moon">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z"/>
                </svg>
              </span>
            </button>

            <a href="#" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700 relative" aria-label="Notificaciones">
              <i data-feather="bell"></i>
              <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </a>

            <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
              <i data-feather="user" class="text-primary-700 dark:text-primary-300"></i>
            </div>
          </div>
        </div>
      </header>

      <main class="p-6">
        <div class="bg-gradient-to-r from-primary-500 to-primary-700 rounded-xl p-6 text-white mb-6" data-aos="fade-up">
          <h2 class="text-2xl font-bold mb-1">¡Hola, <?= htmlspecialchars($U['name']) ?>!</h2>
          <p class="opacity-90">Captura solicitudes, importa información y ayuda a dar de alta alumnos.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
          <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-primary-500" data-aos="fade-up">
            <div class="flex items-center justify-between">
              <div><p class="text-neutral-500 dark:text-neutral-400 text-sm">Solicitudes de hoy</p><h3 class="text-2xl font-bold mt-1">42</h3></div>
              <div class="p-3 rounded-lg bg-primary-50 dark:bg-neutral-700"><i data-feather="file-text" class="text-primary-600"></i></div>
            </div>
          </div>
          <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-emerald-500" data-aos="fade-up" data-aos-delay="50">
            <div class="flex items-center justify-between">
              <div><p class="text-neutral-500 dark:text-neutral-400 text-sm">Aprobadas</p><h3 class="text-2xl font-bold mt-1">28</h3></div>
              <div class="p-3 rounded-lg bg-emerald-50 dark:bg-neutral-700"><i data-feather="check-circle" class="text-emerald-600"></i></div>
            </div>
          </div>
          <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-amber-500" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between">
              <div><p class="text-neutral-500 dark:text-neutral-400 text-sm">En revisión</p><h3 class="text-2xl font-bold mt-1">11</h3></div>
              <div class="p-3 rounded-lg bg-amber-50 dark:bg-neutral-700"><i data-feather="alert-circle" class="text-amber-600"></i></div>
            </div>
          </div>
          <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 border-l-4 border-rose-500" data-aos="fade-up" data-aos-delay="150">
            <div class="flex items-center justify-between">
              <div><p class="text-neutral-500 dark:text-neutral-400 text-sm">Rechazadas</p><h3 class="text-2xl font-bold mt-1">3</h3></div>
              <div class="p-3 rounded-lg bg-rose-50 dark:bg-neutral-700"><i data-feather="x-circle" class="text-rose-600"></i></div>
            </div>
          </div>
        </div>

        <section class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 mb-6" data-aos="fade-up">
          <h2 class="text-xl font-bold mb-4">Acciones rápidas</h2>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="/src/plataforma/solicitudes/nueva" class="flex flex-col items-center justify-center p-4 rounded-lg border border-neutral-100 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition">
              <div class="p-3 rounded-lg bg-primary-50 dark:bg-neutral-700 mb-2"><i data-feather="edit-3" class="text-primary-600"></i></div>
              <span class="text-sm font-medium">Capturar solicitud</span>
            </a>
            <a href="/src/plataforma/capturista/importar" class="flex flex-col items-center justify-center p-4 rounded-lg border border-neutral-100 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition">
              <div class="p-3 rounded-lg bg-emerald-50 dark:bg-neutral-700 mb-2"><i data-feather="upload-cloud" class="text-emerald-600"></i></div>
              <span class="text-sm font-medium">Importar CSV/Excel</span>
            </a>
            <a href="/src/plataforma/capturista/inscripciones" class="flex flex-col items-center justify-center p-4 rounded-lg border border-neutral-100 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition">
              <div class="p-3 rounded-lg bg-amber-50 dark:bg-neutral-700 mb-2"><i data-feather="check-circle" class="text-amber-600"></i></div>
              <span class="text-sm font-medium">Inscribir alumno</span>
            </a>
            <a href="/src/plataforma/capturista/alumnos" class="flex flex-col items-center justify-center p-4 rounded-lg border border-neutral-100 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition">
              <div class="p-3 rounded-lg bg-purple-50 dark:bg-neutral-700 mb-2"><i data-feather="users" class="text-purple-600"></i></div>
              <span class="text-sm font-medium">Ver alumnos</span>
            </a>
          </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <section class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6" data-aos="fade-up">
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-xl font-bold">Últimas solicitudes</h2>
              <a href="/src/plataforma/solicitudes" class="text-primary-700 dark:text-primary-300 text-sm">Ver todas</a>
            </div>

            <div class="space-y-3">
              <div class="flex items-center justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center"><i data-feather="user"></i></div>
                  <div><h3 class="font-medium">Ana Rodríguez</h3><p class="text-sm text-neutral-500 dark:text-neutral-400">Ing. Sistemas · Periodo 2025-1</p></div>
                </div>
                <span class="text-xs bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 px-2 py-1 rounded-full">Capturada</span>
              </div>

              <div class="flex items-center justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900 flex items-center justify-center"><i data-feather="clock"></i></div>
                  <div><h3 class="font-medium">Carlos Méndez</h3><p class="text-sm text-neutral-500 dark:text-neutral-400">Lic. Administración · 2025-1</p></div>
                </div>
                <span class="text-xs bg-amber-100 dark:bg-amber-900 text-amber-700 dark:text-amber-300 px-2 py-1 rounded-full">En revisión</span>
              </div>
            </div>
          </section>

          <section class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6" data-aos="fade-up">
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-xl font-bold">Pendientes de captura</h2>
              <a href="/src/plataforma/capturista/reportes" class="text-primary-700 dark:text-primary-300 text-sm">Ver reportes</a>
            </div>

            <div class="space-y-3">
              <div class="flex items-start justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
                <div class="flex items-start gap-3">
                  <div class="p-2 rounded-lg bg-rose-50 dark:bg-neutral-700 mt-1"><i data-feather="alert-triangle" class="text-rose-600"></i></div>
                  <div><h3 class="font-medium">Documentos faltantes</h3><p class="text-sm text-neutral-500 dark:text-neutral-400">15 solicitudes con archivos incompletos</p></div>
                </div>
                <a href="/src/plataforma/solicitudes?f=faltantes" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700"><i data-feather="chevron-right" class="text-neutral-400"></i></a>
              </div>

              <div class="flex items-start justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
                <div class="flex items-start gap-3">
                  <div class="p-2 rounded-lg bg-primary-50 dark:bg-neutral-700 mt-1"><i data-feather="upload" class="text-primary-600"></i></div>
                  <div><h3 class="font-medium">Importaciones en cola</h3><p class="text-sm text-neutral-500 dark:text-neutral-400">2 archivos pendientes de procesar</p></div>
                </div>
                <a href="/src/plataforma/capturista/importar" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700"><i data-feather="chevron-right" class="text-neutral-400"></i></a>
              </div>
            </div>
          </section>
        </div>
      </main>

      <footer class="p-6 border-t border-neutral-200 dark:border-neutral-700 mt-6">
        <p class="text-center text-sm text-neutral-500 dark:text-neutral-400">© <?= date('Y') ?> UTEC · Panel Capturista</p>
      </footer>
    </div>
  </div>

  <script>
    AOS.init(); feather.replace();

    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');

    // Toggle consistente: colapsa en desktop (clase en <body>), drawer en móvil
    sidebarToggle?.addEventListener('click', () => {
      const isMobile = window.matchMedia('(max-width: 768px)').matches;

      if (isMobile) {
        sidebar.classList.toggle('sidebar-mobile');
      } else {
        document.body.classList.toggle('body--sb-collapsed');
        localStorage.setItem('sbCollapsed', document.body.classList.contains('body--sb-collapsed') ? '1' : '0');
      }
    });

    // Restaurar estado colapsado en desktop
    (function restoreSidebar(){
      const saved = localStorage.getItem('sbCollapsed') === '1';
      const isMobile = window.matchMedia('(max-width: 768px)').matches;
      if (!isMobile && saved) document.body.classList.add('body--sb-collapsed');
    })();

    // Tema persistente
    (function(){
      const html = document.documentElement;
      const saved = localStorage.getItem('theme');
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

      if(saved){ html.classList.toggle('dark', saved==='dark'); }
      else { html.classList.toggle('dark', prefersDark); }

      document.getElementById('theme-toggle')?.addEventListener('click', ()=>{
        const toDark = !html.classList.contains('dark');
        html.classList.toggle('dark', toDark);
        localStorage.setItem('theme', toDark ? 'dark' : 'light');
        feather.replace();
      });
    })();
  </script>
</body>
</html>
