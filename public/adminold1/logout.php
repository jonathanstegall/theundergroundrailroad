<?php
/*
* logout.php
* class_session.php example logout
* Author: Troy Wolf (troy@troywolf.com)
*/

/*
Include the class. Modify path according to where you put the class file.
*/
require_once($_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/session.class.php');

/*
Instantiate a new session object. If session exists, it will be restored,
otherwise, a new session will be created--placing a sid cookie on the user's
computer.
*/
if (!$s = new session()) {
  /*
  There is a problem with the session! The class has a 'log' property that
  contains a log of events. This log is useful for testing and debugging.
  */
  echo "<h2>There is a problem with the session!</h2>";
  echo $s->log;
  exit();
}

/*
You can expire the session which clears the session data, deletes the
session cache file from your web server's hard drive, and expires the sid
cookie on the user's computer.
*/
$s->expire();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title>class_session.php example logout</title>
  <style>
  body {
    font-family:"Trebuchet MS","Arial";
    font-size:11pt;
  }
  h1 {
    margin:10px 0px 5px 0px;
  }
  </style>
  </head>
  <body>
  
  <h2>class_session example logout</h2>
  Your session has ended. You have been logged out.
  <p><a href="example.php">home</a></p>
  
  </body>
</html> 