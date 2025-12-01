<?php
/** @var array|\stdClass[] $grupos */
$esc = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
?>

<style>
    /* ===== Pills de estado ===== */
    .estado-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.35rem 0.9rem;
        border-radius: 9999px;
        border: 1px solid rgba(148, 163, 184, 0.5);
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        gap: 0.35rem;
        background-color: rgba(15, 23, 42, 0.45);
        color: #e5e7eb;
        transition: background-color .15s ease, border-color .15s ease, transform .05s ease;
        white-space: nowrap;
    }

    .estado-pill:hover {
        transform: translateY(-1px);
        background-color: rgba(30, 64, 175, 0.35);
    }

    .estado-pill input {
        display: none;
    }

    .estado-pill span::before {
        content: '';
        width: 0.7rem;
        height: 0.7rem;
        border-radius: 9999px;
        border: 2px solid currentColor;
        display: inline-block;
        margin-right: 0.3rem;
        box-sizing: border-box;
    }

    .estado-pill input:checked + span::before {
        background-color: currentColor;
    }

    .estado-pill.estado-asistio {
        color: #34d399;
        border-color: rgba(52, 211, 153, 0.7);
        background-color: rgba(6, 95, 70, 0.25);
    }

    .estado-pill.estado-falta {
        color: #fb7185;
        border-color: rgba(248, 113, 113, 0.75);
        background-color: rgba(127, 29, 29, 0.25);
    }

    .estado-pill.estado-retardo {
        color: #fbbf24;
        border-color: rgba(251, 191, 36, 0.8);
        background-color: rgba(120, 53, 15, 0.25);
    }

    /* ===== Barra de carga (portal) ===== */
    #loaderBar {
        position: relative;
        overflow: hidden;
    }

    #loaderBarInner {
        height: 100%;
        width: 35%;                         /* barra más larga */
        transform: translateX(-150%);
        animation: loader-slide 1.3s ease-in-out infinite;
    }

    @keyframes loader-slide {
        0% {
            transform: translateX(-150%);
            opacity: 0;                     /* aparece desde “portal” izquierdo */
        }
        15% {
            opacity: 1;
        }
        50% {
            transform: translateX(15%);     /* pasa por la parte central */
            opacity: 1;
        }
        85% {
            opacity: 1;
        }
        100% {
            transform: translateX(180%);    /* se va muy a la derecha */
            opacity: 0;                     /* desaparece en “portal” derecho */
        }
    }
</style>

<div class="max-w-6xl mx-auto py-8">

    <!-- Encabezado -->
    <div class="bg-gradient-to-r from-emerald-500 to-sky-600 text-white p-6 rounded-2xl mb-8 shadow-lg">
        <h2 class="text-2xl font-bold mb-1">Control de asistencia</h2>
        <p class="opacity-95">Registra la asistencia de tus alumnos por grupo y fecha.</p>
    </div>

    <!-- Selector de grupo -->
    <div class="bg-white dark:bg-neutral-800 rounded-2xl shadow p-6 mb-6">
        <label for="selectGrupo" class="block mb-2 font-semibold text-sm uppercase tracking-wide">
            Grupo / Materia
        </label>
        <select id="selectGrupo"
                class="w-full p-3 rounded-xl border border-neutral-300 dark:border-neutral-700
                       dark:bg-neutral-800 dark:text-neutral-100 focus:outline-none focus:ring-2
                       focus:ring-emerald-500">
            <option value="">-- Selecciona un grupo --</option>
            <?php if (!empty($grupos)): ?>
                <?php foreach ($grupos as $g): ?>
                    <option value="<?= $esc($g->group_id) ?>">
                        <?= $esc($g->grupo) ?>
                        <?php if (!empty($g->grupo_titulo)): ?>
                            — <?= $esc($g->grupo_titulo) ?>
                        <?php endif; ?>
                        — <?= $esc($g->materia) ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>

    <!-- Fecha -->
    <div id="fechaBlock" class="hidden bg-white dark:bg-neutral-800 rounded-2xl shadow p-6 mb-6">
        <label for="fecha" class="block mb-2 font-semibold text-sm uppercase tracking-wide">
            Fecha
        </label>
        <input type="date"
               id="fecha"
               value="<?= date('Y-m-d') ?>"
               class="p-3 rounded-xl border border-neutral-300 dark:border-neutral-700
                      dark:bg-neutral-800 dark:text-neutral-100 focus:outline-none focus:ring-2
                      focus:ring-emerald-500" />
    </div>

    <!-- Tabla de asistencia -->
    <div id="tablaBlock" class="hidden bg-white dark:bg-neutral-800 rounded-2xl shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold">Lista de alumnos</h3>
            <span class="text-xs text-neutral-500 dark:text-neutral-400">
                Selecciona una opción por alumno
            </span>
        </div>

        <!-- Barra de carga -->
        <div id="loaderBar" class="hidden h-1 w-full mb-4 rounded-full bg-neutral-800/60">
            <div id="loaderBarInner" class="bg-emerald-500 rounded-full"></div>
        </div>

        <form id="formAsistencia">
            <div class="overflow-x-auto rounded-xl border border-neutral-200 dark:border-neutral-700">
                <table class="w-full text-sm">
                    <thead class="bg-neutral-50 dark:bg-neutral-900/60">
                        <tr>
                            <th class="p-3 text-left font-semibold">Alumno</th>
                            <th class="p-3 text-center font-semibold">Estado</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyAlumnos" class="divide-y divide-neutral-200 dark:divide-neutral-700">
                        <!-- Filas dinámicas -->
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button type="button" id="btnMarcarTodosAsistieron"
                        class="px-4 py-2 rounded-xl border text-sm
                               border-emerald-500 text-emerald-600 dark:text-emerald-400
                               hover:bg-emerald-50 dark:hover:bg-emerald-900/30">
                    Marcar todos como “asistió”
                </button>

                <button type="submit"
                        class="px-6 py-2.5 rounded-xl text-sm font-semibold
                               bg-emerald-600 hover:bg-emerald-700 text-white shadow">
                    Guardar asistencia
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const selectGrupo        = document.getElementById('selectGrupo');
const fechaBlock         = document.getElementById('fechaBlock');
const tablaBlock         = document.getElementById('tablaBlock');
const tbodyAlumnos       = document.getElementById('tbodyAlumnos');
const formAsistencia     = document.getElementById('formAsistencia');
const btnTodosAsistieron = document.getElementById('btnMarcarTodosAsistieron');
const inputFecha         = document.getElementById('fecha');
const loaderBar          = document.getElementById('loaderBar');

function setLoading(isLoading) {
    if (isLoading) {
        loaderBar.classList.remove('hidden');
    } else {
        loaderBar.classList.add('hidden');
    }
}

async function cargarAlumnos() {
    const groupId = selectGrupo.value;
    const fecha   = inputFecha.value;

    if (!groupId) {
        fechaBlock.classList.add('hidden');
        tablaBlock.classList.add('hidden');
        tbodyAlumnos.innerHTML = '';
        setLoading(false);
        return;
    }

    fechaBlock.classList.remove('hidden');
    setLoading(true);

    try {
        const url = `/src/plataforma/app/teacher/attendance/obtenerAlumnos`
            + `?group_id=${encodeURIComponent(groupId)}`
            + `&fecha=${encodeURIComponent(fecha)}`;

        const res  = await fetch(url);
        const text = await res.text();
        let data;

        try {
            data = JSON.parse(text);
        } catch (err) {
            console.error('Respuesta no es JSON, texto recibido:', text);
            alert('Error en el servidor al obtener alumnos (no es JSON). Revisa el log.');
            return;
        }

        tbodyAlumnos.innerHTML = '';

        if (!data.ok || !Array.isArray(data.alumnos) || data.alumnos.length === 0) {
            tbodyAlumnos.innerHTML = `
                <tr>
                    <td colspan="2" class="p-4 text-center text-neutral-500">
                        No hay alumnos registrados en este grupo.
                    </td>
                </tr>`;
            tablaBlock.classList.remove('hidden');
            return;
        }

        data.alumnos.forEach(al => {
            const nombreCompleto =
                `${al.nombre || ''} ` +
                `${al.apellido_paterno || ''} ` +
                `${al.apellido_materno || ''}`.trim();

            const estado = al.estado || 'asistio';

            tbodyAlumnos.innerHTML += `
                <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-900/40">
                    <td class="p-3">${nombreCompleto}</td>
                    <td class="p-3">
                        <div class="flex items-center justify-center gap-2 flex-wrap">
                            <label class="estado-pill estado-asistio">
                                <input type="radio"
                                       name="asistencia[${al.user_id}]"
                                       value="asistio"
                                       ${estado === 'asistio' ? 'checked' : ''}>
                                <span>Asistió</span>
                            </label>
                            <label class="estado-pill estado-falta">
                                <input type="radio"
                                       name="asistencia[${al.user_id}]"
                                       value="falta"
                                       ${estado === 'falta' ? 'checked' : ''}>
                                <span>Falta</span>
                            </label>
                            <label class="estado-pill estado-retardo">
                                <input type="radio"
                                       name="asistencia[${al.user_id}]"
                                       value="retardo"
                                       ${estado === 'retardo' ? 'checked' : ''}>
                                <span>Retardo</span>
                            </label>
                        </div>
                    </td>
                </tr>
            `;
        });

        tablaBlock.classList.remove('hidden');
    } catch (e) {
        console.error(e);
        alert('Error al cargar alumnos.');
    } finally {
        setLoading(false);
    }
}

// Cambio de grupo → recargar asistencia del día seleccionado
selectGrupo.addEventListener('change', () => {
    cargarAlumnos();
});

// Cambio de fecha → recargar asistencia de esa fecha
inputFecha.addEventListener('change', () => {
    if (selectGrupo.value) {
        cargarAlumnos();
    }
});

btnTodosAsistieron.addEventListener('click', () => {
    const radios = tbodyAlumnos.querySelectorAll('input[type="radio"][value="asistio"]');
    radios.forEach(r => r.checked = true);
});

formAsistencia.addEventListener('submit', async function (e) {
    e.preventDefault();

    const groupId = selectGrupo.value;
    const fecha   = inputFecha.value;

    if (!groupId || !fecha) {
        alert('Selecciona un grupo y una fecha.');
        return;
    }

    const formData = new FormData(this);
    formData.append('group_id', groupId);
    formData.append('fecha', fecha);

    try {
        const res  = await fetch('/src/plataforma/app/teacher/attendance/save', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();

        alert(data.msg || 'Asistencia guardada');
    } catch (e) {
        console.error(e);
        alert('Error al guardar la asistencia.');
    }
});
</script>
