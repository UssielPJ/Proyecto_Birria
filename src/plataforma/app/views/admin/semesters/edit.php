<?php
global $pdo;
$conn = $pdo;

$id = (int)($_GET['id'] ?? 0);
$errors = [];
$success = false;

// Obtener el semestre
$stmt = $conn->prepare("
    SELECT s.*, c.name as career_name, c.code as career_code
    FROM semesters s
    LEFT JOIN careers c ON s.career_id = c.id
    WHERE s.id = ?
");
$stmt->execute([$id]);
$semester = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$semester) {
    header('Location: /src/plataforma/app/admin/semesters?error=not_found');
    exit;
}

// Obtener carreras activas
$careers = $conn
    ->query("SELECT id, name, code FROM careers WHERE status = 'active' ORDER BY name ASC")
    ->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $career_id = (int)($_POST['career_id'] ?? 0);
    $semester_number = (int)($_POST['semester_number'] ?? 1);
    $status = $_POST['status'] ?? 'active';

    // Validaciones
    if (empty($name)) {
        $errors[] = 'El nombre del semestre es obligatorio.';
    }
    if ($career_id <= 0) {
        $errors[] = 'Debe seleccionar una carrera.';
    }
    if ($semester_number < 1 || $semester_number > 12) {
        $errors[] = 'El número de semestre debe estar entre 1 y 12.';
    }

    // Verificar que la carrera existe
    if ($career_id > 0) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM careers WHERE id = ? AND status = 'active'");
        $stmt->execute([$career_id]);
        if ($stmt->fetchColumn() == 0) {
            $errors[] = 'La carrera seleccionada no existe o está inactiva.';
        }
    }

    // Verificar que no exista ya un semestre con el mismo número para la misma carrera (excluyendo el actual)
    if ($career_id > 0 && $semester_number > 0) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM semesters WHERE career_id = ? AND semester_number = ? AND id != ?");
        $stmt->execute([$career_id, $semester_number, $id]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'Ya existe un semestre con este número para la carrera seleccionada.';
        }
    }

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("
                UPDATE semesters 
                SET name = ?, career_id = ?, semester_number = ?, status = ?, updated_at = CURRENT_TIMESTAMP
                WHERE id = ?
            ");
            $stmt->execute([$name, $career_id, $semester_number, $status, $id]);
            $success = true;
            
            // Actualizar los datos para mostrar
            $semester = array_merge($semester, [
                'name' => $name,
                'career_id' => $career_id,
                'semester_number' => $semester_number,
                'status' => $status
            ]);
            
        } catch (PDOException $e) {
            $errors[] = 'Error al actualizar el semestre: ' . $e->getMessage();
        }
    }
}
?>

<main class="p-6">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <div class="flex items-center gap-4 mb-4">
                <a href="/src/plataforma/app/admin/semesters" 
                   class="text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200">
                    <i data-feather="arrow-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold">Editar Semestre</h1>
                    <p class="text-neutral-500 dark:text-neutral-400">Modifica la información del semestre</p>
                </div>
            </div>
        </div>

        <?php if ($success): ?>
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
                <div class="flex">
                    <i data-feather="check-circle" class="w-5 h-5 text-green-400 mr-2 mt-0.5"></i>
                    <div>
                        <h3 class="text-sm font-medium text-green-800 dark:text-green-200">
                            Semestre actualizado exitosamente
                        </h3>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-6">
                <div class="flex">
                    <i data-feather="alert-circle" class="w-5 h-5 text-red-400 mr-2 mt-0.5"></i>
                    <div>
                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                            Se encontraron los siguientes errores:
                        </h3>
                        <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Nombre del semestre *
                        </label>
                        <input type="text" name="name" id="name" required
                               value="<?= htmlspecialchars($semester['name']) ?>"
                               class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500"
                               placeholder="Ej: Primer Semestre">
                    </div>

                    <div>
                        <label for="semester_number" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Número de semestre *
                        </label>
                        <select name="semester_number" id="semester_number" required
                                class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Seleccionar número</option>
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i ?>" <?= $semester['semester_number'] == $i ? 'selected' : '' ?>>
                                    <?= $i ?>° Semestre
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="career_id" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Carrera *
                    </label>
                    <select name="career_id" id="career_id" required
                            class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Seleccionar carrera</option>
                        <?php foreach ($careers as $career): ?>
                            <option value="<?= (int)$career['id'] ?>" <?= $semester['career_id'] == $career['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($career['code']) ?> - <?= htmlspecialchars($career['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (empty($careers)): ?>
                        <p class="mt-2 text-sm text-amber-600 dark:text-amber-400">
                            <i data-feather="alert-triangle" class="w-4 h-4 inline mr-1"></i>
                            No hay carreras activas disponibles. 
                            <a href="/src/plataforma/app/admin/careers/create" class="underline hover:no-underline">Crear una carrera primero</a>.
                        </p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Estado *
                    </label>
                    <select name="status" id="status" required
                            class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                        <option value="active" <?= $semester['status'] === 'active' ? 'selected' : '' ?>>Activo</option>
                        <option value="inactive" <?= $semester['status'] === 'inactive' ? 'selected' : '' ?>>Inactivo</option>
                    </select>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <a href="/src/plataforma/app/admin/semesters" 
                       class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-md hover:bg-neutral-50 dark:hover:bg-neutral-600">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                            <?= empty($careers) ? 'disabled' : '' ?>>
                        Actualizar Semestre
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    feather.replace();
</script>