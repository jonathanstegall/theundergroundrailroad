<?php
// bring in session class
require_once($_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/session.class.php');
if (isset($_SESSION['logged_in'])==true) {
	include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/userlevel.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/../includes/mainconstants.php';
	include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/writeadmintemplate.php';
} else {
	// call login function
	$page = $_GET['page'];
	if ($page == 'forgotpassword') {
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/pages/forgotpassword.php';
	} else {
		require_once($_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/login.php');
		login($username,$formaction);
	}
}
?>