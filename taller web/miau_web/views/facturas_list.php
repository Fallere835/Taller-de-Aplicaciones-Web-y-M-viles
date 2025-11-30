<?php
require_once __DIR__ . '/../app/helpers.php';

// Verificar que hay usuario logueado
require_login();

// Configuración de la página
$titulo = 'Mis Facturas';
$pagina_actual = 'facturas';
$mostrar_navegacion = true;

$css_adicional = '
    .table-container {
        overflow-x: auto;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        margin: 0;
    }

    .data-table th,
    .data-table td {
        padding: 15px 12px;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }

    .data-table th {
        background: var(--primary-color);
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .data-table tr:hover {
        background: #f8f9fa;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .status-pagada {
        background: #d4edda;
        color: #155724;
    }

    .status-pendiente {
        background: #fff3cd;
        color: #856404;
    }

    .status-vencida {
        background: #f8d7da;
        color: #721c24;
    }

    .amount {
        font-weight: 600;
        color: var(--primary-color);
    }

    .actions {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        font-size: 0.8rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: var(--secondary-color);
        color: white;
    }

    .btn-download {
        background: var(--success-color);
        color: white;
    }

    .btn-send {
        background: var(--warning-color);
        color: white;
    }

    .btn-view:hover,
    .btn-download:hover,
    .btn-send:hover {
        opacity: 0.8;
        text-decoration: none;
        color: white;
    }

    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .btn-primary {
        background: var(--secondary-color);
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        opacity: 0.9;
        text-decoration: none;
        color: white;
    }

    .search-box {
        padding: 8px 15px;
        border: 2px solid #e9ecef;
        border-radius: 6px;
        font-size: 0.9rem;
        min-width: 200px;
    }

    .search-box:focus {
        outline: none;
        border-color: var(--secondary-color);
    }

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .summary-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
    }

    .summary-amount {
        font-size: 1.5rem;
        font-weight: bold;
        color: var(--secondary-color);
    }

    .summary-label {
        color: #666;
        font-size: 0.9rem;
        margin-top: 5px;
    }
';

require_once __DIR__ . '/layout/header.php';
?>

<div class="content-wrapper">
    <div class="page-title">💰 Mis Facturas</div>
    
    <!-- Resumen de facturas -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-amount">$1.250.000</div>
            <div class="summary-label">Total Facturado</div>
        </div>
        <div class="summary-card">
            <div class="summary-amount">$850.000</div>
            <div class="summary-label">Pagado</div>
        </div>
        <div class="summary-card">
            <div class="summary-amount">$400.000</div>
            <div class="summary-label">Pendiente</div>
        </div>
        <div class="summary-card">
            <div class="summary-amount">15</div>
            <div class="summary-label">Total Facturas</div>
        </div>
    </div>
    
    <div class="toolbar">
        <div>
            <a href="#" class="btn-primary">+ Nueva Factura</a>
        </div>
        <div>
            <input type="search" class="search-box" placeholder="Buscar facturas...">
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nº Factura</th>
                    <th>Fecha Emisión</th>
                    <th>Cliente</th>
                    <th>Orden Asociada</th>
                    <th>Estado</th>
                    <th>Vencimiento</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Datos de ejemplo - TODO: Conectar con base de datos real -->
                <tr>
                    <td><strong>FAC-001</strong></td>
                    <td>15/11/2024</td>
                    <td>Juan Pérez</td>
                    <td>#ORD-001</td>
                    <td><span class="status-badge status-pendiente">Pendiente</span></td>
                    <td>30/11/2024</td>
                    <td class="amount">$350.000</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-download">PDF</a>
                            <a href="#" class="btn-action btn-send">Enviar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>FAC-002</strong></td>
                    <td>14/11/2024</td>
                    <td>María González</td>
                    <td>#ORD-002</td>
                    <td><span class="status-badge status-pagada">Pagada</span></td>
                    <td>29/11/2024</td>
                    <td class="amount">$180.000</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-download">PDF</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>FAC-003</strong></td>
                    <td>10/11/2024</td>
                    <td>Carlos Rodríguez</td>
                    <td>#ORD-003</td>
                    <td><span class="status-badge status-vencida">Vencida</span></td>
                    <td>25/11/2024</td>
                    <td class="amount">$95.000</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-download">PDF</a>
                            <a href="#" class="btn-action btn-send">Recordar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>FAC-004</strong></td>
                    <td>08/11/2024</td>
                    <td>Ana Silva</td>
                    <td>#ORD-004</td>
                    <td><span class="status-badge status-pagada">Pagada</span></td>
                    <td>23/11/2024</td>
                    <td class="amount">$125.000</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-download">PDF</a>
                        </div>
                    </td>
                </tr>
                
                <!-- TODO: En la implementación real, estas filas se generarán dinámicamente -->
            </tbody>
        </table>
    </div>

    <div class="mt-20" style="background: #f8f9fa; padding: 20px; border-radius: 6px; border-left: 4px solid var(--warning-color);">
        <h4 style="margin-bottom: 10px;">📝 Notas de Desarrollo:</h4>
        <ul style="margin: 0; padding-left: 20px; color: #666;">
            <li><strong>Base de Datos:</strong> Los datos se almacenarán en tabla `facturas` con relación a `ordenes_trabajo`.</li>
            <li><strong>Estados:</strong> Pendiente, Pagada, Vencida, Anulada</li>
            <li><strong>Funcionalidades a implementar:</strong> Generación PDF, envío por email, recordatorios automáticos.</li>
            <li><strong>Integración:</strong> Sistema de pagos, contabilidad, reportes fiscales (SII).</li>
        </ul>
    </div>

    <div class="text-center mt-20">
        <a href="dashboard.php" class="btn-primary">← Volver al Panel</a>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>