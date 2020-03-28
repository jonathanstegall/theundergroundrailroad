<?php

class login {		
		// declare variables
		var $user_table = "tbl_users";
		var $username;
		var $password;
		var $valid_username;
		var $valid_password;
	
	function login() {
		// variable values
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		// connect to database or display error
		include("../../includes/db_connect.php");
		mysql_select_db($db_login) or die(mysql_error());
		
		// encrypt password
		$password= md5($password);
		
		// get username from database only if it matches, assign number if it does
		$query = "SELECT * from " . $this->user_table . " WHERE username = '$username'";
		$result = mysql_query($query) or die(mysql_error());
		$num=mysql_num_rows($result);
		
		$i=0;
		if ($i < $num) {
			// if it matches, keep going
			$username=mysql_result($result,$i,"username");
			// message for valid username
			$valid_username = 'yes';
			$query2 = "SELECT * from " . $this->user_table . " WHERE password = '$password'";
			$result2 = mysql_query($query2) or die(mysql_error());
			$num2=mysql_num_rows($result2);
			$j=0;
			if ($j < $num2) {
				// check password for database match
				$password=mysql_result($result2,$j,"password");
				// this is what happens if the login is successful
				$valid_password = 'yes';
				
				return true;
				exit;
			} else {
				// if password does not match
				$valid_password = 'no';
				$message = '<p class="error">The password entered is invalid. Please try again.</p>';
				return $message;
			}
		} else {
			// if username does not match
			$valid_username = 'no';
			$message = '<p class="error">The username entered, ' . $username . ', is invalid. Please try again.</p>';
			return $message;
		}
	}
}
?>