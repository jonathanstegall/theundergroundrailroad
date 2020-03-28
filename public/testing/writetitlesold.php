<?php
	// get category from querystring
	$category = $_GET['category'];
	if (!$category) {
		$category = 'main';
	}
	include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
	mysql_select_db($db_main) or die(mysql_error());
	// find the matching category in the database
	$categoryquery = "SELECT mainCategoryID from tbl_mainCategory WHERE mainCategoryName = '$category'";
	$categoryresult = mysql_query($categoryquery);
	$categorynum=mysql_num_rows($categoryresult);
	// for the matching categories, get the id that matches the name
	$x=0;
	for ($x = 0; $x < $categorynum; $x++) {
		$catid=mysql_result($categoryresult,$x,"mainCategoryID");;
	}
	// if the id matches, get all the items
	$page = $_GET['page'];
	if (!$page) {
		$page = 'home';
	}
	$pagequery = "SELECT pageTitle from tbl_mainPages WHERE pageCategory = '$catid' AND pageName = '$page'";
	$pageresult=mysql_query($pagequery);
	$pagenum=mysql_num_rows($pageresult);
	
	$subpage = $_GET['subpage'];
	if (!$subpage) {
		$subpage = 'index';
	}
	
	// and make pages out of them
	$i=0;
	for ($i = 0; $i < $pagenum; $i++) {
		if ($subpage == 'index') {
			$title=mysql_result($pageresult,$i,"pageTitle");
		} else {
			$subpagequery = "SELECT subPageTitle from tbl_subPages WHERE subPageTitle = '$subpage'";
			$subpageresult=mysql_query($subpagequery);
			$subpagenum=mysql_num_rows($subpageresult);
			$y=0;
			for ($y = 0; $y < $subpagenum; $y++) {
				$pageTitle=mysql_result($pageresult,$i,"pageTitle");
				$subPageTitle=mysql_result($subpageresult,$y,"subPageTitle");
				$title = $subPageTitle. ' - ' . $pageTitle;
			}
		}
		if($catid == 1 && $page != 'home') {
			echo "$title".' - The Underground Railroad';
		} else if ($catid == 2 && $page != 'home') {
			echo "$title".' - The Underground Ministry Handbook - The Underground Railroad';
		} else if ($catid == 3 && $page != 'home') {
			echo "$title".' - Ministries - The Underground Railroad';
		} else {
			echo $title;
		}
	}
?>