<?php
include("conexionbd.php");
if (!empty($_POST["btningresar"])) {
    if (empty($_POST["usuario"]) and empty($_POST["password"])) {
        echo '<div style="color:red">LOS CAMPOS ESTAN VACIOS </div>';
    }else{
        $usuario=$_POST["usuario"];
        $clave=$_POST["password"];
        session_start();
        $_SESSION['usuario']=$usuario;
        date_default_timezone_set('America/Bogota');
        $fechaHora = date('Y-m-d H:i:s');


        $sql3 = "SELECT id_usuario FROM usuario WHERE u_usuario = ?";
        $stmt = $conexion->prepare($sql3);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();




        $sql=$conexion->query(" select * from usuario where u_usuario= '$usuario' and u_contrasena='$clave'");
        $sql2 = $conexion->query("INSERT INTO login_data (l_fecha_hora,id_usuario) VALUES ('$fechaHora','$user_id')");
        if ($datos =$sql->fetch_object()) {
           if ($sql2 == 1) {
            header("location:menu.php");
           }else {
            echo $conexion->error;
           }
           
        }else {
            echo '<div style="color:red">Acceso denegado </div>';
        }
    }
}

?> 