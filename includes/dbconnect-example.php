<?php 

// map key
$key = '';

// connect to database  
$db_host = ''; // db server 
$db_user = ''; // username 
$db_pass = ''; // password 
$db_login = ''; // select database 
$db_main = ''; // select database

$mysql_access = mysql_connect("$db_host", "$db_user", "$db_pass") or die
	('Error connecting to mysql');
// if errors die and display error 
if(!$mysql_access) die("Connection Failed.");
?>