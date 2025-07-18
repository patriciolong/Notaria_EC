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







if (!empty($_POST["btn_registro_imp"])) {
    if (empty($_POST["identificacion"])) {
        echo 'Esta vacio';
        # code...
    } else {





        $id_cliente = $_POST["id_cliente"];
        $fecha = $_POST["fecha"];
        $Oficina = $_POST["Oficina"];
        $nombres_otorga = $_POST["nombres_otorga"];
        $cedula_otorga = $_POST["cedula_otorga"];
        $estcivil = $_POST["estcivil"];
        $razon_poder = $_POST["razon_poder"];
        $opcion_envio_poder = $_POST["opcion_envio_poder"];
        $valor = $_POST["valor"];
        $costo_tramite = $_POST["valor"];
        $abono = $_POST["abono"];
        $abono_tramite = $_POST["abono"];
        $remitente = $_POST["remitente"];
        $ciudad_r = $_POST["ciudad_r"];
        $provincia_r = $_POST["provincia_r"];
        $telefono_r = $_POST["telefono_r"];
        $observaciones_p = $_POST["observaciones_p"];



        $sqlabono = "SELECT c_abonado FROM cliente WHERE id_cliente = ?";
        $stmt = $conexion->prepare($sqlabono);
        $stmt->bind_param("s", $id_cliente);
        $stmt->execute();
        $stmt->bind_result($id_cli_abo);
        $stmt->fetch();
        $stmt->close();


        $aqldeuda = "SELECT c_deuda FROM cliente WHERE id_cliente = ?";
        $stmt = $conexion->prepare($aqldeuda);
        $stmt->bind_param("s", $id_cliente);
        $stmt->execute();
        $stmt->bind_result($id_cli_deu);
        $stmt->fetch();
        $stmt->close();

        $aqldeuda = "SELECT c_saldo FROM cliente WHERE id_cliente = ?";
        $stmt = $conexion->prepare($aqldeuda);
        $stmt->bind_param("s", $id_cliente);
        $stmt->execute();
        $stmt->bind_result($id_cli_sald);
        $stmt->fetch();
        $stmt->close();

        $abonot = $id_cli_abo + $abono;
        $deudt = $id_cli_deu + $valor;
        $sald = $deudt - $abonot;
        $saldo=$costo_tramite-$abono_tramite;

        if ($abono > $valor) {

            echo json_encode(["status" => "error", "message" => "El abono no puede ser mayor al valor del trámite"]);
            exit; // para cortar ejecución
        }else{
            $sql = $conexion->query("INSERT INTO tramite_poderes (id_tram_poderes,id_cliente,tp_oficina,tp_fecha,tp_estado_civil,tp_nombres_otorga_poder,tp_cedulla_otorga_poder,tp_razon_otorga_poder,tp_opcion_envio_poder,tp_enviar_nombrede,tp_ciudad_enviar,tp_telefonos_enviar,id_usuario,tp_observaciones,tp_costo_tramite,tp_abono_tramite,tp_saldo) 
            VALUES ('','$id_cliente','$Oficina','$fecha','$estcivil','$nombres_otorga','$cedula_otorga','$razon_poder','$opcion_envio_poder','$remitente','$ciudad_r','$telefono_r','$user_id','$observaciones_p','$costo_tramite','$abono_tramite','$saldo')");
             //and $sql3 == 1
             if ($sql) {
                // Obtener el ID del último registro insertado
                $last_id = $conexion->insert_id;
                // Devolver una respuesta JSON con el mensaje y el ID
                echo json_encode(["status" => "success", "message" => "Registro insertado correctamente", "id" => $last_id]);
                $sql3 = $conexion->query("UPDATE cliente SET c_abonado='$abonot', c_deuda='$deudt', c_saldo='$sald' WHERE id_cliente='$id_cliente'");

            } else {
                // Si hay un error en la inserción
                echo json_encode(["status" => "error", "message" => "Error al insertar el registro: " . $conexion->error]);
            }
        }



      
    }






}



?>