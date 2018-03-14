<?php
	
class Label extends Model {
	var $label;
	
	function set_id($current_id) { 
		$this->id = $current_id;  
 	}
 
   	function get_id() {
   		$id = $this->id;
   		return $id;
	}
	
	function get_name() {
		$id = $this->id;
		$label_name = mysqli_query($this->mysqli, "SELECT label_name FROM labels WHERE label_id = $id");
		if ($row_labels = mysqli_fetch_array($label_name, MYSQLI_ASSOC)) {
			return htmlentities($row_labels['label_name']);	
		}
	}	
	
	function get_hex() {
		$id = $this->id;
		$label_hex = mysqli_query($this->mysqli, "SELECT label_hex FROM labels WHERE label_id = $id");
		if ($row_labels = mysqli_fetch_array($label_hex, MYSQLI_ASSOC)) {
			return htmlentities($row_labels['label_hex']);	
		}
	}	
	
	function has_label($snippet_id) {
		$id = $this->id;
		$has_label = mysqli_query($this->mysqli, "SELECT * FROM tagging WHERE label_id = $id AND snippet_id = $snippet_id");
		if ($row_labels = mysqli_fetch_array($has_label, MYSQLI_ASSOC)) {
			return true;
		}
	}
	
	function is_visible($user_id) {
		$id = $this->id;
		$has_label = mysqli_query($this->mysqli, "SELECT * from snippets WHERE snippet_id IN (SELECT (snippet_id) FROM tagging WHERE label_id = '$id') AND (snippet_author = '$user_id' OR snippet_visibility != 0)");
		if ($row_labels = mysqli_fetch_array($has_label, MYSQLI_ASSOC)) {
			return true;
		}
	}
}

?>