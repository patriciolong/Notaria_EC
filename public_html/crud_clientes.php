<?php
//seguridad de paginacion
session_start();
error_reporting(0);
$varsesion =$_SESSION['usuario'];
$variable_ses = $varsesion;
$user_oficina =$_SESSION['oficina_U'];

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Importar fuente Lato para el Navbar */
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap');

        /* Definición de variables de color (copiadas de estilos_menu.css para consistencia) */
        :root {
            --primary-color_menu: #004080; /* Azul oscuro y profesional para elementos principales */

            --primary-color: #004080; /* Azul oscuro y profesional */
            --secondary-color: #4A6572; /* Gris azulado complementario */
            --accent-color: #C0A16B; /* Dorado sutil para acentos */
            --text-light: #FFFFFF; /* Color de texto blanco puro */
            --text-dark: #333333; /* Color de texto oscuro general */
            --border-light: #E0E0E0; /* Borde claro para elementos como tarjetas */
        }

        /* --- Estilos de la Barra de Navegación (Navbar) --- */
        .custom-navbar { /* Usamos la clase personalizada */
            background-color: var(--primary-color_menu) !important; /* Fondo azul oscuro */
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
    color: var(--primary-color) !important; /* Texto blanco puro */
    font-weight: 700; /* Negrita */
    font-size: 1.15rem; /* Tamaño de fuente más grande */
    margin-right: 15px; /* Espacio antes del icono de flecha/menú */
    text-shadow: 1px 1px 3px rgba(0,0,0,0.4); /* Sombra de texto para mayor contraste */
    white-space: nowrap; /* Evita que el nombre de usuario se rompa en varias líneas */
    background-color: yellow;
    border-radius: 0.75rem;
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

        /* --- Estilos ADICIONALES para el Formulario de Registro (SOLO EL FORMULARIO) --- */
        .container {
            align-items: center; /* Centra el contenido horizontalmente */
        }

        .form-title {
            font-size: 2.5rem; /* Título más grande */
            font-weight: 700;
            color: var(--primary-color); /* Color del título */
            margin-bottom: 35px; /* Más espacio debajo del título */
            text-align: center;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.1); /* Sombra suave para el título */
            font-family: 'Lato', sans-serif;
        }

        .fs-form {
            background-color: #ffffff; /* Fondo blanco para el formulario */
            padding: 40px; /* Mayor padding interno */
            border-radius: 12px; /* Esquinas más redondeadas */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); /* Sombra más pronunciada */
            width: 100%;
            max-width: 700px; /* Ancho máximo para el formulario */
            display: grid; /* Usamos grid para un layout más flexible */
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* 2 columnas en pantallas grandes */
            gap: 25px; /* Espacio entre los campos */
            margin: auto;
        }

        .fs-field {
            margin-bottom: 0; /* Eliminamos el margin-bottom ya que el gap de grid lo maneja */
        }

        .fs-label {
            display: block; /* Asegura que la label esté en su propia línea */
            margin-bottom: 8px; /* Espacio entre label y input */
            font-weight: 600; /* Labels un poco más negritas */
            color: var(--secondary-color); /* Color de las labels */
            font-size: 1.05rem; /* Tamaño de fuente ligeramente mayor */
            font-family: 'Lato', sans-serif;
        }

        .fs-input {
            width: 100%;
            padding: 12px 15px; /* Padding interno de los inputs */
            border: 1px solid var(--border-light); /* Borde suave */
            border-radius: 8px; /* Bordes redondeados para los inputs */
            font-size: 1rem;
            color: var(--text-dark);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box; /* Incluye padding y border en el ancho total */
            font-family: 'Lato', sans-serif;
        }

        .fs-input:focus {
            border-color: var(--primary-color); /* Borde azul al enfocar */
            box-shadow: 0 0 0 3px rgba(0, 64, 128, 0.2); /* Sombra suave al enfocar */
            outline: none; /* Elimina el contorno por defecto del navegador */
        }

        /* Estilo para el grupo de botones (centrado y con espacio) */
        .fs-button-group {
            grid-column: 1 / -1; /* Ocupa todas las columnas disponibles en el grid */
            display: flex;
            justify-content: center; /* Centrar el botón */
            margin-top: 30px; /* Espacio superior para el botón */
        }

        .fs-button {
            background-color: var(--primary-color); /* Color de fondo del botón */
            color: var(--text-light); /* Color del texto del botón */
            padding: 15px 35px; /* Padding del botón */
            border: none;
            border-radius: 8px; /* Bordes redondeados */
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 64, 128, 0.3); /* Sombra para el botón */
            font-family: 'Lato', sans-serif;
        }

        .fs-button:hover {
            background-color: #003366; /* Un poco más oscuro al pasar el ratón */
            transform: translateY(-2px); /* Ligerísimo efecto de elevación */
            box-shadow: 0 6px 20px rgba(0, 64, 128, 0.4); /* Sombra más intensa al pasar el ratón */
        }

        /* Responsive adjustments for smaller screens */
        @media (max-width: 768px) {
            .fs-form {
                grid-template-columns: 1fr; /* Una columna en pantallas pequeñas */
                padding: 25px;
            }

            .form-title {
                font-size: 2rem;
            }

            .fs-button {
                width: 100%; /* Botón de ancho completo en móviles */
                padding: 12px 25px;
            }
        }
    </style>
</head>
<header>
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
    </nav></header>
<body>
    

    <div class="container">
        <h2 class="form-title">Registrar Cliente</h2>
        <form class="fs-form" action="register_controler.php" method="POST" id="clientesform">
        <?php
            include("conexionbd.php");
            // No incluyas 'register_controler.php' aquí si ya lo estás manejando con Fetch API.
            // Si lo incluyes, el código PHP se ejecutará en la carga inicial de la página,
            // lo que podría interferir con la lógica de envío asíncrono.
            // include("register_controler.php");
            ?>
            <div class="fs-field">
                <label class="fs-label" for="nombre">Nombre</label>
                <input class="fs-input" name="nombre" id="nombre" />
            </div>
            <div class="fs-field">
                <label class="fs-label" for="apellido">Apellido</label>
                <input class="fs-input" name="apellido" id="apellido" />
            </div>
            <div class="fs-field">
                <label class="fs-label" for="edad">Edad</label>
                <input class="fs-input" name="edad" id="edad" />
            </div>
            <div class="fs-field">
                <label class="fs-label" for="identificacion">Identificacion</label>
                <input class="fs-input" name="identificacion" id="identificacion" />
            </div>
            <div class="fs-field">
                <label class="fs-label" for="telefono">Telefono</label>
                <input class="fs-input" name="telefono" id="telefono" />
            </div>
            <div class="fs-field">
                <label class="fs-label" for="direccion">Direccion</label>
                <input class="fs-input" name="direccion" id="direccion" />
            </div>
            <div class="fs-field">
                <label class="fs-label" for="departamento">N° Departamento</label>
                <input class="fs-input"  name="departamento" id="departamento" />
            </div>
            <div class="fs-field">
                <label class="fs-label" for="ciudad">Ciudad</label>
                <input class="fs-input"  name="ciudad" id="ciudad" />
            </div>
            <div class="fs-field">
                <label class="fs-label" for="estado">Estado</label>
                <input class="fs-input"  name="estado" id="estado" />
            </div>
            <div class="fs-field">
                <label class="fs-label" for="postal">Codigo Postal</label>
                <input class="fs-input"  name="postal" id="postal" />
            </div>
            <div class="fs-field">
                <label class="fs-label" for="pais">Pais</label>
                <input class="fs-input"  name="pais" id="pais" />
            </div>
            
            
            
            <div class="fs-field">
                <label class="fs-label" for="email">Email</label>
                <input class="fs-input"  name="email" id="email" />
            </div>

            <div class="fs-field">
                <label class="fs-label" for="c_oficina">Oficina</label>
                <input class="fs-input"  name="c_oficina" id="c_oficina" value="<?php echo $user_oficina;?>" readonly/>

            </div>

            

            <div class="fs-button-group">
                <input class="fs-button" type="submit" name="btn_registro" value="Registrar Cliente" >
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script>
document.getElementById('clientesform').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("btn_registro", "1");

    fetch('register_controler.php', {
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

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message // <--- Usar data.message
            });

        }
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de red',
            text: 'No se pudo enviar el formulario. Intenta más tarde.'
        });

    });
});
</script>
</body>
</html>