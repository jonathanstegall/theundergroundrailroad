<?php
	// display the logout message if the session exists
	include("../../includes/loggedinstatus.php");
	loggedinstatus();
?>
<h2>add shows</h2>
<p>Here, you can add shows to appear on the main shows page. The next five shows that will be occuring will also appear on the main home page. As the days pass, shows are automatically deleted when they are no longer in the future.</p>

<?php
	include("../../includes/adminfunctions/addshowsfunction.php");
	addShows();
?>


