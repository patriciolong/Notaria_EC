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
// Reportar todos los errores para depuración (quitar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluye tu archivo de conexión a la base de datos
include("conexionbd.php");

// Verifica si se recibió un ID de declaración de impuestos por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_declaracion = $_GET['id'];

    // Prepara la consulta SQL para obtener los datos de la declaración y del cliente
    $query = "SELECT
                ti.id_tram_impuestos,
                ti.ti_fecha,
                ti.ti_itin,
                ti.ti_fechain,
                ti.ti_nitin,
                ti.ti_ecivil,
                ti.ti_anio_reporte,
                ti.ti_dependientes,
                ti.ti_mpago,
                ti.ti_banco,
                ti.ti_ncuenta,
                ti.ti_nruta,
                ti.ti_observacion,
                ti.ti_profesion,
                ti.ti_oficina,
                ti.ti_costo_tramite,
                ti.ti_abono_tramite,
                ti.ti_saldo,
                c.c_deuda,
                c.c_abonado,
                c.c_saldo,
                c.c_identificacion,
                c.c_nombre,
                c.c_apellido,
                c.c_telefono,
                c.c_direccion,
                c.c_estado,
                c.c_ciudad,
                c.c_codpostal,
                c.c_email,
                u.u_usuario AS nombre_usuario
              FROM tramite_impuestos AS ti
              JOIN cliente AS c ON ti.id_cliente = c.id_cliente
              JOIN
                usuario u ON ti.id_usuario = u.id_usuario
              WHERE ti.id_tram_impuestos = ?";

    $stmt = $conexion->prepare($query);

    if ($stmt === false) {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("i", $id_declaracion);
    $stmt->execute();
    $result = $stmt->get_result();
    $declaracion_data = $result->fetch_assoc();

    if ($declaracion_data) {
        // Formatear las fechas si existen y no son '0000-00-00'
        $fecha_declaracion = isset($declaracion_data['ti_fecha']) && $declaracion_data['ti_fecha'] != '0000-00-00' && $declaracion_data['ti_fecha'] != ''
            ? date('d/m/Y', strtotime($declaracion_data['ti_fecha']))
            : '__________'; // Usar __________ para campos vacíos
        $fecha_ingreso_eeuu = isset($declaracion_data['ti_fechain']) && $declaracion_data['ti_fechain'] != '0000-00-00' && $declaracion_data['ti_fechain'] != ''
            ? date('d/m/Y', strtotime($declaracion_data['ti_fechain']))
            : '__________'; // Usar __________ para campos vacíos

           
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Declaración de Impuestos - ID <?php echo htmlspecialchars($id_declaracion); ?></title>
            <style>
                /* Estilos Generales para la página */
                body {
                    font-family: 'Arial', sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f0f0f0;
                    color: #333;
                    font-size: 10.5pt; /* Ligeramente más pequeño para optimizar espacio */
                }

                /* Contenedor principal del documento, simula una hoja A4 */
                .document-container {
                    width: 21cm; /* Ancho A4 */
                    min-height: 29.7cm; /* Alto A4 */
                    margin: 15mm auto; /* Márgenes top/bottom 15mm, auto para centrar */
                    padding: 15mm 20mm; /* Padding interno para el contenido */
                    background-color: #fff;
                    box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
                    box-sizing: border-box; /* Incluir padding en el width/height */
                }

                /* Cabecera del documento */
                .header {
                    display: flex; /* Usamos flexbox para alinear los elementos */
                    justify-content: space-between; /* Espacio entre el logo y la info */
                    align-items: flex-start; /* Alinea los elementos al inicio (arriba) */
                    margin-bottom: 25px;
                    border-bottom: 1px solid #ccc;
                    padding-bottom: 10px;
                }
                .header-left {
                    flex-shrink: 0; /* Evita que el logo se encoja */
                }
                .header-logo {
                    max-width: 100px; /* Ajusta el tamaño del logo según sea necesario */
                    height: auto;
                    margin-bottom: 0px; /* Reducido para ajustarse */
                }
                .header-center {
                    flex-grow: 1; /* Permite que el centro ocupe el espacio disponible */
                    text-align: center; /* Centra el título principal */
                }
                .header-center h1 {
                    font-size: 1.6em; /* Un poco más pequeño */
                    color: #2c3e50;
                    margin: 5px 0;
                }
                .header-center p {
                    font-size: 0.9em; /* Más pequeño para detalles */
                    color: #555;
                    margin: 0;
                }
                .header-right {
                    flex-shrink: 0; /* Evita que la info se encoja */
                    text-align: right;
                    font-size: 0.9em;
                    color: #555;
                }
                .header-right p {
                    margin: 2px 0;
                }

                /* Secciones de información (Datos del Cliente, Detalles, Pagos) */
                .info-block {
                    margin-bottom: 15px; /* Menos espacio entre bloques */
                    border: 1px solid #ddd;
                    padding: 10px 15px; /* Menos padding interno */
                    border-radius: 4px;
                }
                .info-block h3 {
                    font-size: 1.1em; /* Más pequeño */
                    margin-top: 0;
                    margin-bottom: 8px; /* Menos espacio */
                    color: #34495e;
                    border-bottom: 1px dashed #eee;
                    padding-bottom: 5px;
                }

                /* Estilo de los campos individuales */
                .field-row {
                    display: table; /* Usamos display: table para controlar mejor los anchos */
                    width: 100%;
                    table-layout: fixed; /* Distribuye las columnas de manera uniforme */
                    margin-bottom: 5px; /* Espacio entre filas */
                }
                .field {
                    display: table-cell; /* Cada campo es una celda */
                    padding-right: 15px; /* Espacio entre columnas */
                    vertical-align: top; /* Alineación superior del contenido */
                }
                /* Ajustes específicos para anchos */
                .field.half-width { width: 50%; }
                .field.third-width { width: 33.33%; }
                .field.quarter-width { width: 25%; }
                .field.full-width { width: 100%; display: block; padding-right: 0; } /* Full-width necesita ser block */

                .field-label {
                    font-weight: bold;
                    color: #444;
                    display: block;
                    margin-bottom: 2px;
                    font-size: 0.85em; /* Un poco más pequeño */
                }
                .field-value {
                    display: block; /* Asegura que la línea ocupe todo el ancho */
                    border-bottom: 1px solid #000;
                    padding-bottom: 2px;
                    min-height: 1.2em; /* Altura mínima para la línea, incluso si está vacío */
                    font-size: 0.95em;
                    word-wrap: break-word; /* Permite que el texto se rompa si es muy largo */
                }
                /* Ajuste para el campo de observaciones */
                .field.full-width .field-value {
                    border: 1px solid #ccc;
                    padding: 5px;
                    min-height: 60px; /* Mayor altura para observaciones */
                }


                /* Estilo para las secciones de pago que requieren un formato específico */
                .payment-section {
                    margin-top: 25px;
                    border: 2px solid #a0a0a0;
                    padding: 15px;
                    border-radius: 5px;
                    display: table; /* Usamos table para los pagos también */
                    width: 100%;
                    table-layout: fixed;
                }
                .payment-field {
                    display: table-cell;
                    padding: 0 10px; /* Padding para el contenido dentro de la celda */
                    vertical-align: middle;
                    text-align: center;
                }
                .payment-field .field-label {
                    font-size: 1em;
                    color: #2c3e50;
                    margin-bottom: 5px;
                    font-weight: bold;
                    white-space: nowrap; /* Evita que la etiqueta se rompa */
                }
                .payment-field .field-value {
                    font-size: 1.1em; /* Un poco más grande para los valores */
                    font-weight: bold;
                    color: #000;
                    border-bottom: 2px solid #000;
                    padding: 5px 0;
                    width: 100%;
                    display: block; /* Para que la línea ocupe todo el ancho */
                }
                /* Ajuste para el recibo, que puede ser más pequeño */
                .payment-field.recibo-field {
                    width: 20%; /* Ajusta el ancho si necesitas que el recibo sea más estrecho */
                }


                /* Sección de Firma */
                .signature-section {
                    margin-top: 40px;
                    padding-top: 20px;
                    border-top: 1px dashed #ccc;
                    text-align: center;
                    display: table; /* Usamos table para las firmas */
                    width: 100%;
                    table-layout: fixed;
                }
                .signature-block {
                    display: table-cell;
                    width: 50%; /* Cada firma ocupa la mitad */
                    text-align: center;
                    vertical-align: top;
                }
                .signature-line {
                    border-bottom: 1px solid #000;
                    width: 70%; /* Línea de firma más corta */
                    margin: 0 auto 5px auto;
                }
                .signature-text {
                    font-size: 0.85em;
                    font-weight: bold;
                    color: #555;
                }

                /* Botones de No Imprimir (Ocultos en la impresión) */
                .no-print {
                    text-align: center;
                    margin-top: 30px;
                    position: fixed;
                    bottom: 20px;
                    left: 50%;
                    transform: translateX(-50%);
                    z-index: 1000;
                    background: #fff;
                    padding: 10px 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                }
                .no-print button {
                    padding: 10px 25px;
                    background-color: #007bff;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 1em;
                    margin: 0 8px;
                    transition: background-color 0.3s ease;
                }
                .no-print button:hover {
                    background-color: #0056b3;
                }
                .no-print button:last-child {
                    background-color: #6c757d;
                }
                .no-print button:last-child:hover {
                    background-color: #5a6268;
                }

                /* Media Query para Impresión */
                @media print {
                    body {
                        background-color: #fff;
                        margin: 0;
                        padding: 0;
                        font-size: 10pt; /* Ajuste final de tamaño para impresión */
                    }
                    .document-container {
                        margin: 0;
                        padding: 10mm; /* Márgenes ajustados para impresión */
                        box-shadow: none;
                        page-break-after: always; /* Cada documento en una nueva página */
                    }
                    .no-print {
                        display: none !important; /* Oculta los botones al imprimir */
                    }
                    /* Forzar que los layouts de tabla se mantengan */
                    .field-row, .payment-section, .signature-section {
                        display: table;
                        width: 100%;
                        table-layout: fixed;
                    }
                    .field, .payment-field, .signature-block {
                        display: table-cell;
                        padding-right: 10px; /* Un poco menos de padding en impresión */
                    }
                     .field.full-width { /* Para el campo de observaciones en impresión */
                        display: block; /* Permite que ocupe todo el ancho */
                        width: 100%;
                        padding-right: 0;
                    }
                }
            </style>
        </head>
        <body>
            <div class="document-container">
                <div class="header">
                    <div class="header-left">
                        <img src="img/logo_impre.png" alt="Logo de la Empresa" class="header-logo">
                    </div>
                    <div class="header-center">
                        <h2>DECLARACIÓN DE IMPUESTOS</h2>
                    </div>
                    <div class="header-right">
                        <p>Fecha: <?php echo htmlspecialchars(($declaracion_data['ti_fecha'] ?? '')); ?></p>
                        <p>Oficina: <?php echo htmlspecialchars(($declaracion_data['ti_oficina'] ?? '')); ?></p>
                    </div>
                </div>

                
                <div class="info-block">
                    <h3>DATOS DEL CLIENTE</h3>
                    <div class="field-row">
                        <div class="field half-width">
                            <span class="field-label">NOMBRES COMPLETOS:</span>
                            <span class="field-value"><?php echo htmlspecialchars(($declaracion_data['c_nombre'] ?? '') . ' ' . ($declaracion_data['c_apellido'] ?? '')); ?></span>
                        </div>
                        <div class="field half-width">
                            <span class="field-label">IDENTIFICACIÓN:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['c_identificacion'] ?? '__________'); ?></span>
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field full-width">
                            <span class="field-label">DIRECCIÓN:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['c_direccion'] ?? '__________'); ?></span>
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field third-width">
                            <span class="field-label">CIUDAD:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['c_ciudad'] ?? '__________'); ?></span>
                        </div>
                        <div class="field third-width">
                            <span class="field-label">ESTADO:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['c_estado'] ?? '__________'); ?></span>
                        </div>
                        <div class="field third-width">
                            <span class="field-label">CÓDIGO POSTAL:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['c_codpostal'] ?? '__________'); ?></span>
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field half-width">
                            <span class="field-label">TELÉFONO:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['c_telefono'] ?? '__________'); ?></span>
                        </div>
                        <div class="field half-width">
                            <span class="field-label">EMAIL:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['c_email'] ?? '__________'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="info-block">
                    <h3>DETALLES DE LA DECLARACIÓN</h3>
                    <div class="field-row">
                        <div class="field third-width">
                            <span class="field-label">FECHA DE DECLARACIÓN:</span>
                            <span class="field-value"><?php echo htmlspecialchars($fecha_declaracion); ?></span>
                        </div>
                        <div class="field third-width">
                            <span class="field-label">ITIN:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['ti_itin'] ?? '__________'); ?></span>
                        </div>
                        <div class="field third-width">
                            <span class="field-label">NÚMERO ITIN:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['ti_nitin'] ?? '__________'); ?></span>
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field third-width">
                            <span class="field-label">FECHA INGRESO EE.UU.:</span>
                            <span class="field-value"><?php echo htmlspecialchars($fecha_ingreso_eeuu); ?></span>
                        </div>
                        <div class="field third-width">
                            <span class="field-label">ESTADO CIVIL:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['ti_ecivil'] ?? '__________'); ?></span>
                        </div>
                        <div class="field third-width">
                            <span class="field-label">PROFESIÓN:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['ti_profesion'] ?? '__________'); ?></span>
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field third-width">
                            <span class="field-label">DEPENDIENTES:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['ti_dependientes'] ?? '__________'); ?></span>
                        </div>
                        <div class="field third-width">
                            <span class="field-label">MÉTODO DE PAGO:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['ti_mpago'] ?? '__________'); ?></span>
                        </div>
                        <div class="field third-width">
                            <span class="field-label">BANCO:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['ti_banco'] ?? '__________'); ?></span>
                        </div>
                    </div>
                    <div class="field-row">
                    <div class="field third-width">
                            <span class="field-label">AÑO DE REPORTE:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['ti_anio_reporte']); ?></span>
                        </div>
                        <div class="field half-width">
                            <span class="field-label">NÚMERO DE CUENTA:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['ti_ncuenta'] ?? '__________'); ?></span>
                        </div>
                        
                        <div class="field half-width">
                            <span class="field-label">NÚMERO DE RUTA:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['ti_nruta'] ?? '__________'); ?></span>
                        </div>
                        
                    </div>
                    <div class="field-row">
                        <div class="field half-width">
                            <span class="field-label">VALOR DEL TRAMITE:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['ti_costo_tramite'] ?? '__________'); ?>$</span>
                        </div>
                        
                        <div class="field half-width">
                            <span class="field-label">ABONO DEL TRAMITE:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['ti_abono_tramite'] ?? '__________'); ?>$</span>
                        </div>
                        <div class="field half-width">
                            <span class="field-label">SALDO DEL TRAMITE:</span>
                            <span class="field-value"><?php echo htmlspecialchars($declaracion_data['ti_saldo'] ?? '__________'); ?>$</span>
                        </div>
                        
                    </div>
                    <div class="field-row">
                        <div class="field full-width">
                            <span class="field-label">OBSERVACIONES:</span>
                            <span class="field-value" style="min-height: 40px; border: 1px solid #ccc; padding: 5px;"><?php echo nl2br(htmlspecialchars($declaracion_data['ti_observacion'] ?? '')); ?></span>
                        </div>
                    </div>
                </div>
                <div class="footer-info">
                    <p>Atendido por: <?php echo htmlspecialchars($declaracion_data['nombre_usuario']); ?></p>
                    <p>Fecha y Hora de Generación: <?php echo date('d/m/Y H:i:s'); ?></p>
                </div>


                <div class="signature-section">
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <div class="signature-text">FIRMA DEL CLIENTE</div>
                    </div>
                    <div class="signature-block">
                        <div class="signature-line"></div>
                        <div class="signature-text">FIRMA AUTORIZADA</div>
                    </div>
                </div>

                <div class="no-print">
                    <button onclick="window.print()">Imprimir</button>
                    <button onclick="window.close()">Cerrar</button>
                </div>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "<p style='text-align: center; color: red; font-size: 1.2em; margin-top: 50px;'>No se encontró el registro de la declaración de impuestos con ID: " . htmlspecialchars($id_declaracion) . "</p>";
    }
    $stmt->close();
} else {
    echo "<p style='text-align: center; color: red; font-size: 1.2em; margin-top: 50px;'>No se proporcionó un ID de declaración válido para imprimir.</p>";
}
?>