<?php
  $PLATAFORMA_URL = "/src/plataforma/";
  
  // Detectar la página actual de forma más robusta
  $current_page = basename($_SERVER['PHP_SELF']);
  if ($current_page === 'index.php' || empty($current_page)) {
    $current_page = 'index.php';
  }
  
  // Determinar la clave activa
  $active_key = '';
  if ($current_page == 'index.php') {
    $active_key = 'inicio';
  } else {
    $active_key = str_replace('.php', '', $current_page);
  }
  
  // Definir los elementos del menú con sus rutas y nombres
  $menu_items = [
    'inicio' => ['url' => '/src/', 'name' => 'Inicio', 'icon' => 'home'],
    'cursos' => ['url' => '/src/cursos.php', 'name' => 'Carreras', 'icon' => 'book'],
    'docentes' => ['url' => '/src/docentes.php', 'name' => 'Docentes', 'icon' => 'users'],
    'recursos' => ['url' => '/src/recursos.php', 'name' => 'Recursos', 'icon' => 'folder'],
    'nosotros' => ['url' => '/src/nosotros.php', 'name' => 'Nosotros', 'icon' => 'info']
  ];
?>

<nav class="fixed top-0 inset-x-0 z-50 transition-all duration-300" id="mainNav">
  <div class="nav-shell mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="h-16 flex items-center justify-between">
      <!-- Brand -->
      <a href="/src/" class="flex items-center gap-3 group transition-all duration-300 nav-brand">
        <div class="relative h-10 w-10">
          <img src="/src/plataforma/app/img/UT.jpg" alt="UTSC" 
               class="h-full w-full rounded-lg object-cover ring-2 ring-white/20 group-hover:ring-primary-500 transition-all duration-300 transform group-hover:scale-105" 
               onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
          <div class="absolute inset-0 bg-gradient-to-br from-primary-500/20 to-secondary-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300 hidden" style="display: none;">
            <i data-feather="award" class="w-full h-full text-primary-500"></i>
          </div>
        </div>
        <div class="flex flex-col">
          <span class="text-lg font-bold tracking-wide nav-title bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-secondary-600">UTSC</span>
          <span class="text-xs text-neutral-500 dark:text-neutral-400">Universidad Tecnológica Santa Catarina</span>
        </div>
      </a>

      <!-- Desktop menu -->
      <div class="hidden lg:flex items-center gap-8">
        <?php foreach($menu_items as $key => $item): 
          $is_active = ($key === $active_key);
          $href_basename = basename($item['url'], '.php');
        ?>
          <a href="<?php echo htmlspecialchars($item['url']); ?>" 
             data-key="<?php echo htmlspecialchars($key); ?>"
             class="nav-link group flex items-center gap-2 py-2 px-3 rounded-lg transition-all duration-300 
                    <?php echo $is_active ? 'active text-primary-600 bg-primary-50 dark:bg-primary-900/20 dark:text-primary-400' : 'hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 dark:hover:text-primary-400'; ?>"
             aria-label="<?php echo htmlspecialchars($item['name']); ?>"
             data-href-key="<?php echo htmlspecialchars($href_basename); ?>">
            <i data-feather="<?php echo htmlspecialchars($item['icon']); ?>" class="w-4 h-4 transition-transform duration-300 group-hover:scale-110"></i>
            <span><?php echo htmlspecialchars($item['name']); ?></span>
          </a>
        <?php endforeach; ?>
      </div>

      <!-- Actions -->
      <div class="hidden lg:flex items-center gap-4">
        <!-- Theme toggle -->
        <button id="themeToggle"
                class="theme-toggle h-10 w-10 rounded-xl flex items-center justify-center ring-1 ring-black/10 dark:ring-white/10 hover:ring-primary-500 transition-all duration-300 bg-white/70 dark:bg-neutral-800/70 backdrop-blur transform hover:scale-105"
                aria-label="Cambiar tema"
                title="Cambiar entre modo claro y oscuro">
          <span class="icon-sun pointer-events-none transition-all duration-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <circle cx="12" cy="12" r="4"></circle>
              <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
            </svg>
          </span>
          <span class="icon-moon pointer-events-none transition-all duration-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
              <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z"/>
            </svg>
          </span>
        </button>

        <!-- Notificaciones -->
        <div class="relative">
          <button id="notificationToggle"
                  class="notification-toggle relative h-10 w-10 rounded-xl flex items-center justify-center ring-1 ring-black/10 dark:ring-white/10 hover:ring-primary-500 transition-all duration-300 bg-white/70 dark:bg-neutral-800/70 backdrop-blur transform hover:scale-105"
                  aria-label="Ver notificaciones"
                  title="Notificaciones">
            <i data-feather="bell" class="h-5 w-5 text-gray-600 dark:text-gray-300"></i>
            <span id="notification-badge" class="notification-badge absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full" style="display: none;">0</span>
          </button>

          <!-- Dropdown de notificaciones -->
          <div id="notificationDropdown" class="notification-dropdown absolute right-0 mt-2 w-80 bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gray-200 dark:border-neutral-700 z-50 transform scale-95 opacity-0 transition-all duration-200 pointer-events-none">
            <div class="p-4 border-b border-gray-200 dark:border-neutral-700">
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notificaciones</h3>
              <p class="text-sm text-gray-500 dark:text-gray-400">Tus últimas actualizaciones</p>
            </div>
            <div class="max-h-64 overflow-y-auto">
              <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                <i data-feather="bell-off" class="w-8 h-8 mx-auto mb-2"></i>
                <p>No hay notificaciones nuevas</p>
                <p class="text-xs mt-1">Te notificaremos cuando haya actualizaciones importantes.</p>
              </div>
            </div>
            <div class="p-3 border-t border-gray-200 dark:border-neutral-700">
              <a href="#" class="text-primary-600 dark:text-primary-400 text-sm font-medium hover:underline">Ver todas las notificaciones</a>
            </div>
          </div>
        </div>

        <!-- Plataforma -->
        <a href="<?php echo htmlspecialchars($PLATAFORMA_URL); ?>"
           class="group relative inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-500 dark:to-emerald-500 px-6 py-2.5 font-semibold text-white transition-all duration-300 hover:translate-y-[-2px] hover:shadow-lg hover:shadow-green-500/30 border-2 border-white shadow-xl animate-pulse"
           aria-label="Acceder a la Plataforma Estudiantil">
          <i data-feather="log-in" class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"></i>
          <span>Plataforma Estudiantil</span>
          <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-500 dark:to-emerald-500 opacity-0 transition-opacity duration-300 group-hover:opacity-20"></div>
        </a>
      </div>

      <!-- Mobile toggles -->
      <div class="lg:hidden flex items-center gap-3">
        <button id="themeToggleSm"
                class="theme-toggle h-10 w-10 rounded-xl flex items-center justify-center ring-1 ring-black/10 dark:ring-white/10 hover:ring-primary-500 transition-all duration-300 bg-white/70 dark:bg-neutral-800/70 backdrop-blur"
                aria-label="Cambiar tema"
                title="Cambiar entre modo claro y oscuro">
          <span class="icon-sun"></span>
          <span class="icon-moon"></span>
        </button>
        <button id="menuToggle"
                class="h-10 w-10 rounded-xl flex items-center justify-center ring-1 ring-black/10 dark:ring-white/10 hover:ring-primary-500 transition-all duration-300 bg-white/70 dark:bg-neutral-800/70 backdrop-blur"
                aria-label="Abrir menú"
                title="Menú móvil">
          <i data-feather="menu" class="h-5 w-5 text-gray-600 dark:text-gray-300"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile menu -->
  <div id="mobileMenu" class="lg:hidden mobile-menu transform -translate-y-full transition-transform duration-300 ease-in-out">
    <div class="bg-white/80 dark:bg-neutral-800/80 backdrop-blur-lg border-t border-neutral-200 dark:border-neutral-700">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="grid gap-3">
          <?php foreach($menu_items as $key => $item): 
            $is_active = ($key === $active_key);
          ?>
            <a href="<?php echo htmlspecialchars($item['url']); ?>" 
               data-key="<?php echo htmlspecialchars($key); ?>"
               class="mobile-link flex items-center gap-3 p-3 rounded-lg transition-all duration-300
                      <?php echo $is_active ? 'text-primary-600 bg-primary-50 dark:bg-primary-900/20 dark:text-primary-400' : 'hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 dark:hover:text-primary-400 text-gray-700 dark:text-gray-300'; ?>"
               aria-label="<?php echo htmlspecialchars($item['name']); ?>"
               data-href-key="<?php echo htmlspecialchars(basename($item['url'], '.php')); ?>">
              <i data-feather="<?php echo htmlspecialchars($item['icon']); ?>" class="w-5 h-5 text-gray-600 dark:text-gray-300"></i>
              <span class="font-medium"><?php echo htmlspecialchars($item['name']); ?></span>
            </a>
          <?php endforeach; ?>
          
          <a href="<?php echo htmlspecialchars($PLATAFORMA_URL); ?>"
             class="flex items-center gap-3 p-3 mt-2 rounded-lg bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-500 dark:to-emerald-500 text-white font-semibold transition-all duration-300 hover:shadow-lg hover:translate-y-[-1px] border-2 border-white shadow-xl animate-pulse"
             aria-label="Acceder a la Plataforma Estudiantil">
            <i data-feather="log-in" class="w-5 h-5"></i>
            <span>Acceder a la Plataforma</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>

<style>
/* Base Styles */
.nav-shell {
  backdrop-filter: blur(12px) saturate(180%);
  background: rgba(255, 255, 255, 0.85);
  border-bottom: 1px solid rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
  border-radius: 0 0 24px 24px;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.dark .nav-shell {
  background: rgba(15, 23, 42, 0.85);
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
  border: 1px solid rgba(255, 255, 255, 0.1);
}

/* Scrolled State */
.nav-scrolled {
  box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
  background: rgba(255, 255, 255, 0.95);
  padding-top: 0.5rem;
  padding-bottom: 0.5rem;
  border-radius: 0 0 16px 16px;
}

.dark .nav-scrolled {
  background: rgba(15, 23, 42, 0.95);
  box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.3), 0 4px 6px -4px rgb(0 0 0 / 0.2);
}

/* Theme Toggle Animation */
.theme-toggle {
  position: relative;
  overflow: hidden;
}

.theme-toggle .icon-sun,
.theme-toggle .icon-moon {
  position: absolute;
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.theme-toggle .icon-sun {
  opacity: 1;
  transform: translateY(0) rotate(0deg);
}

.theme-toggle .icon-moon {
  opacity: 0;
  transform: translateY(100%) rotate(-90deg);
}

.dark .theme-toggle .icon-sun {
  opacity: 0;
  transform: translateY(-100%) rotate(90deg);
}

.dark .theme-toggle .icon-moon {
  opacity: 1;
  transform: translateY(0) rotate(0deg);
}

/* Mobile Menu Animation */
.mobile-menu {
  position: fixed;
  top: 64px;
  left: 0;
  right: 0;
  width: 100vw;
  max-width: 100vw;
  overflow-y: auto;
  overflow-x: hidden;
  height: calc(100vh - 64px);
  transform: translateY(-100%);
  transition: transform 0.3s ease-in-out;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(12px);
  border-top: 1px solid rgba(0, 0, 0, 0.08);
  display: none;
}

.mobile-menu.active {
  transform: translateY(0);
  display: block;
}

.dark .mobile-menu {
  background: rgba(15, 23, 42, 0.95);
  border-top-color: rgba(255, 255, 255, 0.08);
}

.mobile-menu .mx-auto { max-width: 100%; }

/* Hover Effects */
.nav-link {
  position: relative;
  overflow: hidden;
  color: #374151;
  font-weight: 500;
  padding: 0.5rem 0;
  transition: all 0.3s ease;
}

.dark .nav-link {
  color: #d1d5db;
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, #10b981, #059669);
  transform: scaleX(0);
  transform-origin: right;
  transition: transform 0.3s ease;
}

.nav-link:hover::after,
.nav-link.active::after {
  transform: scaleX(1);
  transform-origin: left;
}

.nav-link:hover,
.dark .nav-link:hover,
.nav-link.active,
.dark .nav-link.active {
  color: #10b981;
}

/* Logo y título */
.nav-title {
  background: linear-gradient(135deg, #059669, #10b981);
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: 700;
  letter-spacing: 0.05em;
  transform: translateZ(0);
  backface-visibility: hidden;
}

.dark .nav-title {
  background: linear-gradient(135deg, #34d399, #10b981);
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* Animación para el logo */
.nav-brand img {
  transition: transform 0.3s ease;
}

.nav-brand:hover img {
    transform: scale(1.05);
}

/* Estilo para enlaces móviles */
.mobile-link {
  display: block;
  padding: .75rem 1rem;
  border-radius: .75rem;
  color: #374151;
  font-weight: 500;
}

.mobile-link:hover {
  background: rgba(0, 0, 0, 0.04);
}

.dark .mobile-link {
  color: #d1d5db;
}

.dark .mobile-link:hover {
  background: rgba(255, 255, 255, 0.08);
}

/* Notification Dropdown */
.notification-dropdown {
  transform-origin: top right;
}

.notification-dropdown.opacity-100 {
  transform: scale(1);
  opacity: 1;
  pointer-events: auto;
}

.notification-dropdown.opacity-0 {
  transform: scale(0.95);
  opacity: 0;
  pointer-events: none;
}

/* Responsive Design */
@media (max-width: 1024px) {
  .nav-link::after {
    display: none;
  }

  .nav-shell {
    max-width: 100% !important;
    margin: 0 !important;
    border-radius: 0 !important;
    padding-left: 12px;
    padding-right: 12px;
  }
}
</style>

<script>
// Inicializar Feather Icons
feather.replace();

// Manejo del scroll
const nav = document.getElementById('mainNav');
let lastScroll = 0;

window.addEventListener('scroll', () => {
  const currentScroll = window.scrollY;
  
  // Agregar/remover clase scrolled
  if (currentScroll > 0) {
    nav.classList.add('nav-scrolled');
  } else {
    nav.classList.remove('nav-scrolled');
  }
  
  // Ocultar/mostrar navbar al hacer scroll
  if (currentScroll > lastScroll && currentScroll > 100) {
    nav.style.transform = 'translateY(-100%)';
  } else {
    nav.style.transform = 'translateY(0)';
  }
  
  lastScroll = currentScroll;
});

// Toggle del menú móvil
const menuToggle = document.getElementById('menuToggle');
const mobileMenu = document.getElementById('mobileMenu');

if (menuToggle && mobileMenu) {
  menuToggle.addEventListener('click', () => {
    mobileMenu.classList.toggle('active');
    // Animar el ícono
    const icon = menuToggle.querySelector('i');
    if (mobileMenu.classList.contains('active')) {
      icon.setAttribute('data-feather', 'x');
    } else {
      icon.setAttribute('data-feather', 'menu');
    }
    feather.replace();
  });
}


// Animación suave al cargar la página
document.addEventListener('DOMContentLoaded', () => {
  nav.style.opacity = '0';
  requestAnimationFrame(() => {
    nav.style.transition = 'opacity 0.5s ease';
    nav.style.opacity = '1';
  });
  
  // Re-reemplazar íconos después de cargar el tema
  setTimeout(() => {
    feather.replace();
  }, 100);
});

// Cerrar menú móvil al hacer click en un enlace
document.querySelectorAll('#mobileMenu a').forEach(link => {
  if (link) {
    link.addEventListener('click', () => {
      mobileMenu.classList.remove('active');
      const icon = menuToggle.querySelector('i');
      if (icon) {
        icon.setAttribute('data-feather', 'menu');
        feather.replace();
      }
    });
  }
});

// Detectar la sección actual al hacer scroll (mejorado para active states)
const sections = document.querySelectorAll('section[id]');
window.addEventListener('scroll', () => {
  let current = '';
  sections.forEach(section => {
    const sectionTop = section.offsetTop;
    const sectionHeight = section.clientHeight;
    if (window.scrollY >= sectionTop - 60) {
      current = section.getAttribute('id');
    }
  });
  
  // Actualizar clase activa en los enlaces basados en data-href-key
  document.querySelectorAll('[data-href-key]').forEach(link => {
    if (link) {
      link.classList.remove('active');
      if (link.dataset.hrefKey === current || (current === '' && link.dataset.hrefKey === 'inicio')) {
        link.classList.add('active');
      }
    }
  });
});

// Manejo de enlaces externos
document.querySelectorAll('a[data-external="true"]').forEach(link => {
  link.addEventListener('click', (e) => {
    // Confirmar salida de la página
    if (!confirm('¿Estás seguro de que quieres salir de UTSC?')) {
      e.preventDefault();
    }
  });
});

// Toggle del dropdown de notificaciones
const notificationToggle = document.getElementById('notificationToggle');
const notificationDropdown = document.getElementById('notificationDropdown');

if (notificationToggle && notificationDropdown) {
  notificationToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    const isVisible = notificationDropdown.classList.contains('opacity-100');

    // Cerrar otros dropdowns si es necesario
    document.querySelectorAll('.notification-dropdown').forEach(dropdown => {
      dropdown.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
      dropdown.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
    });

    if (isVisible) {
      notificationDropdown.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
      notificationDropdown.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
    } else {
      notificationDropdown.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
      notificationDropdown.classList.add('opacity-100', 'scale-100', 'pointer-events-auto');
    }
  });

  // Cerrar dropdown al hacer click fuera
  document.addEventListener('click', (e) => {
    if (!notificationDropdown.contains(e.target) && !notificationToggle.contains(e.target)) {
      notificationDropdown.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
      notificationDropdown.classList.remove('opacity-100', 'scale-100', 'pointer-events-auto');
    }
  });
}
</script>