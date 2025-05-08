<?php
// Seguridad de sesión
session_start();
error_reporting(0);
$varsesion = $_SESSION['usuario'];
if ($varsesion == null || $varsesion == '') {
    header("location:index.php");
    die;
}

include("conexionbd.php");
include("modales.php");

// Búsqueda
$busqueda = "";
if (isset($_GET['buscar'])) {
    $busqueda = mysqli_real_escape_string($conexion, $_GET['buscar']);
    $consulta = "SELECT * FROM cliente WHERE c_nombre LIKE '%$busqueda%' OR c_apellido LIKE '%$busqueda%' OR c_identificacion LIKE '%$busqueda%' OR c_telefono LIKE '%$busqueda%'";
} else {
    $consulta = "SELECT * FROM cliente";
}
$resultado = mysqli_query($conexion, $consulta);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #e2e2e2;">
    <div class="container px-lg-5">
        <a class="navbar-brand" href="menu.php">
            <img src="img/logo.png" alt="logo" width="150px">
        </a>
        <div class="btn-group">
            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown">
                <?php echo $varsesion; ?>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="cerrar_sesion.php">Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="text-center">Clientes</h2>

    <form class="row g-3 mb-3" method="get" action="">
        <div class="col-auto">
            <input class="form-control" type="search" name="buscar" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Nombre, Apellido, Identificación o Teléfono">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-success" type="submit">Buscar</button>
            <a href="crud_clientes.php" class="btn btn-outline-primary">Crear</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Identificación</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Deuda Total</th>
                    <th>Abonado</th>
                    <th>Saldo Pendiente</th>
                    <th>Acciones</th>
                    <th>Trámites</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['c_identificacion']) ?></td>
                        <td><?= htmlspecialchars($row['c_nombre']) ?></td>
                        <td><?= htmlspecialchars($row['c_apellido']) ?></td>
                        <td><?= htmlspecialchars($row['c_telefono']) ?></td>
                        <td><?= htmlspecialchars($row['c_deuda']) ?></td>
                        <td><?= htmlspecialchars($row['c_abonado']) ?></td>
                        <td><?= htmlspecialchars($row['c_saldo']) ?></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">Acciones</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalabonar" data-clienteid="<?= $row['id_cliente'] ?>" data-abonado="<?= $row['c_abonado'] ?>" data-deuda="<?= $row['c_deuda'] ?>">Abonar a deuda</a></li>
                                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalcancelardeuda">Cancelar deuda</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <a href="ver_tramites.php?id_cliente=<?= $row['id_cliente'] ?>" target="_blank" class="btn btn-secondary btn-sm">Trámites</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/scripts.js"></script>
</body>
</html>