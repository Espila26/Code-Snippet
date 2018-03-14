<?php

class User extends Model
{
	var $user;
	var $author;
	
	function set_id($current_id) { 
		$this->id = $current_id;  
 	}
 
   	function get_id() {
   		$id = $this->id;
   		return $id;
	}
	
	function get_name() {
		$userid = $this->id;
		$query = mysqli_query($this->mysqli, "SELECT name FROM users WHERE user_id = $userid");
		if ($row_users = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			return htmlentities($row_users['name']);	
		}
	}
	
	function get_email() {
		$userid = $this->id;
		$query = mysqli_query($this->mysqli, "SELECT email FROM users WHERE user_id = $userid");
		if ($row_users = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			return htmlentities($row_users['email']);	
		}
	}

	function get_gravatar() {
		$userid = $this->id;
		$query = mysqli_query($this->mysqli, "SELECT email FROM users WHERE user_id = $userid");
		if ($row_users = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$email = htmlentities($row_users['email']);
			return 'https://www.gravatar.com/avatar/' . md5($email) . '?d=mm';	
		}
	}
	
	function get_title() {
		$userid = $this->id;
		$query = mysqli_query($this->mysqli, "SELECT title FROM users WHERE user_id = $userid");
		if ($row_users = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$title = htmlentities($row_users['title']);
			return $title;	
		}
	}
	
	function get_timezone() {
		$userid = $this->id;
		$query = mysqli_query($this->mysqli, "SELECT timezone FROM users WHERE user_id = $userid");
		if ($row_users = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$timezone = htmlentities($row_users['timezone']);
			return $timezone;	
		}
	}
	
	function get_permissions() {
		$userid = $this->id;
		$query = mysqli_query($this->mysqli, "SELECT permissions FROM users WHERE user_id = $userid");
		if ($row_users = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$permissions = (int)$row_users['permissions'];
			return $permissions;	
		}
	}
	
	function is_admin() {
		$userid = $this->id;
		$query = mysqli_query($this->mysqli, "SELECT permissions FROM users WHERE user_id = $userid");
		if ($row_users = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$permissions = (int)$row_users['permissions'];
			if ($permissions === 1) {
				return true;
			}	else {
				return false;
			}
		}
	}
 }
 
 ?>
