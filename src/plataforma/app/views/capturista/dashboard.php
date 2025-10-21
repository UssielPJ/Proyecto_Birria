<?php
// The controller already loads the data, so we don't need to re-declare models or fetch data here.
// The variables $user, $todayStats, and $pendingActions are passed from the controller.
?>

<!-- Bienvenida -->
<div class="bg-gradient-to-r from-purple-600 via-violet-600 to-indigo-600 rounded-xl p-6 text-white mb-8 shadow-2xl relative overflow-hidden" data-aos="fade-up">
    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-pulse"></div>
    <div class="relative flex items-center gap-4">
        <div class="p-3 bg-white/20 rounded-full backdrop-blur-sm animate-bounce">
            <i data-feather="database" class="w-8 h-8"></i>
        </div>
        <div>
            <h2 class="text-2xl font-bold mb-1 animate-fade-in">¡Hola, <?= htmlspecialchars($user['name']) ?>!</h2>
            <p class="opacity-90 animate-fade-in animation-delay-200">Bienvenido al panel de captura de datos académicos.</p>
        </div>
    </div>
    <div class="absolute top-4 right-4 opacity-20">
        <i data-feather="cpu" class="w-16 h-16 animate-spin-slow"></i>
    </div>
</div>

<!-- Estadísticas -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Registros del Día -->
    <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl shadow-lg p-6 border border-purple-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-tooltip="Gestionar nuevos registros">
        <div class="absolute inset-0 bg-gradient-to-r from-purple-400/20 to-violet-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-purple-600 text-sm font-medium">Nuevos Registros</p>
                <h3 class="text-3xl font-bold mt-1 text-purple-800 counter" data-target="<?= $todayStats['new_registrations'] ?? 0 ?>">0</h3>
                <p class="text-purple-500 text-xs mt-1">Hoy</p>
            </div>
            <div class="p-4 rounded-xl bg-purple-100 shadow-inner group-hover:bg-purple-200 group-hover:rotate-12 transition-all duration-300">
                <i data-feather="user-plus" class="w-8 h-8 text-purple-600"></i>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-purple-400 to-violet-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
        <a href="/src/plataforma/capturista/alumnos/crear" class="text-purple-600 hover:text-purple-700 text-sm font-medium flex items-center mt-4 group-hover:translate-x-1 transition-transform">
            Nuevo registro
            <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
        </a>
    </div>

    <!-- Calificaciones Pendientes -->
    <div class="bg-gradient-to-br from-violet-50 to-indigo-50 rounded-xl shadow-lg p-6 border border-violet-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="100" data-tooltip="Procesar calificaciones pendientes">
        <div class="absolute inset-0 bg-gradient-to-r from-violet-400/20 to-indigo-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-violet-600 text-sm font-medium">Calificaciones Pendientes</p>
                <h3 class="text-3xl font-bold mt-1 text-violet-800 counter" data-target="<?= $todayStats['pending_grades'] ?? 0 ?>">0</h3>
                <p class="text-violet-500 text-xs mt-1">Por procesar</p>
            </div>
            <div class="p-4 rounded-xl bg-violet-100 shadow-inner group-hover:bg-violet-200 group-hover:rotate-12 transition-all duration-300">
                <i data-feather="clock" class="w-8 h-8 text-violet-600"></i>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-violet-400 to-indigo-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
        <a href="/src/plataforma/capturista/inscripciones" class="text-violet-600 hover:text-violet-700 text-sm font-medium flex items-center mt-4 group-hover:translate-x-1 transition-transform">
            Ver pendientes
            <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
        </a>
    </div>

    <!-- Total Estudiantes -->
    <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl shadow-lg p-6 border border-indigo-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="200" data-tooltip="Ver base de datos de estudiantes">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-400/20 to-blue-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-indigo-600 text-sm font-medium">Total Estudiantes</p>
                <h3 class="text-3xl font-bold mt-1 text-indigo-800 counter" data-target="<?= $todayStats['total_students'] ?? 0 ?>">0</h3>
                <p class="text-indigo-500 text-xs mt-1">Registrados</p>
            </div>
            <div class="p-4 rounded-xl bg-indigo-100 shadow-inner group-hover:bg-indigo-200 group-hover:rotate-12 transition-all duration-300">
                <i data-feather="users" class="w-8 h-8 text-indigo-600"></i>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-400 to-blue-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
        <a href="/src/plataforma/capturista/alumnos" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium flex items-center mt-4 group-hover:translate-x-1 transition-transform">
            Ver estudiantes
            <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
        </a>
    </div>

    <!-- Total Profesores -->
    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl shadow-lg p-6 border border-blue-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="300" data-tooltip="Ver reportes y estadísticas">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-cyan-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative flex items-center justify-between">
            <div>
                <p class="text-blue-600 text-sm font-medium">Total Profesores</p>
                <h3 class="text-3xl font-bold mt-1 text-blue-800 counter" data-target="<?= $todayStats['total_teachers'] ?? 0 ?>">0</h3>
                <p class="text-blue-500 text-xs mt-1">Activos</p>
            </div>
            <div class="p-4 rounded-xl bg-blue-100 shadow-inner group-hover:bg-blue-200 group-hover:rotate-12 transition-all duration-300">
                <i data-feather="user-check" class="w-8 h-8 text-blue-600"></i>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-cyan-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
        <a href="/src/plataforma/capturista/reportes" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center mt-4 group-hover:translate-x-1 transition-transform">
            Ver reportes
            <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
        </a>
    </div>
</div>

<!-- Contenido Principal -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Últimos Registros -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6" data-aos="fade-up">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Últimos Registros</h2>
            <a href="/src/plataforma/capturista/alumnos" class="text-purple-600 hover:text-purple-700 text-sm">Ver todos</a>
        </div>
        <div class="space-y-4">
            <?php if (!empty($recentRegistrations)): ?>
                <?php foreach ($recentRegistrations as $registration): ?>
                    <div class="flex items-center justify-between p-3 border border-gray-100 dark:border-neutral-700 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                                <i data-feather="user"></i>
                            </div>
                            <div>
                                <h3 class="font-medium"><?= htmlspecialchars($registration->name) ?></h3>
                                <p class="text-sm text-gray-500 dark:text-neutral-400"><?= htmlspecialchars($registration->email) ?></p>
                            </div>
                        </div>
                        <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded-full"><?= htmlspecialchars($registration->role) ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500 dark:text-neutral-400">No hay registros recientes.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Calificaciones Pendientes -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6" data-aos="fade-up">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Calificaciones Pendientes</h2>
            <a href="/src/plataforma/capturista/inscripciones" class="text-yellow-600 hover:text-yellow-700 text-sm">Ver todas</a>
        </div>
        <div class="space-y-4">
            <?php if (!empty($pendingGrades)): ?>
                <?php foreach ($pendingGrades as $grade): ?>
                    <div class="flex items-center justify-between p-3 border border-gray-100 dark:border-neutral-700 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-yellow-50">
                                <i data-feather="file-text"></i>
                            </div>
                            <div>
                                <h3 class="font-medium">Calificación de <?= htmlspecialchars($grade->student_name) ?></h3>
                                <p class="text-sm text-gray-500 dark:text-neutral-400"><?= htmlspecialchars($grade->course_name) ?></p>
                            </div>
                        </div>
                        <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-1 rounded-full">Pendiente</span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-500">No hay calificaciones pendientes.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
AOS.init();
feather.replace();

// Counter animation
function animateCounters() {
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000;
        const step = target / (duration / 16);
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

// Enhanced hover effects with purple glow
document.querySelectorAll('.grid > div').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-8px) scale(1.05)';
        this.style.boxShadow = '0 25px 50px rgba(0,0,0,0.15), 0 0 30px rgba(147, 51, 234, 0.4)';
    });
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
        this.style.boxShadow = '';
    });
});

// Typing animation for welcome text
const welcomeText = document.querySelector('h2');
if (welcomeText) {
    const text = welcomeText.textContent;
    welcomeText.textContent = '';
    let i = 0;
    const typeWriter = () => {
        if (i < text.length) {
            welcomeText.textContent += text.charAt(i);
            i++;
            setTimeout(typeWriter, 50);
        }
    };
    setTimeout(typeWriter, 500);
}

// Data entry focused particle effect
const createDataParticles = () => {
    const container = document.querySelector('.container') || document.body;
    for (let i = 0; i < 15; i++) {
        const particle = document.createElement('div');
        particle.style.position = 'absolute';
        particle.style.width = '3px';
        particle.style.height = '3px';
        particle.style.background = `hsl(${260 + Math.random() * 40}, 70%, 60%)`; // Purple hues
        particle.style.borderRadius = '50%';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        particle.style.animation = `dataFloat ${Math.random() * 8 + 4}s ease-in-out infinite`;
        particle.style.opacity = '0.15';
        particle.style.zIndex = '-1';
        container.appendChild(particle);
    }
};

// Add custom animations
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
    @keyframes dataFloat {
        0%, 100% { transform: translateY(0px) translateX(0px) rotate(0deg); }
        25% { transform: translateY(-15px) translateX(10px) rotate(90deg); }
        50% { transform: translateY(-5px) translateX(-5px) rotate(180deg); }
        75% { transform: translateY(-20px) translateX(5px) rotate(270deg); }
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

// Initialize on load
window.addEventListener('load', function() {
    animateCounters();
    initTooltips();
    setTimeout(createDataParticles, 1000);
});
</script>