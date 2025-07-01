<?php
session_start();
error_reporting(E_ALL); // Activa todos los errores
ini_set('display_errors', 1); // Muestra los errores en la salida
// Incluir la conexión a la base de datos
include("conexionbd.php");

// Obtener el ID del usuario de la sesión
$varsesion = $_SESSION['usuario'];
$user_id = null; // Inicializar en null

if ($conexion) {
    $sql2 = "SELECT id_usuario FROM usuario WHERE u_usuario = ?";
    $stmt = $conexion->prepare($sql2);
    if ($stmt) {
        $stmt->bind_param("s", $varsesion);
        $stmt->execute();
        $stmt->bind_result($user_id_from_db);
        $stmt->fetch();
        $stmt->close();
        $user_id = $user_id_from_db; // Asignar el ID obtenido
    } else {
        // Manejar error en la preparación de la consulta
        echo json_encode(["status" => "error", "message" => "Error preparando consulta de usuario: " . $conexion->error]);
        exit();
    }
} else {
    // Manejar error en la conexión a la base de datos
    echo json_encode(["status" => "error", "message" => "Error de conexión a la base de datos."]);
    exit();
}


// --- Lógica para buscar datos del cliente (si viene la solicitud de búsqueda) ---
if (isset($_POST['buscar'])) {
    $buscador = $_POST['buscador'];
    $valores = array();
    $valores['existe'] = "0";

    $sql = "SELECT id_cliente, c_nombre, c_apellido, c_identificacion, c_telefono, c_direccion, c_estado, c_ciudad, c_codpostal, c_email, c_napartamento FROM cliente WHERE c_identificacion = ?";
    $stmt = $conexion->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $buscador);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($consulta = $result->fetch_assoc()) {
            $valores['existe'] = "1";
            $valores['id_cliente'] = $consulta['id_cliente'];
            $valores['nombre'] = $consulta['c_nombre'];
            $valores['apellido'] = $consulta['c_apellido'];
            $valores['identificacion'] = $consulta['c_identificacion'];
            $valores['telefono'] = $consulta['c_telefono'];
            $valores['direccion'] = $consulta['c_direccion'];
            $valores['estado'] = $consulta['c_estado'];
            $valores['ciudad'] = $consulta['c_ciudad'];
            $valores['postal'] = $consulta['c_codpostal'];
            $valores['email'] = $consulta['c_email'];
            $valores['departamento'] = $consulta['c_napartamento'];
        }
        $stmt->close();
    } else {
        error_log("Error preparando la búsqueda de cliente: " . $conexion->error);
    }
    echo json_encode($valores);
    exit();
}


// --- Lógica para registrar el trámite de divorcio ---
if (!empty($_POST["btn_registro_divorcio"])) {

    // Validar campos obligatorios
    if (empty($_POST["identificacion"]) || empty($_POST["nombre"]) || empty($_POST["honorarios"]) || empty($_POST["nombre_conyugue"]) || empty($_POST["tipo_divorcio"])) {
        echo json_encode(["status" => "error", "message" => "Faltan campos obligatorios (identificación, nombres, honorarios, nombre del cónyuge, tipo de divorcio)."]);
        exit;
    }

    // Recopilar datos del formulario
    $id_cliente = $_POST["id_cliente"];
    $tipo_divorcio = $_POST["tipo_divorcio"]; // "Controvertido" o "Consensual"
    $nombre_conyugue = $_POST["nombre_conyugue"];
    //$td_notarial = $_POST["td_notarial"];
    $identificacion_conyugue = $_POST["identificacion_conyugue"];
    $direccion_conyugue = $_POST["direccion_conyugue"];
    $apartamento_conyugue = $_POST["apartamento_conyugue"];
    $ciudad_conyugue = $_POST["ciudad_conyugue"];
    $estado_conyugue = $_POST["estado_conyugue"];
    $postal_conyugue = $_POST["postal_conyugue"];
    $telefono_conyugue = $_POST["telefono_conyugue"];
    $lugar_matrimonio = $_POST["lugar_matrimonio"];
    $fecha_matrimonio = $_POST["fecha_matrimonio"];
    $esta_separado = ($_POST["esta_separado"] == "1") ? 1 : 0; // tinyint(1)
    $tiempo_separacion = $_POST["tiempo_separacion"];
    $hijos = ($_POST["hijos"] == "1") ? 1 : 0; // tinyint(1)
    $posee_partida_matrimonio = isset($_POST["posee_partida_matrimonio"]) ? 1 : 0; // tinyint(1)
    $posee_partida_nacimiento_menores = isset($_POST["posee_partida_nacimiento_menores"]) ? 1 : 0; // tinyint(1)
    $contacto_ecuador = $_POST["contacto_ecuador"];
    $telefono_contacto_ecuador = $_POST["telefono_contacto_ecuador"];
    $observaciones = $_POST["observaciones"];
    $oficina = $_POST["oficina"];
    $fecha = $_POST["fecha"];
    $honorarios = floatval($_POST["honorarios"]);
    $abono = floatval($_POST["abono"]);

    // Determinar valores booleanos para td_controvertido y td_consensual
    $td_controvertido = ($tipo_divorcio === "Controvertido") ? 1 : 0;
    $td_consensual = ($tipo_divorcio === "Consensual") ? 1 : 0;
    $td_notarial = ($tipo_divorcio === "Notarial") ? 1 : 0;
    
    // Asignar valores para td_separados y td_noseparados (tinyint(1))
    $td_separados = $esta_separado;
    $td_noseparados = ($esta_separado === 0) ? 1 : 0; // Si no está separado, td_noseparados es 1

    $td_hijos = $hijos;

    // Calcular saldo
    $saldo = $honorarios - $abono;

    // Validación del abono
    if ($abono > $honorarios) {
        echo json_encode(["status" => "error", "message" => "El abono no puede ser mayor a los honorarios."]);
        exit;
    }

    // --- Obtener datos actuales del cliente para actualizar c_abonado, c_deuda, c_saldo ---
    $id_cli_abo = 0;
    $id_cli_deu = 0;
    $id_cli_sald = 0;

    $sqlabono = "SELECT c_abonado, c_deuda, c_saldo FROM cliente WHERE id_cliente = ?";
    $stmt = $conexion->prepare($sqlabono);
    if ($stmt) {
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        $stmt->bind_result($id_cli_abo, $id_cli_deu, $id_cli_sald);
        $stmt->fetch();
        $stmt->close();
    } else {
        error_log("Error preparando la consulta de saldos del cliente: " . $conexion->error);
    }

    // Calcular nuevos totales para el cliente
    $abonot = $id_cli_abo + $abono;
    $deudt = $id_cli_deu + $honorarios;
    $sald_cliente_actualizado = $id_cli_sald + ($honorarios - $abono); // Suma/resta el neto de este trámite al saldo existente

    // --- Inserción del nuevo trámite de divorcio ---
    // ¡AQUÍ ESTÁ EL CAMBIO CLAVE! Eliminamos 'id_hijos'
    $sql_insert_divorcio = "INSERT INTO tramite_divorcio (
        id_cliente, td_controvertido, td_consensual, td_notarial, td_identificacion_c, td_nombre_c, 
        td_direccion_c, td_telefono_c, td_estado_c, td_ciudad_c, td_apt_c, td_cpostal_c, 
        td_lugar_matrimonio, td_fecha_matrimonio, td_separados, td_noseparados, td_tiempo_separacion, td_hijos,
        td_ep_matrimonio, td_ep_nacimiento, td_estado_contac_ecuador, td_tel_ecuador, td_observaciones, 
        td_valor, td_abono, td_saldo, id_usuario, td_oficina, td_fecha
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?
    )";

    $stmt_insert = $conexion->prepare($sql_insert_divorcio);

    if ($stmt_insert) {
        // ¡Y AQUÍ EL OTRO CAMBIO CLAVE! La cadena de tipos ahora tiene 24 caracteres (24 variables)
        // La cadena de tipos corregida es: i i i s s s s s s s s s s i i s i i s s s d d d i
        // Contemos: 3*i + 13*s + 3*d = 19 s's + 5 i's = 24
        $stmt_insert->bind_param(
            "iiiiissssssssssisiiisssdddiss", // <-- CADENA DE TIPOS CORREGIDA (24 caracteres)
            $id_cliente, $td_controvertido, $td_consensual, $td_notarial, $identificacion_conyugue, $nombre_conyugue, 
            $direccion_conyugue, $telefono_conyugue, $estado_conyugue, $ciudad_conyugue, $apartamento_conyugue, $postal_conyugue, 
            $lugar_matrimonio, $fecha_matrimonio, $td_separados, $td_noseparados, $tiempo_separacion, $td_hijos,
            $posee_partida_matrimonio, $posee_partida_nacimiento_menores, $contacto_ecuador, $telefono_contacto_ecuador, $observaciones, 
            $honorarios, $abono, $saldo, $user_id, $oficina, $fecha
        );

        if ($stmt_insert->execute()) {
            $last_id = $conexion->insert_id; // Obtener el ID del nuevo registro

            // --- Actualizar los saldos del cliente en la tabla 'cliente' ---
            $sql_update_cliente = "UPDATE cliente SET c_abonado=?, c_deuda=?, c_saldo=? WHERE id_cliente=?";
            $stmt_update_cliente = $conexion->prepare($sql_update_cliente);

            if ($stmt_update_cliente) {
                $stmt_update_cliente->bind_param("dddi", $abonot, $deudt, $sald_cliente_actualizado, $id_cliente);
                if ($stmt_update_cliente->execute()) {
                    echo json_encode(["status" => "success", "message" => "Trámite de divorcio registrado y saldos de cliente actualizados correctamente.", "id" => $last_id]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Trámite de divorcio registrado, pero error al actualizar saldos del cliente: " . $stmt_update_cliente->error]);
                }
                $stmt_update_cliente->close();
            } else {
                echo json_encode(["status" => "error", "message" => "Error preparando la actualización de saldos del cliente: " . $conexion->error]);
            }

        } else {
            // Si hay un error en la inserción del trámite
            echo json_encode(["status" => "error", "message" => "Error al insertar el registro de divorcio: " . $stmt_insert->error]);
        }
        $stmt_insert->close();
    } else {
        // Error en la preparación de la sentencia de inserción
        echo json_encode(["status" => "error", "message" => "Error preparando la sentencia de inserción de divorcio: " . $conexion->error]);
    }

    $conexion->close(); // Cerrar la conexión a la base de datos
}

?>