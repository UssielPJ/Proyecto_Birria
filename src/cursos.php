<?php
// cursos.php
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Explora los cursos de UTSC: Ingeniería de Software, Inteligencia Artificial, Desarrollo Web y más. Formación profesional en línea con certificaciones oficiales.">
    <meta name="keywords" content="cursos UTSC, educación en línea, ingeniería de software, IA, desarrollo web, mecatrónica">
    <meta property="og:title" content="Cursos - UTSC">
    <meta property="og:description" content="Descubre nuestra gama de cursos diseñados para impulsar tu carrera.">
    <meta property="og:image" content="https://utsc.edu.mx/wp-content/uploads/2023/01/UTSC-Logo.png">
    <meta property="og:url" content="https://utsc.edu.mx/src/cursos.php">
    <title>Cursos - UTSC | Formación Profesional en Línea</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="canonical" href="https://utsc.edu.mx/src/cursos.php">
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
    <!-- Swiper para filtros avanzados si se necesita -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
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
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 
                        0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .category-filter {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        .category-filter:hover {
            background-color: var(--ut-green-600);
            color: white;
            transform: translateY(-1px);
        }
        .category-filter.active {
            background-color: var(--ut-green-700);
            color: white;
            box-shadow: 0 4px 12px rgba(30, 140, 81, 0.3);
        }
        /* Mejoras para modo oscuro */
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
        body.dark .course-card {
            background-color: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        body.dark .course-card:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }
        body.dark .newsletter-card {
            background-color: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        body.dark .newsletter-card input {
            background-color: #334155;
            border-color: rgba(255, 255, 255, 0.2);
            color: #f8fafc;
        }
        body.dark .newsletter-card input::placeholder {
            color: #94a3b8;
        }
        /* Animaciones suaves */
        .course-card, .category-filter, .pagination-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        /* Responsive para filtros */
        @media (max-width: 640px) {
            .category-filter {
                flex: 1 1 100%;
                text-align: center;
            }
        }
        /* Hero gradient dark mode */
        body.dark .hero-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
    </style>
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Course",
      "name": "Cursos UTSC",
      "description": "Cursos en línea de UTSC en ingeniería, tecnología y más.",
      "provider": {
        "@type": "EducationalOrganization",
        "name": "UTSC"
      },
      "hasCourseInstance": [
        {
          "@type": "CourseInstance",
          "courseMode": "online",
          "name": "Ingeniería en Tecnologías de la Información e Innovación Digital"
        }
      ]
    }
    </script>
</head>
<body class="font-sans antialiased bg-neutral-50 dark:bg-neutral-900 text-neutral-900 dark:text-white min-h-screen pt-16">

    <?php require_once __DIR__ . '/navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero-gradient relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-secondary-600 transform -skew-y-6 -translate-y-24 z-0"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 animate-fade-in-up" data-aos="fade-up">Nuestros Cursos</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto animate-fade-in" data-aos="fade-up" data-aos-delay="100">
                Explora nuestra amplia gama de cursos diseñados para impulsar tu carrera profesional en 2025. Certificaciones oficiales y aprendizaje flexible.
            </p>
            
            <!-- Barra de búsqueda -->
            <div class="mt-8 max-w-md mx-auto" data-aos="fade-up" data-aos-delay="150">
                <div class="relative">
                    <input type="search" placeholder="Buscar cursos por nombre o categoría..." class="w-full px-4 py-3 pl-12 rounded-full text-gray-900 focus:ring-[var(--ut-green-600)] focus:border-[var(--ut-green-600)] bg-white/90 backdrop-blur-sm border border-white/20">
                    <i data-feather="search" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-500"></i>
                </div>
            </div>
            
            <!-- Filtros -->
            <div class="mt-12 flex flex-wrap justify-center gap-3" data-aos="fade-up" data-aos-delay="200">
                <button class="category-filter active px-6 py-3 rounded-full text-white font-medium" data-filter="all">Todos</button>
                <button class="category-filter px-6 py-3 rounded-full text-white font-medium" data-filter="ingenieria">Ingeniería</button>
                <button class="category-filter px-6 py-3 rounded-full text-white font-medium" data-filter="tecnologia">Tecnología</button>
                <button class="category-filter px-6 py-3 rounded-full text-white font-medium" data-filter="negocios">Negocios</button>
                <button class="category-filter px-6 py-3 rounded-full text-white font-medium" data-filter="diseno">Diseño</button>
                <button class="category-filter px-6 py-3 rounded-full text-white font-medium" data-filter="ciencias">Ciencias</button>
            </div>
        </div>
    </section>

    <!-- Cursos Grid -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="courses-grid">
            <!-- Curso 1: Ingeniería en Tecnologías de la Información e Innovación Digital -->
            <article class="course-card bg-white dark:bg-neutral-800 rounded-2xl shadow-lg overflow-hidden group" data-aos="fade-up" data-category="tecnologia">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=400&fit=crop" alt="Curso de Ingeniería en Tecnologías de la Información e Innovación Digital en UTSC" class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/90 text-white backdrop-blur-sm">
                            Disponible
                        </span>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-4">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded mb-1">Nivel Intermedio</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                        Ingeniería en Tecnologías de la Información e Innovación Digital
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm mb-4">
                        La ingeniería de software es una disciplina que se centra en la aplicación de principios y métodos de ingeniería al desarrollo, mantenimiento y evolución de software de calidad. Desarrollar soluciones tecnológicas multiplataforma de software web y móvil utilizando programación orientada a objetos, frameworks, bases de datos, estándares de calidad y diseño para resolver problemas del sector productivo, con un enfoque de inclusión, compromiso con la responsabilidad social, equidad social y de género, excelencia, vanguardia, innovación social e interculturalidad.
                    </p>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-neutral-100 dark:bg-neutral-700 flex items-center justify-center">
                                <i data-feather="clock" class="w-4 h-4 text-neutral-600 dark:text-neutral-400"></i>
                            </div>
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">10 cuatrimestres (3 años 8 meses)</span>
                        </div>
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">Gratis</span>
                    </div>
                    <a href="https://utsc.edu.mx/ingenieria-tecnologias-de-la-informacion-e-innovacion-digital/" class="w-full inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-lg font-medium transition-all transform hover:scale-105" aria-label="Ver detalles del curso de Ingeniería en Tecnologías de la Información e Innovación Digital">
                        Ver detalles
                        <i data-feather="arrow-right" class="w-4 h-4 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </article>

            <!-- Curso 2: Ingeniería en Mecatrónica -->
            <article class="course-card bg-white dark:bg-neutral-800 rounded-2xl shadow-lg overflow-hidden group" data-aos="fade-up" data-aos-delay="100" data-category="ingenieria">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1581092160562-6486cd53181c?w=800&h=400&fit=crop" alt="Curso de Ingeniería en Mecatrónica en UTSC" class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/90 text-white backdrop-blur-sm">
                            Disponible
                        </span>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-4">
                        <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-2 py-1 rounded mb-1">Nivel Avanzado</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                        Ingeniería en Mecatrónica
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm mb-4">
                        La ingeniería mecatrónica es una disciplina interdisciplinaria que combina elementos de la ingeniería mecánica, la electrónica, la informática y la automatización para diseñar, desarrollar y controlar sistemas inteligentes y automatizados. Doble titulación: Primero se gradúa como técnico superior universitario (TSU) y luego, si así lo decide, obtiene el título de Ingeniero en Mecatrónica. El alumno realiza dos procesos de estadía, uno para obtener el título de TSU y otro para graduarse como Ingeniero en Mecatrónica, a través de convenios con empresas para aplicar conocimientos en un entorno laboral real.
                    </p>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-neutral-100 dark:bg-neutral-700 flex items-center justify-center">
                                <i data-feather="clock" class="w-4 h-4 text-neutral-600 dark:text-neutral-400"></i>
                            </div>
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">TSU: 2 años (6 cuatrimestres); Ingeniería: 1 año 8 meses (5 cuatrimestres)</span>
                        </div>
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">Gratis</span>
                    </div>
                    <a href="https://utsc.edu.mx/ingenieria-en-mecatronica/" class="w-full inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-lg font-medium transition-all transform hover:scale-105" aria-label="Ver detalles del curso de Ingeniería en Mecatrónica">
                        Ver detalles
                        <i data-feather="arrow-right" class="w-4 h-4 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </article>

            <!-- Curso 3: Ingeniería Industrial -->
            <article class="course-card bg-white dark:bg-neutral-800 rounded-2xl shadow-lg overflow-hidden group" data-aos="fade-up" data-aos-delay="200" data-category="ingenieria">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&h=400&fit=crop" alt="Curso de Ingeniería Industrial en UTSC" class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/90 text-white backdrop-blur-sm">
                            Disponible
                        </span>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-4">
                        <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded mb-1">Nivel Intermedio</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                        Ingeniería Industrial
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm mb-4">
                        La universidad cuenta con doble titulación, primero te gradúas como técnico superior universitario y después, si así lo decides, obtener el título de Ingeniero Industrial. El alumno deberá realizar dos procesos de estadía: el primero para obtener el título de TSU, y el segundo para completar su formación y graduarse como Ingeniero Industrial. Las competencias profesionales incluyen administrar procesos de una organización, gestionar procesos productivos, y optimizar sistemas, procesos y proyectos industriales, entre otras, con un enfoque ético, económico, legal, tecnológico, sistémico, integral, humano y social.
                    </p>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-neutral-100 dark:bg-neutral-700 flex items-center justify-center">
                                <i data-feather="clock" class="w-4 h-4 text-neutral-600 dark:text-neutral-400"></i>
                            </div>
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">TSU: 2 años (6 cuatrimestres); Ingeniería: 1 año 8 meses (5 cuatrimestres)</span>
                        </div>
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">Gratis</span>
                    </div>
                    <a href="https://utsc.edu.mx/ingenieria-industrial/" class="w-full inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-lg font-medium transition-all transform hover:scale-105" aria-label="Ver detalles del curso de Ingeniería Industrial">
                        Ver detalles
                        <i data-feather="arrow-right" class="w-4 h-4 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </article>

            <!-- Curso 4: Ingeniería en Mantenimiento Industrial -->
            <article class="course-card bg-white dark:bg-neutral-800 rounded-2xl shadow-lg overflow-hidden group" data-aos="fade-up" data-category="ingenieria">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=800&h=400&fit=crop" alt="Curso de Ingeniería en Mantenimiento Industrial en UTSC" class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/90 text-white backdrop-blur-sm">
                            Disponible
                        </span>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-4">
                        <span class="inline-block bg-orange-100 text-orange-800 text-xs font-semibold px-2 py-1 rounded mb-1">Nivel Avanzado</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                        Ingeniería en Mantenimiento Industrial
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm mb-4">
                        Si eres una mente inquisitiva con una pasión por la eficiencia y la mejora constante, la carrera de Ingeniería en Mantenimiento Industrial en la Universidad Tecnológica Santa Catarina podría ser tu camino hacia el éxito. El Técnico Superior Universitario en Mantenimiento Área Industrial busca elaborar y ejecutar programas de mantenimiento enfocados a maximizar la disponibilidad del equipo, reducir costos y prolongar la vida útil de los activos productivos. El egresado de Licenciatura en Ingeniería en Mantenimiento Industrial se distingue por poseer las competencias profesionales esenciales que respaldan su desempeño con éxito en el dinámico entorno laboral. Doble titulación: primero se gradúa como Técnico Superior Universitario (TSU) y luego, si así lo decide, obtiene el título de Ingeniero en Mantenimiento Industrial.
                    </p>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-neutral-100 dark:bg-neutral-700 flex items-center justify-center">
                                <i data-feather="clock" class="w-4 h-4 text-neutral-600 dark:text-neutral-400"></i>
                            </div>
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">TSU: 2 años (6 cuatrimestres); Ingeniería: 1 año 8 meses (5 cuatrimestres)</span>
                        </div>
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">Gratis</span>
                    </div>
                    <a href="https://utsc.edu.mx/ingenieria-en-mantenimiento-industrial/" class="w-full inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-lg font-medium transition-all transform hover:scale-105" aria-label="Ver detalles del curso de Ingeniería en Mantenimiento Industrial">
                        Ver detalles
                        <i data-feather="arrow-right" class="w-4 h-4 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </article>

            <!-- Curso 5: Ingeniería en Electromovilidad -->
            <article class="course-card bg-white dark:bg-neutral-800 rounded-2xl shadow-lg overflow-hidden group" data-aos="fade-up" data-aos-delay="100" data-category="tecnologia">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=800&h=400&fit=crop" alt="Curso de Ingeniería en Electromovilidad en UTSC" class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/90 text-white backdrop-blur-sm">
                            Disponible
                        </span>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-4">
                        <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2 py-1 rounded mb-1">Nivel Intermedio</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                        Ingeniería en Electromovilidad
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm mb-4">
                        La universidad cuenta con doble titulación, primero te gradúas como técnico superior universitario y después, si así lo decides, obtener el título de Ingeniero(a) en Electromovilidad. El alumno deberá realizar dos procesos de estadía: el primero para obtener el título de TSU, y el segundo para completar su formación y graduarse como Ingeniero(a) en Electromovilidad. Desarrolla sistemas de electromoción para asegurar el correcto funcionamiento de los vehículos alimentados por energía eléctrica, gestiona proyectos de electromovilidad a través de la integración y administración de nuevas tecnologías sustentables, y evalúa el ciclo de vida del sistema considerando el impacto en los sectores productivo, social y medio ambiente.
                    </p>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-neutral-100 dark:bg-neutral-700 flex items-center justify-center">
                                <i data-feather="clock" class="w-4 h-4 text-neutral-600 dark:text-neutral-400"></i>
                            </div>
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">TSU: 2 años (6 cuatrimestres); Ingeniería: 1 año 8 meses (5 cuatrimestres)</span>
                        </div>
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">Gratis</span>
                    </div>
                    <a href="https://utsc.edu.mx/ingenieria-en-electromovilidad/" class="w-full inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-lg font-medium transition-all transform hover:scale-105" aria-label="Ver detalles del curso de Ingeniería en Electromovilidad">
                        Ver detalles
                        <i data-feather="arrow-right" class="w-4 h-4 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </article>

            <!-- Curso 6: Licenciatura en Gestión Institucional Educativa y Curricular -->
            <article class="course-card bg-white dark:bg-neutral-800 rounded-2xl shadow-lg overflow-hidden group" data-aos="fade-up" data-aos-delay="200" data-category="negocios">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&h=400&fit=crop" alt="Curso de Licenciatura en Gestión Institucional Educativa y Curricular en UTSC" class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-500/90 text-white backdrop-blur-sm">
                            Disponible
                        </span>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-4">
                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded mb-1">Nivel Intermedio</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                        Licenciatura en Gestión Institucional Educativa y Curricular
                    </h3>
                    <p class="text-neutral-600 dark:text-neutral-400 text-sm mb-4">
                        La universidad cuenta con doble titulación, primero te gradúas como técnico superior universitario y después, si así lo decides, obtener el título de Licenciatura en Educación. El alumno(a) deberá realizar dos procesos de estadía: el primero para obtener el título de TSU, y el segundo para completar su formación y graduarse como Licenciado(a) en Educación. Las competencias profesionales incluyen desarrollar el proceso de enseñanza-aprendizaje, considerando las necesidades de los estudiantes, promoviendo habilidades integrales y el uso de nuevas tecnologías, así como administrar, gestionar y desarrollar procesos educativos, institucionales y escolares, con base en teorías pedagógicas y de la psicología de la educación.
                    </p>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 rounded-full bg-neutral-100 dark:bg-neutral-700 flex items-center justify-center">
                                <i data-feather="clock" class="w-4 h-4 text-neutral-600 dark:text-neutral-400"></i>
                            </div>
                            <span class="text-sm text-neutral-600 dark:text-neutral-400">TSU: 2 años (6 cuatrimestres); Licenciatura: 1 año 8 meses (5 cuatrimestres)</span>
                        </div>
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">Gratis</span>
                    </div>
                    <a href="https://utsc.edu.mx/licenciatura-en-gestion-institucional-educativa-y-curricular/" class="w-full inline-flex items-center justify-center gap-2 bg-primary-600 hover:bg-primary-700 text-white py-3 rounded-lg font-medium transition-all transform hover:scale-105" aria-label="Ver detalles del curso de Licenciatura en Gestión Institucional Educativa y Curricular">
                        Ver detalles
                        <i data-feather="arrow-right" class="w-4 h-4 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </article>
        </div>

        <!-- Paginación Mejorada -->
        <div class="flex justify-center mt-12 gap-2" data-aos="fade-up" data-aos-delay="300">
            <button class="pagination-btn w-10 h-10 flex items-center justify-center rounded-lg bg-white dark:bg-neutral-800 shadow hover:shadow-md transition-shadow" aria-label="Página anterior">
                <i data-feather="chevron-left" class="w-5 h-5"></i>
            </button>
            <button class="pagination-btn w-10 h-10 flex items-center justify-center rounded-lg bg-primary-600 text-white shadow-md" aria-label="Página 1 actual">1</button>
            <button class="pagination-btn w-10 h-10 flex items-center justify-center rounded-lg bg-white dark:bg-neutral-800 shadow hover:shadow-md transition-shadow" aria-label="Página 2">2</button>
            <button class="pagination-btn w-10 h-10 flex items-center justify-center rounded-lg bg-white dark:bg-neutral-800 shadow hover:shadow-md transition-shadow" aria-label="Página 3">3</button>
            <button class="pagination-btn w-10 h-10 flex items-center justify-center rounded-lg bg-white dark:bg-neutral-800 shadow hover:shadow-md transition-shadow" aria-label="Página siguiente">
                <i data-feather="chevron-right" class="w-5 h-5"></i>
            </button>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-primary-600 to-secondary-600 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4 animate-fade-in-up" data-aos="fade-up">
                ¿Listo para empezar tu carrera en 2025?
            </h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto animate-fade-in" data-aos="fade-up" data-aos-delay="100">
                Únete a nuestra comunidad de estudiantes y comienza tu camino hacia el éxito profesional con cursos actualizados.
            </p>
            <a href="#" class="inline-flex items-center gap-2 bg-white text-primary-600 px-8 py-3 rounded-xl font-semibold hover:shadow-lg transition-all transform hover:scale-105 shadow-lg" data-aos="fade-up" data-aos-delay="200" aria-label="Inscribirse ahora en un curso">
                Inscríbete ahora
                <i data-feather="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
    </section>

    <!-- Newsletter -->
    <div class="bg-gray-50 dark:bg-neutral-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="newsletter-card bg-white dark:bg-neutral-700 rounded-lg shadow-md p-8 md:p-12" data-aos="fade-up">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                    <div class="mb-8 lg:mb-0">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">¿Quieres recibir nuestras novedades?</h2>
                        <p class="text-gray-600 dark:text-gray-400">Suscríbete a nuestro boletín y recibe información sobre nuevos cursos, descuentos y eventos académicos de 2025.</p>
                    </div>
                    <div>
                        <form class="flex flex-col sm:flex-row gap-3">
                            <input type="email" placeholder="Tu correo electrónico" class="flex-grow px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-[var(--ut-green-600)] focus:border-[var(--ut-green-600)] bg-white dark:bg-neutral-600" required aria-label="Correo electrónico para suscripción">
                            <button type="submit" class="bg-[var(--ut-green-600)] hover:bg-[var(--ut-green-700)] text-white px-6 py-3 rounded-md text-sm font-semibold transition duration-150 ease-in-out whitespace-nowrap" aria-label="Suscribirse al boletín">Suscribirse</button>
                        </form>
                        <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                            Nos preocupamos por la protección de tus datos. Lee nuestra 
                            <a href="#" class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)] hover:underline">Política de Privacidad</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        // Inicializar AOS + Feather
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

        // Filtros de cursos mejorados
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.category-filter');
            const courseCards = document.querySelectorAll('.course-card');
            const searchInput = document.querySelector('input[type="search"]');
            const coursesGrid = document.getElementById('courses-grid');

            function filterCourses(filter, searchTerm = '') {
                courseCards.forEach(card => {
                    const category = card.dataset.category;
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    const description = card.querySelector('p').textContent.toLowerCase();

                    const matchesCategory = filter === 'all' || category === filter;
                    const matchesSearch = title.includes(searchTerm.toLowerCase()) || description.includes(searchTerm.toLowerCase());

                    if (matchesCategory && matchesSearch) {
                        card.style.display = 'block';
                        card.classList.add('animate-fade-in');
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Animación de fade-in para cards visibles
                setTimeout(() => {
                    courseCards.forEach(card => {
                        if (card.style.display !== 'none') {
                            card.classList.add('animate-fade-in');
                        }
                    });
                }, 300);
            }

            // Event listeners para filtros
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    filterCourses(this.dataset.filter, searchInput.value);
                });
            });

            // Event listener para búsqueda
            searchInput.addEventListener('input', function() {
                const activeFilter = document.querySelector('.category-filter.active').dataset.filter;
                filterCourses(activeFilter, this.value);
            });

            // Inicializar con todos los cursos visibles
            filterCourses('all');

            // Paginación básica (simulada)
            const paginationBtns = document.querySelectorAll('.pagination-btn:not([aria-label])');
            paginationBtns.forEach((btn, index) => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    paginationBtns.forEach(b => b.classList.remove('bg-primary-600', 'text-white'));
                    this.classList.add('bg-primary-600', 'text-white');
                    console.log(`Página ${index + 1} seleccionada`);
                });
            });

            // Lazy loading para imágenes
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src || img.src;
                            img.classList.add('opacity-100');
                            imageObserver.unobserve(img);
                        }
                    });
                });
                document.querySelectorAll('img').forEach(img => imageObserver.observe(img));
            }

            // Newsletter form submission
            const newsletterForm = document.querySelector('form');
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('¡Gracias por suscribirte! Te enviaremos novedades pronto.');
                    this.reset();
                });
            }
        });

        // Integración con theme toggle del navbar
        document.addEventListener('themechange', () => {
            feather.replace();
        });
    </script>
</body>
</html>