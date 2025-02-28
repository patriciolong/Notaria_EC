<?php
if (!empty($_POST["btningresar"])) {
    if (empty($_POST["usuario"]) and empty($_POST["password"])) {
        echo '<div style="color:red">LOS CAMPOS ESTAN VACIOS </div>';
    }else{
        $usuario=$_POST["usuario"];
        $clave=$_POST["password"];
        session_start();
        $_SESSION['usuario']=$usuario;

        $sql=$conexion->query(" select * from usuario where u_usuario= '$usuario' and u_contrasena='$clave'");
        if ($datos =$sql->fetch_object()) {
            header("location:menu.php");
        }else {
            echo '<div style="color:red">Acceso denegado </div>';
        }
    }
}

?>