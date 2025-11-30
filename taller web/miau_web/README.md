# MIAUtomotriz - Sistema de Gestión para Talleres Mecánicos

Sistema web desarrollado en PHP 8 para la gestión integral de talleres mecánicos, parte del "Proyecto Automotora". Implementa un patrón MVC simple y está diseñado como material educativo para talleres de desarrollo web.

## 🚀 Características Principales

- **Login diferenciado por rol**: Administrador y Mecánico con interfaces específicas
- **Dashboard responsivo** con navegación hacia todos los módulos
- **Gestión completa** de clientes, órdenes de trabajo, facturas y cotizaciones
- **Control de inventario** de repuestos con alertas de stock
- **Sistema de reportes** preparado para gráficos con Chart.js
- **Formulario de contacto** con validación completa
- **Arquitectura MVC** simple y clara para fines educativos

## 📁 Estructura del Proyecto

```
miau_web/
├── app/                          # Lógica de negocio
│   ├── config.php                # Configuración y conexión BD
│   ├── helpers.php               # Funciones auxiliares
│   ├── auth_service.php          # Servicio de autenticación
│   └── contacto_service.php      # Servicio de contacto
├── views/                        # Vistas HTML/PHP
│   ├── layout/
│   │   ├── header.php            # Cabecera común
│   │   └── footer.php            # Pie de página común
│   ├── login_admin.php           # Login administrador (azul/gris)
│   ├── login_mecanico.php        # Login mecánico (verde/naranja)
│   ├── dashboard.php             # Panel principal
│   ├── contacto_form.php         # Formulario de contacto
│   ├── clientes_list.php         # Gestión de clientes
│   ├── ordenes_list.php          # Mis reparaciones
│   ├── facturas_list.php         # Mis facturas
│   ├── cotizaciones_list.php     # Mis cotizaciones
│   ├── inventario_list.php       # Inventario de repuestos
│   └── reportes_list.php         # Reportes y dashboard
└── public/                       # Controladores (punto de entrada)
    ├── index.php                 # Redirección inicial
    ├── login.php                 # Controlador de login
    ├── logout.php                # Controlador de logout
    ├── dashboard.php             # Controlador del dashboard
    ├── contacto.php              # Controlador de contacto
    ├── clientes.php              # Controlador de clientes
    ├── ordenes.php               # Controlador de órdenes
    ├── facturas.php              # Controlador de facturas
    ├── cotizaciones.php          # Controlador de cotizaciones
    ├── inventario.php            # Controlador de inventario
    └── reportes.php              # Controlador de reportes
```

## 🔧 Configuración Inicial

### 1. Usuarios de Prueba

El sistema incluye usuarios hardcodeados para desarrollo:

**Administrador:**
- Usuario: `admin_demo`
- Contraseña: `admin123`
- Acceso: Completo a todos los módulos

**Mecánico:**
- Usuario: `mec_demo`
- Contraseña: `mec123`
- Acceso: Operativo limitado

### 2. Configuración de Base de Datos

Editar `app/config.php` para configurar PostgreSQL:

```php
define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'miau_automotriz');
define('DB_USER', 'postgres');
define('DB_PASS', 'tu_password');
```

### 3. Servidor Web

Configurar el servidor web para que apunte a la carpeta `public/` como document root.

**Para Apache (.htaccess en public/):**
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

## 🎨 Características de Diseño

### Login Diferenciado
- **Admin**: Paleta azul/gris, diseño corporativo
- **Mecánico**: Paleta verde/naranja, diseño operativo
- **Selección de rol**: Interfaz amigable para elegir tipo de acceso

### Dashboard Responsivo
- Cards de navegación hacia cada módulo
- Estadísticas rápidas (placeholders)
- Actividad reciente
- Diseño adaptable a dispositivos móviles

### Formularios
- Validación frontend y backend
- Mensajes de error contextuales
- "Sticky forms" (mantiene valores en caso de error)
- Protección CSRF

## 📋 Módulos Implementados

### 1. Gestión de Clientes
- Lista con información completa
- Búsqueda y filtros
- Historial de servicios
- Datos de contacto y vehículos

### 2. Órdenes de Trabajo ("Mis Reparaciones")
- Estados: Pendiente → En Proceso → Completado → Entregado
- Información de vehículo y cliente
- Control de tiempos y costos

### 3. Facturación
- Estados: Pendiente, Pagada, Vencida
- Generación desde órdenes completadas
- Resúmenes financieros
- Preparado para PDF y envío por email

### 4. Cotizaciones
- Estados: Pendiente, Aprobada, Rechazada, Vencida
- Control de validez temporal
- Conversión a órdenes de trabajo
- Seguimiento de aprobaciones

### 5. Inventario de Repuestos
- Control de stock con alertas
- Categorización de productos
- Precios de costo y venta
- Movimientos de entrada/salida

### 6. Reportes y Dashboard
- Placeholder para gráficos con Chart.js
- Métricas de negocio
- Análisis de rendimiento
- Exportación de datos

### 7. Sistema de Contacto
- Formulario validado
- Captcha de protección
- Gestión de consultas
- Notificaciones automáticas

## 🔒 Sistema de Autenticación y Permisos

### Roles Definidos
- **ADMIN**: Acceso completo a gestión y reportes
- **MECANICO**: Acceso operativo limitado

### Permisos por Módulo
```php
// Ejemplos de verificación de permisos
require_login();                    // Requiere estar logueado
require_role('ADMIN');              // Solo administradores
has_role('ADMIN');                  // Verificar rol específico
tiene_permiso($rol, 'ver_reportes'); // Verificar permiso específico
```

## 🛠️ Tecnologías Utilizadas

- **Backend**: PHP 8
- **Base de Datos**: PostgreSQL (preparado)
- **Frontend**: HTML5, CSS3, JavaScript vanilla
- **Arquitectura**: MVC manual (sin frameworks)
- **Seguridad**: Protección XSS, CSRF, validación de entrada

## 📚 Para Desarrolladores/Estudiantes

### Conceptos Implementados
1. **Patrón MVC**: Separación clara de responsabilidades
2. **Validación de formularios**: Cliente y servidor
3. **Gestión de sesiones**: Login, logout, permisos
4. **Seguridad web**: Escape HTML, tokens CSRF
5. **Responsive Design**: CSS Grid, Flexbox
6. **Arquitectura escalable**: Preparado para crecimiento

### TODOs para Siguientes Clases
1. **Conexión a PostgreSQL**: Implementar consultas reales
2. **CRUD completo**: Operaciones de base de datos
3. **Gráficos**: Integración con Chart.js
4. **PDF**: Generación de facturas y reportes
5. **Email**: Envío automático de documentos
6. **API REST**: Endpoints para aplicaciones móviles

## 🚀 Próximos Pasos

1. **Configurar Base de Datos**: Crear tablas en PostgreSQL
2. **Implementar Consultas**: Reemplazar datos hardcodeados
3. **Añadir Gráficos**: Integrar Chart.js en reportes
4. **Sistema de Archivos**: Subida de documentos e imágenes
5. **Notificaciones**: Sistema de alertas en tiempo real
6. **Optimización**: Cache, paginación, índices de BD

## 📞 Soporte

Este proyecto es material educativo para talleres de desarrollo web PHP. Las consultas y mejoras son bienvenidas para el aprendizaje colaborativo.

---

**Versión**: 1.0 - Esqueleto Base  
**Fecha**: Noviembre 2024  
**Proyecto**: Automotora - MIAUtomotriz