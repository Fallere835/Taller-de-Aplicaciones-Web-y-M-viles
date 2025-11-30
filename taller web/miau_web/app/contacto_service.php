<?php
/**
 * Servicio de Contacto para MIAUtomotriz
 * 
 * Maneja la validación y procesamiento del formulario de contacto.
 * Continuidad con la clase anterior de formularios PHP.
 */

require_once __DIR__ . '/helpers.php';

/**
 * Valida los datos del formulario de contacto
 * 
 * @param array $datos Datos del formulario
 * @return array Resultado de la validación con errores y valores
 */
function validar_contacto(array $datos): array 
{
    $errores = [];
    $valores = [
        'nombre' => trim($datos['nombre'] ?? ''),
        'email' => trim($datos['email'] ?? ''),
        'mensaje' => trim($datos['mensaje'] ?? '')
    ];

    // Validación del nombre
    if (empty($valores['nombre'])) {
        $errores['nombre'] = 'El nombre es obligatorio.';
    } elseif (strlen($valores['nombre']) < 2) {
        $errores['nombre'] = 'El nombre debe tener al menos 2 caracteres.';
    } elseif (strlen($valores['nombre']) > 100) {
        $errores['nombre'] = 'El nombre no puede tener más de 100 caracteres.';
    } elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $valores['nombre'])) {
        $errores['nombre'] = 'El nombre solo puede contener letras y espacios.';
    }

    // Validación del email
    if (empty($valores['email'])) {
        $errores['email'] = 'El correo electrónico es obligatorio.';
    } elseif (!is_valid_email($valores['email'])) {
        $errores['email'] = 'El formato del correo electrónico no es válido.';
    } elseif (strlen($valores['email']) > 150) {
        $errores['email'] = 'El correo electrónico es demasiado largo.';
    }

    // Validación del mensaje
    if (empty($valores['mensaje'])) {
        $errores['mensaje'] = 'El mensaje es obligatorio.';
    } elseif (strlen($valores['mensaje']) < 10) {
        $errores['mensaje'] = 'El mensaje debe tener al menos 10 caracteres.';
    } elseif (strlen($valores['mensaje']) > 1000) {
        $errores['mensaje'] = 'El mensaje no puede tener más de 1000 caracteres.';
    }

    return [
        'errores' => $errores,
        'valores' => $valores,
        'es_valido' => empty($errores)
    ];
}

/**
 * Procesa el formulario de contacto
 * 
 * @param array $post_data Datos POST del formulario
 * @return array Resultado del procesamiento
 */
function procesar_contacto(array $post_data): array 
{
    // Validar token CSRF
    if (!isset($post_data['csrf_token']) || !csrf_validate($post_data['csrf_token'])) {
        return [
            'exito' => false,
            'mensaje' => 'Token de seguridad inválido. Intente nuevamente.',
            'errores' => [],
            'valores' => []
        ];
    }

    $validacion = validar_contacto($post_data);
    
    if (!$validacion['es_valido']) {
        return [
            'exito' => false,
            'mensaje' => 'Por favor corrige los errores del formulario.',
            'errores' => $validacion['errores'],
            'valores' => $validacion['valores']
        ];
    }

    // Si la validación es exitosa, procesar el contacto
    $resultado_envio = enviar_contacto($validacion['valores']);
    
    if ($resultado_envio['exito']) {
        return [
            'exito' => true,
            'mensaje' => 'Mensaje enviado exitosamente. Te contactaremos pronto.',
            'errores' => [],
            'valores' => ['nombre' => '', 'email' => '', 'mensaje' => ''] // Limpiar formulario
        ];
    } else {
        return [
            'exito' => false,
            'mensaje' => 'Error al enviar el mensaje. Intenta nuevamente.',
            'errores' => [],
            'valores' => $validacion['valores']
        ];
    }
}

/**
 * Envía el mensaje de contacto (simula envío por email o guardar en BD)
 * 
 * @param array $datos Datos validados del contacto
 * @return array Resultado del envío
 */
function enviar_contacto(array $datos): array 
{
    try {
        // TODO: Aquí se implementaría el envío real por email
        // o guardar en base de datos
        
        // Por ahora simular el envío
        $mensaje_log = sprintf(
            "Nuevo contacto - Nombre: %s, Email: %s, Mensaje: %s - Fecha: %s",
            $datos['nombre'],
            $datos['email'],
            substr($datos['mensaje'], 0, 50) . '...',
            date('Y-m-d H:i:s')
        );
        
        error_log($mensaje_log);
        
        // TODO: Implementar una de estas opciones:
        // 1. Envío por email usando PHPMailer o similar
        // 2. Guardar en tabla 'contactos' en PostgreSQL
        // 3. Envío a un servicio externo de email
        
        // Simular éxito del envío
        return [
            'exito' => true,
            'mensaje' => 'Contacto procesado exitosamente'
        ];
        
    } catch (Exception $e) {
        error_log("Error al procesar contacto: " . $e->getMessage());
        
        return [
            'exito' => false,
            'mensaje' => 'Error interno al procesar el contacto'
        ];
    }
}

/**
 * Sanitiza los datos del contacto para mostrar en log o base de datos
 * 
 * @param array $datos Datos del contacto
 * @return array Datos sanitizados
 */
function sanitizar_datos_contacto(array $datos): array 
{
    return [
        'nombre' => h($datos['nombre']),
        'email' => filter_var($datos['email'], FILTER_SANITIZE_EMAIL),
        'mensaje' => h($datos['mensaje'])
    ];
}

/**
 * Obtiene estadísticas de contactos (para futuras implementaciones)
 * 
 * @return array Estadísticas básicas
 */
function obtener_estadisticas_contacto(): array 
{
    // TODO: Implementar consultas reales cuando esté la BD
    return [
        'total_contactos' => 0,
        'contactos_mes_actual' => 0,
        'promedio_diario' => 0
    ];
}

/**
 * Lista los contactos recientes (para panel de administración)
 * 
 * @param int $limite Cantidad máxima de contactos a retornar
 * @return array Lista de contactos
 */
function listar_contactos_recientes(int $limite = 10): array 
{
    // TODO: Implementar consulta real a la tabla contactos
    // Por ahora retornar array vacío
    return [];
}

/**
 * Obtiene un contacto por ID (para ver detalle)
 * 
 * @param int $id ID del contacto
 * @return array|null Datos del contacto o null si no existe
 */
function obtener_contacto_por_id(int $id): ?array 
{
    // TODO: Implementar consulta real a la tabla contactos
    return null;
}

/**
 * Marca un contacto como respondido
 * 
 * @param int $id ID del contacto
 * @param string $respuesta Respuesta dada
 * @return bool True si se actualizó correctamente
 */
function marcar_contacto_respondido(int $id, string $respuesta): bool 
{
    // TODO: Implementar actualización en BD
    return false;
}