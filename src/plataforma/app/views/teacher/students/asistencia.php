<div class="container px-6 py-8">

    <h1 class="text-3xl font-bold mb-6">Asistencia del Grupo <?= $grupoId ?></h1>

    <form method="POST" action="/src/plataforma/app/teacher/students/guardar">

        <input type="hidden" name="grupo_id" value="<?= $grupoId ?>">

        <label class="block mb-2 font-semibold">Fecha:</label>
        <input type="date" name="fecha" class="p-2 border rounded mb-4" required>

        <table class="w-full border">
            <tr class="bg-gray-200">
                <th class="p-2">Alumno</th>
                <th class="p-2">Asistencia</th>
            </tr>

            <?php foreach ($alumnos as $a): ?>
                <tr>
                    <td class="p-2"><?= htmlspecialchars($a['nombre']) ?></td>
                    <td class="p-2">
                        <select name="alumnos[<?= $a['id'] ?>]" class="p-1 border rounded">
                            <option value="asistio">Asistió</option>
                            <option value="falta">Falta</option>
                            <option value="retardo">Retardo</option>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <button class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded">
            Guardar asistencia
        </button>

    </form>
</div>
