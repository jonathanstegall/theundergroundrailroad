<?php
//Set up variables
$longitude = "";
$latitude = "";
$precision = "";

//Three parts to the querystring: q is address, output is the format (

include $_SERVER['DOCUMENT_ROOT'] . '/../includes/dbconnect.php';
mysql_select_db($db_main) or die(mysql_error());
   // Query the table
$addressquery = "SELECT * FROM tbl_ministries";
$addressresult = mysql_query($addressquery) or die(mysql_error());
$addressnum=mysql_num_rows($addressresult);

$i=0;
for ($i = 0; $i < $addressnum; $i++) {
	$active=mysql_result($addressresult,$i,"ministryIsActive");
	$name=mysql_result($addressresult,$i,"subPageNavigationName");
	$street=mysql_result($addressresult,$i,"ministryAddress");
	$city=mysql_result($addressresult,$i,"ministryCity");
	$state=mysql_result($addressresult,$i,"ministryState");
	$country=mysql_result($addressresult,$i,"ministryCountry");
	if ($street && $city && $state && $country) {
		$address = urlencode("$street $city $state $country");
	} else if ($city && $state && $country) {
		$address = urlencode("$city $state $country");
	} else if ($street && $city && $country) {
		$address = urlencode("$street $city $country");
	} else if ($city && $country) {
		$address = urlencode("$city $country");
	}
	//$address = urlencode("columbia MO");
	$url = "http://maps.google.com/maps/geo?q=".$address."&output=csv&key=".$key;

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$data = curl_exec($ch);
	curl_close($ch);

	//echo "Data: ". $data."";
	if (strstr($data,'200')) {
		$data = explode(",",$data);
		$precision = $data[1];
		$latitude = $data[2];
		$longitude = $data[3];
		if ($active == 1) {
			echo "<p><strong>$name</strong></p>";
			echo "<p>Latitude: ".$latitude."</p>";
			echo "<p>Longitude: ".$longitude."</p>";
		}
	} else {
		echo "<p class=\"queryError\">Error in geocoding!</p>";
	}
}


echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Google Maps</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAADcxcUlk2fx0r599j2K_mjhQBx51DaBwbyiqIS7y4DtylRRuY6hRvc0ZDd2GlBRUWK2iRZKerb_iCwQ" type="text/javascript"></script>
	<style type="text/css">
	p.testMap {
		margin: 0;
		padding: 0;
		font: normal 12px Verdana, Arial, Helvetica, sans-serif;
	}
	</style>
  </head>
  <body onunload="GUnload()">


    <!-- you can use tables or divs for the overall layout -->
           <div id="map" style="width: 550px; height: 450px"></div>
    <a href="http://www.econym.demon.co.uk/googlemaps/basic7.htm">Back to the tutorial page</a>


    <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
      However, it seems JavaScript is either disabled or not supported by your browser. 
      To view Google Maps, enable JavaScript by changing your browser options, and then 
      try again.
    </noscript>
 

    <script type="text/javascript">
    //<![CDATA[

    if (GBrowserIsCompatible()) { 

      // Display the map, with some controls and set the initial location 
      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(27.947211,-82.457467),9);
    
   
      // arrays to hold copies of the markers and html used by the side_bar
      // because the function closure trick doesnt work there
      var side_bar_html = "";
      var gmarkers = [];
      var htmls = [];
      var i = 0;


      // A function to create the marker and set up the event window
      function createMarker(point,name,html) {
        var marker = new GMarker(point);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        // save the info we need to use later for the side_bar
        gmarkers[i] = marker;
        htmls[i] = html;
        i++;
        return marker;
      }


      // This function picks up the click and opens the corresponding info window
      function myclick(i) {
        gmarkers[i].openInfoWindowHtml(htmls[i]);
      }

      // Read the data from example4.xml
      
      var request = GXmlHttp.create();
      request.open("GET", "makexml.php", true);
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          var xmlDoc = request.responseXML;
          // obtain the array of markers and loop through it
          var markers = xmlDoc.documentElement.getElementsByTagName("marker");
          
          for (var i = 0; i < markers.length; i++) {
            // obtain the attribues of each marker
            var lat = parseFloat(markers[i].getAttribute("lat"));
            var lng = parseFloat(markers[i].getAttribute("lng"));
            var point = new GLatLng(lat,lng);
           // var html = markers[i].getAttribute("html");
		   var html = GXml.value(markers[i].getElementsByTagName("infowindow")[0]);
            var label = markers[i].getAttribute("label");
            // create the marker
            var marker = createMarker(point,label,html);
            map.addOverlay(marker);
          }
          // put the assembled side_bar_html contents into the side_bar div
          //document.getElementById("side_bar").innerHTML = side_bar_html;         
        }
      }
      request.send(null);

    }
    
    // display a warning if the browser was not compatible
    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }

    //]]>
    </script>
  </body>

</html>';
?>