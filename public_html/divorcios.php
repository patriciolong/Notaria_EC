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
    <title>Divorcios</title>
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
        <p class="fs-2" >Divorcios</p>
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
        <form class="fs-form fs-layout__2-column" method="POST" action="">
            <?php
            include("conexionbd.php");
            include("controlador_divorcios.php");
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
                    
                    <div class="fs-field">
                        <label class="fs-label" for="">Tipo de divorcio</label>
                        <div class="form-check">
                        <input class="form-check-input" type="hidden" id="check1" name="check1" value="0">
                        <input class="form-check-input" type="hidden" id="check2" name="check2" value="0">
                        <label class="form-check-label">Controvertido</label>
                            <input class="form-check-input" type="checkbox" id="check1" name="check1" value="1">
                        </div>
                        <div class="form-check">
                        <label class="form-check-label">Consensual</label>
                            <input class="form-check-input" type="checkbox" id="check2" name="check2" value="1">
                        </div>
                        
                    </div>
                    

                    <div class="fs-field">
                        <label class="fs-label"  for="">Conyuge: Nombres y apellidos</label>
                        <input class="fs-input" id="cn" name="cn" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label"  for="">Conyuge: Identificación</label>
                        <input class="fs-input" id="ci" name="ci" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label"  for="">Conyuge: Dirección</label>
                        <input class="fs-input" id="cd" name="cd" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label"  for="">Conyuge: Apartamento</label>
                        <input class="fs-input" id="ca" name="ca" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label"  for="">Conyuge: Ciudad</label>
                        <input class="fs-input" id="cc" name="cc" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label"  for="">Conyuge: Estado</label>
                        <input class="fs-input" id="ce" name="ce" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label"  for="">Conyuge: Codigo postal</label>
                        <input class="fs-input" id="ccp" name="ccp" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label"  for="">Conyuge: Teléfono</label>
                        <input class="fs-input" id="ct" name="ct" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label"  for="">Lugar de matrimonio</label>
                        <input class="fs-input" id="lm" name="lm" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label"  for="">Fecha de matrimonio</label>
                        <input class="fs-input" id="fm" name="fm" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label" for="">Está seáradp de su cunyugue?</label>
                        <div class="form-check">
                        <input class="form-check-input" type="hidden" id="check3" name="check3" value="0">
                        <input class="form-check-input" type="hidden" id="check4" name="check4" value="0">
                        <label class="form-check-label">Si</label>
                            <input class="form-check-input" type="checkbox" id="check3" name="check3" value="1">
                        </div>
                        <div class="form-check">
                        <label class="form-check-label">No</label>
                            <input class="form-check-input" type="checkbox" id="check4" name="check4" value="1">
                        </div>
                        
                    </div>

                    <div class="fs-field">
                        <label class="fs-label"  for="">Tiempo de separacion</label>
                        <input class="fs-input" id="ts" name="ts" />
                    </div>   
                    
                    <div class="fs-field">
                        <label class="fs-label" for="">Posee</label>
                        <div class="form-check">
                        <input class="form-check-input" type="hidden" id="check5" name="check5" value="0">
                        <input class="form-check-input" type="hidden" id="check6" name="check6" value="0">
                        <label class="form-check-label">Partida de matrimonio</label>
                            <input class="form-check-input" type="checkbox" id="check5" name="check5" value="1">
                        </div>
                        <div class="form-check">
                        <label class="form-check-label">Partida de nacimiento de los menores</label>
                            <input class="form-check-input" type="checkbox" id="check6" name="check6" value="1">
                        </div>                        
                    </div>                  
                    
                    <div class="fs-field">
                        <label class="fs-label" for="">Contacto en el Ecuador</label>
                        <input class="fs-input" name="cee" id="cee" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label" for="">Telefono del contacto</label>
                        <input class="fs-input" type="number" name="te" min="0" id="te" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label" for="">Observaciones</label>
                        <input class="fs-input" name="o" id="o" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label" for="">Honorarios</label>
                        <input class="fs-input" type="number" name="h" min="0" id="h" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="">Abono</label>
                        <input class="fs-input" type="number" name="a" min="0" id="a"/>
                    </div>
                   

                </div>
            </fieldset>


            <div class="fs-button-group">
                <input class="fs-button" type="submit" name="btn_registro_tra">
            </div>

        </form>


    </div>




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
                url: 'controlador_divorcios.php',
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