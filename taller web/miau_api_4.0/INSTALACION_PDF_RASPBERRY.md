# 📄 Instalación de PDF en Raspberry Pi

## 🎯 3 Opciones para Generar PDFs

### ✅ OPCIÓN 1: Sin Librería (La Más Simple)

**Ventaja:** No requiere instalar nada  
**Desventaja:** El usuario debe usar "Imprimir → Guardar como PDF"

**Ya está implementado en el código.** Solo usar:
```
http://[IP_RASPBERRY]/api/orden_pdf.php?id=1
```

Si Dompdf no está instalado, automáticamente usará HTML para imprimir.

---

### ✅ OPCIÓN 2: Instalar Dompdf EN LA RASPBERRY (Una Sola Vez)

**Ventaja:** PDF automático profesional  
**Desventaja:** Requiere 5 minutos de instalación

#### Paso 1: Conectarse por SSH a la Raspberry

```bash
ssh pi@[IP_RASPBERRY]
```

#### Paso 2: Ir a la carpeta del proyecto

```bash
cd /var/www/html/miau_api_2.0
# O la ruta donde esté su proyecto
```

#### Paso 3: Instalar Composer (Si no lo tienen)

```bash
# Descargar Composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

# Mover a ubicación global (opcional)
sudo mv composer.phar /usr/local/bin/composer

# Verificar
composer --version
```

#### Paso 4: Instalar Dompdf

```bash
# Desde la carpeta del proyecto
composer require dompdf/dompdf

# Esperar a que termine (puede tomar 2-3 minutos)
```

#### Paso 5: Verificar que funciona

```
http://[IP_RASPBERRY]/api/orden_pdf.php?id=1
```

Debería descargar un PDF automáticamente.

---

### ✅ OPCIÓN 3: Instalación Manual (Sin Composer)

Si Composer no funciona en la Raspberry:

#### Paso 1: En tu PC, descargar Dompdf

1. Ir a: https://github.com/dompdf/dompdf/releases
2. Descargar: **dompdf-x.x.x.zip**
3. Extraer el ZIP

#### Paso 2: Subir a la Raspberry

```bash
# Desde tu PC, usando SCP:
scp -r dompdf/ pi@[IP_RASPBERRY]:/var/www/html/miau_api_2.0/vendor/
```

#### Paso 3: Modificar PDFService.php

Cambiar la línea:
```php
require 'vendor/autoload.php';
```

Por:
```php
require __DIR__ . '/../../vendor/dompdf/autoload.inc.php';
```

---

## 🔍 Verificar Qué Opción Están Usando

### Test Rápido:

```
http://[IP_RASPBERRY]/api/orden_pdf.php?id=1
```

**Si se descarga un PDF automáticamente:**  
→ Tienen Dompdf instalado ✅

**Si se abre una ventana para imprimir:**  
→ Están usando la opción sin librería ✅ (también válido)

---

## 💡 Recomendación para la Clase

### Para la Clase 4:

**Usar OPCIÓN 1** (sin librería):
- Más simple para los alumnos
- No requiere permisos de instalación
- Funciona inmediatamente

### Para Producción / Proyecto Final:

**Instalar OPCIÓN 2** (Dompdf en Raspberry):
- Una sola instalación
- Todos los alumnos lo usan
- PDFs profesionales automáticos

---

## 📋 Comandos Útiles SSH

### Ver si Composer está instalado:
```bash
composer --version
```

### Ver si Dompdf está instalado:
```bash
ls -la vendor/dompdf/
```

### Ver permisos de la carpeta:
```bash
ls -la /var/www/html/miau_api_2.0/
```

### Dar permisos si es necesario:
```bash
sudo chmod -R 755 /var/www/html/miau_api_2.0/
sudo chown -R www-data:www-data /var/www/html/miau_api_2.0/
```

---

## 🚨 Solución de Problemas

### Error: "Permission denied" al instalar Composer

```bash
# Usar sudo
sudo composer require dompdf/dompdf

# O cambiar permisos de la carpeta
sudo chown -R pi:pi /var/www/html/miau_api_2.0/
```

### Error: "Memory exhausted" al instalar Dompdf

```bash
# Aumentar memoria de PHP temporalmente
php -d memory_limit=512M /usr/local/bin/composer require dompdf/dompdf
```

### Error: "Class 'Dompdf\Dompdf' not found"

**Solución:** Dompdf no está instalado. Usar OPCIÓN 1 (sin librería) o instalar Dompdf.

---

## ✅ Checklist de Instalación

### Opción 1 (Sin Librería):
- [x] Ya está lista en el código
- [ ] Probar: `http://[IP]/api/orden_pdf.php?id=1`
- [ ] Usar "Imprimir → Guardar como PDF"

### Opción 2 (Dompdf en Raspberry):
- [ ] Conectarse por SSH
- [ ] Instalar Composer
- [ ] Ejecutar: `composer require dompdf/dompdf`
- [ ] Verificar carpeta `vendor/dompdf/` existe
- [ ] Probar PDF automático

---

## 🎓 ¿Qué Opción Enseñar en Clase?

### Recomendación:

1. **Empezar con OPCIÓN 1** (sin librería)
   - Funciona inmediatamente
   - Todos pueden probarlo
   - Demostrar que funciona

2. **Mencionar OPCIÓN 2** (Dompdf)
   - Explicar que es más profesional
   - Mostrar cómo se instala en Raspberry (5 min)
   - Dejarlo como "tarea opcional"

3. **Ventajas pedagógicas:**
   - Aprenden que hay alternativas
   - Ven la diferencia entre "rápido" y "profesional"
   - No pierden tiempo en instalación durante la clase

---

## 📞 Soporte

### Si algo no funciona:

1. **Verificar que el PHP funciona:**
   ```
   http://[IP]/views/dashboard.php
   ```

2. **Revisar logs de Apache:**
   ```bash
   sudo tail -f /var/log/apache2/error.log
   ```

3. **Probar consulta SQL directamente:**
   ```bash
   psql -U postgres -d db_automotora -c "SELECT * FROM reparaciones LIMIT 1;"
   ```

---

**¡Con cualquiera de las 3 opciones el sistema funciona! 🚀**
