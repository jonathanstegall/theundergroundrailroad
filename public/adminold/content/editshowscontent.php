<?php
	// display the logout message if the session exists
	include("../../includes/loggedinstatus.php");
	loggedinstatus();
?>

<h2>edit shows:</h2>
<p>Here, you can edit the shows that are currently stored. Information will display in a way that allows you to only edit the information necessary, so remember to leave the rest the same.</p>
<p>An example of this is the show's time. If a show is listed at 7:00 pm and is changed to 8:00 pm, keep the pm at the end. Whatever information is added is what will display on the page.</p>
<?php
	include("../../includes/adminfunctions/editshowsfunction.php");
	//editNews();	
?>
