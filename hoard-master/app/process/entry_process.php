<?php
	
/*******************************
	
	Process New Entry
	app/entry_process.php
	
********************************/

require_once('../head.php');

// Initialise snippet object
$id = trim($_POST['snippet']);
$snippet = new Snippet();
$snippet->set_id($id); 

// Initialise current user object
$user = new User();
$user->set_id($current_user['user_id']); 
	
// Double check the current user owns this snippet
if($snippet->get_author() != $user->get_id()) {
	die('Permission denied');	
}

// Double check the fields have data
if (!isset($_POST['title']) || trim($_POST['title']) == '') {
	die('you forgot to put in a title');
}

if (!isset($_POST['entry']) || trim($_POST['entry']) == '') {
	die('you forgot to put in an entry');
}

$new_entry_snippet = "'".$mysqli->escape_string(trim($_POST['snippet']))."'";
$new_entry_content = "'".$mysqli->escape_string(trim($_POST['entry']))."'";
$new_entry_title = "'".$mysqli->escape_string(trim($_POST['title']))."'";
$new_entry_language = "'".$mysqli->escape_string(trim($_POST['language']))."'";

$new_entry = $mysqli->query("INSERT INTO snippets_entries (snippet_id, entry_content, entry_name, entry_language) VALUES ($new_entry_snippet, $new_entry_content, $new_entry_title, $new_entry_language)");
if (!$new_entry) {
	die('error creating new entry: '.$mysqli->error);
}

// Redirect back to snippet page with success message
header('Location: ../../snippet.php?id=' . trim($_POST['snippet']) . '&entry_success');

?>


