<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Trabajo #<?= htmlspecialchars($datos['id']) ?></title>
    
    <style>
        /**
         * ESTILOS PARA PDF
         * 
         * IMPORTANTE:
         * - Dompdf soporta CSS limitado (principalmente CSS2.1)
         * - No usar Flexbox ni Grid
         * - Preferir tablas para layout
         * - Usar medidas absolutas (px, pt, cm)
         */
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }
        
        /* ENCABEZADO */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #0066cc;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #0066cc;
            font-size: 24pt;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 10pt;
            color: #666;
        }
        
        /* NÚMERO DE ORDEN */
        .numero-orden {
            background-color: #f0f0f0;
            padding: 10px;
            text-align: center;
            font-size: 16pt;
            font-weight: bold;
            margin-bottom: 20px;
            border: 2px solid #333;
        }
        
        /* SECCIONES DE INFORMACIÓN */
        .seccion {
            margin-bottom: 20px;
        }
        
        .seccion h2 {
            background-color: #0066cc;
            color: white;
            padding: 8px;
            font-size: 12pt;
            margin-bottom: 10px;
        }
        
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .info-grid td {
            padding: 6px 10px;
            border: 1px solid #ddd;
        }
        
        .info-grid td:first-child {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 35%;
        }
        
        /* TABLA DE REPUESTOS */
        .tabla-repuestos {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .tabla-repuestos th {
            background-color: #333;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 10pt;
        }
        
        .tabla-repuestos td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            font-size: 10pt;
        }
        
        .tabla-repuestos tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-right {
            text-align: right;
        }
        
        /* TOTALES */
        .totales {
            width: 100%;
            margin-top: 20px;
        }
        
        .totales td {
            padding: 8px;
            font-size: 11pt;
        }
        
        .totales .label {
            text-align: right;
            font-weight: bold;
            width: 70%;
        }
        
        .totales .valor {
            text-align: right;
            border-bottom: 1px solid #ddd;
        }
        
        .totales .total-final {
            background-color: #0066cc;
            color: white;
            font-size: 14pt;
            font-weight: bold;
        }
        
        /* FOOTER */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            font-size: 9pt;
            color: #666;
        }
        
        .firmas {
            margin-top: 50px;
            width: 100%;
        }
        
        .firmas td {
            text-align: center;
            padding-top: 40px;
            border-top: 2px solid #333;
            width: 50%;
        }
        
        /* BADGE DE ESTADO */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 10pt;
            font-weight: bold;
        }
        
        .badge-completado {
            background-color: #28a745;
            color: white;
        }
        
        .badge-en-proceso {
            background-color: #ffc107;
            color: #333;
        }
        
        .badge-pendiente {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <!-- ENCABEZADO -->
    <div class="header">
        <h1>🔧 MIAUtomotriz</h1>
        <p>Taller Mecánico Automotriz | RUT: 12.345.678-9</p>
        <p>Dirección: Av. Principal 123, Santiago | Teléfono: +56 9 1234 5678</p>
        <p>Email: contacto@miautomotriz.cl</p>
    </div>
    
    <!-- NÚMERO DE ORDEN -->
    <div class="numero-orden">
        ORDEN DE TRABAJO #<?= htmlspecialchars($datos['id']) ?>
    </div>
    
    <!-- SECCIÓN: INFORMACIÓN DEL CLIENTE -->
    <div class="seccion">
        <h2>📋 Información del Cliente</h2>
        <table class="info-grid">
            <tr>
                <td>Nombre</td>
                <td><?= htmlspecialchars($datos['cliente_nombre']) ?></td>
            </tr>
            <tr>
                <td>RUT</td>
                <td><?= htmlspecialchars($datos['cliente_rut']) ?></td>
            </tr>
            <tr>
                <td>Teléfono</td>
                <td><?= htmlspecialchars($datos['cliente_telefono']) ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?= htmlspecialchars($datos['cliente_email']) ?></td>
            </tr>
        </table>
    </div>
    
    <!-- SECCIÓN: INFORMACIÓN DEL VEHÍCULO -->
    <div class="seccion">
        <h2>🚗 Información del Vehículo</h2>
        <table class="info-grid">
            <tr>
                <td>Patente</td>
                <td><strong><?= htmlspecialchars($datos['patente']) ?></strong></td>
            </tr>
            <tr>
                <td>Marca y Modelo</td>
                <td><?= htmlspecialchars($datos['marca'] . ' ' . $datos['modelo']) ?></td>
            </tr>
            <tr>
                <td>Año</td>
                <td><?= htmlspecialchars($datos['año']) ?></td>
            </tr>
            <tr>
                <td>Kilometraje</td>
                <td><?= number_format($datos['kilometraje'], 0, ',', '.') ?> km</td>
            </tr>
        </table>
    </div>
    
    <!-- SECCIÓN: DETALLES DE LA REPARACIÓN -->
    <div class="seccion">
        <h2>🔧 Detalles de la Reparación</h2>
        <table class="info-grid">
            <tr>
                <td>Fecha de Ingreso</td>
                <td><?= date('d/m/Y H:i', strtotime($datos['fecha_ingreso'])) ?></td>
            </tr>
            <tr>
                <td>Fecha de Entrega Estimada</td>
                <td>
                    <?= $datos['fecha_entrega'] 
                        ? date('d/m/Y', strtotime($datos['fecha_entrega'])) 
                        : 'A confirmar' 
                    ?>
                </td>
            </tr>
            <tr>
                <td>Estado</td>
                <td>
                    <span class="badge badge-<?= $datos['estado'] ?>">
                        <?= ucfirst(str_replace('_', ' ', htmlspecialchars($datos['estado']))) ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td>Tipo de Avería</td>
                <td><?= htmlspecialchars($datos['tipo_averia'] ?: 'No especificado') ?></td>
            </tr>
        </table>
        
        <?php if (!empty($datos['diagnostico'])): ?>
        <div style="margin-top: 10px; padding: 10px; background-color: #f9f9f9; border-left: 4px solid #0066cc;">
            <strong>Diagnóstico:</strong><br>
            <?= nl2br(htmlspecialchars($datos['diagnostico'])) ?>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- SECCIÓN: REPUESTOS UTILIZADOS -->
    <div class="seccion">
        <h2>🔩 Repuestos Utilizados</h2>
        
        <?php if (empty($datos['repuestos'])): ?>
            <p style="padding: 10px; background-color: #f9f9f9;">
                No se registraron repuestos para esta orden.
            </p>
        <?php else: ?>
            <table class="tabla-repuestos">
                <thead>
                    <tr>
                        <th style="width: 50%;">Descripción</th>
                        <th style="width: 15%; text-align: center;">Cantidad</th>
                        <th style="width: 15%; text-align: right;">Precio Unit.</th>
                        <th style="width: 20%; text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos['repuestos'] as $repuesto): ?>
                        <tr>
                            <td><?= htmlspecialchars($repuesto['nombre']) ?></td>
                            <td style="text-align: center;">
                                <?= htmlspecialchars($repuesto['cantidad']) ?>
                            </td>
                            <td class="text-right">
                                $<?= number_format($repuesto['precio_unitario'], 0, ',', '.') ?>
                            </td>
                            <td class="text-right">
                                <strong>
                                    $<?= number_format($repuesto['subtotal'], 0, ',', '.') ?>
                                </strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
    <!-- SECCIÓN: TOTALES -->
    <div class="seccion">
        <table class="totales">
            <tr>
                <td class="label">Subtotal Repuestos:</td>
                <td class="valor">$<?= number_format($datos['total_repuestos'], 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="label">Mano de Obra:</td>
                <td class="valor">$<?= number_format($datos['costo_mano_obra'] ?? 0, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td class="label total-final">TOTAL GENERAL:</td>
                <td class="valor total-final">$<?= number_format($datos['total_general'], 0, ',', '.') ?></td>
            </tr>
        </table>
    </div>
    
    <!-- FIRMAS -->
    <table class="firmas">
        <tr>
            <td>
                <strong>Firma del Cliente</strong><br>
                RUT: <?= htmlspecialchars($datos['cliente_rut']) ?>
            </td>
            <td>
                <strong>Firma del Mecánico</strong><br>
                MIAUtomotriz
            </td>
        </tr>
    </table>
    
    <!-- FOOTER -->
    <div class="footer">
        <p>Este documento es válido como comprobante de servicio realizado.</p>
        <p>Generado el <?= date('d/m/Y H:i:s') ?> | Sistema MIAUtomotriz v2.0</p>
        <p style="margin-top: 10px; font-size: 8pt;">
            * Los repuestos tienen garantía de 30 días<br>
            * La mano de obra tiene garantía de 90 días
        </p>
    </div>
</body>
</html>
