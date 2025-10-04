<?php
// The controller already loads the data, so we don't need to re-declare models or fetch data here.
// The variables $user, $teacherCourses, $totalStudents, $pendingGrades, $recentGradeUpdates, $weekSchedule, $nextClass are passed from the controller.

?>
<div class="container px-6 py-8">
    <!-- Bienvenida -->
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-xl p-6 text-white mb-8 shadow-2xl relative overflow-hidden" data-aos="fade-up">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-pulse"></div>
        <div class="relative flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full backdrop-blur-sm animate-bounce">
                <i data-feather="book-open" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1 animate-fade-in">¡Bienvenido, <?= htmlspecialchars($user['name']) ?>!</h2>
                <p class="opacity-90 animate-fade-in animation-delay-200">Administra tus clases, estudiantes y calificaciones desde aquí.</p>
            </div>
        </div>
        <div class="absolute top-4 right-4 opacity-20">
            <i data-feather="users" class="w-16 h-16 animate-spin-slow"></i>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Cursos Activos -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-lg p-6 border border-blue-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-tooltip="Gestionar tus cursos activos">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-indigo-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-sm font-medium">Cursos Activos</p>
                    <h3 class="text-3xl font-bold mt-1 text-blue-800 counter" data-target="<?= count($teacherCourses) ?>">0</h3>
                    <p class="text-blue-500 text-xs mt-1">Este semestre</p>
                </div>
                <div class="p-4 rounded-xl bg-blue-100 shadow-inner group-hover:bg-blue-200 group-hover:rotate-12 transition-all duration-300">
                    <i data-feather="book" class="w-8 h-8 text-blue-600"></i>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-indigo-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            <a href="/courses" class="text-blue-600 hover:text-blue-700 text-sm font-medium flex items-center mt-4 group-hover:translate-x-1 transition-transform">
                Ver mis cursos
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Total Estudiantes -->
        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl shadow-lg p-6 border border-indigo-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="100" data-tooltip="Ver todos tus estudiantes">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-400/20 to-purple-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-indigo-600 text-sm font-medium">Total Estudiantes</p>
                    <h3 class="text-3xl font-bold mt-1 text-indigo-800 counter" data-target="<?= $totalStudents ?>">0</h3>
                    <p class="text-indigo-500 text-xs mt-1">En mis cursos</p>
                </div>
                <div class="p-4 rounded-xl bg-indigo-100 shadow-inner group-hover:bg-indigo-200 group-hover:rotate-12 transition-all duration-300">
                    <i data-feather="users" class="w-8 h-8 text-indigo-600"></i>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-400 to-purple-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            <a href="/students" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium flex items-center mt-4 group-hover:translate-x-1 transition-transform">
                Ver estudiantes
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Calificaciones Pendientes -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl shadow-lg p-6 border border-purple-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="200" data-tooltip="Calificaciones que requieren tu atención">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-400/20 to-pink-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-purple-600 text-sm font-medium">Calificaciones Pendientes</p>
                    <h3 class="text-3xl font-bold mt-1 text-purple-800 counter" data-target="<?= count($pendingGrades) ?>">0</h3>
                    <p class="text-purple-500 text-xs mt-1">Requieren atención</p>
                </div>
                <div class="p-4 rounded-xl bg-purple-100 shadow-inner group-hover:bg-purple-200 group-hover:rotate-12 transition-all duration-300">
                    <i data-feather="clock" class="w-8 h-8 text-purple-600"></i>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-purple-400 to-pink-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            <a href="/grades/pending" class="text-purple-600 hover:text-purple-700 text-sm font-medium flex items-center mt-4 group-hover:translate-x-1 transition-transform">
                Calificar pendientes
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Progreso del Semestre -->
        <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-xl shadow-lg p-6 border border-pink-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="300" data-tooltip="Avance del semestre académico">
            <div class="absolute inset-0 bg-gradient-to-r from-pink-400/20 to-rose-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between">
                <div>
                    <p class="text-pink-600 text-sm font-medium">Progreso Semestre</p>
                    <h3 class="text-3xl font-bold mt-1 text-pink-800 counter" data-target="<?= $semesterProgress ?>">0</h3>
                    <p class="text-pink-500 text-xs mt-1">Completado</p>
                </div>
                <div class="p-4 rounded-xl bg-pink-100 shadow-inner group-hover:bg-pink-200 group-hover:rotate-12 transition-all duration-300">
                    <i data-feather="calendar" class="w-8 h-8 text-pink-600"></i>
                </div>
            </div>
            <div class="mt-4 bg-pink-200 rounded-full h-3 overflow-hidden">
                <div class="bg-gradient-to-r from-pink-400 to-rose-500 h-3 rounded-full transition-all duration-1000 ease-out counter-bar" data-width="<?= $semesterProgress ?>%"></div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-pink-400 to-rose-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
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
                if (counter.nextElementSibling && counter.nextElementSibling.textContent.includes('Completado')) {
                    counter.textContent = target + '%';
                } else {
                    counter.textContent = target;
                }
                clearInterval(timer);
            } else {
                if (counter.nextElementSibling && counter.nextElementSibling.textContent.includes('Completado')) {
                    counter.textContent = Math.floor(current) + '%';
                } else {
                    counter.textContent = Math.floor(current);
                }
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

// Enhanced hover effects with blue glow
document.querySelectorAll('.grid > div').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-8px) scale(1.05)';
        this.style.boxShadow = '0 25px 50px rgba(0,0,0,0.15), 0 0 30px rgba(59, 130, 246, 0.4)';
    });
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
        this.style.boxShadow = '';
    });

    // Ripple effect on click
    card.addEventListener('click', function(e) {
        const ripple = document.createElement('div');
        ripple.style.position = 'absolute';
        ripple.style.borderRadius = '50%';
        ripple.style.background = 'rgba(255,255,255,0.6)';
        ripple.style.transform = 'scale(0)';
        ripple.style.animation = 'ripple 0.6s linear';
        ripple.style.left = (e.offsetX - 10) + 'px';
        ripple.style.top = (e.offsetY - 10) + 'px';
        ripple.style.width = '20px';
        ripple.style.height = '20px';

        this.style.position = 'relative';
        this.appendChild(ripple);

        setTimeout(() => ripple.remove(), 600);
    });
});

// Animate progress bars
document.querySelectorAll('.counter-bar').forEach(bar => {
    const width = bar.getAttribute('data-width');
    bar.style.width = '0%';
    setTimeout(() => {
        bar.style.transition = 'width 1.5s ease-out';
        bar.style.width = width;
    }, 500);
});

// Pulse animation for pending items
document.querySelectorAll('h3').forEach(el => {
    if (el.textContent.trim() === '0') {
        el.style.animation = 'pulse 2s infinite';
    }
});

// Teaching-focused particle effect
const createTeachingParticles = () => {
    const container = document.querySelector('.container') || document.body;
    for (let i = 0; i < 10; i++) {
        const particle = document.createElement('div');
        particle.style.position = 'absolute';
        particle.style.width = '3px';
        particle.style.height = '3px';
        particle.style.background = `hsl(${220 + Math.random() * 60}, 70%, 60%)`; // Blue/indigo hues
        particle.style.borderRadius = '50%';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        particle.style.animation = `teachingFloat ${Math.random() * 5 + 3}s ease-in-out infinite`;
        particle.style.opacity = '0.2';
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
    @keyframes ripple {
        to { transform: scale(4); opacity: 0; }
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }
    @keyframes teachingFloat {
        0%, 100% { transform: translateY(0px) translateX(0px) rotate(0deg); }
        25% { transform: translateY(-10px) translateX(5px) rotate(90deg); }
        50% { transform: translateY(-5px) translateX(-8px) rotate(180deg); }
        75% { transform: translateY(-15px) translateX(3px) rotate(270deg); }
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
    setTimeout(createTeachingParticles, 1000);
});
</script>

    <!-- Contenido Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Mis Cursos Activos -->
        <div class="bg-white rounded-xl shadow-sm p-6" data-aos="fade-up">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Mis Cursos Activos</h3>
                <a href="/src/plataforma/app/courses" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Ver todos
                </a>
            </div>
            <div class="space-y-3">
                <?php if (!empty($teacherCourses)): ?>
                    <?php foreach ($teacherCourses as $course): ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <h4 class="font-medium text-gray-800"><?= htmlspecialchars($course->name) ?></h4>
                                <p class="text-sm text-gray-500"><?= $course->student_count ?> estudiantes</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                    Activo
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-8 text-gray-500">
                        <i data-feather="book" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                        <p>No tienes cursos asignados</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Calificaciones Recientes -->
        <div class="bg-white rounded-xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Calificaciones Recientes</h3>
                <a href="/src/plataforma/app/grades" class="text-green-600 hover:text-green-700 text-sm font-medium">
                    Ver todas
                </a>
            </div>
            <div class="space-y-3">
                <?php if (!empty($recentGradeUpdates)): ?>
                    <?php foreach ($recentGradeUpdates as $grade): ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <h4 class="font-medium text-gray-800"><?= htmlspecialchars($grade->student_name) ?></h4>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($grade->course_name) ?></p>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-bold <?= $grade->grade >= 7 ? 'text-green-600' : 'text-red-600' ?>">
                                    <?= number_format($grade->grade, 1) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-8 text-gray-500">
                        <i data-feather="award" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                        <p>No hay calificaciones recientes</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
