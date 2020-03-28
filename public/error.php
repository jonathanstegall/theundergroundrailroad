<?php

$page_redirected_from = $_SERVER['REQUEST_URI'];  // this is especially useful with error 404 to indicate the missing page.
$server_url = "http://" . $_SERVER["SERVER_NAME"] . "/";
$redirect_url = $_SERVER["REDIRECT_URL"];
$redirect_url_array = parse_url($redirect_url);
$end_of_path = strrchr($redirect_url_array["path"], "/");

switch(getenv("REDIRECT_STATUS"))
{
	# "400 - Bad Request"
	case 400:
	$error_code = "400 - Bad Request";
	$explanation = "The syntax of the URL submitted by your browser could not be understood.  Please verify the address and try again.";
	$redirect_to = "";
	break;

	# "401 - Unauthorized"
	case 401:
	$error_code = "401 - Unauthorized";
	$explanation = "This section requires a password or is otherwise protected.  If you feel you have reached this page in error, please return to the login page and try again, or contact the webmaster if you continue to have problems.";
	$redirect_to = "";
	break;

	# "403 - Forbidden"
	case 403:
	$error_code = "403 - Forbidden";
	$explanation = "This section requires a password or is otherwise protected.  If you feel you have reached this page in error, please return to the login page and try again, or contact the webmaster if you continue to have problems.";
	$redirect_to = "";
	break;

	# "404 - Not Found"
	case 404:
	$error_code = "404 - Not Found";
	$explanation = "The requested resource '" . $page_redirected_from . "' could not be found on this server.  Please verify the address and try again.";
	$redirect_to = $server_url . "wiki" . $end_of_path;
	break;

	# "500 - Internal Server Error"
	case 500:
	$error_code = "500 - Internal Server Error";
	$explanation = "The server experienced an unexpected error.  Please verify the address and try again.";
	$redirect_to = "";
	break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="Shortcut Icon" href="/favicon.ico" type="image/x-icon" />
<title>Page not found:<?php print ($redirect_to); ?></title>
<meta name="keywords" content="{keywords}" />
<meta name="description" content="{description}" />
<meta name="author" content="The Underground Railroad" />
<script src="javascripts/flashobject.js" type="text/javascript"></script>
<style type="text/css" media="screen">
	@import "http://www.theundergroundrailroad.org/css/main.css";
</style>
<link rel="stylesheet" type="text/css" media="print" href="css/print.css" />
<script type="text/javascript" src="javascripts/scripts.js"></script>
<!--
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-564949-1";
urchinTracker();
</script>
-->
</head>
<body id="{pageID}">
<div id="all">
  <div id="header">
    <?php include ("../includes/header.php"); ?>
  </div>
  <div id="container" class="clearfix">
    <div id="navigation">
      <?php include ("../includes/mainnav.php"); ?>
    </div>
    <div id="content">
      <h1>Error Code <?php print ($error_code); ?></h1>
      <p>The <a href="http://en.wikipedia.org/wiki/Uniform_resource_locator">URL</a> you requested was not found. <?PHP echo($explanation); ?></p>
      <p><strong>Did you mean to type <a href="<?php print ($redirect_to); ?>"><?php print ($redirect_to); ?></a>?</strong> You will be automatically redirected there in five seconds.</p>
      <p>You may also want to try starting from the home page: <a href="<?php print ($server_url); ?>"><?php print ($server_url); ?></a></p>
      <hr />
      <p><i>A project of <a href="<?php print ($server_url); ?>"><?php print ($server_url); ?></a>.</i></p>
    </div>
    <div id="subcontent">
      <?php include ("../includes/subcontent.php"); ?>
    </div>
  </div>
  <div id="footer">
    <?php include ("../includes/footer.php"); ?>
  </div>
</div>
</body>
</html>
