<?php
function loggedinstatus() {
	// get user's data from the database where it matches the session
	include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
	mysql_select_db($db_login) or die(mysql_error());
	$sessionid = session_id();
	$userquery = "SELECT * FROM
		tbl_users
		INNER JOIN tbl_sessions
			ON tbl_users.username = tbl_sessions.username

		WHERE tbl_sessions.ses_id='$sessionid'
	";
	$userresult=mysql_query($userquery);
	$usernum = mysql_num_rows($userresult);
	// if there is a valid user logged in with a matching session id
	if ($usernum >= 1) {
			$username=mysql_result($userresult,0,"username");
			$email=mysql_result($userresult,0,"email");
			$userlevel=mysql_result($userresult,0,"userAdminLevel");
			echo "<ul class=\"welcomeList\">\n";
				echo '<li class="first">welcome, '.$username.'</li>';
				echo "\n";
				echo "<li><a href=\"index.php?page=logout\">logout</a></li>\n";
			echo "</ul>\n";
	// if there are no users logged in
	} else {
		echo '<ul class="welcomeList">
				<li class="first">welcome</li>
				<li><a href="index.php?page=home">please log in</a></li>';
		echo '</ul>';
	}
}
loggedinstatus();
?>