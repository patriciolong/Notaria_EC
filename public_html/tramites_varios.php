<?php
//seguridad de paginacion 
session_start();
error_reporting(0);
$varsesion =$_SESSION['usuario'];
$variable_ses = $varsesion;
if ($varsesion==null || $varsesion='') {
    header("location:index.php");
    die;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tramites Varios</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/tram_varis.css" rel="stylesheet" />
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
        integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>


    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg" style="background-color: #e2e2e2;">
            <div class="container px-lg-5">
            <a class="navbar-brand" href="http://localhost/Notaria_EC/public_html/menu.php">
                <img src="img\logo.png" alt="logo" width="150px">
            </a>
        <!-- Example single danger button -->
       <div class="btn-group">
       <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <?php echo $variable_ses;?>
        </button>
        <ul class="dropdown-menu">
        <li><hr class="dropdown-divider"></li>
       <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar Sesion</a></li>
       </ul>
      </div>
            </div>
        </nav>

        <div style="widht: 100px; margin:0 auto;text-align: center">
        <p class="fs-2" >Tramites Varios</p>
        </div>

    <!-- Barra de busqueda-->
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Nombre o Identificación"
                    aria-label="Nombre o Identificación" id="buscador" name="buscador">
                <input class="btn btn-outline-success" type="button" onclick="buscar_datos()" value="Buscar"></input>
            </form>
        </div>
    </nav>



    </div>
    <div class="container">
        <form class="fs-form fs-layout__2-column" method="POST" action="" id="formPoderes">
            <?php
            include("conexionbd.php");
            include("prueba_poblacion.php");
            ?>
            <fieldset>
                <div class="fs-field">
                <input class="fs-input" type="hidden" id="id_usuario" name="id_usuario" placeholder="identificacion" />  
                <input class="fs-input" type="hidden" id="id_cliente" name="id_cliente" placeholder="identificacion" />
                    <label class="fs-label" for="">Identificacion</label>
                    <input class="fs-input" id="identificacion" name="identificacion" placeholder="identificacion" />
                    <div class="fs-field">
                        <label class="fs-label" for="">Nombres</label>
                        <input class="fs-input" id="nombre" name="nombre" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Apellidos</label>
                        <input class="fs-input" id="apellido" name="apellido" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Telefono</label>
                        <input class="fs-input" name="telefono" id="telefono" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Direccion</label>
                        <input class="fs-input" name="direccion" id="direccion" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Estado</label>
                        <input class="fs-input" name="estado" id="estado"/>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Ciudad</label>
                        <input class="fs-input" name="ciudad" id="ciudad"/>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Codigo Postal</label>
                        <input class="fs-input" name="postal" id="postal"/>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Email</label>
                        <input class="fs-input" name="email" id="email"/>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">N° Departamento</label>
                        <input class="fs-input" name="departamento" id="departamento"/>
                    </div>


                </div>
                <div class="fs-field">
                    <label class="fs-label" for="">Tipo de documento</label>
                    <select class="form-select" name="tipo_doc" id="tipo_doc">
                        <option>Elegir</option>
                        <option>Nacimiento</option>
                        <option>Matrimonio</option>
                        <option>Defuncion</option>
                        <option>Divorcio</option>
                        <option>Academicas</option>
                        <option>Carta de invitacion</option>
                        <option>Otros</option>
                    </select>
                    <div class="fs-field">
                        <label class="fs-label" for="">Servicios</label>
                        <div class="form-check">
                        <input class="form-check-input" type="hidden" id="check1" name="check1" value="0">
                        <input class="form-check-input" type="hidden" id="check2" name="check2" value="0">
                        <input class="form-check-input" type="hidden" id="check3" name="check3" value="0">
                        <input class="form-check-input" type="hidden" id="check4" name="check4" value="0">
                        <label class="form-check-label">Traducciones</label>
                            <input class="form-check-input" type="checkbox" id="check1" name="check1" value="1">
                        </div>
                        <div class="form-check">
                        <label class="form-check-label">Notarizacion</label>
                            <input class="form-check-input" type="checkbox" id="check2" name="check2" value="1">
                        </div>
                        <div class="form-check">
                        <label class="form-check-label">Certificacion</label>
                            <input class="form-check-input" type="checkbox" id="check3" name="check3" value="1">
                        </div>
                        <div class="form-check">
                        <label class="form-check-label">Apostilla</label>
                            <input class="form-check-input" type="checkbox" id="check4" name="check4" value="1">
                        </div>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Para uso en:</label>
                        <input class="fs-input" id="motivo" name="motivo" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Opcion de envio</label>
                        <select class="form-select" name="opc_envio" id="opc_envio">
                        <option>A su domicilio en EE.UU.</option>
                        <option>Ofrecemos envios express al Ecuador en 3 dias laborables.</option>
                        <option>Venirlo a retirar personalmente en la oficina.</option>
                    </select>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Valor</label>
                        <input class="fs-input" type="number" name="valor" min="0" id="valor" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Abono</label>
                        <input class="fs-input" type="number" name="abono" min="0" id="abono"/>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Enviar a Ecuador a nombre de:</label>
                        <input class="fs-input" name="remitente" id="remitente"/>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Ciudad del remitente</label>
                        <input class="fs-input" name="ciudad_r" id="ciudad_r"/>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Provincia del remitente</label>
                        <input class="fs-input" name="provincia_r" id="provincia_r"/>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Telefono del remitente</label>
                        <input class="fs-input" name="telefono_r" id="telefono_r"/>
                    </div>


                </div>
            </fieldset>


            <div class="fs-button-group">
                <input class="fs-button" type="submit" name="btn_registro_imp">
            </div>

        </form>

        <div id="printButtonContainer" style="display: none; text-align: center; margin-top: 20px;">
            <button class="btn btn-primary" id="printRecordBtn">Imprimir Registro</button>
        </div>



    </div>

    <script>
document.getElementById('formPoderes').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("btn_registro_imp", "1");

    fetch('prueba_poblacion.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json()) // <--- CAMBIO CLAVE: Esperar JSON
    .then(data => { // <--- CAMBIO CLAVE: 'data' en lugar de 'response'
        console.log('Respuesta del servidor:', data);
        if (data.status === "success") { // <--- Verificar el 'status' del JSON
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: data.message, // <--- Usar data.message
                timer: 3000,
                showConfirmButton: false
            });
            this.reset();
            // Mostrar el contenedor del botón de imprimir
            document.getElementById('printButtonContainer').style.display = 'block';
            // Adjuntar el ID del nuevo registro al botón de imprimir
            document.getElementById('printRecordBtn').setAttribute('data-record-id', data.id); // <--- Guardar el ID

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message // <--- Usar data.message
            });
            document.getElementById('printButtonContainer').style.display = 'none'; // Ocultar si hay error
        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de red',
            text: 'No se pudo enviar el formulario. Intenta más tarde.'
        });
        document.getElementById('printButtonContainer').style.display = 'none'; // Ocultar si hay error
    });
});

// Event listener para el botón de imprimir
document.getElementById('printRecordBtn').addEventListener('click', function() {
    const recordId = this.getAttribute('data-record-id'); // Obtener el ID que guardamos
    if (recordId) {
        // Abrir la nueva página de impresión en una nueva pestaña
        window.open('imprimir_tramite.php?id=' + recordId, '_blank');
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'No se pudo obtener el ID del registro para imprimir. Por favor, intente guardar de nuevo.'
        });
    }
});
</script>


</body>

</html>

<script type="text/javascript">
    function buscar_datos() {
        buscador = $("#buscador").val();
        var parametros =
        {
            "buscar": "1",
            "buscador": buscador
        };
        $.ajax(
            {
                data: parametros,
                dataType: 'json',
                url: 'prueba_poblacion.php',
                type: 'post',
                error: function () { alert("Error"); },
                success: function (valores) {
                    $("#nombre").val(valores.nombre);
                    $("#apellido").val(valores.apellido);
                    $("#identificacion").val(valores.identificacion);
                    $("#telefono").val(valores.telefono);
                    $("#direccion").val(valores.direccion);
                    $("#estado").val(valores.estado);
                    $("#ciudad").val(valores.ciudad);
                    $("#postal").val(valores.postal);
                    $("#email").val(valores.email);
                    $("#departamento").val(valores.departamento);
                    $("#id_cliente").val(valores.id_cliente);
                   
                },


            }
        )

    }
</script>