<?php 
	include('main/indexBD.php');
	
	if(isset($_SESSION['usuario'])){ //Pregunta si existe la sesión con nombre usuario
		//Sesión usuario ya tiene acceso a todos los datos, se va a acceder al tipo de usuario
		if($_SESSION['usuario']['id_userType']=="1"){
			header('Location: main/admin/'); //Lo lleva al archivo index del directorio admin
		}
		else if($_SESSION['usuario']['id_userType']=="0"){
			header('Location: main/student/'); //Lo lleva al archivo index del directorio student
		}
	}
?>

<!DOCTYPE html>
<html lang="es"> <!--Lenguaje español-->
<html>
<head>
	<title>Login</title>
	<link rel="shortcut icon" href="images/pestaña.PNG" type="image/png"/> <!--Imagen de la pestaña-->
    <meta charset="UTF-8"> <!--Para caracteres especiales-->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, 
    maximum-scale=1, minimum-scale=1"> <!--Para responsive design-->
    <!--Se agregan los estilos-->
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="stylesheet" href="css/bootstrap.min.css" >
</head>
<body>
	<div id="contenedor" class="container">    
			<div id="signupbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
				<div class="imagen rubberBand" id="imagen"> <!--Imagen animada-->
					<img src="images/una.png">
				</div>

				<div class="" id="transparencia">
					<div class="barraSuperior">
						<div id="titulo">Iniciar Sesión</div>
					</div>     
					
					<div class="panel-body" id="form" >
						<form action="index.php" method="post" id="formRegister" role="form" class="form-horizontal">
							
							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input type="email" class="form-control" name="email" placeholder="Correo electrónico">                                   
							</div>
							
							<div style="margin-bottom: 25px" class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
								<input type="password" class="form-control" name="password" placeholder="Contraseña">   
							</div>

							<?php include('main/errors.php'); ?> <!--Aquí se mostrarán los errores-->
							
							<div class="form-group">                                      
								<div class="col-md-offset-1 col-md-10">
									<input type="submit" name="btnLogin" class="formulario_submit" value="Iniciar Sesión">
								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-12 control">
									<div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
										<p>
											¿No estás registrado? <a href="main/register.php">Registrarse</a>
										</p>
										<p>
											<a href="main/recover.php">¿Olvidaste la contraseña?</a>
										</p>
									</div>
								</div>
							</div>    
						</form>
					</div>                     
				</div>  
			</div>
		</div>
</body>
</html>