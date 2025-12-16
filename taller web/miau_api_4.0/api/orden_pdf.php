<?php
/**
 * orden_pdf.php
 * 
 * CONTROLADOR: Generación de PDF de Orden de Trabajo
 * 
 * UBICACIÓN: api/orden_pdf.php (punto de entrada público)
 * 
 * FUNCIONAMIENTO:
 * 1. Recibe el ID de la orden por GET (?id=123)
 * 2. Valida que el usuario esté autenticado
 * 3. Usa PDFService para generar el PDF
 * 4. Descarga automáticamente el archivo
 * 
 * USO:
 * <a href="../api/orden_pdf.php?id=5" target="_blank">Descargar PDF</a>
 */

session_start();

// IMPORTANTE: Validar autenticación
if (!isset($_SESSION['user_id'])) {
    die("Acceso denegado. Debe iniciar sesión.");
}

// Cargar dependencias
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../app/services/PDFService.php';

// Validar que se envió el ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Error: ID de orden inválido");
}

$ordenId = (int) $_GET['id'];

// Instanciar servicio PDF
$pdfService = new PDFService($conn);

// OPCIÓN 1: Si tienen Dompdf instalado (RECOMENDADO)
try {
    // Este método genera y descarga automáticamente el PDF
    $resultado = $pdfService->generarPDFOrdenTrabajo($ordenId, true);
    
    if (!$resultado) {
        throw new Exception("No se pudo generar el PDF");
    }
    
    // Si llegamos aquí, el PDF se descargó correctamente
    exit; // Importante: detener ejecución después de stream()
    
} catch (Exception $e) {
    // Si falla Dompdf, mostrar error o usar alternativa
    error_log("Error generando PDF: " . $e->getMessage());
    
    // OPCIÓN 2: Alternativa sin librería (HTML para imprimir)
    echo $pdfService->generarHTMLParaImprimir($ordenId);
    echo '<script>window.print();</script>'; // Auto-abrir diálogo de impresión
}

/*
 * ========================================
 * INSTRUCCIONES PARA INSTALAR DOMPDF:
 * ========================================
 * 
 * 1. Si tienen Composer instalado:
 *    composer require dompdf/dompdf
 * 
 * 2. Si NO tienen Composer:
 *    a) Descargar desde: https://github.com/dompdf/dompdf/releases
 *    b) Extraer en una carpeta 'vendor' o 'libs' en la raíz del proyecto
 *    c) Incluir el autoload: require_once __DIR__ . '/../vendor/dompdf/autoload.inc.php';
 * 
 * 3. Verificar instalación:
 *    Crear archivo test_dompdf.php con:
 *    <?php
 *    require 'vendor/autoload.php';
 *    use Dompdf\Dompdf;
 *    $dompdf = new Dompdf();
 *    echo "Dompdf instalado correctamente";
 *    ?>
 * 
 * ========================================
 * PRUEBAS:
 * ========================================
 * 
 * 1. Abrir en navegador: http://localhost/api/orden_pdf.php?id=1
 * 2. Debería descargar un PDF con los datos de la orden 1
 * 3. Si no funciona, revisar:
 *    - ¿Está instalado Dompdf?
 *    - ¿Existen los datos de la orden en la BD?
 *    - ¿Hay errores en el log de PHP?
 */
?>
