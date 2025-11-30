<?php
require_once __DIR__ . '/../app/helpers.php';

// Verificar que hay usuario logueado
require_login();

// Configuración de la página
$titulo = 'Gestión de Clientes';
$pagina_actual = 'clientes';
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

    .client-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .client-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--secondary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .client-details {
        flex: 1;
    }

    .client-name {
        font-weight: 600;
        margin-bottom: 2px;
    }

    .client-rut {
        font-size: 0.85rem;
        color: #666;
    }

    .contact-info {
        font-size: 0.9rem;
    }

    .contact-phone {
        font-weight: 500;
        margin-bottom: 2px;
    }

    .contact-email {
        color: #666;
        font-size: 0.85rem;
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

    .btn-history {
        background: #6c757d;
        color: white;
    }

    .btn-view:hover,
    .btn-edit:hover,
    .btn-history:hover {
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
        min-width: 250px;
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

    .summary-number {
        font-size: 1.8rem;
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
    <div class="page-title">👥 Gestión de Clientes</div>
    
    <!-- Resumen de clientes -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-number">147</div>
            <div class="summary-label">Total Clientes</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">23</div>
            <div class="summary-label">Clientes Activos</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">8</div>
            <div class="summary-label">Nuevos este Mes</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">5</div>
            <div class="summary-label">Con Trabajos Pendientes</div>
        </div>
    </div>
    
    <div class="toolbar">
        <div>
            <a href="#" class="btn-primary">+ Nuevo Cliente</a>
        </div>
        <div>
            <input type="search" class="search-box" placeholder="Buscar por nombre, RUT, teléfono...">
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>RUT</th>
                    <th>Contacto</th>
                    <th>Última Visita</th>
                    <th>Total Gastado</th>
                    <th>Vehículos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Datos de ejemplo - TODO: Conectar con base de datos real -->
                <tr>
                    <td>
                        <div class="client-info">
                            <div class="client-avatar">JP</div>
                            <div class="client-details">
                                <div class="client-name">Juan Pérez González</div>
                                <div class="client-rut">12.345.678-9</div>
                            </div>
                        </div>
                    </td>
                    <td><strong>12.345.678-9</strong></td>
                    <td>
                        <div class="contact-info">
                            <div class="contact-phone">+56 9 8765 4321</div>
                            <div class="contact-email">juan.perez@email.com</div>
                        </div>
                    </td>
                    <td>15/11/2024</td>
                    <td><strong>$850.000</strong></td>
                    <td>2 vehículos</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Editar</a>
                            <a href="#" class="btn-action btn-history">Historial</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="client-info">
                            <div class="client-avatar">MG</div>
                            <div class="client-details">
                                <div class="client-name">María González Silva</div>
                                <div class="client-rut">23.456.789-0</div>
                            </div>
                        </div>
                    </td>
                    <td><strong>23.456.789-0</strong></td>
                    <td>
                        <div class="contact-info">
                            <div class="contact-phone">+56 9 7654 3210</div>
                            <div class="contact-email">maria.gonzalez@email.com</div>
                        </div>
                    </td>
                    <td>14/11/2024</td>
                    <td><strong>$420.000</strong></td>
                    <td>1 vehículo</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Editar</a>
                            <a href="#" class="btn-action btn-history">Historial</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="client-info">
                            <div class="client-avatar">CR</div>
                            <div class="client-details">
                                <div class="client-name">Carlos Rodríguez Morales</div>
                                <div class="client-rut">34.567.890-1</div>
                            </div>
                        </div>
                    </td>
                    <td><strong>34.567.890-1</strong></td>
                    <td>
                        <div class="contact-info">
                            <div class="contact-phone">+56 9 6543 2109</div>
                            <div class="contact-email">carlos.rodriguez@email.com</div>
                        </div>
                    </td>
                    <td>10/11/2024</td>
                    <td><strong>$1.250.000</strong></td>
                    <td>3 vehículos</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Editar</a>
                            <a href="#" class="btn-action btn-history">Historial</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="client-info">
                            <div class="client-avatar">AS</div>
                            <div class="client-details">
                                <div class="client-name">Ana Silva Fernández</div>
                                <div class="client-rut">45.678.901-2</div>
                            </div>
                        </div>
                    </td>
                    <td><strong>45.678.901-2</strong></td>
                    <td>
                        <div class="contact-info">
                            <div class="contact-phone">+56 9 5432 1098</div>
                            <div class="contact-email">ana.silva@email.com</div>
                        </div>
                    </td>
                    <td>08/11/2024</td>
                    <td><strong>$320.000</strong></td>
                    <td>1 vehículo</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Editar</a>
                            <a href="#" class="btn-action btn-history">Historial</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="client-info">
                            <div class="client-avatar">PM</div>
                            <div class="client-details">
                                <div class="client-name">Pedro Morales Castro</div>
                                <div class="client-rut">56.789.012-3</div>
                            </div>
                        </div>
                    </td>
                    <td><strong>56.789.012-3</strong></td>
                    <td>
                        <div class="contact-info">
                            <div class="contact-phone">+56 9 4321 0987</div>
                            <div class="contact-email">pedro.morales@email.com</div>
                        </div>
                    </td>
                    <td>05/11/2024</td>
                    <td><strong>$680.000</strong></td>
                    <td>2 vehículos</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Editar</a>
                            <a href="#" class="btn-action btn-history">Historial</a>
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
            <li><strong>Base de Datos:</strong> Tabla `clientes` con relaciones a `vehiculos` y `ordenes_trabajo`.</li>
            <li><strong>Campos adicionales:</strong> Fecha de registro, preferencias, observaciones especiales.</li>
            <li><strong>Funcionalidades:</strong> Historial completo, recordatorios de mantención, alertas de cumpleaños.</li>
            <li><strong>Validaciones:</strong> RUT chileno, formatos de contacto, duplicados por RUT/email.</li>
        </ul>
    </div>

    <div class="text-center mt-20">
        <a href="dashboard.php" class="btn-primary">← Volver al Panel</a>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>