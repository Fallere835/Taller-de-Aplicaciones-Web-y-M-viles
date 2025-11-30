<?php
header('Content-Type: application/json');
require '../db.php';

// Permitir recibir JSON o POST normal (Volley a veces manda x-www-form-urlencoded)
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

// Si vienen por JSON raw (otra forma común en Android)
if (!$email) {
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);
    $email = $input['email'] ?? null;
    $password = $input['password'] ?? null;
}

if (!$email || !$password) {
    echo json_encode(["ok" => false, "msg" => "Faltan datos"]);
    exit;
}

$stmt = $conn->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = :email");
$stmt->execute([':email' => $email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    echo json_encode([
        "ok" => true,
        "usuario" => [
            "id" => $user['id'],
            "nombre" => $user['nombre'],
            "rol" => $user['rol']
        ]
    ]);
} else {
    echo json_encode(["ok" => false, "msg" => "Usuario o clave incorrectos"]);
}
?>