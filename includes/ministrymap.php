<?php
include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
mysql_select_db($db_main) or die(mysql_error());

$mapquery = "SELECT * FROM tbl_ministries WHERE ministryIsActive = 1";
$mapresult = mysql_query($mapquery) or die(mysql_error());
$mapnum = mysql_num_rows($mapresult);

echo '<markers>';
$x = 0;
$i=0;
for ($i = 0; $i < $mapnum; $i++) {
	$latitude=mysql_result($mapresult,$i,"ministryLatitude");
	$longitude=mysql_result($mapresult,$i,"ministryLongitude");

	$mainpage=mysql_result($mapresult,$i,"subPageMainID");
	$link=mysql_result($mapresult,$i,"subPageName");
	$name=mysql_result($mapresult,$i,"subPageNavigationName");
	$street=mysql_result($mapresult,$i,"ministryAddress");
	$city=mysql_result($mapresult,$i,"ministryCity");
	$state=mysql_result($mapresult,$i,"ministryState");
	$country=mysql_result($mapresult,$i,"ministryCountry");
	
	$website=mysql_result($mapresult,$i,"ministryWebsite");
	
	$summary=mysql_result($mapresult,$i,"ministrySummary");
	$body=mysql_result($mapresult,$i,"ministryBody");
	
	$mainquery = "SELECT pageName FROM tbl_mainPages WHERE pageID='$mainpage'";
	$mainresult = mysql_query($mainquery);
	$mainnum = mysql_num_rows($mainresult);
	$x=0;
	for ($x = 0; $x < $mainnum; $x++) {
		$mainpagename=mysql_result($mainresult,$x,"pageName");
	}
		$ministry = "<p class=\"mapInfoWindow\"><strong>$name</strong><br />";
		if ($street && $city && $state && $country) {
			$address = urlencode("$street $city $state $country");
			$ministry .= "$city, $state, $country";
		} else if ($city && $state && $country) {
			$address = urlencode("$city $state $country");
			$ministry .= "$city, $state, $country";
		} else if ($street && $city && $country) {
			$address = urlencode("$street $city $country");
			$ministry .= "$city, $country";
		} else if ($city && $country) {
			$address = urlencode("$city $country");
			$ministry .= "$city, $country";
		}
		if ($website) {
			$ministry .= "<br /><a href=\"$website\" class=\"window\">Visit Website</a>";
		}
		if ($body) {
			$ministry .= "<br /><a href=\"/ministries/$mainpagename/$link/\">Read More</a>";
		}
		$ministry .= "</p>";
	
	
	echo "<marker lat=\"$latitude\" lng=\"$longitude\" label=\"label\">";
	echo "<infowindow><![CDATA[";
	echo $ministry;
	echo "]]></infowindow>";
	echo "</marker>";
}
echo '</markers> ';
?>