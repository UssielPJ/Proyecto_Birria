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
<!-- Vanta para fondo único en hero -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.net.min.js"></script>
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
  background: radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%), 
              radial-gradient(circle at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 50%);
  pointer-events: none;
}

.stats-card {
  background: linear-gradient(135deg, var(--ut-green-700), var(--ut-green-800));
  border-radius: 16px;
  padding: 2rem;
  color: white;
  position: relative;
  overflow: hidden;
}

.stats-card::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
  animation: rotate 20s linear infinite;
}

@keyframes rotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.timeline-container {
  position: relative;
  max-width: 900px;
  margin: 0 auto;
}

.timeline-line {
  position: absolute;
  left: 50%;
  top: 0;
  bottom: 0;
  width: 6px;
  background: linear-gradient(to bottom, var(--ut-green-500), var(--ut-green-700));
  transform: translateX(-50%);
  border-radius: 3px;
  box-shadow: 0 0 10px rgba(40,165,95,0.3);
}

.timeline-item {
  position: relative;
  margin-bottom: 4rem;
  width: 50%;
  padding: 0 2.5rem;
}

.timeline-item:nth-child(odd) {
  left: 0;
  text-align: right;
}

.timeline-item:nth-child(even) {
  left: 50%;
  text-align: left;
}

.timeline-dot {
  position: absolute;
  top: 2rem;
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--ut-green-500), var(--ut-green-600));
  border: 4px solid white;
  box-shadow: 0 0 0 4px var(--ut-green-100), 0 0 20px rgba(40,165,95,0.4);
  z-index: 2;
  transition: transform 0.3s ease;
}

.timeline-item:hover .timeline-dot {
  transform: scale(1.2);
}

.timeline-item:nth-child(odd) .timeline-dot {
  right: -15px;
}

.timeline-item:nth-child(even) .timeline-dot {
  left: -15px;
}

.timeline-content {
  background: linear-gradient(135deg, white, #f8fafc);
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 8px 25px rgba(0,0,0,0.1);
  border: 1px solid var(--ut-green-100);
  transition: all 0.4s ease;
  position: relative;
}

.timeline-content::before {
  content: '';
  position: absolute;
  top: 2rem;
  width: 0;
  height: 0;
  border: 12px solid transparent;
}

.timeline-item:nth-child(odd) .timeline-content::before {
  right: -24px;
  border-left-color: white;
}

.timeline-item:nth-child(even) .timeline-content::before {
  left: -24px;
  border-right-color: white;
}

.timeline-content:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.timeline-year {
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  font-size: 1.25rem;
  font-weight: bold;
  color: var(--ut-green-700);
  margin-bottom: 1rem;
  background: var(--ut-green-50);
  padding: 0.5rem 1rem;
  border-radius: 9999px;
  border: 1px solid var(--ut-green-200);
}

.timeline-year i {
  color: var(--ut-green-500);
}

.timeline-title {
  font-size: 1.375rem;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 0.75rem;
}

.timeline-description {
  color: #6b7280;
  font-size: 0.95rem;
  line-height: 1.6;
}

/* Mobile responsive */
@media (max-width: 768px) {
  .timeline-line {
    left: 35px;
  }

  .timeline-item {
    width: 100%;
    padding-left: 5rem;
    padding-right: 1.5rem;
    text-align: left;
    margin-bottom: 3rem;
  }

  .timeline-item:nth-child(odd),
  .timeline-item:nth-child(even) {
    left: 0;
  }

  .timeline-dot {
    left: 20px;
  }

  .timeline-content::before {
    left: -24px !important;
    border-right-color: white !important;
    border-left-color: transparent !important;
  }
}

.value-card {
  transition: all 0.4s ease;
  border-radius: 20px;
  overflow: hidden;
  position: relative;
}

.value-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.value-card:hover::before {
  opacity: 1;
}

.value-card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.campus-card {
  transition: all 0.4s ease;
  border-radius: 20px;
  overflow: hidden;
  position: relative;
}

.campus-card::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.campus-card:hover::after {
  opacity: 1;
}

.campus-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 20px 50px rgba(0,0,0,0.15);
}

.gallery-item {
  transition: all 0.4s ease;
  border-radius: 16px;
  overflow: hidden;
}

.gallery-item:hover {
  transform: scale(1.05) rotate(1deg);
  box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

/* NUEVO: Estilos para el apartado deportivo - Más único */
.sports-card {
  transition: all 0.4s ease;
  border-radius: 20px;
  overflow: hidden;
  position: relative;
}

.sports-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #10b981, #8b5cf6);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.sports-card:hover::before {
  opacity: 1;
}

.sports-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

/* Modo oscuro base - Mejorado para mayor cobertura y único */
body.dark {
  background-color: #0f0f23;
  color: #f0f4f8;
}

body.dark .bg-white { background-color: #1a1a2e !important; }
body.dark .bg-gray-50 { background-color: #0f0f23 !important; }
body.dark .text-gray-900 { color: #f0f4f8 !important; }
body.dark .text-gray-500 { color: #a0a8b0 !important; }
body.dark .text-gray-600 { color: #c0c8d0 !important; }

/* Hero section - Gradiente único en dark */
body.dark .hero-nosotros {
  background: linear-gradient(135deg, var(--ut-green-900) 0%, #0a0a1a 50%, var(--ut-green-700) 100%);
}
body.dark .hero-nosotros h1 { color: #f0f4f8; text-shadow: 0 2px 4px rgba(0,0,0,0.5); }
body.dark .hero-nosotros p { color: #d0d8e0; }

/* Stats cards - Más único */
body.dark .stats-card {
  background: linear-gradient(135deg, var(--ut-green-800), #0a0a1a);
  border: 1px solid rgba(40,165,95,0.2);
}
body.dark .stats-card .text-\[var\(--ut-green-700\)\] { color: #4ade80 !important; }
body.dark .stats-card .text-\[var\(--ut-green-600\)\] { color: #22c55e !important; }

/* Modal improvements */
body.dark .bg-black.bg-opacity-75 { background-color: rgba(10,10,26,0.95) !important; }
body.dark .bg-white.rounded-2xl { background-color: #1a1a2e !important; border: 1px solid rgba(40,165,95,0.2) !important; }
body.dark .border-gray-200 { border-color: #2a2a4e !important; }
body.dark .bg-gray-50 { background-color: #0f0f23 !important; }

/* Value cards - Bordes únicos */
body.dark .value-card {
  background-color: #1a1a2e;
  border: 1px solid rgba(40,165,95,0.1);
}
body.dark .value-card h3 { color: #f0f4f8; }
body.dark .value-card p { color: #c0c8d0; }
body.dark .value-card .text-blue-600 { color: #60a5fa; }
body.dark .value-card .text-green-600 { color: #34d399; }
body.dark .value-card .text-purple-600 { color: #a78bfa; }

/* Achievement backgrounds improvements */
body.dark .bg-yellow-100 { background-color: #2e1a0a !important; }
body.dark .bg-yellow-100 .text-yellow-600 { color: #fbbf24 !important; }
body.dark .bg-blue-100 { background-color: #1e3a8a !important; }
body.dark .bg-blue-100 .text-blue-600 { color: #60a5fa !important; }
body.dark .bg-green-100 { background-color: #0a1a14 !important; }
body.dark .bg-green-100 .text-green-600 { color: #34d399 !important; }
body.dark .bg-purple-100 { background-color: #1a0a2e !important; }
body.dark .bg-purple-100 .text-purple-600 { color: #a78bfa !important; }

/* Timeline - Más inmersivo y mejorado para dark mode */
body.dark .timeline-content {
  background: linear-gradient(135deg, #1a1a2e, #2a2a4e);
  border: 1px solid rgba(40,165,95,0.3);
  color: #f0f4f8;
}
body.dark .timeline-title { color: #f0f4f8; }
body.dark .timeline-description { color: #c0c8d0; }
body.dark .timeline-year { 
  color: #4ade80 !important; 
  background: rgba(40,165,95,0.15) !important; 
  border-color: rgba(40,165,95,0.4) !important; 
}
body.dark .timeline-year i { color: #22c55e !important; }

/* Campus cards */
body.dark .campus-card { 
  background-color: #1a1a2e; 
  border: 1px solid rgba(40,165,95,0.1);
}
body.dark .campus-card h3 { color: #f0f4f8; }
body.dark .campus-card p { color: #c0c8d0; }
body.dark .campus-card .text-\[var\(--ut-green-700\)\] { color: #22c55e; }

/* Sports cards */
body.dark .sports-card { 
  background-color: #1a1a2e; 
  border: 1px solid rgba(40,165,95,0.1);
}
body.dark .sports-card h3 { color: #f0f4f8; }
body.dark .sports-card p { color: #c0c8d0; }
body.dark .sports-card .text-gray-600 { color: #c0c8d0; }
body.dark .sports-card .text-green-600 { color: #34d399; }
body.dark .sports-card .text-purple-600 { color: #a78bfa; }

/* Gallery items */
body.dark .gallery-item {
  background-color: #1a1a2e;
  border: 1px solid rgba(40,165,95,0.1);
}
body.dark .gallery-item h4 { color: #f0f4f8; }
body.dark .gallery-item p { color: #c0c8d0; }

/* CTA sections */
body.dark .bg-gradient-to-br.from-green-50.to-emerald-100 {
  background: linear-gradient(135deg, #0a0a1a, #1a1a2e);
}
body.dark .bg-gradient-to-r.from-green-600.to-emerald-700 {
  background: linear-gradient(135deg, var(--ut-green-700), #0a0a1a);
}
body.dark .bg-white.rounded-2xl.shadow-lg {
  background-color: #1a1a2e !important;
  border: 1px solid rgba(40,165,95,0.2) !important;
}
body.dark .bg-white.rounded-3xl.shadow-lg h3 { color: #f0f4f8 !important; }
body.dark .bg-white.rounded-3xl.shadow-lg p { color: #c0c8d0 !important; }
body.dark .bg-green-600 { background-color: #16a34a !important; }
body.dark .bg-green-600:hover { background-color: #15803d !important; }

/* Stats section improvements */
body.dark .text-4xl.font-extrabold.text-gray-900 { color: #f0f4f8 !important; }
body.dark .text-xl.text-gray-600 { color: #c0c8d0 !important; }

/* Additional text colors */
body.dark h1, body.dark h2, body.dark h3, body.dark h4, body.dark h5, body.dark h6 {
  color: #f0f4f8 !important;
}

body.dark p, body.dark span, body.dark div {
  color: #c0c8d0 !important;
}

body.dark .text-xl.text-gray-600 { color: #a0a8b0 !important; }
body.dark .text-lg.text-gray-600 { color: #c0c8d0 !important; }

/* Specific section text colors for better visibility */
body.dark .text-xl.text-gray-500 { color: #a0a8b0 !important; }
body.dark .text-gray-500 { color: #a0a8b0 !important; }
body.dark .text-gray-600 { color: #c0c8d0 !important; }
body.dark .text-gray-700 { color: #d0d8e0 !important; }
body.dark .text-gray-900 { color: #f0f4f8 !important; }

/* Links and buttons */
body.dark a { color: #60a5fa; }
body.dark a:hover { color: #93c5fd; }
body.dark button { color: #f0f4f8; }

/* Gallery section */
body.dark .text-3xl.font-extrabold.text-gray-900 { color: #f0f4f8 !important; }
body.dark .text-xl.text-gray-500 { color: #a0a8b0 !important; }

/* Additional gradient backgrounds for dark mode */
body.dark .bg-gradient-to-br.from-emerald-50.to-green-50 {
  background: linear-gradient(135deg, #0a0a1a, #1a1a2e) !important;
}
body.dark .bg-gradient-to-br.from-white.via-gray-50.to-emerald-50 {
  background: linear-gradient(135deg, #1a1a2e, #2a2a4e) !important;
}
body.dark .bg-gradient-to-b.from-white.to-gray-50 {
  background: linear-gradient(to bottom, #1a1a2e, #0f0f23) !important;
}
body.dark .bg-gradient-to-b.from-gray-50.to-white {
  background: linear-gradient(to bottom, #0f0f23, #1a1a2e) !important;
}
body.dark .bg-gradient-to-b.from-emerald-50.to-white {
  background: linear-gradient(to bottom, #0a0a1a, #1a1a2e) !important;
}
body.dark .bg-gradient-to-br.from-gray-50.to-emerald-50 {
  background: linear-gradient(135deg, #0f0f23, #0a0a1a) !important;
}

/* Carousel in hero - Unique in dark */
body.dark .carousel-indicator { background-color: rgba(240,244,248,0.5) !important; }
body.dark .carousel-indicator.active { background-color: #f0f4f8 !important; }

/* Mejoras específicas para la timeline única en dark mode */
body.dark .timeline-container-unique {
  background: rgba(26, 26, 46, 0.5);
  border-radius: 24px;
  padding: 2rem;
}

body.dark .timeline-line-unique {
  background: linear-gradient(180deg, #4ade80 0%, #22c55e 25%, #16a34a 50%, #15803d 75%, #0f5132 100%);
  box-shadow: 0 0 30px rgba(74, 222, 128, 0.5);
}

body.dark .timeline-progress {
  background: linear-gradient(180deg, rgba(74, 222, 128, 0.9) 0%, rgba(34, 197, 94, 0.6) 50%, rgba(22, 163, 74, 0.3) 100%);
}

body.dark .timeline-dot-unique {
  background: linear-gradient(135deg, #4ade80, #22c55e);
  border-color: #1a1a2e;
  box-shadow: 0 0 0 6px rgba(74, 222, 128, 0.2), 0 0 40px rgba(74, 222, 128, 0.6);
}

body.dark .timeline-dot-unique::after {
  border-color: rgba(74, 222, 128, 0.4);
}

body.dark .timeline-card-unique {
  background: linear-gradient(135deg, rgba(26, 26, 46, 0.95), rgba(42, 42, 78, 0.95));
  backdrop-filter: blur(20px);
  border: 1px solid rgba(74, 222, 128, 0.3);
  color: #f0f4f8;
  box-shadow: 0 20px 40px rgba(0,0,0,0.3), 0 0 0 1px rgba(74, 222, 128, 0.2);
}

body.dark .timeline-card-unique h4 {
  color: #f0f4f8 !important;
}

body.dark .timeline-card-unique p {
  color: #d0d8e0 !important;
}

body.dark .timeline-card-unique .text-3xl.font-bold {
  color: #f0f4f8 !important;
}

body.dark .timeline-card-unique .text-2xl.font-bold {
  color: #f0f4f8 !important;
}

body.dark .timeline-card-unique .text-gray-500,
body.dark .timeline-card-unique .text-gray-400 {
  color: #a0a8b0 !important;
}

body.dark .timeline-card-unique .text-\[var\(--ut-green-700\)\] {
  color: #4ade80 !important;
}

/* Ajustes para stats en timeline cards dark */
body.dark .timeline-card-unique .text-3xl.font-bold {
  color: #f0f4f8 !important;
}

body.dark .timeline-card-unique .grid > div {
  background: rgba(74, 222, 128, 0.1) !important;
  border-color: rgba(74, 222, 128, 0.2) !important;
}

body.dark .timeline-card-unique .grid > div .text-lg.font-bold {
  color: #22c55e !important;
}

/* Mejoras para elementos decorativos en timeline dark */
body.dark .timeline-card-unique::before {
  background: linear-gradient(90deg, #4ade80, #22c55e, #16a34a, #15803d);
}

body.dark .timeline-item-unique:hover .timeline-dot-unique {
  box-shadow: 0 0 0 10px rgba(74, 222, 128, 0.3), 0 0 60px rgba(74, 222, 128, 0.8);
}

/* Responsive dark mode para timeline */
@media (max-width: 1024px) {
  body.dark .timeline-card-unique {
    background: rgba(26, 26, 46, 0.9);
  }
}

@media (max-width: 768px) {
  body.dark .timeline-line-unique {
    width: 4px;
  }
  body.dark .timeline-dot-unique {
    border-width: 3px;
  }
}

/* Mejoras generales para mejor contraste en dark */
body.dark .border-gray-200 { border-color: rgba(74, 222, 128, 0.2) !important; }
body.dark .shadow-xl { box-shadow: 0 20px 40px rgba(0,0,0,0.4) !important; }
body.dark .hover\:shadow-2xl:hover { box-shadow: 0 25px 50px rgba(0,0,0,0.5) !important; }

/* Dark mode fixes for specific sections */
body.dark .bg-white\/80.backdrop-blur-sm.rounded-3xl {
  background-color: rgba(26, 26, 46, 0.95) !important;
  border: 1px solid rgba(74, 222, 128, 0.2) !important;
}

body.dark .bg-white\/80.backdrop-blur-sm.rounded-3xl h3,
body.dark .bg-white\/80.backdrop-blur-sm.rounded-3xl p {
  color: #f0f4f8 !important;
}

body.dark .bg-white\/95.backdrop-blur-sm.rounded-3xl {
  background-color: rgba(26, 26, 46, 0.98) !important;
  border: 1px solid rgba(74, 222, 128, 0.3) !important;
}

body.dark .bg-white\/95.backdrop-blur-sm.rounded-3xl h3,
body.dark .bg-white\/95.backdrop-blur-sm.rounded-3xl p,
body.dark .bg-white\/95.backdrop-blur-sm.rounded-3xl span {
  color: #f0f4f8 !important;
}

body.dark .bg-white\/80.backdrop-blur-sm.rounded-2xl.shadow-2xl {
  background-color: rgba(26, 26, 46, 0.95) !important;
  border: 1px solid rgba(74, 222, 128, 0.2) !important;
}

body.dark .bg-white\/80.backdrop-blur-sm.rounded-2xl.shadow-2xl h3,
body.dark .bg-white\/80.backdrop-blur-sm.rounded-2xl.shadow-2xl p {
  color: #f0f4f8 !important;
}

body.dark .bg-white\/80.backdrop-blur-sm.p-8.rounded-2xl {
  background-color: rgba(26, 26, 46, 0.95) !important;
  border: 1px solid rgba(74, 222, 128, 0.2) !important;
}

body.dark .bg-white\/80.backdrop-blur-sm.p-8.rounded-2xl h4,
body.dark .bg-white\/80.backdrop-blur-sm.p-8.rounded-2xl p {
  color: #f0f4f8 !important;
}

/* Logros Destacados section fixes */
body.dark .text-xl.font-bold.text-gray-900 {
  color: #f0f4f8 !important;
}

body.dark h4.text-xl.font-bold.text-gray-900 {
  color: #f0f4f8 !important;
}

body.dark .flex.items-start.gap-4.p-4 h5,
body.dark .flex.items-start.gap-4.p-4 p {
  color: #f0f4f8 !important;
}

body.dark .text-gray-600 {
  color: #c0c8d0 !important;
}

/* Logros Destacados 2025 section fixes */
body.dark .text-3xl.font-bold.text-gray-900 {
  color: #f0f4f8 !important;
}

body.dark .p-6 h4,
body.dark .p-6 p {
  color: #f0f4f8 !important;
}

body.dark .w-20.h-20 i {
  color: white !important;
}
</style>
</head>
<body class="font-sans antialiased text-gray-800">

<?php include 'navbar.php'; ?>

<!-- Hero Section - Más único con Vanta NET -->
<section class="hero-nosotros text-white py-24 md:py-32 relative">
  <div id="vanta-hero" class="absolute inset-0 opacity-20"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="text-center" data-aos="fade-up">
      <h1 class="text-4xl md:text-6xl font-extrabold mb-6 relative" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
        Nuestra Historia
        <div class="absolute -bottom-2 left-0 w-full h-1 bg-gradient-to-r from-white/0 via-white to-white/0"></div>
      </h1>
      <p class="text-xl md:text-2xl text-emerald-100 max-w-4xl mx-auto leading-relaxed">
        Más de 17 años formando profesionales que transforman el mundo a través de la tecnología y la innovación. Desde nuestra fundación en 2008, hemos evolucionado con el compromiso de integrar avances como la IA ética y la sostenibilidad en cada programa académico, impactando positivamente en comunidades locales y globales.
      </p>
    </div>
  </div>
</section>

<script>
VANTA.NET({
  el: "#vanta-hero",
  mouseControls: true,
  touchControls: true,
  gyroControls: false,
  minHeight: 200.00,
  minWidth: 200.00,
  scale: 1.00,
  scaleMobile: 1.00,
  color: 0x28a55f,
  backgroundColor: 0x0c4f2e,
  points: 10,
  maxDistance: 18,
  spacing: 12
});
</script>

<!-- Estadísticas Mejoradas - Expandida -->
<section class="bg-white py-24">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-20" data-aos="fade-up">
      <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
        Nuestra Trayectoria en 
        <span class="text-[var(--ut-green-600)]">Cifras</span>
      </h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
        Resultados tangibles que respaldan nuestra excelencia educativa. Datos actualizados a octubre 2025, reflejando nuestro crecimiento sostenido y compromiso con la innovación en un mundo post-pandemia y enfocado en la sostenibilidad.
      </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
      <!-- Años de Experiencia -->
      <div class="text-center" data-aos="fade-up">
        <div class="relative bg-gradient-to-br from-[var(--ut-green-50)] to-white rounded-2xl p-10 border border-[var(--ut-green-100)] shadow-xl transition-all duration-500 hover:shadow-2xl">
          <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
            <div class="w-16 h-16 bg-gradient-to-r from-[var(--ut-green-500)] to-[var(--ut-green-600)] rounded-full flex items-center justify-center shadow-xl">
              <i data-feather="award" class="w-8 h-8 text-white"></i>
            </div>
          </div>
          <div class="mt-6">
            <div class="text-5xl font-bold text-[var(--ut-green-700)] mb-3 count-up" data-target="17">0</div>
            <div class="text-[var(--ut-green-600)] font-semibold text-lg">Años de Experiencia</div>
            <p class="text-gray-600 text-base mt-4 leading-relaxed">
              Evolucionando desde 2008 con más de 50 actualizaciones curriculares integrando IA, ciberseguridad y energías renovables.
            </p>
          </div>
        </div>
      </div>
      
      <!-- Estudiantes Graduados -->
      <div class="text-center" data-aos="fade-up" data-aos-delay="100">
        <div class="relative bg-gradient-to-br from-[var(--ut-green-50)] to-white rounded-2xl p-10 border border-[var(--ut-green-100)] shadow-xl transition-all duration-500 hover:shadow-2xl">
          <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
            <div class="w-16 h-16 bg-gradient-to-r from-[var(--ut-green-500)] to-[var(--ut-green-600)] rounded-full flex items-center justify-center shadow-xl">
              <i data-feather="users" class="w-8 h-8 text-white"></i>
            </div>
          </div>
          <div class="mt-6">
            <div class="text-5xl font-bold text-[var(--ut-green-700)] mb-3 count-up" data-target="6500">0</div>
            <div class="text-[var(--ut-green-600)] font-semibold text-lg">Estudiantes Graduados</div>
            <p class="text-gray-600 text-base mt-4 leading-relaxed">
              Con una tasa de empleabilidad del 97% en los primeros 6 meses, muchos en roles de liderazgo en empresas como Siemens y Google México.
            </p>
          </div>
        </div>
      </div>
      
      <!-- Programas Académicos -->
      <div class="text-center" data-aos="fade-up" data-aos-delay="200">
        <div class="relative bg-gradient-to-br from-[var(--ut-green-50)] to-white rounded-2xl p-10 border border-[var(--ut-green-100)] shadow-xl transition-all duration-500 hover:shadow-2xl">
          <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
            <div class="w-16 h-16 bg-gradient-to-r from-[var(--ut-green-500)] to-[var(--ut-green-600)] rounded-full flex items-center justify-center shadow-xl">
              <i data-feather="book-open" class="w-8 h-8 text-white"></i>
            </div>
          </div>
          <div class="mt-6">
            <div class="text-5xl font-bold text-[var(--ut-green-700)] mb-3 count-up" data-target="28">0</div>
            <div class="text-[var(--ut-green-600)] font-semibold text-lg">Programas Académicos</div>
            <p class="text-gray-600 text-base mt-4 leading-relaxed">
              Incluyendo especializaciones en IA aplicada, ciberseguridad cuántica y biotecnología sostenible, con certificaciones internacionales incluidas.
            </p>
          </div>
        </div>
      </div>
      
      <!-- Convenios Internacionales -->
      <div class="text-center" data-aos="fade-up" data-aos-delay="300">
        <div class="relative bg-gradient-to-br from-[var(--ut-green-50)] to-white rounded-2xl p-10 border border-[var(--ut-green-100)] shadow-xl transition-all duration-500 hover:shadow-2xl">
          <div class="absolute -top-6 left-1/2 transform -translate-x-1/2">
            <div class="w-16 h-16 bg-gradient-to-r from-[var(--ut-green-500)] to-[var(--ut-green-600)] rounded-full flex items-center justify-center shadow-xl">
              <i data-feather="globe" class="w-8 h-8 text-white"></i>
            </div>
          </div>
          <div class="mt-6">
            <div class="text-5xl font-bold text-[var(--ut-green-700)] mb-3 count-up" data-target="65">0</div>
            <div class="text-[var(--ut-green-600)] font-semibold text-lg">Convenios Internacionales</div>
            <p class="text-gray-600 text-base mt-4 leading-relaxed">
              Alianzas con MIT, Siemens y universidades en Europa para intercambios, doble titulación y proyectos conjuntos en innovación verde.
            </p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Línea decorativa - Más elaborada -->
    <div class="text-center mt-16" data-aos="fade-up">
      <div class="inline-flex items-center gap-4 text-[var(--ut-green-600)] bg-[var(--ut-green-50)] px-8 py-4 rounded-full border border-[var(--ut-green-200)] shadow-lg">
        <i data-feather="trending-up" class="w-6 h-6"></i>
        <span class="font-semibold text-lg">Creciendo contigo hacia el futuro: +15% anual en matriculación sostenible</span>
        <i data-feather="sparkles" class="w-6 h-6"></i>
      </div>
    </div>
  </div>
</section>

<script>
// Animación de conteo - Mejorada
document.addEventListener('DOMContentLoaded', function() {
  const countUpElements = document.querySelectorAll('.count-up');
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const element = entry.target;
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2500;
        const stepTime = 16;
        const steps = duration / stepTime;
        const increment = target / steps;
        let current = 0;
        
        const timer = setInterval(() => {
          current += increment;
          if (current >= target) {
            element.textContent = target + '+';
            clearInterval(timer);
          } else {
            element.textContent = Math.floor(current).toLocaleString();
          }
        }, stepTime);
        
        observer.unobserve(element);
      }
    });
  }, { threshold: 0.7 });
  
  countUpElements.forEach(element => {
    observer.observe(element);
  });
});
</script>

<!-- Misión, Visión y Valores - Expandida -->
<section class="bg-gradient-to-br from-gray-50 to-emerald-50 py-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-20" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl relative">Nuestra Esencia</h2>
      <p class="mt-6 max-w-3xl text-xl text-gray-500 mx-auto leading-relaxed">Los pilares que nos definen y guían nuestro camino hacia una educación transformadora en la era digital y sostenible.</p>
    </div>
    
    <div class="grid md:grid-cols-3 gap-12">
      <div class="value-card bg-white/80 backdrop-blur-sm p-10 rounded-2xl shadow-xl border border-white/20" data-aos="fade-up">
        <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mb-8 mx-auto shadow-lg">
          <i data-feather="target" class="w-10 h-10 text-white"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 text-center mb-6">Misión</h3>
        <p class="text-gray-600 text-center leading-relaxed text-lg">
          Formar profesionales de excelencia en el ámbito tecnológico mediante programas educativos innovadores que integran IA, sostenibilidad y competencias globales, fomentando el desarrollo integral, el emprendimiento ético y el compromiso activo con la sociedad y el medio ambiente.
        </p>
      </div>
      
      <div class="value-card bg-white/80 backdrop-blur-sm p-10 rounded-2xl shadow-xl border border-white/20" data-aos="fade-up" data-aos-delay="100">
        <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mb-8 mx-auto shadow-lg">
          <i data-feather="eye" class="w-10 h-10 text-white"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 text-center mb-6">Visión</h3>
        <p class="text-gray-600 text-center leading-relaxed text-lg">
          Ser la institución líder en educación tecnológica de Latinoamérica para 2030, reconocida por nuestra innovación disruptiva, calidad académica certificada internacionalmente y contribución al desarrollo sostenible, impulsando soluciones globales a desafíos como el cambio climático y la brecha digital.
        </p>
      </div>
      
      <div class="value-card bg-white/80 backdrop-blur-sm p-10 rounded-2xl shadow-xl border border-white/20" data-aos="fade-up" data-aos-delay="200">
        <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mb-8 mx-auto shadow-lg">
          <i data-feather="heart" class="w-10 h-10 text-white"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-900 text-center mb-6">Valores</h3>
        <ul class="text-gray-600 space-y-3 text-lg">
          <li class="flex items-center justify-center">
            <i data-feather="check-circle" class="w-6 h-6 text-green-500 mr-3"></i>
            <span>Excelencia académica y rigor científico</span>
          </li>
          <li class="flex items-center justify-center">
            <i data-feather="check-circle" class="w-6 h-6 text-green-500 mr-3"></i>
            <span>Innovación constante y pensamiento crítico</span>
          </li>
          <li class="flex items-center justify-center">
            <i data-feather="check-circle" class="w-6 h-6 text-green-500 mr-3"></i>
            <span>Responsabilidad social y sostenibilidad ambiental</span>
          </li>
          <li class="flex items-center justify-center">
            <i data-feather="check-circle" class="w-6 h-6 text-green-500 mr-3"></i>
            <span>Integridad, ética y diversidad inclusiva</span>
          </li>
          <li class="flex items-center justify-center">
            <i data-feather="check-circle" class="w-6 h-6 text-green-500 mr-3"></i>
            <span>Colaboración global y liderazgo transformador</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Historia y Línea de Tiempo - Rediseñada Elegante e Interactiva -->
<section class="bg-gradient-to-br from-white via-gray-50 to-emerald-50 py-32 relative overflow-hidden">
  <!-- Elementos decorativos de fondo -->
  <div class="absolute inset-0 opacity-5">
    <div class="absolute top-20 left-10 w-32 h-32 bg-[var(--ut-green-500)] rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 right-10 w-40 h-40 bg-[var(--ut-green-600)] rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-[var(--ut-green-400)] rounded-full blur-3xl"></div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <!-- Header Section Mejorado -->
    <div class="text-center mb-20" data-aos="fade-up">
      <div class="inline-flex items-center gap-3 bg-gradient-to-r from-[var(--ut-green-100)] to-emerald-100 px-6 py-3 rounded-full border border-[var(--ut-green-200)] mb-8">
        <i data-feather="book-open" class="w-5 h-5 text-[var(--ut-green-600)]"></i>
        <span class="text-[var(--ut-green-700)] font-semibold text-sm uppercase tracking-wide">Nuestra Trayectoria</span>
      </div>
      <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">
        Nuestra <span class="text-transparent bg-clip-text bg-gradient-to-r from-[var(--ut-green-600)] to-[var(--ut-green-800)]">Historia</span>
      </h2>
      <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
        Una trayectoria de innovación, crecimiento y compromiso con la excelencia educativa que nos ha convertido en líderes tecnológicos de Latinoamérica.
      </p>
    </div>

    <!-- Layout Principal Mejorado -->
    <div class="grid lg:grid-cols-5 gap-16 items-start">
      <!-- Columna Izquierda - Texto Mejorado -->
      <div class="lg:col-span-2 space-y-8" data-aos="fade-right">
        <!-- Texto Principal con Mejor Diseño -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-white/50">
          <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-gradient-to-br from-[var(--ut-green-500)] to-[var(--ut-green-700)] rounded-2xl flex items-center justify-center shadow-lg">
              <i data-feather="target" class="w-6 h-6 text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900">Nuestra Visión Original</h3>
          </div>

          <p class="text-gray-700 text-lg leading-relaxed mb-6">
            Fundada en 2008 en respuesta a la creciente demanda de talento tecnológico en Nuevo León, la Universidad Tecnológica de Santa Catarina inició su trayectoria con una visión audaz: revolucionar la educación superior mediante un enfoque práctico y alineado con las necesidades de la industria 4.0.
          </p>

          <p class="text-gray-700 text-lg leading-relaxed mb-8">
            Desde nuestros humildes comienzos con apenas 3 programas académicos y 150 estudiantes, hemos crecido exponencialmente, expandiéndonos a múltiples campus y adoptando tecnologías emergentes como la realidad aumentada en laboratorios virtuales.
          </p>

          <!-- Estadísticas Interactivas -->
          <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="text-center p-4 bg-gradient-to-br from-[var(--ut-green-50)] to-white rounded-2xl border border-[var(--ut-green-100)]">
              <div class="text-2xl font-bold text-[var(--ut-green-700)] mb-1">17</div>
              <div class="text-sm text-gray-600 font-medium">Años</div>
            </div>
            <div class="text-center p-4 bg-gradient-to-br from-[var(--ut-green-50)] to-white rounded-2xl border border-[var(--ut-green-100)]">
              <div class="text-2xl font-bold text-[var(--ut-green-700)] mb-1">6,500+</div>
              <div class="text-sm text-gray-600 font-medium">Graduados</div>
            </div>
            <div class="text-center p-4 bg-gradient-to-br from-[var(--ut-green-50)] to-white rounded-2xl border border-[var(--ut-green-100)]">
              <div class="text-2xl font-bold text-[var(--ut-green-700)] mb-1">28</div>
              <div class="text-sm text-gray-600 font-medium">Programas</div>
            </div>
          </div>
        </div>

      </div>

      <!-- Columna Derecha - Timeline Única y Completa -->
      <div class="lg:col-span-3" data-aos="fade-left">
        <div class="bg-white/95 backdrop-blur-sm rounded-3xl p-8 shadow-2xl border border-white/60 relative overflow-hidden">
          <!-- Elementos decorativos únicos -->
          <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-[var(--ut-green-200)] to-transparent rounded-full opacity-20"></div>
          <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-[var(--ut-green-300)] to-transparent rounded-full opacity-30"></div>

          <div class="relative z-10">
            <div class="flex items-center justify-between mb-8">
              <h3 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-[var(--ut-green-500)] to-[var(--ut-green-700)] rounded-2xl flex items-center justify-center shadow-lg">
                  <i data-feather="clock" class="w-5 h-5 text-white"></i>
                </div>
                Nuestra Evolución
              </h3>
              <div class="flex items-center gap-2 text-sm text-gray-500 bg-gradient-to-r from-gray-100 to-gray-200 px-4 py-2 rounded-full border border-gray-300">
                <i data-feather="mouse-pointer" class="w-4 h-4"></i>
                <span>Interactivo</span>
              </div>
            </div>

            <!-- Timeline Container Único -->
            <div class="timeline-container-unique relative">
              <!-- Línea central con gradiente animado -->
              <div class="timeline-line-unique absolute left-1/2 top-0 bottom-0 w-2 bg-gradient-to-b from-[var(--ut-green-400)] via-[var(--ut-green-500)] to-[var(--ut-green-600)] transform -translate-x-1/2 rounded-full shadow-2xl">
                <div class="timeline-progress absolute top-0 left-0 w-full bg-gradient-to-b from-white/80 to-white/40 rounded-full transition-all duration-1000 ease-out"></div>
              </div>

              <!-- Timeline Items con Diseño Completo -->
              <div class="timeline-item-unique relative mb-16" data-aos="fade-up" data-year="2008">
                <div class="timeline-dot-unique absolute left-1/2 w-8 h-8 bg-gradient-to-br from-[var(--ut-green-500)] to-[var(--ut-green-700)] rounded-full border-4 border-white shadow-2xl transform -translate-x-1/2 z-20 cursor-pointer transition-all duration-500 hover:scale-150 hover:rotate-12">
                  <div class="absolute inset-0 bg-gradient-to-br from-[var(--ut-green-400)] to-[var(--ut-green-600)] rounded-full animate-pulse opacity-75"></div>
                  <div class="absolute inset-1 bg-white rounded-full"></div>
                  <div class="absolute inset-2 bg-gradient-to-br from-[var(--ut-green-500)] to-[var(--ut-green-700)] rounded-full"></div>
                </div>

                <div class="timeline-card-unique bg-gradient-to-r from-white via-gray-50 to-white rounded-3xl p-8 shadow-xl border border-gray-200 hover:border-[var(--ut-green-300)] transition-all duration-700 hover:shadow-2xl hover:-translate-y-2 relative overflow-hidden group">
                  <!-- Elementos decorativos de la card -->
                  <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[var(--ut-green-100)] to-transparent rounded-full opacity-50 group-hover:opacity-100 transition-opacity duration-500"></div>
                  <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-[var(--ut-green-200)] to-transparent rounded-full opacity-30 group-hover:opacity-80 transition-opacity duration-500"></div>

                  <div class="relative z-10">
                    <!-- Header con año e ícono -->
                    <div class="flex items-center justify-between mb-6">
                      <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl flex items-center justify-center shadow-xl">
                          <i data-feather="calendar" class="w-7 h-7 text-white"></i>
                        </div>
                        <div>
                          <div class="text-3xl font-bold text-[var(--ut-green-700)] leading-none">2008</div>
                          <div class="text-sm text-gray-500 font-medium">Fundación</div>
                        </div>
                      </div>
                      <div class="text-right">
                        <div class="text-sm text-gray-400 font-medium">Inicio</div>
                        <div class="text-xs text-gray-500">Era Digital</div>
                      </div>
                    </div>

                    <!-- Título principal -->
                    <h4 class="text-2xl font-bold text-gray-900 mb-4 leading-tight">Fundación Visionaria</h4>

                    <!-- Descripción completa -->
                    <p class="text-gray-700 leading-relaxed mb-6">
                      Inauguración del primer campus en Santa Catarina con 3 programas pioneros en ingeniería industrial y sistemas computacionales. Atendiendo a 150 estudiantes iniciales con un enfoque revolucionario en aprendizaje basado en proyectos reales y tecnología aplicada.
                    </p>

                    <!-- Estadísticas del período -->
                    <div class="grid grid-cols-3 gap-4 mb-6">
                      <div class="text-center p-3 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                        <div class="text-lg font-bold text-blue-700">150</div>
                        <div class="text-xs text-blue-600 font-medium">Estudiantes</div>
                      </div>
                      <div class="text-center p-3 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200">
                        <div class="text-lg font-bold text-green-700">3</div>
                        <div class="text-xs text-green-600 font-medium">Programas</div>
                      </div>
                      <div class="text-center p-3 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl border border-purple-200">
                        <div class="text-lg font-bold text-purple-700">1</div>
                        <div class="text-xs text-purple-600 font-medium">Campus</div>
                      </div>
                    </div>

                    <!-- Elementos destacados -->
                    <div class="flex flex-wrap gap-2">
                      <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">Innovación</span>
                      <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">Tecnología</span>
                      <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">Visión</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="timeline-item-unique relative mb-16" data-aos="fade-up" data-aos-delay="200" data-year="2012">
                <div class="timeline-dot-unique absolute left-1/2 w-8 h-8 bg-gradient-to-br from-[var(--ut-green-500)] to-[var(--ut-green-700)] rounded-full border-4 border-white shadow-2xl transform -translate-x-1/2 z-20 cursor-pointer transition-all duration-500 hover:scale-150 hover:rotate-12">
                  <div class="absolute inset-0 bg-gradient-to-br from-[var(--ut-green-400)] to-[var(--ut-green-600)] rounded-full animate-pulse opacity-75"></div>
                  <div class="absolute inset-1 bg-white rounded-full"></div>
                  <div class="absolute inset-2 bg-gradient-to-br from-[var(--ut-green-500)] to-[var(--ut-green-700)] rounded-full"></div>
                </div>

                <div class="timeline-card-unique bg-gradient-to-l from-white via-gray-50 to-white rounded-3xl p-8 shadow-xl border border-gray-200 hover:border-[var(--ut-green-300)] transition-all duration-700 hover:shadow-2xl hover:-translate-y-2 relative overflow-hidden group ml-auto max-w-2xl">
                  <!-- Elementos decorativos -->
                  <div class="absolute top-0 left-0 w-20 h-20 bg-gradient-to-bl from-[var(--ut-green-100)] to-transparent rounded-full opacity-50 group-hover:opacity-100 transition-opacity duration-500"></div>
                  <div class="absolute bottom-0 right-0 w-16 h-16 bg-gradient-to-tl from-[var(--ut-green-200)] to-transparent rounded-full opacity-30 group-hover:opacity-80 transition-opacity duration-500"></div>

                  <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                      <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-700 rounded-2xl flex items-center justify-center shadow-xl">
                          <i data-feather="map-pin" class="w-7 h-7 text-white"></i>
                        </div>
                        <div>
                          <div class="text-3xl font-bold text-[var(--ut-green-700)] leading-none">2012</div>
                          <div class="text-sm text-gray-500 font-medium">Expansión</div>
                        </div>
                      </div>
                      <div class="text-right">
                        <div class="text-sm text-gray-400 font-medium">Crecimiento</div>
                        <div class="text-xs text-gray-500">Regional</div>
                      </div>
                    </div>

                    <h4 class="text-2xl font-bold text-gray-900 mb-4 leading-tight text-right">Expansión Regional</h4>

                    <p class="text-gray-700 leading-relaxed mb-6 text-right">
                      Apertura del campus Montemorelos y lanzamiento de 5 nuevos programas académicos, incluyendo mecatrónica y desarrollo de software. Duplicando nuestra matrícula a 800 estudiantes y estableciendo los primeros laboratorios de simulación 3D.
                    </p>

                    <div class="grid grid-cols-3 gap-4 mb-6">
                      <div class="text-center p-3 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200">
                        <div class="text-lg font-bold text-orange-700">800</div>
                        <div class="text-xs text-orange-600 font-medium">Estudiantes</div>
                      </div>
                      <div class="text-center p-3 bg-gradient-to-br from-red-50 to-red-100 rounded-xl border border-red-200">
                        <div class="text-lg font-bold text-red-700">5</div>
                        <div class="text-xs text-red-600 font-medium">Programas</div>
                      </div>
                      <div class="text-center p-3 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl border border-indigo-200">
                        <div class="text-lg font-bold text-indigo-700">2</div>
                        <div class="text-xs text-indigo-600 font-medium">Campus</div>
                      </div>
                    </div>

                    <div class="flex flex-wrap gap-2 justify-end">
                      <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-semibold rounded-full">Crecimiento</span>
                      <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">Mecatrónica</span>
                      <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full">3D</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="timeline-item-unique relative mb-16" data-aos="fade-up" data-aos-delay="400" data-year="2016">
                <div class="timeline-dot-unique absolute left-1/2 w-8 h-8 bg-gradient-to-br from-[var(--ut-green-500)] to-[var(--ut-green-700)] rounded-full border-4 border-white shadow-2xl transform -translate-x-1/2 z-20 cursor-pointer transition-all duration-500 hover:scale-150 hover:rotate-12">
                  <div class="absolute inset-0 bg-gradient-to-br from-[var(--ut-green-400)] to-[var(--ut-green-600)] rounded-full animate-pulse opacity-75"></div>
                  <div class="absolute inset-1 bg-white rounded-full"></div>
                  <div class="absolute inset-2 bg-gradient-to-br from-[var(--ut-green-500)] to-[var(--ut-green-700)] rounded-full"></div>
                </div>

                <div class="timeline-card-unique bg-gradient-to-r from-white via-gray-50 to-white rounded-3xl p-8 shadow-xl border border-gray-200 hover:border-[var(--ut-green-300)] transition-all duration-700 hover:shadow-2xl hover:-translate-y-2 relative overflow-hidden group">
                  <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[var(--ut-green-100)] to-transparent rounded-full opacity-50 group-hover:opacity-100 transition-opacity duration-500"></div>
                  <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-[var(--ut-green-200)] to-transparent rounded-full opacity-30 group-hover:opacity-80 transition-opacity duration-500"></div>

                  <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                      <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-cyan-700 rounded-2xl flex items-center justify-center shadow-xl">
                          <i data-feather="globe" class="w-7 h-7 text-white"></i>
                        </div>
                        <div>
                          <div class="text-3xl font-bold text-[var(--ut-green-700)] leading-none">2016</div>
                          <div class="text-sm text-gray-500 font-medium">Global</div>
                        </div>
                      </div>
                      <div class="text-right">
                        <div class="text-sm text-gray-400 font-medium">Internacional</div>
                        <div class="text-xs text-gray-500">Mundo</div>
                      </div>
                    </div>

                    <h4 class="text-2xl font-bold text-gray-900 mb-4 leading-tight">Internacionalización Estratégica</h4>

                    <p class="text-gray-700 leading-relaxed mb-6">
                      Establecimiento de 15 convenios internacionales con universidades en EE.UU. y Europa, permitiendo intercambios estudiantiles y doble titulación. Énfasis en movilidad virtual post-pandemia y colaboración en investigación global.
                    </p>

                    <div class="grid grid-cols-3 gap-4 mb-6">
                      <div class="text-center p-3 bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-xl border border-cyan-200">
                        <div class="text-lg font-bold text-cyan-700">15</div>
                        <div class="text-xs text-cyan-600 font-medium">Convenios</div>
                      </div>
                      <div class="text-center p-3 bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl border border-teal-200">
                        <div class="text-lg font-bold text-teal-700">50+</div>
                        <div class="text-xs text-teal-600 font-medium">Intercambios</div>
                      </div>
                      <div class="text-center p-3 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl border border-emerald-200">
                        <div class="text-lg font-bold text-emerald-700">3</div>
                        <div class="text-xs text-emerald-600 font-medium">Continentes</div>
                      </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                      <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-xs font-semibold rounded-full">Global</span>
                      <span class="px-3 py-1 bg-teal-100 text-teal-700 text-xs font-semibold rounded-full">Intercambio</span>
                      <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">Colaboración</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="timeline-item-unique relative mb-16" data-aos="fade-up" data-aos-delay="600" data-year="2020">
                <div class="timeline-dot-unique absolute left-1/2 w-8 h-8 bg-gradient-to-br from-[var(--ut-green-500)] to-[var(--ut-green-700)] rounded-full border-4 border-white shadow-2xl transform -translate-x-1/2 z-20 cursor-pointer transition-all duration-500 hover:scale-150 hover:rotate-12">
                  <div class="absolute inset-0 bg-gradient-to-br from-[var(--ut-green-400)] to-[var(--ut-green-600)] rounded-full animate-pulse opacity-75"></div>
                  <div class="absolute inset-1 bg-white rounded-full"></div>
                  <div class="absolute inset-2 bg-gradient-to-br from-[var(--ut-green-500)] to-[var(--ut-green-700)] rounded-full"></div>
                </div>

                <div class="timeline-card-unique bg-gradient-to-l from-white via-gray-50 to-white rounded-3xl p-8 shadow-xl border border-gray-200 hover:border-[var(--ut-green-300)] transition-all duration-700 hover:shadow-2xl hover:-translate-y-2 relative overflow-hidden group ml-auto max-w-2xl">
                  <div class="absolute top-0 left-0 w-20 h-20 bg-gradient-to-bl from-[var(--ut-green-100)] to-transparent rounded-full opacity-50 group-hover:opacity-100 transition-opacity duration-500"></div>
                  <div class="absolute bottom-0 right-0 w-16 h-16 bg-gradient-to-tl from-[var(--ut-green-200)] to-transparent rounded-full opacity-30 group-hover:opacity-80 transition-opacity duration-500"></div>

                  <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                      <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-pink-700 rounded-2xl flex items-center justify-center shadow-xl">
                          <i data-feather="monitor" class="w-7 h-7 text-white"></i>
                        </div>
                        <div>
                          <div class="text-3xl font-bold text-[var(--ut-green-700)] leading-none">2020</div>
                          <div class="text-sm text-gray-500 font-medium">Digital</div>
                        </div>
                      </div>
                      <div class="text-right">
                        <div class="text-sm text-gray-400 font-medium">Transformación</div>
                        <div class="text-xs text-gray-500">Pandemia</div>
                      </div>
                    </div>

                    <h4 class="text-2xl font-bold text-gray-900 mb-4 leading-tight text-right">Transformación Digital Acelerada</h4>

                    <p class="text-gray-700 leading-relaxed mb-6 text-right">
                      Implementación completa de plataforma e-learning con IA adaptativa y laboratorios virtuales VR. Manteniendo continuidad educativa durante la pandemia y alcanzando 100% de cobertura digital con herramientas innovadoras.
                    </p>

                    <div class="grid grid-cols-3 gap-4 mb-6">
                      <div class="text-center p-3 bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl border border-pink-200">
                        <div class="text-lg font-bold text-pink-700">100%</div>
                        <div class="text-xs text-pink-600 font-medium">Digital</div>
                      </div>
                      <div class="text-center p-3 bg-gradient-to-br from-rose-50 to-rose-100 rounded-xl border border-rose-200">
                        <div class="text-lg font-bold text-rose-700">VR</div>
                        <div class="text-xs text-rose-600 font-medium">Labs</div>
                      </div>
                      <div class="text-center p-3 bg-gradient-to-br from-fuchsia-50 to-fuchsia-100 rounded-xl border border-fuchsia-200">
                        <div class="text-lg font-bold text-fuchsia-700">IA</div>
                        <div class="text-xs text-fuchsia-600 font-medium">Adaptativa</div>
                      </div>
                    </div>

                    <div class="flex flex-wrap gap-2 justify-end">
                      <span class="px-3 py-1 bg-pink-100 text-pink-700 text-xs font-semibold rounded-full">Digital</span>
                      <span class="px-3 py-1 bg-rose-100 text-rose-700 text-xs font-semibold rounded-full">VR</span>
                      <span class="px-3 py-1 bg-fuchsia-100 text-fuchsia-700 text-xs font-semibold rounded-full">IA</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="timeline-item-unique relative mb-16" data-aos="fade-up" data-aos-delay="800" data-year="2025">
                <div class="timeline-dot-unique absolute left-1/2 w-8 h-8 bg-gradient-to-br from-[var(--ut-green-500)] to-[var(--ut-green-700)] rounded-full border-4 border-white shadow-2xl transform -translate-x-1/2 z-20 cursor-pointer transition-all duration-500 hover:scale-150 hover:rotate-12">
                  <div class="absolute inset-0 bg-gradient-to-br from-[var(--ut-green-400)] to-[var(--ut-green-600)] rounded-full animate-pulse opacity-75"></div>
                  <div class="absolute inset-1 bg-white rounded-full"></div>
                  <div class="absolute inset-2 bg-gradient-to-br from-[var(--ut-green-500)] to-[var(--ut-green-700)] rounded-full"></div>
                </div>

                <div class="timeline-card-unique bg-gradient-to-r from-white via-gray-50 to-white rounded-3xl p-8 shadow-xl border border-gray-200 hover:border-[var(--ut-green-300)] transition-all duration-700 hover:shadow-2xl hover:-translate-y-2 relative overflow-hidden group">
                  <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-[var(--ut-green-100)] to-transparent rounded-full opacity-50 group-hover:opacity-100 transition-opacity duration-500"></div>
                  <div class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-[var(--ut-green-200)] to-transparent rounded-full opacity-30 group-hover:opacity-80 transition-opacity duration-500"></div>

                  <div class="relative z-10">
                    <div class="flex items-center justify-between mb-6">
                      <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-[var(--ut-green-500)] to-[var(--ut-green-700)] rounded-2xl flex items-center justify-center shadow-xl">
                          <i data-feather="award" class="w-7 h-7 text-white"></i>
                        </div>
                        <div>
                          <div class="text-3xl font-bold text-[var(--ut-green-700)] leading-none">2025</div>
                          <div class="text-sm text-gray-500 font-medium">Futuro</div>
                        </div>
                      </div>
                      <div class="text-right">
                        <div class="text-sm text-gray-400 font-medium">Liderazgo</div>
                        <div class="text-xs text-gray-500">Sostenible</div>
                      </div>
                    </div>

                    <h4 class="text-2xl font-bold text-gray-900 mb-4 leading-tight">Liderazgo Sostenible</h4>

                    <p class="text-gray-700 leading-relaxed mb-6">
                      Reconocimiento como la universidad tecnológica #1 en innovación educativa sostenible por el QS World University Rankings. Lanzamiento de campus carbono neutral y programas especializados en energías renovables para el futuro.
                    </p>

                    <div class="grid grid-cols-3 gap-4 mb-6">
                      <div class="text-center p-3 bg-gradient-to-br from-[var(--ut-green-50)] to-[var(--ut-green-100)] rounded-xl border border-[var(--ut-green-200)]">
                        <div class="text-lg font-bold text-[var(--ut-green-700)]">#1</div>
                        <div class="text-xs text-[var(--ut-green-600)] font-medium">Ranking</div>
                      </div>
                      <div class="text-center p-3 bg-gradient-to-br from-lime-50 to-lime-100 rounded-xl border border-lime-200">
                        <div class="text-lg font-bold text-lime-700">0</div>
                        <div class="text-xs text-lime-600 font-medium">Carbono</div>
                      </div>
                      <div class="text-center p-3 bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl border border-amber-200">
                        <div class="text-lg font-bold text-amber-700">∞</div>
                        <div class="text-xs text-amber-600 font-medium">Futuro</div>
                      </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                      <span class="px-3 py-1 bg-[var(--ut-green-100)] text-[var(--ut-green-700)] text-xs font-semibold rounded-full">Sostenible</span>
                      <span class="px-3 py-1 bg-lime-100 text-lime-700 text-xs font-semibold rounded-full">Verde</span>
                      <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs font-semibold rounded-full">Futuro</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section Mejorada -->
    <div class="text-center mt-20" data-aos="fade-up">
      <div class="bg-gradient-to-r from-[var(--ut-green-600)] to-[var(--ut-green-800)] rounded-3xl p-12 text-white shadow-2xl">
        <h3 class="text-3xl font-bold mb-6">¿Quieres ser parte de nuestra historia?</h3>
        <p class="text-xl text-green-100 mb-8 max-w-2xl mx-auto leading-relaxed">
          Únete a la próxima generación de innovadores tecnológicos. Descubre nuestros programas académicos y comienza tu viaje hacia el futuro.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-6">
          <a href="carreras.php" class="bg-white text-[var(--ut-green-700)] px-8 py-4 rounded-2xl font-bold text-lg transition-all duration-300 hover:bg-gray-100 hover:scale-105 shadow-lg">
            Explorar Carreras
          </a>
          <a href="registro.php" class="border-2 border-white text-white px-8 py-4 rounded-2xl font-bold text-lg transition-all duration-300 hover:bg-white hover:text-[var(--ut-green-700)] hover:scale-105">
            Inscribirme Ahora
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Estilos Únicos para Timeline Completa -->
<style>
.timeline-container-unique {
  position: relative;
  padding: 2rem 1rem;
  min-height: 800px;
}

.timeline-line-unique {
  position: absolute;
  left: 50%;
  top: 0;
  bottom: 0;
  width: 6px;
  background: linear-gradient(180deg,
    var(--ut-green-400) 0%,
    var(--ut-green-500) 25%,
    var(--ut-green-600) 50%,
    var(--ut-green-700) 75%,
    var(--ut-green-800) 100%);
  transform: translateX(-50%);
  border-radius: 3px;
  box-shadow: 0 0 30px rgba(40, 165, 95, 0.4);
  z-index: 1;
}

.timeline-line-unique::before {
  content: '';
  position: absolute;
  top: -10px;
  left: -10px;
  right: -10px;
  bottom: -10px;
  background: linear-gradient(45deg, transparent, rgba(40, 165, 95, 0.1), transparent);
  border-radius: 50%;
  animation: lineGlow 3s ease-in-out infinite alternate;
}

@keyframes lineGlow {
  0% { opacity: 0.3; transform: scale(1); }
  100% { opacity: 0.8; transform: scale(1.1); }
}

.timeline-progress {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 0%;
  background: linear-gradient(180deg,
    rgba(255,255,255,0.9) 0%,
    rgba(255,255,255,0.6) 50%,
    rgba(255,255,255,0.3) 100%);
  border-radius: 3px;
  transition: height 2s ease-out;
  z-index: 2;
}

.timeline-item-unique {
  position: relative;
  margin-bottom: 4rem;
  z-index: 10;
}

.timeline-dot-unique {
  position: absolute;
  left: 50%;
  width: 32px;
  height: 32px;
  background: linear-gradient(135deg, var(--ut-green-500), var(--ut-green-700));
  border: 4px solid white;
  border-radius: 50%;
  box-shadow: 0 0 0 6px var(--ut-green-100), 0 0 40px rgba(40, 165, 95, 0.6);
  z-index: 20;
  transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
  transform: translateX(-50%);
}

.timeline-dot-unique:hover {
  transform: translateX(-50%) scale(1.3) rotate(180deg);
  box-shadow: 0 0 0 10px var(--ut-green-100), 0 0 60px rgba(40, 165, 95, 0.8);
}

.timeline-dot-unique::after {
  content: '';
  position: absolute;
  inset: -8px;
  border: 2px solid var(--ut-green-300);
  border-radius: 50%;
  animation: dotPulse 2s ease-in-out infinite;
  opacity: 0;
}

@keyframes dotPulse {
  0%, 100% { transform: scale(1); opacity: 0; }
  50% { transform: scale(1.5); opacity: 0.6; }
}

.timeline-card-unique {
  background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(248,250,252,0.95));
  backdrop-filter: blur(10px);
  border-radius: 24px;
  padding: 2rem;
  box-shadow: 0 20px 40px rgba(0,0,0,0.1), 0 0 0 1px rgba(255,255,255,0.2);
  border: 1px solid rgba(255,255,255,0.3);
  transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
  max-width: 600px;
}

.timeline-card-unique::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg,
    var(--ut-green-400),
    var(--ut-green-500),
    var(--ut-green-600),
    var(--ut-green-700));
  opacity: 0;
  transition: opacity 0.5s ease;
}

.timeline-card-unique:hover::before {
  opacity: 1;
}

.timeline-card-unique:hover {
  transform: translateY(-12px) scale(1.02);
  box-shadow: 0 30px 60px rgba(0,0,0,0.15), 0 0 0 1px rgba(40, 165, 95, 0.1);
}

/* Responsive Design para Timeline Única */
@media (max-width: 1024px) {
  .timeline-container-unique {
    padding: 1.5rem 0.5rem;
  }

  .timeline-line-unique {
    left: 3rem;
  }

  .timeline-dot-unique {
    left: 3rem;
  }

  .timeline-card-unique {
    margin-left: 6rem !important;
    margin-right: 0 !important;
    max-width: 500px;
  }
}

@media (max-width: 768px) {
  .timeline-container-unique {
    padding: 1rem 0.25rem;
  }

  .timeline-line-unique {
    left: 2rem;
    width: 4px;
  }

  .timeline-dot-unique {
    left: 2rem;
    width: 24px;
    height: 24px;
    border-width: 3px;
  }

  .timeline-card-unique {
    margin-left: 4rem !important;
    padding: 1.5rem;
    max-width: none;
  }

  .timeline-card-unique .grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 3rem;
  }
}

@media (max-width: 640px) {
  .timeline-line-unique {
    left: 1.5rem;
  }

  .timeline-dot-unique {
    left: 1.5rem;
    width: 20px;
    height: 20px;
  }

  .timeline-card-unique {
    margin-left: 3rem !important;
    padding: 1rem;
  }

  .timeline-card-unique .grid {
    grid-template-columns: 1fr;
    gap: 1rem;
  }

  .timeline-card-unique h4 {
    font-size: 1.5rem !important;
  }

  .timeline-card-unique .flex.items-center.justify-between {
    flex-direction: column;
    align-items: flex-start !important;
    gap: 1rem;
  }
}

@media (max-width: 480px) {
  .timeline-line-unique {
    left: 1rem;
  }

  .timeline-dot-unique {
    left: 1rem;
  }

  .timeline-card-unique {
    margin-left: 2rem !important;
    padding: 0.75rem;
  }
}

/* Animación de entrada para cards */
.timeline-card-unique[data-aos] {
  opacity: 0;
  transform: translateY(30px);
}

.timeline-card-unique[data-aos].aos-animate {
  opacity: 1;
  transform: translateY(0);
}

/* Efectos de hover mejorados */
.timeline-card-unique:hover .timeline-dot-unique {
  transform: translateX(-50%) scale(1.5) rotate(360deg);
  transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>

<!-- JavaScript para Timeline Única Completa -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Inicializar timeline con animaciones
  initTimeline();

  function initTimeline() {
    const timelineItems = document.querySelectorAll('.timeline-item-unique');
    const progressBar = document.querySelector('.timeline-progress');

    // Animación de progreso de la línea
    let progress = 0;
    const progressInterval = setInterval(() => {
      progress += 1;
      if (progressBar) {
        progressBar.style.height = `${progress}%`;
      }
      if (progress >= 100) {
        clearInterval(progressInterval);
      }
    }, 50);

    // Efectos de hover en dots
    timelineItems.forEach((item, index) => {
      const dot = item.querySelector('.timeline-dot-unique');
      const card = item.querySelector('.timeline-card-unique');

      if (dot && card) {
        // Hover en dot
        dot.addEventListener('mouseenter', () => {
          card.style.transform = 'translateY(-8px) scale(1.01)';
          card.style.boxShadow = '0 25px 50px rgba(0,0,0,0.15)';
        });

        dot.addEventListener('mouseleave', () => {
          card.style.transform = '';
          card.style.boxShadow = '';
        });

        // Hover en card
        card.addEventListener('mouseenter', () => {
          dot.style.transform = 'translateX(-50%) scale(1.2) rotate(45deg)';
          dot.style.boxShadow = '0 0 0 8px var(--ut-green-100), 0 0 40px rgba(40, 165, 95, 0.7)';
        });

        card.addEventListener('mouseleave', () => {
          dot.style.transform = 'translateX(-50%)';
          dot.style.boxShadow = '0 0 0 6px var(--ut-green-100), 0 0 40px rgba(40, 165, 95, 0.6)';
        });

        // Click para expandir/colapsar
        dot.addEventListener('click', () => toggleTimelineCard(card, dot));
        card.addEventListener('click', () => toggleTimelineCard(card, dot));
      }
    });

    // Auto-expandir primera card después de animación
    setTimeout(() => {
      const firstCard = document.querySelector('.timeline-card-unique');
      if (firstCard) {
        firstCard.classList.add('expanded');
        firstCard.style.maxHeight = 'none';
        firstCard.style.transform = 'translateY(-5px)';
      }
    }, 2000);
  }

  function toggleTimelineCard(card, dot) {
    const isExpanded = card.classList.contains('expanded');
    const allCards = document.querySelectorAll('.timeline-card-unique');
    const allDots = document.querySelectorAll('.timeline-dot-unique');

    // Cerrar todas las cards
    allCards.forEach(c => {
      c.classList.remove('expanded');
      c.style.maxHeight = '';
      c.style.transform = '';
    });

    allDots.forEach(d => {
      d.style.transform = 'translateX(-50%)';
      d.style.boxShadow = '0 0 0 6px var(--ut-green-100), 0 0 40px rgba(40, 165, 95, 0.6)';
    });

    // Abrir la card seleccionada si no estaba expandida
    if (!isExpanded) {
      card.classList.add('expanded');
      card.style.maxHeight = 'none';
      card.style.transform = 'translateY(-5px) scale(1.01)';
      card.style.boxShadow = '0 30px 60px rgba(0,0,0,0.2)';

      dot.style.transform = 'translateX(-50%) scale(1.3) rotate(180deg)';
      dot.style.boxShadow = '0 0 0 10px var(--ut-green-100), 0 0 60px rgba(40, 165, 95, 0.8)';

      // Animación de pulso
      setTimeout(() => {
        dot.style.animation = 'dotPulse 1s ease-in-out';
        setTimeout(() => {
          dot.style.animation = '';
        }, 1000);
      }, 300);
    }
  }

  // Efectos de scroll para timeline
  let ticking = false;
  window.addEventListener('scroll', () => {
    if (!ticking) {
      requestAnimationFrame(() => {
        updateTimelineOnScroll();
        ticking = false;
      });
      ticking = true;
    }
  });

  function updateTimelineOnScroll() {
    const timelineItems = document.querySelectorAll('.timeline-item-unique');
    const scrollY = window.scrollY;
    const windowHeight = window.innerHeight;

    timelineItems.forEach((item, index) => {
      const rect = item.getBoundingClientRect();
      const itemTop = rect.top + scrollY;
      const itemCenter = itemTop + rect.height / 2;

      if (scrollY + windowHeight > itemCenter - 100 && scrollY < itemCenter + 100) {
        const dot = item.querySelector('.timeline-dot-unique');
        if (dot) {
          dot.style.transform = 'translateX(-50%) scale(1.1)';
          dot.style.boxShadow = '0 0 0 8px var(--ut-green-100), 0 0 50px rgba(40, 165, 95, 0.7)';
        }
      } else {
        const dot = item.querySelector('.timeline-dot-unique');
        if (dot) {
          dot.style.transform = 'translateX(-50%)';
          dot.style.boxShadow = '0 0 0 6px var(--ut-green-100), 0 0 40px rgba(40, 165, 95, 0.6)';
        }
      }
    });
  }

  // Efectos de entrada con AOS
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const item = entry.target;
        const dot = item.querySelector('.timeline-dot-unique');
        const card = item.querySelector('.timeline-card-unique');

        // Animación de entrada del dot
        if (dot) {
          dot.style.animation = 'bounceIn 0.8s ease-out';
          setTimeout(() => {
            dot.style.animation = '';
          }, 800);
        }

        // Animación de entrada de la card
        if (card) {
          card.style.animation = 'slideInUp 1s ease-out';
          setTimeout(() => {
            card.style.animation = '';
          }, 1000);
        }

        observer.unobserve(item);
      }
    });
  }, observerOptions);

  document.querySelectorAll('.timeline-item-unique').forEach(item => {
    observer.observe(item);
  });
});

// Animaciones CSS adicionales
const style = document.createElement('style');
style.textContent = `
  @keyframes bounceIn {
    0% { transform: translateX(-50%) scale(0); opacity: 0; }
    50% { transform: translateX(-50%) scale(1.2); opacity: 1; }
    100% { transform: translateX(-50%) scale(1); opacity: 1; }
  }

  @keyframes slideInUp {
    0% { transform: translateY(50px); opacity: 0; }
    100% { transform: translateY(0); opacity: 1; }
  }

  .timeline-card-unique.expanded {
    animation: cardExpand 0.5s ease-out;
  }

  @keyframes cardExpand {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
  }
`;
document.head.appendChild(style);
</script>

<!-- Feria de Proyectos para Futuros Universitarios - Expandida -->
<section class="bg-gradient-to-br from-emerald-50 to-green-50 py-24">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-20" data-aos="fade-up">
      <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
        Feria de Proyectos para 
        <span class="text-green-600">Futuros Universitarios</span>
      </h2>
      <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
        Descubre el talento e innovación de nuestros estudiantes en esta exclusiva exhibición académica anual, donde más de 200 proyectos de ingeniería, IA y sostenibilidad se presentan a líderes comunitarios y empresariales. Edición 2025: "Innovación para un Mañana Sostenible".
      </p>
    </div>

    <!-- Mención Honorífica - Visita del Alcalde Miguel Angel - Actualizada a 2025 -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-2xl shadow-2xl overflow-hidden mb-20 relative" data-aos="zoom-in">
      <div class="absolute inset-0 bg-black/10"></div>
      <div class="md:flex relative z-10">
        <div class="md:w-2/3 p-10 md:p-16">
          <div class="flex items-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center mr-6 shadow-lg">
              <i data-feather="award" class="w-8 h-8 text-white"></i>
            </div>
            <span class="text-yellow-300 font-bold text-xl bg-yellow-400/20 px-4 py-2 rounded-full">MENCIÓN HONORÍFICA</span>
          </div>
          <h3 class="text-4xl font-bold text-white mb-6 leading-tight">
            Visita Distinguida del<br>
            <span class="text-yellow-300">Alcalde Miguel Ángel Salazar Rangel</span>
          </h3>
          <p class="text-green-100 text-lg mb-8 leading-relaxed">
            Nos honra la presencia del Alcalde Municipal Miguel Ángel Salazar Rangel, quien en febrero de 2025 reconoció la excelencia académica y el impacto social de nuestros proyectos estudiantiles, destacando iniciativas en movilidad urbana inteligente y agricultura vertical sostenible. Su visita impulsó alianzas municipales para implementación piloto de 5 proyectos ganadores.
          </p>
          <div class="flex flex-wrap items-center gap-6 text-green-200 text-sm">
            <div class="flex items-center"><i data-feather="calendar" class="w-4 h-4 mr-2"></i><span class="font-semibold">24 de Febrero, 2025</span></div>
            <div class="flex items-center"><i data-feather="users" class="w-4 h-4 mr-2"></i><span>200+ Proyectos Exhibidos</span></div>
            <div class="flex items-center"><i data-feather="award" class="w-4 h-4 mr-2"></i><span>5 Alianzas Nuevas</span></div>
          </div>
        </div>
        
        <!-- Carrusel en la parte amarilla - Mejorado -->
        <div class="md:w-1/3 bg-gradient-to-br from-yellow-400 to-yellow-600 p-6 relative">
          <div class="carousel-container relative h-full rounded-2xl overflow-hidden shadow-2xl">
            <div class="carousel-slides flex transition-transform duration-700 ease-in-out h-full">
              <div class="carousel-slide flex-shrink-0 w-full relative">
                <img src="../src/plataforma/app/img/Alcalde.jpg" alt="Alcalde Miguel Angel en la feria" class="w-full h-full object-cover rounded-2xl">
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-4">
                  <p class="text-white text-center text-sm font-semibold">Recorrido por los stands de innovación</p>
                </div>
              </div>
              <div class="carousel-slide flex-shrink-0 w-full relative">
                <img src="./plataforma/app/img/AlcaldeFeria.jpg" alt="Alcalde con estudiantes" class="w-full h-full object-cover rounded-2xl">
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-4">
                  <p class="text-white text-center text-sm font-semibold">Interacción con estudiantes y proyectos</p>
                </div>
              </div>
              <div class="carousel-slide flex-shrink-0 w-full relative">
                <img src="./plataforma/app/img/AlcaldeExplanada.jpg" alt="Reconocimiento oficial" class="w-full h-full object-cover rounded-2xl">
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/50 to-transparent p-4">
                  <p class="text-white text-center text-sm font-semibold">Reconocimiento oficial en explanada</p>
                </div>
              </div>
            </div>
            
            <!-- Controles mejorados -->
            <button class="carousel-prev absolute left-3 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white text-yellow-600 w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-lg">
              <i data-feather="chevron-left" class="w-5 h-5"></i>
            </button>
            <button class="carousel-next absolute right-3 top-1/2 transform -translate-y-1/2 bg-white/90 hover:bg-white text-yellow-600 w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-lg">
              <i data-feather="chevron-right" class="w-5 h-5"></i>
            </button>
            
            <!-- Indicadores mejorados -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3 bg-white/20 backdrop-blur-md rounded-full p-2">
              <div class="carousel-indicator w-3 h-3 bg-white/60 rounded-full cursor-pointer hover:bg-white transition-all duration-300" data-slide="0"></div>
              <div class="carousel-indicator w-3 h-3 bg-white/60 rounded-full cursor-pointer hover:bg-white transition-all duration-300" data-slide="1"></div>
              <div class="carousel-indicator w-3 h-3 bg-white/60 rounded-full cursor-pointer hover:bg-white transition-all duration-300" data-slide="2"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Proyectos Destacados - Expandido con más detalles -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10 mb-16">
      <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition-all duration-500 relative" data-aos="fade-up">
        <div class="relative overflow-hidden">
          <img src="./plataforma/app/img/14-IMG_2845.jpg" alt="Feria Tecnológica" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
          <div class="absolute top-4 right-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
            Innovación 2025
          </div>
          <div class="absolute inset-0 bg-gradient-to-t from-black/40 to transparent"></div>
        </div>
        <div class="p-8">
          <h3 class="text-2xl font-bold text-gray-900 mb-4 leading-tight">Proyectos de Tecnología Avanzada</h3>
          <p class="text-gray-600 mb-6 leading-relaxed">Soluciones innovadoras en robótica colaborativa, IoT industrial y IA predictiva desarrolladas por futuros ingenieros, con prototipos funcionales probados en entornos reales y potencial de patentes internacionales.</p>
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center text-sm text-gray-500">
              <i data-feather="users" class="w-5 h-5 mr-2 text-green-600"></i>
              <span>Ingeniería & IA</span>
            </div>
            <div class="flex items-center text-sm text-green-600 font-semibold">
              <i data-feather="star" class="w-4 h-4 mr-1"></i>
              4.8/5 Calificación
            </div>
          </div>
          <button class="w-full bg-gradient-to-r from-green-600 to-emerald-700 text-white py-3 rounded-xl font-semibold transition-all duration-300 hover:from-green-700 hover:to-emerald-800 transform hover:scale-105">
            Explorar Detalles
          </button>
        </div>
      </div>
      
      <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition-all duration-500 relative" data-aos="fade-up" data-aos-delay="100">
        <div class="relative overflow-hidden">
          <img src="./plataforma/app/img/Mecatronica.jpg" alt="Expo Ingeniería" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
          <div class="absolute top-4 right-4 bg-gradient-to-r from-blue-500 to-cyan-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
            Ingeniería 2025
          </div>
          <div class="absolute inset-0 bg-gradient-to-t from-black/40 to transparent"></div>
        </div>
        <div class="p-8">
          <h3 class="text-2xl font-bold text-gray-900 mb-4 leading-tight">Mecatrónica y Automatización Industrial</h3>
          <p class="text-gray-600 mb-6 leading-relaxed">Sistemas automatizados, brazos robóticos y líneas de producción inteligentes creados por estudiantes de mecatrónica, integrando sensores IoT y control por visión artificial para optimización energética en la industria 4.0.</p>
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center text-sm text-gray-500">
              <i data-feather="cpu" class="w-5 h-5 mr-2 text-blue-600"></i>
              <span>Mecatrónica</span>
            </div>
            <div class="flex items-center text-sm text-blue-600 font-semibold">
              <i data-feather="star" class="w-4 h-4 mr-1"></i>
              4.9/5 Calificación
            </div>
          </div>
          <button class="w-full bg-gradient-to-r from-blue-600 to-cyan-700 text-white py-3 rounded-xl font-semibold transition-all duration-300 hover:from-blue-700 hover:to-cyan-800 transform hover:scale-105">
            Explorar Detalles
          </button>
        </div>
      </div>
      
      <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition-all duration-500 relative" data-aos="fade-up" data-aos-delay="200">
        <div class="relative overflow-hidden">
          <img src="./plataforma/app/img/Negocios.jpg" alt="Foro de Innovación" class="w-full h-56 object-cover transition-transform duration-500 hover:scale-110">
          <div class="absolute top-4 right-4 bg-gradient-to-r from-purple-500 to-pink-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
            Emprendimiento 2025
          </div>
          <div class="absolute inset-0 bg-gradient-to-t from-black/40 to transparent"></div>
        </div>
        <div class="p-8">
          <h3 class="text-2xl font-bold text-gray-900 mb-4 leading-tight">Innovación Empresarial y Startups</h3>
          <p class="text-gray-600 mb-6 leading-relaxed">Modelos de negocio disruptivos, apps fintech y plataformas de e-commerce sostenible desarrollados por futuros empresarios, con validación de mercado y pitch a inversores reales en colaboración con INCmty.</p>
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center text-sm text-gray-500">
              <i data-feather="trending-up" class="w-5 h-5 mr-2 text-purple-600"></i>
              <span>Negocios Digitales</span>
            </div>
            <div class="flex items-center text-sm text-purple-600 font-semibold">
              <i data-feather="star" class="w-4 h-4 mr-1"></i>
              4.7/5 Calificación
            </div>
          </div>
          <button class="w-full bg-gradient-to-r from-purple-600 to-pink-700 text-white py-3 rounded-xl font-semibold transition-all duration-300 hover:from-purple-700 hover:to-pink-800 transform hover:scale-105">
            Explorar Detalles
          </button>
        </div>
      </div>
    </div>

  </div>
</section>

<style>
.carousel-container {
  height: 320px;
}

.carousel-slides {
  height: 100%;
}

.carousel-slide {
  width: 100%;
}

.carousel-indicator.active {
  background: white !important;
  transform: scale(1.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const carouselSlides = document.querySelector('.carousel-slides');
  const indicators = document.querySelectorAll('.carousel-indicator');
  const prevBtn = document.querySelector('.carousel-prev');
  const nextBtn = document.querySelector('.carousel-next');
  
  let currentSlide = 0;
  const totalSlides = 3;
  const slideInterval = 4000;
  
  function showSlide(slideIndex) {
    currentSlide = (slideIndex + totalSlides) % totalSlides;
    carouselSlides.style.transform = `translateX(-${currentSlide * 100}%)`;
    
    indicators.forEach((indicator, index) => {
      indicator.classList.toggle('active', index === currentSlide);
    });
  }
  
  function nextSlide() {
    showSlide(currentSlide + 1);
  }
  
  function prevSlide() {
    showSlide(currentSlide - 1);
  }
  
  nextBtn.addEventListener('click', nextSlide);
  prevBtn.addEventListener('click', prevSlide);
  
  indicators.forEach((indicator, index) => {
    indicator.addEventListener('click', () => showSlide(index));
  });
  
  let autoSlide = setInterval(nextSlide, slideInterval);
  
  const carouselContainer = document.querySelector('.carousel-container');
  carouselContainer.addEventListener('mouseenter', () => clearInterval(autoSlide));
  carouselContainer.addEventListener('mouseleave', () => autoSlide = setInterval(nextSlide, slideInterval));
  
  indicators[0].classList.add('active');
  feather.replace();
});
</script>

<!-- Campus y Planteles - Expandido -->
<section class="py-24 bg-gradient-to-b from-white to-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-20" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl mb-6">Nuestros Planteles</h2>
      <p class="text-xl text-gray-500 max-w-3xl mx-auto leading-relaxed">Infraestructura de vanguardia con certificación LEED para sostenibilidad, equipada con labs de IA, centros de makerspace y espacios colaborativos diseñados para fomentar la innovación y el bienestar estudiantil.</p>
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
      <!-- Campus Central -->
      <div class="campus-card bg-white rounded-2xl shadow-2xl overflow-hidden relative group" data-aos="fade-up">
        <div class="relative overflow-hidden">
          <img src="./plataforma/app/img/PlantelUT.jpg" alt="Campus Montemorelos" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700">
          <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        </div>
        <div class="p-8 relative z-10">
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Campus Montemorelos</h3>
          <p class="text-gray-600 mb-6 leading-relaxed">Extensión estratégica de UTSC con laboratorios especializados en biotecnología, biblioteca digital 24/7 y áreas de innovación abierta. Equipado con paneles solares y sistemas de riego inteligente para operaciones carbono neutral.</p>
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center text-sm text-[var(--ut-green-700)] font-semibold">
              <i data-feather="users" class="w-5 h-5 mr-2"></i>
              1,200+ Estudiantes
            </div>
            <div class="flex items-center text-sm text-gray-500 cursor-pointer hover:text-[var(--ut-green-700)] transition-colors">
              <i data-feather="map-pin" class="w-4 h-4 mr-1"></i>
              <a href="https://www.google.com/maps/search/?api=1&query=Av.+Las+Adjuntas+S%2FN%2C+Col.+Bugambilias%2C+Montemorelos%2C+N.L.%2C+C.P.+67535" target="_blank" class="location-link hover:underline">
                Montemorelos, NL
              </a>
            </div>
          </div>
          <button class="conocer-mas-btn w-full bg-gradient-to-r from-[var(--ut-green-600)] to-[var(--ut-green-700)] text-white py-3 rounded-xl font-semibold transition-all duration-300 hover:from-[var(--ut-green-700)] hover:to-[var(--ut-green-800)] transform hover:scale-105" data-campus="central">
            Descubrir Campus
          </button>
        </div>
      </div>
      
      <!-- Campus Tecnológico -->
      <div class="campus-card bg-white rounded-2xl shadow-2xl overflow-hidden relative group" data-aos="fade-up" data-aos-delay="100">
        <div class="relative overflow-hidden">
          <img src="./plataforma/app/img/Universidad Tecnologia Santa Catarina.jpg" alt="Campus Santa Catarina" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700">
          <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        </div>
        <div class="p-8 relative z-10">
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Campus Santa Catarina</h3>
          <p class="text-gray-600 mb-6 leading-relaxed">Sede principal con ingenierías avanzadas, talleres de manufactura aditiva (impresión 3D) y centro de ciberseguridad certificado. Incluye auditorio para 1,000 personas y gimnasio con equipo biomecánico.</p>
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center text-sm text-[var(--ut-green-700)] font-semibold">
              <i data-feather="users" class="w-5 h-5 mr-2"></i>
              2,500+ Estudiantes
            </div>
            <div class="flex items-center text-sm text-gray-500 cursor-pointer hover:text-[var(--ut-green-700)] transition-colors">
              <i data-feather="map-pin" class="w-4 h-4 mr-1"></i>
              <a href="https://www.google.com/maps/search/?api=1&query=Carretera+Saltillo-Monterrey+Km.+61.5%2C+Santa+Catarina%2C+N.L.%2C+C.P.+66359" target="_blank" class="location-link hover:underline">
                Santa Catarina, NL
              </a>
            </div>
          </div>
          <button class="conocer-mas-btn w-full bg-gradient-to-r from-[var(--ut-green-600)] to-[var(--ut-green-700)] text-white py-3 rounded-xl font-semibold transition-all duration-300 hover:from-[var(--ut-green-700)] hover:to-[var(--ut-green-800)] transform hover:scale-105" data-campus="tecnologico">
            Descubrir Campus
          </button>
        </div>
      </div>
      
      <!-- Campus de Innovación -->
      <div class="campus-card bg-white rounded-2xl shadow-2xl overflow-hidden relative group" data-aos="fade-up" data-aos-delay="200">
        <div class="relative overflow-hidden">
          <img src="./plataforma/app/img/Campus Linares.jpg" alt="Campus Linares" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-700">
          <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        </div>
        <div class="p-8 relative z-10">
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Campus Linares</h3>
          <p class="text-gray-600 mb-6 leading-relaxed">Enfoque en agro-tecnología y turismo inteligente, con huertos hidropónicos, incubadora de startups y centro de simulación VR para experiencias inmersivas en herencia cultural regional.</p>
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center text-sm text-[var(--ut-green-700)] font-semibold">
              <i data-feather="users" class="w-5 h-5 mr-2"></i>
              1,800+ Estudiantes
            </div>
            <div class="flex items-center text-sm text-gray-500 cursor-pointer hover:text-[var(--ut-green-700)] transition-colors">
              <i data-feather="map-pin" class="w-4 h-4 mr-1"></i>
              <a href="https://www.google.com/maps/search/?api=1&query=Antiguo+Camino+a+Hualahuises+S%2FN%2C+Col.+Camachito%2C+Linares%2C+N.L.%2C+C.P.+67867" target="_blank" class="location-link hover:underline">
                Linares, NL
              </a>
            </div>
          </div>
          <button class="conocer-mas-btn w-full bg-gradient-to-r from-[var(--ut-green-600)] to-[var(--ut-green-700)] text-white py-3 rounded-xl font-semibold transition-all duration-300 hover:from-[var(--ut-green-700)] hover:to-[var(--ut-green-800)] transform hover:scale-105" data-campus="innovacion">
            Descubrir Campus
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal para Campus - Unificado y mejorado -->
<div id="campusModal" class="fixed inset-0 bg-black/90 flex items-center justify-center z-50 hidden">
  <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl max-w-6xl w-full mx-4 max-h-[95vh] overflow-y-auto relative">
    <!-- Header -->
    <div class="flex justify-between items-center p-8 border-b border-white/20 sticky top-0 bg-white/95 z-10">
      <div>
        <h3 id="modalTitle" class="text-3xl font-bold text-gray-900 mb-1">Campus Central</h3>
        <p id="modalSubtitle" class="text-gray-600 text-lg">Descubre nuestra infraestructura de vanguardia</p>
      </div>
      <button id="closeModal" class="text-gray-500 hover:text-gray-700 transition-all duration-300 hover:scale-110">
        <i data-feather="x" class="w-8 h-8"></i>
      </button>
    </div>
    
    <!-- Carrusel de fotos -->
    <div class="relative h-96 md:h-[500px]">
      <div id="carouselSlides" class="flex h-full transition-transform duration-700 ease-in-out"></div>
      
      <button id="carouselPrev" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 w-12 h-12 rounded-full flex items-center justify-center shadow-xl transition-all duration-300 hover:scale-110 z-10">
        <i data-feather="chevron-left" class="w-6 h-6"></i>
      </button>
      <button id="carouselNext" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 w-12 h-12 rounded-full flex items-center justify-center shadow-xl transition-all duration-300 hover:scale-110 z-10">
        <i data-feather="chevron-right" class="w-6 h-6"></i>
      </button>
      
      <div id="carouselIndicators" class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-3 bg-black/30 backdrop-blur-md rounded-full p-2"></div>
    </div>
    
    <!-- Información adicional -->
    <div class="p-8 bg-gradient-to-r from-gray-50 to-white">
      <p id="modalDescription" class="text-gray-700 text-lg mb-6 leading-relaxed"></p>
      <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-gray-500">
        <div class="flex items-center"><i data-feather="wifi" class="w-4 h-4 mr-2"></i><span>Conectividad 5G Completa</span></div>
        <div class="flex items-center"><i data-feather="leaf" class="w-4 h-4 mr-2"></i><span>Certificado LEED Oro</span></div>
        <div class="flex items-center"><i data-feather="accessibility" class="w-4 h-4 mr-2"></i><span>Accesible 100%</span></div>
      </div>
    </div>

    <!-- Nueva sección de Ubicación -->
    <div id="modalLocation" class="p-8 bg-gray-50 border-t border-gray-100">
      <h4 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
        <i data-feather="map-pin" class="w-5 h-5 text-[var(--ut-green-600)]"></i>
        Ubicación Exacta
      </h4>
      <p id="modalAddress" class="text-gray-700 mb-4 text-lg font-medium"></p>
      <iframe id="mapEmbed" src="" width="100%" height="300" style="border:0; border-radius: 8px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</div>

<style>
#campusModal .carousel-slide img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.carousel-indicator {
  width: 12px;
  height: 12px;
  background-color: rgba(255,255,255,0.5);
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.4s ease;
}

.carousel-indicator.active {
  background-color: white;
  transform: scale(1.3);
}

/* Estilos para la ubicación clickable */
.location-link {
  cursor: pointer;
  transition: color 0.2s ease;
}

.location-link:hover {
  color: var(--ut-green-700) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const modal = document.getElementById('campusModal');
  const closeModal = document.getElementById('closeModal');
  const conocerMasBtns = document.querySelectorAll('.conocer-mas-btn');
  const modalTitle = document.getElementById('modalTitle');
  const modalSubtitle = document.getElementById('modalSubtitle');
  const modalDescription = document.getElementById('modalDescription');
  const modalAddress = document.getElementById('modalAddress');
  const mapEmbed = document.getElementById('mapEmbed');
  const carouselSlides = document.getElementById('carouselSlides');
  const carouselIndicators = document.getElementById('carouselIndicators');
  const carouselPrev = document.getElementById('carouselPrev');
  const carouselNext = document.getElementById('carouselNext');
  
  let currentSlide = 0;
  let currentCampus = '';
  
  const campusData = {
    central: {
      title: 'Campus Montemorelos',
      subtitle: 'Innovación en un Entorno Natural',
      description: 'Nuestro campus en Montemorelos integra tecnología de punta con un entorno ecológico único, contando con labs de biotecnología equipados con secuenciadores genéticos y un makerspace de 1,000 m² para prototipado rápido. Destaca por su programa de conservación de biodiversidad local y clases al aire libre.',
      location: {
        address: 'Av. Las Adjuntas S/N, Col. Bugambilias, Montemorelos, N.L., C.P. 67535'
      },
      images: [
        './plataforma/app/img/125-IMG_4241.jpg',
        './plataforma/app/img/122-IMG_3871.jpg',
        './plataforma/app/img/121-IMG_3861.jpg',
        './plataforma/app/img/120-IMG_3842.jpg',
        './plataforma/app/img/119-IMG_3836.jpg',
        './plataforma/app/img/118-IMG_3825.jpg',
        './plataforma/app/img/117-IMG_3822.jpg',
        './plataforma/app/img/116-IMG_3819.jpg',
        './plataforma/app/img/115-IMG_3808.jpg',
        './plataforma/app/img/114-IMG_3800.jpg'
      ]
    },
    tecnologico: {
      title: 'Campus Santa Catarina',
      subtitle: 'Corazón de la Ingeniería Avanzada',
      description: 'Sede principal con más de 20 labs especializados, incluyendo un centro de ciberseguridad con simuladores de hacking ético y talleres de impresión 3D industrial. Incluye un data center propio con IA para optimización energética y auditorio holográfico para conferencias globales.',
      location: {
        address: 'Carretera Saltillo-Monterrey Km. 61.5, Santa Catarina, N.L., C.P. 66359'
      },
      images: [
        './plataforma/app/img/tecnologico1.jpg',
        './plataforma/app/img/tecnologico2.jpg',
        './plataforma/app/img/tecnologico3.jpg',
        './plataforma/app/img/tecnologico4.jpg',
        './plataforma/app/img/tecnologico5.jpg',
        './plataforma/app/img/tecnologico6.jpg',
        './plataforma/app/img/tecnologico7.jpg',
        './plataforma/app/img/tecnologico8.jpg',
        './plataforma/app/img/tecnologico9.jpg',
        './plataforma/app/img/tecnologico10.jpg'
      ]
    },
    innovacion: {
      title: 'Campus Linares',
      subtitle: 'Cuna del Emprendimiento Agro-Tech',
      description: 'Diseñado para innovación regional, con huertos hidropónicos inteligentes, incubadora de startups con mentorship de INCmty y centro VR para turismo virtual. Enfocado en agroindustria 4.0, con drones para monitoreo agrícola y programas de economía circular que han generado 15 startups activas.',
      location: {
        address: 'Antiguo Camino a Hualahuises S/N, Col. Camachito, Linares, N.L., C.P. 67867'
      },
      images: [
        './plataforma/app/img/innovacion1.jpg',
        './plataforma/app/img/innovacion2.jpg',
        './plataforma/app/img/innovacion3.jpg',
        './plataforma/app/img/innovacion4.jpg',
        './plataforma/app/img/innovacion5.jpg',
        './plataforma/app/img/innovacion6.jpg',
        './plataforma/app/img/innovacion7.jpg',
        './plataforma/app/img/innovacion8.jpg',
        './plataforma/app/img/innovacion9.jpg',
        './plataforma/app/img/innovacion10.jpg'
      ]
    }
  };
  
  function openCampusModal(campus) {
    currentCampus = campus;
    openModal(currentCampus);
  }
  
  function openModal(campus) {
    const data = campusData[campus];
    modalTitle.textContent = data.title;
    modalSubtitle.textContent = data.subtitle;
    modalDescription.textContent = data.description;
    modalAddress.textContent = data.location.address;
    
    const mapUrl = `https://www.google.com/maps/embed/v1/place?q=${encodeURIComponent(data.location.address)}&key=`;
    mapEmbed.src = mapUrl;
    
    carouselSlides.innerHTML = '';
    carouselIndicators.innerHTML = '';
    
    data.images.forEach((image, index) => {
      const slide = document.createElement('div');
      slide.className = 'carousel-slide flex-shrink-0 w-full';
      slide.innerHTML = `<img src="${image}" alt="${data.title} - Imagen ${index + 1}" class="w-full h-full object-cover">`;
      carouselSlides.appendChild(slide);
      
      const indicator = document.createElement('div');
      indicator.className = `carousel-indicator ${index === 0 ? 'active' : ''}`;
      indicator.addEventListener('click', () => {
        currentSlide = index;
        updateCarousel();
      });
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
  
  conocerMasBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      currentCampus = this.getAttribute('data-campus');
      openModal(currentCampus);
    });
  });
  
  closeModal.addEventListener('click', closeModalFunc);
  modal.addEventListener('click', function(e) {
    if (e.target === modal) closeModalFunc();
  });
  
  carouselPrev.addEventListener('click', () => {
    currentSlide = (currentSlide - 1 + campusData[currentCampus].images.length) % campusData[currentCampus].images.length;
    updateCarousel();
  });
  
  carouselNext.addEventListener('click', () => {
    currentSlide = (currentSlide + 1) % campusData[currentCampus].images.length;
    updateCarousel();
  });
  
  function updateCarousel() {
    carouselSlides.style.transform = `translateX(-${currentSlide * 100}%)`;
    const indicators = carouselIndicators.querySelectorAll('.carousel-indicator');
    indicators.forEach((indicator, index) => {
      indicator.classList.toggle('active', index === currentSlide);
    });
  }
  
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
      closeModalFunc();
    }
  });
  
  // Exponer función global para onclick en HTML
  window.openCampusModal = openCampusModal;
});
</script>

<!-- Tradición Deportiva UTSC - Expandida y Unificada -->
<section class="py-24 bg-gradient-to-b from-gray-50 to-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-20" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl mb-6">Tradición Deportiva UTSC</h2>
      <p class="text-xl text-gray-500 max-w-3xl mx-auto leading-relaxed">Formando atletas de excelencia con valores universitarios, integrando deporte inclusivo y salud mental. En 2025, expandimos a e-sports con torneos de IA gaming y wellness programs certificados.</p>
    </div>
    
    <div class="grid lg:grid-cols-2 gap-12 mb-20">
      <!-- Selección de Fútbol -->
      <div class="sports-card bg-white rounded-3xl shadow-2xl overflow-hidden relative group" data-aos="fade-up">
        <div class="relative overflow-hidden h-72">
          <img src="./plataforma/app/img/SeleccionUT.jpg" alt="Selección de Fútbol" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
          <div class="absolute inset-0 bg-gradient-to-t from-black/40 to transparent"></div>
          <div class="absolute bottom-6 left-6">
            <h3 class="text-3xl font-bold text-white mb-2">Selección de Fútbol</h3>
            <p class="text-green-200 text-lg font-semibold">Representación Masculina</p>
          </div>
          <div class="absolute top-6 right-6">
            <div class="bg-green-500/90 backdrop-blur-sm rounded-full px-4 py-2 shadow-lg">
              <span class="text-white text-base font-bold">ACTIVO 2025</span>
            </div>
          </div>
        </div>
        
        <div class="p-8 relative z-10">
          <div class="grid grid-cols-3 gap-6 mb-8 text-center">
            <div class="p-4">
              <div class="text-3xl font-bold text-green-600 mb-2">18</div>
              <div class="text-sm text-gray-600 font-medium">Jugadores</div>
            </div>
            <div class="p-4">
              <div class="text-3xl font-bold text-green-600 mb-2">4</div>
              <div class="text-sm text-gray-600 font-medium">Torneos</div>
            </div>
            <div class="p-4">
              <div class="text-3xl font-bold text-green-600 mb-2">2024</div>
              <div class="text-sm text-gray-600 font-medium">Campeones Regionales</div>
            </div>
          </div>
          
          <p class="text-gray-600 mb-6 text-lg leading-relaxed">
            Nuestra selección de fútbol encarna disciplina, trabajo en equipo y excelencia, compitiendo en ligas interuniversitarias con un enfoque en desarrollo integral, incluyendo talleres de nutrición deportiva y liderazgo comunitario.
          </p>
          
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3 text-sm text-gray-500">
              <i data-feather="calendar" class="w-5 h-5 text-green-600"></i>
              <span class="font-semibold">Lun/Mié/Jue: 18:00-20:00</span>
            </div>
            <button class="ver-galeria-btn text-green-600 hover:text-green-700 font-bold text-base flex items-center gap-2 transition-all duration-300 hover:scale-105" data-equipo="futbol">
              Ver Galería Completa
              <i data-feather="image" class="w-5 h-5"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Equipo de Tochito Femenino -->
      <div class="sports-card bg-white rounded-3xl shadow-2xl overflow-hidden relative group" data-aos="fade-up" data-aos-delay="100">
        <div class="relative overflow-hidden h-72">
          <img src="./plataforma/app/img/SeleccionTocho.jpg" alt="Tochito Femenino" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
          <div class="absolute inset-0 bg-gradient-to-t from-black/40 to transparent"></div>
          <div class="absolute bottom-6 left-6">
            <h3 class="text-3xl font-bold text-white mb-2">Tochito Femenino</h3>
            <p class="text-purple-200 text-lg font-semibold">Representación Femenina</p>
          </div>
          <div class="absolute top-6 right-6">
            <div class="bg-purple-500/90 backdrop-blur-sm rounded-full px-4 py-2 shadow-lg">
              <span class="text-white text-base font-bold">ACTIVO 2025</span>
            </div>
          </div>
        </div>
        
        <div class="p-8 relative z-10">
          <div class="grid grid-cols-3 gap-6 mb-8 text-center">
            <div class="p-4">
              <div class="text-3xl font-bold text-purple-600 mb-2">15</div>
              <div class="text-sm text-gray-600 font-medium">Jugadoras</div>
            </div>
            <div class="p-4">
              <div class="text-3xl font-bold text-purple-600 mb-2">3</div>
              <div class="text-sm text-gray-600 font-medium">Torneos</div>
            </div>
            <div class="p-4">
              <div class="text-3xl font-bold text-purple-600 mb-2">2025</div>
              <div class="text-sm text-gray-600 font-medium">Campeonas Estatales</div>
            </div>
          </div>
          
          <p class="text-gray-600 mb-6 text-lg leading-relaxed">
            El equipo de tochito femenino promueve empoderamiento, estrategia y resiliencia, participando en torneos nacionales con énfasis en equidad de género y programas de mentoría para atletas emergentes.
          </p>
          
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3 text-sm text-gray-500">
              <i data-feather="calendar" class="w-5 h-5 text-purple-600"></i>
              <span class="font-semibold">Mar/Jue/Vie: 17:00-19:00</span>
            </div>
            <button class="ver-galeria-btn text-purple-600 hover:text-purple-700 font-bold text-base flex items-center gap-2 transition-all duration-300 hover:scale-105" data-equipo="tochito">
              Ver Galería Completa
              <i data-feather="image" class="w-5 h-5"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Logros Deportivos - Expandido -->
    <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-2xl p-12 text-center" data-aos="fade-up">
      <h3 class="text-3xl font-bold text-gray-900 mb-10">Logros Destacados 2025</h3>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="p-6">
          <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path d="M5 3a2 2 0 00-2 2v2a2 2 0 00-2 2v4a2 2 0 002 2h2a2 2 0 002 2v2a2 2 0 002 2h4a2 2 0 002-2v-2a2 2 0 002-2h2a2 2 0 002-2V9a2 2 0 00-2-2h-2a2 2 0 00-2-2V5a2 2 0 00-2-2H5z"/>
            </svg>
          </div>
          <h4 class="text-xl font-bold text-gray-900 mb-3">Campeonato Nacional 2024</h4>
          <p class="text-gray-600 text-lg">Liga Interuniversitaria de Fútbol, con invicto de 12 partidos y premio al fair play.</p>
        </div>
        <div class="p-6">
          <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
          </div>
          <h4 class="text-xl font-bold text-gray-900 mb-3">Subcampeonato Nacional 2025</h4>
          <p class="text-gray-600 text-lg">Torneo Nacional de Tochito Femenino, destacando en estrategia y liderazgo femenino.</p>
        </div>
        <div class="p-6">
          <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
            </svg>
          </div>
          <h4 class="text-xl font-bold text-gray-900 mb-3">+75 Atletas Formados</h4>
          <p class="text-gray-600 text-lg">En programas integrales con becas deportivas y certificación en coaching mental.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal Unificado para Galerías Deportivas -->
<div id="galeriaModal" class="fixed inset-0 bg-black/90 flex items-center justify-center z-50 hidden">
  <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl max-w-6xl w-full mx-4 max-h-[95vh] overflow-hidden relative">
    <div class="flex justify-between items-center p-8 border-b border-white/20">
      <div>
        <h3 id="galeriaTitle" class="text-3xl font-bold text-gray-900 mb-1">Galería Deportiva</h3>
        <p id="galeriaSubtitle" class="text-gray-600 text-lg">Momentos inolvidables de nuestra tradición atlética</p>
      </div>
      <button id="closeGaleriaModal" class="text-gray-500 hover:text-gray-700 transition-all duration-300 hover:scale-110">
        <i data-feather="x" class="w-8 h-8"></i>
      </button>
    </div>
    
    <div class="relative h-96 md:h-[500px]">
      <div id="galeriaSlides" class="flex h-full transition-transform duration-700 ease-in-out"></div>
      
      <button id="galeriaPrev" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 w-12 h-12 rounded-full flex items-center justify-center shadow-xl transition-all duration-300 hover:scale-110 z-10">
        <i data-feather="chevron-left" class="w-6 h-6"></i>
      </button>
      <button id="galeriaNext" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 w-12 h-12 rounded-full flex items-center justify-center shadow-xl transition-all duration-300 hover:scale-110 z-10">
        <i data-feather="chevron-right" class="w-6 h-6"></i>
      </button>
      
      <div id="galeriaIndicators" class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-3 bg-black/30 backdrop-blur-md rounded-full p-2"></div>
    </div>
    
    <div class="p-8 bg-gradient-to-r from-gray-50 to-white">
      <p id="galeriaDescription" class="text-gray-700 text-lg mb-6 leading-relaxed"></p>
      <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-gray-500">
        <div class="flex items-center"><i data-feather="heart" class="w-4 h-4 mr-2 text-red-500"></i><span>Pasión Deportiva</span></div>
        <div class="flex items-center"><i data-feather="users" class="w-4 h-4 mr-2"></i><span>Equipo Unido</span></div>
        <div class="flex items-center"><i data-feather="star" class="w-4 h-4 mr-2 text-yellow-500"></i><span>Logros 2025</span></div>
      </div>
    </div>
  </div>
</div>

<style>
#galeriaModal .galeria-slide img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.galeria-indicator {
  width: 12px;
  height: 12px;
  background-color: rgba(255,255,255,0.5);
  border-radius: 50%;
  cursor: pointer;
  transition: all 0.4s ease;
}

.galeria-indicator.active {
  background-color: white;
  transform: scale(1.3);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const galeriaModal = document.getElementById('galeriaModal');
  const closeGaleriaModal = document.getElementById('closeGaleriaModal');
  const verGaleriaBtns = document.querySelectorAll('.ver-galeria-btn');
  const galeriaTitle = document.getElementById('galeriaTitle');
  const galeriaSubtitle = document.getElementById('galeriaSubtitle');
  const galeriaDescription = document.getElementById('galeriaDescription');
  const galeriaSlides = document.getElementById('galeriaSlides');
  const galeriaIndicators = document.getElementById('galeriaIndicators');
  const galeriaPrev = document.getElementById('galeriaPrev');
  const galeriaNext = document.getElementById('galeriaNext');
  
  let currentGaleriaSlide = 0;
  let currentEquipo = '';
  
  const equipoData = {
    futbol: {
      title: 'Selección de Fútbol Masculino',
      subtitle: 'Gloria en el Campo 2025',
      description: 'Capturando la pasión, estrategia y unidad de nuestra selección en torneos regionales y nacionales. Incluye highlights del campeonato 2024 y entrenamientos innovadores con análisis biomecánico.',
      images: [
        './plataforma/app/img/1-IMG_2145.jpg',
        './plataforma/app/img/97-IMG_3440.jpg',
        './plataforma/app/img/96-IMG_3429.jpg',
        './plataforma/app/img/95-IMG_3364.jpg',
        './plataforma/app/img/103-IMG_3680.jpg',
        './plataforma/app/img/129-03990da8-238f-4839-9fc0-dfbb8905671e.jpg'
      ]
    },
    tochito: {
      title: 'Equipo de Tochito Femenino',
      subtitle: 'Empoderamiento en Acción 2025',
      description: 'Momentos empoderadores de jugadas decisivas, celebraciones y entrenamientos inclusivos. Destacando el subcampeonato nacional 2025 y programas de equidad de género en el deporte universitario.',
      images: [
        './plataforma/app/img/2-IMG_2663.jpg',
        './plataforma/app/img/123-IMG_7641.jpg',
        './plataforma/app/img/101-IMG_4617.jpg',
        './plataforma/app/img/99-IMG_3636.jpg'
        
      ]
    }
  };
  
  verGaleriaBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      currentEquipo = this.getAttribute('data-equipo');
      openGaleriaModal(currentEquipo);
    });
  });
  
  closeGaleriaModal.addEventListener('click', closeGaleriaModalFunc);
  galeriaModal.addEventListener('click', function(e) {
    if (e.target === galeriaModal) closeGaleriaModalFunc();
  });
  
  galeriaPrev.addEventListener('click', () => {
    currentGaleriaSlide = (currentGaleriaSlide - 1 + equipoData[currentEquipo].images.length) % equipoData[currentEquipo].images.length;
    updateGaleriaCarousel();
  });
  
  galeriaNext.addEventListener('click', () => {
    currentGaleriaSlide = (currentGaleriaSlide + 1) % equipoData[currentEquipo].images.length;
    updateGaleriaCarousel();
  });
  
  function openGaleriaModal(equipo) {
    const data = equipoData[equipo];
    galeriaTitle.textContent = data.title;
    galeriaSubtitle.textContent = data.subtitle;
    galeriaDescription.textContent = data.description;
    
    galeriaSlides.innerHTML = '';
    galeriaIndicators.innerHTML = '';
    
    data.images.forEach((image, index) => {
      const slide = document.createElement('div');
      slide.className = 'galeria-slide flex-shrink-0 w-full';
      slide.innerHTML = `<img src="${image}" alt="${data.title} - Imagen ${index + 1}" class="w-full h-full object-cover">`;
      galeriaSlides.appendChild(slide);
      
      const indicator = document.createElement('div');
      indicator.className = `galeria-indicator ${index === 0 ? 'active' : ''}`;
      indicator.addEventListener('click', () => {
        currentGaleriaSlide = index;
        updateGaleriaCarousel();
      });
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
  
  function updateGaleriaCarousel() {
    galeriaSlides.style.transform = `translateX(-${currentGaleriaSlide * 100}%)`;
    const indicators = galeriaIndicators.querySelectorAll('.galeria-indicator');
    indicators.forEach((indicator, index) => {
      indicator.classList.toggle('active', index === currentGaleriaSlide);
    });
  }
  
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !galeriaModal.classList.contains('hidden')) {
      closeGaleriaModalFunc();
    }
  });
});
</script>

<!-- Galería de Logros - Expandida -->
<section class="py-24 bg-gradient-to-b from-emerald-50 to-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-20" data-aos="fade-up">
      <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl mb-6">Logros y Reconocimientos</h2>
      <p class="text-xl text-gray-500 max-w-3xl mx-auto leading-relaxed">El esfuerzo colectivo de nuestra comunidad académica y deportiva reflejado en premios internacionales, patentes y contribuciones sociales que posicionan a UTSC como líder en 2025.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
      <div class="gallery-item bg-white/80 backdrop-blur-sm p-8 rounded-2xl text-center shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2" data-aos="fade-up">
        <div class="w-20 h-20 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
          <i data-feather="award" class="w-10 h-10 text-white"></i>
        </div>
        <h4 class="text-xl font-bold text-gray-900 mb-3">QS Stars 5 Estrellas 2025</h4>
        <p class="text-gray-600 text-base leading-relaxed">En innovación educativa y empleabilidad global, superando a 200 instituciones latinoamericanas.</p>
      </div>
      
      <div class="gallery-item bg-white/80 backdrop-blur-sm p-8 rounded-2xl text-center shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
        <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
          <i data-feather="shield" class="w-10 h-10 text-white"></i>
        </div>
        <h4 class="text-xl font-bold text-gray-900 mb-3">ISO 9001 & LEED Oro</h4>
        <p class="text-gray-600 text-base leading-relaxed">Certificaciones en calidad educativa y sostenibilidad ambiental, con reducción del 40% en emisiones de carbono.</p>
      </div>
      
      <div class="gallery-item bg-white/80 backdrop-blur-sm p-8 rounded-2xl text-center shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
        <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
          <i data-feather="trending-up" class="w-10 h-10 text-white"></i>
        </div>
        <h4 class="text-xl font-bold text-gray-900 mb-3">Top 3 Nacional en Empleabilidad</h4>
        <p class="text-gray-600 text-base leading-relaxed">98% de egresados empleados en 6 meses, con salarios promedio 25% superiores al mercado regional.</p>
      </div>
      
      <div class="gallery-item bg-white/80 backdrop-blur-sm p-8 rounded-2xl text-center shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
        <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl">
          <i data-feather="zap" class="w-10 h-10 text-white"></i>
        </div>
        <h4 class="text-xl font-bold text-gray-900 mb-3">65 Patentes Activas</h4>
        <p class="text-gray-600 text-base leading-relaxed">Registradas en áreas de IA aplicada y energías renovables, generando $2M en royalties para investigación.</p>
      </div>
    </div>
  </div>
</section>

<script>
AOS.init({ duration: 1000, easing: 'ease-out-cubic', once: true });
feather.replace();

// Botón modo oscuro
(function(){
  const toggle = document.getElementById("toggleDark");
  const body = document.body;

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
      feather.replace();
    });
  }
})();
</script>

<?php include 'footer.php'; ?>
</body>
</html>