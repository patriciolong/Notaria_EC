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
                    "tv_valor" => "Valor",
                    "tv_abono" => "Abono",
                    "tv_saldo" => "Saldo",
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
                    "ti_valor" => "Valor",
                    "ti_abono" => "Abono",
                    "ti_saldo" => "Saldo",
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
                    "tp_nombre" => "Nombre",
                    "tp_cedula" => "Identificacion",
                    "tp_razon" => "Razon del poder",
                    "tp_oenvio" => "Opcion de envio",
                    "tp_valor" => "Valor",
                    "tp_abono" => "Abono",
                    "tp_saldo" => "Saldo",
                    "tp_nrecibo" => "Recibo",
                    "tp_noenvio" => "Nombre del envio",
                    "tp_ciudad" => "Ciudad",
                    "tp_provincia" => "Provincia",
                    "tp_telefono" => "Telefono",
                ]
                ],
            "tramite_divorcio" => [
                "titulo" => "Divorcios",
                "mostrar_columnas" =>  [
                    "td_tdivorcio" => "Nombre",
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
                    "td_eseparacion" => "Estado de separacion",
                    "td_tiempo_separacion" => "Tiempo de separacion",
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
                echo "<div class='table-responsive'>";
                echo "<table class='table table-striped'>";
                echo "<thead><tr>";

                echo "<thead><tr>";
                foreach ($config["mostrar_columnas"] as $nombre_col_db => $nombre_amigable) {
                    echo "<th>" . htmlspecialchars($nombre_amigable) . "</th>";
                }
                echo "</tr></thead>";
        
                // 👇 FILAS
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($config["mostrar_columnas"] as $nombre_col_db => $nombre_amigable) {
                        echo "<td>" . htmlspecialchars($row[$nombre_col_db]) . "</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
        
                echo "</table>";
                echo "</div>"; // table-responsive
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
