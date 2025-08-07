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
    $user_oficina = $_SESSION['oficina_U']; // Obtiene la oficina del usuario actual
    $sql = "SELECT * FROM cliente WHERE 
        c_oficina_registro = '" . mysqli_real_escape_string($conexion, $user_oficina) . "' AND
        (
            c_nombre LIKE '%$buscador%' 
            OR c_identificacion LIKE '%$buscador%' 
            OR c_telefono LIKE '%$buscador%'
        )";
    $resultado = mysqli_query($conexion, $sql);
    $valores = [];
    if ($consulta = mysqli_fetch_array($resultado)) {
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
    echo json_encode($valores);
}







if (!empty($_POST["btn_registro_imp"])) {
    if (empty($_POST["identificacion"])) {
        echo 'Esta vacio';
    } else {
        $id_cliente = $_POST["id_cliente"];
        $tipo_doc = $_POST["tipo_doc"];
        $check1 = $_POST["check1"];
        $check2 = $_POST["check2"];
        $check3 = $_POST["check3"];
        $check4 = $_POST["check4"];
        $motivo = $_POST["motivo"];
        $razon_t = $_POST["razon_t"];
        $opc_envio = $_POST["opc_envio"];
        $remitente = $_POST["remitente"];
        $ciudad_r = $_POST["ciudad_r"];
        $provincia_r = $_POST["provincia_r"];
        $telefono_r = $_POST["telefono_r"];
        $valor = $_POST["valor"];
        $abono = $_POST["abono"];
        $oficina = $_POST["Oficina"];
        $fecha = $_POST["fecha"];
        $observaciones_t = $_POST["observaciones_t"];
        $ofifirmar = $_POST["ofifirmar"];

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
        $saldo= $valor - $abono;

        if ($abono > $valor) {

            
            echo json_encode(["status" => "error", "message" => "El abono no puede ser mayor al valor del trámite"]);
            exit; // para cortar ejecución
        }else{
            $sql = $conexion->query("INSERT INTO tramites_varios 
            (id_tramite_varios,id_cliente,tv_motivo,tv_oenvio,
            tv_nrecibo,tv_nom_envio,tv_ciudad,tv_provincia,tv_telefono,
            id_usuario,tv_tip_documento,tv_traducciones,tv_notarizacion,
            tv_certificacion,tv_apostilla,tv_valor_tramite,tv_observaciones,
            tv_oficina,tv_fecha,tv_abono_tramite, tv_saldo,tv_razon_t,tv_firmar_en) 
            VALUES ('','$id_cliente','$motivo','$opc_envio','23131','$remitente',
            '$ciudad_r','$provincia_r','$telefono_r','$user_id','$tipo_doc',
            '$check1','$check2','$check3','$check4','$valor','$observaciones_t',
            '$oficina','$fecha','$abono','$saldo','$razon_t','$ofifirmar')");
              //$sql3 = $conexion->query("UPDATE cliente SET c_abonado='$abonot', c_deuda='$deudt', c_saldo='$sald' WHERE id_cliente='$id_cliente'");
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