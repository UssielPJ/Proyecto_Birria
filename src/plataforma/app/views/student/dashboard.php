<?php
// Variables esperadas desde el controlador:
// $user, $currentCourses, $recentGrades, $averageGrade, $semesterProgress, $scheduleModel
// (Opcional) $weekSchedule si lo sigues pasando, pero ya no es necesario para la próxima clase.

use App\Models\Schedule;

// Asegura el modelo por si no te lo pasaron
if (!isset($scheduleModel) || !($scheduleModel instanceof Schedule)) {
    $scheduleModel = new Schedule();
}

// ID del estudiante
$studentId = is_array($user) ? (int)($user['id'] ?? 0) : (int)($user->id ?? 0);

// Próxima clase (null si no hay)
$nextClass = $studentId > 0 ? $scheduleModel->getNextClass($studentId) : null;

// Helper para día
$DAY_LABELS = [1=>'Lun',2=>'Mar',3=>'Mie',4=>'Jue',5=>'Vie',6=>'Sab',7=>'Dom'];

// Sanitizar nombre
$studentName = htmlspecialchars(is_array($user) ? ($user['name'] ?? ($user['nombre'] ?? 'Estudiante')) : ($user->name ?? ($user->nombre ?? 'Estudiante')));
$avg = is_numeric($averageGrade ?? null) ? (float)$averageGrade : 0.0;
$progress = (int)($semesterProgress ?? 0);
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Bienvenida -->
    <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 rounded-xl p-8 text-white mb-8 shadow-2xl relative overflow-hidden" data-aos="fade-up">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-pulse"></div>
        <div class="relative flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="p-4 bg-white/20 rounded-full backdrop-blur-sm animate-bounce">
                    <i data-feather="book-open" class="w-10 h-10"></i>
                </div>
                <div>
                    <h2 class="text-3xl font-bold mb-2 animate-fade-in">¡Bienvenido, <?= $studentName ?>!</h2>
                    <p class="opacity-90 animate-fade-in animation-delay-200 text-lg">Accede a tus cursos, calificaciones y recursos desde aquí.</p>
                </div>
            </div>
            <div class="absolute top-4 right-4 opacity-20">
                <i data-feather="graduation-cap" class="w-20 h-20 animate-spin-slow"></i>
            </div>
        </div>
    </div>

    <!-- Estadísticas y Accesos Rápidos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Mis Cursos Activos -->
        <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-emerald-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-tooltip="Acceder a tus cursos activos">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-400/20 to-teal-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between mb-4">
                <div>
                    <p class="text-emerald-600 dark:text-emerald-300 text-sm font-medium">Cursos Activos</p>
                    <h3 class="text-3xl font-bold mt-1 text-emerald-800 dark:text-emerald-100 counter" data-target="<?= count($currentCourses ?? []) ?>">0</h3>
                    <p class="text-emerald-500 dark:text-emerald-300 text-xs mt-1">Este semestre</p>
                </div>
                <div class="p-4 rounded-xl bg-emerald-100 dark:bg-neutral-700 shadow-inner group-hover:bg-emerald-200 group-hover:rotate-12 transition-all duration-300">
                    <i data-feather="book" class="w-8 h-8 text-emerald-600"></i>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            <a href="/src/plataforma/app/materias" class="text-emerald-600 dark:text-emerald-300 hover:text-emerald-700 text-sm font-medium flex items-center mt-4 group-hover:translate-x-1 transition-transform">
                Ver mis cursos
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Promedio General -->
        <div class="bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-teal-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="100" data-tooltip="Ver tu rendimiento académico">
            <div class="absolute inset-0 bg-gradient-to-r from-teal-400/20 to-cyan-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between mb-4">
                <div>
                    <p class="text-teal-600 dark:text-teal-300 text-sm font-medium">Promedio General</p>
                    <h3 class="text-3xl font-bold mt-1 text-teal-800 dark:text-teal-100 counter" data-target="<?= number_format($avg, 1) ?>">0</h3>
                    <p class="text-teal-500 dark:text-teal-300 text-xs mt-1">Calificación promedio</p>
                </div>
                <div class="p-4 rounded-xl bg-teal-100 dark:bg-neutral-700 shadow-inner group-hover:bg-teal-200 group-hover:rotate-12 transition-all duration-300">
                    <i data-feather="award" class="w-8 h-8 text-teal-600"></i>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-teal-400 to-cyan-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            <a href="/src/plataforma/app/calificaciones" class="text-teal-600 dark:text-teal-300 hover:text-teal-700 text-sm font-medium flex items-center mt-4 group-hover:translate-x-1 transition-transform">
                Ver calificaciones
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>

        <!-- Progreso del Semestre -->
        <div class="bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-cyan-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="200" data-tooltip="Seguimiento de progreso">
            <div class="absolute inset-0 bg-gradient-to-r from-cyan-400/20 to-blue-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between mb-4">
                <div>
                    <p class="text-cyan-600 dark:text-cyan-300 text-sm font-medium">Progreso Semestre</p>
                    <h3 class="text-3xl font-bold mt-1 text-cyan-800 dark:text-cyan-100 counter" data-target="<?= $progress ?>">0</h3>
                    <p class="text-cyan-500 dark:text-cyan-300 text-xs mt-1">Completado</p>
                </div>
                <div class="p-4 rounded-xl bg-cyan-100 dark:bg-neutral-700 shadow-inner group-hover:bg-cyan-200 group-hover:rotate-12 transition-all duration-300">
                    <i data-feather="clock" class="w-8 h-8 text-cyan-600"></i>
                </div>
            </div>
            <div class="mt-4 mb-2 bg-cyan-200 dark:bg-neutral-700 rounded-full h-3 overflow-hidden">
                <div class="bg-gradient-to-r from-cyan-400 to-blue-500 h-3 rounded-full transition-all duration-1000 ease-out counter-bar" data-width="<?= $progress ?>%"></div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-cyan-400 to-blue-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
        </div>

        <!-- Próxima Clase -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-neutral-800 dark:to-neutral-800 rounded-xl shadow-lg p-6 border border-blue-200 hover:shadow-2xl hover:scale-105 transition-all duration-500 cursor-pointer group relative overflow-hidden" data-aos="fade-up" data-aos-delay="300" data-tooltip="Ver tu horario de clases">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-indigo-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center justify-between mb-4">
                <div>
                    <p class="text-blue-600 dark:text-blue-300 text-sm font-medium">Próxima Clase</p>
                    <?php if (!empty($nextClass)): 
                        $dow = (int)($nextClass['dia_semana'] ?? 0);
                        $label = $DAY_LABELS[$dow] ?? '';
                        $materia = htmlspecialchars($nextClass['materia_nombre'] ?? 'Clase');
                        $horaIni = htmlspecialchars(substr((string)($nextClass['hora_inicio'] ?? ''),0,5));
                        $horaFin = htmlspecialchars(substr((string)($nextClass['hora_fin'] ?? ''),0,5));
                        $prof = htmlspecialchars($nextClass['teacher_nombre'] ?? '—');
                        $aula = htmlspecialchars($nextClass['aula'] ?? '—');
                    ?>
                        <h3 class="text-xl font-bold mt-1 text-blue-800 dark:text-blue-100"><?= $materia ?></h3>
                        <p class="text-sm text-blue-600 dark:text-blue-300">
                            <?= $label ?> · <?= $horaIni ?>–<?= $horaFin ?> · Aula <?= $aula ?> · Prof. <?= $prof ?>
                        </p>
                    <?php else: ?>
                        <h3 class="text-lg font-bold mt-1 text-blue-800 dark:text-blue-100">Sin clases próximas</h3>
                        <p class="text-sm text-blue-500 dark:text-blue-300">Revisa tu horario</p>
                    <?php endif; ?>
                </div>
                <div class="p-4 rounded-xl bg-blue-100 dark:bg-neutral-700 shadow-inner group-hover:bg-blue-200 group-hover:rotate-12 transition-all duration-300">
                    <i data-feather="calendar" class="w-8 h-8 text-blue-600"></i>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-indigo-400 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            <a href="/src/plataforma/app/horario" class="text-blue-600 dark:text-blue-300 hover:text-blue-700 text-sm font-medium flex items-center mt-4 group-hover:translate-x-1 transition-transform">
                Ver horario
                <i data-feather="chevron-right" class="w-4 h-4 ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Mis Cursos Actuales -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300" data-aos="fade-up">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center">
                    <i data-feather="book-open" class="w-5 h-5 mr-2 text-emerald-600"></i>
                    Mis Cursos Actuales
                </h3>
                <a href="/src/plataforma/app/materias" class="text-emerald-600 dark:text-emerald-300 hover:text-emerald-700 text-sm font-medium flex items-center group">
                    Ver todos
                    <i data-feather="arrow-right" class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            <div class="space-y-4">
                <?php if (!empty($currentCourses)): ?>
                    <?php foreach ($currentCourses as $course): ?>
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-neutral-800 dark:to-neutral-800 rounded-lg hover:from-emerald-50 hover:to-teal-50 transition-all duration-300 group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-neutral-700 flex items-center justify-center mr-3 group-hover:bg-emerald-200 transition-colors">
                                    <i data-feather="book" class="w-5 h-5 text-emerald-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">
                                        <?= htmlspecialchars($course->name ?? $course->nombre ?? 'Curso') ?>
                                    </h4>
                                    <?php $tname = $course->teacher_name ?? $course->docente ?? null; ?>
                                    <?php if ($tname): ?>
                                        <p class="text-sm text-gray-500 dark:text-gray-300">Prof. <?= htmlspecialchars($tname) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-xs bg-emerald-100 dark:bg-neutral-700 text-emerald-800 dark:text-emerald-300 px-3 py-1 rounded-full font-medium">
                                    Activo
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-12 text-gray-500 dark:text-gray-300">
                        <i data-feather="book" class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-neutral-600"></i>
                        <p class="text-lg">No tienes cursos activos</p>
                        <p class="text-sm mt-2">Contacta a administración para inscribirte</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Calificaciones Recientes -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow duration-300" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center">
                    <i data-feather="award" class="w-5 h-5 mr-2 text-teal-600"></i>
                    Calificaciones Recientes
                </h3>
                <a href="/src/plataforma/app/calificaciones" class="text-teal-600 dark:text-teal-300 hover:text-teal-700 text-sm font-medium flex items-center group">
                    Ver todas
                    <i data-feather="arrow-right" class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
            <div class="space-y-4">
                <?php if (!empty($recentGrades)): ?>
                    <?php foreach ($recentGrades as $grade): ?>
                        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-neutral-800 dark:to-neutral-800 rounded-lg hover:from-teal-50 hover:to-cyan-50 transition-all duration-300 group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-teal-100 dark:bg-neutral-700 flex items-center justify-center mr-3 group-hover:bg-teal-200 transition-colors">
                                    <i data-feather="award" class="w-5 h-5 text-teal-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">
                                        <?= htmlspecialchars($grade->course_name ?? $grade->materia ?? 'Materia') ?>
                                    </h4>
                                    <?php $created = $grade->created_at ?? null; ?>
                                    <?php if ($created): ?>
                                        <p class="text-sm text-gray-500 dark:text-gray-300"><?= date('d/m/Y', strtotime($created)) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="text-right">
                                <?php $val = (float)($grade->grade ?? $grade->calificacion ?? 0); ?>
                                <span class="text-lg font-bold <?= $val >= 7 ? 'text-green-600' : 'text-red-600' ?>">
                                    <?= number_format($val, 1) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-12 text-gray-500 dark:text-gray-300">
                        <i data-feather="award" class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-neutral-600"></i>
                        <p class="text-lg">No tienes calificaciones registradas</p>
                        <p class="text-sm mt-2">Tus calificaciones aparecerán aquí</p>
                    </div>
                <?php endif; ?>
            </div>
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
        const targetAttr = counter.getAttribute('data-target') || '0';
        const isFloat = targetAttr.includes('.');
        const target = parseFloat(targetAttr);
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const timer = setInterval(() => {
            current += step;
            const next = current >= target ? target : current;

            if (isFloat) {
                counter.textContent = next.toFixed(1);
            } else if ((counter.nextElementSibling && counter.nextElementSibling.textContent.includes('Completado'))) {
                counter.textContent = Math.floor(next) + '%';
            } else {
                counter.textContent = Math.floor(next);
            }

            if (next === target) clearInterval(timer);
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
        this.style.boxShadow = '0 25px 50px rgba(0,0,0,0.15), 0 0 30px rgba(16, 185, 129, 0.4)';
    });
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
        this.style.boxShadow = '';
    });
});

// Animate progress bars
document.querySelectorAll('.counter-bar').forEach(bar => {
    const width = bar.getAttribute('data-width') || '0%';
    bar.style.width = '0%';
    setTimeout(() => {
        bar.style.transition = 'width 1.5s ease-out';
        bar.style.width = width;
    }, 500);
});

// Floating animation for icons
document.querySelectorAll('.grid > div i').forEach(icon => {
    icon.style.animation = 'float 3s ease-in-out infinite';
});

// Learning particles
const createLearningParticles = () => {
    const container = document.querySelector('.container') || document.body;
    for (let i = 0; i < 12; i++) {
        const particle = document.createElement('div');
        particle.style.position = 'absolute';
        particle.style.width = '2px';
        particle.style.height = '2px';
        particle.style.background = `hsl(${160 + Math.random() * 40}, 70%, 60%)`;
        particle.style.borderRadius = '50%';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        particle.style.animation = `learningFloat ${Math.random() * 6 + 3}s ease-in-out infinite`;
        particle.style.opacity = '0.2';
        particle.style.zIndex = '-1';
        container.appendChild(particle);
    }
};

// Custom animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fade-in { from {opacity:0; transform: translateY(20px);} to {opacity:1; transform: translateY(0);} }
    @keyframes spin-slow { from {transform: rotate(0deg);} to {transform: rotate(360deg);} }
    @keyframes float { 0%,100% {transform: translateY(0);} 50% {transform: translateY(-10px);} }
    @keyframes learningFloat {
        0%,100% { transform: translateY(0) translateX(0) rotate(0deg); }
        33% { transform: translateY(-12px) translateX(8px) rotate(120deg); }
        66% { transform: translateY(-6px) translateX(-4px) rotate(240deg); }
    }
    .animate-fade-in { animation: fade-in 0.8s ease-out forwards; }
    .animation-delay-200 { animation-delay: 0.2s; }
    .animate-spin-slow { animation: spin-slow 3s linear infinite; }
`;
document.head.appendChild(style);

// Initialize
window.addEventListener('load', function() {
    animateCounters();
    initTooltips();
    setTimeout(createLearningParticles, 1000);
});
</script>
