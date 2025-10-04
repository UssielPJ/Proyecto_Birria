<?php
// recursos.php
  // Si se está renderizando dentro de index.php, no repetir navbar/footer
  $__is_embedded = isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) === 'index.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="theme-color" content="#ffffff">
  <meta name="description" content="Recursos Académicos UTSC: Guías, webinars, plantillas y mediateca digital para potenciar tu aprendizaje en ingeniería y tecnología para 2025. Descarga gratuita y contenido exclusivo.">
  <meta name="keywords" content="recursos UTSC, guías tecnologías información, webinars mecatrónica, plantillas industrial, mediateca digital">
  <meta property="og:title" content="Recursos Académicos - UTSC">
  <meta property="og:description" content="Explora nuestra mediateca digital, webinars y guías para impulsar tu carrera tecnológica.">
  <meta property="og:image" content="/src/plataforma/app/img/UT.jpg">
  <meta property="og:url" content="https://utsc.edu.mx/src/recursos.php">
  <title>Recursos Académicos - UTSC | Guías, Webinars y Más para 2025</title>
  <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
  <link rel="canonical" href="https://utsc.edu.mx/src/recursos.php">
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
  <!-- Google Fonts -->
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
    .resource-card {
      background: white;
      border-radius: 1rem;
      box-shadow: 0 10px 22px -10px rgba(0,0,0,.2);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      border: 1px solid rgba(0,0,0,.06);
      overflow: hidden;
    }
    .resource-card:hover {
      transform: translateY(-4px) scale(1.02);
      box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    .resource-tag {
      display: inline-block;
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 500;
      background-color: var(--ut-green-100);
      color: var(--ut-green-800);
      margin: 0.25rem;
      transition: all 0.2s ease;
    }
    .resource-tag:hover {
      transform: scale(1.05);
    }
    .resource-filter {
      cursor: pointer;
      padding: 0.75rem 1.5rem;
      border-radius: 0.75rem;
      transition: all 0.3s ease;
      font-weight: 500;
      background: rgba(255,255,255,0.8);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(0,0,0,0.1);
    }
    .resource-filter:hover,
    .resource-filter.active {
      background-color: var(--ut-green-100);
      color: var(--ut-green-800);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(30,140,81,0.2);
      border-color: var(--ut-green-600);
    }
    .download-btn {
      display: inline-flex;
      align-items: center;
      padding: 0.75rem 1.25rem;
      border-radius: 0.75rem;
      background: linear-gradient(135deg, var(--ut-green-600), var(--ut-green-700));
      color: white;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      font-weight: 600;
      box-shadow: 0 4px 14px rgba(30,140,81,0.3);
    }
    .download-btn:hover {
      background: linear-gradient(135deg, var(--ut-green-700), var(--ut-green-800));
      transform: translateY(-2px) scale(1.02);
      box-shadow: 0 8px 20px rgba(30,140,81,0.4);
    }
    .hero-gradient {
      background: linear-gradient(to bottom, var(--ut-green-800), var(--ut-green-900));
      position: relative;
      overflow: hidden;
    }
    .hero-gradient::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="1"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
      animation: float 20s ease-in-out infinite;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }
    /* Dark mode */
    body.dark {
      background-color: #0f172a;
      color: #f8fafc;
    }
    body.dark .bg-white { 
      background-color: #1e293b !important;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    body.dark .bg-gray-50 { 
      background-color: #0f172a !important;
    }
    body.dark .text-gray-900 { color: #f8fafc !important; }
    body.dark .text-gray-800 { color: #f1f5f9 !important; }
    body.dark .text-gray-700 { color: #e2e8f0 !important; }
    body.dark .text-gray-600 { color: #cbd5e1 !important; }
    body.dark .text-gray-500 { color: #94a3b8 !important; }
    body.dark .resource-card {
      background-color: #1e293b;
      border-color: rgba(255,255,255,0.1);
      box-shadow: 0 10px 24px -12px rgba(0,0,0,0.6);
    }
    body.dark .resource-card:hover {
      box-shadow: 0 20px 40px rgba(0,0,0,0.75);
    }
    body.dark .resource-filter {
      background: rgba(30,41,59,0.8);
      border-color: rgba(255,255,255,0.1);
      color: #d1d5db;
    }
    body.dark .resource-filter:hover,
    body.dark .resource-filter.active {
      background-color: #064e3b;
      color: #86efac;
      border-color: #10b981;
    }
    body.dark .resource-tag {
      background-color: #064e3b;
      color: #86efac;
    }
    body.dark .hero-gradient {
      background: linear-gradient(to bottom, #0f172a, #1e293b);
    }
    body.dark .newsletter-section {
      background-color: #1e293b;
    }
    body.dark .newsletter-section input {
      background-color: #334155;
      border-color: rgba(255,255,255,0.2);
      color: #f8fafc;
    }
    body.dark .newsletter-section input::placeholder {
      color: #94a3b8;
    }
    /* Animaciones */
    .animate-fade-in-up {
      animation: fadeInUp 1s ease-out forwards;
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    /* Responsive */
    @media (max-width: 640px) {
      .resource-filter { flex: 1 1 100%; margin-bottom: 0.5rem; text-align: center; }
    }
  </style>
  <!-- Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    "name": "Recursos Académicos UTSC",
    "description": "Guías, webinars y plantillas para aprendizaje en ingeniería y tecnología.",
    "provider": {
      "@type": "EducationalOrganization",
      "name": "UTSC"
    },
    "mainEntity": [
      {
        "@type": "DigitalDocument",
        "name": "Guía de Tecnologías de la Información",
        "description": "Conceptos fundamentales de TI e innovación digital.",
        "encodingFormat": "application/pdf"
      }
    ]
  }
  </script>
</head>
<body class="bg-gray-50 dark:bg-neutral-900">

  <?php if (!$__is_embedded) include 'navbar.php'; ?>

  <!-- Hero Section -->
  <div class="hero-gradient relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
      <div class="text-center animate-fade-in-up" data-aos="fade-up">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-6 bg-gradient-to-r from-white to-emerald-100 bg-clip-text text-transparent">Recursos Académicos</h1>
        <p class="text-lg md:text-xl text-white/90 max-w-3xl mx-auto leading-relaxed">Material complementario para potenciar tu aprendizaje en ingeniería y tecnología en 2025</p>
      </div>
      
      <!-- Barra de búsqueda -->
      <div class="mt-8 max-w-md mx-auto animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
        <div class="relative">
          <input type="search" placeholder="Buscar recursos por título o categoría..." class="w-full px-4 py-3 pl-12 rounded-full text-gray-900 focus:ring-[var(--ut-green-600)] focus:border-[var(--ut-green-600)] bg-white/90 dark:bg-neutral-800/90 backdrop-blur-sm border border-white/20 dark:border-neutral-600 dark:text-white" id="searchInput">
          <i data-feather="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500 dark:text-gray-400"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Resources Section -->
  <div class="py-16 bg-white dark:bg-neutral-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12 animate-fade-in-up" data-aos="fade-up">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Explora Nuestros Recursos</h2>
        <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">Mediateca digital, webinars, guías y más para tu crecimiento profesional</p>
      </div>

      <!-- Tabs -->
      <div class="mb-10 flex flex-wrap justify-center gap-2 animate-fade-in-up" data-aos="fade-up" id="tabs">
        <button data-filter="*" class="resource-filter active" aria-label="Mostrar todos los recursos">Todos</button>
        <button data-filter="biblioteca" class="resource-filter" aria-label="Mostrar recursos de mediateca">Mediateca</button>
        <button data-filter="webinar" class="resource-filter" aria-label="Mostrar webinars">Webinars</button>
        <button data-filter="guia" class="resource-filter" aria-label="Mostrar guías">Guías</button>
        <button data-filter="plantilla" class="resource-filter" aria-label="Mostrar plantillas">Plantillas</button>
      </div>

      <!-- Grid -->
      <div id="grid" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- 1 Guía: Tecnologías de la Información -->
        <div class="resource-card relative animate-fade-in-up" data-aos="fade-up" data-category="guia">
          <div class="relative h-48 overflow-hidden">
            <img class="w-full h-full object-cover transition-transform duration-300 hover:scale-110" src="https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=640&h=360&fit=crop" alt="Guía de Tecnologías de la Información en UTSC" loading="lazy">
            <span class="resource-tag absolute top-3 left-3">Guía</span>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Guía de Tecnologías de la Información e Innovación Digital</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">Conceptos fundamentales, programación orientada a objetos y desarrollo de software multiplataforma.</p>
            <div class="flex justify-between items-center mb-4">
              <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                <i data-feather="file-text" class="w-4 h-4 mr-1"></i><span>PDF, 80 páginas</span>
              </div>
              <span class="text-sm font-medium text-green-600 dark:text-green-400">Gratis</span>
            </div>
            <a href="#" class="download-btn w-full flex items-center justify-center" aria-label="Descargar guía de TI">
              <i data-feather="download" class="w-4 h-4 mr-2"></i> Descargar
            </a>
          </div>
        </div>

        <!-- 2 Webinar: Google Colab con Python -->
        <div class="resource-card relative animate-fade-in-up" data-aos="fade-up" data-aos-delay="100" data-category="webinar">
          <div class="relative h-48 overflow-hidden">
            <img class="w-full h-full object-cover transition-transform duration-300 hover:scale-110" src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=640&h=360&fit=crop" alt="Webinar Google Colab con Python en UTSC" loading="lazy">
            <span class="resource-tag absolute top-3 left-3 bg-purple-100 text-purple-800">Webinar</span>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Google Colab con Python</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">Introducción práctica a Google Colab y Python para análisis de datos y programación. Impartido por Ing. Felipe.<grok-card data-id="449974" data-type="citation_card"></grok-card></p>
            <div class="flex justify-between items-center mb-4">
              <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                <i data-feather="video" class="w-4 h-4 mr-1"></i><span>1h 30min</span>
              </div>
              <span class="text-sm font-medium text-purple-600 dark:text-purple-400">Gratis</span>
            </div>
            <a href="https://www.facebook.com/centropoeta.utsc/videos/google-colab-con-phyton/828041821811593/" class="download-btn w-full flex items-center justify-center bg-purple-600 hover:bg-purple-700" aria-label="Ver webinar de Google Colab">
              <i data-feather="play" class="w-4 h-4 mr-2"></i> Ver ahora
            </a>
          </div>
        </div>

        <!-- 3 Plantilla: Mecatrónica -->
        <div class="resource-card relative animate-fade-in-up" data-aos="fade-up" data-aos-delay="200" data-category="plantilla">
          <div class="relative h-48 overflow-hidden">
            <img class="w-full h-full object-cover transition-transform duration-300 hover:scale-110" src="https://images.unsplash.com/photo-1581092160562-6486cd53181c?w=640&h=360&fit=crop" alt="Plantilla de Proyectos de Mecatrónica en UTSC" loading="lazy">
            <span class="resource-tag absolute top-3 left-3 bg-yellow-100 text-yellow-800">Plantilla</span>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Plantilla para Proyectos de Mecatrónica</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">Estructura para diseñar sistemas automatizados integrando mecánica, electrónica e informática.</p>
            <div class="flex justify-between items-center mb-4">
              <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                <i data-feather="file" class="w-4 h-4 mr-1"></i><span>Excel, PDF</span>
              </div>
              <span class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Gratis</span>
            </div>
            <a href="#" class="download-btn w-full flex items-center justify-center bg-yellow-500 hover:bg-yellow-600" aria-label="Descargar plantilla de mecatrónica">
              <i data-feather="download" class="w-4 h-4 mr-2"></i> Descargar
            </a>
          </div>
        </div>

        <!-- 4 Mediateca: Ingeniería Industrial -->
        <div class="resource-card relative animate-fade-in-up" data-aos="fade-up" data-category="biblioteca">
          <div class="relative h-48 overflow-hidden">
            <img class="w-full h-full object-cover transition-transform duration-300 hover:scale-110" src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=640&h=360&fit=crop" alt="Recurso de Ingeniería Industrial en Mediateca UTSC" loading="lazy">
            <span class="resource-tag absolute top-3 left-3 bg-blue-100 text-blue-800">Mediateca</span>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Fundamentos de Ingeniería Industrial</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">Material de consulta para planeación de operaciones y estándares de calidad en procesos productivos.</p>
            <div class="flex justify-between items-center mb-4">
              <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                <i data-feather="book" class="w-4 h-4 mr-1"></i><span>ePub, PDF</span>
              </div>
              <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Exclusivo</span>
            </div>
            <a href="https://utsc.edu.mx/mediateca/" class="download-btn w-full flex items-center justify-center bg-blue-600 hover:bg-blue-700" aria-label="Acceder a mediateca industrial">
              <i data-feather="external-link" class="w-4 h-4 mr-2"></i> Acceder
            </a>
          </div>
        </div>

        <!-- 5 Guía: Mantenimiento Industrial -->
        <div class="resource-card relative animate-fade-in-up" data-aos="fade-up" data-aos-delay="100" data-category="guia">
          <div class="relative h-48 overflow-hidden">
            <img class="w-full h-full object-cover transition-transform duration-300 hover:scale-110" src="https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=640&h=360&fit=crop" alt="Guía de Mantenimiento Industrial en UTSC" loading="lazy">
            <span class="resource-tag absolute top-3 left-3">Guía</span>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Guía de Mantenimiento Industrial</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">Estrategias para optimizar sistemas industriales y minimizar tiempos de inactividad.</p>
            <div class="flex justify-between items-center mb-4">
              <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                <i data-feather="file-text" class="w-4 h-4 mr-1"></i><span>PDF, 50 páginas</span>
              </div>
              <span class="text-sm font-medium text-green-600 dark:text-green-400">Gratis</span>
            </div>
            <a href="#" class="download-btn w-full flex items-center justify-center" aria-label="Descargar guía de mantenimiento">
              <i data-feather="download" class="w-4 h-4 mr-2"></i> Descargar
            </a>
          </div>
        </div>

        <!-- 6 Webinar: Electromovilidad -->
        <div class="resource-card relative animate-fade-in-up" data-aos="fade-up" data-aos-delay="200" data-category="webinar">
          <div class="relative h-48 overflow-hidden">
            <img class="w-full h-full object-cover transition-transform duration-300 hover:scale-110" src="https://images.unsplash.com/photo-1502877338535-766e3a6052c0?w=640&h=360&fit=crop" alt="Webinar de Electromovilidad en UTSC" loading="lazy">
            <span class="resource-tag absolute top-3 left-3 bg-purple-100 text-purple-800">Webinar</span>
          </div>
          <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Introducción a la Electromovilidad</h3>
            <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">Tecnologías sustentables y gestión de proyectos en movilidad eléctrica.</p>
            <div class="flex justify-between items-center mb-4">
              <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                <i data-feather="video" class="w-4 h-4 mr-1"></i><span>1h 20min</span>
              </div>
              <span class="text-sm font-medium text-purple-600 dark:text-purple-400">Exclusivo</span>
            </div>
            <a href="#" class="download-btn w-full flex items-center justify-center bg-purple-600 hover:bg-purple-700" aria-label="Ver webinar de electromovilidad">
              <i data-feather="play" class="w-4 h-4 mr-2"></i> Ver ahora
            </a>
          </div>
        </div>
      </div>

      <!-- Paginación Mejorada -->
      <div class="mt-12 flex justify-center animate-fade-in-up" data-aos="fade-up" data-aos-delay="300">
        <nav class="flex items-center space-x-2 bg-white dark:bg-neutral-800 p-2 rounded-lg shadow-md">
          <button class="pagination-btn px-3 py-2 rounded-md bg-gray-200 dark:bg-neutral-700 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-300 dark:hover:bg-neutral-600" aria-label="Página anterior">
            <i data-feather="chevron-left" class="w-5 h-5"></i>
          </button>
          <button class="pagination-btn px-3 py-2 rounded-md bg-[var(--ut-green-600)] text-white font-medium shadow-md" aria-label="Página 1 actual">1</button>
          <button class="pagination-btn px-3 py-2 rounded-md bg-gray-200 dark:bg-neutral-700 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-300 dark:hover:bg-neutral-600" aria-label="Página 2">2</button>
          <button class="pagination-btn px-3 py-2 rounded-md bg-gray-200 dark:bg-neutral-700 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-300 dark:hover:bg-neutral-600" aria-label="Página 3">3</button>
          <button class="pagination-btn px-3 py-2 rounded-md bg-gray-200 dark:bg-neutral-700 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-300 dark:hover:bg-neutral-600" aria-label="Página siguiente">
            <i data-feather="chevron-right" class="w-5 h-5"></i>
          </button>
        </nav>
      </div>
    </div>
  </div>

  <!-- Newsletter -->
  <div class="newsletter-section bg-gray-50 dark:bg-neutral-800 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center animate-fade-in-up" data-aos="fade-up">
        <div class="mb-8 lg:mb-0" data-aos="fade-right">
          <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl mb-4">Recibe nuevos recursos</h2>
          <p class="text-lg text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">Suscríbete para recibir guías exclusivas, webinars y actualizaciones directamente en tu correo.</p>
        </div>
        <div data-aos="fade-left">
          <form class="sm:flex gap-3" id="newsletterForm">
            <input type="email" placeholder="Tu correo electrónico" class="flex-grow px-5 py-3 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-[var(--ut-green-600)] focus:border-[var(--ut-green-600)] border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-neutral-700" required aria-label="Correo para suscripción">
            <button type="submit" class="bg-[var(--ut-green-600)] hover:bg-[var(--ut-green-700)] text-white px-6 py-3 rounded-md text-sm font-semibold transition-all transform hover:scale-105 shadow-md" aria-label="Suscribirse al boletín">Suscribirse</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php if (!$__is_embedded) include 'footer.php'; ?>

  <!-- Scripts -->
  <script>
    // AOS + Feather
    AOS.init({ 
      duration: 800, 
      easing: 'ease-out-cubic',
      once: true,
      offset: 50,
      disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches
    });
    feather.replace();

    // Filtros y búsqueda mejorados
    document.addEventListener('DOMContentLoaded', function() {
      const tabs = document.querySelectorAll('#tabs [data-filter]');
      const cards = document.querySelectorAll('#grid [data-category]');
      const searchInput = document.getElementById('searchInput');

      function filterAndSearch(filter, searchTerm = '') {
        cards.forEach(card => {
          const category = card.dataset.category;
          const title = card.querySelector('h3').textContent.toLowerCase();
          const description = card.querySelector('p').textContent.toLowerCase();

          const matchesCategory = filter === '*' || category === filter;
          const matchesSearch = !searchTerm || title.includes(searchTerm.toLowerCase()) || description.includes(searchTerm.toLowerCase());

          if (matchesCategory && matchesSearch) {
            card.style.display = 'block';
            card.classList.add('animate-fade-in-up');
          } else {
            card.style.display = 'none';
          }
        });
      }

      // Tabs
      tabs.forEach(tab => {
        tab.addEventListener('click', function() {
          tabs.forEach(t => t.classList.remove('active'));
          this.classList.add('active');
          filterAndSearch(this.dataset.filter, searchInput.value);
        });
      });

      // Búsqueda
      searchInput.addEventListener('input', function() {
        const activeFilter = document.querySelector('#tabs .active').dataset.filter;
        filterAndSearch(activeFilter, this.value);
      });

      // Inicializar
      filterAndSearch('*');

      // Newsletter form
      const newsletterForm = document.getElementById('newsletterForm');
      if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
          e.preventDefault();
          alert('¡Gracias por suscribirte! Recibirás actualizaciones pronto.');
          this.reset();
        });
      }

      // Paginación simulada
      document.querySelectorAll('.pagination-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          document.querySelectorAll('.pagination-btn').forEach(b => b.classList.remove('bg-[var(--ut-green-600)]', 'text-white'));
          this.classList.add('bg-[var(--ut-green-600)]', 'text-white');
          console.log('Página seleccionada');
        });
      });

      // Theme integration
      document.addEventListener('themechange', () => {
        feather.replace();
      });
    });
  </script>
</body>
</html>