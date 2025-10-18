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

.dark .hero-section {
    background: linear-gradient(135deg, var(--ut-green-800) 0%, var(--ut-green-900) 100%);
}

.dark .hero-section h1 {
    color: white;
}

.dark .hero-section p {
    color: #e2e8f0;
}

.dark .hero-section .bg-white {
    background: #1e293b;
    color: white;
}

.dark .hero-section .bg-white:hover {
    background: #334155;
}

.dark .hero-section .border-white {
    border-color: #e2e8f0;
    color: white;
}

.dark .hero-section .border-white:hover {
    background: rgba(255, 255, 255, 0.1);
}

.dark .university-card h3 {
    color: white;
}

.dark .university-card p {
    color: #cbd5e1;
}

.dark .career-card h4 {
    color: white;
}

.dark .career-card p {
    color: #cbd5e1;
}

.dark .career-card .text-gray-500 {
    color: #9ca3af;
}

.dark .section-title {
    color: white;
}

.dark .badge-primary {
    background: rgba(40, 165, 95, 0.2);
    color: #4ade80;
    border-color: rgba(40, 165, 95, 0.3);
}

.dark .badge-secondary {
    background: rgba(212, 175, 55, 0.2);
    color: #fbbf24;
    border-color: rgba(212, 175, 55, 0.3);
}

.dark .nav-link {
    color: #e5e7eb;
}

.dark .nav-link:hover,
.dark .nav-link.active {
    color: #10b981;
}

.dark .nav-title {
    background: linear-gradient(135deg, #34d399, #10b981);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.dark .theme-toggle {
    background: rgba(31, 41, 55, 0.7);
    border-color: rgba(255, 255, 255, 0.1);
}

.dark .theme-toggle:hover {
    background: rgba(31, 41, 55, 0.9);
    border-color: rgba(16, 185, 129, 0.5);
}

.dark .modal-header {
    background: linear-gradient(135deg, var(--ut-green-700), var(--ut-green-800));
}

.dark .modal-body {
    background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
}

.dark .plantel-description {
    background: rgba(59, 130, 246, 0.2);
}

.dark .plantel-description h4 {
    color: #93c5fd;
}

.dark .plantel-description p {
    color: #bfdbfe;
}

.dark .modal-body h4 {
    color: white;
}

.dark .modal-body p {
    color: #cbd5e1;
}

.dark .modal-body li {
    color: #cbd5e1;
}

.dark .modal-body .bg-gray-100 {
    background: #374151;
    color: #e5e7eb;
}

.dark .modal-body .bg-blue-50 {
    background: rgba(59, 130, 246, 0.1);
}

.dark .modal-body .bg-blue-50 h5 {
    color: #93c5fd;
}

.dark .modal-body .bg-blue-50 p {
    color: #bfdbfe;
}

.dark .modal-body .bg-green-50 {
    background: rgba(34, 197, 94, 0.1);
}

.dark .modal-body .bg-green-50 h5 {
    color: #86efac;
}

.dark .modal-body .bg-green-50 p {
    color: #bbf7d0;
}

.dark .modal-body .text-gray-600 {
    color: #cbd5e1;
}

.dark .modal-body .text-gray-700 {
    color: #e5e7eb;
}

.dark .modal-body .text-blue-900 {
    color: #93c5fd;
}

.dark .modal-body .text-blue-700 {
    color: #bfdbfe;
}

.dark .modal-body .text-green-900 {
    color: #86efac;
}

.dark .modal-body .text-green-700 {
    color: #bbf7d0;
}

.dark .modal-body .border-gray-200 {
    border-color: #374151;
}

.dark .modal-body .bg-gray-50 {
    background: #1f2937;
}

.dark .modal-body .bg-gray-50 .text-gray-700 {
    color: #e5e7eb;
}

.dark .modal-body .bg-gray-50 .border-gray-300 {
    border-color: #4b5563;
}

.dark .modal-body .bg-gray-50 .hover\:border-gray-400:hover {
    border-color: #6b7280;
}

.dark .modal-body .bg-green-500 {
    background: #16a34a;
}

.dark .modal-body .bg-green-500:hover {
    background: #15803d;
}

.dark .modal-body .bg-blue-500 {
    background: #2563eb;
}

.dark .modal-body .bg-blue-500:hover {
    background: #1d4ed8;
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

/* Estilos para el flip solo en la imagen */
.image-flip-container {
  perspective: 1000px;
  cursor: pointer;
}

.image-flip-front,
.image-flip-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  transition: transform 0.6s ease-in-out;
  border-radius: 12px 12px 0 0;
}

.image-flip-back {
  transform: rotateY(180deg);
  display: flex;
  align-items: center;
  justify-content: center;
}

.image-flip-container:hover .image-flip-front {
  transform: rotateY(-180deg);
}

.image-flip-container:hover .image-flip-back {
  transform: rotateY(0deg);
}

.career-card {
  transition: all 0.3s ease;
}

.career-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
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
                <a href="index.php" class="flex items-center gap-3 group transition-all duration-300 nav-brand">
                    <div class="relative h-10 w-10">
                        <img src="plataforma/app/img/UT.jpg" alt="Universidad Tecnológica de Santa Catarina" class="h-full w-full rounded-lg object-cover">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-bold tracking-wide nav-title">UTSC</span>
                        <span class="text-xs text-neutral-500 dark:text-neutral-400">Universidad Tecnológica de Santa Catarina</span>
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
                    <button onclick="alert('Redirigiendo a solicitud de información...')" class="bg-white text-green-700 px-8 py-3 rounded-xl font-bold text-lg hover:bg-green-50 transition-colors shadow-lg">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Solicitar Información
                    </button>
                    <button onclick="alert('Redirigiendo al proceso de admisión...')" class="border-2 border-white text-white px-8 py-3 rounded-xl font-bold text-lg hover:bg-white/10 transition-colors">
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
                            <img src="./plataforma/app/img/Desarrollo de Software.jpeg"
                                 alt="Desarrollo de Software" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-laptop-code text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Ingeniería en Desarrollo y Gestión de Software</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                    <span class="badge badge-secondary">Nuevo</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Formación en el diseño, desarrollo y mantenimiento de software, con énfasis en metodologías ágiles y gestión de proyectos.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 2 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1 año
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
                            <img src="./plataforma/app/img/IndustrialM.jpg"
                                 alt="Mantenimiento Industrial" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-cogs text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Ingeniería en Mantenimiento Industrial</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Capacitación en el mantenimiento de equipos industriales, con enfoque en eficiencia y sostenibilidad operativa.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 2 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1 año
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
                            <img src="./plataforma/app/img/60-IMG_3099.jpg"
                                 alt="Mecatrónica" class="career-image">
                            <div class="career-icon">
                                <i class="fas fa-robot text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Ingeniería en Mecatrónica</h4>
                                <div class="flex space-x-2">
                                    <span class="badge badge-primary">TSU/Ing</span>
                                </div>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Integración de mecánica, electrónica e informática para el desarrollo de sistemas automatizados.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-clock"></i>
                                    TSU: 2 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-users"></i>
                                    Ing: +1 año
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
                            <img src="plataforma/app/img/proceso-industrial.jpg"
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
                            <img src="./plataforma/app/img/Lengua Inglesa.jpg" 
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
                            <img src="plataforma/app/img/Realidad Virtual y Aumentada.jpg"
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
                             <img src="plataforma/app/img/Tecnologías de la Información.jpg"
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
                    <button onclick="alert('Descargando plan de estudios...')" class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-6 rounded-xl font-semibold text-gray-700 dark:text-gray-300 border-2 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 transition-colors">
                        <i class="fas fa-download"></i>
                        Descargar Plan de Estudios
                    </button>
                    <button onclick="alert('Solicitud enviada. Te contactaremos pronto.')" class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-6 rounded-xl font-semibold text-white bg-green-500 hover:bg-green-600 transition-colors">
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
                    <button onclick="alert('Agendando visita al plantel...')" class="inline-flex items-center justify-center gap-2 py-3 px-8 rounded-xl font-semibold text-white bg-blue-500 hover:bg-blue-600 transition-colors">
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
                title: 'Ingeniería en Desarrollo y Gestión de Software',
                universidad: 'Universidad Tecnológica Montemorelos',
                descripcion: 'Formación en diseño, programación, pruebas, mantenimiento y gestión de proyectos de software. Incluye metodologías ágiles, desarrollo web, bases de datos y sistemas embebidos.',
                duracionTsu: '2 años',
                duracionIng: '+1 año',
                perfilEgreso: [
                    'Programador de aplicaciones',
                    'gestor de proyectos tecnológicos',
                    'administrador de bases de datos',
                    'arquitecto de software',
                    'analista de sistemas'
                ],
                campoLaboral: [
                    'Empresas de desarrollo de software',
                    'startups tecnológicas',
                    'áreas de TI en empresas grandes',
                    'consultoras tecnológicas',
                    'instituciones educativas'
                ]
            },
            'mantenimiento-industrial': {
                title: 'Ingeniería en Mantenimiento Industrial',
                universidad: 'Universidad Tecnológica Montemorelos',
                descripcion: 'Capacitación en mantenimiento predictivo y preventivo, gestión de activos, seguridad industrial, control de procesos y automatización.',
                duracionTsu: '2 años',
                duracionIng: '+1 año',
                perfilEgreso: [
                    'Supervisor de mantenimiento',
                    'técnico en automatización',
                    'ingeniero de planta',
                    'gestor de mantenimiento industrial'
                ],
                campoLaboral: [
                    'Industrias manufactureras',
                    'plantas de producción',
                    'empresas de servicios de mantenimiento',
                    'sectores automotriz, petroquímico y alimenticio'
                ]
            },
            'negocios-internacionales': {
                title: 'Negocios Internacionales',
                universidad: 'Universidad Tecnológica Montemorelos',
                descripcion: 'Formación en comercio exterior, logística internacional, negociación intercultural, marketing y financiamiento internacional.',
                duracionTsu: '1.5 años',
                duracionIng: '+1.5 años',
                perfilEgreso: [
                    'Ejecutivo de comercio exterior',
                    'gestor logístico',
                    'analista de mercados internacionales',
                    'asesor en negocios globales'
                ],
                campoLaboral: [
                    'Empresas exportadoras e importadoras',
                    'agencias aduanales',
                    'consultoras internacionales',
                    'instituciones gubernamentales y ONGs'
                ]
            },
            'mecatronica': {
                title: 'Ingeniería en Mecatrónica',
                universidad: 'Universidad Tecnológica Montemorelos',
                descripcion: 'Integración de mecánica, electrónica, informática y control para el desarrollo de sistemas automatizados y robots.',
                duracionTsu: '2 años',
                duracionIng: '+1 año',
                perfilEgreso: [
                    'Ingeniero en automatización',
                    'diseñador de robots',
                    'técnico en control de procesos',
                    'desarrollador de sistemas mecatrónicos'
                ],
                campoLaboral: [
                    'Industria manufacturera',
                    'robótica',
                    'automatización de procesos',
                    'sectores aeronáuticos y de energía'
                ]
            },
            'procesos-productivos': {
                title: 'Procesos Productivos',
                universidad: 'Universidad Tecnológica Montemorelos',
                descripcion: 'Especialización en optimización de procesos de manufactura, control de calidad, gestión de producción y mejora continua.',
                duracionTsu: '1.5 años',
                duracionIng: '+1.5 años',
                perfilEgreso: [
                    'Ingeniero de procesos',
                    'supervisor de producción',
                    'analista de calidad',
                    'gestor de operaciones'
                ],
                campoLaboral: [
                    'Industrias de alimentos, química, metalurgia, farmacéutica, petroquímica y automotriz'
                ]
            },
            'lengua-inglesa': {
                title: 'Lengua Inglesa (Bilingüe)',
                universidad: 'Universidad Tecnológica Montemorelos',
                descripcion: 'Dominio avanzado del inglés, habilidades de traducción, interpretación, comunicación intercultural y enseñanza del idioma.',
                duracionTsu: '1.5 años',
                duracionIng: '+1.5 años',
                perfilEgreso: [
                    'Traductor',
                    'profesor de idiomas',
                    'guía turístico bilingüe',
                    'asesor en comunicación internacional'
                ],
                campoLaboral: [
                    'Instituciones educativas',
                    'sector turístico',
                    'empresas internacionales',
                    'agencias de traducción'
                ]
            },
            // Carreras de UTSC
            'ia-utsc': {
                title: 'Ingeniería en Tecnologías de la Información e Innovación Digital',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Desarrollo de aplicaciones, ciberseguridad, análisis de datos, innovación en transformación digital.',
                duracionTsu: '2 años',
                duracionIng: '+1 año',
                perfilEgreso: [
                    'Desarrollador full-stack',
                    'gestor de proyectos digitales',
                    'administrador de bases de datos',
                    'arquitecto de soluciones TI'
                ],
                campoLaboral: [
                    'Empresas de tecnología',
                    'startups',
                    'hospitales',
                    'instituciones públicas y privadas en transformación digital'
                ]
            },
            'ciberseguridad-utsc': {
                title: 'Ingeniería en Ciberseguridad',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Protección de sistemas informáticos, análisis de vulnerabilidades, pruebas de penetración, gestión de incidentes.',
                duracionTsu: '2 años',
                duracionIng: '+1 año',
                perfilEgreso: [
                    'Analista en seguridad',
                    'consultor en ciberseguridad',
                    'auditor de sistemas',
                    'pentester'
                ],
                campoLaboral: [
                    'Empresas financieras',
                    'sector gubernamental',
                    'empresas de telecomunicaciones',
                    'ciberseguridad en la nube'
                ]
            },
            'energias-utsc': {
                title: 'Ingeniería en Energías Renovables',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Diseño, gestión, mantenimiento de sistemas solares, eólicos, biomasa y tecnologías limpias.',
                duracionTsu: '2 años',
                duracionIng: '+1 año',
                perfilEgreso: [
                    'Ingeniero en energías renovables',
                    'gestor de proyectos sostenibles',
                    'consultor ambiental'
                ],
                campoLaboral: [
                    'Empresas de energías limpias',
                    'plantas solares y eólicas',
                    'consultoras ambientales',
                    'organismos gubernamentales'
                ]
            },
            'biotecnologia-utsc': {
                title: 'Ingeniería en Biotecnología',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Investigación en bioprocesos, cultivos celulares, ADN, producción de bioproductos, control de calidad biotecnológico.',
                duracionTsu: '1.5 años',
                duracionIng: '+1.5 años',
                perfilEgreso: [
                    'Técnico de laboratorio',
                    'investigador',
                    'desarrollador de productos biotecnológicos'
                ],
                campoLaboral: [
                    'Laboratorios farmacéuticos',
                    'industrias alimenticias',
                    'biotecnología ambiental',
                    'instituciones de investigación'
                ]
            },
            'iot-utsc': {
                title: 'IoT y Sistemas Embebidos',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Desarrollo de dispositivos conectados, microcontroladores, sensores, sistemas de domótica y automatización industrial.',
                duracionTsu: '1.5 años',
                duracionIng: '+1.5 años',
                perfilEgreso: [
                    'Ingeniero en IoT',
                    'desarrollador de sistemas embebidos',
                    'especialista en automatización'
                ],
                campoLaboral: [
                    'Industria 4.0',
                    'domótica',
                    'empresas de tecnología',
                    'consultoras en automatización'
                ]
            },
            'datascience-utsc': {
                title: 'Data Science',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Análisis estadístico, minería de datos, machine learning, visualización avanzada, big data.',
                duracionTsu: '1.5 años',
                duracionIng: '+1.5 años',
                perfilEgreso: [
                    'Científico de datos',
                    'analista de inteligencia de negocios',
                    'ingeniero en analytics'
                ],
                campoLaboral: [
                    'Empresas tecnológicas',
                    'bancos',
                    'instituciones de salud',
                    'sector retail',
                    'consultoras de datos'
                ]
            },
            'rv-utsc': {
                title: 'Realidad Virtual y Aumentada',
                universidad: 'Universidad Tecnológica Santa Catarina',
                descripcion: 'Programación de entornos 3D, diseño de experiencias inmersivas, hardware VR/AR, animación.',
                duracionTsu: '1.5 años',
                duracionIng: '+1.5 años',
                perfilEgreso: [
                    'Desarrollador VR/AR',
                    'diseñador de experiencias',
                    'artista 3D'
                ],
                campoLaboral: [
                    'Entretenimiento',
                    'educación',
                    'arquitectura',
                    'salud',
                    'simuladores de entrenamiento'
                ]
            },
            // Carreras de UTL
            'agrotecnologia-utl': {
                title: 'Ingeniería en Agricultura Sustentable y Protegida',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Agricultura de precisión, manejo integrado de plagas, sistemas de riego, biotecnología agrícola.',
                duracionTsu: '2 años',
                duracionIng: '+1 año',
                perfilEgreso: [
                    'Técnico agrícola',
                    'gestor de invernaderos',
                    'consultor en agricultura sostenible'
                ],
                campoLaboral: [
                    'Empresas agrícolas',
                    'invernaderos',
                    'instituciones de innovación agrícola',
                    'ONGs ambientales'
                ]
            },
            'turismo-utl': {
                title: 'Ingeniería en Turismo Sustentable',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Desarrollo de destinos ecológicos, gestión patrimonial, marketing turístico responsable.',
                duracionTsu: '2 años',
                duracionIng: '+1 año',
                perfilEgreso: [
                    'Gestor de destinos turísticos',
                    'planificador de ecoturismo',
                    'asesor en turismo responsable'
                ],
                campoLaboral: [
                    'Agencias de turismo',
                    'entidades públicas',
                    'empresas de ecoturismo',
                    'instituciones culturales'
                ]
            },
            'logistica-utl': {
                title: 'Ingeniería en Logística y Cadena de Suministro',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Gestión de cadenas de suministro, logística internacional, optimización de rutas, almacenes inteligentes.',
                duracionTsu: '2 años',
                duracionIng: '+1 año',
                perfilEgreso: [
                    'Coordinador logístico',
                    'analista de cadena de suministro',
                    'gestor de transporte y distribución'
                ],
                campoLaboral: [
                    'Empresas de transporte',
                    'distribución',
                    'comercio exterior',
                    'sectores automotriz y retail'
                ]
            },
            'desarrollo-utl': {
                title: 'Desarrollo Comunitario',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Diseño e implementación de proyectos sociales, gestión de organizaciones civiles, participación comunitaria.',
                duracionTsu: '1.5 años',
                duracionIng: '+1.5 años',
                perfilEgreso: [
                    'Promotor social',
                    'gestor de proyectos comunitarios',
                    'coordinador de organizaciones sociales'
                ],
                campoLaboral: [
                    'ONGs',
                    'instituciones públicas',
                    'comunidades rurales',
                    'proyectos de desarrollo social'
                ]
            },
            'gastronomia-utl': {
                title: 'Gastronomía Regional',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Técnicas culinarias tradicionales y modernas, gestión de restaurantes, innovación en gastronomía local.',
                duracionTsu: '1.5 años',
                duracionIng: '+1.5 años',
                perfilEgreso: [
                    'Chef especializado',
                    'gestor gastronómico',
                    'innovador culinario',
                    'instructor de cocina'
                ],
                campoLaboral: [
                    'Restaurantes',
                    'hoteles',
                    'centros de investigación culinaria',
                    'emprendimientos gastronómicos'
                ]
            },
            'energias-utl': {
                title: 'Energías Alternativas',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Instalación de sistemas solares, eólicos, biodigestores, gestión de proyectos energéticos sostenibles.',
                duracionTsu: '1.5 años',
                duracionIng: '+1.5 años',
                perfilEgreso: [
                    'Técnico en energías renovables',
                    'instalador de sistemas solares',
                    'gestor de proyectos energéticos'
                ],
                campoLaboral: [
                    'Empresas de energías limpias',
                    'instituciones públicas',
                    'comunidades rurales',
                    'consultoras ambientales'
                ]
            },
            'ti-utl': {
                title: 'Tecnologías de la Información',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Desarrollo de software, redes, soporte técnico, soluciones digitales para el desarrollo local.',
                duracionTsu: '1.5 años',
                duracionIng: '+1.5 años',
                perfilEgreso: [
                    'Desarrollador',
                    'administrador de redes',
                    'consultor en tecnologías de la información'
                ],
                campoLaboral: [
                    'Empresas de tecnología',
                    'sectores gubernamentales',
                    'organizaciones civiles y privadas'
                ]
            },
            'adminpublica-utl': {
                title: 'Administración Pública',
                universidad: 'Universidad Tecnológica de Linares',
                descripcion: 'Gestión de recursos públicos, diseño y evaluación de políticas públicas, administración de instituciones gubernamentales, transparencia y rendición de cuentas.',
                duracionTsu: '2 años',
                duracionIng: '+1 año',
                perfilEgreso: [
                    'Administrador público',
                    'gestor de proyectos gubernamentales',
                    'asesor en políticas públicas'
                ],
                campoLaboral: [
                    'Gobiernos municipales, estatales y federales',
                    'ONG',
                    'instituciones internacionales',
                    'organizaciones civiles'
                ]
            }
        };

      // Datos de los planteles (completado para todas las carreras)
const plantelesData = {
    'desarrollo-software': {
        title: 'Desarrollo y Gestión de Software',
        description: 'Laboratorios de programación, aulas de desarrollo colaborativo, salas de servidores y espacios para proyectos en equipo.',
        images: [
            'https://www.shutterstock.com/image-photo/advanced-medical-science-laboratory-scientist-260nw-1912524370.jpg',
            'https://img.freepik.com/free-photo/programming-background-with-person-working-with-codes-computer_23-2150010125.jpg?semt=ais_hybrid&w=740&q=80',
            'https://static.vecteezy.com/system/resources/previews/006/697/113/non_2x/software-develper-working-on-laptop-at-home-office-programmer-working-develop-web-application-software-programming-concept-free-photo.jpg',
            'https://www.shutterstock.com/image-photo/advanced-medical-science-laboratory-scientist-260nw-1912524385.jpg'
        ]
    },
    'mantenimiento-industrial': {
        title: 'Mantenimiento Industrial',
        description: 'Talleres de mecánica y electricidad, laboratorios de automatización, áreas de práctica en equipos reales.',
        images: [
            'https://www.shutterstock.com/image-photo/dallas-texas-may-22nd-2023-600nw-2325207215.jpg',
            'https://www.shutterstock.com/image-photo/industrial-engineer-working-on-robot-260nw-2461722781.jpg',
            'https://www.shutterstock.com/image-photo/portrait-shot-handsome-mechanic-working-600nw-1711144648.jpg',
            'https://img.freepik.com/free-photo/industrial-worker-working-production-line-factory_342744-177.jpg'
        ]
    },
    'negocios-internacionales': {
        title: 'Negocios Internacionales',
        description: 'Áreas de simulación de negociaciones, laboratorios de comercio exterior, salas de capacitación en idiomas.',
        images: [
            'https://www.shutterstock.com/image-photo/male-mature-caucasian-ceo-businessman-600w-2142010187.jpg',
            'https://thumbs.dreamstime.com/b/business-people-negotiating-conference-room-group-58114637.jpg',
            'https://thumbs.dreamstime.com/b/businessmen-showing-papers-webcam-laptop-negotiation-meeting-room-closeup-to-having-online-office-two-managers-discussing-387578106.jpg',
            'https://thumbs.dreamstime.com/b/group-young-people-sitting-negotiation-room-debating-their-work-joy-business-partners-discussing-board-112926620.jpg'
        ]
    },
    'mecatronica': {
        title: 'Mecatrónica',
        description: 'Laboratorios de robótica, áreas de prototipado, talleres de electrónica y mecánica.',
        images: [
            'https://www.shutterstock.com/image-photo/industrial-programmable-robotic-arm-factory-260nw-2242349339.jpg',
            'https://media.istockphoto.com/id/2084424942/photo/a-female-mechatronics-engineer-is-working-with-a-robotic-arm-prototype-to-examine-new.jpg?s=612x612&w=0&k=20&c=8ihCJ7CzRgnZMlXN8X66ZR0inZS1tdyZ_D-mYrPrapk=',
            'https://static.vecteezy.com/system/resources/thumbnails/070/981/748/small/various-mechanical-parts-and-tools-are-arranged-meticulously-on-a-workbench-in-a-workshop-precision-equipment-is-ready-for-assembly-and-engineering-tasks-illuminated-by-overhead-lights-photo.jpeg',
            'https://media.istockphoto.com/id/1330931321/photo/mechatronics-engineering-in-process-experienced-engineer-working-on-new-automated-robotic.jpg?s=612x612&w=0&k=20&c=kP-W_IWtrL0nCwqLdIRv0dCInP3YDpLkWRIKBuAVn3o='
        ]
    },
    'procesos-productivos': {
        title: 'Procesos Productivos',
        description: 'Laboratorios de control de calidad, simuladores de procesos, áreas de análisis y medición.',
        images: [
            'https://www.shutterstock.com/image-photo/quality-control-officer-inspecting-raw-260nw-2599932405.jpg',
            'https://www.shutterstock.com/image-photo/hygiene-staff-worker-foods-drinks-260nw-2393015413.jpg',
            'https://thumbs.dreamstime.com/b/food-quality-control-concept-expert-inspecting-specimens-groceries-laboratory-148050380.jpg',
            'https://www.shutterstock.com/image-photo/concept-food-industry-banner-factory-260nw-1845178195.jpg'
        ]
    },
    'lengua-inglesa': {
        title: 'Lengua Inglesa (Bilingüe)',
        description: 'Aulas multimedia, laboratorios de idiomas, salas de interpretación, espacios culturales bilingües.',
        images: [
            'https://www.shutterstock.com/image-photo/smiling-young-male-teacher-helping-600nw-2483441623.jpg',
            'https://media.istockphoto.com/id/953264308/photo/learn-english-note-at-wooden-background-with-teachers-glasses.jpg?s=612x612&w=0&k=20&c=S2fmg6b_1CrCwzsGKP_YxVaGA0jHYAyxbJfHvnORFlQ=',
            'https://img.freepik.com/free-photo/kids-classroom-taking-english-class_23-2149402668.jpg',
            'https://media.istockphoto.com/id/184106979/photo/classroom-slide-composited-in.jpg?s=612x612&w=0&k=20&c=vXKLTD-Bcbix3vTcpo1jzixBHQ74Z3yoV6sBdpW4YPE='
        ]
    },
    'ia-utsc': {
        title: 'Ingeniería en Tecnologías de la Información e Innovación Digital',
        description: 'Laboratorios de programación, centros de datos, espacios de innovación y colaboración.',
        images: [
            'https://static.vecteezy.com/system/resources/previews/037/996/745/non_2x/ai-generated-sustainable-technology-diverse-team-innovating-in-green-energy-lab-photo.jpg',
            'https://www.shutterstock.com/image-photo/tablet-laptop-woman-scientist-lab-260nw-2422946607.jpg',
            'https://www.shutterstock.com/image-photo/pharmaceutical-laboratory-young-male-scientist-260nw-2556717801.jpg',
            'https://img.freepik.com/premium-vector/design-digital-innovation-lab-logo-white-background_579306-9365.jpg'
        ]
    },
    'ciberseguridad-utsc': {
        title: 'Ingeniería en Ciberseguridad',
        description: 'Redes aisladas, laboratorios de hacking ético, plataformas de simulación de ataques.',
        images: [
            'https://www.shutterstock.com/image-photo/side-view-hacker-using-computer-260nw-1156539508.jpg',
            'https://media.istockphoto.com/id/958989154/photo/ethical-hacking-concept-with-faceless-hooded-male-person.jpg?s=170667a&w=is&k=20&c=Z9E-7EuSTkxRRNgwbkzu8f8re-W5bGI5QVAHh91HRNA=',
            'https://t4.ftcdn.net/jpg/02/05/93/21/360_F_205932110_IWiDmketVT703mNPZ8eSn76Sa25QoSYw.jpg',
            'https://www.shutterstock.com/image-photo/security-hack-threats-data-leaks-260nw-2331750317.jpg'
        ]
    },
    'energias-utsc': {
        title: 'Ingeniería en Energías Renovables',
        description: 'Laboratorios de energías sostenibles, áreas de simulación, talleres en campo.',
        images: [
            'https://t4.ftcdn.net/jpg/05/08/05/97/360_F_508059717_UR8jns4nwJZm9VTCWo1TNLV3h8JXU2DC.jpg',
            'https://media.istockphoto.com/id/489193525/photo/solar-panels-and-wind-generators-under-blue-sky-on-sunset.jpg?s=612x612&w=0&k=20&c=hIithVnTA3vKOYPa-Okn8qSQunI1OAhGR_tH-NZvqdw=',
            'https://static.vecteezy.com/system/resources/previews/008/563/432/non_2x/esg-banners-environment-society-and-governance-hand-holding-light-bulb-with-renewable-energy-icon-revolving-revenue-photo.jpg',
            'https://media.istockphoto.com/id/2156966176/photo/environmental-concept-with-hand-holding-planet-earth-showing-sustainable-and-eco-friendly.jpg?s=612x612&w=0&k=20&c=sowge6N0GcisgxPq-QmJBS5RBQ0ZmEiVQap5cIytWWU='
        ]
    },
    'biotecnologia-utsc': {
        title: 'Ingeniería en Biotecnología',
        description: 'Laboratorios especializados en biología molecular, áreas de cultivo y fermentación.',
        images: [
            'https://media.istockphoto.com/id/171591485/photo/group-of-scientist-in-laboratory.jpg?s=612x612&w=0&k=20&c=8_feJDq0zslWqzAkQ-WVcmEMC8CTVLFxHfoi3FJ4o2k=',
            'https://www.shutterstock.com/image-photo/close-scientist-hands-holding-test-600w-2431314377.jpg',
            'https://media.istockphoto.com/id/477013712/photo/scientist-using-protective-robber-gloves-for-handling-substances-and-experiments.jpg?s=612x612&w=0&k=20&c=y8qCj3Ok5JwvNz0AgHPXuujoNpnUapzEZ7NkOkyxHqA=',
            'https://www.shutterstock.com/image-photo/medicine-development-laboratory-asian-female-600nw-2456036585.jpg'
        ]
    },
    'iot-utsc': {
        title: 'IoT y Sistemas Embebidos',
        description: 'Laboratorios de electrónica, estaciones de prototipado, plataformas de desarrollo IoT.',
        images: [
            'https://www.shutterstock.com/image-photo/closeup-printed-circuit-board-pcb-260nw-2530139329.jpg',
            'https://st4.depositphotos.com/2978065/24062/i/450/depositphotos_240620438-stock-photo-render-cpu-central-processor-unit.jpg',
            'https://www.shutterstock.com/image-illustration/intricate-illustration-showcasing-advanced-glowing-260nw-2439656221.jpg',
            'https://cdn.pixabay.com/photo/2017/03/23/12/32/arduino-2168193_1280.png'
        ]
    },
    'datascience-utsc': {
        title: 'Data Science',
        description: 'Salas de análisis, servidores de alto rendimiento, software de análisis avanzado.',
        images: [
            'https://www.shutterstock.com/image-photo/server-racks-cabinets-full-hard-600nw-2306905651.jpg',
            'https://media.istockphoto.com/id/1350722246/photo/server-room-background.jpg?s=170667a&w=is&k=20&c=PT0piukz6GO_RhaGY2pmyWqdLg-a8uXO0Hi4q9qGdYM=',
            'https://www.shutterstock.com/image-photo/supercomputer-advanced-cloud-computing-concept-600nw-2306905657.jpg',
            'https://www.shutterstock.com/image-illustration/countless-modern-server-cabinets-render-600nw-2356888839.jpg'
        ]
    },
    'rv-utsc': {
        title: 'Realidad Virtual y Aumentada',
        description: 'Estudios de captura de movimiento, laboratorios de modelado 3D, espacios de programación.',
        images: [
            'https://thumbs.dreamstime.com/b/person-fully-engaged-virtual-reality-experience-using-motion-capture-equipment-sensors-their-body-gloves-391002136.jpg',
            'https://thumbs.dreamstime.com/b/person-wearing-motion-capture-suit-stands-studio-facing-projection-screen-displaying-grid-pattern-321815650.jpg',
            'https://thumbs.dreamstime.com/b/person-wearing-motion-capture-suit-vr-headset-stands-against-green-screen-background-ai-generated-person-motion-325427104.jpg',
            'https://media.istockphoto.com/id/1324380506/photo/people-with-vr-grasses-playing-virtual-reality-game-future-digital-technology-and-3d-virtual.jpg?s=612x612&w=0&k=20&c=I_9fnEi1hNHFwy0qe8g7V1ZQJmgyKEDOSDJonScTSMU='
        ]
    },
    'agrotecnologia-utl': {
        title: 'Ingeniería en Agricultura Sustentable y Protegida',
        description: 'Invernaderos inteligentes, laboratorios de agricultura de precisión y campos experimentales para la aplicación práctica de tecnologías agropecuarias.',
        images: [
            'https://www.shutterstock.com/image-photo/organic-hydroponic-vegetable-growing-greenhouse-260nw-2479106433.jpg',
            'https://media.istockphoto.com/id/1265704346/photo/organic-greenhouse.jpg?s=612x612&w=0&k=20&c=3UYDiVDVED2i2XvUvf0iMxydTNp152-rkehaEvLA6uw=',
            'https://static.vecteezy.com/system/resources/thumbnails/066/755/731/small_2x/farmer-using-a-digital-tablet-to-manage-smart-irrigation-and-crop-growth-in-a-modern-greenhouse-photo.jpeg',
            'https://thumbs.dreamstime.com/b/smart-greenhouse-control-parameters-greenhouse-smart-greenhouse-control-parameters-greenhouse-smart-396709009.jpg'
        ]
    },
    'turismo-utl': {
        title: 'Ingeniería en Turismo Sustentable',
        description: 'Salas de simulación turística, espacios de interpretación cultural y laboratorios de gestión de destinos para el desarrollo de proyectos turísticos responsables.',
        images: [
            'https://media.istockphoto.com/id/1031430214/photo/young-woman-kayaking-through-the-the-backwaters-of-monroe-island.jpg?s=612x612&w=0&k=20&c=kbv2s1kknMzJgk8Nd-W2VNIf0AFx48YtCqygtI3Ppos=',
            'https://media.istockphoto.com/id/1372488167/photo/a-lake-in-the-shape-of-an-airplane-in-the-middle-of-untouched-nature-a-concept-illustrating.jpg?s=612x612&w=0&k=20&c=d-2X_9pmP_RRfvNfTsptxluq5mCcF_ahUZhMi6ESlow=',
            'https://www.shutterstock.com/image-vector/sustainable-tourism-ecological-responsible-travel-260nw-1982804408.jpg',
            'https://www.shutterstock.com/image-vector/sustainable-tourism-set-ecotourism-ecofriendly-260nw-2378753787.jpg'
        ]
    },
    'logistica-utl': {
        title: 'Ingeniería en Logística y Cadena de Suministro',
        description: 'Centros de simulación logística, almacenes modelo y laboratorios de optimización de rutas para la gestión eficiente de cadenas de suministro.',
        images: [
            'https://www.shutterstock.com/image-vector/automated-warehouse-robotic-autonomous-robot-260nw-2480187763.jpg',
            'https://media.istockphoto.com/id/1581309911/photo/high-angle-view-of-a-warehouse-manager-walking-with-foremen-checking-stock-on-racks.jpg?s=612x612&w=0&k=20&c=JCF-qJiwTUAhD8sEgEhHNcJZvxy4JtIWHYeQLKcbcKk=',
            'https://www.shutterstock.com/image-photo/defocused-background-futuristic-warehouse-interior-260nw-2632606263.jpg',
            'https://www.shutterstock.com/image-photo/three-warehouse-workers-safety-vests-600w-2576831333.jpg'
        ]
    },
    'desarrollo-utl': {
        title: 'Desarrollo Comunitario',
        description: 'Espacios de planificación comunitaria, salas de talleres participativos y espacios de proyectos sociales para el diseño e implementación de iniciativas locales.',
        images: [
            'https://media.istockphoto.com/id/2094337676/photo/diverse-team-working-together-in-modern-co-working-space.jpg?s=612x612&w=0&k=20&c=EvWROZsfro1ghOVViXVj-tKS364-NeabwNNYkyvhxoY=',
            'https://www.shutterstock.com/image-photo/group-senior-adults-actively-participating-600nw-2455512829.jpg',
            'https://static.vecteezy.com/system/resources/thumbnails/071/884/290/small_2x/diverse-community-enjoying-a-gardening-workshop-outdoors-photo.jpg',
            'https://media.istockphoto.com/id/1438225124/photo/mid-adult-woman-applauding-during-a-presentation.jpg?s=612x612&w=0&k=20&c=L9w4j54ADE5EK21UQlQtKWnG-2ViKu7tHHfp9LlU0rU='
        ]
    },
    'gastronomia-utl': {
        title: 'Gastronomía Regional',
        description: 'Cocinas especializadas, laboratorios de catación y espacios de innovación culinaria para la preservación y evolución de la gastronomía local.',
        images: [
            'https://img.freepik.com/premium-photo/chef-experimenting-with-new-flavors-modern-kitchen-lab-candid-daily-environment-routine-o_980716-109063.jpg?w=360',
            'https://thumbs.dreamstime.com/b/food-scientist-lab-coat-inspects-vibrant-tomatoes-broccoli-professional-kitchen-environment-focusing-quality-control-341089430.jpg',
            'https://thumbs.dreamstime.com/b/cultured-meat-packs-kitchen-counter-innovative-food-ai-generated-405105780.jpg',
            'https://media.istockphoto.com/id/1327977778/photo/two-female-scientist-cooking-genetic-meat.jpg?s=612x612&w=0&k=20&c=XZ4ihze2dDtqDkHdRjNitw4GyqEKOan1TO1QymlY9Co='
        ]
    },
    'energias-utl': {
        title: 'Energías Alternativas',
        description: 'Instalaciones para energías alternativas con biodigestores, paneles solares comunitarios y laboratorios de eficiencia energética para proyectos rurales.',
        images: [
            'https://img.freepik.com/premium-photo/aerial-view-biogas-plant-facility-with-solar-panels-rural-landscape-renewable-energy-concept_114541-14640.jpg',
            'https://img.freepik.com/premium-photo/solar-panels-livestock-farm-providing-clean-sustainable-energy_269655-74997.jpg',
            'https://media.istockphoto.com/id/1170098138/photo/solar-panels-fields-on-the-green-hills.jpg?s=612x612&w=0&k=20&c=xYjwuTPHyIHsRzj8NAABoGfE5ZpLq2zJbfXi-oJrqQo=',
            'https://static.vecteezy.com/system/resources/previews/068/299/136/non_2x/advanced-solar-research-laboratory-featuring-solar-panels-and-high-tech-equipment-on-display-in-a-modern-scientific-environment-with-natural-light-and-engineering-focus-for-sustainable-energy-photo.jpeg'
        ]
    },
    'ti-utl': {
        title: 'Tecnologías de la Información',
        description: 'Laboratorios de TI regionales con servidores locales, estaciones de desarrollo y centros de capacitación digital para soluciones adaptadas a PyMEs y municipios.',
        images: [
            'https://media.istockphoto.com/id/527034734/photo/huge-data-center.jpg?s=612x612&w=0&k=20&c=etdY4vrRFufNhyeMRCQKWr7jEMAkleCVq9GnPYikalc=',
            'https://www.shutterstock.com/image-photo/network-servers-data-center-shallow-600nw-102675134.jpg',
            'https://media.istockphoto.com/id/477130337/photo/network-servers-racks.jpg?s=612x612&w=0&k=20&c=vCw92YUUOS4HpehQc4Zv8mgbXs-20ob6QgjA1zdODeg=',
            'https://www.shutterstock.com/image-photo/hightech-bright-data-center-computers-600nw-1913228191.jpg'
        ]
    },
    'adminpublica-utl': {
        title: 'Administración Pública',
        description: 'Aulas de simulación gubernamental, laboratorios de políticas públicas y espacios de análisis social para la formación en gestión y transparencia administrativa.',
        images: [
            'https://www.shutterstock.com/image-photo/audience-listening-instructor-employee-education-260nw-2354268499.jpg',
            'https://www.shutterstock.com/image-photo/senior-woman-handing-papers-official-260nw-2630234759.jpg',
            'https://img.freepik.com/free-photo/vintage-style-people-working-office-with-computers_23-2149850976.jpg?semt=ais_hybrid&w=740&q=80',
            'https://www.shutterstock.com/image-photo/digital-government-online-public-services-260nw-2603198411.jpg'
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