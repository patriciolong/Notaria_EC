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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Poder Especial</title>
    <style>
        /* Mismos estilos CSS de la página principal para la interfaz de usuario */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: auto;
        }
        h1, h2 {
            color: #0056b3;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        select, input[type="text"], input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px; /* Espacio entre botones */
        }
        button:hover {
            background-color: #0056b3;
        }
        .document-output {
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .document-output iframe {
            width: 100%;
            height: 600px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .error {
            color: red;
            background-color: #ffe6e6;
            border: 1px solid red;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .action-buttons {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

    <?php
    // Incluir el archivo de conexión a la base de datos
    require_once 'conexionbd.php'; // Asegúrate de que la ruta sea correcta

    $selected_template_id = '';
    $selected_power_id = '';
    $generated_html = '';
    $poder_nombre = ''; // Para usar en el nombre del archivo

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("<div class='error'>Error de conexión: " . $conexion->connect_error . "</div>");
    }

    // --- OBTENER PLANTILLAS Y PODERES (SIEMPRE AL INICIO) ---
    // Obtener plantillas de la base de datos
    $templates_query = "SELECT id_plantilla, nombre_plantilla, contenido_html FROM plantillas WHERE tipo_documento = 'poder_especial'";
    $templates_result = $conexion->query($templates_query);
    $templates = [];
    if ($templates_result && $templates_result->num_rows > 0) {
        while ($row = $templates_result->fetch_assoc()) {
            $templates[$row['id_plantilla']] = $row;
        }
    } else {
        // Este mensaje de error solo se mostrará si realmente no hay plantillas.
        // Lo dejamos aquí para depuración.
        echo "<div class='error'>No se encontraron plantillas de poder especial en la base de datos.</div>";
    }

    // Obtener registros de poderes de la base de datos
    $poderes_query = "
        SELECT
            tp.id_tram_poderes,
            c.id_cliente,
            c.c_nombre,
            c.c_apellido,
            c.c_identificacion,
            c.c_telefono,
            c.c_direccion,
            c.c_ciudad,
            c.c_estado,
            c.c_pais,
            tp.tp_fecha,
            tp.tp_estado_civil,
            tp.tp_nombres_otorga_poder,
            tp.tp_cedulla_otorga_poder,
            tp.tp_opcion_envio_poder,
            tp.tp_enviar_nombrede,
            tp.tp_ciudad_enviar,
            tp.tp_provincia,
            tp.tp_telefonos_enviar
        FROM
            tramite_poderes tp
        JOIN
            cliente c ON tp.id_cliente = c.id_cliente
        ORDER BY tp.id_tram_poderes DESC";
    $poderes_result = $conexion->query($poderes_query);
    $poderes = [];
    if ($poderes_result && $poderes_result->num_rows > 0) {
        while ($row = $poderes_result->fetch_assoc()) {
            $poderes[$row['id_tram_poderes']] = $row;
        }
    } else {
        // Este mensaje de error solo se mostrará si realmente no hay poderes.
        // Lo dejamos aquí para depuración.
        echo "<div class='error'>No se encontraron registros de poderes en la base de datos.</div>";
    }
    // --- FIN DE LA OBTENCIÓN DE DATOS (SIEMPRE AL INICIO) ---

    // Lógica principal para manejar el envío del formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $selected_template_id = $_POST['template_id'] ?? '';
        $selected_power_id = $_POST['power_id'] ?? '';
        $action = $_POST['action'] ?? 'generate'; // 'generate' por defecto, 'download' para descarga

        // Verificamos si la selección es válida DESPUÉS de haber obtenido los datos
        if (!isset($templates[$selected_template_id]) || !isset($poderes[$selected_power_id])) {
            // Este mensaje de error solo se mostrará si la selección POST no corresponde a datos existentes.
            echo "<div class='container'><div class='error'>La plantilla o el registro de poder seleccionados no son válidos o no existen.</div></div>";
        } else {
            $template_content = $templates[$selected_template_id]['contenido_html'];
            $power_data = $poderes[$selected_power_id];

            // Formatear la fecha
            $date_obj = new DateTime($power_data['tp_fecha']);
            // Asegúrate de que tu sistema tenga la configuración regional para español si usas strftime
            setlocale(LC_TIME, 'es_ES', 'es_ES.UTF-8');
            $fecha_otorgamiento_formatted = $date_obj->format('d') . ' de ' . strftime('%B', $date_obj->getTimestamp()) . ' de ' . $date_obj->format('Y');
            $fecha_otorgamiento_raw_usa = $date_obj->format('m/d/Y');

            // Para el nombre del archivo de descarga
            $poder_nombre = 'Poder_Especial_' . str_replace(' ', '_', $power_data['c_nombre'] . '_' . $power_data['c_apellido']) . '_' . $power_data['id_tram_poderes'];

            // Reemplazar las variables de la plantilla
            $replacements = [
                '[[fecha_otorgamiento]]' => $fecha_otorgamiento_formatted,
                '[[notario_nombre]]' => 'Christian Moreno', // Hardcoded
                '[[poderdante_nombre]]' => $power_data['c_nombre'] . ' ' . $power_data['c_apellido'],
                '[[poderdante_identificacion]]' => $power_data['c_identificacion'],
                '[[poderdante_estado_civil]]' => $power_data['tp_estado_civil'],
                '[[poderdante_nacionalidad]]' => $power_data['c_pais'],
                '[[poderdante_domicilio_calle]]' => $power_data['c_direccion'],
                '[[poderdante_domicilio_ciudad]]' => $power_data['c_ciudad'],
                '[[poderdante_domicilio_estado]]' => $power_data['c_estado'],
                '[[poderdante_domicilio_pais]]' => $power_data['c_pais'],
                '[[poderdante_telefono_formatted]]' => $power_data['c_telefono'],
                '[[mandatario_nombre]]' => $power_data['tp_enviar_nombrede'],
                '[[mandatario_cedula]]' => $power_data['tp_cedulla_otorga_poder'],
                '[[inmueble_tipo]]' => 'un bien inmueble', // Marcador de posición
                '[[inmueble_ubicacion]]' => 'dirección del inmueble', // Marcador de posición
                '[[inmueble_provincia]]' => 'provincia del inmueble', // Marcador de posición
                '[[lugar_otorgamiento]]' => 'Kings', // Hardcoded
                '[[fecha_otorgamiento_raw_usa]]' => $fecha_otorgamiento_raw_usa,
                '[[notary_info_name]]' => 'CHRISTIAN MORENO',
                '[[notary_info_title]]' => 'Notary Public – State of New York',
                '[[notary_info_no]]' => '01MO6179161',
                '[[notary_info_county]]' => 'New York County Cert.',
                '[[notary_info_filed]]' => 'Queens & Kings County',
                '[[notary_info_expires]]' => '12/24/2023',
                '[[notary_address]]' => '190 Wyckoff Ave, Brooklyn, N.Y. 11237',
                '[[notary_tel]]' => '718.864.7908',
                '[[notary_whatsapp]]' => '212.867.6350',
                '[[notary_website1]]' => 'www.NotariaEcuador.com',
                '[[notary_website2]]' => 'www.Apostilla Express .com',
                '[[notary_email]]' => 'info@NotariaEcuador.com',
            ];

            $generated_html = str_replace(array_keys($replacements), array_values($replacements), $template_content);

            // Si la acción es 'download', enviamos el archivo y salimos INMEDIATAMENTE
            if ($action == 'download') {
                header("Content-type: application/vnd.ms-word");
                header("Content-Disposition: attachment;Filename=" . $poder_nombre . ".doc");
                header("Pragma: no-cache");
                header("Expires: 0");
                echo $generated_html; // Solo enviamos el HTML de la plantilla
                exit; // ¡MUY IMPORTANTE! Termina la ejecución aquí
            }
        }
    }
    ?>

    <div class="container">
    <div class="button-container">
    <button type="button" class="redirect-button" onclick="location.href='menu.php'">< REGRESAR</button>
</div>
        <h1>Generador de Poder Especial</h1> <form method="POST" action="">
            <div class="form-group">
                
                <label for="template_id">Seleccionar Plantilla:</label>
                <select name="template_id" id="template_id" required>
                    <option value="">-- Seleccione una plantilla --</option>
                    <?php foreach ($templates as $id => $template): ?>
                        <option value="<?php echo htmlspecialchars($id); ?>" <?php echo ($selected_template_id == $id) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($template['nombre_plantilla']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="power_id">Seleccionar Poder de Acta (ID - Nombre Apellido del Poderdante):</label>
                <select name="power_id" id="power_id" required>
                    <option value="">-- Seleccione un poder de acta --</option>
                    <?php foreach ($poderes as $id => $power): ?>
                        <option value="<?php echo htmlspecialchars($id); ?>" <?php echo ($selected_power_id == $id) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($power['id_tram_poderes'] . ' - ' . $power['c_nombre'] . ' ' . $power['c_apellido']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="action-buttons">
                <button type="submit" name="action" value="generate">Generar Documento</button>
                <?php if (!empty($generated_html)): ?>
                    <button type="submit" name="action" value="download">Descargar Word</button>
                <?php endif; ?>
            </div>
        </form>

        <?php if (!empty($generated_html)): ?>
            <h2>Vista Previa del Documento:</h2>
            <div class="document-output">
                <iframe srcdoc="<?php echo htmlspecialchars($generated_html); ?>"></iframe>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>