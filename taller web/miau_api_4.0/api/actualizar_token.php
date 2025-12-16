<?php
// public/api/actualizar_token.php
header('Content-Type: application/json');
require '../../config/db.php';

$input = json_decode(file_get_contents('php://input'), true);
$email = $input['email'] ?? ''; // O ID de usuario
$token = $input['token'] ?? '';

if (empty($email) || empty($token)) {
    echo json_encode(['ok' => false, 'msg' => 'Faltan datos']);
    exit;
}

try {
    // Guardamos el token en la tabla usuarios asociado a ese email
    // Asume que agregaste una columna 'fcm_token' a tu tabla usuarios
    $sql = "UPDATE usuarios SET fcm_token = :token WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':token' => $token, ':email' => $email]);

    echo json_encode(['ok' => true, 'msg' => 'Token actualizado']);
} catch (Exception $e) {
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
?>