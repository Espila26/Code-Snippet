<?php
	
	$database_host = 'localhost'; // Usually 'localhost'
	$database_user = 'root'; // Your database username
	$database_pass = 'root'; // Your database password
	$database_name = 'hoard'; // Your database name
	
	$baseurl = 'http://hoard.localhost:8888'; // Base URL must begin with HTTP and NOT have a trailing slash (eg. 'https://example.com')
	
	// That's all, stop editing!
	
	$mysqli = new mysqli('localhost', 'root', 'root', 'hoard');
	
	if($mysqli->connect_errno > 0){
   		die('Unable to connect to database [' . $mysqli->connect_error . ']');
	}
	
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	
?>