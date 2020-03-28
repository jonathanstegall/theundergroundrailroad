<?php
//include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/badquery.php';
class constructor {
	function constructor() {
		$this->writeTemplate($userlevel);
		$this->databaseConnect();
	}
	function writeTemplate($userlevel) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/writetemplate.php';
	}
	function userLevel() {
		return '1';
	}
	function databaseConnect() {
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
		mysql_select_db($db_main) or die(mysql_error());
	}
}
?>