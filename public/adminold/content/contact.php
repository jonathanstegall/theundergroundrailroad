<?php
	// display the logout message if the session exists
	include("../../includes/loggedinstatus.php");
	loggedinstatus();
?>

<h2>contact webmaster:</h2>
<?php
 
$name_input = $_POST["name_input"];
$email_input = $_POST["email_input"];
$whattosay_input = $HTTP_POST_VARS["whattosay_input"];
$message_input = $_POST["message_input"];

if (!isset($_POST['submit_button'])) { // if page is not submitted to itself echo the form
?>
<p>should you need to contact the webmaster, jon stegall, concerning issues about this administration area, you can do so with this form. please be as descriptive as possible. thanks.</p>
<div id="mainformcontainer">
  <form method="post" class="form" action="<?php echo $PHP_SELF;?>">
    <fieldset>
    <legend>contact jon</legend>
    <label for="name_input">Name: </label>
    <input type="text" id="name_input" name="name_input" value="<? echo $name_input; ?>" />
    <br />
    <label for="email_input">Email: </label>
    <input type="text" id="email_input" name="email_input" value="<? echo $email_input; ?>" />
    <br />
    <input type="radio" id="whattosay_input" name="whattosay_input" class="box" value="Request For New Feature" />
    Request For New Feature<br />
    <input type="radio" id="whattosay_input" name="whattosay_input" value="Report a Problem" class="box" />
    Report a Problem<br />
    <label for="message_input">Description: </label>
    <textarea id="message_input" name="message_input" cols="20" rows="5" value="<? echo $message_input; ?>"></textarea>
    <br />
    <input type="submit" value="Submit" id="submit_button" name="submit_button" class="submit" />
    </fieldset>
  </form>
</div>
<?
} else { 

// only validate form when form is submitted
if(isset($submit_button)){
	$error_msg='';
	if(trim($name_input)=='') {
		$error_msg.="Please enter your name<br>";
	}
	$first_name_input = ucfirst(strtolower($name_input));
	if(trim($email_input)=='') {
		$error_msg.="Please enter an email<br>";
	} else {
		// check if email is a valid address in this format username@domain.com
		if(!ereg("[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]", $email_input)) $error_msg.="Please enter a valid email address<br>";
	}
	// display error message if any, if not, proceed to other processing
	if($error_msg==''){

// begin form processor
		$msg = "this email was sent from the refuge admin page\n\n";
		$msg .= "Name:  $name_input\n\n";
		$msg .= "Email Address: $_POST[email_input]\n\n";
		$msg .= "Request New Feature or Report a Problem? $_POST[whattosay_input]\n\n";
		$msg .= "Message: $_POST[message_input]\n";

/* customizes the email that is sent */
		$to = "nahtanoj83@yahoo.com";
		$subject = "Contact Form From The Underground Railroad Admin";
		$mailheaders = "From: refuge webmaster <nahtanoj83@yahoo.com> \n";
		$mailheaders .= "Reply-To: $_POST[email_input]\n";
		mail($to, $subject, $msg, $mailheaders);
			echo "<p class=\"success\">Thank you for helping further this administrative area. Your email was successfully sent as displayed below.</p>";

// end form processor
	} else {
		echo "<p class=\"errormessage\">$error_msg</p>";
	}
	} else {
		echo "<p class=\"errormessage\">$error_msg</p>";
	}
echo "<p class='emailsent'>".$name_input."<br />";
echo "Your <strong>".$whattosay_input."</strong> attempt was";
if ($error_msg=='') {
	echo " successful.<br>";
	echo "Your message was: ".$message_input."<br /><br />";
	echo "the webmaster will reply concerning your submission</p>";
	} else {
		echo " unsuccessful. Please try again.<br>";
	}
}
?>