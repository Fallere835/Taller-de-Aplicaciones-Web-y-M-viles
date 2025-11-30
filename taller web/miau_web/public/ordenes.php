<?php
/**
 * Controlador de Órdenes de Trabajo para MIAUtomotriz
 * 
 * Gestiona las reparaciones y servicios del taller
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

// TODO: Aquí se implementarían las operaciones con órdenes de trabajo:
// - Listar órdenes según el rol del usuario
// - Crear nuevas órdenes de trabajo
// - Actualizar estado de las órdenes
// - Agregar diagnósticos y reparaciones

// Verificar permisos según el rol
$puede_gestionar_ordenes = has_role('ADMIN');
$puede_ver_ordenes = tiene_permiso($usuario['rol'], 'ver_ordenes');
$puede_actualizar_ordenes = tiene_permiso($usuario['rol'], 'actualizar_ordenes');

if (!$puede_ver_ordenes) {
    redirect('dashboard.php');
}

// Procesar acciones si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    
    switch ($accion) {
        case 'crear':
            // TODO: Implementar creación de orden de trabajo
            if ($puede_gestionar_ordenes) {
                // Lógica para crear orden
            }
            break;
            
        case 'actualizar_estado':
            // TODO: Implementar actualización de estado
            if ($puede_actualizar_ordenes || $puede_gestionar_ordenes) {
                // Lógica para actualizar estado
            }
            break;
            
        case 'agregar_diagnostico':
            // TODO: Implementar agregar diagnóstico
            if ($puede_actualizar_ordenes || $puede_gestionar_ordenes) {
                // Lógica para agregar diagnóstico
            }
            break;
    }
}

// TODO: Cargar órdenes de trabajo desde la base de datos
// Filtros según el rol:
// - Admin: puede ver todas las órdenes
// - Mecánico: solo las órdenes asignadas a él o en proceso

// Cargar la vista de órdenes de trabajo
require_once __DIR__ . '/../views/ordenes_list.php';