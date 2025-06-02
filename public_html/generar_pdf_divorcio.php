<?php
// Reportar errores para depuración (QUÍTALE ESTO EN PRODUCCIÓN)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Carga el autoloader de Composer si usaste Composer
require_once __DIR__ . '/../vendor/autoload.php';


// Si descargaste Dompdf manualmente, ajusta la ruta a tu carpeta dompdf
// require_once 'lib/dompdf/autoload.inc.php'; // Ejemplo si lo pusiste en public_html/lib/dompdf

use Dompdf\Dompdf;
use Dompdf\Options;

// Incluye tu archivo de conexión a la base de datos
include("conexionbd.php");

// 1. Obtener el ID del trámite de divorcio
// Asume que el ID del trámite de divorcio se pasa por la URL (GET)
// Por ejemplo: generar_pdf_divorcio.php?id=123
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_divorcio = $_GET['id'];

    // 2. Prepara la consulta SQL para obtener los datos del divorcio y del cliente
    $query = "SELECT
                td.id_tram_div,
                td.td_controvertido,
                td.td_consensual,
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
                c.c_nombre,
                c.c_apellido,
                c.c_identificacion,
                c.c_telefono,
                c.c_direccion,
                c.c_estado,
                c.c_ciudad,
                c.c_codpostal,
                c.c_email,
                c.c_napartamento
              FROM tramite_divorcio td
              JOIN cliente c ON td.id_cliente = c.id_cliente
              WHERE td.id_tram_div = ?";

    $stmt = $conexion->prepare($query);

    if ($stmt === false) {
        // Manejo de errores en la preparación de la consulta
        error_log("Error al preparar la consulta de divorcio: " . $conexion->error);
        die("Error al preparar la consulta de divorcio.");
    }

    $stmt->bind_param("i", $id_divorcio); // "i" para indicar que es un entero
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $divorcio_data = $result->fetch_assoc();
        $stmt->close();
        $conexion->close(); // Cierra la conexión después de obtener los datos

        // 3. Generar el HTML para el PDF
        // Usa un buffer de salida para capturar el HTML
        ob_start();
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Trámite de Divorcio - <?php echo htmlspecialchars($divorcio_data['id_tram_div']); ?></title>
            <style>
                /* Estilos generales del documento impreso */
                body {
                    font-family: 'Times New Roman', serif;
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                    color: #000;
                    font-size: 11pt; /* Ajusta el tamaño de fuente general */
                }

                .document-container {
                    width: 8.5in; /* Ancho de una hoja Carta */
                    height: 11in; /* Alto de una hoja Carta */
                    margin: 0; /* Sin márgenes en el cuerpo */
                    padding: 0.5in 0.75in; /* Márgenes internos (top/bottom, left/right) */
                    box-sizing: border-box;
                    position: relative; /* Para el posicionamiento del logo */
                }

                /* Encabezado */
                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    margin-bottom: 20px;
                }
                .logo {
                    width: 150px; /* Ajusta según el tamaño de tu logo */
                    height: auto;
                    position: absolute; /* Posicionamiento absoluto para el logo */
                    top: 0.5in; /* Ajusta la posición superior */
                    left: 0.75in; /* Ajusta la posición izquierda */
                }
                .header-info {
                    text-align: right;
                    margin-left: auto; /* Para que se alinee a la derecha */
                }
                .header-info p {
                    margin: 0;
                    font-size: 10pt;
                }
                .office-date-box {
                    border: 1px solid #000;
                    padding: 5px 10px;
                    margin-top: 5px;
                    display: inline-block; /* Para que el borde envuelva el contenido */
                }

                /* Secciones */
                .section-title {
                    font-weight: bold;
                    margin-top: 15px;
                    margin-bottom: 5px;
                    font-size: 11pt;
                }
                .field-row {
                    display: flex;
                    flex-wrap: wrap; /* Permite que los campos se envuelvan */
                    margin-bottom: 5px;
                    align-items: baseline; /* Alinea el texto en la base */
                }
                .field {
                    display: flex;
                    align-items: baseline;
                    margin-right: 20px; /* Espacio entre campos */
                    white-space: nowrap; /* Evita que el label y el valor se rompan */
                }
                .field-label {
                    font-weight: normal; /* Labels de campo no tan negritas */
                    margin-right: 5px;
                    font-size: 11pt;
                }
                .field-value {
                    border-bottom: 1px solid #000;
                    min-width: 80px; /* Ancho mínimo para el campo */
                    padding: 0 2px;
                    font-style: italic; /* Opcional: para diferenciar los valores */
                    font-size: 11pt;
                    flex-grow: 1; /* Permite que el valor crezca para llenar espacio */
                }
                .full-width {
                    width: 100%;
                    margin-right: 0 !important; /* Elimina margen derecho para ocupar todo el ancho */
                }
                .half-width {
                    width: calc(50% - 20px); /* Aproximadamente la mitad menos el margen */
                }
                .quarter-width {
                    width: calc(25% - 20px); /* Aproximadamente un cuarto menos el margen */
                }

                /* Espaciado para el formulario */
                .form-group {
                    margin-bottom: 10px;
                }

                /* Estilo de la línea horizontal para "___" */
                .underline {
                    border-bottom: 1px solid #000;
                    display: inline-block;
                    min-width: 50px; /* Ancho mínimo de la línea */
                }

                /* Para checkboxes y radio buttons */
                .checkbox-option {
                    display: flex;
                    align-items: center;
                    margin-right: 20px;
                    margin-bottom: 5px;
                }
                .checkbox-box {
                    border: 1px solid #000;
                    width: 12px;
                    height: 12px;
                    margin-right: 5px;
                    flex-shrink: 0; /* Evita que el checkbox se encoja */
                }
                .checkbox-box.checked::before {
                    content: 'X';
                    display: block;
                    text-align: center;
                    line-height: 12px;
                    font-size: 10px;
                }

                /* Pie de página para la firma */
                .signature-section {
                    margin-top: 50px;
                    text-align: center;
                }
                .signature-line {
                    border-bottom: 1px solid #000;
                    width: 250px; /* Ancho de la línea de firma */
                    margin: 0 auto 5px auto;
                }
                .signature-text {
                    font-size: 10pt;
                }
                .disclaimer {
                    font-size: 8pt;
                    text-align: justify;
                    margin-top: 30px;
                }

                /* Ocultar elementos no deseados al imprimir */
                @media print {
                    .no-print {
                        display: none !important;
                    }
                    body {
                        margin: 0;
                        padding: 0;
                    }
                    .document-container {
                        width: 100%; /* Ocupa todo el ancho de la página impresa */
                        height: auto; /* Altura automática para el contenido */
                        padding: 0.5in 0.75in; /* Mantén los márgenes de impresión */
                        box-shadow: none;
                        border: none;
                    }
                    .logo {
                        position: absolute; /* Mantener posición absoluta para el logo */
                        top: 0.5in;
                        left: 0.75in;
                    }
                }
            </style>
        </head>
        <body>
            <div class="document-container">
                <img src="img/logo.png" alt="Notaria Ecuador Logo" class="logo">
                <div class="header">
                    <div></div>
                    <div class="header-info">
                        <p>NOTARÍA ECUADOR</p>
                        <p>New York - Notary Public</p>
                        <div class="office-date-box">
                            <div class="field-row">
                                <div class="field">
                                    <span class="field-label">Fecha</span>
                                    <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_controvertido']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-title">1. DATOS DEL CLIENTE (PERSONA QUE SOLICITA EL DIVORCIO):</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NOMBRES Y APELLIDOS (COMPLETOS):</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_nombre'] . ' ' . $divorcio_data['c_apellido']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">NÚMERO DE IDENTIFICACIÓN:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_identificacion']); ?></span>
                    </div>
                    <div class="field">
                        <span class="field-label">AP. NO.</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_napartamento']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">DIRECCIÓN:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_direccion']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field quarter-width">
                        <span class="field-label">CIUDAD:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_ciudad']); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">ESTADO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_estado']); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">CÓDIGO POSTAL:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_codpostal']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">TELÉFONO: (</span>
                        <span class="field-value" style="width: 150px;"><?php echo htmlspecialchars($divorcio_data['c_telefono']); ?></span>
                        <span class="field-label">)</span>
                    </div>
                    <div class="field half-width">
                        <span class="field-label">CELULAR: (</span>
                        <span class="field-value" style="width: 150px;"><?php echo htmlspecialchars($divorcio_data['c_telefono']); ?></span> <span class="field-label">)</span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">CORREO ELECTRÓNICO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['c_email']); ?></span>
                    </div>
                </div>

                <div class="section-title">2. DATOS DEL CÓNYUGE:</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NOMBRES Y APELLIDOS (COMPLETOS):</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_nombre_c']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NO.-DE IDENTIFICACIÓN:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_identificacion_c']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">DIRECCIÓN:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_direccion_c']); ?></span>
                    </div>
                </div>
                 <div class="field-row">
                    <div class="field quarter-width">
                        <span class="field-label">CIUDAD:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_ciudad_c']); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">ESTADO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_estado_c']); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">CÓDIGO POSTAL:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_cpostal_c']); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">AP. NO.</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_apt_c']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">TELÉFONO: (</span>
                        <span class="field-value" style="width: 150px;"><?php echo htmlspecialchars($divorcio_data['td_telefono_c']); ?></span>
                        <span class="field-label">)</span>
                    </div>
                </div>

                <div class="section-title">3. DETALLES DEL DIVORCIO:</div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">TIPO DE DIVORCIO:</span>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo ($divorcio_data['td_controvertido'] == 'Controvertido') ? 'checked' : ''; ?>"></div>
                            <span class="field-label">CONTROVERTIDO</span>
                        </div>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo ($divorcio_data['td_consensual'] == 'Consensual') ? 'checked' : ''; ?>"></div>
                            <span class="field-label">CONSENSUAL</span>
                        </div>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">LUGAR DE MATRIMONIO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_lugar_matrimonio']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">FECHA DE MATRIMONIO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_fecha_matrimonio']); ?></span>
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
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_tiempo_separacion']); ?></span>
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
                </div>

                <div class="section-title">4. CONTACTO EN ECUADOR (SI APLICA):</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NOMBRE DEL CONTACTO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_estado_contac_ecuador']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">TELÉFONO DEL CONTACTO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['td_tel_ecuador']); ?></span>
                    </div>
                </div>

                <div class="section-title">5. OBSERVACIONES:</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-value" style="min-height: 50px;"><?php echo nl2br(htmlspecialchars($divorcio_data['td_observaciones'])); ?></span>
                    </div>
                </div>

                <div class="field-row" style="margin-top: 20px;">
                    <div class="field quarter-width">
                        <span class="field-label">VALOR $</span>
                        <span class="field-value"><?php echo htmlspecialchars(number_format($divorcio_data['td_valor'], 2)); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">ABONO $</span>
                        <span class="field-value"><?php echo htmlspecialchars(number_format($divorcio_data['td_abono'], 2)); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">SALDO $</span>
                        <span class="field-value"><?php echo htmlspecialchars(number_format($divorcio_data['td_saldo'], 2)); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">ID TRÁMITE #</span>
                        <span class="field-value"><?php echo htmlspecialchars($divorcio_data['id_tram_div']); ?></span>
                    </div>
                </div>

                <div class="signature-section">
                    <div class="signature-line"></div>
                    <div class="signature-text">FIRMA DEL CLIENTE</div>
                </div>
            </div>
        </body>
        </html>
        <?php
        $html = ob_get_clean(); // 4. Capturar el HTML generado

        // 5. Configurar Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // Necesario si usas imágenes externas o rutas relativas al logo
        // Si Dompdf está teniendo problemas con las fuentes, puedes agregar:
        // $options->set('defaultFont', 'Times New Roman');

        $dompdf = new Dompdf($options);

        // Cargar el HTML en Dompdf
        $dompdf->loadHtml($html);

        // Establecer el tamaño y la orientación del papel (ej. "Letter" para carta)
        $dompdf->setPaper('Letter', 'portrait');

        // Renderizar el HTML como PDF
        $dompdf->render();

        // 6. Enviar el PDF al navegador
        $dompdf->stream("divorcio_tramite_" . $id_divorcio . ".pdf", array("Attachment" => false)); // "Attachment" => true para descarga
        exit(0); // Terminar el script
    } else {
        echo "<p style='text-align: center; color: red;'>No se encontró el registro de divorcio con ID: " . htmlspecialchars($id_divorcio) . "</p>";
    }
} else {
    echo "<p style='text-align: center; color: red;'>ID de trámite de divorcio no proporcionado o inválido.</p>";
}

// Asegúrate de que la conexión a la base de datos se cierre al final si no se cerró antes
if ($conexion && $conexion->ping()) { // ping() verifica si la conexión sigue viva
    $conexion->close();
}
?>