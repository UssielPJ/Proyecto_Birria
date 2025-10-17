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
    <div id="fb-root"></div>
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
        #video-institucional { scroll-margin-top: 96px; }
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
        
        /* Hero section */
        body.dark .hero-gradient {
          background: linear-gradient(135deg, var(--ut-green-900) 0%, var(--ut-green-800) 50%, var(--ut-green-700) 100%);
        }
        body.dark .hero-gradient h1 { color: white; }
        body.dark .hero-gradient p { color: #e2e8f0; }
        body.dark .hero-gradient .bg-white { background: #1e293b; color: white; }
        body.dark .hero-gradient .bg-white:hover { background: #334155; }
        body.dark .hero-gradient .border-white { border-color: #e2e8f0; color: white; }
        body.dark .hero-gradient .border-white:hover { background: rgba(255, 255, 255, 0.1); }
        
        /* Stats cards */
        body.dark .stats-card { background: linear-gradient(135deg, var(--ut-green-800), var(--ut-green-900)); }
        
        /* Career cards */
        body.dark .career-card { background-color: #1f2937; }
        body.dark .career-card h3 { color: white; }
        body.dark .career-card p { color: #cbd5e1; }
        body.dark .career-card .text-gray-500 { color: #9ca3af; }
        body.dark .career-card .text-gray-600 { color: #d1d5db; }
        
        /* News cards */
        body.dark .news-card { background-color: #1f2937; }
        body.dark .news-card h3 { color: white; }
        body.dark .news-card p { color: #cbd5e1; }
        body.dark .news-card .text-gray-600 { color: #d1d5db; }
        
        /* Campus cards */
        body.dark .campus-card { background-color: #1f2937; }
        body.dark .campus-card h3 { color: white; }
        body.dark .campus-card p { color: #cbd5e1; }
        
        /* Sports cards */
        body.dark .sports-card { background-color: #1f2937; }
        body.dark .sports-card h3 { color: white; }
        body.dark .sports-card p { color: #cbd5e1; }
        body.dark .sports-card .text-gray-600 { color: #d1d5db; }
        
        /* Gallery items */
        body.dark .gallery-item { background-color: #1f2937; }
        body.dark .gallery-item h4 { color: white; }
        body.dark .gallery-item p { color: #cbd5e1; }
        
        /* CTA sections */
        body.dark .bg-gradient-to-br.from-green-50.to-emerald-100 { background: linear-gradient(135deg, #0f172a, #1e293b); }
        body.dark .bg-gradient-to-r.from-green-600.to-emerald-700 { background: linear-gradient(135deg, var(--ut-green-700), var(--ut-green-800)); }
        
        /* Modal backgrounds */
        body.dark .bg-black.bg-opacity-75 { background-color: rgba(0, 0, 0, 0.9); }
        body.dark .bg-white.rounded-2xl { background-color: #1f2937; }
        body.dark .bg-gray-50 { background-color: #111827; }
        body.dark .text-gray-900 { color: #f3f4f6; }
        body.dark .text-gray-600 { color: #d1d5db; }
        body.dark .border-gray-200 { border-color: #374151; }
        
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
        }
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
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

    </style>
</head>
<body class="font-sans antialiased text-gray-800">

    <?php include 'navbar.php'; ?>

    <!-- Hero Section con Carrusel -->
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
                    <button onclick="openGoogleMaps()" class="bg-white text-[var(--ut-green-800)] hover:bg-gray-100 px-6 py-3 rounded-md text-lg font-semibold transition">Ubicación</button>
                    <button onclick="playVideo()" class="border-2 border-white text-white hover:bg-white hover:text-[var(--ut-green-800)] px-6 py-3 rounded-md text-lg font-semibold transition">Ver Video</button>
                </div>
            </div>
            
            <!-- Carrusel en el mismo espacio -->
            <div data-aos="fade-left">
                <div class="carousel-container relative rounded-lg shadow-xl overflow-hidden">
                    <div class="carousel-slides flex transition-transform duration-500 ease-in-out">
                        <!-- Imagen 1 -->
                        <div class="carousel-slide w-full flex-shrink-0">
                            <img src="./plataforma/app/img/PlantelUT.jpg" alt="Campus Principal UT" class="w-full h-auto object-cover rounded-lg">
                        </div>
                        <!-- Imagen 2 -->
                        <div class="carousel-slide w-full flex-shrink-0">
                            <img src="./plataforma/app/img/SeleccionUT.jpg" alt="Instalaciones Deportivas" class="w-full h-auto object-cover rounded-lg">
                        </div>
                        <!-- Imagen 3 -->
                        <div class="carousel-slide w-full flex-shrink-0">
                            <img src="./plataforma/app/img/SeleccionTocho.jpg" alt="Laboratorios Industriales" class="w-full h-auto object-cover rounded-lg">
                        </div>
                        <!-- Imagen 4 -->
                        <div class="carousel-slide w-full flex-shrink-0">
                            <img src="./plataforma/app/img/DocentesUT.jpg" alt="Tecnología Avanzada" class="w-full h-auto object-cover rounded-lg">
                        </div>
                    </div>
                    
                    <!-- Indicadores del carrusel -->
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        <button class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors" data-slide="0"></button>
                        <button class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors" data-slide="1"></button>
                        <button class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors" data-slide="2"></button>
                        <button class="carousel-indicator w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors" data-slide="3"></button>
                    </div>
                    
                    <!-- Botones de navegación -->
                    <button class="carousel-prev absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-2 rounded-full transition-colors">
                        <i data-feather="chevron-left" class="w-6 h-6"></i>
                    </button>
                    <button class="carousel-next absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-2 rounded-full transition-colors">
                        <i data-feather="chevron-right" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.carousel-container {
    /* Mantiene el mismo tamaño que la imagen original */
    width: 100%;
    max-width: 100%;
}

.carousel-slides {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.carousel-slide {
    flex: 0 0 100%;
}

.carousel-indicator.active {
    background-color: white;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carouselSlides = document.querySelector('.carousel-slides');
    const indicators = document.querySelectorAll('.carousel-indicator');
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    
    let currentSlide = 0;
    const totalSlides = 4; // 4 imágenes
    const slideInterval = 3000; // 3 segundos
    
    // Función para mostrar slide específico
    function showSlide(slideIndex) {
        currentSlide = (slideIndex + totalSlides) % totalSlides;
        carouselSlides.style.transform = `translateX(-${currentSlide * 100}%)`;
        
        // Actualizar indicadores
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentSlide);
        });
    }
    
    // Función para siguiente slide
    function nextSlide() {
        showSlide(currentSlide + 1);
    }
    
    // Función para slide anterior
    function prevSlide() {
        showSlide(currentSlide - 1);
    }
    
    // Event listeners para botones
    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);
    
    // Event listeners para indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            showSlide(index);
        });
    });
    
    // Cambio automático cada 3 segundos
    let autoSlide = setInterval(nextSlide, slideInterval);
    
    // Pausar carrusel cuando el mouse está encima
    const carouselContainer = document.querySelector('.carousel-container');
    carouselContainer.addEventListener('mouseenter', () => {
        clearInterval(autoSlide);
    });
    
    carouselContainer.addEventListener('mouseleave', () => {
        autoSlide = setInterval(nextSlide, slideInterval);
    });
    
    // Inicializar primer indicador como activo
    indicators[0].classList.add('active');
    
    // Actualizar feather icons
    feather.replace();
});
</script>

<!-- Nuestra Comunidad en Cifras -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Nuestra Comunidad en Cifras</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Miles de estudiantes transformando su futuro con nosotros</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="stats-card text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="text-4xl font-bold mb-2">5,000+</div>
                    <div class="text-emerald-100">Estudiantes Activos</div>
                </div>
                <div class="stats-card text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="text-4xl font-bold mb-2">120+</div>
                    <div class="text-emerald-100">Programas Académicos</div>
                </div>
                <div class="stats-card text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="text-4xl font-bold mb-2">98%</div>
                    <div class="text-emerald-100">Tasa de Satisfacción</div>
                </div>
                <div class="stats-card text-center" data-aos="fade-up" data-aos-delay="400">
                    <div class="text-4xl font-bold mb-2">15</div>
                    <div class="text-emerald-100">Años de Experiencia</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Carreras con Efecto Flip Solo en la Imagen -->
<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Nuestras Carreras Destacadas</h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Descubre el futuro profesional que te espera en nuestras universidades</p>
        </div>

        <!-- Universidad Tecnológica Montemorelos -->
        <div class="mb-16">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Universidad Tecnológica Montemorelos</h3>
                <p class="text-gray-600">Excelencia educativa con visión global y enfoque en la innovación tecnológica</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <!-- Carrera 1: Desarrollo y Gestión de Software -->
            <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
                <div class="image-flip-container h-48 relative">
                    <!-- Frente de la imagen -->
                    <div class="image-flip-front absolute inset-0">
                        <img src="./plataforma/app/img/Desarrollo de Software.jpeg" alt="Desarrollo de Software" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <span class="text-white font-semibold">Ver detalles</span>
                        </div>
                    </div>

                    <!-- Parte trasera de la imagen -->
                    <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-green-600 to-green-800 text-white p-4 flex items-center justify-center">
                        <div class="text-center">
                            <h4 class="font-bold mb-2">Especialidades:</h4>
                            <ul class="text-sm text-green-100 space-y-1">
                                <li>• Programación full-stack</li>
                                <li>• Bases de datos</li>
                                <li>• Inteligencia artificial</li>
                                <li>• Ciberseguridad</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Tecnología</span>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Desarrollo y Gestión de Software</h3>
                    <p class="text-gray-600">Formación en desarrollo de software, gestión de proyectos tecnológicos y sistemas de información empresarial.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">TSU: 1.5 años | Ing: +1.5 años</span>
                        <a href="carreras.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                            Más info ›
                        </a>
                    </div>
                </div>
            </div>

            <!-- Carrera 2: Mantenimiento Industrial -->
            <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="image-flip-container h-48 relative">
                    <!-- Frente de la imagen -->
                    <div class="image-flip-front absolute inset-0">
                        <img src="./plataforma/app/img/IndustrialM.jpg" alt="Mantenimiento Industrial" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <span class="text-white font-semibold">Ver detalles</span>
                        </div>
                    </div>

                    <!-- Parte trasera de la imagen -->
                    <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-orange-600 to-orange-800 text-white p-4 flex items-center justify-center">
                        <div class="text-center">
                            <h4 class="font-bold mb-2">Especialidades:</h4>
                            <ul class="text-sm text-orange-100 space-y-1">
                                <li>• Gestión de mantenimiento</li>
                                <li>• Automatización</li>
                                <li>• Seguridad industrial</li>
                                <li>• Control de calidad</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <span class="inline-block bg-orange-100 text-orange-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Ingeniería</span>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Mantenimiento Industrial</h3>
                    <p class="text-gray-600">Especialización en mantenimiento de sistemas industriales, automatización y gestión de procesos productivos.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">TSU: 1.5 años | Ing: +1.5 años</span>
                        <a href="carreras.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                            Más info ›
                        </a>
                    </div>
                </div>
            </div>

            <!-- Carrera 3: Negocios Internacionales -->
            <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <div class="image-flip-container h-48 relative">
                    <!-- Frente de la imagen -->
                    <div class="image-flip-front absolute inset-0">
                        <img src="./plataforma/app/img/Negocios.jpg" alt="Negocios Internacionales" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <span class="text-white font-semibold">Ver detalles</span>
                        </div>
                    </div>

                    <!-- Parte trasera de la imagen -->
                    <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-800 text-white p-4 flex items-center justify-center">
                        <div class="text-center">
                            <h4 class="font-bold mb-2">Especialidades:</h4>
                            <ul class="text-sm text-blue-100 space-y-1">
                                <li>• Comercio exterior</li>
                                <li>• Marketing global</li>
                                <li>• Finanzas internacionales</li>
                                <li>• Logística</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Marketing Global</span>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Negocios Internacionales</h3>
                    <p class="text-gray-600">Formación en comercio exterior, logística internacional y gestión de negocios globales con visión estratégica.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">TSU: 1.5 años | Ing: +1.5 años</span>
                        <a href="carreras.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                            Más info ›
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Universidad Tecnológica Santa Catarina -->
        <div class="mb-16">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Universidad Tecnológica Santa Catarina</h3>
                <p class="text-gray-600">Innovación y tecnología de vanguardia con enfoque en el desarrollo sostenible</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <!-- Carrera 1: Inteligencia Artificial -->
                <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
                    <div class="image-flip-container h-48 relative">
                        <!-- Frente de la imagen -->
                        <div class="image-flip-front absolute inset-0">
                            <img src="https://images.unsplash.com/photo-1677442136019-21780ecad995?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Inteligencia Artificial" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <span class="text-white font-semibold">Ver detalles</span>
                            </div>
                        </div>

                        <!-- Parte trasera de la imagen -->
                        <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-purple-600 to-purple-800 text-white p-4 flex items-center justify-center">
                            <div class="text-center">
                                <h4 class="font-bold mb-2">Especialidades:</h4>
                                <ul class="text-sm text-purple-100 space-y-1">
                                    <li>• Machine learning</li>
                                    <li>• Visión por computadora</li>
                                    <li>• Chatbots inteligentes</li>
                                    <li>• IA ética</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">IA</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Inteligencia Artificial</h3>
                        <p class="text-gray-600">Desarrollo de sistemas inteligentes, machine learning y soluciones innovadoras con IA.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">TSU: 1.5 años | Ing: +1.5 años</span>
                            <a href="carreras.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                                Más info ›
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Carrera 2: Ciberseguridad -->
                <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="image-flip-container h-48 relative">
                        <!-- Frente de la imagen -->
                        <div class="image-flip-front absolute inset-0">
                            <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Ciberseguridad" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <span class="text-white font-semibold">Ver detalles</span>
                            </div>
                        </div>

                        <!-- Parte trasera de la imagen -->
                        <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-red-600 to-red-800 text-white p-4 flex items-center justify-center">
                            <div class="text-center">
                                <h4 class="font-bold mb-2">Especialidades:</h4>
                                <ul class="text-sm text-red-100 space-y-1">
                                    <li>• Análisis forense digital</li>
                                    <li>• Ethical hacking</li>
                                    <li>• Gestión de incidentes</li>
                                    <li>• Seguridad de infraestructuras</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Seguridad</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Ciberseguridad</h3>
                        <p class="text-gray-600">Protección de sistemas informáticos, análisis de vulnerabilidades y seguridad digital.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">TSU: 1.5 años | Ing: +1.5 años</span>
                            <a href="carreras.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                                Más info ›
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Carrera 3: Energías Renovables -->
                <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="image-flip-container h-48 relative">
                        <!-- Frente de la imagen -->
                        <div class="image-flip-front absolute inset-0">
                            <img src="https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Energías Renovables" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <span class="text-white font-semibold">Ver detalles</span>
                            </div>
                        </div>

                        <!-- Parte trasera de la imagen -->
                        <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-yellow-600 to-yellow-800 text-white p-4 flex items-center justify-center">
                            <div class="text-center">
                                <h4 class="font-bold mb-2">Especialidades:</h4>
                                <ul class="text-sm text-yellow-100 space-y-1">
                                    <li>• Sistemas fotovoltaicos</li>
                                    <li>• Energía eólica</li>
                                    <li>• Eficiencia energética</li>
                                    <li>• Biocombustibles</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Sostenibilidad</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Energías Renovables</h3>
                        <p class="text-gray-600">Desarrollo de sistemas de energía sostenible y tecnologías limpias para el futuro.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">TSU: 1.5 años | Ing: +1.5 años</span>
                            <a href="carreras.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                                Más info ›
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Universidad Tecnológica de Linares -->
        <div class="mb-16">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Universidad Tecnológica de Linares</h3>
                <p class="text-gray-600">Desarrollo regional con calidad educativa y compromiso social</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <!-- Carrera 1: Agrotecnología -->
                <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
                    <div class="image-flip-container h-48 relative">
                        <!-- Frente de la imagen -->
                        <div class="image-flip-front absolute inset-0">
                            <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Agrotecnología" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <span class="text-white font-semibold">Ver detalles</span>
                            </div>
                        </div>

                        <!-- Parte trasera de la imagen -->
                        <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-green-600 to-green-800 text-white p-4 flex items-center justify-center">
                            <div class="text-center">
                                <h4 class="font-bold mb-2">Especialidades:</h4>
                                <ul class="text-sm text-green-100 space-y-1">
                                    <li>• Agricultura de precisión</li>
                                    <li>• Riego tecnificado</li>
                                    <li>• Análisis de suelos</li>
                                    <li>• Bioinsumos</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Agroindustria</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Agrotecnología</h3>
                        <p class="text-gray-600">Aplicación de tecnología avanzada en la agricultura para optimizar producción y sostenibilidad.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">TSU: 1.5 años | Ing: +1.5 años</span>
                            <a href="carreras.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                                Más info ›
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Carrera 2: Turismo Sustentable -->
                <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="image-flip-container h-48 relative">
                        <!-- Frente de la imagen -->
                        <div class="image-flip-front absolute inset-0">
                            <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Turismo Sustentable" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <span class="text-white font-semibold">Ver detalles</span>
                            </div>
                        </div>

                        <!-- Parte trasera de la imagen -->
                        <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-800 text-white p-4 flex items-center justify-center">
                            <div class="text-center">
                                <h4 class="font-bold mb-2">Especialidades:</h4>
                                <ul class="text-sm text-blue-100 space-y-1">
                                    <li>• Ecoturismo</li>
                                    <li>• Patrimonio cultural</li>
                                    <li>• Marketing turístico</li>
                                    <li>• Gestión sostenible</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Turismo</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Turismo Sustentable</h3>
                        <p class="text-gray-600">Gestión de destinos turísticos con enfoque en sostenibilidad y desarrollo local.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">TSU: 1.5 años | Ing: +1.5 años</span>
                            <a href="carreras.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                                Más info ›
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Carrera 3: Logística y Transporte -->
                <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="image-flip-container h-48 relative">
                        <!-- Frente de la imagen -->
                        <div class="image-flip-front absolute inset-0">
                            <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Logística y Transporte" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                <span class="text-white font-semibold">Ver detalles</span>
                            </div>
                        </div>

                        <!-- Parte trasera de la imagen -->
                        <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-orange-600 to-orange-800 text-white p-4 flex items-center justify-center">
                            <div class="text-center">
                                <h4 class="font-bold mb-2">Especialidades:</h4>
                                <ul class="text-sm text-orange-100 space-y-1">
                                    <li>• Cadena de suministro</li>
                                    <li>• Comercio exterior</li>
                                    <li>• Planificación de rutas</li>
                                    <li>• Gestión de almacenes</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <span class="inline-block bg-orange-100 text-orange-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Logística</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Logística y Transporte</h3>
                        <p class="text-gray-600">Optimización de cadenas de suministro y gestión eficiente del transporte.</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm text-gray-500">TSU: 1.5 años | Ing: +1.5 años</span>
                            <a href="carreras.php" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                                Más info ›
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
            
            
        </div>
    </div>

    <!-- Blog / Noticias Recientes -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <div data-aos="fade-right">
                    <h2 class="text-3xl font-extrabold text-gray-900">Noticias y Actualizaciones</h2>
                    <p class="mt-2 text-lg text-gray-500">Mantente informado sobre lo último en UTSC</p>
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="news-card bg-white rounded-lg overflow-hidden shadow-md" data-aos="fade-up">
                    <img class="w-full h-48 object-cover" src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Beca Santander">
                    <div class="p-6">
                        <span class="inline-block bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs font-semibold px-2.5 py-0.5 rounded mb-2">Novedad</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Beca Santander Media Manutención 2025</h3>
                        <p class="text-gray-600 mb-4">Ya está disponible la beca de Grupo Santander para estudiantes de la UTSC Montemorelos, apoyando la manutención durante el ciclo escolar 2025.</p>
                        <button onclick="showNewsModal('beca-santander')" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium flex items-center">
                            Leer más
                            <i data-feather="arrow-right" class="ml-1 w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="news-card bg-white rounded-lg overflow-hidden shadow-md" data-aos="fade-up" data-aos-delay="100">
                    <img class="w-full h-48 object-cover" src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="FIL Monterrey">
                    <div class="p-6">
                        <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">Evento</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Presencia en FIL Monterrey 2025</h3>
                        <p class="text-gray-600 mb-4">La UT Santa Catarina, incluyendo la unidad Montemorelos, participó en la inauguración de la Feria Internacional del Libro Monterrey 2025.</p>
                        <button onclick="showNewsModal('fil-monterrey')" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium flex items-center">
                            Leer más
                            <i data-feather="arrow-right" class="ml-1 w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="news-card bg-white rounded-lg overflow-hidden shadow-md" data-aos="fade-up" data-aos-delay="200">
                    <img class="w-full h-48 object-cover" src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Graduación">
                    <div class="p-6">
                        <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">Logro</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Backstage Graduación UTSC 2025</h3>
                        <p class="text-gray-600 mb-4">Felicitaciones a los graduados de la Universidad Tecnológica de Santa Catarina en la ceremonia de septiembre 2025.</p>
                        <button onclick="showNewsModal('graduacion')" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium flex items-center">
                            Leer más
                            <i data-feather="arrow-right" class="ml-1 w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Interactivo -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Explora Nuestro Campus Virtual</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Descubre todo lo que tenemos para ofrecerte</p>
            </div>
            
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Video Institucional -->
                <div id="video-institucional" data-aos="fade-right">
                    <div class="campus-map-container bg-white p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Video Institucional</h3>
                        <div class="bg-black rounded-lg overflow-hidden shadow-lg" style="position: relative; padding-bottom: 56.25%; height: 0;">
                            <iframe
                                id="video-iframe"
                                src="https://www.youtube.com/embed/dMSyje4103g"
                                title="Video Institucional UTSC"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                            </iframe>
                        </div>
                    </div>
                </div>
                
                <!-- Universidades Disponibles -->
                <div data-aos="fade-left">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Nuestras Universidades</h3>
                    <div class="space-y-4">
                        <div class="career-selector bg-white p-4 rounded-lg shadow-sm border border-gray-100 cursor-pointer flex items-center">
                            <div class="w-10 h-10 rounded-full bg-[var(--ut-green-100)] text-[var(--ut-green-700)] flex items-center justify-center mr-4">
                                <i data-feather="book" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Universidad Tecnológica Montemorelos</h4>
                                <p class="text-sm text-gray-500">6 carreras disponibles</p>
                            </div>
                        </div>

                        <div class="career-selector bg-white p-4 rounded-lg shadow-sm border border-gray-100 cursor-pointer flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center mr-4">
                                <i data-feather="award" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Universidad Tecnológica Santa Catarina</h4>
                                <p class="text-sm text-gray-500">7 carreras disponibles</p>
                            </div>
                        </div>

                        <div class="career-selector bg-white p-4 rounded-lg shadow-sm border border-gray-100 cursor-pointer flex items-center">
                            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center mr-4">
                                <i data-feather="map-pin" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Universidad Tecnológica de Linares</h4>
                                <p class="text-sm text-gray-500">8 carreras disponibles</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="carreras.php" class="inline-flex items-center text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium">
                            Explorar todas las carreras
                            <i data-feather="arrow-right" class="ml-2 w-5 h-5"></i>
                        </a>
                    </div>
                </div>
            </div>
        
        </div>
    </div>

    <!-- Inscripciones Section -->
    <div style="background:linear-gradient(180deg,var(--ut-green-800),var(--ut-green-900));" class="text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl mb-4">Inscripciones Abiertas</h2>
                <p class="text-lg text-emerald-100 mb-8 max-w-2xl mx-auto">Realiza tu inscripción en nuestras universidades tecnológicas y comienza tu camino hacia el éxito académico</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="registro.php" class="bg-white text-[var(--ut-green-800)] hover:bg-gray-100 px-6 py-3 rounded-md text-lg font-semibold transition">Inscribirme Ahora</a>
                    <a href="mailto:contacto@UTSC.edu?subject=Solicitud%20de%20Información%20sobre%20Inscripciones&body=Hola,%20me%20gustaría%20obtener%20más%20información%20sobre%20las%20inscripciones%20en%20la%20UTSC.%20Por%20favor,%20contáctenme%20para%20asesorarme." class="border-2 border-white text-white hover:bg-white hover:text-[var(--ut-green-800)] px-6 py-3 rounded-md text-lg font-semibold transition" onclick="alert('Se abrirá tu cliente de correo electrónico para contactar al asesor.')">Contactar Asesor</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para noticias -->
    <div id="news-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 id="modal-title" class="text-2xl font-bold text-gray-900"></h3>
                        <button onclick="closeNewsModal()" class="text-gray-500 hover:text-gray-700">
                            <i data-feather="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                    <div id="modal-content" class="text-gray-600"></div>
                </div>
            </div>
        </div>
    </div>

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

        // Navegación por anclas
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
        
        // Función para abrir Google Maps con la ubicación de la universidad
        function openGoogleMaps() {
            const url = 'https://maps.app.goo.gl/7sFQrFoVAPTGma3n8';
            window.open(url, '_blank');
        }

        // Función para reproducir el video en bucle
        function playVideo() {
            const iframe = document.getElementById('video-iframe');
            const src = iframe.src;
            // Agregar parámetros para autoplay y loop
            const newSrc = src + '?autoplay=1&loop=1&playlist=' + src.split('/').pop();
            iframe.src = newSrc;
            // Scroll suave al video
            document.getElementById('video-institucional').scrollIntoView({ behavior: 'smooth' });
        }

        // Función para mostrar modal de noticias
        function showNewsModal(newsType) {
            const modal = document.getElementById('news-modal');
            const title = document.getElementById('modal-title');
            const content = document.getElementById('modal-content');

            const newsData = {
                'beca-santander': {
                    title: 'Beca Santander Media Manutención 2025',
                    content: `
                        <p class="mb-4">La Universidad Tecnológica de Santa Catarina (UTSC) Montemorelos se complace en anunciar que ya está disponible la Beca Santander Media Manutención 2025.</p>
                        <p class="mb-4">Esta beca, proporcionada por Grupo Santander, tiene como objetivo apoyar a los estudiantes de la UTSC Montemorelos durante el ciclo escolar 2025, cubriendo parcialmente los gastos de manutención.</p>
                        <p class="mb-4"><strong>Requisitos:</strong></p>
                        <ul class="list-disc list-inside mb-4">
                            <li>Ser estudiante activo de la UTSC Montemorelos</li>
                            <li>Mantener un promedio mínimo de 8.0</li>
                            <li>Presentar solicitud antes del 31 de enero de 2025</li>
                        </ul>
                        <p>Para más información, contacta a la oficina de becas al correo: becas@utsc.edu.mx</p>
                    `
                },
                'fil-monterrey': {
                    title: 'Presencia en FIL Monterrey 2025',
                    content: `
                        <p class="mb-4">La Universidad Tecnológica de Santa Catarina, incluyendo su unidad en Montemorelos, participó activamente en la inauguración de la Feria Internacional del Libro Monterrey 2025.</p>
                        <p class="mb-4">Nuestros representantes tuvieron la oportunidad de presentar los programas académicos innovadores que ofrecemos, destacando las carreras en tecnología, negocios y energías renovables.</p>
                        <p class="mb-4">Durante el evento, se realizaron alianzas estratégicas con editoriales y se presentó el nuevo catálogo de publicaciones académicas de la UTSC.</p>
                        <p>La participación en FIL Monterrey reafirma nuestro compromiso con la educación y la cultura en la región noreste de México.</p>
                    `
                },
                'graduacion': {
                    title: 'Backstage Graduación UTSC 2025',
                    content: `
                        <p class="mb-4">¡Felicitaciones a todos los graduados de la Universidad Tecnológica de Santa Catarina en la ceremonia de septiembre 2025!</p>
                        <p class="mb-4">La ceremonia de graduación fue un evento memorable donde se reconoció el esfuerzo y dedicación de nuestros estudiantes. Más de 500 egresados recibieron su título en diversas disciplinas tecnológicas.</p>
                        <p class="mb-4"><strong>Destacados del evento:</strong></p>
                        <ul class="list-disc list-inside mb-4">
                            <li>Discurso inaugural del Rector Dr. Roberto Silva</li>
                            <li>Reconocimientos especiales a estudiantes destacados</li>
                            <li>Presentación musical de la Orquesta Sinfónica de la UTSC</li>
                            <li>Cena de gala con familiares y amigos</li>
                        </ul>
                        <p>Los graduados de 2025 están preparados para liderar la transformación tecnológica en México y el mundo. ¡Les deseamos el mayor de los éxitos!</p>
                    `
                }
            };

            if (newsData[newsType]) {
                title.textContent = newsData[newsType].title;
                content.innerHTML = newsData[newsType].content;
                modal.classList.remove('hidden');
                feather.replace();
            }
        }

        // Función para cerrar modal de noticias
        function closeNewsModal() {
            document.getElementById('news-modal').classList.add('hidden');
        }

        // Interactividad para el selector de carreras
        document.querySelectorAll('.career-selector').forEach(item => {
            item.addEventListener('click', function() {
                // Remover clase activa de todos
                document.querySelectorAll('.career-selector').forEach(el => {
                    el.classList.remove('border-[var(--ut-green-500)]', 'bg-[var(--ut-green-50)]');
                });

                // Agregar clase activa al seleccionado
                this.classList.add('border-[var(--ut-green-500)]', 'bg-[var(--ut-green-50)]');
            });
        });
    </script>
</body>
</html>