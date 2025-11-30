<?php
/**
 * Controlador de Contacto para MIAUtomotriz
 * 
 * Maneja tanto la visualización como el procesamiento del formulario de contacto
 */

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/contacto_service.php';

// Variables para la vista
$errores = [];
$valores = ['nombre' => '', 'email' => '', 'mensaje' => ''];
$exito = false;
$mensaje_error = '';

// Procesar formulario si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = procesar_contacto($_POST);
    
    if ($resultado['exito']) {
        // Contacto enviado exitosamente
        $exito = true;
        $valores = $resultado['valores']; // Formulario limpio
    } else {
        // Error en el contacto
        $errores = $resultado['errores'];
        $valores = $resultado['valores'];
        $mensaje_error = $resultado['mensaje'];
    }
} else {
    // Si es GET, mostrar formulario vacío
    // Los valores ya están inicializados arriba
}

// Cargar la vista del formulario de contacto
require_once __DIR__ . '/../views/contacto_form.php';