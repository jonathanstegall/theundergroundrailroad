<?php
// bring in session class
require_once($_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/session.class.php');
// start session class
if (!$s = new session()) {
	// show errors if there are any
	echo "<h2>There is a problem with the session!</h2>";
	echo $s->log;
	exit();
}
// bring in form class
include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/formprocessor.class.php';
// form variables
$formaction = $_SERVER['PHP_SELF'];
$username = $_POST['username'];
$pword = $_POST['pword'];
// xml form - the processor will validate this and take out invalid html fields after checking input
$form = <<<EOD
	<form class="form" action="$formaction" id="login" method="post">
		<fieldset class="structure">
			<legend>Login</legend>
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
					<label for="pword">Password: </label>
					<input type="password" name="pword" id="pword" required="yes" validate="alphanumeric" size="10" /><error for="pword"> <strong class="error">!</strong></error>
					<errormsg field="pword" test="required">You did not provide a password</errormsg>
					<errormsg field="pword" test="validate">Your password must contain only letters and numbers</errormsg>
				</p>
				<p class="submit">
					<input type="submit" name="submit" id="submit" value="Contact Us" />
				</p>	
			</fieldset>
	</form>

EOD;
function uniqueName($username) {
    return true;
}

$processor =& new FormProcessor($form);
// if form validates
if ($processor->validate()) {
	// authorize the login
	require_once($_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/authorize.php');
	$authvalue = Authorize($username,$pword);
	// if it is authorized
	 if ($authvalue == 1) {
		// session value of logged in for the user
		$s->data['logged_in'] = true;
		// store the username
		$s->data['username'] = $username;
		// get original destination
		$dest = $s->data['page_destination'];
		unset($s->data['page_destination']);
		$s->save();
		// redirect to original destination
		//header("Location: ".$dest);
		echo $username;
		echo $s->data['logged_in'];
		echo '<br>';
		echo '<a href="logout.php">logout</a>';
    } else {
		// or tell them what they did wrong
		echo $authvalue;
		$processor->display();
	}
} else {
    $processor->display();
}
?>