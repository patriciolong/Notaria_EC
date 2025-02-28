<?php
//seguridad de paginacion 
session_start();
error_reporting(0);
$varsesion = $_SESSION['usuario'];
if ($varsesion == null || $varsesion = '') {
    header("location:index.php");
    die;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Heroic Features - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/register.css" rel="stylesheet" />
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg" style="background-color: #e2e2e2;">
        <div class="container px-lg-5">
            <a class="navbar-brand" href="#!">
                <img src="img\logo.png" alt="logo" width="150px">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="cerrar_sesion.php">Cerrar
                            Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="py-5">
        <div class="container px-lg-5">
            <p class="fs-4">Crear nuevo cliente</p>

        </div>
        </div>
        </div>
    </header>
    <!-- Page Content-->
    <div class="container">
        <form class="fs-form fs-layout__2-column" method="POST" >
        <?php
        include("conexionbd.php");
        include("register_controler.php");
        ?>
            <fieldset >
                <div class="fs-field">
                    <label class="fs-label" for="">Identificacion</label>
                    <input class="fs-input"  name="identificacion" placeholder="identificacion"  />
                </div>
            </fieldset>
            <fieldset>
                <div class="fs-field">
                    <label class="fs-label" for="">Nombres</label>
                    <input class="fs-input"  name="nombres"  />
                </div>
                <div class="fs-field">
                    <label class="fs-label" for="">Apellidos</label>
                    <input class="fs-input"  name="apellidos"   />
                </div>
            </fieldset>
            <fieldset>
                <div class="fs-field">
                    <label class="fs-label" for="">Telefono</label>
                    <input class="fs-input"  name="telefono"  />
                </div>
                <div class="fs-field">
                    <label class="fs-label" for="">Edad</label>
                    <input class="fs-input"  name="edad"   />
                </div>
            </fieldset>
            <fieldset>
                <div class="fs-field">
                    <label class="fs-label" for="">Direccion</label>
                    <input class="fs-input"  name="direccion" />
                </div>
                <div class="fs-field">
                    <label class="fs-label" for="">Pais</label>
                    <input class="fs-input"  name="pais" />
                </div>
                <div class="fs-field">
                    <label class="fs-label" for="">Estado</label>
                    <input class="fs-input"  name="estado" />
                </div>
                <div class="fs-field">
                    <label class="fs-label" for="">Ciudad</label>
                    <input class="fs-input"  name="ciudad" />
                </div>
                <div class="fs-field">
                    <label class="fs-label" for="">Codigo Postal</label>
                    <input class="fs-input"  name="postal" />
                </div>
                <div class="fs-field">
                    <label class="fs-label" for="">Email</label>
                    <input class="fs-input"  name="email" />
                </div>
                <div class="fs-field">
                    <label class="fs-label" for="">N° Departamento</label>
                    <input class="fs-input"  name="departamento" />
                </div>
            </fieldset>

                <div class="fs-button-group">
    <input class="fs-button" type="submit" name="btn_registro" >
  </div>

        </form>

        
    </div>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>