<?php
require_once __DIR__ . '/../app/helpers.php';

// Verificar que hay usuario logueado
require_login();

// Configuración de la página
$titulo = 'Mis Reparaciones';
$pagina_actual = 'ordenes';
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

    .status-pendiente {
        background: #fff3cd;
        color: #856404;
    }

    .status-proceso {
        background: #d1ecf1;
        color: #0c5460;
    }

    .status-completado {
        background: #d4edda;
        color: #155724;
    }

    .status-entregado {
        background: #d4edda;
        color: #155724;
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

    .btn-edit {
        background: var(--warning-color);
        color: white;
    }

    .btn-view:hover,
    .btn-edit:hover {
        opacity: 0.8;
        text-decoration: none;
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #666;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.5;
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
';

require_once __DIR__ . '/layout/header.php';
?>

<div class="content-wrapper">
    <div class="page-title">🔧 Mis Reparaciones</div>
    
    <div class="toolbar">
        <div>
            <a href="#" class="btn-primary">+ Nueva Reparación</a>
        </div>
        <div>
            <input type="search" class="search-box" placeholder="Buscar por patente, cliente...">
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nº Orden</th>
                    <th>Fecha Ingreso</th>
                    <th>Patente</th>
                    <th>Vehículo</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Datos de ejemplo - TODO: Conectar con base de datos real -->
                <tr>
                    <td><strong>#ORD-001</strong></td>
                    <td>15/11/2024</td>
                    <td><strong>ABC-123</strong></td>
                    <td>Toyota Corolla 2020</td>
                    <td>Juan Pérez</td>
                    <td><span class="status-badge status-proceso">En Proceso</span></td>
                    <td>$350.000</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Editar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>#ORD-002</strong></td>
                    <td>14/11/2024</td>
                    <td><strong>DEF-456</strong></td>
                    <td>Honda Civic 2019</td>
                    <td>María González</td>
                    <td><span class="status-badge status-completado">Completado</span></td>
                    <td>$180.000</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Editar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>#ORD-003</strong></td>
                    <td>13/11/2024</td>
                    <td><strong>GHI-789</strong></td>
                    <td>Nissan Sentra 2021</td>
                    <td>Carlos Rodríguez</td>
                    <td><span class="status-badge status-entregado">Entregado</span></td>
                    <td>$95.000</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                        </div>
                    </td>
                </tr>
                
                <!-- Fila vacía para mostrar que no hay más datos -->
                <!-- TODO: En la implementación real, esta sección se generará dinámicamente -->
            </tbody>
        </table>
    </div>

    <div class="mt-20" style="background: #f8f9fa; padding: 20px; border-radius: 6px; border-left: 4px solid var(--warning-color);">
        <h4 style="margin-bottom: 10px;">📝 Notas de Desarrollo:</h4>
        <ul style="margin: 0; padding-left: 20px; color: #666;">
            <li><strong>Base de Datos:</strong> Los datos mostrados son ejemplos. Se conectará con tabla `ordenes_trabajo` en PostgreSQL.</li>
            <li><strong>Estados:</strong> Pendiente → En Proceso → Completado → Entregado</li>
            <li><strong>Funcionalidades a implementar:</strong> CRUD completo, filtros, búsqueda, impresión de órdenes.</li>
            <li><strong>Permisos:</strong> Mecánicos pueden ver y actualizar. Administradores: acceso total.</li>
        </ul>
    </div>

    <div class="text-center mt-20">
        <a href="dashboard.php" class="btn-primary">← Volver al Panel</a>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>