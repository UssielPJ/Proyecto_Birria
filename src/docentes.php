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
    <meta property="og:image" content="https://utsc.edu.mx/wp-content/uploads/2023/01/UTSC-Logo.png">
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
      "name": "Universidad Tecnológica Santa Catarina (UTSC)",
      "employee": [
        {
          "@type": "Person",
          "name": "MC. Laura Mónica Madrigal González",
          "jobTitle": "Encargada del Despacho de la Rectoría",
          "description": "Líder académica en Universidad Tecnológica Santa Catarina"
        },
        {
          "@type": "Person",
          "name": "MDP. Beatriz Eugenia Luna Olvera",
          "jobTitle": "Encargada de la Dirección Académica",
          "description": "Directora Académica en UTSC"
        },
        {
          "@type": "Person",
          "name": "Yessica J. Martínez Iracheta",
          "jobTitle": "Recepción de la Dirección Académica",
          "description": "Apoyo administrativo en Dirección Académica de UTSC"
        },
        {
          "@type": "Person",
          "name": "Ing. Juan José Reyna Picón",
          "jobTitle": "Coordinador de Transparencia",
          "description": "Coordinador en Dirección Jurídica de UTSC"
        },
        {
          "@type": "Person",
          "name": "Lic. Jesús Ayala González",
          "jobTitle": "Encargado de la Dirección de Administración y Finanzas",
          "description": "Director de Administración y Finanzas en UTSC"
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
                <button class="department-filter" data-filter="administracion">Administración</button>
            </div>

            <!-- Teachers Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="teachers-grid">
                <!-- Teacher 1: Ing. Juan José Reyna Picón - Coordinador de Transparencia -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-category="administracion">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face" alt="Ing. Juan José Reyna Picón, Coordinador de Transparencia en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ing. Juan José Reyna Picón</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Coordinador de Transparencia</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Ing. Juan José Reyna Picón"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Email de Ing. Juan José Reyna Picón"><i data-feather="mail"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Ingeniero enfocado en transparencia y gestión administrativa en el ámbito educativo.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Transparencia</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Gestión Administrativa</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Ética</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver perfil de Ing. Juan José Reyna Picón">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver perfil
                        </button>
                    </div>
                </div>

                <!-- Teacher 2: Lic. Jesús Ayala González - Dirección de Administración y Finanzas -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-aos-delay="100" data-category="administracion">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1581092160562-6486cd53181c?w=150&h=150&fit=crop&crop=face" alt="Lic. Jesús Ayala González, Encargado de Administración y Finanzas en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Lic. Jesús Ayala González</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Dirección de Administración y Finanzas</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Lic. Jesús Ayala González"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Phone de Lic. Jesús Ayala González"><i data-feather="phone"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Encargado de la gestión financiera y administrativa de la institución.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Finanzas</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Administración</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Presupuestos</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver perfil de Lic. Jesús Ayala González">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver perfil
                        </button>
                    </div>
                </div>

                <!-- Teacher 3: MDIP. Marcela Denisse Leal Alanís - Dirección Jurídica -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-aos-delay="200" data-category="administracion">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=150&h=150&fit=crop&crop=face" alt="MDIP. Marcela Denisse Leal Alanís, Dirección Jurídica en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">MDIP. Marcela Denisse Leal Alanís</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Dirección Jurídica</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de MDIP. Marcela Denisse Leal Alanís"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Mail de MDIP. Marcela Denisse Leal Alanís"><i data-feather="mail"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Encargada de la dirección jurídica, asegurando el cumplimiento normativo.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Derecho Educativo</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Normatividad</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Cumplimiento</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver perfil de MDIP. Marcela Denisse Leal Alanís">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver perfil
                        </button>
                    </div>
                </div>

                <!-- Teacher 4: Lic. Mario Alberto Juarez Alanís - Contralor Interno -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-category="administracion">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=150&h=150&fit=crop&crop=face" alt="Lic. Mario Alberto Juarez Alanís, Contralor Interno en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Lic. Mario Alberto Juarez Alanís</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Contralor Interno</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Lic. Mario Alberto Juarez Alanís"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Twitter de Lic. Mario Alberto Juarez Alanís"><i data-feather="twitter"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Responsable de la contraloría interna y auditorías en la institución.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Auditoría</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Control Interno</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Riesgos</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver perfil de Lic. Mario Alberto Juarez Alanís">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver perfil
                        </button>
                    </div>
                </div>

                <!-- Teacher 5: Lic. Julio Cesar Galván Salazar - Auxiliar Jurídico -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-aos-delay="100" data-category="administracion">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1502877338535-766e3a6052c0?w=150&h=150&fit=crop&crop=face" alt="Lic. Julio Cesar Galván Salazar, Auxiliar Jurídico en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Lic. Julio Cesar Galván Salazar</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Auxiliar Jurídico</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Lic. Julio Cesar Galván Salazar"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="YouTube de Lic. Julio Cesar Galván Salazar"><i data-feather="youtube"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Apoyo en asuntos jurídicos y contratos institucionales.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Contratos</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Asesoría Legal</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Cumplimiento Normativo</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver perfil de Lic. Julio Cesar Galván Salazar">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver perfil
                        </button>
                    </div>
                </div>

                <!-- Teacher 6: Lic. Linda Nancy Orozco Castilleja - Coordinador de Archivo General -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-aos-delay="200" data-category="administracion">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=150&h=150&fit=crop&crop=face" alt="Lic. Linda Nancy Orozco Castilleja, Coordinador de Archivo General en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Lic. Linda Nancy Orozco Castilleja</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Coordinador de Archivo General</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Lic. Linda Nancy Orozco Castilleja"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Twitter de Lic. Linda Nancy Orozco Castilleja"><i data-feather="twitter"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Gestión y organización de archivos institucionales.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Archivos</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Documentación</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Organización</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver perfil de Lic. Linda Nancy Orozco Castilleja">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver perfil
                        </button>
                    </div>
                </div>

                <!-- Teacher 7: MC. Laura Mónica Madrigal González - Rectora -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-category="administracion">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face" alt="MC. Laura Mónica Madrigal González, Encargada del Despacho de la Rectoría en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">MC. Laura Mónica Madrigal González</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Encargada del Despacho de la Rectoría</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="https://www.facebook.com/lauramadrigalMC/" target="_blank" class="social-icon" aria-label="Facebook de MC. Laura Mónica Madrigal González"><i data-feather="facebook"></i></a>
                                <a href="#" class="social-icon" aria-label="Instagram de MC. Laura Mónica Madrigal González"><i data-feather="instagram"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Líder académica dedicada a la formación profesional y la inclusión en la UTSC.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Liderazgo Educativo</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Innovación</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Inclusión</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver perfil de MC. Laura Mónica Madrigal González">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver perfil
                        </button>
                    </div>
                </div>

                <!-- Teacher 8: MDP. Beatriz Eugenia Luna Olvera - Dirección Académica -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-aos-delay="100" data-category="ciencias">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face" alt="MDP. Beatriz Eugenia Luna Olvera, Encargada de la Dirección Académica en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">MDP. Beatriz Eugenia Luna Olvera</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Encargada de la Dirección Académica</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="https://mx.linkedin.com/in/beatriz-eugenia-luna-olvera-69963a146" target="_blank" class="social-icon" aria-label="LinkedIn de MDP. Beatriz Eugenia Luna Olvera"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Email de MDP. Beatriz Eugenia Luna Olvera"><i data-feather="mail"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Encargada de la dirección académica con énfasis en innovación pedagógica.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Innovación Pedagógica</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Formación Docente</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Evaluación</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver perfil de MDP. Beatriz Eugenia Luna Olvera">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver perfil
                        </button>
                    </div>
                </div>

                <!-- Teacher 9: Yessica J. Martínez Iracheta - Recepción Dirección Académica -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-aos-delay="200" data-category="administracion">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face" alt="Yessica J. Martínez Iracheta, Recepción de la Dirección Académica en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Yessica J. Martínez Iracheta</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Recepción de la Dirección Académica</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Yessica J. Martínez Iracheta"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Phone de Yessica J. Martínez Iracheta"><i data-feather="phone"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Apoyo administrativo en la dirección académica, facilitando el desarrollo curricular.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Currículo</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Calidad Educativa</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Apoyo Académico</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver perfil de Yessica J. Martínez Iracheta">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver perfil
                        </button>
                    </div>
                </div>

                <!-- Teacher 10: Ing. Laura Patricia Álvarez Navarro - Recepción Rectoría -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-category="administracion">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face" alt="Ing. Laura Patricia Álvarez Navarro, Recepción del Despacho de la Rectoría en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ing. Laura Patricia Álvarez Navarro</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Recepción del Despacho de la Rectoría</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Ing. Laura Patricia Álvarez Navarro"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Mail de Ing. Laura Patricia Álvarez Navarro"><i data-feather="mail"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Apoyo en recepción y coordinación en el despacho rectoral.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Coordinación</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Recepción</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Apoyo Ejecutivo</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver perfil de Ing. Laura Patricia Álvarez Navarro">
                            <i data-feather="book-open" class="w-4 h-4 mr-2"></i> Ver perfil
                        </button>
                    </div>
                </div>

                <!-- Teacher 11: Magda Elena Ibarra Hernández - Recepción Dirección Jurídica -->
                <div class="docente-card teacher-card" data-aos="fade-up" data-aos-delay="100" data-category="administracion">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <img class="w-16 h-16 rounded-full object-cover ring-2 ring-white/20 shadow-md" src="https://images.unsplash.com/photo-1581092160562-6486cd53181c?w=150&h=150&fit=crop&crop=face" alt="Magda Elena Ibarra Hernández, Recepción de la Dirección Jurídica en UTSC" loading="lazy">
                            <div class="ml-4 flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Magda Elena Ibarra Hernández</h3>
                                <p class="text-[var(--ut-green-700)] dark:text-[var(--ut-green-400)]">Recepción de la Dirección Jurídica</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="social-icon" aria-label="LinkedIn de Magda Elena Ibarra Hernández"><i data-feather="linkedin"></i></a>
                                <a href="#" class="social-icon" aria-label="Phone de Magda Elena Ibarra Hernández"><i data-feather="phone"></i></a>
                            </div>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Apoyo administrativo en la dirección jurídica.</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)]">Apoyo Jurídico</span>
                            <span class="specialty-chip bg-green-100 text-green-800">Recepción</span>
                            <span class="specialty-chip bg-purple-100 text-purple-800">Coordinación</span>
                        </div>
                        <button class="w-full btn-docente py-2 px-4 flex items-center justify-center" aria-label="Ver perfil de Magda Elena Ibarra Hernández">
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
                    alert('Redirigiendo a perfil del docente...');
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