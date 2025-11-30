<?php
/**
 * Controlador de Facturas para MIAUtomotriz
 * 
 * Gestiona la facturación y seguimiento de pagos
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

// TODO: Aquí se implementarían las operaciones con facturas:
// - Listar facturas según permisos
// - Generar nuevas facturas desde órdenes completadas
// - Marcar facturas como pagadas
// - Generar reportes de facturación

// Verificar permisos según el rol
$puede_gestionar_facturas = has_role('ADMIN') || tiene_permiso($usuario['rol'], 'gestionar_facturas');

if (!$puede_gestionar_facturas) {
    redirect('dashboard.php');
}

// Procesar acciones si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    
    switch ($accion) {
        case 'generar':
            // TODO: Implementar generación de factura desde orden
            $orden_id = $_POST['orden_id'] ?? 0;
            if ($orden_id > 0) {
                // Lógica para generar factura
            }
            break;
            
        case 'marcar_pagada':
            // TODO: Implementar marcar como pagada
            $factura_id = $_POST['factura_id'] ?? 0;
            if ($factura_id > 0) {
                // Lógica para marcar como pagada
            }
            break;
            
        case 'enviar_email':
            // TODO: Implementar envío de factura por email
            $factura_id = $_POST['factura_id'] ?? 0;
            if ($factura_id > 0) {
                // Lógica para enviar por email
            }
            break;
            
        case 'generar_pdf':
            // TODO: Implementar generación de PDF
            $factura_id = $_POST['factura_id'] ?? 0;
            if ($factura_id > 0) {
                // Lógica para generar PDF
            }
            break;
    }
}

// TODO: Cargar facturas desde la base de datos
// - Calcular totales y resúmenes
// - Aplicar filtros de fecha, estado, cliente
// - Implementar paginación

// Cargar la vista de facturas
require_once __DIR__ . '/../views/facturas_list.php';