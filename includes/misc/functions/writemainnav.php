<?php
function writeMainNav() {
	// get category from querystring
	$category = $_GET['category'];
	if (!$category) {
		$category = 'main';
	}
	$currentPage = $_GET['page'];
	if (!$currentPage) {
		$currentPage = 'home';
	}
	// find the matching category in the database
	$categoryquery = "SELECT * from tbl_mainCategory WHERE mainCategoryName = '$category'";
	$categoryresult = mysql_query($categoryquery);
	$categorynum=mysql_num_rows($categoryresult);
	// for the matching categories, get the id that matches the name
	$x=0;
	for ($x = 0; $x < $categorynum; $x++) {
		$catid=mysql_result($categoryresult,$x,"mainCategoryID");
		$catname=mysql_result($categoryresult,$x,"mainCategoryName");
		// begin the navigation div with the proper id
		echo '<div id="nav';
		echo $catname;
		//echo 'section"><span class="hidden">'."$catname".'</span></div>';
		echo 'section"></div>';
	}
	// if the id matches, get all the items
	$navquery = "SELECT * from tbl_mainPages WHERE pageCategory = '$catid'";
	$navresult=mysql_query($navquery);
	$navnum=mysql_num_rows($navresult);
	// and make list items out of them
	echo '<ul id="nav">';
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/navlinks.php';
	echo "</ul>\n";
};
writeMainNav();
?>