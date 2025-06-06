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
<?php
include 'conexionbd.php'; // Include your database connection file

$user = null; // Inicializa $user a null

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Si la solicitud es POST, obtenemos el ID del formulario POST
    $id = $_POST['id_usuario'] ?? null;
    $nombre = $_POST['u_nombre'];
    $apellido = $_POST['u_apellido'];
    $usuario = $_POST['u_usuario'];
    $rol = $_POST['u_rol'];
    $estado = $_POST['u_estado'];
    $contrasena = $_POST['u_contrasena']; // Get password, will need to hash if not already

    if ($id === null) {
        // Esto no debería pasar si el input hidden está siempre ahí, pero es una buena práctica de seguridad
        echo "<script>alert('Error: ID de usuario no proporcionado para la actualización.'); window.location.href='listado_usuarios.php';</script>";
        exit;
    }

    // Update user data
    $stmt = null; // Initialize $stmt to null

    if (!empty($contrasena)) {
        // Si se proporciona una nueva contraseña, hashearla y actualizarla
        // ¡¡RECOMENDADO!!: Hashear la contraseña antes de almacenarla.
       // $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT); // Always hash passwords!

        $stmt = $conexion->prepare("UPDATE usuario SET u_nombre = ?, u_apellido = ?, u_usuario = ?, u_rol = ?, u_estado = ?, u_contrasena = ? WHERE id_usuario = ?");
        // 'ssssssi' assuming u_nombre, u_apellido, u_usuario, u_rol, u_estado, u_contrasena are strings and id_usuario is integer
        // Adjust 's' or 'i' for u_rol and u_estado based on their actual data types in your DB
        $stmt->bind_param("ssssssi", $nombre, $apellido, $usuario, $rol, $estado, $contrasena, $id);

    } else {
        // Si la contraseña está vacía, no se actualiza la contraseña
        $stmt = $conexion->prepare("UPDATE usuario SET u_nombre = ?, u_apellido = ?, u_usuario = ?, u_rol = ?, u_estado = ? WHERE id_usuario = ?");
        // 'sssssi' assuming u_nombre, u_apellido, u_usuario, u_rol, u_estado are strings and id_usuario is integer
        // Adjust 's' or 'i' for u_rol and u_estado based on their actual data types in your DB
        $stmt->bind_param("sssssi", $nombre, $apellido, $usuario, $rol, $estado, $id);
    }

    if ($stmt && $stmt->execute()) { // Check if $stmt is not null before executing
        echo "<script>alert('Usuario actualizado exitosamente.'); window.location.href='listado_usuarios.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el usuario: " . ($stmt ? $stmt->error : "Statement not prepared") . "');</script>";
    }
    if ($stmt) {
        $stmt->close();
    }

} else {
    // Si la solicitud es GET (carga inicial de la página), obtenemos el ID de la URL
    $user_id = $_GET['id'] ?? null;

    if ($user_id) {
        // Fetch user data
        $stmt = $conexion->prepare("SELECT id_usuario, u_nombre, u_apellido, u_usuario, u_contrasena, u_rol, u_estado FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if (!$user) {
            echo "Usuario no encontrado.";
            exit;
        }
    } else {
        echo "ID de usuario no proporcionado.";
        exit;
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/tram_varis.css" rel="stylesheet" />
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
    <h2 class="my-4">Editar Usuario</h2>
    <?php if ($user): ?>
    <form action="editar_usuario.php" method="POST">
        <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($user['id_usuario']); ?>">

        <div class="mb-3">
            <label for="u_usuario" class="form-label">Usuario:</label>
            <input type="text" class="form-control" id="u_usuario" name="u_usuario" value="<?php echo htmlspecialchars($user['u_usuario']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="u_nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="u_nombre" name="u_nombre" value="<?php echo htmlspecialchars($user['u_nombre']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="u_apellido" class="form-label">Apellido:</label>
            <input type="text" class="form-control" id="u_apellido" name="u_apellido" value="<?php echo htmlspecialchars($user['u_apellido']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="u_rol" class="form-label">Rol:</label>
            <select class="form-select" id="u_rol" name="u_rol" required> 
                        <option><?php echo htmlspecialchars($user['u_rol']); ?></option>
                        <option>Empleado</option>
                        <option>Administrador</option>
                    </select>


        </div>
        <div class="mb-3">
            <label for="u_estado" class="form-label">Estado:</label>
            <select class="form-select" id="u_estado" name="u_estado" required> 
                        <option>Activo</option>
                        <option>Inactivo</option>
                    </select>


        </div>
        <div class="mb-3">
            <label for="u_contrasena" class="form-label">Contraseña (dejar en blanco para mantener la actual):</label>
            <input type="password" class="form-control" id="u_contrasena" name="u_contrasena" placeholder="********">
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="listado_usuarios.php" class="btn btn-secondary">Regresar</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
    <?php else: ?>
        <p class="alert alert-warning">No se pudieron cargar los datos del usuario para editar.</p>
    <?php endif; ?>
</div>
</body>
</html>