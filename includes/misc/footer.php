<?php /* this is the interior of the footer div */ 
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
	}
	// if the id matches, get all the items
	$navquery = "SELECT * from tbl_mainPages WHERE pageCategory = '$catid'";
	$navresult=mysql_query($navquery);
	$navnum=mysql_num_rows($navresult);
	// and make list items out of them
	echo '<ul id="foot">';
		echo '<li class="first">&copy; ' . date('Y') . '</li>';
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/navlinks.php';
	echo "</ul>\n";

?>
<br />
<p class="small"><a href="http://www.dreamhost.com/r.cgi?234834" class="window">Hosted by Dreamhost</a></p>
