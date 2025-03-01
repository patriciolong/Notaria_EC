<?php

include("conexionbd.php")

?>

<! DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Formulario</title>
</head>
<body>

<form action="#" name="ejemplo" method="post">

<input type="submit" name="registro">

</form>

</body>

<?php

if(isset($_POST['registro'])){


$insertarDatos = "UPDATE cliente SET c_abonado='6', c_deuda='5' WHERE id_cliente='1'";

//$insertarDatos = "INSERT INTO cliente VALUES('$nombre', '$correo', '$telefono','','','','','','','','','','','','')";
$ejecutarInsertar = mysqli_query ($conexion, $insertarDatos);

//echo $insertarDatos;
header("Refresh:4 ;URL=pruebas.php");
exit;


}

?>