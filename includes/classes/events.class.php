<?php
class events {
	function events($page,$pageid,$contentType,$subpage,$record) {
		if (!$subpage) {
			$this->listEventCategories($page,$pageid,$contentType);
		} else if ($subpage != 'index' && !$record) {
			$this->writeEventPage($subpage);
			$this->listEventData($page,$subpage,$record,$contentType);
		} else if ($record) {
			$this->writeEventData($record,$subpage,$contentType);
		} else {
			return false;
		}
	}
	function listEventCategories($page,$pageid,$contentType) {
		$listClass = $contentType.'Div';
		$eventspagequery = "SELECT * FROM tbl_events";
		$eventspageresult=mysql_query($eventspagequery);
		$eventspagenum=mysql_num_rows($eventspageresult);
		$i=0;
		for ($i = 0; $i < $eventspagenum; $i++) {
		echo "<div class=\"$listClass\">\n";
			$subfilename=mysql_result($eventspageresult,$i,"subPageName");
			$subnavname=mysql_result($eventspageresult,$i,"subPageNavigationName");
			$subnavsummary=mysql_result($eventspageresult,$i,"subPageSummary");
			$subnavname = ucfirst($subnavname);
			$subnavtitle = '"'.$subnavname.'"';
			$sublinkid = "$subfilename".'Link';
			$category = $_GET['category'];
			// edit this if the index prefix ever goes away
			$url = "\"/$category/$page/$subfilename/\"";
			echo "<h3><a href=$url title=$subnavtitle>$subnavname</a></h3>";
				echo "<p>$subnavsummary<br /><a href=$url title=$subnavtitle>Read More</a></p>\n";		
			echo "</div>";
		}
	}
	function writeEventPage($subpage) {
		$eventspagequery = "SELECT * FROM tbl_events WHERE subPageName='$subpage'";
		$eventspageresult=mysql_query($eventspagequery);
		$eventspagenum=mysql_num_rows($eventspageresult);
		$i=0;
		for ($i = 0; $i < $eventspagenum; $i++) {
			$subpageid=mysql_result($eventspageresult,$i,"subPageID");
			$h1=mysql_result($eventspageresult,$i,"subPageH1");
			$body=mysql_result($eventspageresult,$i,"subPageBody");
			$code=mysql_result($eventspageresult,$i,"subPagePHPCode");
			echo "<h1>$h1</h1>";
			echo $body;
			/*$eventcategoryquery = "SELECT * FROM tbl_eventCategories WHERE eventPageID='$subpageid'";
			$eventcategoryresult = mysql_query($eventcategoryquery);
			$eventcategorynum = mysql_num_rows($eventcategoryresult);
			$x=0;
			for ($x = 0; $x < $eventcategorynum; $x++) {
				$categorytitle=mysql_result($eventcategoryresult,$x,"eventCategoryTitle");
				$categorybody=mysql_result($eventcategoryresult,$x,"eventCategoryBody");
			
			echo "<h3>$categorytitle</h3>\n";
			echo $categorybody;
			}
			*/
			if ($code) {
				eval($code);
			}
		}
	}
	function listEventData($page,$subpage,$record,$contentType) {
		$listClass = $contentType.'Div';	
		$todaysdate=date("Y-m-d");
		
		$eventspagequery = "SELECT subPageID FROM tbl_events WHERE subPageName='$subpage'";
		$eventspageresult=mysql_query($eventspagequery);
		$eventspagenum=mysql_num_rows($eventspageresult);
		$i=0;
		for ($i = 0; $i < $eventspagenum; $i++) {
			$subpageid=mysql_result($eventspageresult,$i,"subPageID");
		}
		$eventcategoryquery="SELECT DISTINCT eventCategoryID, eventCategoryTitle FROM tbl_eventCategories WHERE eventPageID='$subpageid'";
		$eventcategoryresult=mysql_query($eventcategoryquery);
		$eventcategorynum=mysql_num_rows($eventcategoryresult);
		$y=0;
		for ($y=0; $y < $eventcategorynum; $y++) {
			$eventid=mysql_result($eventcategoryresult,$y,"eventCategoryID");
			$eventcategory=mysql_result($eventcategoryresult,$y,"eventCategoryTitle");
			echo "<h3>$eventcategory</h3>";
			$eventquery="SELECT * FROM tbl_eventData WHERE recordSubPageID='$subpageid' AND recordEventCategoryID='$eventid' ORDER BY eventDate, recordTitle";
			$eventresult=mysql_query($eventquery);
			$eventnum=mysql_num_rows($eventresult);
			$x=0;
			for ($x=0; $x < $eventnum; $x++) {
				$eventdate=mysql_result($eventresult,$x,"eventDate");
				$eventdate=strtotime($eventdate);
				$eventdate=date("Y-m-d",$eventdate);
				if ($todaysdate > $eventdate) {
					echo "<div class=\"$listClass oldEvent\">\n";
						$category = $_GET['category'];
						$eventfilename=mysql_result($eventresult,$x,"recordName");
						$eventnavname=mysql_result($eventresult,$x,"recordNavigationName");
						$eventnavname = ucfirst($eventnavname);
						$eventnavtitle = '"'.$eventnavname.'"';
						$eventlinkid = "$eventfilename".'Link';
						$eventsummary=mysql_result($eventresult,$x,"eventSummary");
						$category = $_GET['category'];
						$page = $_GET['page'];
						$url = "\"/$category/$page/$subpage/$eventfilename/\"";
						echo "<h3><a href=$url title=$eventnavtitle>$eventnavname</a></h3>";
							echo "<p>$eventsummary<br /><a href=$url title=$eventnavtitle>Read More</a></p>\n";		
					echo "</div>";
				} else {
					echo "<div class=\"$listClass\">\n";
						$category = $_GET['category'];
						$eventfilename=mysql_result($eventresult,$x,"recordName");
						$eventnavname=mysql_result($eventresult,$x,"recordNavigationName");
						$eventnavname = ucfirst($eventnavname);
						$eventnavtitle = '"'.$eventnavname.'"';
						$eventlinkid = "$eventfilename".'Link';
						$eventsummary=mysql_result($eventresult,$x,"eventSummary");
						$category = $_GET['category'];
						$page = $_GET['page'];
						$url = "\"/$category/$page/$subpage/$eventfilename/\"";
						echo "<h3><a href=$url title=$eventnavtitle>$eventnavname</a></h3>";
							echo "<p>$eventsummary<br /><a href=$url title=$eventnavtitle>Read More</a></p>\n";		
					echo "</div>";
				}
				
			}
		}
	}
	function writeEventData($record,$subpage,$contentType) {
		$eventspagequery = "SELECT subPageID FROM tbl_events WHERE subPageName='$subpage'";
		$eventspageresult=mysql_query($eventspagequery);
		$eventspagenum=mysql_num_rows($eventspageresult);
		$i=0;
		for ($i = 0; $i < $eventspagenum; $i++) {
			$subpageid=mysql_result($eventspageresult,$i,"subPageID");
		}
		$writeeventquery="SELECT * FROM tbl_eventData WHERE recordSubPageID='$subpageid' AND recordName='$record'";
		$writeeventresult=mysql_query($writeeventquery);
		$writeeventnum=mysql_num_rows($writeeventresult);
		$x=0;
		for ($x=0; $x < $writeeventnum; $x++) {				
			$h1=mysql_result($writeeventresult,$x,"eventH1");
			$body=mysql_result($writeeventresult,$x,"eventBody");
			$code=mysql_result($writeeventresult,$x,"eventPHPCode");
			echo "<h1>$h1</h1>";
			echo $body;
			if ($code) {
				eval($code);
			}
		}
	}
}
?>