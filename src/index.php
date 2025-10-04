<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="UTSC - Plataforma de E-Learning: Educación tecnológica sin límites. Accede a carreras en línea, ingenierías destacadas y recursos educativos de vanguardia. Certificaciones oficiales y +4600 estudiantes activos.">
    <meta name="keywords" content="UTSC, educación tecnológica, e-learning, carreras en línea, ingeniería mecatrónica, tecnologías información, mantenimiento industrial">
    <meta property="og:title" content="UTSC - Plataforma de E-Learning">
    <meta property="og:description" content="Educación tecnológica sin límites. Descubre carreras y programas innovadores.">
    <meta property="og:image" content="/src/plataforma/app/img/UT.jpg">
    <meta property="og:url" content="https://utsc.edu.mx">
    <meta name="twitter:card" content="summary_large_image">
    <title>UTSC - Plataforma de E-Learning | Educación Tecnológica Innovadora</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="canonical" href="https://utsc.edu.mx/src/index.php">
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
    <script src="/src/js/theme.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- Vanta requiere three.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.globe.min.js"></script>
    <!-- Tippy.js para tooltips -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <!-- Swiper para carruseles avanzados -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Google Fonts para tipografías mejoradas -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{
          --ut-green-900:#0c4f2e;
          --ut-green-800:#12663a;
          --ut-green-700:#177a46;
          --ut-green-600:#1e8c51;
          --ut-green-500:#28a55f;
          --ut-green-400:#4ade80;
          --ut-green-100:#e6f6ed;
          --ut-accent-blue: #3b82f6;
          --ut-accent-indigo: #6366f1;
          --ut-accent-purple: #8b5cf6;
        }
        body { font-family: 'Inter', sans-serif; }
        .hero-gradient {
            background: linear-gradient(135deg, var(--ut-green-900) 0%, var(--ut-green-800) 50%, var(--ut-green-700) 100%);
            position: relative;
            overflow: hidden;
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

        /* Sistema de modo oscuro mejorado */
        body.dark {
            background-color: #0f172a; /* Slate 900 - fondo más oscuro */
            color: #f8fafc;           /* Slate 50 - texto muy claro */
        }

        /* Ajustes generales para modo oscuro */
        body.dark .bg-white { 
            background-color: #1e293b !important; /* Slate 800 */
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        body.dark .bg-gray-50 { 
            background-color: #0f172a !important; /* Slate 900 */
        }
        
        /* Mejoras de texto para modo oscuro */
        body.dark .text-gray-900 { color: #f8fafc !important; } /* Slate 50 */
        body.dark .text-gray-800 { color: #f1f5f9 !important; } /* Slate 100 */
        body.dark .text-gray-700 { color: #e2e8f0 !important; } /* Slate 200 */
        body.dark .text-gray-600 { color: #cbd5e1 !important; } /* Slate 300 */
        body.dark .text-gray-500 { color: #94a3b8 !important; } /* Slate 400 */
        
        /* Ajustes de color para elementos específicos en modo oscuro */
        body.dark .stats-card {
            background: linear-gradient(135deg, #065f46, #047857); /* Verde oscuro */
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Ajuste de sombras para modo oscuro */
        body.dark .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.6), 
                       0 4px 6px -4px rgba(0, 0, 0, 0.4) !important;
        }
        
        /* Cards en modo oscuro */
        body.dark .course-card,
        body.dark .news-card,
        body.dark .career-card,
        body.dark .testimonial-card,
        body.dark .feature-card {
            background-color: #1e293b; /* Slate 800 */
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        /* Botones en modo oscuro */
        body.dark .btn-primary {
            background: linear-gradient(135deg, #059669, #047857);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Hero section en modo oscuro */
        body.dark .hero-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
        
        /* Mejoras de contraste para badges en modo oscuro */
        body.dark .bg-green-100 {
            background-color: #064e3b !important;
            color: #6ee7b7 !important;
        }
        body.dark .bg-blue-100 {
            background-color: #1e3a8a !important;
            color: #93c5fd !important;
        }
        body.dark .bg-purple-100 {
            background-color: #4c1d95 !important;
            color: #ddd6fe !important;
        }
        body.dark .bg-red-100 {
            background-color: #7f1d1d !important;
            color: #fecaca !important;
        }
        body.dark .bg-yellow-100 {
            background-color: #713f12 !important;
            color: #fef08a !important;
        }

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

        /* Estilos para el botón de tema */
        #themeToggle, #themeToggleSm {
            position: relative;
            overflow: hidden;
        }

        .icon-sun, .icon-moon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .icon-sun {
            transform: translate(-50%, -50%);
            opacity: 1;
        }

        .icon-moon {
            transform: translate(-50%, 50%);
            opacity: 0;
        }

        body.dark .icon-sun {
            transform: translate(-50%, -150%);
            opacity: 0;
        }

        body.dark .icon-moon {
            transform: translate(-50%, -50%);
            opacity: 1;
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
        
        /* Nuevos estilos para el rediseño */
        .news-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .campus-map-container {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .career-selector {
            transition: all 0.3s ease;
        }
        .career-selector:hover {
            transform: translateY(-3px);
        }
        .video-container {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .stats-card {
            background: linear-gradient(135deg, var(--ut-green-700), var(--ut-green-800));
            border-radius: 12px;
            padding: 1.5rem;
            color: white;
        }
        .testimonial-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }
        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .feature-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        /* Nuevas animaciones */
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        .animate-fade-in-up {
            animation: fadeInUp 1s ease-out forwards;
        }
        .animate-scale-in {
            animation: scaleIn 0.5s ease-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Mejoras en las cards */
        .news-card, .career-card, .docente-card, .feature-card, .testimonial-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backface-visibility: hidden;
            will-change: transform, box-shadow;
        }
        
        .news-card:hover, .career-card:hover, .docente-card:hover, .feature-card:hover, .testimonial-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        /* Efecto de hover en botones */
        .btn-primary {
            background: linear-gradient(135deg, var(--ut-green-600), var(--ut-accent-blue));
            background-size: 200% 100%;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-position: 100% 0;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Transiciones suaves para cambios de tema */
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        
        /* Transiciones para elementos que cambian con el tema */
        .bg-white,
        .bg-gray-50,
        .course-card,
        .news-card,
        .career-card,
        .stats-card,
        .btn-primary,
        .hero-gradient,
        .nav-shell,
        .feature-card,
        .testimonial-card {
            transition: all 0.3s ease !important;
        }
        
        /* Animación suave para cambio de tema en textos */
        [class^="text-"] {
            transition: color 0.3s ease;
        }
        
        /* Transición suave para sombras */
        [class*="shadow"] {
            transition: box-shadow 0.3s ease;
        }
        
        /* Transiciones para badges y elementos de acento */
        [class*="bg-"] {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Efectos de scroll suave */
        .smooth-scroll {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }

        /* Tooltips personalizados */
        .tippy-box {
            background-color: var(--ut-green-800);
            color: white;
            border-radius: 8px;
            font-size: 0.875rem;
        }

        .tippy-arrow {
            color: var(--ut-green-800);
        }

        /* Efectos de gradiente */
        .gradient-text {
            background: linear-gradient(135deg, var(--ut-green-500), var(--ut-accent-blue));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Mejoras en el dark mode */
        .dark .gradient-text {
            background: linear-gradient(135deg, var(--ut-green-400), var(--ut-accent-indigo));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dark .btn-primary {
            background: linear-gradient(135deg, var(--ut-green-700), var(--ut-accent-purple));
        }

         /* Estilos para el flip solo en la imagen */
.image-flip-container {
  perspective: 1000px;
  cursor: pointer;
}

.image-flip-front,
.image-flip-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  transition: transform 0.6s ease-in-out;
  border-radius: 12px 12px 0 0;
}

.image-flip-back {
  transform: rotateY(180deg);
  display: flex;
  align-items: center;
  justify-content: center;
}

.image-flip-container:hover .image-flip-front {
  transform: rotateY(-180deg);
}

.image-flip-container:hover .image-flip-back {
  transform: rotateY(0deg);
}

.career-card {
  transition: all 0.3s ease;
}

.career-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

        /* Swiper overrides */
        .swiper {
            width: 100%;
            padding-bottom: 50px;
        }
        .swiper-slide {
            display: flex;
            justify-content: center;
        }
        .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
            transition: all 0.3s ease;
        }
        .swiper-pagination-bullet-active {
            background: white;
            transform: scale(1.2);
        }
        .swiper-button-next, .swiper-button-prev {
            color: white;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 40px;
            height: 40px;
        }
        .swiper-button-next:hover, .swiper-button-prev:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Accessibility improvements */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
            .swiper-wrapper {
                transition: none;
            }
        }

        /* Print styles */
        @media print {
            .hero-gradient, .bg-white, .bg-gray-50 {
                background: white !important;
                color: black !important;
            }
            body.dark {
                background: white !important;
                color: black !important;
            }
        }

        /* Mejoras para PWA */
        @media (display-mode: standalone) {
            body { padding-top: 0; }
            #mainNav { position: relative; }
        }
    </style>
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "EducationalOrganization",
      "name": "Universidad Tecnológica Santa Catarina (UTSC)",
      "url": "https://utsc.edu.mx",
      "logo": "/src/plataforma/app/img/UT.jpg",
      "description": "Plataforma de E-Learning dedicada a la educación tecnológica innovadora.",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Santa Catarina, Nuevo León",
        "addressCountry": "MX"
      },
      "sameAs": [
        "https://www.facebook.com/UTSCNL",
        "https://twitter.com/UTSantaCatarina"
      ],
      "course": [
        {
          "@type": "Course",
          "name": "Ingeniería en Tecnologías de la Información e Innovación Digital",
          "description": "Desarrolla soluciones tecnológicas multiplataforma de software web y móvil.",
          "courseMode": "online"
        },
        {
          "@type": "Course",
          "name": "Ingeniería en Mecatrónica",
          "description": "Combina elementos de la ingeniería mecánica, electrónica, informática y automatización.",
          "courseMode": "online"
        }
      ]
    }
    </script>
</head>
<body class="font-sans antialiased text-gray-800">

    <?php include 'navbar.php'; ?>

    <!-- Hero Section con Swiper Carousel Mejorado -->
    <div id="inicio" class="hero-gradient text-white relative overflow-hidden">
        <!-- Vanta background layer -->
        <div id="vanta-bg" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;"></div>
        <div class="relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                    <div class="mb-12 lg:mb-0" data-aos="fade-right">
                        <div class="relative">
                            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-6 animate-fade-in-up">
                                Educación Tecnológica <br> 
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-200 to-blue-200">Sin Límites</span>
                            </h1>
                            <div class="absolute -top-10 -right-10 w-20 h-20 bg-gradient-to-br from-emerald-400 to-blue-500 rounded-full filter blur-xl opacity-30 animate-pulse"></div>
                        </div>
                        <p class="text-lg md:text-xl text-emerald-100 mb-8 max-w-xl animate-fade-in">
                            Accede a nuestras carreras en línea desde cualquier dispositivo y lleva tu formación profesional al siguiente nivel. Descubre un nuevo mundo de posibilidades educativas con certificaciones oficiales y soporte personalizado.
                        </p>
                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 animate-fade-in-up">
                            <a href="cursos.php" class="group bg-white text-[var(--ut-green-800)] hover:bg-gray-100 px-8 py-4 rounded-lg text-lg font-semibold transition-all transform hover:scale-105 hover:shadow-lg flex items-center" aria-label="Explorar carreras disponibles">
                                <i data-feather="book-open" class="w-5 h-5 mr-2 transition-transform group-hover:rotate-12"></i>
                                Explorar Carreras
                            </a>
                            <a href="#" class="group border-2 border-white text-white hover:bg-white hover:text-[var(--ut-green-800)] px-8 py-4 rounded-lg text-lg font-semibold transition-all transform hover:scale-105 hover:shadow-lg flex items-center" aria-label="Ver video introductorio">
                                <i data-feather="play-circle" class="w-5 h-5 mr-2 transition-transform group-hover:rotate-12"></i>
                                Ver Video
                            </a>
                        </div>
                        <div class="mt-12 flex items-center space-x-4 text-sm text-emerald-100 animate-fade-in">
                            <div class="flex items-center">
                                <i data-feather="check-circle" class="w-5 h-5 mr-2 text-emerald-300"></i>
                                Certificación oficial
                            </div>
                            <div class="flex items-center">
                                <i data-feather="users" class="w-5 h-5 mr-2 text-emerald-300"></i>
                                +4600 estudiantes<grok-card data-id="c7c9cb" data-type="citation_card"></grok-card>
                            </div>
                            <div class="flex items-center">
                                <i data-feather="award" class="w-5 h-5 mr-2 text-emerald-300"></i>
                                27 años de experiencia<grok-card data-id="084c34" data-type="citation_card"></grok-card>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Swiper Carousel mejorado -->
                    <div data-aos="fade-left">
                        <div class="swiper hero-swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="./plataforma/app/img/PlantelUT.jpg" alt="Campus Principal de UTSC con instalaciones modernas" class="w-full h-80 object-cover rounded-lg shadow-2xl" loading="lazy">
                                </div>
                                <div class="swiper-slide">
                                    <img src="./plataforma/app/img/SeleccionUT.jpg" alt="Instalaciones deportivas de UTSC para actividades recreativas" class="w-full h-80 object-cover rounded-lg shadow-2xl" loading="lazy">
                                </div>
                                <div class="swiper-slide">
                                    <img src="./plataforma/app/img/SeleccionTocho.jpg" alt="Laboratorios industriales equipados en UTSC" class="w-full h-80 object-cover rounded-lg shadow-2xl" loading="lazy">
                                </div>
                                <div class="swiper-slide">
                                    <img src="./plataforma/app/img/DocentesUT.jpg" alt="Docentes expertos en tecnología avanzada en UTSC" class="w-full h-80 object-cover rounded-lg shadow-2xl" loading="lazy">
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nuestra Comunidad en Cifras -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Nuestra Comunidad en Cifras</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Miles de estudiantes transformando su futuro con nosotros, respaldados por datos reales y certificaciones globales.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="stats-card text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-4xl font-bold mb-2">4,600+</div>
                    <div class="text-emerald-100">Estudiantes Activos<grok-card data-id="5c389c" data-type="citation_card"></grok-card></div>
                </div>
                <div class="stats-card text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-4xl font-bold mb-2">6</div>
                    <div class="text-emerald-100">Programas Académicos</div>
                </div>
                <div class="stats-card text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-4xl font-bold mb-2">98%</div>
                    <div class="text-emerald-100">Tasa de Satisfacción</div>
                </div>
                <div class="stats-card text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-4xl font-bold mb-2">27</div>
                    <div class="text-emerald-100">Años de Experiencia<grok-card data-id="344f38" data-type="citation_card"></grok-card></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Características Nuevas -->
    <div class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Por Qué Elegir UTSC</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Descubre las características que nos hacen líderes en educación tecnológica.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="feature-card text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-icon bg-gradient-to-r from-emerald-500 to-teal-500 mb-4 mx-auto">
                        <i data-feather="globe" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Aprendizaje Global</h3>
                    <p class="text-gray-600">Accede a contenido internacional y colabora con estudiantes de todo el mundo.</p>
                </div>
                <div class="feature-card text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-icon bg-gradient-to-r from-blue-500 to-indigo-500 mb-4 mx-auto">
                        <i data-feather="shield" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Seguridad Avanzada</h3>
                    <p class="text-gray-600">Plataforma segura con encriptación de datos y protección de privacidad garantizada.</p>
                </div>
                <div class="feature-card text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-icon bg-gradient-to-r from-purple-500 to-pink-500 mb-4 mx-auto">
                        <i data-feather="cpu" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Tecnología de Vanguardia</h3>
                    <p class="text-gray-600">Herramientas de IA y VR para una experiencia inmersiva en el aprendizaje.</p>
                </div>
                <div class="feature-card text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-icon bg-gradient-to-r from-green-500 to-emerald-500 mb-4 mx-auto">
                        <i data-feather="zap" class="w-8 h-8 text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Soporte 24/7</h3>
                    <p class="text-gray-600">Asesores disponibles en cualquier momento para guiarte en tu camino educativo.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Carreras con Efecto Flip Solo en la Imagen -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Nuestras Carreras Destacadas</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Descubre el futuro profesional que te espera con programas actualizados al 2025.</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Carrera 1: Ingeniería en Tecnologías de la Información e Innovación Digital -->
                <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
                    <div class="image-flip-container h-48 relative" role="img" aria-label="Vista de Tecnologías de la Información">
                        <!-- Frente de la imagen -->
                        <div class="image-flip-front absolute inset-0">
                            <img src="./plataforma/app/img/Negocios.jpg" alt="Estudiantes en laboratorio de tecnologías de la información" class="w-full h-full object-cover" loading="lazy">
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <span class="text-white font-semibold">Ver detalles</span>
                            </div>
                        </div>
                        
                        <!-- Parte trasera de la imagen -->
                        <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-800 text-white p-4 flex items-center justify-center">
                            <div class="text-center">
                                <h4 class="font-bold mb-2">Especialidades:</h4>
                                <ul class="text-sm text-blue-100 space-y-1">
                                    <li>• Programación orientada a objetos</li>
                                    <li>• Frameworks y bases de datos</li>
                                    <li>• Desarrollo web y móvil</li>
                                    <li>• Innovación digital</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Tecnología</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Ingeniería en Tecnologías de la Información e Innovación Digital</h3>
                        <p class="text-gray-600">Desarrolla soluciones tecnológicas multiplataforma de software web y móvil utilizando programación orientada a objetos, frameworks y bases de datos.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Duración: 3 años 8 meses</span>
                            <a href="cursos.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                                Más info ›
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Carrera 2: Ingeniería en Mecatrónica -->
                <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="image-flip-container h-48 relative" role="img" aria-label="Vista de Mecatrónica">
                        <!-- Frente de la imagen -->
                        <div class="image-flip-front absolute inset-0">
                            <img src="./plataforma/app/img/CorrecaminosUT.jpg" alt="Estudiantes trabajando en robótica mecatrónica" class="w-full h-full object-cover" loading="lazy">
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <span class="text-white font-semibold">Ver detalles</span>
                            </div>
                        </div>
                        
                        <!-- Parte trasera de la imagen -->
                        <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-green-600 to-green-800 text-white p-4 flex items-center justify-center">
                            <div class="text-center">
                                <h4 class="font-bold mb-2">Especialidades:</h4>
                                <ul class="text-sm text-green-100 space-y-1">
                                    <li>• Mecánica y electrónica</li>
                                    <li>• Informática y automatización</li>
                                    <li>• Sistemas inteligentes</li>
                                    <li>• Control de sistemas</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Ingeniería</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Ingeniería en Mecatrónica</h3>
                        <p class="text-gray-600">Combina elementos de la ingeniería mecánica, la electrónica, la informática y la automatización para diseñar, desarrollar y controlar sistemas inteligentes y automatizados.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Duración: 3 años 8 meses</span>
                            <a href="cursos.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                                Más info ›
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Carrera 3: Ingeniería Industrial -->
                <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="image-flip-container h-48 relative" role="img" aria-label="Vista de Ingeniería Industrial">
                        <!-- Frente de la imagen -->
                        <div class="image-flip-front absolute inset-0">
                            <img src="./plataforma/app/img/IndustrialM.jpg" alt="Estudiantes en procesos industriales" class="w-full h-full object-cover" loading="lazy">
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <span class="text-white font-semibold">Ver detalles</span>
                            </div>
                        </div>
                        
                        <!-- Parte trasera de la imagen -->
                        <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-orange-600 to-orange-800 text-white p-4 flex items-center justify-center">
                            <div class="text-center">
                                <h4 class="font-bold mb-2">Especialidades:</h4>
                                <ul class="text-sm text-orange-100 space-y-1">
                                    <li>• Planeación de operaciones</li>
                                    <li>• Administración de calidad</li>
                                    <li>• Gestión de procesos</li>
                                    <li>• Logística</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <span class="inline-block bg-orange-100 text-orange-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Ingeniería</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Ingeniería Industrial</h3>
                        <p class="text-gray-600">Administra procesos productivos mediante técnicas de planeación y administración de operaciones, cumpliendo estándares de calidad.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Duración: 3 años 8 meses</span>
                            <a href="cursos.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                                Más info ›
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Carrera 4: Ingeniería en Mantenimiento Industrial -->
                <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <div class="image-flip-container h-48 relative" role="img" aria-label="Vista de Mantenimiento Industrial">
                        <!-- Frente de la imagen -->
                        <div class="image-flip-front absolute inset-0">
                            <img src="./plataforma/app/img/mecatronica7.jpg" alt="Técnicos en mantenimiento de sistemas electromecánicos" class="w-full h-full object-cover" loading="lazy">
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <span class="text-white font-semibold">Ver detalles</span>
                            </div>
                        </div>
                        
                        <!-- Parte trasera de la imagen -->
                        <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-purple-600 to-purple-800 text-white p-4 flex items-center justify-center">
                            <div class="text-center">
                                <h4 class="font-bold mb-2">Especialidades:</h4>
                                <ul class="text-sm text-purple-100 space-y-1">
                                    <li>• Mantenimiento predictivo</li>
                                    <li>• Sistemas electromecánicos</li>
                                    <li>• Optimización de procesos</li>
                                    <li>• Eficiencia energética</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Ingeniería</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Ingeniería en Mantenimiento Industrial</h3>
                        <p class="text-gray-600">Optimiza procesos y diseña soluciones innovadoras para liderar el cambio en entornos empresariales, gestionando actividades de mantenimiento y supervisando sistemas electromecánicos.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Duración: 3 años 8 meses</span>
                            <a href="cursos.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                                Más info ›
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Carrera 5: Ingeniería en Electromovilidad -->
                <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="400">
                    <div class="image-flip-container h-48 relative" role="img" aria-label="Vista de Electromovilidad">
                        <!-- Frente de la imagen -->
                        <div class="image-flip-front absolute inset-0">
                            <img src="./plataforma/app/img/CorrecaminosUT.jpg" alt="Vehículos eléctricos en laboratorio de electromovilidad" class="w-full h-full object-cover" loading="lazy">
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <span class="text-white font-semibold">Ver detalles</span>
                            </div>
                        </div>
                        
                        <!-- Parte trasera de la imagen -->
                        <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-red-600 to-red-800 text-white p-4 flex items-center justify-center">
                            <div class="text-center">
                                <h4 class="font-bold mb-2">Especialidades:</h4>
                                <ul class="text-sm text-red-100 space-y-1">
                                    <li>• Sistemas de electromoción</li>
                                    <li>• Baterías y motores</li>
                                    <li>• Proyectos sustentables</li>
                                    <li>• Gestión PEI</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Ingeniería</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Ingeniería en Electromovilidad</h3>
                        <p class="text-gray-600">Desarrolla sistemas de electromoción y gestiona proyectos de electromovilidad con tecnologías sustentables, integrando elementos considerando aspectos técnicos, económicos y normativos.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Duración: 3 años 8 meses</span>
                            <a href="cursos.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                                Más info ›
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="cursos.php" class="inline-flex items-center bg-[var(--ut-green-600)] hover:bg-[var(--ut-green-700)] text-white px-8 py-4 rounded-lg font-semibold transition transform hover:scale-105 shadow-lg" aria-label="Conocer todas las carreras">
                    <i data-feather="book-open" class="mr-3 w-5 h-5"></i>
                    Conoce Todas Nuestras Carreras
                </a>
            </div>
        </div>
    </div>

    <!-- Blog / Noticias Recientes -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <div data-aos="fade-right">
                    <h2 class="text-3xl font-extrabold text-gray-900">Noticias y Actualizaciones</h2>
                    <p class="mt-2 text-lg text-gray-500">Mantente informado sobre lo último en UTSC con contenido fresco del 2025.</p>
                </div>
                <a href="#" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium" data-aos="fade-left" aria-label="Ver todas las noticias">Ver todas →</a>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="news-card bg-white rounded-lg overflow-hidden shadow-md" data-aos="fade-up">
                    <img class="w-full h-48 object-cover" src="./plataforma/app/img/IndustrialM.jpg" alt="Bienvenidos al ciclo escolar 2025 en UTSC" loading="lazy">
                    <div class="p-6">
                        <span class="inline-block bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs font-semibold px-2.5 py-0.5 rounded mb-2">Novedad</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Bienvenidos al Ciclo Escolar 2025</h3>
                        <p class="text-gray-600 mb-4">En nombre de toda la comunidad UTSC, damos la bienvenida a los estudiantes al ciclo septiembre-diciembre 2025.<grok-card data-id="1f52aa" data-type="citation_card"></grok-card></p>
                        <a href="#" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium flex items-center" aria-label="Leer más sobre el ciclo escolar">
                            Leer más
                            <i data-feather="arrow-right" class="ml-1 w-4 h-4"></i>
                        </a>
                    </div>
                </div>
                
                <div class="news-card bg-white rounded-lg overflow-hidden shadow-md" data-aos="fade-up" data-aos-delay="100">
                    <img class="w-full h-48 object-cover" src="./plataforma/app/img/Negocios.jpg" alt="Graduación UTSC 2025" loading="lazy">
                    <div class="p-6">
                        <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">Evento</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Backstage Graduación UTSC 2025</h3>
                        <p class="text-gray-600 mb-4">Celebra con nosotros la graduación de septiembre 2025 y el cierre de un ciclo exitoso.</p>
                        <a href="#" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium flex items-center" aria-label="Leer más sobre la graduación">
                            Leer más
                            <i data-feather="arrow-right" class="ml-1 w-4 h-4"></i>
                        </a>
                    </div>
                </div>
                
                <div class="news-card bg-white rounded-lg overflow-hidden shadow-md" data-aos="fade-up" data-aos-delay="200">
                    <img class="w-full h-48 object-cover" src="./plataforma/app/img/Mecatronica.jpg" alt="Promoción de salud en UTSC" loading="lazy">
                    <div class="p-6">
                        <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">Salud</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Promoviendo Salud y Bienestar</h3>
                        <p class="text-gray-600 mb-4">En UTSC, promovemos la salud, el bienestar y la educación como pilares fundamentales de una comunidad informada y protegida.<grok-card data-id="83b777" data-type="citation_card"></grok-card></p>
                        <a href="#" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium flex items-center" aria-label="Leer más sobre promoción de salud">
                            Leer más
                            <i data-feather="arrow-right" class="ml-1 w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Interactivo -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Explora Nuestro Campus Virtual</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Descubre todo lo que tenemos para ofrecerte con tours interactivos y filtros avanzados.</p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Mapa Interactivo -->
                <div data-aos="fade-right">
                    <div class="campus-map-container bg-white p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Recorrido Virtual por el Campus</h3>
                        <div class="bg-gradient-to-br from-[var(--ut-green-100)] to-emerald-50 h-64 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <i data-feather="map" class="w-12 h-12 text-[var(--ut-green-600)] mx-auto mb-3"></i>
                                <p class="text-gray-600">Haz clic para explorar nuestro campus virtual en 360°</p>
                                <button class="mt-4 bg-[var(--ut-green-600)] hover:bg-[var(--ut-green-700)] text-white px-4 py-2 rounded-md font-medium transition" aria-label="Iniciar recorrido virtual">
                                    Iniciar Recorrido
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Selector de Carreras con Filtro -->
                <div data-aos="fade-left">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Encuentra Tu Carrera Ideal</h3>
                    <div class="space-y-4">
                        <div class="career-selector bg-white p-4 rounded-lg shadow-sm border border-gray-100 cursor-pointer flex items-center transition-all" tabindex="0" role="button" aria-label="Seleccionar Tecnologías de la Información">
                            <div class="w-10 h-10 rounded-full bg-[var(--ut-green-100)] text-[var(--ut-green-700)] flex items-center justify-center mr-4">
                                <i data-feather="cpu" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Tecnologías de la Información</h4>
                                <p class="text-sm text-gray-500">1 programa disponible</p>
                            </div>
                        </div>
                        
                        <div class="career-selector bg-white p-4 rounded-lg shadow-sm border border-gray-100 cursor-pointer flex items-center transition-all" tabindex="0" role="button" aria-label="Seleccionar Ingeniería">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center mr-4">
                                <i data-feather="settings" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Ingeniería</h4>
                                <p class="text-sm text-gray-500">5 programas disponibles</p>
                            </div>
                        </div>
                        
                        <div class="career-selector bg-white p-4 rounded-lg shadow-sm border border-gray-100 cursor-pointer flex items-center transition-all" tabindex="0" role="button" aria-label="Seleccionar Gestión Educativa">
                            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center mr-4">
                                <i data-feather="book-open" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Gestión Educativa</h4>
                                <p class="text-sm text-gray-500">1 programa disponible</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <a href="cursos.php" class="inline-flex items-center text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium" aria-label="Explorar todas las carreras">
                            Explorar todas las carreras
                            <i data-feather="arrow-right" class="ml-2 w-5 h-5"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Video Destacado -->
            <div class="mt-16" data-aos="fade-up">
                <div class="video-container bg-gradient-to-r from-[var(--ut-green-800)] to-[var(--ut-green-900)] p-8 text-white rounded-2xl">
                    <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                        <div>
                            <h3 class="text-2xl font-bold mb-4">Conoce Nuestra Historia</h3>
                            <p class="text-emerald-100 mb-6">Descubre cómo hemos transformado la educación tecnológica durante más de 27 años con innovaciones constantes.<grok-card data-id="19a2c8" data-type="citation_card"></grok-card></p>
                            <a href="registro.php" class="bg-white text-[var(--ut-green-800)] hover:bg-gray-100 px-6 py-3 rounded-md text-lg font-semibold transition inline-block" aria-label="Unirse a UTSC">
                                Únete a Nosotros
                            </a>
                        </div>
                        <div class="mt-6 lg:mt-0 flex justify-center">
                            <div class="relative w-full max-w-md">
                                <div class="bg-black/30 rounded-lg h-48 flex items-center justify-center">
                                    <button class="bg-white/20 hover:bg-white/30 rounded-full p-4 transition" aria-label="Reproducir video de historia">
                                        <i data-feather="play" class="w-10 h-10 text-white"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nuestro Equipo Docente -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Conoce a Nuestros Expertos</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Profesionales con experiencia que guiarán tu aprendizaje con mentorías personalizadas.</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="docente-card text-center" data-aos="fade-up">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-cyan-400 to-emerald-400 mx-auto mb-4 flex items-center justify-center text-white font-bold text-xl" aria-label="Foto de MC. Laura Madrigal">LM</div>
                    <h3 class="text-lg font-bold text-gray-900">MC. Laura Mónica Madrigal González</h3>
                    <p class="text-gray-600 mb-3">Rectora</p>
                    <div class="flex justify-center space-x-1 mb-4">
                        <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs px-2 py-1 rounded" data-tooltip="Liderazgo Educativo">Liderazgo</span>
                        <span class="specialty-chip bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded" data-tooltip="Innovación">Innovación</span>
                    </div>
                    <button class="btn-docente w-full py-2 rounded-md text-sm font-medium transition" aria-label="Ver perfil de MC. Laura Madrigal">Ver Perfil</button>
                </div>
                
                <div class="docente-card text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 mx-auto mb-4 flex items-center justify-center text-white font-bold text-xl" aria-label="Foto de MDP. Yessica Martínez">YM</div>
                    <h3 class="text-lg font-bold text-gray-900">MDP. Yessica J. Martínez Iracheta</h3>
                    <p class="text-gray-600 mb-3">Dirección Académica</p>
                    <div class="flex justify-center space-x-1 mb-4">
                        <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs px-2 py-1 rounded" data-tooltip="Currículo">Currículo</span>
                        <span class="specialty-chip bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded" data-tooltip="Calidad">Calidad</span>
                    </div>
                    <button class="btn-docente w-full py-2 rounded-md text-sm font-medium transition" aria-label="Ver perfil de MDP. Yessica Martínez">Ver Perfil</button>
                </div>
                
                <div class="docente-card text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-amber-400 to-orange-400 mx-auto mb-4 flex items-center justify-center text-white font-bold text-xl" aria-label="Foto de MDP. Beatriz Luna">BL</div>
                    <h3 class="text-lg font-bold text-gray-900">MDP. Beatriz Eugenia Luna Olvera</h3>
                    <p class="text-gray-600 mb-3">Dirección Académica</p>
                    <div class="flex justify-center space-x-1 mb-4">
                        <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs px-2 py-1 rounded" data-tooltip="Innovación Pedagógica">Pedagogía</span>
                        <span class="specialty-chip bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded" data-tooltip="Formación">Formación</span>
                    </div>
                    <button class="btn-docente w-full py-2 rounded-md text-sm font-medium transition" aria-label="Ver perfil de MDP. Beatriz Luna">Ver Perfil</button>
                </div>
                
                <div class="docente-card text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-green-400 to-cyan-400 mx-auto mb-4 flex items-center justify-center text-white font-bold text-xl" aria-label="Foto de Ing. Felipe">IF</div>
                    <h3 class="text-lg font-bold text-gray-900">Ing. Felipe</h3>
                    <p class="text-gray-600 mb-3">Docente de Tecnologías</p>
                    <div class="flex justify-center space-x-1 mb-4">
                        <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs px-2 py-1 rounded" data-tooltip="Python">Python</span>
                        <span class="specialty-chip bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded" data-tooltip="Google Colab">Colab</span>
                    </div>
                    <button class="btn-docente w-full py-2 rounded-md text-sm font-medium transition" aria-label="Ver perfil de Ing. Felipe">Ver Perfil</button>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="docentes.php" class="inline-flex items-center text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium" aria-label="Conocer todo el equipo académico">
                    Conocer todo el equipo académico
                    <i data-feather="arrow-right" class="ml-2 w-5 h-5"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Sección de Testimonios Nueva con Swiper -->
    <div class="bg-white py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Lo Que Dicen Nuestros Estudiantes</h2>
                <p class="mt-4 text-xl text-gray-500">Historias reales de éxito y transformación educativa.</p>
            </div>
            <div class="swiper testimonial-swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testimonial-card text-center mx-4">
                            <div class="w-16 h-16 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                                <i data-feather="quote" class="w-8 h-8 text-white"></i>
                            </div>
                            <p class="text-gray-700 mb-4 italic">"UTSC cambió mi carrera. Los programas son flexibles y los profesores increíbles."</p>
                            <div class="flex items-center justify-center">
                                <div class="w-10 h-10 bg-gray-300 rounded-full mr-3"></div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Estudiante de Mecatrónica</h4>
                                    <p class="text-sm text-gray-500">Egresado 2025</p>
                                </div>
                            </div>
                            <div class="flex justify-center mt-4 space-x-1">
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-card text-center mx-4">
                            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                                <i data-feather="quote" class="w-8 h-8 text-white"></i>
                            </div>
                            <p class="text-gray-700 mb-4 italic">"Excelente plataforma. Obtuve mi certificación y ahora trabajo en una gran empresa tech."</p>
                            <div class="flex items-center justify-center">
                                <div class="w-10 h-10 bg-gray-300 rounded-full mr-3"></div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Egresado de TI</h4>
                                    <p class="text-sm text-gray-500">2024</p>
                                </div>
                            </div>
                            <div class="flex justify-center mt-4 space-x-1">
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-card text-center mx-4">
                            <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                                <i data-feather="quote" class="w-8 h-8 text-white"></i>
                            </div>
                            <p class="text-gray-700 mb-4 italic">"El soporte es inigualable. Recomiendo UTSC a todos mis colegas."</p>
                            <div class="flex items-center justify-center">
                                <div class="w-10 h-10 bg-gray-300 rounded-full mr-3"></div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Estudiante de Industrial</h4>
                                    <p class="text-sm text-gray-500">Actual</p>
                                </div>
                            </div>
                            <div class="flex justify-center mt-4 space-x-1">
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                                <i data-feather="star" class="w-5 h-5 text-yellow-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div style="background:linear-gradient(180deg,var(--ut-green-800),var(--ut-green-900));" class="text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl mb-4">¿Listo para Transformar Tu Futuro?</h2>
                <p class="text-lg text-emerald-100 mb-8 max-w-2xl mx-auto">Únete a nuestra comunidad de más de 4,600 estudiantes que están construyendo el futuro de la tecnología en 2025.<grok-card data-id="5ff4a3" data-type="citation_card"></grok-card></p>
                <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="registro.php" class="bg-white text-[var(--ut-green-800)] hover:bg-gray-100 px-6 py-3 rounded-md text-lg font-semibold transition" aria-label="Crear cuenta gratuita">Crear Cuenta Gratuita</a>
                    <a href="mailto:contacto@utsc.edu.mx" class="border-2 border-white text-white hover:bg-white hover:text-[var(--ut-green-800)] px-6 py-3 rounded-md text-lg font-semibold transition" aria-label="Contactar asesor">Contactar Asesor</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // AOS + Feather con configuración mejorada
        AOS.init({ 
            duration: 800, 
            easing: 'ease-out-cubic',
            once: true,
            offset: 50,
            delay: 50,
            mirror: true,
            disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches
        });
        feather.replace();

        // Inicializar tooltips
        document.addEventListener('DOMContentLoaded', () => {
            // Tooltips para botones y cards
            tippy('[data-tooltip]', {
                placement: 'top',
                arrow: true,
                theme: 'custom',
                animation: 'shift-away',
                duration: [200, 150]
            });
        });

        // Vanta.js background (ahora sobre #inicio)
        if (typeof VANTA !== 'undefined') {
            VANTA.GLOBE({
                el: "#vanta-bg",
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
        }

        // Inicializar Swiper para Hero Carousel
        new Swiper('.hero-swiper', {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            effect: 'fade',
            speed: 800,
            grabCursor: true,
        });

        // Inicializar Swiper para Testimonios
        new Swiper('.testimonial-swiper', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
            spaceBetween: 20,
            speed: 600,
        });

        // Navegación por anclas corregida
        (function () {
          const map = {
            'index.php':   '#inicio',
            'docentes.php':'#docentes',
            'cursos.php':  '#cursos',
            'recursos.php':'#recursos',
            'nosotros.php':'#nosotros'
          };

          document.addEventListener('click', function (e) {
            const a = e.target.closest('a[href]');
            if (!a) return;

            const href = a.getAttribute('href');
            if (!href) return;

            // Ignorar enlaces que ya son anclas o externos
            if (href.startsWith('#') || a.hasAttribute('data-external')) return;

            try {
              const url = new URL(href, window.location.href);

              // Ignorar enlaces a otros dominios
              if (url.origin !== window.location.origin) return;

              // Ignorar enlaces a la plataforma
              if (url.pathname.startsWith('/src/plataforma')) return;

              // Extraer el nombre del archivo
              const pathSegments = url.pathname.split('/');
              const file = pathSegments[pathSegments.length - 1].toLowerCase();

              // Determinar si es la página actual
              const currentPage = window.location.pathname.split('/').pop().toLowerCase();
              const isCurrentPage = file === currentPage || (file === '' && currentPage === '');

              // Obtener el selector de destino
              const targetSel = isCurrentPage ? '#inicio' : map[file];
              if (!targetSel) return;

              // Si estamos en la misma página, hacer scroll a la sección
              if (isCurrentPage) {
                e.preventDefault();
                const target = document.querySelector(targetSel);
                if (target) {
                  target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                  history.pushState(null, '', targetSel);
                }
              }
              // Si no, navegar a la página correspondiente
              else {
                // No prevenir el comportamiento por defecto, dejar que navegue
              }
            } catch (err) { 
              console.error('Error en navegación:', err);
            }
          }, true);
        })();

        // Sistema mejorado de modo oscuro
        (function(){
            const themeToggle = document.getElementById("themeToggle");
            const themeToggleSm = document.getElementById("themeToggleSm");
            const body = document.body;
            const root = document.documentElement;
            
            function applyTheme(isDark) {
                body.classList.toggle('dark', isDark);
                
                const metaThemeColor = document.querySelector('meta[name="theme-color"]');
                if (metaThemeColor) {
                    metaThemeColor.setAttribute('content', isDark ? '#0f172a' : '#ffffff');
                }
                
                const updateButton = (button) => {
                    if (button) {
                        const sunIcon = button.querySelector('.icon-sun');
                        const moonIcon = button.querySelector('.icon-moon');
                        if (sunIcon && moonIcon) {
                            sunIcon.style.transform = isDark ? 'translateY(-100%)' : 'translateY(0)';
                            sunIcon.style.opacity = isDark ? '0' : '1';
                            moonIcon.style.transform = isDark ? 'translateY(0)' : 'translateY(100%)';
                            moonIcon.style.opacity = isDark ? '1' : '0';
                        }
                    }
                };
                
                updateButton(themeToggle);
                updateButton(themeToggleSm);
                
                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
                
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                
                window.dispatchEvent(new CustomEvent('themechange', { detail: { isDark } }));
            }
            
            function initializeTheme() {
                const savedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const shouldBeDark = savedTheme === 'dark' || (!savedTheme && prefersDark);
                
                applyTheme(shouldBeDark);
            }
            
            [themeToggle, themeToggleSm].forEach(button => {
                if (button) {
                    button.addEventListener('click', () => {
                        applyTheme(!body.classList.contains('dark'));
                    });
                }
            });
            
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                if (!localStorage.getItem('theme')) {
                    applyTheme(e.matches);
                }
            });
            
            initializeTheme();
            
            window.themeController = {
                toggle: () => applyTheme(!body.classList.contains('dark')),
                setDark: () => applyTheme(true),
                setLight: () => applyTheme(false),
                isDark: () => body.classList.contains('dark')
            };
        })();
        
        // Interactividad para el selector de carreras
        document.querySelectorAll('.career-selector').forEach(item => {
            const handleSelect = function() {
                document.querySelectorAll('.career-selector').forEach(el => {
                    el.classList.remove('border-[var(--ut-green-500)]', 'bg-[var(--ut-green-50)]', 'ring-2', 'ring-[var(--ut-green-500)]');
                });
                this.classList.add('border-[var(--ut-green-500)]', 'bg-[var(--ut-green-50)]', 'ring-2', 'ring-[var(--ut-green-500)]');
            };
            
            item.addEventListener('click', handleSelect);
            item.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    handleSelect.call(item);
                }
            });
        });

        // Lazy loading para imágenes mejorado
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src || img.src;
                        img.classList.remove('opacity-0');
                        img.classList.add('animate-fade-in');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                img.dataset.src = img.src;
                img.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzIwIiBoZWlnaHQ9IjMyMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjRUVFRUVFIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCwgaGVsdmV0aWNhLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjE0IiBmaWxsPSIjOTk5OTk5IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+TGFkaW5nPC90ZXh0Pjwvc3ZnPg==';
                img.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                imageObserver.observe(img);
            });
        }

        // Service Worker para PWA (básico)
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then(reg => {
                    console.log('SW registered');
                }).catch(err => {
                    console.log('SW registration failed');
                });
            });
        }
    </script>
</body>
</html>