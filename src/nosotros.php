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

<!-- Estadísticas -->
<section class="bg-white py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <div class="stats-card text-center" data-aos="fade-up">
        <div class="text-3xl font-bold mb-2">15+</div>
        <div class="text-emerald-100">Años de Experiencia</div>
      </div>
      <div class="stats-card text-center" data-aos="fade-up" data-aos-delay="100">
        <div class="text-3xl font-bold mb-2">5,000+</div>
        <div class="text-emerald-100">Estudiantes Graduados</div>
      </div>
      <div class="stats-card text-center" data-aos="fade-up" data-aos-delay="200">
        <div class="text-3xl font-bold mb-2">25+</div>
        <div class="text-emerald-100">Programas Académicos</div>
      </div>
      <div class="stats-card text-center" data-aos="fade-up" data-aos-delay="300">
        <div class="text-3xl font-bold mb-2">50+</div>
        <div class="text-emerald-100">Convenios Internacionales</div>
      </div>
    </div>
  </div>
</section>

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

<!-- Ferias y Eventos Educativos -->
<section class="bg-gray-50 py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Participación en Ferias Educativas</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Mostrando innovación y talento en eventos nacionales e internacionales</p>
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
      <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
        <img src="./plataforma/app/img/IndustrialM.jpg" alt="Feria Tecnológica" class="w-full h-48 object-cover">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-3">Feria Internacional de Tecnología</h3>
          <p class="text-gray-600 mb-4">Participación anual con proyectos innovadores de robótica e inteligencia artificial desarrollados por nuestros estudiantes.</p>
          <div class="flex items-center text-sm text-gray-500">
            <i data-feather="map-pin" class="w-4 h-4 mr-1"></i>
            Ciudad de México
          </div>
        </div>
      </div>
      
      <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <img src="./plataforma/app/img/Mecatronica.jpg" alt="Expo Ingeniería" class="w-full h-48 object-cover">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-3">Expo Ingeniería Latinoamericana</h3>
          <p class="text-gray-600 mb-4">Showcase de proyectos de mecatrónica y automatización industrial que han recibido reconocimientos internacionales.</p>
          <div class="flex items-center text-sm text-gray-500">
            <i data-feather="map-pin" class="w-4 h-4 mr-1"></i>
            Guadalajara, Jalisco
          </div>
        </div>
      </div>
      
      <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
        <img src="./plataforma/app/img/Negocios.jpg" alt="Foro de Innovación" class="w-full h-48 object-cover">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-3">Foro de Innovación Educativa</h3>
          <p class="text-gray-600 mb-4">Presentación de nuestras metodologías de enseñanza disruptivas y casos de éxito de egresados emprendedores.</p>
          <div class="flex items-center text-sm text-gray-500">
            <i data-feather="map-pin" class="w-4 h-4 mr-1"></i>
            Monterrey, N.L.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Campus y Planteles -->
<section class="bg-white py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Nuestros Planteles</h2>
      <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Infraestructura de vanguardia para una educación de excelencia</p>
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div class="campus-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
        <img src="./plataforma/app/img/PlantelUT.jpg" alt="Campus Central" class="w-full h-48 object-cover">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-2">Campus Central</h3>
          <p class="text-gray-600 mb-4">Sede principal con laboratorios especializados, biblioteca digital y áreas de innovación.</p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)]">
            <i data-feather="users" class="w-4 h-4 mr-1"></i>
            2,500+ estudiantes
          </div>
        </div>
      </div>
      
      <div class="campus-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <img src="./plataforma/app/img/CorrecaminosUT.jpg" alt="Campus Norte" class="w-full h-48 object-cover">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-2">Campus Tecnológico</h3>
          <p class="text-gray-600 mb-4">Especializado en ingenierías avanzadas con talleres de manufactura y prototipado.</p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)]">
            <i data-feather="users" class="w-4 h-4 mr-1"></i>
            1,800+ estudiantes
          </div>
        </div>
      </div>
      
      <div class="campus-card bg-white rounded-xl shadow-lg overflow-hidden" data-aos="fade-up" data-aos-delay="200">
        <img src="./plataforma/app/img/Mecatronica.jpg" alt="Campus Sur" class="w-full h-48 object-cover">
        <div class="p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-2">Campus de Innovación</h3>
          <p class="text-gray-600 mb-4">Enfoque en emprendimiento tecnológico y desarrollo de startups estudiantiles.</p>
          <div class="flex items-center text-sm text-[var(--ut-green-700)]">
            <i data-feather="users" class="w-4 h-4 mr-1"></i>
            1,200+ estudiantes
          </div>
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
</script>

<?php include 'footer.php'; ?>
</body>
</html>