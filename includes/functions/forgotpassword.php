<?php
function forgotPassword($username,$email,$formaction) {
	// form variables
	$formaction = $_SERVER['PHP_SELF'].'?page=forgotpassword';
	$username = $_POST['username'];
	$email = $_POST['email'];

	$question1 = "What city were you born in?";
	$question2 = "Where did you go to school?";
	$question3 = "What is your favorite sports team?";
	$question4 = "Where did you go to school?";

	$question = $_POST['question'];
	$answer = $_POST['answer'];
	// bring in form class
	include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/formprocessor.class.php';
	// xml form - the processor will validate this and take out invalid html fields after checking input
$form = <<<EOD
	<form class="form" action="$formaction" id="emailPasswordForm" method="post">
		<fieldset class="structure">
			<legend>Reset Password</legend>
		<errorlist>
		<ul class="errorList">
			<erroritem> <li><message /></li> </erroritem>
		</ul>
		</errorlist>
				<p>
					<label for="username">Username: </label>
					<input type="text" name="username" id="username" class="required" required="yes" validate="alpha" callback="uniqueName" size="20" /><error for="username"> <strong class="error">!</strong></error>
					<errormsg field="username" test="required">You did not enter your username</errormsg>
					<errormsg field="username" test="alpha">Your username must consist <em>only</em> of letters</errormsg>
				</p>
				 <p>
					<label for="email">Email: </label>
					<input type="text" name="email" id="email" class="required" required="yes" validate="email" size="20" /><error for="email"> <strong class="error">!</strong></error>
					<errormsg field="email" test="required">You must provide an email address</errormsg>
					<errormsg field="email" test="validate">Your email address is invalid</errormsg>
				</p>
				<p><label for="question">Security Question: </label>
				<select name="question" id="question">
					<option value="" selected="selected">Choose a question</option>
					<option value="$question1">$question1</option>
					<option value="$question2">$question2</option>
					<option value="$question3">$question3</option>
					<option value="$question4">$question4</option>
				</select>
				</p>
				
				<p>
					<label for="answer">Answer: </label>
					<input type="text" name="answer" id="answer" class="required" required="yes" validate="alpha" size="20" /><error for="answer"> <strong class="error">!</strong></error>
					<errormsg field="answer" test="required">You did not enter your answer</errormsg>
					<errormsg field="answer" test="alpha">Your answer must consist <em>only</em> of letters</errormsg>
				</p>
				<p class="submit">
					<input type="submit" name="submit" id="submit" value="Send Your Password" />
				</p>	
			</fieldset>
	</form>
EOD;
	function uniqueName($email) {
		return true;
	}
	$processor =& new FormProcessor($form);
	// if form validates
	if ($processor->validate()) {
		// send the password
		include ($_SERVER['DOCUMENT_ROOT'] . '/../includes/loginconstants.php');
		$emailquery = "SELECT * from tbl_users WHERE email = '$email' AND username = '$username'";
		$emailresult = mysql_query($emailquery) or die(mysql_error());
		$emailnum=mysql_num_rows($emailresult);
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/question.class.php';
		$questionclass =& new question();
		$answervalue = $questionclass->checkQuestion($question,$answer);	
		//$answervalue = checkQuestion($question,$answer);
		if ($answervalue == 1) {
		//echo $emailnum;
			$x=0;
			if ($x < $emailnum) {
				include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/password.class.php';
				$password =& new password();
				$reset = $password->createRandomPassword();	
				//echo $reset;
				$password->resetPassword($email,$reset);
				$password->emailPassword($reset,$email);
				echo '<p class="queryResult">Your password has been reset. The new one has been emailed to you.</p>';
			}
		} else {
			$answer = '';
			echo $answervalue;
			$processor->display();
		}
	} else {
		$processor->display();
	}
}
?>