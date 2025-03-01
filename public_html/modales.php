<?php
include("conexionbd.php");
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>



     <!-- Modal -->
 <div class="modal fade" id="modalabonar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Cuanto desea abonar a la deuda del cliente?</h1>
                <button type="button"  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                    intentemos

            </div>
            <div class="modal-footer">
            <form action="#" name="ejemplo" method="post">

            <input type="submit" name="registro">

            </form>            
            </div>
            </div>
        </div>
    </div>

    

         <!-- Modal -->
 <div class="modal fade" id="modalcancelardeuda" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Seguro desea cancelar la deuda del cliente?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
            </div>
            </div>
        </div>
    </div>

</body>


</html>

<?php
if(isset($_POST['registro'])){


$insertarDatos = "UPDATE cliente SET c_abonado='8', c_deuda='5' WHERE id_cliente='1'";

$ejecutarInsertar = mysqli_query ($conexion, $insertarDatos);

//echo $insertarDatos;
header("Refresh:4 ;URL=clientes.php");
exit;


}

?>
