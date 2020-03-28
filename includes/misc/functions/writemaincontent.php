<?php
	// get category from querystring
	$category = $_GET['category'];
	if (!$category) {
		$category = 'main';
	}
	// find the matching category in the database
	$categoryquery = "SELECT mainCategoryID from tbl_mainCategory WHERE mainCategoryName = '$category'";
	$categoryresult = mysql_query($categoryquery);
	$categorynum=mysql_num_rows($categoryresult);
	badQuery($categorynum);
	// for the matching categories, get the id that matches the name
	$x=0;
	for ($x = 0; $x < $categorynum; $x++) {
		$catid=mysql_result($categoryresult,$x,"mainCategoryID");;
	}
	// if the id matches, get all the items
	$page = $_GET['page'];
	if (!$page) {
		$page = 'home';
	} else if ($page == 'forum') {
		header( 'Location: http://groups.msn.com/UndergroundRailroad/messages.msnw' ) ;
	}
	$pagequery = "SELECT * from tbl_mainPages WHERE pageCategory = '$catid' AND pageName = '$page'";
	$pageresult=mysql_query($pagequery);
	$pagenum=mysql_num_rows($pageresult);
	badQuery($pagenum);
	// and make pages out of them
	$i=0;
	for ($i = 0; $i < $pagenum; $i++) {
		//$subpages=mysql_result($pageresult,$i,"pageNumberSubpages");
		$pageid=mysql_result($pageresult,$i,"pageID");
		$contentType=mysql_result($pageresult,$i,"pageContentType");
		$h1=mysql_result($pageresult,$i,"pageH1");
		$body=mysql_result($pageresult,$i,"pageBody");
		//echo $contentType;	
	}
	$subpage = $_GET['subpage'];
	if ($subpage != 'index') {
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/writesubpage.php';
		$record = $_GET['record'];
		if ($record != 'main') {
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/writerecord.php';
			//echo $record;
			//echo $subpageid;
		} else {
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/listrecords.php';
		}
	} else {
		echo '<h1>'.$h1.'</h1>';
		echo $body;
		if ($pageid != '') {
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/listsubpages.php';
		};
	}
?>