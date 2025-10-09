<div class="container px-6 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-xl p-6 text-white mb-8 shadow-2xl relative overflow-hidden" data-aos="fade-up">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-pulse"></div>
        <div class="relative flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full backdrop-blur-sm animate-bounce">
                <i data-feather="award" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1 animate-fade-in">Gestión de Calificaciones</h2>
                <p class="opacity-90 animate-fade-in animation-delay-200">Administra las calificaciones de tus estudiantes.</p>
            </div>
        </div>
        <div class="absolute top-4 right-4 opacity-20">
            <i data-feather="trending-up" class="w-16 h-16 animate-spin-slow"></i>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-4 mb-6" data-aos="fade-up" data-aos-delay="100">
        <a href="/src/plataforma/app/teacher/grades/create" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
            <i data-feather="plus" class="w-4 h-4"></i>
            Nueva Calificación
        </a>
        <a href="/src/plataforma/app/teacher/courses" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
            <i data-feather="book" class="w-4 h-4"></i>
            Ver Cursos
        </a>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Calificaciones Recientes -->
        <div class="bg-white rounded-xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Calificaciones Recientes</h3>
                <a href="/src/plataforma/app/teacher/grades" class="text-green-600 hover:text-green-700 text-sm font-medium">
                    Ver todas
                </a>
            </div>
            <div class="space-y-3">
                <?php if (!empty($grades)): ?>
                    <?php foreach ($grades as $grade): ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <h4 class="font-medium text-gray-800"><?= htmlspecialchars($grade->student_name ?? 'Estudiante') ?></h4>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($grade->course_name ?? 'Curso') ?></p>
                            </div>
                            <div class="text-right">
                                <span class="text-lg font-bold <?= ($grade->grade ?? 0) >= 7 ? 'text-green-600' : 'text-red-600' ?>">
                                    <?= number_format($grade->grade ?? 0, 1) ?>
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

        <!-- Calificaciones Pendientes -->
        <div class="bg-white rounded-xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Calificaciones Pendientes</h3>
                <a href="/src/plataforma/app/teacher/grades/create" class="text-orange-600 hover:text-orange-700 text-sm font-medium">
                    Calificar ahora
                </a>
            </div>
            <div class="space-y-3">
                <?php if (!empty($pendingGrades)): ?>
                    <?php foreach (array_slice($pendingGrades, 0, 5) as $pending): ?>
                        <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg border border-orange-200">
                            <div>
                                <h4 class="font-medium text-gray-800"><?= htmlspecialchars($pending->student_name ?? 'Estudiante') ?></h4>
                                <p class="text-sm text-gray-500"><?= htmlspecialchars($pending->course_name ?? 'Curso') ?></p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full">
                                    Pendiente
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-8 text-gray-500">
                        <i data-feather="clock" class="w-12 h-12 mx-auto mb-3 text-gray-300"></i>
                        <p>No hay calificaciones pendientes</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6" data-aos="fade-up" data-aos-delay="400">
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl shadow-lg p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-medium">Total Calificaciones</p>
                    <h3 class="text-2xl font-bold mt-1 text-green-800"><?= count($grades) ?></h3>
                </div>
                <div class="p-3 rounded-xl bg-green-100">
                    <i data-feather="award" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-lg p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-sm font-medium">Calificaciones Altas</p>
                    <h3 class="text-2xl font-bold mt-1 text-blue-800">
                        <?= count(array_filter($grades, fn($g) => ($g->grade ?? 0) >= 8)) ?>
                    </h3>
                </div>
                <div class="p-3 rounded-xl bg-blue-100">
                    <i data-feather="trending-up" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl shadow-lg p-6 border border-orange-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-600 text-sm font-medium">Necesitan Atención</p>
                    <h3 class="text-2xl font-bold mt-1 text-orange-800">
                        <?= count(array_filter($grades, fn($g) => ($g->grade ?? 0) < 7)) ?>
                    </h3>
                </div>
                <div class="p-3 rounded-xl bg-orange-100">
                    <i data-feather="alert-triangle" class="w-6 h-6 text-orange-600"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
AOS.init();
feather.replace();

// Add the same animations as teacher dashboard
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