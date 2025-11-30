<?php
require_once __DIR__ . '/../app/helpers.php';

// Verificar que hay usuario logueado
require_login();

// Configuración de la página
$titulo = 'Inventario de Repuestos';
$pagina_actual = 'inventario';
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

    .product-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .product-image {
        width: 50px;
        height: 50px;
        background: #f8f9fa;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        border: 2px solid #e9ecef;
    }

    .product-details {
        flex: 1;
    }

    .product-name {
        font-weight: 600;
        margin-bottom: 3px;
    }

    .product-code {
        font-size: 0.85rem;
        color: #666;
        font-family: monospace;
    }

    .stock-level {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .stock-low {
        color: #dc3545;
    }

    .stock-medium {
        color: #fd7e14;
    }

    .stock-good {
        color: #28a745;
    }

    .stock-badge {
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        margin-left: 8px;
    }

    .badge-low {
        background: #f8d7da;
        color: #721c24;
    }

    .badge-medium {
        background: #fff3cd;
        color: #856404;
    }

    .badge-good {
        background: #d4edda;
        color: #155724;
    }

    .price {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 1.05rem;
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

    .btn-restock {
        background: var(--success-color);
        color: white;
    }

    .btn-view:hover,
    .btn-edit:hover,
    .btn-restock:hover {
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

    .toolbar-left {
        display: flex;
        gap: 15px;
        align-items: center;
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

    .filter-select {
        padding: 8px 15px;
        border: 2px solid #e9ecef;
        border-radius: 6px;
        font-size: 0.9rem;
        background: white;
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

    .alert-low-stock {
        background: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 6px;
        border: 1px solid #f5c6cb;
        margin-bottom: 20px;
    }
';

require_once __DIR__ . '/layout/header.php';
?>

<div class="content-wrapper">
    <div class="page-title">📦 Inventario de Repuestos</div>
    
    <!-- Alerta de stock bajo -->
    <div class="alert-low-stock">
        <strong>⚠️ Alerta de Stock:</strong> Hay 3 productos con stock bajo que requieren reposición.
    </div>
    
    <!-- Resumen del inventario -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-number">245</div>
            <div class="summary-label">Total Productos</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">$2.850.000</div>
            <div class="summary-label">Valor Total Inventario</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">23</div>
            <div class="summary-label">Stock Bajo</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">8</div>
            <div class="summary-label">Sin Stock</div>
        </div>
    </div>
    
    <div class="toolbar">
        <div class="toolbar-left">
            <a href="#" class="btn-primary">+ Nuevo Producto</a>
            <select class="filter-select">
                <option value="">Todas las categorías</option>
                <option value="frenos">Frenos</option>
                <option value="motor">Motor</option>
                <option value="suspension">Suspensión</option>
                <option value="electrico">Sistema Eléctrico</option>
                <option value="neumaticos">Neumáticos</option>
                <option value="aceites">Aceites y Fluidos</option>
            </select>
        </div>
        <div>
            <input type="search" class="search-box" placeholder="Buscar por código, nombre...">
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Código</th>
                    <th>Categoría</th>
                    <th>Stock</th>
                    <th>Precio Costo</th>
                    <th>Precio Venta</th>
                    <th>Último Ingreso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Datos de ejemplo - TODO: Conectar con base de datos real -->
                <tr>
                    <td>
                        <div class="product-info">
                            <div class="product-image">🔧</div>
                            <div class="product-details">
                                <div class="product-name">Pastillas de Freno Delanteras</div>
                                <div class="product-code">FRENO-001</div>
                            </div>
                        </div>
                    </td>
                    <td><strong>FRENO-001</strong></td>
                    <td>Frenos</td>
                    <td>
                        <span class="stock-level stock-low">3</span>
                        <span class="stock-badge badge-low">Bajo</span>
                    </td>
                    <td>$25.000</td>
                    <td class="price">$40.000</td>
                    <td>10/11/2024</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Editar</a>
                            <a href="#" class="btn-action btn-restock">Reabastecer</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="product-info">
                            <div class="product-image">🛢️</div>
                            <div class="product-details">
                                <div class="product-name">Aceite Motor 5W-30</div>
                                <div class="product-code">ACEITE-003</div>
                            </div>
                        </div>
                    </td>
                    <td><strong>ACEITE-003</strong></td>
                    <td>Aceites y Fluidos</td>
                    <td>
                        <span class="stock-level stock-good">25</span>
                        <span class="stock-badge badge-good">Bueno</span>
                    </td>
                    <td>$8.500</td>
                    <td class="price">$15.000</td>
                    <td>15/11/2024</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Editar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="product-info">
                            <div class="product-image">⚙️</div>
                            <div class="product-details">
                                <div class="product-name">Filtro de Aire</div>
                                <div class="product-code">FILTRO-012</div>
                            </div>
                        </div>
                    </td>
                    <td><strong>FILTRO-012</strong></td>
                    <td>Filtros</td>
                    <td>
                        <span class="stock-level stock-medium">8</span>
                        <span class="stock-badge badge-medium">Medio</span>
                    </td>
                    <td>$12.000</td>
                    <td class="price">$22.000</td>
                    <td>12/11/2024</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Editar</a>
                            <a href="#" class="btn-action btn-restock">Reabastecer</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="product-info">
                            <div class="product-image">🔋</div>
                            <div class="product-details">
                                <div class="product-name">Batería 12V 60Ah</div>
                                <div class="product-code">BAT-045</div>
                            </div>
                        </div>
                    </td>
                    <td><strong>BAT-045</strong></td>
                    <td>Sistema Eléctrico</td>
                    <td>
                        <span class="stock-level stock-good">6</span>
                        <span class="stock-badge badge-good">Bueno</span>
                    </td>
                    <td>$85.000</td>
                    <td class="price">$120.000</td>
                    <td>08/11/2024</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Editar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="product-info">
                            <div class="product-image">🏎️</div>
                            <div class="product-details">
                                <div class="product-name">Amortiguador Delantero</div>
                                <div class="product-code">SUSP-028</div>
                            </div>
                        </div>
                    </td>
                    <td><strong>SUSP-028</strong></td>
                    <td>Suspensión</td>
                    <td>
                        <span class="stock-level stock-low">2</span>
                        <span class="stock-badge badge-low">Bajo</span>
                    </td>
                    <td>$45.000</td>
                    <td class="price">$75.000</td>
                    <td>05/11/2024</td>
                    <td>
                        <div class="actions">
                            <a href="#" class="btn-action btn-view">Ver</a>
                            <a href="#" class="btn-action btn-edit">Editar</a>
                            <a href="#" class="btn-action btn-restock">Reabastecer</a>
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
            <li><strong>Base de Datos:</strong> Tabla `inventario` con control de stock mínimo, rotación, proveedores.</li>
            <li><strong>Alertas:</strong> Notificaciones automáticas cuando stock < mínimo configurado.</li>
            <li><strong>Movimientos:</strong> Registro de entradas/salidas, ajustes de inventario, mermas.</li>
            <li><strong>Integración:</strong> Con órdenes de trabajo, cotizaciones, sistema de compras.</li>
        </ul>
    </div>

    <div class="text-center mt-20">
        <a href="dashboard.php" class="btn-primary">← Volver al Panel</a>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>