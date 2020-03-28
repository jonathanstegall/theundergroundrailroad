<?php
	// the template class
	require_once $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/template.class.php';
	$page = new Page("../templates/maintemplate.php");
	$page->
		// use the page class to insert the values for the page
		replace_tags (
			array (
				// title tag
				"title" => "../includes/functions/writetitles.php",
				// meta description
				"description" => "../includes/functions/writedescriptions.php",
				// meta keywords
				"keywords" => "../includes/functions/writekeywords.php",
				// functions for specific stuff
				"contenthead" => "../includes/functions/writespecifichead.php",
				// header
				"header" => "../includes/header.php",
				// the main nav
				"navigation" => "../includes/functions/writemainnav.php",
				// main content area
				"content" => "../includes/functions/writecontent.php",
				// sub content area
				"subcontent" => "../includes/subcontent.php",
				// adsense area
				"adsense" => "../includes/adsense.php",
				// footer
				"footer" => "../includes/footer.php",
			)
		);
	// output the values
	$page->output();
?>
