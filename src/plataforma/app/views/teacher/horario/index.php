<?php
// Variables esperadas desde el controlador:
// $user, $schedule
// $schedule debe ser un array con la estructura: [dia => [hora => materia]]
?>

<div class="py-8 max-w-7xl mx-auto">
    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white mb-8" data-aos="fade-up">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/20 rounded-full">
                <i data-feather="calendar" class="w-8 h-8"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-1">Mi Horario</h2>
                <p class="opacity-900">Consulta tus clases y horarios de la semana</p>
            </div>
        </div>
    </div>

    <!-- Selector de semana -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-4 mb-6 flex items-center justify-between" data-aos="fade-up">
        <div class="flex items-center gap-2">
            <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700 transition-colors">
                <i data-feather="chevron-left" class="w-5 h-5"></i>
            </button>
            <h3 class="text-lg font-medium text-gray-800 dark:text-white">
                Semana del 15 al 21 de mayo, 2023
            </h3>
            <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700 transition-colors">
                <i data-feather="chevron-right" class="w-5 h-5"></i>
            </button>
        </div>
        <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors flex items-center">
            <i data-feather="download" class="w-4 h-4 mr-2"></i>
            Descargar horario
        </button>
    </div>

    <!-- Tabla de horario -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg overflow-hidden" data-aos="fade-up">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-neutral-700">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Hora
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Lunes
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Martes
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Miércoles
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Jueves
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Viernes
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Sábado
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Fila 7:00 - 8:30 -->
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                            7:00 - 8:30
                        </td>
                        <td class="px-4 py-3 text-center">
                            <!-- Vacío -->
                        </td>
                        <td class="px-4 py-3 text-center">
                            <!-- Vacío -->
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-2 border-l-4 border-blue-500">
                                <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300">Matemáticas III</h4>
                                <p class="text-xs text-blue-600 dark:text-blue-400">Aula 201</p>
                                <p class="text-xs text-blue-600 dark:text-blue-400">Prof. García</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <!-- Vacío -->
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-2 border-l-4 border-green-500">
                                <h4 class="text-sm font-medium text-green-800 dark:text-green-300">Física II</h4>
                                <p class="text-xs text-green-600 dark:text-green-400">Lab. Física</p>
                                <p class="text-xs text-green-600 dark:text-green-400">Prof. Martínez</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <!-- Vacío -->
                        </td>
                    </tr>

                    <!-- Fila 8:30 - 10:00 -->
                    <tr class="bg-gray-50 dark:bg-neutral-700/20">
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                            8:30 - 10:00
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-2 border-l-4 border-purple-500">
                                <h4 class="text-sm font-medium text-purple-800 dark:text-purple-300">Programación Web</h4>
                                <p class="text-xs text-purple-600 dark:text-purple-400">Aula 305</p>
                                <p class="text-xs text-purple-600 dark:text-purple-400">Prof. López</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-2 border-l-4 border-blue-500">
                                <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300">Matemáticas III</h4>
                                <p class="text-xs text-blue-600 dark:text-blue-400">Aula 201</p>
                                <p class="text-xs text-blue-600 dark:text-blue-400">Prof. García</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-2 border-l-4 border-purple-500">
                                <h4 class="text-sm font-medium text-purple-800 dark:text-purple-300">Programación Web</h4>
                                <p class="text-xs text-purple-600 dark:text-purple-400">Aula 305</p>
                                <p class="text-xs text-purple-600 dark:text-purple-400">Prof. López</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-2 border-l-4 border-blue-500">
                                <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300">Matemáticas III</h4>
                                <p class="text-xs text-blue-600 dark:text-blue-400">Aula 201</p>
                                <p class="text-xs text-blue-600 dark:text-blue-400">Prof. García</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-2 border-l-4 border-green-500">
                                <h4 class="text-sm font-medium text-green-800 dark:text-green-300">Física II</h4>
                                <p class="text-xs text-green-600 dark:text-green-400">Lab. Física</p>
                                <p class="text-xs text-green-600 dark:text-green-400">Prof. Martínez</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <!-- Vacío -->
                        </td>
                    </tr>

                    <!-- Fila 10:00 - 11:30 -->
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                            10:00 - 11:30
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-2 border-l-4 border-amber-500">
                                <h4 class="text-sm font-medium text-amber-800 dark:text-amber-300">Bases de Datos</h4>
                                <p class="text-xs text-amber-600 dark:text-amber-400">Aula 203</p>
                                <p class="text-xs text-amber-600 dark:text-amber-400">Prof. Hernández</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-2 border-l-4 border-amber-500">
                                <h4 class="text-sm font-medium text-amber-800 dark:text-amber-300">Bases de Datos</h4>
                                <p class="text-xs text-amber-600 dark:text-amber-400">Aula 203</p>
                                <p class="text-xs text-amber-600 dark:text-amber-400">Prof. Hernández</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-2 border-l-4 border-green-500">
                                <h4 class="text-sm font-medium text-green-800 dark:text-green-300">Física II</h4>
                                <p class="text-xs text-green-600 dark:text-green-400">Lab. Física</p>
                                <p class="text-xs text-green-600 dark:text-green-400">Prof. Martínez</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-2 border-l-4 border-amber-500">
                                <h4 class="text-sm font-medium text-amber-800 dark:text-amber-300">Bases de Datos</h4>
                                <p class="text-xs text-amber-600 dark:text-amber-400">Aula 203</p>
                                <p class="text-xs text-amber-600 dark:text-amber-400">Prof. Hernández</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-2 border-l-4 border-purple-500">
                                <h4 class="text-sm font-medium text-purple-800 dark:text-purple-300">Programación Web</h4>
                                <p class="text-xs text-purple-600 dark:text-purple-400">Aula 305</p>
                                <p class="text-xs text-purple-600 dark:text-purple-400">Prof. López</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <!-- Vacío -->
                        </td>
                    </tr>

                    <!-- Fila 11:30 - 13:00 -->
                    <tr class="bg-gray-50 dark:bg-neutral-700/20">
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                            11:30 - 13:00
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-2 border-l-4 border-red-500">
                                <h4 class="text-sm font-medium text-red-800 dark:text-red-300">Inglés IV</h4>
                                <p class="text-xs text-red-600 dark:text-red-400">Aula 102</p>
                                <p class="text-xs text-red-600 dark:text-red-400">Prof. Smith</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-2 border-l-4 border-red-500">
                                <h4 class="text-sm font-medium text-red-800 dark:text-red-300">Inglés IV</h4>
                                <p class="text-xs text-red-600 dark:text-red-400">Aula 102</p>
                                <p class="text-xs text-red-600 dark:text-red-400">Prof. Smith</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-2 border-l-4 border-amber-500">
                                <h4 class="text-sm font-medium text-amber-800 dark:text-amber-300">Bases de Datos</h4>
                                <p class="text-xs text-amber-600 dark:text-amber-400">Aula 203</p>
                                <p class="text-xs text-amber-600 dark:text-amber-400">Prof. Hernández</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-2 border-l-4 border-red-500">
                                <h4 class="text-sm font-medium text-red-800 dark:text-red-300">Inglés IV</h4>
                                <p class="text-xs text-red-600 dark:text-red-400">Aula 102</p>
                                <p class="text-xs text-red-600 dark:text-red-400">Prof. Smith</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-2 border-l-4 border-blue-500">
                                <h4 class="text-sm font-medium text-blue-800 dark:text-blue-300">Matemáticas III</h4>
                                <p class="text-xs text-blue-600 dark:text-blue-400">Aula 201</p>
                                <p class="text-xs text-blue-600 dark:text-blue-400">Prof. García</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <!-- Vacío -->
                        </td>
                    </tr>

                    <!-- Fila 13:00 - 14:30 (Receso) -->
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap bg-orange-50 dark:bg-orange-900/20">
                            13:00 - 14:30
                        </td>
                        <td class="px-4 py-3 text-center bg-orange-50 dark:bg-orange-900/20">
                            <div class="text-sm font-medium text-orange-600 dark:text-orange-400">Receso</div>
                        </td>
                        <td class="px-4 py-3 text-center bg-orange-50 dark:bg-orange-900/20">
                            <div class="text-sm font-medium text-orange-600 dark:text-orange-400">Receso</div>
                        </td>
                        <td class="px-4 py-3 text-center bg-orange-50 dark:bg-orange-900/20">
                            <div class="text-sm font-medium text-orange-600 dark:text-orange-400">Receso</div>
                        </td>
                        <td class="px-4 py-3 text-center bg-orange-50 dark:bg-orange-900/20">
                            <div class="text-sm font-medium text-orange-600 dark:text-orange-400">Receso</div>
                        </td>
                        <td class="px-4 py-3 text-center bg-orange-50 dark:bg-orange-900/20">
                            <div class="text-sm font-medium text-orange-600 dark:text-orange-400">Receso</div>
                        </td>
                        <td class="px-4 py-3 text-center bg-orange-50 dark:bg-orange-900/20">
                            <div class="text-sm font-medium text-orange-600 dark:text-orange-400">Receso</div>
                        </td>
                    </tr>

                    <!-- Fila 14:30 - 16:00 -->
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                            14:30 - 16:00
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-2 border-l-4 border-indigo-500">
                                <h4 class="text-sm font-medium text-indigo-800 dark:text-indigo-300">Sistemas Operativos</h4>
                                <p class="text-xs text-indigo-600 dark:text-indigo-400">Lab. Computación</p>
                                <p class="text-xs text-indigo-600 dark:text-indigo-400">Prof. Ramírez</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-2 border-l-4 border-indigo-500">
                                <h4 class="text-sm font-medium text-indigo-800 dark:text-indigo-300">Sistemas Operativos</h4>
                                <p class="text-xs text-indigo-600 dark:text-indigo-400">Lab. Computación</p>
                                <p class="text-xs text-indigo-600 dark:text-indigo-400">Prof. Ramírez</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-2 border-l-4 border-red-500">
                                <h4 class="text-sm font-medium text-red-800 dark:text-red-300">Inglés IV</h4>
                                <p class="text-xs text-red-600 dark:text-red-400">Aula 102</p>
                                <p class="text-xs text-red-600 dark:text-red-400">Prof. Smith</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-2 border-l-4 border-indigo-500">
                                <h4 class="text-sm font-medium text-indigo-800 dark:text-indigo-300">Sistemas Operativos</h4>
                                <p class="text-xs text-indigo-600 dark:text-indigo-400">Lab. Computación</p>
                                <p class="text-xs text-indigo-600 dark:text-indigo-400">Prof. Ramírez</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-amber-50 dark:bg-amber-900/20 rounded-lg p-2 border-l-4 border-amber-500">
                                <h4 class="text-sm font-medium text-amber-800 dark:text-amber-300">Bases de Datos</h4>
                                <p class="text-xs text-amber-600 dark:text-amber-400">Aula 203</p>
                                <p class="text-xs text-amber-600 dark:text-amber-400">Prof. Hernández</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <!-- Vacío -->
                        </td>
                    </tr>

                    <!-- Fila 16:00 - 17:30 -->
                    <tr class="bg-gray-50 dark:bg-neutral-700/20">
                        <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                            16:00 - 17:30
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-teal-50 dark:bg-teal-900/20 rounded-lg p-2 border-l-4 border-teal-500">
                                <h4 class="text-sm font-medium text-teal-800 dark:text-teal-300">Redes</h4>
                                <p class="text-xs text-teal-600 dark:text-teal-400">Lab. Redes</p>
                                <p class="text-xs text-teal-600 dark:text-teal-400">Prof. Torres</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-teal-50 dark:bg-teal-900/20 rounded-lg p-2 border-l-4 border-teal-500">
                                <h4 class="text-sm font-medium text-teal-800 dark:text-teal-300">Redes</h4>
                                <p class="text-xs text-teal-600 dark:text-teal-400">Lab. Redes</p>
                                <p class="text-xs text-teal-600 dark:text-teal-400">Prof. Torres</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-2 border-l-4 border-indigo-500">
                                <h4 class="text-sm font-medium text-indigo-800 dark:text-indigo-300">Sistemas Operativos</h4>
                                <p class="text-xs text-indigo-600 dark:text-indigo-400">Lab. Computación</p>
                                <p class="text-xs text-indigo-600 dark:text-indigo-400">Prof. Ramírez</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-teal-50 dark:bg-teal-900/20 rounded-lg p-2 border-l-4 border-teal-500">
                                <h4 class="text-sm font-medium text-teal-800 dark:text-teal-300">Redes</h4>
                                <p class="text-xs text-teal-600 dark:text-teal-400">Lab. Redes</p>
                                <p class="text-xs text-teal-600 dark:text-teal-400">Prof. Torres</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-2 border-l-4 border-green-500">
                                <h4 class="text-sm font-medium text-green-800 dark:text-green-300">Física II</h4>
                                <p class="text-xs text-green-600 dark:text-green-400">Lab. Física</p>
                                <p class="text-xs text-green-600 dark:text-green-400">Prof. Martínez</p>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <!-- Vacío -->
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Leyenda -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg p-6 mt-6" data-aos="fade-up" data-aos-delay="100">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Leyenda</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="flex items-center">
                <div class="w-4 h-4 bg-blue-500 rounded mr-2"></div>
                <span class="text-sm text-gray-600 dark:text-gray-300">Matemáticas III</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-purple-500 rounded mr-2"></div>
                <span class="text-sm text-gray-600 dark:text-gray-300">Programación Web</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-amber-500 rounded mr-2"></div>
                <span class="text-sm text-gray-600 dark:text-gray-300">Bases de Datos</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                <span class="text-sm text-gray-600 dark:text-gray-300">Física II</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-red-500 rounded mr-2"></div>
                <span class="text-sm text-gray-600 dark:text-gray-300">Inglés IV</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-indigo-500 rounded mr-2"></div>
                <span class="text-sm text-gray-600 dark:text-gray-300">Sistemas Operativos</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-teal-500 rounded mr-2"></div>
                <span class="text-sm text-gray-600 dark:text-gray-300">Redes</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-orange-500 rounded mr-2"></div>
                <span class="text-sm text-gray-600 dark:text-gray-300">Receso</span>
            </div>
        </div>
    </div>
</div>

<script>
    AOS.init();
    feather.replace();
</script>
