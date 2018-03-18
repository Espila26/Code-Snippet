<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
    <title>Gestionar Archivos PHP</title>
	<link href="estilos/gestionarArchivos.css" type="text/css" rel="stylesheet"/>
	<?php
	session_start();
	
	if( !isset( $_SESSION['userName'] ))
		header("Location: Login.php");
	
	$metaArray = readMetaFile( 'metaData.txt' );
	$metaDataFile = initializeFile( 'metaData.txt' );
	$usersfile = initializeFile( "usuarios.txt" );
	$usersArray = unserializeUsersData( $usersfile );
	if( isset( $_POST[ 'submit' ] ) ){
		uploadFile( $metaDataFile, $metaArray );
	}
	if( isset( $_POST[ 'edit' ] ) || isset( $_POST[ 'delete' ] )){
		echo"yes";
		if( isset( $_POST[ 'metaDataCheckBox' ] ) ){
			$valuesChecked = getCheckBoxValues( $_POST[ 'metaDataCheckBox' ]);
			if( isset( $_POST[ 'edit' ] )){
				if(count($valuesChecked)>1){

					header("Location: gestionarArchivos.php");
					echo"solo es posible editar un archivo a la vez";//recordar meter errores en un session
				}
			}else{
				foreach ($valuesChecked as $id ) {
				 $valueToDelete = $metaArray[$id];
				 $valueToDelete['deleted'] = true;
				 $metaArray[$id] = $valueToDelete;
				 saveFileSerialized($metaDataFile, $metaArray);
				}
			}
		}else{
			header("Location: gestionarArchivos.php");
			echo"se debe de seleccionar al menos un archivo";//recordar meter errores en un session
		}
	}
	
	if( isset( $_POST[ 'submitEdit' ] )){
		$sharedWithString = '';
		if( isset( $_POST[ 'sharedWith' ] )){
			var_dump( $_POST[ 'sharedWith' ] );
			foreach( $_POST[ 'sharedWith' ] as $selectedOption )
				$sharedWithString = $sharedWithString . ',' . $selectedOption;
		}
		var_dump( $sharedWithString );
		$index = $_POST[ 'metaIndex' ];
		$valueToEdit = $metaArray[ $index ];
		$valueToEdit[ 'metaName' ] = $_POST[ 'metaName' ];
		$valueToEdit[ 'description' ] = $_POST[ 'metaDescription' ];
		$valueToEdit[ 'sharedWith' ] = $sharedWithString;
		$metaArray[ $index ] = $valueToEdit;
		saveFileSerialized( $metaDataFile, $metaArray );
	}
		
	if( isset( $_POST[ 'logout' ] )){
		unset( $_SESSION[ 'userName' ] );
		header("Location: Login.php");
	}
	
	function uploadFile( $metaDataFile, $metaArray ){
		if ( $_FILES[ 'archivo' ][ "error" ] > 0 ){
			echo "Error: " . $_FILES[ 'archivo' ][ 'error' ] . "<br>";
		}else{
			$name = $_FILES[ 'archivo' ][ 'name' ]."";
			$size = round( $_FILES[ 'archivo' ][ 'size' ] / 1024 / 1024, 3);
			$path =  $_SESSION[ 'userName' ];
			buildMetaData( $metaDataFile, $metaArray, "MetaData para: " . $name, $name, "uploadedFile",
                    		$path, $_SESSION[ 'userName' ], " ", $size, false);

			//chdir( 'C:\\ProjectDirectories\\' );// Change the directory where we are to the one we want
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
	
	function unserializeUsersData( $file ){
		$array = [];
		while ($data = fread($file,200)) {
			$array[] = unserialize( $data );
		}
		return $array;
	}
	
	function buildMetaData( $file, $metaDataArray, $metaName , $name, $description, $path, $owner, $sharedWith, $size, $deleted ){
		$count = count( $metaDataArray );
		$metaData = array( 'id' => $count, 'metaName' => $metaName, 'realName' => $name, 'description' => $description,
                       	   'path' => $path, 'owner' => $owner, 'sharedWith' => $sharedWith, 'size' => $size, 'deleted' => $deleted);
		array_push( $metaDataArray, $metaData );
		saveFileSerialized( $file, $metaDataArray );
	}
	
	function saveFileSerialized( $file, $array ){
		var_dump($array);
		$newArray = [];
		foreach( $array as $data){
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
	<header>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<img src="imagenes/php.PNG" alt="Image">
			<input class="search" type="text" name="search" placeholder="Buscar Archivo..">
			<input type="submit" name="logout" class="logout" value="">
		</form>
	</header>
    <body>
		<h1>Administrador de Archivos PHP</h1>
		<div class="uploadFile">
			<h2>Archivo a subir:</h2>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
				<input class="custom-file-input" type="file" name="archivo" id="archivo"></input></br></br>
				<input class='button'  type="submit" name="submit" value="Subir archivo"></input>
			</form>
		</div>
		
		<div class="showFiles">
		<?php
		if( isset( $metaArray ) && !isset( $_POST['edit'] )){
		$contFiles = 0;
		$contFolders = 0;
		$totalSize = 0;
		echo "<form action= ".$_SERVER['PHP_SELF']." method='post'>
		<table>
		<h2>Archivos de " .$_SESSION[ 'userName' ]. "</h2>
			<tr>
				<th>Nombre</th>
				<th>Tamanno</th>
				<th>Accion</th>
			</tr>";
			foreach( $metaArray as $array ){
				if( $array['owner'] == $_SESSION[ 'userName' ] && $array[ 'deleted' ] == false ){
					echo"<tr>
							<td> <a href='../".$array[ 'path' ]."/".$array[ 'realName' ]."' download> ".$array[ 'metaName' ]." </a> </td>
							<td> ".$array['size']." MB  </td>
							<td> <input name=metaDataCheckBox[] type=checkbox value= ".$array['id']." > </td>
						 </tr>";
						 $contFiles++;
						 $totalSize = $totalSize + $array[ 'size' ];
				}
			}
			echo" <tr><td></td><td>".$contFiles." Archivos(" .$totalSize. " MB) </td>
			<td> <input class='button' type='submit' name='show' value='Mostrar'> </input>
			<input class='button' type='submit' name='edit' value='Editar'> </input>
			<input class='button' type='submit' name='delete' value='Eliminar'> </input> </td></tr>
		</table>
		</form>";
		}else if( isset( $_POST['edit'] )){
			$index = $valuesChecked[0];
			$value = $metaArray[ $index ];
		echo"<h2>Editar Archivo</h2>
		<div class='edit'>
		  <form action= ".$_SERVER['PHP_SELF']." method='post'>
			<label for='metaName'>Nombre</label>
			<input  class='textEdit' type='text' name='metaName' placeholder='Nombre del archivo..' value = '" .$value['metaName']. "' >
			<input  class='textEdit' type='text' name='metaIndex'  value = '" .$index. "' >

			<label for='sharedWith'>Compartido Con:</label>
			<select name='sharedWith[]' size='3' multiple='multiple' tabindex='1'>";
			foreach( $usersArray as $array ){
				echo"<option value='".$array[ 'username' ]."'>".$array[ 'username' ]."</option>
			";}echo"
			</select>
			<label for='description'>Descripcion</label>
			<textarea class='textEdit' type='text'; name='metaDescription' placeholder='Descripcion del archivo..'>".$value['description']. "</textarea>
			<input class='inputEdit' type='submit' name='submitEdit' value='Submit'>
		  </form>
		</div>";
		}?>
		</div>		
    </body>
</html>