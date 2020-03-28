<?php
function userLevel() {
	$userlevel = 0;
	return $userlevel;
}
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
    <p>If you have forgotten your password, you will need to supply us with information so that we can verify your user status. Upon this verification, your password will be reset, and an email will be sent to you containing the new password.</p>
    <p><strong>Please note that you will not receive your current password, but you can change the new one when you receive it.</strong></p>
    <?php
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/forgotpassword.php';
		forgotPassword($username,$email,$formaction);
	?>
  </div>
  <div id="footer">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/../includes/adminfooter.php'; ?>
  </div>
</div>
</body>
</html>