<?php
class account {
	var $task;
	function account($username,$pword) {
		if (isset($_SESSION['logged_in'])==true) {
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/loginconstants.php';
			$sessionid = session_id();
			$userquery = "SELECT * FROM
				tbl_users
				INNER JOIN tbl_sessions
					ON tbl_users.username = tbl_sessions.username
			
				WHERE tbl_sessions.ses_id='$sessionid'
			";
			$userresult=mysql_query($userquery);
			$usernum = mysql_num_rows($userresult) or die(mysql_error());
			$i=0;
			for ($i = 0; $i < $usernum; $i++) {
				$loggedinuser=mysql_result($userresult,$i,"username");
			}
			$task = $_GET['task'];
		} else {
			return;
		}
	}
	function checkUser($username,$pword) {
		// database info
		include ($_SERVER['DOCUMENT_ROOT'] . '/../includes/loginconstants.php');
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
				$status_msg .= "<ul class=\"errorList\"><li>password failed</li></ul>";
				return $status_msg;
			}
		} else {
			$status_msg .= "<ul class=\"errorList\"><li>username failed</li></ul>";
			return $status_msg;
		}
	}
	function editaccount($username) {
		$posteduser = $_POST['username'];
		if ($username == $posteduser) {
			$newemail = $_POST['newemail'];
			$oldpassword = $_POST['oldpassword'];
			$newpassword = $_POST['newpassword'];
			$newquestion = $_POST['userquestion'];
			if ($newquestion == "Choose a Question") {
				echo '<p class="queryError">You did not choose a question. Please try again.</p>';
				return false;
			} else {
				$newanswer = $_POST['newanswer'];
				include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/password.class.php';
				$password =& new password();
				$checkpassword = $password->checkOldPassword($oldpassword,$username);	
				if ($checkpassword == 1) {
					$changepassword = $password->changePassword($newpassword);
					include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/question.class.php';
					$questionclass =& new question();
					$changeanswer = $questionclass->changeAnswer($newanswer);
					$edituserquery = "UPDATE tbl_users SET email='$newemail', password='$changepassword', userQuestion='$newquestion', userAnswer='$changeanswer' WHERE username='$username'";
					$edituserresult = mysql_query($edituserquery) or die(mysql_error());
					echo '<p class="queryResult">Your account was successfully edited.</p>';
				}
			}
		} else {
			echo '<p class="queryError">You are not a recognized user.</p>';
		}
	}
	function deleteaccount($username) {
		$posteduser = $_POST['username'];
		if ($username == $posteduser) {
			$deletequery = "DELETE from tbl_users WHERE username = '$username'";
			$deleteresult = mysql_query($deletequery) or die(mysql_error());
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/logout.php';
		} else {
			echo '<p class="queryError">You are not a recognized user.</p>';
		}
	}
}
?>