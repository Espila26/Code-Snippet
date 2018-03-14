<?php
	
/*******************************
	
	Process Edit Entry
	app/edit_process.php
	
********************************/

require_once('../head.php');

$user = new User();
$user->set_id($current_user['user_id']); 
	
$id = trim($_POST['entryid']);
$entry = new Entry();
$entry->set_id($id); 
	
$snippet = new Snippet();
$snippet->set_id($entry->get_parent()); 
	
// Double check the current user owns this snippet
if($snippet->get_author() != $user->get_id()) {
	die('Permission denied');	
}

// Connect to database and insert entry
require_once('config.php');

$entry_id = $entry->get_id();

$new_entry = $mysqli->query("DELETE FROM snippets_entries WHERE entry_id = $entry_id");
if (!$new_entry) {
	die('error deleting entry: '.$mysqli->error);
}

// Redirect back to snippet page with success message
header('Location: ../snippet.php?id=' . $snippet->get_id() . '&delete_success');

?>


