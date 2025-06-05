<?php
include("conexionbd.php"); // Asegúrate de que esta ruta sea correcta

if (!empty($_POST["btn_registro"])) {
    if (empty($_POST["identificacion"])) {
        // Redirige con un mensaje de error si la identificación está vacía
        header("Location: crud_clientes.php?status=error&message=El campo Identificación no puede estar vacío.");
        exit;
    } else {
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

        // Verificar si la identificación ya existe
        $check_sql = $conexion->prepare("SELECT c_identificacion FROM cliente WHERE c_identificacion = ?");
        $check_sql->bind_param("s", $identificacion);
        $check_sql->execute();
        $check_sql->store_result();

        if ($check_sql->num_rows > 0) {
            // Redirige con un mensaje de error si la identificación ya existe
            header("Location: crud_clientes.php?status=error&message=La identificación ya existe. Por favor, ingrese una diferente.");
            exit;
        } else {
            // Usar sentencias preparadas para prevenir la inyección SQL
            $sql = $conexion->prepare("INSERT INTO cliente (c_identificacion, c_nombre, c_apellido, c_telefono, c_edad, c_direccion, c_pais, c_estado, c_ciudad, c_codpostal, c_email, c_napartamento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $sql->bind_param("sssissssssss", $identificacion, $nombre, $apellido, $telefono, $edad, $direccion, $pais, $estado, $ciudad, $postal, $email, $departamento);

            if ($sql->execute()) {
                // Redirige con un mensaje de éxito
                header("Location: crud_clientes.php?status=success&message=Cliente registrado exitosamente.");
                exit;
            } else {
                // Redirige con un mensaje de error detallado desde la base de datos
                header("Location: crud_clientes.php?status=error&message=Error al registrar el cliente: " . $sql->error);
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