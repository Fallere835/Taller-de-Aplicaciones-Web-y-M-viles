# 📦 Instalación de Composer y Dompdf

## ¿Qué es Composer?

Composer es el gestor de dependencias estándar de PHP, similar a:
- npm para JavaScript/Node.js
- pip para Python
- Maven para Java

---

## 🪟 INSTALACIÓN EN WINDOWS

### Opción A: Instalador Automático (Recomendado)

1. **Descargar Composer:**
   - Ir a: https://getcomposer.org/download/
   - Descargar: **Composer-Setup.exe**

2. **Ejecutar el instalador:**
   - Hacer doble clic en Composer-Setup.exe
   - Seguir el asistente (Next → Next → Install)
   - Detectará automáticamente PHP

3. **Verificar instalación:**
   ```powershell
   # Abrir PowerShell y ejecutar:
   composer --version
   
   # Debería mostrar algo como:
   # Composer version 2.6.5
   ```

### Opción B: Instalación Manual

1. **Descargar composer.phar:**
   ```powershell
   php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
   php composer-setup.php
   php -r "unlink('composer-setup.php');"
   ```

2. **Mover a una ubicación global:**
   ```powershell
   # Crear carpeta si no existe
   mkdir C:\bin
   
   # Mover composer
   move composer.phar C:\bin\composer.phar
   
   # Agregar C:\bin al PATH del sistema
   ```

3. **Crear archivo batch (composer.bat):**
   ```batch
   @echo off
   php "C:\bin\composer.phar" %*
   ```

---

## 🐧 INSTALACIÓN EN LINUX / RASPBERRY PI

```bash
# Descargar e instalar
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"

# Mover a ubicación global
sudo mv composer.phar /usr/local/bin/composer

# Dar permisos de ejecución
sudo chmod +x /usr/local/bin/composer

# Verificar
composer --version
```

---

## 🍎 INSTALACIÓN EN macOS

```bash
# Opción 1: Con Homebrew (recomendado)
brew install composer

# Opción 2: Manual (igual que Linux)
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# Verificar
composer --version
```

---

## 📄 INSTALAR DOMPDF EN EL PROYECTO

### 1. Abrir terminal en la raíz del proyecto

```powershell
# En Windows PowerShell
cd C:\Users\mda30\Downloads\miau_api_2.0

# Verificar que estás en la carpeta correcta
ls
# Deberías ver: config/, views/, api/, etc.
```

### 2. Ejecutar Composer

```bash
composer require dompdf/dompdf
```

**Salida esperada:**
```
Using version ^2.0 for dompdf/dompdf
./composer.json has been created
Running composer update dompdf/dompdf
Loading composer repositories with package information
Updating dependencies
Lock file operations: 3 installs, 0 updates, 0 removals
  - Locking dompdf/dompdf (v2.0.3)
  - Locking phenx/php-font-lib (0.5.4)
  - Locking phenx/php-svg-lib (0.5.0)
Writing lock file
Installing dependencies from lock file
Package operations: 3 installs, 0 updates, 0 removals
  - Downloading dompdf/dompdf (v2.0.3)
  - Downloading phenx/php-font-lib (0.5.4)
  - Downloading phenx/php-svg-lib (0.5.0)
  - Installing phenx/php-font-lib (0.5.4): Extracting archive
  - Installing phenx/php-svg-lib (0.5.0): Extracting archive
  - Installing dompdf/dompdf (v2.0.3): Extracting archive
Generating autoload files
```

### 3. Verificar instalación

Ahora deberías tener:
```
miau_api_2.0/
├── vendor/               ← NUEVO (dependencias)
│   ├── dompdf/
│   ├── phenx/
│   └── autoload.php     ← Este archivo se incluye en el código
├── composer.json         ← NUEVO (configuración de dependencias)
├── composer.lock         ← NUEVO (versiones instaladas)
├── api/
├── views/
└── ...
```

---

## 🧪 PROBAR QUE FUNCIONA

### 1. Crear archivo de prueba: `test_dompdf.php`

```php
<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$html = '<html><body>
    <h1>¡Dompdf Funciona!</h1>
    <p>Si ves este PDF, la instalación fue exitosa.</p>
</body></html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("test.pdf", ["Attachment" => false]);
?>
```

### 2. Ejecutar en navegador

```
http://localhost/miau_api_2.0/test_dompdf.php
```

**Resultado esperado:** Se abre un PDF en el navegador con el texto "¡Dompdf Funciona!"

---

## 🚨 SOLUCIÓN DE PROBLEMAS

### Error: "php is not recognized"

**Problema:** PHP no está en el PATH del sistema

**Solución Windows:**
1. Buscar dónde está instalado PHP (ej: `C:\xampp\php`)
2. Agregar al PATH:
   - Win + R → `sysdm.cpl` → Opciones avanzadas
   - Variables de entorno
   - Editar PATH del sistema
   - Agregar: `C:\xampp\php`
3. Reiniciar PowerShell

**Solución Linux:**
```bash
# Verificar si PHP está instalado
which php

# Si no está, instalar:
sudo apt update
sudo apt install php php-cli php-mbstring php-xml
```

---

### Error: "Composer detected issues in your platform"

**Problema:** Extensiones de PHP faltantes

**Solución:**
```bash
# Ver qué extensiones requiere
composer diagnose

# Instalar extensiones comunes
# Windows (descomentar en php.ini):
extension=mbstring
extension=xml
extension=gd

# Linux:
sudo apt install php-mbstring php-xml php-gd
```

---

### Error: "Fatal error: Allowed memory size exhausted"

**Problema:** PHP no tiene suficiente memoria

**Solución:**
```bash
# Ejecutar con más memoria
php -d memory_limit=512M composer.phar require dompdf/dompdf

# O cambiar permanentemente en php.ini:
memory_limit = 512M
```

---

### Error: "Could not find package dompdf/dompdf"

**Problema:** Sin conexión a Internet

**Solución:**
1. Verificar conexión a Internet
2. Si estás detrás de un proxy, configurar:
   ```bash
   composer config -g http-proxy http://proxy.example.com:8080
   ```

---

## 📋 ALTERNATIVA: INSTALACIÓN MANUAL DE DOMPDF

Si Composer no funciona, puedes instalar Dompdf manualmente:

### 1. Descargar

- Ir a: https://github.com/dompdf/dompdf/releases
- Descargar: **dompdf-x.x.x.zip**

### 2. Extraer

```
miau_api_2.0/
└── libs/               ← Crear esta carpeta
    └── dompdf/         ← Extraer aquí
        ├── src/
        ├── lib/
        └── autoload.inc.php
```

### 3. Incluir en el código

```php
// En lugar de:
require 'vendor/autoload.php';

// Usar:
require __DIR__ . '/libs/dompdf/autoload.inc.php';
```

---

## ✅ CHECKLIST FINAL

- [ ] Composer instalado y funcionando (`composer --version`)
- [ ] Dompdf instalado en el proyecto (carpeta `vendor/`)
- [ ] `test_dompdf.php` genera un PDF correctamente
- [ ] `api/orden_pdf.php?id=1` genera PDF de orden de trabajo

---

## 📚 RECURSOS ADICIONALES

- **Composer:** https://getcomposer.org/doc/
- **Dompdf:** https://github.com/dompdf/dompdf
- **Tutorial Composer:** https://getcomposer.org/doc/00-intro.md

---

## 💡 CONSEJOS

1. **No subir `vendor/` a Git:**
   ```
   # .gitignore
   /vendor/
   composer.lock
   ```

2. **En servidor de producción:**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```

3. **Actualizar dependencias:**
   ```bash
   composer update
   ```

4. **Ver dependencias instaladas:**
   ```bash
   composer show
   ```

---

**¡Listo para generar PDFs! 🚀**
