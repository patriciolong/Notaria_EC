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
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Notaria Ecuador</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
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
        <!-- Header-->
        <header class="py-5">
            <div class="container px-lg-5">
                        <p class="fs-4">Porfavor seleccione el tramite a realizar</p>
                    </div>
                </div>
            </div>
        </header>
        <!-- Page Content-->
        <section class="pt-4">
            <div class="container px-lg-5">
                <!-- Page Features-->
                <div class="row gx-lg-5">
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <a href="clientes.php" type="button"  class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i  class="bi bi-person-fill"></i></a>
                                <h2 class="fs-4 fw-bold">Clientes</h2>
                                <p class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <a href="tramites_varios.php" class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-file-text"></i></a>
                                <h2 class="fs-4 fw-bold">Tramites Varios</h2>
                                <p class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                            <a href="declaracion_impuestos.php" class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-file-text"></i></a>
                                <h2 class="fs-4 fw-bold">Declaracion de impuestos</h2>
                                <p class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <a href="poderes.php" class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-file-text"></i></a>
                                    <h2 class="fs-4 fw-bold">Poderes</h2>

                                    <p class="mb-0"></p>


                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <a  href="divorcios.php" class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-file-zip"></i></a>
                                    <h2 class="fs-4 fw-bold">Divorcios</h2>
                                    <p class="mb-0"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                            <a href="tabla_logins.php" class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-file-text"></i></a>
                                <h2 class="fs-4 fw-bold">Reporte ingresos de usuarios</h2>

                                <p class="mb-0"></p>


                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                            <a href="dashboard_plantillas.php" class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-file-text"></i></a>
                                <h2 class="fs-4 fw-bold">Plantillas</h2>

                                <p class="mb-0"></p>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
