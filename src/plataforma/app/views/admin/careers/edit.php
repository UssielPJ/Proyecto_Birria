<?php
global $pdo;
$conn = $pdo;

$id = (int)($_GET['id'] ?? 0);
$errors = [];
$success = false;

// Obtener la carrera
$stmt = $conn->prepare("SELECT * FROM careers WHERE id = ?");
$stmt->execute([$id]);
$career = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$career) {
    header('Location: /src/plataforma/app/admin/careers?error=not_found');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $code = trim($_POST['code'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $duration_semesters = (int)($_POST['duration_semesters'] ?? 8);
    $total_credits = (int)($_POST['total_credits'] ?? 240);
    $modality = $_POST['modality'] ?? 'presencial';
    $status = $_POST['status'] ?? 'active';

    // Validaciones
    if (empty($name)) {
        $errors[] = 'El nombre de la carrera es obligatorio.';
    }
    if (empty($code)) {
        $errors[] = 'El código de la carrera es obligatorio.';
    }
    if ($duration_semesters < 1 || $duration_semesters > 12) {
        $errors[] = 'La duración debe estar entre 1 y 12 semestres.';
    }
    if ($total_credits < 1) {
        $errors[] = 'Los créditos totales deben ser mayor a 0.';
    }

    // Verificar código único (excluyendo el actual)
    if (!empty($code)) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM careers WHERE code = ? AND id != ?");
        $stmt->execute([$code, $id]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = 'El código de carrera ya existe.';
        }
    }

    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("
                UPDATE careers 
                SET name = ?, code = ?, description = ?, duration_semesters = ?, 
                    total_credits = ?, modality = ?, status = ?, updated_at = CURRENT_TIMESTAMP
                WHERE id = ?
            ");
            $stmt->execute([$name, $code, $description, $duration_semesters, $total_credits, $modality, $status, $id]);
            $success = true;
            
            // Actualizar los datos para mostrar
            $career = array_merge($career, [
                'name' => $name,
                'code' => $code,
                'description' => $description,
                'duration_semesters' => $duration_semesters,
                'total_credits' => $total_credits,
                'modality' => $modality,
                'status' => $status
            ]);
            
        } catch (PDOException $e) {
            $errors[] = 'Error al actualizar la carrera: ' . $e->getMessage();
        }
    }
}
?>

<main class="p-6">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <div class="flex items-center gap-4 mb-4">
                <a href="/src/plataforma/app/admin/careers" 
                   class="text-neutral-500 hover:text-neutral-700 dark:text-neutral-400 dark:hover:text-neutral-200">
                    <i data-feather="arrow-left" class="w-5 h-5"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold">Editar Carrera</h1>
                    <p class="text-neutral-500 dark:text-neutral-400">Modifica la información de la carrera académica</p>
                </div>
            </div>
        </div>

        <?php if ($success): ?>
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
                <div class="flex">
                    <i data-feather="check-circle" class="w-5 h-5 text-green-400 mr-2 mt-0.5"></i>
                    <div>
                        <h3 class="text-sm font-medium text-green-800 dark:text-green-200">
                            Carrera actualizada exitosamente
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
                            Nombre de la carrera *
                        </label>
                        <input type="text" name="name" id="name" required
                               value="<?= htmlspecialchars($career['name']) ?>"
                               class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500"
                               placeholder="Ej: Ingeniería en Sistemas Computacionales">
                    </div>

                    <div>
                        <label for="code" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Código *
                        </label>
                        <input type="text" name="code" id="code" required
                               value="<?= htmlspecialchars($career['code']) ?>"
                               class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500"
                               placeholder="Ej: ISC">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Descripción
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500"
                              placeholder="Descripción de la carrera académica"><?= htmlspecialchars($career['description'] ?? '') ?></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="duration_semesters" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Duración (semestres) *
                        </label>
                        <input type="number" name="duration_semesters" id="duration_semesters" required
                               value="<?= htmlspecialchars($career['duration_semesters']) ?>"
                               min="1" max="12"
                               class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="total_credits" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Créditos totales *
                        </label>
                        <input type="number" name="total_credits" id="total_credits" required
                               value="<?= htmlspecialchars($career['total_credits']) ?>"
                               min="1"
                               class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                    </div>

                    <div>
                        <label for="modality" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                            Modalidad *
                        </label>
                        <select name="modality" id="modality" required
                                class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                            <option value="presencial" <?= $career['modality'] === 'presencial' ? 'selected' : '' ?>>Presencial</option>
                            <option value="virtual" <?= $career['modality'] === 'virtual' ? 'selected' : '' ?>>Virtual</option>
                            <option value="mixta" <?= $career['modality'] === 'mixta' ? 'selected' : '' ?>>Mixta</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">
                        Estado *
                    </label>
                    <select name="status" id="status" required
                            class="block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 focus:border-primary-500 focus:ring-primary-500">
                        <option value="active" <?= $career['status'] === 'active' ? 'selected' : '' ?>>Activa</option>
                        <option value="inactive" <?= $career['status'] === 'inactive' ? 'selected' : '' ?>>Inactiva</option>
                    </select>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t border-neutral-200 dark:border-neutral-700">
                    <a href="/src/plataforma/app/admin/careers" 
                       class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 rounded-md hover:bg-neutral-50 dark:hover:bg-neutral-600">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Actualizar Carrera
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    feather.replace();
</script>