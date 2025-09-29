<?php
  // URL de la plataforma estudiantil (ajústala a lo tuyo)
  $PLATAFORMA_URL = "/src/plataforma/";
  // p.ej. /login.php, /alumnos/, https://plataforma.utec.edu
?>
<nav class="fixed top-0 inset-x-0 z-50">
  <div class="nav-shell mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="h-16 flex items-center justify-between">
      <!-- Brand -->
      <a href="#inicio" class="flex items-center gap-2 group">
        <img src="/static/logo_utec.png" alt="UTEC" class="h-9 w-9 rounded-md object-cover ring-2 ring-white/20 group-hover:ring-white/40 transition" onerror="this.style.display='none'">
        <span class="text-lg font-semibold tracking-wide nav-title">UTSC</span>
      </a>

      <!-- Desktop menu -->
      <div class="hidden lg:flex items-center gap-8">
        <a href="#inicio"    class="nav-link">Inicio</a>
        <a href="#cursos"    class="nav-link">Cursos</a>
        <a href="#docentes"  class="nav-link">Docentes</a>
        <a href="#recursos"  class="nav-link">Recursos</a>
        <a href="nosotros.php" class="nav-link">Nosotros</a>

      </div>

      <!-- Actions -->
      <div class="hidden lg:flex items-center gap-3">
        <!-- Theme toggle -->
        <button id="themeToggle"
                class="h-10 w-10 rounded-xl flex items-center justify-center ring-1 ring-black/10 hover:ring-black/20 transition bg-white/70 backdrop-blur nav-toggle"
                aria-label="Cambiar tema">
          <!-- Iconos superpuestos para animación -->
          <span class="icon-sun pointer-events-none">
            <!-- Sun (Feather) -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="4"></circle>
              <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
            </svg>
          </span>
          <span class="icon-moon pointer-events-none">
            <!-- Moon (Feather) -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
              <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z"/>
            </svg>
          </span>
        </button>

        <!-- Plataforma (no interceptar) -->
        <a href="<?php echo htmlspecialchars($PLATAFORMA_URL); ?>"
           class="btn-login"
           data-external="true">
          Plataforma Estudiantil
        </a>
      </div>

      <!-- Mobile toggles -->
      <div class="lg:hidden flex items-center gap-2">
        <button id="themeToggleSm"
                class="h-10 w-10 rounded-xl flex items-center justify-center ring-1 ring-black/10 hover:ring-black/20 transition bg-white/70 backdrop-blur nav-toggle"
                aria-label="Cambiar tema">
          <span class="icon-sun"></span><span class="icon-moon"></span>
        </button>
        <button id="menuToggle"
                class="h-10 w-10 rounded-xl flex items-center justify-center ring-1 ring-black/10 hover:ring-black/20 transition bg-white/70 backdrop-blur"
                aria-label="Abrir menú">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 6h18M3 12h18M3 18h18"/>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile drawer -->
  <div id="mobileMenu" class="lg:hidden mobile-panel">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 space-y-2">
      <a href="#inicio"    class="mobile-link">Inicio</a>
      <a href="#cursos"    class="mobile-link">Cursos</a>
      <a href="#docentes"  class="mobile-link">Docentes</a>
      <a href="#recursos"  class="mobile-link">Recursos</a>
      <a href="<?php echo htmlspecialchars($PLATAFORMA_URL); ?>"
         class="btn-login w-full justify-center mt-2"
         data-external="true">Plataforma Estudiantil</a>
    </div>
  </div>
</nav>

<!-- Styles específicos de la navbar -->
<style>
  /* --- Fix generales para evitar desbordes horizontales --- */
  html, body { overflow-x: hidden; }
  nav.fixed{ left:0; right:0; width:100vw; }

  /* Shell con blur y sombra suave */
  .nav-shell{ background: color-mix(in oklab, white 80%, transparent); backdrop-filter: blur(10px); border-radius: 0 0 18px 18px; }
  .nav-title{ color:#14532d; }
  .nav-link{ color:#1f2937; font-weight:500; }
  .nav-link:hover{ color:#0c4f2e; }
  .btn-login{
    display:inline-flex; align-items:center; gap:.5rem;
    background:#28a55f; color:white; padding:.6rem 1rem; border-radius:.75rem;
    font-weight:600; box-shadow:0 6px 16px -6px rgba(16,185,129,.45);
    transition:transform .15s ease, box-shadow .2s ease;
  }
  .btn-login:hover{ transform:translateY(-1px); box-shadow:0 10px 22px -8px rgba(16,185,129,.55); }
  .mobile-panel{ display:none; background: color-mix(in oklab, white 92%, transparent); border-top:1px solid rgba(0,0,0,.06); }
  .mobile-link{ display:block; padding:.75rem 1rem; border-radius:.75rem; color:#1f2937; font-weight:500; }
  .mobile-link:hover{ background:rgba(0,0,0,.04); }

  /* Toggle icon animation (sun <-> moon) */
  .nav-toggle { position:relative; color:#111827; width:40px; min-width:40px; }
  .nav-toggle .icon-sun, .nav-toggle .icon-moon{
    position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
    transition: opacity .25s ease, transform .25s ease;
  }
  .nav-toggle .icon-moon{ opacity:0; transform:scale(.5) rotate(-90deg); }
  body.dark .nav-toggle{ color:#f3f4f6; }
  body.dark .nav-toggle .icon-sun{ opacity:0; transform:scale(.5) rotate(90deg); }
  body.dark .nav-toggle .icon-moon{ opacity:1; transform:scale(1) rotate(0deg); }

  /* Dark mode para navbar */
  body.dark .nav-shell{ background: color-mix(in oklab, #0b1220 80%, transparent); }
  body.dark .nav-title{ color:#e5e7eb; }
  body.dark .nav-link{ color:#e5e7eb; }
  body.dark .nav-link:hover{ color:#86efac; }
  body.dark .mobile-panel{ background: color-mix(in oklab, #0b1220 90%, transparent); border-color:rgba(255,255,255,.08); }
  body.dark .mobile-link{ color:#e5e7eb; }

  /* --- Responsivo: en móviles la shell ocupa 100% sin bordes redondeados --- */
  @media (max-width: 1024px){
    .nav-shell{
      max-width: 100% !important;
      margin: 0 !important;
      border-radius: 0 !important;
      padding-left: 12px;
      padding-right: 12px;
    }
  }

  /* --- Drawer móvil fijo, ancho exacto y sin scroll lateral --- */
  #mobileMenu.mobile-panel{
    position: fixed;
    top: 64px;               /* altura de la navbar (h-16) */
    left: 0;
    right: 0;
    width: 100vw;
    max-width: 100vw;
    overflow-y: auto;
    overflow-x: hidden;
    height: calc(100vh - 64px);
    display: none;           /* se abre por JS */
    z-index: 40;
  }
  #mobileMenu .mx-auto{ max-width: 100%; }
</style>

<script>
  // --- Mobile menu
  (function(){
    const btn = document.getElementById('menuToggle');
    const panel = document.getElementById('mobileMenu');
    if(btn && panel){
      btn.addEventListener('click', ()=>{
        panel.style.display = panel.style.display === 'block' ? 'none' : 'block';
      });
      // Cerrar al hacer click en un link
      panel.addEventListener('click', (e)=>{
        const a = e.target.closest('a[href]');
        if(a) panel.style.display = 'none';
      });
    }
  })();

  // --- Theme toggle (persistente)
  (function(){
    const applySaved = ()=>{
      if(localStorage.getItem('theme') === 'dark') document.body.classList.add('dark');
    };
    applySaved();

    const bind = (id)=>{
      const el = document.getElementById(id);
      if(!el) return;
      el.addEventListener('click', ()=>{
        document.body.classList.toggle('dark');
        localStorage.setItem('theme', document.body.classList.contains('dark') ? 'dark' : 'light');
      });
    };
    bind('themeToggle');
    bind('themeToggleSm');
  })();
</script>
