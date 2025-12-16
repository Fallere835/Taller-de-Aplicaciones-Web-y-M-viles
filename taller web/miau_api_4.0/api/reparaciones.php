<?php
header('Content-Type: application/json');
require '../db.php'; // Tu conexión PDO

$method = $_SERVER['REQUEST_METHOD'];

// --- GET: PARA LISTAR Y GRAFICAR ---
if ($method == 'GET') {
    $action = $_GET['action'] ?? 'list';

    if ($action == 'chart') {
        // Datos para el Dashboard Web (Agrupados)
        $sql = "SELECT estado, COUNT(*) as cantidad FROM reparaciones GROUP BY estado";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

    } else {
        // Datos para la App Móvil y Tabla Web
        // Si mandan 'patente', filtramos. Si no, traemos todo.
        $patente = $_GET['patente'] ?? '';
        
        $sql = "SELECT r.id, r.estado, r.costo_estimado, v.patente, v.modelo 
                FROM reparaciones r 
                JOIN vehiculos v ON r.vehiculo_id = v.id";
        
        if (!empty($patente)) {
            $sql .= " WHERE v.patente ILIKE :patente";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':patente' => "%$patente%"]);
        } else {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}

// --- POST: PARA APROBAR COTIZACIÓN (Móvil) ---
if ($method == 'POST') {
    // Leer JSON de entrada
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['id']) && isset($input['nuevo_estado'])) {
        $sql = "UPDATE reparaciones SET estado = :estado WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute([
            ':estado' => $input['nuevo_estado'],
            ':id' => $input['id']
        ]);
        
        if ($res) {
            echo json_encode(['ok' => true, 'mensaje' => 'Estado actualizado correctamente']);
        } else {
            echo json_encode(['ok' => false, 'mensaje' => 'No se pudo actualizar']);
        }
    } else {
        echo json_encode(['ok' => false, 'mensaje' => 'Datos incompletos']);
    }
}
?>