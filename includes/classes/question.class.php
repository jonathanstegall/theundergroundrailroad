<?php
class question {
	function question() {
		
	}
	function checkQuestion($question,$answer) {
		// database info
		//echo $question;
		include ($_SERVER['DOCUMENT_ROOT'] . '/../includes/loginconstants.php');
		$questionquery = "SELECT * from tbl_users WHERE userQuestion = '$question'";
		$questionresult = mysql_query($questionquery) or die(mysql_error());
		$questionnum=mysql_num_rows($questionresult);
		$x=0;
		if ($x < $questionnum) {
			$validquestion=mysql_result($questionresult,$x,"userQuestion");
			define('SALT_LENGTH', 9);
			// get the password from the database
			$hashquery="SELECT userAnswer FROM tbl_users WHERE userQuestion='$validquestion'";
			$hashresult=mysql_query($hashquery);
			$hashnum = mysql_num_rows($hashresult) or die(mysql_error());
			$i=0;
			for ($i = 0; $i < $hashnum; $i++) {
				$validanswer=mysql_result($hashresult,$i,"userAnswer");
			}
			
			// create a hash from the form value of validanswer
			function generateQuestionHash($answer, $salt = null) {
				if ($salt === null) {
					$salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
				} else {
					$salt = substr($salt, 0, SALT_LENGTH);
				}
				return $salt . sha1($salt . $answer);
			}
			// see if it matches the hash in the database
			$mainhash = generateQuestionHash($answer, $validanswer);
			//echo $mainhash;
			if ($mainhash == $validanswer) {
				return true;
			} else {
				$status_msg .= "<ul class=\"errorList\"><li>answer failed</li></ul>";
				//echo $status_msg;
				return $status_msg;
			}
		} else {
			$status_msg .= "<ul class=\"errorList\"><li>question failed</li></ul>";
			return $status_msg;
		}
	}
	function changeAnswer($newanswer) {
		define('SALT_LENGTH', 9);
		// create a hash from the form value of pword
		function questionHash($newanswer, $salt = null) {
			if ($salt === null) {
				$salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
			} else {
				$salt = substr($salt, 0, SALT_LENGTH);
			}
			return $salt . sha1($salt . $newanswer);
		}
		// see if it matches the hash in the database
		$newhash = questionHash($newanswer);
		return $newhash;
	}
}
?>