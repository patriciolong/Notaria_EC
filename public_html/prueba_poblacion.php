
  <?php
  session_start();
  error_reporting(0);
  $varsesion =$_SESSION['usuario'];
include("conexionbd.php");  

$sql2 = "SELECT id_usuario FROM usuario WHERE u_usuario = ?";
$stmt = $conexion->prepare($sql2);
$stmt->bind_param("s", $varsesion);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();




if (isset($_POST['buscar'])) {
    $buscador=$_POST['buscador'];
    $valores = array();
    $valores['existe']="0";

    
  
    $sql=mysqli_query($conexion,"Select * from cliente where c_identificacion = '$buscador'");
    while($consulta = mysqli_fetch_array($sql))
    {
        $valores['existe']="1";
        $valores['id_cliente']=$consulta['id_cliente'];
        $valores['nombre']=$consulta['c_nombre'];
        $valores['apellido']=$consulta['c_apellido'];
        $valores['identificacion']=$consulta['c_identificacion'];
        $valores['telefono']=$consulta['c_telefono'];
        $valores['direccion']=$consulta['c_direccion'];
        $valores['estado']=$consulta['c_estado'];
        $valores['ciudad']=$consulta['c_ciudad'];
        $valores['postal']=$consulta['c_codpostal'];
        $valores['email']=$consulta['c_email'];
        $valores['departamento']=$consulta['c_napartamento'];

    }
    $valores = json_encode($valores);
    echo $valores;
}

    





if (!empty($_POST["btn_registro_tra"])) {
  if (empty($_POST["identificacion"])) {
      echo 'Esta vacio';
      # code...
  }else{





      $id_cliente = $_POST["id_cliente"];
      $tipo_doc = $_POST["tipo_doc"];
      $check1 = $_POST["check1"];
      $check2 = $_POST["check2"];
      $check3 = $_POST["check3"];
      $check4 = $_POST["check4"];
      $motivo = $_POST["motivo"];
      $opc_envio = $_POST["opc_envio"];
      $remitente = $_POST["remitente"];
      $ciudad_r = $_POST["ciudad_r"];
      $provincia_r = $_POST["provincia_r"];
      $telefono_r = $_POST["telefono_r"];
      $sql = $conexion->query("INSERT INTO tramites_varios (id_tramite_varios,id_cliente,tv_motivo,tv_oenvio,tv_nrecibo,tv_nom_envio,tv_ciudad,tv_provincia,tv_telefono,id_usuario,tv_tip_documento,tv_traducciones,tv_notarizacion,tv_certificacion,tv_apostilla) 
      VALUES ('','$id_cliente','$motivo','$opc_envio','23131','$remitente','$ciudad_r','$provincia_r','$telefono_r','$user_id','$tipo_doc','$check1','$check2','$check3','$check4')");
      if ($sql==1) {
          echo '<div class="succes">REGISTRADO TRAMITE </div>';
          header("Refresh:4 ;URL=menu.php");
          exit;
          # code...
      }else{
          echo "Error";
      }
  }




 

}



  ?>