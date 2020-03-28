<?php
function Authorize($username,$pword) {
	// database info
	include ($_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php');
	mysql_select_db($db_login) or die(mysql_error());
	$userquery = "SELECT * from tbl_users WHERE username = '$username'";
	$result = mysql_query($userquery) or die(mysql_error());
	$num=mysql_num_rows($result);
	$x=0;
	if ($x < $num) {
		$validusername=mysql_result($result,$x,"username");
		define('SALT_LENGTH', 9);
		// get the password from the database
		$hashquery="SELECT password FROM tbl_users WHERE username='$validusername'";
		$hashresult=mysql_query($hashquery);
		$hashnum = mysql_num_rows($hashresult) or die(mysql_error());
		$i=0;
		for ($i = 0; $i < $hashnum; $i++) {
			$password=mysql_result($hashresult,$i,"password");
		}
		// create a hash from the form value of pword
		function generateHash($pword, $salt = null) {
			if ($salt === null) {
				$salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
			} else {
				$salt = substr($salt, 0, SALT_LENGTH);
			}
			return $salt . sha1($salt . $pword);
		}
		// see if it matches the hash in the database
		$mainhash = generateHash($pword, $password);
		//echo $mainhash;
		if ($mainhash == $password) {
			return true;
		} else {
			$status_msg .= "password failed<br />";
			//echo $status_msg;
			return $status_msg;
		}
	} else {
		$status_msg .= "username failed<br />";
		return $status_msg;
	}
}
?>