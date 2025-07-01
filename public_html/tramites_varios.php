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
    <title>Tramites Varios</title>
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
        /* Custom Form Styles */
.tax-declaration-form {
    background-color: #f8f9fa; /* Light background for the form */
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    margin-top: 30px;
    margin-bottom: 50px;
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

/* Checkbox specific styles */
.checkbox-field {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px; /* Reduced margin for checkboxes within a group */
}

.checkbox-field .form-check-input {
    width: 20px;
    height: 20px;
    flex-shrink: 0; /* Prevent checkbox from shrinking */
    margin-top: 0; /* Reset default margin */
    border-radius: 4px; /* Slightly rounded corners for checkbox */
    transition: background-color 0.2s ease, border-color 0.2s ease;
}

.checkbox-field .form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.checkbox-field .form-check-label {
    margin-bottom: 0; /* Remove bottom margin for labels */
    font-weight: 600;
    color: var(--secondary-color);
    font-size: 0.95rem;
}

/* Grouping for multiple checkboxes */
.checkbox-group {
    padding-top: 5px; /* Add some padding above the group */
    /* Remove padding-bottom if not needed, as form-field already has margin-bottom */
}

/* Full width field for notes (if applicable, though not explicitly in tramites_varios.php) */
.form-field.full-width {
    grid-column: 1 / -1; /* Spans across all columns in the grid */
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
<div style="widht: 100px; margin:0 auto;text-align: center">
        <p class="fs-2">Tramites Varios</p>
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
        <form class="tax-declaration-form" method="POST" action="" id="formPoderes">
            <?php
            include("conexionbd.php");
            include("prueba_poblacion.php");
            ?>
            <fieldset class="form-section">
                <legend class="section-title">Información Personal</legend>
                <div class="form-grid">
                    <input class="form-input" type="hidden" id="id_usuario" name="id_usuario" placeholder="identificacion" />
                    <input class="form-input" type="hidden" id="id_cliente" name="id_cliente" placeholder="identificacion" />

                    <div class="form-field">
                        <label class="form-label" for="identificacion">Identificacion</label>
                        <input class="form-input" id="identificacion" name="identificacion" placeholder="identificacion" />
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="nombre">Nombres</label>
                        <input class="form-input" id="nombre" name="nombre" />
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="apellido">Apellidos</label>
                        <input class="form-input" id="apellido" name="apellido" />
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="telefono">Telefono</label>
                        <input class="form-input" name="telefono" id="telefono" />
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="direccion">Direccion</label>
                        <input class="form-input" name="direccion" id="direccion" />
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="estado">Estado</label>
                        <input class="form-input" name="estado" id="estado"/>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="ciudad">Ciudad</label>
                        <input class="form-input" name="ciudad" id="ciudad"/>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="postal">Codigo Postal</label>
                        <input class="form-input" name="postal" id="postal"/>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-input" name="email" id="email"/>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="departamento">N° Departamento</label>
                        <input class="form-input" name="departamento" id="departamento"/>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="oficina">Oficina</label>
                        <input class="form-input" name="oficina" id="oficina"/>
                    </div>
                </div>
            </fieldset>

            <fieldset class="form-section">
                <legend class="section-title">Detalles del Trámite</legend>
                <div class="form-grid">
                    <div class="form-field">
                        <label class="form-label" for="tipo_doc">Tipo de documento</label>
                        <select class="form-select" name="tipo_doc" id="tipo_doc">
                            <option>Elegir</option>
                            <option>Nacimiento</option>
                            <option>Matrimonio</option>
                            <option>Defuncion</option>
                            <option>Divorcio</option>
                            <option>Academicas</option>
                            <option>Carta de invitacion</option>
                            <option>Otros</option>
                        </select>
                    </div>
                    <div class="form-field checkbox-group">
                        <label class="form-label">Servicios</label>
                        <input class="form-check-input" type="hidden" id="check1" name="check1" value="0">
                        <input class="form-check-input" type="hidden" id="check2" name="check2" value="0">
                        <input class="form-check-input" type="hidden" id="check3" name="check3" value="0">
                        <input class="form-check-input" type="hidden" id="check4" name="check4" value="0">

                        <div class="checkbox-field">
                            <input class="form-check-input" type="checkbox" id="check1" name="check1" value="1">
                            <label class="form-check-label" for="check1">Traducciones</label>
                        </div>
                        <div class="checkbox-field">
                            <input class="form-check-input" type="checkbox" id="check2" name="check2" value="1">
                            <label class="form-check-label" for="check2">Notarizacion</label>
                        </div>
                        <div class="checkbox-field">
                            <input class="form-check-input" type="checkbox" id="check3" name="check3" value="1">
                            <label class="form-check-label" for="check3">Certificacion</label>
                        </div>
                        <div class="checkbox-field">
                            <input class="form-check-input" type="checkbox" id="check4" name="check4" value="1">
                            <label class="form-check-label" for="check4">Apostilla</label>
                        </div>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="motivo">Para uso en:</label>
                        <input class="form-input" id="motivo" name="motivo" />
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="opc_envio">Opcion de envio</label>
                        <select class="form-select" name="opc_envio" id="opc_envio">
                            <option>A su domicilio en EE.UU.</option>
                            <option>Ofrecemos envios express al Ecuador en 3 dias laborables.</option>
                            <option>Venirlo a retirar personalmente en la oficina.</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="valor">Valor</label>
                        <input class="form-input" type="number" name="valor" min="0" id="valor" />
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="abono">Abono</label>
                        <input class="form-input" type="number" name="abono" min="0" id="abono"/>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="remitente">Enviar a Ecuador a nombre de:</label>
                        <input class="form-input" name="remitente" id="remitente"/>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="ciudad_r">Ciudad del remitente</label>
                        <input class="form-input" name="ciudad_r" id="ciudad_r"/>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="provincia_r">Provincia del remitente</label>
                        <input class="form-input" name="provincia_r" id="provincia_r"/>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="telefono_r">Telefono del remitente</label>
                        <input class="form-input" name="telefono_r" id="telefono_r"/>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="telefono_r">Observaciones</label>
                        <input class="form-input" name="observaciones_t" id="observaciones_t"/>
                    </div>
                </div>
            </fieldset>


            <div class="form-button-group">
                <input class="submit-button" type="submit" name="btn_registro_imp" value="Guardar Trámite">
            </div>

        </form>

        <div id="printButtonContainer" style="display: none; text-align: center; margin-top: 20px;">
            <button class="btn btn-primary" id="printRecordBtn">Imprimir Registro</button>
        </div>


    </div>

    <script>
document.getElementById('formPoderes').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append("btn_registro_imp", "1");

    fetch('prueba_poblacion.php', {
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
        window.open('imprimir_tramite_varios.php?id=' + recordId, '_blank');
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
                url: 'prueba_poblacion.php',
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