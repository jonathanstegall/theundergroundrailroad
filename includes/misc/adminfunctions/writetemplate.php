<?php
	// the template class
	require_once $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/templateclass.php';
	$page = new Page("../../templates/admintemplate.php");
	$page->
		// use the page class to insert the values from above
		replace_tags (
			array (
				// body id
				"pageID" => "main_home",
				// title tag
				"title" => "../../includes/functions/writetitles.php",
				// keywords
				"keywords" => "../../includes/functions/writekeywords.php",
				// description
				"description" => "../../includes/functions/writedescriptions.php",
				// header
				"header" => "../../includes/header.php",
				// the main nav
				"navigation" => "../../includes/functions/writemainnav.php",
				// main content area
				"content" => "../../includes/functions/writemaincontent.php",
				// sub content area
				"subcontent" => "../../includes/subcontent.php",
				// footer
				"footer" => "../../includes/footer.php",
			)
		);
	// output the values
	$page->output();
?>