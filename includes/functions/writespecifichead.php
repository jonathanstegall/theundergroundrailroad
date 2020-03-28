<?php
$category = $_GET['category'];
$page = $_GET['page'];
if (!$category) {
	$category = 'main';
} else {
	$category = $_GET['category'];
}

$subpage = $_GET['subpage'];
if ($category == 'ministries' && $page == 'home' && $subpage == '') {
	echo '<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAADcxcUlk2fx0r599j2K_mjhQBx51DaBwbyiqIS7y4DtylRRuY6hRvc0ZDd2GlBRUWK2iRZKerb_iCwQ" type="text/javascript"></script>
	<script type="text/javascript" src="http://www.theundergroundrailroad.org/javascripts/mainMap.js"></script>
	<script type="text/javascript" src="http://www.theundergroundrailroad.org/javascripts/scripts.js"></script>
	<script type="text/javascript">addLoadEvent(loadGoogleMap);</script>';
} else if ($category == 'ministries' && $page == '' && $subpage == '') {
	echo '<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAADcxcUlk2fx0r599j2K_mjhQBx51DaBwbyiqIS7y4DtylRRuY6hRvc0ZDd2GlBRUWK2iRZKerb_iCwQ" type="text/javascript"></script>
	<script type="text/javascript" src="http://www.theundergroundrailroad.org/javascripts/mainMap.js"></script>
	<script type="text/javascript" src="http://www.theundergroundrailroad.org/javascripts/scripts.js"></script>
	<script type="text/javascript">addLoadEvent(loadGoogleMap);</script>';
} else {
	echo '<script type="text/javascript" src="http://www.theundergroundrailroad.org/javascripts/scripts.js"></script>';
}
?>