<?php

include('classes/model.php');
include('config.php');

if (isset($_COOKIE['hoard_session']) && trim($_COOKIE['hoard_session']) != '') { // user has a session already?
	// delete the saved session token from the database
	$user_session_id = trim($_COOKIE['hoard_session']);
	$user_session_id_db = "'".$mysqli->escape_string($user_session_id)."'";
	$delete_session = $mysqli->query("DELETE FROM user_sessions WHERE session_id=$user_session_id_db");
}

$_COOKIE = array();
unset($_COOKIE);
setcookie('hoard_session', '', time() - 3600);

// TODO: Why won't this accept the $baseurl variable?
setcookie('hoard_session', '', time() - 3600, '/', 'hoard.localhost');

header('Location: ../index.php');
die();

?>