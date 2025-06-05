<?php
//seguridad de paginacion
session_start();
error_reporting(0);
$varsesion = $_SESSION['usuario'];
$variable_ses = $varsesion;
if ($varsesion == null || $varsesion = '') {
    header("location:index.php");
    die;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Declaración de Impuestos</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
        <style>
        /* Importar fuente Lato para el Navbar */
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap');

        /* Definición de variables de color (copiadas de estilos_menu.css para consistencia) */
        :root {
            --primary-color: #004080; /* Azul oscuro y profesional */
            --secondary-color: #4A6572; /* Gris azulado complementario */
            --accent-color: #C0A16B; /* Dorado sutil para acentos */
            --text-light: #FFFFFF; /* Color de texto blanco puro */
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
            /* Si el logo sigue perdiéndose, intente quitar el comentario de la siguiente línea
               o ajuste el valor de 'brightness' si su logo es muy oscuro */
            /* filter: brightness(1.2); */ /* Un ligero aumento de brillo si es necesario */
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

        /* Custom styles for the form */
        .form-section {
            background-color: #f8f9fa; /* Light background for the form area */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            margin-bottom: 30px; /* Added margin for bottom */
        }

        .form-section h3 {
            color: var(--primary-color);
            margin-bottom: 25px;
            font-weight: 700;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .form-control, .form-select, textarea {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 10px 15px;
            font-size: 1rem;
            width: 100%; /* Ensure full width for textareas */
        }

        .form-control:focus, .form-select:focus, textarea:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 64, 128, 0.25);
        }

        .form-check-label {
            margin-left: 5px;
            color: #333;
        }

        .btn-submit-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--text-light);
            padding: 12px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
            width: 100%; /* Full width for the button */
        }

        .btn-submit-custom:hover {
            background-color: #003366; /* Slightly darker blue on hover */
            border-color: #003366;
            transform: translateY(-2px); /* Slight lift effect */
            color: var(--text-light);
        }

        /* Adjust button container for alignment */
        .button-container {
            text-align: center;
            margin-top: 30px;
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

    <div class="container text-center mt-4">
        <h2 class="fs-2 fw-bold text-primary">Declaración de Impuestos</h2>
    </div>

    <nav class="navbar bg-light mb-4"> <div class="container-fluid">
            <form class="d-flex w-100" role="search">
                <input class="form-control me-2" type="search" placeholder="Nombre o Identificación"
                    aria-label="Nombre o Identificación" id="buscador" name="buscador">
                <input class="btn btn-primary" type="button" onclick="buscar_datos()" value="Buscar"></input>
            </form>
        </div>
    </nav>


    <div class="container form-section">
        <h3 class="mb-4">Registro de Declaración de Impuestos</h3>
        <form method="POST" action="" id="formPoderes">
            <?php
            include("conexionbd.php");
            include("declaracion_impu_controller.php");
            ?>
            <input type="hidden" id="id_usuario" name="id_usuario" />
            <input type="hidden" id="id_cliente" name="id_cliente" />

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="identificacion" class="form-label">Identificación</label>
                        <input type="text" class="form-control" id="identificacion" name="identificacion" placeholder="Identificación" />
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" />
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" />
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" id="telefono" />
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" name="direccion" id="direccion" />
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <input type="text" class="form-control" name="estado" id="estado" />
                    </div>
                    <div class="mb-3">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <input type="text" class="form-control" name="ciudad" id="ciudad" />
                    </div>
                    <div class="mb-3">
                        <label for="postal" class="form-label">Código Postal</label>
                        <input type="text" class="form-control" name="postal" id="postal" />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" />
                    </div>
                    <div class="mb-3">
                        <label for="departamento" class="form-label">N° Departamento</label>
                        <input type="text" class="form-control" name="departamento" id="departamento" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fechaim" class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fechaim" id="fechaim" />
                    </div>
                    <div class="mb-3 form-check">
                        <input type="hidden" name="check1" value="0"> <input class="form-check-input" type="checkbox" id="check1" name="check1" value="1">
                        <label class="form-check-label" for="check1">Aplicación Itin</label>
                    </div>
                    <div class="mb-3">
                        <label for="fechaeeuu" class="form-label">Fecha de Ingreso a EEUU</label>
                        <input type="date" class="form-control" name="fechaeeuu" id="fechaeeuu" />
                    </div>
                    <div class="mb-3">
                        <label for="numitin" class="form-label">Numero de Itin o Social</label>
                        <input type="text" class="form-control" name="numitin" id="numitin" />
                    </div>
                    <div class="mb-3">
                        <label for="estcivil" class="form-label">Estado Civil</label>
                        <select class="form-select" name="estcivil" id="estcivil">
                            <option>Elegir</option>
                            <option>Soltero(A)</option>
                            <option>Casados Juntos</option>
                            <option>Cabeza de Familia</option>
                            <option>Casados Separados</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="profesion" class="form-label">Profesion</label>
                        <input type="text" class="form-control" name="profesion" id="profesion" />
                    </div>
                    <div class="mb-3">
                        <label for="dependentes" class="form-label">Numero Dependentes</label>
                        <input type="number" class="form-control" name="dependentes" id="dependentes" />
                    </div>
                    <div class="mb-3">
                        <label for="metpago" class="form-label">Metodo de Pago</label>
                        <select class="form-select" name="metpago" id="metpago">
                            <option>Elegir</option>
                            <option>W2</option>
                            <option>1099</option>
                            <option>CASH</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="banco" class="form-label">Banco</label>
                        <input type="text" class="form-control" name="banco" id="banco" />
                    </div>
                    <div class="mb-3">
                        <label for="ncuenta" class="form-label">Numero de Cuenta</label>
                        <input type="number" class="form-control" name="ncuenta" id="ncuenta" />
                    </div>
                    <div class="mb-3">
                        <label for="nruta" class="form-label">Numero de Ruta</label>
                        <input type="number" class="form-control" name="nruta" id="nruta" />
                    </div>
                    <div class="mb-3">
                        <label for="notas" class="form-label">Notas</label>
                        <textarea class="form-control" name="notas" id="notas" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="button-container">
                <button type="submit" class="btn btn-submit-custom" name="btn_registro_imp">Registrar Declaración</button>
            </div>

        </form>

        <div id="printButtonContainer" style="display: none; text-align: center; margin-top: 20px;">
            <button class="btn btn-success" id="printRecordBtn">Imprimir Registro</button>
        </div>
    </div>


    <script>
document.getElementById('formPoderes').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("btn_registro_imp", "1");

    fetch('declaracion_impu_controller.php', {
        method: 'POST',
        body: formData
    })
    .then(res => {
        if (!res.ok) {
            // If response is not OK, try to read it as text for more info
            return res.text().then(text => { throw new Error(text); });
        }
        return res.json(); // <--- CAMBIO CLAVE: Esperar JSON
    })
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
        window.open('imprimir_declaracion_impuestos.php?id=' + recordId, '_blank');
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
                url: 'declaracion_impu_controller.php',
                type: 'post',
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("AJAX Error: " + textStatus, errorThrown);
                    alert("Error al buscar datos: " + textStatus);
                },
                success: function (valores) {
                    if (valores) { // Check if 'valores' is not null or empty
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
                    } else {
                        // Optionally, clear fields if no data is found
                        $("#nombre").val('');
                        $("#apellido").val('');
                        $("#identificacion").val('');
                        $("#telefono").val('');
                        $("#direccion").val('');
                        $("#estado").val('');
                        $("#ciudad").val('');
                        $("#postal").val('');
                        $("#email").val('');
                        $("#departamento").val('');
                        $("#id_cliente").val('');
                        Swal.fire({
                            icon: 'info',
                            title: 'No encontrado',
                            text: 'No se encontraron datos para la búsqueda.'
                        });
                    }
                },
            }
        )
    }
</script>