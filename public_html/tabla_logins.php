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
        
    </style>


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
