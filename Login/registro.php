<!DOCTYPE html>
 
<html lang="es">
 
<head>
<title>Agenda</title>
<meta charset="utf-8" />
</head>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box}

/* Full-width input fields */
input[type=text], input[type=password] {
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
    background-color: #ddd;
    outline: none;
}

hr {
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
}

button:hover {
    opacity:1;
}

/* Extra styles for the cancel button */
.cancelbtn {
    padding: 14px 20px;
    background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn, .signupbtn {
  float: left;
  width: 50%;
}

/* Add padding to container elements */
.container {
    padding: 16px;
}

/* Clear floats */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
    .cancelbtn, .signupbtn {
       width: 100%;
    }
}
</style>

<?php
	$file = initializeFile( "usuarios.txt" );
	createDirectory( 'C:\\ProjectDirectories' );
		
	$array = [];
	while ($data = fread($file,200)) {
		$array[] = unserialize( $data );
	}
	
	if ( isset( $_POST[ 'signUp' ] ) && isset( $_POST[ 'username' ] ) && isset( $_POST[ 'psw' ] )) {
	
		$count = count( $array );
		$userExists = userNameExists( $array, $_POST[ 'username' ], $_POST[ 'psw' ] );
		if( $_POST[ 'psw' ] == $_POST[ 'psw-repeat' ] && !$userExists ){
			$user = array( 'id' => $count, 'username' => $_POST[ 'username' ], 'password' => $_POST[ 'psw' ] );
			$string = str_pad( serialize( $user ), 200 );
			fwrite( $file, $string );
			//chdir('C:\\ProjectDirectories\\');// Change the directory where we are to the one we want
			createDirectory( $_POST[ 'username' ] );
			header("Location: registro.php");
		}else{
			echo "Passwords do not match or username already exists";
		}
	
	}
	
	function userNameExists( $array, $username, $password ){
		foreach( $array  as $user ){
			if( $user[ 'username' ] == $username && $user[ 'password' ] == $password ){
				return true;
			}
		}
		return false;
	}
	
	function initializeFile( $path ){
		if ( file_exists( $path ))
			$file = fopen( $path, "r+" );
		else
			$file = fopen( $path, "a+" );
		return $file;
	}
	
	function createDirectory( $path ){
		if (!file_exists( $path ))
			mkdir( $path, 0777, true );
	}

?>

<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" style="border:1px solid #ccc" method="post">
  <div class="container">
    <h1>Registro de Nuevos Usuarios</h1>
    <p>Complete la información para registrar nuevos usuarios.</p>
    <hr>

    <label for="email"><b>Nombre de Usuario</b></label>
    <input type="text" placeholder="Ingresa Usuario" name="username" required>

    <label for="psw"><b>Contraseña</b></label>
    <input type="password" placeholder="Ingresa Contraseña" name="psw" required>

    <label for="psw-repeat"><b>Repita Contraseña</b></label>
    <input type="password" placeholder="Ingresa de nuevo la Contraseña" name="psw-repeat" required>

    <div class="clearfix">
      <button type="button" class="cancelbtn">Cancelar</button>
      <button name="signUp" type="submit" class="signupbtn">Registrar</button>
    </div>
  </div>
</form>

</body>
</html>