<?php
// config/db.php
$host = '192.168.136.56';
$db   = 'db_automotora';
$user = 'icinf'; // O tu usuario de Raspberry
$pass = 'ICINF'; 
$port = "5432";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;";
    $conn = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    // En producción no mostraríamos el error detallado, pero para alumnos sí.
    die("Error de conexión: " . $e->getMessage());
}
?>