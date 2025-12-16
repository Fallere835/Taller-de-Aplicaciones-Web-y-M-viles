# 🚗 MIAUtomotriz - Sistema de Gestión de Taller Automotriz

## Clase 4: Dashboard Avanzado y Exportación PDF

### 📌 Descripción

Sistema completo de gestión para talleres automotrices con interfaz web (PHP/PostgreSQL) y aplicación móvil (Android/Java). Esta entrega incluye:

- ✅ Dashboard interactivo con 4 gráficos en tiempo real
- ✅ Exportación profesional a PDF de Órdenes de Trabajo
- ✅ Arquitectura MVC profesional
- ✅ Seguridad robusta (PDO + prepared statements + XSS protection)
- ✅ Datos de prueba listos para usar

---

## 🚀 Inicio Rápido (5 minutos)

### 1. Configurar Base de Datos

```sql
-- En pgAdmin o psql:
CREATE DATABASE db_automotora;

-- Ejecutar todo el contenido de: schema.sql
```

### 2. Configurar Conexión

Editar `config/db.php`:
```php
$host = 'localhost';
$db   = 'db_automotora';
$user = 'postgres';        // Tu usuario
$pass = 'tu_contraseña';   // Tu contraseña
$port = "5432";
```

### 3. Poblar Datos de Prueba

Abrir en navegador:
```
http://localhost/seeder_completo.php
```

### 4. Acceder al Sistema

```
http://localhost/views/login.php

Credenciales:
- Admin:    admin@miau.cl / admin123
- Mecánico: carlos@miau.cl / mecanico123
- Cliente:  pedro@mail.com / cliente123
```

---

## 📊 Características

### Dashboard Interactivo
- **Gráfico 1:** Estado de Vehículos en Taller (barras verticales)
- **Gráfico 2:** Averías Más Comunes (gráfico de dona)
- **Gráfico 3:** Ingresos Mensuales (líneas con tendencia)
- **Gráfico 4:** Repuestos Más Utilizados (barras horizontales)
- **Tabla:** Últimos Ingresos con filtro en tiempo real

### Exportación PDF
- Orden de Trabajo completa con diseño profesional
- Datos del cliente y vehículo
- Lista detallada de repuestos con precios
- Totales calculados automáticamente
- Firmas digitales

### Seguridad
- ✅ Prepared Statements con PDO
- ✅ Protección contra SQL Injection
- ✅ Protección contra XSS
- ✅ Validación de sesiones
- ✅ Separación MVC estricta

---

## 📁 Estructura del Proyecto

```
miau_api_2.0/
│
├── app/                          # Lógica de negocio (NUEVO)
│   ├── services/
│   │   ├── DashboardService.php  # Consultas para gráficos
│   │   └── PDFService.php        # Generación de PDFs
│   └── models/                   # Modelos de datos
│
├── api/                          # Endpoints / Controladores
│   ├── login.php
│   ├── reparaciones.php
│   └── orden_pdf.php             # Descarga de PDFs (NUEVO)
│
├── config/
│   └── db.php                    # Conexión PDO
│
├── views/                        # Vistas HTML
│   ├── dashboard.php             # Dashboard principal (MEJORADO)
│   ├── login.php
│   └── pdf/
│       └── orden_trabajo_template.php  # Plantilla PDF (NUEVO)
│
├── css/
│   └── style.css
│
├── js/
│   └── dashboard.js              # Chart.js (MEJORADO)
│
├── schema.sql                    # Esquema completo de BD (NUEVO)
├── seeder_completo.php           # Datos de prueba (NUEVO)
│
└── docs/                         # Documentación (NUEVO)
    ├── INDEX.md                  # Este archivo
    ├── README_CLASE4.md          # Guía rápida para alumnos
    ├── GUIA_DIDACTICA_CLASE4.md  # Guía completa para docentes
    ├── EJEMPLOS_ANTES_DESPUES.md # Código seguro vs inseguro
    ├── INSTALACION_COMPOSER.md   # Tutorial de instalación
    ├── CHEATSHEET.md             # Referencia rápida
    └── RESUMEN_EJECUTIVO.md      # Resumen completo
```

---

## 🛠️ Requisitos

### Software Necesario
- PHP 7.4 o superior
- PostgreSQL 12 o superior
- Servidor web (Apache, Nginx, o PHP built-in server)
- Composer (para instalar Dompdf)

### Extensiones PHP Requeridas
- pdo_pgsql
- mbstring
- gd (para PDFs con imágenes)

---

## 📚 Documentación

### 🎓 Para Estudiantes
1. **[README_CLASE4.md](README_CLASE4.md)** - Guía de inicio rápido
2. **[CHEATSHEET.md](CHEATSHEET.md)** - Comandos y código esencial
3. **[EJEMPLOS_ANTES_DESPUES.md](EJEMPLOS_ANTES_DESPUES.md)** - Ejemplos de código seguro

### 👨‍🏫 Para Docentes
1. **[RESUMEN_EJECUTIVO.md](RESUMEN_EJECUTIVO.md)** - Resumen completo
2. **[GUIA_DIDACTICA_CLASE4.md](GUIA_DIDACTICA_CLASE4.md)** - Guía paso a paso de la clase
3. **[INSTALACION_COMPOSER.md](INSTALACION_COMPOSER.md)** - Setup de dependencias

### 📖 Índice Completo
- **[INDEX.md](INDEX.md)** - Navegación por toda la documentación

---

## 🔧 Instalación de Dompdf (Para PDFs)

### Con Composer (Recomendado)

```bash
# Desde la raíz del proyecto
composer require dompdf/dompdf
```

### Sin Composer

Descargar desde: https://github.com/dompdf/dompdf/releases  
Extraer en `libs/dompdf/`

**Nota:** Ver `INSTALACION_COMPOSER.md` para instrucciones detalladas.

---

## 🧪 Testing

### Datos de Prueba Incluidos

El seeder genera automáticamente:
- 3 usuarios (admin, mecánico, cliente)
- 5 clientes
- 8 vehículos
- 12 repuestos
- 20 reparaciones variadas
- ~60 facturas distribuidas en 12 meses

### URLs de Prueba

```
Dashboard:
http://localhost/views/dashboard.php

PDF de Orden 1:
http://localhost/api/orden_pdf.php?id=1

API de Reparaciones:
http://localhost/api/reparaciones.php?action=chart
```

---

## 🎯 Tareas de la Clase

### Obligatoria
- [ ] Configurar BD y ejecutar schema
- [ ] Poblar datos con el seeder
- [ ] Verificar que los 4 gráficos funcionen
- [ ] Generar al menos 1 PDF

### Opcional (Elegir una)
- **A)** Agregar un 5º gráfico personalizado
- **B)** Mejorar PDF (logo, firma digital, términos)
- **C)** Crear PDF de Cotización

---

## 🐛 Solución de Problemas

### Los gráficos no aparecen
- Abrir consola del navegador (F12)
- Verificar que las variables `datosXXX` tienen datos
- Revisar errores en rojo

### Error "Class 'Dompdf\Dompdf' not found"
```bash
composer require dompdf/dompdf
```

### Error de base de datos
- Verificar que `db_automotora` exista
- Ejecutar `schema.sql` completo
- Verificar credenciales en `config/db.php`

**Más ayuda:** Ver `CHEATSHEET.md` o `GUIA_DIDACTICA_CLASE4.md`

---

## 🏗️ Arquitectura

### Patrón MVC Implementado

```
┌─────────────────┐
│     VISTA       │ ← views/dashboard.php
│   (HTML + PHP)  │   Solo presentación, sin lógica
└────────┬────────┘
         │
         ↓ Usa
┌─────────────────┐
│   SERVICIO      │ ← app/services/DashboardService.php
│ (Lógica + SQL)  │   Consultas SQL + procesamiento
└────────┬────────┘
         │
         ↓ Consulta
┌─────────────────┐
│   BASE DATOS    │ ← PostgreSQL
│   (Datos)       │   Almacenamiento
└─────────────────┘
```

**Ventajas:**
- Código testeable y mantenible
- Reutilizable (mismo servicio para web y móvil)
- Seguro (SQL aislado de las vistas)

---

## 🔒 Seguridad

### Medidas Implementadas

**SQL Injection Prevention:**
```php
// ✅ Siempre usar prepared statements
$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);
```

**XSS Prevention:**
```php
// ✅ Siempre escapar HTML
<?= htmlspecialchars($dato) ?>
```

**Session Validation:**
```php
// ✅ Validar en cada página protegida
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
```

---

## 📈 Tecnologías Utilizadas

### Backend
- PHP 7.4+
- PostgreSQL 12+
- PDO (PHP Data Objects)
- Dompdf 2.0+

### Frontend
- HTML5 + CSS3
- JavaScript ES6+
- Bootstrap 5
- Chart.js 4.0+

### Herramientas
- Composer (gestor de dependencias)
- pgAdmin 4 (administración de BD)

---

## 👥 Roles del Sistema

### Administrador
- Dashboard completo con todos los gráficos
- Gestión de usuarios
- Reportes financieros
- Exportación de documentos

### Mecánico
- Dashboard operativo
- Ingreso de reparaciones
- Gestión de inventario
- Órdenes de trabajo

### Cliente
- Ver sus reparaciones
- Descargar cotizaciones
- Historial de vehículos

---

## 🎓 Conceptos Aprendidos

- ✅ PDO con prepared statements
- ✅ Consultas SQL complejas (GROUP BY, JOINs)
- ✅ Funciones de fecha en PostgreSQL
- ✅ Patrón MVC / Arquitectura en capas
- ✅ Chart.js (4 tipos de gráficos)
- ✅ Generación de PDFs con PHP
- ✅ Prevención de SQL Injection
- ✅ Prevención de XSS
- ✅ Filtrado en tiempo real con JavaScript
- ✅ Paso de datos PHP → JSON → JavaScript

---

## 📞 Soporte

### Documentación
- Ver carpeta de documentación completa
- Consultar `INDEX.md` para navegar

### Errores Comunes
- Ver `CHEATSHEET.md` - Sección "Errores Comunes"
- Ver `GUIA_DIDACTICA_CLASE4.md` - Sección "Troubleshooting"

### Debugging
1. Revisar consola del navegador (F12)
2. Revisar logs de PHP
3. Probar consultas SQL en pgAdmin
4. Verificar permisos de archivos

---

## 🚀 Próximos Pasos

### Clase 5: Integración Móvil Avanzada
- POST de formularios desde Android
- Subida de imágenes
- Notificaciones push
- Sincronización offline

### Clase 6: Autenticación Avanzada
- JWT (JSON Web Tokens)
- Roles y permisos granulares
- Recuperación de contraseña

### Clase 7: Deploy y Producción
- Configuración de servidor
- Certificados SSL
- Optimización de rendimiento
- Backup automático

---

## 📝 Licencia

Este proyecto es material educativo para uso en clases de desarrollo web.  
Todos los derechos reservados © 2025 MIAUtomotriz.

---

## ✅ Checklist de Verificación

Antes de empezar la clase:
- [ ] PostgreSQL instalado y funcionando
- [ ] PHP instalado (verificar con `php --version`)
- [ ] Servidor web configurado
- [ ] Composer instalado (verificar con `composer --version`)
- [ ] BD creada y poblada
- [ ] Login funciona correctamente
- [ ] Dashboard muestra los 4 gráficos
- [ ] Al menos 1 PDF se genera correctamente

---

## 🎉 ¡Todo Listo!

El proyecto está completamente configurado y documentado.  
**Tiempo de setup:** ~10 minutos  
**Duración de clase:** ~2 horas  
**Nivel:** Intermedio-Avanzado  

### 🏁 Empezar Ahora:
1. Lee [`README_CLASE4.md`](README_CLASE4.md) para inicio rápido
2. Ejecuta `schema.sql` y `seeder_completo.php`
3. Accede a `http://localhost/views/login.php`

---

**¡Buena clase! 🚀**

Para documentación completa, ver: [`INDEX.md`](INDEX.md)
