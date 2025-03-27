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
    <title>Clientes</title>
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>



<?php

    include("conexionbd.php");
    include("modales.php");
?>

<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg" style="background-color: #e2e2e2;">
            <div class="container px-lg-5">
            <a class="navbar-brand" href="http://localhost/NOTARIA_ECUADOR/public_html/menu.php">
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

        <div style="widht: 100px; margin:0 auto;text-align: center">
        <p class="fs-2" >Clientes</p>
        </div>

        <!-- Barra de busqueda-->
<nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
        <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Nombre o Identificación" aria-label="Nombre o Identificación">
        <button class="btn btn-outline-success" type="submit">Buscar</button>
        <a class=" btn btn-outline-success" type="button"  style="margin-left:10px" href="crud_clientes.php">Crear</a>
      </form>  
      </div>
</nav>

<div class="container text-center">
  <div class="row">
    <div class="col"><h5>Identificación </h5></div>
    <div class="col"><h5>Nombres<h5></div>
    <div class="col"><h5>Apellidos<h5></div>
    <div class="col"><h5>Teléfono<h5></div>    
    <div class="col"><h5>Deuda total<h5></div>
    <div class="col"><h5>Abonado<h5></div>
    <div class="col"><h5>Saldo Pendiente<h5></div>
    <div class="col"><h5>Acciones<h5></div>
    <div class="col"><h5>Tramites<h5></div>
  </div>
  <div class="row">

  <div class="col"> 
    
    <?php
    $inc = include("conexionbd.php");
    if ($inc) {
        $consulta = "SELECT * FROM cliente";
        $resultado = mysqli_query($conexion,$consulta);
       
        if ($resultado){
            while($row = $resultado->fetch_array()){
                $id = $row['c_identificacion'];            
                ?>
                        <div style="padding:13.5px">

                             <?php 
                             echo $id;                              
                             ?>                            

                        </div>
                <?php
            } 
        }    
    }
    ?>
    
    </div>
    <div class="col">
    
    <?php
    $inc = include("conexionbd.php");
    if ($inc) {
        $consulta = "SELECT * FROM cliente";
        $resultado = mysqli_query($conexion,$consulta);
       
        if ($resultado){
            while($row = $resultado->fetch_array()){
                $nombre = $row['c_nombre'];            
                ?>
                        <div style="padding:13.5px">
                             <?php echo $nombre; ?>                            
                        </div>
                <?php
            } 
        }    
    }
    ?>
    
    </div>
    <div class="col">
    
    <?php
    $inc = include("conexionbd.php");
    if ($inc) {
        $consulta = "SELECT * FROM cliente";
        $resultado = mysqli_query($conexion,$consulta);
       
        if ($resultado){
            while($row = $resultado->fetch_array()){
                $apellido = $row['c_apellido'];            
                ?>
                        <div style="padding:13.5px">
                             <?php echo $apellido; ?>                            
                        </div>
                <?php
            } 
        }    
    }
    ?>
    
    </div>
    <div class="col">
        
    <?php
    $inc = include("conexionbd.php");
    if ($inc) {
        $consulta = "SELECT * FROM cliente";
        $resultado = mysqli_query($conexion,$consulta);
       
        if ($resultado){
            while($row = $resultado->fetch_array()){
                $telefono = $row['c_telefono'];            
                ?>
                        <div style="padding:13.5px">
                             <?php echo $telefono; ?>                            
                        </div>
                <?php
            } 
        }    
    }
    ?>
    
    </div>

    <div class="col">
    
    <?php
    $inc = include("conexionbd.php");
    if ($inc) {
        $consulta = "SELECT * FROM cliente";
        $resultado = mysqli_query($conexion,$consulta);
       
        if ($resultado){
            while($row = $resultado->fetch_array()){
                $deuda = $row['c_deuda'];            
                ?>
                        <div style="padding:13.5px">
                             <?php echo $deuda; ?>                            
                        </div>
                <?php
            } 
        }    
    }
    ?>
    </div>

    <div class="col">
    
    <?php
    $inc = include("conexionbd.php");
    if ($inc) {
        $consulta = "SELECT * FROM cliente";
        $resultado = mysqli_query($conexion,$consulta);
       
        if ($resultado){
            while($row = $resultado->fetch_array()){
                $abonado = $row['c_abonado'];            
                ?>
                        <div style="padding:13.5px">
                             <?php echo $abonado; ?>                            
                        </div>
                <?php
            } 
        }    
    }
    ?>
    
    </div>
    <div class="col">
    
    <?php
    $inc = include("conexionbd.php");
    if ($inc) {
        $consulta = "SELECT * FROM cliente";
        $resultado = mysqli_query($conexion,$consulta);
       
        if ($resultado){
            while($row = $resultado->fetch_array()){

                /*$abonado = $row['c_abonado']; 
                $deuda = $row['c_deuda']; 
                $saldo = $deuda - $abonado;*/
                $saldo = $row['c_saldo'];      
                  
                ?>
                        <div style="padding:13.5px">
                             <?php echo $saldo;?>      

                        </div>
                <?php
            } 
        }    
    }
    ?>
    
    </div>

    <div class="col">
    <?php
      $inc = include("conexionbd.php");
      if ($inc) {
          $consulta = "SELECT * FROM cliente";
          $resultado = mysqli_query($conexion,$consulta);
        
          if ($resultado){
              while($row = $resultado->fetch_array()){
                    $idcli = $row['id_cliente'];               
                  ?>
                          <div style="padding:10px" class="dropdown">
                              <div class="btn-group">
                                  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      Acciones
                                  </button>
                                  <ul class="dropdown-menu">              

                                      <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalabonar" 
                                      data-clienteid="<?php echo $idcli;?>" data-abonado="0" data-deuda="0"
                                      
                                      >Abonar a deuda</a></li>

                                      <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#modalcancelardeuda">Cancelar deuda</a></li>                
                                  </ul>
                                  </div>
                          </div>
                  <?php
              } 
          }    
      }
    ?>

        
    </div>

    <div class="col">
    <?php
      $inc = include("conexionbd.php");
      if ($inc) {
          $consulta = "SELECT * FROM cliente";
          $resultado = mysqli_query($conexion,$consulta);
        
          if ($resultado){
              while($row = $resultado->fetch_array()){
                  $deuda = $row['c_deuda'];            
                  ?>
                          <div style="padding:10px" class="dropdown">
                              <div class="btn-group">
                                  <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      Tramites
                                  </button>
                                  <ul class="dropdown-menu">              
                                      <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Tramites Varios</a></li>
                                      <li><a class="dropdown-item" >Declaracion de impuestos</a></li>
                                      <li><a class="dropdown-item" href="#">Poderes</a></li>
                                      <li><a class="dropdown-item" href="#">Divorcios</a></li>
                                      
                                  </ul>
                                  </div>
                              </div>
                  <?php
              } 
          }    
      }
      ?>
  </div>
</div>



      <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>


</body>
</html>