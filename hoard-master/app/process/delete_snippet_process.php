<?php
	
/*******************************
	
	Process Delete Snippet
	app/delete_snippet_process.php
	
********************************/

require_once('../head.php');

$user = new User();
$user->set_id($current_user['user_id']); 
	
$id = trim($_POST['snippet_id']);
	
$snippet = new Snippet();
$snippet->set_id($id); 
	
// Double check the current user owns this snippet or is an admin
if($snippet->get_author() != $user->get_id() && !$user->is_admin()) {
	die('Permission denied');	
}
$snippet_id = $snippet->get_id();

$delete_snippet = $mysqli->query("DELETE FROM snippets WHERE snippet_id = $snippet_id");
if (!$delete_snippet) {
	die('error deleting entry: '.$mysqli->error);
}

// Redirect back to snippet page with success message
header('Location: ../../index.php?delete_success');

?>


