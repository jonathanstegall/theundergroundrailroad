<?php
	// the template class
	require_once $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/templateclass.php';
	$page = new Page("../../templates/admintemplate.php");
	$page->
		// use the page class to insert the values for the page
		replace_tags (
			array (
				// title tag
				"title" => "../../includes/functions/writetitles.php",
				// keywords
				"keywords" => "../../includes/functions/writekeywords.php",
				// description
				"description" => "../../includes/functions/writedescriptions.php",
				// header
				"header" => "../../includes/adminheader.php",
				// the main nav
				"navigation" => "../../includes/functions/writeadminnav.php",
				// logged in status
				"loggedinstatus" => "../../includes/functions/loggedinstatus.php",
				// main content area
				"content" => "../../includes/functions/writeadmincontent.php",
				// sub content area
				"subcontent" => "../../includes/adminsubcontent.php",
				// footer
				"footer" => "../../includes/adminfooter.php",
			)
		);
	// output the values
	$page->output();
?>