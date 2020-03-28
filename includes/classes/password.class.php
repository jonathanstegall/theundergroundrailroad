<?php
class password {
	function password() {
		
	}
	function createRandomPassword() {
		$seed = (integer) md5(microtime());
		mt_srand($seed);
		$randompass = mt_rand(1,99999999);
		$randompass = substr(md5($randompass), mt_rand(0, 19), mt_rand(6, 12));
		return $randompass;
	}
	function resetPassword($email,$reset) {
		define('SALT_LENGTH', 9);
		// get the password from the database
		$hashquery="SELECT password FROM tbl_users WHERE email='$email'";
		$hashresult=mysql_query($hashquery);
		$hashnum = mysql_num_rows($hashresult) or die(mysql_error());
		$i=0;
		for ($i = 0; $i < $hashnum; $i++) {
			$password=mysql_result($hashresult,$i,"password");
			// create a hash from the form value of pword
			function generateHash($reset, $salt = null) {
				if ($salt === null) {
					$salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
				} else {
					$salt = substr($salt, 0, SALT_LENGTH);
				}
				return $salt . sha1($salt . $reset);
			}
			// see if it matches the hash in the database
			$mainhash = generateHash($reset);
			//echo $mainhash;
			if ($mainhash) {
				$resetpassquery="UPDATE tbl_users SET password='$mainhash' WHERE email = '$email'";		
				mysql_query($resetpassquery) or die(mysql_error());
			} else {
				$status_msg .= "password not created<br />";
				//echo $status_msg;
				return $status_msg;
			}
		}
	}
	function emailPassword($reset,$email) {
		$to = 'nahtanoj83@yahoo.com';
		$from = 'TownGreeters.com Password Reset';
		$subject = "Reset password - towngreeters.com";
		$message = 'You have requested that your password at www.towngreeters.com be reset. Your new password is '.$reset.'. Please store this in a safe location. If you desire, you can visit http://www.towngreeters.com/admin/changepassword.php to change your password</a>.';
		$headers = "From: $from";
		mail($to, $subject, $message, $headers);
	}
	function checkOldPassword($oldpassword,$username) {
		//echo $oldpassword;
		//echo $username;
		define('SALT_LENGTH', 9);
		// get the password from the database
		$hashquery="SELECT password FROM tbl_users WHERE username='$username'";
		$hashresult=mysql_query($hashquery);
		$hashnum = mysql_num_rows($hashresult) or die(mysql_error());
		$i=0;
		for ($i = 0; $i < $hashnum; $i++) {
			$password=mysql_result($hashresult,$i,"password");
		}
		// create a hash from the form value of pword
		function generateHash($oldpassword, $salt = null) {
			if ($salt === null) {
				$salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
			} else {
				$salt = substr($salt, 0, SALT_LENGTH);
			}
			return $salt . sha1($salt . $oldpassword);
		}
		// see if it matches the hash in the database
		$mainhash = generateHash($oldpassword, $password);
		//echo $mainhash;
		if ($mainhash == $password) {
			return true;
		} else {
			$status_msg .= "<p class=\"queryError\">password failed</p>";
			return $status_msg;
		}
	}
	function changePassword($newpassword) {
		define('SALT_LENGTH', 9);
		// create a hash from the form value of pword
		function createHash($newpassword, $salt = null) {
			if ($salt === null) {
				$salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
			} else {
				$salt = substr($salt, 0, SALT_LENGTH);
			}
			return $salt . sha1($salt . $newpassword);
		}
		// see if it matches the hash in the database
		$newhash = generateHash($newpassword);
		return $newhash;
	}
}
?>