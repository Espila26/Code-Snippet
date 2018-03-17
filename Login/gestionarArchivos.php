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
	if( isset( $_POST[ 'edit' ] ) || isset( $_POST[ 'delete' ] )){
		echo"yes";
		if( isset( $_POST[ 'metaDataCheckBox' ] ) ){
			$valuesChecked = getCheckBoxValues( $_POST[ 'metaDataCheckBox' ]);
			if( isset( $_POST[ 'edit' ] )){
				var_dump( $valuesChecked );
			}else{
				//delete code
			}
		}
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
	
	function getCheckBoxValues( $checkBox ){
		$values = [];
		if( isset( $checkBox ) ){
			foreach($checkBox as $selected){
				array_push( $values, $selected );
			}
		}
		return $values;
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
		$contFiles = 0;
		$contFolders = 0;
		$totalSize = 0;
		echo "<form action= ".$_SERVER['PHP_SELF']." method='post'>
		<table>
		<h1>Archivos</h1>
			<tr>
				<th>Nombre</th>
				<th>Tamanno</th>
				<th> </th>
			</tr>";
			foreach( $metaArray as $array ){
				if( $array['owner'] == $_SESSION[ 'userName' ] ){
					echo"<tr>
							<td> ".$array[ 'metaName' ]." </td>
							<td> ".$array['size']." MB  </td>
							<td> <input name=metaDataCheckBox[] type=checkbox value= ".$array['id']." > </td>
						 </tr>";
						 $contFiles++;
						 $totalSize = $totalSize + $array[ 'size' ];
				}
			}
			echo" <tr>".$contFiles." Archivos(" .$totalSize. " MB) </tr>
			<tr> <input type='submit' name='edit' value='Editar'> </input> </tr>
			<tr> <input type='submit' name='delete' value='Eliminar'> </input> </tr>
		</table>
		</form>";
		}?>
		</div>
    </body>
</html>