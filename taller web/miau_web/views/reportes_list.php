<?php
require_once __DIR__ . '/../app/helpers.php';

// Verificar que hay usuario logueado
require_login();

// Configuración de la página
$titulo = 'Reportes y Dashboard';
$pagina_actual = 'reportes';
$mostrar_navegacion = true;

$css_adicional = '
    .reports-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .report-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        border-left: 5px solid var(--secondary-color);
    }

    .report-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .report-icon {
        font-size: 2.5rem;
        opacity: 0.8;
    }

    .report-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 5px;
    }

    .report-subtitle {
        color: #666;
        font-size: 0.9rem;
    }

    .placeholder-chart {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 8px;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed #dee2e6;
        margin-bottom: 15px;
    }

    .placeholder-text {
        color: #6c757d;
        font-style: italic;
        text-align: center;
    }

    .report-actions {
        display: flex;
        gap: 10px;
    }

    .btn-report {
        flex: 1;
        padding: 8px 15px;
        border: none;
        border-radius: 6px;
        font-size: 0.85rem;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: var(--secondary-color);
        color: white;
    }

    .btn-export {
        background: var(--success-color);
        color: white;
    }

    .btn-view:hover,
    .btn-export:hover {
        opacity: 0.8;
        text-decoration: none;
        color: white;
    }

    .metrics-overview {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .metric-item {
        text-align: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .metric-value {
        font-size: 2rem;
        font-weight: bold;
        color: var(--secondary-color);
        margin-bottom: 5px;
    }

    .metric-label {
        color: #666;
        font-size: 0.9rem;
    }

    .metric-change {
        font-size: 0.8rem;
        margin-top: 5px;
    }

    .change-positive {
        color: var(--success-color);
    }

    .change-negative {
        color: var(--danger-color);
    }

    .todo-section {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
    }

    .todo-title {
        color: #856404;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .todo-list {
        list-style: none;
        padding: 0;
    }

    .todo-item {
        background: white;
        margin-bottom: 10px;
        padding: 15px;
        border-radius: 6px;
        border-left: 4px solid #f39c12;
    }

    .todo-item h5 {
        margin: 0 0 8px 0;
        color: #856404;
    }

    .todo-item p {
        margin: 0;
        font-size: 0.9rem;
        color: #666;
    }
';

require_once __DIR__ . '/layout/header.php';
?>

<div class="content-wrapper">
    <div class="page-title">📊 Reportes y Dashboard</div>
    
    <!-- Métricas generales -->
    <div class="metrics-overview">
        <h3 style="margin-bottom: 20px; color: var(--primary-color);">Resumen del Mes</h3>
        <div class="metrics-grid">
            <div class="metric-item">
                <div class="metric-value">$2.850.000</div>
                <div class="metric-label">Ingresos Totales</div>
                <div class="metric-change change-positive">↗ +12% vs mes anterior</div>
            </div>
            <div class="metric-item">
                <div class="metric-value">47</div>
                <div class="metric-label">Órdenes Completadas</div>
                <div class="metric-change change-positive">↗ +8% vs mes anterior</div>
            </div>
            <div class="metric-item">
                <div class="metric-value">23</div>
                <div class="metric-label">Nuevos Clientes</div>
                <div class="metric-change change-positive">↗ +15% vs mes anterior</div>
            </div>
            <div class="metric-item">
                <div class="metric-value">3.2</div>
                <div class="metric-label">Días Promedio por Trabajo</div>
                <div class="metric-change change-negative">↗ +0.3 días vs mes anterior</div>
            </div>
        </div>
    </div>

    <!-- Grid de reportes -->
    <div class="reports-grid">
        <!-- Reporte de Ingresos -->
        <div class="report-card">
            <div class="report-header">
                <div class="report-icon">💰</div>
                <div>
                    <div class="report-title">Ingresos Mensuales</div>
                    <div class="report-subtitle">Evolución de facturación por mes</div>
                </div>
            </div>
            <div class="placeholder-chart">
                <div class="placeholder-text">
                    📈 Gráfico de barras<br>
                    Ingresos últimos 12 meses
                </div>
            </div>
            <div class="report-actions">
                <a href="#" class="btn-report btn-view">Ver Detalle</a>
                <a href="#" class="btn-report btn-export">Exportar</a>
            </div>
        </div>

        <!-- Reporte de Repuestos -->
        <div class="report-card">
            <div class="report-header">
                <div class="report-icon">🔧</div>
                <div>
                    <div class="report-title">Repuestos Más Utilizados</div>
                    <div class="report-subtitle">Top 10 productos por rotación</div>
                </div>
            </div>
            <div class="placeholder-chart">
                <div class="placeholder-text">
                    📊 Gráfico circular<br>
                    Repuestos más vendidos
                </div>
            </div>
            <div class="report-actions">
                <a href="#" class="btn-report btn-view">Ver Detalle</a>
                <a href="#" class="btn-report btn-export">Exportar</a>
            </div>
        </div>

        <!-- Reporte de Averías -->
        <div class="report-card">
            <div class="report-header">
                <div class="report-icon">⚠️</div>
                <div>
                    <div class="report-title">Averías Más Frecuentes</div>
                    <div class="report-subtitle">Problemas más comunes por marca/modelo</div>
                </div>
            </div>
            <div class="placeholder-chart">
                <div class="placeholder-text">
                    📊 Gráfico de barras horizontales<br>
                    Tipos de reparación más frecuentes
                </div>
            </div>
            <div class="report-actions">
                <a href="#" class="btn-report btn-view">Ver Detalle</a>
                <a href="#" class="btn-report btn-export">Exportar</a>
            </div>
        </div>

        <!-- Reporte de Rendimiento -->
        <div class="report-card">
            <div class="report-header">
                <div class="report-icon">⏱️</div>
                <div>
                    <div class="report-title">Rendimiento del Taller</div>
                    <div class="report-subtitle">Tiempos de trabajo y eficiencia</div>
                </div>
            </div>
            <div class="placeholder-chart">
                <div class="placeholder-text">
                    📈 Gráfico de líneas<br>
                    Tiempo promedio por tipo de trabajo
                </div>
            </div>
            <div class="report-actions">
                <a href="#" class="btn-report btn-view">Ver Detalle</a>
                <a href="#" class="btn-report btn-export">Exportar</a>
            </div>
        </div>

        <!-- Reporte de Clientes -->
        <div class="report-card">
            <div class="report-header">
                <div class="report-icon">👥</div>
                <div>
                    <div class="report-title">Análisis de Clientes</div>
                    <div class="report-subtitle">Segmentación y comportamiento</div>
                </div>
            </div>
            <div class="placeholder-chart">
                <div class="placeholder-text">
                    📊 Dashboard de métricas<br>
                    Clientes frecuentes, nuevos, inactivos
                </div>
            </div>
            <div class="report-actions">
                <a href="#" class="btn-report btn-view">Ver Detalle</a>
                <a href="#" class="btn-report btn-export">Exportar</a>
            </div>
        </div>

        <!-- Reporte de Inventario -->
        <div class="report-card">
            <div class="report-header">
                <div class="report-icon">📦</div>
                <div>
                    <div class="report-title">Estado del Inventario</div>
                    <div class="report-subtitle">Rotación de stock y alertas</div>
                </div>
            </div>
            <div class="placeholder-chart">
                <div class="placeholder-text">
                    📊 Panel de control<br>
                    Productos con bajo stock, rotación
                </div>
            </div>
            <div class="report-actions">
                <a href="#" class="btn-report btn-view">Ver Detalle</a>
                <a href="#" class="btn-report btn-export">Exportar</a>
            </div>
        </div>
    </div>

    <!-- Sección TODO para desarrolladores -->
    <div class="todo-section">
        <div class="todo-title">
            📝 TO-DO: Implementación de Reportes
        </div>
        <div class="todo-list">
            <div class="todo-item">
                <h5>1. Integración con Chart.js</h5>
                <p>Implementar gráficos interactivos usando Chart.js para visualizar los datos de forma atractiva.</p>
            </div>
            <div class="todo-item">
                <h5>2. Consultas SQL Optimizadas</h5>
                <p>Crear consultas PostgreSQL eficientes para obtener métricas de ingresos, rotación de productos, etc.</p>
            </div>
            <div class="todo-item">
                <h5>3. Exportación a PDF/Excel</h5>
                <p>Implementar funcionalidad de exportación usando librerías como TCPDF o PhpSpreadsheet.</p>
            </div>
            <div class="todo-item">
                <h5>4. Dashboard en Tiempo Real</h5>
                <p>Agregar actualización automática de métricas usando AJAX y WebSockets.</p>
            </div>
            <div class="todo-item">
                <h5>5. Filtros y Fechas Personalizadas</h5>
                <p>Permitir al usuario seleccionar rangos de fechas y filtros específicos para cada reporte.</p>
            </div>
        </div>
    </div>

    <div class="mt-20" style="background: #f8f9fa; padding: 20px; border-radius: 6px; border-left: 4px solid var(--warning-color);">
        <h4 style="margin-bottom: 10px;">📝 Notas de Desarrollo:</h4>
        <ul style="margin: 0; padding-left: 20px; color: #666;">
            <li><strong>Librerías recomendadas:</strong> Chart.js para gráficos, TCPDF para PDF, PhpSpreadsheet para Excel.</li>
            <li><strong>Base de Datos:</strong> Crear vistas y procedimientos almacenados para consultas complejas.</li>
            <li><strong>Performance:</strong> Implementar caché para reportes que no cambian frecuentemente.</li>
            <li><strong>Seguridad:</strong> Controlar acceso a reportes según rol del usuario (admin vs mecánico).</li>
        </ul>
    </div>

    <div class="text-center mt-20">
        <a href="dashboard.php" class="btn-primary">← Volver al Panel</a>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>