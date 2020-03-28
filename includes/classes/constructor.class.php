<?php
class constructor {
	function constructor() {
		// see if there's a session
		require_once($_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/session.class.php');
		// and if they're a user
		$this->getUser();
		// connect to database
		$this->databaseConnect();
		// and write the main template
		$this->writeTemplate();
	}
	// find the user
	function getUser() {
		$user = 1;
		return $user;
	}
	// validation of get query
	function checkQueryString($var) {
		if ($var == 1) {
			return true;
		} else {
			return false;
		}
	}
	// write the navigation elements based on the section of the page where that nav should appear - header, footer, etc.
	// these are called in the individual functions - writemainnav.php, footer.php, etc.
	function writeNav($section) {
		// the category
		$category = $_GET['category'];
		// the page
		$page = $_GET['page'];
		// how to get the category
		if (!$category) {
			$category = 'main';
		} else {
			$category = $_GET['category'];
		}
		// category navigation - this is the very top level
		$categoryquery = "SELECT * from tbl_mainCategory WHERE mainCategoryName = '$category'";
		$categoryresult = mysql_query($categoryquery);
		$categorynum=mysql_num_rows($categoryresult);
		// validate query
		$truecategory = $this->checkQueryString($categorynum);
		if ($truecategory == 1 || $category == 'main') {
			$x=0;
			for ($x = 0; $x < $categorynum; $x++) {
				$catid=mysql_result($categoryresult,$x,"mainCategoryID");
			}
		} else {
			//echo '<p class="queryError">Invalid category request. Please try again.</p>';
			return false;
		}
		// how to get the page
		if (!$page) {
			$page = 'home';
		} else {
			$page = $_GET['page'];
		}
		// pages that match the get query - for current status
		$pagequery = "SELECT * from tbl_mainPages WHERE pageName = '$page'";
		$pageresult = mysql_query($pagequery);
		$pagenum=mysql_num_rows($pageresult);
		// validate the query
		$truepage = $this->checkQueryString($pagenum);
		// get the current page
		if ($truepage == 1 || $page == 'home') {
			$currentPage = $page;
		} else {
			echo '<p class="queryError">Invalid page request. Please try again.</p>';
			return false;
		}
		// make the nav for each section
		switch ($section){
			// top level
			case "top":
				echo '<span class="hidden">the underground railroad</span>';
				$category = $_GET['category'];
				$categoryquery = "SELECT * from tbl_mainCategory ORDER BY mainCategoryOrder";
				$categoryresult = mysql_query($categoryquery);
				$categorynum=mysql_num_rows($categoryresult);
				echo "<ul id=\"topnav\">\n";
					$x=0;
					for ($x = 0; $x < $categorynum; $x++) {
						$catname=mysql_result($categoryresult,$x,"mainCategoryName");
						echo "<li id=\"$catname\"><a href=\"/$catname/\" title=\"$catname\">$catname</a></li>";
					}
				echo "</ul>\n";
				break;
			// main
			case "main":
				$navquery = "SELECT * from tbl_mainPages WHERE pageCategory = '$catid'";
				$navresult=mysql_query($navquery);
				$navnum=mysql_num_rows($navresult);
				echo '<ul id="nav">';
					// list items are reused by main and footer
					include $_SERVER['DOCUMENT_ROOT'] . '/../includes/navlinks.php';
				echo "</ul>\n";
				break;
			// footer
			case "footer":
				$navquery = "SELECT * from tbl_mainPages WHERE pageCategory = '$catid'";
				$navresult=mysql_query($navquery);
				$navnum=mysql_num_rows($navresult);
				echo '<ul id="foot">';
					echo '<li class="first">&copy; ' . date('Y') . '</li>';
					include $_SERVER['DOCUMENT_ROOT'] . '/../includes/navlinks.php';
				echo "</ul>\n";
				break;	
			// if there's not a section present, something's broken.
			default:
				echo "<p class=\"queryError\">Invalid use of function.</p>";
				break; 		
		}
	}
	// write the main content
	function writeContent() {
		// content querystring variables
		$category = $_GET['category'];
		$page = $_GET['page'];
		$subpage = $_GET['subpage'];
		$record = $_GET['record'];
		// category
		if (!$category) {
			$category = 'main';
		} else {
			$category = $_GET['category'];
		}
		// find out what category we're in
		$categoryquery = "SELECT mainCategoryID from tbl_mainCategory WHERE mainCategoryName = '$category'";
		$categoryresult = mysql_query($categoryquery);
		$categorynum=mysql_num_rows($categoryresult);
		// and if it's real
		$truecategory = $this->checkQueryString($categorynum);
		if ($truecategory == 1) {
			$x=0;
			for ($x = 0; $x < $categorynum; $x++) {
				$catid=mysql_result($categoryresult,$x,"mainCategoryID");
			}
		// if the category is invalid, quit
		} else {
			echo '<p class="queryError">Invalid category request. Please try again.</p>';
			return false;
		}
		// page
		if (!$page) {
			$page = 'home';
		} else if ($page == 'forum') {
			// crappy msn forum
			header( 'Location: http://groups.msn.com/UndergroundRailroad/messages.msnw' );
		} else {
			$page = $_GET['page'];
		}
		// find all the pages in the category
		$pagequery = "SELECT * from tbl_mainPages WHERE pageCategory = '$catid' AND pageName = '$page'";
		$pageresult=mysql_query($pagequery);
		$pagenum=mysql_num_rows($pageresult);
		// and check the querystring
		$truepage = $this->checkQueryString($pagenum);
		if ($truepage == 1) {
			$i=0;
			for ($i = 0; $i < $pagenum; $i++) {
				// get the id and contenttype i.e. articles, ajaxtabs
				$pageid=mysql_result($pageresult,$i,"pageid");
				$contentType=mysql_result($pageresult,$i,"pageContentType");
			}
			// create the content
			include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/contentpage.class.php';
			$contentPage = new contentPage($pageid,$subpage);
		} else {
			// invalid query
			echo '<p class="queryError">Invalid page request. Please try again.</p>';
			return false;
		}
		
		// subpage
		if (!$subpage) {
			$subpage = 'index';
		} else {
			$subpage = $_GET['subpage'];
		}
		// if there's a specific table for this kind of subpage - defined in the main level page
		$tableName = 'tbl_'.$contentType;
		// then get subpages that are in it
		$subpagequery = "SELECT * from tbl_subPages WHERE subPageMainID = '$pageid' AND subPageName = '$subpage'";
		$subpageresult=mysql_query($subpagequery);
		// if there is a subpage for the main page
		if ($subpageresult) {
			$subpagenum=mysql_num_rows($subpageresult);
			// check query
			$truesubpage = $this->checkQueryString($subpagenum);
			if ($truesubpage == 1 || $subpage == 'index') {
				$y=0;
				for ($y = 0; $y < $subpagenum; $y++) {
					// get the matching id
					$subpageid=mysql_result($subpageresult,$y,"subPageID");
					$subPageContentType=mysql_result($subpageresult,$y,"subPageContentType");
				}
				// write the subpage
				include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/subpage.class.php';
				$subpage = new subPage($subpageid,$pageid,$contentType,$record);
			} else if ($tableName) {
				$page = $_GET['page'];
				$subpage = $_GET['subpage'];
				$record = $_GET['record'];
				$className = "$contentType.class.php";
				$declareClass = $contentType;
				$functionName = $contentType.'';
				include $_SERVER['DOCUMENT_ROOT'] . "/../includes/classes/$className";
				$pageClass = new $functionName($page,$pageid,$contentType,$subpage,$record);
			} else {
				// query error
				echo '<p class="queryError">Invalid content request. Please try again.</p>';
				return false;
			}
		} else {
			// if the main page does not have a valid subpage, continue
			// code will run if it exists
			return false;
		}
		// record
		
		if (!$record) {
			$record = 'index';
		} else {
			$record = $_GET['record'];
		}
		if ($contentType == 'subPages') {
			// if there's a specific table for this kind of record - defined in the subpage page
			$tableName = 'tbl_'.$subPageContentType;
			// find record
			$recordquery = "SELECT * from ".$tableName." WHERE recordSubPageID = '$subpageid' AND recordName = '$record'";
			$recordresult=mysql_query($recordquery);
			if ($recordresult) {
				$recordnum=mysql_num_rows($recordresult);
				// check query
				$truerecord = $this->checkQueryString($recordnum);
				if ($truerecord == 1 || $record == 'index') {
					$n=0;
					for ($n = 0; $n < $recordnum; $n++) {
						$recordid=mysql_result($recordresult,$n,"recordID");
						$recordContentType=mysql_result($recordresult,$n,"recordContentType");
					}
					// write the record
					include $_SERVER['DOCUMENT_ROOT'] . '/../includes/classes/record.class.php';
					$record = new record($recordid,$subpageid,$subPageContentType);
				} else {
					// bad querystring
					echo '<p class="queryError">Invalid content request. Please try again.</p>';
					return false;
				}
			} else {
				// if the sub page does not have a valid record, continue
				// code will run if it exists
				return false;
			}
		} else {
			return false;
		}
	}
	// connect to the database
	function databaseConnect() {
		include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
		// the main one
		mysql_select_db($db_main) or die(mysql_error());
	}
	// write the template for the layout
	function writeTemplate() {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/../includes/functions/writetemplate.php';
	}
}
?>