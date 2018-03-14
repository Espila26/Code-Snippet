<?php
 
class Search extends Model {
	var $search;
	
	function set_query($query) {
		$this->query = $query;
	}
	
	function search_label() {
		$mysqli = $this->mysqli;
		$query = $this->query;
		$search_label = get_between($query,"#"," ");
		if($search_label) {
			return $mysqli->escape_string($search_label);
		} else {
			return false;
		}
	}
	
	function search_author() {
		$mysqli = $this->mysqli;
		$query = $this->query;
		$search_label = get_between($query,"@"," ");
		if($search_label) {
			return $mysqli->escape_string($search_label);
		} else {
			return false;
		}
	}
	
	function search_order() {
		$mysqli = $this->mysqli;
		$query = $this->query;
		$search_label = get_between($query,"^"," ");
		if($search_label) {
			return $mysqli->escape_string($search_label);
		} else {
			return false;
		}
	}
	
	function search_favourite() {
		$mysqli = $this->mysqli;
		$query = $this->query;
		if(strpos($query, "&lt;3") !== false) {
			return true;
		} else {
			return false;
		}
	}
		
	function query_label() {
		$mysqli = $this->mysqli;
		$query = $this->query;
		$search_label = get_between($query,"#"," ");
		if($search_label) {
			$label = mysqli_query($this->mysqli, "SELECT * FROM labels WHERE label_name LIKE = $search_label");
			return $mysqli->escape_string(htmlentities($label['label_id']));	
		} else {
			return '*';
		}
	}
}

?>
