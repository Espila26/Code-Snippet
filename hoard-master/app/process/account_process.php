<?php
	
/*******************************
	
	Process Account Details
	app/account_process.php
	
********************************/

require_once('../head.php');

// Initialise current user object
$user = new User();
$user->set_id($current_user['user_id']); 

// Double check the fields have data
if (!isset($_POST['title']) || trim($_POST['title']) == '') {
	die('Oops! You forgot to enter a title.');
}

if (!isset($_POST['name']) || trim($_POST['name']) == '') {
	die('Oops! You forgot to choose a name.');
}

if (!isset($_POST['timezone']) || trim($_POST['timezone']) == '') {
	die('Oops! You forgot to pick a timezone.');
}

if (!isset($_POST['email']) || trim($_POST['email']) == '') {
	die('Oops! You forgot to enter an email.');
}

$user_id = $user->get_id();
$old_email = "'" . mysqli_query($mysqli, "SELECT email FROM users WHERE user_id = $user_id")->fetch_object()->email . "'";

$new_title = "'".$mysqli->escape_string(trim($_POST['title']))."'";
$new_name = "'".$mysqli->escape_string(trim($_POST['name']))."'";
$new_email = "'".$mysqli->escape_string(trim($_POST['email']))."'";
$new_timezone = "'".$mysqli->escape_string(trim($_POST['timezone']))."'";
$current_id = $user->get_id();

$existing_emails = mysqli_query($mysqli, "SELECT email FROM users WHERE email = $new_email AND email != $old_email");
$existing_emails_count = mysqli_num_rows($existing_emails);

if ($existing_emails_count) { die('Email already exists'); }

$new_entry = $mysqli->query("UPDATE users SET email = $new_email, name = $new_name, title = $new_title, timezone = $new_timezone WHERE user_id = $current_id");

if (!$new_entry) {
	die('error changing details: '.$mysqli->error);
}

// Redirect back to dashboard with success message
header('Location: /account.php?update_success');

?>


