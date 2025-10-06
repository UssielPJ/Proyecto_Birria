<?php
require_once __DIR__ . '/../../partials/head.php';
$announcement = $data['announcement'];
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Editar Anuncio</h1>

            <form action="/src/plataforma/app/admin/announcements/update/<?php echo $announcement->getId(); ?>" method="POST" class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Título
                    </label>
                    <input type="text" id="title" name="title" required
                           value="<?php echo htmlspecialchars($announcement->getTitle()); ?>"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Contenido
                    </label>
                    <textarea id="content" name="content" rows="6" required
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"><?php echo htmlspecialchars($announcement->getContent()); ?></textarea>
                </div>

                <div>
                    <label for="target_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Destinatarios
                    </label>
                    <select id="target_role" name="target_role"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="all" <?php echo $announcement->getTargetRole() === 'all' ? 'selected' : ''; ?>>Todos</option>
                        <option value="student" <?php echo $announcement->getTargetRole() === 'student' ? 'selected' : ''; ?>>Estudiantes</option>
                        <option value="teacher" <?php echo $announcement->getTargetRole() === 'teacher' ? 'selected' : ''; ?>>Maestros</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="/src/plataforma/app/admin/announcements"
                       class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Actualizar Anuncio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../../partials/footer.php';
?>