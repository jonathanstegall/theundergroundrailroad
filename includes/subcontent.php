<h3>Upcoming Events</h3>
<?php
$todaysdate=date("Y-m-d");
$eventsquery = "SELECT * FROM tbl_eventData";
$eventsresult = mysql_query($eventsquery);
$eventsnum = mysql_num_rows($eventsresult);
$y=0;
for ($y=0; $y < $eventsnum; $y++) {
	$eventdate=mysql_result($eventsresult,$y,"eventDate");
	$eventdate=strtotime($eventdate);
	$eventdate=date("Y-m-d",$eventdate);
	if ($todaysdate < $eventdate) {
			$category = $_GET['category'];
			$eventfilename=mysql_result($eventsresult,$y,"recordName");
			$eventnavname=mysql_result($eventsresult,$y,"recordNavigationName");
			$eventnavname = ucfirst($eventnavname);
			$eventnavtitle = '"'.$eventnavname.'"';
			$eventlinkid = "$eventfilename".'Link';
			$eventsummary=mysql_result($eventsresult,$y,"eventSummary");
			$category = $_GET['category'];
			$page = $_GET['page'];
			//$url = "\"/$category/$page/$subpage/$eventfilename/\"";
			$url = "\"/main/events/\"";
			echo "<h4><a href=$url title=$eventnavtitle>$eventnavname</a></h4>";
				//echo "<p>$eventsummary<br /><a href=$url title=$eventnavtitle>Read More</a></p>\n";		
	}
}
?>
<h3>View a Ministry</h3>
<?php
$ministriesquery = "SELECT subPageMainID, subPageName, subPageNavigationName, ministrySummary FROM tbl_ministries ORDER BY Rand() LIMIT 1";
$ministriesresult = mysql_query($ministriesquery);
$ministriesnum = mysql_num_rows($ministriesresult);
$y=0;
for ($y=0; $y < $ministriesnum; $y++) {
	$mainid=mysql_result($ministriesresult,$y,"subPageMainID");
	$ministryname=mysql_result($ministriesresult,$y,"subPageName");
	$navname=mysql_result($ministriesresult,$y,"subPageNavigationName");
	$ministrysummary=mysql_result($ministriesresult,$y,"ministrySummary");
	$pagequery = "SELECT pageName FROM tbl_mainPages WHERE pageID='$mainid'";
	$pageresult = mysql_query($pagequery);
	$pagenum = mysql_num_rows($pageresult);
	$x=0;
	for ($x=0; $x < $pagenum; $x++) {
		$pagename = mysql_result($pageresult,$x,"pageName");
		$url = "\"/ministries/$pagename/$ministryname/\"";
		echo "<h4><a href=$url title=\"$navname\">$navname</a></h4>";
		echo "<p>$ministrysummary</p>";
	}
}
echo "<p><a href=\"/ministries/\" title=\"Ministries\">See all ministries</a></p>";
?>
