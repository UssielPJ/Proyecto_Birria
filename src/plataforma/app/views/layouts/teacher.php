<?php
/** @var string $title */
/** @var array|null $user */
/** @var string $content */
if (!isset($title))  $title  = 'UTEC · Panel Maestro';
if (!isset($user))   $user   = $_SESSION['user'] ?? ['name'=>'Profesor', 'email'=>'profesor@utec.edu'];
?>
<!DOCTYPE html>
<html lang="es" class="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($title) ?></title>

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
            primary:{50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b'},
            neutral:{50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a'}
          }
        }
      }
    }
  </script>

  <style>
    /* ====== FIX de colapso consistente (igual que en admin/student/capturista) ====== */
    :root{ --sb-expanded:16rem; --sb-collapsed:5rem; }
    .sidebar{
      position:fixed; inset:0 auto 0 0; width:var(--sb-expanded);
      z-index:50; overflow-x:hidden; overflow-y:auto; transition:width .25s ease;
    }
    .content-area{ margin-left:var(--sb-expanded); transition:margin-left .25s ease; position:relative; z-index:40; }

    .body--sb-collapsed .sidebar{ width:var(--sb-collapsed); }
    .body--sb-collapsed .content-area{ margin-left:var(--sb-collapsed); }
    .body--sb-collapsed .logo-text,
    .body--sb-collapsed .user-info,
    .body--sb-collapsed .nav-text{ display:none; }

    .nav-item{ display:flex; align-items:center; gap:.75rem; padding:.75rem; border-radius:.5rem; }

    @media (max-width:768px){
      .sidebar{ transform:translateX(-100%); }
      .sidebar.sidebar-mobile{ transform:translateX(0); }
      .content-area{ margin-left:0 !important; }
    }

    /* Botón tema animado */
    .nav-toggle{ position:relative; }
    .nav-toggle .icon-sun,.nav-toggle .icon-moon{
      position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
      transition:opacity .25s ease, transform .25s ease;
    }
    .nav-toggle .icon-moon{ opacity:0; transform:scale(.5) rotate(-90deg); }
    html.dark .nav-toggle .icon-sun{ opacity:0; transform:scale(.5) rotate(90deg); }
    html.dark .nav-toggle .icon-moon{ opacity:1; transform:scale(1) rotate(0deg); }
  </style>
</head>

<body class="bg-neutral-50 dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 min-h-screen">
  <div class="flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-white dark:bg-neutral-800 shadow-lg">
      <div class="p-4 flex items-center gap-3">
        <div class="bg-primary-500 p-2 rounded-lg"><i data-feather="book" class="text-white"></i></div>
        <span class="logo-text text-xl font-bold text-primary-700 dark:text-primary-300">UTEC</span>
      </div>

      <div class="px-4 pb-4 border-b border-neutral-200 dark:border-neutral-700">
        <div class="user-info flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
            <i data-feather="user" class="text-primary-700 dark:text-primary-300"></i>
          </div>
          <div>
            <p class="font-medium leading-tight"><?= htmlspecialchars($user['name'] ?? 'Profesor') ?></p>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 leading-tight"><?= htmlspecialchars($user['email'] ?? 'profesor@utec.edu') ?></p>
          </div>
        </div>
      </div>

      <nav class="p-4">
        <ul class="space-y-2">
          <li>
            <a href="/src/plataforma/app/maestro"
               class="nav-item <?php echo ($_SERVER['REQUEST_URI'] === '/src/plataforma/app/maestro')
                ? 'bg-primary-50 dark:bg-neutral-700/60 text-primary-700 dark:text-primary-300'
                : 'hover:bg-neutral-100 dark:hover:bg-neutral-700'; ?>">
              <i data-feather="home"></i><span class="nav-text">Panel</span>
            </a>
          </li>
          <li><a href="/src/plataforma/app/maestro/clases" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700"><i data-feather="book-open"></i><span class="nav-text">Mis Clases</span></a></li>
          <li><a href="/src/plataforma/app/maestro/horario" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700"><i data-feather="calendar"></i><span class="nav-text">Horario</span></a></li>
          <li><a href="/src/plataforma/app/maestro/calificar" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700"><i data-feather="edit"></i><span class="nav-text">Calificar</span></a></li>
          <li><a href="/src/plataforma/app/maestro/estudiantes" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700"><i data-feather="users"></i><span class="nav-text">Estudiantes</span></a></li>
          <li><a href="/src/plataforma/app/maestro/asistencia" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700"><i data-feather="clipboard"></i><span class="nav-text">Asistencia</span></a></li>
          <li><a href="/src/plataforma/app/anuncios" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700"><i data-feather="bell"></i><span class="nav-text">Anuncios</span></a></li>
        </ul>
      </nav>

      <div class="p-4 border-t border-neutral-200 dark:border-neutral-700 mt-auto">
        <a href="/src/plataforma/logout" class="nav-item hover:bg-neutral-100 dark:hover:bg-neutral-700 w-full">
          <i data-feather="log-out"></i><span class="nav-text">Cerrar sesión</span>
        </a>
      </div>
    </aside>

    <!-- Topbar + Contenido -->
    <div id="content" class="content-area flex-1 min-h-screen">
      <header class="bg-white dark:bg-neutral-800 shadow-sm sticky top-0 z-40">
        <div class="flex items-center justify-between p-4">
          <div class="flex items-center gap-4">
            <button id="sidebar-toggle" class="text-neutral-500 dark:text-neutral-400" aria-label="Alternar menú">
              <i data-feather="menu"></i>
            </button>
            <h1 class="text-xl font-bold"><?= htmlspecialchars($title) ?></h1>
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

            <a href="/src/plataforma/app/anuncios" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700 relative" aria-label="Notificaciones">
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
        <?= $content /* <- aquí entra la vista hija */ ?>
      </main>

      <footer class="p-6 border-t border-neutral-200 dark:border-neutral-700 mt-6">
        <p class="text-center text-sm text-neutral-500 dark:text-neutral-400">© <?= date('Y') ?> UTEC · Panel del Maestro</p>
      </footer>
    </div>
  </div>

  <script>
    AOS.init(); feather.replace();

    const sidebar = document.getElementById('sidebar');
    const toggle  = document.getElementById('sidebar-toggle');

    // Toggle: desktop (clase en <body>) y móvil (drawer)
    toggle?.addEventListener('click', ()=>{
      const isMobile = window.matchMedia('(max-width: 768px)').matches;
      if(isMobile){
        sidebar.classList.toggle('sidebar-mobile');
      }else{
        document.body.classList.toggle('body--sb-collapsed');
        localStorage.setItem('sbCollapsed', document.body.classList.contains('body--sb-collapsed') ? '1' : '0');
      }
    });

    // Restaurar estado de colapso en desktop
    (function(){
      const saved = localStorage.getItem('sbCollapsed') === '1';
      const isMobile = window.matchMedia('(max-width: 768px)').matches;
      if(!isMobile && saved) document.body.classList.add('body--sb-collapsed');
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
