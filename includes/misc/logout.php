<?php
function logout() {
	include("../../includes/classes/sessionclass.php");
	session_destroy();
	header("location: index.php");
}
?>