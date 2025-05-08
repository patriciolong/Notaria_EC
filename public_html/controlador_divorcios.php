<?php
session_start();
error_reporting(0);
$varsesion = $_SESSION['usuario'];
include("conexionbd.php");

$sql2 = "SELECT id_usuario FROM usuario WHERE u_usuario = ?";
$stmt = $conexion->prepare($sql2);
$stmt->bind_param("s", $varsesion);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();




if (isset($_POST['buscar'])) {
    $buscador = $_POST['buscador'];
    $valores = array();
    $valores['existe'] = "0";



    $sql = mysqli_query($conexion, "Select * from cliente where c_identificacion = '$buscador'");
    while ($consulta = mysqli_fetch_array($sql)) {
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
    $valores = json_encode($valores);
    echo $valores;
}







if (!empty($_POST["btn_registro_tra"])) {
    if (empty($_POST["identificacion"])) {
        echo 'Está vacío el campo de identificación.';
    } else {
        $id_cliente = $_POST["id_cliente"];

        // Checks
        $check1 = $_POST["check1"]; // td_controvertido
        $check2 = $_POST["check2"]; // td_consensual
        $check3 = $_POST["check3"]; // td_separados
        $check4 = $_POST["check4"]; // td_noseparados
        $check5 = $_POST["check5"]; // td_ep_matrimonio
        $check6 = $_POST["check6"]; // td_ep_nacimiento

        // Datos del cónyuge
        $ci = $_POST["ci"];
        $cn = $_POST["cn"];
        $cd = $_POST["cd"];
        $ct = $_POST["ct"];
        $ce = $_POST["ce"];
        $cc = $_POST["cc"];
        $ca = $_POST["ca"];
        $ccp = $_POST["ccp"];

        // Matrimonio
        $lm = $_POST["lm"];
        $fm = $_POST["fm"];
        $ts = $_POST["ts"];

        // Ecuador contacto
        $cee = $_POST["cee"];
        $te = $_POST["te"];
        $o = $_POST["o"];
        //$hijos = "1";

        // Pago
        $valor = floatval($_POST["h"]);
        $abono = floatval($_POST["a"]);
        $mpago = "EFECTIVO"; // Cambia por $_POST["mpago"] si usas formulario

        // Consultar datos previos del cliente
        $stmt = $conexion->prepare("SELECT c_abonado, c_deuda FROM cliente WHERE id_cliente = ?");
        $stmt->bind_param("i", $id_cliente);
        $stmt->execute();
        if (!$stmt->execute()) {
            die("Error en ejecución: " . $stmt->error);
        }
        $stmt->bind_result($abonado_actual, $deuda_actual);
        $stmt->fetch();
        $stmt->close();

        $abonado_nuevo = $abonado_actual + $abono;
        $deuda_nueva = $deuda_actual + $valor;
        $saldo = $deuda_nueva - $abonado_nuevo;

        // Validar abono
        if ($abono > $valor) {
            echo "<script>alert('El abono no puede ser mayor al valor del trámite');</script>";
        } else {
            $stmt = $conexion->prepare("INSERT INTO tramite_divorcio (
                id_cliente, td_controvertido, td_consensual, td_identificacion_c, td_nombre_c, td_direccion_c,
                td_telefono_c, td_estado_c, td_ciudad_c, td_apt_c, td_cpostal_c, td_lugar_matrimonio, td_fecha_matrimonio,
                td_separados, td_noseparados, td_tiempo_separacion, td_ep_matrimonio, td_ep_nacimiento,
                td_estado_contac_ecuador, td_tel_ecuador, td_observaciones, td_mpago, td_valor, td_abono, td_saldo, id_usuario
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param(
                "iiissssssssssiiiisssdddi",
                $id_cliente, $check1, $check2, $hijos, $ci, $cn, $cd, $ct, $ce, $cc, $ca, $ccp, $lm, $fm,
                $check3, $check4, $ts, $check5, $check6, $cee, $te, $o, $mpago, $valor, $abono, $saldo, $user_id
            );

            if ($stmt->execute()) {
                // Actualizar cliente
                $stmt2 = $conexion->prepare("UPDATE cliente SET c_abonado = ?, c_deuda = ?, c_saldo = ? WHERE id_cliente = ?");
                $stmt2->bind_param("dddi", $abonado_nuevo, $deuda_nueva, $saldo, $id_cliente);
                $stmt2->execute();
                $stmt2->close();

                echo '<div class="success">Trámite de divorcio registrado correctamente.</div>';
                header("Refresh:4; URL=menu.php");
                exit;
            } else {
                echo "Error al registrar el trámite: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}




?>