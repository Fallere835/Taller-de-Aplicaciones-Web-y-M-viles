<?php
// controllers/auth.php
session_start();
// Ajustamos la ruta para salir de 'controllers' y entrar a 'config'
require '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Guardamos datos en sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['user_rol'] = $user['rol'];

        // Redirigir al dashboard (que está en views)
        header("Location: ../views/dashboard.php");
        exit;
    } else {
        // Redirigir al login con error
        header("Location: ../views/login.php?error=Credenciales incorrectas");
        exit;
    }
}
?>