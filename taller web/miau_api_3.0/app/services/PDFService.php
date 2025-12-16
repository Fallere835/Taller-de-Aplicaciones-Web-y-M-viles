<?php
/**
 * PDFService.php
 * 
 * PROPÓSITO:
 * Servicio para generar documentos PDF usando Dompdf.
 * Gestiona la creación de Órdenes de Trabajo, Cotizaciones y Facturas.
 * 
 * INSTALACIÓN DE DOMPDF:
 * Desde la raíz del proyecto ejecutar:
 * composer require dompdf/dompdf
 * 
 * Si no tienen Composer:
 * 1. Descargar desde: https://getcomposer.org/download/
 * 2. Ejecutar: php composer.phar require dompdf/dompdf
 */

// Autoload de Composer (si está instalado)
// require_once __DIR__ . '/../../vendor/autoload.php';

// Si no usan Composer, pueden incluir Dompdf manualmente:
// require_once __DIR__ . '/../../libs/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFService {
    
    private $conn;
    private $dompdf;
    
    /**
     * Constructor
     * 
     * @param PDO $conn Conexión a la base de datos
     */
    public function __construct($conn) {
        $this->conn = $conn;
        
        // Configurar opciones de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // Para cargar imágenes externas
        $options->set('defaultFont', 'Arial');
        
        $this->dompdf = new Dompdf($options);
    }
    
    /**
     * ========================================
     * MÉTODO 1: Obtener Datos Completos de Orden de Trabajo
     * ========================================
     * 
     * Recupera toda la información necesaria para generar una OT:
     * - Datos del cliente
     * - Datos del vehículo
     * - Lista de trabajos realizados
     * - Lista de repuestos utilizados
     * - Totales (mano de obra + repuestos)
     * 
     * @param int $ordenId ID de la orden de trabajo
     * @return array|null Datos completos o null si no existe
     */
    public function obtenerDatosOrdenTrabajo($ordenId) {
        try {
            // Obtener datos principales de la orden
            $sql = "SELECT 
                        r.id,
                        r.fecha_ingreso,
                        r.fecha_entrega,
                        r.estado,
                        r.diagnostico,
                        r.tipo_averia,
                        r.costo_estimado,
                        r.costo_mano_obra,
                        v.patente,
                        v.marca,
                        v.modelo,
                        v.año,
                        v.kilometraje,
                        c.nombre as cliente_nombre,
                        c.email as cliente_email,
                        c.telefono as cliente_telefono,
                        c.rut as cliente_rut
                    FROM reparaciones r
                    INNER JOIN vehiculos v ON r.vehiculo_id = v.id
                    INNER JOIN clientes c ON v.cliente_id = c.id
                    WHERE r.id = :id";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $ordenId]);
            $orden = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$orden) {
                return null; // Orden no encontrada
            }
            
            // Obtener repuestos utilizados
            $sql = "SELECT 
                        r.nombre,
                        r.precio_unitario,
                        dr.cantidad,
                        (r.precio_unitario * dr.cantidad) as subtotal
                    FROM detalle_repuesto dr
                    INNER JOIN repuestos r ON dr.id_repuesto = r.id
                    WHERE dr.id_reparacion = :id";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $ordenId]);
            $orden['repuestos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Calcular totales
            $totalRepuestos = array_sum(array_column($orden['repuestos'], 'subtotal'));
            $orden['total_repuestos'] = $totalRepuestos;
            $orden['total_general'] = $totalRepuestos + ($orden['costo_mano_obra'] ?? 0);
            
            return $orden;
            
        } catch (PDOException $e) {
            error_log("Error en obtenerDatosOrdenTrabajo: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * ========================================
     * MÉTODO 2: Generar HTML de Orden de Trabajo
     * ========================================
     * 
     * Crea el HTML completo de la OT usando una plantilla.
     * Este HTML será convertido a PDF por Dompdf.
     * 
     * @param array $datos Datos de la orden (del método anterior)
     * @return string HTML renderizado
     */
    private function generarHTMLOrdenTrabajo($datos) {
        // Iniciar buffer de salida para capturar el HTML
        ob_start();
        
        // Incluir la vista de la plantilla PDF
        // La vista tiene acceso a la variable $datos
        include __DIR__ . '/../../views/pdf/orden_trabajo_template.php';
        
        // Capturar y retornar el contenido
        $html = ob_get_clean();
        
        return $html;
    }
    
    /**
     * ========================================
     * MÉTODO 3: Generar y Descargar PDF de Orden de Trabajo
     * ========================================
     * 
     * Método principal que orquesta todo el proceso:
     * 1. Obtiene los datos
     * 2. Genera el HTML
     * 3. Convierte a PDF
     * 4. Descarga el archivo
     * 
     * @param int $ordenId ID de la orden
     * @param bool $descargar True para forzar descarga, false para mostrar en navegador
     * @return bool True si se generó correctamente
     */
    public function generarPDFOrdenTrabajo($ordenId, $descargar = true) {
        try {
            // 1. Obtener datos
            $datos = $this->obtenerDatosOrdenTrabajo($ordenId);
            
            if (!$datos) {
                throw new Exception("Orden de trabajo no encontrada");
            }
            
            // 2. Generar HTML
            $html = $this->generarHTMLOrdenTrabajo($datos);
            
            // 3. Cargar HTML en Dompdf
            $this->dompdf->loadHtml($html);
            
            // 4. Configurar tamaño de página y orientación
            $this->dompdf->setPaper('Letter', 'portrait');
            
            // 5. Renderizar el PDF (procesar el HTML)
            $this->dompdf->render();
            
            // 6. Enviar el PDF al navegador
            $nombreArchivo = "OrdenTrabajo_" . $ordenId . "_" . date('Ymd') . ".pdf";
            
            // Si $descargar = true, fuerza la descarga
            // Si $descargar = false, abre el PDF en el navegador
            $this->dompdf->stream($nombreArchivo, [
                "Attachment" => $descargar
            ]);
            
            return true;
            
        } catch (Exception $e) {
            error_log("Error en generarPDFOrdenTrabajo: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * ========================================
     * MÉTODO ALTERNATIVO: Generar PDF sin Librería
     * ========================================
     * 
     * Si no pueden instalar Dompdf, pueden usar esta alternativa:
     * Genera un HTML optimizado para "Imprimir como PDF" desde el navegador.
     * 
     * @param int $ordenId
     * @return string HTML para imprimir
     */
    public function generarHTMLParaImprimir($ordenId) {
        $datos = $this->obtenerDatosOrdenTrabajo($ordenId);
        
        if (!$datos) {
            return "<h1>Orden no encontrada</h1>";
        }
        
        // Generar HTML con estilos inline para impresión
        $html = $this->generarHTMLOrdenTrabajo($datos);
        
        // Agregar estilos específicos para impresión
        $html = "<style>
            @media print {
                body { margin: 0; padding: 20px; }
                .no-imprimir { display: none !important; }
            }
        </style>" . $html;
        
        return $html;
    }
}
?>
