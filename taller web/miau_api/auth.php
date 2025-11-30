<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Buscar usuario por email
    $stmt = $conn->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    // 2. Verificar contraseña HASHED
    if ($user && password_verify($password, $user['password'])) {
        // Login correcto
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['user_rol'] = $user['rol'];

        header("Location: dashboard.php"); // Redirigir al panel
        exit;
    } else {
        // Login fallido
        header("Location: login.php?error=Credenciales incorrectas");
        exit;
    }
}
?>