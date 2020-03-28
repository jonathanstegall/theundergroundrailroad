<?php
	// display the logout message if the session exists
	include("../../includes/loggedinstatus.php");
	loggedinstatus();
?>

<h2>edit links:</h2>
<p>Here, you can edit the links for the links page. Again, categories can be added as necessary, and please, make sure the http:// stays as part of the value that is submitted.</p>
<?php
	include("../../includes/adminfunctions/editlinksfunction.php");
	//editNews();	
?>
