<?php
/**
 * Controlador de Inventario para MIAUtomotriz
 * 
 * Gestiona el stock de repuestos, herramientas y materiales
 */

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/auth_service.php';

// Verificar que hay usuario logueado
require_login();

// Actualizar última actividad
actualizar_ultima_actividad();

// Obtener datos del usuario actual
$usuario = get_logged_user();

// TODO: Aquí se implementarían las operaciones con inventario:
// - Listar productos con stock actual
// - Alertas de stock bajo
// - Movimientos de entrada y salida
// - Ajustes de inventario
// - Control de costos y precios

// Verificar permisos según el rol
$puede_gestionar_inventario = has_role('ADMIN') || tiene_permiso($usuario['rol'], 'gestionar_inventario');
$puede_ver_inventario = tiene_permiso($usuario['rol'], 'ver_inventario') || $puede_gestionar_inventario;
$puede_actualizar_inventario = tiene_permiso($usuario['rol'], 'actualizar_inventario');

if (!$puede_ver_inventario) {
    redirect('dashboard.php');
}

// Procesar acciones si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    
    switch ($accion) {
        case 'crear_producto':
            // TODO: Implementar creación de producto
            if ($puede_gestionar_inventario) {
                $datos_producto = [
                    'codigo' => $_POST['codigo'] ?? '',
                    'nombre' => $_POST['nombre'] ?? '',
                    'categoria' => $_POST['categoria'] ?? '',
                    'precio_costo' => $_POST['precio_costo'] ?? 0,
                    'precio_venta' => $_POST['precio_venta'] ?? 0,
                    'stock_inicial' => $_POST['stock_inicial'] ?? 0,
                    'stock_minimo' => $_POST['stock_minimo'] ?? 0,
                    'ubicacion' => $_POST['ubicacion'] ?? '',
                    'proveedor' => $_POST['proveedor'] ?? ''
                ];
                // Lógica para crear producto
            }
            break;
            
        case 'actualizar_stock':
            // TODO: Implementar actualización de stock
            if ($puede_actualizar_inventario || $puede_gestionar_inventario) {
                $producto_id = $_POST['producto_id'] ?? 0;
                $cantidad = $_POST['cantidad'] ?? 0;
                $tipo_movimiento = $_POST['tipo'] ?? 'entrada'; // entrada, salida, ajuste
                $motivo = $_POST['motivo'] ?? '';
                
                if ($producto_id > 0 && $cantidad != 0) {
                    // Registrar movimiento de inventario
                    // Actualizar stock actual
                }
            }
            break;
            
        case 'actualizar_precios':
            // TODO: Implementar actualización de precios
            if ($puede_gestionar_inventario) {
                $producto_id = $_POST['producto_id'] ?? 0;
                $nuevo_precio_costo = $_POST['precio_costo'] ?? 0;
                $nuevo_precio_venta = $_POST['precio_venta'] ?? 0;
                
                if ($producto_id > 0) {
                    // Actualizar precios del producto
                    // Registrar cambio de precios para auditoría
                }
            }
            break;
            
        case 'transferir_stock':
            // TODO: Implementar transferencia entre ubicaciones
            if ($puede_gestionar_inventario) {
                $producto_id = $_POST['producto_id'] ?? 0;
                $ubicacion_origen = $_POST['ubicacion_origen'] ?? '';
                $ubicacion_destino = $_POST['ubicacion_destino'] ?? '';
                $cantidad = $_POST['cantidad'] ?? 0;
                
                // Lógica para transferir stock
            }
            break;
    }
}

// TODO: Cargar datos del inventario desde la base de datos
// - Productos con stock actual
// - Alertas de stock bajo
// - Últimos movimientos
// - Estadísticas de valor total del inventario
// - Filtros por categoría, proveedor, estado

// Cargar la vista de inventario
require_once __DIR__ . '/../views/inventario_list.php';