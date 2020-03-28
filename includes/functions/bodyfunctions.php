<?php
$category = $_GET['category'];
if (!$category) {
	$category = 'main';
} else {
	$category = $_GET['category'];
}
if ($category == 'ministries') {
	echo 'onload="loadGoogleMap()" onunload="GUnload()"';
}
?>