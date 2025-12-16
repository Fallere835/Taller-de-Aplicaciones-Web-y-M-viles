<?php
/**
 * seeder_completo.php
 * 
 * PROPÓSITO:
 * Poblar la base de datos con datos de prueba para la Clase 4.
 * Incluye datos para todos los gráficos del dashboard.
 * 
 * EJECUCIÓN:
 * Abrir en navegador: http://localhost/seeder_completo.php
 * O ejecutar: php seeder_completo.php
 * 
 * IMPORTANTE:
 * ✓ Este script ELIMINA todos los datos existentes
 * ✓ Solo usar en ambiente de desarrollo
 * ✓ NO ejecutar en producción
 */

require_once 'config/db.php';

echo "<h1>🌱 Seeder MIAUtomotriz - Clase 4</h1>";
echo "<pre>";

try {
    $conn->beginTransaction();
    
    // ========================================
    // 1. LIMPIAR TABLAS (ORDEN IMPORTANTE POR FOREIGN KEYS)
    // ========================================
    echo "🗑️  Limpiando tablas existentes...\n";
    
    $conn->exec("TRUNCATE TABLE detalle_repuesto CASCADE");
    $conn->exec("TRUNCATE TABLE facturas CASCADE");
    $conn->exec("TRUNCATE TABLE reparaciones CASCADE");
    $conn->exec("TRUNCATE TABLE repuestos CASCADE");
    $conn->exec("TRUNCATE TABLE vehiculos CASCADE");
    $conn->exec("TRUNCATE TABLE clientes CASCADE");
    $conn->exec("TRUNCATE TABLE usuarios CASCADE");
    
    // Reiniciar secuencias
    $conn->exec("ALTER SEQUENCE usuarios_id_seq RESTART WITH 1");
    $conn->exec("ALTER SEQUENCE clientes_id_seq RESTART WITH 1");
    $conn->exec("ALTER SEQUENCE vehiculos_id_seq RESTART WITH 1");
    $conn->exec("ALTER SEQUENCE reparaciones_id_seq RESTART WITH 1");
    $conn->exec("ALTER SEQUENCE repuestos_id_seq RESTART WITH 1");
    $conn->exec("ALTER SEQUENCE facturas_id_seq RESTART WITH 1");
    
    echo "✅ Tablas limpiadas\n\n";
    
    // ========================================
    // 2. USUARIOS
    // ========================================
    echo "👥 Insertando usuarios...\n";
    
    $usuarios = [
        ['Admin', 'admin@miau.cl', password_hash('admin123', PASSWORD_DEFAULT), 'admin'],
        ['Carlos Méndez', 'carlos@miau.cl', password_hash('mecanico123', PASSWORD_DEFAULT), 'mecanico'],
        ['Pedro González', 'pedro@mail.com', password_hash('cliente123', PASSWORD_DEFAULT), 'cliente']
    ];
    
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
    foreach ($usuarios as $u) {
        $stmt->execute($u);
    }
    echo "✅ {$stmt->rowCount()} usuarios insertados\n\n";
    
    // ========================================
    // 3. CLIENTES
    // ========================================
    echo "📋 Insertando clientes...\n";
    
    $clientes = [
        ['Juan Pérez', '12345678-9', '+56912345678', 'juan@mail.com'],
        ['María González', '98765432-1', '+56987654321', 'maria@mail.com'],
        ['Roberto Sánchez', '11223344-5', '+56911223344', 'roberto@mail.com'],
        ['Ana Martínez', '55667788-9', '+56955667788', 'ana@mail.com'],
        ['Luis Torres', '99887766-5', '+56999887766', 'luis@mail.com']
    ];
    
    $stmt = $conn->prepare("INSERT INTO clientes (nombre, rut, telefono, email) VALUES (?, ?, ?, ?)");
    foreach ($clientes as $c) {
        $stmt->execute($c);
    }
    echo "✅ {$stmt->rowCount()} clientes insertados\n\n";
    
    // ========================================
    // 4. VEHÍCULOS
    // ========================================
    echo "🚗 Insertando vehículos...\n";
    
    $vehiculos = [
        ['ABCD12', 'Toyota', 'Corolla', 2018, 85000, 1],
        ['EFGH34', 'Nissan', 'Sentra', 2020, 45000, 1],
        ['IJKL56', 'Chevrolet', 'Cruze', 2019, 62000, 2],
        ['MNOP78', 'Hyundai', 'Accent', 2021, 28000, 3],
        ['QRST90', 'Kia', 'Rio', 2017, 95000, 4],
        ['UVWX12', 'Mazda', '3', 2022, 15000, 5],
        ['YZAB34', 'Ford', 'Focus', 2016, 110000, 2],
        ['CDEF56', 'Honda', 'Civic', 2019, 58000, 3]
    ];
    
    $stmt = $conn->prepare("INSERT INTO vehiculos (patente, marca, modelo, año, kilometraje, cliente_id) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($vehiculos as $v) {
        $stmt->execute($v);
    }
    echo "✅ {$stmt->rowCount()} vehículos insertados\n\n";
    
    // ========================================
    // 5. REPUESTOS
    // ========================================
    echo "🔩 Insertando repuestos...\n";
    
    $repuestos = [
        ['Filtro de aceite', 15000],
        ['Filtro de aire', 12000],
        ['Pastillas de freno delanteras', 45000],
        ['Pastillas de freno traseras', 38000],
        ['Aceite motor 5W30 (4L)', 28000],
        ['Batería 12V 60Ah', 85000],
        ['Bujías (set 4)', 32000],
        ['Correa de distribución', 65000],
        ['Amortiguador delantero', 120000],
        ['Neumático 185/65 R15', 55000],
        ['Líquido de frenos DOT4 (1L)', 18000],
        ['Refrigerante motor (5L)', 22000]
    ];
    
    $stmt = $conn->prepare("INSERT INTO repuestos (nombre, precio_unitario) VALUES (?, ?)");
    foreach ($repuestos as $r) {
        $stmt->execute($r);
    }
    echo "✅ {$stmt->rowCount()} repuestos insertados\n\n";
    
    // ========================================
    // 6. REPARACIONES (CON DIFERENTES ESTADOS Y TIPOS)
    // ========================================
    echo "🔧 Insertando reparaciones...\n";
    
    $tiposAveria = [
        'Sistema de frenos',
        'Motor',
        'Suspensión',
        'Sistema eléctrico',
        'Transmisión',
        'Refrigeración',
        'Escape',
        'Neumáticos'
    ];
    
    $estados = ['pendiente', 'en_proceso', 'completado', 'entregado'];
    
    $reparaciones = [];
    
    // Crear 20 reparaciones variadas
    for ($i = 1; $i <= 20; $i++) {
        $vehiculoId = rand(1, 8);
        $estado = $estados[array_rand($estados)];
        $tipoAveria = $tiposAveria[array_rand($tiposAveria)];
        $diasAtras = rand(1, 90);
        $fechaIngreso = date('Y-m-d H:i:s', strtotime("-$diasAtras days"));
        $fechaEntrega = date('Y-m-d', strtotime("+3 days", strtotime($fechaIngreso)));
        $costoManoObra = rand(30, 150) * 1000;
        $costoEstimado = $costoManoObra + rand(50, 200) * 1000;
        
        $diagnosticos = [
            'Desgaste normal de componentes',
            'Revisión preventiva según kilometraje',
            'Falla detectada por cliente',
            'Mantenimiento programado',
            'Ruidos anormales detectados',
            'Pérdida de rendimiento'
        ];
        
        $diagnostico = $diagnosticos[array_rand($diagnosticos)];
        
        $reparaciones[] = [
            $vehiculoId,
            $fechaIngreso,
            $fechaEntrega,
            $estado,
            $diagnostico,
            $tipoAveria,
            $costoEstimado,
            $costoManoObra
        ];
    }
    
    $stmt = $conn->prepare("INSERT INTO reparaciones 
                            (vehiculo_id, fecha_ingreso, fecha_entrega, estado, diagnostico, tipo_averia, costo_estimado, costo_mano_obra) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($reparaciones as $rep) {
        $stmt->execute($rep);
    }
    
    echo "✅ {$stmt->rowCount()} reparaciones insertadas\n\n";
    
    // ========================================
    // 7. DETALLE DE REPUESTOS (Relación N:N)
    // ========================================
    echo "🔩 Asignando repuestos a reparaciones...\n";
    
    $stmt = $conn->prepare("INSERT INTO detalle_repuesto (id_reparacion, id_repuesto, cantidad) VALUES (?, ?, ?)");
    
    $totalDetalles = 0;
    for ($repId = 1; $repId <= 20; $repId++) {
        // Cada reparación usa entre 1 y 5 repuestos
        $cantRepuestos = rand(1, 5);
        
        for ($i = 0; $i < $cantRepuestos; $i++) {
            $repuestoId = rand(1, 12);
            $cantidad = rand(1, 4);
            
            $stmt->execute([$repId, $repuestoId, $cantidad]);
            $totalDetalles++;
        }
    }
    
    echo "✅ $totalDetalles detalles de repuestos insertados\n\n";
    
    // ========================================
    // 8. FACTURAS (PARA GRÁFICO DE INGRESOS MENSUALES)
    // ========================================
    echo "💰 Generando facturas...\n";
    
    $stmt = $conn->prepare("INSERT INTO facturas (id_reparacion, fecha, monto_total, metodo_pago) VALUES (?, ?, ?, ?)");
    
    $metodosPago = ['efectivo', 'tarjeta', 'transferencia'];
    
    // Generar facturas para los últimos 12 meses
    for ($mes = 0; $mes < 12; $mes++) {
        $cantFacturas = rand(3, 8); // Entre 3 y 8 facturas por mes
        
        for ($i = 0; $i < $cantFacturas; $i++) {
            $reparacionId = rand(1, 20);
            $diasAtras = ($mes * 30) + rand(0, 29);
            $fecha = date('Y-m-d', strtotime("-$diasAtras days"));
            $montoTotal = rand(80, 500) * 1000;
            $metodoPago = $metodosPago[array_rand($metodosPago)];
            
            $stmt->execute([$reparacionId, $fecha, $montoTotal, $metodoPago]);
        }
    }
    
    echo "✅ Facturas generadas para gráfico de ingresos\n\n";
    
    // ========================================
    // COMMIT
    // ========================================
    $conn->commit();
    
    echo "\n";
    echo "====================================\n";
    echo "✅ SEEDER COMPLETADO EXITOSAMENTE\n";
    echo "====================================\n\n";
    
    echo "📊 RESUMEN:\n";
    echo "- Usuarios: " . count($usuarios) . "\n";
    echo "- Clientes: " . count($clientes) . "\n";
    echo "- Vehículos: " . count($vehiculos) . "\n";
    echo "- Repuestos: " . count($repuestos) . "\n";
    echo "- Reparaciones: " . count($reparaciones) . "\n";
    echo "- Detalles de repuestos: $totalDetalles\n\n";
    
    echo "🔐 CREDENCIALES:\n";
    echo "Admin    -> admin@miau.cl / admin123\n";
    echo "Mecánico -> carlos@miau.cl / mecanico123\n";
    echo "Cliente  -> pedro@mail.com / cliente123\n\n";
    
    echo "🚀 Ahora puedes:\n";
    echo "1. Acceder al dashboard: views/dashboard.php\n";
    echo "2. Ver los 4 gráficos con datos reales\n";
    echo "3. Generar PDFs: api/orden_pdf.php?id=1\n";
    
} catch (PDOException $e) {
    $conn->rollBack();
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "Revisa que todas las tablas existan en la BD.\n";
}

echo "</pre>";
?>
