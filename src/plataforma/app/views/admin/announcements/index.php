<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Anuncios</h1>
        <a href="/src/plataforma/app/admin/announcements/create"
           class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
            <i class="fas fa-plus mr-2"></i>Crear Anuncio
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <?php if (empty($announcements)): ?>
            <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                <i class="fas fa-bell text-4xl mb-4"></i>
                <p>No hay anuncios creados aún.</p>
                <a href="/src/plataforma/app/admin/announcements/create"
                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mt-2 inline-block">
                    Crear el primer anuncio
                </a>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Título
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Autor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Destinatarios
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Fecha
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php foreach ($announcements as $announcement): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        <?php echo htmlspecialchars($announcement->title ?? ''); ?>
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">
                                        <?php
                                        $content = $announcement->content ?? '';
                                        echo htmlspecialchars(substr($content, 0, 100)) . (strlen($content) > 100 ? '...' : '');
                                        ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <?php echo htmlspecialchars($announcement->author_name ?? 'Desconocido'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        <?php
                                        $role = $announcement->target_role ?? 'all';
                                        switch($role) {
                                            case 'student':
                                                echo 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                                                break;
                                            case 'teacher':
                                                echo 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                                                break;
                                            default:
                                                echo 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
                                        }
                                        ?>">
                                        <?php
                                        switch($role) {
                                            case 'student':
                                                echo 'Estudiantes';
                                                break;
                                            case 'teacher':
                                                echo 'Maestros';
                                                break;
                                            default:
                                                echo 'Todos';
                                        }
                                        ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo (isset($announcement->created_at) && $announcement->created_at) ? date('d/m/Y H:i', strtotime($announcement->created_at)) : 'N/A'; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/src/plataforma/app/admin/announcements/edit/<?php echo $announcement->id; ?>"
                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                    <form action="/src/plataforma/app/admin/announcements/delete/<?php echo $announcement->id; ?>" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('¿Estás seguro de que quieres eliminar este anuncio?')">
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
