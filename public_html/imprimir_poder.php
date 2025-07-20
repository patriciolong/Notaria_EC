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
    tp.id_tram_poderes,
    tp.tp_oficina,
    tp.tp_fecha,
    tp.tp_estado_civil,
    tp.tp_nombres_otorga_poder,
    tp.tp_cedulla_otorga_poder,
    tp.tp_razon_otorga_poder,
    tp.tp_opcion_envio_poder,
    tp.tp_observaciones,
    tp.tp_costo_tramite,
    tp.tp_abono_tramite,
    tp.tp_saldo,
    c.c_deuda,
    c.c_abonado,
    c.c_saldo,
    tp.tp_enviar_nombrede,
    tp.tp_ciudad_enviar,
    tp.tp_provincia,
    tp.tp_telefonos_enviar,
    c.c_identificacion,
    c.c_nombre,
    c.c_apellido,
    c.c_telefono,
    c.c_direccion,
    c.c_estado,
    c.c_ciudad,
    c.c_codpostal,
    c.c_email,
    c.c_napartamento
  FROM tramite_poderes tp
  JOIN cliente c ON tp.id_cliente = c.id_cliente
  WHERE tp.id_tram_poderes = ?";

    $stmt = $conexion->prepare($query);
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conexion->error);
    }
    $stmt->bind_param("i", $id_tramite_varios);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $poder_data = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Poder - <?php echo $poder_data['id_tram_poderes']; ?></title>
            <style>
                body {
                    font-family: 'Times New Roman', Times, serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                    color: #333;
                    /* Added for better single-page control, but can be problematic if content is too long */
                    height: 297mm; /* A4 height */
                    overflow: hidden; /* Hide overflow to attempt fitting */
                }
                .container {
                    width: 210mm; /* A4 width */
                    height: 297mm; /* A4 height */
                    margin: 0 auto; /* Centered with no top/bottom margin for more space */
                    background-color: #fff;
                    border: 1px solid #ddd;
                    box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
                    padding: 15mm 15mm; /* Reduced padding for more content space */
                    box-sizing: border-box;
                    display: flex; /* Use flexbox for better content distribution */
                    flex-direction: column;
                }
                .header {
                    display: flex; /* Usamos flexbox para alinear los elementos */
                    justify-content: space-between; /* Espacio entre el logo y la info de la notaría */
                    align-items: flex-start; /* Alinea los elementos al inicio (arriba) */
                    margin-bottom: 20px; /* Reduced margin */
                    border-bottom: 1px solid #eee;
                    padding-bottom: 10px; /* Reduced padding */
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
                    font-size: 22px; /* Slightly smaller */
                    color: #222;
                    text-transform: uppercase;
                }
                .header p {
                    margin: 2px 0; /* Reduced margin */
                    font-size: 10px; /* Slightly smaller */
                    color: #666;
                }
                .header-right {
                    flex-shrink: 0; /* Evita que la info se encoja */
                    text-align: right;
                }
                .title {
                    font-size: 18px; /* Slightly smaller */
                    font-weight: bold;
                    margin-bottom: 20px; /* Reduced margin */
                    color: #333;
                    text-align: center;
                    text-transform: uppercase;
                }
                .section-title {
                    font-size: 14px; /* Slightly smaller */
                    font-weight: bold;
                    margin-top: 18px; /* Reduced margin */
                    margin-bottom: 8px; /* Reduced margin */
                    color: #444;
                    border-bottom: 1px solid #ddd;
                    padding-bottom: 3px; /* Reduced padding */
                }
                .field-row {
                    display: flex;
                    flex-wrap: wrap;
                    margin-bottom: 3px; /* Significantly reduced margin */
                    font-size: 11px; /* Slightly smaller */
                }
                .field {
                    display: flex;
                    align-items: baseline;
                    margin-right: 20px; /* Reduced space between fields */
                    margin-bottom: 3px; /* Reduced margin for wrapped fields */
                    white-space: nowrap;
                }
                .field-label {
                    font-weight: bold;
                    margin-right: 5px; /* Closer to value */
                    color: #555;
                }
                .field-value {
                    flex-grow: 1;
                    color: #222;
                    border-bottom: 1px dotted #999;
                    padding-bottom: 0px; /* Reduced padding */
                    min-width: 40px; /* Smaller min-width */
                }
                .full-width {
                    width: 100%;
                }
                .half-width {
                    width: calc(50% - 10px); /* Adjusted for reduced margin-right */
                }
                .quarter-width {
                    width: calc(25% - 10px); /* Adjusted for reduced margin-right */
                }

                .checkbox-option {
                    display: flex;
                    align-items: center;
                    margin-right: 10px; /* Reduced space between checkbox options */
                    margin-bottom: 2px; /* Reduced margin */
                }
                .checkbox-box {
                    border: 1px solid #555;
                    width: 11px; /* Slightly smaller checkbox */
                    height: 11px; /* Slightly smaller checkbox */
                    margin-right: 4px; /* Reduced margin */
                    flex-shrink: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                .checkbox-box.checked::before {
                    content: 'X';
                    display: block;
                    font-size: 9px; /* Smaller 'X' */
                    font-weight: bold;
                    color: #000;
                }
                .disclaimer {
                    font-size: 9px; /* Smaller font */
                    color: #777;
                    margin-top: 20px; /* Reduced margin */
                    text-align: center;
                    padding-top: 8px; /* Reduced padding */
                    border-top: 1px dashed #eee;
                }

                .signature-section {
                    margin-top: auto; /* Push to the bottom */
                    padding-top: 10px; /* Reduced padding */
                    text-align: center;
                    flex-shrink: 0; /* Prevent it from shrinking */
                }
                .signature-block {
                    width: 70%; /* Wider signature line */
                    max-width: 350px; /* Increased max-width */
                    margin: 0 auto; /* Center the block */
                }
                .signature-line {
                    border-top: 1px solid #000;
                    margin-bottom: 3px; /* Reduced margin */
                    width: 100%;
                }
                .signature-text {
                    font-size: 10px; /* Slightly smaller */
                    color: #333;
                    text-transform: uppercase;
                }

                .no-print {
                    text-align: center;
                    padding: 10px; /* Reduced padding */
                    background-color: #f0f0f0;
                    border-top: 1px solid #ddd;
                    position: sticky;
                    bottom: 0;
                    z-index: 100;
                    flex-shrink: 0; /* Prevent it from shrinking */
                }
                .no-print button {
                    padding: 8px 20px; /* Reduced padding */
                    font-size: 13px; /* Slightly smaller font */
                    margin: 0 5px; /* Reduced margin */
                }

                @media print {
                    html, body {
                        margin: 0;
                        padding: 0;
                        height: 100%; /* Ensure full height on print */
                        overflow: hidden; /* Crucial for single page */
                    }
                    .container {
                        width: 100%;
                        height: 100%; /* Make container fill the page */
                        border: none;
                        box-shadow: none;
                        padding: 10mm; /* Reduced padding for print */
                        margin: 0;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between; /* Distribute content */
                    }
                    .no-print {
                        display: none;
                    }
                    .header, .title, .section-title, .field-label, .field-value, .checkbox-box, .signature-text {
                        color: #000 !important;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <div class="header-left">
                        <img src="img/logo_impre.png" alt="Logo de la Notaría" class="header-logo">
                    </div>
                    <div class="header-right">
                        <div class="field-row" style="margin-bottom: 0;">
                            <div class="field" style="justify-content: flex-end; width: 100%; margin-bottom: 0;">
                                <span class="field-label">Oficina:</span>
                                <span class="field-value" style="border-bottom: none;"><?php echo htmlspecialchars($poder_data['tp_oficina']); ?></span>
                            </div>
                        </div>
                        <div class="field-row" style="margin-bottom: 0;">
                            <div class="field" style="justify-content: flex-end; width: 100%; margin-bottom: 0;">
                                <span class="field-label">Fecha:</span>
                                <span class="field-value" style="border-bottom: none;"><?php echo htmlspecialchars($poder_data['tp_fecha']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="title">COMPROBANTE DE TRÁMITE DE PODER</div>


                <div class="section-title">1. PERSONA QUE OTORGA EL PODER (USTED):</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NOMBRES Y APELLIDOS (COMPLETOS):</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_nombre'] . ' ' . $poder_data['c_apellido']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">NÚMERO DE IDENTIFICACIÓN:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_identificacion']); ?></span>
                    </div>
                    
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">DIRECCIÓN:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_direccion']); ?></span>
                    </div>
                    <div class="field half-width">
                        <span class="field-label">AP. NO.</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_napartamento']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field quarter-width">
                        <span class="field-label">CIUDAD:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_ciudad']); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">ESTADO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_estado']); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">CÓDIGO POSTAL:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_codpostal']); ?></span>
                    </div>
                </div>
                <div class="field-row" style="align-items: flex-start;">
                    <div class="field full-width" style="flex-direction: column; align-items: flex-start; margin-right: 0;">
                        <span class="field-label" style="margin-bottom: 3px;">ESTADO CIVIL:</span>
                        <div style="display: flex; flex-wrap: wrap;">
                            <div class="checkbox-option">
                                <div class="checkbox-box <?php echo (strtolower($poder_data['tp_estado_civil']) == 'casados juntos') ? 'checked' : ''; ?>"></div>
                                <span class="field-label" style="font-weight: normal;">CASADO(A)</span>
                            </div>
                            <div class="checkbox-option">
                                <div class="checkbox-box <?php echo (strtolower($poder_data['tp_estado_civil']) == 'soltero(a)') ? 'checked' : ''; ?>"></div>
                                <span class="field-label" style="font-weight: normal;">SOLTERO(A)</span>
                            </div>
                            <div class="checkbox-option">
                                <div class="checkbox-box <?php echo (strtolower($poder_data['tp_estado_civil']) == 'union libre') ? 'checked' : ''; ?>"></div>
                                <span class="field-label" style="font-weight: normal;">UNIÓN LIBRE</span>
                            </div>
                            <div class="checkbox-option">
                                <div class="checkbox-box <?php echo (strtolower($poder_data['tp_estado_civil']) == 'divorciado(a)') ? 'checked' : ''; ?>"></div>
                                <span class="field-label" style="font-weight: normal;">DIVORCIADO(A)</span>
                            </div>
                            <div class="checkbox-option">
                                <div class="checkbox-box <?php echo (strtolower($poder_data['tp_estado_civil']) == 'viudo(a)') ? 'checked' : ''; ?>"></div>
                                <span class="field-label" style="font-weight: normal;">VIUDO(A)</span>
                            </div>
                            <div class="checkbox-option">
                                <div class="checkbox-box <?php echo (!in_array(strtolower($poder_data['tp_estado_civil']), ['casados juntos', 'soltero(a)', 'union libre', 'divorciado(a)', 'viudo(a)'])) ? 'checked' : ''; ?>"></div>
                                <span class="field-label" style="font-weight: normal;">OTRO</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">TELÉFONO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_telefono']); ?></span>
                    </div>
                    <div class="field half-width">
                        <span class="field-label">CELULAR:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_telefono']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">CORREO ELECTRÓNICO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_email']); ?></span>
                    </div>
                </div>

                <div class="section-title">2. PERSONA A FAVOR DE QUIEN OTORGA EL PODER:</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NOMBRE Y APELLIDOS COMPLETOS:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_nombres_otorga_poder']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NO. DE CÉDULA (SI LO SABE):</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_cedulla_otorga_poder']); ?></span>
                    </div>
                </div>

                <div class="section-title">3. RAZÓN DEL PODER:</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-value" style="min-height: 30px; border: 1px dashed #ccc; padding: 3px; box-sizing: border-box; width: 100%;"><?php echo htmlspecialchars($poder_data['tp_razon_otorga_poder']); ?></span>
                    </div>
                </div>

                <div class="section-title">4. USTED PREFIERE QUE EL PODER SE LE ENVÍE:</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-value" style="min-height: 18px; border: 1px dashed #ccc; padding: 3px; box-sizing: border-box; width: 100%;"><?php echo htmlspecialchars($poder_data['tp_opcion_envio_poder']); ?></span>
                    </div>
                </div>

                <div class="disclaimer">
                    <p>NOTARÍA ECUADOR INC. ESTE DOCUMENTO SERÁ LEGALIZADO A TRAVÉS DE LA APOSTILLA.</p>
                </div>

                <div class="section-title" style="margin-top: 20px;">DETALLES DE PAGO Y ENVÍO:</div>
                <div class="field-row">
                    <div class="field quarter-width">
                        <span class="field-label">VALOR DEL TRAMITE: $</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_costo_tramite'] ?? '__________'); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">MONTO ABONADO: $</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_abono_tramite'] ?? '__________'); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">SALDO: $</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_saldo'] ?? '__________'); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">ENVIAR A ECUADOR A NOMBRE DE:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_enviar_nombrede']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">CIUDAD - PROVINCIA:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_ciudad_enviar'] . ' - ' . $poder_data['tp_provincia']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">TELÉFONOS (011593):</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_telefonos_enviar']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">OBSERVACIONES:</span>
                        <span class="field-value" style="min-height: 30px; border: 1px dashed #ccc; padding: 3px; box-sizing: border-box; width: 100%;"><?php echo htmlspecialchars($poder_data['tp_observaciones']); ?></span>
                    </div>
                </div>

                <div class="signature-section">
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <div class="signature-text">FIRMA DEL CLIENTE</div>
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
        echo "<p style='text-align: center; color: red; margin-top: 50px;'>No se encontró el registro del trámite con ID: " . htmlspecialchars($id_tramite_varios) . "</p>";
    }
    $stmt->close();
} else {
    echo "<p style='text-align: center; color: red; margin-top: 50px;'>ID de trámite no especificado.</p>";
}
$conexion->close();
?>