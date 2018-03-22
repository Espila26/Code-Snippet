<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}


span.psw {
    float: right;
    padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}
</style>

<?php
	session_start();
	$file = initializeFile( "usuarios.txt" );
	
	$array = [];
	while ($data = fread($file,200)) {
		$array[] = unserialize( $data );
	}
	
	if( isset( $_SESSION[ 'userName' ])){
		unset( $_SESSION[ 'userName' ] );
	}
	
	if( isset( $_POST[ 'login' ] ) ){
		$userWasFound = false;
		if( $_POST[ 'uname' ] && $_POST[ 'psw' ] ){
			foreach( $array  as $user ){
				if( $user[ 'username' ] == $_POST[ 'uname' ] && 
				    $user[ 'password' ] == $_POST[ 'psw' ] ){
					$_SESSION['userName'] = $user[ 'username' ];
					echo"session started";
					$userWasFound = true;
					header("Location: gestionarArchivos.php");
				}
			}
		}	
		if( !$userWasFound ){
			echo "Username or password incorrect :(";
		}
		
	}
	
	function initializeFile( $path ){
		if ( file_exists( $path ))
			$file = fopen( $path, "r+" );
		else
			$file = fopen( $path, "a+" );
		return $file;
	}

?>

</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <div class="imgcontainer">
    <img src="imagenes/Login.png">
  </div>

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
        
    <button name="login" type="submit">Login</button>
  </div>

  <div class="container" style="background-color:#f1f1f1">
	<button name="signIn" type="button" class="cancelbtn"><a href="registro.php">Registrarse</a></button>
    <button type="button" class="cancelbtn">Cancel</button>
  </div>
</form>

</body>
</html>