<?php
/**
 * Servicio de Autenticación para MIAUtomotriz
 * 
 * Maneja la lógica de autenticación de usuarios.
 * En esta versión inicial usa usuarios hardcodeados.
 * 
 * TODO: Reemplazar por consultas reales a PostgreSQL con password_hash/password_verify
 */

require_once __DIR__ . '/helpers.php';

/**
 * Usuarios de prueba hardcodeados
 * TODO: Estos usuarios se eliminarán cuando se implemente la BD real
 */
const USUARIOS_PRUEBA = [
    'admin_demo' => [
        'id' => 1,
        'username' => 'admin_demo',
        'password' => 'admin123', // TODO: Usar password_hash en BD real
        'rol' => 'ADMIN',
        'nombre_completo' => 'Administrador Demo',
        'email' => 'admin@miautomotriz.cl'
    ],
    'mec_demo' => [
        'id' => 2,
        'username' => 'mec_demo',
        'password' => 'mec123', // TODO: Usar password_hash en BD real
        'rol' => 'MECANICO',
        'nombre_completo' => 'Mecánico Demo',
        'email' => 'mecanico@miautomotriz.cl'
    ]
];

/**
 * Intenta autenticar un usuario
 * 
 * @param string $username Nombre de usuario
 * @param string $password Contraseña
 * @return array Resultado del intento de login
 */
function intentar_login(string $username, string $password): array 
{
    // Validaciones básicas
    if (empty($username) || empty($password)) {
        return [
            'ok' => false,
            'error' => 'Usuario y contraseña son requeridos.'
        ];
    }

    // TODO: En la versión con BD, aquí haríamos:
    // 1. Buscar usuario por username en la tabla usuarios
    // 2. Verificar password con password_verify()
    // 3. Retornar datos del usuario si es válido
    
    // Por ahora, buscar en el array hardcodeado
    if (isset(USUARIOS_PRUEBA[$username])) {
        $usuario = USUARIOS_PRUEBA[$username];
        
        // Verificar contraseña (en BD sería password_verify)
        if ($usuario['password'] === $password) {
            // Login exitoso - remover password del array de retorno
            $usuario_sin_password = $usuario;
            unset($usuario_sin_password['password']);
            
            return [
                'ok' => true,
                'usuario' => $usuario_sin_password
            ];
        }
    }
    
    // Login fallido
    return [
        'ok' => false,
        'error' => 'Usuario o contraseña incorrectos.'
    ];
}

/**
 * Valida si un rol es válido
 * 
 * @param string $rol Rol a validar
 * @return bool True si es válido, false en caso contrario
 */
function es_rol_valido(string $rol): bool 
{
    return in_array($rol, ['ADMIN', 'MECANICO']);
}

/**
 * Obtiene los permisos de un rol
 * 
 * @param string $rol Rol del usuario
 * @return array Permisos del rol
 */
function obtener_permisos_rol(string $rol): array 
{
    switch ($rol) {
        case 'ADMIN':
            return [
                'ver_dashboard',
                'gestionar_clientes',
                'ver_ordenes',
                'gestionar_facturas',
                'gestionar_cotizaciones',
                'gestionar_inventario',
                'ver_reportes',
                'gestionar_usuarios'
            ];
            
        case 'MECANICO':
            return [
                'ver_dashboard',
                'ver_clientes',
                'ver_ordenes',
                'actualizar_ordenes',
                'ver_inventario',
                'actualizar_inventario'
            ];
            
        default:
            return [];
    }
}

/**
 * Verifica si un usuario tiene un permiso específico
 * 
 * @param string $rol Rol del usuario
 * @param string $permiso Permiso a verificar
 * @return bool True si tiene el permiso, false en caso contrario
 */
function tiene_permiso(string $rol, string $permiso): bool 
{
    $permisos = obtener_permisos_rol($rol);
    return in_array($permiso, $permisos);
}

/**
 * Procesa el formulario de login
 * 
 * @param array $post_data Datos del formulario POST
 * @return array Resultado del procesamiento
 */
function procesar_login(array $post_data): array 
{
    // Validar token CSRF si está presente
    if (isset($post_data['csrf_token'])) {
        if (!csrf_validate($post_data['csrf_token'])) {
            return [
                'ok' => false,
                'error' => 'Token de seguridad inválido. Intente nuevamente.'
            ];
        }
    }
    
    $username = trim($post_data['username'] ?? '');
    $password = $post_data['password'] ?? '';
    
    return intentar_login($username, $password);
}

/**
 * Registra un intento de login (para auditoría)
 * 
 * @param string $username Username del intento
 * @param bool $exitoso Si el login fue exitoso
 * @param string $ip IP del cliente
 * @return void
 */
function registrar_intento_login(string $username, bool $exitoso, string $ip): void 
{
    // TODO: En la versión con BD, guardar en tabla de auditoría
    // Por ahora solo log en error_log
    $estado = $exitoso ? 'EXITOSO' : 'FALLIDO';
    $mensaje = "Login {$estado} - Usuario: {$username} - IP: {$ip} - " . date('Y-m-d H:i:s');
    
    error_log($mensaje);
}

/**
 * Obtiene información del usuario logueado desde la sesión
 * 
 * @return array|null Datos del usuario o null si no está logueado
 */
function obtener_usuario_actual(): ?array 
{
    return get_logged_user();
}

/**
 * Actualiza la última actividad del usuario en sesión
 * 
 * @return void
 */
function actualizar_ultima_actividad(): void 
{
    if (is_logged_in()) {
        $_SESSION['ultima_actividad'] = time();
    }
}

/**
 * Verifica si la sesión ha expirado
 * 
 * @param int $tiempo_limite Tiempo límite en segundos (default: 2 horas)
 * @return bool True si ha expirado, false en caso contrario
 */
function sesion_expirada(int $tiempo_limite = 7200): bool 
{
    if (!isset($_SESSION['ultima_actividad'])) {
        return false;
    }
    
    return (time() - $_SESSION['ultima_actividad']) > $tiempo_limite;
}