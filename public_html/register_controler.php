<?php
if (!empty($_POST["btn_registro"])) {
    if (empty($_POST["identificacion"])) {
        echo 'Esta vacio';
        # code...
    }else{
        $id_cliente = $_POST["cliente"];
        $identificacion = $_POST["identificacion"];
        $nombre = $_POST["nombres"];
        $apellido = $_POST["apellidos"];
        $telefono = $_POST["telefono"];
        $edad = $_POST["edad"];
        $direccion = $_POST["direccion"];
        $pais = $_POST["pais"];
        $estado = $_POST["estado"];
        $ciudad = $_POST["ciudad"];
        $postal = $_POST["postal"];
        $email = $_POST["email"];
        $departamento = $_POST["departamento"];
        $sql = $conexion->query("INSERT INTO cliente (c_identificacion,c_nombre,c_apellido,c_telefono,c_edad,c_direccion,c_pais,c_estado,c_ciudad,c_codpostal,c_email,c_napartamento) 
        VALUES ('$identificacion','$nombre','$apellido','$telefono','$edad','$direccion','$pais','$estado','$ciudad','$postal','$email','$departamento')");
        if ($sql==1) {
            echo '<div class="succes">REGISTRADO </div>';
            header("Refresh:4 ;URL=menu.php");
            exit;
            # code...
        }else{
            echo "Error". $conexion->error;
        }
    }




   

}


?>