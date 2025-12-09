<?php
session_start();

// 1. PROTECCIÓN OBLIGATORIA
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
}
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

    <!-- SECCIÓN DE MÉTRICAS (LO NUEVO DE LA CLASE 3) -->
    <h3 class="mb-3">Monitor de Taller en Tiempo Real</h3>
    <div class="row">
        <!-- Gráfico JS -->
        <div class="col-md-5">
            <div class="card p-3 shadow-sm">
                <h5 class="card-title">Estado de Vehículos</h5>
                <div style="height: 250px;">
                    <canvas id="miGrafico"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabla JS -->
        <div class="col-md-7">
            <div class="card p-3 shadow-sm">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="card-title">Últimos Ingresos</h5>
                    <input type="text" id="filtroInput" class="form-control form-control-sm w-50" placeholder="Buscar patente...">
                </div>
                
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Patente</th>
                            <th>Modelo</th>
                            <th>Estado</th>
                            <th>Costo</th>
                        </tr>
                    </thead>
                    <tbody id="tablaCuerpo">
                        <!-- JS llenará esto automáticamente -->
                        <tr><td colspan="4" class="text-center text-muted">Cargando datos...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/dashboard.js"></script>
</body>
</html>