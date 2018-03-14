<?php
	
/*******************************
	
	Process Edit Snippet Details
	app/details_process.php
	
********************************/

require_once('../head.php');

$user = new User();
$user->set_id($current_user['user_id']); 
	
$id = trim($_POST['snippetid']);
$snippet = new Snippet();
$snippet->set_id($id); 

	
// Double check the current user owns this snippet
if($snippet->get_author() != $user->get_id()) {
	die('Permission denied');	
}

// Double check the fields have data
if (!isset($_POST['title']) || trim($_POST['title']) == '') {
	die('you forgot to put in a title');
}

if (!isset($_POST['description']) || trim($_POST['description']) == '') {
	die('you forgot to put in an entry');
}

// Connect to database and insert entry
$snippet_title = "'".$mysqli->escape_string(trim($_POST['title']))."'";
$snippet_description = "'".$mysqli->escape_string(trim($_POST['description']))."'";
$snippet_visibility = "'".$mysqli->escape_string(trim($_POST['visibility']))."'";
$snippet_id = $snippet->get_id();
$labelpost = $_POST['labelpicker'];

// Update entry details
$new_entry = $mysqli->query("UPDATE snippets SET snippet_title = $snippet_title, snippet_description = $snippet_description, snippet_visibility = $snippet_visibility WHERE snippet_id = $snippet_id");
if (!$new_entry) {
	die('error editing snippet: '.$mysqli->error);
}


// Delete all the current assigned labels (I wonder if there's a better way to just update these?)
$delete_labels = $mysqli->query("DELETE FROM tagging WHERE snippet_id = $snippet_id");
if (!$new_entry) {
	die('error deleting labels: '.$mysqli->error);
}


// Re-assign new labels
foreach ($labelpost as $labeloption) {
	$label = $mysqli->query("INSERT INTO tagging (snippet_id, label_id) VALUES ($snippet_id, $labeloption)");
}
 
// Redirect back to snippet page with success message
header('Location: ../../snippet.php?id=' . $snippet->get_id() . '&details_success');

?>


