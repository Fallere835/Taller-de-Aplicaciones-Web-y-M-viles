
<?php
require 'db.php';

// La contraseña real será '123456'
$pass_hash = password_hash("123456", PASSWORD_DEFAULT);

try {
    $sql = "INSERT INTO usuarios (email, password, nombre, rol) VALUES 
            ('admin@automotora.cl', :pass, 'Admin Sistema', 'admin'),
            ('mecanico@automotora.cl', :pass, 'Roberto Mecánico', 'mecanico')";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([':pass' => $pass_hash]);
    echo "Usuarios creados con éxito. Pass: 123456";
} catch (PDOException $e) {
    echo "Error (probablemente ya existen): " . $e->getMessage();
}
?>