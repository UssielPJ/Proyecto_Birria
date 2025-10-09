<?php
// ==== [AÑADIDO] Helpers para incrustar otras páginas sin modificar su diseño ====
function _read_file($path){ return file_exists($path) ? file_get_contents($path) : ""; }

/** Quita envolturas <html>, <head>, <body> si existen y devuelve solo el cuerpo visible */
function render_fragment_from($file){
  $html = _read_file($file);
  if ($html === "") return "<!-- $file no encontrado -->";
  $lower = strtolower($html);

  // Intento de extraer solo el contenido dentro de <body>...</body>
  $body_start = stripos($lower, "<body");
  $body_end   = stripos($lower, "</body>");
  if ($body_start !== false && $body_end !== false){
    // Salta atributos de <body ...>
    $gt = stripos($lower, ">", $body_start);
    if ($gt !== false){
      $inner = substr($html, $gt+1, $body_end - ($gt+1));
      return $inner;
    }
  }

  // Si no hay <body>, retornamos tal cual (útil si el archivo ya es un fragmento)
  return $html;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTSC - Plataforma de E-Learning</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Vanta requiere three.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.globe.min.js"></script>
    <style>
        :root{
          --ut-green-900:#0c4f2e;
          --ut-green-800:#12663a;
          --ut-green-700:#177a46;
          --ut-green-600:#1e8c51;
          --ut-green-500:#28a55f;
          --ut-green-100:#e6f6ed;
        }
        .hero-gradient {
            background: linear-gradient(135deg, var(--ut-green-900) 0%, var(--ut-green-800) 50%, var(--ut-green-700) 100%);
        }
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        }
        .feature-icon {
            width: 60px; height: 60px; display:flex; align-items:center; justify-content:center; border-radius:12px;
        }
        /* ==== navegación con anclas sin tocar tu navbar ==== */
        html { scroll-behavior: smooth; }
        /* Evita que la sección quede oculta por la navbar fija (ajusta 96px si tu navbar es más alta/baja) */
        section[id] { scroll-margin-top: 96px; }
        /* Offset también para el hero/anclas en div */
        #inicio { scroll-margin-top: 96px; }
        div[id] { scroll-margin-top: 96px; }

        /* Modo oscuro base */
        body.dark {
          background-color: #111827; /* gris oscuro */
          color: #f3f4f6;           /* texto claro */
        }
        /* Ajustes para secciones claras */
        body.dark .bg-white { background-color: #1f2937 !important; }   /* gris intermedio */
        body.dark .bg-gray-50 { background-color: #111827 !important; } /* fondo más oscuro */
        body.dark .text-gray-900 { color: #f3f4f6 !important; }
        body.dark .text-gray-500 { color: #9ca3af !important; }
        body.dark .text-gray-600 { color: #d1d5db !important; }

        /* Tarjetas / elementos */
        body.dark .course-card { background-color: #1f2937; }
        body.dark .bg-gray-50.p-8 { background-color: #1f2937; }

        /* Tarjetas de docentes */
        .docente-card {
          background-color: #ffffff;          /* Claro en modo light */
          border-radius: 0.75rem;             /* Bordes redondeados */
          padding: 1.5rem;
          box-shadow: 0 6px 18px -6px rgba(0,0,0,0.15);
          transition: transform .2s ease, box-shadow .2s ease;
        }
        .docente-card:hover {
          transform: translateY(-4px);
          box-shadow: 0 12px 22px -8px rgba(0,0,0,0.25);
        }
        /* Modo oscuro (más oscuro) */
        body.dark .docente-card{
          background-color:#0f172a !important;         /* slate-900 aprox. más oscuro */
          border:1px solid rgba(255,255,255,.04) !important;
          box-shadow: 0 10px 28px -14px rgba(0,0,0,.85), 0 0 0 1px rgba(255,255,255,.02) inset !important;
        }
        body.dark .docente-card:hover{
          background-color:#131c31 !important;         /* un tic más claro en hover */
          border-color: rgba(255,255,255,.07) !important;
          box-shadow: 0 18px 34px -12px rgba(0,0,0,.9), 0 0 0 1px rgba(255,255,255,.04) inset !important;
        }
        /* Texto dentro de la card para que siga siendo legible */
        body.dark .docente-card .text-gray-900 { color:#f3f4f6 !important; }
        body.dark .docente-card .text-gray-600 { color:#cbd5e1 !important; }
        /* Chips más oscuros */
        body.dark .docente-card .specialty-chip.bg-\[var\(--ut-green-100\)\]{
          background-color:#052e24 !important; color:#86efac !important;
          border:1px solid rgba(134,239,172,.25);
        }
        body.dark .docente-card .specialty-chip.bg-green-100{
          background-color:#064e3b !important; color:#86efac !important;
          border:1px solid rgba(134,239,172,.25);
        }
        body.dark .docente-card .specialty-chip.bg-purple-100{
          background-color:#1e1b4b !important; color:#c7d2fe !important;
          border:1px solid rgba(199,210,254,.25);
        }
        body.dark .docente-card .specialty-chip.bg-yellow-100{
          background-color:#451a03 !important; color:#fde68a !important;
          border:1px solid rgba(253,230,138,.25);
        }
        /* Botón dentro de la card más oscuro */
        body.dark .docente-card .btn-docente{
          background:#0b1220 !important; 
          color:#e5e7eb !important;
          border:1px solid rgba(255,255,255,.06) !important;
          box-shadow: 0 8px 18px -12px rgba(0,0,0,.75) !important;
        }
        body.dark .docente-card .btn-docente:hover{ background:#111a2a !important; }
    </style>
</head>
<body class="font-sans antialiased text-gray-800">

    <?php include 'navbar.php'; ?>

    <!-- Hero Section -->
    <div id="inicio" class="hero-gradient text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                <div class="mb-12 lg:mb-0" data-aos="fade-right">
                    <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-6">
                      Educación Tecnológica <br> <span class="text-emerald-200">Sin Límites</span>
                    </h1>
                    <p class="text-lg md:text-xl text-emerald-100 mb-8">
                      Accede a nuestros cursos en línea desde cualquier dispositivo y lleva tu formación profesional al siguiente nivel.
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="cursos.php" class="bg-white text-[var(--ut-green-800)] hover:bg-gray-100 px-6 py-3 rounded-md text-lg font-semibold transition">Explorar Cursos</a>
                        <a href="#" class="border-2 border-white text-white hover:bg-white hover:text-[var(--ut-green-800)] px-6 py-3 rounded-md text-lg font-semibold transition">Ver Video</a>
                    </div>
                </div>
                <div data-aos="fade-left">
                    <img src=".//plataforma/app/img/PlantelUT.jpg" alt="E-learning" class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Nuestra Plataforma</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Diseñada para ofrecer la mejor experiencia de aprendizaje en línea</p>
            </div>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-icon bg-[var(--ut-green-100)] text-[var(--ut-green-700)] mx-auto mb-4">
                        <i data-feather="monitor" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Multiplataforma</h3>
                    <p class="text-gray-500">Accede desde cualquier dispositivo: computadora, tablet o smartphone.</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-icon bg-[var(--ut-green-100)] text-[var(--ut-green-700)] mx-auto mb-4">
                        <i data-feather="book-open" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Contenido Interactivo</h3>
                    <p class="text-gray-500">Videos, cuestionarios y ejercicios prácticos para un aprendizaje efectivo.</p>
                </div>
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-icon bg-[var(--ut-green-100)] text-[var(--ut-green-700)] mx-auto mb-4">
                        <i data-feather="users" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Comunidad Activa</h3>
                    <p class="text-gray-500">Interactúa con profesores y compañeros a través de foros y chats.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <div data-aos="fade-right">
                    <h2 class="text-3xl font-extrabold text-gray-900">Nuestros Cursos</h2>
                    <p class="mt-2 text-lg text-gray-500">Explora nuestra oferta académica</p>
                </div>
                <a href="cursos.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium" data-aos="fade-left">Ver todos →</a>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Course 1 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md course-card transition duration-300 ease-in-out" data-aos="fade-up">
                    <img class="w-full h-48 object-cover" src="./plataforma/app/img/IndustrialM.jpg" alt="Inteligencia Artificial">
                    <div class="p-6">
                        <div class="flex items-center mb-2">
                            <span class="bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs font-semibold px-2.5 py-0.5 rounded">Nuevo</span>
                            <span class="ml-2 text-gray-500 text-sm">Mantenimiento</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Mantenimiento Industrial</h3>
                        <p class="text-gray-600 mb-4">Gestión y soluciones en Mantenimiento Industrial.</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <i data-feather="clock" class="w-4 h-4 text-gray-500 mr-1"></i>
                                <span class="text-sm text-gray-500">1 año 8 meses</span>
                            </div>
                            <span class="text-[var(--ut-green-700)] font-medium">Inscripciones abiertas</span>
                        </div>
                    </div>
                </div>
                <!-- Course 2 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md course-card transition duration-300 ease-in-out" data-aos="fade-up" data-aos-delay="100">
                    <img class="w-full h-48 object-cover" src="./plataforma/app/img/Negocios.jpg" alt="Desarrollo Web">
                    <div class="p-6">
                        <div class="flex items-center mb-2">
                            <span class="bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs font-semibold px-2.5 py-0.5 rounded">Popular</span>
                            <span class="ml-2 text-gray-500 text-sm">Crecimiento</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Negocios Internacionales</h3>
                        <p class="text-gray-600 mb-4">Formación integral para gestionar empresas en un entorno global competitivo.</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <i data-feather="clock" class="w-4 h-4 text-gray-500 mr-1"></i>
                                <span class="text-sm text-gray-500">1 año 8 meses</span>
                            </div>
                            <span class="text-[var(--ut-green-700)] font-medium">Inscripciones abiertas</span>
                        </div>
                    </div>
                </div>
                <!-- Course 3 -->
                <div class="bg-white rounded-lg overflow-hidden shadow-md course-card transition duration-300 ease-in-out" data-aos="fade-up" data-aos-delay="200">
                    <img class="w-full h-48 object-cover" src="./plataforma/app/img/Mecatronica.jpg" alt="Ciberseguridad">
                    <div class="p-6">
                        <div class="flex items-center mb-2">
                            <span class="bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs font-semibold px-2.5 py-0.5 rounded">Avanzado</span>
                            <span class="ml-2 text-gray-500 text-sm">Automatización</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Robótica Industrial</h3>
                        <p class="text-gray-600 mb-4">Desarrollo de robots capaces de optimizar procesos productivos con precisión y eficiencia.</p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <i data-feather="clock" class="w-4 h-4 text-gray-500 mr-1"></i>
                                <span class="text-sm text-gray-500">1 año 8 meses</span>
                            </div>
                            <span class="text-[var(--ut-green-700)] font-medium">Inscripciones abiertas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Lo que dicen nuestros estudiantes</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Experiencias reales de nuestra comunidad académica</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonios iguales a tu diseño -->
                <div class="bg-gray-50 p-8 rounded-lg" data-aos="fade-up">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full object-cover" src=" alt="Ana Martínez">
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900">Ana Martínez</h4>
                            <p class="text-[var(--ut-green-700)]">Ing. en Sistemas</p>
                        </div>
                    </div>
                    <p class="text-gray-600">"La plataforma es intuitiva y los contenidos son de alta calidad. Pude completar mi especialización mientras trabajaba tiempo completo."</p>
                    <div class="flex mt-4">
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                    </div>
                </div>
                <div class="bg-gray-50 p-8 rounded-lg" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full object-cover" src="http://static.photos/people/200x200/2" alt="Carlos Rodríguez">
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900">Carlos Rodríguez</h4>
                            <p class="text-[var(--ut-green-700)]">Desarrollador Web</p>
                        </div>
                    </div>
                    <p class="text-gray-600">"Los proyectos prácticos me ayudaron a construir un portafolio que me consiguió mi primer trabajo como desarrollador junior."</p>
                    <div class="flex mt-4">
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                    </div>
                </div>
                <div class="bg-gray-50 p-8 rounded-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center mb-4">
                        <img class="w-12 h-12 rounded-full object-cover" src="http://static.photos/people/200x200/3" alt="María González">
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-900">María González</h4>
                            <p class="text-[var(--ut-green-700)]">Estudiante de Maestría</p>
                        </div>
                    </div>
                    <p class="text-gray-600">"La flexibilidad de horarios me permitió balancear mis estudios de posgrado con mis responsabilidades familiares."</p>
                    <div class="flex mt-4">
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                        <i data-feather="star" class="w-5 h-5 text-gray-300 fill-current"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div style="background:linear-gradient(180deg,var(--ut-green-800),var(--ut-green-900));" class="text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                <div class="mb-8 lg:mb-0" data-aos="fade-right">
                    <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl mb-4">¿Listo para comenzar?</h2>
                    <p class="text-lg text-emerald-100 mb-6">Únete a miles de estudiantes que están transformando su futuro con nuestra plataforma.</p>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="registro.php" class="bg-white text-[var(--ut-green-800)] hover:bg-gray-100 px-6 py-3 rounded-md text-lg font-semibold transition">Crear Cuenta</a>
                        <a href="mailto:contacto@utec.edu" class="border-2 border-white text-white hover:bg-white hover:text-[var(--ut-green-800)] px-6 py-3 rounded-md text-lg font-semibold transition">Contactar Asesor</a>
                    </div>
                </div>
                <div data-aos="fade-left">
                    <img src="./plataforma/app/img/CorrecaminosUT.jpg" alt="Estudiantes" class="rounded-lg shadow-xl">
                </div>
            </div>
        </div>
    </div>

    <!-- ==== Secciones unificadas (anclas) ==== -->
    <section id="docentes">
        <?php echo render_fragment_from('docentes.php'); ?>
    </section>

    <section id="cursos">
        <?php echo render_fragment_from('cursos.php'); ?>
    </section>

    <section id="recursos">
        <?php echo render_fragment_from('recursos.php'); ?>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        // AOS + Feather
        AOS.init({ duration: 800, easing: 'ease-in-out', once: true });
        feather.replace();

        // Vanta.js background (ahora sobre #inicio)
        VANTA.GLOBE({
            el: "#inicio",
            mouseControls: true,
            touchControls: true,
            gyroControls: false,
            minHeight: 200.00,
            minWidth: 200.00,
            scale: 1.00,
            scaleMobile: 1.00,
            color: 0x28a55f,
            backgroundColor: 0x0c4f2e,
            size: 0.7
        });

        (function () {
  // Mapa archivo -> ancla
  const map = {
    'index.php':   '#inicio',
    'docentes.php':'#docentes',
    'cursos.php':  '#cursos',
    'recursos.php':'#recursos'
  };

  document.addEventListener('click', function (e) {
    const a = e.target.closest('a[href]');
    if (!a) return;

    const href = a.getAttribute('href');
    if (!href) return;

    // 1) Respeta anchors directos y enlaces marcados como externos
    if (href.startsWith('#') || a.hasAttribute('data-external')) return;

    try {
      const url = new URL(href, window.location.href);

      // 2) Sólo mismo origen
      if (url.origin !== window.location.origin) return;

      // 3) No interceptar nada de la plataforma (ajusta el prefijo si cambiaste la ruta)
      if (url.pathname.startsWith('/src/plataforma')) return;

      // 4) Detectar archivo de destino
      const file = url.pathname.split('/').pop().toLowerCase();

      // Caso “raíz” con / o sin archivo -> #inicio (sólo si navega a la misma página base)
      const isRootToSelf =
        (file === '' && (url.pathname === '/' || url.pathname === window.location.pathname));

      const targetSel = isRootToSelf ? '#inicio' : map[file];
      if (!targetSel) return;

      // 5) Interceptar y hacer scroll suave
      e.preventDefault();
      const target = document.querySelector(targetSel);
      if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        history.pushState(null, '', targetSel);
      }
    } catch (err) { /* noop */ }
  }, true);
})();

        // Botón modo oscuro (si está en navbar como #toggleDark)
        (function(){
          const toggle = document.getElementById("toggleDark");
          const body = document.body;

          // Cargar preferencia guardada
          if(localStorage.getItem("theme") === "dark"){
            body.classList.add("dark");
            if (toggle) toggle.innerHTML = "☀";
          }

          if(toggle){
            toggle.addEventListener("click", () => {
              body.classList.toggle("dark");
              if(body.classList.contains("dark")){
                localStorage.setItem("theme","dark");
                toggle.innerHTML = "☀";
              } else {
                localStorage.setItem("theme","light");
                toggle.innerHTML = "🌙";
              }
              feather.replace(); // refrescar íconos si usas feather
            });
          }
        })();
    </script>
</body>
</html>