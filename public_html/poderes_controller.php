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
        $fechaim = $_POST["fechaim"];
        $check1 = $_POST["check1"];
        $fechaeeuu = $_POST["fechaeeuu"];
        $numitin = $_POST["numitin"];
        $estcivil = $_POST["estcivil"];
        $profesion = $_POST["profesion"];
        $dependentes = $_POST["dependentes"];
        $metpago = $_POST["metpago"];
        $banco = $_POST["banco"];
        $ncuenta = $_POST["ncuenta"];
        $nruta = $_POST["nruta"];
        $notas = $_POST["notas"];
        $abono = $_POST["abono"];

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

        if ($abono > $valor) {

            echo "<script>alert('El abono no puede ser mayor al valor del tramite');</script>";
        }else{
            $sql = $conexion->query("INSERT INTO tramite_impuestos (id_tram_impuestos,id_cliente,ti_fecha,ti_itin,ti_fechain,ti_nitin,ti_ecivil,ti_dependientes,ti_mpago,ti_banco,ti_ncuenta,ti_nruta,ti_observacion,id_usuario,ti_profesion) 
            VALUES ('','$id_cliente','$fechaim','$check1','$fechaeeuu','$numitin','$estcivil','$dependentes','$metpago','$banco','$ncuenta','$nruta','$notas','$user_id','$profesion')");
             // $sql3 = $conexion->query("UPDATE cliente SET c_abonado='$abonot', c_deuda='$deudt', c_saldo='$sald' WHERE id_cliente='$id_cliente'");
             //and $sql3 == 1
              if ($sql == 1  ) {
                  echo '<div class="succes">REGISTRADO TRAMITE </div>';
                  echo '<div class="succes"></div>';
                  header("Refresh:4 ;URL=menu.php");
                  exit;
            //      # code...
              } else {
                  echo "Error";
                  header("Refresh:4 ;URL=menu.php");
                  exit;
             }
        }



      
    }






}



?>