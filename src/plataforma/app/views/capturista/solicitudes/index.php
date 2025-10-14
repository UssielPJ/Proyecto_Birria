<?php
// 🔒 Guard de acceso
if (session_status() === PHP_SESSION_NONE) session_start();
if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
  header('Location: /src/plataforma/'); exit;
}

// Variables que vienen del controlador:
// $aspirantes => lista de registros de la tabla aspirantes
?>

<main class="p-6">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Solicitudes de Aspirantes</h1>
    <a href="/src/plataforma/app/capturista/solicitudes/nueva"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center gap-2">
      <i data-feather="plus"></i>
      Nuevo registro
    </a>
  </div>

  <!-- Tabla de aspirantes -->
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
        <thead class="bg-neutral-50 dark:bg-neutral-800">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Folio</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Nombre</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Correo</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Carrera solicitada</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Periodo</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Estatus</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase">Fecha</th>
            <th class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
          <?php if (!empty($aspirantes)): ?>
            <?php foreach ($aspirantes as $a): ?>
              <tr>
                <td class="px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100"><?= htmlspecialchars($a->folio ?? '') ?></td>
                <td class="px-6 py-4 text-sm text-neutral-900 dark:text-neutral-100">
                  <?= htmlspecialchars($a->nombre ?? '') ?>
                  <?= htmlspecialchars(' ' . ($a->apellido_paterno ?? '')) ?>
                  <?= htmlspecialchars(' ' . ($a->apellido_materno ?? '')) ?>
                </td>
                <td class="px-6 py-4 text-sm text-neutral-700 dark:text-neutral-300"><?= htmlspecialchars($a->email ?? '') ?></td>
                <td class="px-6 py-4 text-sm text-neutral-700 dark:text-neutral-300">
                  <?= htmlspecialchars($a->carrera_solicitada_id ?? '') ?>
                </td>
                <td class="px-6 py-4 text-sm text-neutral-700 dark:text-neutral-300">
                  <?= htmlspecialchars($a->periodo_solicitado_id ?? '') ?>
                </td>
                <td class="px-6 py-4">
                  <?php
                    $statusColors = [
                      'registrado'      => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                      'documentacion'   => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                      'examen'          => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
                      'aceptado'        => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                      'rechazado'       => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                    ];
                    $class = $statusColors[$a->status] ?? 'bg-neutral-100 text-neutral-800';
                  ?>
                  <span class="px-2 inline-flex text-xs font-semibold rounded-full <?= $class ?>">
                    <?= ucfirst(htmlspecialchars($a->status)) ?>
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                  <?= htmlspecialchars(date('d/m/Y', strtotime($a->fecha_registro ?? $a->created_at ?? 'now'))) ?>
                </td>
                <td class="px-6 py-4 text-right text-sm font-medium">
                  <div class="flex justify-end gap-3">
                    <a href="/src/plataforma/app/capturista/solicitudes/editar/<?= $a->id ?>"
                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">Editar</a>
                    <form action="/src/plataforma/app/capturista/solicitudes/eliminar/<?= $a->id ?>" method="POST"
                          onsubmit="return confirm('¿Eliminar este registro?')" style="display:inline;">
                      <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Eliminar</button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="px-6 py-6 text-center text-neutral-500 dark:text-neutral-400">
                No hay aspirantes registrados.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<script>
if (window.feather) feather.replace();
</script>
