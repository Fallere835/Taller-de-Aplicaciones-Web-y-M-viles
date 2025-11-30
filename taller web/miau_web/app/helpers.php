<?php
/**
 * Funciones auxiliares para la aplicación MIAUtomotriz
 * 
 * Este archivo contiene funciones de utilidad para el manejo de sesiones,
 * escape de HTML, redirecciones y otras operaciones comunes.
 */

require_once __DIR__ . '/config.php';

/**
 * Escapa cadenas HTML para prevenir ataques XSS
 * 
 * @param string $value Valor a escapar
 * @return string Valor escapado
 */
function h(string $value): string 
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Redirige a una ruta específica y termina la ejecución
 * 
 * @param string $path Ruta a la que redirigir
 * @return void
 */
function redirect(string $path): void 
{
    // Si no comienza con http, asumimos que es una ruta relativa
    if (!str_starts_with($path, 'http')) {
        $path = '/' . ltrim($path, '/');
    }
    
    header('Location: ' . $path);
    exit;
}

/**
 * Verifica si hay un usuario logueado en la sesión
 * 
 * @return bool True si está logueado, false en caso contrario
 */
function is_logged_in(): bool 
{
    return isset($_SESSION['usuario']) && !empty($_SESSION['usuario']['id']);
}

/**
 * Obtiene los datos del usuario logueado
 * 
 * @return array|null Datos del usuario o null si no está logueado
 */
function get_logged_user(): ?array 
{
    return $_SESSION['usuario'] ?? null;
}

/**
 * Requiere que haya un usuario logueado, si no redirige al login
 * 
 * @return void
 */
function require_login(): void 
{
    if (!is_logged_in()) {
        redirect('login.php');
    }
}

/**
 * Verifica si el usuario logueado tiene un rol específico
 * 
 * @param string $rol Rol requerido (ADMIN o MECANICO)
 * @return bool True si tiene el rol, false en caso contrario
 */
function has_role(string $rol): bool 
{
    $user = get_logged_user();
    return $user && isset($user['rol']) && $user['rol'] === $rol;
}

/**
 * Requiere que el usuario logueado tenga un rol específico
 * 
 * @param string $rol Rol requerido
 * @return void
 */
function require_role(string $rol): void 
{
    require_login();
    
    if (!has_role($rol)) {
        redirect('dashboard.php'); // Redirige al dashboard si no tiene el rol
    }
}

/**
 * Inicia sesión con los datos del usuario
 * 
 * @param array $usuario Datos del usuario
 * @return void
 */
function login_user(array $usuario): void 
{
    $_SESSION['usuario'] = $usuario;
    $_SESSION['login_time'] = time();
}

/**
 * Cierra la sesión del usuario
 * 
 * @return void
 */
function logout_user(): void 
{
    session_destroy();
    session_start(); // Reinicia una sesión limpia
}

/**
 * Genera un token CSRF para formularios
 * 
 * @return string Token CSRF
 */
function csrf_token(): string 
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Valida un token CSRF
 * 
 * @param string $token Token a validar
 * @return bool True si es válido, false en caso contrario
 */
function csrf_validate(string $token): bool 
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Formatea una fecha en formato chileno
 * 
 * @param string $date Fecha a formatear
 * @return string Fecha formateada
 */
function format_date(string $date): string 
{
    $timestamp = strtotime($date);
    return date('d/m/Y', $timestamp);
}

/**
 * Formatea una fecha con hora
 * 
 * @param string $datetime Fecha y hora a formatear
 * @return string Fecha y hora formateada
 */
function format_datetime(string $datetime): string 
{
    $timestamp = strtotime($datetime);
    return date('d/m/Y H:i', $timestamp);
}

/**
 * Formatea un número como moneda chilena
 * 
 * @param float $amount Cantidad a formatear
 * @return string Cantidad formateada
 */
function format_currency(float $amount): string 
{
    return '$' . number_format($amount, 0, ',', '.');
}

/**
 * Valida un email
 * 
 * @param string $email Email a validar
 * @return bool True si es válido, false en caso contrario
 */
function is_valid_email(string $email): bool 
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Valida un RUT chileno
 * 
 * @param string $rut RUT a validar
 * @return bool True si es válido, false en caso contrario
 */
function is_valid_rut(string $rut): bool 
{
    // TODO: Implementar validación completa de RUT chileno
    // Por ahora solo verificamos que tenga el formato básico
    return preg_match('/^\d{1,8}-[0-9kK]$/', $rut) === 1;
}

/**
 * Limpia y formatea un RUT
 * 
 * @param string $rut RUT a limpiar
 * @return string RUT limpio
 */
function clean_rut(string $rut): string 
{
    // Elimina puntos y espacios, convierte a mayúsculas
    return strtoupper(str_replace(['.', ' '], '', $rut));
}