<?php	
	// if the id matches, get all the items
	$page = $_GET['page'];
	if (!$page) {
		$page = 'home';
	}
	require_once($_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/account.class.php');
	$account =& new account($username,$pword);
	// check the user, and write content based on their level
	$userlevel = userLevel();
	
	// if not logged in
	switch ($userlevel){
		case 0:
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/mainconstants.php';
			$pagequery = "SELECT * from tbl_mainPages WHERE pageName = '$page' AND isLoggedOut = '1' AND pageUserLevel = '$userlevel'";
			$pageresult=mysql_query($pagequery);
			$pagenum=mysql_num_rows($pageresult);
			// then write the pages for the query match (so they can see the home page, etc.
			if ($pagenum == 1) {
				$badquery = badQuery($pagenum);
				$badquery;
				$i=0;
				for ($i = 0; $i < $pagenum; $i++) {
					$pageID=mysql_result($pageresult,$i,"pageID");
					$body=mysql_result($pageresult,$i,"pageBody");
					$phpcode=mysql_result($pageresult,$i,"phpCode");
				}
				// get the page and the tasks associated with it
				if (!$badquery) {
					//echo $userlevel;
					echo $body;
					eval($phpcode);
				} else if ($badquery != false) {
					echo $badquery;
					$pagequery = "SELECT pageBody from tbl_mainPages WHERE pageName = '$page'";
					$pageresult=mysql_query($pagequery);
					$body = mysql_result($pageresult, 0);
					echo $body;
					if ($phpcode) {
						eval($phpcode);
					}
				} else {
					echo '<p class="queryError">You are not recognized as a valid user. Please log in and try again.</p>';
				}
			// if the query did not match, they're not supposed to be on the page.
			} else {
				echo '<p class="queryError">You are not recognized as a valid user. Please log in and try again.</p>';
			}	
			break;	
		case 1:
			//echo 'you are level 1';
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
			mysql_select_db($db_main) or die(mysql_error());
			$pagequery = "SELECT * from tbl_mainPages WHERE pageName = '$page' AND isLoggedOut = '0' AND pageUserLevel <= '$userlevel'";
			$pageresult=mysql_query($pagequery);
			$pagenum=mysql_num_rows($pageresult);
			$badquery = badQuery($pagenum);
			$badquery;
			// and make pages out of them
			$i=0;
			for ($i = 0; $i < $pagenum; $i++) {
				$pageID=mysql_result($pageresult,$i,"pageID");
				$body=mysql_result($pageresult,$i,"pageBody");
				$phpcode=mysql_result($pageresult,$i,"phpCode");
				$showwithtasks=mysql_result($pageresult,$i,"showWithTasks");
			}
			// get the page and the tasks associated with it
			if (!$badquery) {
				$task = $_GET['task'];
				// if there's a task in the querystring, see if it should also show the page body
				if ($task) {
					// if the page content should be shown when the task is loaded, show it
					if ($showwithtasks == 1) {
						echo $body;
						if ($phpcode) {
							eval($phpcode);
							include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/admintask.class.php';
							$admintask = new adminTask;
						}
					// if not, just load the tasks
					} else if ($showwithtasks == 0) {
						// see if it's valid, and if it is, write it
						include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/admintask.class.php';
						$admintask = new adminTask;
					}
				// if there's no task in the querystring, just show the body and list the tasks
				} else {
					echo $body;
					if ($phpcode) {
						eval($phpcode);
					}
					include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/admintask.class.php';
					$admintask = new adminTask;
				}
			} else if ($badquery != false) {
				echo $badquery;
				$pagequery = "SELECT pageBody from tbl_mainPages WHERE pageName = '$page'";
				$pageresult=mysql_query($pagequery);
				$body = mysql_result($pageresult, 0);
				echo $body;
				if ($phpcode) {
					eval($phpcode);
				}
				$task = $_GET['task'];
				// see if it's valid, and if it is, write it
				include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/admintask.class.php';
			} else {
				return;
			}
			break;	
		case 2:
			//echo 'you are level 2';
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
			mysql_select_db($db_main) or die(mysql_error());
			$pagequery = "SELECT * from tbl_mainPages WHERE pageName = '$page' AND isLoggedOut = '0' AND pageUserLevel <= '$userlevel'";
			$pageresult=mysql_query($pagequery);
			$pagenum=mysql_num_rows($pageresult);
			$badquery = badQuery($pagenum);
			// and make pages out of them
			$i=0;
			for ($i = 0; $i < $pagenum; $i++) {
				$pageID=mysql_result($pageresult,$i,"pageID");
				$showwithtasks=mysql_result($pageresult,$i,"showWithTasks");
				$body=mysql_result($pageresult,$i,"pageBody");
				$phpcode=mysql_result($pageresult,$i,"phpCode");
			}
			// get the page and the tasks associated with it
			if (!$badquery) {
				$task = $_GET['task'];
				// if there's a task in the querystring, see if it should also show the page body
				if ($task) {
					// if the page content should be shown when the task is loaded, show it
					if ($showwithtasks == 1) {
						echo $body;
						if ($phpcode) {
							eval($phpcode);
							include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/admintask.class.php';
							$admintask = new adminTask;
						}
					// if not, just load the tasks
					} else if ($showwithtasks == 0) {
						// see if it's valid, and if it is, write it
						include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/admintask.class.php';
						$admintask = new adminTask;
					}
				// if there's no task in the querystring, just show the body and list the tasks
				} else {
					echo $body;
					if ($phpcode) {
						eval($phpcode);
					}
					include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/admintask.class.php';
					$admintask = new adminTask;
				}
			} else {
				return;
			}
			break;	
		default:
			echo '<p class="queryError">You are not recognized as a valid user. Please log in and try again.</p>';
		break; 	
	}
?>