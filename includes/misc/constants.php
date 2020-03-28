<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
mysql_select_db($db_main) or die(mysql_error());
include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/badquery.php';
?>