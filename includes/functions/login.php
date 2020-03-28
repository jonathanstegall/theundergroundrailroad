<?php
function login($username,$formaction) {
	// form variables
	$formaction = $_SERVER['PHP_SELF'];
	$username = $_POST['username'];
	$pword = $_POST['pword'];
	// bring in form class
	include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/formprocessor.class.php';
	// xml form - the processor will validate this and take out invalid html fields after checking input
$form = <<<EOD
	<form class="form" action="$formaction" id="loginForm" method="post">
		<errorlist>
		<ul class="errorList">
			<erroritem> <li><message /></li> </erroritem>
		</ul>
		</errorlist>
		<fieldset class="structure">
			<legend>Login</legend>
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
					<input type="submit" name="submit" id="submit" value="Login" />
				</p>
				<p class="forgotPass"><a href="index.php?page=forgotpassword">forgot password?</a></p>
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
		require_once($_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/account.class.php');
		$account =& new account($username,$pword);
		$authvalue = $account->checkUser($username,$pword);
		// if it is authorized
		 if ($authvalue == 1) {
			// session value of logged in for the user
			$_SESSION['logged_in'] = true;
			$sessionid = session_id();
			// add the username to the database
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
			mysql_select_db($db_login) or die(mysql_error());
			$adduser = "UPDATE tbl_sessions SET username='$username' WHERE ses_id='$sessionid'";
			$result = mysql_query($adduser) or die(mysql_error());
			// send them back to the page where they tried to login
			$destination = $_SERVER['SCRIPT_NAME'];
			if (!$page) {
				// or to the home page, if they weren't somewhere else
				$destination = 'index.php?page=home';
			}
			header("Location: ".$destination);
		} else {
			// or tell them what they did wrong inside the template html
			function userLevel() {
				$userlevel = 0;
				return $userlevel;
			}
			echo $status_msg;
			?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="content-type" content="text/html; charset=utf-8" />
			<title>Towngreeters.com Admin</title>
			<link rel="stylesheet" type="text/css" media="screen" href="http://www.towngreeters.com/css/admin.css" />
			</head>
			<body>
			<div id="all">
			  <div id="header">
				<?php include $_SERVER['DOCUMENT_ROOT'] . '/../includes/adminheader.php'; ?>
			  </div>
			  <div id="navigation"> <?php include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/writeadminnav.php'; ?> </div>
			  <div id="content">
				<?php
					include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/writeadmincontent.php';
				?>
			 </div>
			  <div id="footer"> <?php include $_SERVER['DOCUMENT_ROOT'] . '/../includes/adminfooter.php'; ?> </div>
			</div>
			</body>
			</html>
			<?php
		}
	} else {
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/userlevel.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Towngreeters.com Admin</title>
<link rel="stylesheet" type="text/css" media="screen" href="http://www.towngreeters.com/css/admin.css" />
</head>
<body>
<div id="all">
  <div id="header">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/../includes/adminheader.php'; ?>
  </div>
  <div id="navigation"> <?php include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/writeadminnav.php'; ?> </div>
  <div id="content">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/writeadmincontent.php'; ?>
  </div>
  <div id="footer"> <?php include $_SERVER['DOCUMENT_ROOT'] . '/../includes/adminfooter.php'; ?> </div>
</div>
</body>
</html>
<?php	
	}
}
?>