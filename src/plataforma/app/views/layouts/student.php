<?php
// Verificar sesión y obtener datos de usuario
$userName  = $_SESSION['user']['name']  ?? '';
$userEmail = $_SESSION['user']['email'] ?? '';
$role      = $_SESSION['user']['role']  ?? 'alumno';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UTSC · Plataforma Estudiantil</title>
  <!-- Prevenir flash de tema incorrecto -->
  <script>
    (function() {
      const savedTheme = localStorage.getItem('theme');
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        document.documentElement.classList.add('dark');
      }
    })();
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="/src/plataforma/assets/css/notifications.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="/src/plataforma/app/js/theme.js" defer></script>
  <script src="/src/plataforma/app/js/notifications.js" defer></script>

  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: {50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b'},
            neutral: {50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a'}
          }
        }
      }
    }
  </script>

  <style>
    /* ====== FIX de colapso consistente ====== */
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

    .nav-item {
      display: flex;
      align-items: center;
      gap: .75rem;
      padding: .75rem;
      border-radius: .5rem;
      font-weight: 500;
      color: #4a5568;
      transition: all 0.3s ease-in-out;
      position: relative;
      overflow: hidden;
    }

    .nav-item::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.1), transparent);
      transition: left 0.5s ease;
    }

    .nav-item:hover::before {
      left: 100%;
    }

    .nav-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(16, 185, 129, 0.15);
      background: linear-gradient(135deg, rgba(209, 250, 229, 0.8), rgba(167, 243, 208, 0.8));
      color: #047857;
    }

    .nav-item.active {
      background: linear-gradient(135deg, #a7f3d0, #6ee7b7);
      color: #064e3b;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
      transform: translateY(-1px);
    }

    .nav-item.active::after {
      content: '';
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 60%;
      background: #047857;
      border-radius: 0 2px 2px 0;
    }

    .dark .nav-item {
      color: #a0aec0;
    }

    .dark .nav-item:hover {
      background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
      box-shadow: 0 10px 25px rgba(16, 185, 129, 0.2);
      color: #34d399;
    }

    .dark .nav-item.active {
      background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(52, 211, 153, 0.1));
      color: #34d399;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .dark .nav-item.active::after {
      background: #34d399;
    }

    .body--sb-collapsed .nav-item{ justify-content:center; gap:0; }

    @media (max-width:768px){
      .sidebar{ transform:translateX(-100%); }
      .sidebar.sidebar-mobile{ transform:translateX(0); }
      .content-area{ margin-left:0 !important; }
    }

    /* Botón tema (sol/luna) animado */
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
      <div class="p-4 flex items-center space-x-3">
        <div class="flex items-center gap-2">
          <img src="/src/plataforma/app/img/UT.jpg" alt="UTSC Logo" class="h-10 w-auto rounded">
          <span class="logo-text text-xl font-bold text-primary-700 dark:text-primary-300">UTSC</span>
        </div>
      </div>

      <div class="px-4 pb-4 border-b border-neutral-200 dark:border-neutral-700">
        <div class="user-info flex items-center space-x-3">
          <div class="w-10 h-10 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
            <i data-feather="user" class="text-primary-700 dark:text-primary-300"></i>
          </div>
          <div>
            <p class="font-medium leading-tight"><?= htmlspecialchars($userName) ?></p>
            <p class="text-sm text-neutral-500 dark:text-neutral-400 leading-tight"><?= htmlspecialchars($userEmail) ?></p>
          </div>
        </div>
      </div>

      <?php include __DIR__ . '/../partials/navbar.php'; ?>

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
            <h1 class="text-xl font-bold">Panel Principal</h1>
          </div>

          <div class="flex items-center gap-3">
            <!-- Toggle tema -->
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
        <?= $content ?? '' ?>
      </main>

      <footer class="p-6 border-t border-neutral-200 dark:border-neutral-700 mt-6">
        <p class="text-center text-sm text-neutral-500 dark:text-neutral-400">© <?= date('Y') ?> UTSC · Plataforma Estudiantil</p>
      </footer>
    </div>
  </div>

  <script>
    AOS.init(); feather.replace();

    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');

    // Colapso desktop (clase en body) y drawer mobile
    sidebarToggle.addEventListener('click', () => {
      const isMobile = window.matchMedia('(max-width: 768px)').matches;
      if (isMobile) {
        sidebar.classList.toggle('sidebar-mobile');
      } else {
        document.body.classList.toggle('body--sb-collapsed');
        localStorage.setItem('sbCollapsed', document.body.classList.contains('body--sb-collapsed') ? '1' : '0');
      }
    });

    // Restaurar estado en desktop
    (function(){
      const saved = localStorage.getItem('sbCollapsed') === '1';
      const isMobile = window.matchMedia('(max-width: 768px)').matches;
      if (!isMobile && saved) document.body.classList.add('body--sb-collapsed');
    })();

    // El gestor de tema ya está cargado en el head
  </script>
</body>
</html>
