<?php

session_start();
error_reporting(0);
$varsesion =$_SESSION['usuario'];
$variable_ses = $varsesion;

include("conexionbd.php");



if (!empty($_POST["btn_registro"])) {
    if (empty($_POST["identificacion"])) {
        echo json_encode(["status" => "error", "message" => "Todos los campos son necesarios"]);
        exit;
    }else{
        
        $identificacion = $_POST["identificacion"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $telefono = $_POST["telefono"];
        $edad = $_POST["edad"];
        $direccion = $_POST["direccion"];
        $pais = $_POST["pais"];
        $estado = $_POST["estado"];
        $ciudad = $_POST["ciudad"];
        $postal = $_POST["postal"];
        $email = $_POST["email"];
        $departamento = $_POST["departamento"];
        $oficina = $_POST["c_oficina"];


        $sql = $conexion->query("INSERT INTO cliente (c_identificacion,c_nombre,c_apellido,c_telefono,c_edad,c_direccion,c_pais,c_estado,c_ciudad,c_codpostal,c_email,c_napartamento, c_register,c_oficina_registro) 
        VALUES ('$identificacion','$nombre','$apellido','$telefono','$edad','$direccion','$pais','$estado','$ciudad','$postal','$email','$departamento', '$variable_ses','$oficina')");
       if ($sql) {
        echo json_encode(["status" => "success", "message" => "Registro insertado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al insertar el registro: " . $conexion->error]);
    }
    }




   

}


?>