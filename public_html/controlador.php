<?php
include("conexionbd.php");
if (!empty($_POST["btningresar"])) {
    if (empty($_POST["usuario"]) and empty($_POST["password"])) {
        echo '<div style="color:red">LOS CAMPOS ESTAN VACIOS </div>';
    } else {
        $usuario = $_POST["usuario"];
        $clave = $_POST["password"];
        session_start();
        $_SESSION['usuario'] = $usuario;
        date_default_timezone_set('America/Bogota');
        $fechaHora = date('Y-m-d H:i:s');

        // Prepare and execute the query to get user_id and u_estado
        $sql_check_user = "SELECT id_usuario, u_estado FROM usuario WHERE u_usuario = ? AND u_contrasena = ?";
        $stmt_check_user = $conexion->prepare($sql_check_user);
        $stmt_check_user->bind_param("ss", $usuario, $clave);
        $stmt_check_user->execute();
        $stmt_check_user->bind_result($user_id, $user_estado);
        $stmt_check_user->fetch();
        $stmt_check_user->close();

        if ($user_id) { // If a user with the provided credentials exists
            if ($user_estado == 'Activo') { // Check if the user's status is 'Activo'
                // Insert login data
                $sql2 = $conexion->query("INSERT INTO login_data (l_fecha_hora,id_usuario) VALUES ('$fechaHora','$user_id')");
                if ($sql2 == 1) {
                    header("location:menu.php");
                } else {
                    echo $conexion->error;
                }
            } else {
                echo '<div style="color:red">Su cuenta está inactiva. Contacte al administrador.</div>';
            }
        } else {
            echo '<div style="color:red">Acceso denegado. Usuario o contraseña incorrectos.</div>';
        }
    }
}
?>