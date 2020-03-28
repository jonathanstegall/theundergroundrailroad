<?php

function loggedinstatus() {
	//$session_table = "tbl_sessions";
	// see if the session exists
	if (isset ($_SESSION['logged_in'])) {
		//$username = $_POST['username'];
		// if it does, get it from the database
		include("db_connect.php");
		mysql_select_db($db_login) or die(mysql_error());
		$getuser = "SELECT * FROM tbl_sessions";
		$getresult = mysql_query($getuser) or die(mysql_error());
		
		while($resultarray = mysql_fetch_array($getresult)) {
			$username=$resultarray["username"];
		}
		// and display this message
		$loggedinmessage = '<p class="loginstatus"><strong>' . $username . '</strong> is logged in. click to <a href="logout.php" title="log out">log out</a></p>';
		echo $loggedinmessage;
	} else {
		// if the session already exists, do not display the form... but the logged in message
		//echo $loggedinmessage;
		echo 'you are not logged in, and cannot access this page. that is your login status';
		exit;
	}
}

?>