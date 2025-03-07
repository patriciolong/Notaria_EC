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
            <div class="modal-header" data-clienteid="1" data-abonado="0">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Cuanto desea abonar a la deuda del cliente?</h1>
                <button type="button"  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAbono">
                    
                    <input type="hidden" id="cliente_id" name="cliente_id" >
                    
                    <label for="nuevo_abono">Monto a Abonar:</label>
                    <input type="number" step="0.01" id="nuevo_abono" name="nuevo_abono" class="form-control" required>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success"
                        >Abonar</button>
                    </div>
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

<script>
document.addEventListener("DOMContentLoaded", function() {
    var abonoModal = document.getElementById("modalabonar");

    abonoModal.addEventListener("show.bs.modal", function(event) {
        var button = event.relatedTarget; // Botón que abrió el modal
        var clienteId = button.getAttribute("data-clienteid");
        var abonado = button.getAttribute("data-abonado");

        // Asignar los valores al formulario dentro del modal
        document.getElementById("cliente_id").value = clienteId;
    });

    // Capturar el envío del formulario con AJAX
    document.getElementById("formAbono").addEventListener("submit", function(event) {
        event.preventDefault(); // Evitar recarga de la página

        var formData = new FormData(this);

        fetch("edicion_bd.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Mostrar mensaje de respuesta
            location.reload(); // Recargar la página para reflejar cambios
        })
        .catch(error => console.error("Error:", error));
    });
});
</script>

</body>


</html>

