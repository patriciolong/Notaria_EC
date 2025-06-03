<?php
//seguridad de paginacion
session_start();
error_reporting(0);
$varsesion =$_SESSION['usuario'];
$variable_ses = $varsesion;
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
    <title>Registro Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/register.css" rel="stylesheet" /> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <style>
        /* Importar fuente Lato para el Navbar */
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap');

        /* Definición de variables de color (copiadas de estilos_menu.css para consistencia) */
        :root {
            --primary-color: #004080; /* Azul oscuro y profesional */
            --secondary-color: #4A6572; /* Gris azulado complementario */
            --accent-color: #C0A16B; /* Dorado sutil para acentos */
            --text-light: #FFFFFF; /* Color de texto blanco puro */
            --text-dark: #333333; /* Color de texto oscuro general */
            --border-light: #E0E0E0; /* Borde claro para elementos como tarjetas */
        }

        /* --- Estilos de la Barra de Navegación (Navbar) --- */
        .custom-navbar { /* Usamos la clase personalizada */
            background-color: var(--primary-color) !important; /* Fondo azul oscuro */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25); /* Sombra más prominente para profundidad */
            padding: 0.8rem 0; /* Espaciado vertical para una altura elegante */
        }

        .custom-navbar .container {
            display: flex;
            justify-content: space-between; /* Logo a la izquierda, usuario a la derecha */
            align-items: center; /* Centrar verticalmente todos los elementos */
            flex-wrap: nowrap; /* Evita que los elementos se envuelvan a la siguiente línea */
        }

        .custom-navbar .navbar-brand {
            padding: 0;
            margin-right: 30px; /* Espacio a la derecha del logo */
            display: flex; /* Asegura que el logo se comporte bien */
            align-items: center;
        }

        .custom-navbar .navbar-brand img {
            /* Mantiene los colores originales del logo */
            width: 180px; /* Tamaño adaptado del logo */
            height: auto;
            transition: transform 0.3s ease;
        }

        .custom-navbar .navbar-brand img:hover {
            transform: scale(1.03); /* Ligerísimo efecto de escala al pasar el ratón */
        }

        /* Estilo para el nombre de usuario (texto en blanco) */
        .custom-navbar .user-name {
            color: var(--text-light) !important; /* Texto blanco puro */
            font-weight: 700; /* Negrita */
            font-size: 1.15rem; /* Tamaño de fuente más grande */
            margin-right: 15px; /* Espacio antes del icono de flecha/menú */
            text-shadow: 1px 1px 3px rgba(0,0,0,0.4); /* Sombra de texto para mayor contraste */
            white-space: nowrap; /* Evita que el nombre de usuario se rompa en varias líneas */
            font-family: 'Lato', sans-serif; /* Aplica la fuente Lato */
        }

        /* Estilo del menú desplegable del usuario */
        .custom-navbar .dropdown-menu {
            border: none;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25); /* Sombra prominente */
            border-radius: 0.75rem; /* Esquinas redondeadas */
            padding: 0.75rem 0;
            min-width: 180px; /* Ancho mínimo para el menú */
        }

        .custom-navbar .dropdown-item {
            color: var(--text-dark); /* Color de texto oscuro para los ítems */
            padding: 0.85rem 1.8rem; /* Espaciado interno */
            font-size: 1rem;
            transition: background-color 0.2s ease, color 0.2s ease;
            font-family: 'Lato', sans-serif; /* Aplica la fuente Lato */
        }

        .custom-navbar .dropdown-item:hover {
            background-color: var(--primary-color); /* Fondo azul oscuro al pasar el ratón */
            color: var(--text-light) !important; /* Texto blanco al pasar el ratón */
        }

        .custom-navbar .dropdown-divider {
            border-top: 1px solid var(--border-light); /* Divisor sutil */
            margin: 0.5rem 0;
        }

        /* Estilos para el botón de menú hamburguesa (responsive) */
        .custom-navbar .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.7) !important; /* Borde blanco semi-transparente */
            transition: border-color 0.3s ease;
        }

        .custom-navbar .navbar-toggler:hover {
            border-color: var(--accent-color) !important; /* Borde dorado al pasar el ratón */
        }

        .custom-navbar .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important; /* Icono blanco puro para contraste */
        }
    </style>
</head>

<body>
    <nav class="custom-navbar navbar navbar-expand-lg">
        <div class="container px-lg-5">
            <a class="navbar-brand" href="menu.php">
                <img src="img/logo.png" alt="logo"> </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle user-name" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $varsesion;?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                            <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="form-title">Registrar Cliente</h2>
        <form class="fs-form" action="registrar.php" method="POST">
            <fieldset>
                <div class="fs-field">
                    <label class="fs-label" for="">Nombre</label>
                    <input class="fs-input" name="nombre" />
                </div>
                <div class="fs-field">
                    <label class="fs-label" for="">Apellido</label>
                    <input class="fs-input" name="apellido" />
                </div>
                <div class="fs-field">
                    <label class="fs-label" for="">Identificacion</label>
                    <input class="fs-input" name="identificacion" />
                </div>
                <div class="fs-field">
                    <label class="fs-label" for="">Telefono</label>
                    <input class="fs-input" name="telefono" />
                </div>
                <div class="fs-field">
                    <label class="fs-label" for="">Direccion</label>
                    <input class="fs-input" name="direccion" />
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>