<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carreras Universitarias - UTSC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
    --ut-green-900: #0c4f2e;
    --ut-green-800: #12663a;
    --ut-green-700: #177a46;
    --ut-green-600: #1e8c51;
    --ut-green-500: #28a55f;
    --ut-green-400: #4cbb7c;
    --ut-green-300: #7dd0a0;
    --ut-green-200: #b8e4c9;
    --ut-green-100: #e6f6ed;
    --ut-green-50: #f0faf4;
    --ut-gold: #d4af37;
    --ut-silver: #c0c0c0;
    --ut-blue: #3b82f6;
    --ut-purple: #8b5cf6;
    --ut-orange: #f97316;
    --ut-red: #ef4444;
    --ut-yellow: #eab308;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: 100vh;
    overflow-x: hidden;
    scroll-behavior: smooth;
}

.dark body {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
}

.hero-section {
    position: relative;
    background: linear-gradient(135deg, var(--ut-green-600) 0%, var(--ut-green-800) 100%);
    overflow: hidden;
    min-height: 60vh;
    display: flex;
    align-items: center;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.1"><polygon fill="white" points="0,1000 1000,0 1000,1000"/></svg>');
    background-size: cover;
}

.floating-shapes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
}

.shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.1;
    filter: blur(40px);
}

.shape-1 {
    width: 300px;
    height: 300px;
    background: var(--ut-green-300);
    top: -50px;
    right: -50px;
}

.shape-2 {
    width: 200px;
    height: 200px;
    background: var(--ut-gold);
    bottom: -30px;
    left: -30px;
}

.shape-3 {
    width: 150px;
    height: 150px;
    background: var(--ut-blue);
    top: 30%;
    left: 15%;
}

.university-card {
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 20px;
    box-shadow: 
        0 4px 6px -1px rgba(0, 0, 0, 0.05),
        0 10px 15px -3px rgba(0, 0, 0, 0.05),
        0 0 0 1px rgba(255, 255, 255, 0.8);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
    height: fit-content;
}

.dark .university-card {
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
    box-shadow: 
        0 4px 6px -1px rgba(0, 0, 0, 0.2),
        0 10px 15px -3px rgba(0, 0, 0, 0.3),
        0 0 0 1px rgba(255, 255, 255, 0.05);
}

.university-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--ut-green-500), var(--ut-green-700));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
}

.university-card:hover::before {
    transform: scaleX(1);
}

.university-card:hover {
    transform: translateY(-5px);
    box-shadow: 
        0 20px 25px -5px rgba(0, 0, 0, 0.1),
        0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.dark .university-card:hover {
    box-shadow: 
        0 20px 25px -5px rgba(0, 0, 0, 0.4),
        0 10px 10px -5px rgba(0, 0, 0, 0.3);
}

.career-card {
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 16px;
    box-shadow: 
        0 2px 4px -1px rgba(0, 0, 0, 0.05),
        0 4px 6px -1px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
}

.dark .career-card {
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
    box-shadow: 
        0 2px 4px -1px rgba(0, 0, 0, 0.2),
        0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.career-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--ut-green-500), var(--ut-green-700));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
}

.career-card:hover::before {
    transform: scaleX(1);
}

.career-card:hover {
    transform: translateY(-3px);
    box-shadow: 
        0 10px 15px -3px rgba(0, 0, 0, 0.1),
        0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.dark .career-card:hover {
    box-shadow: 
        0 10px 15px -3px rgba(0, 0, 0, 0.3),
        0 4px 6px -2px rgba(0, 0, 0, 0.2);
}

.career-image {
    height: 140px;
    width: 100%;
    object-fit: cover;
    border-radius: 12px 12px 0 0;
    transition: transform 0.3s ease;
}

.career-card:hover .career-image {
    transform: scale(1.03);
}

.career-icon {
    background: linear-gradient(135deg, var(--ut-green-500), var(--ut-green-700));
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(40, 165, 95, 0.3);
    transition: all 0.3s ease;
    position: absolute;
    top: 115px;
    right: 15px;
    border: 2px solid white;
}

.career-card:hover .career-icon {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(40, 165, 95, 0.4);
}

.conocer-carrera-btn {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, var(--ut-green-500), var(--ut-green-700));
    border-radius: 10px;
    font-weight: 600;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 4px rgba(40, 165, 95, 0.2);
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.conocer-carrera-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(40, 165, 95, 0.3);
    background: linear-gradient(135deg, var(--ut-green-600), var(--ut-green-800));
}

.ver-plantel-btn {
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    background: linear-gradient(135deg, var(--ut-blue), var(--ut-purple));
    border-radius: 10px;
    font-weight: 600;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.ver-plantel-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
    background: linear-gradient(135deg, #4f83f8, #9a67f7);
}

.badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.5rem;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-right: 0.375rem;
    margin-bottom: 0.375rem;
}

.badge-primary {
    background: rgba(40, 165, 95, 0.1);
    color: var(--ut-green-700);
    border: 1px solid rgba(40, 165, 95, 0.2);
}

.dark .badge-primary {
    background: rgba(40, 165, 95, 0.2);
    color: var(--ut-green-300);
    border: 1px solid rgba(40, 165, 95, 0.3);
}

.badge-secondary {
    background: rgba(212, 175, 55, 0.1);
    color: #b8941f;
    border: 1px solid rgba(212, 175, 55, 0.2);
}

.dark .badge-secondary {
    background: rgba(212, 175, 55, 0.2);
    color: #e6c34d;
    border: 1px solid rgba(212, 175, 55, 0.3);
}

.section-title {
    position: relative;
    display: inline-block;
    margin-bottom: 1.5rem;
    font-size: 1.75rem;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, var(--ut-green-500), var(--ut-green-700));
    border-radius: 2px;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.career-card {
    animation: fadeInUp 0.5s ease-out;
}

.career-card:nth-child(2) { animation-delay: 0.1s; }
.career-card:nth-child(3) { animation-delay: 0.2s; }
.career-card:nth-child(4) { animation-delay: 0.3s; }
.career-card:nth-child(5) { animation-delay: 0.4s; }
.career-card:nth-child(6) { animation-delay: 0.5s; }

#carreraModal, #plantelModal {
    opacity: 0;
    transition: opacity 0.3s ease;
}

#carreraModal:not(.hidden), #plantelModal:not(.hidden) {
    opacity: 1;
}

#carreraModal > div, #plantelModal > div {
    transform: scale(0.95) translateY(10px);
    transition: transform 0.3s ease;
}

#carreraModal:not(.hidden) > div, #plantelModal:not(.hidden) > div {
    transform: scale(1) translateY(0);
}

.modal-header {
    background: linear-gradient(135deg, var(--ut-green-500), var(--ut-green-700));
    border-radius: 16px 16px 0 0;
    padding: 1.25rem 1.5rem;
    color: white;
}

.plantel-modal-header {
    background: linear-gradient(135deg, var(--ut-blue), var(--ut-purple));
    border-radius: 16px 16px 0 0;
    padding: 1.25rem 1.5rem;
    color: white;
}

.modal-body {
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 0 0 16px 16px;
    padding: 1.5rem;
}

.dark .modal-body {
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
}

.career-feature {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    padding: 0.5rem;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.7);
    transition: all 0.2s ease;
    font-size: 0.9rem;
}

.dark .career-feature {
    background: rgba(30, 41, 59, 0.5);
}

.career-feature:hover {
    transform: translateX(3px);
    background: rgba(255, 255, 255, 0.9);
}

.dark .career-feature:hover {
    background: rgba(30, 41, 59, 0.8);
}

.career-feature i {
    margin-right: 0.5rem;
    color: var(--ut-green-500);
    font-size: 1.1rem;
    width: 20px;
    text-align: center;
}

.university-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.75rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.university-card:hover .university-icon {
    transform: scale(1.05);
}

.placeholder-card {
    background: linear-gradient(145deg, #f1f5f9 0%, #e2e8f0 100%);
    border-radius: 16px;
    border: 2px dashed #cbd5e1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem 1.5rem;
    transition: all 0.3s ease;
    height: 100%;
}

.dark .placeholder-card {
    background: linear-gradient(145deg, #334155 0%, #1e293b 100%);
    border-color: #475569;
}

.placeholder-card:hover {
    transform: translateY(-3px);
    border-color: var(--ut-green-500);
}

.nav-shell {
    backdrop-filter: blur(12px) saturate(180%);
    background: rgba(255, 255, 255, 0.85);
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
    border-radius: 0 0 20px 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.dark .nav-shell {
    background: rgba(15, 23, 42, 0.85);
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.nav-scrolled {
    box-shadow: 0 8px 12px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    background: rgba(255, 255, 255, 0.95);
    padding-top: 0.375rem;
    padding-bottom: 0.375rem;
    border-radius: 0 0 16px 16px;
}

.dark .nav-scrolled {
    background: rgba(15, 23, 42, 0.95);
    box-shadow: 0 8px 12px -3px rgb(0 0 0 / 0.3), 0 4px 6px -4px rgb(0 0 0 / 0.2);
}

.nav-link {
    position: relative;
    overflow: hidden;
    color: #374151;
    font-weight: 500;
    padding: 0.375rem 0;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.dark .nav-link {
    color: #d1d5db;
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, #10b981, #059669);
    transform: scaleX(0);
    transform-origin: right;
    transition: transform 0.3s ease;
}

.nav-link:hover::after,
.nav-link.active::after {
    transform: scaleX(1);
    transform-origin: left;
}

.nav-link:hover,
.dark .nav-link:hover,
.nav-link.active,
.dark .nav-link.active {
    color: #10b981;
}

.nav-title {
    background: linear-gradient(135deg, #059669, #10b981);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: 700;
    letter-spacing: 0.05em;
    font-size: 1.25rem;
}

.dark .nav-title {
    background: linear-gradient(135deg, #34d399, #10b981);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.theme-toggle {
    position: relative;
    overflow: hidden;
}

.theme-toggle .icon-sun,
.theme-toggle .icon-moon {
    position: absolute;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.theme-toggle .icon-sun {
    opacity: 1;
    transform: translateY(0) rotate(0deg);
}

.theme-toggle .icon-moon {
    opacity: 0;
    transform: translateY(100%) rotate(-90deg);
}

.dark .theme-toggle .icon-sun {
    opacity: 0;
    transform: translateY(-100%) rotate(90deg);
}

.dark .theme-toggle .icon-moon {
    opacity: 1;
    transform: translateY(0) rotate(0deg);
}

.button-group {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.75rem;
}

.button-group button {
    flex: 1;
    font-size: 0.8rem;
    padding: 0.375rem 0.75rem;
}

.plantel-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.75rem;
    margin-top: 0.75rem;
}

.plantel-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.3s ease;
    cursor: pointer;
}

.plantel-image:hover {
    transform: scale(1.03);
}

.plantel-description {
    background: rgba(59, 130, 246, 0.1);
    border-radius: 10px;
    padding: 0.75rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.dark .plantel-description {
    background: rgba(59, 130, 246, 0.2);
}

.page-section {
    min-height: auto;
    padding-top: 60px;
    padding-bottom: 60px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-section {
        min-height: 50vh;
        padding: 2rem 0;
    }
    
    .section-title {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .career-image {
        height: 120px;
    }
    
    .career-icon {
        width: 40px;
        height: 40px;
        top: 95px;
        right: 12px;
    }
    
    .university-icon {
        width: 50px;
        height: 50px;
    }
    
    .button-group {
        flex-direction: column;
    }
}
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Navbar -->
    <nav class="fixed top-0 inset-x-0 z-50 transition-all duration-300" id="mainNav">
        <div class="nav-shell mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between">
                <!-- Brand -->
                <a href="#inicio" class="flex items-center gap-3 group transition-all duration-300 nav-brand">
                    <div class="relative h-10 w-10">
                        <div class="h-full w-full rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 flex items-center justify-center">
                            <span class="text-white font-bold">UT</span>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-bold tracking-wide nav-title bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-secondary-600">UTSC</span>
                        <span class="text-xs text-neutral-500 dark:text-neutral-400">Universidad Tecnológica Santa Catarina</span>
                    </div>
                </a>

                <!-- Desktop menu -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="index.php" class="nav-link">Inicio</a>
                    <a href="carreras.php" class="nav-link active">Carreras</a>
                    <a href="nosotros.php" class="nav-link">Nosotros</a>
                </div>

                <!-- Actions -->
                <div class="hidden lg:flex items-center gap-4">
                    <!-- Theme toggle -->
                    <button id="themeToggle"
                            class="theme-toggle h-10 w-10 rounded-xl flex items-center justify-center ring-1 ring-black/10 dark:ring-white/10 hover:ring-primary-500 transition-all duration-300 bg-white/70 dark:bg-neutral-800/70 backdrop-blur transform hover:scale-105"
                            aria-label="Cambiar tema"
                            title="Cambiar entre modo claro y oscuro">
                        <span class="icon-sun pointer-events-none transition-all duration-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
                            </svg>
                        </span>
                        <span class="icon-moon pointer-events-none transition-all duration-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z"/>
                            </svg>
                        </span>
                    </button>

                    <!-- Plataforma -->
                    <a href="#plataforma"
                       class="group relative inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-500 dark:to-emerald-500 px-6 py-2.5 font-semibold text-white transition-all duration-300 hover:translate-y-[-2px] hover:shadow-lg hover:shadow-green-500/30 border-2 border-white shadow-xl animate-pulse"
                       aria-label="Acceder a la Plataforma Estudiantil">
                        <i data-feather="log-in" class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1"></i>
                        <span>Plataforma Estudiantil</span>
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-green-600 to-emerald-600 dark:from-green-500 dark:to-emerald-500 opacity-0 transition-opacity duration-300 group-hover:opacity-20"></div>
                    </a>
                </div>

                <!-- Mobile toggles -->
                <div class="lg:hidden flex items-center gap-3">
                    <button id="themeToggleSm"
                            class="theme-toggle h-10 w-10 rounded-xl flex items-center justify-center ring-1 ring-black/10 dark:ring-white/10 hover:ring-primary-500 transition-all duration-300 bg-white/70 dark:bg-neutral-800/70 backdrop-blur"
                            aria-label="Cambiar tema"
                            title="Cambiar entre modo claro y oscuro">
                        <span class="icon-sun pointer-events-none transition-all duration-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="12" cy="12" r="4"></circle>
                                <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/>
                            </svg>
                        </span>
                        <span class="icon-moon pointer-events-none transition-all duration-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z"/>
                            </svg>
                        </span>
                    </button>
                    <button id="menuToggle"
                            class="h-10 w-10 rounded-xl flex items-center justify-center ring-1 ring-black/10 dark:ring-white/10 hover:ring-primary-500 transition-all duration-300 bg-white/70 dark:bg-neutral-800/70 backdrop-blur"
                            aria-label="Abrir menú"
                            title="Menú móvil">
                        <i data-feather="menu" class="h-5 w-5 text-gray-600 dark:text-gray-300"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sección Inicio -->
    <section id="inicio" class="page-section hero-section pt-32 pb-20 text-white relative overflow-hidden">
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-6 leading-tight">
                    Descubre Nuestras
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-yellow-300 to-green-300">Carreras</span>
                </h1>
                <p class="text-xl md:text-2xl text-green-100 mb-8 max-w-3xl mx-auto">
                    Formamos a los líderes del mañana con programas educativos de vanguardia y enfoque práctico
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button class="bg-white text-green-700 px-8 py-3 rounded-xl font-bold text-lg hover:bg-green-50 transition-colors shadow-lg">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Solicitar Información
                    </button>
                    <button class="border-2 border-white text-white px-8 py-3 rounded-xl font-bold text-lg hover:bg-white/10 transition-colors">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Proceso de Admisión
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección Carreras -->
    <section id="carreras" class="page-section py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Universidad Tecnológica Montemorelos -->
            <div class="mb-20">
                <div class="university-card p-8 mb-12">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                        <div class="university-icon bg-gradient-to-r from-green-500 to-emerald-600">
                            <i class="fas fa-book text-white text-3xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Universidad Tecnológica Montemorelos</h3>
                            <p class="text-xl text-gray-600 dark:text-gray-300 mb-4">Excelencia educativa con visión global y enfoque en la innovación tecnológica</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="badge badge-primary">+20 Años de Experiencia</span>
                                <span class="badge badge-secondary">Programas Certificados</span>
                                <span class="badge badge-primary">Vinculación Internacional</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de Carreras -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <!-- Desarrollo y Gestión de Software -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Desarrollo de Software" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-laptop-code text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Desarrollo y Gestión de Software</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                    <span class="badge badge-secondary">Nuevo</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Formación en desarrollo de software, gestión de proyectos tecnológicos y sistemas de información empresarial.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="desarrollo-software">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="desarrollo-software">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Mantenimiento Industrial -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Mantenimiento Industrial" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-cogs text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Mantenimiento Industrial</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Especialización en mantenimiento de sistemas industriales, automatización y gestión de procesos productivos.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="mantenimiento-industrial">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="mantenimiento-industrial">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Negocios Internacionales -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1553877522-43269d4ea984?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Negocios Internacionales" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-globe text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Negocios Internacionales</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Formación en comercio exterior, logística internacional y gestión de negocios globales con visión estratégica.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="negocios-internacionales">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="negocios-internacionales">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Mecatrónica -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Mecatrónica" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-robot text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Mecatrónica</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Integración de mecánica, electrónica e informática para el desarrollo de sistemas automatizados y robots industriales.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="mecatronica">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="mecatronica">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Procesos Productivos -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1581093458791-9d4a26f5b0d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Procesos Productivos" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-industry text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Procesos Productivos</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Optimización de procesos de manufactura, control de calidad y gestión de producción para maximizar eficiencia.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="procesos-productivos">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="procesos-productivos">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Lengua Inglesa -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Lengua Inglesa" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-language text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Lengua Inglesa</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                    <span class="badge badge-secondary">Bilingüe</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Dominio del idioma inglés, traducción, interpretación y enseñanza del lenguaje en contextos profesionales.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="lengua-inglesa">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="lengua-inglesa">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Universidad Tecnológica Santa Catarina -->
            <div class="mb-20">
                <div class="university-card p-8 mb-12">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                        <div class="university-icon bg-gradient-to-r from-blue-500 to-blue-600">
                            <i class="fas fa-award text-white text-3xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Universidad Tecnológica Santa Catarina</h3>
                            <p class="text-xl text-gray-600 dark:text-gray-300 mb-4">Innovación y tecnología de vanguardia con enfoque en el desarrollo sostenible</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="badge badge-primary">Tecnología Avanzada</span>
                                <span class="badge badge-secondary">Laboratorios Especializados</span>
                                <span class="badge badge-primary">Vinculación Empresarial</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Carrera 1 - Inteligencia Artificial -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1677442136019-21780ecad995?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Inteligencia Artificial" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-brain text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Inteligencia Artificial</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                    <span class="badge badge-secondary">Nuevo</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Desarrollo de sistemas inteligentes, machine learning y soluciones innovadoras con IA.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="ia-utsc">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="ia-utsc">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carrera 2 - Ciberseguridad -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Ciberseguridad" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-shield-alt text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Ciberseguridad</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                    <span class="badge badge-secondary">Demanda Alta</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Protección de sistemas informáticos, análisis de vulnerabilidades y seguridad digital.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="ciberseguridad-utsc">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="ciberseguridad-utsc">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carrera 3 - Energías Renovables -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Energías Renovables" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-solar-panel text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Energías Renovables</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Desarrollo de sistemas de energía sostenible y tecnologías limpias para el futuro.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="energias-utsc">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="energias-utsc">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carrera 4 - Biotecnología -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Biotecnología" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-dna text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Biotecnología</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Aplicación tecnológica en sistemas biológicos para desarrollar productos y procesos.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="biotecnologia-utsc">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="biotecnologia-utsc">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carrera 5 - IoT y Sistemas Embebidos -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="IoT y Sistemas Embebidos" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-microchip text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">IoT y Sistemas Embebidos</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                    <span class="badge badge-secondary">Emergente</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Desarrollo de dispositivos conectados y sistemas inteligentes para la industria 4.0.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="iot-utsc">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="iot-utsc">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carrera 6 - Data Science -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Data Science" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-chart-bar text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Data Science</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Análisis de grandes volúmenes de datos y desarrollo de soluciones basadas en analytics.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="datascience-utsc">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="datascience-utsc">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carrera 7 - Realidad Virtual y Aumentada -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1592478411213-6153e4ebc696?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Realidad Virtual y Aumentada" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-vr-cardboard text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Realidad Virtual y Aumentada</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                    <span class="badge badge-secondary">Innovador</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Desarrollo de experiencias inmersivas y aplicaciones de realidad extendida.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="rv-utsc">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="rv-utsc">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Universidad Tecnológica de Linares -->
            <div class="mb-20">
                <div class="university-card p-8 mb-12">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                        <div class="university-icon bg-gradient-to-r from-purple-500 to-purple-600">
                            <i class="fas fa-graduation-cap text-white text-3xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Universidad Tecnológica de Linares</h3>
                            <p class="text-xl text-gray-600 dark:text-gray-300 mb-4">Desarrollo regional con calidad educativa y compromiso social</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="badge badge-primary">Enfoque Regional</span>
                                <span class="badge badge-secondary">Compromiso Social</span>
                                <span class="badge badge-primary">Desarrollo Sustentable</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Carrera 1 - Agrotecnología -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1625246333195-78d9c38ad449?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Agrotecnología" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-tractor text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Agrotecnología</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                    <span class="badge badge-secondary">Regional</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Tecnología aplicada a la agricultura para optimizar producción y sostenibilidad.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="agrotecnologia-utl">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="agrotecnologia-utl">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carrera 2 - Turismo Sustentable -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Turismo Sustentable" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-leaf text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Turismo Sustentable</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Gestión de destinos turísticos con enfoque en sostenibilidad y desarrollo local.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="turismo-utl">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="turismo-utl">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carrera 3 - Logística y Transporte -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Logística y Transporte" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-truck text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Logística y Transporte</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Optimización de cadenas de suministro y gestión eficiente del transporte.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="logistica-utl">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="logistica-utl">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carrera 4 - Desarrollo Comunitario -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1573164713714-d95e436ab8d6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Desarrollo Comunitario" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-hands-helping text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Desarrollo Comunitario</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                    <span class="badge badge-secondary">Social</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Implementación de proyectos para el desarrollo sostenible de comunidades.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="desarrollo-utl">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="desarrollo-utl">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carrera 5 - Gastronomía Regional -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Gastronomía Regional" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-utensils text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Gastronomía Regional</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Preservación y innovación de la cocina tradicional con técnicas modernas.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="gastronomia-utl">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="gastronomia-utl">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carrera 6 - Energías Alternativas -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Energías Alternativas" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-bolt text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Energías Alternativas</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Implementación de soluciones energéticas sostenibles para comunidades rurales.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="energias-utl">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="energias-utl">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carrera 7 - Tecnologías de la Información -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1518709268805-4e9042af2176?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Tecnologías de la Información" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-server text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Tecnologías de la Información</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Implementación de soluciones tecnológicas para el desarrollo regional.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="ti-utl">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="ti-utl">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Carrera 8 - Administración Pública -->
                    <div class="career-card p-0 glow-effect">
                        <div class="relative">
                            <img src="https://images.unsplash.com/photo-1589829545856-d10d557cf95f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                                 alt="Administración Pública" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-landmark text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Administración Pública</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Gestión eficiente de instituciones públicas y desarrollo de políticas sociales.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1.5 años
                                </span>
                            </div>
                            <div class="button-group">
                                <button class="conocer-carrera-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-carrera="adminpublica-utl">
                                    <i class="fas fa-info-circle"></i>
                                    Conocer más
                                </button>
                                <button class="ver-plantel-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2"
                                        data-plantel="adminpublica-utl">
                                    <i class="fas fa-building"></i>
                                    Ver Plantel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para información de carreras -->
    <div id="carreraModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden">
            <!-- Header del modal -->
            <div class="modal-header">
                <div class="flex justify-between items-center">
                    <h3 id="modalCarreraTitle" class="text-2xl font-bold">Información de la Carrera</h3>
                    <button id="closeCarreraModal" class="text-white hover:text-gray-200 text-xl transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Contenido del modal -->
            <div class="modal-body p-6 overflow-y-auto max-h-[60vh]">
                <div id="modalCarreraContent">
                    <!-- El contenido se cargará dinámicamente -->
                </div>
            </div>
            
            <!-- Footer del modal -->
            <div class="p-6 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                <div class="flex flex-col sm:flex-row gap-4">
                    <button class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-6 rounded-xl font-semibold text-gray-700 dark:text-gray-300 border-2 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 transition-colors">
                        <i class="fas fa-download"></i>
                        Descargar Plan de Estudios
                    </button>
                    <button class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-6 rounded-xl font-semibold text-white bg-green-500 hover:bg-green-600 transition-colors">
                        <i class="fas fa-paper-plane"></i>
                        Solicitar Información
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver plantel -->
    <div id="plantelModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-6xl w-full mx-4 max-h-[90vh] overflow-hidden">
            <!-- Header del modal -->
            <div class="plantel-modal-header">
                <div class="flex justify-between items-center">
                    <h3 id="modalPlantelTitle" class="text-2xl font-bold">Instalaciones y Plantel</h3>
                    <button id="closePlantelModal" class="text-white hover:text-gray-200 text-xl transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <!-- Contenido del modal -->
            <div class="modal-body p-6 overflow-y-auto max-h-[60vh]">
                <div id="modalPlantelContent">
                    <!-- El contenido se cargará dinámicamente -->
                </div>
            </div>
            
            <!-- Footer del modal -->
            <div class="p-6 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                <div class="flex justify-center">
                    <button class="inline-flex items-center justify-center gap-2 py-3 px-8 rounded-xl font-semibold text-white bg-blue-500 hover:bg-blue-600 transition-colors">
                        <i class="fas fa-calendar-alt"></i>
                        Agendar Visita al Plantel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inicializar Feather Icons
        feather.replace();

        // Datos de las carreras de Montemorelos
        const carrerasData = {
            'desarrollo-software': {
                title: 'Desarrollo y Gestión de Software',
                universidad: 'Universidad Tecnológica Montemorelos',
                descripcion: 'Forma profesionales capaces de desarrollar, implementar y gestionar sistemas de software de calidad, aplicando metodologías ágiles y estándares internacionales.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Desarrollar aplicaciones web y móviles',
                    'Gestionar proyectos de software',
                    'Administrar bases de datos',
                    'Implementar metodologías ágiles',
                    'Diseñar arquitecturas de software',
                    'Realizar pruebas de calidad'
                ],
                campoLaboral: [
                    'Desarrollador Full Stack',
                    'Gestor de Proyectos TI',
                    'Administrador de Bases de Datos',
                    'Consultor Tecnológico',
                    'Arquitecto de Software',
                    'Analista de Sistemas'
                ]
            },
            'mantenimiento-industrial': {
                title: 'Mantenimiento Industrial',
                universidad: 'Universidad Tecnológica Montemorelos',
                descripcion: 'Prepara especialistas en el mantenimiento de sistemas industriales, automatización y gestión de procesos productivos con enfoque en eficiencia y seguridad.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Mantenimiento predictivo y preventivo',
                    'Automatización industrial',
                    'Gestión de procesos productivos',
                    'Seguridad industrial',
                    'Control de calidad',
                    'Supervisión de equipos'
                ],
                campoLaboral: [
                    'Supervisor de Mantenimiento',
                    'Técnico en Automatización',
                    'Gestor de Procesos',
                    'Consultor Industrial',
                    'Ingeniero de Planta',
                    'Coordinador de Producción'
                ]
            },
            'negocios-internacionales': {
                title: 'Negocios Internacionales',
                universidad: 'Universidad Tecnológica Montemorelos',
                descripcion: 'Forma profesionales en comercio exterior, logística internacional y gestión de negocios globales con visión estratégica y competencias interculturales.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Gestión de comercio exterior',
                    'Logística internacional',
                    'Negociación intercultural',
                    'Marketing global',
                    'Finanzas internacionales',
                    'Estrategias de expansión'
                ],
                campoLaboral: [
                    'Ejecutivo de Comercio Exterior',
                    'Agente Aduanal',
                    'Consultor Internacional',
                    'Gestor Logístico',
                    'Analista de Mercados',
                    'Coordinador de Exportación'
                ]
            },
            'mecatronica': {
                title: 'Mecatrónica',
                universidad: 'Universidad Tecnológica Montemorelos',
                descripcion: 'Integra conocimientos de mecánica, electrónica e informática para el diseño, desarrollo y mantenimiento de sistemas automatizados y robots industriales.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Diseño de sistemas mecatrónicos',
                    'Programación de robots',
                    'Automatización industrial',
                    'Control de procesos',
                    'Instrumentación y control',
                    'Diseño CAD/CAM'
                ],
                campoLaboral: [
                    'Ingeniero de Automatización',
                    'Técnico en Robótica',
                    'Diseñador Mecatrónico',
                    'Supervisor de Producción',
                    'Especialista en Control',
                    'Proyectista Industrial'
                ]
            },
            'procesos-productivos': {
                title: 'Procesos Productivos',
                universidad: 'Universidad Tecnológica Montemorelos',
                descripcion: 'Especializa en la optimización de procesos de manufactura, control de calidad y gestión de producción para maximizar la eficiencia operativa.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Optimización de procesos',
                    'Control de calidad',
                    'Gestión de producción',
                    'Lean manufacturing',
                    'Logística y cadena de suministro',
                    'Seguridad industrial'
                ],
                campoLaboral: [
                    'Ingeniero de Procesos',
                    'Supervisor de Producción',
                    'Consultor de Calidad',
                    'Gestor Operativo',
                    'Analista de Mejora Continua',
                    'Coordinador de Manufactura'
                ]
            },
            'lengua-inglesa': {
                title: 'Lengua Inglesa',
                universidad: 'Universidad Tecnológica Montemorelos',
                descripcion: 'Desarrolla competencias lingüísticas avanzadas en inglés, preparando para la traducción, interpretación y enseñanza del idioma en contextos profesionales.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Dominio avanzado del inglés',
                    'Traducción e interpretación',
                    'Enseñanza del idioma',
                    'Comunicación intercultural',
                    'Lingüística aplicada',
                    'Gestión cultural'
                ],
                campoLaboral: [
                    'Traductor/Intérprete',
                    'Profesor de Inglés',
                    'Guía Turístico Bilingüe',
                    'Ejecutivo Internacional',
                    'Editor de Contenidos',
                    'Asesor Lingüístico'
                ]
            },
            // Carreras de UTSC
            'ia-utsc': {
                title: 'Inteligencia Artificial',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Formación en desarrollo de sistemas inteligentes, machine learning, deep learning y soluciones innovadoras con inteligencia artificial para transformar industrias y crear el futuro tecnológico.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Desarrollar algoritmos de machine learning',
                    'Implementar sistemas de visión por computadora',
                    'Crear chatbots y asistentes virtuales inteligentes',
                    'Diseñar redes neuronales artificiales',
                    'Analizar grandes volúmenes de datos',
                    'Implementar soluciones de IA ética'
                ],
                campoLaboral: [
                    'Ingeniero de Machine Learning',
                    'Científico de Datos',
                    'Desarrollador de IA',
                    'Especialista en Visión por Computadora',
                    'Arquitecto de Sistemas Inteligentes',
                    'Consultor en Transformación Digital'
                ]
            },
            'ciberseguridad-utsc': {
                title: 'Ciberseguridad',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Formación especializada en protección de sistemas informáticos, análisis de vulnerabilidades, ethical hacking y gestión de seguridad digital para enfrentar los desafíos del mundo conectado.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Auditoría de sistemas de información',
                    'Análisis forense digital',
                    'Gestión de incidentes de seguridad',
                    'Desarrollo de políticas de seguridad',
                    'Pentesting y ethical hacking',
                    'Protección de infraestructura crítica'
                ],
                campoLaboral: [
                    'Analista de Ciberseguridad',
                    'Consultor de Seguridad Informática',
                    'Ethical Hacker',
                    'Especialista en Forense Digital',
                    'Arquitecto de Seguridad',
                    'Gestor de Riesgos Digitales'
                ]
            },
            'energias-utsc': {
                title: 'Energías Renovables',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Formación en el diseño, implementación y gestión de sistemas de energía sostenible, incluyendo solar, eólica, biomasa y otras tecnologías limpias para un futuro energético responsable.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Diseño de sistemas fotovoltaicos',
                    'Gestión de proyectos eólicos',
                    'Análisis de eficiencia energética',
                    'Desarrollo de biocombustibles',
                    'Planificación de redes inteligentes',
                    'Auditoría energética'
                ],
                campoLaboral: [
                    'Ingeniero de Proyectos Renovables',
                    'Especialista en Eficiencia Energética',
                    'Consultor en Sustentabilidad',
                    'Técnico en Sistemas Solares',
                    'Gestor de Parques Eólicos',
                    'Auditor Energético'
                ]
            },
            'biotecnologia-utsc': {
                title: 'Biotecnología',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Integración de conocimientos biológicos y tecnológicos para el desarrollo de productos y procesos innovadores en áreas como salud, alimentación, medio ambiente y agricultura.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Desarrollo de productos biotecnológicos',
                    'Análisis de ADN y proteínas',
                    'Cultivo de células y tejidos',
                    'Fermentación y procesos biológicos',
                    'Control de calidad biotecnológico',
                    'Biorremediación ambiental'
                ],
                campoLaboral: [
                    'Técnico de Laboratorio Biotecnológico',
                    'Investigador en Bioprocesos',
                    'Especialista en Control de Calidad',
                    'Desarrollador de Productos',
                    'Consultor Ambiental',
                    'Técnico en Bioseguridad'
                ]
            },
            'iot-utsc': {
                title: 'IoT y Sistemas Embebidos',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Desarrollo de dispositivos inteligentes conectados, sistemas embebidos y soluciones de internet de las cosas para la industria 4.0, smart cities y aplicaciones innovadoras.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Diseño de sistemas embebidos',
                    'Programación de microcontroladores',
                    'Desarrollo de aplicaciones IoT',
                    'Integración de sensores y actuadores',
                    'Protocolos de comunicación inalámbrica',
                    'Ciberseguridad en dispositivos IoT'
                ],
                campoLaboral: [
                    'Desarrollador de Sistemas Embebidos',
                    'Ingeniero IoT',
                    'Especialista en Automatización',
                    'Arquitecto de Soluciones Conectadas',
                    'Técnico en Dispositivos Inteligentes',
                    'Consultor en Transformación Digital'
                ]
            },
            'datascience-utsc': {
                title: 'Data Science',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Formación en análisis de grandes volúmenes de datos, machine learning, estadística avanzada y visualización de datos para extraer insights valiosos y apoyar la toma de decisiones empresariales.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Análisis estadístico avanzado',
                    'Minería de datos y pattern recognition',
                    'Machine learning y deep learning',
                    'Visualización de datos complejos',
                    'Gestión de bases de datos big data',
                    'Storytelling con datos'
                ],
                campoLaboral: [
                    'Científico de Datos',
                    'Analista de Business Intelligence',
                    'Especialista en Machine Learning',
                    'Arquitecto de Datos',
                    'Consultor Analytics',
                    'Desarrollador de Dashboards'
                ]
            },
            'rv-utsc': {
                title: 'Realidad Virtual y Aumentada',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Desarrollo de experiencias inmersivas, aplicaciones de realidad virtual, aumentada y mixta para sectores como entretenimiento, educación, salud, arquitectura y entrenamiento profesional.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Desarrollo de entornos virtuales',
                    'Programación de interacciones 3D',
                    'Diseño de experiencias inmersivas',
                    'Integración de hardware VR/AR',
                    'Animación y modelado 3D',
                    'Optimización de rendimiento gráfico'
                ],
                campoLaboral: [
                    'Desarrollador de Realidad Virtual',
                    'Diseñador de Experiencias Inmersivas',
                    'Especialista en Realidad Aumentada',
                    'Artista 3D y Animador',
                    'Arquitecto de Entornos Virtuales',
                    'Consultor en Tecnologías Inmersivas'
                ]
            },
            // Carreras de UTL
            'agrotecnologia-utl': {
                title: 'Agrotecnología',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Aplicación de tecnología avanzada en la agricultura para optimizar la producción, mejorar la sostenibilidad y desarrollar soluciones innovadoras para el sector agroalimentario regional.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Manejo de sistemas de riego tecnificado',
                    'Agricultura de precisión con drones',
                    'Gestión de invernaderos automatizados',
                    'Análisis de suelos y cultivos',
                    'Desarrollo de bioinsumos',
                    'Comercialización de productos agrícolas'
                ],
                campoLaboral: [
                    'Técnico en Agricultura de Precisión',
                    'Especialista en Riego Tecnificado',
                    'Gestor de Invernaderos',
                    'Asesor Agropecuario',
                    'Desarrollador de Bioinsumos',
                    'Comercializador Agrotecnológico'
                ]
            },
            'turismo-utl': {
                title: 'Turismo Sustentable',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Formación en gestión de destinos turísticos con enfoque en sostenibilidad, conservación del patrimonio natural y cultural, y desarrollo comunitario responsable.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Planificación de destinos turísticos',
                    'Gestión de empresas turísticas sustentables',
                    'Desarrollo de productos ecoturísticos',
                    'Interpretación del patrimonio natural',
                    'Marketing turístico responsable',
                    'Gestión de calidad en servicios turísticos'
                ],
                campoLaboral: [
                    'Gestor de Destinos Turísticos',
                    'Guía de Turismo Sustentable',
                    'Desarrollador de Productos Ecoturísticos',
                    'Consultor en Turismo Responsable',
                    'Coordinador de Proyectos Turísticos',
                    'Empresario Turístico'
                ]
            },
            'logistica-utl': {
                title: 'Logística y Transporte',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Optimización de cadenas de suministro, gestión eficiente del transporte y desarrollo de soluciones logísticas para el comercio regional e internacional.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Gestión de almacenes y distribución',
                    'Planificación de rutas de transporte',
                    'Análisis de costos logísticos',
                    'Coordinación de cadena de frío',
                    'Gestión de comercio exterior',
                    'Implementación de sistemas ERP'
                ],
                campoLaboral: [
                    'Coordinador Logístico',
                    'Analista de Cadena de Suministro',
                    'Gestor de Transporte',
                    'Especialista en Comercio Exterior',
                    'Supervisor de Almacén',
                    'Consultor Logístico'
                ]
            },
            'desarrollo-utl': {
                title: 'Desarrollo Comunitario',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Formación para implementar proyectos de desarrollo sostenible que mejoren la calidad de vida en comunidades, fomentando la participación ciudadana y el emprendimiento social.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Diseño de proyectos comunitarios',
                    'Gestión de organizaciones sociales',
                    'Metodologías de participación ciudadana',
                    'Elaboración de diagnósticos comunitarios',
                    'Sostenibilidad de proyectos sociales',
                    'Emprendimiento social'
                ],
                campoLaboral: [
                    'Promotor del Desarrollo Comunitario',
                    'Gestor de Proyectos Sociales',
                    'Coordinador de Organizaciones Civiles',
                    'Consultor en Desarrollo Local',
                    'Facilitador Comunitario',
                    'Emprendedor Social'
                ]
            },
            'gastronomia-utl': {
                title: 'Gastronomía Regional',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Preservación e innovación de la cocina tradicional regional, combinando técnicas culinarias modernas con ingredientes locales para el desarrollo gastronómico sostenible.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Técnicas culinarias tradicionales',
                    'Innovación en cocina regional',
                    'Gestión de establecimientos gastronómicos',
                    'Seguridad e higiene alimentaria',
                    'Maridaje y enología',
                    'Emprendimiento gastronómico'
                ],
                campoLaboral: [
                    'Chef Especializado en Cocina Regional',
                    'Gestor de Restaurantes',
                    'Consultor Gastronómico',
                    'Investigador Culinario',
                    'Emprendedor Gastronómico',
                    'Instructor Culinario'
                ]
            },
            'energias-utl': {
                title: 'Energías Alternativas',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Implementación de soluciones energéticas sostenibles adaptadas a las necesidades de comunidades rurales y urbanas, con enfoque en accesibilidad y bajo impacto ambiental.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Instalación de sistemas solares',
                    'Diseño de biodigestores',
                    'Eficiencia energética residencial',
                    'Energía eólica a pequeña escala',
                    'Gestión de proyectos energéticos',
                    'Educación comunitaria en energía'
                ],
                campoLaboral: [
                    'Técnico en Energías Renovables',
                    'Instalador de Sistemas Solares',
                    'Promotor de Eficiencia Energética',
                    'Consultor en Energía Comunitaria',
                    'Gestor de Proyectos Energéticos',
                    'Educador Ambiental'
                ]
            },
            'ti-utl': {
                title: 'Tecnologías de la Información',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Desarrollo de soluciones tecnológicas adaptadas al contexto regional, incluyendo software para PyMEs, sistemas de información municipal y herramientas digitales para el desarrollo local.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Desarrollo de software adaptado',
                    'Implementación de redes locales',
                    'Soporte técnico comunitario',
                    'Sistemas de información municipal',
                    'Capacitación digital',
                    'Ciberseguridad básica'
                ],
                campoLaboral: [
                    'Desarrollador de Software Local',
                    'Técnico en Soporte Comunitario',
                    'Administrador de Redes Locales',
                    'Consultor TI para PyMEs',
                    'Coordinador de Proyectos Digitales',
                    'Instructor de Alfabetización Digital'
                ]
            },
            'adminpublica-utl': {
                title: 'Administración Pública',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Formación para la gestión eficiente de instituciones públicas, desarrollo de políticas sociales y mejora de los servicios gubernamentales con enfoque en transparencia y participación ciudadana.',
                duracionTsu: '1 año 6 meses',
                duracionIng: '1 año 6 meses adicionales',
                perfilEgreso: [
                    'Gestión de recursos públicos',
                    'Elaboración de políticas sociales',
                    'Transparencia y rendición de cuentas',
                    'Participación ciudadana',
                    'Planificación del desarrollo local',
                    'Evaluación de programas públicos'
                ],
                campoLaboral: [
                    'Funcionario Público',
                    'Gestor de Proyectos Gubernamentales',
                    'Analista de Políticas Públicas',
                    'Consultor en Administración Pública',
                    'Coordinador de Participación Ciudadana',
                    'Auditor Gubernamental'
                ]
            }
        };

        // Datos de los planteles
        const plantelesData = {
            'desarrollo-software': {
                title: 'Desarrollo y Gestión de Software',
                description: 'Nuestras instalaciones para Desarrollo de Software cuentan con laboratorios de última generación, aulas especializadas y espacios colaborativos diseñados para fomentar la innovación y el trabajo en equipo.',
                images: [
                    'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1547658719-da2b51169166?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                ]
            },
            'mantenimiento-industrial': {
                title: 'Mantenimiento Industrial',
                description: 'Contamos con talleres especializados, laboratorios de automatización y áreas de práctica equipadas con tecnología industrial de vanguardia para la formación práctica de nuestros estudiantes.',
                images: [
                    'https://images.unsplash.com/photo-1581093458791-9d4a26f5b0d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                ]
            },
            'negocios-internacionales': {
                title: 'Negocios Internacionales',
                description: 'Nuestras instalaciones para Negocios Internacionales incluyen salas de negociación, laboratorios de comercio exterior y espacios de simulación empresarial para una formación práctica y realista.',
                images: [
                    'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1553877522-43269d4ea984?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1497366811353-6870744d04b2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                ]
            },
            'mecatronica': {
                title: 'Mecatrónica',
                description: 'Laboratorios de robótica, talleres de automatización y áreas de prototipado equipados con tecnología de punta para el desarrollo de proyectos mecatrónicos innovadores.',
                images: [
                    'https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1581093458791-9d4a26f5b0d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                ]
            },
            'procesos-productivos': {
                title: 'Procesos Productivos',
                description: 'Instalaciones industriales a escala, laboratorios de control de calidad y áreas de simulación de procesos para una formación práctica en optimización productiva.',
                images: [
                    'https://images.unsplash.com/photo-1581093458791-9d4a26f5b0d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1581092580497-e0d23cbdf1dc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1581093458791-9d4a26f5b0d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                ]
            },
            'lengua-inglesa': {
                title: 'Lengua Inglesa',
                description: 'Aulas multimedia, laboratorios de idiomas, salas de interpretación y espacios culturales diseñados para la inmersión lingüística y el desarrollo de competencias interculturales.',
                images: [
                    'https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1497366754035-f200968a6e72?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1497366811353-6870744d04b2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                ]
            },
            'ia-utsc': {
                title: 'Inteligencia Artificial',
                description: 'Laboratorios de IA equipados con servidores de alto rendimiento, estaciones de trabajo especializadas y espacios colaborativos para el desarrollo de proyectos de inteligencia artificial y machine learning.',
                images: [
                    'https://images.unsplash.com/photo-1677442136019-21780ecad995?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1555255707-c07966088b7b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1555255707-c07966088b7b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1677442136019-21780ecad995?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                ]
            },
            'ciberseguridad-utsc': {
                title: 'Ciberseguridad',
                description: 'Laboratorios especializados en ciberseguridad con redes aisladas, equipos de pentesting, salas de war games y herramientas profesionales para la formación en seguridad informática.',
                images: [
                    'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                    'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80'
                ]
            }
        };

        // JavaScript para los modales
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
            
            const carreraModal = document.getElementById('carreraModal');
            const plantelModal = document.getElementById('plantelModal');
            const closeCarreraModal = document.getElementById('closeCarreraModal');
            const closePlantelModal = document.getElementById('closePlantelModal');
            const conocerCarreraBtns = document.querySelectorAll('.conocer-carrera-btn');
            const verPlantelBtns = document.querySelectorAll('.ver-plantel-btn');
            const modalCarreraTitle = document.getElementById('modalCarreraTitle');
            const modalCarreraContent = document.getElementById('modalCarreraContent');
            const modalPlantelTitle = document.getElementById('modalPlantelTitle');
            const modalPlantelContent = document.getElementById('modalPlantelContent');
            
            // Abrir modal de carrera
            conocerCarreraBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const carreraId = this.getAttribute('data-carrera');
                    openCarreraModal(carreraId);
                });
            });
            
            // Abrir modal de plantel
            verPlantelBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const plantelId = this.getAttribute('data-plantel');
                    openPlantelModal(plantelId);
                });
            });
            
            // Cerrar modales
            closeCarreraModal.addEventListener('click', () => closeModal(carreraModal));
            closePlantelModal.addEventListener('click', () => closeModal(plantelModal));
            
            // Cerrar modales al hacer clic fuera
            carreraModal.addEventListener('click', function(e) {
                if (e.target === carreraModal) {
                    closeModal(carreraModal);
                }
            });
            
            plantelModal.addEventListener('click', function(e) {
                if (e.target === plantelModal) {
                    closeModal(plantelModal);
                }
            });
            
            function openCarreraModal(carreraId) {
                const carrera = carrerasData[carreraId];
                
                if (carrera) {
                    modalCarreraTitle.textContent = carrera.title;
                    
                    modalCarreraContent.innerHTML = `
                        <div class="space-y-6">
                            <!-- Información general -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Descripción</h4>
                                <p class="text-gray-600 dark:text-gray-300">${carrera.descripcion}</p>
                            </div>
                            
                            <!-- Duración -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                                    <h5 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">TSU (Técnico Superior Universitario)</h5>
                                    <p class="text-blue-700 dark:text-blue-300">${carrera.duracionTsu}</p>
                                </div>
                                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                                    <h5 class="font-semibold text-green-900 dark:text-green-100 mb-2">Ingeniería</h5>
                                    <p class="text-green-700 dark:text-green-300">${carrera.duracionIng}</p>
                                </div>
                            </div>
                            
                            <!-- Perfil de Egreso -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Perfil de Egreso</h4>
                                <ul class="grid md:grid-cols-2 gap-2">
                                    ${carrera.perfilEgreso.map(item => `
                                        <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                            <i class="fas fa-check text-green-500"></i>
                                            ${item}
                                        </li>
                                    `).join('')}
                                </ul>
                            </div>
                            
                            <!-- Campo Laboral -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Campo Laboral</h4>
                                <div class="flex flex-wrap gap-2">
                                    ${carrera.campoLaboral.map(item => `
                                        <span class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-sm">
                                            ${item}
                                        </span>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    `;
                    
                    carreraModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            }
            
            function openPlantelModal(plantelId) {
                const plantel = plantelesData[plantelId];
                
                if (plantel) {
                    modalPlantelTitle.textContent = `Plantel - ${plantel.title}`;
                    
                    modalPlantelContent.innerHTML = `
                        <div class="space-y-6">
                            <!-- Descripción del plantel -->
                            <div class="plantel-description">
                                <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">Nuestras Instalaciones</h4>
                                <p class="text-blue-800 dark:text-blue-200">${plantel.description}</p>
                            </div>
                            
                            <!-- Galería de imágenes -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Galería de Instalaciones</h4>
                                <div class="plantel-gallery">
                                    ${plantel.images.map(img => `
                                        <img src="${img}" alt="Instalación ${plantel.title}" class="plantel-image">
                                    `).join('')}
                                </div>
                            </div>
                            
                            <!-- Características del plantel -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Características del Plantel</h4>
                                <ul class="grid md:grid-cols-2 gap-2">
                                    <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                        <i class="fas fa-check text-blue-500"></i>
                                        Laboratorios especializados
                                    </li>
                                    <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                        <i class="fas fa-check text-blue-500"></i>
                                        Equipo de última generación
                                    </li>
                                    <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                        <i class="fas fa-check text-blue-500"></i>
                                        Espacios colaborativos
                                    </li>
                                    <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                        <i class="fas fa-check text-blue-500"></i>
                                        Aulas multimedia
                                    </li>
                                    <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                        <i class="fas fa-check text-blue-500"></i>
                                        Áreas de práctica
                                    </li>
                                    <li class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                        <i class="fas fa-check text-blue-500"></i>
                                        Talleres equipados
                                    </li>
                                </ul>
                            </div>
                        </div>
                    `;
                    
                    plantelModal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            }
            
            function closeModal(modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
            
            // Cerrar con ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (!carreraModal.classList.contains('hidden')) {
                        closeModal(carreraModal);
                    }
                    if (!plantelModal.classList.contains('hidden')) {
                        closeModal(plantelModal);
                    }
                }
            });

            // Manejo del tema oscuro/claro
            (function(){
                const themeToggle = document.getElementById("themeToggle");
                const themeToggleSm = document.getElementById("themeToggleSm");
                const body = document.body;

                // Función para aplicar el tema
                function applyTheme(theme) {
                    if (theme === "dark") {
                        body.classList.add("dark");
                        localStorage.setItem("theme", "dark");
                    } else {
                        body.classList.remove("dark");
                        localStorage.setItem("theme", "light");
                    }
                    feather.replace(); // Refrescar íconos
                }

                // Cargar preferencia guardada al inicio
                const savedTheme = localStorage.getItem("theme");
                if (savedTheme === "dark") {
                    applyTheme("dark");
                } else if (savedTheme === "light") {
                    applyTheme("light");
                } else {
                    // Si no hay preferencia guardada, usar la preferencia del sistema
                    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        applyTheme("dark");
                    } else {
                        applyTheme("light");
                    }
                }

                // Manejar el botón de tema desktop
                if (themeToggle) {
                    themeToggle.addEventListener("click", () => {
                        const isDark = body.classList.contains("dark");
                        applyTheme(isDark ? "light" : "dark");
                    });
                }

                // Manejar el botón de tema móvil
                if (themeToggleSm) {
                    themeToggleSm.addEventListener("click", () => {
                        const isDark = body.classList.contains("dark");
                        applyTheme(isDark ? "light" : "dark");
                    });
                }

                // Escuchar cambios en la preferencia del sistema
                if (window.matchMedia) {
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if (!localStorage.getItem("theme")) {
                            applyTheme(e.matches ? "dark" : "light");
                        }
                    });
                }
            })();

            // Manejo del scroll para navbar
            const nav = document.getElementById('mainNav');
            let lastScroll = 0;

            window.addEventListener('scroll', () => {
                const currentScroll = window.scrollY;
                
                // Agregar/remover clase scrolled
                if (currentScroll > 0) {
                    nav.classList.add('nav-scrolled');
                } else {
                    nav.classList.remove('nav-scrolled');
                }
                
                // Ocultar/mostrar navbar al hacer scroll
                if (currentScroll > lastScroll && currentScroll > 100) {
                    nav.style.transform = 'translateY(-100%)';
                } else {
                    nav.style.transform = 'translateY(0)';
                }
                
                lastScroll = currentScroll;
            });

            // Navegación suave
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        // Cerrar menú móvil si está abierto
                        const mobileMenu = document.getElementById('mobileMenu');
                        if (mobileMenu && mobileMenu.classList.contains('active')) {
                            mobileMenu.classList.remove('active');
                            const icon = document.querySelector('#menuToggle i');
                            if (icon) {
                                icon.setAttribute('data-feather', 'menu');
                                feather.replace();
                            }
                        }
                        
                        // Scroll suave
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Actualizar enlace activo en navbar
            window.addEventListener('scroll', () => {
                const sections = document.querySelectorAll('.page-section');
                const navLinks = document.querySelectorAll('.nav-link');
                
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    if (window.scrollY >= sectionTop - 100) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${current}`) {
                        link.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>