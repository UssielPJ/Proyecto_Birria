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
body {
  font-family: sans-serif;
  background-color: #f9fafb;
  color: #111827;
  scroll-behavior: smooth;
}
body.dark {
  background-color: #111827;
  color: #f3f4f6;
}
.container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
.header-nosotros { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; }
.header-nosotros img { width: 120px; border-radius: 0.5rem; object-fit: cover; }
.header-nosotros h2 { font-size: 2.5rem; font-weight: 800; color: var(--ut-green-900); }

.card-section { margin-bottom: 4rem; }
.card-section h3 { font-size: 1.75rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--ut-green-800); }

.card-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; }
.card {
  background-color: #ffffff;
  border-radius: 0.75rem;
  overflow: hidden;
  box-shadow: 0 6px 18px -6px rgba(0,0,0,0.15);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 24px -4px rgba(0,0,0,0.2);
}
.card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}
.card p {
  padding: 1rem;
  font-size: 1rem;
  color: #4b5563;
}
</style>
</head>
<body class="font-sans antialiased text-gray-800">

<?php include 'navbar.php'; ?>

<div class="container">

  <!-- Encabezado -->
  <br>
</br>

  <!-- Sobre la Universidad -->
  <div class="card-section" data-aos="fade-up">
    <h3>Sobre la Universidad</h3>
    <div class="card-grid">
      <div class="card"><img src="./plataforma/app/img/PlantelUT.jpg" alt="Campus 1"><p>Instalaciones modernas y equipadas para el aprendizaje.</p></div>
      <div class="card"><img src="./plataforma/app/img/CorrecaminosUT.jpg" alt="Campus 2"><p>Laboratorios y aulas interactivas para estudiantes.</p></div>
      <div class="card"><img src="./plataforma/app/img/Mecatronica.jpg" alt="Campus 3"><p>Ambiente estudiantil seguro y amigable.</p></div>
    </div>
  </div>

  <!-- Ferias Educativas -->
  <div class="card-section" data-aos="fade-up">
    <h3>Ferias Educativas</h3>
    <div class="card-grid">
      <div class="card"><img src="./plataforma/app/img/IndustrialM.jpg" alt="Feria 1"><p>Participación en ferias locales con proyectos innovadores.</p></div>
      <div class="card"><img src="./plataforma/app/img/Mecatronica.jpg" alt="Feria 2"><p>Exposición de trabajos de nuestros alumnos y docentes.</p></div>
      <div class="card"><img src="./plataforma/app/img/Negocios.jpg" alt="Feria 3"><p>Eventos educativos que fomentan la integración y el aprendizaje.</p></div>
    </div>
  </div>

  <!-- Alumnado -->
  <div class="card-section" data-aos="fade-up">
    <h3>Alumnado</h3>
    <div class="card-grid">
      <div class="card"><img src="/static/alumno1.jpg" alt="Alumno 1"><p>Estudiantes destacados en innovación y tecnología.</p></div>
      <div class="card"><img src="/static/alumno2.jpg" alt="Alumno 2"><p>Participación activa en proyectos comunitarios.</p></div>
      <div class="card"><img src="/static/alumno3.jpg" alt="Alumno 3"><p>Alumnos comprometidos con su formación profesional.</p></div>
    </div>
  </div>

</div>

<script>
AOS.init({ duration: 1000, once: true });
feather.replace();
</script>

<?php include 'footer.php'; ?>
</body>
</html>
<?php 