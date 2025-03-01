<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link href="css/styles.css" rel="stylesheet" />
      <!-- Bootstrap core JS-->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

</head>
<body>


<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg" style="background-color: #e2e2e2;">
            <div class="container px-lg-5">
                <a class="navbar-brand" href="#!">
                    <img src="img\logo.png" alt="logo" width="150px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Barra de busqueda-->
        <nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
        <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Nombre o Identificación" aria-label="Nombre o Identificación" id="buscador" name="buscador">
        <input class="btn btn-outline-success" type="button" onclick="buscar_datos()" value="Buscar"></input>
      </form>  
      </div>
</nav>

<div class="container">
    <form class="form" action="">
        <label for="">Nombre</label>
        <input class="form" type="text" name="nombre" id="nombre">
        <label for="">Apellido</label>
        <input class="form" type="text" name="apellido" id="apellido">
        <label for="">Identificacion</label>
        <input class="form" type="text" name="identificacion" id="identificacion">
    </form>

</div>
    



</body>
</html>

<script type="text/javascript">
function buscar_datos() {
    buscador=$("#buscador").val();
    var parametros =
    {
        "buscar":"1",
        "buscador":buscador
    };
    $.ajax(
        {
            data:parametros,
            dataType:'json',
            url:'prueba_poblacion.php',
            type:'post',
            error:function()
            {alert("Error");},
            success:function (valores) 
            {
            $("#nombre").val(valores.nombre);    
            $("#apellido").val(valores.apellido);    
            $("#identificacion").val(valores.identificacion);    
            }

        }
    )
    
}
</script>