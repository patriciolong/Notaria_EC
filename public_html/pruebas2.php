<?php
include("conexionbd.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<input type="submit" name="registro">

</body>
</html>


<?php

if(isset($_POST['registro'])){



$insertarDatos = "UPDATE `cliente` SET `c_abonado`='7',`c_deuda`='8' WHERE `id_cliente`='1'";

$ejecutarInsertar = mysqli_query ($conexion, $insertarDatos);


header("Refresh:3; url:clientes.php");
die;


}

?>