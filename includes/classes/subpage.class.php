<?php
class subPage {
	function subPage($subpageid,$pageid,$contentType,$record) {
		// if there is not a subpage in the query, list all of them
		if (!$subpageid) {
			$this->listSubPages($pageid,$contentType);
		} else {
			// or, if we are not on a record write the one in the query
			if (!$record) {
				$this->writeSubPage($subpageid,$contentType);
			} else {
				// if we are on a record, go back and write it
				return false;
			}
		}
		
	}
	function listSubPages($pageid,$contentType) {
		$tableName = 'tbl_'.$contentType;
		$listClass = $contentType.'Div';
		if ($contentType == 'subPages') {
			$subpagequery = "SELECT * FROM ".$tableName." WHERE subPageMainID = ".$pageid."";
			$subpageresult=mysql_query($subpagequery);
			$subpagenum=mysql_num_rows($subpageresult);
			$i=0;
			for ($i = 0; $i < $subpagenum; $i++) {
			echo "<div class=\"$listClass\">\n";
				$subfilename=mysql_result($subpageresult,$i,"subPageName");
				$subnavname=mysql_result($subpageresult,$i,"subPageNavigationName");
				$subnavsummary=mysql_result($subpageresult,$i,"subPageSummary");
				$subnavname = ucfirst($subnavname);
				$subnavtitle = '"'.$subnavname.'"';
				$sublinkid = "$subfilename".'Link';
				$category = $_GET['category'];
				$page = $_GET['page'];
				// edit this if the index prefix ever goes away
				$url = "\"/$category/$page/$subfilename/\"";
				echo "<h3><a href=$url title=$subnavtitle>$subnavname</a></h3>";
					echo "<p>$subnavsummary<br /><a href=$url title=$subnavtitle>Read More</a></p>\n";		
			echo "</div>";
			}
		} else {
			$page = $_GET['page'];
			$subpage = $_GET['subpage'];
			$record = $_GET['record'];
			$className = "$contentType.class.php";
			$declareClass = $contentType;
			$functionName = $contentType.'';
			include $_SERVER['DOCUMENT_ROOT'] . "/../includes/classes/$className";
			$pageClass = new $functionName($page,$pageid,$contentType,$subpage,$record);
		}
	}
	function writeSubPage($subpageid,$contentType) {
		$tableName = 'tbl_'.$contentType;
		$listFile = 'write'.$contentType.'.php';
		$writesubpagequery = "SELECT * FROM ".$tableName." WHERE subPageID = '$subpageid'";
		$writesubpageresult=mysql_query($writesubpagequery);
		$writesubpagenum=mysql_num_rows($writesubpageresult);
		// if we're on a standard subpage, write it
		if ($tableName == 'tbl_subPages') {
			$i=0;
			for ($i = 0; $i < $writesubpagenum; $i++) {
				$h1=mysql_result($writesubpageresult,$i,"subPageH1");
				$body=mysql_result($writesubpageresult,$i,"subPageBody");
				$code=mysql_result($writesubpageresult,$i,"subPagePHPCode");
				echo "<h1>$h1</h1>";
				echo $body;
				if ($code) {
					eval($code);
				}
			}
		} else {
			$subpage = $_GET['subpage'];
			$className = "$contentType.class.php";
			$declareClass = $contentType;
			$functionName = $contentType.'';
			include $_SERVER['DOCUMENT_ROOT'] . "/../includes/classes/$className";
			$pageClass = new $functionName($page,$pageid,$contentType,$subpage,$record);
			return false;
		}
	}
}
?>