# 📝 CHEATSHEET - Clase 4 MIAUtomotriz

## 🔑 Credenciales de Prueba

```
Admin:    admin@miau.cl / admin123
Mecánico: carlos@miau.cl / mecanico123
Cliente:  pedro@mail.com / cliente123
```

---

## 🗄️ Comandos SQL Importantes

### Crear BD
```sql
CREATE DATABASE db_automotora;
```

### Ver datos de prueba
```sql
-- Estados de vehículos
SELECT estado, COUNT(*) FROM reparaciones GROUP BY estado;

-- Ingresos mensuales
SELECT TO_CHAR(fecha, 'TMMonth YYYY') as mes, SUM(monto_total) 
FROM facturas 
WHERE fecha >= NOW() - INTERVAL '12 months'
GROUP BY DATE_TRUNC('month', fecha), TO_CHAR(fecha, 'TMMonth YYYY');

-- Repuestos más usados
SELECT r.nombre, SUM(dr.cantidad) as total
FROM detalle_repuesto dr
INNER JOIN repuestos r ON dr.id_repuesto = r.id
GROUP BY r.nombre
ORDER BY total DESC
LIMIT 10;
```

---

## 🎨 Tipos de Gráficos Chart.js

```javascript
// Barras verticales
type: 'bar'

// Líneas (tendencias)
type: 'line'

// Torta completa
type: 'pie'

// Dona (torta con hueco)
type: 'doughnut'

// Barras horizontales
type: 'bar',
options: { indexAxis: 'y' }
```

---

## 🔒 Código Seguro

### Prepared Statements
```php
// ✅ BIEN
$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);

// ❌ MAL
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);
```

### Escapar HTML
```php
// ✅ BIEN
<?= htmlspecialchars($dato) ?>

// ❌ MAL
<?= $dato ?>
```

---

## 📊 Flujo de Datos para Gráficos

```
1. SQL con GROUP BY
   ↓
2. PDO prepare + execute
   ↓
3. fetchAll(FETCH_ASSOC)
   ↓
4. json_encode() en la vista
   ↓
5. Array.map() en JS
   ↓
6. new Chart()
```

---

## 📄 Generar PDF

```php
// En el servicio
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('Letter', 'portrait');
$dompdf->render();
$dompdf->stream("archivo.pdf", ["Attachment" => true]);
```

---

## 🎯 Estructura MVC

```
app/services/        → SQL + Lógica de negocio
views/              → HTML + Presentación
api/                → Controladores / Endpoints
```

**REGLA:** NUNCA poner SQL en las vistas

---

## 🔧 Comandos Útiles

### Composer
```bash
# Instalar Dompdf
composer require dompdf/dompdf

# Actualizar dependencias
composer update

# Ver dependencias instaladas
composer show
```

### PHP
```bash
# Verificar instalación
php --version

# Iniciar servidor
php -S localhost:8000
```

### PostgreSQL
```bash
# Crear BD
createdb db_automotora

# Ejecutar script
psql -U postgres -d db_automotora -f schema.sql

# Conectar a BD
psql -U postgres -d db_automotora
```

---

## 🐛 Errores Comunes

### "Class 'Dompdf\Dompdf' not found"
```bash
composer require dompdf/dompdf
```

### Los gráficos no aparecen
```javascript
// En consola del navegador (F12)
console.log(datosEstadoVehiculos);
```

### "SQLSTATE[42P01]: Undefined table"
```sql
-- Ejecutar schema.sql completo
```

### PDF vacío
```
Verificar que la orden tenga repuestos:
SELECT * FROM detalle_repuesto WHERE id_reparacion = 1;
```

---

## 📂 Archivos Clave

```
app/services/DashboardService.php  → Consultas para gráficos
app/services/PDFService.php        → Generación de PDFs
views/dashboard.php                → Dashboard con 4 gráficos
views/pdf/orden_trabajo_template.php → Plantilla PDF
js/dashboard.js                    → Inicialización Chart.js
api/orden_pdf.php                  → Endpoint descarga PDF
schema.sql                         → Esquema completo BD
seeder_completo.php                → Datos de prueba
```

---

## 🧪 URLs de Prueba

```
Login:
http://localhost/views/login.php

Dashboard:
http://localhost/views/dashboard.php

PDF:
http://localhost/api/orden_pdf.php?id=1

API:
http://localhost/api/reparaciones.php?action=chart
```

---

## 💡 Tips Rápidos

1. Siempre usar prepared statements con PDO
2. Siempre usar htmlspecialchars() al mostrar datos
3. Nunca poner SQL directo en las vistas
4. CSS en archivos .css (no inline)
5. JS en archivos .js (no inline)
6. Revisar consola (F12) si algo no funciona
7. Probar consultas SQL en pgAdmin primero

---

## 📖 Documentos Completos

- `GUIA_DIDACTICA_CLASE4.md` → Guía completa del docente
- `README_CLASE4.md` → Guía rápida alumnos
- `EJEMPLOS_ANTES_DESPUES.md` → Código seguro vs inseguro
- `INSTALACION_COMPOSER.md` → Setup de dependencias
- `RESUMEN_EJECUTIVO.md` → Este documento

---

## ✅ Checklist de Verificación

- [ ] BD creada con schema.sql
- [ ] Seeder ejecutado correctamente
- [ ] Login funciona con credenciales de prueba
- [ ] Dashboard muestra 4 gráficos
- [ ] Filtro de tabla funciona
- [ ] Composer instalado
- [ ] Dompdf instalado (carpeta vendor/)
- [ ] PDF se genera correctamente

---

**¡Todo listo! 🚀**
