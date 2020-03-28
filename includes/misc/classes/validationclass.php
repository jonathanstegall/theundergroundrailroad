<?php

class validation {

	var $username;
	var $password;
	
	function validate_login() {
		// if it is the login form
		if (isset($_POST['username']) && isset($_POST['password'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			if (function_exists("mysql_real_escape_string")) { 
				$username = mysql_real_escape_string($username);
				$password = mysql_real_escape_string($password);
			}
			if (get_magic_quotes_gpc()){ 
				$username = stripslashes($username);
				$password = stripslashes($password);
			}
			$username = addslashes($username);
			$password = addslashes($password);
			// strip away any dangerous tags
			$username=strip_tags($username);
			$password=strip_tags($password);
			// remove spaces from variables
			$username=str_replace(" ","",$username);
			$password=str_replace(" ","",$password);
			// remove escaped spaces
			$username=str_replace("%20","",$username);
			$password=str_replace("%20","",$password);
			// html characters
			$username = htmlspecialchars($username);
			$password = htmlspecialchars($password);
			// remove non alphanumeric characters
			$username = preg_replace("/[^a-zA-Z0-9]/", "", $username);
			$password = preg_replace("/[^a-zA-Z0-9]/", "", $password);
			return true;
		} else {
			$message = '<p class="error">error occured in submission</p>';
			return $message;
		}
	}
	
	function validate_links() {
		if (isset($_POST['title']) && isset($_POST['address']) && isset($_POST['category']) && isset($_POST['description']) ) {
			$title = $_POST['title'];
			$address = $_POST['address'];
			$category = $_POST['category'];
			$description = $_POST['description'];
			
			if (function_exists("mysql_real_escape_string")) { 
				$title = mysql_real_escape_string($title);
				$address = mysql_real_escape_string($address);
				$category = mysql_real_escape_string($category);
				$description = mysql_real_escape_string($description);
			} 
			
			if (get_magic_quotes_gpc()){ 
				$title = stripslashes($title);
				$address = stripslashes($address);
				$category = stripslashes($category);
				$description = stripslashes($description);
			}
			
			if ($title=='') {
				$message = '<p class="error">title field is required. please try again.</p>';
				return $message;
			} else {
				$title = addslashes($title);
				$title = htmlspecialchars($title);
				$title=strip_tags($title);
				$title=str_replace(" ","",$title);
				$title=str_replace("%20","",$title);
				$title = preg_replace("/[^a-zA-Z0-9]/", "", $title);
				return true;
			}
			if ($address=='') {
				$message = '<p class="error">address field is required. please try again.</p>';
				return $message;
			} else {
				$address = addslashes($address);
				$address = htmlspecialchars($address);
				$address=strip_tags($address);
				$address=str_replace(" ","",$address);
				$address=str_replace("%20","",$address);
				if (preg_match("/^(http(s?):\\/\\/|ftp:\\/\\/{1})((\w+\.)+)\w{2,}(\/?)$/i", $address)) {
				return true;
				} else {
					$message = '<p class="error">this is not a valid address. please try again.</p>';
					return $message;
				}
			}
			if ($category=='') {
				$message = '<p class="error">category field is required. please try again.</p>';
				return $message;
			} else {
				$category = addslashes($category);
				$category = htmlspecialchars($category);
				$category=strip_tags($category);
				$category=str_replace(" ","",$category);
				$category=str_replace("%20","",$category);
				$category = preg_replace("/[^a-zA-Z0-9]/", "", $category);
				return true;
			}
			if ($description=='') {
				$message = '<p class="error">description field is required. please try again.</p>';
				return $message;
			} else {
				$description = addslashes($description);
				$description = htmlspecialchars($description);
				$description=strip_tags($description);
				$description=str_replace(" ","",$description);
				$description=str_replace("%20","",$description);
				$description = preg_replace("/[^a-zA-Z0-9]/", "", $description);
				return true;
			}
		} else {
			$message = '<p class="error">error occured in submission</p>';
			return $message;
		}
	}

	function validate_news() {
		if (isset($_POST['author']) && isset($_POST['title']) && isset($_POST['newsitem']) ) {
			$author = $_POST['author'];
			$title = $_POST['title'];
			$newsitem = $_POST['newsitem'];
			
			if (function_exists("mysql_real_escape_string")) { 
				$author = mysql_real_escape_string($author);
				$title = mysql_real_escape_string($title);
				$newsitem = mysql_real_escape_string($newsitem);
			} 
			
			if (get_magic_quotes_gpc()){ 
				$author = stripslashes($author);
				$title = stripslashes($title);
				$newsitem = stripslashes($newsitem);
			}
			
			if ($author=='') {
				$message = '<p class="error">author field is required. please try again.</p>';
				return $message;
			} else {
				$author = addslashes($author);
				$author = htmlspecialchars($author);
				$author=strip_tags($author);
				$author=str_replace(" ","",$author);
				$author=str_replace("%20","",$author);
				$author = preg_replace("/[^a-zA-Z0-9]/", "", $author);
				return true;
			}
			if ($title=='') {
				$message = '<p class="error">title field is required. please try again.</p>';
				return $message;
			} else {
				$title = addslashes($title);
				$title = htmlspecialchars($title);
				$title=strip_tags($title);
				$title=str_replace(" ","",$title);
				$title=str_replace("%20","",$title);
				$title = preg_replace("/[^a-zA-Z0-9]/", "", $title);
				return true;
			}
			if ($newsitem=='') {
				$message = '<p class="error">news item field is required. please try again.</p>';
				return $message;
			} else {
				$newsitem = addslashes($newsitem);
				$newsitem = htmlspecialchars($newsitem);
				$newsitem=strip_tags($newsitem);
				$newsitem=str_replace(" ","",$newsitem);
				$newsitem=str_replace("%20","",$newsitem);
				$newsitem = preg_replace("/[^a-zA-Z0-9]/", "", $newsitem);
				return true;
			}
		} else {
			$message = '<p class="error">error occured in submission</p>';
			return $message;
		}
	}
	
	function validate_shows() {
		if (isset($_POST['year']) && isset($_POST['month']) && isset($_POST['daynumber']) && isset($_POST['showdate']) && isset($_POST['bands']) && isset($_POST['price']) && isset($_POST['time']) && isset($_POST['ampm']) ) {
			$showdate = $_POST['showdate'];
			$year = $_POST['year'];
			$month = $_POST['month'];
			$daynumber = $_POST['daynumber'];
			$bands = $_POST['bands'];
			$price = $_POST['price'];
			$time = $_POST['time'];
			$ampm = $_POST["ampm"];
						
			if (function_exists("mysql_real_escape_string")) { 
				$showdate = mysql_real_escape_string($showdate);
				$year = mysql_real_escape_string($year);
				$month = mysql_real_escape_string($month);
				$daynumber = mysql_real_escape_string($daynumber);
				$bands = mysql_real_escape_string($bands);
				$price = mysql_real_escape_string($price);
				$time = mysql_real_escape_string($time);
				$ampm = mysql_real_escape_string($ampm);
			} 
			
			if (get_magic_quotes_gpc()){ 
				$showdate = stripslashes($showdate);
				$year = stripslashes($year);
				$month = stripslashes($month);
				$daynumber = stripslashes($daynumber);
				$bands = stripslashes($bands);
				$price = stripslashes($price);
				$time = stripslashes($time);
				$ampm = stripslashes($ampm);
			}
			
			$showdate = addslashes($showdate);
			$year = addslashes($year);
			$month = addslashes($month);
			$daynumber = addslashes($daynumber);
			$bands = addslashes($bands);
			$price = addslashes($price);
			$time = addslashes($time);
			$ampm = addslashes($ampm);
			
			$showdate = htmlspecialchars($showdate);
			$year = htmlspecialchars($year);
			$month = htmlspecialchars($month);
			$daynumber = htmlspecialchars($daynumber);
			$bands = htmlspecialchars($bands);
			$price = htmlspecialchars($price);
			$time = htmlspecialchars($time);
			$ampm = htmlspecialchars($ampm);
			return true;

		} else {
			$message = '<p class="error">error occured in submission</p>';
			return $message;
		}
	}

}
?> 