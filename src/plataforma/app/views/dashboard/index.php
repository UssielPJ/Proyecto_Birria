<?php
// Opcional: si ya tienes sesión y usuario:
$userName  = $_SESSION['user']['name']  ?? 'Estudiante';
$userEmail = $_SESSION['user']['email'] ?? 'usuario@UTSC.edu';
$role      = $_SESSION['user']['role']  ?? 'alumno'; // 'alumno' | 'maestro' | 'admin'
?>
<!DOCTYPE html>
<html lang="es" class="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UTSC · Panel</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- Tailwind config: paleta verde -->
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: { /* emerald */
              50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',400:'#34d399',
              500:'#10b981',600:'#059669',700:'#047857',800:'#065f46',900:'#064e3b'
            },
            neutral: { /* slate */
              50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',
              500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a'
            }
          }
        }
      }
    }
  </script>

  <style>
    .sidebar { transition:all .25s ease; }
    .sidebar-collapsed { width:5rem; }
    .sidebar-collapsed .nav-text,
    .sidebar-collapsed .logo-text,
    .sidebar-collapsed .user-info { display:none; }
    .sidebar-collapsed .nav-item { justify-content:center; }

    .content-area { transition:all .25s ease; }
    .content-expanded { margin-left:16rem; }
    .content-collapsed { margin-left:5rem; }

    @media (max-width: 768px){
      .sidebar { position:fixed; z-index:50; transform:translateX(-100%); }
      .sidebar-mobile { transform:translateX(0); }
      .content-area { margin-left:0 !important; }
    }

    /* Botón tema (sol/luna) animado */
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
    <aside id="sidebar" class="sidebar bg-white dark:bg-neutral-800 shadow-lg h-screen fixed top-0 left-0 w-64 overflow-y-auto">
      <div class="p-4 flex items-center space-x-3">
        <img src="/src/plataforma/app/img/UT.jpg" alt="UTSC Logo" class="h-10 w-auto rounded">
        <span class="logo-text text-xl font-bold text-primary-700 dark:text-primary-300">UTSC</span>
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

      <nav class="p-4">
        <ul class="space-y-2">
          <li>
            <a href="/src/plataforma/app" class="nav-item flex items-center space-x-3 p-3 rounded-lg bg-primary-50 dark:bg-neutral-700/60 text-primary-700 dark:text-primary-300">
              <i data-feather="home"></i><span class="nav-text">Panel</span>
            </a>
          </li>
          <li>
            <a href="/src/plataforma/app/materias" class="nav-item flex items-center space-x-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-700">
              <i data-feather="book-open"></i><span class="nav-text">Materias</span>
            </a>
          </li>
          <li>
            <a href="/src/plataforma/app/horario" class="nav-item flex items-center space-x-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-700">
              <i data-feather="calendar"></i><span class="nav-text">Horario</span>
            </a>
          </li>
          <li>
            <a href="/src/plataforma/app/calificaciones" class="nav-item flex items-center space-x-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-700">
              <i data-feather="award"></i><span class="nav-text">Calificaciones</span>
            </a>
          </li>
          <li>
            <a href="/src/plataforma/app/encuestas" class="nav-item flex items-center space-x-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-700">
              <i data-feather="clipboard"></i><span class="nav-text">Encuestas</span>
            </a>
          </li>
          <li>
            <a href="/src/plataforma/app/becas" class="nav-item flex items-center space-x-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-700">
              <i data-feather="dollar-sign"></i><span class="nav-text">Becas</span>
            </a>
          </li>
          <li>
            <a href="/src/plataforma/app/anuncios" class="nav-item flex items-center space-x-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-700">
              <i data-feather="bell"></i><span class="nav-text">Anuncios</span>
            </a>
          </li>

          <?php if ($role === 'admin'): ?>
          <li>
            <a href="/src/plataforma/app/admin" class="nav-item flex items-center space-x-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-700">
              <i data-feather="settings"></i><span class="nav-text">Admin</span>
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </nav>

      <div class="p-4 border-t border-neutral-200 dark:border-neutral-700 mt-auto">
        <a href="/src/plataforma/logout" class="nav-item flex items-center space-x-3 p-3 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-700 w-full">
          <i data-feather="log-out"></i><span class="nav-text">Cerrar sesión</span>
        </a>
      </div>
    </aside>

    <!-- Contenido -->
    <div id="content" class="content-area flex-1 content-expanded min-h-screen">
      <!-- Topbar -->
      <header class="bg-white dark:bg-neutral-800 shadow-sm sticky top-0 z-40">
        <div class="flex items-center justify-between p-4">
          <div class="flex items-center gap-4">
            <button id="sidebar-toggle" class="text-neutral-500 dark:text-neutral-400">
              <i data-feather="menu"></i>
            </button>
            <h1 class="text-xl font-bold">Panel Principal</h1>
          </div>

          <div class="flex items-center gap-3">
            <!-- Toggle tema -->
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

            <a href="/src/plataforma/app/anuncios" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700 relative">
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
        <!-- Bienvenida -->
        <div class="bg-gradient-to-r from-primary-500 via-emerald-500 to-teal-500 rounded-xl p-6 text-white mb-6 shadow-2xl relative overflow-hidden" data-aos="fade-up">
          <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-pulse"></div>
          <div class="relative">
            <h2 class="text-2xl font-bold mb-1 animate-fade-in">¡Bienvenido de nuevo, <?= htmlspecialchars($userName) ?>!</h2>
            <p class="opacity-90 animate-fade-in animation-delay-200">Revisa tus materias, horario y calificaciones en un solo lugar.</p>
          </div>
          <div class="absolute top-4 right-4 opacity-20">
            <i data-feather="book-open" class="w-16 h-16 animate-spin-slow"></i>
          </div>
        </div>

        <!-- Tarjetas KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
          <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 border-l-4 border-primary-500 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-tooltip="Ver todas tus materias">
            <div class="absolute inset-0 bg-gradient-to-r from-primary-400/20 to-emerald-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-sm">Materias inscritas</p>
                <h3 class="text-2xl font-bold mt-1 counter" data-target="5">0</h3>
              </div>
              <div class="p-3 rounded-lg bg-primary-50 dark:bg-neutral-700 group-hover:bg-primary-100 group-hover:rotate-12 transition-all duration-300">
                <i data-feather="book" class="text-primary-600"></i>
              </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-primary-400 to-emerald-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
          </div>

          <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 border-l-4 border-emerald-500 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="50" data-tooltip="Ver tu rendimiento académico">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-400/20 to-teal-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-sm">Promedio actual</p>
                <h3 class="text-2xl font-bold mt-1 counter" data-target="87">0</h3>
              </div>
              <div class="p-3 rounded-lg bg-emerald-50 dark:bg-neutral-700 group-hover:bg-emerald-100 group-hover:rotate-12 transition-all duration-300">
                <i data-feather="award" class="text-emerald-600"></i>
              </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
          </div>

          <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 border-l-4 border-amber-500 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="100" data-tooltip="Gestionar tus tareas">
            <div class="absolute inset-0 bg-gradient-to-r from-amber-400/20 to-orange-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-sm">Tareas pendientes</p>
                <h3 class="text-2xl font-bold mt-1 counter" data-target="3">0</h3>
              </div>
              <div class="p-3 rounded-lg bg-amber-50 dark:bg-neutral-700 group-hover:bg-amber-100 group-hover:rotate-12 transition-all duration-300">
                <i data-feather="clipboard" class="text-amber-600"></i>
              </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-orange-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
          </div>

          <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="150" data-tooltip="Ver tu horario de clases">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-400/20 to-indigo-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between">
              <div>
                <p class="text-neutral-500 dark:text-neutral-400 text-sm">Próxima clase</p>
                <h3 class="text-2xl font-bold mt-1">10:00 AM</h3>
              </div>
              <div class="p-3 rounded-lg bg-purple-50 dark:bg-neutral-700 group-hover:bg-purple-100 group-hover:rotate-12 transition-all duration-300">
                <i data-feather="clock" class="text-purple-600"></i>
              </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-purple-400 to-indigo-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
          </div>
        </div>

        <!-- Anuncios -->
        <section class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 mb-6" data-aos="fade-up">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Anuncios recientes</h2>
            <a href="/src/plataforma/app/anuncios" class="text-primary-700 dark:text-primary-300 text-sm">Ver todos</a>
          </div>

          <div class="space-y-4">
            <div class="p-4 border border-neutral-100 dark:border-neutral-700 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-700 transition">
              <div class="flex items-start gap-3">
                <div class="p-2 rounded-lg bg-primary-50 dark:bg-neutral-700">
                  <i data-feather="info" class="text-primary-600"></i>
                </div>
                <div>
                  <h3 class="font-medium">Cambio de aula - Matemáticas</h3>
                  <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">La clase del viernes se impartirá en el aula 304 en lugar de la 201.</p>
                  <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-2">Hace 2 horas</p>
                </div>
              </div>
            </div>

            <div class="p-4 border border-neutral-100 dark:border-neutral-700 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-700 transition">
              <div class="flex items-start gap-3">
                <div class="p-2 rounded-lg bg-emerald-50 dark:bg-neutral-700">
                  <i data-feather="calendar" class="text-emerald-600"></i>
                </div>
                <div>
                  <h3 class="font-medium">Fechas de exámenes finales</h3>
                  <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1">Ya puedes revisar las fechas de exámenes en Horario.</p>
                  <p class="text-xs text-neutral-400 dark:text-neutral-500 mt-2">Ayer, 15:30</p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Próximas clases & Tareas -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <section class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6" data-aos="fade-up">
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-xl font-bold">Próximas clases</h2>
              <a href="/src/plataforma/app/horario" class="text-primary-700 dark:text-primary-300 text-sm">Ver horario</a>
            </div>

            <div class="space-y-4">
              <div class="flex items-center justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
                <div class="flex items-center gap-3">
                  <div class="p-2 rounded-lg bg-rose-50 dark:bg-neutral-700">
                    <i data-feather="book" class="text-rose-600"></i>
                  </div>
                  <div>
                    <h3 class="font-medium">Física Cuántica</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Aula 205 — 10:00–12:00</p>
                  </div>
                </div>
                <a href="/src/plataforma/app/horario" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700">
                  <i data-feather="chevron-right" class="text-neutral-400"></i>
                </a>
              </div>

              <div class="flex items-center justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
                <div class="flex items-center gap-3">
                  <div class="p-2 rounded-lg bg-purple-50 dark:bg-neutral-700">
                    <i data-feather="book" class="text-purple-600"></i>
                  </div>
                  <div>
                    <h3 class="font-medium">Álgebra Lineal</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Aula 301 — 14:00–16:00</p>
                  </div>
                </div>
                <a href="/src/plataforma/app/horario" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700">
                  <i data-feather="chevron-right" class="text-neutral-400"></i>
                </a>
              </div>
            </div>
          </section>

          <section class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6" data-aos="fade-up">
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-xl font-bold">Tareas pendientes</h2>
              <a href="/src/plataforma/app/materias" class="text-primary-700 dark:text-primary-300 text-sm">Ver todas</a>
            </div>

            <div class="space-y-4">
              <div class="flex items-start justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
                <div class="flex items-start gap-3">
                  <div class="p-2 rounded-lg bg-amber-50 dark:bg-neutral-700 mt-1">
                    <i data-feather="clipboard" class="text-amber-600"></i>
                  </div>
                  <div>
                    <h3 class="font-medium">Proyecto final — Historia</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Entrega: Viernes 15 de marzo</p>
                    <div class="flex items-center gap-2 mt-2">
                      <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-1.5">
                        <div class="bg-amber-500 h-1.5 rounded-full" style="width:60%"></div>
                      </div>
                      <span class="text-xs text-neutral-500 dark:text-neutral-400">60%</span>
                    </div>
                  </div>
                </div>
                <a href="/src/plataforma/app/materias" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700">
                  <i data-feather="chevron-right" class="text-neutral-400"></i>
                </a>
              </div>

              <div class="flex items-start justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
                <div class="flex items-start gap-3">
                  <div class="p-2 rounded-lg bg-primary-50 dark:bg-neutral-700 mt-1">
                    <i data-feather="clipboard" class="text-primary-600"></i>
                  </div>
                  <div>
                    <h3 class="font-medium">Ensayo literario</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Entrega: Lunes 18 de marzo</p>
                    <div class="flex items-center gap-2 mt-2">
                      <div class="w-full bg-neutral-200 dark:bg-neutral-700 rounded-full h-1.5">
                        <div class="bg-primary-500 h-1.5 rounded-full" style="width:30%"></div>
                      </div>
                      <span class="text-xs text-neutral-500 dark:text-neutral-400">30%</span>
                    </div>
                  </div>
                </div>
                <a href="/src/plataforma/app/materias" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700">
                  <i data-feather="chevron-right" class="text-neutral-400"></i>
                </a>
              </div>
            </div>
          </section>
        </div>
      </main>

      <footer class="p-6 border-t border-neutral-200 dark:border-neutral-700 mt-6">
        <p class="text-center text-sm text-neutral-500 dark:text-neutral-400">© <?= date('Y') ?> UTSC · Plataforma Estudiantil</p>
      </footer>
    </div>
  </div>

  <script>
    AOS.init();
    feather.replace();

    // Counter animation
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    // Special handling for grades (divide by 10)
                    if (counter.nextElementSibling && counter.nextElementSibling.textContent.includes('Promedio')) {
                        counter.textContent = (target / 10).toFixed(1);
                    } else {
                        counter.textContent = target;
                    }
                    clearInterval(timer);
                } else {
                    if (counter.nextElementSibling && counter.nextElementSibling.textContent.includes('Promedio')) {
                        counter.textContent = (current / 10).toFixed(1);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }
            }, 16);
        });
    }

    // Tooltip functionality
    function initTooltips() {
        const cards = document.querySelectorAll('[data-tooltip]');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function(e) {
                const tooltip = document.createElement('div');
                tooltip.className = 'absolute bg-gray-800 text-white text-xs px-2 py-1 rounded shadow-lg z-50 pointer-events-none';
                tooltip.textContent = this.getAttribute('data-tooltip');
                tooltip.style.top = e.clientY - 30 + 'px';
                tooltip.style.left = e.clientX + 10 + 'px';
                document.body.appendChild(tooltip);

                this.addEventListener('mousemove', function(e) {
                    tooltip.style.top = e.clientY - 30 + 'px';
                    tooltip.style.left = e.clientX + 10 + 'px';
                });

                this.addEventListener('mouseleave', function() {
                    tooltip.remove();
                });
            });
        });
    }

    // Enhanced hover effects with emerald glow
    document.querySelectorAll('.grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-4 > div').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.05)';
            this.style.boxShadow = '0 25px 50px rgba(0,0,0,0.15), 0 0 30px rgba(16, 185, 129, 0.4)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '';
        });
    });

    // Sidebar
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    let isCollapsed = false;

    sidebarToggle.addEventListener('click', ()=>{
      // Desktop colapsable
      isCollapsed = !isCollapsed;
      if(isCollapsed){
        sidebar.classList.add('sidebar-collapsed');
        content.classList.remove('content-expanded');
        content.classList.add('content-collapsed');
      }else{
        sidebar.classList.remove('sidebar-collapsed');
        content.classList.remove('content-collapsed');
        content.classList.add('content-expanded');
      }
      // Mobile drawer
      sidebar.classList.toggle('sidebar-mobile');
    });

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

    // Add custom animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-fade-in {
            animation: fade-in 0.8s ease-out forwards;
        }
        .animation-delay-200 {
            animation-delay: 0.2s;
        }
        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }
    `;
    document.head.appendChild(style);

    // Initialize on load
    window.addEventListener('load', function() {
        animateCounters();
        initTooltips();
    });
  </script>
</body>
</html>
