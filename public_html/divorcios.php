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
</head>

<body>

    <nav class="navbar navbar-expand-lg" style="background-color: #e2e2e2;">
        <div class="container px-lg-5">
            <a class="navbar-brand" href="http://localhost/NotariaEc/Notaria_EC/public_html/menu.php">
                <img src="img\logo.png" alt="logo" width="150px">
            </a>
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <?php echo $variable_ses; ?>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="width: 100px; margin:0 auto;text-align: center">
        <p class="fs-2">Divorcios</p>
    </div>

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Nombre o Identificación"
                    aria-label="Nombre o Identificación" id="buscador" name="buscador">
                <input class="btn btn-outline-success" type="button" onclick="buscar_datos()" value="Buscar"></input>
            </form>
        </div>
    </nav>

    <div class="container">
        <form class="fs-form fs-layout__2-column" method="POST" action="" id="formDivorcios">
            <?php
            // Incluimos la conexión a la base de datos
            include("conexionbd.php");
            ?>
            <fieldset>
                <div class="fs-field">
                    <div class="">
                        <h3 class="" for="">1. Datos del Solicitante (Usted):</h3>
                    </div>
                    <input class="fs-input" type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $user_id; ?>" />
                    <input class="fs-input" type="hidden" id="id_cliente" name="id_cliente" />
                    
                    <label class="fs-label" for="identificacion">Identificación</label>
                    <input class="fs-input form-control" id="identificacion" name="identificacion" placeholder="identificación" required />
                    
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
                        <label class="fs-label" for="estado">Estado</label>
                        <input class="fs-input form-control" name="estado" id="estado" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="ciudad">Ciudad</label>
                        <input class="fs-input form-control" name="ciudad" id="ciudad" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="postal">Código Postal</label>
                        <input class="fs-input form-control" name="postal" id="postal" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="email">Email</label>
                        <input class="fs-input form-control" name="email" id="email" />
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="departamento">N° Departamento</label>
                        <input class="fs-input form-control" name="departamento" id="departamento" />
                    </div>
                </div>

                <div class="fs-field">
                    <div class="">
                        <h3 class="" for="">2. Datos del Trámite de Divorcio:</h3>
                    </div>
                    <div class="fs-field">
                        <label class="fs-label" for="tipo_divorcio_group">Tipo de Divorcio:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_divorcio" id="tipo_divorcio_controv" value="Controvertido" required>
                            <label class="form-check-label" for="tipo_divorcio_controv">
                                Controvertido
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="tipo_divorcio" id="tipo_divorcio_consens" value="Consensual" required>
                            <label class="form-check-label" for="tipo_divorcio_consens">
                                Consensual
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
                        <label class="fs-label" for="tiempo_separacion">Tiempo de Separación (si aplica)</label>
                        <input class="fs-input form-control" name="tiempo_separacion" id="tiempo_separacion" placeholder="Ej: 2 años, 6 meses" />
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
                        Swal.fire({
                            icon: 'info',
                            title: 'Cliente Encontrado',
                            text: 'Datos del cliente cargados exitosamente.'
                        });
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