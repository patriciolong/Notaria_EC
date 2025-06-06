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
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Notaria Ecuador</title>
        <link rel="icon" type="image/x-xicon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/estilos_menu.css" rel="stylesheet" />
    </head>
    <body>
        <nav class="custom-navbar navbar navbar-expand-lg">
            <div class="container px-lg-5">
                <a class="navbar-brand" href="menu.php">
                    <img src="img\logo.png" alt="logo"> </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-name" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $variable_ses;?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                                <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <header class="py-5">
            <div class="container px-lg-5">
                        <p class="fs-4">Porfavor seleccione el tramite a realizar</p>
                    </div>
                </div>
            </div>
        </header>
        <section class="pt-4">
            <div class="container px-lg-5">
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
                    <?php if ($user_rol == 'Administrador'): ?>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                            <a href="tabla_logins.php" class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-file-text"></i></a>
                                <h2 class="fs-4 fw-bold">Reporte ingresos de usuarios</h2>

                                <p class="mb-0"></p>


                            </div>
                        </div>
                    </div>
                     <?php endif; ?>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                            <a href="dashboard_plantillas.php" class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-file-text"></i></a>
                                <h2 class="fs-4 fw-bold">Plantillas</h2>

                                <p class="mb-0"></p>


                            </div>
                        </div>
                    </div>
                    <?php if ($user_rol == 'Administrador'): ?>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                            <a href="creacion_usuarios.php" class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-file-text"></i></a>
                                <h2 class="fs-4 fw-bold">Registrar Usuario</h2>

                                <p class="mb-0"></p>


                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if ($user_rol == 'Administrador'): ?>
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card bg-light border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                            <a href="listado_usuarios.php" class="feature bg-primary bg-gradient text-white rounded-3 mb-4 mt-n4"><i class="bi bi-file-text"></i></a>
                                <h2 class="fs-4 fw-bold">Listado de Usuarios</h2>

                                <p class="mb-0"></p>


                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>