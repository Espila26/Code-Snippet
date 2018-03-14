<?php
	
/*******************************
	
	Process User Permissions Change
	app/delete_snippet_process.php
	
********************************/

require_once('login_check.php');
require_once('functions.php');
require_once('config.php');

$user = new User();
$user->set_id($current_user['user_id']); 
	
// Double check the current user owns this snippet or is an admin
if(!$user->is_admin()) {
	die('Permission denied');	
}

$changeid = trim($_POST['id']);
$changeid = $mysqli->escape_string($changeid);

$user_permissions = $mysqli->query("UPDATE users SET permissions = '1' WHERE permissions = '0' AND user_id = $changeid;");

if (!$user_permissions) {
	die('error changing permissions: '.$mysqli->error);
}

// Redirect back to snippet page with success message
header('Location: ../admin.php?update_success');

?>


