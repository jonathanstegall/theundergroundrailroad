<?php 

// connect to database  
$db_host = 'mysql.theundergroundrailroad.org'; // db server 
$db_user = 'underground_web'; // username 
$db_pass = 'o?vzK#j4NM'; // password 
$db_login = 'underground_members'; // select database 
$db_main = 'underground_main'; // select database
$db_ministries = 'underground_ministries'; // select database
$db_handbook = 'underground_handbook'; // select database


$mysql_access = mysql_connect("$db_host", "$db_user", "$db_pass") or die
	('Error connecting to mysql');
// if errors die and display error 
if(!$mysql_access) die("Connection Failed.");

?>