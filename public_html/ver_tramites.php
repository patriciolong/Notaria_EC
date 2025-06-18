<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Trámites del Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <?php
    include("conexionbd.php");

    if (isset($_GET['id_cliente'])) {
        $id_cliente = intval($_GET['id_cliente']);
        $nombre_cliente = "Cliente no encontrado";

        $stmt_nombre = $conexion->prepare("SELECT c_nombre, c_apellido FROM cliente WHERE id_cliente = ?");
        $stmt_nombre->bind_param("i", $id_cliente);
        $stmt_nombre->execute();
        $result_nombre = $stmt_nombre->get_result();

        if ($fila_nombre = $result_nombre->fetch_assoc()) {
            $nombre_cliente = $fila_nombre['c_nombre'] . " " . $fila_nombre['c_apellido'];
        }
        

        echo "<h2 class='mb-4'>Trámites de: <span class='text-primary'>" . htmlspecialchars($nombre_cliente) . "</span></h2>";

        // Configuración individual por tabla
        $tablas_tramites = [
            "tramites_varios" => [
                "titulo" => "Tramites Varios",
                "mostrar_columnas" =>  [
                    "tv_motivo" => "Motivo",
                    "tv_oenvio" => "Opcion de Envio",
                    "tv_nrecibo" => "Recibo",
                    "tv_nom_envio" => "Nombre del envio",
                    "tv_ciudad" => "Ciudad",
                    "tv_provincia" => "Provincia",
                    "tv_telefono" => "Telefono",
                ]
            ],
            "tramite_impuestos" => [
                "titulo" => "Impuestos",
                "mostrar_columnas" =>  [
                    "ti_fecha" => "Fecha",
                    "ti_itin" => "ITIN",
                    "ti_fechain" => "Fecha de ingreso a USA",
                    "ti_nitin" => "Numero de ITIN o social",
                    "ti_ecivil" => "Estado civil",
                    "ti_dependientes" => "Numero de dependientes",
                    "ti_mpago" => "Metodo de pago",
                    "ti_banco" => "Banco",
                    "ti_ncuenta" => "Numero de cuenta",
                    "ti_nruta" => "Numero de ruta",
                    "ti_observacion" => "Observaciones",
                ]
            ],
            "tramite_poderes" => [
                "titulo" => "Poderes",
                "mostrar_columnas" =>  [
                    "tp_razon_otorga_poder" => "Razon del poder",
                    "tp_opcion_envio_poder" => "Opcion de envio",
                    "tp_enviar_nombrede" => "Nombre del envio",
                    "tp_ciudad_enviar" => "Ciudad",
                    "tp_provincia" => "Provincia",
                    "tp_telefonos_enviar" => "Telefono",
                ]
                ],
            "tramite_divorcio" => [
                "titulo" => "Divorcios",
                "mostrar_columnas" =>  [
                    "td_identificacion_c" => "Identificacion",
                    "td_nombre_c" => "Nombre del conyugue",
                    "td_direccion_c" => "Direccion del conyugue",
                    "td_telefono_c" => "Telefono del conyugue",
                    "td_estado_c" => "Estado civil del conyugue",
                    "td_ciudad_c" => "Ciudad del conyugue",
                    "td_apt_c" => "Apartamento del conyugue",
                    "td_cpostal_c" => "Codigo postal del conyugue",
                    "td_lugar_matrimonio" => "Lugar de matrimonio",
                    "td_fecha_matrimonio" => "Fecha de matrimonio",
                    "td_separados" => "Separados",
                    "td_noseparados" => "No Separados",
                    "td_tiempo_separacion" => "Tiempo de separacion",
                    "td_hijos" => "Hijos",
                    "td_ep_matrimonio" => "Partida de matrimonio",
                    "td_ep_nacimiento" => "Partida de nacimiento",
                    "td_estado_contac_ecuador" => "Contacto en el Ecuador",
                    "td_tel_ecuador" => "Telefono en Ecuador",
                    "td_observaciones" => "Observaciones",
                    "td_mpago" => "Metodo de pago",
                    "td_valor" => "Valor",
                    "td_abono" => "Abono",
                    "td_saldo" => "Saldo",
                ]
            ]
        ];

        foreach ($tablas_tramites as $tabla => $config) {
            echo "<div class='card mb-4'>";
            echo "<div class='card-header bg-primary text-white'>" . $config["titulo"] . "</div>";
            echo "<div class='card-body'>";

            $stmt = $conexion->prepare("SELECT * FROM $tabla WHERE id_cliente = ?");
            $stmt->bind_param("i", $id_cliente);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                if ($result->num_rows > 0) {
    if ($tabla === "tramite_divorcio") {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card mb-3 shadow-sm'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title mb-3 text-primary'>Divorcio #" . $row['id_tram_div'] . "</h5>";
            echo "<div class='row'>";

            foreach ($config["mostrar_columnas"] as $nombre_col_db => $nombre_amigable) {
                echo "<div class='col-md-6 mb-2'>
                        <strong>" . htmlspecialchars($nombre_amigable) . ":</strong><br>" . htmlspecialchars($row[$nombre_col_db]) . "
                      </div>";
            }

            echo "</div>"; // row

            echo "<div class='mt-3'>";
            echo "<a href='generar_pdf_divorcio.php?id=" . $row['id_tram_div'] . "' target='_blank' class='btn btn-danger btn-sm me-2'>📄 PDF</a>";

            // Formulario para editar observaciones
            echo "<form action='actualizar_observaciones.php' method='post' class='d-inline-block'>";
            echo "<input type='hidden' name='id_tram_div' value='" . $row['id_tram_div'] . "'>";
            echo "<input type='text' name='td_observaciones' class='form-control form-control-sm d-inline-block me-1' style='width:auto; display:inline;' value='" . htmlspecialchars($row['td_observaciones']) . "'>";
            echo "<button type='submit' class='btn btn-success btn-sm'>💾</button>";
            echo "</form>";

            echo "</div>"; // botones
            echo "</div>"; // card-body
            echo "</div>"; // card
        }
    } else {
        // El resto de las tablas sigue como antes con tabla normal
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped'>";
        echo "<thead><tr>";
        foreach ($config["mostrar_columnas"] as $nombre_col_db => $nombre_amigable) {
            echo "<th>" . htmlspecialchars($nombre_amigable) . "</th>";
        }
        echo "</tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($config["mostrar_columnas"] as $nombre_col_db => $nombre_amigable) {
                echo "<td>" . htmlspecialchars($row[$nombre_col_db]) . "</td>";
            }

            echo "<td>";
            if ($tabla === "tramites_varios") {
                $id = $row['id_tramite_varios'];
                $archivo = "imprimir_tramite_varios.php.";
            } elseif ($tabla === "tramite_impuestos") {
                $id = $row['id_tram_impuestos'];
                $archivo = "imprimir_declaracion_impuestos.php";
            } elseif ($tabla === "tramite_poderes") {
                $id = $row['id_tram_poderes'];
                $archivo = "imprimir_poder.php";
            }

            if ($id && $archivo) {
                echo "<a href='{$archivo}?id={$id}' target='_blank' class='btn btn-danger btn-sm'>
                        <i class='bi bi-file-earmark-pdf'></i> PDF
                    </a>";
            }
            echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>"; // table-responsive
    }
}

            } else {
                echo "<p class='text-muted'>No hay trámites registrados para este cliente en esta categoría.</p>";
            }
        
            echo "</div>"; // card-body
            echo "</div>"; // card
        }        

        $conexion->close();
    } else {
        echo "<div class='alert alert-danger'>Cliente no especificado.</div>";
    }
    ?>
</div>
</body>
</html>
