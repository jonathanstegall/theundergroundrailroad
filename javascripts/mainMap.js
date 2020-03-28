//<![CDATA[
    function loadGoogleMap() {
      if (GBrowserIsCompatible()) {
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
	  
        var map = new GMap2(document.getElementById("map"));
		map.enableDoubleClickZoom();
		map.enableContinuousZoom();
        map.addControl(new GLargeMapControl());
        map.addControl(new GMapTypeControl());
        map.setCenter(new GLatLng(39,-50),2);
        GDownloadUrl("/map.xml", function(data) {
          var xml = GXml.parse(data); 
          var markers = xml.documentElement.getElementsByTagName("marker");
          for (var i = 0; i < markers.length; i++) {
		  var lat = parseFloat(markers[i].getAttribute("lat"));
            var lng = parseFloat(markers[i].getAttribute("lng"));
            var point = new GLatLng(lat,lng);
		   var html = GXml.value(markers[i].getElementsByTagName("infowindow")[0]);
            var label = markers[i].getAttribute("label");
            // create the marker
            var marker = createMarker(point,label,html);
            map.addOverlay(marker);
          }
        });
      }
    }
    //]]>