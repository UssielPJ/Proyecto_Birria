<div class="container px-6 py-8">
  <div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold">Nuevo Rol</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Crea un nuevo rol con sus permisos</p>
      </div>

      <form action="/admin/roles/store" method="POST" class="space-y-6">
        <!-- Información Básica del Rol -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Información del Rol</h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium mb-1">Nombre del Rol</label>
              <input type="text" name="name" required class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Ej: Administrador">
            </div>
            <div>
              <label class="block text-sm font-medium mb-1">Estado</label>
              <select name="status" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800">
                <option value="active" selected>Activo</option>
                <option value="inactive">Inactivo</option>
              </select>
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Descripción</label>
            <textarea name="description" rows="3" class="w-full px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-800" placeholder="Describe las funciones de este rol"></textarea>
          </div>
        </div>

        <!-- Permisos -->
        <div class="bg-neutral-50 dark:bg-neutral-900 p-4 rounded-lg space-y-4">
          <h2 class="font-semibold text-lg">Permisos</h2>
          <p class="text-sm text-neutral-500 dark:text-neutral-400">Selecciona los permisos que tendrá este rol</p>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Usuarios -->
            <div class="space-y-3">
              <h3 class="font-medium text-sm text-neutral-700 dark:text-neutral-300">Usuarios</h3>
              <div class="space-y-2">
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="users.view" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Ver usuarios</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="users.create" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Crear usuarios</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="users.edit" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Editar usuarios</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="users.delete" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Eliminar usuarios</span>
                </label>
              </div>
            </div>

            <!-- Roles -->
            <div class="space-y-3">
              <h3 class="font-medium text-sm text-neutral-700 dark:text-neutral-300">Roles</h3>
              <div class="space-y-2">
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="roles.view" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Ver roles</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="roles.create" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Crear roles</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="roles.edit" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Editar roles</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="roles.delete" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Eliminar roles</span>
                </label>
              </div>
            </div>

            <!-- Estudiantes -->
            <div class="space-y-3">
              <h3 class="font-medium text-sm text-neutral-700 dark:text-neutral-300">Estudiantes</h3>
              <div class="space-y-2">
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="students.view" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Ver estudiantes</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="students.create" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Crear estudiantes</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="students.edit" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Editar estudiantes</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="students.delete" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Eliminar estudiantes</span>
                </label>
              </div>
            </div>

            <!-- Profesores -->
            <div class="space-y-3">
              <h3 class="font-medium text-sm text-neutral-700 dark:text-neutral-300">Profesores</h3>
              <div class="space-y-2">
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="teachers.view" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Ver profesores</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="teachers.create" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Crear profesores</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="teachers.edit" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Editar profesores</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="teachers.delete" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Eliminar profesores</span>
                </label>
              </div>
            </div>

            <!-- Cursos -->
            <div class="space-y-3">
              <h3 class="font-medium text-sm text-neutral-700 dark:text-neutral-300">Cursos</h3>
              <div class="space-y-2">
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="courses.view" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Ver cursos</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="courses.create" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Crear cursos</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="courses.edit" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Editar cursos</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="courses.delete" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Eliminar cursos</span>
                </label>
              </div>
            </div>

            <!-- Calificaciones -->
            <div class="space-y-3">
              <h3 class="font-medium text-sm text-neutral-700 dark:text-neutral-300">Calificaciones</h3>
              <div class="space-y-2">
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="grades.view" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Ver calificaciones</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="grades.create" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Crear calificaciones</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="grades.edit" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Editar calificaciones</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" name="permissions[]" value="grades.delete" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-neutral-300 rounded">
                  <span class="ml-2 text-sm">Eliminar calificaciones</span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="flex justify-end gap-4">
          <a href="/admin/roles" class="px-4 py-2 rounded-lg border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-700">
            Cancelar
          </a>
          <button type="submit" class="px-4 py-2 rounded-lg bg-primary-500 text-white hover:bg-primary-600">
            Guardar Rol
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Función para seleccionar/deseleccionar todos los permisos de una categoría
  function toggleCategory(category, checked) {
    const checkboxes = document.querySelectorAll(`input[name="permissions[]"][value^="${category}."]`);
    checkboxes.forEach(cb => cb.checked = checked);
  }

  // Agregar botones para seleccionar todos en cada categoría (opcional)
  document.addEventListener('DOMContentLoaded', function() {
    const categories = ['users', 'roles', 'students', 'teachers', 'courses', 'grades'];
    categories.forEach(cat => {
      const header = document.querySelector(`h3:contains('${cat.charAt(0).toUpperCase() + cat.slice(1)}')`);
      if (header) {
        const selectAllBtn = document.createElement('button');
        selectAllBtn.type = 'button';
        selectAllBtn.className = 'text-xs text-primary-600 hover:text-primary-800 ml-2';
        selectAllBtn.textContent = 'Seleccionar todos';
        selectAllBtn.onclick = () => toggleCategory(cat, true);
        header.appendChild(selectAllBtn);
      }
    });
  });
</script>