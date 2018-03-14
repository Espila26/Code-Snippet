<?php
	
/*******************************
	
	Custom Functions
	app/functions.php
	
********************************/	

// Get contents between 2 strings, used to parse search

function get_between($content, $start, $end){
    $r = explode($start, $content);
    if (isset($r[1])) {
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}

?>