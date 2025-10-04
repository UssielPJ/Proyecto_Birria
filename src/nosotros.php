<?php
// nosotros.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="UTSC - Nuestra Historia: Más de 15 años formando profesionales en tecnología. Descubre nuestra misión, visión, valores, hitos, campus y logros educativos para 2025.">
    <meta name="keywords" content="UTSC, historia universidad, misión visión, campus UTEC, logros educativos, innovación tecnológica">
    <meta property="og:title" content="UTSC - Nosotros | Historia y Valores Educativos">
    <meta property="og:description" content="Descubre más de 15 años de excelencia en educación tecnológica. Misión, visión, campus y logros de UTSC.">
    <meta property="og:image" content="/src/plataforma/app/img/UT.jpg">
    <meta property="og:url" content="https://utsc.edu/src/nosotros.php">
    <title>UTSC - Nosotros | Historia, Valores y Logros Educativos 2025</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="canonical" href="https://utsc.edu/src/nosotros.php">
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
        .hero-nosotros {
          background: linear-gradient(135deg, var(--ut-green-900) 0%, var(--ut-green-800) 50%, var(--ut-green-700) 100%);
          position: relative;
          overflow: hidden;
        }
        .hero-nosotros::before {
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
        .stats-card {
          background: linear-gradient(135deg, var(--ut-green-700), var(--ut-green-800));
          border-radius: 12px;
          padding: 1.5rem;
          color: white;
          transition: all 0.3s ease;
          position: relative;
          overflow: hidden;
        }
        .stats-card::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          height: 2px;
          background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        }
        .stats-card:hover {
          transform: translateY(-5px);
          box-shadow: 0 20px 40px rgba(23, 37, 42, 0.2);
        }
        .timeline-item {
          position: relative;
          padding-left: 2.5rem;
          margin-bottom: 2.5rem;
        }
        .timeline-item::before {
          content: '';
          position: absolute;
          left: 1rem;
          top: 0;
          width: 2px;
          height: 100%;
          background: linear-gradient(to bottom, var(--ut-green-500), var(--ut-green-300));
        }
        .timeline-dot {
          position: absolute;
          left: 0.75rem;
          top: 0;
          width: 16px;
          height: 16px;
          border-radius: 50%;
          background: var(--ut-green-500);
          border: 3px solid white;
          box-shadow: 0 2px 8px rgba(40, 165, 95, 0.3);
          transition: all 0.3s ease;
        }
        .timeline-item:hover .timeline-dot {
          transform: scale(1.2);
          box-shadow: 0 4px 12px rgba(40, 165, 95, 0.4);
        }
        .value-card {
          transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          border-radius: 16px;
          overflow: hidden;
          background: white;
          box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .value-card:hover {
          transform: translateY(-8px) scale(1.02);
          box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }
        .campus-card {
          transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          border-radius: 16px;
          overflow: hidden;
          background: white;
          box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .campus-card:hover {
          transform: translateY(-8px) scale(1.02);
          box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .campus-card img {
          transition: transform 0.3s ease;
        }
        .campus-card:hover img {
          transform: scale(1.1);
        }
        .gallery-item {
          transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          border-radius: 12px;
          overflow: hidden;
          background: white;
          box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .gallery-item:hover {
          transform: translateY(-5px) scale(1.02);
          box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .gallery-item .icon-container {
          transition: all 0.3s ease;
        }
        .gallery-item:hover .icon-container {
          transform: scale(1.1);
          background: rgba(255,255,255,0.9);
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
        body.dark .stats-card {
            background: linear-gradient(135deg, #065f46, #047857);
        }
        body.dark .value-card,
        body.dark .campus-card,
        body.dark .gallery-item {
            background-color: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        body.dark .value-card:hover,
        body.dark .campus-card:hover,
        body.dark .gallery-item:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }
        body.dark .hero-nosotros {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
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
        @media (max-width: 768px) {
            .timeline-item { padding-left: 1.5rem; }
            .timeline-dot { left: 0.25rem; width: 12px; height: 12px; }
        }
    </style>
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "EducationalOrganization",
      "name": "UTSC",
      "url": "https://utsc.edu",
      "description": "Universidad Tecnológica con más de 15 años de experiencia en educación innovadora.",
      "foundingDate": "2008",
      "numberOfEmployees": {
        "@type": "QuantitativeValue",
        "minValue": 50,
        "maxValue": 100
      },
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Santa Catarina, N.L.",
        "addressCountry": "MX"
      }
    }
    </script>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-white">

<?php include 'navbar.php'; ?>

<!-- Hero Section -->
<section class="hero-nosotros text-white relative overflow-hidden py-20">
  <div class="absolute inset-0 opacity-10">
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-white rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
  </div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="text-center animate-fade-in-up" data-aos="fade-up">
      <h1 class="text-4xl md:text-6xl font-extrabold mb-6 bg-gradient-to-r from-white to-emerald-100 bg-clip-text text-transparent">Nuestra Historia</h1>
      <p class="text-xl md:text-2xl text-emerald-100 max-w-3xl mx-auto leading-relaxed">
        Más de 15 años formando profesionales que transforman el mundo a través de la tecnología y la innovación en 2025.
      </p>
    </div>
  </div>
</section>

<!-- Estadísticas -->
<section class="bg-white dark:bg-neutral-900 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <div class="stats-card text-center animate-fade-in-up" data-aos="fade-up">
        <div class="text-3xl md:text-4xl font-bold mb-2">15+</div>
        <div class="text-emerald-100 text-sm md:text-base">Años de Experiencia</div>
      </div>
      <div class="stats-card text-center animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
        <div class="text-3xl md:text-4xl font-bold mb-2">5,000+</div>
        <div class="text-emerald-100 text-sm md:text-base">Estudiantes Graduados</div>
      </div>
      <div class="stats-card text-center animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
        <div class="text-3xl md:text-4xl font-bold mb-2">25+</div>
        <div class="text-emerald-100 text-sm md:text-base">Programas Académicos</div>
      </div>
      <div class="stats-card text-center animate-fade-in-up" data-aos="fade-up" data-aos-delay="300">
        <div class="text-3xl md:text-4xl font-bold mb-2">50+</div>
        <div class="text-emerald-100 text-sm md:text-base">Convenios Internacionales</div>
      </div>
    </div>
  </div>
</section>

<!-- Misión, Visión y Valores -->
<section class="bg-gray-50 dark:bg-neutral-800 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16 animate-fade-in-up" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Nuestra Esencia</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">Los pilares que nos definen y guían nuestro camino hacia la excelencia en 2025</p>
    </div>
    
    <div class="grid md:grid-cols-3 gap-8">
      <div class="value-card p-8 rounded-xl shadow-lg animate-fade-in-up" data-aos="fade-up">
        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i data-feather="target" class="w-8 h-8 text-blue-600 dark:text-blue-400"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-4">Misión</h3>
        <p class="text-gray-600 dark:text-gray-300 text-center leading-relaxed">
          Formar profesionales de excelencia en el ámbito tecnológico mediante programas educativos innovadores, 
          fomentando el desarrollo integral y el compromiso con la sociedad en la era digital de 2025.
        </p>
      </div>
      
      <div class="value-card p-8 rounded-xl shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
        <div class="w-16 h-16 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i data-feather="eye" class="w-8 h-8 text-green-600 dark:text-green-400"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-4">Visión</h3>
        <p class="text-gray-600 dark:text-gray-300 text-center leading-relaxed">
          Ser la institución líder en educación tecnológica, reconocida por nuestra innovación, 
          calidad académica y contribución al desarrollo sostenible de nuestra región en 2025.
        </p>
      </div>
      
      <div class="value-card p-8 rounded-xl shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
        <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/20 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i data-feather="heart" class="w-8 h-8 text-purple-600 dark:text-purple-400"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-4">Valores</h3>
        <ul class="text-gray-600 dark:text-gray-300 space-y-2 text-center">
          <li class="flex items-center justify-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 dark:text-green-400 mr-2"></i>
            Excelencia académica
          </li>
          <li class="flex items-center justify-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 dark:text-green-400 mr-2"></i>
            Innovación constante
          </li>
          <li class="flex items-center justify-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 dark:text-green-400 mr-2"></i>
            Responsabilidad social
          </li>
          <li class="flex items-center justify-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 dark:text-green-400 mr-2"></i>
            Integridad y ética
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Historia y Línea de Tiempo -->
<section class="bg-white dark:bg-neutral-900 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-2 gap-12 items-start">
      <div data-aos="fade-right">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8 animate-fade-in-up">Nuestra Historia</h2>
        <p class="text-gray-600 dark:text-gray-300 text-lg mb-6 leading-relaxed">
          Fundada en 2008, la Universidad Tecnológica de Santa Catarina inició su trayecto con la visión 
          de revolucionar la educación tecnológica en la región. Desde nuestros humildes comienzos con 
          apenas 3 programas académicos, hemos crecido hasta convertirnos en una institución de referencia 
          con presencia en múltiples campus y alianzas globales.
        </p>
        <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed">
          Nuestro compromiso con la innovación y la excelencia nos ha permitido establecer alianzas 
          estratégicas con empresas líderes en el sector tecnológico, garantizando que nuestros estudiantes 
          reciban una educación de vanguardia que los prepare para los desafíos del futuro en 2025.
        </p>
      </div>
      
      <div data-aos="fade-left">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 animate-fade-in-up">Hitos Importantes</h3>
        <div class="space-y-6">
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">2008 - Fundación</h4>
            <p class="text-gray-600 dark:text-gray-300">Inauguración del primer campus con 3 programas de ingeniería</p>
          </div>
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">2012 - Expansión</h4>
            <p class="text-gray-600 dark:text-gray-300">Apertura del segundo campus y lanzamiento de 5 nuevos programas</p>
          </div>
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">2016 - Internacionalización</h4>
            <p class="text-gray-600 dark:text-gray-300">Establecimiento de los primeros convenios internacionales</p>
          </div>
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up" data-aos-delay="300">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">2020 - Transformación Digital</h4>
            <p class="text-gray-600 dark:text-gray-300">Implementación completa de plataforma e-learning y laboratorios virtuales</p>
          </div>
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up" data-aos-delay="400">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">2024 - Liderazgo</h4>
            <p class="text-gray-600 dark:text-gray-300">Reconocimiento como la universidad tecnológica #1 en innovación educativa</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Ferias y Eventos Educativos -->
<section class="bg-gray-50 dark:bg-neutral-800 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16 animate-fade-in-up" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Participación en Ferias Educativas</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">Mostrando innovación y talento en eventos nacionales e internacionales en 2025</p>
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
      <div class="campus-card rounded-xl shadow-lg overflow-hidden animate-fade-in-up" data-aos="fade-up">
        <img src="./plataforma/app/img/IndustrialM.jpg" alt="Feria Internacional de Tecnología en UTEC" class="w-full h-48 object-cover" loading="lazy">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Feria Internacional de Tecnología</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Participación anual con proyectos innovadores de robótica e inteligencia artificial desarrollados por nuestros estudiantes.</p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">
            <i data-feather="map-pin" class="w-4 h-4 mr-1"></i>
            Ciudad de México
          </div>
        </div>
      </div>
      
      <div class="campus-card rounded-xl shadow-lg overflow-hidden animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
        <img src="./plataforma/app/img/Mecatronica.jpg" alt="Expo Ingeniería Latinoamericana en UTEC" class="w-full h-48 object-cover" loading="lazy">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Expo Ingeniería Latinoamericana</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Showcase de proyectos de mecatrónica y automatización industrial que han recibido reconocimientos internacionales.</p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">
            <i data-feather="map-pin" class="w-4 h-4 mr-1"></i>
            Guadalajara, Jalisco
          </div>
        </div>
      </div>
      
      <div class="campus-card rounded-xl shadow-lg overflow-hidden animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
        <img src="./plataforma/app/img/Negocios.jpg" alt="Foro de Innovación Educativa en UTEC" class="w-full h-48 object-cover" loading="lazy">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Foro de Innovación Educativa</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Presentación de nuestras metodologías de enseñanza disruptivas y casos de éxito de egresados emprendedores.</p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">
            <i data-feather="map-pin" class="w-4 h-4 mr-1"></i>
            Monterrey, N.L.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Campus y Planteles -->
<section class="bg-white dark:bg-neutral-900 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16 animate-fade-in-up" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Nuestros Planteles</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">Infraestructura de vanguardia para una educación de excelencia en 2025</p>
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div class="campus-card rounded-xl shadow-lg overflow-hidden animate-fade-in-up" data-aos="fade-up">
        <img src="./plataforma/app/img/PlantelUT.jpg" alt="Campus Central de UTSC con instalaciones modernas" class="w-full h-48 object-cover" loading="lazy">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Campus Central</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Sede principal con laboratorios especializados, biblioteca digital y áreas de innovación colaborativa.</p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">
            <i data-feather="users" class="w-4 h-4 mr-1"></i>
            2,500+ estudiantes
          </div>
        </div>
      </div>
      
      <div class="campus-card rounded-xl shadow-lg overflow-hidden animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
        <img src="./plataforma/app/img/CorrecaminosUT.jpg" alt="Campus Tecnológico de UTSC enfocado en ingenierías" class="w-full h-48 object-cover" loading="lazy">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Campus Tecnológico</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Especializado en ingenierías avanzadas con talleres de manufactura y prototipado rápido.</p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">
            <i data-feather="users" class="w-4 h-4 mr-1"></i>
            1,800+ estudiantes
          </div>
        </div>
      </div>
      
      <div class="campus-card rounded-xl shadow-lg overflow-hidden animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
        <img src="./plataforma/app/img/Mecatronica.jpg" alt="Campus de Innovación de UTSC para emprendimiento" class="w-full h-48 object-cover" loading="lazy">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Campus de Innovación</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Enfoque en emprendimiento tecnológico y desarrollo de startups estudiantiles con aceleradoras.</p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">
            <i data-feather="users" class="w-4 h-4 mr-1"></i>
            1,200+ estudiantes
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Galería de Logros -->
<section class="bg-gray-50 dark:bg-neutral-800 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16 animate-fade-in-up" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Logros y Reconocimientos</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">El esfuerzo de nuestra comunidad académica reflejado en premios y distinciones en 2025</p>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <div class="gallery-item p-6 rounded-lg text-center shadow-lg animate-fade-in-up" data-aos="fade-up">
        <div class="icon-container w-16 h-16 bg-yellow-100 dark:bg-yellow-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="award" class="w-8 h-8 text-yellow-600 dark:text-yellow-400"></i>
        </div>
        <h4 class="font-semibold text-gray-900 dark:text-white">Premio a la Innovación</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Educativa 2023</p>
      </div>
      
      <div class="gallery-item p-6 rounded-lg text-center shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
        <div class="icon-container w-16 h-16 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="globe" class="w-8 h-8 text-blue-600 dark:text-blue-400"></i>
        </div>
        <h4 class="font-semibold text-gray-900 dark:text-white">Certificación ISO</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">9001:2015</p>
      </div>
      
      <div class="gallery-item p-6 rounded-lg text-center shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
        <div class="icon-container w-16 h-16 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="trending-up" class="w-8 h-8 text-green-600 dark:text-green-400"></i>
        </div>
        <h4 class="font-semibold text-gray-900 dark:text-white">Top 5 Nacional</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">En empleabilidad</p>
      </div>
      
      <div class="gallery-item p-6 rounded-lg text-center shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="300">
        <div class="icon-container w-16 h-16 bg-purple-100 dark:bg-purple-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="star" class="w-8 h-8 text-purple-600 dark:text-purple-400"></i>
        </div>
        <h4 class="font-semibold text-gray-900 dark:text-white">+50 Patentes</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Registradas</p>
      </div>
    </div>
  </div>
</section>

<script>
AOS.init({ 
    duration: 1000, 
    easing: 'ease-out-cubic',
    once: true,
    offset: 50,
    disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches
});
feather.replace();

// Theme integration
document.addEventListener('themechange', () => {
    feather.replace();
});
</script>

<?php include 'footer.php'; ?>
</body>
</html>