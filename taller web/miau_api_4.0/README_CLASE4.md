# 🚀 GUÍA RÁPIDA PARA ALUMNOS - CLASE 4

## ⚡ Inicio Rápido (5 minutos)

### 1️⃣ Configurar Base de Datos

```bash
# En pgAdmin o terminal de PostgreSQL:
# 1. Crear la base de datos
CREATE DATABASE db_automotora;

# 2. Ejecutar el schema (copiar y pegar todo el contenido de schema.sql)
```

### 2️⃣ Configurar Conexión

Editar `config/db.php`:
```php
$host = 'localhost';
$db   = 'db_automotora';
$user = 'postgres';        // Tu usuario de PostgreSQL
$pass = 'tu_contraseña';   // Tu contraseña
$port = "5432";
```

### 3️⃣ Poblar Datos de Prueba

Abrir en navegador:
```
http://localhost/seeder_completo.php
```

Deberías ver: ✅ SEEDER COMPLETADO EXITOSAMENTE

### 4️⃣ Probar el Sistema

**Login:**
```
http://localhost/views/login.php
```

**Credenciales:**
- 👨‍💼 Admin: `admin@miau.cl` / `admin123`
- 🔧 Mecánico: `carlos@miau.cl` / `mecanico123`
- 👤 Cliente: `pedro@mail.com` / `cliente123`

---

## 📊 Qué Verás en el Dashboard

1. **Gráfico de Estado de Vehículos** (Barras)
   - Muestra cuántos vehículos hay en cada estado
   
2. **Gráfico de Averías Más Comunes** (Torta)
   - Muestra los tipos de fallas más frecuentes
   
3. **Gráfico de Ingresos Mensuales** (Líneas)
   - Evolución de facturación en los últimos 12 meses
   
4. **Gráfico de Repuestos Más Usados** (Barras horizontales)
   - Top 10 de repuestos más consumidos

5. **Tabla de Últimos Ingresos**
   - Con filtro en tiempo real por patente
   - Botón para descargar PDF de cada orden

---

## 📄 Generar PDF

### Opción A: Con Dompdf (Recomendado)

**Instalar con Composer:**
```bash
# Desde la raíz del proyecto
composer require dompdf/dompdf
```

**Si no tienes Composer:**
1. Descargar Composer: https://getcomposer.org/download/
2. Instalar Composer
3. Ejecutar el comando de arriba

**Probar PDF:**
1. En el dashboard, clic en cualquier botón "📄 PDF"
2. Debería descargarse un PDF profesional

### Opción B: Sin Librería (Alternativa)

Si no puedes instalar Dompdf, el sistema automáticamente usará HTML para imprimir:
1. Se abrirá una ventana con el documento
2. Usar Ctrl+P (Imprimir)
3. Seleccionar "Guardar como PDF"

---

## 🧰 Estructura del Proyecto (MVC)

```
miau_api_2.0/
│
├── app/                          ← LÓGICA DE NEGOCIO
│   ├── services/
│   │   ├── DashboardService.php  ← Consultas para gráficos
│   │   └── PDFService.php        ← Generación de PDFs
│   └── models/                   ← (Opcional) Clases de entidades
│
├── config/
│   └── db.php                    ← Conexión PDO a PostgreSQL
│
├── api/                          ← ENDPOINTS / CONTROLADORES
│   ├── login.php
│   ├── reparaciones.php
│   └── orden_pdf.php             ← Descarga de PDFs
│
├── views/                        ← VISTAS (PRESENTACIÓN)
│   ├── dashboard.php             ← Dashboard con 4 gráficos
│   ├── login.php
│   └── pdf/
│       └── orden_trabajo_template.php  ← Plantilla HTML del PDF
│
├── css/
│   └── style.css                 ← Estilos (NO inline)
│
├── js/
│   └── dashboard.js              ← Inicialización de gráficos
│
├── schema.sql                    ← Esquema de la BD
├── seeder_completo.php           ← Datos de prueba
└── GUIA_DIDACTICA_CLASE4.md      ← Guía del profesor
```

---

## 🎯 Tareas de la Clase

### ✅ Tarea 1: Verificar que Todo Funcione (Obligatorio)
- [ ] Los 4 gráficos cargan correctamente
- [ ] El filtro de tabla funciona al escribir una patente
- [ ] Al menos 1 PDF se genera correctamente

### 🔧 Tarea 2: Personalización (Elegir UNA opción)

**Opción A: Agregar un 5º Gráfico**
- Crear método en `DashboardService.php`
- Agregar consulta SQL con GROUP BY
- Pasar datos a JS con `json_encode`
- Inicializar gráfico en `dashboard.js`

**Opción B: Mejorar el PDF**
- Agregar logo del taller (imagen)
- Cambiar colores corporativos
- Agregar términos y condiciones al pie

**Opción C: Crear PDF de Cotización**
- Duplicar `PDFService::generarPDFOrdenTrabajo()`
- Crear nueva plantilla para cotización
- Agregar validez (ej: "Válida por 15 días")

---

## 🔍 Cómo Funciona Chart.js (Paso a Paso)

### Paso 1: Consulta SQL Agrupada
```php
// app/services/DashboardService.php
$sql = "SELECT estado, COUNT(*) as cantidad 
        FROM reparaciones 
        GROUP BY estado";
```

### Paso 2: Ejecutar con PDO
```php
$stmt = $this->conn->prepare($sql);
$stmt->execute();
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Resultado: [
//   ['estado' => 'pendiente', 'cantidad' => '5'],
//   ['estado' => 'en_proceso', 'cantidad' => '12']
// ]
```

### Paso 3: Pasar a JavaScript
```php
<!-- views/dashboard.php -->
<script>
const datosEstado = <?= json_encode($datos) ?>;
</script>
```

### Paso 4: Renderizar Gráfico
```javascript
// js/dashboard.js
const labels = datosEstado.map(item => item.estado);
const valores = datosEstado.map(item => parseInt(item.cantidad));

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,    // ['pendiente', 'en_proceso']
        datasets: [{
            data: valores  // [5, 12]
        }]
    }
});
```

---

## 🚨 Problemas Comunes

### ❌ "Class 'Dompdf\Dompdf' not found"
**Solución:** Instalar Dompdf con Composer (ver arriba)

### ❌ Los gráficos no aparecen
**Solución:**
1. Abrir consola del navegador (F12)
2. Buscar errores en rojo
3. Verificar que las variables `datosXXX` tienen datos:
   ```javascript
   console.log(datosEstadoVehiculos);
   ```

### ❌ "SQLSTATE[42P01]: Undefined table"
**Solución:** Ejecutar `schema.sql` para crear las tablas

### ❌ El PDF está vacío
**Solución:** 
1. Verificar que la orden tiene repuestos en `detalle_repuesto`
2. Probar con otra orden: `?id=2`, `?id=3`, etc.

### ❌ El filtro de tabla no funciona
**Solución:**
1. Verificar que el ID del input sea `filtroInput`
2. Verificar que el tbody tenga ID `tablaCuerpo`
3. Revisar consola del navegador por errores JS

---

## 📖 Conceptos Clave a Entender

### 🔒 Seguridad

**✅ SIEMPRE hacer:**
```php
// Prepared statements
$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);

// Escapar HTML
echo htmlspecialchars($dato);
```

**❌ NUNCA hacer:**
```php
// SQL directo (vulnerable a SQL Injection)
$sql = "SELECT * FROM users WHERE email = '$email'";

// HTML sin escapar (vulnerable a XSS)
echo $dato;
```

### 🏗️ Patrón MVC

- **Modelo (app/services/):** Consultas SQL, lógica de negocio
- **Vista (views/):** HTML, presentación
- **Controlador (api/):** Coordina modelo y vista

**Regla de oro:** NUNCA poner SQL directo en las vistas.

### 📊 Chart.js

**Tipos de gráficos:**
- `bar`: Barras verticales
- `line`: Líneas (tendencias)
- `pie` / `doughnut`: Tortas
- `radar`: Radar (comparaciones)

**Configuración básica:**
```javascript
new Chart(canvas, {
    type: 'bar',           // Tipo
    data: {
        labels: [...],     // Eje X
        datasets: [{
            data: [...]    // Eje Y
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});
```

---

## 🎓 Recursos de Apoyo

- **Chart.js:** https://www.chartjs.org/docs/
- **Dompdf:** https://github.com/dompdf/dompdf
- **PDO:** https://www.php.net/manual/es/book.pdo.php
- **PostgreSQL:** https://www.postgresql.org/docs/

---

## 💡 Consejos

1. **Siempre revisar la consola del navegador** (F12) si algo no funciona
2. **Probar consultas SQL en pgAdmin** antes de ponerlas en el código
3. **Guardar cambios frecuentemente** y probar paso a paso
4. **Leer los comentarios en el código** - explican cada parte
5. **Preguntar al profesor** si algo no queda claro

---

## ✨ ¿Qué Sigue Después de Esta Clase?

- **Clase 5:** Integración móvil Android (POST de formularios)
- **Clase 6:** Autenticación JWT y roles avanzados
- **Clase 7:** Deploy a servidor real (Raspberry Pi / VPS)

---

**¡Éxito en la clase! 🚀**

Si algo no funciona, revisa primero:
1. ¿Está la BD creada y poblada?
2. ¿Está Dompdf instalado?
3. ¿Hay errores en la consola del navegador?
4. ¿Las credenciales de `config/db.php` son correctas?
