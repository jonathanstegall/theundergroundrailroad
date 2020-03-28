<?php
class adminTask {
	var $task;
	var $page;
	function adminTask() {
		$task = '';
		$page = $_GET['page'];
		$task = $_GET['task'];
		if (!$task) {
			$this->listTasks();
		} else {
			// if validate function carries out, continue writing the function
			if ($this->validateTask($task,$page)) {
				//write the task if it is valid
				$this->writeTask($task);
			} else {
				// if it's not, it's an error
				return false;
			}
		}
	}
	function validateTask($task) {
		$taskquery = "SELECT * FROM tbl_subPages WHERE adminTaskName = '$task'";
		$taskresult=mysql_query($taskquery);
		$tasknum=mysql_num_rows($taskresult);
		if ($tasknum == 1) {
			return true;
		} else {
			echo '<p class="queryError">You have attempted an invalid task. Please try again.</p>';
			//return false;
		}
	}
	function listTasks() {
		$userlevel = userLevel();
		//echo $userlevel;
		//echo 'no task in query string';
		$page = $_GET['page'];
		$pagequery = "SELECT * FROM tbl_mainPages WHERE pageName = '$page' AND isLoggedOut = '0'";
		$pageresult=mysql_query($pagequery);
		$pagenum=mysql_num_rows($pageresult);
		badQuery($pagenum);
		if ($pagenum == 0) {
			echo '<p class="queryError">You are on a page that does not exist. Please try again.</p>';
		} else {
			// and make tasks out of them
			$i=0;
			for ($i = 0; $i < $pagenum; $i++) {
				$pageid=mysql_result($pageresult,$i,"pageID");
			}
			$taskquery = "SELECT * FROM tbl_subPages WHERE adminTaskPageID = '$pageid' AND pageUserLevel <= '$userlevel' AND showTaskInList=1";
			$taskresult=mysql_query($taskquery);		
			$tasknum = mysql_num_rows($taskresult);
			if ($tasknum != 0) {
				echo "<ul class=\"taskList\">\n";
				$y=0;
				for ($y = 0; $y < $tasknum; $y++) {
					$userlevel=mysql_result($taskresult,$y,"pageUserLevel");
					$tasklink=mysql_result($taskresult,$y,"adminTaskName");
					$taskname=mysql_result($taskresult,$y,"adminTaskNavigationName");
					$url = 'http://www.towngreeters.com/admin/?page='.$page.'&amp;task='.$tasklink.'';
					echo "<li><a href=\"$url\">$taskname</a></li>\n";
				};
				echo "</ul>\n";
			} else {
				return '<p class="queryError">No tasks are associated with this page.</p>';
			}
		}
	}
	function writeTask($task) {
		//echo '<p>this task, '.$task.', is a valid task</p>';
		$taskquery = "SELECT * FROM tbl_subPages WHERE adminTaskName = '$task'";
		$taskresult=mysql_query($taskquery);
		$tasknum=mysql_num_rows($taskresult);
		$badquery = badQuery($tasknum);
		// and make pages out of them
		$i=0;
		for ($i = 0; $i < $tasknum; $i++) {
			$adminTaskID=mysql_result($taskresult,$i,"adminTaskID");
			$adminTaskName=mysql_result($taskresult,$i,"adminTaskName");
			$taskbody=mysql_result($taskresult,$i,"adminTaskBody");
			$taskcode=mysql_result($taskresult,$i,"adminTaskCode");
		}
		// get the page and the tasks associated with it
		if (!$badquery) {
			// include the task code
			if ($taskbody) {
				echo $taskbody;
			}
			eval($taskcode);
		} else {
			return;
		}
	}
};
?>