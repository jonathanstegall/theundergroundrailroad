<?php
$adminemail = 'jonathan@jonathanstegall.com';
$thisdomain = 'http://www.theundergroundrailroad.org';

// get session class
$usertable = "tbl_users";
$sessiontable = "tbl_sessions";
$username = $_POST['username'];
include("../../includes/classes/sessionclass.php");
		// if the form is submitted
		if (isset($_POST['submit'])) {
			// validate it
			include("../../includes/classes/validationclass.php");
			$validateform = new validation;
			$validateform -> validate_login();
			$validationresults = $validateform->validate_login();
			// if there are no validation errors
			if ($validationresults == 1) {
				// run the login class
				include("../../includes/classes/loginclass.php");
				$submitform = new login;
				$submitform -> login();
				$loginvalue = $submitform->login();
				// if the login info is correct
				if ($loginvalue == 1) {
					// store it in the session
					$_SESSION['logged_in'] = true;
					include("../../includes/db_connect.php");
					mysql_select_db($db_login) or die(mysql_error());
		mysql_select_db($db_login) or die(mysql_error());
		$adduser = "UPDATE tbl_sessions SET username='$username'";
		$result = mysql_query($adduser) or die(mysql_error());

					// run the createpage function
					//createPage();
					return $_SESSION['logged_in'];
				} else {
					// if incorrect, display the error
					$message = $submitform->login();
				}
			} else {
				// if validation is incorrect, display that error
			if ($_SERVER['HTTP_X_FORWARD_FOR']) {
					$ip = $_SERVER['HTTP_X_FORWARD_FOR'];
					$domain = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				} else {
					$ip = $_SERVER['REMOTE_ADDR'];
					$domain = gethostbyaddr($_SERVER['REMOTE_ADDR']);
				}
				$message = '<p class="error">you have submitted invalid data</p>';
				$emailbody = "Invalid data was submitted from ".$ip." at ".$domain.". Please check into this.";
				$subject = "invalid data submitted at ".$thisdomain."!";
				$headers = 'BCC: nahtanoj83@yahoo.com'."\r\n";
				mail($adminemail, $subject, $emailbody, $headers);
			}
		} else {
		if (isset ($_SESSION['logged_in'])) {
			return $_SESSION['logged_in'];
		} else {
			// if form has not been submitted, display this message AND the html form
			$message = '<legend>Please submit the form</legend>';
		}
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Login - The Underground Railroad</title>
<meta name="robots" content="none" />
<script src="../javascripts/flashobject.js" type="text/javascript"></script>
<style type="text/css" media="screen">
	@import "../css/main.css";
	@import "../css/admin.css";
</style>
<link rel="stylesheet" type="text/css" media="print" href="../css/print.css" />
<!--[if lt IE 7]> 
<script src="../javascripts/dropdownfix.js" type="text/javascript" charset="utf-8"></script> 
<![endif]-->
<script type="text/javascript" src="../javascripts/scripts.js"></script>
</head>
<body>
<div id="all">
  <div id="header">
    <?php include("../../includes/adminheader.php"); ?>
  </div>
  <div id="container" class="clearfix">
    <div id="left">
      <?php include("../../includes/adminleftnav.php"); ?>
    </div>
    <div id="content">
      <form action="<?=$PHP_SELF?>" method="post" class="form">
        <fieldset>
        <?php echo $message;  ?>
        <label for="username">Username: </label>
        <input type="text" name="username" id="username" />
        <br />
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" />
        <input type="submit" value="submit" name="submit" id="submit" class="submit" />
        </fieldset>
      </form>
    </div>
    <div id="right">
      <?php include("../../includes/rightcontent.php"); ?>
    </div>
  </div>
  <div id="footer">
    <?php include("../../includes/adminfooter.php"); ?>
  </div>
</div>
</body>
</html>
