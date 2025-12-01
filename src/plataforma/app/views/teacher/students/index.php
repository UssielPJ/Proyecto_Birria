<?php
/** @var array|\stdClass[] $grupos */
$esc = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
?>

<style>
    /* ===== Loader barra ===== */
    #loaderBar {
        position: relative;
        overflow: hidden;
    }

    #loaderBarInner {
        height: 100%;
        width: 35%;
        transform: translateX(-150%);
        animation: loader-slide 1.3s ease-in-out infinite;
    }

    @keyframes loader-slide {
        0% {
            transform: translateX(-150%);
            opacity: 0;
        }
        15% {
            opacity: 1;
        }
        50% {
            transform: translateX(15%);
            opacity: 1;
        }
        85% {
            opacity: 1;
        }
        100% {
            transform: translateX(180%);
            opacity: 0;
        }
    }
</style>

<div class="max-w-6xl mx-auto py-8">

    <!-- Encabezado / Hero -->
    <div class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white p-6 rounded-2xl mb-8 shadow-lg">
        <h2 class="text-2xl font-bold mb-1">Gestión de Estudiantes</h2>
        <p class="opacity-95">
            Elige un grupo para ver a sus alumnos y acceder rápidamente a sus calificaciones o asistencias.
        </p>
    </div>

    <!-- Selector de grupo -->
    <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
            <div>
                <label for="selectGrupo" class="block mb-2 font-semibold text-sm uppercase tracking-wide">
                    Grupo asignado
                </label>
                <select id="selectGrupo"
                        class="w-full p-3 rounded-xl border border-neutral-300 dark:border-neutral-700
                               dark:bg-neutral-800 dark:text-neutral-100 focus:outline-none focus:ring-2
                               focus:ring-indigo-500">
                    <option value="">-- Selecciona un grupo --</option>
                    <?php if (!empty($grupos)): ?>
                        <?php foreach ($grupos as $g): ?>
                            <option value="<?= $esc($g->group_id) ?>">
                                <?= $esc($g->grupo ?? $g->codigo ?? 'Grupo '.$g->group_id) ?>
                                <?php if (!empty($g->grupo_titulo ?? null)): ?>
                                    — <?= $esc($g->grupo_titulo) ?>
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="text-sm text-neutral-500 dark:text-neutral-400 md:text-right">
                <p class="mb-1 font-semibold">¿Qué puedes hacer aquí?</p>
                <p>• Ver el listado de estudiantes por grupo.</p>
                <p>• Abrir sus calificaciones o historial de asistencias.</p>
            </div>
        </div>
    </div>

    <!-- Tabla de alumnos -->
    <div id="tablaBlock" class="hidden bg-white dark:bg-neutral-800 rounded-2xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold">Estudiantes del grupo</h3>
            <span class="text-xs text-neutral-500 dark:text-neutral-400">
                Da clic en el botón de cada estudiante.
            </span>
        </div>

        <!-- Loader -->
        <div id="loaderBar" class="hidden h-1 w-full mb-4 rounded-full bg-neutral-800/60">
            <div id="loaderBarInner" class="bg-indigo-400 rounded-full"></div>
        </div>

        <div class="overflow-x-auto rounded-xl border border-neutral-200 dark:border-neutral-700">
            <table class="w-full text-sm">
                <thead class="bg-neutral-50 dark:bg-neutral-900/60">
                    <tr>
                        <th class="p-3 text-left font-semibold">Alumno</th>
                        <th class="p-3 text-left font-semibold">Matrícula</th>
                        <th class="p-3 text-center font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyAlumnos" class="divide-y divide-neutral-200 dark:divide-neutral-700">
                    <!-- Filas dinámicas -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const selectGrupo  = document.getElementById('selectGrupo');
const tablaBlock   = document.getElementById('tablaBlock');
const tbodyAlumnos = document.getElementById('tbodyAlumnos');
const loaderBar    = document.getElementById('loaderBar');

function setLoading(isLoading) {
    if (isLoading) {
        loaderBar.classList.remove('hidden');
    } else {
        loaderBar.classList.add('hidden');
    }
}

async function cargarAlumnosGrupo() {
    const groupId = selectGrupo.value;

    if (!groupId) {
        tablaBlock.classList.add('hidden');
        tbodyAlumnos.innerHTML = '';
        return;
    }

    setLoading(true);

    try {
        const url = `/src/plataforma/app/teacher/students/obtenerAlumnos?group_id=${encodeURIComponent(groupId)}`;
        const res = await fetch(url);
        const text = await res.text();

        let data;
        try {
            data = JSON.parse(text);
        } catch (err) {
            console.error('Respuesta no es JSON, texto recibido:', text);
            alert('Error en el servidor al obtener alumnos (no es JSON).');
            return;
        }

        tbodyAlumnos.innerHTML = '';

        if (!data.ok || !Array.isArray(data.alumnos) || data.alumnos.length === 0) {
            tbodyAlumnos.innerHTML = `
                <tr>
                    <td colspan="3" class="p-4 text-center text-neutral-500">
                        No hay alumnos registrados en este grupo.
                    </td>
                </tr>`;
            tablaBlock.classList.remove('hidden');
            return;
        }

        data.alumnos.forEach(al => {
            const nombreCompleto =
                `${al.nombre ?? ''} ${al.apellido_paterno ?? ''} ${al.apellido_materno ?? ''}`.trim();
            const matricula = al.matricula ?? '—';

            // Ajusta estas URLs si tus rutas son diferentes
            const urlCalificaciones = `/src/plataforma/app/teacher/grades?group_id=${encodeURIComponent(groupId)}&student_id=${encodeURIComponent(al.user_id)}`;
            const urlAsistencias    = `/src/plataforma/app/teacher/attendance?group_id=${encodeURIComponent(groupId)}&student_id=${encodeURIComponent(al.user_id)}`;

            tbodyAlumnos.innerHTML += `
                <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-900/40">
                    <td class="p-3">${nombreCompleto}</td>
                    <td class="p-3">${matricula}</td>
                    <td class="p-3">
                        <div class="flex items-center justify-center gap-2 flex-wrap">
                            <a href="${urlCalificaciones}"
                               class="px-3 py-1.5 rounded-full text-xs font-semibold
                                      bg-emerald-600 hover:bg-emerald-700 text-white">
                                Ver calificaciones
                            </a>
                            <a href="${urlAsistencias}"
                               class="px-3 py-1.5 rounded-full text-xs font-semibold
                                      bg-sky-600 hover:bg-sky-700 text-white">
                                Ver asistencias
                            </a>
                        </div>
                    </td>
                </tr>
            `;
        });

        tablaBlock.classList.remove('hidden');
    } catch (e) {
        console.error(e);
        alert('Error al cargar los alumnos del grupo.');
    } finally {
        setLoading(false);
    }
}

selectGrupo.addEventListener('change', cargarAlumnosGrupo);
</script>
