<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cliente_id']) && isset($_POST['nuevo_abono'])) {
        $cliente_id = intval($_POST['cliente_id']);
        $nuevo_abono = floatval($_POST['nuevo_abono']);

        // Conectar a la base de datos        
        include("conexionbd.php");

        // Obtener el abono actual
        $sql_select = "SELECT c_abonado FROM cliente WHERE id_cliente = ?";
        $stmt = $conexion->prepare($sql_select);
        $stmt->bind_param("i", $cliente_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $abono_actual = floatval($fila['c_abonado']);

            // Sumar el nuevo abono
            $nuevo_total = $abono_actual + $nuevo_abono;

            // Actualizar en la base de datos
            $sql_update = "UPDATE cliente SET c_abonado = ? WHERE id_cliente = ?";
            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bind_param("di", $nuevo_total, $cliente_id);

            if ($stmt_update->execute()) {
                echo "Abono actualizado correctamente.";
            } else {
                echo "Error al actualizar el abono.";
            }
        } else {
            echo "Cliente no encontrado.";
        }

        $conexion->close();
    } else {
        echo "Faltan datos.";
    }
} else {
    echo "Método no permitido.";
}
?>
