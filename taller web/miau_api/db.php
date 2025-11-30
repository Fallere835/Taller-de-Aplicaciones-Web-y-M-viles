<?php
$host = 'localhost';
$db   = 'db_automotora';
$user = 'admin'; // Usuario de PostgreSQL
$pass = ''; // Password de PostgreSQL
$port = "5432";

try {
    // DSN: Data Source Name
    $direccion = "pgsql:host=$host;port=$port;dbname=$db;";
    $conn = new PDO($direccion, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lanzar excepciones en caso de error
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Traer datos como array asociativo
    ]);
} catch (\PDOException $e) {
    die("Error de conexión: " . $e->getMessage()); // En producción, esto iría a un log
}
?>