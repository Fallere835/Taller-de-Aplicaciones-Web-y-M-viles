# 📚 ÍNDICE DE DOCUMENTACIÓN - Clase 4 MIAUtomotriz


1. **Si necesitas instalar Composer:**
   - [`INSTALACION_COMPOSER.md`](INSTALACION_COMPOSER.md) - Tutorial completo de instalación

2. **Para estudiar:**
   - [`EJEMPLOS_ANTES_DESPUES.md`](EJEMPLOS_ANTES_DESPUES.md) - Ejemplos de código seguro

---

## 📂 Archivos del Proyecto

### 🗄️ Base de Datos
- [`schema.sql`](schema.sql) - Esquema completo de la BD
- [`seeder_completo.php`](seeder_completo.php) - Datos de prueba (ejecutar en navegador)

### 💻 Código PHP

#### Servicios (Lógica de Negocio)
- [`app/services/DashboardService.php`](app/services/DashboardService.php) - Consultas para gráficos
- [`app/services/PDFService.php`](app/services/PDFService.php) - Generación de PDFs

#### API / Controladores
- [`api/orden_pdf.php`](api/orden_pdf.php) - Endpoint para descargar PDFs
- [`api/reparaciones.php`](api/reparaciones.php) - API de reparaciones (ya existía)
- [`api/login.php`](api/login.php) - Autenticación (ya existía)

#### Vistas
- [`views/dashboard.php`](views/dashboard.php) - Dashboard con 4 gráficos
- [`views/pdf/orden_trabajo_template.php`](views/pdf/orden_trabajo_template.php) - Plantilla HTML del PDF
- [`views/login.php`](views/login.php) - Página de login (ya existía)

#### JavaScript
- [`js/dashboard.js`](js/dashboard.js) - Inicialización de gráficos Chart.js

#### Configuración
- [`config/db.php`](config/db.php) - Conexión PDO a PostgreSQL

---

## 🚀 Inicio Rápido (3 pasos)

### 1. Configurar Base de Datos
```sql
CREATE DATABASE db_automotora;
-- Ejecutar todo el contenido de schema.sql
```

### 2. Poblar Datos
Abrir en navegador: `http://localhost/seeder_completo.php`

### 3. Login
```
URL: http://localhost/views/login.php
Usuario: admin@miau.cl
Password: admin123
```

---

## 📊 Características Implementadas

### Dashboard Web
✅ **Gráfico 1:** Estado de Vehículos (barras)  
✅ **Gráfico 2:** Averías Más Comunes (dona)  
✅ **Gráfico 3:** Ingresos Mensuales (líneas)  
✅ **Gráfico 4:** Repuestos Más Usados (barras horizontales)  
✅ **Tabla:** Últimos Ingresos con filtro en tiempo real  

### Exportación PDF
✅ Orden de Trabajo completa con:
- Datos del cliente y vehículo
- Detalles de la reparación
- Lista de repuestos con precios
- Totales calculados
- Diseño profesional

---

## 🔒 Seguridad Implementada

✅ **Prepared Statements** - Todas las consultas usan PDO con parámetros nombrados  
✅ **htmlspecialchars()** - Todas las salidas están escapadas  
✅ **Patrón MVC** - Separación total de lógica y presentación  
✅ **Validación de Sesión** - Todas las páginas protegidas validan autenticación  

---

## 🎓 Conceptos que se Enseñan

### Backend
- PDO con prepared statements
- Consultas SQL complejas (GROUP BY, SUM, COUNT, JOINs)
- Funciones de fecha en PostgreSQL
- Patrón MVC / Arquitectura en capas
- Generación de PDFs con Dompdf

### Frontend
- Chart.js (4 tipos de gráficos)
- Filtrado en tiempo real con JavaScript
- Paso de datos PHP → JSON → JavaScript
- Métodos funcionales (Array.map)

### Seguridad
- Prevención de SQL Injection
- Prevención de XSS (Cross-Site Scripting)
- Validación de sesiones
- Separación de capas

---

## 🆘 Ayuda Rápida

### Los gráficos no aparecen
1. Abrir consola del navegador (F12)
2. Verificar que las variables `datosXXX` tienen datos
3. Revisar errores en consola

### Error al generar PDF
1. Verificar que Composer esté instalado: `composer --version`
2. Instalar Dompdf: `composer require dompdf/dompdf`
3. Verificar que la carpeta `vendor/` exista

### Error de base de datos
1. Verificar que la BD `db_automotora` exista
2. Ejecutar `schema.sql` completo
3. Ejecutar `seeder_completo.php`

---

## 📖 Documentos por Orden de Lectura

### Para el Docente:
1. [`RESUMEN_EJECUTIVO.md`](RESUMEN_EJECUTIVO.md) ← **Empezar aquí**
2. [`GUIA_DIDACTICA_CLASE4.md`](GUIA_DIDACTICA_CLASE4.md)
3. [`EJEMPLOS_ANTES_DESPUES.md`](EJEMPLOS_ANTES_DESPUES.md)
4. [`CHEATSHEET.md`](CHEATSHEET.md)

### Para los Alumnos:
1. [`README_CLASE4.md`](README_CLASE4.md) ← **Empezar aquí**
2. [`INSTALACION_COMPOSER.md`](INSTALACION_COMPOSER.md) (si es necesario)
3. [`CHEATSHEET.md`](CHEATSHEET.md)
4. [`EJEMPLOS_ANTES_DESPUES.md`](EJEMPLOS_ANTES_DESPUES.md)

---

## 🎯 Tareas de la Clase

### Obligatoria (Todos los grupos)
- [ ] Ejecutar `schema.sql`
- [ ] Ejecutar `seeder_completo.php`
- [ ] Verificar que los 4 gráficos funcionen
- [ ] Generar al menos 1 PDF

### Opcional (Elegir UNA)
- **Opción A:** Agregar un 5º gráfico personalizado
- **Opción B:** Mejorar el PDF (logo, firma digital, términos)
- **Opción C:** Crear PDF de Cotización

---

## 📞 Contacto y Soporte

Si algo no funciona:
1. Revisar [`CHEATSHEET.md`](CHEATSHEET.md) - Errores comunes
2. Consultar [`GUIA_DIDACTICA_CLASE4.md`](GUIA_DIDACTICA_CLASE4.md) - Troubleshooting
3. Revisar consola del navegador (F12)
4. Revisar logs de PHP

---

## ✅ Checklist de Verificación

Antes de empezar:
- [ ] PostgreSQL instalado y funcionando
- [ ] PHP instalado (versión 7.4+)
- [ ] Servidor web funcionando (XAMPP, WAMP, etc.)
- [ ] Composer instalado (para PDFs)

Después de configurar:
- [ ] BD creada y poblada con datos
- [ ] Login funciona correctamente
- [ ] Dashboard muestra los 4 gráficos
- [ ] Filtro de tabla funciona
- [ ] Al menos 1 PDF se genera correctamente

---

## 🎉 ¡Todo Listo!

Este proyecto está completo y listo para enseñar. Todos los archivos están documentados y siguen las mejores prácticas profesionales.

**Tiempo total de preparación:** ~10 minutos  
**Duración de la clase:** ~2 horas  
**Nivel de complejidad:** Intermedio-Avanzado  

---

**Última actualización:** Diciembre 2025  
**Versión:** 2.0 - Clase 4  
**Autor:** Asistente de desarrollo  
**Licencia:** Uso educativo  

---

## 🔗 Enlaces Útiles

- **Chart.js:** https://www.chartjs.org/docs/
- **Dompdf:** https://github.com/dompdf/dompdf
- **PDO:** https://www.php.net/manual/es/book.pdo.php
- **PostgreSQL:** https://www.postgresql.org/docs/
- **Composer:** https://getcomposer.org/

---

**¡Buena clase! 🚀**
