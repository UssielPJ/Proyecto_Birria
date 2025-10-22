<!-- Footer -->
<footer class="bg-gray-900 dark:bg-neutral-900 text-white pt-16 pb-8 relative overflow-hidden">
  <div class="absolute inset-0 opacity-5">
    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-[var(--ut-green-900)/0.1] to-transparent"></div>
  </div>
  <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
      <div class="space-y-4">
        <div class="flex items-center gap-3">
          <img src="/src/plataforma/app/img/UT.jpg" alt="UTSC Logo" class="h-10 w-10 rounded-lg object-cover ring-2 ring-white/20">
          <div>
            <h3 class="text-lg font-bold">UTSC</h3>
            <p class="text-xs text-gray-400">Universidad Tecnológica Santa Catarina</p>
          </div>
        </div>
        <p class="text-gray-400 text-sm leading-relaxed">UTSC, comprometida con la excelencia académica y la innovación en 2025.</p>
        <div class="flex space-x-4 pt-2">
          <a href="https://www.facebook.com/UTSCNL/" class="social-link text-gray-400 hover:text-white transition-all duration-300 hover:scale-110" aria-label="Facebook de UTSC" target="_blank"><i data-feather="facebook" class="w-5 h-5"></i></a>
          <a href="https://twitter.com/UTSantaCatarina" class="social-link text-gray-400 hover:text-white transition-all duration-300 hover:scale-110" aria-label="Twitter de UTSC" target="_blank"><i data-feather="twitter" class="w-5 h-5"></i></a>
          <a href="https://www.linkedin.com/company/utsc/" class="social-link text-gray-400 hover:text-white transition-all duration-300 hover:scale-110" aria-label="LinkedIn de UTSC" target="_blank"><i data-feather="linkedin" class="w-5 h-5"></i></a>
          <a href="https://www.youtube.com/user/UTSantaCatarina" class="social-link text-gray-400 hover:text-white transition-all duration-300 hover:scale-110" aria-label="YouTube de UTSC" target="_blank"><i data-feather="youtube" class="w-5 h-5"></i></a>
          <a href="https://www.instagram.com/utsantacatarina/" class="social-link text-gray-400 hover:text-white transition-all duration-300 hover:scale-110" aria-label="Instagram de UTSC" target="_blank"><i data-feather="instagram" class="w-5 h-5"></i></a>
        </div>
      </div>
      <div>
        <h3 class="text-lg font-semibold mb-4">Carreras</h3>
        <ul class="space-y-2">
          <li><a href="/src/carreras.php#tecnologia" class="text-gray-400 hover:text-white transition-colors duration-200 block py-1">Tecnologías de la Información</a></li>
          <li><a href="/src/carreras.php#ingenieria" class="text-gray-400 hover:text-white transition-colors duration-200 block py-1">Mecatrónica</a></li>
          <li><a href="/src/carreras.php#ingenieria" class="text-gray-400 hover:text-white transition-colors duration-200 block py-1">Ingeniería Industrial</a></li>
          <li><a href="/src/carreras.php#ingenieria" class="text-gray-400 hover:text-white transition-colors duration-200 block py-1">Electromovilidad</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-lg font-semibold mb-4">Enlaces Rápidos</h3>
        <ul class="space-y-2">
          <li><a href="/src/registro.php" class="text-gray-400 hover:text-white transition-colors duration-200 block py-1">Inscripción</a></li>
          <li><a href="/src/plataforma/app/views/auth/login.php" class="text-gray-400 hover:text-white transition-colors duration-200 block py-1">Plataforma Estudiantil</a></li>
          <li><a href="/src/nosotros.php" class="text-gray-400 hover:text-white transition-colors duration-200 block py-1">Nosotros</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-lg font-semibold mb-4">Contacto</h3>
        <ul class="space-y-3">
          <li class="flex items-center text-gray-400 hover:text-white transition-colors duration-200">
            <i data-feather="mail" class="w-4 h-4 mr-2"></i>
            <a href="mailto:contacto@utsc.edu.mx">contacto@utsc.edu.mx</a>
          </li>
          <li class="flex items-center text-gray-400 hover:text-white transition-colors duration-200">
            <i data-feather="phone" class="w-4 h-4 mr-2"></i>
            <a href="tel:+528181248400">+52 81 8124 8400</a>
          </li>
          <li class="flex items-center text-gray-400 hover:text-white transition-colors duration-200">
            <i data-feather="map-pin" class="w-4 h-4 mr-2"></i>
            Carretera Saltillo-Monterrey Km. 61.5 C.P. 66359, Santa Catarina, N.L., México
          </li>
        </ul>
      </div>
    </div>
    <div class="border-t border-gray-800 dark:border-neutral-700 pt-6">
      <p class="text-center text-gray-500 text-sm">© 2025 UTSC. Todos los derechos reservados. | <a href="/src/privacidad.php" class="hover:text-white transition-colors duration-200">Política de Privacidad</a> | <a href="/src/terminos.php" class="hover:text-white transition-colors duration-200">Términos de Uso</a></p>
    </div>
  </div>
</footer>

<style>
footer {
  background: linear-gradient(to bottom, #111827, #0f172a);
}
.social-link {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.social-link:hover {
  transform: translateY(-2px);
}
.dark footer {
  background: linear-gradient(to bottom, #0f172a, #1e293b);
}
.dark .bg-gray-800 {
  background-color: #1f2937 !important;
}
</style>

<script>
feather.replace();
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('newsletterForm');
  if (form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      alert('¡Gracias por suscribirte! Te enviaremos actualizaciones pronto.');
      form.reset();
    });
  }
  document.addEventListener('themechange', () => {
    feather.replace();
  });
});
</script>