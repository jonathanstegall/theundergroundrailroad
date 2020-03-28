<?php
	// display the logout message if the session exists
	include("../../includes/loggedinstatus.php");
	loggedinstatus();

	include("../../includes/db_connect.php");
	
	include("../../includes/classes/deleteclass.php");
	$delete = new delete;
	
	if($_GET["cmd"]=="deleteshow") {
		$delete -> deleteShow();
	}
	if($_GET["cmd"]=="deletenews") {
		$delete -> deleteNews();
	}
	if($_GET["cmd"]=="deletelink") {
		$delete -> deleteLink();
	}

?>