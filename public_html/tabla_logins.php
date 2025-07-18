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
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de usuarios</title>
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
    <style>
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #555;
            color: white;
        }
        .filtros {
            text-align: center;
            margin: 20px;
        }
        .filtros input {
            margin: 0 10px;
            padding: 5px;
        }
        #paginacion {
    margin-top: 20px;
}

#paginacion button {
    background-color: #f2f2f2;
    border: 1px solid #ccc;
    padding: 8px 12px;
    margin: 0 3px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
}

#paginacion button:hover {
    background-color: #ddd;
}

#paginacion button.active {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
}

#paginacion button:disabled {
    background-color: #eee;
    color: #999;
    cursor: not-allowed;
}
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

<h2 style="text-align:center;">Registro de Logins</h2>
<div class="filtros">
    <label for="filtroFecha">Filtrar por Fecha:</label>
    <input type="date" id="filtroFecha">

    <label for="filtroUsuario">Filtrar por Usuario:</label>
    <input type="text" id="filtroUsuario" placeholder="Escribe usuario">

    <button id="btnLimpiarFiltros">Limpiar Filtros</button> <!-- AQUI -->
</div>

<table id="tablaLogins">
    <thead>
        <tr>
            <th>ID Login</th>
            <th>Fecha y Hora</th>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Apellido</th>
        </tr>
    </thead>
    <tbody>
        <!-- Aquí se cargarán los datos -->
    </tbody>
</table>
<div id="contadorRegistros" style="text-align:center; margin: 20px; font-weight: bold;">
    Mostrando 0 registros
</div>
<div id="paginacion" style="text-align:center; margin: 20px;">
    <button id="btnAnterior">Anterior</button>
    <span id="numerosPaginas"></span>
    <button id="btnSiguiente">Siguiente</button>
</div>

<script>
let datosOriginales = [];
let datosFiltrados = [];
let registrosPorPagina = 10;
let paginaActual = 1;

document.addEventListener('DOMContentLoaded', function() {
    fetch('obtener_logins.php')
        .then(response => response.json())
        .then(data => {
            datosOriginales = data;
            datosFiltrados = data;
            mostrarDatos();
        })
        .catch(error => {
            console.error('Error al cargar los datos:', error);
        });

    document.getElementById('filtroFecha').addEventListener('input', filtrarDatos);
    document.getElementById('filtroUsuario').addEventListener('input', filtrarDatos);
    document.getElementById('btnLimpiarFiltros').addEventListener('click', limpiarFiltros);
    document.getElementById('btnAnterior').addEventListener('click', paginaAnterior);
    document.getElementById('btnSiguiente').addEventListener('click', paginaSiguiente);
});

function mostrarDatos() {
    const tbody = document.querySelector('#tablaLogins tbody');
    tbody.innerHTML = '';

    let inicio = (paginaActual - 1) * registrosPorPagina;
    let fin = inicio + registrosPorPagina;
    let datosPagina = datosFiltrados.slice(inicio, fin);

    if (datosPagina.length === 0) {
        const tr = document.createElement('tr');
        const td = document.createElement('td');
        td.colSpan = 5;
        td.textContent = 'No se encontraron resultados';
        td.style.fontWeight = 'bold';
        td.style.color = 'red';
        tr.appendChild(td);
        tbody.appendChild(tr);
    } else {
        datosPagina.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${row.id_login}</td>
                <td>${row.l_fecha_hora}</td>
                <td>${row.u_usuario}</td>
                <td>${row.u_nombre}</td>
                <td>${row.u_apellido}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    // Actualizar contador
    const contador = document.getElementById('contadorRegistros');
    contador.textContent = `Mostrando ${datosFiltrados.length} registro${datosFiltrados.length !== 1 ? 's' : ''}`;

    // Actualizar número de página
    document.getElementById('paginaActual').textContent = `Página ${paginaActual}`;

    // Desactivar botones de anterior/siguiente
    document.getElementById('btnAnterior').disabled = (paginaActual === 1);
    document.getElementById('btnSiguiente').disabled = (paginaActual >= Math.ceil(datosFiltrados.length / registrosPorPagina));

    // CREAR NÚMEROS DE PÁGINAS
    generarNumerosPaginas();
}
function generarNumerosPaginas() {
    const contenedor = document.getElementById('numerosPaginas');
    contenedor.innerHTML = '';

    let totalPaginas = Math.ceil(datosFiltrados.length / registrosPorPagina);

    for (let i = 1; i <= totalPaginas; i++) {
        const btnPagina = document.createElement('button');
        btnPagina.textContent = i;
        
        if (i === paginaActual) {
            btnPagina.classList.add('active');
        }

        btnPagina.addEventListener('click', function() {
            paginaActual = i;
            mostrarDatos();
        });

        contenedor.appendChild(btnPagina);
    }
}

function filtrarDatos() {
    const filtroFecha = document.getElementById('filtroFecha').value;
    const filtroUsuario = document.getElementById('filtroUsuario').value.toLowerCase();

    datosFiltrados = datosOriginales.filter(row => {
        let coincideFecha = true;
        let coincideUsuario = true;

        if (filtroFecha) {
            const fechaDelRegistro = row.l_fecha_hora.split(' ')[0];
            coincideFecha = (fechaDelRegistro === filtroFecha);
        }

        if (filtroUsuario) {
            coincideUsuario = row.u_usuario.toLowerCase().includes(filtroUsuario);
        }

        return coincideFecha && coincideUsuario;
    });

    paginaActual = 1; // Reiniciar a la primera página
    mostrarDatos();
}

function limpiarFiltros() {
    document.getElementById('filtroFecha').value = '';
    document.getElementById('filtroUsuario').value = '';
    datosFiltrados = datosOriginales;
    paginaActual = 1;
    mostrarDatos();
}

function paginaAnterior() {
    if (paginaActual > 1) {
        paginaActual--;
        mostrarDatos();
    }
}

function paginaSiguiente() {
    if (paginaActual < Math.ceil(datosFiltrados.length / registrosPorPagina)) {
        paginaActual++;
        mostrarDatos();
    }
}

</script>

</body>
</html>
