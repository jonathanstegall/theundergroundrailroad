<?php
// inside the navigation div
	// get page from querystring
	$currentPage = $_GET['page'];
		if (!$currentPage) {
			$currentPage = 'home';
		};
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
		$userlevel=mysql_result($userresult,$i,"userAdminLevel");
	}
	if ($usernum == 0) {
		$userlevel = 0;
	}
	//echo $userlevel;
	switch ($userlevel){
		case 0:
			//echo $userlevel;
			// get all the items
			$userlevel = userLevel();
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
			mysql_select_db($db_main) or die(mysql_error());
			$navquery = "SELECT * from tbl_mainPages WHERE pageUserLevel <= '$userlevel' AND inMainNav = 1 OR isLoggedOut = 1 AND inMainNav = 1";
			$navresult=mysql_query($navquery);
			$navnum=mysql_num_rows($navresult);
			// and make list items out of them
			echo '<ul id="nav">';
				include $_SERVER['DOCUMENT_ROOT'] . '/../includes/adminnavlinks.php';
				echo '<li><a href="http://www.towngreeters.com/">Return to TownGreeters</a></li>';
			echo "</ul>\n";
			break;	
		case 1:
			//echo 'you are level 1';
			// get all the items
			$userlevel = userLevel();
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
			mysql_select_db($db_main) or die(mysql_error());
			$navquery = "SELECT * from tbl_mainPages WHERE pageUserLevel <= '$userlevel' AND isLoggedOut = 0 AND inMainNav = 1";
			$navresult=mysql_query($navquery);
			$navnum=mysql_num_rows($navresult);
			// and make list items out of them
			echo '<ul id="nav">';
				include $_SERVER['DOCUMENT_ROOT'] . '/../includes/adminnavlinks.php';
			echo "</ul>\n";
			break;	
		case 2:
			//echo 'you are level 2';
			// get all the items
			$userlevel = userLevel();
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
			mysql_select_db($db_main) or die(mysql_error());
			$navquery = "SELECT * from tbl_mainPages WHERE pageUserLevel <= '$userlevel' AND isLoggedOut = 0 AND inMainNav = 1";
			$navresult=mysql_query($navquery);
			$navnum=mysql_num_rows($navresult);
			// and make list items out of them
			echo '<ul id="nav">';
				include $_SERVER['DOCUMENT_ROOT'] . '/../includes/adminnavlinks.php';
			echo "</ul>\n";
			break;	
		default:
			echo "<p class=\"queryError\">invalid access attempt</p>";
		break; 	
	}
// navigation div ends here
?>