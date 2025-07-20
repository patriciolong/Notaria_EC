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
    $sql = "SELECT * FROM cliente WHERE 
        c_nombre LIKE '%$buscador%' 
        OR c_identificacion LIKE '%$buscador%' 
        OR c_telefono LIKE '%$buscador%'";
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
        # code...
    } else {





        $id_cliente = $_POST["id_cliente"];
        $fechaim = $_POST["fechaim"];
        $check1 = $_POST["check1"];
        $fechaeeuu = $_POST["fechaeeuu"];
        $anio_reporte = $_POST["anio_reporte"];
        $numitin = $_POST["numitin"];
        $estcivil = $_POST["estcivil"];
        $profesion = $_POST["profesion"];
        $dependentes = $_POST["dependentes"];
        $metpago = $_POST["metpago"];
        $banco = $_POST["banco"];
        $ncuenta = $_POST["ncuenta"];
        $nruta = $_POST["nruta"];
        $notas = $_POST["notas"];
        $abono = $_POST["atramite"];
        $valor = $_POST["vtramite"];
        $oficina = $_POST["oficina"];

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
        $saldo=$valor-$abono;

        if ($abono > $valor) {

            echo json_encode(["status" => "error", "message" => "El abono no puede ser mayor al valor del trámite"]);
            exit; // para cortar ejecución
        }else{
            $sql = $conexion->query("INSERT INTO tramite_impuestos (id_tram_impuestos,id_cliente,ti_fecha,ti_itin,ti_fechain,ti_nitin,ti_ecivil,ti_dependientes,ti_mpago,ti_banco,ti_ncuenta,ti_nruta,ti_observacion,id_usuario,ti_profesion,ti_anio_reporte,ti_oficina,ti_costo_tramite,ti_abono_tramite,ti_saldo) 
            VALUES ('','$id_cliente','$fechaim','$check1','$fechaeeuu','$numitin','$estcivil','$dependentes','$metpago','$banco','$ncuenta','$nruta','$notas','$user_id','$profesion','$anio_reporte','$oficina','$valor','$abono','$saldo')");
             // $sql3 = $conexion->query("UPDATE cliente SET c_abonado='$abonot', c_deuda='$deudt', c_saldo='$sald' WHERE id_cliente='$id_cliente'");
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