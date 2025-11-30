<?php
/**
 * Controlador de Cotizaciones para MIAUtomotriz
 * 
 * Gestiona las cotizaciones y seguimiento de aprobaciones
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

// TODO: Aquí se implementarían las operaciones con cotizaciones:
// - Listar cotizaciones según estado y fecha
// - Crear nuevas cotizaciones
// - Actualizar estado (pendiente, aprobada, rechazada, vencida)
// - Convertir cotizaciones aprobadas en órdenes de trabajo

// Verificar permisos según el rol
$puede_gestionar_cotizaciones = has_role('ADMIN') || tiene_permiso($usuario['rol'], 'gestionar_cotizaciones');

if (!$puede_gestionar_cotizaciones) {
    redirect('dashboard.php');
}

// Procesar acciones si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    
    switch ($accion) {
        case 'crear':
            // TODO: Implementar creación de cotización
            $datos_cotizacion = [
                'cliente_id' => $_POST['cliente_id'] ?? 0,
                'descripcion' => $_POST['descripcion'] ?? '',
                'items' => $_POST['items'] ?? [],
                'validez_dias' => $_POST['validez_dias'] ?? 15,
                'observaciones' => $_POST['observaciones'] ?? ''
            ];
            // Lógica para crear cotización
            break;
            
        case 'actualizar_estado':
            // TODO: Implementar actualización de estado
            $cotizacion_id = $_POST['cotizacion_id'] ?? 0;
            $nuevo_estado = $_POST['estado'] ?? '';
            if ($cotizacion_id > 0 && in_array($nuevo_estado, ['pendiente', 'aprobada', 'rechazada', 'vencida'])) {
                // Lógica para actualizar estado
            }
            break;
            
        case 'convertir_orden':
            // TODO: Implementar conversión a orden de trabajo
            $cotizacion_id = $_POST['cotizacion_id'] ?? 0;
            if ($cotizacion_id > 0) {
                // Verificar que la cotización esté aprobada
                // Crear nueva orden de trabajo basada en la cotización
            }
            break;
            
        case 'enviar_email':
            // TODO: Implementar envío de cotización por email
            $cotizacion_id = $_POST['cotizacion_id'] ?? 0;
            if ($cotizacion_id > 0) {
                // Generar PDF de la cotización y enviar por email
            }
            break;
            
        case 'duplicar':
            // TODO: Implementar duplicación de cotización
            $cotizacion_id = $_POST['cotizacion_id'] ?? 0;
            if ($cotizacion_id > 0) {
                // Crear nueva cotización basada en una existente
            }
            break;
    }
}

// TODO: Cargar cotizaciones desde la base de datos
// - Aplicar filtros de estado, cliente, fecha
// - Calcular estadísticas (total pendiente, aprobadas, etc.)
// - Verificar vencimientos y actualizar estados automáticamente
// - Implementar paginación

// Cargar la vista de cotizaciones
require_once __DIR__ . '/../views/cotizaciones_list.php';