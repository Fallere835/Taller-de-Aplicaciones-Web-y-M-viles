<?php
// config/db.php
$host = 'localhost';
$db   = 'db_automotora';
$user = ''; // O tu usuario de Raspberry
$pass = ''; 
$port = "";

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