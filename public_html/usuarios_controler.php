<?php
include("conexionbd.php"); // Asegúrate de que esta ruta sea correcta

if (!empty($_POST["btn_registro"])) {
    if (empty($_POST["usuario"])) {
        // Redirige con un mensaje de error si la identificación está vacía
        header("Location: creacion_usuarios.php?status=error&message=El campo Usuario no puede estar vacío.");
        exit;
    } else {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $usuario = $_POST["usuario"];
        $pass = $_POST["contrasena"];

        // Verificar si la identificación ya existe
        $check_sql = $conexion->prepare("SELECT u_usuario FROM usuario WHERE u_usuario = ?");
        $check_sql->bind_param("s", $usuario);
        $check_sql->execute();
        $check_sql->store_result();

        if ($check_sql->num_rows > 0) {
            // Redirige con un mensaje de error si la identificación ya existe
            header("Location: creacion_usuarios.php?status=error&message=La identificación ya existe. Por favor, ingrese una diferente.");
            exit;
        } else {
            // Usar sentencias preparadas para prevenir la inyección SQL
            $sql = $conexion->prepare("INSERT INTO usuario (u_nombre, u_apellido, u_usuario, u_contrasena) VALUES (?, ?, ?, ?)");
            $sql->bind_param("ssss", $nombre, $apellido, $usuario, $pass);

            if ($sql->execute()) {
                // Redirige con un mensaje de éxito
                header("Location: creacion_usuarios.php?status=success&message=Usuario registrado exitosamente.");
                exit;
            } else {
                // Redirige con un mensaje de error detallado desde la base de datos
                header("Location: creacion_usuarios.php?status=error&message=Error al registrar el Usuario: " . $sql->error);
                exit;
            }
        }
        $check_sql->close();
        $sql->close();
    }
}
// Asegúrate de cerrar la conexión a la base de datos al final
$conexion->close();
?>