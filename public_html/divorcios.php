<?php
// seguridad de paginacion
session_start();
error_reporting(0); // Desactivar la visualización de errores en producción
$varsesion = $_SESSION['usuario'];
$variable_ses = $varsesion;

// Redirigir si la sesión no está activa
if ($varsesion == null || $varsesion == '') {
    header("location:index.php");
    die;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Divorcios</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/tram_varis.css" rel="stylesheet" /> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script> <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <style>
        /* Importar fuente Lato para el Navbar */
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap');

        /* Definición de variables de color (copiadas de estilos_menu.css para consistencia) */
        :root {
            --primary-color_menu: #004080; /* Azul oscuro y profesional para elementos principales */
            --primary-color: #004080; /* Azul oscuro y profesional */
            --secondary-color: #4A6572; /* Gris azulado complementario */
            --accent-color: #C0A16B; /* Dorado sutil para acentos */
            --text-light: #FFFFFF; /* Color de texto blanco puro */
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

/* Checkbox specific styles (though not explicitly used in this form) */
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
}

/* Full width field for notes (if applicable) */
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

<div class="container mt-4">
    <p class="display-4 fw-bold text-center" style="color: #004080;">Divorcios</p>
</div>

<!-- Título pequeño encima de la barra de búsqueda -->
<div class="container mt-4">
    <p class="text-center mb-2" style="font-size: 1.1rem; color: #004080; font-weight: 600;">Buscar clientes</p>
</div>

<nav class="navbar bg-body-tertiary">
    <div class="container-fluid justify-content-center">
        <form class="d-flex w-100" role="search" style="max-width:700px; margin:auto;">
            <input class="form-control me-2 w-75" type="search" placeholder="Nombre Telefono o Identificación"
                aria-label="Nombre o Identificación" id="buscador" name="buscador">
            <input class="btn btn-outline-success" type="button" onclick="buscar_datos()" value="Buscar">
        </form>
    </div>
</nav>

    <div class="container">
    <form class="tax-declaration-form" method="POST" action="" id="formDivorcios">
            <?php
            // Incluimos la conexión a la base de datos
            include("conexionbd.php");
            ?>
           <fieldset class="form-section">
           <legend class="section-title">1. Información Personal del Cliente</legend>
           <div class="form-grid">
                    
                    <input class="fs-input" type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $user_id; ?>" />
                    <input class="fs-input" type="hidden" id="id_cliente" name="id_cliente" />
                    
                    <div class="fs-field">
                        <label class="fs-label" for="identificacion">Identificación</label>
                        <input class="fs-input form-control" id="identificacion" name="identificacion" placeholder="" required />
                    </div>
                        
                    <div class="fs-field">
                        <label class="fs-label" for="nombre">Nombres</label>
                        <input class="fs-input form-control" id="nombre" name="nombre" required />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="apellido">Apellidos</label>
                        <input class="fs-input form-control" id="apellido" name="apellido" required />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="telefono">Teléfono</label>
                        <input class="fs-input form-control" name="telefono" id="telefono" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="direccion">Dirección</label>
                        <input class="fs-input form-control" name="direccion" id="direccion" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="departamento">N° Departamento</label>
                        <input class="fs-input form-control" name="departamento" id="departamento" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="ciudad">Ciudad</label>
                        <input class="fs-input form-control" name="ciudad" id="ciudad" />
                    </div>



                    <div class="fs-field">
                        <label class="fs-label" for="estado">Estado</label>
                        <input class="fs-input form-control" name="estado" id="estado" />
                    </div>
                   
                    <div class="fs-field">
                        <label class="fs-label" for="postal">Código Postal</label>
                        <input class="fs-input form-control" name="postal" id="postal" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="email">Email</label>
                        <input class="fs-input form-control" name="email" id="email" />
                    </div>
                    
                    <div class="form-field">
                        <label class="form-label" for="oficina">Oficina</label>
                        <input class="form-input" name="oficina" id="oficina"/>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="fecha">Fecha</label>
                        <input class="fs-input form-control" type="date" name="fecha" id="fecha" />
                    </div>
                </div>
                
                <legend class="section-title">2. Información del Cónyuge</legend>
                <div class="form-grid">
                    <div class="fs-field">
                        <label class="fs-label" for="tipo_divorcio_group">Tipo de Divorcio:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_divorcio" id="tipo_divorcio_controv" value="Controvertido" required>
                            <label class="form-check-label" for="tipo_divorcio_controv">
                                Causal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_divorcio" id="tipo_divorcio_consens" value="Consensual" required>
                            <label class="form-check-label" for="tipo_divorcio_consens">
                                Consensual
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_divorcio" id="tipo_divorcio_not" value="Notarial" required>
                            <label class="form-check-label" for="tipo_divorcio_not">
                                Notarial
                            </label>
                        </div>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label">¿Está separado de su cónyuge?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="esta_separado" id="separado_si" value="1">
                            <label class="form-check-label" for="separado_si">
                                Sí
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="esta_separado" id="separado_no" value="0" checked>
                            <label class="form-check-label" for="separado_no">
                                No
                            </label>
                        </div>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label">¿Existen Hijos Menores de Edad?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="hijos" id="hijos_si" value="1">
                            <label class="form-check-label" for="hijos_si">
                                Sí
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="hijos" id="hijos_no" value="0" checked>
                            <label class="form-check-label" for="hijos_no">
                                No
                            </label>
                        </div>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label">¿Posee los siguientes documentos?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="posee_partida_matrimonio" id="posee_partida_matrimonio" value="1">
                            <label class="form-check-label" for="posee_partida_matrimonio">
                                Partida de Matrimonio
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="posee_partida_nacimiento_menores" id="posee_partida_nacimiento_menores" value="1">
                            <label class="form-check-label" for="posee_partida_nacimiento_menores">
                                Partida de Nacimiento de los menores
                            </label>
                        </div>
                    </div>

                    <div class="fs-field">
                        <label class="fs-label" for="nombre_conyugue">Nombre del Cónyuge</label>
                        <input class="fs-input form-control" name="nombre_conyugue" id="nombre_conyugue" required />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="identificacion_conyugue">Identificación del Cónyuge</label>
                        <input class="fs-input form-control" name="identificacion_conyugue" id="identificacion_conyugue" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="direccion_conyugue">Dirección del Cónyuge</label>
                        <input class="fs-input form-control" name="direccion_conyugue" id="direccion_conyugue" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="apartamento_conyugue">Apartamento del Cónyuge</label>
                        <input class="fs-input form-control" name="apartamento_conyugue" id="apartamento_conyugue" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="ciudad_conyugue">Ciudad del Cónyuge</label>
                        <input class="fs-input form-control" name="ciudad_conyugue" id="ciudad_conyugue" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="estado_conyugue">Estado del Cónyuge</label>
                        <input class="fs-input form-control" name="estado_conyugue" id="estado_conyugue" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="postal_conyugue">Código Postal del Cónyuge</label>
                        <input class="fs-input form-control" name="postal_conyugue" id="postal_conyugue" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="telefono_conyugue">Teléfono del Cónyuge</label>
                        <input class="fs-input form-control" name="telefono_conyugue" id="telefono_conyugue" />
                    </div>

                    <div class="fs-field">
                        <label class="fs-label" for="lugar_matrimonio">Lugar de Matrimonio</label>
                        <input class="fs-input form-control" name="lugar_matrimonio" id="lugar_matrimonio" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="fecha_matrimonio">Fecha de Matrimonio</label>
                        <input class="fs-input form-control" type="date" name="fecha_matrimonio" id="fecha_matrimonio" />
                    </div>

                   
                    
                    <div class="fs-field">
                        <label class="fs-label" for="tiempo_separacion">Tiempo de Separación (si aplica)</label>
                        <input class="fs-input form-control" name="tiempo_separacion" id="tiempo_separacion" placeholder="Ej: 2 años, 6 meses" />
                    </div>

                    
                    <div class="fs-field">
                        <label class="fs-label" for="motivo">Registre el motivo del divorcio:</label>
                        <textarea class="fs-input form-control" name="motivo" id="motivo" rows="3"></textarea>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="con_quien_vive">Hijos a Cargo de:</label>
                        <textarea class="fs-input form-control" name="con_quien_vive" id="con_quien_vive" rows="3"></textarea>
                    </div>

                    

                    <div class="fs-field">
                        <label class="fs-label" for="contacto_ecuador">Contacto en Ecuador</label>
                        <input class="fs-input form-control" name="contacto_ecuador" id="contacto_ecuador" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="telefono_contacto_ecuador">Teléfono del Contacto en Ecuador</label>
                        <input class="fs-input form-control" name="telefono_contacto_ecuador" id="telefono_contacto_ecuador" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="observaciones">Observaciones</label>
                        <textarea class="fs-input form-control" name="observaciones" id="observaciones" rows="3"></textarea>
                    </div>

                    <div class="fs-field">
                        <label class="fs-label" for="honorarios">Honorarios ($)</label>
                        <input class="fs-input form-control" type="number" name="honorarios" min="0" step="0.01" id="honorarios" required />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="abono">Abono ($)</label>
                        <input class="fs-input form-control" type="number" name="abono" min="0" step="0.01" id="abono" />
                    </div>
                </div>
                </fieldset>

            <div class="fs-button-group">
                <input class="fs-button btn btn-primary" type="submit" name="btn_registro_divorcio" value="Registrar Divorcio">
            </div>
        </form>

        <div id="printButtonContainer" style="display: none; text-align: center; margin-top: 20px;">
            <button class="btn btn-info" id="printRecordBtn">Imprimir Registro de Divorcio</button>
        </div>
    </div>

    <script>
        // Script para el envío del formulario de Divorcios
        document.getElementById('formDivorcios').addEventListener('submit', function(e) {
            e.preventDefault(); // Evitar el envío normal del formulario

            const formData = new FormData(this);
            formData.append("btn_registro_divorcio", "1"); // Indicador para el controlador

            // Deshabilitar el botón para evitar envíos dobles
            const submitButton = document.querySelector('input[name="btn_registro_divorcio"]');
            submitButton.disabled = true;

            fetch('divorcios_controller.php', { // Apunta al nuevo controlador
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Respuesta del servidor:', data);
                    if (data.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: data.message,
                            timer: 3000,
                            showConfirmButton: false
                            
                        });
                        this.reset(); // Limpiar el formulario
                        document.getElementById('printButtonContainer').style.display = 'block';
                        document.getElementById('printRecordBtn').setAttribute('data-record-id', data.id);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message
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
                })
                .finally(() => {
                    submitButton.disabled = false; // Habilitar el botón de nuevo
                });
        });

        // Event listener para el botón de imprimir
        document.getElementById('printRecordBtn').addEventListener('click', function() {
            const recordId = this.getAttribute('data-record-id'); // Obtener el ID que guardamos
            if (recordId) {
                // Abrir la nueva página de impresión en una nueva pestaña
                window.open('generar_pdf_divorcio.php?id=' + recordId, '_blank'); // Asume un imprimir_divorcio.php
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'No se pudo obtener el ID del registro para imprimir. Por favor, intente guardar de nuevo.'
                });
            }
        });
    </script>

    <script type="text/javascript">
        function buscar_datos() {
            buscador = $("#buscador").val();
            var parametros = {
                "buscar": "1",
                "buscador": buscador
            };
            $.ajax({
                data: parametros,
                dataType: 'json',
                url: 'poderes_controller.php', // O el controlador que uses para buscar clientes genéricos
                type: 'post',
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de búsqueda',
                        text: 'No se pudo conectar para buscar el cliente.'
                    });
                },
                success: function(valores) {
                    if (valores.existe === "1") {
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
                        /*Swal.fire({
                            icon: 'info',
                            title: 'Cliente Encontrado',
                            text: 'Datos del cliente cargados exitosamente.'
                        });*/
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Cliente No Encontrado',
                            text: 'La identificación no se encontró en la base de datos de clientes. Por favor, ingrese los datos manualmente.'
                        });
                        // Opcional: Limpiar campos si no se encuentra
                        $("#id_cliente").val("");
                        $("#nombre").val("");
                        $("#apellido").val("");
                        $("#telefono").val("");
                        $("#direccion").val("");
                        $("#estado").val("");
                        $("#ciudad").val("");
                        $("#postal").val("");
                        $("#email").val("");
                        $("#departamento").val("");
                    }
                },
            });
        }
    </script>

</body>

</html>