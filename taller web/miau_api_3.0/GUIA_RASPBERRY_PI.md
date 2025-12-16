# 🚀 GUÍA RÁPIDA PARA RASPBERRY PI - Clase 4

## 📌 Tu Escenario de Trabajo

- ✅ PostgreSQL en Raspberry Pi
- ✅ Alumnos conectan por SSH
- ✅ Ya tienen tablas de clases anteriores
- ✅ Solo necesitan agregar funcionalidad nueva

---

## ⚡ Pasos de Instalación (10 minutos)

### 1️⃣ Conectarse por SSH a la Raspberry

```bash
ssh pi@[IP_RASPBERRY]
# O usar PuTTY en Windows
```

### 2️⃣ Ir a la carpeta del proyecto

```bash
cd /var/www/html/miau_api_2.0
# O donde esté su proyecto web
```

### 3️⃣ Subir archivos nuevos

**Opción A: Con SCP (desde tu PC)**
```bash
# Subir carpeta app/
scp -r app/ pi@[IP]:/var/www/html/miau_api_2.0/

# Subir archivos PHP
scp api/orden_pdf.php pi@[IP]:/var/www/html/miau_api_2.0/api/
scp views/dashboard.php pi@[IP]:/var/www/html/miau_api_2.0/views/
scp js/dashboard.js pi@[IP]:/var/www/html/miau_api_2.0/js/

# Subir archivos SQL y PHP
scp migracion_clase4.sql pi@[IP]:/var/www/html/miau_api_2.0/
scp seeder_clase4_incremental.php pi@[IP]:/var/www/html/miau_api_2.0/
```

**Opción B: Con SFTP (interfaz gráfica)**
- Usar FileZilla o WinSCP
- Conectar a la IP de la Raspberry
- Arrastrar y soltar los archivos

**Opción C: Directamente en SSH (copiar/pegar)**
```bash
# Crear directorio
mkdir -p /var/www/html/miau_api_2.0/app/services
mkdir -p /var/www/html/miau_api_2.0/views/pdf

# Crear archivos con nano
nano /var/www/html/miau_api_2.0/app/services/DashboardService.php
# Copiar el contenido y guardar (Ctrl+X, Y, Enter)
```

### 4️⃣ Ejecutar Migración de BD

```bash
# Conectarse a PostgreSQL
psql -U postgres -d db_automotora

# Dentro de psql, ejecutar:
\i /var/www/html/miau_api_2.0/migracion_clase4.sql

# Verificar:
\dt    # Ver tablas
SELECT * FROM facturas LIMIT 1;  # Probar nueva tabla

# Salir
\q
```

### 5️⃣ Poblar Datos Nuevos

Abrir en navegador:
```
http://[IP_RASPBERRY]/seeder_clase4_incremental.php
```

Deberías ver:
```
✅ MIGRACIÓN COMPLETADA EXITOSAMENTE
```

### 6️⃣ Probar Dashboard

```
http://[IP_RASPBERRY]/views/login.php
```

Login con:
- Email: `admin@miau.cl`
- Password: `admin123`

---

## 📊 Archivos que DEBES Subir

### ✅ Archivos Esenciales (Obligatorios):

```
app/
  services/
    DashboardService.php       ← NUEVO (lógica de gráficos)
    PDFService.php             ← NUEVO (generación PDF)
    
views/
  dashboard.php                ← REEMPLAZAR el existente
  pdf/
    orden_trabajo_template.php ← NUEVO (plantilla PDF)
    
js/
  dashboard.js                 ← REEMPLAZAR el existente
  
api/
  orden_pdf.php                ← NUEVO (descarga PDF)
  
migracion_clase4.sql           ← EJECUTAR en PostgreSQL
seeder_clase4_incremental.php  ← EJECUTAR en navegador
```

### 📚 Archivos de Documentación (Opcionales):

```
README_CLASE4.md               ← Guía para alumnos
INSTALACION_PDF_RASPBERRY.md   ← Guía de PDFs
CHEATSHEET.md                  ← Referencia rápida
EJEMPLOS_ANTES_DESPUES.md      ← Ejemplos didácticos
```

---

## ❌ Archivos que NO Necesitas

- ❌ `schema.sql` (ya tienen la BD creada)
- ❌ `seeder_completo.php` (borra todo, NO usar)
- ❌ `INSTALACION_COMPOSER.md` (instalar en Raspberry si quieren)

---

## 🔧 Opción: Instalar Dompdf en Raspberry (5 min)

### Si quieren PDFs automáticos profesionales:

```bash
# Conectarse por SSH
ssh pi@[IP_RASPBERRY]

# Ir al proyecto
cd /var/www/html/miau_api_2.0

# Instalar Composer (si no lo tienen)
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Instalar Dompdf
composer require dompdf/dompdf

# Dar permisos
sudo chown -R www-data:www-data vendor/
```

### Si NO instalan Dompdf:

✅ **El sistema igual funciona** usando "Imprimir → Guardar como PDF"

---

## 🧪 Checklist de Verificación

### Después de subir archivos:

- [ ] Conectado por SSH a Raspberry
- [ ] Archivos subidos a `/var/www/html/miau_api_2.0/`
- [ ] Ejecutado `migracion_clase4.sql` en PostgreSQL
- [ ] Ejecutado `seeder_clase4_incremental.php` en navegador
- [ ] Login funciona: `http://[IP]/views/login.php`
- [ ] Dashboard muestra 4 gráficos
- [ ] PDF se puede generar (con o sin Dompdf)

---

## 🎯 ¿Qué Verán los Alumnos?

### Dashboard con 4 Gráficos:
1. **Estado de Vehículos** (barras)
2. **Averías Comunes** (dona)
3. **Ingresos Mensuales** (líneas)
4. **Repuestos Usados** (barras horizontales)

### Tabla Interactiva:
- Filtro en tiempo real por patente
- Botón para descargar PDF de cada orden

### Generación PDF:
- Clic en botón "📄 PDF"
- Se genera Orden de Trabajo completa

---

## 💡 Consejos para la Clase

### 1. Preparación (Antes de la clase):
- Subir todos los archivos a la Raspberry
- Ejecutar migración y seeder
- Probar que todo funciona
- **Tiempo:** 10-15 minutos

### 2. Durante la Clase:
- Mostrar dashboard funcionando
- Explicar cada gráfico y su consulta SQL
- Demostrar generación de PDF
- Dejar que los alumnos exploren

### 3. No es necesario que cada alumno instale:
- ❌ NO necesitan Composer en sus PCs
- ❌ NO necesitan instalar Dompdf individualmente
- ✅ TODO funciona desde la Raspberry compartida

---

## 📋 Comandos Útiles SSH

### Ver archivos subidos:
```bash
ls -la /var/www/html/miau_api_2.0/app/services/
```

### Ver permisos:
```bash
ls -la /var/www/html/miau_api_2.0/
```

### Dar permisos si es necesario:
```bash
sudo chmod -R 755 /var/www/html/miau_api_2.0/
sudo chown -R www-data:www-data /var/www/html/miau_api_2.0/
```

### Ver logs de errores:
```bash
sudo tail -f /var/log/apache2/error.log
```

### Verificar PostgreSQL:
```bash
psql -U postgres -d db_automotora -c "SELECT COUNT(*) FROM facturas;"
```

---

## 🚨 Solución de Problemas

### Los gráficos no aparecen:
```bash
# Verificar que DashboardService.php existe
ls -la /var/www/html/miau_api_2.0/app/services/DashboardService.php

# Verificar permisos
sudo chmod 644 /var/www/html/miau_api_2.0/app/services/*.php
```

### Error de PostgreSQL:
```bash
# Verificar que las tablas nuevas existen
psql -U postgres -d db_automotora -c "\dt"

# Ver si la tabla facturas existe
psql -U postgres -d db_automotora -c "SELECT COUNT(*) FROM facturas;"
```

### PDF no funciona:
- **Sin Dompdf:** Normal, usar "Imprimir → PDF"
- **Con Dompdf:** Verificar que `vendor/` existe

---

## 📞 Flujo de Trabajo Recomendado

```
TU PC                    RASPBERRY PI
  │                           │
  ├─ Descargar archivos      │
  │  del proyecto            │
  │                          │
  ├─ SCP/SFTP ──────────────>├─ Recibir archivos
  │                          │  en /var/www/html/
  │                          │
  │                          ├─ Ejecutar migracion_clase4.sql
  │                          │  en PostgreSQL
  │                          │
  │                          ├─ Abrir en navegador:
  │                          │  seeder_clase4_incremental.php
  │                          │
ALUMNOS                      │
  │                          │
  ├─ Abrir navegador ───────>├─ http://[IP]/views/login.php
  │                          │
  ├─ Ver dashboard ─────────>├─ 4 gráficos funcionando
  │                          │
  └─ Generar PDFs ──────────>└─ Descargar Orden de Trabajo
```

---

## ✅ Resultado Final

Los alumnos podrán:
- ✅ Acceder desde cualquier PC al dashboard
- ✅ Ver 4 gráficos interactivos con datos reales
- ✅ Filtrar reparaciones en tiempo real
- ✅ Generar PDFs de órdenes de trabajo
- ✅ Todo sin instalar nada en sus PCs

---

**¡Todo listo en 10 minutos! 🚀**

La Raspberry Pi hace todo el trabajo pesado.  
Los alumnos solo necesitan un navegador.
