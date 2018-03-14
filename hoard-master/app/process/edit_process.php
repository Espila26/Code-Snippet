<?php
	
/*******************************
	
	Process Edit Entry
	app/edit_process.php
	
********************************/

require_once('../head.php');
	
$id = trim($_POST['entryid']);
$entry = new Entry();
$entry->set_id($id); 
	
$snippet = new Snippet();
$snippet->set_id($entry->get_parent()); 
	
if($snippet->get_author() != $user->get_id()) {
	die('Permission denied');	
}

if (!isset($_POST['title']) || trim($_POST['title']) == '') {
	die('you forgot to put in a title');
}

if (!isset($_POST['entry']) || trim($_POST['entry']) == '') {
	die('you forgot to put in an entry');
}

$new_entry_content = "'".$mysqli->escape_string(trim($_POST['entry']))."'";
$new_entry_title = "'".$mysqli->escape_string(trim($_POST['title']))."'";
$new_entry_language = "'".$mysqli->escape_string(trim($_POST['language']))."'";
$entry_id = $entry->get_id();

$new_entry = $mysqli->query("UPDATE snippets_entries SET entry_content = $new_entry_content, entry_name = $new_entry_title, entry_language = $new_entry_language WHERE entry_id = $entry_id");
if (!$new_entry) {
	die('error editing entry: '.$mysqli->error);
}

header('Location: ../../snippet.php?id=' . $entry->get_parent() . '&edit_success');

?>


