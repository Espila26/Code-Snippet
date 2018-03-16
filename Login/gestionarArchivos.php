<!DOCTYPE html>
<html>
	<head>
	<?php
	session_start();
	
	if( !isset( $_SESSION['userName'] ))
		header("Location: Login.php");
	
	$metaArray = readMetaFile( 'metaData.txt' );
	$metaDataFile = initializeFile( 'metaData.txt' );
	if( isset( $_POST[ 'submit' ] ) ){
		uploadFile( $metaDataFile, $metaArray );
	}
	
	function uploadFile( $metaDataFile, $metaArray ){
		if ( $_FILES[ 'archivo' ][ "error" ] > 0 ){
			echo "Error: " . $_FILES[ 'archivo' ][ 'error' ] . "<br>";
		}else{
			$name = $_FILES[ 'archivo' ][ 'name' ]."";
			$size = round( $_FILES[ 'archivo' ][ 'size' ] / 1024 / 1024, 3);
			$path = 'C:\\ProjectDirectories\\' . $_SESSION[ 'userName' ];
			buildMetaData( $metaDataFile, $metaArray, "MetaData para: " . $name, $name, "uploadedFile",
                    		$path, $_SESSION[ 'userName' ], " ", $size);

			chdir( 'C:\\ProjectDirectories\\' );// Change the directory where we are to the one we want
			move_uploaded_file( $_FILES[ 'archivo' ][ 'tmp_name' ],
			"".$_SESSION[ 'userName' ]."/" . $_FILES[ 'archivo' ][ 'name' ]);
		}
	}
	
	function getUserFiles(){//no se esta usando de momento, ver si puede ser util o si no, borrarla
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
	
	function initializeFile( $path ){
		if ( file_exists( $path ))
			$file = fopen( $path, "r+" );
		else
			$file = fopen( $path, "a+" );
		return $file;
	}
	
	function buildMetaData( $file, $metaDataArray, $metaName , $name, $description, $path, $owner, $sharedWith, $size ){
		$count = count( $metaDataArray );
		$newArray = [];
		$metaData = array( 'id' => $count, 'metaName' => $metaName, 'realName' => $name, 'description' => $description,
                       	   'path' => $path, 'owner' => $owner, 'sharedWith' => $sharedWith, 'size' => $size);
		array_push( $metaDataArray, $metaData );
		foreach( $metaDataArray as $data){
			array_push( $newArray, serialize( $data ));//Primero se mete cada array serializado dentro de un 
		}                                              //array que guardara toda la metadata y luego se serializa el
		$string = serialize( $newArray );              // array que contiene todas las metadatas
		fwrite( $file, $string );
		header("Location: gestionarArchivos.php");
	}
	
	function readMetaFile( $file ){
		$fp = fopen($file, "r");
		if( filesize( $file ) > 0){
		$contents = fread($fp, filesize( $file ));
		$array = unserialize( $contents );
		$newArray = [];
		
		foreach( $array as $data ){
			array_push( $newArray, unserialize( $data ));
		}
		return $newArray;
		}
		return [];
		
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
		if( isset( $metaArray )){
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
				foreach( $metaArray as $array ){
				?>
					<tr>
						<form method="post">
							<td> <?php echo $array[ 'metaName' ] ?> </td>
							<td> <?php echo $array['size']. " MB" ?> </td>
						</form>
					</tr>
				<?php
				  $contFiles++;
				  $totalSize = $totalSize + $array[ 'size' ];
				}
	    		?>
				<tr><?php echo $contFiles ." Archivos(" .$totalSize. " MB)" ?> </tr>
		</table>
		<?php
		}
		?>
		</div>
		
    </body>
</html>
