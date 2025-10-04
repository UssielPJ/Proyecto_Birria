<?php
  // Si se está renderizando dentro de index.php, no repetir navbar/footer
  $__is_embedded = isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) === 'index.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Conoce a los docentes de UTSC: expertos en tecnologías de la información, mecatrónica, ingeniería industrial y más. Profesionales con experiencia en innovación para 2025.">
    <meta name="keywords" content="docentes UTSC, profesores ingeniería, expertos mecatrónica, electromovilidad, mantenimiento industrial">
    <meta property="og:title" content="Docentes - UTSC">
    <meta property="og:description" content="Equipo de profesionales apasionados por la enseñanza y la innovación tecnológica.">
    <meta property="og:image" content="/src/plataforma/app/img/UT.jpg">
    <meta property="og:url" content="https://utsc.edu.mx/src/docentes.php">
    <title>Docentes - UTSC | Expertos en Educación Tecnológica 2025</title>
    <link rel="icon" type="image/x-icon" href="/static/favicon.ico">
    <link rel="canonical" href="https://utsc.edu.mx/src/docentes.php">
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
        .docente-card {
            background-color: #ffffff;
            border-radius: .75rem;
            box-shadow: 0 10px 22px -10px rgba(0,0,0,.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0,0,0,.06);
            overflow: hidden;
        }
        .docente-card:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .specialty-chip {
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
        .specialty-chip:hover {
            transform: scale(1.05);
        }
        .department-filter {
            cursor: pointer;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        .department-filter:hover,
        .department-filter.active {
            background-color: var(--ut-green-100);
            color: var(--ut-green-800);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30, 140, 81, 0.2);
        }
        .social-icon {
            color: var(--ut-green-700);
            transition: all 0.2s ease;
            width: 20px;
            height: 20px;
        }
        .social-icon:hover {
            color: var(--ut-green-900);
            transform: translateY(-2px) scale(1.1);
        }
        /* Modo oscuro mejorado */
        body.dark {
            background-color: #0f172a;
            color: #f8fafc;
        }
        body.dark .docente-card{
          background-color:#1f2937;
          border-color: rgba(255,255,255,.06);
          box-shadow: 0 10px 24px -12px rgba(0,0,0,.6);
        }
        body.dark .docente-card:hover{
          box-shadow: 0 20px 40px rgba(0,0,0,.75);
        }
        /* Chips en dark */
        body.dark .specialty-chip.bg-\[var\(--ut-green-100\)\]{
          background-color:#064e3b !important;
          color:#86efac !important;
        }
        body.dark .specialty-chip.bg-green-100{ background-color:#064e3b !important; color:#86efac !important; }
        body.dark .specialty-chip.bg-purple-100{ background-color:#312e81 !important; color:#c7d2fe !important; }
        body.dark .specialty-chip.bg-yellow-100{ background-color:#78350f !important; color:#fde68a !important; }
        /* Botón en dark */
        .btn-docente{
          background:#f3f4f6; color:#111827;
          border-radius:.5rem; font-weight:600;
          transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          box-shadow: 0 4px 10px -6px rgba(0,0,0,.2);
        }
        .btn-docente:hover{ 
            background:#e5e7eb; 
            transform: translateY(-1px) scale(1.02); 
            box-shadow: 0 8px 20px -8px rgba(0,0,0,.3);
        }
        body.dark .btn-docente{ 
            background:#374151; 
            color:#e5e7eb; 
            box-shadow: 0 6px 16px -10px rgba(0,0,0,.6); 
        }
        body.dark .btn-docente:hover{ 
            background:#4b5563; 
        }
        /* Stats cards en dark */
        body.dark .stats-card {
            background: linear-gradient(135deg, #065f46, #047857);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        body.dark .bg-white { 
            background-color: #111827 !important; 
        }
        body.dark .text-gray-900{ color:#f3f4f6 !important; }
        body.dark .text-gray-600{ color:#d1d5db !important; }
        body.dark .text-gray-500{ color:#9ca3af !important; }
        /* Hero y CTA en dark */
        body.dark .hero-gradient {
            background: linear-gradient(180deg, #0f172a, #1e293b);
        }
        body.dark .cta-gradient {
            background: linear-gradient(180deg, #0f172a, #1e293b);
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
            .department-filter { flex: 1 1 100%; margin-bottom: 0.5rem; }
        }
    </style>
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "EducationalOrganization",
      "name": "UTSC",
      "employee": [
        {
          "@type": "Person",
          "name": "MC. Laura Mónica Madrigal González",
          "jobTitle": "Rectora",
          "description": "Líder académica en Universidad Tecnológica Santa Catarina"
        }
      ]
    }
    </script>
</head>
<body class="font-sans antialiased text-gray-800 dark:text-white">

    <?php if (!$__is_embedded) include 'navbar.php'; ?>

    <!-- Hero Section -->
    <div class="hero-gradient text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-secondary-600 transform -skew-y-6 -translate-y-24 z-0"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center animate-fade-in-up">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-6">Nuestros Docentes</h1>
                <p class="text-lg md:text-xl text-emerald-100 max-w-3xl mx-auto">Conoce a nuestro equipo de profesionales expertos en sus áreas de conocimiento para el 2025.</p>
            </div>
        </div>
    </div>

    <!-- Teachers Section -->
    <div class="py-16 bg-white dark:bg-neutral-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Cuerpo Docente</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">Profesionales con amplia experiencia académica y laboral en tecnologías emergentes.</p>
            </div>

            <!-- Teachers Filter -->
            <div class="mb-12 flex flex-wrap justify-center gap-2" data-aos="fade-up" id="filter-container">
                <button class="department-filter active" data-filter="all">Todos</button>
                <button class="department-filter" data-filter="tecnologia">Tecnología</button>
                <button class="department-filter" data-filter="ingenieria">Ingeniería</button>
                <button class="department-filter" data-filter="negocios">Negocios</button>
                <button class="department-filter" data-filter="ciencias">Ciencias</button>
            </div>

            <!-- Teachers Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="teachers-grid">
                <!-- Teacher 1: Tecnologías de la Información -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-category="tecnologia">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face" alt="Ing. Juan Pérez, profesor de Tecnologías de la Información en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ing. Juan Pérez</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Tecnologías de la Información</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Ing. Juan Pérez"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="GitHub de Ing. Juan Pérez"><i data-feather="github"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Ingeniero en sistemas con experiencia en desarrollo de software multiplataforma y bases de datos para innovación digital.<grok-card data-id="75ec9a" data-type="citation_card"></grok-card></p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Programación</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Bases de Datos</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Web Development</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver cursos de Ing. Juan Pérez">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver cursos
                        </button>
                    </div>
                </div>

                <!-- Teacher 2: Mecatrónica -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-aos-delay="100" data-category="ingenieria">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1581092160562-6486cd53181c?w=150&h=150&fit=crop&crop=face" alt="Ing. María López, profesora de Mecatrónica en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ing. María López</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Mecatrónica</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Ing. María López"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Twitter de Ing. María López"><i data-feather="twitter"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Especialista en integración de mecánica, electrónica e informática para sistemas automatizados.<grok-card data-id="c57c4a" data-type="citation_card"></grok-card></p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Automatización</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Robótica</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">IoT</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver cursos de Ing. María López">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver cursos
                        </button>
                    </div>
                </div>

                <!-- Teacher 3: Ingeniería Industrial -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-aos-delay="200" data-category="ingenieria">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=150&h=150&fit=crop&crop=face" alt="Ing. Carlos Ramírez, profesor de Ingeniería Industrial en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ing. Carlos Ramírez</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Ingeniería Industrial</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Ing. Carlos Ramírez"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="LinkedIn de Ing. Carlos Ramírez"><i data-feather="github"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Experto en planeación de operaciones y gestión de calidad en procesos productivos.<grok-card data-id="5fce10" data-type="citation_card"></grok-card></p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Gestión de Calidad</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Logística</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Lean Manufacturing</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver cursos de Ing. Carlos Ramírez">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver cursos
                        </button>
                    </div>
                </div>

                <!-- Teacher 4: Mantenimiento Industrial -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-category="ingenieria">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=150&h=150&fit=crop&crop=face" alt="Ing. Ana García, profesora de Mantenimiento Industrial en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ing. Ana García</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Mantenimiento Industrial</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Ing. Ana García"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Twitter de Ing. Ana García"><i data-feather="twitter"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Especialista en optimización de sistemas electromecánicos y estrategias de mantenimiento predictivo.<grok-card data-id="35c611" data-type="citation_card"></grok-card></p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Mantenimiento Predictivo</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Sistemas Electromecánicos</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Eficiencia Energética</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver cursos de Ing. Ana García">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver cursos
                        </button>
                    </div>
                </div>

                <!-- Teacher 5: Electromovilidad -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-aos-delay="100" data-category="ingenieria">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1502877338535-766e3a6052c0?w=150&h=150&fit=crop&crop=face" alt="Ing. Luis Hernández, profesor de Electromovilidad en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ing. Luis Hernández</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Electromovilidad</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Ing. Luis Hernández"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="YouTube de Ing. Luis Hernández"><i data-feather="youtube"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Ingeniero enfocado en sistemas de electromoción sustentable y gestión de proyectos en movilidad eléctrica.<grok-card data-id="dc1a08" data-type="citation_card"></grok-card></p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Baterías Eléctricas</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Motores Eléctricos</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Sustentabilidad</span>
                            <span class="specialty-chip bg-yellow-100 text-yellow-800">Proyectos PEI</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver cursos de Ing. Luis Hernández">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver cursos
                        </button>
                    </div>
                </div>

                <!-- Teacher 6: Gestión Institucional Educativa -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-aos-delay="200" data-category="negocios">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=150&h=150&fit=crop&crop=face" alt="Lic. Beatriz Olvera, profesora de Gestión Educativa en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Lic. Beatriz Olvera</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Gestión Educativa</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Lic. Beatriz Olvera"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Twitter de Lic. Beatriz Olvera"><i data-feather="twitter"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Experta en gestión curricular e institucional con enfoque en inclusión educativa.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Currículo</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Inclusión</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Educación Superior</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver cursos de Lic. Beatriz Olvera">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver cursos
                        </button>
                    </div>
                </div>

                <!-- Teacher 7: Rectora (from real info) -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-category="negocios">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face" alt="MC. Laura Madrigal, Rectora en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">MC. Laura Mónica Madrigal González</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Rectora</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de MC. Laura Madrigal"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Instagram de MC. Laura Madrigal"><i data-feather="instagram"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Líder académica dedicada a la formación profesional y la inclusión en la UTSC.<grok-card data-id="65d045" data-type="citation_card"></grok-card></p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Liderazgo Educativo</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Innovación</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Inclusión</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver información de MC. Laura Madrigal">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver perfil
                        </button>
                    </div>
                </div>

                <!-- Teacher 8: From directory, Dirección Académica -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-aos-delay="100" data-category="ciencias">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face" alt="MDP. Yessica Martínez, Encargada Académica en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">MDP. Yessica J. Martínez Iracheta</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Dirección Académica</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de MDP. Yessica Martínez"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Email de MDP. Yessica Martínez"><i data-feather="mail"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Encargada de la dirección académica, enfocada en el desarrollo curricular y la calidad educativa.<grok-card data-id="c6a6b0" data-type="citation_card"></grok-card></p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Currículo</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Calidad Educativa</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Evaluación</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver información de MDP. Yessica Martínez">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver perfil
                        </button>
                    </div>
                </div>

                <!-- Teacher 9: Another from directory -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-aos-delay="200" data-category="ingenieria">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face" alt="MDP. Beatriz Luna, Encargada Académica en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">MDP. Beatriz Eugenia Luna Olvera</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Dirección Académica</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de MDP. Beatriz Luna"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Phone de MDP. Beatriz Luna"><i data-feather="phone"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Encargada de la dirección académica con énfasis en innovación pedagógica.<grok-card data-id="d15c34" data-type="citation_card"></grok-card></p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Innovación Pedagógica</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Formación Docente</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Evaluación</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver información de MDP. Beatriz Luna">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver perfil
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-gray-50 dark:bg-neutral-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">Nuestros Docentes en Números</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">Calidad académica respaldada por datos para 2025</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="stats-card text-center bg-white dark:bg-neutral-700 p-8 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600" data-aos="fade-up">
                    <div class="text-5xl font-bold text-[var(--ut-green-700)] mb-2">98%</div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Evaluación Positiva</h3>
                    <p class="text-gray-500 dark:text-gray-400">De nuestros estudiantes recomiendan a nuestros docentes</p>
                </div>
                <div class="stats-card text-center bg-white dark:bg-neutral-700 p-8 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-5xl font-bold text-[var(--ut-green-700)] mb-2">15+</div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Años de Experiencia</h3>
                    <p class="text-gray-500 dark:text-gray-400">Promedio de experiencia profesional de nuestro equipo</p>
                </div>
                <div class="stats-card text-center bg-white dark:bg-neutral-700 p-8 rounded-lg shadow-sm border border-gray-200 dark:border-gray-600" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-5xl font-bold text-[var(--ut-green-700)] mb-2">50+</div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Certificaciones</h3>
                    <p class="text-gray-500 dark:text-gray-400">Entre nuestro cuerpo docente en tecnologías líderes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-gradient text-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl mb-6 animate-fade-in-up" data-aos="fade-up">¿Quieres unirte a nuestro equipo docente?</h2>
                <p class="text-lg text-emerald-100 max-w-3xl mx-auto mb-8 animate-fade-in" data-aos="fade-up" data-aos-delay="100">Buscamos profesionales apasionados por la enseñanza y la tecnología para 2025.</p>
                <button class="bg-white text-[var(--ut-green-800)] hover:bg-gray-100 px-6 py-3 rounded-md text-lg font-semibold transition-all transform hover:scale-105 shadow-lg" data-aos="fade-up" data-aos-delay="200" aria-label="Enviar solicitud para unirse al equipo docente">Enviar solicitud</button>
            </div>
        </div>
    </div>

    <?php if (!$__is_embedded) include 'footer.php'; ?>

    <script>
        // Inicializar AOS y Feather
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

        // Filtros funcionales
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.department-filter');
            const teacherCards = document.querySelectorAll('.teacher-card');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.dataset.filter;
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    teacherCards.forEach(card => {
                        const category = card.dataset.category;
                        if (filter === 'all' || category === filter) {
                            card.style.display = 'block';
                            card.classList.add('animate-fade-in-up');
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

            // Social icons hover effects
            document.querySelectorAll('.social-icon').forEach(icon => {
                icon.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.1)';
                });
                icon.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Buttons interactions
            document.querySelectorAll('.btn-docente').forEach(btn => {
                btn.addEventListener('click', function() {
                    alert('Redirigiendo a cursos del docente...');
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