<?php
/**
 * Controlador de Clientes para MIAUtomotriz
 * 
 * Gestiona la visualización y operaciones con la base de datos de clientes
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

// TODO: Aquí se implementarían las operaciones con clientes:
// - Listar clientes con paginación
// - Buscar clientes por filtros
// - Crear/editar/eliminar clientes (según permisos)
// - Obtener historial de cada cliente

// Verificar permisos según el rol
$puede_gestionar_clientes = has_role('ADMIN') || tiene_permiso($usuario['rol'], 'gestionar_clientes');
$puede_ver_clientes = tiene_permiso($usuario['rol'], 'ver_clientes') || $puede_gestionar_clientes;

if (!$puede_ver_clientes) {
    // Redirigir si no tiene permisos para ver clientes
    redirect('dashboard.php');
}

// Procesar acciones si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    
    switch ($accion) {
        case 'crear':
            // TODO: Implementar creación de cliente
            break;
        case 'editar':
            // TODO: Implementar edición de cliente
            break;
        case 'eliminar':
            // TODO: Implementar eliminación de cliente (solo admin)
            break;
    }
}

// TODO: Cargar lista de clientes desde la base de datos
// Por ahora la vista usa datos de ejemplo

// Cargar la vista de lista de clientes
require_once __DIR__ . '/../views/clientes_list.php';