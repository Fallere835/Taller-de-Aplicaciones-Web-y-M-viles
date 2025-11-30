<?php
require_once __DIR__ . '/../app/helpers.php';

// Verificar que hay usuario logueado
require_login();

// Configuración de la página
$titulo = 'Mis Cotizaciones';
$pagina_actual = 'cotizaciones';
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

    .status-aprobada {
        background: #d4edda;
        color: #155724;
    }

    .status-pendiente {
        background: #fff3cd;
        color: #856404;
    }

    .status-rechazada {
        background: #f8d7da;
        color: #721c24;
    }

    .status-vencida {
        background: #e2e3e5;
        color: #495057;
    }

    .validity {
        font-size: 0.85rem;
        color: #666;
    }

    .validity.expired {
        color: #dc3545;
        font-weight: 500;
    }

    .amount {
        font-weight: 600;
        color: var(--primary-color);
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
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

    .btn-edit {
        background: var(--warning-color);
        color: white;
    }

    .btn-approve {
        background: var(--success-color);
        color: white;
    }

    .btn-send {
        background: #6c757d;
        color: white;
    }

    .btn-view:hover,
    .btn-edit:hover,
    .btn-approve:hover,
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
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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

    .summary-number {
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
    <div class="page-title">📋 Mis Cotizaciones</div>
    
    <!-- Resumen de cotizaciones -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-number">23</div>
            <div class="summary-label">Total Cotizaciones</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">8</div>
            <div class="summary-label">Pendientes</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">12</div>
            <div class="summary-label">Aprobadas</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">3</div>
            <div class="summary-label">Rechazadas</div>
        </div>
    </div>
    
    <div class="toolbar">
        <div>
            <a href="#" class="btn-primary">+ Nueva Cotización</a>
        </div>
        <div>
            <input type="search" class="search-box" placeholder="Buscar cotizaciones...">
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nº Cotización</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Descripción</th>
                    <th>Validez</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Datos de ejemplo - TODO: Conectar con base de datos real -->
                <tr>
                    <td><strong>COT-001</strong></td>
                    <td>15/11/2024</td>
                    <td>Juan Pérez</td>
                    <td>Cambio de frenos delanteros</td>
                    <td>
                        <span class="validity">Hasta 30/11/2024</span>
                    </td>
                    <td><span class="status-badge status-pendiente">Pendiente</span></td>
                    <td class="amount">$350.000</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Editar</a>
                            <a href="#" class="btn-action btn-send">Enviar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>COT-002</strong></td>
                    <td>12/11/2024</td>
                    <td>María González</td>
                    <td>Mantención 20.000 km</td>
                    <td>
                        <span class="validity">Hasta 27/11/2024</span>
                    </td>
                    <td><span class="status-badge status-aprobada">Aprobada</span></td>
                    <td class="amount">$180.000</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-approve">Procesar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>COT-003</strong></td>
                    <td>10/11/2024</td>
                    <td>Carlos Rodríguez</td>
                    <td>Reparación de motor</td>
                    <td>
                        <span class="validity expired">Venció 25/11/2024</span>
                    </td>
                    <td><span class="status-badge status-vencida">Vencida</span></td>
                    <td class="amount">$850.000</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Renovar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>COT-004</strong></td>
                    <td>08/11/2024</td>
                    <td>Ana Silva</td>
                    <td>Cambio de neumáticos</td>
                    <td>
                        <span class="validity">Hasta 23/11/2024</span>
                    </td>
                    <td><span class="status-badge status-rechazada">Rechazada</span></td>
                    <td class="amount">$280.000</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Modificar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>COT-005</strong></td>
                    <td>05/11/2024</td>
                    <td>Pedro Morales</td>
                    <td>Sistema de aire acondicionado</td>
                    <td>
                        <span class="validity">Hasta 20/11/2024</span>
                    </td>
                    <td><span class="status-badge status-aprobada">Aprobada</span></td>
                    <td class="amount">$450.000</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-approve">Procesar</a>
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
            <li><strong>Base de Datos:</strong> Tabla `cotizaciones` con campos para validez, términos y condiciones.</li>
            <li><strong>Estados:</strong> Pendiente, Aprobada, Rechazada, Vencida, Procesada</li>
            <li><strong>Funcionalidades:</strong> Generación PDF, envío automático, seguimiento, conversión a orden de trabajo.</li>
            <li><strong>Automatización:</strong> Recordatorios antes del vencimiento, alertas de cotizaciones aprobadas.</li>
        </ul>
    </div>

    <div class="text-center mt-20">
        <a href="dashboard.php" class="btn-primary">← Volver al Panel</a>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>