<aside class="w-64 shrink-0 p-4 space-y-1 bg-white">
  <div class="flex items-center mb-4">
    <img src="/src/plataforma/app/img/UT.jpg" alt="UTSC Logo" class="h-10 mr-3 rounded">
    <span class="text-xl font-bold">UTSC</span>
  </div>
  <!-- User Info -->
  <div class="flex items-center mb-6">
    <div class="w-12 h-12 rounded-full bg-green-200 flex items-center justify-center mr-3">
      <i class="fas fa-user text-2xl text-green-600"></i>
    </div>
    <div>
      <p class="font-bold">Administrador</p>
      <p class="text-sm text-gray-500">admin@UTSC.edu</p>
    </div>
  </div>

  <nav>
    <a class="menu-item active" href="/src/plataforma/app">
      <i class="fas fa-home mr-3"></i> Panel
    </a>
    <a class="menu-item" href="/src/plataforma/app/admin/students">
      <i class="fas fa-user-graduate mr-3"></i> Estudiantes
    </a>
    <a class="menu-item" href="/src/plataforma/app/admin/teachers">
      <i class="fas fa-chalkboard-teacher mr-3"></i> Profesores
    </a>
    <a class="menu-item" href="/src/plataforma/app/admin/subjects">
      <i class="fas fa-book mr-3"></i> Materias
    </a>
    <a class="menu-item" href="/src/plataforma/app/admin/schedule">
      <i class="fas fa-calendar-alt mr-3"></i> Horarios
    </a>
    <a class="menu-item" href="/src/plataforma/app/grades">
      <i class="fas fa-medal mr-3"></i> Calificaciones
    </a>
    <a class="menu-item" href="/src/plataforma/app/payments">
      <i class="fas fa-dollar-sign mr-3"></i> Pagos
    </a>
    <a class="menu-item" href="/src/plataforma/app/settings">
      <i class="fas fa-cog mr-3"></i> Configuración
    </a>
    <a class="menu-item" href="/src/plataforma/app/announcements">
      <i class="fas fa-bell mr-3"></i> Anuncios
    </a>
  </nav>
</aside>
<style>
  .menu-item {
    display: flex;
    align-items: center;
    padding: .8rem .8rem;
    border-radius: .6rem;
    font-weight: 500;
    color: #4a5568;
    transition: background-color 0.2s, color 0.2s;
  }

  .menu-item:hover {
    background-color: #edf2f7;
    color: #2d3748;
  }

  .menu-item.active {
    background-color: #e6f4ea;
    color: #38a169;
  }

  .dark .menu-item {
    color: #a0aec0;
  }

  .dark .menu-item:hover {
    background-color: rgba(255, 255, 255, .06);
    color: #f7fafc;
  }

  .dark .menu-item.active {
    background-color: rgba(56, 161, 105, 0.2);
    color: #68d391;
  }
</style>
