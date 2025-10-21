<?php
// Guard de acceso
if (session_status() === PHP_SESSION_NONE) session_start();
if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
  header('Location: /src/plataforma/'); exit;
}
$U = $_SESSION['user'] ?? [];
?>
<!DOCTYPE html>
<html lang="es" class="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UTSC · Panel Capturista</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="/src/plataforma/app/js/theme.js" defer></script>

  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: {
              50:'#faf5ff',100:'#f3e8ff',200:'#e9d5ff',300:'#d8b4fe',400:'#c084fc',
              500:'#a855f7',600:'#9333ea',700:'#7c3aed',800:'#6b21a8',900:'#581c87'
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
      background: linear-gradient(90deg, transparent, rgba(168, 85, 247, 0.1), transparent);
      transition: left 0.5s ease;
    }

    .nav-item:hover::before {
      left: 100%;
    }

    .nav-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(168, 85, 247, 0.15);
      background: linear-gradient(135deg, rgba(243, 232, 255, 0.8), rgba(233, 213, 255, 0.8));
      color: #7c3aed;
    }

    .nav-item.active {
      background: linear-gradient(135deg, #e9d5ff, #d8b4fe);
      color: #581c87;
      box-shadow: 0 4px 15px rgba(168, 85, 247, 0.3);
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
      background: #7c3aed;
      border-radius: 0 2px 2px 0;
    }

    .dark .nav-item {
      color: #a0aec0;
    }

    .dark .nav-item:hover {
      background: linear-gradient(135deg, rgba(168, 85, 247, 0.1), rgba(147, 51, 234, 0.1));
      box-shadow: 0 10px 25px rgba(168, 85, 247, 0.2);
      color: #c084fc;
    }

    .dark .nav-item.active {
      background: linear-gradient(135deg, rgba(168, 85, 247, 0.2), rgba(196, 181, 253, 0.1));
      color: #c084fc;
      box-shadow: 0 4px 15px rgba(168, 85, 247, 0.4);
    }

    .dark .nav-item.active::after {
      background: #c084fc;
    }

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
        <div class="flex items-center gap-2">
          <img src="/src/plataforma/app/img/UT.jpg" alt="UTSC Logo" class="h-10 w-auto rounded">
          <span class="logo-text text-xl font-bold text-primary-700 dark:text-primary-300">Captura UTSC</span>
        </div>
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
        <?= $content ?? '' ?>
      </main>

      <footer class="p-6 border-t border-neutral-200 dark:border-neutral-700 mt-6">
        <p class="text-center text-sm text-neutral-500 dark:text-neutral-400">© <?= date('Y') ?> UTSC · Panel Capturista</p>
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

  </script>
</body>
</html>
