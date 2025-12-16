-- ============================================
-- SCHEMA DATABASE - MIAUtomotriz Clase 4
-- ============================================
-- 
-- Base de datos PostgreSQL para sistema de taller automotriz
-- Incluye todas las tablas necesarias para los gráficos y PDFs
--
-- EJECUCIÓN:
-- psql -U postgres -d db_automotora -f schema.sql
-- O copiar y pegar en pgAdmin
-- ============================================

-- Eliminar tablas si existen (CUIDADO: Borra todos los datos)
DROP TABLE IF EXISTS detalle_repuesto CASCADE;
DROP TABLE IF EXISTS facturas CASCADE;
DROP TABLE IF EXISTS reparaciones CASCADE;
DROP TABLE IF EXISTS repuestos CASCADE;
DROP TABLE IF EXISTS vehiculos CASCADE;
DROP TABLE IF EXISTS clientes CASCADE;
DROP TABLE IF EXISTS usuarios CASCADE;

-- ============================================
-- TABLA: usuarios
-- ============================================
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL CHECK (rol IN ('admin', 'mecanico', 'cliente')),
    created_at TIMESTAMP DEFAULT NOW()
);

-- ============================================
-- TABLA: clientes
-- ============================================
CREATE TABLE clientes (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    rut VARCHAR(12) UNIQUE NOT NULL,
    telefono VARCHAR(20),
    email VARCHAR(100),
    direccion TEXT,
    created_at TIMESTAMP DEFAULT NOW()
);

-- ============================================
-- TABLA: vehiculos
-- ============================================
CREATE TABLE vehiculos (
    id SERIAL PRIMARY KEY,
    patente VARCHAR(10) UNIQUE NOT NULL,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    año INTEGER CHECK (año >= 1900 AND año <= 2100),
    kilometraje INTEGER DEFAULT 0,
    cliente_id INTEGER REFERENCES clientes(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT NOW()
);

-- ============================================
-- TABLA: reparaciones
-- ============================================
CREATE TABLE reparaciones (
    id SERIAL PRIMARY KEY,
    vehiculo_id INTEGER REFERENCES vehiculos(id) ON DELETE CASCADE,
    fecha_ingreso TIMESTAMP DEFAULT NOW(),
    fecha_entrega DATE,
    estado VARCHAR(20) NOT NULL DEFAULT 'pendiente' 
        CHECK (estado IN ('pendiente', 'en_proceso', 'completado', 'entregado')),
    diagnostico TEXT,
    tipo_averia VARCHAR(100),  -- NUEVO: Para gráfico de averías
    costo_estimado NUMERIC(10,2) DEFAULT 0,
    costo_mano_obra NUMERIC(10,2) DEFAULT 0,  -- NUEVO: Para cálculo de totales en PDF
    created_at TIMESTAMP DEFAULT NOW()
);

-- ============================================
-- TABLA: repuestos
-- ============================================
CREATE TABLE repuestos (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio_unitario NUMERIC(10,2) NOT NULL,
    stock INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT NOW()
);

-- ============================================
-- TABLA: detalle_repuesto (Relación N:N)
-- ============================================
-- Relaciona qué repuestos se usaron en cada reparación
CREATE TABLE detalle_repuesto (
    id SERIAL PRIMARY KEY,
    id_reparacion INTEGER REFERENCES reparaciones(id) ON DELETE CASCADE,
    id_repuesto INTEGER REFERENCES repuestos(id) ON DELETE CASCADE,
    cantidad INTEGER NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT NOW()
);

-- ============================================
-- TABLA: facturas
-- ============================================
-- NUEVO: Para el gráfico de ingresos mensuales
CREATE TABLE facturas (
    id SERIAL PRIMARY KEY,
    id_reparacion INTEGER REFERENCES reparaciones(id) ON DELETE CASCADE,
    fecha DATE NOT NULL DEFAULT CURRENT_DATE,
    monto_total NUMERIC(10,2) NOT NULL,
    metodo_pago VARCHAR(20) CHECK (metodo_pago IN ('efectivo', 'tarjeta', 'transferencia')),
    created_at TIMESTAMP DEFAULT NOW()
);

-- ============================================
-- ÍNDICES PARA MEJORAR RENDIMIENTO
-- ============================================
CREATE INDEX idx_reparaciones_estado ON reparaciones(estado);
CREATE INDEX idx_reparaciones_tipo_averia ON reparaciones(tipo_averia);
CREATE INDEX idx_reparaciones_vehiculo ON reparaciones(vehiculo_id);
CREATE INDEX idx_vehiculos_cliente ON vehiculos(cliente_id);
CREATE INDEX idx_detalle_reparacion ON detalle_repuesto(id_reparacion);
CREATE INDEX idx_detalle_repuesto ON detalle_repuesto(id_repuesto);
CREATE INDEX idx_facturas_fecha ON facturas(fecha);

-- ============================================
-- COMENTARIOS EN TABLAS (Documentación)
-- ============================================
COMMENT ON TABLE usuarios IS 'Usuarios del sistema web (admin, mecánico, cliente)';
COMMENT ON TABLE clientes IS 'Clientes del taller (dueños de vehículos)';
COMMENT ON TABLE vehiculos IS 'Vehículos registrados en el taller';
COMMENT ON TABLE reparaciones IS 'Órdenes de trabajo / reparaciones';
COMMENT ON TABLE repuestos IS 'Catálogo de repuestos disponibles';
COMMENT ON TABLE detalle_repuesto IS 'Detalle de repuestos usados por reparación';
COMMENT ON TABLE facturas IS 'Facturas emitidas (para gráfico de ingresos)';

COMMENT ON COLUMN reparaciones.tipo_averia IS 'Clasificación de la avería (para gráfico)';
COMMENT ON COLUMN reparaciones.costo_mano_obra IS 'Costo de la mano de obra (sin repuestos)';

-- ============================================
-- DATOS INICIALES MÍNIMOS
-- ============================================
-- Usuario administrador por defecto
INSERT INTO usuarios (nombre, email, password, rol) 
VALUES ('Admin', 'admin@miau.cl', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- Password: admin123

-- ============================================
-- VERIFICACIÓN
-- ============================================
SELECT 
    table_name,
    (SELECT COUNT(*) FROM information_schema.columns WHERE table_name = t.table_name) as columnas
FROM information_schema.tables t
WHERE table_schema = 'public'
    AND table_type = 'BASE TABLE'
ORDER BY table_name;

-- ============================================
-- EJEMPLOS DE CONSULTAS PARA TESTING
-- ============================================

-- Ver todos los vehículos con sus dueños
-- SELECT v.patente, v.marca, v.modelo, c.nombre as cliente
-- FROM vehiculos v
-- INNER JOIN clientes c ON v.cliente_id = c.id;

-- Ver reparaciones agrupadas por estado (para gráfico)
-- SELECT estado, COUNT(*) as cantidad 
-- FROM reparaciones 
-- GROUP BY estado;

-- Ver ingresos por mes (para gráfico)
-- SELECT 
--     TO_CHAR(fecha, 'TMMonth YYYY') as mes,
--     SUM(monto_total) as total
-- FROM facturas
-- WHERE fecha >= NOW() - INTERVAL '12 months'
-- GROUP BY DATE_TRUNC('month', fecha), TO_CHAR(fecha, 'TMMonth YYYY')
-- ORDER BY DATE_TRUNC('month', fecha);

-- Ver repuestos más usados (para gráfico)
-- SELECT 
--     r.nombre,
--     SUM(dr.cantidad) as total_usado
-- FROM detalle_repuesto dr
-- INNER JOIN repuestos r ON dr.id_repuesto = r.id
-- GROUP BY r.id, r.nombre
-- ORDER BY total_usado DESC
-- LIMIT 10;
