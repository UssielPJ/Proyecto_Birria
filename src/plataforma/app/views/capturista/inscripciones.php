<?php
// 🔒 Guard de acceso
if (session_status() === PHP_SESSION_NONE) session_start();
if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
  header('Location: /src/plataforma/'); exit;
}

use App\Core\Database;

$db   = new Database();
$conn = $db->getPdo();

// Parámetros
$buscar    = $_GET['q'] ?? '';
$periodoId = $_GET['periodo_id'] ?? '';  // ← usa periodo_id
$estado    = $_GET['status'] ?? '';      // ← usa status
$page      = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit     = 10;
$offset    = ($page - 1) * $limit;

// Filtros
$where  = [];
$params = [];

if ($buscar) {
  $where[] = "(u.nombre LIKE :buscar OR sp.matricula LIKE :buscar OR sp.curp LIKE :buscar)";
  $params[':buscar'] = "%{$buscar}%";
}
if ($periodoId !== '') {
  $where[] = "i.periodo_id = :periodo_id";
  $params[':periodo_id'] = (int)$periodoId;
}
if ($estado !== '') {
  $where[] = "i.status = :status";
  $params[':status'] = $estado;
}
$whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Total
$sqlTotal = "
  SELECT COUNT(*) AS total
  FROM inscripciones i
  LEFT JOIN student_profiles sp ON i.estudiante_id = sp.user_id
  LEFT JOIN users u             ON u.id            = sp.user_id
  $whereClause
";
$stmt = $conn->prepare($sqlTotal);
$stmt->execute($params);
$total = (int)($stmt->fetch(\PDO::FETCH_ASSOC)['total'] ?? 0);
$totalPages = max(1, (int)ceil($total / $limit));

// Listado
$sql = "
  SELECT 
    i.id,
    i.periodo_id,
    i.tipo_inscripcion,
    i.status,
    i.fecha_inscripcion,
    i.calificacion_final,
    sp.matricula,
    sp.curp,
    sp.carrera_id,
    sp.grupo,
    u.nombre AS alumno_nombre,
    u.email  AS alumno_email
  FROM inscripciones i
  LEFT JOIN student_profiles sp ON i.estudiante_id = sp.user_id
  LEFT JOIN users u             ON u.id            = sp.user_id
  $whereClause
  ORDER BY i.fecha_inscripcion DESC
  LIMIT :offset, :limit
";
$stmt = $conn->prepare($sql);
foreach ($params as $k => $v) $stmt->bindValue($k, $v);
$stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
$stmt->bindValue(':limit',  $limit,  \PDO::PARAM_INT);
$stmt->execute();
$inscripciones = $stmt->fetchAll(\PDO::FETCH_OBJ);

// Periodos disponibles (IDs, porque no hay tabla periodos aquí)
try {
  $periodos = $conn->query("SELECT DISTINCT periodo_id FROM inscripciones ORDER BY periodo_id DESC")
                   ->fetchAll(\PDO::FETCH_COLUMN);
} catch (\Throwable $e) { $periodos = []; }
?>

<main class="p-6">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h1 class="text-2xl font-bold mb-2">Inscripciones</h1>
      <p class="text-neutral-500 dark:text-neutral-400">Gestión de inscripciones de alumnos.</p>
    </div>
    <a href="/src/plataforma/app/capturista/inscripciones/nueva" 
       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center gap-2">
      <i data-feather="plus"></i>
      Nueva inscripción
    </a>
  </div>

  <!-- Filtros -->
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-4 mb-6">
    <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <label class="block text-sm mb-1">Buscar</label>
        <input type="text" name="q" value="<?= htmlspecialchars($buscar) ?>"
               placeholder="Nombre, matrícula o CURP..."
               class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
      </div>

      <div>
        <label class="block text-sm mb-1">Periodo (ID)</label>
        <select name="periodo_id" class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
          <option value="">Todos</option>
          <?php foreach ($periodos as $p): ?>
            <option value="<?= (int)$p ?>" <?= (string)$periodoId === (string)$p ? 'selected' : '' ?>><?= (int)$p ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label class="block text-sm mb-1">Estado</label>
        <select name="status" class="w-full rounded-md border-neutral-300 dark:border-neutral-600 dark:bg-neutral-700">
          <option value="">Todos</option>
          <?php
            // Ajusta a tu ENUM real (ej.: 'inscrito','cursando','aprobado','reprobado')
            $estados = ['inscrito','cursando','aprobado','reprobado','cancelada','completada'];
            foreach ($estados as $st):
          ?>
            <option value="<?= $st ?>" <?= $estado === $st ? 'selected' : '' ?>><?= ucfirst($st) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="flex items-end">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-flex items-center gap-2">
          <i data-feather="filter"></i> Filtrar
        </button>
      </div>
    </form>
  </div>

  <!-- Tabla -->
  <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
        <thead class="bg-neutral-50 dark:bg-neutral-800">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Alumno</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Matrícula</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Periodo (ID)</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Estado</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase text-neutral-500 dark:text-neutral-400">Fecha</th>
            <th class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700">
          <?php if (!empty($inscripciones)): foreach ($inscripciones as $i): ?>
            <tr>
              <td class="px-6 py-4">
                <div class="text-sm font-medium text-neutral-900 dark:text-neutral-100">
                  <?= htmlspecialchars($i->alumno_nombre ?? 'Sin nombre') ?>
                </div>
                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                  <?= htmlspecialchars($i->alumno_email ?? '') ?>
                </div>
              </td>
              <td class="px-6 py-4 text-sm text-neutral-700 dark:text-neutral-300">
                <?= htmlspecialchars($i->matricula ?? '') ?>
              </td>
              <td class="px-6 py-4 text-sm text-neutral-700 dark:text-neutral-300">
                <?= htmlspecialchars($i->periodo_id ?? '-') ?>
              </td>
              <td class="px-6 py-4">
                <?php
                  $colors = [
                    'inscrito'    => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                    'cursando'    => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                    'aprobado'    => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                    'reprobado'   => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                    'cancelada'   => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                    'completada'  => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                  ];
                  $class = $colors[$i->status] ?? 'bg-neutral-100 text-neutral-800';
                ?>
                <span class="px-2 inline-flex text-xs font-semibold rounded-full <?= $class ?>">
                  <?= ucfirst(htmlspecialchars($i->status ?? '')) ?>
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-neutral-500 dark:text-neutral-400">
                <?= htmlspecialchars(date('d/m/Y', strtotime($i->fecha_inscripcion ?? 'now'))) ?>
              </td>
              <td class="px-6 py-4 text-right text-sm">
                <a href="/src/plataforma/app/capturista/inscripciones/editar/<?= (int)$i->id ?>"
                   class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                   Editar
                </a>
              </td>
            </tr>
          <?php endforeach; else: ?>
            <tr><td colspan="6" class="px-6 py-6 text-center text-neutral-500 dark:text-neutral-400">No se encontraron inscripciones.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</main>

<script>
if (window.feather) feather.replace();
</script>
