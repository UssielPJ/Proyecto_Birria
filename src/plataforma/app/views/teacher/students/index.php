<div class="container px-6 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 rounded-xl p-6 text-white mb-8 shadow-2xl relative overflow-hidden" data-aos="fade-up">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-pulse"></div>
        <div class="relative flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full backdrop-blur-sm animate-bounce">
                <i data-feather="users" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1 animate-fade-in">Mis Estudiantes</h2>
                <p class="opacity-90 animate-fade-in animation-delay-200">Estudiantes inscritos en tus cursos.</p>
            </div>
        </div>
        <div class="absolute top-4 right-4 opacity-20">
            <i data-feather="user-check" class="w-16 h-16 animate-spin-slow"></i>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-xl shadow-sm p-6" data-aos="fade-up" data-aos-delay="100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Lista de Estudiantes</h3>
            <div class="text-sm text-gray-500">
                Total: <span class="font-semibold text-indigo-600"><?= count($students) ?></span> estudiantes
            </div>
        </div>

        <?php if (!empty($students)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($students as $student): ?>
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-4 border border-gray-200 hover:shadow-lg hover:scale-105 transition-all duration-200">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                <i data-feather="user" class="w-5 h-5 text-indigo-600"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 text-sm">
                                    <?= htmlspecialchars($student->name ?? 'Sin nombre') ?>
                                </h4>
                                <p class="text-xs text-gray-500">
                                    <?= htmlspecialchars($student->matricula ?? 'Sin matrícula') ?>
                                </p>
                            </div>
                        </div>

                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Carrera:</span>
                                <span class="font-medium text-gray-800">
                                    <?= htmlspecialchars($student->carrera ?? 'N/A') ?>
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Semestre:</span>
                                <span class="font-medium text-gray-800">
                                    <?= htmlspecialchars($student->semestre ?? 'N/A') ?>
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Cursos inscritos:</span>
                                <span class="font-medium text-indigo-600">
                                    <?= $student->enrolled_courses ?? 0 ?>
                                </span>
                            </div>
                        </div>

                        <div class="mt-3 pt-3 border-t border-gray-200">
                            <a href="mailto:<?= htmlspecialchars($student->email ?? '') ?>"
                               class="text-xs text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-1">
                                <i data-feather="mail" class="w-3 h-3"></i>
                                Contactar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i data-feather="users" class="w-8 h-8 text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No hay estudiantes inscritos</h3>
                <p class="text-gray-500">Aún no tienes estudiantes inscritos en tus cursos.</p>
            </div>
        <?php endif; ?>
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