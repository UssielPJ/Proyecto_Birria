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
                    <a href="cursos.php" class="bg-white text-[var(--ut-green-800)] hover:bg-gray-100 px-6 py-3 rounded-md text-lg font-semibold transition">Explorar Cursos</a>
                    <a href="#" class="border-2 border-white text-white hover:bg-white hover:text-[var(--ut-green-800)] px-6 py-3 rounded-md text-lg font-semibold transition">Ver Video</a>
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
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Descubre el futuro profesional que te espera</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Carrera 1: Negocios Internacionales -->
            <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
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
                    <p class="text-gray-600">Formación en comercio global y estrategias de mercado internacional.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">Duración: 4 años</span>
                        <a href="#" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                            Más info ›
                        </a>
                    </div>
                </div>
            </div>

            <!-- Carrera 2: Desarrollo y Gestión de Software -->
            <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="image-flip-container h-48 relative">
                    <!-- Frente de la imagen -->
                    <div class="image-flip-front absolute inset-0">
                        <img src="./plataforma/app/img/CorrecaminosUT.jpg" alt="Desarrollo de Software" class="w-full h-full object-cover">
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
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Desarrollo de Software</h3>
                    <p class="text-gray-600">Crea soluciones tecnológicas que transformen el mundo digital.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">Duración: 4 años</span>
                        <a href="#" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                            Más info ›
                        </a>
                    </div>
                </div>
            </div>

            <!-- Carrera 3: Mantenimiento Industrial -->
            <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
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
                    <p class="text-gray-600">Optimiza procesos productivos y garantiza la eficiencia operativa.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">Duración: 4 años</span>
                        <a href="#" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                            Más info ›
                        </a>
                    </div>
                </div>
            </div>

            <!-- Carrera 4: Mecatrónica -->
            <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                <div class="image-flip-container h-48 relative">
                    <!-- Frente de la imagen -->
                    <div class="image-flip-front absolute inset-0">
                        <img src="./plataforma/app/img/mecatronica7.jpg" alt="Mecatrónica" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <span class="text-white font-semibold">Ver detalles</span>
                        </div>
                    </div>
                    
                    <!-- Parte trasera de la imagen -->
                    <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-purple-600 to-purple-800 text-white p-4 flex items-center justify-center">
                        <div class="text-center">
                            <h4 class="font-bold mb-2">Especialidades:</h4>
                            <ul class="text-sm text-purple-100 space-y-1">
                                <li>• Robótica industrial</li>
                                <li>• Control automático</li>
                                <li>• Sensores y actuadores</li>
                                <li>• IoT industrial</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Robótica</span>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Mecatrónica</h3>
                    <p class="text-gray-600">Integra mecánica, electrónica e informática para crear sistemas inteligentes.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">Duración: 4 años</span>
                        <a href="#" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                            Más info ›
                        </a>
                    </div>
                </div>
            </div>

            <!-- Carrera 5: Lengua Inglesa -->
            <div class="career-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="400">
                <div class="image-flip-container h-48 relative">
                    <!-- Frente de la imagen -->
                    <div class="image-flip-front absolute inset-0">
                        <img src="./plataforma/app/img/CorrecaminosUT.jpg" alt="Lengua Inglesa" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                            <span class="text-white font-semibold">Ver detalles</span>
                        </div>
                    </div>
                    
                    <!-- Parte trasera de la imagen -->
                    <div class="image-flip-back absolute inset-0 bg-gradient-to-br from-red-600 to-red-800 text-white p-4 flex items-center justify-center">
                        <div class="text-center">
                            <h4 class="font-bold mb-2">Especialidades:</h4>
                            <ul class="text-sm text-red-100 space-y-1">
                                <li>• Inglés técnico</li>
                                <li>• Traducción</li>
                                <li>• Comunicación intercultural</li>
                                <li>• Enseñanza del inglés</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full mb-3">Idiomas</span>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Lengua Inglesa</h3>
                    <p class="text-gray-600">Domina el idioma global para negocios, tecnología y comunicación internacional.</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500">Duración: 4 años</span>
                        <a href="#" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] text-sm font-medium">
                            Más info ›
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <a href="nosotros.php" class="inline-flex items-center bg-[var(--ut-green-600)] hover:bg-[var(--ut-green-700)] text-white px-8 py-4 rounded-lg font-semibold transition transform hover:scale-105 shadow-lg">
                <i data-feather="book-open" class="mr-3 w-5 h-5"></i>
                Conoce Todas Nuestras Carreras
            </a>
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
                <a href="#" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium" data-aos="fade-left">Ver todas →</a>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="news-card bg-white rounded-lg overflow-hidden shadow-md" data-aos="fade-up">
                    <img class="w-full h-48 object-cover" src="./plataforma/app/img/IndustrialM.jpg" alt="Nuevo programa">
                    <div class="p-6">
                        <span class="inline-block bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs font-semibold px-2.5 py-0.5 rounded mb-2">Novedad</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Lanzamos Nuevo Programa de IA</h3>
                        <p class="text-gray-600 mb-4">Conoce nuestro nuevo programa especializado en Inteligencia Artificial con enfoque industrial.</p>
                        <a href="#" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium flex items-center">
                            Leer más
                            <i data-feather="arrow-right" class="ml-1 w-4 h-4"></i>
                        </a>
                    </div>
                </div>
                
                <div class="news-card bg-white rounded-lg overflow-hidden shadow-md" data-aos="fade-up" data-aos-delay="100">
                    <img class="w-full h-48 object-cover" src="./plataforma/app/img/Negocios.jpg" alt="Evento académico">
                    <div class="p-6">
                        <span class="inline-block bg-purple-100 text-purple-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">Evento</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Congreso Internacional de Negocios</h3>
                        <p class="text-gray-600 mb-4">Participa en nuestro congreso anual con expertos internacionales en negocios globales.</p>
                        <a href="#" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium flex items-center">
                            Leer más
                            <i data-feather="arrow-right" class="ml-1 w-4 h-4"></i>
                        </a>
                    </div>
                </div>
                
                <div class="news-card bg-white rounded-lg overflow-hidden shadow-md" data-aos="fade-up" data-aos-delay="200">
                    <img class="w-full h-48 object-cover" src="./plataforma/app/img/Mecatronica.jpg" alt="Logro estudiantil">
                    <div class="p-6">
                        <span class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">Logro</span>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Estudiantes Ganadores de Competencia</h3>
                        <p class="text-gray-600 mb-4">Nuestro equipo de Mecatrónica gana primer lugar en competencia nacional de robótica.</p>
                        <a href="#" class="text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium flex items-center">
                            Leer más
                            <i data-feather="arrow-right" class="ml-1 w-4 h-4"></i>
                        </a>
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
                <!-- Mapa Interactivo -->
                <div data-aos="fade-right">
                    <div class="campus-map-container bg-white p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Recorrido Virtual por el Campus</h3>
                        <div class="bg-gradient-to-br from-[var(--ut-green-100)] to-emerald-50 h-64 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <i data-feather="map" class="w-12 h-12 text-[var(--ut-green-600)] mx-auto mb-3"></i>
                                <p class="text-gray-600">Haz clic para explorar nuestro campus virtual</p>
                                <button class="mt-4 bg-[var(--ut-green-600)] hover:bg-[var(--ut-green-700)] text-white px-4 py-2 rounded-md font-medium transition">
                                    Iniciar Recorrido
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Selector de Carreras -->
                <div data-aos="fade-left">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Encuentra Tu Carrera Ideal</h3>
                    <div class="space-y-4">
                        <div class="career-selector bg-white p-4 rounded-lg shadow-sm border border-gray-100 cursor-pointer flex items-center">
                            <div class="w-10 h-10 rounded-full bg-[var(--ut-green-100)] text-[var(--ut-green-700)] flex items-center justify-center mr-4">
                                <i data-feather="cpu" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Tecnologías de la Información</h4>
                                <p class="text-sm text-gray-500">8 programas disponibles</p>
                            </div>
                        </div>
                        
                        <div class="career-selector bg-white p-4 rounded-lg shadow-sm border border-gray-100 cursor-pointer flex items-center">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center mr-4">
                                <i data-feather="briefcase" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Negocios y Administración</h4>
                                <p class="text-sm text-gray-500">6 programas disponibles</p>
                            </div>
                        </div>
                        
                        <div class="career-selector bg-white p-4 rounded-lg shadow-sm border border-gray-100 cursor-pointer flex items-center">
                            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center mr-4">
                                <i data-feather="settings" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900">Ingeniería y Manufactura</h4>
                                <p class="text-sm text-gray-500">10 programas disponibles</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <a href="#" class="inline-flex items-center text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium">
                            Explorar todas las carreras
                            <i data-feather="arrow-right" class="ml-2 w-5 h-5"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Video Destacado -->
            <div class="mt-16" data-aos="fade-up">
                <div class="video-container bg-gradient-to-r from-[var(--ut-green-800)] to-[var(--ut-green-900)] p-8 text-white">
                    <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                        <div>
                            <h3 class="text-2xl font-bold mb-4">Conoce Nuestra Historia</h3>
                            <p class="text-emerald-100 mb-6">Descubre cómo hemos transformado la educación tecnológica durante más de 15 años.</p>
                            <a href="registro.php" class="bg-white text-[var(--ut-green-800)] hover:bg-gray-100 px-6 py-3 rounded-md text-lg font-semibold transition inline-block">
                                Únete a Nosotros
                            </a>
                        </div>
                        <div class="mt-6 lg:mt-0 flex justify-center">
                            <div class="relative w-full max-w-md">
                                <div class="bg-black/30 rounded-lg h-48 flex items-center justify-center">
                                    <button class="bg-white/20 hover:bg-white/30 rounded-full p-4 transition">
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
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Conoce a Nuestros Expertos</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Profesionales con experiencia que guiarán tu aprendizaje</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="docente-card text-center" data-aos="fade-up">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-cyan-400 to-emerald-400 mx-auto mb-4 flex items-center justify-center text-white font-bold text-xl">DR</div>
                    <h3 class="text-lg font-bold text-gray-900">Dr. Roberto Silva</h3>
                    <p class="text-gray-600 mb-3">Director de Ingeniería</p>
                    <div class="flex justify-center space-x-1 mb-4">
                        <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs px-2 py-1 rounded">IA</span>
                        <span class="specialty-chip bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">Robótica</span>
                    </div>
                    <button class="btn-docente w-full py-2 rounded-md text-sm font-medium transition">Ver Perfil</button>
                </div>
                
                <div class="docente-card text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 mx-auto mb-4 flex items-center justify-center text-white font-bold text-xl">MG</div>
                    <h3 class="text-lg font-bold text-gray-900">Mtra. Gabriela Ortega</h3>
                    <p class="text-gray-600 mb-3">Coordinadora de Negocios</p>
                    <div class="flex justify-center space-x-1 mb-4">
                        <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs px-2 py-1 rounded">Marketing</span>
                        <span class="specialty-chip bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Finanzas</span>
                    </div>
                    <button class="btn-docente w-full py-2 rounded-md text-sm font-medium transition">Ver Perfil</button>
                </div>
                
                <div class="docente-card text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-amber-400 to-orange-400 mx-auto mb-4 flex items-center justify-center text-white font-bold text-xl">JC</div>
                    <h3 class="text-lg font-bold text-gray-900">Ing. Javier Cortés</h3>
                    <p class="text-gray-600 mb-3">Especialista en Mecatrónica</p>
                    <div class="flex justify-center space-x-1 mb-4">
                        <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs px-2 py-1 rounded">Automatización</span>
                        <span class="specialty-chip bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">IoT</span>
                    </div>
                    <button class="btn-docente w-full py-2 rounded-md text-sm font-medium transition">Ver Perfil</button>
                </div>
                
                <div class="docente-card text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-green-400 to-cyan-400 mx-auto mb-4 flex items-center justify-center text-white font-bold text-xl">AP</div>
                    <h3 class="text-lg font-bold text-gray-900">Dra. Ana Pérez</h3>
                    <p class="text-gray-600 mb-3">Investigadora en Biotecnología</p>
                    <div class="flex justify-center space-x-1 mb-4">
                        <span class="specialty-chip bg-[var(--ut-green-100)] text-[var(--ut-green-800)] text-xs px-2 py-1 rounded">Bioingeniería</span>
                        <span class="specialty-chip bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded">Nanotecnología</span>
                    </div>
                    <button class="btn-docente w-full py-2 rounded-md text-sm font-medium transition">Ver Perfil</button>
                </div>
            </div>
            
            <div class="text-center mt-12">
                <a href="#" class="inline-flex items-center text-[var(--ut-green-700)] hover:text-[var(--ut-green-900)] font-medium">
                    Conocer todo el equipo académico
                    <i data-feather="arrow-right" class="ml-2 w-5 h-5"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div style="background:linear-gradient(180deg,var(--ut-green-800),var(--ut-green-900));" class="text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl mb-4">¿Listo para Transformar Tu Futuro?</h2>
                <p class="text-lg text-emerald-100 mb-8 max-w-2xl mx-auto">Únete a nuestra comunidad de más de 5,000 estudiantes que están construyendo el futuro de la tecnología</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="registro.php" class="bg-white text-[var(--ut-green-800)] hover:bg-gray-100 px-6 py-3 rounded-md text-lg font-semibold transition">Crear Cuenta Gratuita</a>
                    <a href="mailto:contacto@utec.edu" class="border-2 border-white text-white hover:bg-white hover:text-[var(--ut-green-800)] px-6 py-3 rounded-md text-lg font-semibold transition">Contactar Asesor</a>
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