<?php
// Guard de acceso
if (session_status() === PHP_SESSION_NONE) session_start();
if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
  header('Location: /src/plataforma/'); exit;
}

require_once __DIR__ . '/../../../../../config/database.php';

// Procesar archivo subido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $archivo = $_FILES['archivo']['tmp_name'];
        $tipo = $_POST['tipo'] ?? '';
        
        // Verificar extensión
        $extension = strtolower(pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, ['csv', 'xlsx'])) {
            $error = "El archivo debe ser CSV o Excel (xlsx)";
        } else {
            try {
                // Aquí iría la lógica de importación según el tipo
                // Por ahora solo simulamos el proceso
                
                // Crear registro de importación
                $stmt = $conn->prepare("
                    INSERT INTO importaciones (
                        nombre_archivo, tipo, estado, total_registros
                    ) VALUES (
                        :nombre, :tipo, 'en_proceso', 0
                    )
                ");
                
                $stmt->execute([
                    ':nombre' => $_FILES['archivo']['name'],
                    ':tipo' => $tipo
                ]);
                
                $importacionId = $conn->lastInsertId();
                
                // Redireccionar a la página de estado
                header("Location: /src/plataforma/capturista/importar/estado?id=$importacionId");
                exit;
            } catch (Exception $e) {
                $error = "Error al procesar el archivo: " . $e->getMessage();
            }
        }
    } else {
        $error = "Por favor selecciona un archivo";
    }
}

// Obtener historial de importaciones
$importaciones = $conn->query("
    SELECT * FROM importaciones 
    ORDER BY id DESC 
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-2">Importar Datos</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Sube archivos CSV o Excel para importar información masivamente.</p>
    </div>

    <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline"><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Formulario de importación -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-medium mb-4">Nueva importación</h2>
            
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <div>
                    <label for="tipo" class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                        Tipo de datos
                    </label>
                    <select name="tipo" id="tipo" required
                            class="mt-1 block w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Selecciona el tipo de datos</option>
                        <option value="alumnos">Alumnos</option>
                        <option value="solicitudes">Solicitudes</option>
                        <option value="calificaciones">Calificaciones</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-1">
                        Archivo CSV/Excel
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-neutral-300 dark:border-neutral-600 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <i data-feather="upload-cloud" class="mx-auto h-12 w-12 text-neutral-400"></i>
                            <div class="flex text-sm text-neutral-600 dark:text-neutral-400">
                                <label for="archivo" class="relative cursor-pointer rounded-md font-medium text-primary-600 hover:text-primary-500">
                                    <span>Sube un archivo</span>
                                    <input id="archivo" name="archivo" type="file" class="sr-only" accept=".csv,.xlsx">
                                </label>
                                <p class="pl-1">o arrastra y suelta</p>
                            </div>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                CSV o Excel hasta 10MB
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-primary-500 text-white px-4 py-2 rounded-lg hover:bg-primary-600 inline-flex items-center gap-2">
                        <i data-feather="upload"></i>
                        Iniciar importación
                    </button>
                </div>
            </form>
        </div>

        <!-- Historial de importaciones -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-medium mb-4">Últimas importaciones</h2>
            
            <div class="space-y-4">
                <?php foreach ($importaciones as $imp): ?>
                    <div class="flex items-center justify-between p-4 border border-neutral-200 dark:border-neutral-700 rounded-lg">
                        <div class="min-w-0">
                            <h3 class="text-sm font-medium text-neutral-900 dark:text-neutral-100 truncate">
                                <?= htmlspecialchars($imp['nombre_archivo']) ?>
                            </h3>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400">
                                <?= ucfirst($imp['tipo'] ?? '') ?> · ID: <?= $imp['id'] ?>
                            </p>
                            <div class="mt-1">
                                <?php
                                $estadoClases = [
                                    'completado' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                    'en_proceso' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'error' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                ];
                                $clase = $estadoClases[$imp['estado'] ?? 'desconocido'] ?? 'bg-neutral-100 text-neutral-800';
                                ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $clase ?>">
                                    <?= ucfirst(str_replace('_', ' ', $imp['estado'] ?? '')) ?>
                                </span>
                            </div>
                        </div>
                        <a href="/src/plataforma/capturista/importar/estado?id=<?= $imp['id'] ?>" 
                           class="ml-4 text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                            Ver detalles
                        </a>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($importaciones)): ?>
                    <div class="text-center py-4 text-neutral-500 dark:text-neutral-400">
                        No hay importaciones recientes
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($importaciones)): ?>
                <div class="mt-4 text-center">
                    <a href="/src/plataforma/capturista/importar/historial" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 text-sm">
                        Ver historial completo
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
    // Inicializar los íconos
    feather.replace();

    // Manejar la visualización del nombre del archivo
    const input = document.getElementById('archivo');
    input.addEventListener('change', function() {
        const filename = this.files[0]?.name;
        if (filename) {
            const label = this.parentElement.nextElementSibling;
            label.textContent = filename;
        }
    });

    // Manejar drag and drop
    const dropzone = document.querySelector('.border-dashed');
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropzone.classList.add('border-primary-500');
    }

    function unhighlight(e) {
        dropzone.classList.remove('border-primary-500');
    }

    dropzone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        input.files = files;
        
        const filename = files[0]?.name;
        if (filename) {
            const label = input.parentElement.nextElementSibling;
            label.textContent = filename;
        }
    }
</script>