<?php
// Guard de acceso
if (session_status() === PHP_SESSION_NONE) session_start();
if (!in_array('admin', $_SESSION['roles'] ?? [], true)) {
  header('Location: /src/plataforma/'); exit;
}
$user = $_SESSION['user'] ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UTEC · Panel Administrativo</title>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="/src/plataforma/app/js/theme.js" defer></script>
  <script src="/src/plataforma/app/js/notifications.js" defer></script>

  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: {50:'#fff7ed',100:'#ffedd5',200:'#fed7aa',300:'#fdba74',400:'#fb923c',500:'#f97316',600:'#ea580c',700:'#c2410c',800:'#9a3412',900:'#7c2d12'},
            neutral: {50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a'}
          }
        }
      }
    }
  </script>

  <style>
    .nav-toggle{ position:relative; }
    .nav-toggle .icon-sun,.nav-toggle .icon-moon{
      position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
      transition:opacity .25s ease, transform .25s ease;
    }
    .nav-toggle .icon-moon{ opacity:0; transform:scale(.5) rotate(-90deg); }
    html.dark .nav-toggle .icon-sun{ opacity:0; transform:scale(.5) rotate(90deg); }
    html.dark .nav-toggle .icon-moon{ opacity:1; transform:scale(1) rotate(0deg); }
    
    .nav-item {
      display: flex;
      align-items: center;
      padding: 0.75rem 1rem;
      border-radius: 0.75rem;
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
      background: linear-gradient(90deg, transparent, rgba(249, 115, 22, 0.1), transparent);
      transition: left 0.5s ease;
    }

    .nav-item:hover::before {
      left: 100%;
    }

    .nav-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(249, 115, 22, 0.15);
    }

    .nav-item.active {
      background: linear-gradient(135deg, #fed7aa, #fdba74);
      color: #c2410c;
      box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
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
      background: #ea580c;
      border-radius: 0 2px 2px 0;
    }

    .dark .nav-item {
      color: #a0aec0;
    }

    .dark .nav-item:hover {
      box-shadow: 0 10px 25px rgba(249, 115, 22, 0.2);
    }

    .dark .nav-item.active {
      background: linear-gradient(135deg, rgba(249, 115, 22, 0.2), rgba(251, 146, 60, 0.1));
      color: #fb923c;
      box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
    }

    .dark .nav-item.active::after {
      background: #fb923c;
    }
  </style>
</head>

<body class="bg-neutral-50 dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 min-h-screen">
  <div class="flex">
    <!-- Sidenav -->
    <aside class="w-64 shrink-0 p-4 space-y-1 bg-white dark:bg-neutral-800">
      <div class="flex items-center mb-4">
        <img src="/src/plataforma/app/img/UT.jpg" alt="UTEC Logo" class="h-10 mr-3 rounded">
        <span class="text-xl font-bold text-neutral-800 dark:text-white">UTEC</span>
      </div>
      <!-- User Info -->
      <div class="flex items-center mb-6">
        <div class="w-12 h-12 rounded-full bg-orange-200 dark:bg-orange-900 flex items-center justify-center mr-3">
          <i class="fas fa-user text-2xl text-orange-600 dark:text-orange-400"></i>
        </div>
        <div>
          <p class="font-bold text-neutral-800 dark:text-white"><?= htmlspecialchars($user['name'] ?? 'Administrador') ?></p>
          <p class="text-sm text-gray-500 dark:text-neutral-400"><?= htmlspecialchars($user['email'] ?? 'admin@utec.edu') ?></p>
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
            <button id="sidebar-toggle" class="text-neutral-500 dark:text-neutral-400">
              <i data-feather="menu"></i>
            </button>
            <h1 class="text-xl font-bold">Panel Administrativo</h1>
          </div>

          <div class="flex items-center gap-3">
            <button id="theme-toggle" class="nav-toggle h-9 w-9 rounded-xl ring-1 ring-black/10 dark:ring-white/10 hover:ring-black/20 dark:hover:ring-white/20 bg-white/80 dark:bg-neutral-700/60">
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

            <a href="#" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700 relative">
              <i data-feather="bell"></i>
              <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </a>

            <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
              <i data-feather="user" class="text-primary-700 dark:text-primary-300"></i>
            </div>

            <a href="/src/plataforma/logout" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700 text-neutral-600 dark:text-neutral-400 hover:text-red-500 dark:hover:text-red-400 transition-colors" title="Cerrar Sesión">
              <i data-feather="log-out"></i>
            </a>
          </div>
        </div>
      </header>

      <main class="p-6">
        <?= $content ?? '' ?>
      </main>

      <footer class="p-6 border-t border-neutral-200 dark:border-neutral-700 mt-6">
        <p class="text-center text-sm text-neutral-500 dark:text-neutral-400">© 2023 UTEC · Panel Administrativo</p>
      </footer>
    </div>
  </div>

  <script>
    AOS.init(); feather.replace();

    // Sidenav functionality
    const menuItems = document.querySelectorAll('.menu-item');
    
    menuItems.forEach(item => {
      item.addEventListener('click', function() {
        // Remove active class from all items
        menuItems.forEach(i => i.classList.remove('active'));
        // Add active class to clicked item
        this.classList.add('active');
      });
    });

  </script>
</body>
</html>
