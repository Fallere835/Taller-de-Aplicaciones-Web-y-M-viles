<?php
/**
 * Configuración de la aplicación MIAUtomotriz
 * 
 * Archivo de configuración principal donde se define la conexión a la base de datos
 * y otras configuraciones generales del sistema.
 */

/**
 * Configuración de la base de datos PostgreSQL
 * TODO: Completar con las credenciales reales del servidor
 */
define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'miau_automotriz');
define('DB_USER', 'postgres');
define('DB_PASS', 'password');

/**
 * Configuración general de la aplicación
 */
define('APP_NAME', 'MIAUtomotriz');
define('APP_URL', 'http://localhost');

/**
 * Función para obtener conexión a la base de datos
 * 
 * @return PDO|null Conexión PDO o null si hay error
 */
function db(): ?PDO 
{
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            // TODO: Implementar conexión real a PostgreSQL
            // Por ahora retornamos null para desarrollo inicial
            
            /*
            $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
            */
            
            // Descomentar línea siguiente cuando se configure la BD real:
            // return $pdo;
            
            return null; // Por ahora retorna null
            
        } catch (PDOException $e) {
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            return null;
        }
    }
    
    return $pdo;
}

/**
 * Configuración de zona horaria
 */
date_default_timezone_set('America/Santiago');

/**
 * Configuración de sesión
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}