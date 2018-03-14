<?php
	
/*******************************
	
	Process Change User Permission
	app/delete_snippet_process.php
	
********************************/

require_once('../head.php');

// Set the object for target user	
$id = $_GET['id'];

// Admin permissions required
if(!$user->is_admin() || !$id || $user->get_id() == $id) {
	die('Permission denied');	
}

$author = new User();
$author->set_id($id); 

// 0 is user, 1 is admin
if($author->is_admin()) {
	$new_status = 0;
} else {
	$new_status = 1;
}

$permissions_change = $mysqli->query("UPDATE users SET permissions = $new_status WHERE user_id = $id");
if (!$permissions_change) {
	die('error changing permissions: '.$mysqli->error);
}

// Redirect back to snippet page with success message
header('Location: ../../admin.php?permissions_success');

?>
