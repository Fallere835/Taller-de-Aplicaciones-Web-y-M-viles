<?php
session_start();

// 1. PROTECCIÓN OBLIGATORIA
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}

// 2. CARGAR CONEXIÓN Y SERVICIOS
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../app/services/DashboardService.php';

// 3. INSTANCIAR SERVICIO
$dashboardService = new DashboardService($conn);

// 4. OBTENER DATOS PARA TODOS LOS GRÁFICOS
// ✓ La lógica SQL está en el servicio, NO en la vista
$estadoVehiculos = $dashboardService->obtenerEstadoVehiculos();
$ingresosMensuales = $dashboardService->obtenerIngresosMensuales();
$repuestosMasUsados = $dashboardService->obtenerRepuestosMasUsados(10);
$averiasMasComunes = $dashboardService->obtenerAveriasMasComunes();
$ultimosIngresos = $dashboardService->obtenerUltimosIngresos(10);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Automotora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="container py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <div>
            <h1>Hola, <?= htmlspecialchars($_SESSION['user_name']) ?></h1>
            <span class="badge bg-secondary"><?= ucfirst($_SESSION['user_rol']) ?></span>
        </div>
        <a href="../api/logout.php" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
    </div>

    <!-- SECCIÓN DE ACCIONES RÁPIDAS (TU CÓDIGO ORIGINAL) -->
    <div class="row mb-5">
        <?php if ($_SESSION['user_rol'] == 'admin'): ?>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3 h-100">
                    <div class="card-header">Administración</div>
                    <div class="card-body">
                        <p class="card-text">Gestión de usuarios y finanzas.</p>
                        <a href="#" class="btn btn-light btn-sm">Ir a Gestión</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($_SESSION['user_rol'] == 'admin' || $_SESSION['user_rol'] == 'mecanico'): ?>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3 h-100">
                    <div class="card-header">Taller</div>
                    <div class="card-body">
                        <p class="card-text">Ingresar reparaciones y ver inventario.</p>
                        <a href="#" class="btn btn-light btn-sm">Ver Taller</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- SECCIÓN DE MÉTRICAS Y GRÁFICOS -->
    <h3 class="mb-4">📊 Dashboard de Reportes</h3>
    
    <!-- FILA 1: Gráficos de Estado y Averías -->
    <div class="row mb-4">
        <!-- Gráfico 1: Estado de Vehículos (Barras) -->
        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Estado de Vehículos en Taller</h5>
                </div>
                <div class="card-body">
                    <canvas id="graficoEstadoVehiculos" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico 2: Averías Más Comunes (Torta) -->
        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Averías Más Comunes</h5>
                </div>
                <div class="card-body">
                    <canvas id="graficoAverias" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- FILA 2: Ingresos y Repuestos -->
    <div class="row mb-4">
        <!-- Gráfico 3: Ingresos Mensuales (Líneas) -->
        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Ingresos Mensuales (Últimos 12 meses)</h5>
                </div>
                <div class="card-body">
                    <canvas id="graficoIngresos" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico 4: Repuestos Más Usados (Barras Horizontales) -->
        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Top 10 Repuestos Más Utilizados</h5>
                </div>
                <div class="card-body">
                    <canvas id="graficoRepuestos" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- FILA 3: Tabla de Últimos Ingresos -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">📋 Últimos Ingresos al Taller</h5>
                    <input type="text" id="filtroInput" class="form-control form-control-sm w-25" 
                           placeholder="🔍 Buscar patente...">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Patente</th>
                                    <th>Modelo</th>
                                    <th>Estado</th>
                                    <th>Costo Estimado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaCuerpo">
                                <?php if (empty($ultimosIngresos)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            No hay reparaciones registradas
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($ultimosIngresos as $ingreso): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($ingreso['id']) ?></td>
                                            <td><strong><?= htmlspecialchars($ingreso['patente']) ?></strong></td>
                                            <td><?= htmlspecialchars($ingreso['modelo']) ?></td>
                                            <td>
                                                <span class="badge bg-<?= 
                                                    $ingreso['estado'] == 'completado' ? 'success' : 
                                                    ($ingreso['estado'] == 'en_proceso' ? 'warning' : 'secondary') 
                                                ?>">
                                                    <?= ucfirst(str_replace('_', ' ', htmlspecialchars($ingreso['estado']))) ?>
                                                </span>
                                            </td>
                                            <td>$<?= number_format($ingreso['costo'], 0, ',', '.') ?></td>
                                            <td>
                                                <a href="../api/orden_pdf.php?id=<?= $ingreso['id'] ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   target="_blank"
                                                   title="Descargar PDF">
                                                    📄 PDF
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT: Pasar datos de PHP a JavaScript -->
    <script>
        // ✓ BUENA PRÁCTICA: Pasar datos de PHP a JS de forma segura
        // json_encode escapa automáticamente caracteres especiales
        
        const datosEstadoVehiculos = <?= json_encode($estadoVehiculos) ?>;
        const datosIngresosMensuales = <?= json_encode($ingresosMensuales) ?>;
        const datosRepuestosMasUsados = <?= json_encode($repuestosMasUsados) ?>;
        const datosAveriasMasComunes = <?= json_encode($averiasMasComunes) ?>;
    </script>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/dashboard.js"></script>
</body>
</html>