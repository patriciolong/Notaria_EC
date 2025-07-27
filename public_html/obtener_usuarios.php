<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include 'conexionbd.php';

$sql = "SELECT
            usuario.id_usuario,
            usuario.u_usuario,
            usuario.u_nombre,
            usuario.u_apellido,
            usuario.u_rol,
            usuario.u_estado,
            usuario.u_oficina
        FROM usuario";

$result = $conexion->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// If there was an error in the query
if (!$result) {
    echo json_encode(["error" => $conexion->error]);
    exit;
}

echo json_encode($data);

$conexion->close();
?>