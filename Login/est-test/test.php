<!DOCTYPE html>
<html>
<head>
	<title>Tarea No.3: Manejo de Archivos</title>
</head>
<body>
	<form action="test.php" method="POST">
		<table>
			<tr>
				<td>Name: </td>
				<td><input type="text" name="NameInfo" value="name"></td>
			</tr>
			<tr>
				<td>Work: </td>
				<td><input type="text" name="WorkInfo" value="work"></td>
			</tr>
			<tr>
				<td>Mobile: </td>
				<td><input type="text" name="MobileInfo" value="mobile"></td>
			</tr>
			<tr>
				<td>Email: </td>
				<td><input type="text" name="EmailInfo" value="email"></td>
			</tr>
			<tr>
				<td>Address: </td>
				<td><input type="text" name="AddressInfo" value="address"></td>
			</tr>
		</table>
		<br />
		<input type="submit" id ="submitButton" value="Submit">
	</form>

	<?php
		$name = $_POST['NameInfo'];
		$work = $_POST['WorkInfo'];
		$mobile = $_POST['MobileInfo'];
		$email = $_POST['EmailInfo'];
		$address = $_POST['AddressInfo'];
		$file = fopen('C:/wamp64/www/PrograWeb/TareaNo.3/test.txt', 'w+');
		if (isset($file)) {
			ftruncate($file, 0);
			$data = $name."-".$work."-".$mobile."-".$email."-".$address;
			fwrite($file, $data);
			fclose($file);
			die(header("Location: ".$_SERVER["HTTP_REFERER"]));
		}else{
			echo "<p>ERROR!!</p>";
		}

	?>


</body>
</html>