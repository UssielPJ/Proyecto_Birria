<!-- Bienvenida -->
<div class="bg-gradient-to-r from-red-600 via-orange-500 to-yellow-500 rounded-xl p-6 text-white mb-8 shadow-2xl relative overflow-hidden" data-aos="fade-up">
    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-pulse"></div>
    <div class="relative flex items-center gap-4">
        <div class="p-3 bg-white/20 rounded-full backdrop-blur-sm animate-bounce">
            <i data-feather="shield" class="w-8 h-8"></i>
        </div>
        <div>
            <h2 class="text-2xl font-bold mb-1 animate-fade-in">Panel de Administración</h2>
            <p class="opacity-90 animate-fade-in animation-delay-200">Administra y supervisa todos los aspectos de la plataforma.</p>
        </div>
    </div>
    <div class="absolute top-4 right-4 opacity-20">
        <i data-feather="settings" class="w-16 h-16 animate-spin-slow"></i>
    </div>
</div>

<!-- Estadísticas Principales -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total de Estudiantes -->
    <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-xl shadow-lg p-6 border border-red-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-tooltip="Ver detalles de estudiantes">
        <div class="absolute inset-0 bg-gradient-to-r from-red-400/20 to-orange-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-red-600 text-sm font-medium">Total Estudiantes</p>
                <h3 class="text-3xl font-bold mt-1 text-red-800 counter" data-target="<?= $stats['total_students'] ?>">0</h3>
                <p class="text-red-500 text-xs mt-1">↗️ +12% este mes</p>
            </div>
            <div class="p-4 rounded-xl bg-red-100 shadow-inner group-hover:bg-red-200 group-hover:rotate-12 transition-all duration-300">
                <i data-feather="users" class="w-8 h-8 text-red-600"></i>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-red-400 to-orange-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
    </div>

    <!-- Total de Profesores -->
    <div class="bg-gradient-to-br from-orange-50 to-yellow-50 rounded-xl shadow-lg p-6 border border-orange-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="100" data-tooltip="Ver detalles de profesores">
        <div class="absolute inset-0 bg-gradient-to-r from-orange-400/20 to-yellow-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-orange-600 text-sm font-medium">Total Profesores</p>
                <h3 class="text-3xl font-bold mt-1 text-orange-800 counter" data-target="<?= $stats['total_teachers'] ?>">0</h3>
                <p class="text-orange-500 text-xs mt-1">↗️ +2% este mes</p>
            </div>
            <div class="p-4 rounded-xl bg-orange-100 shadow-inner group-hover:bg-orange-200 group-hover:rotate-12 transition-all duration-300">
                <i data-feather="user-check" class="w-8 h-8 text-orange-600"></i>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400 to-yellow-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
    </div>

    <!-- Total de Materias -->
    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl shadow-lg p-6 border border-yellow-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="200" data-tooltip="Ver detalles de materias">
        <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/20 to-amber-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-yellow-600 text-sm font-medium">Total Materias</p>
                <h3 class="text-3xl font-bold mt-1 text-yellow-800 counter" data-target="<?= $stats['total_subjects'] ?>">0</h3>
                <p class="text-yellow-500 text-xs mt-1">→ Sin cambios</p>
            </div>
            <div class="p-4 rounded-xl bg-yellow-100 shadow-inner group-hover:bg-yellow-200 group-hover:rotate-12 transition-all duration-300">
                <i data-feather="book-open" class="w-8 h-8 text-yellow-600"></i>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-400 to-amber-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
    </div>

    <!-- Cursos Activos -->
    <div class="bg-gradient-to-br from-amber-50 to-red-50 rounded-xl shadow-lg p-6 border border-amber-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="300" data-tooltip="Ver cursos activos">
        <div class="absolute inset-0 bg-gradient-to-r from-amber-400/20 to-red-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-amber-600 text-sm font-medium">Cursos Activos</p>
                <h3 class="text-3xl font-bold mt-1 text-amber-800 counter" data-target="<?= $stats['active_courses'] ?>">0</h3>
                <p class="text-amber-500 text-xs mt-1">↗️ +5% este mes</p>
            </div>
            <div class="p-4 rounded-xl bg-amber-100 shadow-inner group-hover:bg-amber-200 group-hover:rotate-12 transition-all duration-300">
                <i data-feather="activity" class="w-8 h-8 text-amber-600"></i>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-amber-400 to-red-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
    </div>
</div>

<section class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 mb-6" data-aos="fade-up">
  <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Acciones rápidas</h2>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <a href="#" class="flex flex-col items-center justify-center p-4 rounded-lg border border-neutral-100 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition">
      <div class="p-3 rounded-lg bg-primary-50 dark:bg-neutral-700 mb-2">
        <i data-feather="user-plus" class="text-primary-600"></i>
      </div>
      <span class="text-sm font-medium">Nuevo estudiante</span>
    </a>
    <a href="#" class="flex flex-col items-center justify-center p-4 rounded-lg border border-neutral-100 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition">
      <div class="p-3 rounded-lg bg-emerald-50 dark:bg-neutral-700 mb-2">
        <i data-feather="user-plus" class="text-emerald-600"></i>
      </div>
      <span class="text-sm font-medium">Nuevo profesor</span>
    </a>
    <a href="/src/plataforma/app/admin/subjects/create" class="flex flex-col items-center justify-center p-4 rounded-lg border border-neutral-100 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition">
      <div class="p-3 rounded-lg bg-amber-50 dark:bg-neutral-700 mb-2">
        <i data-feather="book-open" class="text-amber-600"></i>
      </div>
      <span class="text-sm font-medium">Nueva materia</span>
    </a>
    <a href="#" class="flex flex-col items-center justify-center p-4 rounded-lg border border-neutral-100 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition">
      <div class="p-3 rounded-lg bg-purple-50 dark:bg-neutral-700 mb-2">
        <i data-feather="bell" class="text-purple-600"></i>
      </div>
      <span class="text-sm font-medium">Nuevo anuncio</span>
    </a>
  </div>
</section>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
  <section class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6" data-aos="fade-up">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-bold text-gray-800 dark:text-white">Últimos estudiantes</h2>
      <a href="#" class="text-primary-700 dark:text-primary-300 text-sm">Ver todos</a>
    </div>

    <div class="space-y-4">
      <?php if (!empty($stats['recent_users'])): ?>
        <?php foreach ($stats['recent_users'] as $user): ?>
          <div class="flex items-center justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center">
                <i data-feather="user" class="text-primary-700 dark:text-primary-300"></i>
              </div>
              <div>
                <h3 class="font-medium"><?= htmlspecialchars($user->name) ?></h3>
                <p class="text-sm text-neutral-500 dark:text-neutral-400"><?= htmlspecialchars($user->role ?? 'Unknown') ?></p>
              </div>
            </div>
            <span class="text-xs bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 px-2 py-1 rounded-full">Nuevo</span>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p class="text-neutral-500 dark:text-neutral-400">No hay usuarios recientes.</p>
      <?php endif; ?>
    </div>
  </section>

  <section class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6" data-aos="fade-up">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-bold text-gray-800 dark:text-white">Pendientes administrativos</h2>
      <a href="#" class="text-primary-700 dark:text-primary-300 text-sm">Ver todos</a>
    </div>

    <div class="space-y-4">
      <div class="flex items-start justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
        <div class="flex items-start gap-3">
          <div class="p-2 rounded-lg bg-amber-50 dark:bg-neutral-700 mt-1">
            <i data-feather="alert-circle" class="text-amber-600"></i>
          </div>
          <div>
            <h3 class="font-medium">Documentos faltantes</h3>
            <p class="text-sm text-neutral-500 dark:text-neutral-400"><?= $stats['incomplete_documents'] ?> estudiantes con documentos incompletos</p>
          </div>
        </div>
        <a href="#" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700">
          <i data-feather="chevron-right" class="text-neutral-400"></i>
        </a>
      </div>

      <div class="flex items-start justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
        <div class="flex items-start gap-3">
          <div class="p-2 rounded-lg bg-primary-50 dark:bg-neutral-700 mt-1">
            <i data-feather="dollar-sign" class="text-primary-600"></i>
          </div>
          <div>
            <h3 class="font-medium">Pagos pendientes</h3>
            <p class="text-sm text-neutral-500 dark:text-neutral-400"><?= $stats['pending_payments'] ?> pagos pendientes de confirmación</p>
          </div>
        </div>
        <a href="#" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700">
          <i data-feather="chevron-right" class="text-neutral-400"></i>
        </a>
      </div>

      <div class="flex items-start justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
        <div class="flex items-start gap-3">
          <div class="p-2 rounded-lg bg-rose-50 dark:bg-neutral-700 mt-1">
            <i data-feather="alert-triangle" class="text-rose-600"></i>
          </div>
          <div>
            <h3 class="font-medium">Solicitudes pendientes</h3>
            <p class="text-sm text-neutral-500 dark:text-neutral-400"><?= $metrics['pending_solicitudes'] ?? 0 ?>solicitudes requieren atención</p>
          </div>
        </div>
        <a href="#" class="p-2 rounded-full hover:bg-neutral-100 dark:hover:bg-neutral-700">
          <i data-feather="chevron-right" class="text-neutral-400"></i>
        </a>
      </div>
    </div>
  </section>
</div>

<!-- Materias Recientes -->
<section class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6" data-aos="fade-up">
 <div class="flex items-center justify-between mb-4">
   <h2 class="text-xl font-bold">Materias recientes</h2>
   <a href="/src/plataforma/app/admin/subjects" class="text-primary-700 dark:text-primary-300 text-sm">Ver todas</a>
 </div>

 <div class="space-y-4">
   <?php if (!empty($stats['recent_subjects'])): ?>
     <?php foreach ($stats['recent_subjects'] as $subject): ?>
       <div class="flex items-center justify-between p-3 border border-neutral-100 dark:border-neutral-700 rounded-lg">
         <div class="flex items-center gap-3">
           <div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900 flex items-center justify-center">
             <i data-feather="book" class="text-amber-600 dark:text-amber-400"></i>
           </div>
           <div>
             <h3 class="font-medium"><?= htmlspecialchars($subject->name) ?></h3>
             <p class="text-sm text-neutral-500 dark:text-neutral-400"><?= htmlspecialchars($subject->code ?? '') ?> · <?= $subject->creditos ?? 0 ?> créditos</p>
           </div>
         </div>
         <span class="text-xs bg-amber-100 dark:bg-amber-900 text-amber-700 dark:text-amber-300 px-2 py-1 rounded-full">Nueva</span>
       </div>
     <?php endforeach; ?>
   <?php else: ?>
     <p class="text-neutral-500 dark:text-neutral-400">No hay materias recientes.</p>
   <?php endif; ?>
 </div>
</section>

<script>
AOS.init();
feather.replace();

// Counter animation
function animateCounters() {
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const step = target / (duration / 16); // 60fps
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                counter.textContent = target;
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current);
            }
        }, 16);
    });
}

// Tooltip functionality
function initTooltips() {
    const cards = document.querySelectorAll('[data-tooltip]');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function(e) {
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute bg-gray-800 text-white text-xs px-2 py-1 rounded shadow-lg z-50 pointer-events-none';
            tooltip.textContent = this.getAttribute('data-tooltip');
            tooltip.style.top = e.clientY - 30 + 'px';
            tooltip.style.left = e.clientX + 10 + 'px';
            document.body.appendChild(tooltip);

            this.addEventListener('mousemove', function(e) {
                tooltip.style.top = e.clientY - 30 + 'px';
                tooltip.style.left = e.clientX + 10 + 'px';
            });

            this.addEventListener('mouseleave', function() {
                tooltip.remove();
            });
        });
    });
}

// Enhanced hover effects
document.querySelectorAll('.grid > div').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-8px) scale(1.05)';
        this.style.boxShadow = '0 25px 50px rgba(0,0,0,0.15), 0 0 30px rgba(239, 68, 68, 0.3)';
    });
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
        this.style.boxShadow = '';
    });
});

// Quick actions hover effects
document.querySelectorAll('.grid.grid-cols-2 a').forEach(action => {
    action.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
        this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
    });
    action.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = '';
    });
});

// Initialize animations on load
window.addEventListener('load', function() {
    animateCounters();
    initTooltips();
});

// Add custom CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-fade-in {
        animation: fade-in 0.8s ease-out forwards;
    }
    .animation-delay-200 {
        animation-delay: 0.2s;
    }
    .animate-spin-slow {
        animation: spin-slow 3s linear infinite;
    }
`;
document.head.appendChild(style);
</script>
