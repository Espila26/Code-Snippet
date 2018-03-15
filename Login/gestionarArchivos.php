<!DOCTYPE html>
<html>
	<head>
	<?php
	session_start();
	
	if( !isset( $_SESSION['userName'] ))
		header("Location: Login.php");
	
	$userFiles = getUserFiles();
	if( isset( $_POST[ 'submit' ] ) ){
		uploadFile();
		header("Location: gestionarArchivos.php");
	}
	
	function uploadFile(){
		if ( $_FILES[ 'archivo' ][ "error" ] > 0 ){
			echo "Error: " . $_FILES[ 'archivo' ][ 'error' ] . "<br>";
		}else{
			chdir( 'C:\\ProjectDirectories\\' );// Change the directory where we are to the one we want
			move_uploaded_file( $_FILES[ 'archivo' ][ 'tmp_name' ],
			"".$_SESSION[ 'userName' ]."/" . $_FILES[ 'archivo' ][ 'name' ]);
		}
	}
	
	function getUserFiles(){
		$path = 'C:\\ProjectDirectories\\' . $_SESSION['userName'];
		chdir( $path );
		$directory = opendir( "." ); //ruta actual
		$userFiles = [];
		
		while( $file = readdir( $directory )) //obtenemos un archivo y luego otro sucesivamente
		{
			if( $file != '.' && ( $file != '..' )){
				$filesize = filesize($file); // bytes
				if ( is_dir( $file ))//verificamos si es o no un directorio
				{
					$foundFile = array( 'name' => "[".$file . "]", 
										'size' => $filesize = round($filesize / 1024 / 1024, 3),
										'isFolder' => true ); // megabytes with 3 digit );
					array_push( $userFiles, $foundFile ); //de ser un directorio lo envolvemos entre corchetes
				}
				else
				{
					$foundFile = array( 'name' => $file, 
										'size' => $filesize = round($filesize / 1024 / 1024, 3),
										'isFolder' => false ); // megabytes with 3 digit );
					array_push( $userFiles, $foundFile );
				}
			}
		}
		return $userFiles;
	}

	?>
	
    </head>
    <body>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="archivo" id="archivo"></input>
            <input type="submit" name="submit" value="Subir archivo"></input>
        </form>
		
		<div>
		<?php
		if( isset( $userFiles )){
		?>
		<table>
		<h1>Archivos</h1>
			<tr>
				<th>Nombre</th>
				<th>Tamanno</th>
			</tr>
				<?php
				$contFiles = 0;
				$contFolders = 0;
				$totalSize = 0;
				foreach( $userFiles as $file ){
				?>
					<tr>
						<form method="post">
							<td> <?php echo $file[ 'name' ] ?> </td>
							<td> <?php echo $file['size']. " MB" ?> </td>
						</form>
					</tr>
				<?php
				if( $file[ 'isFolder' ] == true )
					$contFolders++;
				else
					$contFiles++;
				$totalSize = $totalSize + $file[ 'size' ];
				}
	    		?>
				<tr><?php echo $contFolders. " Carpetas - " . $contFiles ." Archivos(" .$totalSize. " MB)" ?> </tr>
		</table>
		<?php
		}
		?>
		</div>
		
    </body>
</html>
