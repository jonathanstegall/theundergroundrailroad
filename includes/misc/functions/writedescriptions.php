<?php
function writeDescriptions() {
	$category = $_GET['category'];
	$page = $_GET['page'];
	$subpage = $_GET['subpage'];
	if ($subpage == 'index') {
		$catidquery = "SELECT mainCategoryID from tbl_mainCategory WHERE mainCategoryName = '$category'";
		$catidresult=mysql_query($catidquery);
		$catidnum=mysql_num_rows($catidresult);
		// for the matching categories, get the id that matches the name
		$x=0;
		for ($x = 0; $x < $catidnum; $x++) {
			$catid=mysql_result($catidresult,$x,"mainCategoryID");
		}
		$pagequery = "SELECT pageDescription from tbl_mainPages WHERE pageCategory = '$catid' AND pageName = '$page'";
		$pageresult=mysql_query($pagequery);
		$pagenum=mysql_num_rows($pageresult);
		// and make pages out of them
		$i=0;
		for ($i = 0; $i < $pagenum; $i++) {
			$description=mysql_result($pageresult,$i,"pageDescription");
			echo $description;
		}
	} else {
		$pageidquery = "SELECT * from tbl_mainPages WHERE pageName = '$page'";
		$pageidresult=mysql_query($pageidquery);
		$pageidnum=mysql_num_rows($pageidresult);
		// for the matching categories, get the id that matches the name
		$x=0;
		for ($x = 0; $x < $pageidnum; $x++) {
			$pageid=mysql_result($pageidresult,$x,"pageID");
			$contentType=mysql_result($pageidresult,$x,"pageContentType");
			$tableName = 'tbl_'.$contentType;
		}
		$subpagequery = "SELECT subPageDescription from ".$tableName." WHERE subPageMainID = '$pageid' AND subPageName = '$subpage'";
		$subpageresult=mysql_query($subpagequery);
		$subpageum=mysql_num_rows($subpageresult);
		// and make pages out of them
		$i=0;
		for ($i = 0; $i < $subpageum; $i++) {
			$description=mysql_result($subpageresult,$i,"subPageDescription");
			echo $description;
		}
	}
};
writeDescriptions();
?>