
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css\login.css">
    <title>Login</title>
  </head>
 <body >
    
 <div class="container">
	<div class="screen">
		<div class="screen__content">
			<form class="login" method="post" action="">
        <?php
        include("conexionbd.php");
        include("controlador.php");
        ?>
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="text" class="login__input" placeholder="Usuario" name="usuario">
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input type="password" class="login__input" placeholder="Contraseña" name="password">
				</div>
          <input class="button login__submit" type="submit" name="btningresar" class="btn" value="Iniciar Sesion">				</button>				
			</form>
			<div class="social-login">
			
				<div class="social-icons">
					<a href="#" class="social-login__icon fab fa-instagram"></a>
					<a href="#" class="social-login__icon fab fa-facebook"></a>
					<a href="#" class="social-login__icon fab fa-twitter"></a>
				</div>
			</div>
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>
      
    
    </body>
   
