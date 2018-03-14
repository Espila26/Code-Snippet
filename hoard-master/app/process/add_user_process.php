<?php
	
require_once('../head.php');

$user = new User();
$user->set_id($current_user['user_id']); 

// Check the user is an admin
if($user->get_permissions() != 1) {
	die('Permission denied');
} 

// make a new user

if (!isset($_POST['e']) || trim($_POST['e']) == '') {
	die('you forgot to put in a goddamn email address, jeez.');
}

if (!filter_var(trim($_POST['e']), FILTER_VALIDATE_EMAIL)) {
	die('the email address you put in is invalid, jeez.');
}

if (!isset($_POST['p1']) || trim($_POST['p1']) == '') {
	die('you forgot to put in your password, jeez.');
}

if (!isset($_POST['p2']) || trim($_POST['p2']) == '') {
	die('you forgot to put in your password again, jeez.');
}

if (trim($_POST['p1']) != trim($_POST['p2'])) {
	die('your passwords do not match.');
}

// ok, make a new user

$new_user_email_db = "'".$mysqli->escape_string(trim($_POST['e']))."'";

// check to see if email already in use
$check_for_email = $mysqli->query("SELECT user_id FROM users WHERE email=$new_user_email_db");
if ($check_for_email->num_rows > 0) {
	die('sorry, but that email address appears to already be in use.');
}

$pwd_salt = substr(get_key(256), 0, 22); // make a new 22-character salt
$new_user_pwd_hash = crypt(trim($_POST['p1']), '$2y$12$' . $pwd_salt);
$new_user_pwd_hash_db = "'".$mysqli->escape_string($new_user_pwd_hash)."'";

$new_user_row = $mysqli->query("INSERT INTO users (email, password, tsc) VALUES ($new_user_email_db, $new_user_pwd_hash_db, UNIX_TIMESTAMP())");
if (!$new_user_row) {
	die('error creating new user: '.$mysqli->error);
}

$new_user_id = $mysqli->insert_id;

header('Location: /admin.php?new_success');

?>