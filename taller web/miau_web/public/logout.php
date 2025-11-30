<?php
/**
 * Controlador de Logout para MIAUtomotriz
 * 
 * Cierra la sesión del usuario y lo redirige al login
 */

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/helpers.php';

// Registrar el logout si había usuario logueado
if (is_logged_in()) {
    $usuario = get_logged_user();
    
    // Log del logout
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $mensaje = "Logout - Usuario: {$usuario['username']} - IP: {$ip} - " . date('Y-m-d H:i:s');
    error_log($mensaje);
}

// Cerrar sesión
logout_user();

// Redirigir al login
redirect('login.php');