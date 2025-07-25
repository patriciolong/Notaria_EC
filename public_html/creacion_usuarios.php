<?php
session_start();
error_reporting(0);
$varsesion = $_SESSION['usuario'];
$user_rol = $_SESSION['rol'] ?? '';

if ($varsesion == null || $varsesion == '') {
    header("location:index.php");
    die();
}

// Check if the user has the 'Administrador' or 'Notario' role to access this page
if ($user_rol != 'Administrador') {
    // Redirect to an unauthorized page or menu.php with an error message
    header("location:menu.php?error=acceso_denegado");
    die();
}

// Rest of your creacion_usuarios.php code
// ...
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
        /* Custom Form Styles for Register and similar forms */
.tax-declaration-form { /* Renombramos para que sea más genérico si aplica a varios formularios */
    background-color: #f8f9fa; /* Light background for the form */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    margin-top: 30px;
    margin-bottom: 50px;
    max-width: 700px; /* Limita el ancho del formulario para mejor lectura */
    margin-left: auto;
    margin-right: auto;
}

.form-section {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 25px;
    margin-bottom: 30px;
    background-color: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.section-title {
    font-size: 1.75rem;
    color: var(--primary-color);
    margin-bottom: 25px;
    text-align: center;
    font-weight: 700;
    position: relative;
    padding-bottom: 10px;
}

.section-title::after {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 0;
    width: 60px;
    height: 3px;
    background-color: var(--accent-color);
    border-radius: 2px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.form-field {
    margin-bottom: 15px; /* Adjust spacing between fields */
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--secondary-color);
    font-size: 0.95rem;
}

.form-input,
.form-select,
.form-textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    font-size: 1rem;
    color: #495057;
    transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    background-color: #fdfdfd;
}

.form-input:focus,
.form-select:focus,
.form-textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(0, 64, 128, 0.25); /* Primary color with transparency */
    outline: none;
}

.form-textarea {
    min-height: 100px;
    resize: vertical;
}

.form-button-group {
    text-align: center;
    margin-top: 40px;
}

.submit-button {
    background-color: var(--primary-color);
    color: var(--text-light);
    padding: 15px 35px;
    border: none;
    border-radius: 8px;
    font-size: 1.2rem;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    box-shadow: 0 4px 10px rgba(0, 64, 128, 0.2);
}

.submit-button:hover {
    background-color: #003366; /* Slightly darker blue on hover */
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0, 64, 128, 0.3);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr; /* Single column layout on smaller screens */
    }
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

    <div style="widht: 100px; margin:0 auto;text-align: center">
        <p class="fs-2">Registro de Usuarios</p>
    </div>

    <div class="container">
        <form class="tax-declaration-form" method="POST" action="" id="formusuarios">
            <?php
            include("conexionbd.php");
            include("register_usuarios_controler.php");
            ?>
            <fieldset class="form-section">
                <legend class="section-title">Información del Usuario</legend>
                <div class="form-grid">
                    <div class="form-field">
                        <label class="form-label" for="nombre">Nombre</label>
                        <input class="form-input" id="nombre" name="nombre" type="text" required />
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="apellido">Apellido</label>
                        <input class="form-input" id="apellido" name="apellido" type="text" required />
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="usuario">Usuario</label>
                        <input class="form-input" id="usuario" name="usuario" type="text" required />
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="pass">Contraseña</label>
                        <input class="form-input" id="pass" name="pass" type="text" required />
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="rol">Rol</label>
                        <select class="form-select" id="rol" name="rol" required> 
                            <option value="Empleado">Empleado</option>
                            <option value="Administrador">Administrador</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="estado">Estado</label>
                        <select class="form-select" id="estado" name="estado" required> 
                            <option value="Activo">Activo</option>
                            <option value="Inactivo">Inactivo</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="ofi">Oficina</label>
                        <select class="form-select" id="ofi" name="ofi" required> 
                            <option value="Brooklyn">Brooklyn</option>
                            <option value="Spring Valley">Spring Valley</option>
                            <option value="New Jersey">New Jersey</option>
                            <option value="Ossining">Ossining</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <div class="form-button-group">
                <input class="submit-button" type="submit" name="btn_registro_user" value="Registrar Usuario">
            </div>

        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script>
document.getElementById('formusuarios').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("btn_registro_user", "1");

    fetch('register_usuarios_controler.php', {
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