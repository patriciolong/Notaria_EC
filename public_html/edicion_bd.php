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

        $sql_select2 = "SELECT c_saldo FROM cliente WHERE id_cliente = ?";
        $stmt2 = $conexion->prepare($sql_select2);
        $stmt2->bind_param("i", $cliente_id);
        $stmt2->execute();
        $resultado2 = $stmt2->get_result();

        if ($resultado->num_rows > 0 && $resultado2->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $fila2 = $resultado2->fetch_assoc();
            $abono_actual = floatval($fila['c_abonado']);            
            $deuda_actual = floatval($fila2['c_saldo']);

            // Sumar el nuevo abono
            $nuevo_total = $abono_actual + $nuevo_abono;
            $nuevo_total2 = $deuda_actual - $nuevo_abono;

            if($nuevo_total2 < 0 || $nuevo_abono < 0) {
                echo "El abono no puede ser mayor al saldo pendiente ni menor que 0.";
                exit;            
                
            }

            // Actualizar en la base de datos
            $sql_update = "UPDATE cliente SET c_abonado = ?, c_saldo = ? WHERE id_cliente = ?";
            $stmt_update = $conexion->prepare($sql_update);
            $stmt_update->bind_param("ddi", $nuevo_total, $nuevo_total2,  $cliente_id);

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
