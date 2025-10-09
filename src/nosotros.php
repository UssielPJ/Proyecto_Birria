<?php
// nosotros.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
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
</head>
<body class="font-sans antialiased text-gray-800">

<?php include 'navbar.php'; ?>


<!-- Hero Section -->
<section class="hero-nosotros text-white py-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center" data-aos="fade-up">
      <h1 class="text-4xl md:text-6xl font-extrabold mb-6">Nuestra Historia</h1>
      <p class="text-xl md:text-2xl text-emerald-100 max-w-3xl mx-auto">
        Más de 15 años formando profesionales que transforman el mundo a través de la tecnología y la innovación
      </p>
    </div>
  </div>
</section>

<!-- Estadísticas Mejoradas -->
<section class="bg-white py-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
        Nuestra Trayectoria en 
        <span class="text-[var(--ut-green-600)]">Cifras</span>
      </h2>
      <p class="text-xl text-gray-600 max-w-2xl mx-auto">
        Resultados tangibles que respaldan nuestra excelencia educativa
      </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      <!-- Años de Experiencia -->
      <div class="text-center" data-aos="fade-up">
        <div class="relative bg-gradient-to-br from-[var(--ut-green-50)] to-white rounded-2xl p-8 border border-[var(--ut-green-100)] shadow-lg transition-all duration-300">
          <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
            <div class="w-12 h-12 bg-gradient-to-r from-[var(--ut-green-500)] to-[var(--ut-green-600)] rounded-full flex items-center justify-center shadow-lg">
              <i data-feather="award" class="w-6 h-6 text-white"></i>
            </div>
          </div>
          <div class="mt-4">
            <div class="text-4xl font-bold text-[var(--ut-green-700)] mb-2 count-up" data-target="15">0</div>
            <div class="text-[var(--ut-green-600)] font-semibold">Años de Experiencia</div>
            <p class="text-gray-600 text-sm mt-3">
              Formando profesionales desde 2009
            </p>
          </div>
        </div>
      </div>
      
      <!-- Estudiantes Graduados -->
      <div class="text-center" data-aos="fade-up" data-aos-delay="100">
        <div class="relative bg-gradient-to-br from-[var(--ut-green-50)] to-white rounded-2xl p-8 border border-[var(--ut-green-100)] shadow-lg transition-all duration-300">
          <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
            <div class="w-12 h-12 bg-gradient-to-r from-[var(--ut-green-500)] to-[var(--ut-green-600)] rounded-full flex items-center justify-center shadow-lg">
              <i data-feather="users" class="w-6 h-6 text-white"></i>
            </div>
          </div>
          <div class="mt-4">
            <div class="text-4xl font-bold text-[var(--ut-green-700)] mb-2 count-up" data-target="5000">0</div>
            <div class="text-[var(--ut-green-600)] font-semibold">Estudiantes Graduados</div>
            <p class="text-gray-600 text-sm mt-3">
              Profesionales exitosos en el mercado laboral
            </p>
          </div>
        </div>
      </div>
      
      <!-- Programas Académicos -->
      <div class="text-center" data-aos="fade-up" data-aos-delay="200">
        <div class="relative bg-gradient-to-br from-[var(--ut-green-50)] to-white rounded-2xl p-8 border border-[var(--ut-green-100)] shadow-lg transition-all duration-300">
          <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
            <div class="w-12 h-12 bg-gradient-to-r from-[var(--ut-green-500)] to-[var(--ut-green-600)] rounded-full flex items-center justify-center shadow-lg">
              <i data-feather="book-open" class="w-6 h-6 text-white"></i>
            </div>
          </div>
          <div class="mt-4">
            <div class="text-4xl font-bold text-[var(--ut-green-700)] mb-2 count-up" data-target="25">0</div>
            <div class="text-[var(--ut-green-600)] font-semibold">Programas Académicos</div>
            <p class="text-gray-600 text-sm mt-3">
              Carreras de vanguardia y alta demanda
            </p>
          </div>
        </div>
      </div>
      
      <!-- Convenios Internacionales -->
      <div class="text-center" data-aos="fade-up" data-aos-delay="300">
        <div class="relative bg-gradient-to-br from-[var(--ut-green-50)] to-white rounded-2xl p-8 border border-[var(--ut-green-100)] shadow-lg transition-all duration-300">
          <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
            <div class="w-12 h-12 bg-gradient-to-r from-[var(--ut-green-500)] to-[var(--ut-green-600)] rounded-full flex items-center justify-center shadow-lg">
              <i data-feather="globe" class="w-6 h-6 text-white"></i>
            </div>
          </div>
          <div class="mt-4">
            <div class="text-4xl font-bold text-[var(--ut-green-700)] mb-2 count-up" data-target="50">0</div>
            <div class="text-[var(--ut-green-600)] font-semibold">Convenios Internacionales</div>
            <p class="text-gray-600 text-sm mt-3">
              Alianzas estratégicas globales
            </p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Línea decorativa -->
    <div class="text-center mt-12" data-aos="fade-up">
      <div class="inline-flex items-center gap-3 text-[var(--ut-green-600)] bg-[var(--ut-green-50)] px-6 py-3 rounded-full border border-[var(--ut-green-200)]">
        <i data-feather="trending-up" class="w-5 h-5"></i>
        <span class="font-semibold">Creciendo contigo hacia el futuro</span>
      </div>
    </div>
  </div>
</section>

<script>
// Animación de conteo
document.addEventListener('DOMContentLoaded', function() {
  const countUpElements = document.querySelectorAll('.count-up');
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const element = entry.target;
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
          current += step;
          if (current >= target) {
            element.textContent = target + '+';
            clearInterval(timer);
          } else {
            element.textContent = Math.floor(current);
          }
        }, 16);
        
        observer.unobserve(element);
      }
    });
  }, { threshold: 0.5 });
  
  countUpElements.forEach(element => {
    observer.observe(element);
  });
});
</script>

<!-- Misión, Visión y Valores -->
<section class="bg-gray-50 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Nuestra Esencia</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Los pilares que nos definen y guían nuestro camino</p>
    </div>
    
    <div class="grid md:grid-cols-3 gap-8">
      <div class="value-card bg-white p-8 rounded-xl shadow-lg" data-aos="fade-up">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i data-feather="target" class="w-8 h-8 text-blue-600"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 text-center mb-4">Misión</h3>
        <p class="text-gray-600 text-center">
          Formar profesionales de excelencia en el ámbito tecnológico mediante programas educativos innovadores, 
          fomentando el desarrollo integral y el compromiso con la sociedad.
        </p>
      </div>
      
      <div class="value-card bg-white p-8 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="100">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i data-feather="eye" class="w-8 h-8 text-green-600"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 text-center mb-4">Visión</h3>
        <p class="text-gray-600 text-center">
          Ser la institución líder en educación tecnológica, reconocida por nuestra innovación, 
          calidad académica y contribución al desarrollo sostenible de nuestra región.
        </p>
      </div>
      
      <div class="value-card bg-white p-8 rounded-xl shadow-lg" data-aos="fade-up" data-aos-delay="200">
        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6 mx-auto">
          <i data-feather="heart" class="w-8 h-8 text-purple-600"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 text-center mb-4">Valores</h3>
        <ul class="text-gray-600 space-y-2">
          <li class="flex items-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 mr-2"></i>
            Excelencia académica
          </li>
          <li class="flex items-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 mr-2"></i>
            Innovación constante
          </li>
          <li class="flex items-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 mr-2"></i>
            Responsabilidad social
          </li>
          <li class="flex items-center">
            <i data-feather="check" class="w-4 h-4 text-green-500 mr-2"></i>
            Integridad y ética
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Historia y Línea de Tiempo -->
<section class="bg-white py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-2 gap-12 items-start">
      <div data-aos="fade-right">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Nuestra Historia</h2>
        <p class="text-gray-600 text-lg mb-6">
          Fundada en 2008, la Universidad Tecnológica de Santa Catarina inició su trayecto con la visión 
          de revolucionar la educación tecnológica en la región. Desde nuestros humildes comienzos con 
          apenas 3 programas académicos, hemos crecido hasta convertirnos en una institución de referencia 
          con presencia en múltiples campus.
        </p>
        <p class="text-gray-600 text-lg">
          Nuestro compromiso con la innovación y la excelencia nos ha permitido establecer alianzas 
          estratégicas con empresas líderes en el sector tecnológico, garantizando que nuestros estudiantes 
          reciban una educación de vanguardia que los prepare para los desafíos del futuro.
        </p>
      </div>
      
      <div data-aos="fade-left">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">Hitos Importantes</h3>
        <div class="space-y-6">
          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900">2008 - Fundación</h4>
            <p class="text-gray-600">Inauguración del primer campus con 3 programas de ingeniería</p>
          </div>
          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900">2012 - Expansión</h4>
            <p class="text-gray-600">Apertura del segundo campus y lanzamiento de 5 nuevos programas</p>
          </div>
          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900">2016 - Internacionalización</h4>
            <p class="text-gray-600">Establecimiento de los primeros convenios internacionales</p>
          </div>
          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900">2020 - Transformación Digital</h4>
            <p class="text-gray-600">Implementación completa de plataforma e-learning y laboratorios virtuales</p>
          </div>
          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <h4 class="text-lg font-semibold text-gray-900">2024 - Liderazgo</h4>
            <p class="text-gray-600">Reconocimiento como la universidad tecnológica #1 en innovación educativa</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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
          </div>
        </div>
      </div>
      
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
          </div>
        </div>
      </div>
      
      <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
        <div class="relative">
          <img src="./plataforma/app/img/Negocios.jpg" alt="Foro de Innovación" class="w-full h-48 object-cover">
          <div class="absolute top-4 right-4 bg-purple-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
            Emprendimiento
          </div>
        </div>
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-3">Innovación Empresarial</h3>
          <p class="text-gray-600 mb-4">Startups y modelos de negocio disruptivos desarrollados por futuros empresarios.</p>
          <div class="flex items-center justify-between">
            <div class="flex items-center text-sm text-gray-500">
              <i data-feather="trending-up" class="w-4 h-4 mr-1"></i>
              Negocios
            </div>
            <button class="text-green-600 hover:text-green-700 font-medium text-sm flex items-center gap-1">
              Ver Proyecto
              <i data-feather="arrow-right" class="w-4 h-4"></i>
            </button>
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
<section class="bg-white py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Nuestros Planteles</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Infraestructura de vanguardia para una educación de excelencia</p>
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Campus Central -->
      <div class="campus-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
        <img src="./plataforma/app/img/PlantelUT.jpg" alt="Campus Central" class="w-full h-48 object-cover">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-2">Campus Montemorelos</h3>
          <p class="text-gray-600 mb-4">Extensión de la Universidad Tecnologica Santa Catarina, con laboratorios especializados, biblioteca digital y áreas de innovación.</p>
          <div class="flex items-center justify-between">
            <div class="flex items-center text-sm text-[var(--ut-green-700)]">
              <i data-feather="users" class="w-4 h-4 mr-1"></i>
              250+ estudiantes
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
          <h3 class="text-xl font-bold text-gray-900 mb-2">Campus Santa Catarina</h3>
          <p class="text-gray-600 mb-4">Campus principal, ingenierías avanzadas con talleres de manufactura y prototipado.</p>
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
          <h3 class="text-xl font-bold text-gray-900 mb-2">Campus de Linares</h3>
          <p class="text-gray-600 mb-4">Enfoque en emprendimiento tecnológico y desarrollo de startups estudiantiles.</p>
          <div class="flex items-center justify-between">
            <div class="flex items-center text-sm text-[var(--ut-green-700)]">
              <i data-feather="users" class="w-4 h-4 mr-1"></i>
              1,200+ estudiantes
            </div>
            <button class="conocer-mas-btn bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors" data-campus="innovacion">
              Conocer más
            </button>
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
            <button class="ver-galeria-btn text-green-600 hover:text-green-700 font-medium text-sm flex items-center gap-1" data-equipo="futbol">
                Ver Galería
                <i data-feather="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal para Galería de Fútbol -->
<div id="galeriaModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden">
        <!-- Header del modal -->
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h3 id="galeriaTitle" class="text-2xl font-bold text-gray-900">Galería - Selección de Fútbol</h3>
            <button id="closeGaleriaModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i data-feather="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <!-- Carrusel de fotos -->
        <div class="relative">
            <div id="galeriaSlides" class="flex transition-transform duration-500 ease-in-out">
                <!-- Las imágenes se cargarán dinámicamente -->
            </div>
            
            <!-- Controles del carrusel -->
            <button id="galeriaPrev" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all">
                <i data-feather="chevron-left" class="w-6 h-6"></i>
            </button>
            <button id="galeriaNext" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all">
                <i data-feather="chevron-right" class="w-6 h-6"></i>
            </button>
            
            <!-- Indicadores -->
            <div id="galeriaIndicators" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <!-- Los indicadores se generarán dinámicamente -->
            </div>
        </div>
        
        <!-- Información adicional -->
        <div class="p-6 bg-gray-50">
            <p id="galeriaDescription" class="text-gray-600 mb-4">Galería fotográfica de la Selección de Fútbol UTSC</p>
            <div class="flex items-center text-sm text-gray-500">
                <i data-feather="info" class="w-4 h-4 mr-2"></i>
                <span>Desliza para ver más fotos del equipo</span>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const galeriaModal = document.getElementById('galeriaModal');
    const closeGaleriaModal = document.getElementById('closeGaleriaModal');
    const verGaleriaBtns = document.querySelectorAll('.ver-galeria-btn');
    const galeriaTitle = document.getElementById('galeriaTitle');
    const galeriaDescription = document.getElementById('galeriaDescription');
    const galeriaSlides = document.getElementById('galeriaSlides');
    const galeriaIndicators = document.getElementById('galeriaIndicators');
    const galeriaPrev = document.getElementById('galeriaPrev');
    const galeriaNext = document.getElementById('galeriaNext');
    
    let currentGaleriaSlide = 0;
    let currentEquipo = '';
    
    // Datos de la galería de fútbol
    const equipoData = {
        futbol: {
            title: 'Selección de Fútbol',
            description: 'Galería fotográfica de la Selección de Fútbol UTSC - Representación Masculina',
            images: [
                './plataforma/app/img/futbol1.jpg',
                './plataforma/app/img/futbol2.jpg',
                './plataforma/app/img/futbol3.jpg',
                './plataforma/app/img/futbol4.jpg'
            ]
        }
    };
    
    // Abrir modal de galería
    verGaleriaBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            currentEquipo = this.getAttribute('data-equipo');
            openGaleriaModal(currentEquipo);
        });
    });
    
    // Cerrar modal
    closeGaleriaModal.addEventListener('click', closeGaleriaModalFunc);
    
    // Cerrar modal al hacer clic fuera
    galeriaModal.addEventListener('click', function(e) {
        if (e.target === galeriaModal) {
            closeGaleriaModalFunc();
        }
    });
    
    // Controles del carrusel
    galeriaPrev.addEventListener('click', showPrevGaleriaSlide);
    galeriaNext.addEventListener('click', showNextGaleriaSlide);
    
    function openGaleriaModal(equipo) {
        const data = equipoData[equipo];
        galeriaTitle.textContent = `Galería - ${data.title}`;
        galeriaDescription.textContent = data.description;
        
        // Limpiar carrusel anterior
        galeriaSlides.innerHTML = '';
        galeriaIndicators.innerHTML = '';
        
        // Cargar nuevas imágenes
        data.images.forEach((image, index) => {
            const slide = document.createElement('div');
            slide.className = 'galeria-slide min-w-full';
            slide.innerHTML = `<img src="${image}" alt="${data.title} - Foto ${index + 1}" class="w-full h-96 object-cover">`;
            galeriaSlides.appendChild(slide);
            
            const indicator = document.createElement('div');
            indicator.className = `galeria-indicator w-3 h-3 bg-white/50 rounded-full cursor-pointer transition-all ${index === 0 ? '!bg-white scale-125' : ''}`;
            indicator.addEventListener('click', () => showGaleriaSlide(index));
            galeriaIndicators.appendChild(indicator);
        });
        
        currentGaleriaSlide = 0;
        updateGaleriaCarousel();
        galeriaModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeGaleriaModalFunc() {
        galeriaModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    function showPrevGaleriaSlide() {
        const totalSlides = equipoData[currentEquipo].images.length;
        currentGaleriaSlide = (currentGaleriaSlide - 1 + totalSlides) % totalSlides;
        updateGaleriaCarousel();
    }
    
    function showNextGaleriaSlide() {
        const totalSlides = equipoData[currentEquipo].images.length;
        currentGaleriaSlide = (currentGaleriaSlide + 1) % totalSlides;
        updateGaleriaCarousel();
    }
    
    function showGaleriaSlide(index) {
        currentGaleriaSlide = index;
        updateGaleriaCarousel();
    }
    
    function updateGaleriaCarousel() {
        galeriaSlides.style.transform = `translateX(-${currentGaleriaSlide * 100}%)`;
        
        // Actualizar indicadores
        const indicators = galeriaIndicators.querySelectorAll('.galeria-indicator');
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('!bg-white', index === currentGaleriaSlide);
            indicator.classList.toggle('scale-125', index === currentGaleriaSlide);
            indicator.classList.toggle('bg-white/50', index !== currentGaleriaSlide);
        });
    }
    
    // Cerrar con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !galeriaModal.classList.contains('hidden')) {
            closeGaleriaModalFunc();
        }
    });
});
</script>

<!-- FIN DEL CÓDIGO DE SELECCIÓN DE FÚTBOL -->

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
            <button class="ver-galeria-btn text-purple-600 hover:text-purple-700 font-medium text-sm flex items-center gap-1" data-equipo="tochito">
                Ver Galería
                <i data-feather="arrow-right" class="w-4 h-4"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal para Galería de Tochito Femenino -->
<div id="galeriaModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden">
        <!-- Header del modal -->
        <div class="flex justify-between items-center p-6 border-b border-gray-200">
            <h3 id="galeriaTitle" class="text-2xl font-bold text-gray-900">Galería - Tochito Femenino</h3>
            <button id="closeGaleriaModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                <i data-feather="x" class="w-6 h-6"></i>
            </button>
        </div>
        
        <!-- Carrusel de fotos -->
        <div class="relative">
            <div id="galeriaSlides" class="flex transition-transform duration-500 ease-in-out">
                <!-- Las imágenes se cargarán dinámicamente -->
            </div>
            
            <!-- Controles del carrusel -->
            <button id="galeriaPrev" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all">
                <i data-feather="chevron-left" class="w-6 h-6"></i>
            </button>
            <button id="galeriaNext" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 w-10 h-10 rounded-full flex items-center justify-center shadow-lg transition-all">
                <i data-feather="chevron-right" class="w-6 h-6"></i>
            </button>
            
            <!-- Indicadores -->
            <div id="galeriaIndicators" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                <!-- Los indicadores se generarán dinámicamente -->
            </div>
        </div>
        
        <!-- Información adicional -->
        <div class="p-6 bg-gray-50">
            <p id="galeriaDescription" class="text-gray-600 mb-4">Galería fotográfica del equipo de Tochito Femenino UTSC</p>
            <div class="flex items-center text-sm text-gray-500">
                <i data-feather="info" class="w-4 h-4 mr-2"></i>
                <span>Desliza para ver más fotos del equipo</span>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const galeriaModal = document.getElementById('galeriaModal');
    const closeGaleriaModal = document.getElementById('closeGaleriaModal');
    const verGaleriaBtns = document.querySelectorAll('.ver-galeria-btn');
    const galeriaTitle = document.getElementById('galeriaTitle');
    const galeriaDescription = document.getElementById('galeriaDescription');
    const galeriaSlides = document.getElementById('galeriaSlides');
    const galeriaIndicators = document.getElementById('galeriaIndicators');
    const galeriaPrev = document.getElementById('galeriaPrev');
    const galeriaNext = document.getElementById('galeriaNext');
    
    let currentGaleriaSlide = 0;
    let currentEquipo = '';
    
    // Datos de la galería de tochito
    const equipoData = {
        tochito: {
            title: 'Tochito Femenino',
            description: 'Galería fotográfica del equipo de Tochito Femenino UTSC - Representación Femenina',
            images: [
                './plataforma/app/img/tochito1.jpg',
                './plataforma/app/img/tochito2.jpg',
                './plataforma/app/img/tochito3.jpg',
                './plataforma/app/img/tochito4.jpg'
            ]
        }
    };
    
    // Abrir modal de galería
    verGaleriaBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            currentEquipo = this.getAttribute('data-equipo');
            openGaleriaModal(currentEquipo);
        });
    });
    
    // Cerrar modal
    closeGaleriaModal.addEventListener('click', closeGaleriaModalFunc);
    
    // Cerrar modal al hacer clic fuera
    galeriaModal.addEventListener('click', function(e) {
        if (e.target === galeriaModal) {
            closeGaleriaModalFunc();
        }
    });
    
    // Controles del carrusel
    galeriaPrev.addEventListener('click', showPrevGaleriaSlide);
    galeriaNext.addEventListener('click', showNextGaleriaSlide);
    
    function openGaleriaModal(equipo) {
        const data = equipoData[equipo];
        galeriaTitle.textContent = `Galería - ${data.title}`;
        galeriaDescription.textContent = data.description;
        
        // Limpiar carrusel anterior
        galeriaSlides.innerHTML = '';
        galeriaIndicators.innerHTML = '';
        
        // Cargar nuevas imágenes
        data.images.forEach((image, index) => {
            const slide = document.createElement('div');
            slide.className = 'galeria-slide min-w-full';
            slide.innerHTML = `<img src="${image}" alt="${data.title} - Foto ${index + 1}" class="w-full h-96 object-cover">`;
            galeriaSlides.appendChild(slide);
            
            const indicator = document.createElement('div');
            indicator.className = `galeria-indicator w-3 h-3 bg-white/50 rounded-full cursor-pointer transition-all ${index === 0 ? '!bg-white scale-125' : ''}`;
            indicator.addEventListener('click', () => showGaleriaSlide(index));
            galeriaIndicators.appendChild(indicator);
        });
        
        currentGaleriaSlide = 0;
        updateGaleriaCarousel();
        galeriaModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeGaleriaModalFunc() {
        galeriaModal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    function showPrevGaleriaSlide() {
        const totalSlides = equipoData[currentEquipo].images.length;
        currentGaleriaSlide = (currentGaleriaSlide - 1 + totalSlides) % totalSlides;
        updateGaleriaCarousel();
    }
    
    function showNextGaleriaSlide() {
        const totalSlides = equipoData[currentEquipo].images.length;
        currentGaleriaSlide = (currentGaleriaSlide + 1) % totalSlides;
        updateGaleriaCarousel();
    }
    
    function showGaleriaSlide(index) {
        currentGaleriaSlide = index;
        updateGaleriaCarousel();
    }
    
    function updateGaleriaCarousel() {
        galeriaSlides.style.transform = `translateX(-${currentGaleriaSlide * 100}%)`;
        
        // Actualizar indicadores
        const indicators = galeriaIndicators.querySelectorAll('.galeria-indicator');
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('!bg-white', index === currentGaleriaSlide);
            indicator.classList.toggle('scale-125', index === currentGaleriaSlide);
            indicator.classList.toggle('bg-white/50', index !== currentGaleriaSlide);
        });
    }
    
    // Cerrar con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !galeriaModal.classList.contains('hidden')) {
            closeGaleriaModalFunc();
        }
    });
});
</script>

<!-- FIN DEL CÓDIGO DE TOCHITO FEMENINO -->

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
<section class="bg-gray-50 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Logros y Reconocimientos</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">El esfuerzo de nuestra comunidad académica reflejado en premios y distinciones</p>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <div class="gallery-item bg-white p-6 rounded-lg text-center" data-aos="fade-up">
        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="award" class="w-8 h-8 text-yellow-600"></i>
        </div>
        <h4 class="font-semibold text-gray-900">Premio a la Innovación</h4>
        <p class="text-sm text-gray-600 mt-2">Educativa 2023</p>
      </div>
      
      <div class="gallery-item bg-white p-6 rounded-lg text-center" data-aos="fade-up" data-aos-delay="100">
        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="globe" class="w-8 h-8 text-blue-600"></i>
        </div>
        <h4 class="font-semibold text-gray-900">Certificación ISO</h4>
        <p class="text-sm text-gray-600 mt-2">9001:2015</p>
      </div>
      
      <div class="gallery-item bg-white p-6 rounded-lg text-center" data-aos="fade-up" data-aos-delay="200">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="trending-up" class="w-8 h-8 text-green-600"></i>
        </div>
        <h4 class="font-semibold text-gray-900">Top 5 Nacional</h4>
        <p class="text-sm text-gray-600 mt-2">En empleabilidad</p>
      </div>
      
      <div class="gallery-item bg-white p-6 rounded-lg text-center" data-aos="fade-up" data-aos-delay="300">
        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i data-feather="star" class="w-8 h-8 text-purple-600"></i>
        </div>
        <h4 class="font-semibold text-gray-900">+50 Patentes</h4>
        <p class="text-sm text-gray-600 mt-2">Registradas</p>
      </div>
    </div>
  </div>
</section>

<script>
AOS.init({ duration: 1000, once: true });
feather.replace();

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
</script>

<?php include 'footer.php'; ?>
</body>
</html>