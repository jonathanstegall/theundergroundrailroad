<?php 
// connect to database  
$db_host = 'mysql.theundergroundrailroad.org'; // db server 
$db_user = 'underground_web'; // username 
$db_pass = 'o?vzK#j4NM'; // password 
$db_login = 'db_undergroundmembers'; // select database 
$db_main = 'db_undergroundmain'; // select database

$mysql_access = mysql_connect("$db_host", "$db_user", "$db_pass") or die
	('Error connecting to mysql');
// if errors die and display error 
if(!$mysql_access) die("Connection Failed.");
?>