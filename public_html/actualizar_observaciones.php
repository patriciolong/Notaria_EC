<?php
include("conexionbd.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_tram_div"]) && isset($_POST["td_observaciones"])) {
    $id = intval($_POST["id_tram_div"]);
    $obs = trim($_POST["td_observaciones"]);

    $stmt = $conexion->prepare("UPDATE tramite_divorcio SET td_observaciones = ? WHERE id_tram_div = ?");
    $stmt->bind_param("si", $obs, $id);
    
    if ($stmt->execute()) {
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
    } else {
        echo "Error al actualizar observaciones.";
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Datos inválidos.";
}
