<?php

require_once('../head.php');

// Initialise current user object
$user = new User();
$user->set_id($current_user['user_id']); 

// Double check the fields have data
if (!isset($_POST['snippet_title']) || trim($_POST['snippet_title']) == '') {
	die('Oops! You forgot to enter a title.');
}

// ok, make a new snippet

$snippet_title = "'".$mysqli->escape_string(trim($_POST['snippet_title']))."'";
$author = "'".$user->get_id()."'";
$snippet_description = "'".$mysqli->escape_string(trim($_POST['snippet_description']))."'";
$published = "'".date('Y-m-d H:i:s')."'";
$snippet_visibility = "'".$mysqli->escape_string(trim($_POST['visibility']))."'";
$labelpost = $_POST['labelpicker'];

$new_snippet = $mysqli->query("INSERT INTO snippets (snippet_title, snippet_published, snippet_description, snippet_visibility, snippet_author) VALUES ($snippet_title, $published, $snippet_description, $snippet_visibility, $author)");
if (!$new_snippet) {
	die('error creating new snippet: '.$mysqli->error);
}
$new_snippet = $mysqli->insert_id;

$new_entry_content = "'".$mysqli->escape_string(trim($_POST['entry']))."'";
$new_entry_title = "'".$mysqli->escape_string(trim($_POST['entry_title']))."'";
$new_entry_language = "'".$mysqli->escape_string(trim($_POST['entry_language']))."'";

$new_entry = $mysqli->query("INSERT INTO snippets_entries (snippet_id, entry_name, entry_content, entry_language) VALUES ($mysqli->insert_id, $new_entry_title, $new_entry_content, $new_entry_language)");



// Re-assign new labels
foreach ($labelpost as $labeloption) {
	$label = $mysqli->query("INSERT INTO tagging (snippet_id, label_id) VALUES ($new_snippet, $labeloption)");
}

if (!$new_entry) {
	die('error creating new entry: '.$mysqli->error);
}


header('Location: ../../index.php?snippet_success');

?>


