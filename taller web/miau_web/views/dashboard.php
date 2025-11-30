<?php
require_once __DIR__ . '/../app/helpers.php';

// Verificar que hay usuario logueado
$usuario = get_logged_user();
if (!$usuario) {
    redirect('login.php');
}

// Configuración de la página
$titulo = 'Panel Principal';
$pagina_actual = 'dashboard';
$mostrar_navegacion = true;

$css_adicional = '
    .dashboard-welcome {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        text-align: center;
    }

    .welcome-message {
        font-size: 1.8rem;
        font-weight: 300;
        margin-bottom: 10px;
    }

    .welcome-subtitle {
        opacity: 0.9;
        font-size: 1rem;
    }

    .user-role-badge {
        background: rgba(255,255,255,0.2);
        padding: 5px 15px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 15px;
        font-size: 0.9rem;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .dashboard-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border-left: 5px solid var(--secondary-color);
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        text-decoration: none;
        color: inherit;
    }

    .card-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        opacity: 0.8;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--primary-color);
    }

    .card-description {
        color: #666;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .card-action {
        color: var(--secondary-color);
        font-weight: 500;
        font-size: 0.95rem;
    }

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: var(--secondary-color);
        display: block;
    }

    .stat-label {
        color: #666;
        font-size: 0.9rem;
        margin-top: 5px;
    }

    .recent-activity {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .activity-title {
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--primary-color);
    }

    .activity-item {
        padding: 15px 0;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--light-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .activity-content {
        flex: 1;
    }

    .activity-text {
        font-weight: 500;
        margin-bottom: 3px;
    }

    .activity-time {
        font-size: 0.8rem;
        color: #666;
    }

    /* Colores específicos para roles */
    .role-admin .dashboard-card {
        border-left-color: var(--admin-secondary);
    }

    .role-mecanico .dashboard-card {
        border-left-color: var(--mechanic-secondary);
    }

    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .dashboard-stats {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .welcome-message {
            font-size: 1.5rem;
        }
    }
';

require_once __DIR__ . '/layout/header.php';
?>

<div class="content-wrapper role-<?= strtolower($usuario['rol']) ?>">
    <!-- Mensaje de bienvenida -->
    <div class="dashboard-welcome">
        <h1 class="welcome-message">¡Bienvenido, <?= h($usuario['nombre_completo']) ?>!</h1>
        <p class="welcome-subtitle">Sistema de gestión MIAUtomotriz</p>
        <span class="user-role-badge"><?= h($usuario['rol']) ?></span>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="dashboard-stats">
        <div class="stat-card">
            <span class="stat-number">--</span>
            <div class="stat-label">Órdenes Activas</div>
        </div>
        <div class="stat-card">
            <span class="stat-number">--</span>
            <div class="stat-label">Clientes</div>
        </div>
        <div class="stat-card">
            <span class="stat-number">--</span>
            <div class="stat-label">Facturas Pendientes</div>
        </div>
        <div class="stat-card">
            <span class="stat-number">--</span>
            <div class="stat-label">Repuestos Disponibles</div>
        </div>
    </div>

    <!-- Menú principal de navegación -->
    <div class="dashboard-grid">
        <a href="ordenes.php" class="dashboard-card">
            <div class="card-icon">🔧</div>
            <h3 class="card-title">Mis Reparaciones</h3>
            <p class="card-description">
                Gestiona las órdenes de trabajo, diagnósticos y reparaciones en curso.
            </p>
            <span class="card-action">Ir a Reparaciones →</span>
        </a>

        <a href="facturas.php" class="dashboard-card">
            <div class="card-icon">💰</div>
            <h3 class="card-title">Mis Facturas</h3>
            <p class="card-description">
                Consulta el estado de facturación y pagos de los trabajos realizados.
            </p>
            <span class="card-action">Ver Facturas →</span>
        </a>

        <a href="cotizaciones.php" class="dashboard-card">
            <div class="card-icon">📋</div>
            <h3 class="card-title">Mis Cotizaciones</h3>
            <p class="card-description">
                Revisa y gestiona las cotizaciones enviadas a clientes.
            </p>
            <span class="card-action">Gestionar Cotizaciones →</span>
        </a>

        <a href="clientes.php" class="dashboard-card">
            <div class="card-icon">👥</div>
            <h3 class="card-title">Clientes</h3>
            <p class="card-description">
                Base de datos de clientes, sus vehículos e historial de servicios.
            </p>
            <span class="card-action">Ver Clientes →</span>
        </a>

        <a href="inventario.php" class="dashboard-card">
            <div class="card-icon">📦</div>
            <h3 class="card-title">Inventario</h3>
            <p class="card-description">
                Control de stock de repuestos, herramientas y materiales.
            </p>
            <span class="card-action">Gestionar Inventario →</span>
        </a>

        <a href="reportes.php" class="dashboard-card">
            <div class="card-icon">📊</div>
            <h3 class="card-title">Reportes</h3>
            <p class="card-description">
                Análisis de rendimiento, ingresos y estadísticas del taller.
            </p>
            <span class="card-action">Ver Reportes →</span>
        </a>
    </div>

    <!-- Actividad reciente -->
    <div class="recent-activity">
        <h3 class="activity-title">Actividad Reciente</h3>
        
        <div class="activity-item">
            <div class="activity-icon">🔧</div>
            <div class="activity-content">
                <div class="activity-text">Nueva orden de trabajo creada</div>
                <div class="activity-time">Hace 2 horas - TODO: Conectar con BD real</div>
            </div>
        </div>
        
        <div class="activity-item">
            <div class="activity-icon">💰</div>
            <div class="activity-content">
                <div class="activity-text">Factura pagada</div>
                <div class="activity-time">Hace 4 horas - TODO: Conectar con BD real</div>
            </div>
        </div>
        
        <div class="activity-item">
            <div class="activity-icon">👤</div>
            <div class="activity-content">
                <div class="activity-text">Nuevo cliente registrado</div>
                <div class="activity-time">Hace 1 día - TODO: Conectar con BD real</div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 20px; color: #666; font-style: italic;">
            <!-- TODO: Aquí se mostrará actividad real desde la base de datos -->
            Las actividades mostradas son de ejemplo. Se conectarán con datos reales en siguientes iteraciones.
        </div>
    </div>
</div>

<?php
$js_adicional = '
    // Actualizar estadísticas cada cierto tiempo (cuando esté conectado a BD)
    function actualizarEstadisticas() {
        // TODO: Implementar llamada AJAX para actualizar estadísticas
        console.log("TODO: Actualizar estadísticas desde BD");
    }

    // Cada 5 minutos actualizar estadísticas
    // setInterval(actualizarEstadisticas, 300000);
';

require_once __DIR__ . '/layout/footer.php';
?>