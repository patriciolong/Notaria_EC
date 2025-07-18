<?php
// imprimir_tramite_varios.php
session_start();
error_reporting(0); // Para suprimir errores en producción, en desarrollo usar E_ALL
$varsesion = $_SESSION['usuario'];

if ($varsesion == null || $varsesion == '') {
    header("location:index.php");
    die;
}

include("conexionbd.php"); // Tu archivo de conexión a la base de datos

// Verifica si se recibió un ID de trámite varios por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_tramite_varios = $_GET['id'];

    // Prepara la consulta SQL para obtener los datos del trámite y del cliente
    $query = "SELECT
                tv.id_tramite_varios,
                tv.tv_motivo,
                tv.tv_oenvio,
                tv.tv_nrecibo,
                tv.tv_nom_envio,
                tv.tv_oficina,
                tv.tv_fecha,
                tv.tv_ciudad AS tv_ciudad_envio,
                tv.tv_provincia AS tv_provincia_envio,
                tv.tv_telefono AS tv_telefono_envio,
                tv.tv_tip_documento,
                tv.tv_traducciones,
                tv.tv_notarizacion,
                tv.tv_certificacion,
                tv.tv_apostilla,
                tv.tv_valor_tramite,
                tv.tv_abono_tramite,
                tv.tv_observaciones,
                c.c_identificacion,
                c.c_nombre,
                c.c_estado,
                c.c_napartamento,
                c.c_apellido,
                c.c_telefono AS c_telefono_cliente,
                c.c_direccion,
                c.c_ciudad AS c_ciudad_cliente,
                c.c_email,
                c.c_codpostal,
                u.u_usuario AS nombre_usuario
            FROM
                tramites_varios tv
            JOIN
                cliente c ON tv.id_cliente = c.id_cliente
            JOIN
                usuario u ON tv.id_usuario = u.id_usuario
            WHERE
                tv.id_tramite_varios = ?";

    $stmt = $conexion->prepare($query);
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conexion->error);
    }
    $stmt->bind_param("i", $id_tramite_varios);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $tramite_data = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Comprobante de Trámite Varios</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    margin: 0;
                    padding: 20px;
                    background-color: #f4f4f4;
                }
                .container {
                    width: 210mm; /* A4 width */
                    min-height: 297mm; /* A4 height */
                    margin: 0 auto;
                    background-color: #fff;
                    border: 1px solid #ccc;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    padding: 20mm;
                    box-sizing: border-box; /* Include padding in width/height */
                }
                .header {
                    display: flex; /* Usamos flexbox para alinear los elementos */
                    justify-content: space-between; /* Espacio entre el logo y la info de la notaría */
                    align-items: flex-start; /* Alinea los elementos al inicio (arriba) */
                    margin-bottom: 30px;
                    border-bottom: 1px solid #eee;
                    padding-bottom: 10px;
                }
                .header-left {
                    flex-shrink: 0; /* Evita que el logo se encoja */
                }
                .header-logo {
                    max-width: 100px; /* Ajusta el tamaño del logo según sea necesario */
                    height: auto;
                }
                .header-center {
                    flex-grow: 1; /* Permite que el centro ocupe el espacio disponible */
                    text-align: center; /* Centra el título principal */
                }
                .header h1 {
                    margin: 0;
                    font-size: 24px;
                    color: #333;
                }
                .header p {
                    margin: 2px 0;
                    font-size: 12px;
                    color: #666;
                }
                .header-right {
                    flex-shrink: 0; /* Evita que la info se encoja */
                    text-align: right;
                    font-size: 12px;
                    color: #666;
                }
                .header-right p {
                    margin: 2px 0;
                }
                .title {
                    font-size: 18px;
                    font-weight: bold;
                    margin-bottom: 15px;
                    color: #333;
                    text-align: center;
                }
                .section-title {
                    font-size: 14px;
                    font-weight: bold;
                    margin-top: 20px;
                    margin-bottom: 10px;
                    color: #555;
                    border-bottom: 1px solid #eee;
                    padding-bottom: 5px;
                }
                .field-row {
                    display: flex;
                    margin-bottom: 5px;
                    font-size: 12px;
                }
                .field-label {
                    font-weight: bold;
                    width: 150px; /* Adjust as needed */
                    flex-shrink: 0;
                    color: #444;
                }
                .field-value {
                    flex-grow: 1;
                    color: #222;
                }
                .checkbox-list {
                    margin-top: 5px;
                    margin-left: 20px;
                    font-size: 12px;
                }
                .checkbox-item {
                    margin-bottom: 3px;
                }
                .total-amount {
                    text-align: right;
                    font-size: 16px;
                    font-weight: bold;
                    margin-top: 30px;
                    border-top: 1px solid #eee;
                    padding-top: 10px;
                }
                .footer-info {
                    margin-top: 50px;
                    font-size: 11px;
                    color: #777;
                    text-align: left;
                }
                .signature-section {
                    margin-top: 60px; /* Space for signatures */
                    display: flex;
                    justify-content: space-around;
                    text-align: center;
                }
                .signature-block {
                    flex-basis: 45%;
                }
                .signature-line {
                    border-top: 1px solid #000;
                    margin-bottom: 5px;
                    width: 80%; /* Adjust as needed */
                    margin-left: auto;
                    margin-right: auto;
                }
                .signature-text {
                    font-size: 10px;
                    color: #333;
                }
                .no-print {
                    text-align: center;
                    margin-top: 30px;
                    position: sticky;
                    bottom: 20px;
                    background-color: #f4f4f4;
                    padding: 10px;
                    border-top: 1px solid #eee;
                }
                .no-print button {
                    padding: 10px 20px;
                    background-color: #007bff;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    margin: 0 5px;
                    font-size: 14px;
                }
                .no-print button:hover {
                    opacity: 0.9;
                }
                .no-print button.close {
                    background-color: #6c757d;
                }

                @media print {
                    .no-print {
                        display: none;
                    }
                    body {
                        margin: 0;
                        padding: 0;
                    }
                    .container {
                        width: 100%;
                        min-height: auto;
                        border: none;
                        box-shadow: none;
                        padding: 0;
                        margin: 0;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <div class="header-left">
                        <img src="img/logo.png" alt="Logo de la Notaría" class="header-logo">
                    </div>
                    
                    <div class="header-right">
                    <p>Fecha: <?php echo htmlspecialchars(($tramite_data['tv_fecha'] ?? '')); ?></p>
                        <p>Oficina: <?php echo htmlspecialchars(($tramite_data['tv_oficina'] ?? '')); ?></p>
                    </div>
                </div>

                <div class="title">COMPROBANTE DE TRÁMITE VARIOS</div>
                

                <div class="section-title">INFORMACIÓN DEL CLIENTE</div>
                <div class="field-row">
                    <span class="field-label">Nombres Completos:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['c_nombre'] . ' ' . $tramite_data['c_apellido']); ?></span>
                </div>
                <div class="field-row">
                    <span class="field-label">Identificación/RUC:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['c_identificacion']); ?></span>
                </div>
                <div class="field-row">
                    <span class="field-label">Teléfono:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['c_telefono_cliente']); ?></span>
                </div>
                <div class="field-row">
                    <span class="field-label">Dirección:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['c_direccion'] . ', ' . $tramite_data['c_ciudad_cliente']. ', ' . $tramite_data['c_estado']); ?></span>
                </div>
                <div class="field-row">
                    <span class="field-label">N° Apartamento:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['c_napartamento']); ?></span>
                </div>
                <div class="field-row">
                    <span class="field-label">Email:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['c_email']); ?></span>
                </div>
                <div class="field-row">
                    <span class="field-label">Código Postal:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['c_codpostal']); ?></span>
                </div>

                <div class="section-title">DETALLES DEL TRÁMITE</div>
                <div class="field-row">
                    <span class="field-label">Motivo del Trámite:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['tv_motivo']); ?></span>
                </div>
                <div class="field-row">
                    <span class="field-label">Tipo de Documento:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['tv_tip_documento']); ?></span>
                </div>
                <div class="field-row">
                    <span class="field-label">Servicios Solicitados:</span>
                </div>
                <div class="checkbox-list">
                    <div class="checkbox-item">
                        <span><?php echo ($tramite_data['tv_traducciones'] ? '[X]' : '[ ]'); ?></span> Traducciones
                    </div>
                    <div class="checkbox-item">
                        <span><?php echo ($tramite_data['tv_notarizacion'] ? '[X]' : '[ ]'); ?></span> Notarización
                    </div>
                    <div class="checkbox-item">
                        <span><?php echo ($tramite_data['tv_certificacion'] ? '[X]' : '[ ]'); ?></span> Certificación
                    </div>
                    <div class="checkbox-item">
                        <span><?php echo ($tramite_data['tv_apostilla'] ? '[X]' : '[ ]'); ?></span> Apostilla
                    </div>
                </div>
                <div class="field-row" style="margin-top: 10px;">
                    <span class="field-label">Observaciones:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['tv_observaciones']); ?></span>
                </div>

                <?php if (!empty($tramite_data['tv_oenvio']) && $tramite_data['tv_oenvio'] != 'N/A'): ?>
                <div class="section-title">INFORMACIÓN DE ENVÍO</div>
                <div class="field-row">
                    <span class="field-label">Opción de Envío:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['tv_oenvio']); ?></span>
                </div>
                <div class="field-row">
                    <span class="field-label">Nombre de Remitente:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['tv_nom_envio']); ?></span>
                </div>
                <div class="field-row">
                    <span class="field-label">Ciudad de Envío:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['tv_ciudad_envio']); ?></span>
                </div>
                <div class="field-row">
                    <span class="field-label">Provincia de Envío:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['tv_provincia_envio']); ?></span>
                </div>
                <div class="field-row">
                    <span class="field-label">Teléfono de Envío:</span>
                    <span class="field-value"><?php echo htmlspecialchars($tramite_data['tv_telefono_envio']); ?></span>
                </div>
                <?php endif; ?>

                <div class="total-amount">
                    Valor del Trámite: $<?php echo number_format($tramite_data['tv_valor_tramite'], 2); ?>
                    <br>
                    Abono del Trámite: $<?php echo number_format($tramite_data['tv_abono_tramite'], 2); ?>
                </div>
               

                <div class="footer-info">
                    <p>Atendido por: <?php echo htmlspecialchars($tramite_data['nombre_usuario']); ?></p>
                    <p>Fecha y Hora de Generación: <?php echo date('d/m/Y H:i:s'); ?></p>
                </div>

                <div class="signature-section">
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <div class="signature-text">FIRMA DEL CLIENTE</div>
                    </div>
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <div class="signature-text">FIRMA NOTARIO/RESPONSABLE</div>
                    </div>
                </div>

                <div class="no-print">
                    <button onclick="window.print()">Imprimir este documento</button>
                    <button class="close" onclick="window.close()">Cerrar</button>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "<p style='text-align: center; color: red;'>No se encontró el registro del trámite con ID: " . htmlspecialchars($id_tramite_varios) . "</p>";
    }
    $stmt->close();
} else {
    echo "<p style='text-align: center; color: red;'>ID de trámite no especificado.</p>";
}
$conexion->close();
?>