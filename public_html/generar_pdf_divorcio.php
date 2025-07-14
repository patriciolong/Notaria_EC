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
                td.id_tram_div,
                td.td_controvertido,
                td.td_consensual,
                td.td_notarial,
                td.td_identificacion_c,
                td.td_nombre_c,
                td.td_direccion_c,
                td.td_telefono_c,
                td.td_estado_c,
                td.td_ciudad_c,
                td.td_apt_c,
                td.td_cpostal_c,
                td.td_lugar_matrimonio,
                td.td_fecha_matrimonio,
                td.td_fecha,
                td.td_separados,
                td.td_noseparados,
                td.td_tiempo_separacion,
                td.td_ep_matrimonio,
                td.td_ep_nacimiento,
                td.td_estado_contac_ecuador,
                td.td_tel_ecuador,
                td.td_observaciones,
                td.td_valor,
                td.td_abono,
                td.td_saldo,
                td.td_oficina,
                td.td_motivo_divorcio,
                td.td_con_quien_vive,
                c.c_nombre,
                c.c_apellido,
                c.c_identificacion,
                c.c_telefono,
                c.c_direccion,
                c.c_estado,
                c.c_ciudad,
                c.c_codpostal,
                c.c_email,
                c.c_napartamento,
                u.u_usuario AS nombre_usuario
              FROM tramite_divorcio td
              JOIN cliente c ON td.id_cliente = c.id_cliente
              JOIN
                usuario u ON td.id_usuario = u.id_usuario
              WHERE td.id_tram_div = ?";

    $stmt = $conexion->prepare($query);
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conexion->error);
    }
    $stmt->bind_param("i", $id_tramite_varios);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $divorcio_data = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Trámite de Divorcio - <?php echo htmlspecialchars($divorcio_data['id_tram_div']); ?></title>
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
                .footer-info {
                    margin-top: 10px;
                    font-size: 11px;
                    color: #777;
                    text-align: left;
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
                        <img src="img/logo.png" alt="Logo de la Notaría" class="header-logo">
                    </div>
                    
                    <div class="header-right">
                        <div class="field-row" style="margin-bottom: 0;">
                            <div class="field" style="justify-content: flex-end; width: 100%; margin-bottom: 0;">
                                <span class="field-label">Oficina:</span>
                                <span class="field-value" style="border-bottom: none;"><?php echo htmlspecialchars($divorcio_data['td_oficina']); ?></span>
                            </div>
                        </div>
                        <div class="field-row" style="margin-bottom: 0;">
                            <div class="field" style="justify-content: flex-end; width: 100%; margin-bottom: 0;">
                                <span class="field-label">Fecha:</span>
                                <span class="field-value" style="border-bottom: none;"><?php echo htmlspecialchars($divorcio_data['td_fecha']); ?></span>
                            </div>
                        </div>
                        <div class="field-row" style="margin-bottom: 0;">
                            <div class="field" style="justify-content: flex-end; width: 100%; margin-bottom: 0;">
                                <span class="field-label">Atendido por:</span>
                                <span class="field-value" style="border-bottom: none;"><?php echo htmlspecialchars($divorcio_data['nombre_usuario']); ?></span>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="title">COMPROBANTE DE TRÁMITE DE DIVORCIO</div>

                <div class="section-title">1. DATOS DEL CLIENTE (PERSONA QUE SOLICITA EL DIVORCIO):</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NOMBRES Y APELLIDOS (COMPLETOS):</span>
                        <span class="field-value"><?php echo htmlspecialchars(($divorcio_data['c_nombre'] ?? '') . ' ' . ($divorcio_data['c_apellido'] ?? '')); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">NÚMERO DE IDENTIFICACIÓN:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_identificacion'] ?? '__________'); ?></span>
                    </div>
                    <div class="field">
                        <span class="field-label">AP. NO.</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_napartamento'] ?? '__________'); ?></span>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">DIRECCIÓN:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_direccion'] ?? '__________'); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field quarter-width">
                        <span class="field-label">CIUDAD:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_ciudad'] ?? '__________'); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">ESTADO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_estado'] ?? '__________'); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">CÓDIGO POSTAL:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_codpostal'] ?? '__________'); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">TELÉFONO: (</span>
                        <span class="field-value" style="width: 150px;"><?php echo htmlspecialchars($divorcio_data['c_telefono'] ?? '__________'); ?></span>
                        <span class="field-label">)</span>
                    </div>
                    <div class="field half-width">
                        <span class="field-label">CELULAR: (</span>
                        <span class="field-value" style="width: 150px;"><?php echo htmlspecialchars($divorcio_data['c_telefono'] ?? '__________'); ?></span> <span class="field-label">)</span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">CORREO ELECTRÓNICO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_email'] ?? '__________'); ?></span>
                    </div>
                </div>
                <div class="section-title">2. DATOS DEL CÓNYUGE:</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NOMBRES Y APELLIDOS (COMPLETOS):</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_nombre_c'] ?? '__________'); ?></span>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NO.-DE IDENTIFICACIÓN:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_identificacion_c'] ?? '__________'); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">DIRECCIÓN:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_direccion_c'] ?? '__________'); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field quarter-width">
                        <span class="field-label">CIUDAD:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_ciudad_c'] ?? '__________'); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">ESTADO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_estado_c'] ?? '__________'); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">CÓDIGO POSTAL:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_cpostal_c'] ?? '__________'); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">AP. NO.</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_apt_c'] ?? '__________'); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">TELÉFONO: (</span>
                        <span class="field-value" style="width: 150px;"><?php echo htmlspecialchars($divorcio_data['td_telefono_c'] ?? '__________'); ?></span>
                        <span class="field-label">)</span>
                    </div>
                </div>
                <div class="section-title">3. DETALLES DEL DIVORCIO:</div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">TIPO DE DIVORCIO:</span>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo ($divorcio_data['td_controvertido'] == '1') ? 'checked' : ''; ?>"></div>
                            <span class="field-label">CONTROVERTIDO</span>
                        </div>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo ($divorcio_data['td_consensual'] == '1') ? 'checked' : ''; ?>"></div>
                            <span class="field-label">CONSENSUAL</span>
                        </div>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo ($divorcio_data['td_notarial'] == '1') ? 'checked' : ''; ?>"></div>
                            <span class="field-label">NOTARIAL</span>
                        </div>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">LUGAR DE MATRIMONIO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_lugar_matrimonio'] ?? '__________'); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">FECHA DE MATRIMONIO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_fecha_matrimonio'] ?? '__________'); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">¿ESTÁN SEPARADOS?</span>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo ($divorcio_data['td_separados'] == 1) ? 'checked' : ''; ?>"></div>
                            <span class="field-label">SÍ</span>
                        </div>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo ($divorcio_data['td_noseparados'] == 1) ? 'checked' : ''; ?>"></div>
                            <span class="field-label">NO</span>
                        </div>
                    </div>
                    <div class="field half-width">
                        <span class="field-label">TIEMPO DE SEPARACIÓN:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_tiempo_separacion'] ?? '__________'); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">POSEEN PARTIDA DE MATRIMONIO:</span>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo ($divorcio_data['td_ep_matrimonio'] == 1) ? 'checked' : ''; ?>"></div>
                            <span class="field-label">SÍ</span>
                        </div>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo ($divorcio_data['td_ep_matrimonio'] == 0) ? 'checked' : ''; ?>"></div>
                            <span class="field-label">NO</span>
                        </div>
                    </div>
                    <div class="field half-width">
                        <span class="field-label">POSEEN PARTIDA DE NACIMIENTO (HIJOS MENORES):</span>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo ($divorcio_data['td_ep_nacimiento'] == 1) ? 'checked' : ''; ?>"></div>
                            <span class="field-label">SÍ</span>
                        </div>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo ($divorcio_data['td_ep_nacimiento'] == 0) ? 'checked' : ''; ?>"></div>
                            <span class="field-label">NO</span>
                        </div>
                    </div>
                    <div class="field half-width">
                        <span class="field-label">MOTIVO DEL DIVORCIO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_motivo_divorcio']); ?></span>
                    </div>
                    <div class="field half-width">
                        <span class="field-label">PERSONAS CON LAS QUE VIVE:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_con_quien_vive']); ?></span>
                    </div>
                </div>
                <div class="section-title">4. CONTACTO EN ECUADOR (SI APLICA):</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NOMBRE DEL CONTACTO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_estado_contac_ecuador'] ?? '__________'); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">TELÉFONO DEL CONTACTO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_tel_ecuador'] ?? '__________'); ?></span>
                    </div>
                </div>

                <div class="section-title">5. OBSERVACIONES:</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-value" style="min-height: 50px;"><?php echo nl2br(htmlspecialchars($divorcio_data['td_observaciones'] ?? '')); ?></span>
                    </div>
                </div>
                <div class="field-row" style="margin-top: 20px;">
                    <div class="field quarter-width">
                        <span class="field-label">VALOR $</span>
                        <span class="field-value"><?php echo htmlspecialchars(number_format($divorcio_data['td_valor'] ?? 0, 2)); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">ABONO $</span>
                        <span class="field-value"><?php echo htmlspecialchars(number_format($divorcio_data['td_abono'] ?? 0, 2)); ?></span>
                        
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