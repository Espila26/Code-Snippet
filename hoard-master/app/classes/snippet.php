<?php
	
class Snippet extends Model {
	var $snippet;
	
	function set_id($current_id) { 
		$this->id = $current_id;  
 	}
 
   	function get_id() {
   		$id = $this->id;
   		return $id;
	}
	
	function get_title() {
		$id = $this->id;
		$snippet_title = mysqli_query($this->mysqli, "SELECT snippet_title FROM snippets WHERE snippet_id = $id");
		if ($row_snippets = mysqli_fetch_array($snippet_title, MYSQLI_ASSOC)) {
			return htmlentities($row_snippets['snippet_title']);	
		}
	}
	
	function get_date() {
		$id = $this->id;
		$snippet_date = mysqli_query($this->mysqli, "SELECT snippet_published FROM snippets WHERE snippet_id = $id");
		if ($row_snippets = mysqli_fetch_array($snippet_date, MYSQLI_ASSOC)) {
			return htmlentities($row_snippets['snippet_published']);	
		}
	}
	
	function get_pretty_date($format, $timezone) {
		$id = $this->id;
		$snippet_date = mysqli_query($this->mysqli, "SELECT snippet_published FROM snippets WHERE snippet_id = $id");
		if ($row_snippets = mysqli_fetch_array($snippet_date, MYSQLI_ASSOC)) {
			date_default_timezone_set($timezone);
			$raw = $row_snippets['snippet_published'];	
			return date($format, strtotime($raw));
		}
		
	}
	
	function get_description() {
		$id = $this->id;
		$snippet_description = mysqli_query($this->mysqli, "SELECT snippet_description FROM snippets WHERE snippet_id = $id");
		if ($snippet_description && $row_snippets = mysqli_fetch_array($snippet_description, MYSQLI_ASSOC)) {
			return $row_snippets['snippet_description'];	
		}
	}
	
	function get_author() {
		$id = $this->id;
		$snippet_author = mysqli_query($this->mysqli, "SELECT snippet_author FROM snippets WHERE snippet_id = $id");
		if ($row_snippets = mysqli_fetch_array($snippet_author, MYSQLI_ASSOC)) {
			return htmlentities($row_snippets['snippet_author']);	
		}
	}
	
	function get_author_name() {
		$id = $this->id;
		$snippet_author = mysqli_query($this->mysqli, "SELECT snippet_author FROM snippets WHERE snippet_id = $id");
		if ($row_snippets = mysqli_fetch_array($snippet_author, MYSQLI_ASSOC)) {
			$authorid = htmlentities($row_snippets['snippet_author']);	
		}
		$snippet_author_name = mysqli_query($this->mysqli, "SELECT name FROM users WHERE user_id = $authorid");
		if ($row_snippets = mysqli_fetch_array($snippet_author_name, MYSQLI_ASSOC)) {
			return htmlentities($row_snippets['name']);	
		}
	}
	
	function get_visibility() {
		$id = $this->id;
		$snippet_visibility = mysqli_query($this->mysqli, "SELECT snippet_visibility FROM snippets WHERE snippet_id = $id");
		if ($row_snippets = mysqli_fetch_array($snippet_visibility, MYSQLI_ASSOC)) {
			return htmlentities($row_snippets['snippet_visibility']);	
		}
	}
	
	function get_labels() {
		$id = $this->id;
		$query = mysqli_query($this->mysqli, "SELECT label_id FROM tagging WHERE snippet_id = $id");
		$result = mysqli_fetch_all($query, MYSQLI_ASSOC);
		return $result;
	}
 }
 
?>