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
        }

        .dark body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .hero-section {
            position: relative;
            background: linear-gradient(135deg, var(--ut-green-600) 0%, var(--ut-green-800) 100%);
            overflow: hidden;
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
            width: 400px;
            height: 400px;
            background: var(--ut-green-300);
            top: -100px;
            right: -100px;
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            background: var(--ut-gold);
            bottom: -50px;
            left: -50px;
        }

        .shape-3 {
            width: 200px;
            height: 200px;
            background: var(--ut-blue);
            top: 40%;
            left: 20%;
        }

        .university-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 24px;
            box-shadow: 
                0 4px 6px -1px rgba(0, 0, 0, 0.05),
                0 10px 15px -3px rgba(0, 0, 0, 0.05),
                0 0 0 1px rgba(255, 255, 255, 0.8);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
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
            height: 4px;
            background: linear-gradient(90deg, var(--ut-green-500), var(--ut-green-700));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease;
        }

        .university-card:hover::before {
            transform: scaleX(1);
        }

        .university-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.9);
        }

        .dark .university-card:hover {
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.1);
        }

        .career-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 20px;
            box-shadow: 
                0 4px 6px -1px rgba(0, 0, 0, 0.05),
                0 10px 15px -3px rgba(0, 0, 0, 0.05),
                0 0 0 1px rgba(255, 255, 255, 0.8);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .dark .career-card {
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
            box-shadow: 
                0 4px 6px -1px rgba(0, 0, 0, 0.2),
                0 10px 15px -3px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        .career-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--ut-green-500), var(--ut-green-700));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease;
        }

        .career-card:hover::before {
            transform: scaleX(1);
        }

        .career-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.7s ease;
        }

        .career-card:hover::after {
            left: 100%;
        }

        .career-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04),
                0 0 0 1px rgba(255, 255, 255, 0.9);
        }

        .dark .career-card:hover {
            box-shadow: 
                0 20px 25px -5px rgba(0, 0, 0, 0.4),
                0 10px 10px -5px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 255, 255, 0.1);
        }

        .career-image {
            height: 180px;
            width: 100%;
            object-fit: cover;
            border-radius: 16px 16px 0 0;
            transition: transform 0.5s ease;
        }

        .career-card:hover .career-image {
            transform: scale(1.05);
        }

        .career-icon {
            background: linear-gradient(135deg, var(--ut-green-500), var(--ut-green-700));
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(40, 165, 95, 0.3);
            transition: all 0.3s ease;
            position: absolute;
            top: 150px;
            right: 20px;
            border: 3px solid white;
        }

        .career-card:hover .career-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 8px 20px rgba(40, 165, 95, 0.4);
        }

        .conocer-carrera-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            background: linear-gradient(135deg, var(--ut-green-500), var(--ut-green-700));
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 6px rgba(40, 165, 95, 0.2);
        }

        .conocer-carrera-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .conocer-carrera-btn:hover::before {
            left: 100%;
        }

        .conocer-carrera-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(40, 165, 95, 0.3);
            background: linear-gradient(135deg, var(--ut-green-600), var(--ut-green-800));
        }

        .explorar-campus-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            background: linear-gradient(135deg, var(--ut-blue), var(--ut-purple));
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2);
        }

        .explorar-campus-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .explorar-campus-btn:hover::before {
            left: 100%;
        }

        .explorar-campus-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
            background: linear-gradient(135deg, #4f83f8, #9a67f7);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
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
            margin-bottom: 2rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--ut-green-500), var(--ut-green-700));
            border-radius: 2px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .career-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .career-card:nth-child(2) { animation-delay: 0.1s; }
        .career-card:nth-child(3) { animation-delay: 0.2s; }
        .career-card:nth-child(4) { animation-delay: 0.3s; }
        .career-card:nth-child(5) { animation-delay: 0.4s; }
        .career-card:nth-child(6) { animation-delay: 0.5s; }

        #carreraModal {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #carreraModal:not(.hidden) {
            opacity: 1;
        }

        #carreraModal > div {
            transform: scale(0.9) translateY(20px);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        #carreraModal:not(.hidden) > div {
            transform: scale(1) translateY(0);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--ut-green-500), var(--ut-green-700));
            border-radius: 20px 20px 0 0;
            padding: 1.5rem 2rem;
            color: white;
        }

        .modal-body {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 0 0 20px 20px;
        }

        .dark .modal-body {
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
        }

        .career-feature {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
        }

        .dark .career-feature {
            background: rgba(30, 41, 59, 0.5);
        }

        .career-feature:hover {
            transform: translateX(5px);
            background: rgba(255, 255, 255, 0.9);
        }

        .dark .career-feature:hover {
            background: rgba(30, 41, 59, 0.8);
        }

        .career-feature i {
            margin-right: 0.75rem;
            color: var(--ut-green-500);
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }

        .university-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .university-card:hover .university-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .placeholder-card {
            background: linear-gradient(145deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 20px;
            border: 2px dashed #cbd5e1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            transition: all 0.3s ease;
        }

        .dark .placeholder-card {
            background: linear-gradient(145deg, #334155 0%, #1e293b 100%);
            border-color: #475569;
        }

        .placeholder-card:hover {
            transform: translateY(-5px);
            border-color: var(--ut-green-500);
        }

        .glow-effect {
            position: relative;
        }

        .glow-effect::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: inherit;
            box-shadow: 0 0 20px 10px rgba(40, 165, 95, 0.3);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .glow-effect:hover::after {
            opacity: 1;
        }

        .nav-shell {
            backdrop-filter: blur(12px) saturate(180%);
            background: rgba(255, 255, 255, 0.85);
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            border-radius: 0 0 24px 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .nav-shell {
            background: rgba(15, 23, 42, 0.85);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-scrolled {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            background: rgba(255, 255, 255, 0.95);
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            border-radius: 0 0 16px 16px;
        }

        .dark .nav-scrolled {
            background: rgba(15, 23, 42, 0.95);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.3), 0 4px 6px -4px rgb(0 0 0 / 0.2);
        }

        .nav-link {
            position: relative;
            overflow: hidden;
            color: #374151;
            font-weight: 500;
            padding: 0.5rem 0;
            transition: all 0.3s ease;
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
            transform: translateZ(0);
            backface-visibility: hidden;
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
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
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
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .button-group button {
            flex: 1;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Navbar -->
    <nav class="fixed top-0 inset-x-0 z-50 transition-all duration-300" id="mainNav">
        <div class="nav-shell mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between">
                <!-- Brand -->
                <a href="/src/" class="flex items-center gap-3 group transition-all duration-300 nav-brand">
                    <div class="relative h-10 w-10">
                        <img src="/src/plataforma/app/img/UT.jpg" alt="UTSC" 
                             class="h-full w-full rounded-lg object-cover ring-2 ring-white/20 group-hover:ring-primary-500 transition-all duration-300 transform group-hover:scale-105" 
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500/20 to-secondary-500/20 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300 hidden" style="display: none;">
                            <i data-feather="award" class="w-full h-full text-primary-500"></i>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-bold tracking-wide nav-title bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-secondary-600">UTSC</span>
                        <span class="text-xs text-neutral-500 dark:text-neutral-400">Universidad Tecnológica Santa Catarina</span>
                    </div>
                </a>

                <!-- Desktop menu -->
                <div class="hidden lg:flex items-center gap-8">
                    <a href="#inicio" class="nav-link">Inicio</a>
                    <a href="carreras.php" class="nav-link active">Carreras</a>
                    <a href="#docentes" class="nav-link">Docentes</a>
                    <a href="#recursos" class="nav-link">Recursos</a>
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
                    <a href="/src/plataforma/"
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

    <!-- Hero Section -->
    <section class="hero-section pt-32 pb-20 text-white relative overflow-hidden">
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

    <!-- Sección de Carreras Universitarias -->
    <section class="py-20">
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
                                <button class="explorar-campus-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2">
                                    <i class="fas fa-building"></i>
                                    Ver Instalaciones
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
                                <button class="explorar-campus-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2">
                                    <i class="fas fa-industry"></i>
                                    Ver Talleres
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
                                <button class="explorar-campus-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2">
                                    <i class="fas fa-briefcase"></i>
                                    Ver Empresas
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
                                <button class="explorar-campus-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2">
                                    <i class="fas fa-microchip"></i>
                                    Ver Laboratorios
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
                                <button class="explorar-campus-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2">
                                    <i class="fas fa-cogs"></i>
                                    Ver Plantas
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
                                <button class="explorar-campus-btn text-white py-3 px-4 rounded-lg font-semibold flex items-center justify-center gap-2">
                                    <i class="fas fa-school"></i>
                                    Ver Aulas
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
                    <!-- Espacios para carreras de UTSC -->
                    <div class="placeholder-card">
                        <i class="fas fa-plus text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400 text-lg">Nuevas Carreras en Desarrollo</p>
                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Próximamente más información</p>
                    </div>
                    <div class="placeholder-card">
                        <i class="fas fa-plus text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400 text-lg">Nuevas Carreras en Desarrollo</p>
                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Próximamente más información</p>
                    </div>
                    <div class="placeholder-card">
                        <i class="fas fa-plus text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400 text-lg">Nuevas Carreras en Desarrollo</p>
                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Próximamente más información</p>
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
                    <!-- Espacios para carreras de UTL -->
                    <div class="placeholder-card">
                        <i class="fas fa-plus text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400 text-lg">Nuevas Carreras en Desarrollo</p>
                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Próximamente más información</p>
                    </div>
                    <div class="placeholder-card">
                        <i class="fas fa-plus text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400 text-lg">Nuevas Carreras en Desarrollo</p>
                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Próximamente más información</p>
                    </div>
                    <div class="placeholder-card">
                        <i class="fas fa-plus text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400 text-lg">Nuevas Carreras en Desarrollo</p>
                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Próximamente más información</p>
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
            }
        };

        // JavaScript para el modal
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
            
            const modal = document.getElementById('carreraModal');
            const closeModal = document.getElementById('closeCarreraModal');
            const conocerCarreraBtns = document.querySelectorAll('.conocer-carrera-btn');
            const modalTitle = document.getElementById('modalCarreraTitle');
            const modalContent = document.getElementById('modalCarreraContent');
            
            // Abrir modal
            conocerCarreraBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const carreraId = this.getAttribute('data-carrera');
                    openCarreraModal(carreraId);
                });
            });
            
            // Cerrar modal
            closeModal.addEventListener('click', closeCarreraModal);
            
            // Cerrar modal al hacer clic fuera
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeCarreraModal();
                }
            });
            
            function openCarreraModal(carreraId) {
                const carrera = carrerasData[carreraId];
                
                if (carrera) {
                    modalTitle.textContent = carrera.title;
                    
                    modalContent.innerHTML = `
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
                    
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
            }
            
            function closeCarreraModal() {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
            
            // Cerrar con ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeCarreraModal();
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
        });
    </script>
</body>
</html>