<?php

class Core extends Model {
	var $core;
	
    function version_number() {
		$version_number = 'pre-0.1.0';
		return $version_number;
    }
    
    function company_name() {
		$query = mysqli_query($this->mysqli, "SELECT value FROM options WHERE options = 'company_name'");
		if ($company_name = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			return htmlentities($company_name['value']);
		}
    }
    
    function branding_logo() {
		$query = mysqli_query($this->mysqli, "SELECT value FROM options WHERE options = 'branding_logo'");
		if ($branding_logo = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$logo_url = htmlentities($branding_logo['value']);
		}

		$query = mysqli_query($this->mysqli, "SELECT value FROM options WHERE options = 'branding_logo_link'");
		if ($branding_logo = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$logo_link = htmlentities($branding_logo['value']);
		}
		
		$query = mysqli_query($this->mysqli, "SELECT value FROM options WHERE options = 'branding_logo_height'");
		if ($branding_logo = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$logo_height = htmlentities($branding_logo['value']);
		}
		
		return '<a href="' . $logo_link . '"><img src="' . $logo_url . '" class="logo" style="height: ' . $logo_height . 'px"></a>';
    }
}
 
?>
