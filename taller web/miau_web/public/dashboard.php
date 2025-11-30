<?php
/**
 * Controlador del Dashboard Principal para MIAUtomotriz
 * 
 * Muestra el panel principal con acceso a todos los módulos del sistema
 */

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/auth_service.php';

// Verificar que hay usuario logueado
require_login();

// Actualizar última actividad
actualizar_ultima_actividad();

// Verificar si la sesión ha expirado
if (sesion_expirada()) {
    logout_user();
    redirect('login.php');
}

// Obtener datos del usuario
$usuario = get_logged_user();

// Aquí se pueden cargar datos para el dashboard como:
// - Estadísticas rápidas
// - Notificaciones
// - Actividad reciente
// TODO: Implementar consultas cuando esté la BD

// Cargar la vista del dashboard
require_once __DIR__ . '/../views/dashboard.php';