<?php
//seguridad de paginacion
session_start(); // <--- MUY IMPORTANTE QUE ESTÉ AL PRINCIPIO
error_reporting(0);
$varsesion =$_SESSION['usuario'];
$variable_ses = $varsesion;
$user_rol = $_SESSION['rol'] ?? ''; // <-- Aquí se obtiene el rol

// *** DEPURACIÓN EN MENU.PHP: Muestra el rol aquí ***
//echo "DEBUG MENU - Rol de la sesión: '" . $user_rol . "'<br>";
//echo "DEBUG MENU - Usuario de la sesión: " . $variable_ses . "<br>";

if ($varsesion==null || $varsesion=='') {
    header("location:index.php");
    die;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link href="css/styles.css" rel="stylesheet" />
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
        <input class="form-control me-2" type="search" placeholder="Nombre o Identificación" aria-label="Nombre o Identificación">
        <button class="btn btn-outline-success" type="submit">Buscar</button>
      </form>  
      </div>
</nav>

<div class="container text-center">
  <div class="row">
    <div class="col"><h4>Identificación </h4></div>
    <div class="col"><h4>Nombres<h4></div>
    <div class="col"><h4>Apellidos<h4></div>
    <div class="col"><h4>Saldo Abonado<h4></div>
    <div class="col"><h4>Saldo pendiente<h4></div>
    <div class="col"><h4>Acciones<h4></div>
  </div>
  <div class="row">
    <div class="col">01500308732</div>
    <div class="col">Juan Felipe</div>
    <div class="col">Carangui Cuesta</div>
    <div class="col">$ 100</div>
    <div class="col">$ 100</div>
    <div class="col">
    <div class="dropdown">
    <div class="btn-group">
        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Acciones
        </button>
        <ul class="dropdown-menu">              
            <li><a class="dropdown-item" href="#">Abonar a deuda</a></li>
            <li><a class="dropdown-item" href="#">Cancelar deuda</a></li>
        </ul>
        </div>
    </div>
  </div>
</div>

      <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>



</body>
</html>