<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carreras Universitarias - UTSC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <?php include 'navbar.php'; ?>
    <style>
        :root {
            --ut-green-900: #0c4f2e;
            --ut-green-800: #12663a;
            --ut-green-700: #177a46;
            --ut-green-600: #1e8c51;
            --ut-green-500: #28a55f;
            --ut-green-100: #e6f6ed;
            --ut-green-50: #f0faf4;
        }

        .career-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .career-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s ease;
        }

        .career-card:hover::before {
            left: 100%;
        }

        .career-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .conocer-carrera-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
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
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        #carreraModal {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #carreraModal:not(.hidden) {
            opacity: 1;
        }

        #carreraModal > div {
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        #carreraModal:not(.hidden) > div {
            transform: scale(1);
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

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(40, 165, 95, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(40, 165, 95, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(40, 165, 95, 0);
            }
        }

        .bg-green-500:hover {
            animation: pulse 1.5s infinite;
        }

        #modalCarreraContent::-webkit-scrollbar {
            width: 6px;
        }

        #modalCarreraContent::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        #modalCarreraContent::-webkit-scrollbar-thumb {
            background: var(--ut-green-500);
            border-radius: 3px;
        }

        #modalCarreraContent::-webkit-scrollbar-thumb:hover {
            background: var(--ut-green-600);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-white">
    <!-- Sección de Carreras Universitarias -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Encabezado Principal -->
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
                    Nuestras 
                    <span class="text-green-600">Carreras</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Descubre la oferta educativa de nuestras instituciones hermanas
                </p>
            </div>

            <!-- Universidad Tecnológica Montemorelos -->
            <div class="mb-20">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i data-feather="book" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Universidad Tecnológica Montemorelos</h3>
                        <p class="text-gray-600">Excelencia educativa con visión global</p>
                    </div>
                </div>

                <!-- Lista Horizontal de Carreras -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <!-- Desarrollo y Gestión de Software -->
                    <div class="career-card bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300">
                        <div class="h-4 bg-gradient-to-r from-blue-500 to-blue-600"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <h4 class="text-lg font-bold text-gray-900">Desarrollo y Gestión de Software</h4>
                                <span class="bg-blue-100 text-blue-600 text-xs font-semibold px-2 py-1 rounded-full">TSU/Ing</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">
                                Formación en desarrollo de software, gestión de proyectos tecnológicos y sistemas de información.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span class="flex items-center gap-1">
                                    <i data-feather="clock" class="w-4 h-4"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-feather="users" class="w-4 h-4"></i>
                                    Ingeniería: +1.5 años
                                </span>
                            </div>
                            <button class="w-full conocer-carrera-btn bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2"
                                    data-carrera="desarrollo-software">
                                <i data-feather="info" class="w-4 h-4"></i>
                                Conocer más
                            </button>
                        </div>
                    </div>

                    <!-- Mantenimiento Industrial -->
                    <div class="career-card bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300">
                        <div class="h-4 bg-gradient-to-r from-orange-500 to-orange-600"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <h4 class="text-lg font-bold text-gray-900">Mantenimiento Industrial</h4>
                                <span class="bg-orange-100 text-orange-600 text-xs font-semibold px-2 py-1 rounded-full">TSU/Ing</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">
                                Especialización en mantenimiento de sistemas industriales, automatización y gestión de procesos.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span class="flex items-center gap-1">
                                    <i data-feather="clock" class="w-4 h-4"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-feather="users" class="w-4 h-4"></i>
                                    Ingeniería: +1.5 años
                                </span>
                            </div>
                            <button class="w-full conocer-carrera-btn bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2"
                                    data-carrera="mantenimiento-industrial">
                                <i data-feather="info" class="w-4 h-4"></i>
                                Conocer más
                            </button>
                        </div>
                    </div>

                    <!-- Negocios Internacionales -->
                    <div class="career-card bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300">
                        <div class="h-4 bg-gradient-to-r from-green-500 to-green-600"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <h4 class="text-lg font-bold text-gray-900">Negocios Internacionales</h4>
                                <span class="bg-green-100 text-green-600 text-xs font-semibold px-2 py-1 rounded-full">TSU/Ing</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">
                                Formación en comercio exterior, logística internacional y gestión de negocios globales.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span class="flex items-center gap-1">
                                    <i data-feather="clock" class="w-4 h-4"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-feather="users" class="w-4 h-4"></i>
                                    Ingeniería: +1.5 años
                                </span>
                            </div>
                            <button class="w-full conocer-carrera-btn bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2"
                                    data-carrera="negocios-internacionales">
                                <i data-feather="info" class="w-4 h-4"></i>
                                Conocer más
                            </button>
                        </div>
                    </div>

                    <!-- Mecatrónica -->
                    <div class="career-card bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300">
                        <div class="h-4 bg-gradient-to-r from-purple-500 to-purple-600"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <h4 class="text-lg font-bold text-gray-900">Mecatrónica</h4>
                                <span class="bg-purple-100 text-purple-600 text-xs font-semibold px-2 py-1 rounded-full">TSU/Ing</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">
                                Integración de mecánica, electrónica e informática para el desarrollo de sistemas automatizados.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span class="flex items-center gap-1">
                                    <i data-feather="clock" class="w-4 h-4"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-feather="users" class="w-4 h-4"></i>
                                    Ingeniería: +1.5 años
                                </span>
                            </div>
                            <button class="w-full conocer-carrera-btn bg-purple-500 hover:bg-purple-600 text-white py-2 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2"
                                    data-carrera="mecatronica">
                                <i data-feather="info" class="w-4 h-4"></i>
                                Conocer más
                            </button>
                        </div>
                    </div>

                    <!-- Procesos Productivos -->
                    <div class="career-card bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300">
                        <div class="h-4 bg-gradient-to-r from-red-500 to-red-600"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <h4 class="text-lg font-bold text-gray-900">Procesos Productivos</h4>
                                <span class="bg-red-100 text-red-600 text-xs font-semibold px-2 py-1 rounded-full">TSU/Ing</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">
                                Optimización de procesos de manufactura, control de calidad y gestión de producción.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span class="flex items-center gap-1">
                                    <i data-feather="clock" class="w-4 h-4"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-feather="users" class="w-4 h-4"></i>
                                    Ingeniería: +1.5 años
                                </span>
                            </div>
                            <button class="w-full conocer-carrera-btn bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2"
                                    data-carrera="procesos-productivos">
                                <i data-feather="info" class="w-4 h-4"></i>
                                Conocer más
                            </button>
                        </div>
                    </div>

                    <!-- Lengua Inglesa -->
                    <div class="career-card bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-all duration-300">
                        <div class="h-4 bg-gradient-to-r from-yellow-500 to-yellow-600"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <h4 class="text-lg font-bold text-gray-900">Lengua Inglesa</h4>
                                <span class="bg-yellow-100 text-yellow-600 text-xs font-semibold px-2 py-1 rounded-full">TSU/Ing</span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4">
                                Dominio del idioma inglés, traducción, interpretación y enseñanza del lenguaje.
                            </p>
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span class="flex items-center gap-1">
                                    <i data-feather="clock" class="w-4 h-4"></i>
                                    TSU: 1.5 años
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-feather="users" class="w-4 h-4"></i>
                                    Ingeniería: +1.5 años
                                </span>
                            </div>
                            <button class="w-full conocer-carrera-btn bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2"
                                    data-carrera="lengua-inglesa">
                                <i data-feather="info" class="w-4 h-4"></i>
                                Conocer más
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Universidad Tecnológica Santa Catarina -->
            <div class="mb-20">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i data-feather="award" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Universidad Tecnológica Santa Catarina</h3>
                        <p class="text-gray-600">Innovación y tecnología de vanguardia</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Espacios para carreras de UTSC -->
                    <div class="bg-gray-100 rounded-2xl p-8 text-center border-2 border-dashed border-gray-300">
                        <i data-feather="plus" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                        <p class="text-gray-500">Carreras por agregar</p>
                    </div>
                    <div class="bg-gray-100 rounded-2xl p-8 text-center border-2 border-dashed border-gray-300">
                        <i data-feather="plus" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                        <p class="text-gray-500">Carreras por agregar</p>
                    </div>
                    <div class="bg-gray-100 rounded-2xl p-8 text-center border-2 border-dashed border-gray-300">
                        <i data-feather="plus" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                        <p class="text-gray-500">Carreras por agregar</p>
                    </div>
                </div>
            </div>

            <!-- Universidad Tecnológica de Linares -->
            <div class="mb-20">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i data-feather="graduation-cap" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Universidad Tecnológica de Linares</h3>
                        <p class="text-gray-600">Desarrollo regional con calidad educativa</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Espacios para carreras de UTL -->
                    <div class="bg-gray-100 rounded-2xl p-8 text-center border-2 border-dashed border-gray-300">
                        <i data-feather="plus" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                        <p class="text-gray-500">Carreras por agregar</p>
                    </div>
                    <div class="bg-gray-100 rounded-2xl p-8 text-center border-2 border-dashed border-gray-300">
                        <i data-feather="plus" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                        <p class="text-gray-500">Carreras por agregar</p>
                    </div>
                    <div class="bg-gray-100 rounded-2xl p-8 text-center border-2 border-dashed border-gray-300">
                        <i data-feather="plus" class="w-12 h-12 text-gray-400 mx-auto mb-4"></i>
                        <p class="text-gray-500">Carreras por agregar</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal para información de carreras -->
    <div id="carreraModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-hidden">
            <!-- Header del modal -->
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h3 id="modalCarreraTitle" class="text-2xl font-bold text-gray-900">Información de la Carrera</h3>
                <button id="closeCarreraModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i data-feather="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Contenido del modal -->
            <div class="p-6 overflow-y-auto max-h-[60vh]">
                <div id="modalCarreraContent">
                    <!-- El contenido se cargará dinámicamente -->
                </div>
            </div>
            
            <!-- Footer del modal -->
            <div class="p-6 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row gap-4">
                    <button class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-6 rounded-xl font-semibold text-gray-700 border-2 border-gray-300 hover:border-gray-400 transition-colors">
                        <i data-feather="download" class="w-5 h-5"></i>
                        Descargar Plan de Estudios
                    </button>
                    <button class="flex-1 inline-flex items-center justify-center gap-2 py-3 px-6 rounded-xl font-semibold text-white bg-green-500 hover:bg-green-600 transition-colors">
                        <i data-feather="send" class="w-5 h-5"></i>
                        Solicitar Información
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                    'Implementar metodologías ágiles'
                ],
                campoLaboral: [
                    'Desarrollador Full Stack',
                    'Gestor de Proyectos TI',
                    'Administrador de Bases de Datos',
                    'Consultor Tecnológico'
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
                    'Seguridad industrial'
                ],
                campoLaboral: [
                    'Supervisor de Mantenimiento',
                    'Técnico en Automatización',
                    'Gestor de Procesos',
                    'Consultor Industrial'
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
                    'Marketing global'
                ],
                campoLaboral: [
                    'Ejecutivo de Comercio Exterior',
                    'Agente Aduanal',
                    'Consultor Internacional',
                    'Gestor Logístico'
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
                    'Control de procesos'
                ],
                campoLaboral: [
                    'Ingeniero de Automatización',
                    'Técnico en Robótica',
                    'Diseñador Mecatrónico',
                    'Supervisor de Producción'
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
                    'Lean manufacturing'
                ],
                campoLaboral: [
                    'Ingeniero de Procesos',
                    'Supervisor de Producción',
                    'Consultor de Calidad',
                    'Gestor Operativo'
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
                    'Comunicación intercultural'
                ],
                campoLaboral: [
                    'Traductor/Intérprete',
                    'Profesor de Inglés',
                    'Guía Turístico Bilingüe',
                    'Ejecutivo Internacional'
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
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Descripción</h4>
                                <p class="text-gray-600">${carrera.descripcion}</p>
                            </div>
                            
                            <!-- Duración -->
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h5 class="font-semibold text-blue-900 mb-2">TSU (Técnico Superior Universitario)</h5>
                                    <p class="text-blue-700">${carrera.duracionTsu}</p>
                                </div>
                                <div class="bg-green-50 p-4 rounded-lg">
                                    <h5 class="font-semibold text-green-900 mb-2">Ingeniería</h5>
                                    <p class="text-green-700">${carrera.duracionIng}</p>
                                </div>
                            </div>
                            
                            <!-- Perfil de Egreso -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-3">Perfil de Egreso</h4>
                                <ul class="grid md:grid-cols-2 gap-2">
                                    ${carrera.perfilEgreso.map(item => `
                                        <li class="flex items-center gap-2 text-gray-600">
                                            <i data-feather="check" class="w-4 h-4 text-green-500"></i>
                                            ${item}
                                        </li>
                                    `).join('')}
                                </ul>
                            </div>
                            
                            <!-- Campo Laboral -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-3">Campo Laboral</h4>
                                <div class="flex flex-wrap gap-2">
                                    ${carrera.campoLaboral.map(item => `
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                            ${item}
                                        </span>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    `;
                    
                    feather.replace();
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
        });
    </script>
</body>
</html>