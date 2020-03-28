<?php
// check to see if the user is logged in
include("../../includes/login.php");
// if the session is found
if(isset($_SESSION['logged_in'])==true) {
	// admin template class
	require_once("../../includes/classes/admintemplateclass.php");
	$page = new Page("../../templates/admintemplate.php");
	
	$page->
		// use the page class to insert the values from above
		replace_tags (
			array (
				// body id
				"pageID" => "admincontact",
				// title tag
				"title" => "Contact Webmaster - Admin - The Underground Railroad",
				// header
				"header" => "../../includes/adminheader.php",
				// left
				"left" => "../../includes/adminleftnav.php",
				// main content area
				"content" => "content/contact.php",
				// right content area
				"right" => "../../includes/rightcontent.php",
				// footer
				"footer" => "../../includes/adminfooter.php",
			)
		);
	// output the values
	$page->output();
	
} else {
	// if the session value does not exist - this should never be seen, as it should be caught elsewhere
	echo 'you are not logged in, and cannot access this page';
}
?>