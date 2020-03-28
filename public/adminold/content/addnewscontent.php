<?php
	// display the logout message if the session exists
	include("../../includes/loggedinstatus.php");
	loggedinstatus();
?>

<h2>add news:</h2>
<p>News appears on the home page, and can be added with this form.</p>
<?php
	include("../../includes/adminfunctions/addnewsfunction.php");
	addNews();
?>
