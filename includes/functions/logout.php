<?php
function logout() {
	require_once($_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/session.class.php');
	session_destroy();
	header("location: index.php");
}
logout();
?>