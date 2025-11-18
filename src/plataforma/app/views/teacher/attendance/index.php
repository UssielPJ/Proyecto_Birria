<div class="container px-6 py-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 rounded-xl p-6 text-white mb-8 shadow-2xl relative overflow-hidden" data-aos="fade-up">
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-pulse"></div>
        <div class="relative flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full backdrop-blur-sm animate-bounce">
                <i data-feather="clipboard" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1 animate-fade-in">Control de Asistencia</h2>
                <p class="opacity-90 animate-fade-in animation-delay-200">Registra y administra la asistencia de tus estudiantes.</p>
            </div>
        </div>
        <div class="absolute top-4 right-4 opacity-20">
            <i data-feather="check-circle" class="w-16 h-16 animate-spin-slow"></i>
        </div>
    </div>

    <!-- Coming Soon Message -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-16 text-center border-2 border-dashed border-neutral-200 dark:border-neutral-700">
        <div class="w-20 h-20 bg-neutral-100 dark:bg-neutral-700 rounded-full flex items-center justify-center mx-auto mb-6">
            <i data-feather="clipboard" class="w-10 h-10 text-neutral-400 dark:text-neutral-500"></i>
        </div>
        <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-3">Funcionalidad en Desarrollo</h3>
        <p class="text-neutral-500 dark:text-neutral-400 mb-6 max-w-md mx-auto">El sistema de control de asistencia está siendo implementado. Pronto podrás registrar la asistencia de tus estudiantes de manera eficiente.</p>
        <div class="flex justify-center gap-4">
            <button class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200 shadow-sm">
                <i data-feather="bell" class="w-5 h-5 mr-2"></i>
                Notificar cuando esté listo
            </button>
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