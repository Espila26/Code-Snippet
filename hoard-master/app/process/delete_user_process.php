<?php
	
/*******************************
	
	Process Delete User
	app/delete_user_process.php
	
********************************/

require_once('../head.php');
	
$id = (int)trim($_GET['id']);
	
if(!$user->is_admin()) {
	die('Permission denied');	
}

if($user->get_id() == $id) {
	die('Please do not delete yourself');	
}

$delete_user = $mysqli->query("DELETE FROM users WHERE user_id = $id");
if (!$delete_user) {
	die('error deleting user: '.$mysqli->error);
}

$delete_snippets = $mysqli->query("DELETE FROM snippets WHERE snippet_author = $id");
if (!$delete_snippets) {
	die('error deleting snippets: '.$mysqli->error);
}

// Redirect back to snippet page with success message
header('Location: ../../admin.php?delete_success');

?>


