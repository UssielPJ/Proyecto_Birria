<?php
// nosotros.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
<<<<<<< HEAD
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="UTSC - Nuestra Historia: Fundada en 1998, más de 27 años formando profesionales en tecnología. Descubre nuestra misión, visión, valores, hitos, campus y logros educativos para 2025.">
    <meta name="keywords" content="UTSC, historia universidad, misión visión, campus UTSC, logros educativos, innovación tecnológica">
    <meta property="og:title" content="UTSC - Nosotros | Historia y Valores Educativos">
    <meta property="og:description" content="Descubre más de 27 años de excelencia en educación tecnológica inclusiva. Misión, visión, campus y logros de UTSC.">
    <meta property="og:image" content="https://utsc.edu.mx/wp-content/uploads/2023/01/UTSC-Logo.png">
    <meta property="og:url" content="https://utsc.edu.mx/src/nosotros.php">
    <title>UTSC - Nosotros | Historia, Valores y Logros Educativos 2025</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="canonical" href="https://utsc.edu.mx/src/nosotros.php">
    <!-- Prevenir flash de tema incorrecto -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                document.body.classList.add('dark');
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
      "name": "Universidad Tecnológica Santa Catarina (UTSC)",
      "url": "https://utsc.edu.mx",
      "description": "Organismo Público descentralizado del Gobierno del Estado de Nuevo León, parte de la Red Nacional de Universidades Tecnológicas. Fundada en 1998 con enfoque en inclusión educativa.",
      "foundingDate": "1998",
      "numberOfEmployees": {
        "@type": "QuantitativeValue",
        "minValue": 50,
        "maxValue": 100
      },
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Carretera Saltillo-Monterrey Km. 61.5",
        "addressLocality": "Santa Catarina, N.L.",
        "postalCode": "66359",
        "addressCountry": "MX"
      }
    }
    </script>
=======
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UTSC - Nosotros</title>
<link rel="icon" type="image/x-icon" href="/static/favicon.ico">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="https://unpkg.com/feather-icons"></script>
<style>
:root{
  --ut-green-900:#0c4f2e;
  --ut-green-800:#12663a;
  --ut-green-700:#177a46;
  --ut-green-600:#1e8c51;
  --ut-green-500:#28a55f;
  --ut-green-100:#e6f6ed;
}

.hero-nosotros {
  background: linear-gradient(135deg, var(--ut-green-900) 0%, var(--ut-green-800) 50%, var(--ut-green-700) 100%);
}
.stats-card {
  background: linear-gradient(135deg, var(--ut-green-700), var(--ut-green-800));
  border-radius: 12px;
  padding: 1.5rem;
  color: white;
}

.timeline-item {
  position: relative;
  padding-left: 2rem;
  margin-bottom: 2rem;
}

.timeline-item::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  width: 3px;
  height: 100%;
  background: var(--ut-green-500);
}

.timeline-dot {
  position: absolute;
  left: -6px;
  top: 0;
  width: 15px;
  height: 15px;
  border-radius: 50%;
  background: var(--ut-green-500);
}

.value-card {
  transition: all 0.3s ease;
  border-radius: 12px;
  overflow: hidden;
}

.value-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.campus-card {
  transition: all 0.3s ease;
  border-radius: 12px;
  overflow: hidden;
}

.campus-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(0,0,0,0.15);
}

.gallery-item {
  transition: all 0.3s ease;
  border-radius: 8px;
  overflow: hidden;
}

.gallery-item:hover {
  transform: scale(1.05);
}

/* NUEVO: Estilos para el apartado deportivo */
.sports-card {
  transition: all 0.3s ease;
  border-radius: 1rem;
  overflow: hidden;
}

.sports-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

/* Modo oscuro base */
body.dark {
  background-color: #111827;
  color: #f3f4f6;
}

/* Ajustes para secciones claras en modo oscuro */
body.dark .bg-white { 
  background-color: #1f2937 !important; 
}

body.dark .bg-gray-50 { 
  background-color: #111827 !important; 
}

body.dark .text-gray-900 { 
  color: #f3f4f6 !important; 
}

body.dark .text-gray-500 { 
  color: #9ca3af !important; 
}

body.dark .text-gray-600 { 
  color: #d1d5db !important; 
}

/* Tarjetas en modo oscuro */
body.dark .value-card,
body.dark .campus-card,
body.dark .gallery-item,
body.dark .sports-card {
  background-color: #1f2937;
  border: 1px solid #374151;
}

body.dark .stats-card {
  background: linear-gradient(135deg, var(--ut-green-800), var(--ut-green-900));
}
</style>
>>>>>>> 3ac172b6db056b2918dcc372299bfbc057cba132
</head>
<body class="font-sans antialiased text-gray-800 dark:text-white">
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
        Fundada en 1998<grok-card data-id="fa38df" data-type="citation_card"></grok-card>, más de 27 años formando profesionales inclusivos que transforman el mundo a través de la tecnología y la innovación en 2025.
<section class="hero-nosotros text-white relative overflow-hidden py-20">
  <div class="absolute inset-0 opacity-10">
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-white rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
  </div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="text-center animate-fade-in-up" data-aos="fade-up">
      <h1 class="text-4xl md:text-6xl font-extrabold mb-6 bg-gradient-to-r from-white to-emerald-100 bg-clip-text text-transparent">Nuestra Historia</h1>
      <p class="text-xl md:text-2xl text-emerald-100 max-w-3xl mx-auto leading-relaxed">
        Fundada en 1998<grok-card data-id="fa38df" data-type="citation_card"></grok-card>, más de 27 años formando profesionales inclusivos que transforman el mundo a través de la tecnología y la innovación en 2025.
      </p>
    </div>
  </div>
</section>

<!-- Estadísticas -->
<section class="bg-white dark:bg-neutral-900 py-16">
<section class="bg-white dark:bg-neutral-900 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <div class="stats-card text-center animate-fade-in-up" data-aos="fade-up">
        <div class="text-3xl md:text-4xl font-bold mb-2">27</div>
        <div class="text-emerald-100 text-sm md:text-base">Años de Experiencia</div>
      <div class="stats-card text-center animate-fade-in-up" data-aos="fade-up">
        <div class="text-3xl md:text-4xl font-bold mb-2">27</div>
        <div class="text-emerald-100 text-sm md:text-base">Años de Experiencia</div>
      </div>
      <div class="stats-card text-center animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
        <div class="text-3xl md:text-4xl font-bold mb-2">4,600+</div>
        <div class="text-emerald-100 text-sm md:text-base">Estudiantes Activos</div>
      <div class="stats-card text-center animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
        <div class="text-3xl md:text-4xl font-bold mb-2">4,600+</div>
        <div class="text-emerald-100 text-sm md:text-base">Estudiantes Activos</div>
      </div>
      <div class="stats-card text-center animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
        <div class="text-3xl md:text-4xl font-bold mb-2">6</div>
        <div class="text-emerald-100 text-sm md:text-base">Programas Académicos</div>
      <div class="stats-card text-center animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
        <div class="text-3xl md:text-4xl font-bold mb-2">6</div>
        <div class="text-emerald-100 text-sm md:text-base">Programas Académicos</div>
      </div>
      <div class="stats-card text-center animate-fade-in-up" data-aos="fade-up" data-aos-delay="300">
        <div class="text-3xl md:text-4xl font-bold mb-2">Múltiples</div>
        <div class="text-emerald-100 text-sm md:text-base">Convenios de Colaboración</div>
      <div class="stats-card text-center animate-fade-in-up" data-aos="fade-up" data-aos-delay="300">
        <div class="text-3xl md:text-4xl font-bold mb-2">Múltiples</div>
        <div class="text-emerald-100 text-sm md:text-base">Convenios de Colaboración</div>
      </div>
    </div>
  </div>
</section>

<!-- Misión, Visión y Valores -->
<section class="bg-gray-50 dark:bg-neutral-800 py-16">
<section class="bg-gray-50 dark:bg-neutral-800 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16 animate-fade-in-up" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Nuestra Esencia</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">Los pilares que nos definen y guían nuestro camino hacia la excelencia inclusiva en 2025</p>
    <div class="text-center mb-16 animate-fade-in-up" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Nuestra Esencia</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">Los pilares que nos definen y guían nuestro camino hacia la excelencia inclusiva en 2025</p>
    </div>
    
    <div class="grid md:grid-cols-3 gap-8">
      <div class="value-card p-8 rounded-xl shadow-lg animate-fade-in-up" data-aos="fade-up">
        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i data-feather="target" class="w-8 h-8 text-blue-600 dark:text-blue-400"></i>
      <div class="value-card p-8 rounded-xl shadow-lg animate-fade-in-up" data-aos="fade-up">
        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i data-feather="target" class="w-8 h-8 text-blue-600 dark:text-blue-400"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-4">Misión</h3>
        <p class="text-gray-600 dark:text-gray-300 text-center leading-relaxed">
          Creemos que la educación debe ser accesible para todos, eliminando barreras y ofreciendo oportunidades para que los estudiantes desarrollen su potencial sin importar su origen o circunstancias.<grok-card data-id="f63395" data-type="citation_card"></grok-card>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-4">Misión</h3>
        <p class="text-gray-600 dark:text-gray-300 text-center leading-relaxed">
          Creemos que la educación debe ser accesible para todos, eliminando barreras y ofreciendo oportunidades para que los estudiantes desarrollen su potencial sin importar su origen o circunstancias.<grok-card data-id="f63395" data-type="citation_card"></grok-card>
        </p>
      </div>
      
      <div class="value-card p-8 rounded-xl shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
        <div class="w-16 h-16 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i data-feather="eye" class="w-8 h-8 text-green-600 dark:text-green-400"></i>
      <div class="value-card p-8 rounded-xl shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
        <div class="w-16 h-16 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i data-feather="eye" class="w-8 h-8 text-green-600 dark:text-green-400"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-4">Visión</h3>
        <p class="text-gray-600 dark:text-gray-300 text-center leading-relaxed">
          Ser una institución de educación superior de calidad que cumpla con las expectativas y necesidades cambiantes de sus estudiantes, capital humano y sociedad.<grok-card data-id="44e041" data-type="citation_card"></grok-card>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-4">Visión</h3>
        <p class="text-gray-600 dark:text-gray-300 text-center leading-relaxed">
          Ser una institución de educación superior de calidad que cumpla con las expectativas y necesidades cambiantes de sus estudiantes, capital humano y sociedad.<grok-card data-id="44e041" data-type="citation_card"></grok-card>
        </p>
      </div>
      
      <div class="value-card p-8 rounded-xl shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
        <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/20 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i data-feather="heart" class="w-8 h-8 text-purple-600 dark:text-purple-400"></i>
      <div class="value-card p-8 rounded-xl shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
        <div class="w-16 h-16 bg-purple-100 dark:bg-purple-900/20 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i data-feather="heart" class="w-8 h-8 text-purple-600 dark:text-purple-400"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-4">Valores</h3>
        <ul class="text-gray-600 dark:text-gray-300 space-y-2 text-center">
          <li class="flex items-center justify-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 dark:text-green-400 mr-2"></i>
            Inclusión<grok-card data-id="0d1b3a" data-type="citation_card"></grok-card>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-4">Valores</h3>
        <ul class="text-gray-600 dark:text-gray-300 space-y-2 text-center">
          <li class="flex items-center justify-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 dark:text-green-400 mr-2"></i>
            Inclusión<grok-card data-id="0d1b3a" data-type="citation_card"></grok-card>
          </li>
          <li class="flex items-center justify-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 dark:text-green-400 mr-2"></i>
            Respeto
          <li class="flex items-center justify-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 dark:text-green-400 mr-2"></i>
            Respeto
          </li>
          <li class="flex items-center justify-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 dark:text-green-400 mr-2"></i>
            Empatía
          <li class="flex items-center justify-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 dark:text-green-400 mr-2"></i>
            Empatía
          </li>
          <li class="flex items-center justify-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 dark:text-green-400 mr-2"></i>
            Colaboración<grok-card data-id="f8f2ce" data-type="citation_card"></grok-card>
          <li class="flex items-center justify-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 dark:text-green-400 mr-2"></i>
            Colaboración<grok-card data-id="f8f2ce" data-type="citation_card"></grok-card>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Historia y Línea de Tiempo -->
<section class="bg-white dark:bg-neutral-900 py-16">
<section class="bg-white dark:bg-neutral-900 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-2 gap-12 items-start">
      <div data-aos="fade-right">
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8 animate-fade-in-up">Nuestra Historia</h2>
        <p class="text-gray-600 dark:text-gray-300 text-lg mb-6 leading-relaxed">
          La Universidad Tecnológica Santa Catarina se creó a partir del decreto Número 98, publicado el 30 de septiembre de 1998<grok-card data-id="905cb3" data-type="citation_card"></grok-card>. Es un Organismo Público descentralizado del Gobierno del Estado de Nuevo León y forma parte de la Red Nacional de Universidades Tecnológicas y Politécnicas de la Secretaría de Educación Pública.
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8 animate-fade-in-up">Nuestra Historia</h2>
        <p class="text-gray-600 dark:text-gray-300 text-lg mb-6 leading-relaxed">
          La Universidad Tecnológica Santa Catarina se creó a partir del decreto Número 98, publicado el 30 de septiembre de 1998<grok-card data-id="905cb3" data-type="citation_card"></grok-card>. Es un Organismo Público descentralizado del Gobierno del Estado de Nuevo León y forma parte de la Red Nacional de Universidades Tecnológicas y Politécnicas de la Secretaría de Educación Pública.
        </p>
        <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed">
          Nuestro compromiso con la innovación y la inclusión nos ha permitido establecer alianzas estratégicas con empresas y organizaciones líderes, garantizando que nuestros estudiantes reciban una educación de vanguardia que los prepare para los desafíos del futuro en 2025.<grok-card data-id="a6fb77" data-type="citation_card"></grok-card>
        <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed">
          Nuestro compromiso con la innovación y la inclusión nos ha permitido establecer alianzas estratégicas con empresas y organizaciones líderes, garantizando que nuestros estudiantes reciban una educación de vanguardia que los prepare para los desafíos del futuro en 2025.<grok-card data-id="a6fb77" data-type="citation_card"></grok-card>
        </p>
      </div>
      
      <div data-aos="fade-left">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 animate-fade-in-up">Hitos Importantes</h3>
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 animate-fade-in-up">Hitos Importantes</h3>
        <div class="space-y-6">
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up">
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">1998 - Fundación</h4>
            <p class="text-gray-600 dark:text-gray-300">Creación por decreto y inicio de construcción del campus en 20 hectáreas. Instalaciones provisionales en Blvd. Díaz Ordaz.<grok-card data-id="d734fb" data-type="citation_card"></grok-card></p>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">1998 - Fundación</h4>
            <p class="text-gray-600 dark:text-gray-300">Creación por decreto y inicio de construcción del campus en 20 hectáreas. Instalaciones provisionales en Blvd. Díaz Ordaz.<grok-card data-id="d734fb" data-type="citation_card"></grok-card></p>
          </div>
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Septiembre 1998 - Inicio Académico</h4>
            <p class="text-gray-600 dark:text-gray-300">Actividades con 116 alumnos y 3 programas TSU: Mecánica, Electrónica y Automatización, Mantenimiento y Procesos.<grok-card data-id="7101e2" data-type="citation_card"></grok-card></p>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Septiembre 1998 - Inicio Académico</h4>
            <p class="text-gray-600 dark:text-gray-300">Actividades con 116 alumnos y 3 programas TSU: Mecánica, Electrónica y Automatización, Mantenimiento y Procesos.<grok-card data-id="7101e2" data-type="citation_card"></grok-card></p>
          </div>
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">2004 - Modelo de Inclusión</h4>
            <p class="text-gray-600 dark:text-gray-300">Implementación del modelo de inclusión educativa y laboral.<grok-card data-id="b70f85" data-type="citation_card"></grok-card></p>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">2004 - Modelo de Inclusión</h4>
            <p class="text-gray-600 dark:text-gray-300">Implementación del modelo de inclusión educativa y laboral.<grok-card data-id="b70f85" data-type="citation_card"></grok-card></p>
          </div>
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up" data-aos-delay="300">
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up" data-aos-delay="300">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">2023 - Centro Microsoft</h4>
            <p class="text-gray-600 dark:text-gray-300">Alianza con The Trust for the Americas como Centro Autorizado Certificador de Microsoft.<grok-card data-id="5430d7" data-type="citation_card"></grok-card></p>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">2023 - Centro Microsoft</h4>
            <p class="text-gray-600 dark:text-gray-300">Alianza con The Trust for the Americas como Centro Autorizado Certificador de Microsoft.<grok-card data-id="5430d7" data-type="citation_card"></grok-card></p>
          </div>
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up" data-aos-delay="400">
          <div class="timeline-item animate-fade-in-up" data-aos="fade-up" data-aos-delay="400">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">2024 - Premios de Reconocimiento</h4>
            <p class="text-gray-600 dark:text-gray-300">Premio por modelo de inclusión y Premio Congruencia en Inclusión Educativa.<grok-card data-id="d72252" data-type="citation_card"></grok-card><grok-card data-id="f34815" data-type="citation_card"></grok-card></p>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">2024 - Premios de Reconocimiento</h4>
            <p class="text-gray-600 dark:text-gray-300">Premio por modelo de inclusión y Premio Congruencia en Inclusión Educativa.<grok-card data-id="d72252" data-type="citation_card"></grok-card><grok-card data-id="f34815" data-type="citation_card"></grok-card></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<<<<<<< HEAD
<!-- Ferias y Eventos Educativos -->
<section class="bg-gray-50 dark:bg-neutral-800 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16 animate-fade-in-up" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Participación en Eventos Educativos</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">Mostrando innovación y talento en eventos nacionales en 2024-2025</p>
=======
<!-- Feria de Proyectos para Futuros Universitarios -->
<section class="bg-gradient-to-br from-green-50 to-emerald-100 py-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
        Feria de Proyectos para 
        <span class="text-green-600">Futuros Universitarios</span>
      </h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">
        Descubre el talento e innovación de nuestros estudiantes en esta exclusiva exhibición académica
      </p>
>>>>>>> 3ac172b6db056b2918dcc372299bfbc057cba132
    </div>

    <!-- Mención Honorífica - Visita del Alcalde Miguel Angel -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-2xl overflow-hidden mb-16" data-aos="zoom-in">
      <div class="md:flex">
        <div class="md:w-2/3 p-8 md:p-12">
          <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center mr-4">
              <i data-feather="award" class="w-6 h-6 text-white"></i>
            </div>
            <span class="text-yellow-300 font-semibold text-lg">MENCIÓN HONORÍFICA</span>
          </div>
          <h3 class="text-3xl font-bold text-white mb-4">
            Visita Distinguida del<br>
            <span class="text-yellow-300">Alcalde Miguel Ángel Salazar Rangel</span>
          </h3>
          <p class="text-green-100 text-lg mb-6">
            Nos honra la presencia del Alcalde Municipal Miguel Ángel Salazar Rangel quien reconoció la excelencia académica 
            y el impacto social de nuestros proyectos estudiantiles.
          </p>
          <div class="flex items-center text-green-200">
            <i data-feather="calendar" class="w-5 h-5 mr-2"></i>
            <span class="font-semibold">24 de Febrero, 2025</span>
          </div>
        </div>
        
        <!-- Carrusel en la parte amarilla -->
        <div class="md:w-1/3 bg-gradient-to-br from-yellow-400 to-yellow-500 p-4">
          <div class="carousel-container relative h-full rounded-xl overflow-hidden">
            <!-- Imágenes del carrusel -->
            <div class="carousel-slides flex transition-transform duration-500 ease-in-out">
              <div class="carousel-slide flex-shrink-0 w-full">
                <img src="../src/plataforma/app/img/Alcalde.jpg" alt="Alcalde Miguel Angel en la feria" class="w-full h-48 object-cover rounded-lg">
                <p class="text-white text-center text-sm mt-2 font-semibold">Recorrido por los stands</p>
              </div>
              <div class="carousel-slide flex-shrink-0 w-full">
                <img src="./plataforma/app/img/AlcaldeFeria.jpg" alt="Alcalde con estudiantes" class="w-full h-48 object-cover rounded-lg">
                <p class="text-white text-center text-sm mt-2 font-semibold">Con nuestros estudiantes</p>
              </div>
              <div class="carousel-slide flex-shrink-0 w-full">
                <img src="./plataforma/app/img/AlcaldeExplanada.jpg" alt="Reconocimiento oficial" class="w-full h-48 object-cover rounded-lg">
                <p class="text-white text-center text-sm mt-2 font-semibold">Reccorido por la universidad</p>
              </div>
            </div>
            
            <!-- Controles del carrusel -->
            <button class="carousel-prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-yellow-600 w-8 h-8 rounded-full flex items-center justify-center transition-all">
              <i data-feather="chevron-left" class="w-5 h-5"></i>
            </button>
            <button class="carousel-next absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-yellow-600 w-8 h-8 rounded-full flex items-center justify-center transition-all">
              <i data-feather="chevron-right" class="w-5 h-5"></i>
            </button>
            
            <!-- Indicadores -->
            <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-2">
              <div class="carousel-indicator w-2 h-2 bg-white/80 rounded-full cursor-pointer"></div>
              <div class="carousel-indicator w-2 h-2 bg-white/80 rounded-full cursor-pointer"></div>
              <div class="carousel-indicator w-2 h-2 bg-white/80 rounded-full cursor-pointer"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Proyectos Destacados -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
<<<<<<< HEAD
      <div class="campus-card rounded-xl shadow-lg overflow-hidden animate-fade-in-up" data-aos="fade-up">
        <img src="https://via.placeholder.com/400x300?text=Feria+Empleo+2025" alt="Feria del Empleo UTSC 2025" class="w-full h-48 object-cover" loading="lazy">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Feria del Empleo UTSC 2025</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Evento para conectar estudiantes con 56 empresas e instituciones, fomentando empleabilidad y emprendimiento.<grok-card data-id="09cefc" data-type="citation_card"></grok-card><grok-card data-id="e64b9a" data-type="citation_card"></grok-card></p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">
            <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
            2025
=======
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300" data-aos="fade-up">
        <div class="relative">
          <img src="./plataforma/app/img/IndustrialM.jpg" alt="Feria Tecnológica" class="w-full h-48 object-cover">
          <div class="absolute top-4 right-4 bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
            Innovación
          </div>
        </div>
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-3">Proyectos de Tecnología Avanzada</h3>
          <p class="text-gray-600 mb-4">Soluciones innovadoras en robótica, IoT y inteligencia artificial desarrolladas por nuestros futuros ingenieros.</p>
          <div class="flex items-center justify-between">
            <div class="flex items-center text-sm text-gray-500">
              <i data-feather="users" class="w-4 h-4 mr-1"></i>
              Ingeniería
            </div>
            <button class="text-green-600 hover:text-green-700 font-medium text-sm flex items-center gap-1">
              Ver Proyecto
              <i data-feather="arrow-right" class="w-4 h-4"></i>
            </button>
>>>>>>> 3ac172b6db056b2918dcc372299bfbc057cba132
          </div>
        </div>
      </div>
      
<<<<<<< HEAD
      <div class="campus-card rounded-xl shadow-lg overflow-hidden animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
        <img src="https://via.placeholder.com/400x300?text=V+Foro+de+Inclusión" alt="V Foro de Inclusión 2024" class="w-full h-48 object-cover" loading="lazy">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">V Foro de Inclusión 2024</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Inaugurado por el Secretario General de Gobierno, destacando el liderazgo de UTSC en inclusión educativa.<grok-card data-id="d12527" data-type="citation_card"></grok-card></p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">
            <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
            2024
=======
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
        <div class="relative">
          <img src="./plataforma/app/img/Mecatronica.jpg" alt="Expo Ingeniería" class="w-full h-48 object-cover">
          <div class="absolute top-4 right-4 bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
            Ingeniería
          </div>
        </div>
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-3">Mecatrónica y Automatización</h3>
          <p class="text-gray-600 mb-4">Sistemas automatizados y robots industriales creados por estudiantes de mecatrónica.</p>
          <div class="flex items-center justify-between">
            <div class="flex items-center text-sm text-gray-500">
              <i data-feather="cpu" class="w-4 h-4 mr-1"></i>
              Mecatrónica
            </div>
            <button class="text-green-600 hover:text-green-700 font-medium text-sm flex items-center gap-1">
              Ver Proyecto
              <i data-feather="arrow-right" class="w-4 h-4"></i>
            </button>
>>>>>>> 3ac172b6db056b2918dcc372299bfbc057cba132
          </div>
        </div>
      </div>
      
<<<<<<< HEAD
      <div class="campus-card rounded-xl shadow-lg overflow-hidden animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
        <img src="https://via.placeholder.com/400x300?text=Encuentro+Regional+2024" alt="Encuentro Regional Deportivo y Cultural 2024" class="w-full h-48 object-cover" loading="lazy">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Encuentro Regional Deportivo y Cultural</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Tercer lugar regional para nuestros Correcaminos en el ERDCUTyP 2024, destacando disciplina y talento.<grok-card data-id="352def" data-type="citation_card"></grok-card></p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">
            <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
            2024
=======
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
        <div class="relative">
          <img src="./plataforma/app/img/Negocios.jpg" alt="Foro de Innovación" class="w-full h-48 object-cover">
          <div class="absolute top-4 right-4 bg-purple-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
            Emprendimiento
>>>>>>> 3ac172b6db056b2918dcc372299bfbc057cba132
          </div>
        </div>
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Encuentro Regional Deportivo y Cultural</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Tercer lugar regional para nuestros Correcaminos en el ERDCUTyP 2024, destacando disciplina y talento.<grok-card data-id="352def" data-type="citation_card"></grok-card></p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">
            <i data-feather="calendar" class="w-4 h-4 mr-1"></i>
            2024
          </div>
        </div>
      </div>
    </div>

    <!-- CTA para Preparatorias -->
    <div class="text-center" data-aos="fade-up">
      <div class="bg-white rounded-2xl shadow-lg p-8 max-w-4xl mx-auto">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">¿Eres de Preparatoria?</h3>
        <p class="text-gray-600 mb-6 text-lg">
          Agenda una visita guiada y descubre cómo puedes formar parte de nuestra comunidad universitaria
        </p>
        <button class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-semibold text-lg transition-colors duration-300 flex items-center gap-2 mx-auto">
          <i data-feather="calendar" class="w-5 h-5"></i>
          Agendar Visita
        </button>
      </div>
    </div>
  </div>
</section>

<style>
.carousel-container {
  height: 280px;
}

.carousel-slides {
  width: 300%;
}

.carousel-slide {
  width: 33.333%;
  padding: 0 8px;
}

.carousel-prev:hover, .carousel-next:hover {
  background: white !important;
  transform: scale(1.1);
}

.carousel-indicator.active {
  background: white;
  transform: scale(1.2);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const carouselSlides = document.querySelector('.carousel-slides');
  const prevButton = document.querySelector('.carousel-prev');
  const nextButton = document.querySelector('.carousel-next');
  const indicators = document.querySelectorAll('.carousel-indicator');
  let currentSlide = 0;
  const totalSlides = 3;

  function updateCarousel() {
    carouselSlides.style.transform = `translateX(-${currentSlide * 33.333}%)`;
    indicators.forEach((indicator, index) => {
      indicator.classList.toggle('active', index === currentSlide);
    });
  }

  nextButton.addEventListener('click', () => {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
  });

  prevButton.addEventListener('click', () => {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateCarousel();
  });

  indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => {
      currentSlide = index;
      updateCarousel();
    });
  });

  // Auto-advance cada 5 segundos
  setInterval(() => {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
  }, 5000);

  // Inicializar primer indicador como activo
  indicators[0].classList.add('active');
});
</script>

<!-- Campus y Planteles -->
<section class="bg-white dark:bg-neutral-900 py-16">
<section class="bg-white dark:bg-neutral-900 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16 animate-fade-in-up" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Nuestro Campus Principal</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">Infraestructura de vanguardia en Santa Catarina, N.L., para una educación de excelencia en 2025</p>
    <div class="text-center mb-16 animate-fade-in-up" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Nuestro Campus Principal</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">Infraestructura de vanguardia en Santa Catarina, N.L., para una educación de excelencia en 2025</p>
    </div>
    
<<<<<<< HEAD
    <div class="grid md:grid-cols-1 gap-8">
      <div class="campus-card rounded-xl shadow-lg overflow-hidden animate-fade-in-up" data-aos="fade-up">
        <img src="https://via.placeholder.com/800x400?text=Campus+UTSC+Santa+Catarina" alt="Campus Principal de UTSC en Carretera Saltillo-Monterrey Km. 61.5" class="w-full h-64 object-cover" loading="lazy">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Campus UTSC - Santa Catarina</h3>
          <p class="text-gray-600 dark:text-gray-300 mb-4">Ubicado en Carretera Saltillo-Monterrey Km. 61.5, C.P. 66359, con 20 hectáreas de terreno. Incluye laboratorios especializados, biblioteca digital y áreas de innovación colaborativa.<grok-card data-id="90f5c4" data-type="citation_card"></grok-card><grok-card data-id="c841ed" data-type="citation_card"></grok-card></p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">
            <i data-feather="users" class="w-4 h-4 mr-1"></i>
            4,600+ estudiantes
=======
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Campus Central -->
      <div class="campus-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
        <img src="./plataforma/app/img/PlantelUT.jpg" alt="Campus Central" class="w-full h-48 object-cover">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-2">Campus Central</h3>
          <p class="text-gray-600 mb-4">Sede principal con laboratorios especializados, biblioteca digital y áreas de innovación.</p>
          <div class="flex items-center justify-between">
            <div class="flex items-center text-sm text-[var(--ut-green-700)]">
              <i data-feather="users" class="w-4 h-4 mr-1"></i>
              2,500+ estudiantes
            </div>
            <button class="conocer-mas-btn bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors" data-campus="central">
              Conocer más
            </button>
          </div>
        </div>
      </div>
      
      <!-- Campus Tecnológico -->
      <div class="campus-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <img src="./plataforma/app/img/CorrecaminosUT.jpg" alt="Campus Norte" class="w-full h-48 object-cover">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-2">Campus Tecnológico</h3>
          <p class="text-gray-600 mb-4">Especializado en ingenierías avanzadas con talleres de manufactura y prototipado.</p>
          <div class="flex items-center justify-between">
            <div class="flex items-center text-sm text-[var(--ut-green-700)]">
              <i data-feather="users" class="w-4 h-4 mr-1"></i>
              1,800+ estudiantes
            </div>
            <button class="conocer-mas-btn bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors" data-campus="tecnologico">
              Conocer más
            </button>
          </div>
        </div>
      </div>
      
      <!-- Campus de Innovación -->
      <div class="campus-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
        <img src="./plataforma/app/img/Mecatronica.jpg" alt="Campus Sur" class="w-full h-48 object-cover">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-2">Campus de Innovación</h3>
          <p class="text-gray-600 mb-4">Enfoque en emprendimiento tecnológico y desarrollo de startups estudiantiles.</p>
          <div class="flex items-center justify-between">
            <div class="flex items-center text-sm text-[var(--ut-green-700)]">
              <i data-feather="users" class="w-4 h-4 mr-1"></i>
              1,200+ estudiantes
            </div>
            <button class="conocer-mas-btn bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors" data-campus="innovacion">
              Conocer más
            </button>
>>>>>>> 3ac172b6db056b2918dcc372299bfbc057cba132
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal para mostrar las fotos -->
<div id="campusModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden">
    <!-- Header del modal -->
    <div class="flex justify-between items-center p-6 border-b border-gray-200">
      <h3 id="modalTitle" class="text-2xl font-bold text-gray-900">Campus Central</h3>
      <button id="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
        <i data-feather="x" class="w-6 h-6"></i>
      </button>
    </div>
    
    <!-- Carrusel de fotos -->
    <div class="relative">
      <div id="carouselSlides" class="flex transition-transform duration-500 ease-in-out">
        <!-- Las imágenes se cargarán dinámicamente -->
      </div>
      
      <!-- Controles del carrusel -->
      <button id="carouselPrev" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all">
        <i data-feather="chevron-left" class="w-6 h-6"></i>
      </button>
      <button id="carouselNext" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all">
        <i data-feather="chevron-right" class="w-6 h-6"></i>
      </button>
      
      <!-- Indicadores -->
      <div id="carouselIndicators" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
        <!-- Los indicadores se generarán dinámicamente -->
      </div>
    </div>
    
    <!-- Información adicional -->
    <div class="p-6 bg-gray-50">
      <p id="modalDescription" class="text-gray-600 mb-4"></p>
      <div class="flex items-center text-sm text-gray-500">
        <i data-feather="info" class="w-4 h-4 mr-2"></i>
        <span>Desliza para ver más fotos del campus</span>
      </div>
    </div>
  </div>
</div>

<style>
#campusModal .carousel-slide {
  min-width: 100%;
  transition: transform 0.5s ease-in-out;
}

#carouselSlides {
  width: 100%;
}

.carousel-indicator {
  width: 10px;
  height: 10px;
  background-color: rgba(255, 255, 255, 0.5);
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.3s ease;
}

.carousel-indicator.active {
  background-color: white;
  transform: scale(1.2);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('campusModal');
  const closeModal = document.getElementById('closeModal');
  const conocerMasBtns = document.querySelectorAll('.conocer-mas-btn');
  const modalTitle = document.getElementById('modalTitle');
  const modalDescription = document.getElementById('modalDescription');
  const carouselSlides = document.getElementById('carouselSlides');
  const carouselIndicators = document.getElementById('carouselIndicators');
  const carouselPrev = document.getElementById('carouselPrev');
  const carouselNext = document.getElementById('carouselNext');
  
  let currentSlide = 0;
  let currentCampus = '';
  
  // Datos de cada campus (aquí defines las imágenes de cada uno)
  const campusData = {
    central: {
      title: 'Campus Central',
      description: 'Sede principal con laboratorios especializados, biblioteca digital y áreas de innovación. Más de 2,500 estudiantes.',
      images: [
        './plataforma/app/img/central1.jpg',
        './plataforma/app/img/central2.jpg',
        './plataforma/app/img/central3.jpg'
      ]
    },
    tecnologico: {
      title: 'Campus Tecnológico',
      description: 'Especializado en ingenierías avanzadas con talleres de manufactura y prototipado. Más de 1,800 estudiantes.',
      images: [
        './plataforma/app/img/tecnologico1.jpg',
        './plataforma/app/img/tecnologico2.jpg',
        './plataforma/app/img/tecnologico3.jpg'
      ]
    },
    innovacion: {
      title: 'Campus de Innovación',
      description: 'Enfoque en emprendimiento tecnológico y desarrollo de startups estudiantiles. Más de 1,200 estudiantes.',
      images: [
        './plataforma/app/img/innovacion1.jpg',
        './plataforma/app/img/innovacion2.jpg',
        './plataforma/app/img/innovacion3.jpg'
      ]
    }
  };
  
  // Abrir modal
  conocerMasBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      currentCampus = this.getAttribute('data-campus');
      openModal(currentCampus);
    });
  });
  
  // Cerrar modal
  closeModal.addEventListener('click', closeModalFunc);
  
  // Cerrar modal al hacer clic fuera
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      closeModalFunc();
    }
  });
  
  // Controles del carrusel
  carouselPrev.addEventListener('click', showPrevSlide);
  carouselNext.addEventListener('click', showNextSlide);
  
  function openModal(campus) {
    const data = campusData[campus];
    modalTitle.textContent = data.title;
    modalDescription.textContent = data.description;
    
    // Limpiar carrusel anterior
    carouselSlides.innerHTML = '';
    carouselIndicators.innerHTML = '';
    
    // Cargar nuevas imágenes
    data.images.forEach((image, index) => {
      const slide = document.createElement('div');
      slide.className = 'carousel-slide';
      slide.innerHTML = `<img src="${image}" alt="${data.title} - Foto ${index + 1}" class="w-full h-96 object-cover">`;
      carouselSlides.appendChild(slide);
      
      const indicator = document.createElement('div');
      indicator.className = `carousel-indicator ${index === 0 ? 'active' : ''}`;
      indicator.addEventListener('click', () => showSlide(index));
      carouselIndicators.appendChild(indicator);
    });
    
    currentSlide = 0;
    updateCarousel();
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }
  
  function closeModalFunc() {
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
  }
  
  function showPrevSlide() {
    currentSlide = (currentSlide - 1 + campusData[currentCampus].images.length) % campusData[currentCampus].images.length;
    updateCarousel();
  }
  
  function showNextSlide() {
    currentSlide = (currentSlide + 1) % campusData[currentCampus].images.length;
    updateCarousel();
  }
  
  function showSlide(index) {
    currentSlide = index;
    updateCarousel();
  }
  
  function updateCarousel() {
    carouselSlides.style.transform = `translateX(-${currentSlide * 100}%)`;
    
    // Actualizar indicadores
    const indicators = carouselIndicators.querySelectorAll('.carousel-indicator');
    indicators.forEach((indicator, index) => {
      indicator.classList.toggle('active', index === currentSlide);
    });
  }
  
  // Cerrar con ESC
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
      closeModalFunc();
    }
  });
});
</script>

<!-- Tradición Deportiva UTSC -->
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Tradición Deportiva</h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Formando atletas de excelencia con valores universitarios</p>
        </div>
        
        <div class="grid lg:grid-cols-2 gap-12 mb-16">
           <!-- Selección de Fútbol -->
<div class="sports-card bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-right">
    <div class="relative h-64">
        <img src="./plataforma/app/img/SeleccionUT.jpg" alt="Selección de Fútbol" class="w-full h-64 object-cover">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute bottom-4 left-6">
            <h3 class="text-2xl font-bold text-white">Selección de Fútbol</h3>
            <p class="text-green-200">Representación Masculina</p>
        </div>
        <div class="absolute top-4 right-6">
            <div class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1">
                <span class="text-white text-sm font-semibold">ACTIVO</span>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-3 gap-4 mb-6 text-center">
            <div>
                <div class="text-2xl font-bold text-green-600">15</div>
                <div class="text-sm text-gray-600">Jugadores</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-green-600">3</div>
                <div class="text-sm text-gray-600">Torneos</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-green-600">2022</div>
                <div class="text-sm text-gray-600">Campeones</div>
            </div>
        </div>
        
        <p class="text-gray-600 mb-4">
            Nuestra selección de fútbol representa los valores de disciplina, trabajo en equipo y excelencia deportiva en cada competencia interuniversitaria.
        </p>
        
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-feather="calendar" class="w-4 h-4 text-green-600"></i>
                <span class="text-sm text-gray-600">Entrenamientos: Lunes y Miércoles</span>
            </div>
            <button class="text-green-600 hover:text-green-700 font-medium text-sm flex items-center gap-1">
                Ver Galería
                <i data-feather="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>

<!-- Equipo de Tochito Femenino -->
<div class="sports-card bg-white rounded-2xl shadow-lg overflow-hidden" data-aos="fade-left">
    <div class="relative h-64">
        <img src="./plataforma/app/img/SeleccionTocho.jpg" alt="Tochito Femenino" class="w-full h-64 object-cover">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="absolute bottom-4 left-6">
            <h3 class="text-2xl font-bold text-white">Tochito Femenino</h3>
            <p class="text-purple-200">Representación Femenina</p>
        </div>
        <div class="absolute top-4 right-6">
            <div class="bg-white/20 backdrop-blur-sm rounded-full px-3 py-1">
                <span class="text-white text-sm font-semibold">ACTIVO</span>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-3 gap-4 mb-6 text-center">
            <div>
                <div class="text-2xl font-bold text-purple-600">12</div>
                <div class="text-sm text-gray-600">Jugadoras</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-purple-600">2</div>
                <div class="text-sm text-gray-600">Torneos</div>
            </div>
            <div>
                <div class="text-2xl font-bold text-purple-600">2023</div>
                <div class="text-sm text-gray-600">Subcampeonas</div>
            </div>
        </div>
        
        <p class="text-gray-600 mb-4">
            El equipo de tochito femenino demuestra fuerza, estrategia y empoderamiento, rompiendo barreras en el deporte universitario.
        </p>
        
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-feather="calendar" class="w-4 h-4 text-purple-600"></i>
                <span class="text-sm text-gray-600">Entrenamientos: Martes y Jueves</span>
            </div>
            <button class="text-purple-600 hover:text-purple-700 font-medium text-sm flex items-center gap-1">
                Ver Galería
                <i data-feather="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>

        <!-- Logros Deportivos -->
        <div class="bg-white rounded-2xl shadow-lg p-8" data-aos="fade-up">
            <h3 class="text-2xl font-bold text-gray-900 text-center mb-8">Logros Destacados</h3>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center p-4">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-feather="award" class="w-8 h-8 text-yellow-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Campeonato 2022</h4>
                    <p class="text-sm text-gray-600">Liga Interuniversitaria de Fútbol</p>
                </div>
                <div class="text-center p-4">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-feather="star" class="w-8 h-8 text-purple-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">Subcampeonato 2023</h4>
                    <p class="text-sm text-gray-600">Torneo Nacional de Tochito</p>
                </div>
                <div class="text-center p-4">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-feather="users" class="w-8 h-8 text-green-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900">+50 Atletas</h4>
                    <p class="text-sm text-gray-600">Formados en nuestros equipos</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Galería de Logros -->
<section class="bg-gray-50 dark:bg-neutral-800 py-16">
<section class="bg-gray-50 dark:bg-neutral-800 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16 animate-fade-in-up" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Logros y Reconocimientos</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">El esfuerzo de nuestra comunidad académica reflejado en premios y distinciones en 2025</p>
    <div class="text-center mb-16 animate-fade-in-up" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Logros y Reconocimientos</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">El esfuerzo de nuestra comunidad académica reflejado en premios y distinciones en 2025</p>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <div class="gallery-item p-6 rounded-lg text-center shadow-lg animate-fade-in-up" data-aos="fade-up">
        <div class="icon-container w-16 h-16 bg-yellow-100 dark:bg-yellow-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="award" class="w-8 h-8 text-yellow-600 dark:text-yellow-400"></i>
      <div class="gallery-item p-6 rounded-lg text-center shadow-lg animate-fade-in-up" data-aos="fade-up">
        <div class="icon-container w-16 h-16 bg-yellow-100 dark:bg-yellow-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="award" class="w-8 h-8 text-yellow-600 dark:text-yellow-400"></i>
        </div>
        <h4 class="font-semibold text-gray-900 dark:text-white">Premio por Modelo de Inclusión</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">1er Lugar 2024<grok-card data-id="70494f" data-type="citation_card"></grok-card></p>
        <h4 class="font-semibold text-gray-900 dark:text-white">Premio por Modelo de Inclusión</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">1er Lugar 2024<grok-card data-id="70494f" data-type="citation_card"></grok-card></p>
      </div>
      
      <div class="gallery-item p-6 rounded-lg text-center shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
        <div class="icon-container w-16 h-16 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="globe" class="w-8 h-8 text-blue-600 dark:text-blue-400"></i>
      <div class="gallery-item p-6 rounded-lg text-center shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="100">
        <div class="icon-container w-16 h-16 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="globe" class="w-8 h-8 text-blue-600 dark:text-blue-400"></i>
        </div>
        <h4 class="font-semibold text-gray-900 dark:text-white">Centro Microsoft Certificado</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Reconocimiento 2023<grok-card data-id="5cc7cf" data-type="citation_card"></grok-card></p>
        <h4 class="font-semibold text-gray-900 dark:text-white">Centro Microsoft Certificado</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Reconocimiento 2023<grok-card data-id="5cc7cf" data-type="citation_card"></grok-card></p>
      </div>
      
      <div class="gallery-item p-6 rounded-lg text-center shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
        <div class="icon-container w-16 h-16 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="trending-up" class="w-8 h-8 text-green-600 dark:text-green-400"></i>
      <div class="gallery-item p-6 rounded-lg text-center shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="200">
        <div class="icon-container w-16 h-16 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="trending-up" class="w-8 h-8 text-green-600 dark:text-green-400"></i>
        </div>
        <h4 class="font-semibold text-gray-900 dark:text-white">Premio Congruencia</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Inclusión Educativa 2024<grok-card data-id="cc6fe9" data-type="citation_card"></grok-card></p>
        <h4 class="font-semibold text-gray-900 dark:text-white">Premio Congruencia</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Inclusión Educativa 2024<grok-card data-id="cc6fe9" data-type="citation_card"></grok-card></p>
      </div>
      
      <div class="gallery-item p-6 rounded-lg text-center shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="300">
        <div class="icon-container w-16 h-16 bg-purple-100 dark:bg-purple-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="star" class="w-8 h-8 text-purple-600 dark:text-purple-400"></i>
      <div class="gallery-item p-6 rounded-lg text-center shadow-lg animate-fade-in-up" data-aos="fade-up" data-aos-delay="300">
        <div class="icon-container w-16 h-16 bg-purple-100 dark:bg-purple-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="star" class="w-8 h-8 text-purple-600 dark:text-purple-400"></i>
        </div>
        <h4 class="font-semibold text-gray-900 dark:text-white">1,810 Egresados</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">En 2022<grok-card data-id="7bfb23" data-type="citation_card"></grok-card></p>
        <h4 class="font-semibold text-gray-900 dark:text-white">1,810 Egresados</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">En 2022<grok-card data-id="7bfb23" data-type="citation_card"></grok-card></p>
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
AOS.init({ 
    duration: 1000, 
    easing: 'ease-out-cubic',
    once: true,
    offset: 50,
    disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches
});
feather.replace();

<<<<<<< HEAD
// Theme integration
document.addEventListener('themechange', () => {
    feather.replace();
});
=======
// Botón modo oscuro (si está en navbar como #toggleDark)
(function(){
  const toggle = document.getElementById("toggleDark");
  const body = document.body;

  // Cargar preferencia guardada
  if(localStorage.getItem("theme") === "dark"){
    body.classList.add("dark");
    if (toggle) toggle.innerHTML = "☀️";
  }

  if(toggle){
    toggle.addEventListener("click", () => {
      body.classList.toggle("dark");
      if(body.classList.contains("dark")){
        localStorage.setItem("theme","dark");
        toggle.innerHTML = "☀️";
      } else {
        localStorage.setItem("theme","light");
        toggle.innerHTML = "🌙";
      }
      feather.replace(); // refrescar íconos si usas feather
    });
  }
})();
>>>>>>> 3ac172b6db056b2918dcc372299bfbc057cba132
</script>

<?php include 'footer.php'; ?>
</body>
</html>