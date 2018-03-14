<?php

class Model {
    public $mysqli;
     
    public function __construct() {
	    global $database_name;
	    global $database_user;
	    global $database_pass;
	    global $database_host;
        $this->mysqli = new mysqli($database_host, $database_user, $database_pass, $database_name);
    }
}
 
?>
