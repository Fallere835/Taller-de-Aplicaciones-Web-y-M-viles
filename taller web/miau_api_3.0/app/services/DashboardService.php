<?php
/**
 * DashboardService.php
 * 
 * PROPÓSITO:
 * Este servicio contiene TODA la lógica de negocio relacionada con el dashboard.
 * Nunca mezclamos SQL ni lógica de negocio dentro de las vistas.
 * 
 * BUENAS PRÁCTICAS IMPLEMENTADAS:
 * ✓ Prepared Statements (PDO) - SIEMPRE
 * ✓ Manejo de errores con try-catch
 * ✓ Separación de responsabilidades (Servicio = Lógica de negocio)
 * ✓ Retorno de datos estructurados (arrays asociativos)
 */

class DashboardService {
    
    private $conn;
    
    /**
     * Constructor: Recibe la conexión PDO desde db.php
     * 
     * @param PDO $conn Conexión a PostgreSQL
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    /**
     * ========================================
     * MÉTODO 1: Estado de Vehículos (Gráfico Original)
     * ========================================
     * 
     * Obtiene la cantidad de vehículos agrupados por estado
     * para el gráfico de barras/torta existente.
     * 
     * @return array Ejemplo: [
     *   ['estado' => 'en_espera', 'cantidad' => 5],
     *   ['estado' => 'en_proceso', 'cantidad' => 12]
     * ]
     */
    public function obtenerEstadoVehiculos() {
        try {
            // ✓ CORRECTO: Prepared statement (aunque no hay parámetros, es buena práctica)
            $sql = "SELECT estado, COUNT(*) as cantidad 
                    FROM reparaciones 
                    GROUP BY estado 
                    ORDER BY cantidad DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            // En producción, loguear el error en archivo
            error_log("Error en obtenerEstadoVehiculos: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * ========================================
     * MÉTODO 2: Ingresos Mensuales (NUEVO)
     * ========================================
     * 
     * Calcula el total facturado por mes en los últimos 12 meses.
     * Asume que existe una tabla 'facturas' o 'orden_trabajo' con:
     * - fecha (DATE o TIMESTAMP)
     * - monto_total (NUMERIC)
     * 
     * @return array Ejemplo: [
     *   ['mes' => 'Enero 2025', 'total' => 1500000],
     *   ['mes' => 'Febrero 2025', 'total' => 2300000]
     * ]
     */
    public function obtenerIngresosMensuales() {
        try {
            // Usamos DATE_TRUNC para agrupar por mes
            // TO_CHAR para formatear el mes como texto legible
            $sql = "SELECT 
                        TO_CHAR(fecha, 'TMMonth YYYY') as mes,
                        SUM(monto_total) as total
                    FROM facturas
                    WHERE fecha >= NOW() - INTERVAL '12 months'
                    GROUP BY DATE_TRUNC('month', fecha), TO_CHAR(fecha, 'TMMonth YYYY')
                    ORDER BY DATE_TRUNC('month', fecha) ASC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Asegurar que siempre retornamos un array (aunque esté vacío)
            return $resultados ?: [];
            
        } catch (PDOException $e) {
            error_log("Error en obtenerIngresosMensuales: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * ========================================
     * MÉTODO 3: Repuestos Más Utilizados (NUEVO)
     * ========================================
     * 
     * Obtiene los 10 repuestos más usados en reparaciones.
     * Asume que existe:
     * - Tabla 'repuestos' (id, nombre)
     * - Tabla 'detalle_repuesto' (id_reparacion, id_repuesto, cantidad)
     * 
     * @param int $limite Cantidad de repuestos a retornar (por defecto 10)
     * @return array Ejemplo: [
     *   ['nombre' => 'Filtro de aceite', 'total_usado' => 45],
     *   ['nombre' => 'Pastillas de freno', 'total_usado' => 38]
     * ]
     */
    public function obtenerRepuestosMasUsados($limite = 10) {
        try {
            // ✓ CORRECTO: Usamos :limite como parámetro nombrado
            $sql = "SELECT 
                        r.nombre,
                        SUM(dr.cantidad) as total_usado
                    FROM detalle_repuesto dr
                    INNER JOIN repuestos r ON dr.id_repuesto = r.id
                    GROUP BY r.id, r.nombre
                    ORDER BY total_usado DESC
                    LIMIT :limite";
            
            $stmt = $this->conn->prepare($sql);
            // IMPORTANTE: LIMIT requiere bindValue con PDO::PARAM_INT
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error en obtenerRepuestosMasUsados: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * ========================================
     * MÉTODO 4: Averías Más Comunes (NUEVO)
     * ========================================
     * 
     * Agrupa las reparaciones por tipo de avería.
     * Asume que existe:
     * - Tabla 'reparaciones' con campo 'tipo_averia' o
     * - Tabla 'tipos_averia' con relación a 'reparaciones'
     * 
     * @return array Ejemplo: [
     *   ['tipo_averia' => 'Sistema de frenos', 'cantidad' => 28],
     *   ['tipo_averia' => 'Motor', 'cantidad' => 15]
     * ]
     */
    public function obtenerAveriasMasComunes() {
        try {
            // Opción 1: Si tipo_averia está directo en reparaciones
            $sql = "SELECT 
                        tipo_averia,
                        COUNT(*) as cantidad
                    FROM reparaciones
                    WHERE tipo_averia IS NOT NULL
                    GROUP BY tipo_averia
                    ORDER BY cantidad DESC
                    LIMIT 8";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            /*
            // Opción 2: Si usan tabla separada 'tipos_averia'
            $sql = "SELECT 
                        ta.nombre as tipo_averia,
                        COUNT(r.id) as cantidad
                    FROM reparaciones r
                    INNER JOIN tipos_averia ta ON r.id_tipo_averia = ta.id
                    GROUP BY ta.id, ta.nombre
                    ORDER BY cantidad DESC
                    LIMIT 8";
            */
            
        } catch (PDOException $e) {
            error_log("Error en obtenerAveriasMasComunes: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * ========================================
     * MÉTODO 5: Últimos Ingresos (Tabla del Dashboard)
     * ========================================
     * 
     * Obtiene las últimas reparaciones ingresadas para mostrar en tabla.
     * 
     * @param int $limite Cantidad de registros a retornar
     * @return array
     */
    public function obtenerUltimosIngresos($limite = 10) {
        try {
            $sql = "SELECT 
                        r.id,
                        v.patente,
                        v.modelo,
                        r.estado,
                        r.costo_estimado as costo
                    FROM reparaciones r
                    INNER JOIN vehiculos v ON r.vehiculo_id = v.id
                    ORDER BY r.id DESC
                    LIMIT :limite";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Error en obtenerUltimosIngresos: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * ========================================
     * MÉTODO DE EJEMPLO: Consulta INSEGURA vs SEGURA
     * ========================================
     * 
     * Este método es EDUCATIVO para mostrar a los alumnos
     * la diferencia entre código vulnerable y código seguro.
     */
    public function ejemploConsultaSegura($estado) {
        // ❌ MAL - NUNCA HACER ESTO (Vulnerable a SQL Injection)
        // $sql = "SELECT * FROM reparaciones WHERE estado = '$estado'";
        // $result = $this->conn->query($sql);
        
        // ✓ BIEN - SIEMPRE USAR PREPARED STATEMENTS
        $sql = "SELECT * FROM reparaciones WHERE estado = :estado";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':estado' => $estado]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
