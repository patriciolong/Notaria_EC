<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include 'conexionbd.php';

$sql = "SELECT 
            login_data.id_login, 
            login_data.l_fecha_hora, 
            usuario.u_usuario, 
            usuario.u_nombre, 
            usuario.u_apellido
        FROM login_data
        INNER JOIN usuario ON login_data.id_usuario = usuario.id_usuario
        ORDER BY login_data.l_fecha_hora DESC";

$result = $conexion->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Si hubo error en la consulta
if (!$result) {
    echo json_encode(["error" => $conexion->error]);
    exit;
}

echo json_encode($data);

$conexion->close();
?>
