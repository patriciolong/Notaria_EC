<?php
include("conexionbd.php");
if (!empty($_POST["btn_registro_user"])) {
    if (empty($_POST["usuario"]) || empty($_POST["nombre"]) || empty($_POST["apellido"]) || empty($_POST["pass"])|| empty($_POST["rol"])|| empty($_POST["estado"])|| empty($_POST["ofi"])) {
        echo json_encode(["status" => "error", "message" => "Todos los campos son necesarios"]);
        exit;
    } else {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $usuario = $_POST["usuario"];
        $pass = $_POST["pass"]; // Consider hashing the password for security
        $rol = $_POST["rol"];
        $estado = $_POST["estado"];
        $ofi = $_POST["ofi"];

        // Corrected SQL query: u_usuario should be $usuario, not $apellido
        $sql = $conexion->query("INSERT INTO usuario (u_nombre,u_apellido,u_usuario,u_contrasena,u_rol,u_estado,u_oficina)
        VALUES ('$nombre','$apellido','$usuario','$pass','$rol','$estado', '$ofi')");

        if ($sql) {
            echo json_encode(["status" => "success", "message" => "Registro insertado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al insertar el registro: " . $conexion->error]);
        }
    }
}
?>