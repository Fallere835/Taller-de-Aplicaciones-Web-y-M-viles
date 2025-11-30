<?php
/**
 * Punto de entrada principal de la aplicación MIAUtomotriz
 * 
 * Redirige al usuario según su estado de sesión:
 * - Si está logueado: lo lleva al dashboard
 * - Si no está logueado: lo lleva al login
 */

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/helpers.php';

// Si ya hay un usuario logueado, redirigir al dashboard
if (is_logged_in()) {
    redirect('/../public/dashboard.php');
}

// Si no hay usuario logueado, redirigir al login
redirect('/../public/login.php');