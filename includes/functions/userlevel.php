<?php
function userLevel() {
	//echo 'hello';
	include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
	mysql_select_db($db_login) or die(mysql_error());
	$sessionid = session_id();
	//echo $sessionid;
	$userquery = "SELECT userAdminLevel FROM
		tbl_users
		INNER JOIN tbl_sessions
			ON tbl_users.username = tbl_sessions.username

		WHERE tbl_sessions.ses_id='$sessionid'
	";
	$userresult=mysql_query($userquery);
	$usernum = mysql_num_rows($userresult);
	$i=0;
	for ($i = 0; $i < $usernum; $i++) {
		global $userlevel;
		$userlevel=mysql_result($userresult,$i,"userAdminLevel");
		return $userlevel;
	}
	if ($usernum == 0) {
		global $userlevel;
		$userlevel = 0;
	}
}
?>