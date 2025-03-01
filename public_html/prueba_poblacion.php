
  <?php
include("conexionbd.php");  

if (isset($_POST['buscar'])) {
    $buscador=$_POST['buscador'];
    $valores = array();
    $valores['existe']="0";
    
    $sql=mysqli_query($conexion,"Select * from cliente where id_cliente = '$buscador'");
    while($consulta = mysqli_fetch_array($sql))
    {
        $valores['existe']="1";
        $valores['nombre']=$consulta['c_nombre'];
        $valores['apellido']=$consulta['c_apellido'];
        $valores['identificacion']=$consulta['c_identificacion'];

    }
    $valores = json_encode($valores);
    echo $valores;
}
  ?>