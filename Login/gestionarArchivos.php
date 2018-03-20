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
	
	$metaDataFile = initializeFile( 'metaData.txt' );
	$metaIndexfile = initializeFile( "metaIndex.txt" );
	$metaArray = readMetaFile( 'metaData.txt' );
	$metaIndexArray = readMetaFile( 'metaIndex.txt' );
	$usersfile = initializeFile( "usuarios.txt" );
	$usersArray = unserializeUsersData( $usersfile );
	if( isset( $_POST[ 'submit' ] ) ){
		uploadFile( $metaDataFile, $metaArray, $metaIndexfile, $metaIndexArray );
	}
	if( isset( $_POST[ 'edit' ] ) || isset( $_POST[ 'delete' ] ) || isset( $_POST[ 'show' ] )){
		echo"yes";
		if( isset( $_POST[ 'metaDataCheckBox' ] ) ){
			$valuesChecked = getCheckBoxValues( $_POST[ 'metaDataCheckBox' ]);
			if( isset( $_POST[ 'edit' ] ) || isset( $_POST[ 'show' ] )){
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
		foreach( $_POST[ 'sharedWith' ] as $selectedOption )
				$sharedWithString = $sharedWithString . ',' . $selectedOption;
		}
		var_dump( $sharedWithString );
		$description ="";$metaName =""; $author="";$date="";$clasification = "";
			
		if( isset( $_POST[ 'addName' ] ))
			$metaName = $_POST[ 'addName' ];
		if( isset( $_POST[ 'addDescription' ] ))
			$description = $_POST[ 'addDescription' ];
		if( isset( $_POST[ 'addAuthor' ] ))
			$author = $_POST[ 'addAuthor' ];
		if( isset( $_POST[ 'addDate' ] ))
			$date = $_POST[ 'addDate' ];
		if( isset( $_POST[ 'addClasification' ] ))
			$clasification = $_POST[ 'addClasification' ];
		$index = $_POST[ 'metaIndex' ];
		$valueToEdit = $metaArray[ $index ];
		$valueToEdit[ 'metaName' ] = $metaName;
		$valueToEdit[ 'description' ] = $description;
		$valueToEdit[ 'author' ] = $author;
		$valueToEdit[ 'date' ] = $date;
		$valueToEdit[ 'clasification' ] = $clasification;
		$valueToEdit[ 'sharedWith' ] = '';
		$metaArray[ $index ] = $valueToEdit;
		saveFileSerialized( $metaDataFile, $metaArray, true );
	}
		
	if( isset( $_POST[ 'logout' ] )){
		unset( $_SESSION[ 'userName' ] );
		header("Location: Login.php");
	}
	
	function uploadFile( $metaDataFile, $metaArray, $metaIndexfile, $metaIndexArray ){
		if ( $_FILES[ 'archivo' ][ "error" ] > 0 ){
			echo "Error: " . $_FILES[ 'archivo' ][ 'error' ] . "<br>";
		}else{
			$description ="";$metaName =""; $author="";$date="";$clasification = "";
			
			if( isset( $_POST[ 'addName' ] ))
				$metaName = $_POST[ 'addName' ];
			if( isset( $_POST[ 'addDescription' ] ))
				$description = $_POST[ 'addDescription' ];
			if( isset( $_POST[ 'addAuthor' ] ))
				$author = $_POST[ 'addAuthor' ];
			if( isset( $_POST[ 'addDate' ] ))
				$date = $_POST[ 'addDate' ];
			if( isset( $_POST[ 'addClasification' ] ))
				$clasification = $_POST[ 'addClasification' ];
			
			$name = $_FILES[ 'archivo' ][ 'name' ]."";
			$size = round( $_FILES[ 'archivo' ][ 'size' ] / 1024 / 1024, 3);
			$path =  $_SESSION[ 'userName' ];
			buildMetaData( $metaDataFile, $metaArray, $metaName, $name, $description,
                    		$path, $_SESSION[ 'userName' ], " ", $size, false, $author, 
							$date, $clasification,$metaIndexfile, $metaIndexArray);

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
	
	function buildMetaData( $file, $metaDataArray, $metaName , $name, $description, $path, $owner, 
							$sharedWith, $size, $deleted, $author, $date, $clasification, $metaIndexfile, $metaIndexArray ){
		$count = count( $metaDataArray );
		$metaData = array( 'metaName' => $metaName, 'description' => $description,
                       	   'path' => $path, 'owner' => $owner, 'sharedWith' => $sharedWith, 
						   'size' => $size, 'deleted' => $deleted, 'author' => $author, 
						   'date' => $date, 'clasification' => $clasification);
		array_push( $metaDataArray, $metaData );
		
		$metaIndex = array( 'id' => $count, 'realName' => $name );
		array_push( $metaIndexArray, $metaIndex );
		
		saveFileSerialized( $file, $metaDataArray, false );
		saveFileSerialized( $metaIndexfile, $metaIndexArray, true );
	}
	
	function saveFileSerialized( $file, $array, $reload ){
		var_dump($array);
		$newArray = [];
		foreach( $array as $data){
			array_push( $newArray, serialize( $data ));//Primero se mete cada array serializado dentro de un 
		}                                              //array que guardara toda la metadata y luego se serializa el
		$string = serialize( $newArray );              // array que contiene todas las metadatas
		fwrite( $file, $string );
		if( $reload )
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
		<div class="add">
		<?php
		$title = "Archivo a subir:";
		if( isset( $_POST[ 'edit' ] )|| isset( $_POST[ 'show' ] )){
			$index = $valuesChecked[0];
			$current = $metaArray[ $index ];
			$title = "Editar Archivo:";
		}
		if( !isset( $current ) ){
			$current = array( 'metaName' => '', 'description' => '', 'path' => '', 'owner' => '', 'sharedWith' => '', 
							  'size' => '', 'deleted' => '', 'author' => '', 'date' => '', 'clasification' => '');
		}
			echo"<h2>".$title."</h2>
			<form action='".$_SERVER['PHP_SELF']."' method='post' enctype='multipart/form-data'>
				<label for='addName'>Nombre</label>
				<input  class='textAdd' type='text' name='addName' placeholder='Nombre del archivo..' value='".$current[ 'metaName' ]."'>
				<label for='addAuthor'>Autor</label>
				<input  class='textAdd' type='text' name='addAuthor' placeholder='Nombre del autor..' value='".$current[ 'author' ]."'>
				<label for='addDate'>Fecha</label>
				<input  class='textAdd' type='date' name='addDate' value='".$current[ 'date' ]."'>
				<label for='addClasification'>Clasificacion</label>
				<input  class='textAdd' type='text' name='addClasification' placeholder='Clasificacion del archivo..' value='".$current[ 'clasification' ]."'>
				<label for='sharedWith'>Compartido Con:</label>
				<select name='sharedWith[]' size='1' multiple='multiple' tabindex='1' >";
				foreach( $usersArray as $array ){
					echo"<option value='".$array[ 'username' ]."'>".$array[ 'username' ]."</option>";}
				echo"</select>
				<label for='addDescription'>Descripcion</label>
				<textarea class='textAdd' type='text'; name='addDescription' placeholder='Descripcion del archivo..' value='".$current[ 'description' ]."'></textarea>";
				if( !isset( $_POST[ 'edit' ] ) && !isset( $_POST[ 'show' ] ) ){
				echo"<input class='custom-file-input' type='file' name='archivo' id='archivo'></input></br></br>
				<input class='button'  type='submit' name='submit' value='Subir archivo'></input>";
				}else if( isset( $_POST[ 'edit' ] ) ){
					echo"<input class='inputEdit' type='submit' name='submitEdit' value='Submit'>
					<input  class='textEdit' type='text' name='metaIndex'  value = '" .$index. "' >";
				}
				echo"
			</form>
		</div>
		
		<div class='showFiles'>";
		if( isset( $metaArray ) ){
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
			foreach( $metaIndexArray as $array ){
				$index = $array[ 'id' ];
				$current = $metaArray[ $index ];
				if( $current['owner'] == $_SESSION[ 'userName' ] && $current[ 'deleted' ] == false ){
					echo"<tr>
							<td> <a href='../".$current[ 'path' ]."/".$array[ 'realName' ]."' download> ".$current[ 'metaName' ]." </a> </td>
							<td> ".$current['size']." MB  </td>
							<td> <input name=metaDataCheckBox[] type=checkbox value= ".$array['id']." > </td>
						 </tr>";
						 $contFiles++;
						 $totalSize = $totalSize + $current[ 'size' ];
				}
			}
			echo" <tr><td></td><td>".$contFiles." Archivos(" .$totalSize. " MB) </td>
			<td> <input class='button' type='submit' name='show' value='Mostrar'> </input>
			<input class='button' type='submit' name='edit' value='Editar'> </input>
			<input class='button' type='submit' name='delete' value='Eliminar'> </input> </td></tr>
		</table>
		</form>";
		}?>
		</div>		
    </body>
</html>