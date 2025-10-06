<?php
// Guard de acceso
if (session_status() === PHP_SESSION_NONE) session_start();
if (!in_array('capturista', $_SESSION['roles'] ?? [], true)) {
  header('Location: /src/plataforma/'); exit;
}

require_once dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/config/database.php';

// Obtener estadísticas generales
$stats = [
    'solicitudes_hoy' => $conn->query("
        SELECT COUNT(*) FROM solicitudes 
        WHERE DATE(fecha_creacion) = CURDATE()
    ")->fetchColumn(),
    
    'solicitudes_semana' => $conn->query("
        SELECT COUNT(*) FROM solicitudes 
        WHERE fecha_creacion >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    ")->fetchColumn(),
    
    'solicitudes_mes' => $conn->query("
        SELECT COUNT(*) FROM solicitudes 
        WHERE fecha_creacion >= DATE_SUB(NOW(), INTERVAL 30 DAY)
    ")->fetchColumn(),
    
    'total_alumnos' => $conn->query("
        SELECT COUNT(*) FROM alumnos
    ")->fetchColumn()
];

// Obtener distribución por estado
$estados = $conn->query("
    SELECT estado, COUNT(*) as total 
    FROM solicitudes 
    GROUP BY estado
")->fetchAll(PDO::FETCH_KEY_PAIR);

// Obtener distribución por carrera
$carreras = $conn->query("
    SELECT carrera, COUNT(*) as total 
    FROM alumnos 
    WHERE carrera IS NOT NULL 
    GROUP BY carrera 
    ORDER BY total DESC 
    LIMIT 5
")->fetchAll(PDO::FETCH_KEY_PAIR);

// Obtener tendencia de solicitudes por día (últimos 7 días)
$tendencia = $conn->query("
    SELECT DATE(fecha_creacion) as fecha, COUNT(*) as total 
    FROM solicitudes 
    WHERE fecha_creacion >= DATE_SUB(NOW(), INTERVAL 7 DAY)
    GROUP BY DATE(fecha_creacion)
    ORDER BY fecha ASC
")->fetchAll(PDO::FETCH_KEY_PAIR);

// Calcular porcentajes de estados para el gráfico circular
$total_solicitudes = array_sum($estados);
$porcentajes_estados = array_map(function($total) use ($total_solicitudes) {
    return round(($total / $total_solicitudes) * 100, 1);
}, $estados);
?>

<main class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold mb-2">Reportes y Estadísticas</h1>
        <p class="text-neutral-500 dark:text-neutral-400">Visualiza métricas y tendencias del sistema.</p>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Solicitudes hoy</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $stats['solicitudes_hoy'] ?></h3>
                </div>
                <div class="p-3 rounded-lg bg-primary-50 dark:bg-neutral-700">
                    <i data-feather="file-text" class="text-primary-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Esta semana</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $stats['solicitudes_semana'] ?></h3>
                </div>
                <div class="p-3 rounded-lg bg-emerald-50 dark:bg-neutral-700">
                    <i data-feather="calendar" class="text-emerald-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Este mes</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $stats['solicitudes_mes'] ?></h3>
                </div>
                <div class="p-3 rounded-lg bg-blue-50 dark:bg-neutral-700">
                    <i data-feather="trending-up" class="text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Total alumnos</p>
                    <h3 class="text-2xl font-bold mt-1"><?= $stats['total_alumnos'] ?></h3>
                </div>
                <div class="p-3 rounded-lg bg-purple-50 dark:bg-neutral-700">
                    <i data-feather="users" class="text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Gráfico de estados -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-medium mb-4">Distribución por estado</h2>
            <div class="relative" style="height: 300px;">
                <canvas id="estadosChart"></canvas>
            </div>
        </div>

        <!-- Gráfico de carreras -->
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-medium mb-4">Top 5 carreras</h2>
            <div class="relative" style="height: 300px;">
                <canvas id="carrerasChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tendencia de solicitudes -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6 mb-6">
        <h2 class="text-lg font-medium mb-4">Tendencia de solicitudes</h2>
        <div class="relative" style="height: 300px;">
            <canvas id="tendenciaChart"></canvas>
        </div>
    </div>

    <!-- Acciones rápidas -->
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-medium mb-4">Acciones rápidas</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="/src/plataforma/reportes/exportar?tipo=solicitudes" 
               class="flex items-center gap-3 p-4 rounded-lg border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                <div class="p-2 rounded-lg bg-primary-50 dark:bg-neutral-700">
                    <i data-feather="download" class="text-primary-600"></i>
                </div>
                <div>
                    <h3 class="font-medium">Exportar solicitudes</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Descarga en CSV/Excel</p>
                </div>
            </a>

            <a href="/src/plataforma/reportes/exportar?tipo=alumnos" 
               class="flex items-center gap-3 p-4 rounded-lg border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                <div class="p-2 rounded-lg bg-emerald-50 dark:bg-neutral-700">
                    <i data-feather="users" class="text-emerald-600"></i>
                </div>
                <div>
                    <h3 class="font-medium">Exportar alumnos</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Lista completa de alumnos</p>
                </div>
            </a>

            <a href="/src/plataforma/reportes/generar" 
               class="flex items-center gap-3 p-4 rounded-lg border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-700">
                <div class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700">
                    <i data-feather="file-text" class="text-blue-600"></i>
                </div>
                <div>
                    <h3 class="font-medium">Generar reporte</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Reporte personalizado</p>
                </div>
            </a>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Inicializar los íconos
    feather.replace();

    // Configuración común para el tema oscuro
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#94a3b8' : '#475569';
    const gridColor = isDark ? '#1e293b' : '#e2e8f0';

    // Datos para los gráficos
    const estados = <?= json_encode($estados) ?>;
    const carreras = <?= json_encode($carreras) ?>;
    const tendencia = <?= json_encode($tendencia) ?>;

    // Colores para los estados
    const estadosColores = {
        'pendiente': '#fbbf24',
        'aprobada': '#34d399',
        'revision': '#60a5fa',
        'rechazada': '#ef4444'
    };

    // Gráfico de estados (circular)
    new Chart(document.getElementById('estadosChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(estados).map(e => e.charAt(0).toUpperCase() + e.slice(1)),
            datasets: [{
                data: Object.values(estados),
                backgroundColor: Object.keys(estados).map(e => estadosColores[e] || '#6b7280'),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: textColor,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Gráfico de carreras (barras)
    new Chart(document.getElementById('carrerasChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(carreras),
            datasets: [{
                label: 'Alumnos',
                data: Object.values(carreras),
                backgroundColor: '#10b981',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: gridColor
                    },
                    ticks: {
                        color: textColor
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: textColor
                    }
                }
            }
        }
    });

    // Gráfico de tendencia (línea)
    new Chart(document.getElementById('tendenciaChart'), {
        type: 'line',
        data: {
            labels: Object.keys(tendencia).map(fecha => {
                const d = new Date(fecha);
                return d.toLocaleDateString('es-ES', { weekday: 'short', day: 'numeric' });
            }),
            datasets: [{
                label: 'Solicitudes',
                data: Object.values(tendencia),
                borderColor: '#10b981',
                backgroundColor: '#10b98120',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: gridColor
                    },
                    ticks: {
                        color: textColor
                    }
                },
                x: {
                    grid: {
                        color: gridColor
                    },
                    ticks: {
                        color: textColor
                    }
                }
            }
        }
    });
</script>