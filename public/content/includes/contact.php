<?php

include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/formprocessorclass.php';

$test = 'test';
$form = <<<EOD

	<form class="form" action="contact.php" id="form" method="post">
		<fieldset class="structure">
			<legend>Contact Us</legend>
		<errorlist>
		<ul class="errorList">
			<erroritem> <li><message /></li> </erroritem>
		</ul>
		</errorlist>
				<p>
					<label for="name">Name: </label>
					<input type="text" name="name" id="name" class="required" required="yes" validate="alpha" callback="uniqueName" size="20" /><error for="name"> <strong class="error">!</strong></error>
					<errormsg field="name" test="required">You did not enter your name</errormsg>
					<errormsg field="name" test="alpha">Your name must consist <em>only</em> of letters</errormsg>
				</p>
				 <p>
					<label for="email">Email: </label>
					<input type="text" name="email" id="email" class="required" required="yes" validate="email" size="20" /><error for="email"> <strong class="error">!</strong></error>
					<errormsg field="email" test="required">You must provide an email address</errormsg>
					<errormsg field="email" test="validate">Your email address is invalid</errormsg>
				</p>
				<p>
					<label for="pass1">Password: </label>
					<input type="password" name="pass1" id="pass1" required="yes" validate="alphanumeric" size="10" /><error for="pass1"> <strong class="error">!</strong></error>
					<errormsg field="pass1" test="required">You did not provide a password</errormsg>
					<errormsg field="pass1" test="validate">Your password must contain only letters and numbers</errormsg>
				</p>
				<p>
					<label for="pass2">Repeat password: </label>
					<input type="password" name="pass2" id="pass2" validate="alphanumeric" mustmatch="pass1" size="10" /><error for="pass2"> <strong class="error">!</strong></error>
					<errormsg field="pass2" test="mustmatch">The two passwords did not match</errormsg>
				</p>
				<p>
					<label for="dob">DOB [dd/mm/yyyy]: </label>
					<input type="text" name="dob" id="dob" required="yes" regexp="|^\d{1,2}\/\d{1,2}\/\d{4}$|" size="10" /><error for="dob"> <strong class="error">!</strong></error>
					<errormsg field="dob" test="regexp">Your DOB must be in the form dd/mm/yyyy</errormsg>
					<errormsg field="dob" test="required">You must provide a date of birth</errormsg>
				</p>
				<p>
					<label for="comments">Comments: </label>
					<textarea name="comments" id="comments" class="required" required="yes" validate="alphanumeric"></textarea>
				</p>
				<p class="submit">
					<input type="submit" name="submit" id="submit" value="Contact Us" />
				</p>	
			</fieldset>
	</form>

EOD;
function uniqueName($name) {
    return true;
}
$processor =& new FormProcessor($form);
if ($processor->validate()) {
echo '<h3>The following has been successfully submitted</h3>';
echo '<ul class="formValues">';
	array_pop($_POST);
	foreach ($_POST as $key => $value) {
		$key = ucfirst($key);
		echo "<li><strong>" . $key . ":</strong> " . $value . "</li>";
	}
echo '</ul>';
} else {
    $processor->display();
}
?>