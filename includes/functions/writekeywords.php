<?php
	function writeKeywords() {
		$constructor = new constructor();
		$category = $_GET['category'];
		$page = $_GET['page'];
		$subpage = $_GET['subpage'];
		$record = $_GET['record'];
		if (!$category) {
			$category = 'main';
		} else {
			$category = $_GET['category'];
		}
		$categoryquery = "SELECT mainCategoryID from tbl_mainCategory WHERE mainCategoryName = '$category'";
		$categoryresult = mysql_query($categoryquery);
		$categorynum=mysql_num_rows($categoryresult);
		$truecategory = $constructor->checkQueryString($categorynum);
		if ($truecategory == 1) {
			$x=0;
			for ($x = 0; $x < $categorynum; $x++) {
				$catid=mysql_result($categoryresult,$x,"mainCategoryID");
			}
		} else {
			echo 'Invalid category request. Please try again.';
			return false;
		}
		
		if (!$page) {
			$page = 'home';
		} else {
			$page = $_GET['page'];
		}
		$pagequery = "SELECT * from tbl_mainPages WHERE pageCategory = '$catid' AND pageName = '$page'";
		$pageresult=mysql_query($pagequery);
		$pagenum=mysql_num_rows($pageresult);
		$truepage = $constructor->checkQueryString($pagenum);
		if ($truepage == 1) {
			$i=0;
			for ($i = 0; $i < $pagenum; $i++) {
				$pageid=mysql_result($pageresult,$i,"pageid");
				$pagekeywords=mysql_result($pageresult,$i,"pageKeywords");
			}
			if ($subpage == '' && $record == '') {
				echo $pagekeywords;
				return true;
			}
		} else {
			echo 'Invalid content';
			return false;
		}
		
		if (!$subpage) {
			$subpage = 'index';
		} else {
			$subpage = $_GET['subpage'];
		}
		$subpagequery = "SELECT * from tbl_subPages WHERE subPageMainID = '$pageid' AND subPageName = '$subpage'";
		$subpageresult=mysql_query($subpagequery);
		$subpagenum=mysql_num_rows($subpageresult);
		$truesubpage = $constructor->checkQueryString($subpagenum);
		if ($truesubpage == 1) {
			$y=0;
			for ($y = 0; $y < $subpagenum; $y++) {
				$subpageid=mysql_result($subpageresult,$y,"subPageID");
				$subpagekeywords=mysql_result($subpageresult,$y,"subPageKeywords");
			}
			if (!$record) {
				echo $subpagekeywords;
				return true;
			}
		} else {
			echo 'Invalid content';
			return false;
		}
		
		if (!$record) {
			$record = 'index';
		} else {
			$record = $_GET['record'];
		}
		$recordquery = "SELECT * from tbl_records WHERE recordSubPageID = '$subpageid' AND recordName = '$record'";
		$recordresult=mysql_query($recordquery);
		$recordnum=mysql_num_rows($recordresult);
		$truerecord = $constructor->checkQueryString($recordnum);
		if ($truerecord == 1) {
			$n=0;
			for ($n = 0; $n < $recordnum; $n++) {
				$recordid=mysql_result($recordresult,$n,"recordID");
				$recordkeywords=mysql_result($recordresult,$n,"recordKeywords");
			}
			echo $recordkeywords;
			return true;
		} else {
			echo 'Invalid content';
			return false;
		}
	}
	writeKeywords();
?>