<?php
	
/*******************************
	
	Search Logic
	app/search_process.php
	
********************************/

require_once('app/head.php');

// Define our special search terms (#, @, ^, <3)
$search_label = $search->search_label(); 
$search_author = $search->search_author();
$search_order = $search->search_order();
$search_favourites = $search->search_favourite();

// Strip out everything else and leave us with the primary search string
$search_contents = $mysqli->escape_string(trim(str_replace(
    array($search_label, $search_author, $search_order, '#', '^', '@', '+', '&lt;3'),
    array('','','','','','',''), 
    $q
)));

// The primary search query
$contents_search = "SELECT * FROM snippets WHERE snippet_title LIKE '%$search_contents%'";


// Label Search -------------------

// Get label from search query (Anything between a # and a space)
$search_label = $search->search_label();

// Set some empty variables 
$label_search = null;
$label_results = null;

// If a label search detected...
if($search_label) {
	
	// Get the label from our labels database
	$label_query = mysqli_query($mysqli, "SELECT * FROM labels WHERE label_name LIKE '%$search_label%' LIMIT 1");
	$label_results = mysqli_fetch_array($label_query, MYSQLI_ASSOC);
	
	// If it's not found, run a query we know will fail to show 0 results (TODO: a better way of handling this?)
	if($label_query) { $label_id = htmlentities($label_results['label_id']); } else { $label_id = "'$search_label'"; }
	
	// Create our bit of the main query
	$label_search = " AND snippet_id IN (SELECT (snippet_id) FROM tagging WHERE label_id = '$label_id')";
}


// User Search -------------------

// Get author from search query (Anything between an @ and a space)
$search_author = $search->search_author(); 

// Set an empty variable in case there was no author search
$author_search = null;

if($search_author) {
	
	// Find the user in our users database
	$author_query = mysqli_query($mysqli, "SELECT * FROM users WHERE name LIKE '%$search_author%' LIMIT 1");
	$author_results = mysqli_fetch_array($author_query, MYSQLI_ASSOC);
	
	// Set the user id, run a query we know will fail otherwise
	if($author_query) { $user_id = htmlentities($author_results['user_id']); } else { $user_id = '$search_author'; }	
	
	// Create our user search
	$author_search = " AND snippet_author = '$user_id'";
}


// Favourites Search -------------------

// Nice and easy this one, if the search contains <3 
if($search_favourites) {
	
	// Cross check the favourites table and grab snippet IDs that match the current user
	$favourites_search = " AND snippet_id IN (SELECT (snippet_id) FROM favourites WHERE user_id = '$userid')";
} else {
	
	// Otherwise give 'em nothing
	$favourites_search = null;
}


// Order Search -------------------

// Another easy one, a couple empty variables and an order_name for a more descriptive front-end
$order_search = null;
$order_name = null;

if($search_order) {
	if(strpos($search_order, "title") !== false) { 
		$order_search = ' ORDER BY snippet_title ASC';
		$order_name = 'Title, Alphabetical';
	}
	
	if(strpos($search_order, "title_r") !== false) { 
		$order_search = ' ORDER BY snippet_title DESC';
		$order_name = 'Title, Reverse Alphabetical';
	}
	
	if(strpos($search_order, "date") !== false) { 
		$order_search = ' ORDER BY snippet_published DESC';
		$order_name = 'Date, Newest First';
	}
	
	if(strpos($search_order, "date_r") !== false) { 
		$order_search = ' ORDER BY snippet_published ASC';
		$order_name = 'Date, Oldest First';
	}
}


// Permissions Check -------------------

// Only show snippets the user owns or has permission to see (set to team or public)
$permissions_search = " AND (snippet_author = '$userid' OR snippet_visibility != 0)";


// Final Query -------------------

$final_search = $contents_search . $label_search . $author_search . $favourites_search . $permissions_search . $order_search;
$snippets = mysqli_query($mysqli, "$final_search");

?>


