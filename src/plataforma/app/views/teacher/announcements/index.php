

<main class="p-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-xl p-6 text-white mb-8 shadow-lg">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold mb-1">Anuncios</h1>
                <p class="opacity-90 text-sm">Gestiona anuncios y comunicaciones importantes para tu comunidad educativa</p>
            </div>
            <a href="/src/plataforma/app/admin/announcements/create"
               class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-medium rounded-lg transition-all duration-200 shadow-sm border border-white/30">
                <i data-feather="plus" class="w-5 h-5 mr-2"></i>
                Crear Anuncio
            </a>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="space-y-6">
        <?php if (empty($announcements)): ?>
            <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-16 text-center border-2 border-dashed border-neutral-200 dark:border-neutral-700">
                <div class="w-20 h-20 bg-neutral-100 dark:bg-neutral-700 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-feather="bell" class="w-10 h-10 text-neutral-400 dark:text-neutral-500"></i>
                </div>
                <h3 class="text-xl font-semibold text-neutral-900 dark:text-white mb-3">No hay anuncios publicados</h3>
                <p class="text-neutral-500 dark:text-neutral-400 mb-6 max-w-md mx-auto">Sé el primero en crear un anuncio para mantener informada a tu comunidad educativa.</p>
                <a href="/src/plataforma/app/teacher/announcements/create"
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-all duration-200 shadow-sm">
                    <i data-feather="plus" class="w-5 h-5 mr-2"></i>
                    Crear el primer anuncio
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($announcements as $announcement): ?>
                <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 overflow-hidden hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <!-- Announcement Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-3">
                                    <h3 class="text-xl font-bold text-neutral-900 dark:text-white truncate">
                                        <?= htmlspecialchars($announcement->title ?? '') ?>
                                    </h3>
                                    <?php
                                    $role = $announcement->target_role ?? 'all';
                                    $roleConfig = [
                                        'student' => ['bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300', 'Estudiantes'],
                                        'teacher' => ['bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300', 'Maestros'],
                                        'all' => ['bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-300', 'Todos']
                                    ];
                                    list($roleClass, $roleLabel) = $roleConfig[$role] ?? $roleConfig['all'];
                                    ?>
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full <?= $roleClass ?> whitespace-nowrap">
                                        <i data-feather="users" class="w-3 h-3 mr-1"></i>
                                        <?= $roleLabel ?>
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 text-sm text-neutral-500 dark:text-neutral-400">
                                    <div class="flex items-center gap-1">
                                        <i data-feather="user" class="w-4 h-4"></i>
                                        <span>Por: <?= htmlspecialchars($announcement->author_name ?? 'Administración') ?></span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <i data-feather="calendar" class="w-4 h-4"></i>
                                        <span>
                                            <?php
                                            $date = isset($announcement->created_at) && $announcement->created_at
                                                ? date('d/m/Y H:i', strtotime($announcement->created_at))
                                                : 'Fecha desconocida';
                                            echo $date;
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center gap-1 ml-4 flex-shrink-0">
                                <a href="/src/plataforma/app/teacher/announcements/edit/<?= $announcement->id ?>"
                                   class="inline-flex items-center justify-center w-10 h-10 text-neutral-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-all duration-200"
                                   title="Editar anuncio">
                                    <i data-feather="edit-2" class="w-4 h-4"></i>
                                </a>
                                <form action="/src/plataforma/app/teacher/announcements/delete/<?= $announcement->id ?>" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('¿Estás seguro de que quieres eliminar este anuncio? Esta acción no se puede deshacer.')">
                                    <button type="submit"
                                            class="inline-flex items-center justify-center w-10 h-10 text-neutral-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200"
                                            title="Eliminar anuncio">
                                        <i data-feather="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Announcement Content -->
                        <div class="text-neutral-700 dark:text-neutral-300 leading-relaxed border-t border-neutral-100 dark:border-neutral-700 pt-4">
                            <?= nl2br(htmlspecialchars($announcement->content ?? '')) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<script>
    // Inicializar los íconos
    feather.replace();
</script>