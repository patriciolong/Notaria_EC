<?php

    $inc = include("conexionbd.php");
    if ($inc) {
        $consulta = "SELECT * FROM cliente";
        $resultado = mysqli_query($conexion,$consulta);

       
        if ($resultado){
            while($row = $resultado->fetch_array()){
                $id = $row['id_cliente'];
                $nombre = $row['c_identificacion'];
                $email = $row['c_nombre'];
                $fechareg = $row['c_apellido' ];
                ?>
                    <div>
                        <h2> <?php echo $nombre; ?></h2>
                            
                    </div>
                <?php

            } 
        }
        
    }
?>