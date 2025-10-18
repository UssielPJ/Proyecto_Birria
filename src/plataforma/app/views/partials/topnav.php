<?php
// topbar.php
?>
<nav class="w-full border-b border-white/10 bg-slate-900/70 backdrop-blur">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between">
    <div class="text-white font-semibold">UTSC · Estudiantes</div>

    <div class="flex items-center gap-3">
      <!-- Botón modo claro/oscuro -->
      <button id="themeToggle"
              class="h-9 w-9 rounded-xl flex items-center justify-center ring-1 ring-white/10 hover:ring-white/20 transition bg-white/10 text-white nav-toggle"
              aria-label="Cambiar tema">
        <span class="icon-sun pointer-events-none">
          <!-- Sun -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="4"></circle>
            <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
          </svg>
        </span>
        <span class="icon-moon pointer-events-none">
          <!-- Moon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z"/>
          </svg>
        </span>
      </button>

      <a href="/src/plataforma/app/anuncios" class="text-white/80 hover:text-white">Anuncios</a>
      <a href="/src/plataforma/logout" class="text-red-300 hover:text-red-200">Salir</a>
    </div>
  </div>
</nav>

<style>
  /* Toggle animado */
  .nav-toggle { position:relative; }
  .nav-toggle .icon-sun, .nav-toggle .icon-moon{
    position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
    transition: opacity .25s ease, transform .25s ease;
  }
  .nav-toggle .icon-moon{ opacity:0; transform:scale(.5) rotate(-90deg); }
  body.dark .nav-toggle .icon-sun{ opacity:0; transform:scale(.5) rotate(90deg); }
  body.dark .nav-toggle .icon-moon{ opacity:1; transform:scale(1) rotate(0deg); }

  /* Paleta base clara/oscura del área app */
  body{ background:#0f172a; }                  /* oscuro por defecto si ya lo tenías así */
  body.light{ background:#f8fafc; color:#111827; }
  body.dark { background:#0f172a; color:#e5e7eb; }

  /* Tarjetas (tiles) — ver sección 2 */
  .tile{
    background:#ffffff; color:#1f2937;         /* legible en claro */
    border-radius: .875rem;
    box-shadow: 0 10px 24px -14px rgba(0,0,0,.25);
    transition: transform .15s ease, box-shadow .2s ease, background .2s ease, color .2s ease;
  }
  .tile:hover{ transform: translateY(-2px); box-shadow: 0 16px 28px -16px rgba(0,0,0,.35); }
  .tile-title{ color:#111827; font-weight:600; }
  .tile-sub{ color:#6b7280; }

  body.dark .tile{
    background:#0b1220; color:#e5e7eb;         /* legible en oscuro */
    border:1px solid rgba(255,255,255,.06);
    box-shadow: 0 10px 28px -16px rgba(0,0,0,.75), 0 0 0 1px rgba(255,255,255,.03) inset;
  }
  body.dark .tile-title{ color:#f3f4f6; }
  body.dark .tile-sub{ color:#a3a3a3; }
</style>

<script>
  // Tema persistente
  (function(){
    const saved = localStorage.getItem('theme');        // 'dark' | 'light' | null
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    if(saved){ document.body.classList.toggle('dark', saved==='dark');
               document.body.classList.toggle('light', saved==='light'); }
    else { document.body.classList.toggle('dark', prefersDark); }

    const btn = document.getElementById('themeToggle');
    if(btn){
      btn.addEventListener('click', ()=>{
        const toDark = !document.body.classList.contains('dark');
        document.body.classList.toggle('dark', toDark);
        document.body.classList.toggle('light', !toDark);
        localStorage.setItem('theme', toDark ? 'dark' : 'light');
      });
    }
  })();
</script>
