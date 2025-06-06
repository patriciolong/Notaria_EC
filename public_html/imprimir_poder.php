<?php
//seguridad de paginacion
session_start(); // <--- MUY IMPORTANTE QUE ESTÉ AL PRINCIPIO
error_reporting(0);
$varsesion =$_SESSION['usuario'];
$variable_ses = $varsesion;
$user_rol = $_SESSION['rol'] ?? ''; // <-- Aquí se obtiene el rol

// *** DEPURACIÓN EN MENU.PHP: Muestra el rol aquí ***
//echo "DEBUG MENU - Rol de la sesión: '" . $user_rol . "'<br>";
//echo "DEBUG MENU - Usuario de la sesión: " . $variable_ses . "<br>";

if ($varsesion==null || $varsesion=='') {
    header("location:index.php");
    die;
}

?>
<?php
// Reportar todos los errores para depuración (puedes quitarlo una vez que funcione)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluye tu archivo de conexión a la base de datos
include("conexionbd.php");

// Verifica si se recibió un ID de poder por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) { // <-- AQUI COMIENZA EL BLOQUE DEL IF PRINCIPAL
    $id_poder = $_GET['id'];

    // Prepara la consulta SQL para obtener los datos del poder y del cliente
    $query = "SELECT
                tp.id_tram_poderes,
                tp.tp_oficina,
                tp.tp_fecha,
                tp.tp_estado_civil,
                tp.tp_nombres_otorga_poder,
                tp.tp_cedulla_otorga_poder,
                tp.tp_razon_otorga_poder,
                tp.tp_opcion_envio_poder,
                c.c_deuda,   -- <--- Añadido (si ya lo añadiste a la BD)
                c.c_abonado,   -- <--- Añadido (si ya lo añadiste a la BD)
                c.c_saldo,   -- <--- Añadido (si ya lo añadiste a la BD)
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

    // Es crucial verificar si $stmt es false antes de intentar usar bind_param
    if ($stmt === false) {
        // En caso de error en la preparación de la consulta
        die("Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("i", $id_poder); // "i" para indicar que es un entero
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $poder_data = $result->fetch_assoc();
        // Cierra el bloque PHP temporalmente para escribir HTML
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Poder - <?php echo $poder_data['id_tram_poderes']; ?></title>
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

                /* Para checkboxes y radio buttons (se mantienen solo para Estado Civil) */
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
                <img src="img/logo.png" alt="Notaria Ecuador Logo" class="logo"> <div class="header">
                    <div></div> <div class="header-info">
                        <p>NOTARÍA ECUADOR</p>
                        <p>New York - Notary Public</p>
                        <div class="office-date-box">
                            <div class="field-row">
                                <div class="field">
                                    <span class="field-label">Oficina</span>
                                    <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_oficina']); ?></span>
                                </div>
                            </div>
                            <div class="field-row">
                                <div class="field">
                                    <span class="field-label">Fecha</span>
                                    <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_fecha']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-title">1. PERSONA QUE OTORGA EL PODER (USTED):</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NOMBRES Y APELLIDOS (COMPLETOS):</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_nombre'] . ' ' . $poder_data['c_apellido']); ?></span>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">SE IDENTIFICA CON:</span>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo (strpos($poder_data['c_identificacion'], '-') === false && strlen($poder_data['c_identificacion']) == 10) ? 'checked' : ''; ?>"></div>
                            <span class="field-label">CEDULA</span>
                        </div>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo (strpos($poder_data['c_identificacion'], '-') !== false) ? 'checked' : ''; ?>"></div>
                            <span class="field-label">PASAPORTE</span>
                        </div>
                        <div class="checkbox-option">
                            <div class="checkbox-box"></div>
                            <span class="field-label">IDENTIFICACION CONSULAR</span>
                        </div>
                        <div class="checkbox-option">
                            <div class="checkbox-box"></div>
                            <span class="field-label">OTRO</span>
                        </div>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">NÚMERO DE IDENTIFICACIÓN:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_identificacion']); ?></span>
                    </div>
                    <div class="field">
                        <span class="field-label">AP. NO.</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_napartamento']); ?></span>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">DIRECCIÓN:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_direccion']); ?></span>
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

                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">ESTADO CIVIL:</span>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo (strtolower($poder_data['tp_estado_civil']) == 'casados juntos') ? 'checked' : ''; ?>"></div>
                            <span class="field-label">CASADO(A)</span>
                        </div>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo (strtolower($poder_data['tp_estado_civil']) == 'soltero(a)') ? 'checked' : ''; ?>"></div>
                            <span class="field-label">SOLTERO(A)</span>
                        </div>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo (strtolower($poder_data['tp_estado_civil']) == 'union libre') ? 'checked' : ''; ?>"></div>
                            <span class="field-label">UNION LIBRE</span>
                        </div>
                    </div>
                </div>
                <div class="field-row">
                     <div class="field half-width">
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo (strtolower($poder_data['tp_estado_civil']) == 'divorciado(a)') ? 'checked' : ''; ?>"></div>
                            <span class="field-label">DIVORCIADO(A)</span>
                        </div>
                         <div class="checkbox-option">
                            <div class="checkbox-box <?php echo (strtolower($poder_data['tp_estado_civil']) == 'viudo(a)') ? 'checked' : ''; ?>"></div>
                            <span class="field-label">VIUDO(A)</span>
                        </div>
                        <div class="checkbox-option">
                            <div class="checkbox-box <?php echo (!in_array(strtolower($poder_data['tp_estado_civil']), ['casados juntos', 'soltero(a)', 'union libre', 'divorciado(a)', 'viudo(a)'])) ? 'checked' : ''; ?>"></div>
                            <span class="field-label">OTRO</span>
                        </div>
                    </div>
                </div>


                <div class="field-row">
                    <div class="field half-width">
                        <span class="field-label">TELÉFONO: (</span>
                        <span class="field-value" style="width: 150px;"><?php echo htmlspecialchars($poder_data['c_telefono']); ?></span>
                        <span class="field-label">)</span>
                    </div>
                    <div class="field half-width">
                        <span class="field-label">CELULAR: (</span>
                        <span class="field-value" style="width: 150px;"><?php echo htmlspecialchars($poder_data['c_telefono']); ?></span> <span class="field-label">)</span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">CORREO ELECTRÓNICO:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_email']); ?></span>
                    </div>
                </div>

                <div class="section-title">2. PERSONA A FAVOR DE QUIEN OTORGA EL PODER.-</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NOMBRE Y APELLIDOS COMPLETOS:</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_nombres_otorga_poder']); ?></span>
                    </div>
                </div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-label">NO.-DE CEDULA (SI LO SABE):-</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_cedulla_otorga_poder']); ?></span>
                    </div>
                </div>

                <div class="section-title">3. RAZON DEL PODER.-</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_razon_otorga_poder']); ?></span>
                    </div>
                </div>

                <div class="section-title">4. USTED PREFIERE QUE EL PODER SE LE ENVIE:</div>
                <div class="field-row">
                    <div class="field full-width">
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['tp_opcion_envio_poder']); ?></span>
                    </div>
                </div>

                <div class="disclaimer">
                    <p>NOTARÍA ECUADOR INC. ESTE DOCUMENTO SERÁ LEGALIZADO A TRAVES DE LA APOSTILLE</p>
                </div>

                <div class="field-row" style="margin-top: 20px;">
                    <div class="field quarter-width">
                        <span class="field-label">VALOR $</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_deuda'] ?? '__________'); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">ABONO $</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_abonado'] ?? '__________'); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">SALDO $</span>
                        <span class="field-value"><?php echo htmlspecialchars($poder_data['c_saldo'] ?? '__________'); ?></span>
                    </div>
                    <div class="field quarter-width">
                        <span class="field-label">RECIBO #</span>
                        <span class="field-value"><?php //echo htmlspecialchars($poder_data['tp_recibo'] ?? '__________'); ?></span>
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

                <div class="signature-section">
                    <div class="signature-line"></div>
                    <div class="signature-text">FIRMA DEL CLIENTE</div>
                </div>

                <div class="no-print" style="text-align: center; margin-top: 30px;">
                    <button onclick="window.print()" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Imprimir este documento</button>
                    <button onclick="window.close()" style="padding: 10px 20px; background-color: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">Cerrar</button>
                </div>
            </div>
        </body>
        </html>
        <?php
        // Cierra el if ($result->num_rows > 0)
    } else {
        echo "<p style='text-align: center; color: red;'>No se encontró el registro del poder con ID: " . htmlspecialchars($id_poder) . "</p>";
    }
    // Cierra el $stmt
    $stmt->close();
} // <-- ¡Esta es la llave de cierre que faltaba para el IF principal!
else {
    echo "<p style='text-align: center; color: red;'>ID de poder no proporcionado o inválido.</p>";
}
// Cierra la conexión a la base de datos
$conexion->close();
?>