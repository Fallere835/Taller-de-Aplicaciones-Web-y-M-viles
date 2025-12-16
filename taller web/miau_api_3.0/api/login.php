<?php
// api/login.php
header('Content-Type: application/json');
require '../db.php'; // Asegúrate de tener tu db.php con PDO

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Recibir JSON crudo (Mejor compatibilidad con Android/Volley y JS/Fetch)
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Si no es JSON, intentar leer POST tradicional (fallback)
    $email = $data['email'] ?? $_POST['email'] ?? '';
    $pass  = $data['password'] ?? $_POST['password'] ?? '';

    if (empty($email) || empty($pass)) {
        echo json_encode(['ok' => false, 'msg' => 'Faltan datos']);
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($pass, $user['password'])) {
            // LOGIN ÉXITOSO
            // Iniciamos sesión PHP para la parte Web
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['rol'] = $user['rol'];

            echo json_encode([
                'ok' => true, 
                'msg' => 'Bienvenido',
                'usuario' => [
                    'id' => $user['id'],
                    'nombre' => $user['nombre'],
                    'rol' => $user['rol']
                ]
            ]);
        } else {
            echo json_encode(['ok' => false, 'msg' => 'Credenciales inválidas']);
        }
    } catch (Exception $e) {
        echo json_encode(['ok' => false, 'msg' => 'Error de servidor']);
    }
} else {
    echo json_encode(['ok' => false, 'msg' => 'Método no permitido']);
}
?>