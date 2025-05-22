<?php
session_start();
error_reporting(0); // Considera activar esto para depuración en desarrollo
include("conexionbd.php"); // Asegúrate de que esta ruta sea correcta para tu conexión

if (isset($_GET['id'])) {
    $id_tramite = $_GET['id'];

    // Consulta para obtener los datos del trámite, cliente y usuario
    $sql = "SELECT tv.*, c.*, u.u_nombre, u.u_apellido 
            FROM tramites_varios tv
            JOIN cliente c ON tv.id_cliente = c.id_cliente
            JOIN usuario u ON tv.id_usuario = u.id_usuario
            WHERE tv.id_tramite_varios = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_tramite);
    $stmt->execute();
    $result = $stmt->get_result();
    $tramite = $result->fetch_assoc();
    $stmt->close();

    if (!$tramite) {
        echo "Trámite no encontrado.";
        exit;
    }
} else {
    echo "ID de trámite no proporcionado.";
    exit;
}

// Obtener la fecha actual
$fecha_actual = date("d/m/Y");

// Mapear los nombres de los servicios para mostrar "Sí" o "No"
$traducciones = $tramite['tv_traducciones'] ? 'Sí' : 'No';
$notarizacion = $tramite['tv_notarizacion'] ? 'Sí' : 'No';
$certificacion = $tramite['tv_certificacion'] ? 'Sí' : 'No';
$apostilla = $tramite['tv_apostilla'] ? 'Sí' : 'No';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir Recibo de Trámite Varios</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0; /* Elimina el margen predeterminado */
            padding: 20px;
            box-sizing: border-box;
            background-color: #f8f8f8;
        }
        .form-container {
            width: 210mm; /* Ancho de una hoja A4 */
            min-height: 297mm; /* Alto de una hoja A4 */
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative; /* Para posicionar elementos absolutamente */
            box-sizing: border-box;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        .header .logo {
            flex: 0 0 auto;
            margin-right: 20px;
        }
        .header .logo img {
            max-width: 150px; /* Ajusta el tamaño del logo */
        }
        .header .office-info {
            flex-grow: 1;
            text-align: right;
            border-bottom: 1px solid #000; /* Línea para Oficina y Fecha */
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .header .office-info p {
            margin: 0;
            font-size: 14px;
        }
        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
        }
        .section {
            margin-bottom: 15px;
        }
        .section h3 {
            font-size: 16px;
            margin-bottom: 5px;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 5px;
        }
        .form-field {
            flex: 1;
            display: flex;
            align-items: baseline;
            margin-right: 20px; /* Espacio entre campos */
            min-width: 200px; /* Asegura que no se apilen demasiado */
        }
        .form-field.full-width {
            flex-basis: 100%;
            margin-right: 0;
        }
        .form-field label {
            font-weight: bold;
            margin-right: 5px;
            white-space: nowrap; /* Evita que el label se rompa */
        }
        .form-field .value-display {
            flex-grow: 1;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            font-size: 14px;
        }
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px; /* Espacio entre checkboxes */
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
        }
        .checkbox-item input[type="checkbox"] {
            margin-right: 5px;
        }
        .checkbox-item label {
            font-weight: normal;
        }
        .footer-notes {
            margin-top: 30px;
            font-size: 12px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            text-align: center;
        }
        .button-container {
            text-align: center;
            margin-top: 30px;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .form-container {
                border: none;
                box-shadow: none;
                width: 100%;
                min-height: auto;
                padding: 10mm; /* Pequeño margen para impresión */
            }
            .button-container {
                display: none; /* Oculta el botón de imprimir */
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="header">
            <div class="logo">
                <img src="img/logo.png" alt="Notaría Ecuador">
                </div>
            <div class="office-info">
                <p>Oficina: New York</p>
                <p>Fecha: <?php echo $fecha_actual; ?></p>
            </div>
        </div>

        <div class="title">
            TRAMITES - VARIOS
        </div>

        <div class="section">
            <div class="form-row">
                <div class="form-field full-width">
                    <label>Nombre y Apellidos:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['c_nombre'] . " " . $tramite['c_apellido']); ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-field">
                    <label>IDENTIFICACIÓN:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['c_identificacion']); ?></span>
                </div>
                <div class="form-field">
                    <label>NÚMERO DE LA IDENTIFICACIÓN:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['c_identificacion']); ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-field full-width">
                    <label>DIRECCIÓN:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['c_direccion'] . " Apt. #" . $tramite['c_napartamento']); ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-field">
                    <label>CIUDAD:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['c_ciudad']); ?></span>
                </div>
                <div class="form-field">
                    <label>ESTADO:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['c_estado']); ?></span>
                </div>
                <div class="form-field">
                    <label>CÓDIGO POSTAL:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['c_codpostal']); ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-field">
                    <label>TELÉFONO:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['c_telefono']); ?></span>
                </div>
                <div class="form-field">
                    <label>Celular:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['c_telefono']); ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-field full-width">
                    <label>CORREO ELECTRÓNICO:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['c_email']); ?></span>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="form-row">
                <div class="form-field">
                    <label>TIPO DE DOCUMENTO:</label>
                    <span class="value-display">
                        <input type="checkbox" <?php echo ($tramite['tv_tip_documento'] == 'Nacimiento') ? 'checked' : ''; ?>> Nacimiento
                        <input type="checkbox" <?php echo ($tramite['tv_tip_documento'] == 'Matrimonio') ? 'checked' : ''; ?>> Matrimonio
                        <input type="checkbox" <?php echo ($tramite['tv_tip_documento'] == 'Defuncion') ? 'checked' : ''; ?>> Defunción
                        <input type="checkbox" <?php echo ($tramite['tv_tip_documento'] == 'Divorcio') ? 'checked' : ''; ?>> Divorcio
                        <input type="checkbox" <?php echo ($tramite['tv_tip_documento'] == 'Academicas') ? 'checked' : ''; ?>> Académicas
                        <input type="checkbox" <?php echo ($tramite['tv_tip_documento'] == 'Carta de invitacion') ? 'checked' : ''; ?>> Carta de Invitación
                        <input type="checkbox" <?php echo ($tramite['tv_tip_documento'] == 'Otros') ? 'checked' : ''; ?>> Otros
                    </span>
                </div>
                <div class="form-field">
                    <label>Para Uso En:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['tv_motivo']); ?></span>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-field">
                    <label>Servicios:</label>
                    <span class="value-display">
                        <input type="checkbox" <?php echo ($tramite['tv_traducciones'] == 1) ? 'checked' : ''; ?>> TRADUCCIONES
                        <input type="checkbox" <?php echo ($tramite['tv_notarizacion'] == 1) ? 'checked' : ''; ?>> NOTARIZACIÓN
                        <input type="checkbox" <?php echo ($tramite['tv_certificacion'] == 1) ? 'checked' : ''; ?>> CERTIFICACIÓN
                        <input type="checkbox" <?php echo ($tramite['tv_apostilla'] == 1) ? 'checked' : ''; ?>> APOSTILLA
                    </span>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="form-row">
                <div class="form-field full-width">
                    <label>USTED DESEA QUE EL DOCUMENTO SE LE ENVIE:</label>
                    <span class="value-display">
                        <input type="checkbox" <?php echo ($tramite['tv_oenvio'] == 'A su domicilio en EE.UU.') ? 'checked' : ''; ?>> A Su Domicilio En Los EE.UU.
                        <input type="checkbox" <?php echo ($tramite['tv_oenvio'] == 'Ofrecemos envios express al Ecuador en 3 dias laborables.') ? 'checked' : ''; ?>> Ofrecemos envíos express al Ecuador en 3 días laborables.
                        <input type="checkbox" <?php echo ($tramite['tv_oenvio'] == 'Venirlo a retirar personalmente en la oficina.') ? 'checked' : ''; ?>> Venirlo a Retirar Personalmente En La Oficina De:
                    </span>
                </div>
            </div>
            <?php if (!empty($tramite['tv_nom_envio'])): ?>
            <div class="form-row">
                <div class="form-field full-width">
                    <label>Enviar a nombre de:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['tv_nom_envio']); ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-field">
                    <label>Ciudad de Destino:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['tv_ciudad']); ?></span>
                </div>
                <div class="form-field">
                    <label>Provincia de Destino:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['tv_provincia']); ?></span>
                </div>
            </div>
            <div class="form-row">
                <div class="form-field">
                    <label>Teléfono de Contacto:</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['tv_telefono']); ?></span>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="section">
            <div class="form-row">
                <div class="form-field">
                    <label>VALOR $</label>
                    <span class="value-display"><?php echo htmlspecialchars(number_format($tramite['tv_valor_tramite'], 2, '.', ',')); ?></span>
                </div>
                <div class="form-field">
                    <label>ABONO $</label>
                    <span class="value-display"><?php echo htmlspecialchars(number_format($tramite['c_abonado'], 2, '.', ',')); ?></span>
                </div>
                <div class="form-field">
                    <label>SALDO $</label>
                    <span class="value-display"><?php echo htmlspecialchars(number_format($tramite['c_saldo'], 2, '.', ',')); ?></span>
                </div>
                <div class="form-field">
                    <label>RECIBO #</label>
                    <span class="value-display"><?php echo htmlspecialchars($tramite['tv_nrecibo']); ?></span>
                </div>
            </div>
        </div>

        <div class="footer-notes">
            <p>Hemos solicitado los servicios de Notaría Ecuador Inc. Para la(s)</p>
            <p>Traducción(es) y apostille(s) de(los) documentos arriba mencionados.</p>
            <p>PARA USO INTERNO DE LA OFICINA</p>
            <p>FIRMA: _________________________________</p>
            <p>Registrado por: <?php echo htmlspecialchars($tramite['u_nombre'] . " " . $tramite['u_apellido']); ?></p>
        </div>

        <div class="button-container">
            <button onclick="window.print()">Imprimir Recibo</button>
        </div>
    </div>
</body>
</html>