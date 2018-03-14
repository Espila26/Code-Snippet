<?php

$login_required = true;

require_once(__DIR__ . '/login_check.php');
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/functions.php'); 
require_once(__DIR__ . '/classes/model.php'); 
require_once(__DIR__ . '/classes/core.php'); 
require_once(__DIR__ . '/classes/user.php'); 
require_once(__DIR__ . '/classes/label.php'); 
require_once(__DIR__ . '/classes/search.php'); 
require_once(__DIR__ . '/classes/snippet.php'); 
require_once(__DIR__ . '/classes/entry.php'); 
require_once(__DIR__ . '/classes/user.php'); 

$user = new User();
$user->set_id($current_user['user_id']); 

?>